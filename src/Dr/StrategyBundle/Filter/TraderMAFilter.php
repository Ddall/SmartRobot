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
        return 'Trader MA';
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
            ->setRequired(true)
        ;

        $mAType = new FilterParameter();
        $mAType
            ->setType('integer')
            ->setComment('Type of Moving Average. TRADER_MA_TYPE_* series of constants should be used. see: http://php.net/manual/en/trader.constants.php')
            ->setDefault(TRADER_MA_TYPE_SMA)
            ->setChoices(array(
                TRADER_MA_TYPE_SMA => 'Trader SMA',
                TRADER_MA_TYPE_EMA => 'Trader EMA',
                TRADER_MA_TYPE_WMA => 'Trader WMA',
                TRADER_MA_TYPE_DEMA => 'Trader DEMA',
                TRADER_MA_TYPE_TEMA => 'Trader TEMA',
                TRADER_MA_TYPE_TRIMA => 'Trader TRIMA',
                TRADER_MA_TYPE_KAMA => 'Trader KAMA',
                TRADER_MA_TYPE_MAMA => 'Trader MAMA',
                TRADER_MA_TYPE_T3 => 'Trader T3',
            ))
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
