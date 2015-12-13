<?php
/**
 * Created by PhpStorm.
 * User: Allan
 * Date: 03/11/2015
 * Time: 15:02
 */

namespace WebBundle\Controller;


use Dr\ReaderBundle\Service\BaseHelper;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller{

    /**
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request){
        // Find last update
        $lastUpdate = $this->getHelper()->getTradingPairRepository()->getLastUpdateTime();

        $chart = new Highchart();
        $chart->chart->renderTo('homeChart');

        $memoryUsage = $this->humanFilesize(memory_get_usage());

        return $this->render('WebBundle:Default:home.html.twig',array(
                'lastUpdate' => $lastUpdate,
                'memoryUsage' => $memoryUsage,
                'chart' => $chart,

            )
        );

    }


    /**
     * @return BaseHelper
     */
    private function getHelper(){
        return $this->get('dr.helper');
    }

    /**
     * @param     $bytes
     * @param int $decimals
     * @return string
     */
    private function humanFilesize($bytes, $decimals = 2) {
        $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . $size[ $factor ];
    }


}
