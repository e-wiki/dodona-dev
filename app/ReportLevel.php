<?php namespace Dodona;

use Illuminate\Database\Eloquent\Model;

class ReportLevel extends Model {

	const CLIENT_LEVEL  = 'Client';
	const SERVICE_LEVEL = 'Service';
	const SITE_LEVEL    = 'Site';
	const SERVER_LEVEL  = 'Server';
	
	/**
	 * Indicates if the model should be timestamped.
	 * 
	 * @var bool
	 */
	public $timestamps = false;
	
	/**
	 * Get the reports associated with the level.
	 * 
	 * @return collection of Dodona\Report
	 */
	public function reports()
	{
		return $this->hasMany('Dodona\Report');
	}

}
