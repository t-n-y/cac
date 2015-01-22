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
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
use Cac\BarBundle\Form\Type\BarEditType;
use Cac\AdminBundle\Entity\Visited;
/**
 * Bar controller.
 *
 * @Route("/bars")
 */
class BarController extends Controller
{
    /**
     * @Route("/list", name="bars")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();

        return array(
                'bars' => $entities
            );    
    }

    /**
     * @Route("/abonnement/{id}", name="bars_abonnement")
     * @Template()
     */
    public function abonnementAction($id)
    {
        return array(
                
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
        $promotion = new Promotion();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {

            $entity->setAuthor($user);
            $entity->setPromotion($promotion);
            $promotion->setPromotion('');
            $promotion->setBar($entity);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->persist($promotion);
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
            $entity->preUpload();
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('promotion_create', array('id' => $id)));
        }

        return $this->render('CacBarBundle:Bar:newPart2.html.twig', array(
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
     * Finds and displays a Bar entity.
     *
     * @Route("/{id}", name="bar_show")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $user = $this->get('security.context')->getToken()->getUser();

        $visit = new Visited();
        $visit->setBar($entity);
        if (is_object($user)) {
            $visit->setUser($user);
        }
        $visit->setCreatedAt(new \DateTime('now'));
        $em->persist($visit);
        $em->flush();

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'bar'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * @Route("/note/{id}/{text}/{note}", name="bar_eval", options={"expose"=true})
     * @Template()
     */
    public function evalAction($id, $text, $note)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        $comment = new Comment();
        $comment->setBar($entity);
        $comment->setComment($text);
        $comment->setNote($note);
        $comment->setCreatedAt(new \DateTime('now'));
        $em->persist($comment);
        $em->flush();

        return new Response('comment');
    }
}
