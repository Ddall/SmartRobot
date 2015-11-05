<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 05/11/2015
 * Time: 23:26
 */

namespace Dr\ReaderBundle\Service;


use Dr\MarketBundle\Entity\TradingPair;

interface MarketServiceInterface{

    /**
     * @return string
     */
    public function getName();

    /**
     * @param boolean $dryrun
     * @throws \Exception
     */
    public function updateAllTradeHistory($dryrun = false);

    /**
     * Updates the history for a single tradingpair
     * @param TradingPair $pair
     * @param boolean $dryrun
     * @throws Exception
     * @return integer number of new Trades
     */
    public function updateTradeHistory(TradingPair $pair, $dryrun = false);


    /**
     * Use this to update the trading pairs available on Market
     * @param boolean $dryrun
     */
    public function updateTradingPairs($dryrun = false);


    /**
     * Use this to update a single trading pair
     * @param TradingPair $pair
     * @param boolean $dryrun
     * @return array
     */
    public function updateOrderBook(TradingPair $pair, $dryrun = false);


    /**
     * Use this to update the orderbook for all tradingpairs
     * costs 1 point per active pair
     * @param boolean $dryrun
     * @return array
     */
    public function updateAllOrderBook($dryrun = false);


}
