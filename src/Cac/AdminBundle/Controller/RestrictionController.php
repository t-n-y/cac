<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Cac\BarBundle\Entity\Restriction;
use Cac\BarBundle\Form\Type\RestrictionType;
/**
 * Admin default controller.
 *
 * @Route("/whostheboss/restrictions")
 */
class RestrictionController extends Controller
{
    /**
     * @Route("/list", name="restriction_index")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
    
        $entities = $em->getRepository('CacBarBundle:Restriction')->findAll();

        $entity = new Restriction();
        $form   = $this->createCreateForm($entity);

        return array(
                'restrictions' => $entities,
                'entity' => $entity,
                'form' => $form->createView()
            ); 
    }

    /**
    * Creates a form to create a Restriction entity.
    *
    * @param Restriction $restriction The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Restriction $entity)
    {
        $form = $this->createForm(new RestrictionType(), $entity, array(
            'action' => $this->generateUrl('restriction_create'),
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
     * Creates a new Restriction entity.
     *
     * @Route("/", name="restriction_create")
     * @Method("POST")
     * @Template("CacAdminBundle:Restriction:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Restriction();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        $user = $this->get('security.context')->getToken()->getUser();

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('restriction_index'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

}
