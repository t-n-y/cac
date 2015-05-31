<?php

namespace Cac\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Cac\PaymentBundle\Entity\Payment;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/free-pay", name="free-pay", options={"expose"=true})
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();

    	if ($this->getRequest()->isMethod('POST')) {
    		\Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
			$token = $_POST['stripeToken'];

			$this->createFreeStripeUser($user, $em, $token);
			return $this->redirect($this->generateUrl('confirm_payment'));
    	}
        return array();
    }

    /**
     * @Route("/premium-pay", name="premium-pay", options={"expose"=true})
     * @Template()
     */
    public function premiumAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	if ($this->getRequest()->isMethod('POST')) {
    		\Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");
    		
			$token = $_POST['stripeToken'];
			$this->createPremiumStripeUser($user, $em, $token);
			return $this->redirect($this->generateUrl('confirm_payment'));
    	}
        return array();
    }

    private function createFreeStripeUser($user, $em, $token)
    {
		try {
			$customer = \Stripe\Customer::create(array(
			  "source" => $token,
			  "plan" => "free",
			  "email" => $user->getEmail(),
			  "description" => $user->getFirstname().' '.$user->getName())
			);	
			$payment = new Payment();
			$payment->setUser($user);
			$payment->setCustomerId($customer->id);
			$payment->setPlan('free');
			$em->persist($payment);
			$em->flush();
		} catch (Exception $e) {
			
		}
    }

    private function createPremiumStripeUser($user, $em, $token)
    {
		try {
			$customer = \Stripe\Customer::create(array(
			  "source" => $token,
			  "plan" => "premium",
			  "email" => $user->getEmail(),
			  "description" => $user->getFirstname().' '.$user->getName())
			);	
			$payment = new Payment();
			$payment->setUser($user);
			$payment->setCustomerId($customer->id);
			$payment->setPlan('premium');
			$em->persist($payment);
			$em->flush();
		} catch (Exception $e) {
			
		}
    }

    /**
     * @Route("/change-plan/{plan}/{id}")
     * @Template()
     */
    public function changePlanAction($plan, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($id);
    	$newPlan = $plan;

    	\Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");

    	$customerId = $payment->getCustomerId();

		$cu = \Stripe\Customer::retrieve($customerId);

		$planId = $cu->subscriptions->data[0]->id;

		$subscription = $cu->subscriptions->retrieve($planId);
		$subscription->plan = $newPlan;
		$subscription->save();

		// $plouf = \Stripe\InvoiceItem::create(array(
		//     "customer" => $customerId,
		//     "amount" => -500,
		//     "currency" => "eur",
		//     "description" => "One-time setup fee number two")
		// );

        return new Response('plan update');
    }

    /**
     * @Route("/payment-sucess", name="confirm_payment")
     * @Template()
     */
    public function confirmPaymentAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	$barId = $em->getRepository('CacBarBundle:Bar')->findByAuthor($user)[0]->getId();
    	return array('barId' => $barId);
    }
}
