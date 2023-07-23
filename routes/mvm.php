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

$mvm->get('/info', function () use ($mvm) {
         return phpinfo();
});

$mvm->get('/testdb', function () use ($mvm) {

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


$mvm->group(['prefix' => 'mvm/'], function () use ($mvm) {
    $mvm->group(['middleware' => 'CheckToken'], function () use ($mvm) {
        $mvm->post('auth/login', 'AuthController@login');
        $mvm->post('auth/logout', 'AuthController@logout');
    });
 
});