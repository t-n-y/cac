<?php

namespace Cac\BarBundle\Controller;

use Cac\BarBundle\Entity\Bar;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Event;
use Cac\BarBundle\Form\EventType;

/**
 * SMS Campagne controller.
 *
 * @Route("/sms-campaign")
 */
class SMSCampaignController extends Controller
{
    /**
     * Send a new SMS campaign.
     *
     * @Route("/send", name="campaign_send", options={"expose"=true})
     * @Method("POST")
     */
    public function sendAction(Request $request)
    {
        $response = array(
            'status' => 'ok'
        );
        return new JsonResponse($response);
    }
}