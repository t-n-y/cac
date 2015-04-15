<?php

namespace Cac\BarBundle\Services;

use Doctrine\ORM\EntityManager;
use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\PromotionOption;
use Cac\BarBundle\Entity\PromotionOptionCategory;

class PromotionManager
{
    private $days;
    private $em;
    private $restriction;
    private $value;
    private $quantity;
    private $emptyPromotions;

    public function __construct(EntityManager $entityManager) {
        $this->days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
        $this->em = $entityManager;
        $this->restriction = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('restriction');
        $this->value = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('value');
        $this->quantity = $this->em->getRepository('CacBarBundle:PromotionOptionCategory')->findOneByShortcode('quantity');
        $this->emptyPromotions = new \Doctrine\Common\Collections\ArrayCollection();

        $this->generateEmptyPromotions();
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
        $this->promotions[] = $promotion;

        return $this;
    }
}