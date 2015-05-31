<?php

namespace Cac\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\UserBundle\Entity\Bigboss;
use Cac\UserBundle\Form\RegistrationBigbossFormType;

/**
 * Barman controller.
 *
 * @Route("/bigboss")
 */
class BigbossController extends Controller
{
    /**
     * Register new Bigboss entities.
     *
     * @Route("/register", name="bigboss_register")
     * @Template()
     */
    public function registerAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if ($user !== "anon." && $user->getRoles()[0] === "ROLE_BIGBOSS") {
            $em = $this->getDoctrine()->getManager();
            $barId = $em->getRepository('CacBarBundle:Bar')->findBy(array('author'=> $user->getId()));
            if ($barId === 0) {
                return $this->redirect($this->generateUrl('bars_offerFeedback', array('id' => $barId[0]->getId())));
            }
            else
                return $this->redirect($this->generateUrl('bar_new'));
        }
        else{
            return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\UserBundle\Entity\Bigboss');
        }
    }
}