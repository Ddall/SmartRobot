<?php
/**
 * DdxSr - FilterService.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Service;


use Dr\ReaderBundle\Service\AbstractDdxDrService;

class FilterService extends AbstractDdxDrService{

    /**
     * @var array
     */
    private $filters;

    /**
     * FilterService constructor.
     *
     * @param array $filters
     */
    public function __construct(array $filters) {
        $this->filters = $filters;
    }

    public function getFilters(){

    }

    public function getFiltersType(){

    }



}
