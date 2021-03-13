<?php 
    require_once 'inc/config.php';
    require_once 'controller/PersonController.php';
    require_once 'controller/StandingController.php';

    
    use Pecee\Http\Request;
    use Pecee\SimpleRouter\SimpleRouter;

    // PERSONS
    SimpleRouter::get('/webtech/zadanie2/', 'PersonController@index');
    SimpleRouter::get('/webtech/zadanie2/persons/{id}/edit', 'PersonController@edit');
    SimpleRouter::post('/webtech/zadanie2/persons/{id}/edit', 'PersonController@update');
    SimpleRouter::delete('/webtech/zadanie2/persons/{id}/delete', 'PersonController@delete');
    SimpleRouter::get('/webtech/zadanie2/persons/create', 'PersonController@create');
    SimpleRouter::post('/webtech/zadanie2/persons/create', 'PersonController@store');
    SimpleRouter::get('/webtech/zadanie2/persons/{id}', 'PersonController@show');



    

    // STANDINGS
    SimpleRouter::get('/webtech/zadanie2/standings/add', 'StandingController@create');
    SimpleRouter::post('/webtech/zadanie2/standings/add', 'StandingController@store');



    // 404
    SimpleRouter::error(function(Request $request, \Exception $exception) {
        
        return view('404.php');
        
    });

    SimpleRouter::start();
