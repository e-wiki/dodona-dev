<?php namespace Dodona;
/**
 * Client model.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Dodona\Alert;
use Dodona\CheckCategory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * Client class.
 * 
 * Maps the clients table.
 */
class Client extends Model {
	
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
	 * @return collection of Dodona\Client
	 */
	static public function getEnabled()
	{
		return Client::where('enabled', 1)->get();
	}
	
	/**
	 * Get the services of the client.
	 * 
	 * @return collection of Dodona\Service
	 */
	public function services()
	{
		return $this->hasMany('Dodona\Service');
	}
	
	/**
	 * Get the enabled services of the client.
	 * 
	 * @return colleciton of Dodona\Service
	 */
	public function enabledServices()
	{
		return $this->services()->where('enabled', 1)->get();
	}
	
	/**
	 * Get the sites of the client.
	 * 
	 * @return collection of Dodona\Site
	 */
	public function sites()
	{
		return $this->hasManyThrough('Dodona\Site', 'Dodona\Service');
	}
	
	/**
	 * Get the servers of the client.
	 * 
	 * @return Collection
	 */
	public function servers()
	{
		$result = new Collection;
		
		foreach ($this->sites as $site)
		{
			foreach ($site->servers as $server)
			{
				$result->push($server);
			}
		}
		
		return $result;
	}
	
	/**
	 * Get the client's area alert level.
	 * 
	 * @return Dodona\Alert
	 */
	public function areaStatus($check_category_id)
	{
		$result = Alert::find(Alert::BLUE);
		
		$services = $this->enabledServices();
		
		foreach ($services as $service)
		{
			$status = $this->_pickStatusArea($service, $check_category_id);
			
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
	 * @param Dodona\Service $service
	 * @param char $check_category_id
	 * @return char
	 */
	private function _pickStatusArea($service, $check_category_id)
	{
		switch ($check_category_id)
		{
			case CheckCategory::CAPACITY_ID:
				return $service->capacityStatus();
			case CheckCategory::RECOVERABILITY_ID:
				return $service->recoverabilityStatus();
			case CheckCategory::AVAILABILITY_ID:
				return $service->availabilityStatus();
			case CheckCategory::PERFORMANCE_ID:
				return $service->performanceStatus();
			default:
				return Alert::BLUE;
		}
	}
	
	/**
	 * Get the client's capacity status.
	 * 
	 * @return Dodona\Alert
	 */
	public function capacityStatus()
	{
		return $this->areaStatus(CheckCategory::CAPACITY_ID);
	}
	
	/**
	 * Get the client's recoverability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function recoverabilityStatus()
	{
		return $this->areaStatus(CheckCategory::RECOVERABILITY_ID);
	}
	
	/**
	 * Get the client's availability status.
	 * 
	 * @return Dodona\Alert
	 */
	public function availabilityStatus()
	{
		return $this->areaStatus(CheckCategory::AVAILABILITY_ID);
	}
	
	/**
	 * Get the client's performance status.
	 * 
	 * @return Dodona\Alert
	 */
	public function performanceStatus()
	{
		return $this->areaStatus(CheckCategory::PERFORMANCE_ID);
	}
	
	/**
	 * Disable the client and its services.
	 */
	public function disable()
	{
		$this->enabled = false;
		$this->save();
		
		foreach ($this->services as $service)
		{
			$service->disable();
		}
	}
	
}
