<?php namespace Dodona\Http\Controllers;

/**
 * Status Controller.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Models\CheckCategory;
use Dodona\Models\Client;
use Dodona\Http\Controllers\Controller;
use Dodona\Models\Server;
use Dodona\Models\Service;

/**
 * Handles the status capabilities of the Dodona Framework.
 */
class StatusController extends Controller
{
    /**
     * Loads the main status page.
     *
     * @return string
     */
    public function index()
    {
        $clients = Client::getEnabled();
        
        return view('status.all', compact('clients'));
    }
    
    /**
     * Loads the client status page.
     *
     * @param unsigned integer $id
     * @return string
     */
    public function client(Client $client)
    {
        return view('status.client', compact('client'));
    }
    
    /**
     * Loads the service status page.
     *
     * @param unsigned integer $id
     * @return string
     */
    public function service(Service $service)
    {
        $client  = $service->client;
        
        return view('status.service', compact('client', 'service'));
    }
    
    /**
     * Loads the server status page.
     *
     * @param unsigned integer $id
     * @return string
     */
    public function server(Server $server)
    {
        $service          = $server->service();
        $client           = $service->client;
        $checks           = $server->latestServerCheckResults();
        $check_categories = CheckCategory::all();
        
        return view('status.server', compact('client', 'service', 'server', 'checks', 'check_categories'));
    }
}
