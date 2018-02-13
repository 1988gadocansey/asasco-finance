<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models;
use Illuminate\Http\Request;

class PaymentProductController extends Controller {

	public $assets_load_list = array("Bill Payment" => "loadcustomers", "eVoucher" => "loadevouchers", "eTicket" => "loadetickets");
	public $assets_view_list = array("Bill Payment" => "viewbillassets", "eVoucher" => "viewevoucherassets", "eTicket" => "vieweticketassets");

    
    
    public function show_query() {

		\DB::listen(function ($sql, $binding, $timing) {
			print_r("<pre>");
			var_dump($sql);
			var_dump($binding);
		}
		);
	}
    
    
	public function add_params_to_product_search($request, $query) {
		if ($request->has('search')) {
			$search = $request["search"];
			//using the query closure and passing the $search to it allows laravel to create a subquery that encompasses the orWhere queries in one bracket
			$query->where(function ($query) use ($search) {
				$query->orWhere("payment_name", "like", "%$search%");
				$query->orWhere("account_no", "like", "%$search%");
				$query->orWhere("payment_info", "like", "%$search%");
				$query->orWhere("usage_instruction", "like", "%$search%");
			});

		}

		if ($request->has('deadline') && $request->has('submit')) {
			$query->where("deadline", $request["deadline"]);
		}

		return $query;
	}

	public function add_params_to_serials_assets_search($request, $query) {
		if ($request->has('date1')) {
			$query->where("date_sold", ">=", $request["date1"]);
		}
		if ($request->has('date2')) {
			$query->where("date_sold", "<=", $request["date2"]);
		}

		if ($request->has('search')) {
			$search = $request["search"];
			$query->where(function ($query) use ($search) {				
				$query->orWhere("pin", "like", "%$search%");
				$query->orWhere("status", "like", "%$search%");
				$query->orWhere("receiptno", "like", "%$search%");
				$query->orWhere("name", "like", "%$search%");
				$query->orWhere("phone", "like", "%$search%");
				$query->orWhere("email", "like", "%$search%");
			});
		}

		return $query;
	}

	public function view_billpayment(Request $request) {

		$query = Models\PaymentProduct::where(\DB::raw("lower(purpose)"), "like", "bill payment%");
		$query = $this->add_params_to_product_search($request, $query);

		$paymentproducts = $query->orderBy("dates", "desc")->paginate(50);
		$request->flash();
		return view('payments.viewpaymentproducts')->with("paymentproducts", $paymentproducts)->with("assets_load_list", $this->assets_load_list)->with("assets_view_list", $this->assets_view_list)->with("search_url", "viewbillpayment");
	}

	public function view_products(Request $request) {

		$query = Models\PaymentProduct::query();
		$query = $this->add_params_to_product_search($request, $query);

		$paymentproducts = $query->orderBy("purpose", "asc")
                ->orderBy("payment_name", "asc")->paginate(50);
		$request->flash();
		return view('payments.viewpaymentproducts')->with("paymentproducts", $paymentproducts)->with("assets_load_list", $this->assets_load_list)->with("assets_view_list", $this->assets_view_list)->with("search_url", "viewbillpayment");
	}

	public function view_evouchers(Request $request) {

		$query = Models\PaymentProduct::where(\DB::raw("lower(purpose)"), "like", "evoucher%");
		$query = $this->add_params_to_product_search($request, $query);

		$paymentproducts = $query->orderBy("dates", "desc")->paginate(50);
		$request->flash();
		return view('payments.viewpaymentproducts')->with("paymentproducts", $paymentproducts)->with("assets_load_list", $this->assets_load_list)->with("assets_view_list", $this->assets_view_list)->with("search_url", "viewevouchers");
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	

	public function view_evoucher_assets(Request $request, $product_id) {		
	
        $query = Models\Evouchers::where("product_id", $product_id);
 
		$query = $this->add_params_to_serials_assets_search($request, $query);
        //add serial to query since etickets have serial and pin
        $query->orWhere(function($query)use($request){
            $query->orWhere("serial", "like", '%'.$request["search"].'%');
        });

		$paymentproducts = $query->orderBy("date_sold", "desc")->orderBy("receiptno", "asc")
                            ->with("product_info")->paginate(50);

		$request->flash();        
        
		return view('payments.evoucherassets')->with("paymentproducts", $paymentproducts)
                ->with("product_id",$product_id);
	}
    
    
    public function view_eticket_assets(Request $request, $product_id) {
        
		$query = Models\Etickets::where("product_id", $product_id);
         
		$query = $this->add_params_to_serials_assets_search($request, $query);        

		$paymentproducts = $query->orderBy("date_sold", "desc")->orderBy("receiptno", "asc")->with("product_info")->paginate(50);

		$request->flash();        
        
		return view('payments.eticketassets')->with("paymentproducts", $paymentproducts)->with("product_id",$product_id);
	}
    
    
     public function view_billpayment_assets(Request $request, $product_id) {
        
		$query = Models\BillCustomers::where("product_id", $product_id);
         
//		if ($request->has('date1')) {
//			$query->where("date_sold", ">=", $request["date1"]);
//		}
//		if ($request->has('date2')) {
//			$query->where("date_sold", "<=", $request["date2"]);
//		}

		if ($request->has('search')) {
			$search = $request["search"];
			$query->where(function ($query) use ($search) {
				$query->orWhere("indexno", "like", "%$search%");
				$query->orWhere("program", "like", "%$search%");
				$query->orWhere("level", "like", "%$search%");				
				$query->orWhere("name", "like", "%$search%");
				$query->orWhere("phone", "like", "%$search%");				
			});
		}

		$paymentproducts = $query->orderBy("lastpaid", "desc")->orderBy("name", "asc")->with("product_info")->paginate(50);

		$request->flash();        
        
		return view('payments.billpaymentassets')->with("paymentproducts", $paymentproducts)->with("product_id",$product_id);
	}
    

	public function createPaymentItem(Request $request) {
		//$purposes = Models\Purpose::lists("purpose", "purpose");
		$paymentproduct = new \stdClass;
		return view('ePayments.addProducts')->with("paymentproduct", $paymentproduct);

	}

	public function save_product(Requests\PaymentProductRequest $request) {
		// $paymentproduct = new \stdClass;
		$paymentproduct = new Models\PaymentProduct();

		$paymentproduct->purpose = $request["purpose"];
		$paymentproduct->payment_name = $request["payment_name"];
		$paymentproduct->account_no = $request["account_no"];
		$paymentproduct->deadline = $request["deadline"];
		$paymentproduct->payment_info = $request["payment_info"];
		$paymentproduct->accept_part_payment = $request["accept_part_payment"];
		$paymentproduct->currency = $request["currency"];
		$paymentproduct->default_value = $request["default_value"];
		$paymentproduct->payment_period = $request["payment_period"];
        $paymentproduct->cot = $request["cot"];
		$paymentproduct->usage_instruction = $request["usage_instruction"];

		if (!$paymentproduct->save()) {
			return redirect("createproduct")->withErrors()->withInput()->with("errors", array("Error!Unable to save payment product"));
		}

		return redirect("viewproduct/" . $paymentproduct->id)->with("messages", array("Successfully saved Payment Product, $paymentproduct->payment_name"));

	}
    
    public function view_product(Request $request, $id) {
		$paymentproduct = Models\PaymentProduct::where("id", $id)->firstOrFail();
		$purposes = Models\Purpose::lists("purpose", "purpose");

		return view('payments.paymentproductform')->with("paymentproduct", $paymentproduct)->with("purposes", $purposes);

	}
    
    public function update_product(Requests\PaymentProductRequest $request,$id) {
		// $paymentproduct = new \stdClass;
//		$paymentproduct = new Models\PaymentProduct();
        $paymentproduct = Models\PaymentProduct::where("id", $id)->firstOrFail();
        
		$paymentproduct->purpose = $request["purpose"];
		$paymentproduct->payment_name = $request["payment_name"];
		$paymentproduct->account_no = $request["account_no"];
		$paymentproduct->deadline = $request["deadline"];
		$paymentproduct->payment_info = $request["payment_info"];
		$paymentproduct->accept_part_payment = $request["accept_part_payment"];
		$paymentproduct->currency = $request["currency"];
		$paymentproduct->default_value = $request["default_value"];
		$paymentproduct->payment_period = $request["payment_period"];
        $paymentproduct->cot = $request["cot"];
		$paymentproduct->usage_instruction = $request["usage_instruction"];

		if (!$paymentproduct->save()) {
			return redirect("viewproduct/" . $paymentproduct->id)->withInput()->withErrors( array("Error!Unable to update payment product  $paymentproduct->payment_name"));
		}
        
        return redirect("viewproduct/" . $paymentproduct->id)->with("messages", array("Successfully updated Payment Product, $paymentproduct->payment_name"));

	}

}

