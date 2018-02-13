<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ProtocolModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpoly_protocols';
    
    protected $primaryKey="id";
    protected $guarded = ['id'];
    public $timestamps = false;
     public function student(){
        return $this->belongsTo('App\Models\StudentModel', "student","INDEXNO");
    }
     public function sender(){
        return $this->belongsTo('App\User', "user","id");
    }
      
     
}
