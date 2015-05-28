<?php

namespace Cac\MailingBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;
use Symfony\Component\HttpFoundation\Request;
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
    public function indexAction(Request $request)
    {
        /*$dispatcher = $this->get('hip_mandrill.dispatcher');

        $message = new Message();
        $templateName = 'user-validation';
        $link = 'http://www.click-and-cheers.com/';
        $templateContent = array(
            array(
                'name' => 'link',
                'content' => '<a href="'.$link.'">'.$link.'</a>'
            )
        );

        $message
            ->addTo('jonathan.brayette@gmail.com', 'Jonathan Brayette')
            ->setSubject('Test template')
            ->setTrackOpens(true)
            ->setTrackClicks(true);

        $result = $dispatcher->send($message, $templateName, $templateContent);

        return new Response('<pre>' . print_r($result, true) . '</pre>');*/
        var_dump();
        die;

    }

}