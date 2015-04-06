<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Cac\BarBundle\Entity\PromotionOptionCategory;
use Cac\BarBundle\Form\Type\PromotionOptionCategoryType;
/**
 * Admin default controller.
 *
 * @Route("/whostheboss/promotion-option")
 */
class PromotionOptionController extends Controller
{
    /**
     * @Route("/categories", name="promotion_option_category_index")
     * @Template()
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findAll();

        $entity = new PromotionOptionCategory();
        $form   = $this->createCreateForm($entity);

        return array(
                'entities' => $entities,
                'entity' => $entity,
                'form' => $form->createView()
            ); 
    }

    /**
    * Creates a form to create a PromotionOptionCategory entity.
    *
    * @param PromotionOptionCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PromotionOptionCategory $entity)
    {
        $form = $this->createForm(new PromotionOptionCategoryType(), $entity, array(
            'action' => $this->generateUrl('promotion_option_category_create'),
            'method' => 'POST',
        ));

        $form->add(
            'submit', 
            'submit', 
            array(
                'label' => 'Ajouter'
            )
        );

        return $form;
    }

    /**
     * Creates a new PromotionOptionCategory entity.
     *
     * @Route("/", name="promotion_option_category_create")
     * @Method("POST")
     * @Template("CacAdminBundle:PromotionOption:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new PromotionOptionCategory();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('promotion_option_category_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

}
