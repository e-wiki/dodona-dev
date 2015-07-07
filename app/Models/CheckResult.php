<?php namespace Dodona\Models;

/**
 * Check Result Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CheckResult class.
 *
 * Maps the check_results table.
 */
class CheckResult extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'name', 'check_id', 'alert_id' ];
    
    /**
     * Get the check the result belongs to.
     *
     * @return Dodona\Models\Check
     */
    public function check()
    {
        return $this->belongsTo('Dodona\Models\Check');
    }
    
    /**
     * Get the alert the check result belongs to.
     *
     * @return Dodona\Models\Alert
     */
    public function alert()
    {
        return $this->belongsTo('Dodona\Models\Alert');
    }
    
    /**
     * Get the server check results for this check result.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasMany('Dodona\Models\ServerCheckResult');
    }

    /**
     * Get the tickets for this check result.
     * 
     * @return collection
     */
    public function tickets()
    {
        return $this->hasManyThrough('Dodona\Models\Ticket', 'Dodona\Models\ServerCheckResult');
    }
}
