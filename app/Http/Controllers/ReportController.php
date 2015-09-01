<?php

namespace Dodona\Http\Controllers;

use Dodona\Models\Reporting\ReportForm;
use Dodona\Models\Server;
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
        if (Input::get('store'))
        {
            return $this->createReport();
        }

        $choices = ReportForm::getReportFormChoices();

        $dropdowns = ReportForm::getReportFormDropdowns($choices);

        return view('report.form', compact('choices', 'dropdowns'));
    }

    private function createReport()
    {
        $server = Server::find(Input::get('current_server_id'));

        $red_alerts   = $server->getRedAlerts;
//        $amber_alerts = $server->getAmberAlerts;

        return $red_alerts;
    }
    
}
