<?php

namespace Cac\PaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Cac\PaymentBundle\Entity\Payment;

class DefaultController extends Controller
{
    /**
     * @Route("/pay")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();

    	if ($this->getRequest()->isMethod('POST')) {
    		\Stripe\Stripe::setApiKey("sk_test_zLHsgtijLe1xYM1XPhf12zGY");

			// // Get the credit card details submitted by the form
			$token = $_POST['stripeToken'];
			$payment = new Payment();
			$payment->setUser($user);
			$payment->setToken($token);
			$em->persist($payment);
			$em->flush();
			
			try {
				$customer = \Stripe\Customer::create(array(
				  "source" => $token,
				  "plan" => "premium",
				  "email" => $user->getEmail())
				);	
			} catch (Exception $e) {
				
			}
			

			// // Create the charge on Stripe's servers - this will charge the user's card
			// try {
			// $charge = \Stripe\Charge::create(array(
			//   "amount" => 1000, // amount in cents, again
			//   "currency" => "eur",
			//   "source" => $token,
			//   "description" => "Example charge")
			// );
			// } catch(\Stripe\Error\Card $e) {
			//   // The card has been declined
			// }
    	}
        return array();
    }
}
