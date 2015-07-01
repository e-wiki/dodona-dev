<?php
/**
 * Status Controller.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */


namespace Dodona\Http\Controllers;

use Dodona\Check;
use Dodona\CheckResult;
use Dodona\Client;
use Dodona\DatabaseTechnology;
use Dodona\Environment;
use Dodona\Http\Controllers\Controller;
use Dodona\OperatingSystem;
use Dodona\Server;
use Dodona\Service;
use Dodona\Site;

/**
 * Handles the administration of the Dodona Framework.
 */
class AdministrationController extends Controller
{
    public function index()
    {
        $clients_count  = Client::count();
        $services_count = Service::count();
        $sites_count    = Site::count();
        $servers_count  = Server::count();
        
        $checks_count        = Check::count();
        $check_results_count = CheckResult::count();
        
        return view('administration.main',
                compact(
                    'clients_count',
                    'services_count',
                    'sites_count',
                    'servers_count',
                    'checks_count',
                    'check_results_count'
        ));
    }
    
    public function clients()
    {
        $clients = Client::orderBy('name', 'asc')->get();
        
        return view('administration.clients', compact('clients'));
    }
    
    public function services()
    {
        $client_list = Client::lists('name', 'id');
        $services    = Service::orderBy('name', 'asc')->get();
        
        return view('administration.services', compact('client_list', 'services'));
    }
    
    public function sites()
    {
        $service_list     = Service::lists('name', 'id');
        $environment_list = Environment::lists('name', 'id');
        $sites            = Site::orderBy('name', 'asc')->get();
        
        return view('administration.sites', compact('service_list', 'environment_list', 'sites'));
    }
    
    public function servers()
    {
        $service_list             = Service::lists('name', 'id');
        $site_list                = Site::lists('name', 'id');
        $operating_system_list    = OperatingSystem::lists('name', 'id');
        $database_technology_list = DatabaseTechnology::lists('name', 'id');
        $servers                  = Server::orderBy('name', 'asc')->get();
        
        return view('administration.servers', compact(
                'service_list',
                'site_list',
                'operating_system_list',
                'database_technology_list',
                'servers'
        ));
    }
}
