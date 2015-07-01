<?php namespace Dodona;

/**
 * Latest Server Check Result Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * LatestServerCheckResult class.
 *
 * Maps the v_latest_server_check_results view.
 */
class LatestServerCheckResult extends Model
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

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'v_latest_server_check_results';
    
    public $timestamps = false;
    
    /**
     * Get the server the server result belongs to.
     *
     * @return Dodona\Server
     */
    public function server()
    {
        return $this->belongsTo('Dodona\Server');
    }
    
    /**
     * Get the check result.
     *
     * @return Dodona\CheckResult
     */
    public function checkResult()
    {
        return $this->belongsTo('Dodona\CheckResult');
    }
    
    /**
     * Get the check the server result belongs to.
     *
     * @return Dodona\Check
     */
    public function check()
    {
        return $this->belongsTo('Dodona\Check');
    }

    /**
     * Get the server result's parent.
     *
     * @return Dodona\ServerCheckResult
     */
    public function serverCheckResult()
    {
        return $this->belongsTo('Dodona\ServerCheckResult');
    }
    
    /**
     * Get the server results owned by this server result.
     *
     * @return collection of Dodona\ServerCheckResult
     */
    public function serverCheckResults()
    {
        return $this->hasMany('Dodona\ServerCheckResult');
    }
        
    /**
     * Get the server's check result ticket.
     *
     * @return Dodona\Ticket
     */
    public function ticket()
    {
        return $this->hasOne('Dodona\Ticket');
    }
}
