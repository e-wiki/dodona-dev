<?php namespace Dodona;

/**
 * Check Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * Check class.
 *
 * Maps the checks table.
 */
class Check extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'id', 'name', 'check_category_id', 'check_module_id' ];

    /**
     * Get the check category of the check.
     *
     * @return Dodona\CheckCategory
     */
    public function checkCategory()
    {
        return $this->belongsTo('Dodona\CheckCategory');
    }
    
    public function checkModule()
    {
        return $this->belongsTo('Dodona\CheckModule');
    }
    
    /**
     * Get the check results of the check.
     *
     * @return collection of Dodona\CheckResult
     */
    public function checkResults()
    {
        return $this->hasMany('Dodona\CheckResult');
    }
}
