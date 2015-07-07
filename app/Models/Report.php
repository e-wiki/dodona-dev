<?php namespace Dodona\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Get the level of the report.
     *
     * @return Dodona\Models\ReportLevel
     */
    public function level()
    {
        return $this->belongsTo('Dodona\Models\ReportLevel');
    }
    
    /**
     * Get the type of the report.
     *
     * @return Dodona\Models\ReportType
     */
    public function type()
    {
        return $this->belongsTo('Dodona\Models\ReportType');
    }
}
