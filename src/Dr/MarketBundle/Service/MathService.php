<?php
/**
 * MathService
 * @author Allan
 */
namespace Dr\MarketBundle\Service;

use Dr\ReaderBundle\Service\AbstractDdxDrService;
use Doctrine\ORM\EntityManagerInterface;

class MathService extends AbstractDdxDrService{

    /**
     * @param EntityManagerInterface $entityManager
     * @return \Dr\MarketBundle\Service\MathService
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->setEntityManager($entityManager);
        return $this;
    }
}
