<?php
/**
 * DdxSr - MarketTest.php
 * Created by Allan.
 */

namespace Dr\MarketBundle\Tests\Entity;


use Dr\MarketBundle\Entity\Market;

class MarketTest extends \PHPUnit_Framework_TestCase {

    public function testMarket(){

        $market = $this->createEntity();


        $

    }



    /**
     * @return Market
     */
    private function createEntity(){
        $market = new Market();
        $market->setName('Default Market');

        return $market;
    }

}
