<?php
    class PaginationColumn
    {    
        public $searchTerm;
        public $columnName;
        public $sort;

        public function __Construct( $columnName = "", $searchTerm = "", $sort )
        {
            $this->searchTerm = $searchTerm;
            $this->columnName = $columnName;
            $this->sort = $sort;
        }
    }
?>
