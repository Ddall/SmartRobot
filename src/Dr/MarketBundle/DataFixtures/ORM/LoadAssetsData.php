<?php

namespace Dr\MarketBundle\DataFixtures\ORM;

/**
 * @author Allan
 */

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Dr\MarketBundle\Entity\Asset;

class LoadAssetsData implements FixtureInterface{
    
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager){
        $data = array(
            'Euro' => array('EUR', '€'),
            'US Dollar' => array('USD', '$'),
            'Bitcoin' => array('BTC', '฿'),
            'Litecoin' => array('LTC', 'Ł'),
            'Dogecoin' => array('DOGE', 'Ð'),
            'Pound' => array('Pound', '£'),
            'Yen' => array('JPY', '¥'),
        );

        $entities = array();
        foreach($data as $name => $line){
            $entities[] = new Asset($name, $line[0], $line[1] );
        }

        foreach($entities as $entity){
            $manager->persist($entity);
        }

        $manager->flush();
    }
}
