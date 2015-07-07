<?php namespace Dodona\Models;

/**
 * Alert Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * Alert class.
 *
 * Maps the alerts table.
 */
class Alert extends Model
{
    const BLUE  = 'B';
    const GREEN = 'G';
    const AMBER = 'A';
    const RED   = 'R';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'name', ];

    /**
     * Mapped table has no automatic timestamp fields.
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Get the check results of this alert level.
     *
     * @return collection
     */
    public function checkResults()
    {
        return $this->hasMany('Dodona\Models\CheckResult');
    }
    
    /**
     * Get the server check results of this alert level.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasManyThrough('Dodona\Models\ServerCheckResult', 'Dodona\Models\CheckResult');
    }
}
