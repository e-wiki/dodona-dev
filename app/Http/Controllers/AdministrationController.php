<?php
/**
 * Status Controller.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */


namespace Dodona\Http\Controllers;

use Dodona\Http\Controllers\Controller;
use Dodona\Models\Support\Alert;
use Dodona\Models\Status\Check;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Status\CheckModule;
use Dodona\Models\Status\CheckResult;
use Dodona\Models\Client;
use Dodona\Models\Support\DatabaseTechnology;
use Dodona\Models\Support\Environment;
use Dodona\Models\Support\OperatingSystem;
use Dodona\Models\Server;
use Dodona\Models\Service;
use Dodona\Models\Site;
use Sentinel\Models\Group;
use Sentinel\Models\User;

/**
 * Handles the administration of the Dodona Framework.
 */
class AdministrationController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('sentry.member:Admins');
    }

    public function index()
    {
        $clients_count  = Client::count();
        $services_count = Service::count();
        $sites_count    = Site::count();
        $servers_count  = Server::count();

        $check_modules_count = CheckModule::count();
        $checks_count        = Check::count();
        $check_results_count = CheckResult::count();

        $groups_count = Group::count();
        $users_count  = User::count();
        
        return view('administration.main',
                compact(
                    'clients_count',
                    'services_count',
                    'sites_count',
                    'servers_count',
                    'check_modules_count',
                    'checks_count',
                    'check_results_count',
                    'groups_count',
                    'users_count'
        ));
    }
    
    public function clients()
    {
        $clients = Client::orderBy('name', 'asc')->paginate($this->items_per_page);

        $clients->setPath('clients');
        
        return view('administration.clients', compact('clients'));
    }
    
    public function services()
    {
        $client_list = Client::lists('name', 'id');
        $services    = Service::orderBy('name', 'asc')->paginate($this->items_per_page);

        $services->setPath('services');
        
        return view('administration.services', compact('client_list', 'services'));
    }
    
    public function sites()
    {
        $service_list     = Service::lists('name', 'id');
        $environment_list = Environment::lists('name', 'id');
        $sites            = Site::orderBy('name', 'asc')->paginate($this->items_per_page);

        $sites->setPath('sites');
        
        return view('administration.sites', compact('service_list', 'environment_list', 'sites'));
    }
    
    public function servers()
    {
        $service_list             = Service::lists('name', 'id');
        $site_list                = Site::lists('name', 'id');
        $operating_system_list    = OperatingSystem::lists('name', 'id');
        $database_technology_list = DatabaseTechnology::lists('name', 'id');
        $servers                  = Server::orderBy('name', 'asc')->paginate($this->items_per_page);

        $servers->setPath('servers');
        
        return view('administration.servers', compact(
            'service_list',
            'site_list',
            'operating_system_list',
            'database_technology_list',
            'servers'
        ));
    }

    public function checkModules()
    {
        $check_modules = CheckModule::orderBy('name', 'asc')->paginate($this->items_per_page);

        $check_modules->setPath('check_modules');

        return view('administration.check_modules', compact('check_modules'));
    }

    public function checks()
    {
        $check_categories_list = CheckCategory::lists('name', 'id');
        $check_modules_list    = CheckModule::lists('name', 'id');
        $checks                = Check::orderBy('id', 'asc')->paginate($this->items_per_page);
        
        $checks->setPath('checks');

        return view('administration.checks', compact(
            'check_categories_list',
            'check_modules_list',
            'checks'
        ));
    }

    public function checkResults()
    {
        $checks_list   = Check::lists('name', 'id');
        $alerts_list   = Alert::lists('name', 'id');
        $check_results = CheckResult::orderBy('id', 'asc')->paginate($this->items_per_page);

        $check_results->setPath('check_results');

        #return $check_results;

        return view('administration.check_results', compact(
            'checks_list',
            'alerts_list',
            'check_results'
        ));
    }
}
