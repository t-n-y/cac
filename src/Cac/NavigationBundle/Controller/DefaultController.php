<?php

namespace Cac\NavigationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Bar;

class DefaultController extends Controller
{
    /**
     * @Route("/navigation", name="navigation")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bigboss = $this->get('security.context')->getToken()->getUser();
        $bar = $em->getRepository('CacBarBundle:Bar')->findOneByAuthor($bigboss->getId());

        return array('bar' => $bar);
    }
}
