<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransactions extends Model {
	//
	protected $table = "payment_transactions";

	protected $guarded = array('id');

	public function evoucher_info() {
		return $this->hasMany('App\Models\Evouchers', "receiptno", "receiptno");
	}

	public function eticket_info() {
		return $this->hasMany('App\Models\Etickets', "receiptno", "receiptno");
	}

	public function product_info() {
		return $this->hasMany('App\Models\PaymentProduct', "id", "product_id");
	}

	public function company_info() {
		return $this->hasMany('App\Models\Company', "code", "company_id");
	}

	public function bill_customer_info() {
		return $this->hasMany('App\Models\BillCustomers', "indexno", "client_id");
	}

	public function voucher_customer_info() {
		return $this->hasMany('App\Models\VoucherCustomers', "receiptno", "receiptno");
	}

	public function ticket_customer_info() {
		return $this->hasMany('App\Models\TicketsCustomers', "receiptno", "receiptno");
	}

	public function serials_customer_info() {
		return $this->hasMany('App\Models\SerialsCustomers', "receiptno", "receiptno");
	}

}
