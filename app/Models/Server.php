<?php

namespace Dodona\Models;

/**
 * Server model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Interfaces\Child;
use Dodona\Interfaces\Enablable;
use Dodona\Interfaces\Refreshable;
use Dodona\Models\Entity;
use Dodona\Models\ServerCheckResult;
use Dodona\Models\Service;
use Dodona\Models\Site;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Support\Alert;
use Dodona\Models\Support\DatabaseTechnology;
use Dodona\Models\Support\OperatingSystem;
use Dodona\Traits\RefreshableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Server class.
 *
 * Maps the servers table.
 */
class Server extends Entity implements Enablable, Refreshable, Child
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'servers';
    
    use RefreshableTrait, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'enabled',
        'auto_refreshed',
        'description',
        'service_id',
        'site_id',
        'operating_system_id',
        'database_technology_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Disable the server.
     */
    public function disable()
    {
        $this->enabled = false;
        $this->save();
    }

    /**
     * Get the service the server belongs to.
     *
     * @return Service
     */
    public function service()
    {
        return $this->site->service;
    }
    
    /**
     * Get the site the server belongs to.
     *
     * @return Site
     */
    public function site()
    {
        return $this->belongsTo('Dodona\Models\Site');
    }
    
    /**
     * Get the operating system of the server.
     *
     * @return OperatingSystem
     */
    public function operatingSystem()
    {
        return $this->belongsTo('Dodona\Models\Support\OperatingSystem');
    }
    
    /**
     * Get the database technology of the server.
     *
     * @return DatabaseTechnology
     */
    public function databaseTechnology()
    {
        return $this->belongsTo('Dodona\Models\Support\DatabaseTechnology');
    }
    
    /**
     * Get the server's check results.
     *
     * @return collection
     */
    public function serverCheckResults()
    {
        return $this->hasMany('Dodona\Models\ServerCheckResult');
    }

    /**
     * Get the server's tickets.
     *
     * @return collection
     */
    public function tickets()
    {
        return $this->hasManyThrough('Dodona\Models\Ticketing\Ticket', 'Dodona\Models\ServerCheckResult');
    }

    public function owner()
    {
        return $this->site;
    }
    
    /**
     * Get the latest server's check results.
     *
     * @return ServerCheckResult
     */
    public function latestServerCheckResults()
    {
        return $this->hasMany('Dodona\Models\LatestServerCheckResult');
    }

    /**
     *
     * @param CheckCategory $check_category
     * @return type
     */
    public function latestCategoryServerCheckResults(CheckCategory $check_category)
    {
        return count($this->latestServerCheckResults()->where('check_category_id', $check_category->id)->get());
    }
    
    /**
     * Get the server's area alert level.
     *
     * @param CheckCategory $check_category
     * @return Alert
     */
    public function areaStatus(CheckCategory $check_category)
    {
        $checks = $this->latestServerCheckResults()->where('check_category_id', $check_category->id)->get();

        $result = $this->initializeAreaResult(count($checks));
        
        foreach ($checks as $check) {
            if ($check->checkResult->alert->id === Alert::RED) {
                $result = Alert::find(Alert::RED);

                break;
            }

            if ($check->checkResult->alert->id === Alert::AMBER) {
                $result = Alert::find(Alert::AMBER);
            }
        }
        
        return $result;
    }

    /**
     * Initialise the result for the areaStatus.
     *
     * @param integer $count
     * @return Alert
     */
    private function initializeAreaResult($count)
    {
        $result = Alert::find(Alert::BLUE);
        
        if ($count > 0) {
            $result = Alert::find(Alert::GREEN);
        }
        
        return $result;
    }

    public function getAlerts($alert_id)
    {
        return $this->serverCheckResults()
            ->whereNull('server_check_result_id')
            ->where('alert_id', $alert_id);
    }

    public function getRedAlerts()
    {
        return $this->getAlerts(Alert::RED);
    }

    public function getAmberAlerts()
    {
        return $this->getAlerts(Alert::AMBER);
    }
    
}
