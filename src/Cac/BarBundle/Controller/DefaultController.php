<?php

namespace Cac\BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Bar;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/search/{value}", name="search", options={"expose"=true}) 
     * @Template()
     */
    public function searchAction($value)
    {

        $em = $this->getDoctrine()->getManager();
        $search = $em->getRepository('CacBarBundle:Bar')->getSearchResult($value);
        return array('searchResults' => $search, 'searchParams' => $value);
    }
}
