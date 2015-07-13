<?php namespace Dodona\Models;

/**
 * Server Check Result Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * ServerCheckResult class.
 *
 * Maps the server_check_results table.
 */
class ServerCheckResult extends Model
{
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
        'id',
        'server_id',
        'check_result_id',
        'check_id',
        'raised_at',
        'new_alert',
        'ticket_id',
    ];
    
    public $timestamps = false;
    
    /**
     * Get the server the server result belongs to.
     *
     * @return Dodona\Models\Server
     */
    public function server()
    {
        return $this->belongsTo('Dodona\Models\Server');
    }
    
    /**
     * Get the check result.
     *
     * @return Dodona\Models\Status\CheckResult
     */
    public function checkResult()
    {
        return $this->belongsTo('Dodona\Models\Status\CheckResult');
    }
    
    /**
     * Get the check the server result belongs to.
     *
     * @return Dodona\Models\Status\Check
     */
    public function check()
    {
        return $this->belongsTo('Dodona\Models\Status\Check');
    }

    /**
     * Get the server result's parent.
     *
     * @return Dodona\Models\ServerCheckResult
     */
    public function serverCheckResult()
    {
        return $this->belongsTo('Dodona\Models\ServerCheckResult');
    }
    
    /**
     * Get the server results owned by this server result.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasMany('Dodona\Models\ServerCheckResult');
    }
        
    /**
     * Get the server's check result ticket.
     *
     * @return Dodona\Models\Ticketing\Ticket
     */
    public function ticket()
    {
        return $this->hasOne('Dodona\Models\Ticketing\Ticket');
    }
}
