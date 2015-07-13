<?php namespace Dodona\Models\Ticketing;

/**
 * Ticket Category Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * TicketCategory class.
 *
 * Maps the ticket_categories table.
 */
class TicketCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    public $timestamps = false;
    
    /**
     * Get tickets of this category.
     *
     * @return collection
     */
    public function tickets()
    {
        return $this->hasMany('Dodona\Models\Ticketing\Ticket');
    }

    /**
     * Get the server results of this category.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasManyThrough('Dodona\Models\ServerCheckResult', 'Dodona\Models\Ticketing\Ticket');
    }
}
