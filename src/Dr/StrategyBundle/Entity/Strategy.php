<?php

namespace Dr\StrategyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Strategy
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Strategy
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
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;


    /**
     * @var Indicator
     *
     * @ORM\OneToMany(targetEntity="Dr\StrategyBundle\Entity\Indicator", mappedBy="strategy", orphanRemoval=true)
     */
    private $indicators;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicators = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     *
     * @return Strategy
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
     * Set comment
     *
     * @param string $comment
     *
     * @return Strategy
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Strategy
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isActive(){
        if($this->active === true){
            return true;
        }
        return false;
    }


    /**
     * Add indicator
     *
     * @param \Dr\StrategyBundle\Entity\Indicator $indicator
     *
     * @return Strategy
     */
    public function addIndicator(\Dr\StrategyBundle\Entity\Indicator $indicator)
    {
        $this->indicators[] = $indicator;

        return $this;
    }

    /**
     * Remove indicator
     *
     * @param \Dr\StrategyBundle\Entity\Indicator $indicator
     */
    public function removeIndicator(\Dr\StrategyBundle\Entity\Indicator $indicator)
    {
        $this->indicators->removeElement($indicator);
    }

    /**
     * Get indicators
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndicators()
    {
        return $this->indicators;
    }
}
