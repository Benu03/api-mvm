<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return redirect('https://www.ts3.co.id');
        
});

$router->get('/info', function () use ($router) {
    return phpinfo();
});

$router->get('/testdb', function () use ($router) {

   try {
       DB::connection('ts3')->getPdo();
       $data = "Connected successfully to: " . DB::connection('ts3')->getDatabaseName();
       
   } catch (\Exception $e) {
       return response()->json(
           [   'status'       =>  400,
               'success'   =>  false,
               'message'   =>  'Request Failed',
               'data'      =>  [$e]
           ], 400);
   }
   
   return response()->json(
       [   'status'       =>  200,
           'success'   =>  true,
           'message'   =>  'Request Success',
           'data'      =>  [$data]
       ], 200);
});
