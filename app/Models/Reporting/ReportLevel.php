<?php namespace Dodona\Models\Reporting;

use Illuminate\Database\Eloquent\Model;

class ReportLevel extends Model
{
    const CLIENT_LEVEL  = 'Client';
    const SERVICE_LEVEL = 'Service';
    const SITE_LEVEL    = 'Site';
    const SERVER_LEVEL  = 'Server';

    const CLIENT_LEVEL_ID  = 1;
    const SERVICE_LEVEL_ID = 2;
    const SITE_LEVEL_ID    = 3;
    const SERVER_LEVEL_ID  = 4;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Get the reports associated with the level.
     *
     * @return collection
     */
    public function reports()
    {
        return $this->hasMany('Dodona\Models\Reporting\Report');
    }
}
