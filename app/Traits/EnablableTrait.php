<?php

namespace Dodona\Traits;

trait EnablableTrait
{

    /**
     * Is the entity enabled or not.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Enable the entity.
     */
    public function enable()
    {
        $this->enabled = true;
        $this->save();

        $this->owner()->enable();
    }

    /**
     * Disable the entity and children.
     */
    public function disable()
    {
        $this->enabled = false;
        $this->save();

        foreach ($this->enabledChildren() as $child)
        {
            $child->disable();
        }
    }

}
