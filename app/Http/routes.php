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
Route::get('/', ['as' => 'home', 'uses' => 'StatusController@index']);

/**
 * Status Controller routes.
 */
Route::group(['prefix' => 'status', 'as' => 'status.'], function()
{
    Route::get('', ['as' => 'all', 'uses' => 'StatusController@index']);
    Route::get('client/{client}', ['as' => 'client', 'uses' => 'StatusController@client']);
    Route::get('service/{service}', ['as' => 'service', 'uses' => 'StatusController@service']);
    Route::get('server/{server}', ['as' => 'server', 'uses' => 'StatusController@server']);
});

/**
 * Ticket Controller routes.
 */
Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function()
{
    Route::get('show/{ticket}', ['as' => 'show', 'uses' => 'TicketController@show']);
    Route::get('create/{server_check_result}', ['as' => 'create', 'uses' => 'TicketController@create']);
    Route::post('store', ['as' => 'store', 'uses' => 'TicketController@store']);
});

/**
 * Report Controller routes.
 */
Route::group(['prefix' => 'report', 'as' => 'report'], function()
{
    Route::get('', 'ReportController@index');
    Route::post('', 'ReportController@index');
});

/**
 * Administration Controllers routes.
 */
Route::group(['prefix' => 'administration', 'as' => 'administration.'], function()
{
    Route::get('', ['as' => 'main', 'uses' => 'AdministrationController@index']);
    Route::get('clients', ['as' => 'clients', 'uses' => 'AdministrationController@clients']);
    Route::get('services', ['as' => 'services', 'uses' => 'AdministrationController@services']);
    Route::get('sites', ['as' => 'sites', 'uses' => 'AdministrationController@sites']);
    Route::get('servers', ['as' => 'servers', 'uses' => 'AdministrationController@servers']);
});

Route::group(['prefix' => 'client', 'as' => 'client.'], function()
{
    Route::post('store', ['as' => 'store', 'uses' => 'Administration\ClientController@store']);
    Route::get('enable/{client}', ['as' => 'enable', 'uses' => function (Dodona\Client $client)
    {
        $client->enable();

        return redirect('administration/clients/');
    }]);
    Route::get('disable/{client}', ['as' => 'disable', 'uses' => function (Dodona\Client $client)
    {
        $client->disable();

        return redirect('administration/clients/');
    }]);
});

Route::group(['prefix' => 'service', 'as' => 'service.'], function()
{
    Route::post('store', ['as' => 'store', 'uses' => 'Administration\ServiceController@store']);
    Route::get('enable/{service}', ['as' => 'enable', 'uses' => function (Dodona\Service $service)
    {
        $service->enable();

        return redirect('administration/services');
    }]);
    Route::get('disable/{service}', ['as' => 'disable', 'uses' => function (Dodona\Service $service)
    {
        $service->disable();

        return redirect('administration/services');
    }]);
});

Route::post('site/store', ['as' => 'site.store', 'uses' => 'Administration\SiteController@store']);

Route::group(['prefix' => 'server', 'as' => 'server.'], function()
{
    Route::post('store', ['as' => 'store', 'uses' => 'Administration\ServerController@store']);
    Route::get('enable/{server}', ['as' => 'enable', 'uses' => function (Dodona\Server $server)
    {
        $server->enable();

        return redirect('administration/servers');
    }]);
    Route::get('disable/{server}', ['as' => 'disable', 'uses' => function (Dodona\Server $server)
    {
        $server->disable();

        return redirect('administration/servers');
    }]);
});
