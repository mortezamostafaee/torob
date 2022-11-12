<?php

function get_options($options)
{
    global $wpdb;
    $results = $wpdb->get_results( "SELECT option_name,option_value FROM {$wpdb->prefix}options WHERE option_name IN($options)" ); 
    $output = [];
    foreach($results as $item)
    {
        $output[$item->option_name] = $item->option_value;
    }

    $arr = explode(',', $options);
    foreach($arr as $option)
    {
        $op = trim(str_replace("'", "", $option));
        if( !array_key_exists($op, $output) )
        {
            $output[$op] = '';
        }
    }
    return $output;
}