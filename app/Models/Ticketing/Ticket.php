<?php namespace Dodona\Models\Ticketing;

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
class Ticket extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tickets';

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
        'user_id',
        'ticket_category_id',
        'ticket_priority_id',
        'ticket_type_id',
        'summary',
        'description',
    ];
    
    public $timestamps = false;
    
    /**
     * Get the user the ticket belongs to.
     * 
     * @return Dodona\Models\User
     */
    public function user()
    {
        return $this->belongsTo('Dodona\Models\Authentication\User');
    }

    /**
     * Get the server check results related to the ticket.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasMany('Dodona\Models\ServerCheckResult');
    }
    
    /**
     * Get the server check result the ticket belongs to.
     * @return Dodona\ServerCheckResult
     */
    public function serverCheckResult()
    {
        return $this->belongsTo('Dodona\Models\ServerCheckResult');
    }
    
    /**
     * Get the category of the ticket.
     *
     * @return Dodona\Models\TicketCategory
     */
    public function ticketCategory()
    {
        return $this->belongsTo('Dodona\Models\Ticketing\TicketCategory');
    }
    
    /**
     * Get the priority of the ticket.
     *
     * @return Dodona\Models\TicketPriority
     */
    public function ticketPriority()
    {
        return $this->belongsTo('Dodona\Models\Ticketing\TicketPriority');
    }
    
    /**
     * Get the type of the ticket.
     *
     * @return Dodona\Models\TicketType
     */
    public function ticketType()
    {
        return $this->belongsTo('Dodona\Models\Ticketing\TicketType');
    }
    
    /**
     * Get the server the ticket belongs to.
     *
     * @return Dodona\Models\Server
     */
    public function server()
    {
        return $this->serverCheckResult()->getResults()->server;
    }
}
