<?php namespace Dodona\Models\Support;

/**
 * Operating System Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * OperatingSystem class.
 *
 * Maps the operating_systems table.
 */
class OperatingSystem extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    
    /**
     * Get servers with this operating system.
     *
     * @return collection
     */
    public function servers()
    {
        return $this->hasMany('Dodona\Models\Server');
    }
    
    /**
     * No timestamp columns.
     *
     * @var boolean
     */
    public $timestamps = false;
}
