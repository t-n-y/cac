<?php

namespace Cac\BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Sponsorship;
use Symfony\Component\HttpFoundation\JsonResponse;

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

	/**
     * @Route("/validate-code/{code}", name="validate_code", options={"expose"=true})
     */
	public function validateCodeAction($code)
	{
		$em = $this->getDoctrine()->getManager();
		$sponsorship = $em->getRepository('CacBarBundle:Sponsorship')->findOneByCode($code);
		if ($sponsorship == null) {
			return new JsonResponse(array('msg' => 'Ce code n\'existe pas'));
		}
		if ($sponsorship->getUsedAt() != null) {
			return new JsonResponse(array('msg' => 'code déjà utilisé'));
		}
		$bar = $em->getRepository('CacBarBundle:Bar')->findOneById($sponsorship->getBar()->getId());
		$tmpDaySponsorships = $bar->getDaySponsorships();

		$daySponsorships = [];
		foreach($tmpDaySponsorships as $daySponsorship) {
			$ds = array(
				'day' => $daySponsorship->getDay(),
				'number' => $daySponsorship->getNumber()
			);
			$daySponsorships[] = $ds;
		}
		setlocale(LC_TIME, "fr_FR");
  		$date = new \Datetime();
  		$weekDays = [];

  		$i = 0;
  		do {
  			$day = $date->format('d-m-Y');
  			if($this->checkDaySponsorship($date, $daySponsorships, $bar->getId()) === 0) {
  				$weekDays[] = $day;
  			}
  			$date->modify('+1 day');
  			$i++;
  		} while($i < 7);

		return new JsonResponse(array(
			'msg' => 'code ok',
			'bar' => $bar->getId(),
			'barName' => $bar->getName(),
			'ssSchedule' => $daySponsorships,
			'weekdays' => $weekDays
		));
	}

	public function checkDaySponsorship($date, $daySponsorships, $id)
	{
		$em = $this->getDoctrine()->getManager();
		$dayName = strftime("%A", $date->getTimestamp());
		foreach($daySponsorships as $ds) {
			if($ds['day'] == $dayName) {
				$number = $ds['number'];
				$qt = $em->getRepository('CacBarBundle:Sponsorship')->checkAvailableDay($date->format('y-m-d'), $id);
				return $number - $qt;
			}
		}

		return 0;
	}

	/**
     * @Route("/invite-friend/{mail}/{date}/{code}", name="invite_friend", options={"expose"=true})
     */
	public function inviteFriendAction($mail, $date, $code)
	{
		$newdate = \DateTime::createFromFormat('d-m-Y', $date);
		$used = $newdate->format('y-m-d');

		return new JsonResponse(array('msg' => 'invitation envoyée'));
		// $em = $this->getDoctrine()->getManager();
		// $bar = $em->getReference('Cac\BarBundle\Entity\Bar', $id);
		// $codes = array();
		// for ($i=0; $i < 20; $i++) { 
		// 	$codes[] = substr(md5(microtime()),rand(0,26),6);
		// 	$sponsorship = new Sponsorship();
		// 	$sponsorship->setBar($bar)->setCode($codes[$i]);
		// 	$em->persist($sponsorship);
		// }
		// $em->flush();
		// return array('codes' => $codes);
	}
}
