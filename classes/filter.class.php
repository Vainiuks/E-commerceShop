<?php

class Filter {

    private $filterValue;

    public function setFilterValue($filterValue) {
        $this->filterValue = $filterValue;
    }

    public function getFilterValue() {
        return $this->filterValue;
    }
}