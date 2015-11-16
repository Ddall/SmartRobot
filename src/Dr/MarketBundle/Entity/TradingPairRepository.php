<?php

namespace Dr\MarketBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * TradeRepository
 */
class TradingPairRepository extends EntityRepository{

    /**
     * Use this to find out when were the orderbooks last refreshed
     * @return \DateTime|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getLastUpdateTime(){
        $qb = $this->createQueryBuilder('t');
        $pair = $qb->select('t')
            ->where('t.lastRefresh IS NOT NULL')
            ->orderBy('t.lastRefresh', 'DESC')

            ->setMaxResults(1)->getQuery()->getOneOrNullResult()
            ;

        if($pair instanceof TradingPair){
            return $pair->getLastRefresh();
        }

        return null;

    }
}
