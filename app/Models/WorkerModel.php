<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WorkerModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'staffs';
    
    protected $primaryKey="id";
    protected $guarded = ['id'];
     
    public function departments(){
        return $this->belongsTo('App\Models\DepartmentModel', "department","id");
    }
     
}
