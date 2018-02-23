<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransactions extends Model {
	//
	protected $table = "students_ledger";

	protected $guarded = array('id');

	public function studentDetails() {
		return $this->belongsTo('App\Models\RegistrationCard', "Registration_No", "Registration_No");
	}

    public function students() {
        return $this->hasMany('App\Models\RegistrationCard', "Registration_No", "Registration_No");
    }
    public function bankdetails(){
        return $this->belongsTo('App\Models\BankModel', "bank","id");
    }



}
