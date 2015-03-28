<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\CarteBar;
use Cac\BarBundle\Form\CarteBarType;

/**
 * CarteBar controller.
 *
 * @Route("/cartebar")
 */
class CarteBarController extends Controller
{

    /**
     * Lists all CarteBar entities.
     *
     * @Route("/", name="cartebar")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CacBarBundle:CarteBar')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new CarteBar entity.
     *
     * @Route("/", name="cartebar_create")
     * @Method("POST")
     * @Template("CacBarBundle:CarteBar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new CarteBar();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('cartebar_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CarteBar entity.
     *
     * @param CarteBar $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CarteBar $entity)
    {
        $form = $this->createForm(new CarteBarType(), $entity, array(
            'action' => $this->generateUrl('cartebar_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new CarteBar entity.
     *
     * @Route("/new", name="cartebar_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new CarteBar();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a CarteBar entity.
     *
     * @Route("/{id}", name="cartebar_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:CarteBar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarteBar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing CarteBar entity.
     *
     * @Route("/{id}/edit", name="cartebar_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:CarteBar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarteBar entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a CarteBar entity.
    *
    * @param CarteBar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CarteBar $entity)
    {
        $form = $this->createForm(new CarteBarType(), $entity, array(
            'action' => $this->generateUrl('cartebar_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CarteBar entity.
     *
     * @Route("/{id}", name="cartebar_update")
     * @Method("PUT")
     * @Template("CacBarBundle:CarteBar:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:CarteBar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CarteBar entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cartebar_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CarteBar entity.
     *
     * @Route("/{id}", name="cartebar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CacBarBundle:CarteBar')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CarteBar entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cartebar'));
    }

    /**
     * Creates a form to delete a CarteBar entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cartebar_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
