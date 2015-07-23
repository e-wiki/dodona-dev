<?php namespace Dodona\Models\Authentication;

use Sentinel\Models\User as SentinelUser;

/**
 * Alert Model.
 *
 * @author  Nikolaos Gaitanis <ngaitanis@gmail.com>
 * @version 1.0.0
 * @copyright (c) 2015, Nikolaos Gaitanis
 */

/**
 * Alert class.
 *
 * Maps the alerts table.
 */
class User extends SentinelUser
{

    /**
     * Concatenates first and last name.
     * 
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

}
