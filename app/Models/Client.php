<?php namespace Dodona\Models;

use Dodona\Models\Client;
use Dodona\Models\Entity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Client model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * Client class.
 *
 * Maps the clients table.
 */
class Client extends Entity
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

    public function refreshed()
    {
        $result = [
            'manual' => 0,
            'auto'   => 0,
        ];

        foreach ($this->enabledServices() as $service)
        {
            $result['manual'] += $service->refreshed()['manual'];
            $result['auto']   += $service->refreshed()['auto'];
        }

        return $result;
    }

}
