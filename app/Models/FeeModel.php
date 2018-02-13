<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class FeeModel extends Model
{
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpoly_fees';
    
    protected $primaryKey="ID";
    protected $guarded = ['ID'];
    
   public function program(){
        return $this->belongsTo('App\Models\ProgrammeModel', "PROGRAMME","ID");
    }
}
