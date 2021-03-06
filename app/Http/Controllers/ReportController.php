<?php

namespace Dodona\Http\Controllers;

use Carbon\Carbon;

use Dodona\Client;
use Dodona\Http\Controllers\Controller;
use Dodona\Report;
use Dodona\ReportLevel;
use Dodona\ReportType;
use Dodona\Site;
use Dodona\Server;
use Dodona\Service;

#use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;

class ReportController extends Controller
{
    /**
	 * Load the main report page.
	 * 
	 * @return string
	 */
	public function index()
	{
		$fields = $this->_captureReportFields();
		
		$report_levels = ReportLevel::orderBy('id')->lists('name', 'id')->all();
		$report_types  = ReportType::orderBy('id')->lists('name', 'id')->all();
		
		switch ($fields['report_level_id'])
		{
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
		
		return view('report.form', compact('fields', 'report_levels', 'report_types', 'items'));
	}
	
	private function _captureReportFields()
	{
		$fields['report_level_id'] = Request::get('report_level_id');
		$fields['report_type_id']  = Request::get('report_type_id');
		
		switch ($fields['report_type_id'])
		{
			case ReportType::CUSTOM:
				$fields['view_mode']  = "days";
				$fields['format']     = "DD/MM/YYYY";
				$fields['start_date'] = $this->_parseDate(Request::get('start_date'))->format('d/m/Y');
				$fields['end_date']   = $this->_parseDate(Request::get('end_date'))->format('d/m/Y');
				break;
			case ReportType::YEARLY:
				$fields['view_mode']  = "years";
				$fields['format']     = "YYYY";
				$fields['start_date'] = $this->_parseDate(Request::get('start_date'))->format('Y');
				break;
			case ReportType::MONTHLY:
				$fields['view_mode']  = "months";
				$fields['format']     = "MM/YYYY";
				$fields['start_date'] = $this->_parseDate(Request::get('start_date'))->format('m/Y');
				break;
			case ReportType::DAILY:
			default:
				$fields['view_mode']  = "days";
				$fields['format']     = "DD/MM/YYYY";
				$fields['start_date'] = $this->_parseDate(Request::get('start_date'))->format('d/m/Y');
				break;
		}
		
		return $fields;
	}
	
	private function _parseDate($date)
	{
		$result = Carbon::now();
		
		if ( ! empty($date)) {
			switch (strlen($date))
			{
				case 4:
					$result = Carbon::createFromFormat("Y", $date);
					break;
				case 7:
					$result = Carbon::createFromFormat("m/Y", $date);
					break;
				case 10:
				default:
					$result = Carbon::createFromFormat("d/m/Y", $date);
					break;
			}
		}
		
		return $result;
	}
	
}
