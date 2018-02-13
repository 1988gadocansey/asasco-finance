<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;


class FeePaymentModel extends Model
{
     use LogsActivity;
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tpoly_feedetails';
     protected static $logAttributes = ['INDEXNO', 'AMOUNT','YEAR','SEMESTER'];
    protected $primaryKey="ID";
    protected $guarded = ['ID'];
    public $timestamps = false;
   public function student(){
        return $this->belongsTo('App\Models\StudentModel', "INDEXNO","INDEXNO");
    }
     public function bank(){
        return $this->belongsTo('App\Models\BankModel', "BANK","ID");
    }
     
     
}
