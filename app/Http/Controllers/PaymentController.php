<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeeModel;
use App\Models\FeePaymentModel;
use App\Models\StudentModel; 
use App\Models\ReceiptModel; 
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
 
class PaymentController extends Controller
{
    
      public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }
    /**
     * Create a new controller instance.
     *
     
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

         
    }
    public function printLostReceipt(Request $request , FeeController $feeController, SystemController $sys) {
        if ($request->isMethod("get")) {

            return view('finance.fees.printLostReceipt') ;
                           
             
        } 
       else{
        $receiptno=$request->input('receipt');
        
        $payment_transaction =FeePaymentModel::where("RECEIPTNO",
			$receiptno)->first();

		if (empty($payment_transaction)) {
			abort(434, "No payment transaction with this receipt <span class='uk-text-bold uk-text-large'>$receiptno</span>");
		}

		$words= $feeController->convert($payment_transaction->AMOUNT);
               
                $receipt=$payment_transaction->RECEIPTNO;
		if ($payment_transaction->PAYMENTTYPE =="Transcript Order") {
                    
                    $url = url("printreceiptTranscript/".trim($receipt));
                        $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                        $request->session()->flash("success",
			"Payment successfully   $print_window");
                        return redirect("/students");
                
			 
		 }
		elseif ($payment_transaction->PAYMENTTYPE =="Resit"){
			 
		}
                else{
        
                 
                  $url = url("printreceipt/".trim($receipt));
                  
                          $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                $request->session()->flash("success",
                "Payment successfully   $print_window");
                return redirect("/students");
                }
       }
    }
    public function new_receiptno(){
        $receiptno_query = Models\Receiptno::first();
		$receiptno_query->increment("receiptno", 1);
        $receiptno = str_pad($receiptno_query->receiptno, 12, "0", STR_PAD_LEFT);
		
        return $receiptno;
        
    }
    
    public function pad_receiptno($receiptno){
       return str_pad($receiptno, 12, "0", STR_PAD_LEFT);
       }
         public function payments( Request $request,  FeeController $control, SystemController $sys) {
               
        //$user = @\Auth::user()->id;
        
            $fee = FeePaymentModel::query();
         

        if ($request->has('mode') && trim($request->input('mode')) != "") {
            // dd($request);
            $fee->where('PAYMENTDETAILS', "=", $request->input("mode", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $fee->where("LEVEL", $request->input("level", ""));
        }
        if ($request->has('bank') && trim($request->input('bank')) != "") {
            $fee->where("BANK", '=', $request->input("bank", ""));
        }
        if ($request->has('indexno') && trim($request->input('indexno')) != "") {
            $fee->where("INDEXNO", '=', $request->input("indexno", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $fee->where("YEAR", "=", $request->input("year", ""));
        }
        if ($request->has('type') && trim($request->input('type'))) {
            $fee->where("PAYMENTTYPE", "=", $request->input('type'));
        }
        if ($request->has('users') && trim($request->input('users'))) {
            $fee->where("RECIEPIENT", "=", $request->input('users'));
        }
        if ($request->has('program') && trim($request->input('program'))) {
            $fee->where("PROGRAMME", "=", $request->input('program'));
        }
        if ($request->has('from_date') && $request->has('to_date')) {
            //$fee->whereBetween('TRANSDATE', [$request->input('from_date'), $request->input('to_date')]);
            $fee->whereBetween(\DB::raw('TRANSDATE'), array($request->input('from_date'), $request->input('to_date')));
        }
        if ($request->has('filter') && trim($request->input('filter')) != "" && $request->input('amount') != "") {
            $filter = $request->input('filter');
            $amount = $request->input('amount');
            if ($filter == '=') {
                $fee->where("AMOUNT", $amount);
            } else {
                $fee->where("AMOUNT", "$filter", $amount);
                // dd($request);
            }
        }

        $data = $fee->orderBy('TRANSDATE', 'DESC')->paginate(800000);

        $request->flashExcept("_token");
        \Session::put('students', $data);

        foreach ($data as $key => $row) {

            $t[] = $row->AMOUNT;
            $data[$key]->TOTALS = @array_sum($t);
        }

        $totals = @$sys->formatMoney($data[$key]->TOTALS);
        return view('finance.fees.transactions')->with("data", $data)
                        ->with('program', $sys->getProgramList())
                        ->with('year', $control->years())
                        ->with('bank', $control->banks())
                        ->with('users', $sys->getUsers())
                        ->with('total', $totals);
    }
    /**
     *  
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        
        return view('finance.fees.ledger');
    }
     public function anyData(Request $request)
    {
         
        $fees =  FeePaymentModel::select(['ID','BANK','AMOUNT','LEVEL','FEE_TYPE','INDEXNO','TRANSDATE','TRANSACTION_ID','RECEIPTNO','SEMESTER','YEAR','PAYMENTTYPE','PAYMENTDETAILS'])->get();


        return Datatables::of($fees)
          
            
            ->setRowId('id')
            ->setRowClass(function ($fee) {
               // return $fee->ID % 2 == 0 ? 'uk-text-success uk-text-bold' : 'uk-text-warning uk-text-bold';
            })
            ->setRowData([
                'id' => 'test',
            ])
            ->setRowAttr([
                'color' => 'red',
            ])
                  
            ->make(true);
             
            //flash the request so it can still be available to the view or search form and the search parameters shown on the form 
      //$request->flash();
    }
    
     public function showPayform(){
         return view('finance.fees.payfee');
    }
    public function showStudent(Request $request, FeeController $feeController,SystemController $sys)
    {
        $student=  explode(',',$request->input('q'));
        $student=$student[0];
        
        $sql= StudentModel::where("INDEXNO",$student)->get();
        //dd($sql);
         if(count($sql)==0){
      
          return redirect("/pay_transcript")->with("error","<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
          }
          else{
               
              $array=$sys->getSemYear();
              $sem=$array[0]->SEMESTER;
              $year=$array[0]->YEAR;
               return view("finance.ePayments.processTranscript")->with( 'data',$sql)->with('year',$year)->with('sem',$sem)->with('banks', $feeController->banks())->with('receipt', $feeController->getReceipt());
      
          }
    }
     public function processTranscript(Request $request, SystemController $sys, FeeController $feeController){
        
               
              $array=$sys->getSemYear();
              $sem=$array[0]->SEMESTER;
              $year=$array[0]->YEAR;
              $phone=$request->input('phone');
              $user = \Auth::user()->id;
              $feetype = "Transcript order";
                  
                  
                   
                    $receipt=$request->input('receipt');
                    $indexno=$request->input('student');
                    $copy=$request->input('copy');
                    $price=$request->input('price');
                    $amount=$copy * $price;
                    $program=$request->input('programme');
                    $level=$request->input('level');
                     $feeLedger=new FeePaymentModel();
                $feeLedger->INDEXNO=$indexno;
                $feeLedger->PROGRAMME=$program;
                $feeLedger->AMOUNT=$amount;
                 
                $feeLedger->PROGRAMME=$program;
                $feeLedger->LEVEL=$level;
                $feeLedger->RECIEPIENT=$user;
                 $feeLedger->PAYMENTTYPE="Transcript Order";
                $feeLedger->RECEIPTNO=$receipt;
                $feeLedger->YEAR=$year;
                $feeLedger->FEE_TYPE=$feetype;
                $feeLedger->SEMESTER=$sem;
                $feeLedger->NO_COPIES=$copy;
                if($feeLedger->save()){
                   $message="Hi $indexno you have just paid GHC$amount as transcript printing fee";
                    if($sys->firesms($message, $phone, $indexno)){
                     
                       
                     
                     } 
                      $feeController->updateReceipt();
                     $url = url("printreceiptTranscript/".trim($receipt));
                        $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                        $request->session()->flash("success",
			"Payment successfully   $print_window");
                        return redirect("/pay_transcript");
                }else{
                    \DB::rollBack();
                 redirect()->back()->with('error','Error processing payment') ;
                            
                 
                }
               
            
    }
    public function printreceipt(Request $request, $receiptno) {

		// $this->show_query();

		$transaction = FeePaymentModel::where("RECEIPTNO", $receiptno)->with("student", "bank"
                )->first();
        
        if (empty($transaction)) {
            abort(434, "No Fee payment   with this receipt <span class='uk-text-bold uk-text-large'>{{$receiptno}}</span>");
        }

        $words= $this->convert($transaction->AMOUNT);

         
      

        return view("finance.fees.receipt")->with("transaction", $transaction)->with('words',$words);
        
        
        }
      public function printreceiptTranscript(Request $request, $receiptno, FeeController $feeController) {

		// $this->show_query();

		$transaction = FeePaymentModel::where("RECEIPTNO", $receiptno)->with("student", "bank"
                )->first();
        
        if (empty($transaction)) {
            abort(434, "No Transcript payment   with this receipt <span class='uk-text-bold uk-text-large'>{{$receiptno}}</span>");
        }

        $words= $feeController->convert($transaction->AMOUNT);

              
               return view("finance.ePayments.transcriptReceipt")->with("transaction", $transaction)->with('words',$words);
     
         
        
        }
     
     
     
     
     
    
         
	 
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request)
    {
         $query = FeeModel::where('ID',$request->input("id"))->delete();
         
         if ($query) {
             \Session::flash("success", "<span style='font-weight:bold;font-size:13px;'> Fee  </span>successfully deleted!");

             return redirect()->route("view_fees");
        }
    }
}
