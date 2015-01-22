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
     * @Route("/sort/price", name="sortByPrice", options={"expose"=true}) 
     * @Template()
     */
    public function sortByPriceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findBy(array(), array('priceRange'=>'ASC'));
        return array('bars' => $entities);
    }

    /**
     * @Route("/sort/date", name="sortByDate", options={"expose"=true}) 
     * @Template()
     */
    public function sortByDateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findBy(array(), array('creationDate'=>'ASC'));
        return array('bars' => $entities);
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
