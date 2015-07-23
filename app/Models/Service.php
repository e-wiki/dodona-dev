<?php namespace Dodona\Models;

use Dodona\Models\Client;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Service model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * Service class.
 *
 * Maps the services table.
 */
class Service extends Entity
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'services';

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
    protected $fillable = ['id', 'name', 'enabled', 'description', 'client_id'];
    
    /**
     * Get all enabled services.
     *
     * @return collection
     */
    public static function getEnabled()
    {
        return Service::where('enabled', 1)->get();
    }
    
    /**
     * Get the client that owns the service.
     *
     * @return Client
     */
    public function client()
    {
        return $this->belongsTo('Dodona\Models\Client');
    }

    public function owner()
    {
        return $this->client;
    }

    public function children()
    {
        return $this->sites;
    }
    
    /**
     * Get the sites of the service.
     *
     * @return collection
     */
    public function sites()
    {
        return $this->hasMany('Dodona\Models\Site');
    }
    
    /**
     * Get the servers of the service.
     *
     * @return collection
     */
    public function servers()
    {
        return $this->hasManyThrough('Dodona\Models\Server', 'Dodona\Models\Site');
    }

    /**
     * Get the check module of the service.
     *
     * @return Dodona\Models\Status\CheckModule
     */
    public function checkModules()
    {
        return $this->hasOne('Dodona\Models\Status\CheckModule');
    }

    /**
     * Get the enabled servers of the service.
     *
     * @return collection
     */
    public function enabledSites()
    {
        return $this->sites()->where('enabled', 1)->get();
    }

    public function enabledChildren()
    {
        return $this->enabledSites();
    }

}
