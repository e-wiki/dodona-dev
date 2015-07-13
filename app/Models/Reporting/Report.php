<?php namespace Dodona\Models\Reporting;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Get the level of the report.
     *
     * @return Dodona\Models\Reporting\ReportLevel
     */
    public function level()
    {
        return $this->belongsTo('Dodona\Models\Reporting\ReportLevel');
    }
    
    /**
     * Get the type of the report.
     *
     * @return Dodona\Models\Reporting\ReportType
     */
    public function type()
    {
        return $this->belongsTo('Dodona\Models\Reporting\ReportType');
    }
}
