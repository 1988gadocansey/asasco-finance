<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class FeePaymentModel extends Model
{
    //use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'feepayrecord';
    //protected static $logAttributes = ['stuId', 'paid','worker','year'.'term'];
    protected $primaryKey="id";
    protected $guarded = ['id'];
    //public $timestamps = false;
    public function student(){
        return $this->belongsTo('App\Models\StudentModel', "stuId","indexNo");
    }
    public function account(){
        return $this->belongsTo('App\Models\BankModel', "bank","accountno");
    }
    public function staff(){
        return $this->belongsTo('App\Models\WorkerModel', "worker","emp_number");
    }
    public function bankdetails(){
        return $this->belongsTo('App\Models\BankModel', "bank","id");
    }


}
