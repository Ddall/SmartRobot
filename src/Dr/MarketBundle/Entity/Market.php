<?php

namespace Dr\MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dr\MarketBundle\Entity\Trade;

/**
 * Market
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Market
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Trade
     * 
     * @ORM\OneToMany(targetEntity="Dr\MarketBundle\Entity\Trade", mappedBy="market", cascade={"persist"}, orphanRemoval=true)
     */
    private $trades;
    
    /**
     *
     * @var TradingPair
     * @ORM\OneToMany(targetEntity="Dr\MarketBundle\Entity\TradingPair", mappedBy="market", cascade={"persist"}, orphanRemoval=true)
     */
    private $tradingPairs;
    
    // MANUAL METHODS
    
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getActiveTradingPairs(){
        $pairs = new \Doctrine\Common\Collections\ArrayCollection();
        
        foreach($this->getTradingPairs() as $pair){
            if($pair->isActive()){
                $pairs[$pair->getName()] = $pair;
            }
        }
        
        return $pairs;
    }


    /**
     * @return bool
     */
    public function hasActiveTradingPairs(){
        foreach($this->getTradingPairs() as $pair){
            if($pair->isActive()){
                return true;
            }
        }

        return false;
    }



    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trades = new \Doctrine\Common\Collections\ArrayCollection();
        $this->tradingPairs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // AUTO METHODS
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Market
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add trades
     *
     * @param \Dr\MarketBundle\Entity\Trade $trades
     * @return Market
     */
    public function addTrade(\Dr\MarketBundle\Entity\Trade $trades)
    {
        $this->trades[] = $trades;

        return $this;
    }

    /**
     * Remove trades
     *
     * @param \Dr\MarketBundle\Entity\Trade $trades
     */
    public function removeTrade(\Dr\MarketBundle\Entity\Trade $trades)
    {
        $this->trades->removeElement($trades);
    }

    /**
     * Get trades
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrades()
    {
        return $this->trades;
    }

    /**
     * Add tradingPairs
     *
     * @param \Dr\MarketBundle\Entity\TradingPair $tradingPairs
     * @return Market
     */
    public function addTradingPair(\Dr\MarketBundle\Entity\TradingPair $tradingPairs)
    {
        $this->tradingPairs[] = $tradingPairs;

        return $this;
    }

    /**
     * Remove tradingPairs
     *
     * @param \Dr\MarketBundle\Entity\TradingPair $tradingPairs
     */
    public function removeTradingPair(\Dr\MarketBundle\Entity\TradingPair $tradingPairs)
    {
        $this->tradingPairs->removeElement($tradingPairs);
    }

    /**
     * Get tradingPairs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTradingPairs()
    {
        return $this->tradingPairs;
    }
}
