<?php

namespace Cac\BarBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Bigboss;
use Cac\BarBundle\Form\RegistrationBigbossFormType;

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
        return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\BarBundle\Entity\Bigboss');
    }
}