<?php namespace Dodona;
/**
 * Server model.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Alert;
use Dodona\LatestServerCheckResult;

use DB;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Server class.
 * 
 * Maps the servers table.
 */
class Server extends Model {
	
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
		'enabled',
		'description',
		'service_id',
		'site_id',
		'operating_system_id',
		'database_technology_id',
		'automatic_checks',
	];

	/**
	 * Is the server enabled or not.
	 * 
	 * @return boolean
	 */
	public function isEnabled()
	{
		return ($this->enabled === 1) ? TRUE : FALSE;
	}
	
	/**
	 * Get the service the server belongs to.
	 * 
	 * @return Dodona\Service
	 */
	public function service()
	{
		return $this->site()->getResults()->service;
	}
	
	/**
	 * Get the site the server belongs to.
	 * 
	 * @return Dodona\Site
	 */
	public function site()
	{
		return $this->belongsTo('Dodona\Site');
	}
	
	/**
	 * Get the operating system of the server.
	 * 
	 * @return Dodona\OperatingSystem
	 */
	public function operatingSystem()
	{
		return $this->belongsTo('Dodona\OperatingSystem');
	}
	
	/**
	 * Get the database technology of the server.
	 * 
	 * @return Dodona\DatabaseTechnology
	 */
	public function databaseTechnology()
	{
		return $this->belongsTo('Dodona\DatabaseTechnology');
	}
	
	/**
	 * Get the server's check results.
	 * 
	 * @return collection of Dodona\ServerCheckResult
	 */
	public function serverCheckResults()
	{
		return $this->hasMany('Dodona\ServerCheckResult');
	}
	
	/**
	 * Get the latest server's check results.
	 * 
	 * @return \Dodona\ServerCheckResult
	 */
	public function latestServerCheckResults($check_category_id = NULL)
	{
		$checks = DB::table('v_latest_server_check_results')
				->where('server_id', $this->id)
				->orderBy('check_id', 'asc')
				->get();
		
		$results = new Collection;
		foreach ($checks as $check)
		{
			$latest_server_check_result = $this->_returnCategoryCheckResult($check, $check_category_id);
			if ( ! is_null($latest_server_check_result))
			{
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
	private function _returnCategoryCheckResult($check, $check_category_id = NULL)
	{
		$result = NULL;
		
		if (!empty($check_category_id))
		{
			if ($check->check_category_id === $check_category_id)
			{
				$result = new LatestServerCheckResult( ( array ) $check, true );
			}
		}
		else
		{
			$result = new LatestServerCheckResult( ( array ) $check, true );
		}
		
		return $result;
	}
	
	/**
	 * Get the server's area alert level.
	 * 
	 * @return Dodona\Alert
	 */
	public function areaStatus($area_id)
	{
		$checks = $this->latestServerCheckResults($area_id);
		
		$result = $this->_initializeAreaResult(count($checks));
		
		foreach ($checks as $check)
		{
			if ($check->checkResult->check->checkCategory->id === $area_id
					and $check->checkResult->alert->id === Alert::RED)
			{
				$result = Alert::find(Alert::RED);

				break;
			}

			if ($check->checkResult->check->checkCategory->id === $area_id
					and $check->checkResult->alert->id === Alert::AMBER)
			{
				$result = Alert::find(Alert::AMBER);
			}
		}
		
		return $result;
	}
	
	/**
	 * Get the server's capacity status.
	 * 
	 * @return Dodona\Alert
	 */
	public function capacityStatus()
	{
		return $this->areaStatus(CheckCategory::CAPACITY_ID);
	}
	
	/**
	 * Get the server's recoverability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function recoverabilityStatus()
	{
		return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
	}
	
	/**
	 * Get the server's availability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function availabilityStatus()
	{
		return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
	}
	
	/**
	 * Get the server's performance status.
	 * 
	 * @return Dodona\Alert
	 */
	public function performanceStatus()
	{
		return $this->areaStatus(CheckCategory::PERFORMANCE_ID);
	}

	/**
	 * Initialise the result for the areaStatus.
	 * 
	 * @param integer $count
	 * @return Dodona\Alert
	 */
	private function _initializeAreaResult($count)
	{
		if ($count > 0)
		{
			$result = Alert::find(Alert::GREEN);
		}
		else
		{
			$result = Alert::find(Alert::BLUE);
		}
		
		return $result;
	}
	
	/**
	 * Get the server's tickets.
	 * 
	 * @return collection of Dodona\Ticket
	 */
	public function tickets()
	{
		return $this->hasManyThrough('Dodona\Ticket', 'Dodona\ServerCheckResult');
	}
	
	/**
	 * Enable the server, its service, and its client.
	 */
	public function enable()
	{
		$this->enabled = TRUE;
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

}
