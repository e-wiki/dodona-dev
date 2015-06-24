<?php namespace Dodona;
/**
 * Ticket Model.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * Ticket class.
 * 
 * Maps the tickets table.
 */
class Ticket extends Model {
	
	/**
	 * The attributes that should be mutated to dates.
	 * 
	 * @var array
	 */
	protected $dates = ['raised_at'];
	
	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [
		'server_check_result_id',
		'raised_at',
		'reference',
		'ticket_category_id',
		'ticket_priority_id',
		'ticket_type_id',
		'summary',
		'description',
	];
	
	public $timestamps = false;
	
	/**
	 * Get the server check results related to the ticket.
	 * 
	 * @return collection of Dodona\ServerCheckResult
	 */
	public function serverCheckResults()
	{
		return $this->hasMany('Dodona\ServerCheckResult');
	}
	
	/**
	 * Get the server check result the ticket belongs to.
	 * @return Dodona\ServerCheckResult
	 */
	public function serverCheckResult()
	{
		return $this->belongsTo('Dodona\ServerCheckResult');
	}
	
	/**
	 * Get the category of the ticket.
	 * 
	 * @return Dodona\TicketCategory
	 */
	public function ticketCategory()
	{
		return $this->belongsTo('Dodona\TicketCategory');
	}
	
	/**
	 * Get the priority of the ticket.
	 * 
	 * @return Dodona\TicketPriority
	 */
	public function ticketPriority()
	{
		return $this->belongsTo('Dodona\TicketPriority');
	}
	
	/**
	 * Get the type of the ticket.
	 * 
	 * @return Dodona\TicketType
	 */
	public function ticketType()
	{
		return $this->belongsTo('Dodona\TicketType');
	}
	
	/**
	 * Get the server the ticket belongs to.
	 * 
	 * @return Dodona\Server
	 */
	public function server()
	{
		return $this->serverCheckResult()->getResults()->server;
	}

}
