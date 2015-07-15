<?php namespace Dodona\Models\Status;

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
    protected $fillable = [
        'id',
        'name',
        'check_category_id',
        'check_module_id'
    ];

    /**
     * Get the category the check belongs to.
     *
     * @return Dodona\Models\Status\CheckCategory
     */
    public function checkCategory()
    {
        return $this->belongsTo('Dodona\Models\Status\CheckCategory');
    }

    /**
     * Get the module the check belongs to.
     *
     * @return Dodona\Models\Status\CheckModule
     */
    public function checkModule()
    {
        return $this->belongsTo('Dodona\Models\Status\CheckModule');
    }
    
    /**
     * Get the check results of the check.
     *
     * @return collection
     */
    public function checkResults()
    {
        return $this->hasMany('Dodona\Models\Status\CheckResult');
    }

    /**
     * Get the server check results of the check.
     * 
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasManyThrough('Dodona\Models\ServerCheckResult', 'Dodona\Models\Status\CheckResult');
    }
}
