<?php namespace Dodona\Http\Controllers;

/**
 * Status Controller.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Http\Controllers\Controller;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Client;
use Dodona\Models\Server;
use Dodona\Models\Service;
use Dodona\Models\Site;

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
     * @param Dodona\Models\Client $client
     * @return string
     */
    public function client(Client $client)
    {
        return view('status.client', compact('client'));
    }
    
    /**
     * Loads the service status page.
     *
     * @param Dodona\Models\Service $service
     * @return string
     */
    public function service(Service $service)
    {
        $client  = $service->client;
        
        return view('status.service', compact('client', 'service'));
    }

    /**
     * Loads the site status page.
     * 
     * @param Dodona\Models\Site $site
     * @return string
     */
    public function site(Site $site)
    {
        $service = $site->service;
        $client  = $service->client;

        return view('status.site', compact('client', 'service', 'site'));
    }
    
    /**
     * Loads the server status page.
     *
     * @param Dodona\Models\Server $server
     * @return string
     */
    public function server(Server $server)
    {
        $site             = $server->site;
        $service          = $site->service;
        $client           = $service->client;
        $check_results    = $server->latestServerCheckResults;
        $check_categories = CheckCategory::all();
        
        return view('status.server', compact(
            'client',
            'service',
            'site',
            'server',
            'check_results',
            'check_categories'
        ));
    }
}
