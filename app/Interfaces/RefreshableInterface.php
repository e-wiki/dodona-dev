<?php

namespace Dodona\Interfaces;

interface Refreshable {

    public function isAutoRefreshed();
    
    public function autoRefresh();
    
    public function manualRefresh();
    
}