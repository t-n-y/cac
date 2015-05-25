<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Entity\Comment;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\Image;
use Cac\BarBundle\Entity\Highlight;
use Cac\BarBundle\Entity\DaySchedule;
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
use Cac\BarBundle\Form\Type\BarEditType;
/**
 * Bar controller.
 *
 * @Route("/pro")
 */
class ProController extends Controller
{
    /**
     * @Route("/abonnement/{id}", name="bars_abonnement")
     * @Template()
     */
    public function abonnementAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        return array(
                'bar'      => $entity
            );    
    }

    /**
     * @Route("/offer/{id}", name="bars_offer")
     * @Template()
     */
    public function offerAction($id)
    {
        setlocale(LC_TIME, "fr_FR");
        $today = strftime("%A");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $restriction = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneBy(array('shortcode' => 'restriction'));
        $restrictions = $em->getRepository('CacBarBundle:PromotionOption')->findBy(array('category' => $restriction->getId()));

        $lists = array(
            'drinkNumber' => array('Illimité','5','10','20','30','40','50','100'),
            'drinkDuration' => array('Illimité','1 semaine', '2 semaines', '3 semaines', '1 mois', '2 mois'),
            'printNumber' => array('X5','X10', 'X20', 'X30'),
            'days' => array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche')
        );

        return array(
            'bar'      => $entity,
            'today' => $today,
            'restrictions' => $restrictions,
            'promotions' => $entity->getPromotions(),
            'lists' => $lists,
        );  
    }

    /**
     * @Route("/retourOffre/{id}", name="bars_offerFeedback")
     * @Template()
     */
    public function offerFeedbackAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);
        $promoOffertes = $em->getRepository('CacBarBundle:PromoOffertes')->findBy(array('bar'=> $bar), array('id' => 'DESC'));

        return array(
            'bar'      => $bar,
            'promos' => $promoOffertes,
        );  
    }

    /**
     * @Route("/optionOffre/{id}", name="bars_option")
     * @Template()
     */
    public function optionAction($id)
    {
        setlocale(LC_TIME, "fr_FR");
        $today = strftime("%A");

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1)/*page number*/,
            16/*limit per page*/
        );
        $highlight = $em->getRepository('CacBarBundle:highlight')->findAll();
        shuffle($highlight);

        return array(
            'bars' => $pagination,
            'bar'      => $entity,
            'highlight' => $highlight
        );  
    }

    /**
    * Creates a form to create a Bar entity.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Bar $entity)
    {
        $form = $this->createForm(new BarType(), $entity, array(
            'action' => $this->generateUrl('bar_create'),
            'method' => 'POST',
        ));

        $form->add(
            'submit', 
            'submit', 
            array(
                'label' => 'Enregistrer'
            )
        );

        return $form;
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/new", name="bar_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Bar();
        $form   = $this->createCreateForm($entity);
        return array(
            'bar' => $entity,
            'form'   => $form->createView(),
        );    
    }

    /**
     * Creates a new Bar entity.
     *
     * @Route("/", name="bar_create")
     * @Method("POST")
     * @Template("CacBarBundle:Bar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Bar();
        $pm = $this->get('cac_bar.promotion_manager');
        $emptyPromotions = $pm->getEmptyPromotions();
        $emptyHappyHours = $pm->getEmptyHappyHours();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $schedules = json_decode($request->request->get('cac_barbundle_bar')['schedule'], true);
            foreach($schedules as $day => $options) {
                $schedule = new DaySchedule();
                $schedule->setDayName($day);
                foreach($options as $option => $value) {
                    $uc = 'set'.ucfirst($option);
                    $schedule->$uc($value);
                    $entity->addDaySchedule($schedule);
                    $schedule->setBar($entity);
                }
            }

            $entity->setAdress(explode(",",$entity->getAdress())[0]);
            $entity->setAuthor($user);

            foreach($emptyPromotions as $promotion) {
                $entity->addPromotion($promotion);
                $promotion->setBar($entity);
                $em->persist($promotion);
            }

            foreach($emptyHappyHours as $promotion) {
                $entity->addPromotion($promotion);
                $promotion->setBar($entity);
                $em->persist($promotion);
            }
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bar_new_part2', array('id' => $entity->getId())));
        }

        return array(
            'bar' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Article entity.
     *
     * @Route("/{id}/new-part2", name="bar_new_part2")
     * @Method({"GET","POST"})
     * @Template()
     */
    public function newPart2Action(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        $form = $this->createFormBuilder($entity)
            ->add('file', null, array('label' => '+ Ajouter une photo'))
            ->add("Let's go !", 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            var_dump($request->request->get('coords'));
            die;
            $entity->preUpload();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('promotion_create', array('id' => $id)));
        }
        return $this->render('CacBarBundle:Pro:newPart2.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
        ));
    }

    /**
     * Displays a form to edit an existing Bar entity.
     *
     * @Route("/edit/{id}", name="bar_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }
        if ($this->get('security.context')->getToken()->getUser() != $entity->getAuthor()) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'bar'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Bar entity.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Bar $entity)
    {
        $form = $this->createForm(new BarEditType(), $entity, array(
            'action' => $this->generateUrl('bar_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));


        $form->add('submit', 
            'submit', 
            array(
                'label' => 'Mettre à jour'
            )
        )
         ->add('file', null, array('label' => 'Modifier la photo'));

        return $form;
    }

    /**
     * Edits an existing Bar entity.
     *
     * @Route("/{id}", name="bar_update")
     * @Method("PUT")
     * @Template("CacBarBundle:Bar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('L\'établissement demandé n\'existe pas.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setEditedAt(new \DateTime('now'));
            $em->flush();
            return $this->redirect($this->generateUrl('bar_show', array('id' => $id)));
        }

        return array(
            'bar'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Bar entity.
     *
     * @Route("/{id}", name="bar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('L\'établissement demandé est introuvable.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('bars'));
    }

    /**
     * Creates a form to delete a Bar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bar_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 
                'submit', 
                array(
                    'label' => 'Supprimer'
                )
            )
            ->getForm()
        ;
    }

    /**
     * @Route("/validate-promotion/{id}", name="validate_promo", options={"expose"=true})
     */
    public function validatePromotionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('CacBarBundle:PromoOffertes')->find($id);
        $promo->setEtat('validé');
        $em->persist($promo);
        $user = $promo->getUser();
        $user->setScore($user->getScore()+10);
        $em->persist($user);
        $em->flush();
        return new Response($promo->getEtat());
    }
    
    /**
     * @Route("/invalidate-promotion/{id}", name="invalidate_promo", options={"expose"=true})
     */
    public function invalidatePromotionAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $promo = $em->getRepository('CacBarBundle:PromoOffertes')->find($id);
        $promo->setEtat('non validé');
        $user = $promo->getUser();
        $user->setScore($user->getScore()-15);
        $em->persist($user);
        $em->persist($promo);
        $em->flush();
        return new Response($promo->getEtat());
    }

    /**
     * @Route("/highlight/{id}", name="highlight_bar", options={"expose"=true})
     */
    public function highlightAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $nbHightlight = $em->getRepository('CacAdminBundle:NbHighlight')->findAll();
        $hightlights = $em->getRepository('CacBarBundle:Highlight')->findAll();
        $hightlightedBar = $em->getRepository('CacBarBundle:Highlight')->findOneByBar($id);
        if ($hightlightedBar !== null) {
            return new Response("Bar deja mis en avant");
        }

        if (isset($nbHightlight[0]) && count($hightlights) <= $nbHightlight[0]->getNbHighlight()) {
            $highlight = new Highlight();
            $highlight->setBar($em->getReference('Cac\BarBundle\Entity\Bar', $id));
            $highlight->setDate(new \DateTime('now'));
            $em->persist($highlight);
            $em->flush();
            return new Response($highlight->getId());
        }
        else
            return new Response("Bar non ajouté");
    }
}
