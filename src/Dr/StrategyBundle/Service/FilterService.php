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
     * Stores an array of string with the names of the filters
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
            $instance = new $filter;

            if(false === $instance instanceof AbstractFilter){
                throw new BaseException('FilterService::getFiltersInstances: cant create instance of ' . $filter);
            }

            $output[ $instance->getIdentifier() ] = $instance;
        }

        return $output;
    }

    /**
     * @return array
     * @throws BaseException
     */
    public function getFiltersList(){
        $output = $this->getFiltersInstances();

        foreach($output as $key => $filter){
            $output[$key] = $filter->getName();
        }

        return $output;
    }


}
