<?php namespace Dodona\Models;

/**
 * Site Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Models\Entity;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Support\Alert;
use Dodona\Models\Support\Environment;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Site class.
 *
 * Maps the sites table.
 */
class Site extends Entity
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'sites';

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
     * @return Service
     */
    public function service()
    {
        return $this->belongsTo('Dodona\Models\Service');
    }

    /**
     * Get the parent service of the site.
     *
     * @return Dodona\Models\Entity
     */
    public function owner()
    {
        return $this->service;
    }

    public function children()
    {
        return $this->servers;
    }

    /**
     * Get the environment the site belongs to.
     *
     * @return Environment
     */
    public function environment()
    {
        return $this->belongsTo('Dodona\Models\Support\Environment');
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

    /**
     * Get the enabled servers of the site.
     *
     * @return collection
     */
    public function enabledServers()
    {
        return $this->servers()->where('enabled', 1)->get();
    }

    /**
     * Get the enabled servers of the site.
     *
     * @return collection
     */
    public function enabledChildren()
    {
        return $this->enabledServers();
    }
    
}
