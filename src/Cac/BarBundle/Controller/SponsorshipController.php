<?php

namespace Cac\BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Sponsorship;

class SponsorshipController extends Controller
{
	/**
     * @Route("/generate-codes/{id}", name="generate_codes")
     * @Template()
     */
	public function generateCodesAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$bar = $em->getReference('Cac\BarBundle\Entity\Bar', $id);
		$codes = array();
		for ($i=0; $i < 20; $i++) { 
			$codes[] = substr(md5(microtime()),rand(0,26),6);
			$sponsorship = new Sponsorship();
			$sponsorship->setBar($bar)->setCode($codes[$i]);
			$em->persist($sponsorship);
		}
		$em->flush();
		return array('codes' => $codes);
	}
}
