<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\AdminBundle\Entity\NbHighlight;
use Cac\AdminBundle\Form\NbHighlightType;

/**
 * NbHighlight controller.
 *
 * @Route("whostheboss/nbhighlight")
 */
class NbHighlightController extends Controller
{

    /**
     * Creates a new NbHighlight entity.
     *
     * @Route("/", name="nbhighlight_create")
     * @Method("POST")
     * @Template("CacAdminBundle:NbHighlight:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NbHighlight();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bn_highlight'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a NbHighlight entity.
     *
     * @param NbHighlight $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NbHighlight $entity)
    {
        $form = $this->createForm(new NbHighlightType(), $entity, array(
            'action' => $this->generateUrl('nbhighlight_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NbHighlight entity.
     *
     * @Route("/new", name="nbhighlight_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NbHighlight();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing NbHighlight entity.
     *
     * @Route("/edit", name="nbhighlight_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacAdminBundle:NbHighlight')->findAll();
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NbHighlight entity.');
        }

        $editForm = $this->createEditForm($entity[0]);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a NbHighlight entity.
    *
    * @param NbHighlight $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NbHighlight $entity)
    {
        $form = $this->createForm(new NbHighlightType(), $entity, array(
            'action' => $this->generateUrl('nbhighlight_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NbHighlight entity.
     *
     * @Route("/update", name="nbhighlight_update")
     * @Method("PUT")
     * @Template("CacAdminBundle:NbHighlight:edit.html.twig")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacAdminBundle:NbHighlight')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NbHighlight entity.');
        }

        $editForm = $this->createEditForm($entity[0]);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('nbhighlight_edit'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
}
