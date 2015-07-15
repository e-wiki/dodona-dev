<?php

namespace Dodona\Http\Controllers;

use Carbon\Carbon;
use Dodona\Http\Controllers\Controller;
use Dodona\Models\Client;
use Dodona\Models\Reporting\ReportLevel;
use Dodona\Models\Reporting\ReportType;
use Dodona\Models\Server;
use Dodona\Models\Service;
use Dodona\Models\Site;
use Illuminate\Support\Facades\Request;
use function view;

class ReportController extends Controller
{
    /**
     * Date format depending on the length of the date.
     * 
     * @var array
     */
    private $carbonFormatLookup = [
        4  => 'Y',
        7  => 'm/Y',
        10 => 'd/m/Y',
    ];

    /**
     * Load the main report page.
     *
     * @return string
     */
    public function index()
    {
        $fields = $this->captureReportFields();
        
        $report_levels = ReportLevel::orderBy('id')->lists('name', 'id')->all();

        # Not using WEEKLY for the time being as it currently breaks the date
        # format. It is not supported by PHP and Carbon out of the box.
        $report_types  = ReportType::where('id', '!=', 2)->orderBy('id')->lists('name', 'id')->all();

        $items = $this->getLevelItems($fields['report_level_id']);

        return view('report.form', compact('fields', 'report_levels', 'report_types', 'items'));
    }
    
    private function captureReportFields()
    {
        $fields['report_level_id'] = Request::get('report_level_id');
        $fields['report_type_id']  = Request::get('report_type_id');
        $fields['start_date']      = $this->parseDate(Request::get('start_date'))->format('d/m/Y');
        $fields['view_mode']       = "days";
        $fields['format']          = "DD/MM/YYYY";
        
        $this->parseReportType($fields);
        
        return $fields;
    }
    
    private function parseReportType(&$fields)
    {
        switch ($fields['report_type_id']) {
            case ReportType::CUSTOM:
                $fields['end_date']   = $this->parseDate(Request::get('end_date'))->format('d/m/Y');
                break;
            case ReportType::YEARLY:
                $fields['view_mode']  = "years";
                $fields['format']     = "YYYY";
                $fields['start_date'] = $this->parseDate($fields['start_date'])->format('Y');
                break;
            case ReportType::MONTHLY:
                $fields['view_mode']  = "months";
                $fields['format']     = "MM/YYYY";
                $fields['start_date'] = $this->parseDate($fields['start_date'])->format('m/Y');
                break;
            case ReportType::DAILY:
            default:
                break;
        }
    }
    
    private function parseDate($date)
    {
        $result = Carbon::now();
        
        if (! empty($date)) {
            $result = Carbon::createFromFormat($this->carbonFormatLookup[strlen($date)], $date);
        }
        
        return $result;
    }

    private function getLevelItems($report_level_id)
    {
        switch ($report_level_id) {
            case ReportLevel::SERVER_LEVEL:
                $items = Server::orderBy('name')->lists('name', 'id')->all();
                break;
            case ReportLevel::SITE_LEVEL:
                $items = Site::orderBy('name')->lists('name', 'id')->all();
                break;
            case ReportLevel::SERVICE_LEVEL:
                $items = Service::orderBy('name')->lists('name', 'id')->all();
                break;
            case ReportLevel::CLIENT_LEVEL:
            default:
                $items = Client::orderBy('name')->lists('name', 'id')->all();
                break;
        }

        return $items;
    }
}
