<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class BillModel extends Model
{

    protected $table = 'bill_items';

    protected $primaryKey="id";
    protected $guarded = ['id'];
    public $timestamps = false;
       public function userDetails(){
            return $this->belongsTo('App\User', "Created_by","fund");
        }

}
