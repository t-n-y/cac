<?php

namespace Cac\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Cac\PaymentBundle\Entity\PaymentOptions;

/**
 * Admin default controller.
 *
 * @Route("/whostheboss")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/nombre-mise-en-avant", name="bn_highlight")
     * @Template()
     */
    public function nbHighlightAction()
    {
    	$em = $this->getDoctrine()->getManager();
    	$highlight = $em->getRepository('CacAdminBundle:NbHighlight')->findAll();


		if (count($highlight) === 0) {
			return $this->redirect($this->generateUrl('nbhighlight_new'));
		}
		else{
			return $this->redirect($this->generateUrl('nbhighlight_edit', array('id' => 1)));
		}

	}

    /**
     * @Route("/carte-to-validate", name="validate_carte")
     * @Template()
     */
    public function validateCarteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cartes = $em->getRepository('CacBarBundle:CarteBar')->findByVisible(false);

        return array('cartes' => $cartes);
    }

    /**
     * @Route("/validate-carte/{id}/{user}", name="validate_the_carte", options={"expose"=true})
     */
    public function validateTheCarteAction($id, $user)
    {
        $em = $this->getDoctrine()->getManager();
        $carte = $em->getRepository('CacBarBundle:CarteBar')->find($id);
        $carte->setVisible(true);
        $em->persist($carte);
        $em->flush();
        $plan = $em->getRepository('CacPaymentBundle:Payment')->findOneByUser($user)->getPlan();
        $user = $this->get('security.context')->getToken()->getUser();
        if ($plan === "shooter") {
            $option = new PaymentOptions();
            $option->setName('carte');
            $option->setUser($user);
            $option->setActive(1);
            $option->setCreatedAt(new \DateTime('now'));
            $em->persist($option);
            $em->flush();
            $this->forward('CacPaymentBundle:Default:changePlan', array('plan'  => 'shootercarte','id' => $user));
        }
        elseif ($plan === "cosmo") {
            $option = new PaymentOptions();
            $option->setName('carte');
            $option->setUser($user);
            $option->setActive(1);
            $option->setCreatedAt(new \DateTime('now'));
            $em->persist($option);
            $em->flush();
            $this->forward('CacPaymentBundle:Default:changePlan', array('plan'  => 'cosmocarte','id' => $user));
        }
        else{
            return new Response("Ce bar est deja abonné aux cartes. Carte validée");
        }
        return new Response("Carte validée");
    }

    /**
     * @Route("/list-bars", name="list_bars")
     * @Template()
     */
    public function listBarsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $bars = $em->getRepository('CacBarBundle:Bar')->findAll();
        return array('bars' => $bars);
    }

    /**
     * @Route("/define-price/{id}/{price}", name="define_price", options={"expose"=true})
     */
    public function definePriceAction($id, $price)
    {
        $em = $this->getDoctrine()->getManager();
        $bigboss = $em->getRepository('CacUserBundle:User')->find($id);
        $bigboss->setGlassPrice(intval($price));
        $em->persist($bigboss);
        $em->flush();
        return new Response("prix modifié");
    }
}
