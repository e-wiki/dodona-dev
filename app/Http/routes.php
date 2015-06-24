<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * Main page route.
 */
Route::get('/', 'StatusController@index');

/**
 * Status Controller routes.
 */
Route::get('/status/', ['as' => 'status', 'user' => 'StatusController@index']);
Route::get('/status/client/{id?}', 'StatusController@client');
Route::get('/status/service/{id?}', 'StatusController@service');
Route::get('/status/server/{id?}', 'StatusController@server');
Route::get('/status/ticket/create/{id?}', 'StatusController@createTicket');
Route::get('/status/ticket/show/{id?}', 'StatusController@showTicket');
Route::post('/status/ticket/store/', 'StatusController@storeTicket');
//Route::resource('status', 'StatusController');

/**
 * Report Controller routes.
 */
Route::get('/report/', ['as' => 'report', 'uses' => 'ReportController@index']);
Route::post('/report/level/', 'ReportController@index');
