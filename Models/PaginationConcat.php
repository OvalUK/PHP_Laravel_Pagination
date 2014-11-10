<?php

class PaginationConcat
{
    public $seperator;
    public $columns = array();
    
    public function __construct( $seperator, $columns = array() )
    {
        $this->seperator = $seperator;
        $this->columns = $columns;
    }
}