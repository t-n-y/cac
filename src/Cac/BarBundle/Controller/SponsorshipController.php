<?php

namespace Cac\BarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Cac\BarBundle\Entity\Sponsorship;
use Symfony\Component\HttpFoundation\JsonResponse;
use Hip\MandrillBundle\Message;
use Hip\MandrillBundle\Dispatcher;

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
		$user = $this->get('security.context')->getToken()->getUser();

		if (!is_object($user) || ($user->getRoles()[0] !== "ROLE_USER")) {
			return new JsonResponse(array(
				'msg' => 'Vous devez être connecté en tant qu\'utilisateur pour inviter un ami'
			));
		}
		else{
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
		$em = $this->getDoctrine()->getManager();
		$user = $this->get('security.context')->getToken()->getUser();

		$newdate = \DateTime::createFromFormat('d-m-Y', $date);
		$used = $newdate->format('y-m-d');

// ld($newdate);
// ldd($used);
		

		$sponsorship = $em->getRepository('CacBarBundle:Sponsorship')->findOneByCode($code);
		$sponsorship->setUsedAt($newdate);
		$em->persist($sponsorship);
		$em->flush();

		$bar = $em->getRepository('CacBarBundle:Bar')->findOneById($sponsorship->getBar());

		$md = $this->get('hip_mandrill.dispatcher');

        $message = new Message();
        $templateName = 'invitation';
        $templateContent = array(
            array(
                'name' => $user->getName(),
                'firstname' => $user->getFirstname(),
                'date' => $used,
                'barname' => $bar->getName(),
                'adress' => $bar->getAdress().', '.$bar->getZipcode().', '.$bar->getTown()
            )
        );
        $message
            ->addTo($mail, 'ami')
            ->setSubject('Invitation de votre ami')
            ->setTrackOpens(true)
            ->setTrackClicks(true);

        $result = $md->send($message, $templateName, $templateContent);

		return new JsonResponse(array('msg' => 'invitation envoyée'));
	}
}
