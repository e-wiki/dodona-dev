<?php

namespace Dodona;

use Illuminate\Database\Eloquent\Model;

class Environment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'environments';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name'];
    
    /**
     * No timestamp columns.
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * The sites belonging to an environment.
     *
     * @return collection
     */
    public function sites()
    {
        return $this->hasMany('Dodona\Site');
    }
}
