<?php

namespace Cac\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\UserBundle\Entity\Barman;
use Cac\UserBundle\Form\RegistrationBarmanFormType;

/**
 * Barman controller.
 *
 * @Route("/barman")
 */
class BarmanController extends Controller
{
    /**
     * Register new Barman entities.
     *
     * @Route("/register", name="barman_register")
     * @Template()
     */
    public function registerAction()
    {
        return $this->container
                    ->get('pugx_multi_user.registration_manager')
                    ->register('Cac\UserBundle\Entity\Barman');
    }
}
