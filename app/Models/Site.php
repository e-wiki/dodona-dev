<?php namespace Dodona\Models;

/**
 * Site Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Interfaces\Enablable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Site class.
 *
 * Maps the sites table.
 */
class Site extends Model implements Enablable
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
     * Is the service enabled or not.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->enabled === 1) ? true : false;
    }
    
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
     * Get the environment the site belongs to.
     *
     * @return Environment
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

    /**
     * Get the enabled servers of the service.
     *
     * @return collection
     */
    public function enabledServers()
    {
        return $this->servers()->where('enabled', 1)->get();
    }

    public function refreshed()
    {
        $result = [
            'manual' => 0,
            'auto'   => 0,
        ];

        foreach ($this->enabledServers() as $server)
        {
            $result['manual'] += ( ! $server->auto_refreshed) ? 1 : 0;
            $result['auto']   += (   $server->auto_refreshed) ? 1 : 0;
        }

        return $result;
    }

    /**
     * Get the site's area alert level.
     *
     * @return Alert
     */
    public function areaStatus($check_category_id)
    {
        $result = Alert::find(Alert::BLUE);

        $servers = $this->enabledServers();

        foreach ($servers as $server) {
            $status = $this->_pickStatusArea($server, $check_category_id);

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
     * @return Alert
     */
    public function capacityStatus()
    {
        return $this->areaStatus(CheckCategory::CAPACITY_ID);
    }

    /**
     * Get the service's recoverability status.
     *
     * @return Alert
     */
    public function recoverabilityStatus()
    {
        return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
    }

    /**
     * Get the service's availability status.
     *
     * @return Alert
     */
    public function availabilityStatus()
    {
        return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
    }

    /**
     * Get the service's performance status.
     *
     * @return Alert
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

        $this->service->enable();
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

        foreach ($this->servers as $server) {
            $server->disable();
        }
    }
    
}
