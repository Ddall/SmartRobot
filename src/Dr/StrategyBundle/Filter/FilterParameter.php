<?php
/**
 * DdxSr - FilterParameter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


use Symfony\Component\Config\Definition\Exception\InvalidTypeException;

class FilterParameter{

    const TYPE_INTEGER  = 'integer';
    const TYPE_FLOAT    = 'float';
    const TYPE_BOOL     = 'bool';

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $comment;

    /**
     * @var mixed
     */
    private $value;

    /**
     * default value
     * @var mixed
     */
    private $default;

    /**
     * false by default
     * @var bool
     */
    private $required;

    /**
     * @return string
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param $type string
     * @return $this
     * @throws \Exception
     */
    public function setType($type){
        switch(strtolower($type)){
            case self::TYPE_INTEGER:
            case self::TYPE_FLOAT:
            case self::TYPE_BOOL;
            case 'boolean':
                $this->type = strtolower($type);
                break;

            default:
                throw new \Exception('FilterParameter:setType() bad or missing type. accepted: integer, float, bool');
                break;
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getComment(){
        return $this->comment;
    }

    /**
     * @param $comment
     * @return $this
     */
    public function setComment($comment){
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getValue(){
        if(!$this->value){
            return $this->getDefault();
        }

        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     * @throws \Exception
     */
    public function setValue($value){
        if(!$this->getType()){
            $this->setType( gettype($value) );
        }

        $this->setValue();

        return $this;
    }


    /**
     * @param $value mixed
     * @return $this
     */
    public function setDefault($value){
        $this->default = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault(){
        return $this->default();
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required){
        if(!is_bool($required)){
            throw new \Exception('wrong type');
        }

        $this->required = $required;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRequired(){
        if($this->required === null){
            return false;
        }

        return $this->required;
    }

    /**
     * @return bool
     */
    public function hasDefault(){
        if($this->default === null){
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    public function hasValue(){
        if($this->value === null){
            return false;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isValid(){
        if($this->isRequired()){
            if( $this->hasValue() || $this->hasDefault() ){
                return true;
            }

            return true;
        }

        return true;
    }


}
