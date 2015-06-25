<?php namespace Dodona;
/**
 * Service model.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Alert;
use Dodona\CheckCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Service class.
 * 
 * Maps the services table.
 */
class Service extends Model {
	
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
	 * @return collection of Dodona\Service
	 */
	static public function getEnabled()
	{
		return Service::where('enabled', 1)->get();
	}
	
	/**
	 * Get the client that owns the service.
	 * 
	 * @return Dodona\Client
	 */
	public function client()
	{
		return $this->belongsTo('Dodona\Client');
	}
	
	/**
	 * Get the sites of the service.
	 * 
	 * @return collection of Dodona\Site
	 */
	public function sites()
	{
		return $this->hasMany('Dodona\Site');
	}
	
	/**
	 * Get the servers of the service.
	 * 
	 * @return collection of Dodona\Server
	 */
	public function servers()
	{
		return $this->hasManyThrough('Dodona\Server', 'Dodona\Site');
	}
	/**
	 * Get the enabled servers of the service.
	 * 
	 * @return collection of Dodona\Server
	 */
	public function enabledServers()
	{
		return $this->servers()->where('enabled', 1)->get();
	}
	
	/**
	 * Get the service's area alert level.
	 * 
	 * @return Dodona\Alert
	 */
	public function areaStatus($check_category_id)
	{
		$result = Alert::find(Alert::BLUE);
		
		$servers = $this->enabledServers();
		
		foreach ($servers as $server)
		{
			$status = $this->_pickStatusArea($server, $check_category_id);
			
			if ($status->id === Alert::RED)
			{
				$result = Alert::find(Alert::RED);
				
				break;
			}
			
			if ($status->id === Alert::AMBER)
			{
				$result = Alert::find(Alert::AMBER);
			}
			
			if ($status->id === Alert::GREEN && $result->id === Alert::BLUE)
			{
				$result = Alert::find(Alert::GREEN);
			}
		}
		
		return $result;
	}
	
	/**
	 * Returns the status area result depending on the check category id.
	 * 
	 * @param Dodona\Server $server
	 * @param char $check_category_id
	 * @return char
	 */
	private function _pickStatusArea($server, $check_category_id)
	{
		switch ($check_category_id)
		{
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
	 * @return Dodona\Alert
	 */
	public function capacityStatus()
	{
		return $this->areaStatus(CheckCategory::CAPACITY_ID);
	}
	
	/**
	 * Get the service's recoverability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function recoverabilityStatus()
	{
		return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
	}
	
	/**
	 * Get the service's availability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function availabilityStatus()
	{
		return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
	}
	
	/**
	 * Get the service's performance status.
	 * 
	 * @return Dodona\Alert
	 */
	public function performanceStatus()
	{
		return $this->areaStatus(CheckCategory::PERFORMANCE_ID);
	}
	
	/**
	 * Disable the service, and its servers.
	 */
	public function disable()
	{
		$this->enabled = false;
		$this->save();
		
		foreach ($this->servers as $server)
		{
			$server->disable();
		}
	}

}
