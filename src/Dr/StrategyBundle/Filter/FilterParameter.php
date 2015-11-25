<?php
/**
 * DdxSr - FilterParameter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


class FilterParameter{

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
            case 'integer':
            case 'float':
            case 'bool':
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


}
