<?php

namespace Dodona\Models;

use Dodona\Interfaces\Enablable;
use Dodona\Traits\AreaStatusTrait;
use Dodona\Traits\EnablableTrait;
use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model implements Enablable
{
    use EnablableTrait;

    use AreaStatusTrait;

    /**
     * Get whether the site is refreshed manually, auto, or both.
     *
     * @return array
     */
    public function refreshed()
    {
        $result = [
            'manual' => 0,
            'auto'   => 0,
        ];

        foreach ($this->enabledChildren() as $child)
        {
            $result['manual'] += $child->refreshed()['manual'];
            $result['auto']   += $child->refreshed()['auto'];
        }

        return $result;
    }
    
}
