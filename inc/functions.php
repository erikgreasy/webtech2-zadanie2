<?php


define( "BASE_URL", "http://localhost/webtech/zadanie2" );


/**
 * Get Segments
 * 
 * From an url like http://example.com/edit/5
 * creates an array of URI segments [edit, 5]
 * 
 * @return array
 */
function get_segments() {

    $current_url = 'http' .
        ( isset( $_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'  ? 's://' : '://' ) .
        $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ;
    

    $path = str_replace( BASE_URL, '', $current_url );
    $path = parse_url( $path, PHP_URL_PATH );


    $segments = explode( '/', trim( $path, '/' ) );
    

    return $segments;
}


/**
 * Segment
 * 
 * Returns the index-th URI segment
 * 
 * @param $index
 * @return string or false
 */
function segment( $index ) {
    $segments = get_segments();

    return isset( $segments[ $index-1 ] ) ? $segments[ $index-1 ] : false;
    
}