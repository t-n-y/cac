<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends Controller
{
    /**
     * @Route("/ajax-search", name="ajax_search")
     * @Method("POST")
     */
    public function ajaxSearchAction(Request $request)
    {
        $search = $request->request->get('search');

        $res = $this->getDoctrine()->getRepository('CacBarBundle:Bar')->research($search);

        return new JsonResponse($res); 
    }

}
