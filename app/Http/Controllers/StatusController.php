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
use Dodona\Http\Requests\CreateTicketRequest;
use Dodona\Server;
use Dodona\ServerCheckResult;
use Dodona\Service;
use Dodona\Ticket;
use Dodona\TicketCategory;
use Dodona\TicketPriority;
use Dodona\TicketType;

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
	
	/**
	 * Loads the ticket creation page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function createTicket($id = NULL)
	{
		if (is_null($id))
		{
			return redirect('status');
		}
		
		$server_check_result = ServerCheckResult::find($id);
		$server              = Server::find($server_check_result->server->id);
		$service             = $server->service();
		$client              = $service->client;
		
		return view('status.ticket.create', [
			'client'              => $client,
			'service'             => $service,
			'server'              => $server,
			'server_check_result' => $server_check_result,
			'ticket_categories'   => TicketCategory::lists('name', 'id'),
			'ticket_priorities'   => TicketPriority::lists('name', 'id'),
			'ticket_priority'     => (($server_check_result->checkResult->alert->id === 'R') ? 2 : 3),
			'ticket_types'        => TicketType::lists('name', 'id'),
			'reference'           => $server->id . $server_check_result->check_result_id . date('YmdHis', strtotime($server_check_result->raised_at)),
		]);
	}
	
	/**
	 * Stores the ticket and returns to the server status page.
	 * 
	 * @return void
	 */
	public function storeTicket(CreateTicketRequest $request)
	{
		echo 'In _storeTicket';
		$ticket = Ticket::create([
			'server_check_result_id' => $request->get('server_check_result_id'),
			'raised_at'              => date('Y-m-d H:i:s'),
			'reference'              => $request->get('reference'),
			'ticket_category_id'     => $request->get('ticket_category_id'),
			'ticket_priority_id'     => $request->get('ticket_priority_id'),
			'ticket_type_id'         => $request->get('ticket_type_id'),
			'summary'                => $request->get('summary'),
			'description'            => $request->get('description'),
		]);
		
		$server_check_result = ServerCheckResult::find($request->get('server_check_result_id'));
		$server_check_result->ticket_id = $ticket->id;
		$server_check_result->save();
		foreach ($server_check_result->serverCheckResults as $child)
		{
			$child->ticket_id = $ticket->id;
			$child->save();
		}
		
		return redirect('status/server/' . $request->get('server_id'));
	}
	
	/**
	 * Loads the ticket page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function showTicket($id = NULL)
	{
		if (is_null($id))
		{
			return redirect('status');
		}
		
		$ticket              = Ticket::find($id);
		$server              = Server::find($ticket->serverCheckResult->server_id);
		$service             = $server->service();
		$client              = $service->client;
		$server_check_result = ServerCheckResult::find($ticket->server_check_result_id);
		
		return view('status.ticket.show', compact('client', 'service', 'server', 'server_check_result', 'ticket'));
	}

}
