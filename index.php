<?php 
    require_once 'inc/config.php';
    require_once 'controller/PersonController.php';
    require_once 'controller/StandingController.php';

    
    use Pecee\Http\Request;
    use Pecee\SimpleRouter\SimpleRouter;

    // PERSONS
    SimpleRouter::get( ROUTING_PREFIX . '/' , 'PersonController@index');
    SimpleRouter::get( ROUTING_PREFIX .'/persons/{id}/edit', 'PersonController@edit');
    SimpleRouter::post( ROUTING_PREFIX .'/persons/{id}/edit', 'PersonController@update');
    SimpleRouter::delete( ROUTING_PREFIX .'/persons/{id}/delete', 'PersonController@delete');
    SimpleRouter::get( ROUTING_PREFIX .'/persons/create', 'PersonController@create');
    SimpleRouter::post( ROUTING_PREFIX .'/persons/create', 'PersonController@store');
    SimpleRouter::get( ROUTING_PREFIX .'/persons/{id}', 'PersonController@show');



    

    // STANDINGS
    SimpleRouter::get( ROUTING_PREFIX .'/standings/add', 'StandingController@create');
    SimpleRouter::post( ROUTING_PREFIX .'/standings/add', 'StandingController@store');



    // 404
    SimpleRouter::error(function(Request $request, \Exception $exception) {
        
        return view('404.php');
        
    });

    SimpleRouter::start();
