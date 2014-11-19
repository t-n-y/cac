<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Barman;
use Cac\BarBundle\Form\BarmanType;

/**
 * Barman controller.
 *
 * @Route("/barman")
 */
class BarmanController extends Controller
{

    /**
     * Lists all Barman entities.
     *
     * @Route("/", name="barman")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CacBarBundle:Barman')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Barman entity.
     *
     * @Route("/", name="barman_create")
     * @Method("POST")
     * @Template("CacBarBundle:Barman:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Barman();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('barman_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Barman entity.
     *
     * @param Barman $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Barman $entity)
    {
        $form = $this->createForm(new BarmanType(), $entity, array(
            'action' => $this->generateUrl('barman_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Barman entity.
     *
     * @Route("/new", name="barman_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Barman();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Barman entity.
     *
     * @Route("/{id}", name="barman_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Barman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barman entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Barman entity.
     *
     * @Route("/{id}/edit", name="barman_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Barman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barman entity.');
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
    * Creates a form to edit a Barman entity.
    *
    * @param Barman $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Barman $entity)
    {
        $form = $this->createForm(new BarmanType(), $entity, array(
            'action' => $this->generateUrl('barman_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Barman entity.
     *
     * @Route("/{id}", name="barman_update")
     * @Method("PUT")
     * @Template("CacBarBundle:Barman:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Barman')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Barman entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('barman_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Barman entity.
     *
     * @Route("/{id}", name="barman_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('CacBarBundle:Barman')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Barman entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('barman'));
    }

    /**
     * Creates a form to delete a Barman entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('barman_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
