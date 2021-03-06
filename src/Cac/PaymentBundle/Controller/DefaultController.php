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
     * @Route("/free-pay", name="free-pay")
     * @Template()
     */
    public function indexAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();

    	if ($this->getRequest()->isMethod('POST')) {

            try {
                $stripeApikey = $this->container->getParameter('stripe_api_key');

                \Stripe\Stripe::setApiKey($stripeApikey);
                $token = $_POST['stripeToken'];

                $this->createFreeStripeUser($user, $em, $token);
                return $this->redirect($this->generateUrl('confirm_payment'));
            } catch (\Stripe\Error\Card $e) {
                // Card was declined.
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Votre carte n\'a pas pu être enregistrée.
                    Il semble que les informations que vous avez renseignées comportent une erreur, merci de recommencer.'
                );
                $referer = $this->getRequest()->headers->get('referer');
                return $this->redirect($referer);
            }
    	}
        return array();
    }

    /**
     * @Route("/premium-pay", name="premium-pay")
     * @Template()
     */
    public function premiumAction(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();
    	$user = $this->get('security.context')->getToken()->getUser();
    	if ($this->getRequest()->isMethod('POST')) {



            try {
                $stripeApikey = $this->container->getParameter('stripe_api_key');

                \Stripe\Stripe::setApiKey($stripeApikey);
                
                $token = $_POST['stripeToken'];
                $this->createPremiumStripeUser($user, $em, $token);
                return $this->redirect($this->generateUrl('confirm_payment'));
            } catch (\Stripe\Error\Card $e) {
                // Card was declined.
                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'Votre carte n\'a pas pu être enregistrée.
                    Il semble que les informations que vous avez renseignées comportent une erreur, merci de recommencer.'
                );
                $referer = $this->getRequest()->headers->get('referer');
                return $this->redirect($referer);
            }
    	}
        return array();
    }

    private function createFreeStripeUser($user, $em, $token)
    {
		try {
			$customer = \Stripe\Customer::create(array(
			  "source" => $token,
			  "plan" => "shooter",
			  "email" => $user->getEmail(),
			  "description" => $user->getFirstname().' '.$user->getName())
			);	
			$payment = new Payment();
			$payment->setUser($user);
			$payment->setCustomerId($customer->id);
			$payment->setPlan('shooter');
			$user->addRole('ROLE_SHOOTER');
			$user->removeRole('ROLE_COSMO');
			$em->persist($payment);
			$em->flush();




            // générer un nouveau token
            $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                $user,
                null,
                'main',
                $user->getRoles()
            );
            $this->container->get('security.context')->setToken($token);

// faire un refresh du user a l'aide du user manager
            $userManager = $this->container->get('fos_user.user_manager');
            $userManager->refreshUser($user);


		} catch (Exception $e) {
			
		}
    }

    private function createPremiumStripeUser($user, $em, $token)
    {
		try {
			$customer = \Stripe\Customer::create(array(
			  "source" => $token,
			  "plan" => "cosmo",
			  "email" => $user->getEmail(),
			  "description" => $user->getFirstname().' '.$user->getName())
			);	
			$payment = new Payment();
			$payment->setUser($user);
			$payment->setCustomerId($customer->id);
			$payment->setPlan('cosmo');
			$user->addRole('ROLE_COSMO');
			$user->removeRole('ROLE_SHOOTER');
			$em->persist($user);
			$em->persist($payment);
			$em->flush();


            // générer un nouveau token
            $token = new \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken(
                $user,
                null,
                'main',
                $user->getRoles()
            );
            $this->container->get('security.context')->setToken($token);

// faire un refresh du user a l'aide du user manager
            $userManager = $this->container->get('fos_user.user_manager');
            $userManager->refreshUser($user);
		} catch (Exception $e) {
			
		}
    }

    /**
     * @Route("/change-plan/{plan}/{id}" , name="change-plan", options={"expose"=true})
     * @Template()
     */
    public function changePlanAction($plan, $id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$payment = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($id);
    	$newPlan = $plan;

    	$stripeApikey = $this->container->getParameter('stripe_api_key');

        \Stripe\Stripe::setApiKey($stripeApikey);

    	$customerId = $payment->getCustomerId();

		$cu = \Stripe\Customer::retrieve($customerId);

		$planId = $cu->subscriptions->data[0]->id;

		$subscription = $cu->subscriptions->retrieve($planId);
		$subscription->plan = $newPlan;
		$subscription->save();
        $payment->setPlan($newPlan);
        $em->persist($payment);
        $em->flush();

        return new Response('plan modifié');
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

    /**
     * @Route("/my-options/{barId}", name="display_options")
     * @Template()
     */
    public function displayOptionsAction($barId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $options = $em->getRepository('CacPaymentBundle:PaymentOptions')->findBy(array('user' => $user->getId(), 'active' => 1 ));
        return array('options' => $options, 'barId' => $barId);
    }

    /**
     * @Route("/my-finished-options", name="display_finish_options")
     * @Template()
     */
    public function displayFinishedOptionsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $options = $em->getRepository('CacPaymentBundle:PaymentOptions')->findBy(array('user' => $user->getId(), 'active' => 0 ));
        return array('options' => $options);
    }

    /**
     * @Route("/remove_carte/{barId}", name="remove_carte_abo", options={"expose"=true})
     */
    public function removeCarteAction($barId)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $option = $em->getRepository('CacPaymentBundle:PaymentOptions')->findOneBy(array('user' => $user->getId(), 'name' => 'carte' ));
        $carte = $em->getRepository('CacBarBundle:CarteBar')->findOneByBar($barId);
        $carte->setVisible(false);
        $option->setActive(0);
        $option->setDeletedAt(new \DateTime('now'));
        $em->persist($option);
        $em->persist($carte);
        $em->flush();
        $plan = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($user)->getPlan();
        if ($plan === "shootercarte") {
            $this->forward('CacPaymentBundle:Default:changePlan', array('plan'  => 'shooter','id' => $user));
        }
        elseif ($plan === "cosmocarte") {
            $this->forward('CacPaymentBundle:Default:changePlan', array('plan'  => 'cosmo','id' => $user));
        }

        return new Response('carte supprimée');
    }
}
