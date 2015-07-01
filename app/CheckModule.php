<?php namespace Dodona;

/**
 * Check Module Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CheckModule class.
 *
 * Maps the check_modules table.
 */
class CheckModule extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name' ];
    
    /**
     * Get the checks for this module.
     *
     * @return collection
     */
    public function checks()
    {
        return $this->hasMany('Dodona\Check');
    }
    
    /**
     * Get the check results for this module.
     *
     * @return collection
     */
    public function checkResults()
    {
        return $this->hasManyThrough('Dodona\CheckResult', 'Dodona\Check');
    }
}
