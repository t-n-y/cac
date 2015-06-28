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
 * user reservations controller.
 *
 * @Route("/")
 */
class UserReservationsController extends Controller
{
    /**
     * get past reservation of the user.
     *
     * @Route("/past-reservations", name="past-reservations")
     * @Template()
     */
    public function pastReservationsAction()
    {
        setlocale(LC_TIME, "fr_FR");
        $today = ucfirst(strftime("%A"));

        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $promoOffertes = $em->getRepository('CacBarBundle:PromoOffertes')->findBy(array('user'=> $user), array('id' => 'DESC'));
        return array(
            'promoOffertes' => $promoOffertes,
            'today' => $today,
        );
    }

    /**
     * get past reservation of the user.
     *
     * @Route("/past-invitations", name="past-invitations")
     * @Template()
     */
    public function pastInvitationsAction()
    {
        setlocale(LC_TIME, "fr_FR");
        $today = ucfirst(strftime("%A"));

        $user = $this->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $verresOfferts = $em->getRepository('CacBarBundle:VerresOfferts')->findBy(array('user'=> $user), array('id' => 'DESC'));
        return array(
            'verresOfferts' => $verresOfferts,
            'today' => $today,
        );
    }
}
