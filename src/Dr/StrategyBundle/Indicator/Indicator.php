<?php


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
