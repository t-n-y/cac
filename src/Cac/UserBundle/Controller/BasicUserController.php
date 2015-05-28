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
 * @Route("/user")
 */
class BasicUserController extends Controller
{
    /**
     * Register new user entities.
     *
     * @Route("/register", name="user_register")
     * @Template()
     */
    public function registerAction()
    {
        return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\UserBundle\Entity\BasicUser');
    }

    /**
     * Register new user entities.
     *
     * @Route("/sconfirm/{email}&{token}", name="user_sconfirm")
     * @Template()
     */
    public function sconfirmAction($email, $token)
    {
        var_dump(urldecode($email));
        var_dump($token);
        var_dump(
            'http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('user_sconfirm', array(
                'email' => urlencode('cuicui@gmail.schtroumpf'),
                'token' => 'cuicui'
                ))
            );
        die;
    }
}