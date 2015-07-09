<?php namespace Dodona\Models;

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
class User extends \Sentinel\Models\User
{

    public function getFullNameAttribute()
    {
        return $this->attributes['first_name'] . ' ' . $this->attributes['last_name'];
    }

}
