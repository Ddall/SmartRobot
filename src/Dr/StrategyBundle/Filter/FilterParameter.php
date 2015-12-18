<?php
/**
 * DdxSr - FilterParameter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


use AppBundle\Exception\LockedException;
use AppBundle\Exception\WrongTypeException;

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
     * Array of choices as: array[VALUE] = 'LABEL'
     * @var array
     */
    private $choices;

    /**
     * @var bool
     */
    private $readOnly;


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
        $this->isReadOnly(true);

        switch(strtolower($type)){
            case self::TYPE_INTEGER:
            case self::TYPE_FLOAT:
            case self::TYPE_BOOL:
                $this->type = strtolower($type);
                break;

            case 'boolean':
                $this->type = self::TYPE_BOOL;
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
        $this->isReadOnly(true);

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

        if($this->hasChoices()){
            if(array_key_exists($value, $this->choices)){
                $this->value = $value;

            }else{
                throw new \Exception('FilterParameter setValue value outside of possible choices');

            }
        }else{
            $this->value = $value;

        }


        return $this;
    }

    /**
     * @param $value mixed
     * @return $this
     */
    public function setDefault($value){
        $this->isReadOnly(true);

        $this->default = $value;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefault(){
        return $this->default;
    }

    /**
     * @param bool $required
     * @return $this
     */
    public function setRequired($required){
        $this->isReadOnly(true);

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
    public function isValid() {
        if ($this->isRequired()) {
            if ($this->hasValue() || $this->hasDefault()) {
                return true;
            }

            return true;
        }

        return true;
    }


    /**
     * @param array $choices
     * @return $this
     */
    public function setChoices(array $choices){
        $this->isReadOnly(true);

        $this->choices = $choices;

        return $this;
    }

    /**
     * @return array|bool
     */
    public function getChoices(){
        if(is_array($this->choices)){
            return $this->choices;
        }

        return false;
    }


    /**
     * @return bool
     */
    public function hasChoices(){
        if($this->getChoices() !== false ){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $readOnly
     * @return $this
     * @throws WrongTypeException
     */
    protected function setReadOnly($readOnly){
        if(!is_bool($readOnly)){
            throw new WrongTypeException('FilterParameter setReadOnly expecting parameter of type bool');
        }

        $this->readOnly = $readOnly;

        return $this;
    }

    /**
     * @return $this
     */
    public function lock(){
        $this->setReadOnly(true);
        return $this;
    }

    /**
     * @param bool $strict
     * @return bool
     * @throws LockedException
     * @throws WrongTypeException
     */
    public function isReadOnly($strict = false){
        if(!is_bool($strict)){
            throw new WrongTypeException('FilterParameter isReadOnly expecting parameter of type bool');
        }

        if($this->readOnly){
            if($strict){
                throw new LockedException('FilterParameter: instance is locked. Only the value can be set at this time');
            }

            return true;
        }

        return false;
    }

}
