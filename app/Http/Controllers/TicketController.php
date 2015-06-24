<?php
/**
 * Ticket Controller.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

namespace Dodona\Http\Controllers;

use Carbon\Carbon;

use Dodona\Http\Requests;
use Dodona\Http\Controllers\Controller;
use Dodona\Http\Requests\TicketRequest;
use Dodona\Server;
use Dodona\ServerCheckResult;
use Dodona\Ticket;
use Dodona\TicketCategory;
use Dodona\TicketPriority;
use Dodona\TicketType;

use Illuminate\Http\Request;

/**
 * Handles thes tickets for the Dodona Framework.
 */
class TicketController extends Controller
{
    
	/**
	 * Loads the ticket page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function show($id = NULL)
	{
		$ticket              = Ticket::find($id);
		$server              = Server::find($ticket->serverCheckResult->server_id);
		$service             = $server->service();
		$client              = $service->client;
		$server_check_result = ServerCheckResult::find($ticket->server_check_result_id);
		
		return view('ticket.show', compact('client', 'service', 'server', 'server_check_result', 'ticket'));
	}
    
	
	/**
	 * Loads the ticket creation page.
	 * 
	 * @param unsigned integer $id
	 * @return string
	 */
	public function create($id)
	{
		$server_check_result = ServerCheckResult::find($id);
		$server              = Server::find($server_check_result->server->id);
		$service             = $server->service();
		$client              = $service->client;
		
		return view('ticket.create', [
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
	public function store(TicketRequest $request)
	{
		$ticket = Ticket::create([
			'server_check_result_id' => $request->get('server_check_result_id'),
			'raised_at'              => Carbon::now(),
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
    
}
