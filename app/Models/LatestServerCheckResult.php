<?php namespace Dodona\Models;

use Dodona\Models\Server;
use Dodona\Models\ServerCheckResult;
use Dodona\Models\Status\Check;
use Dodona\Models\Status\CheckResult;
use Dodona\Models\Ticketing\Ticket;
use Illuminate\Database\Eloquent\Model;

/**
 * Latest Server Check Result Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * LatestServerCheckResult class.
 *
 * Maps the v_latest_server_check_results view.
 */
class LatestServerCheckResult extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_latest_server_check_results';

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

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['raised_at'];
    
    public $timestamps = false;
    
    /**
     * Get the server the server result belongs to.
     *
     * @return Server
     */
    public function server()
    {
        return $this->belongsTo('Dodona\Models\Server');
    }
    
    /**
     * Get the check result.
     *
     * @return CheckResult
     */
    public function checkResult()
    {
        return $this->belongsTo('Dodona\Models\Status\CheckResult');
    }
    
    /**
     * Get the check the server result belongs to.
     *
     * @return Check
     */
    public function check()
    {
        return $this->belongsTo('Dodona\Models\Status\Check');
    }

    /**
     * Get the server result's parent.
     *
     * @return ServerCheckResult
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
     * @return Ticket
     */
    public function ticket()
    {
        return $this->hasOne('Dodona\Models\Ticketing\Ticket');
    }
}
