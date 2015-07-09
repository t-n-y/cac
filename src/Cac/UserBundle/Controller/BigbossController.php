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

    /**
     * @Route("/compte/{id}", name="compte")
     * @Template()
     */
    public function compteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('CacBarBundle:Bar')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Le bar demandé n\'existe pas.');
        }
        if ($this->get('security.context')->getToken()->getUser() != $entity->getAuthor()) {
            throw $this->createNotFoundException('Vous n\'avez pas accés à ce contenu.');
        }

        $payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($entity->getAuthor());
        \Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
        $customerId = $payment->getCustomerId();
        // $cu = \Stripe\Customer::retrieve($customerId);
        

        $upcomingInvoice = \Stripe\Invoice::upcoming(array("customer" => $customerId));
        $amoutDue = $upcomingInvoice->__toArray(true)['amount_due'];
        $amoutDue = $amoutDue / 100;

        $end = $upcomingInvoice->__toArray(true)['period_end'];
        // $end = $cu->__toArray(true)['subscriptions']['data'][0]['current_period_end'];
        $date = new \DateTime();
        $date->setTimestamp($end);
        $facturationDate = $date->format('d-m-Y');

        setlocale(LC_TIME, "fr_FR");
        $today = ucfirst(strftime("%A"));

        $restriction = $em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneBy(array('shortcode' => 'restriction'));
        $restrictions = $em->getRepository('CacBarBundle:PromotionOption')->findBy(array('category' => $restriction->getId()));

        return array(
            'bar'      => $entity,
            'today' => $today,
            'restrictions' => $restrictions,
            'facturationDate' => $facturationDate,
            'amoutDue' => $amoutDue
        );     
    }
}