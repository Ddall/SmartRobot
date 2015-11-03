<?php

namespace Dr\MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Position
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Dr\MarketBundle\Entity\PositionRepository")
 */
class Position
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="volume", type="float")
     */
    private $volume;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime")
     */
    private $timestamp;
    
    // -- PERSO -- PERSO -- PERSO -- PERSO -- PERSO -- PERSO -- PERSO -- PERSO
    public function __construct() {
        $this->timestamp = new \DateTime();
        return $this;
    }

    /**
     * @param string $unixtimestamp
     * @return \Dr\MarketBundle\Entity\Position
     */
    public function setUnixTimestamp($unixtimestamp){
        $this->timestamp->setTimestamp($unixtimestamp);
        return $this;
    }
    
    // -- AUTO -- AUTO -- AUTO -- AUTO -- AUTO -- AUTO -- AUTO -- AUTO -- AUTO
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
     * Set price
     *
     * @param float $price
     * @return Position
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set volume
     *
     * @param float $volume
     * @return Position
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;

        return $this;
    }

    /**
     * Get volume
     *
     * @return float 
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return Position
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
