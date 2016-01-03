<?php
/**
 * DdxSr - AbstractFilter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


use Dr\StrategyBundle\Entity\Indicator;

abstract class AbstractFilter implements FilterInterface{

    const FILTER_TYPE_BOOL = 0;
    const FILTER_TYPE_FLOAT = 1;
    CONST FILTER_TYPE_INTEGER = 2;

    /**
     * @return Indicator
     */
    public function createIndicator(){
        $indicator = new Indicator();
        $indicator->setFilter( get_class() );
        $indicator->setParameters( $this->getDefaults() );

        return $indicator;
    }

    /**
     * Use this method to check if an array of parameters is valid
     * @param array $parameters
     * @return bool
     */
    public function checkParameters(array $inputParameters){

        $defaults = $this->getDefaults();

        foreach($defaults as $key => $parameter ){
            if(false === $parameter instanceof FilterParameter){
                return false;
            }

            if($parameter->isRequired()){
                if(array_key_exists($key, $inputParameters) && $inputParameters[$key]->isValid() ){
                    continue;
                }else{
                    return false;
                }
            }
        }

        return true;
    }

}
