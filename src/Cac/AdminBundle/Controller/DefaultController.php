<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
}
