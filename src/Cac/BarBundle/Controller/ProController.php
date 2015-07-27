<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Entity\Comment;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\PromotionDummy;
use Cac\BarBundle\Entity\Image;
use Cac\BarBundle\Entity\Highlight;
use Cac\BarBundle\Entity\DaySchedule;
use Cac\BarBundle\Entity\File;
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
use Cac\BarBundle\Form\Type\PromotionDummyType;
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
        $today = ucfirst(strftime("%A"));

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $entity->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $restriction = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneBy(array('shortcode' => 'restriction'));
        $restrictions = $em->getRepository('CacBarBundle:PromotionOption')->findBy(array('category' => $restriction->getId()));

        $editForm = $this->createEditPromoForm($entity);
        $editSSForm = $this->createEditSSForm($entity);

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
            'edit_form'   => $editForm->createView(),
            'edit_dayss_form' => $editSSForm->createView(),
        );  
    }



    /**
    * Creates a form to edit a Bar entity promotions.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditPromoForm(Bar $entity)
    {
        $pm = $this->get('cac_bar.promotion_manager');
        $promotions = $entity->getPromotions();
        $promotionJSON = $pm->toDummyJSON($promotions);
        $promotionDummy = new PromotionDummy($promotionJSON);

        $form = $this->createForm(new PromotionDummyType(), $promotionDummy, array(
            'action' => $this->generateUrl('bar_update_promo', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 
            'submit', 
            array(
                'label' => 'Valider'
            )
        );

        return $form;
    }

    /**
    * Creates a form to edit a Bar entity sponsorships.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditSSForm(Bar $entity)
    {
        $pm = $this->get('cac_bar.promotion_manager');
        $daySponsorships = $entity->getDaySponsorships();
        $daySponsorshipsJSON = $pm->daySponsorShipsDummyJSON($daySponsorships);
        $sponsorshipDummy = new PromotionDummy($daySponsorshipsJSON);
        $form = $this->createForm(new PromotionDummyType(), $sponsorshipDummy, array(
            'action' => $this->generateUrl('bar_update_dayss', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        $form->add('submit', 
            'submit', 
            array(
                'label' => 'Valider'
            )
        );

        return $form;
    }

    /**
     * Edits an existing Bar entity promotions.
     *
     * @Route("/day-sponsorship/{id}", name="bar_update_dayss")
     * @Method("POST")
     */
    public function updateDaySSAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $pm = $this->get('cac_bar.promotion_manager');

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('L\'établissement demandé n\'existe pas.');
        }

        $daySponsorships = $entity->getDaySponsorships();

        $sponsorshipDummy = new PromotionDummy();
        $dummyJSON = $pm->daySponsorShipsDummyJSON($daySponsorships);
        $sponsorshipDummy->setPromotion($dummyJSON);

        $newDaySponsorships = json_decode($request->request->get('data'), true);
        foreach($daySponsorships as $daySponsorship) {
            $daySponsorship->setNumber($newDaySponsorships[$daySponsorship->getDay()]['number']);
            $em->persist($daySponsorship);
        }



        $em->flush();

        $res = array(
            'status' => 1
        );

        return new JsonResponse($res);
    }

    /**
     * Edits an existing Bar entity promotions.
     *
     * @Route("/promo/{id}", name="bar_update_promo")
     * @Method("POST")
     */
    public function updatePromoAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $pm = $this->get('cac_bar.promotion_manager');

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('L\'établissement demandé n\'existe pas.');
        }

        $promotions = $entity->getPromotions();

        $promotionDummy = new PromotionDummy();
        $dummyJSON = $pm->toDummyJSON($promotions);
        $promotionDummy->setPromotion($dummyJSON);

        $newPromotions = json_decode($request->request->get('data'), true);
        foreach($promotions as $promotion) {
            $options = $promotion->getOptions();
            foreach($options as $option) {
                $category = $option->getCategoryShortcode();
                if($category == 'restriction') $category = 'condition';
                $option->setValue($newPromotions[$promotion->getDay()][$promotion->getCategory()][$category]);
                $em->persist($option);
            }
        }

        $em->flush();

        $res = array(
            'status' => 1
        );

        return new JsonResponse($res);
    }

    /**
     * @Route("/retourOffre/{id}", name="bars_offerFeedback")
     * @Template()
     */
    public function offerFeedbackAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $barId = $em->getRepository('CacBarBundle:Bar')->findBy(array('author'=> $user->getId()));
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);
        if ($barId === 0) {
            return $this->redirect($this->generateUrl('bar_new'));
        }
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        
        $promoOffertes = $em->getRepository('CacBarBundle:PromoOffertes')->findBy(array('bar'=> $bar), array('id' => 'DESC'));
        $verresOfferts = $em->getRepository('CacBarBundle:verresOfferts')->findBy(array('bar'=> $bar), array('id' => 'DESC'));
        return array(
            'bar'      => $bar,
            'promos' => $promoOffertes,
            'verres' => $verresOfferts,
        );  
    }

    /**
     * @Route("/list", name="bars_list")
     * @Template()
     */
    public function listBarAction()
    {
        // Mac et UNIX/Linux
        setlocale(LC_TIME, "fr_FR");
        // Windows
        //setlocale(LC_TIME, "french");
        $today = ucfirst(strftime("%A"));
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();
        $bars = array();
        $i = 0;
        foreach ($entities as $entity) {
            $promoOfTheDay = $entity->getPromotionByDay($today)->getOption('value')->getValue();
            $happyHourOfTheDay = $entity->getHappyHourByDay($today)->getOption('value')->getValue();
            $nbAvis = count($entity->getComments()->getValues());
            $coms = $entity->getComments()->getValues();
            $note = 0;
            foreach ($coms as $com) {
                $note += $com->getNote();
            }
           $bars[$i]['id'] = $entity->getId();
           $bars[$i]['path'] = $entity->getPath();
           $bars[$i]['name'] = $entity->getName();
           $bars[$i]['dresscode'] = $entity->getDressCode();
           $bars[$i]['averagePrice'] = $entity->getCocktailPrice();
           $bars[$i]['adress'] = $entity->getAdress();
           $bars[$i]['zipcode'] = $entity->getZipCode();
           $bars[$i]['town'] = $entity->getTown();
           $bars[$i]['nbAvis'] = $nbAvis;
           $bars[$i]['note'] = $note;
           $bars[$i]['promo'] = $promoOfTheDay;
           $bars[$i]['happy'] = $happyHourOfTheDay;
           $bars[$i]['author'] = $entity->getAuthor();
           $i ++;
        }



       
        return array(
            'bars' => $bars,
            'today' => $today
        );
    }

    /**
     * @Route("/retourMail", name="bars_mailFeedback")
     * @Template()
     */
    public function offerMailAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user !== "anon." && $user->getRoles()[0] === "ROLE_BIGBOSS") {
            $em = $this->getDoctrine()->getManager();
            $barId = $em->getRepository('CacBarBundle:Bar')->findBy(array('author'=> $user->getId()));
            return $this->redirect($this->generateUrl('bars_offerFeedback', array('id' => $barId[0]->getId())));
        }

        return $this->redirect($this->generateUrl('home'));
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
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $entity->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }
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
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $role = $this->get('security.context')->isGranted('ROLE_COSMO');
        $bars = $em->getRepository('CacBarBundle:Bar')->findByAuthor($user);

        if (count($bars) > 0 && $role === false ) {
            ldd('Vous ne pouvez créer qu\'un seul bar avec la formule shooter !');
        }

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
     * @Template("CacBarBundle:Pro:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Bar();
        $pm = $this->get('cac_bar.promotion_manager');
        $emptyPromotions = $pm->getEmptyPromotions();
        $emptyHappyHours = $pm->getEmptyHappyHours();
        $emptyDaySponsorships = $pm->getEmptyDaySponsorships();

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

            foreach($emptyDaySponsorships as $daySS) {
                $entity->addDaySponsorship($daySS);
                $daySS->setBar($entity);
                $em->persist($daySS);
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
            ->add('file', null, array('label' => '+'))
            ->add("Poursuivre", 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $coords = json_decode($request->request->get('coords'), true);
            $entity->preUpload();
            $em->persist($entity);
            $em->flush();
            //$entity->resizeImg($coords);
            return $this->redirect($this->generateUrl('promotion_create', array('id' => $id)));
        }
        return $this->render('CacBarBundle:Pro:newPart2.html.twig', array(
            'form' => $form->createView(),
            'id' => $id,
            'bar' => $entity
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
        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $entity->getAuthor() && $role !== true ) {
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
        );

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
        if ($promo->getEtat() === "non validé") {
            $customer = $promo->getBar()->getAuthor();
            \Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
            $payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($customer);
            $customerId = $payment->getCustomerId();
            \Stripe\InvoiceItem::create(array(
                "customer" => $customerId,
                "amount" => $customer->getGlassPrice(),
                "currency" => "eur",
                "description" => "Promotion")
            );
        }
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
        $customer = $promo->getBar()->getAuthor();
        \Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
        $payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($customer);
        $customerId = $payment->getCustomerId();
        \Stripe\InvoiceItem::create(array(
            "customer" => $customerId,
            "amount" => '-'.$customer->getGlassPrice(),
            "currency" => "eur",
            "description" => "Promotion")
        );
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

    /**
     * Upload a file to a Bar entity.
     *
     * @Route("/upload/{id}", name="file_upload", options={"expose"=true})
     * @Method({"GET", "POST"})
     * @Template("CacBarBundle:Pro:upload.html.twig")
     */
    public function uploadAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$bar) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $file = new File();
        $form = $this->createFormBuilder($file)
            ->add('file')
            ->getForm()
        ;

        if ($this->getRequest()->isMethod('POST')) {
            $form->handleRequest($this->getRequest());
            if ($form->isValid()) {
                $file->setBar($bar);
                $em->persist($file);
                $em->flush();

                return $this->redirect($this->generateUrl('file_upload', array('id' => $bar->getId())));
            }
        }

        return array(
            'bar' => $bar,
            'form' => $form->createView()
        );
    }

    /**
     * Delete a file from a Bar entity.
     *
     * @Route("/delete-file/{id}/{bar}", name="file_delete")
     */
    public function deleteFileAction($id, Bar $bar = null)
    {
        $em = $this->getDoctrine()->getManager();
        if($id != 0) {
            $file = $em->getRepository('CacBarBundle:File')->find($id);
        } else {
            $bar->setPath('defaultImageBar.jpg');
            $em->persist($bar);
            $em->flush();

            return $this->redirect($this->generateUrl('file_upload', array('id' => $bar->getId())));
        }
        if($bar === null) $bar = $em->getRepository('CacBarBundle:Bar')->find($file->getBar()->getId());

        if (!$file) {
            throw $this->createNotFoundException('Le fichier demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $bar->removeFile($file);
        $em->persist($bar);
        $em->remove($file);
        $em->flush();

        return $this->redirect($this->generateUrl('file_upload', array('id' => $bar->getId())));
    }

    /**
     * Manage slider for a Bar entity.
     *
     * @Route("/manage-slider/{id}", name="manage_slider")
     * @Method({"GET"})
     * @Template("CacBarBundle:Pro:manageSlider.html.twig")
     */
    public function manageSliderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $bar = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$bar) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        return array(
            'bar' => $bar
        );
    }

    /**
     * Save slider order for a Bar entity.
     *
     * @Route("/save-slider-order", name="save_slider_order", options={"expose"=true})
     * @Method({"POST"})
     */
    public function saveSliderOrderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $list = $request->request->get('list');
        $res = [];

        foreach($list as $value) {
            $file = $em->getRepository('CacBarBundle:File')->find($value['id']);
            $file->setOrder(intval($value['order']));
            $em->persist($file);
            array_push($res, array($value['id'] => $value['order']));
        }
        $em->flush();
        array_push($res, array('status' => '1'));

        return new JsonResponse($res);
    }

    /**
     * Crop image for Bar entity.
     *
     * @Route("/crop/{id}", name="crop")
     * @Method({"GET", "POST"})
     * @Template("CacBarBundle:Pro:crop.html.twig")
     */
    public function cropAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('CacBarBundle:File')->find($id);
        $bar = $em->getRepository('CacBarBundle:Bar')->find($file->getBar()->getId());

        if (!$bar) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        list($width, $height, $type, $attr) = getimagesize($file->getAbsolutePath());

        return array(
            'bar' => $bar,
            'file' => $file,
            'imgWidth' => $width,
            'imgHeight' => $height
        );
    }

    /**
     * Save crop size for a File entity.
     *
     * @Route("/save-crop/{id}", name="save_crop", options={"expose"=true})
     * @Method({"POST"})
     */
    public function saveCropAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $file = $em->getRepository('CacBarBundle:File')->find($id);
        $bar = $em->getRepository('CacBarBundle:Bar')->find($file->getBar()->getId());

        if (!$bar) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $ratio = $request->request->get('ratio');

        $cropX = floor($request->request->get('x')/$ratio);
        $cropY = floor($request->request->get('y')/$ratio);
        $cropW = floor($request->request->get('w')/$ratio);
        $cropH = floor($request->request->get('h')/$ratio);

        $res = [];

        $file->setCropX($cropX);
        $file->setCropY($cropY);
        $file->setCropH($cropW);
        $file->setCropW($cropH);

        $em->persist($file);

        array_push($res, array('coords' => array(
            'x' => $cropX,
            'y' => $cropY,
            'w' => $cropW,
            'h' => $cropH
        )));

        $em->flush();

        array_push($res, array('status' => '1'));

        return new JsonResponse($res);
    }

    /**
     * Add/remove image from slider for a Bar entity.
     *
     * @Route("/toggle-picture", name="toggle_picture", options={"expose"=true})
     * @Method({"POST"})
     */
    public function togglePictureAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('id');
        $file = $em->getRepository('CacBarBundle:File')->find($id);
        $bar = $em->getRepository('CacBarBundle:Bar')->find($file->getBar()->getId());

        if (!$bar) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        if ($this->get('security.context')->isGranted('ROLE_ADMIN'))
            $role = true;
        else
            $role = false;
        if ($this->get('security.context')->getToken()->getUser() != $bar->getAuthor() && $role !== true ) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $res = [];

        if($file->getSlider() == 0) {
            $file->setSlider(1);
        } else {
            $file->setSlider(0);
        }

        $em->persist($file);
        $em->flush();

        array_push($res, array('status' => '1'));

        return new JsonResponse($res);
    }
}
