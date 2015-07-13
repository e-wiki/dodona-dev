<?php namespace Dodona\Models;

use Dodona\Interfaces\Enablable;
use Dodona\Interfaces\Refreshable;
use Dodona\Models\LatestServerCheckResult;
use Dodona\Models\ServerCheckResult;
use Dodona\Models\Site;
use Dodona\Models\Status\CheckCategory;
use Dodona\Models\Support\Alert;
use Dodona\Models\Support\DatabaseTechnology;
use Dodona\Models\Support\OperatingSystem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

/**
 * Server model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * Server class.
 *
 * Maps the servers table.
 */
class Server extends Model implements Enablable, Refreshable
{
    use SoftDeletes;
    
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
     * Is the server enabled or not.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->enabled === 1);
    }
    
    /**
     * Get the service the server belongs to.
     *
     * @return Service
     */
    public function service()
    {
        return $this->site()->getResults()->service;
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
     * Get the latest server's check results.
     *
     * @return ServerCheckResult
     */
    public function latestServerCheckResults($check_category_id = null)
    {
        $checks = DB::table('v_latest_server_check_results')
                ->where('server_id', $this->id)
                ->orderBy('check_id', 'asc')
                ->get();
        
        $results = new Collection;
        foreach ($checks as $check) {
            $latest_server_check_result = $this->_returnCategoryCheckResult($check, $check_category_id);
            if (! is_null($latest_server_check_result)) {
                $results->push($latest_server_check_result);
            }
        }
        
        return $results;
    }
    
    /**
     * Return latest server check result if matching category id.
     *
     * @param type $check
     * @param type $check_category_id
     * @return LatestServerCheckResult
     */
    private function _returnCategoryCheckResult($check, $check_category_id = null)
    {
        $result = null;
        
        if (!empty($check_category_id)) {
            if ($check->check_category_id === $check_category_id) {
                $result = new LatestServerCheckResult(( array ) $check, true);
            }
        } else {
            $result = new LatestServerCheckResult(( array ) $check, true);
        }
        
        return $result;
    }
    
    /**
     * Get the server's area alert level.
     *
     * @return Dodona\Models\Support\Alert
     */
    public function areaStatus($area_id)
    {
        $checks = $this->latestServerCheckResults($area_id);
        
        $result = $this->_initializeAreaResult(count($checks));
        
        foreach ($checks as $check) {
            if ($check->checkResult->check->checkCategory->id === $area_id
                    and $check->checkResult->alert->id === Alert::RED) {
                $result = Alert::find(Alert::RED);

                break;
            }

            if ($check->checkResult->check->checkCategory->id === $area_id
                    and $check->checkResult->alert->id === Alert::AMBER) {
                $result = Alert::find(Alert::AMBER);
            }
        }
        
        return $result;
    }
    
    /**
     * Get the server's capacity status.
     *
     * @return Dodona\Models\Support\Alert
     */
    public function capacityStatus()
    {
        return $this->areaStatus(CheckCategory::CAPACITY_ID);
    }
    
    /**
     * Get the server's recoverability status.
     *
     * @return Dodona\Models\Support\Alert
     */
    public function recoverabilityStatus()
    {
        return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
    }
    
    /**
     * Get the server's availability status.
     *
     * @return Dodona\Models\Support\Alert
     */
    public function availabilityStatus()
    {
        return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
    }
    
    /**
     * Get the server's performance status.
     *
     * @return Dodona\Models\Support\Alert
     */
    public function performanceStatus()
    {
        return $this->areaStatus(CheckCategory::PERFORMANCE_ID);
    }

    /**
     * Initialise the result for the areaStatus.
     *
     * @param integer $count
     * @return Dodona\Models\Support\Alert
     */
    private function _initializeAreaResult($count)
    {
        $result = Alert::find(Alert::BLUE);
        
        if ($count > 0) {
            $result = Alert::find(Alert::GREEN);
        }
        
        return $result;
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
    
    /**
     * Enable the server, its service, and its client.
     */
    public function enable()
    {
        $this->enabled = true;
        $this->save();
        
        $this->service()->enable();
    }
    
    /**
     * Disable the server.
     */
    public function disable()
    {
        $this->enabled = false;
        $this->save();
    }

    public function isAutoRefreshed()
    {
        return $this->auto_refreshed;
    }

    public function autoRefresh()
    {
        $this->auto_refreshed = true;
        $this->save();
    }

    public function manualRefresh()
    {
        $this->auto_refreshed = false;
        $this->save();
    }
}
