<?php
namespace Dodona\Models;

/**
 * Client model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Interfaces\Enablable;
use Dodona\Interfaces\Owner;
use Dodona\Models\Client;
use Dodona\Models\Entity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Client class.
 *
 * Maps the clients table.
 */
class Client extends Entity implements Enablable, Owner
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'clients';

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
    protected $fillable = ['id', 'name', 'enabled', 'description'];

    /**
     * Get all enabled clients.
     *
     * @return collection
     */
    public static function getEnabled()
    {
        return Client::where('enabled', 1)->get();
    }
    
    /**
     * Get the services of the client.
     *
     * @return collection
     */
    public function services()
    {
        return $this->hasMany('Dodona\Models\Service');
    }
    
    /**
     * Get the enabled services of the client.
     *
     * @return collection
     */
    public function enabledServices()
    {
        return $this->services()->where('enabled', 1)->get();
    }

    /**
     * Enable the entity.
     */
    public function enable()
    {
        $this->enabled = true;
        $this->save();
    }

    public function children()
    {
        return $this->services;
    }

    public function enabledChildren()
    {
        return $this->enabledServices();
    }

    /**
     * Get the sites of the client.
     *
     * @return collection
     */
    public function sites()
    {
        return $this->hasManyThrough('Dodona\Models\Site', 'Dodona\Models\Service');
    }
    
    /**
     * Get the servers of the client.
     *
     * @return Collection
     */
    public function servers()
    {
        $result = new Collection;
        
        foreach ($this->sites as $site) {
            foreach ($site->servers as $server) {
                $result->push($server);
            }
        }
        
        return $result;
    }

}
