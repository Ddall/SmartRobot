<?php

namespace Dr\MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TradingPair
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dr\MarketBundle\Entity\TradingPairRepository")
 */
class TradingPair
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
     * @ORM\Column(name="name", type="string", length=50)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="remoteName", type="string", length=50)
     */
    private $remoteName;
    
    /**
     * @var Market 
     * @ORM\ManyToOne(targetEntity="Dr\MarketBundle\Entity\Market", inversedBy="tradingPairs")
     * @ORM\JoinColumn(name="market_id", referencedColumnName="id")
     */
    private $market;
    
    /**
     * @var Asset
     * @ORM\ManyToOne(targetEntity="Dr\MarketBundle\Entity\Asset")
     * @ORM\JoinColumn(name="assetFrom_id", referencedColumnName="id")
     */
    private $assetFrom;
    
    /**
     * @var Asset
     * @ORM\ManyToOne(targetEntity="Dr\MarketBundle\Entity\Asset")
     * @ORM\JoinColumn(name="assetTo_id", referencedColumnName="id")
     */
    private $assetTo;
    
    /**
     * @var boolean
     * @ORM\Column(name="isActive", type="boolean", nullable=false)
     */
    private $isActive;

    // MANUAL METHODS

    /**
     * __ctor
     * @param \Dr\MarketBundle\Entity\Market $market
     * @param string $name
     * @param string $remoteName
     * @return \Dr\MarketBundle\Entity\TradingPair
     */
    public function __construct(Market $market = null,  $name = null, $remoteName = null) {
        $this->setMarket($market);
        $this->setName($name);
        $this->setRemoteName($remoteName);
        $this->isActive = false;
        return $this;
    }
    
    
    /**
     * @return string
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * @return boolean
     */
    public function isActive(){
        return $this->isActive;
    }
    
    /**
     * @return \Dr\MarketBundle\Entity\TradingPair
     */
    public function enable(){
        $this->isActive = true;
        return $this;
    }
    
    /**
     * @return \Dr\MarketBundle\Entity\TradingPair
     */
    public function disable(){
        $this->isActive = false;
        return $this;
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
     * @return TradingPair
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
     * Set remoteName
     *
     * @param string $remoteName
     * @return TradingPair
     */
    public function setRemoteName($remoteName)
    {
        $this->remoteName = $remoteName;

        return $this;
    }

    /**
     * Get remoteName
     *
     * @return string 
     */
    public function getRemoteName()
    {
        return $this->remoteName;
    }

    /**
     * Set market
     *
     * @param \Dr\MarketBundle\Entity\Market $market
     * @return TradingPair
     */
    public function setMarket(\Dr\MarketBundle\Entity\Market $market = null)
    {
        $this->market = $market;

        return $this;
    }

    /**
     * Get market
     *
     * @return \Dr\MarketBundle\Entity\Market 
     */
    public function getMarket()
    {
        return $this->market;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return TradingPair
     */
    public function setActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Set assetFrom
     *
     * @param \Dr\MarketBundle\Entity\Asset $assetFrom
     * @return TradingPair
     */
    public function setAssetFrom(\Dr\MarketBundle\Entity\Asset $assetFrom = null)
    {
        $this->assetFrom = $assetFrom;

        return $this;
    }

    /**
     * Get assetFrom
     *
     * @return \Dr\MarketBundle\Entity\Asset 
     */
    public function getAssetFrom()
    {
        return $this->assetFrom;
    }

    /**
     * Set assetTo
     *
     * @param \Dr\MarketBundle\Entity\Asset $assetTo
     * @return TradingPair
     */
    public function setAssetTo(\Dr\MarketBundle\Entity\Asset $assetTo = null)
    {
        $this->assetTo = $assetTo;

        return $this;
    }

    /**
     * Get assetTo
     *
     * @return \Dr\MarketBundle\Entity\Asset 
     */
    public function getAssetTo()
    {
        return $this->assetTo;
    }

}
