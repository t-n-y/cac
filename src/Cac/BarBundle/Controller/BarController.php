<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Bar;
use Cac\BarBundle\Form\Type\BarType;
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
     * @Template("BarBundle:Bar:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Bar();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('bar_show', array('id' => $entity->getId())));
        }

        return array(
            'bar' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * @Route("/edit")
     * @Template()
     */
    public function editAction()
    {
        return array(
                // ...
            );    
    }

    /**
     * Finds and displays a Bar entity.
     *
     * @Route("/{id}", name="bar_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        return array(
            'bar'      => $entity
        );
    }

    /**
     * @Route("/delete")
     * @Template()
     */
    public function deleteAction()
    {
        return array(
                // ...
            );    
    }

    /**
     * @Route("/search")
     * @Template()
     */
    public function searchAction()
    {
        return array(
                // ...
            );    
    }

    /**
     * @Route("evaluate")
     * @Template()
     */
    public function evalAction()
    {
        return array(
                // ...
            );    
    }

}
