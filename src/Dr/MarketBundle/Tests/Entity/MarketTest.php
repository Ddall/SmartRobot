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

        $this->assertInstanceOf('Dr\MarketBundle\Entity\Market', $market, 'Market constructor failed to create instance of Market');

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
