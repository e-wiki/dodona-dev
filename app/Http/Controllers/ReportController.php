<?php

namespace Dodona\Http\Controllers;

use Dodona\Http\Controllers\Controller;
use Dodona\Models\Client;
use Dodona\Models\Reporting\ReportLevel;
use Dodona\Models\Server;
use Dodona\Models\Service;
use Dodona\Models\Site;
use Illuminate\Support\Facades\Input;

class ReportController extends Controller
{

    /**
     * Load the main report page.
     *
     * @return string
     */
    public function index()
    {
        $choices = $this->getChoices();

        $report_levels = ReportLevel::orderBy('id', 'asc')->lists('name', 'id');
        $client_list   = Client::lists('name', 'id')->push('--- Select client ---');
        $service_list  = Service::where('client_id', $choices['client_id'])->lists('name', 'id')->push('--- Select service ---');
        $site_list     = Site::where('service_id', $choices['service_id'])->lists('name', 'id')->push('--- Select site ---');
        $server_list   = Server::where('site_id', $choices['site_id'])->lists('name', 'id')->push('--- Select server ---');

        return view('report.form', compact(
            'choices',
            'report_levels',
            'client_list',
            'service_list',
            'site_list',
            'server_list'
        ));
    }

    private function getChoices($choices = [])
    {
        $choices['current_client_id']  = Input::get('current_client_id', 0);
        $choices['current_service_id'] = Input::get('current_service_id', 0);
        $choices['current_site_id']    = Input::get('current_site_id', 0);
        $choices['current_server_id']  = Input::get('current_server_id', 0);

        $choices['report_level_id'] = Input::get('report_level_id', '');
        $choices['client_id']       = Input::get('client_id', 0);
        $choices['service_id']      = ($choices['client_id'] === $choices['current_client_id']) ? Input::get('service_id') : 0;
        $choices['site_id']         = ($choices['service_id'] === $choices['current_service_id']) ? Input::get('site_id') : 0;
        $choices['server_id']       = ($choices['site_id'] === $choices['current_site_id']) ? Input::get('server_id') : 0;

        return $choices;
    }
    
}
