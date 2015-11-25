<?php
/**
 * DdxSr - FilterInterface.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;

use Dr\StrategyBundle\Entity\Indicator;

interface FilterInterface{

    /**
     * @return Indicator
     */
    public function createIndicator();

    /**
     * @return string
     */
    public function getName();

    /**
     * Returns an array of FilterParameter that represent parameters used by the filter
     * @return array
     */
    public function getDefaults();

}
