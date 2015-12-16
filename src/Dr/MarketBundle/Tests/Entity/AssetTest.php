<?php
/**
 * DdxSr - AssetTest.php
 * Created by Allan.
 */

namespace Dr\MarketBundle\Tests\Entity;

use Dr\MarketBundle\Entity\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase {

    public function testContructor(){

        $asset = new Asset('Euro', 'EUR', '€', Asset::TYPE_FIAT);

        $this->assertTrue( $asset instanceof Asset );
        $this->assertTrue( $asset->getName() === 'Euro' );

    }
}
