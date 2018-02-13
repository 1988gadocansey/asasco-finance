<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProgrammeModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'programme';
    
    protected $primaryKey="id";
    protected $guarded = ['id','code'];
    public $timestamps = false;
    public function departments(){
        return $this->hasMany('App\Models\DepartmentModel', "deptCode","deptCode");
    }
     
    public function students() {
    return $this->belongsTo('App\Models\StudentModel', "programme","code");
  
    }
    
     
}
