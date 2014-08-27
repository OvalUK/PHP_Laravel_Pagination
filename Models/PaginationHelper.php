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
     * @param Db::table $query
     * @param \Oval\Pagination\PaginationModel $paginationModel
     * @return $paginationModel->amount
     */
    public static function PrepareForDb( $query, PaginationModel $paginationModel )
    {
        $whereClauses = array();
        $sortBy = array();

        foreach( $paginationModel->columns as $column )
        {
            /* @var $column PaginationColumn */
            $query->where($column->columnName, 'LIKE', "%".$column->searchTerm."%");                 
            $sortBy[ $column->columnName ] = $column->sort;
        }

        foreach( $sortBy as $key => $value )
        {
            switch( $value )
            {
                case "asc":
                    $query->orderBy( $key, "asc" );
                    break;
                case "desc":
                    $query->orderBy( $key, "desc" );
                    break;
            }
        }     

        return $paginationModel->amount;
    }
}
?>
