<?php

namespace Cac\BarBundle\Services;

use Doctrine\ORM\EntityManager;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\PromotionOption;
use Cac\BarBundle\Entity\PromotionOptionCategory;
use Cac\BarBundle\Entity\DaySponsorship;

class PromotionManager
{
    private $days;
    private $em;
    private $restriction;
    private $value;
    private $quantity;
    private $beginning;
    private $ending;
    private $emptyPromotions;
    private $emptyHappyHours;
    private $emptyDaySponsorships;

    public function __construct(EntityManager $entityManager) {
        $this->days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $this->em = $entityManager;
        $this->restriction = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('restriction');
        $this->value = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('value');
        $this->quantity = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('quantity');
        $this->beginning = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('beginning');
        $this->ending = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('ending');
        $this->emptyPromotions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emptyHappyHours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->emptyDaySponsorships = new \Doctrine\Common\Collections\ArrayCollection();

        $this->generateEmptyPromotions();
        $this->generateEmptyHappyHours();
        $this->generateEmptyDaySponsorships();
    }

    public function generateEmptyPromotions()
    {
        foreach($this->days as $day) {
            $promotion = new Promotion();
            $promotion->setDay($day);
            $promotion->setCategory('promotion');

            $restrictionOption = new PromotionOption();
            $restrictionOption->setCategory($this->restriction);
            $restrictionOption->setValue('');
            $restrictionOption->setName('');

            $valueOption = new PromotionOption();
            $valueOption->setCategory($this->value);
            $valueOption->setValue('');
            $valueOption->setName('');

            $quantityOption = new PromotionOption();
            $quantityOption->setCategory($this->quantity);
            $quantityOption->setValue('');
            $quantityOption->setName('');

            $promotion->addOption($restrictionOption);
            $promotion->addOption($valueOption);
            $promotion->addOption($quantityOption);

            $this->addEmptyPromotion($promotion);
        }

        return $this;
    }

    public function generateEmptyHappyHours()
    {
        foreach($this->days as $day) {
            $promotion = new Promotion();
            $promotion->setDay($day);
            $promotion->setCategory('happy-hour');

            $restrictionOption = new PromotionOption();
            $restrictionOption->setCategory($this->restriction);
            $restrictionOption->setValue('');
            $restrictionOption->setName('');

            $valueOption = new PromotionOption();
            $valueOption->setCategory($this->value);
            $valueOption->setValue('');
            $valueOption->setName('');

            $beginningOption = new PromotionOption();
            $beginningOption->setCategory($this->beginning);
            $beginningOption->setValue('');
            $beginningOption->setName('');

            $endingOption = new PromotionOption();
            $endingOption->setCategory($this->ending);
            $endingOption->setValue('');
            $endingOption->setName('');

            $promotion->addOption($restrictionOption);
            $promotion->addOption($valueOption);
            $promotion->addOption($beginningOption);
            $promotion->addOption($endingOption);

            $this->addEmptyHappyHours($promotion);
        }

        return $this;
    }

    public function generateEmptyDaySponsorships()
    {
        foreach($this->days as $day) {
            $daySponsorship = new DaySponsorship();
            $daySponsorship->setDay($day);
            $daySponsorship->setNumber('5');

            $this->addEmptyDaySponsorship($daySponsorship);
        }

        return $this;
    }

    public function populatePromotion(\Cac\BarBundle\Entity\Promotion $promotion)
    {
        return $this;
    }

    public function getEmptyPromotions()
    {
        return $this->emptyPromotions;
    }

    public function addEmptyPromotion(\Cac\BarBundle\Entity\Promotion $promotion)
    {
        $this->emptyPromotions[] = $promotion;

        return $this;
    }

    public function getEmptyHappyHours()
    {
        return $this->emptyHappyHours;
    }

    public function addEmptyHappyHours(\Cac\BarBundle\Entity\Promotion $promotion)
    {
        $this->emptyHappyHours[] = $promotion;

        return $this;
    }

    public function getEmptyDaySponsorships()
    {
        return $this->emptyDaySponsorships;
    }

    public function addEmptyDaySponsorship(\Cac\BarBundle\Entity\DaySponsorship $daySS)
    {
        $this->emptyDaySponsorships[] = $daySS;

        return $this;
    }

    public function toDummyJSON($promotions)
    {
        $oldDummyJSON = file_get_contents(__DIR__.'/../../../../web/json/promotion.template.json');
        $dummyArray = json_decode($oldDummyJSON, true);

        foreach($promotions as $promotion) {
            if($promotion->getCategory() == 'promotion') {
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['value'] = $promotion->getOption('value')->getValue();
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['quantity'] = $promotion->getOption('quantity')->getValue();
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['condition'] = $promotion->getOption('restriction')->getValue();
            }
            if($promotion->getCategory() == 'happy-hour') {
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['value'] = $promotion->getOption('value')->getValue();
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['condition'] = $promotion->getOption('restriction')->getValue();
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['beginning'] = $promotion->getOption('beginning')->getValue();
                $dummyArray[$promotion->getDay()][$promotion->getCategory()]['ending'] = $promotion->getOption('ending')->getValue();
            }
        }

        $newDummyJSON = json_encode($dummyArray);

        return $newDummyJSON;
    }

    public function daySponsorShipsDummyJSON($daySponsorships)
    {
        $oldDummyJSON = file_get_contents(__DIR__.'/../../../../web/json/sponsorship.template.json');
        $dummyArray = json_decode($oldDummyJSON, true);

        foreach($daySponsorships as $daySponsorship) {
            $dummyArray[$daySponsorship->getDay()]['number'] = $daySponsorship->getNumber();
        }

        $newDummyJSON = json_encode($dummyArray);

        return $newDummyJSON;
    }
}
