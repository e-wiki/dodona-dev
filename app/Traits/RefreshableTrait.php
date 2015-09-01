<?php

namespace Dodona\Traits;

trait RefreshableTrait
{

    /**
     * 
     * 
     * @return array
     */
    public function isAutoRefreshed()
    {
        return $this->auto_refreshed;
    }

    public function refreshed()
    {
        $result['manual'] = $this->isAutoRefreshed() ? 0 : 1;
        $result['auto']   = $this->isAutoRefreshed() ? 1 : 0;

        return $result;
    }

    public function autoRefresh()
    {
        $this->auto_refreshed = true;
        $this->save();
    }

    public function manualRefresh()
    {
        $this->auto_refreshed = false;
        $this->save();
    }
}
