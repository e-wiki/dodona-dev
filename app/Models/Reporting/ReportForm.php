<?php

namespace Dodona\Models\Reporting;

use Dodona\Models\Client;
use Dodona\Models\Server;
use Dodona\Models\Service;
use Dodona\Models\Site;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class ReportForm extends Model
{

    /**
     * Parses and returns the Report Form choices.
     *
     * @param array $choices
     * @return array
     */
    static public function getReportFormChoices($choices = [])
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

    /**
     * Parses and returns the Report Form dropdown values.
     *
     * @param type $choices
     * @return type
     */
    static public function getReportFormDropdowns($choices)
    {
        $dropdowns['report_levels'] = ReportLevel::orderBy('id', 'asc')->lists('name', 'id');
        $dropdowns['client_list']   = Client::lists('name', 'id')->push('--- Select client ---');
        $dropdowns['service_list']  = Service::where('client_id', $choices['client_id'])->lists('name', 'id')->push('--- Select service ---');
        $dropdowns['site_list']     = Site::where('service_id', $choices['service_id'])->lists('name', 'id')->push('--- Select site ---');
        $dropdowns['server_list']   = Server::where('site_id', $choices['site_id'])->lists('name', 'id')->push('--- Select server ---');

        return $dropdowns;
    }
}
