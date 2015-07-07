<?php namespace Dodona\Models;

/**
 * Site Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Site class.
 *
 * Maps the sites table.
 */
class Site extends Model
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
    protected $fillable = [
        'id',
        'name',
        'description',
        'service_id',
        'environment_id'
    ];
    
    /**
     * Get the service that owns the site.
     *
     * @return Dodona\Models\Service
     */
    public function service()
    {
        return $this->belongsTo('Dodona\Models\Service');
    }
    
    /**
     * Get the environment the site belongs to.
     *
     * @return Dodona\Models\Environment
     */
    public function environment()
    {
        return $this->belongsTo('Dodona\Models\Environment');
    }
    
    /**
     * Get the servers of the site.
     *
     * @return collection
     */
    public function servers()
    {
        return $this->hasMany('Dodona\Models\Server');
    }
}
