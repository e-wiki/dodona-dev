<?php namespace Dodona\Models\Reporting;

use Illuminate\Database\Eloquent\Model;

class ReportType extends Model
{
    const DAILY   = 1;
    const MONTHLY = 3;
    const YEARLY  = 4;
    const CUSTOM  = 5;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * Get the reports associated with the type.
     *
     * @return collection
     */
    public function reports()
    {
        return $this->hasMany('Dodona\Models\Reporting\Report');
    }
}
