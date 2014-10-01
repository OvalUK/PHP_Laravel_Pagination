<?php
    class PaginationModel
    {    
        public $page;
        public $amount;
        public $columns = array();
        
        public function __Construct()
        {
            $this->page = Input::has( "page" ) ? Input::get( "page" ) : 0;
        }
    }
?>
