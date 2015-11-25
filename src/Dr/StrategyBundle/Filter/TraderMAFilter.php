<?php
/**
 * DdxSr - TraderMAFilter.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Filter;


/**
 * Class TraderMAFilter
 * @see http://php.net/manual/en/function.trader-ma.php
 * @package Dr\StrategyBundle\Filter
 */
class TraderMAFilter extends AbstractFilter{

    /**
     * @return string
     */
    public function getName() {
        return 'TraderMA';
    }

    /**
     * Returns an array of FilterParameter that represent parameters used by the filter
     *
     * @return array
     */
    public function getDefaults() {
        $timePeriod= new FilterParameter();
        $timePeriod
            ->setType('integer')
            ->setComment('Number of period. Valid range from 2 to 100000.')
        ;

        $mAType = new FilterParameter();
        $mAType
            ->setType('integer')
            ->setComment('Type of Moving Average. TRADER_MA_TYPE_* series of constants should be used. see: http://php.net/manual/en/trader.constants.php')
            ->setDefault(TRADER_MA_TYPE_SMA);
        ;

        return array(
            'timePeriod' => $timePeriod,
            'mAType' => $mAType,
        );
    }}
