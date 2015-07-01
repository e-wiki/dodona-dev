<?php namespace Dodona;

/**
 * Check Category Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * CheckCategory class.
 *
 * Maps the check_categories.
 */
class CheckCategory extends Model
{
    const CAPACITY_ID       = 'C';
    const RECOVERABILITY_ID = 'R';
    const AVAILABILITY_ID   = 'A';
    const PERFORMANCE_ID    = 'P';
    
    const CAPACITY       = 'Capacity';
    const RECOVERABILITY = 'Recoverability';
    const AVAILABILITY   = 'Availability';
    const PERFORMANCE    = 'Performance';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'name' ];
    
    public $timestamps = false;

    /**
     * Get the checks of this category.
     *
     * @return collection of Dodona\Check
     */
    public function checks()
    {
        return $this->hasMany('Dodona\Check');
    }
    
    /**
     * Get the check results of this category.
     *
     * @return collection of Dodona\CheckResult
     */
    public function checkResults()
    {
        return $this->hasManyThrough('Dodona\CheckResult', 'Dodona\Check');
    }
}
