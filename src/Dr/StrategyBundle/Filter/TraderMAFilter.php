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
     * @inheritdoc
     * @return string
     */
    public function getName() {
        return 'TraderMA';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function getDefaults() {
        $timePeriod = new FilterParameter();
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
    }

    /**
     * @inheritdoc
     * @return integer
     */
    public function getType() {
        return self::FILTER_TYPE_FLOAT;
    }

}
