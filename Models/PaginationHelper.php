<?php

class PaginationHelper
{    
    /** 
     * Takes a readable sort string and converts to html that sets the correct 
     * option in the select input
     */
    public static function ConvertForSelect( $value, $type )
    {   
        switch( $value )
        {
            case 'asc':
            case 'desc':
                if($type == $value)
                    return 'selected="selected"';
                break;
        }
        return '';
    }

    /**
     * 
     * @param $fullSearch
     * @param $tableName
     * @param Db::table $query
     * @param \Oval\Pagination\PaginationModel $paginationModel
     * @return $paginationModel->amount
     */    
    public static function PrepareForDb( $query, PaginationModel $paginationModel, $fullSearch = false )
    {        
        $sortBy = array();
        
        if( $fullSearch )
        {            
            $query->where( function( $cQuery ) use ( $paginationModel, &$sortBy )
            {
                foreach( $paginationModel->columns as $key => $column )
                {
                    if( isset( $column->concat ) )
                    {
                        $columnString = implode(",",$column->concat->columns);
                        $concat = "CONCAT_WS( " . $column->concat->seperator . ", " . $columnString .  " )";
                                               
                        //If a column needs to be concatoncated
                        $cQuery->orWhere( DB::raw($concat), "LIKE", "%$column->searchTerm%");
                        $sortBy[ $concat ] = $column->sort;                   
                    }
                    else
                    {                        
                        if( $column->preValueAsserted !== FALSE )
                        {
                            $cQuery->orWhere( $column->columnName, 'LIKE', "%". $column->searchTerm."%");
                        }else
                        {
                            $cQuery->orWhere( $column->columnName, 'LIKE', "%".$paginationModel->searchTerm."%");
                        }
                        $sortBy[ $column->columnName ] = $column->sort;
                    }
                }
            } );
        }
        else
        {
            foreach( $paginationModel->columns as $column )
            {
                /* @var $column PaginationColumn */
                if( !empty( $column->searchTerm ) )
                {
                    $query->where( $column->columnName, 'LIKE', "%".$column->searchTerm."%");
                }  

                $sortBy[ $column->columnName ] = $column->sort;
            }
        }
        
        
        foreach( $sortBy as $key => $value )
        {
            switch( $value )
            {
                case "asc":
                    $query->orderBy( DB::raw($key), "asc" );
                    break;
                case "desc":
                    $query->orderBy( DB::raw($key), "desc" );
                    break;
            }
        }     
        return $paginationModel->amount;
    }
    
    public static function GetNewSortParams($currentSort = "", $type = "")
    {
        $paramaterString = $_SERVER['QUERY_STRING'];
               
        
        parse_str($paramaterString, $arr);
        
        switch($currentSort)
        {
            case "none":
                $newSort = "asc";
                break;
            case "asc":
                $newSort = "desc";
                break;
            case "desc":
                $newSort = "asc";
                break;
            default:
                $newSort = "asc";
                break;
        }
        
        foreach($arr as $key => $value)
        {
            if($key != $type)
            {
                if($value == "asc" || $value == "desc")
                {
                    $arr[$key] = "none";
                }
            }
        }
        
        
        $arr[$type] = $newSort;
        
        return "?" . http_build_query($arr);
    }   
    
    public static function GetFontAwesomeSortIcon($currentSort)
    {
        switch($currentSort)
        {
            
            case "asc":
                return "fa-sort-asc";
                break;
            case "desc":
                return "fa-sort-desc";
                break;
            default:
                return "fa-sort";
                break;
        }
    }
}
?>
