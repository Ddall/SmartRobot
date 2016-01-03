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
     * Return the display name of a filter, don't use this to find a filter, use getIdentifier instead
     * @return string
     */
    static function getName();

    /**
     * Returns the identifier of a filter
     * @return string
     */
    static function getIdentifier();

    /**
     * Returns an array of FilterParameter that represent parameters used by the filter
     * @return array
     */
    public function getDefaults();

    /**
     * Return the type of return to expect from a filter. can be any value from FILTER_TYPE_*
     * @return integer
     */
    public function getType();



}
