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


    class PaginationColumn
    {    
        public $searchTerm;
        public $columnName;
        public $sort;
        public $concat;
        public $preValueAsserted = false;
        
        public function __Construct( $columnName = "", $searchTerm = "", $sort, $concat = null, $preValueCallback = false )
        {
            if( is_callable( $preValueCallback ) )
            {
                $this->searchTerm = call_user_func( $preValueCallback );
                $this->preValueAsserted = true;
            }else
            {
                $this->searchTerm = $searchTerm;
            }
            
            $this->columnName = $columnName;
            $this->sort = $sort;
            $this->concat = $concat;
        }
    }
?>