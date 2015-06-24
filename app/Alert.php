<?php namespace Dodona;
/**
 * Alert Model.
 * 
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;

/**
 * Alert class.
 * 
 * Maps the alerts table.
 */
class Alert extends Model {
	
	const BLUE  = 'B';
	const GREEN = 'G';
	const AMBER = 'A';
	const RED   = 'R';
	
	/**
	 * The attributes that are mass assignable.
	 * 
	 * @var array
	 */
	protected $fillable = [ 'id', 'name', ];
	
	public $timestamps = false;

	/**
	 * Get the check results of this alert level.
	 * @return collection of Dodona\CheckResult
	 */
	public function checkResults()
	{
		return $this->hasMany('Dodona\CheckResult');
	}
	
	/**
	 * Get the server check results of this alert level.
	 * 
	 * @return collection of Dodona\ServerCheckResults
	 */
	public function serverCheckResults()
	{
		return $this->checkResults()->getResults()->serverCheckResults;
	}

}
