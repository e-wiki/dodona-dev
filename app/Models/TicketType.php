<?php namespace Dodona\Models;

/**
 * Ticket Type Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * TicketPriority class.
 *
 * Maps the ticket_priorities table.
 */
class TicketType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];
    
    public $timestamps = false;

    /**
     * Get tickets of this priority.
     *
     * @return collection
     */
    public function tickets()
    {
        return $this->hasMany('Dodona\Models\Ticket');
    }

    /**
     * Get the server results of this type.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasManyThrough('Dodona\Models\ServerCheckResult', 'Dodona\Models\Ticket');
    }
}
