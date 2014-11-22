<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Form\Type\BarType;
use Cac\BarBundle\Form\Type\PromotionType;
/**
 * Bar controller.
 *
 * @Route("/bars/promotion")
 */
class PromotionController extends Controller
{
	/**
     * Displays the promotion and happy-hours interface for an existing Bar entity.
     *
     * @Route("/{id}/edit", name="promotion_edit")
     * @Method("GET")
     * @Template("CacBarBundle:Promotion:edit.html.twig")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $promotion = $entity->getPromotion();

        $restrictions = $em->getRepository('CacBarBundle:Restriction')->findAll();

        if (!$entity) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        $editForm = $this->createEditForm($promotion);

        return array(
            'promotion'      => $promotion,
            'form'   => $editForm->createView(),
            'restrictions' => $restrictions
        );
    }

    /**
    * Creates a form to edit a Bar entity.
    *
    * @param Bar $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Promotion $promotion)
    {
        $form = $this->createForm(new PromotionType(), $promotion, array(
            'action' => $this->generateUrl('promotion_update', array('id' => $promotion->getId())),
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
     * Edits an existing Bar entity.
     *
     * @Route("/{id}", name="promotion_update")
     * @Method("PUT")
     * @Template("CacBarBundle:Promotion:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $promotion = $em->getRepository('CacBarBundle:Promotion')->find($id);
        $entity = $promotion->getBar();

        if (!$entity) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }

        $editForm = $this->createEditForm($promotion);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('promotion_show', array('id' => $entity->getId())));
        }

        return array(
            'bar'      => $entity,
            'form'   => $editForm->createView()
        );
    }

    /**
     * Finds and displays a Bar entity.
     *
     * @Route("/{id}", name="promotion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);
        $restrictions = $em->getRepository('CacBarBundle:Restriction')->findAll();

        $editForm = $this->createEditForm($entity->getPromotion());

        return array(
            'bar'      => $entity,
            'form'   => $editForm->createView(),
            'restrictions' => $restrictions
        );
    }
}
