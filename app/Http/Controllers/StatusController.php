<?php namespace Dodona\Http\Controllers;
/**
 * Status Controller.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\CheckCategory;
use Dodona\Client;
use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\TicketRequest;
use Dodona\Server;
use Dodona\ServerCheckResult;
use Dodona\Service;

use Illuminate\Support\Facades\Request;

/**
 * Handles the status capabilities of the Dodona Framework.
 */
class StatusController extends Controller {

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
	public function client($id = NULL)
	{
		if (is_null($id))
		{
			return redirect('status');
		}
		
		$client   = Client::find($id);
		
		return view('status.client', compact('client'));
	}
	
	/**
	 * Loads the service status page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function service($id = NULL)
	{
		if (is_null($id))
		{
			return redirect('status');
		}
		
		$service = Service::find($id);
		$client  = $service->client;
		
		return view('status.service', compact('client', 'service'));
	}
	
	/**
	 * Loads the server status page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function server($id = NULL)
	{
		if (is_null($id))
		{
			return redirect('status');
		}
		
		$server           = Server::find($id);
		$service          = $server->service();
		$client           = $service->client;
		$checks           = $server->latestServerCheckResults();
		$check_categories = CheckCategory::all();
		
		return view('status.server', compact('client', 'service', 'server', 'checks', 'check_categories'));
	}

}
