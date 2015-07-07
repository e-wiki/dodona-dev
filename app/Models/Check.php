<?php namespace Dodona\Models;

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
     * Get the category the check belongs to.
     *
     * @return Dodona\Models\CheckCategory
     */
    public function checkCategory()
    {
        return $this->belongsTo('Dodona\Models\CheckCategory');
    }

    /**
     * Get the module the check belongs to.
     *
     * @return Dodona\Models\CheckModule
     */
    public function checkModule()
    {
        return $this->belongsTo('Dodona\Models\CheckModule');
    }
    
    /**
     * Get the check results of the check.
     *
     * @return collection
     */
    public function checkResults()
    {
        return $this->hasMany('Dodona\Models\CheckResult');
    }

    /**
     * Get the server check results of the check.
     * 
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasManyThrough('Dodona\Models\ServerCheckResult', 'Dodona\Models\CheckResult');
    }
}
