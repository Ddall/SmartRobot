<?php

namespace Dr\StrategyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Dr\StrategyBundle\Filter\FilterParameter;

/**
 * Indicator
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Indicator
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
     * @var string
     *
     * @ORM\Column(name="filter", type="string", length=255, nullable=false)
     */
    private $filter;

    /**
     * @var array
     *
     * @ORM\Column(name="parameters", type="array", nullable=false)
     */
    private $parameters;

    /**
     * @var string
     *
     * @ORM\Column(name="comments", type="text")
     */
    private $comments;


    /**
     * @var Strategy
     *
     * @ORM\ManyToOne(targetEntity="Dr\StrategyBundle\Entity\Strategy", inversedBy="indicators")
     * @ORM\JoinColumn(name="strategy_id", referencedColumnName="id")
     */
    private $strategy;

    // AUTO

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
     * @return Indicator
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
     * Set filter
     *
     * @param string $filter
     *
     * @return Indicator
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     *
     * @return Indicator
     */
    public function setParameters($parameters)
    {
        if(!is_array($parameters)){
            throw new \Exception('Indicator:setParameters: missing or wrong parameter, expected array, ' . gettype($parameters) . ' given' );
        }

        foreach ($parameters as $parameter) {
            if(false === $parameters instanceof FilterParameter){
                throw new \Exception('Indicator:setParameters: wrong parameter, expected FilterParameter ' . gettype($parameter) . ' given');
            }
        }

        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set comments
     *
     * @param string $comments
     *
     * @return Indicator
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }


    /**
     * @return Strategy
     */
    public function getStrategy(){
        return $this->strategy;
    }

    /**
     * @param Strategy $strategy
     * @return $this
     */
    public function setStrategy(Strategy $strategy){
        $this->strategy = $strategy;

        return $this;
    }
}

