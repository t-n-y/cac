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
     * @Route("/map", name="map") 
     * @Template()
     */
    public function mapAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findAll();

        $adress = array();
        $i = 0;
        foreach ($entities as $entity) {
            $adress['adress'][$i] = $entity->getAdress().' , '.$entity->getTown().' , '.$entity->getCountry();
            $adress['info'][$i] = $entity->getName();
            $adress['id'][$i] = $entity->getId();
            $i++;
        }

        return array('adress' => json_encode($adress));
    }

    /**
     * @Route("/sort/price", name="sortByPrice", options={"expose"=true}) 
     * @Template()
     */
    public function sortByPriceAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findBy(array(), array('cocktailPrice'=>'ASC'));
        return array('bars' => $entities);

    }

    /**
     * @Route("/sort/date", name="sortByDate", options={"expose"=true}) 
     * @Template("CacBarBundle:Default:sortByPrice.html.twig")
     */
    public function sortByDateAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findBy(array(), array('creationDate'=>'DESC'));
        return array('bars' => $entities);
    }

    /**
     * @Route("/sort/best", name="sortByBest", options={"expose"=true}) 
     * @Template("CacBarBundle:Default:sortByPrice.html.twig")
     */
    public function sortByBestAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('CacBarBundle:Bar')->findBy(array(), array('score'=>'DESC'));
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

    private function randomBar()
    {
        $em = $this->getDoctrine()->getManager();
        $randomIdBar = $em->getRepository('CacBarBundle:Bar')->findOneRandom();
        return $randomIdBar;
    }

    /**
     * @Route("/bars/show/random", name="randomBar") 
     */
    public function randomBarAction()
    {   
        return $this->redirect($this->generateUrl('bar_show', array('id' => $this->randomBar()['id'])));
    }
}
