<?php

namespace Cac\BarBundle\Services;

use Cac\BarBundle\Entity\Promotion;
use Cac\BarBundle\Entity\PromotionOption;
use Cac\BarBundle\Entity\PromotionOptionCategory;

class PromotionManager
{
    private $days;
    private $restriction;
    private $em;

    public function __construct(EntityManager $entityManager) {
        $this->em = $entityManager;
    }

    public function generateEmptyPromotions()
    {


        return array();
    }
}