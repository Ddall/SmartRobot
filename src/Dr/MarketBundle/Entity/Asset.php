<?php

namespace Dr\MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Asset
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Asset
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
     * @ORM\Column(name="abbr", type="string", length=10)
     */
    private $abbr;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=3, nullable=true)
     */
    private $symbol;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer", nullable = true)
     */
    private $type;

    const TYPE_UNDEFINED = 0;
    const TYPE_FIAT = 1;
    const TYPE_VIRTUAL = 2;

    /**
     * @param string $name
     * @param string $abbr
     * @param string $symbol
     * @return \Dr\MarketBundle\Entity\Asset
     */
    public function __construct($name = null, $abbr = null, $symbol = null, $type = self::TYPE_UNDEFINED) {
        $this->setName($name);
        $this->setAbbr($abbr);
        $this->setSymbol($symbol);
        $this->setType($type);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString() {

        return $this->getName() . ' '. ' (' . $this->getTypeString() .')' ;
    }

    public function getTypeString(){
        switch($this->type){
            case self::TYPE_VIRTUAL:
                return 'Virtual';
                break;

            case self::TYPE_FIAT:
                return 'Fiat';
                break;

            case self::TYPE_UNDEFINED:
            default:
                return 'Undefined';
        }
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
     * @return Asset
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
     * Set abbr
     *
     * @param string $abbr
     * @return Asset
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;

        return $this;
    }

    /**
     * Get abbr
     *
     * @return string 
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * Set symbol
     *
     * @param string $symbol
     * @return Asset
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return int
     */
    public function getType(){
        return $this->type;
    }


    /**
     * @param int $type
     * @return $this
     * @throws \Exception
     */
    public function setType($type){

        if($type === null ){
            $this->type = self::TYPE_UNDEFINED;

        }elseif($type == self::TYPE_UNDEFINED || $type == self::TYPE_FIAT || $type == self::TYPE_VIRTUAL){
            $this->type = $type;

        }else{
            throw new \Exception('Asset::setType(): bad parameter');
        }

        return $this;
    }
}
