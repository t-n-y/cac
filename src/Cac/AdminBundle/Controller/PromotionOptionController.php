<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Cac\BarBundle\Entity\PromotionOptionCategory;
use Cac\BarBundle\Form\Type\PromotionOptionCategoryType;
use Cac\BarBundle\Entity\PromotionOption;
use Cac\BarBundle\Form\Type\PromotionOptionType;
/**
 * Admin default controller.
 *
 * @Route("/whostheboss/promotion")
 */
class PromotionOptionController extends Controller
{
    /**
     * @Route("/", name="promotion_index")
     * @Template()
     */
    public function indexAction()
    {
        return array(); 
    }

    /**
     * @Route("/options/categories", name="promotion_option_category_index")
     * @Template()
     */
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findAll();

        $entity = new PromotionOptionCategory();
        $form   = $this->createCategoryCreateForm($entity);

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
    private function createCategoryCreateForm(PromotionOptionCategory $entity)
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
     * @Route("/options/categories/create", name="promotion_option_category_create")
     * @Method("POST")
     * @Template("CacAdminBundle:PromotionOption:categories.html.twig")
     */
    public function createCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new PromotionOptionCategory();

        $form = $this->createCategoryCreateForm($entity);
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

    /**
     * @Route("/options", name="promotion_options_index")
     * @Template()
     */
    public function optionsAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:PromotionOption')->findAll();

        $entity = new PromotionOption();
        $form   = $this->createOptionCreateForm($entity);

        return array(
                'entities' => $entities,
                'entity' => $entity,
                'form' => $form->createView()
            ); 
    }

    /**
    * Creates a form to create a PromotionOption entity.
    *
    * @param PromotionOptionCategory $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createOptionCreateForm(PromotionOption $entity)
    {
        $form = $this->createForm(new PromotionOptionType(), $entity, array(
            'action' => $this->generateUrl('promotion_option_create'),
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
     * @Route("/option/create", name="promotion_option_create")
     * @Method("POST")
     * @Template("CacAdminBundle:PromotionOption:options.html.twig")
     */
    public function createOptionAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new PromotionOption();

        $form = $this->createOptionCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('promotion_options_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

}
