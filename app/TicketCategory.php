<?php namespace Dodona;

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
     * @return collection of Dodona\Ticket
     */
    public function tickets()
    {
        return $this->hasMany('Dodona\Ticket');
    }
}
