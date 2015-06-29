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
Route::get('/status/client/{client}', 'StatusController@client');
Route::get('/status/service/{service}', 'StatusController@service');
Route::get('/status/server/{server}', 'StatusController@server');

/**
 * Ticket Controller routes.
 */
Route::get('/ticket/show/{ticket}', 'TicketController@show');
Route::get('/ticket/create/{server_check_result}', 'TicketController@create');
Route::post('/ticket/store', 'TicketController@store');

/**
 * Report Controller routes.
 */
Route::get('/report/', ['as' => 'report', 'uses' => 'ReportController@index']);
Route::post('/report/', 'ReportController@index');

/**
 * Administration Controller routes.
 */
Route::get('/administration/', ['as' => 'administration', 'uses' => 'AdministrationController@index']);
Route::get('/administration/clients', 'AdministrationController@clients');
Route::get('/administration/client/enable/{client}', function(Dodona\Client $client)
{
	$client->enable();

	return redirect('administration/clients/');
});
Route::get('/administration/client/disable/{client}', function(Dodona\Client $client)
{
	$client->disable();

	return redirect('administration/clients/');
});
Route::get('/administration/services', 'AdministrationController@services');
Route::get('/administration/service/enable/{service}', function(Dodona\Service $service)
{
	$service->enable();

	return redirect('administration/services/');
});
Route::get('/administration/service/disable/{service}', function(Dodona\Service $service)
{
	$service->disable();

	return redirect('administration/services/');
});
Route::get('/administration/sites', 'AdministrationController@sites');
Route::get('/administration/servers', 'AdministrationController@servers');
Route::get('/administration/server/enable/{server}', function(Dodona\Server $server)
{
	$server->enable();

	return redirect('administration/servers/');
});
Route::get('/administration/server/disable/{server}', function(Dodona\Server $server)
{
	$server->disable();

	return redirect('administration/servers/');
});
