<?php
/**
 * DdxSr - FilterParameterTest.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Tests\Entity;


use AppBundle\Exception\BaseException;
use Dr\StrategyBundle\Filter\FilterParameter;

class FilterParameterTest extends \PHPUnit_Framework_TestCase {
    public function testDefault(){
        $fparam = $this->getEntity();

        $this->assertInstanceOf(get_class(FilterParameter::class), $fparam);
    }


    public function testLocked(){
        $fparam = $this->getEntity();

        $fparam->lock();
        $fparam->setComment('Toto');
    }

    /**
     * @return FilterParameter
     * @throws \Exception
     */
    private function getEntity(){
        $param = new FilterParameter();
        $param
            ->setType(FilterParameter::TYPE_INTEGER)
            ->setDefault(1)
            ->setRequired(true)
            ->setComment('Dummy comment')
            ;

        return $param;
    }

}
