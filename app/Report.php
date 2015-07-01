<?php namespace Dodona;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    /**
     * Get the level of the report.
     *
     * @return Dodona\ReportLevel
     */
    public function level()
    {
        return $this->belongsTo('Dodona\ReportLevel');
    }
    
    /**
     * Get the type of the report.
     *
     * @return Dodona\ReportType
     */
    public function type()
    {
        return $this->belongsTo('Dodona\ReportType');
    }
}
