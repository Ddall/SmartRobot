<?php
/**
 * DdxSr - FilterService.php
 * Created by Allan.
 */

namespace Dr\StrategyBundle\Service;


use AppBundle\Exception\BaseException;
use Dr\ReaderBundle\Service\AbstractDdxDrService;
use Dr\StrategyBundle\Filter\AbstractFilter;

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

    /**
     * @return array
     */
    public function getFilters(){
        return $this->filters;
    }




    /**
     * @return array
     * @throws BaseException
     */
    public function getFiltersInstances(){
        $output = array();
        foreach($this->filters as $key => $filter){
            $output[$key] = new $filter;
            if(false === $output[$key] instanceof AbstractFilter){
                throw new BaseException('FilterService::getFiltersInstances: cant create instance of ' . $filter);
            }
        }

        return $output;
    }

}
