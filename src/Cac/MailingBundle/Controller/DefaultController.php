<?php

namespace Cac\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;
/**
 * Mailing controller.
 *
 * @Route("/mailing")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/test")
     * @Template()
     */
    public function indexAction()
    {
        $dispatcher = $this->get('hip_mandrill.dispatcher');

        $message = new Message();
        $templateName = 'test-template';

        $message
            ->addTo('jonathan.brayette@gmail.com', 'Jonathan')
            ->setSubject('Validation')
            ->setText('Merci de valider votre inscription')
            ->setTrackOpens(true)
            ->setTrackClicks(true);

        $result = $dispatcher->send($message, $templateName);

        return new Response('<pre>' . print_r($result, true) . '</pre>');

    }

}