<?php namespace Dodona;

/**
 * Database Technology Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * DatabaseTechnology class.
 *
 * Maps the database_technologies table.
 */
class DatabaseTechnology extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * Get servers with this database technology.
     *
     * @return collection of Dodona\Server
     */
    public function servers()
    {
        return $this->hasMany('Dodona\Server');
    }
    
    /**
     * No timestamp columns.
     *
     * @var boolean
     */
    public $timestamps = false;
}
