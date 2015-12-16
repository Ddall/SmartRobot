<?php
/**
 * DdxSr - AssetTest.php
 * Created by Allan.
 */

namespace Dr\MarketBundle\Tests\Entity;

use Dr\MarketBundle\Entity\Asset;

class AssetTest extends \PHPUnit_Framework_TestCase {

    public function testConstructor(){

        $asset = new Asset('Euro', 'EUR', '€', Asset::TYPE_FIAT);

        $this->assertInstanceOf('Dr\MarketBundle\Entity\Asset', $asset, 'Asset contructor failed to create instance of Asset');

        $this->assertEquals('Euro', $asset->getName(), 'Asset constructor did not set Name properly');

        $this->assertEquals(Asset::TYPE_FIAT, $asset->getType(), 'Asset constructor did not set type properly');

        $this->assertEquals('€', $asset->getDisplaySymbol(), 'Asset contructor did not set symbol properly');

        unset($asset);
        $asset = new Asset();
        $this->assertEquals(Asset::TYPE_UNDEFINED, $asset->getType(), 'Asset constructor failed to set default type');


    }


    public function testTypeException(){
        $asset = new Asset();

        $asset->setType('toto');

    }

    public function testType(){

        $asset = new Asset();
        $asset->setType(Asset::TYPE_FIAT);
        $this->assertEquals(Asset::TYPE_FIAT, $asset->getType());

        $this->assertStringEndsWith(')', $asset->__toString(), 'Asset __toSting may have a problem');

        $this->assertContains('Fiat', $asset->getTypeString(), 'Asset typeString may have a problem');

        $asset->setType(Asset::TYPE_VIRTUAL);
        $this->assertContains('Virtual', $asset->getTypeString(), 'Asset typeString may have a problem');

        $asset->setType(Asset::TYPE_UNDEFINED);
        $this->assertContains('Undefined', $asset->getTypeString(), 'Asset typeString may have a problem');

    }
}
