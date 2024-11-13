<?php


if (!function_exists('get_dinamic_field_value')) {

    function get_dinamic_field_value($identifier)
    {
        $page = \App\Models\Page::where('identifier',$identifier)->first();
        
        if(!$page){
            return '';
        }

        return $page->getFieldValue('field');
    }
}
