<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 17/11/2015
 * Time: 11:37
 */

namespace Dr\StrategyBundle\Indicator;


class Indicator{


    public function compute(){
        return true;
    }

    public function getName(){
        return 'default_ema';
    }

    public function getParameterList(){
        return array(
            'duration' => 'integer',

        );
    }

}
