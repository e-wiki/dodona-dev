<?php namespace Dodona\Models;

/**
 * Service model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Models\Alert;
use Dodona\Models\CheckCategory;
use Dodona\Interfaces\Enablable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Service class.
 *
 * Maps the services table.
 */
class Service extends Model implements Enablable
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
    protected $fillable = ['id', 'name', 'enabled', 'description', 'client_id'];

    /**
     * Is the service enabled or not.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->enabled === 1) ? true : false;
    }
    
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
     * @return Dodona\Models\Client
     */
    public function client()
    {
        return $this->belongsTo('Dodona\Models\Client');
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
     * Get the enabled servers of the service.
     *
     * @return collection
     */
    public function enabledSites()
    {
        return $this->sites()->where('enabled', 1)->get();
    }
    
    /**
     * Get the service's area alert level.
     *
     * @return Dodona\Models\Alert
     */
    public function areaStatus($check_category_id)
    {
        $result = Alert::find(Alert::BLUE);
        
        $sites = $this->enabledSites();
        
        foreach ($sites as $site) {
            $status = $this->_pickStatusArea($site, $check_category_id);
            
            if ($status->id === Alert::RED) {
                $result = Alert::find(Alert::RED);
                
                break;
            }
            
            if ($status->id === Alert::AMBER) {
                $result = Alert::find(Alert::AMBER);
            }
            
            if ($status->id === Alert::GREEN && $result->id === Alert::BLUE) {
                $result = Alert::find(Alert::GREEN);
            }
        }
        
        return $result;
    }
    
    /**
     * Returns the status area result depending on the check category id.
     *
     * @param Server $server
     * @param char $check_category_id
     * @return char
     */
    private function _pickStatusArea($server, $check_category_id)
    {
        switch ($check_category_id) {
            case CheckCategory::CAPACITY_ID:
                return $server->capacityStatus();
            case CheckCategory::RECOVERABILITY_ID:
                return $server->recoverabilityStatus();
            case CheckCategory::AVAILABILITY_ID:
                return $server->availabilityStatus();
            case CheckCategory::PERFORMANCE_ID:
                return $server->performanceStatus();
            default:
                return Alert::BLUE;
        }
    }
    
    /**
     * Get the service's capacity status.
     *
     * @return Dodona\Models\Alert
     */
    public function capacityStatus()
    {
        return $this->areaStatus(CheckCategory::CAPACITY_ID);
    }
    
    /**
     * Get the service's recoverability status.
     *
     * @return Dodona\Models\Alert
     */
    public function recoverabilityStatus()
    {
        return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
    }
    
    /**
     * Get the service's availability status.
     *
     * @return Dodona\Models\Alert
     */
    public function availabilityStatus()
    {
        return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
    }
    
    /**
     * Get the service's performance status.
     *
     * @return Dodona\Models\Alert
     */
    public function performanceStatus()
    {
        return $this->areaStatus(CheckCategory::PERFORMANCE_ID);
    }
    
    /**
     * Enable the service and its client.
     *
     * @return void
     */
    public function enable()
    {
        $this->enabled = true;
        $this->save();
        
        $this->client->enable();
    }
    
    /**
     * Disable the service, and its servers.
     *
     * @return void
     */
    public function disable()
    {
        $this->enabled = false;
        $this->save();
        
        foreach ($this->sites as $site) {
            $site->disable();
        }
    }

    public function refreshed()
    {
        $result = [
            'manual' => 0,
            'auto'   => 0,
        ];

        foreach ($this->sites as $site)
        {
            $result['manual'] += $site->refreshed()['manual'];
            $result['auto']   += $site->refreshed()['auto'];
        }

        return $result;
    }

}
