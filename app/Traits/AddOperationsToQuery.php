<?php

namespace App\Traits;
use Carbon\Carbon;

trait AddOperationsToQuery
{
    public function addOrderAndFilters($query, $conditions ) { 

        if(isset($conditions['filter'])){
            foreach($conditions['filter'] as $filter ){

                if(isset($filter['value']) && $filter['value'] != '*'){
                    $subtables = explode('.',$filter['name']);
                    $value = $this->convertValueFormatIfNeeded($filter);
                    if(count($subtables) > 1){
                        //case field of subtable
                        $fieldName = array_shift($subtables);
                        $subtables = explode('.',$filter['name']);
                        $fieldName = array_pop($subtables);

                        $subtablesName = implode('.', $subtables);
                        $query = $query->whereHas($subtablesName, function($q) use($fieldName,$filter, $value) {
                            // Query the name field in status table
                            $q->where($fieldName, $filter['operator'],$value); 
                        });
                    }else{
                        $query = $query->where($filter['name'],$filter['operator'],$value);
    
                    }
                }
            }
        }
        $query = $this->addSearchConditions($query,$conditions);

        if(isset($conditions['order'])){
            foreach($conditions['order'] as $order ){
                $query = $query->orderBy($order['name'],$order['operator']);
            }
        }
        
        return $query;

    }

    public function addSearchConditions($query, $conditions) {

        if (isset($conditions['search'])) {
            
            $value = isset($conditions['search']['query']) ? $conditions['search']['query'] : null;
            $fields = isset($conditions['search']['fields']) ? $conditions['search']['fields'] : [];
    
            if ($value && count($fields) > 0) {
                if ($value != '*') {
                    $query = $query->where(function($query) use ($fields, $value, $contactsSpecialSearch) {
                        $value = '%' . $value . '%'; 
                        foreach ($fields as $index => $field) {
                            $subtables = explode('.', $field);
                            $method = $index === 0 ? 'whereHas' : 'orWhereHas';

                            if (count($subtables) > 1) {
                                $fieldName = array_shift($subtables);
                                // Caso: Campo en una tabla relacionada no contacts
                                $subtables = explode('.', $field);
                                $fieldName = array_pop($subtables);
                                $subtablesName = implode('.', $subtables);

                                $query->$method($subtablesName, function($q) use ($fieldName, $value) {
                                    $q->where($fieldName, 'LIKE', $value);
                                });
                                
                            } else {
                                // Caso: Campo en la tabla principal
                                $method = $index === 0 ? 'where' : 'orWhere';

                                $query->$method($field, 'LIKE', $value);
                            }
                        }
                    });
                }
            }
        }
    
        return $query;
    }
    

    public function convertValueFormatIfNeeded($filter) {
        $value = $filter['value'];

        if(!isset($filter['format'])){
            return  $value;
        }

        switch($filter['format']){
            case 'timestamp':
                if(is_numeric($value) ){
                    $value = (int) $value;
                }
                $value = (new  Carbon($value))->format('Y-m-d\Th:i:sT');;
            break;
        }

        return  $value;
    } 
}
