<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class StudentModel extends Model
{
   // use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'student';
    // protected static $logAttributes = ['currentClass', 'indexno','programme','name'];
    protected $primaryKey="ID";
    protected $guarded = ['ID'];
    public $timestamps = false;
    public function programme(){
        return $this->hasMany('App\Models\ProgrammeModel', "code","programme");
    }
    public function program(){
        return $this->belongsTo('App\Models\ProgrammeModel',"programme","code");
    }
     
}
