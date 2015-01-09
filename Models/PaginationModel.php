<?php
    class PaginationModel
    {    
        public $paginationName;
        public $page;
        public $amount;
        public $columns = array();
        
        public $searchTerm;
        
        public function __Construct()
        {
            $this->page = Input::has( "page" ) ? Input::get( "page" ) : 0;
        }
    }
?>
