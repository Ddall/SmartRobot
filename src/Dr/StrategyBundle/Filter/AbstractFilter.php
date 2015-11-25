<?php
/**
 * DdxSr - AbstractFilter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


use Dr\StrategyBundle\Entity\Indicator;

abstract class AbstractFilter implements FilterInterface{

    /**
     * @return Indicator
     */
    public function createIndicator(){
        $indicator = new Indicator();
        $indicator->setFilter( get_class() );
        $indicator->setParameters( $this->getDefaults() );

        return $indicator;
    }


}
