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




$mvm->group(['prefix' => 'mvm/'], function () use ($mvm) {
    $mvm->group(['middleware' => 'CheckKey'], function () use ($mvm) {
        $mvm->post('auth/login', 'AuthController@login');
        $mvm->post('auth/logout', 'AuthController@logout');



        $mvm->group(['middleware' => 'Session'], function () use ($mvm) {
            $mvm->post('home', 'MvmController@home');
            
        });



    });
});