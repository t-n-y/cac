<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 * Admin default controller.
 *
 * @Route("/whostheboss")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/nombre-mise-en-avant", name="bn_highlight")
     * @Template()
     */
    public function nbHighlightAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$highlight = $em->getRepository('CacAdminBundle:NbHighlight')->findAll();


		if (count($highlight) === 0) {
			return $this->redirect($this->generateUrl('nbhighlight_new'));
		}
		else{
			return $this->redirect($this->generateUrl('nbhighlight_edit', array('id' => 1)));
		}

	}

    /**
     * @Route("/carte-to-validate", name="validate_carte")
     * @Template()
     */
    public function validateCarteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository('CacBarBundle:CarteBar')->findByVisible(false);

        return array('cartes' => $cartes);
    }

    /**
     * @Route("/validate-carte/{id}", name="validate_the_carte", options={"expose"=true})
     */
    public function validateTheCarteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('CacBarBundle:CarteBar')->find($id);
        $carte->setVisible(true);
        $em->persist($carte);
        $em->flush();
        return new Response("carte validée");
    }
}
