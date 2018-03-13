<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\FeeModel;
use App\Models\FeePaymentModel;
use App\Models\StudentModel;
use App\Models;
use App\Models\ReceiptModel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;

class FeeController extends Controller
{

    public function log_query()
    {
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

    public function createBill(Request $request, SystemController $sys)
    {
        if (@\Auth::user()->role == 'FO') {

            $this->validate($request, [
                'level' => 'required',
                'amount' => 'required|numeric',
                'program' => 'required',
            ]);
            $array = $sys->getSemYear();

            $year = $array[0]->YEAR;
            $amount = $request->input('amount');
            $level = $request->input('level');
            $program = $request->input('program');
            Models\BillModel::create([
                'LEVEL' => $level,
                'AMOUNT' => $amount,
                'PROGRAMME' => $program,
                'YEAR' => $year
            ]);
            return redirect("/finance/reports/fees/")->with("success", "Bill created successfully");
        } else {
            return redirect("/dashboard");
        }
    }

    public function getTotalPayment($student, $term, $yearr)
    {
        $sys = new SystemController();
        $array = $sys->getSemYear();
        if ($term == "" && $yearr == "") {
            $term = $array[0]->term;
            $yearr = $array[0]->year;
        }

        //$fee = FeePaymentModel::query()->where('year', '=', $yearr)->where('term', $term)->where('stuId', $student)->sum('paid');

        $paid = Models\PaymentTransactions::where("Registration_No", $student)->where("Academic_Year",$yearr)
            ->where("Academic_Term",$term)->where("Transaction_Type","PAYMENT")
            ->where("Item_Status","ACTIVE")->sum("Credit_Amount");

        return $paid;


    }

    public function masterLedger(Request $request, SystemController $sys)
    {

        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $fee = FeePaymentModel::query();

        if ($request->has('class') && trim($request->input('class')) != "") {
            $fee->where("classes", $request->input("class", ""));
        }

        if ($request->has('indexno') && trim($request->input('indexno')) != "") {
            $fee->where("stuId", '=', $request->input("indexno", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $fee->where("year", "=", $request->input("year", ""));
        }


        if ($request->has('type') && trim($request->input('type'))) {
            $fee->where("type", "=", $request->input('type'));
        }
        if ($request->has('paytype') && trim($request->input('paytype'))) {
            $fee->where("paymentType", "=", $request->input('type'));
        }
        $data = $fee->orderBy('created_at', 'DESC')->paginate(2);

        $request->flashExcept("_token");
        \Session::put('students', $data);

        foreach ($data as $key => $row) {
            $a[] = $row->paid;

            $t[] = $this->getTotalPayment($row->stuId, $row->term, $row->year);
            $data[$key]->paid = @array_sum($t);
        }

        $totals = @$sys->formatMoney($data[$key]->paid);
        return view('finance.reports.masterLedger')->with("data", $data)
            ->with('program', $sys->getProgramList())
            ->with('year', $this->years())
            ->with('bank', $this->banks())
            ->with('nationality', $sys->getCountry())

            ->with('religion', $sys->getReligion())
            ->with('region', $sys->getRegions())
            ->with('department', $sys->getDepartmentList())
            ->with('class', $sys->getClassList())
            ->with('house', $sys->getHouseList())
            ->with('total', $totals);

    }

    public function dailyPayments(Request $request, SystemController $sys){
        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $fee = Models\PaymentTransactions::query()->where("Item_Status","ACTIVE");

        if ($request->has('class') && trim($request->input('class')) != "") {
            $fee->where("Currently_In_Class", $request->input("class", ""));
        }

        if ($request->has('indexno') && trim($request->input('indexno')) != "") {
            $fee->where("Registration_No", '=', $request->input("indexno", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
            $fee->where("Academic_Year", "=", $request->input("year", ""));
        }
        if ($request->has('term') && trim($request->input('term')) != "") {
            $fee->where("Academic_Term", "=", $request->input("term", ""));
        }


        if ($request->has('type') && trim($request->input('type'))!="") {
            $fee->where("Payment_Method", "=", $request->input('type'));
        }
        if (($request->has('from_date') && $request->input('to_date'))&&($request->input('from_date')!="" && $request->input('to_date')!="")) {
            //$fee->whereBetween('TRANSDATE', [$request->input('from_date'), $request->input('to_date')]);
            $fee->whereBetween(\DB::raw('created_at'), array($request->input('from_date'), $request->input('to_date')));
        }


        $data = $fee->orderBy('created_at', 'DESC')->paginate(100);

        $request->flashExcept("_token");
        \Session::put('students', $data);

        /*foreach ($data as $key => $row) {
            $a[] = $row->paid;

            $t[] = $this->getTotalPayment($row->Registration_No, $row->Academic_Term, $row->Academic_Year);
            $data[$key]->Credit_Amount = @array_sum($t);
        }*/

        //$totals = @$sys->formatMoney($data[$key]->paid);

        foreach ($data as $key => $row) {

            $t[] = $row->Credit_Amount;
            $data[$key]->TOTALS = @array_sum($t);
        }

        $totals = @$sys->formatMoney($data[$key]->TOTALS);
        return view('finance.reports.transactions')->with("data", $data)
            ->with('program', $sys->getProgramList())
            ->with('year', $this->years())
            ->with('bank', $this->banks())
            ->with('nationality', $sys->getCountry())
            ->with('total', $totals)
            ->with('religion', $sys->getReligion())
            ->with('region', $sys->getRegions())
            ->with('department', $sys->getDepartmentList())
            ->with('class', $sys->getClassList())
            ->with('house', $sys->getHouseList())
            ;

    }


    public function bills(Request $request, SystemController $sys){
        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $fee = Models\BillModel::query()->where("Item_Status","ACTIVE");

        if ($request->has('program') && trim($request->input('program')) != "") {
            $fee->where("Academic_Programme", $request->input("program", ""));
        }
        if ($request->has('class') && trim($request->input('class')) != "") {
            $fee->where("Class", $request->input("class", ""));
        }

        if ($request->has('year') && trim($request->input('year')) != "") {
            $fee->where("Academic_Year", "=", $request->input("year", ""));
        }
        if ($request->has('term') && trim($request->input('term')) != "") {
            $fee->where("Academic_Term", "=", $request->input("term", ""));
        }


        if ($request->has('residence') && trim($request->input('residence'))!="") {
            $fee->where("Residence", "=", $request->input('residence'));
        }



        $data = $fee->orderBy('Last_Modified_Date', 'DESC')->paginate(100);

        $request->flashExcept("_token");



        foreach ($data as $key => $row) {

            $t[] = $row->Debit_Amount;
            $data[$key]->TOTALS = @array_sum($t);
        }

        $totals = @$sys->formatMoney($data[$key]->TOTALS);
        return view('finance.fees.bills')->with("data", $data)
            ->with('program', $sys->getProgramList())
            ->with('year', $this->years())


            ->with('total', $totals)

            ->with('class', $sys->getClassList())

            ;

    }


    public function sendFeeSMS(Request $request)
    {
        $message = $request->input("message", "");
        $query = \Session::get('students');
        $sms = new SystemController();
        \DB::beginTransaction();
        try {

            foreach ($query as $rtmt => $member) {


                if ($sms->firesms($message, $member->TELEPHONENO, @$member->INDEXNO)) {

                    \Session::forget('students');
                    return redirect('/owing_paid')->with('success', array('Message sent to students succesfully'));

                } else {
                    return redirect('/owing_paid')->withErrors("SMS could not be sent.. please verify if you have sms data and internet access.");
                }
            }
        } catch (\Exception $e) {
            \DB::rollback();

        }
    }

    public function new_receiptno()
    {
        $receiptno_query = Models\Receiptno::first();
        $receiptno_query->increment("receiptno", 1);
        $receiptno = str_pad($receiptno_query->receiptno, 12, "0", STR_PAD_LEFT);

        return $receiptno;

    }

    public function pad_receiptno($receiptno)
    {
        return str_pad($receiptno, 12, "0", STR_PAD_LEFT);
    }

    public function showBillUpload(Request $request,SystemController $sys){
        return view("finance.fees.billUpload");
    }
    public function processBillUpload(Request $request,SystemController $sys){
        if($request->hasFile('file')){
            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
            $file=$request->file('file');
            $user = \Auth::user()->fund;

            $ext = strtolower($file->getClientOriginalExtension());
            $valid_exts = array('csv','xlx','xlsx'); // valid extensions

            $path = $request->file('file')->getRealPath();
            if (in_array($ext, $valid_exts)) {
                $data = Excel::load($path, function($reader) {

                })->get();

                // dd($data);
                if(!empty($data) && $data->count()){


                    foreach ($data as $key => $value) {
                        //$object=$sys->getStudentData($value->customerid);
                        //$program=$object->Academic_Programme;
                        //$class=$object->Currently_In_Class;

                        $bill=date("Y").str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);

                        $insert[] = ['Class'=> $value->class,  'Academic_Programme'=>$value->programme,'Debit_Amount'=>$value->amount,'Item_Description'=>$value->item_description,'Created_By'=>$user
                             ,
                            'Bill_No'=>$bill,
                            'Bill_Type'=>$value->bill_type,
                            'Residence'=>$value->residence,
                            'Gender'=>$value->gender,
                            'Item_Code'=>$value->bill_category,
                            'Academic_Year'=>$year,
                            'Academic_Term'=>$sem

                        ];

                    }

                    // dd($insert);
                    if(!empty($insert)){

                        \DB::table('bill_history')->insert($insert);

                        return redirect('/bills')->with("success",  " <span style='font-weight:bold;font-size:13px;'>Bills  successfully uploaded!</span> " );


                    }

                }

            }
            else{
                return redirect('/upload/payments')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload file format must be xlx,csv,xslx!</span> ");

            }
        }
    }

    public function processPaymentUpload(Request $request,SystemController $sys){
        if($request->hasFile('file')){
            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
            $file=$request->file('file');
            $user = \Auth::user()->fund;

            $ext = strtolower($file->getClientOriginalExtension());
            $valid_exts = array('csv','xlx','xlsx'); // valid extensions

            $path = $request->file('file')->getRealPath();
            if (in_array($ext, $valid_exts)) {
                $data = Excel::load($path, function($reader) {

                })->get();

               // dd($data);
                if(!empty($data) && $data->count()){


                    foreach ($data as $key => $value) {
                        $object=$sys->getStudentData($value->customerid);
                        $program=$object->Academic_Programme;
                        $class=$object->Currently_In_Class;

                        $receipt=date('Y').str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);

                        $insert[] = ['Academic_Programme'=>$program,'Currently_In_Class'=>$class,'bank_date' => $value->date,'Academic_Term'=>$sem,'Academic_Year'=>$year,'Transaction_Type'=>'PAYMENTS','transaction_description'=> $value->transaction_description, 'Receipt_No' => $receipt,'Registration_No'=>$value->customerid,'Credit_Amount'=>$value->amount,'Running_Balance'=>$value->cumulativeamt,'Received_By'=>$user
                        ,'created_at'=>new \DateTime(),
                            'Payment_Method'=>'eTransact Upload'
                        ];

                    }

                    // dd($insert);
                    if(!empty($insert)){

                        \DB::table('students_ledger')->insert($insert);

                         return redirect('/transactions/ledger')->with("success",  " <span style='font-weight:bold;font-size:13px;'>Payments  successfully uploaded!</span> " );


                    }

                }

            }
            else{
                return redirect('/upload/payments')->with("error", " <span style='font-weight:bold;font-size:13px;'>Please upload file format must be xlx,csv,xslx!</span> ");

            }
        }
    }



    public function showPayform()
    {
        return view('finance.fees.payfee');
    }
    public function singleBillPrint(){
        return view('finance.fees.singleBillSearch');
    }
    public function processSingleBillPrint(Request $request, SystemController $sys){
        $student = explode(',', $request->input('q'));
        $student = $student[0];

        $sql = Models\RegistrationCard::where("Registration_No", $student)->first();


        if (count($sql) == 0) {

            return redirect("print/bill/single")->with("error", "<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
        } else {

            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
            $program =  $sql->Academic_Programme;
            $class =  $sql->Currently_In_Class;
            $residence =  $sql->Boarder;
            $name=$sql->Surname." ". $sql->First_Name;


                $bills = Models\BillModel::where("Academic_Programme", $program)
                    ->where("class", $class)
                    ->where("Residence", $residence)
                    ->where("Academic_Year", $year)
                    ->where("Academic_Term", $sem)
                    ->where("Item_Status", "ACTIVE")->get();

                //dd($bills);






            return view("finance.fees.printSingleBill")->with('data', $sql)->with('year', $year)->with('sem', $sem)
                ->with("class", $sys->getClassList())

                ->with("bills",$bills)
                ->with("year",$year)
                ->with("class",$class)
                ->with("name",$name)
                ->with("term",$sem)
                ->with("residence",$residence)
                ->with('banks', $this->banks())->with('receipt', $this->getReceipt());

        }

    }
    public function bulkBillForm(){
        return view('finance.fees.bulkBillSearch');
    }
    public function processBulkBill(Request $request, SystemController $sys){
        $data = explode('-', $request->input('q'));
        $program = $data[0];
        $class = $data[1];


        $sql = Models\RegistrationCard::where("Currently_In_Class", $class)
        ->where("Academic_Programme",$program)->orderBy("Surname")
        ->get();


        if (count($sql) == 0) {

            return redirect("/bill/class/bulk/print")->with("error", "<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
        } else {

            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
             
           
            
               

                /*$bills= \DB::table("registration_card")->join("students_ledger","registration_card.Registration_No","=","students_ledger.Registration_No")
                 ->where("registration_card.Academic_Programme",$program)
                 ->where("registration_card.Currently_In_Class", $class)
                  ->where("students_ledger.Academic_Year", $year)
                    ->where("students_ledger.Academic_Term", $sem)
                    ->where("students_ledger.Item_Status", "ACTIVE")->get();*/
 
            return view("finance.fees.printBulkBill")->with('year', $year)->with('sem', $sem)
                 
                
                ->with("year",$year)
                ->with("class",$class)
                ->with("program",$program)
                 ->with("students",$sql)
                ->with("term",$sem)
                
                ;

        }
 

    }
    public function showSingleBillCreateForm(){
        return view('finance.fees.createSingleBill');
    }

    public function showStudentInfoBill(Request $request, SystemController $sys)
    {
        $student = explode(',', $request->input('q'));
        $student = $student[0];

        $sql = Models\RegistrationCard::where("Registration_No", $student)->get();


        if (count($sql) == 0) {

            return redirect("/student/bill/create")->with("error", "<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
        } else {
             $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;

            $bills = Models\PaymentTransactions::where("Registration_No", $student)->where("Academic_Year",$year)
                ->where("Academic_Term",$sem)->where("Transaction_Type","BILLING")
                ->where("Item_Status","ACTIVE")->sum("Debit_Amount");


            $paid = Models\PaymentTransactions::where("Registration_No", $student)->where("Academic_Year",$year)
                ->where("Academic_Term",$sem)->where("Transaction_Type","PAYMENT")
                ->where("Item_Status","ACTIVE")->sum("Credit_Amount");

            $item = \DB::table('bill_items')->orderBy("Item_Code" )->orderBy("Item_Description")
                ->pluck('Item_Description', 'Item_Description');
         
             
             

            return view("finance.fees.processIndividualBillCreation")->with('data', $sql)->with('year', $sys->years())
                 ->with("paid",$paid)
                 ->with("item",$item)
                ->with("bills",$bills);

        }

    }

    public function processSingleBillCreation(Request $request, SystemController $sys)
    {
         $user=\Auth::user()->fund;

                        $bill=date("Y").str_pad(mt_rand(1,999),3,'0',STR_PAD_LEFT);

                        $insert[] = ['Class'=> $request->class,  'Academic_Programme'=>$request->programme,'Debit_Amount'=>$request->amount,'Item_Description'=>$request->description,'Created_By'=>$user
                             ,
                            "Bill_No"=>$bill,
                            "Bill_Type"=>"Additional Bill",
                             
                             "student"=>$request->student,
                            "Item_Code"=>$request->code,
                            "Academic_Year"=>$request->year,
                            "Academic_Term"=>$request->term

                        ];

                    

                    // dd($insert);
                    if(!empty($insert)){

                        \DB::table('bill_history')->insert($insert);

                        return redirect('/bills')->with("success",  " <span style='font-weight:bold;font-size:13px;'>Bills  successfully uploaded!</span> " );


                    }
    }



    public function showClassInfoBill(Request $request, SystemController $sys)
    {
           
             
             $item = \DB::table('bill_items')->orderBy("Item_Code" )->orderBy("Item_Description")
                ->pluck('Item_Description', 'Item_Description');
         
            
            return view("finance.fees.classBillCreate")->with('year', $sys->years())
                 ->with("program",$sys->getProgramList())
                 ->with("item",$item)
                ->with("class",$sys->getClassList());

         

    }

    public function processClassBillCreation(Request $request, SystemController $sys){


    }

















    public function showStudent(Request $request, SystemController $sys)
    {
        $student = explode(',', $request->input('q'));
        $student = $student[0];

        $sql = Models\RegistrationCard::where("Registration_No", $student)->get();


        if (count($sql) == 0) {

            return redirect("/pay/fees")->with("error", "<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
        } else {

            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;

            $bills = Models\PaymentTransactions::where("Registration_No", $student)->where("Academic_Year",$year)
                ->where("Academic_Term",$sem)->where("Transaction_Type","BILLING")
                ->where("Item_Status","ACTIVE")->sum("Debit_Amount");


            $paid = Models\PaymentTransactions::where("Registration_No", $student)->where("Academic_Year",$year)
                ->where("Academic_Term",$sem)->where("Transaction_Type","PAYMENT")
                ->where("Item_Status","ACTIVE")->sum("Credit_Amount");


            return view("finance.fees.processPayment")->with('data', $sql)->with('year', $year)->with('sem', $sem)
                ->with("class", $sys->getClassList())
                ->with("paid",$paid)
                ->with("bills",$bills)
                ->with('banks', $this->banks())->with('receipt', $this->getReceipt());

        }

    }

    public function processPayment(Request $request,SystemController $sys){
        // if (@\Auth::user()->department == "Finance") {

        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $phone = $request->input('phone');

        $user = \Auth::user()->fund;
        $program = $request->input('programme');

        $type = $request->input('type');
        $amount = $request->input('amount');
        $receipt = $request->input('receipt');
        $indexno = $request->input('student');

        $class = $request->input('currentClass');
        $newClass = $request->input('class');

        $bank = $request->input('bank');

        $bank_date = $request->input('bank_date');


        $sql = Models\PaymentTransactions::where("Receipt_No", $receipt)->first();


        if (empty($sql)) {
            $feeLedger = new Models\PaymentTransactions();
            $feeLedger->Registration_No = $indexno;
            $feeLedger->Currently_In_Class = $class;
            $feeLedger->Academic_Programme = $program;
            $feeLedger->Credit_Amount = $amount;
            $feeLedger->Payment_Method = $type;

            $feeLedger->bank_date = $bank_date;


            $feeLedger->Received_By = $user;
            $feeLedger->bank = $bank;

            $feeLedger->Receipt_No = $receipt;
            $feeLedger->Academic_Year = $year;

            $feeLedger->Academic_Term = $sem;
            $feeLedger->Item_Status = "ACTIVE";

            if ($feeLedger->save()) {

                $this->updateReceipt();


                $balance = Models\RegistrationCard::where("Registration_No", $indexno)->get();


                @$firstName = @$balance[0]->First_Name;

                $billOwing = (@$balance[0]->totalOwings - $amount) ;
                $totalPaid = (@$balance[0]->totalPayments + $amount) ;
                if(!empty( $newClass)) {
                    Models\RegistrationCard::where('Registration_No', $indexno)->update(array(  'Currently_In_Class' => $newClass,  'totalOwings' => $billOwing,    'totalPayments' => $totalPaid));
                }
                else{
                    Models\RegistrationCard::where('Registration_No', $indexno)->update(array('totalOwings' => $billOwing,    'totalPayments' => $totalPaid));

                }


                $url = url("printreceipt/" . trim($receipt));
                $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                $request->session()->flash("success", "Payment successfully   $print_window");
                return redirect("/pay");
            }




        } else {
              return redirect("/pay")->with("error", " <span style='font-weight:bold;font-size:13px;'> Payment already made with this receipt  number  </span>");
        }

        /* } else {
             return redirect("/dashboard")->with("message", "Unauthorized access detected.");
         }*/
    }

    public function processPaymentOld(Request $request,SystemController $sys)
    {
       // if (@\Auth::user()->department == "Finance") {
            
            $array = $sys->getSemYear();
            $sem = $array[0]->term;
            $year = $array[0]->year;
            $phone = $request->input('phone');
            //  dd($phone);
            $user = \Auth::user()->fund;
            $feetype = $request->input('type');

            $type = $request->input('type');
            $amount = $request->input('amount');
            $receipt = $request->input('receipt');
            $indexno = $request->input('student');
            $owing = $request->input('bill') - $amount;
            $class = $request->input('currentClass');
            $newClass = $request->input('class');

            $bank = $request->input('bank');
            $previousOwing = $request->input('prev-owing');
            $bank_date = $request->input('bank_date');

            $details = "Payment of " . $type . " Fees";

            $transactionID = $request->input('transaction');

            if ($request->input('total') <= $amount) {
                $paymenttype = "Full payment";
            } else {
                $paymenttype = "Part payment";
            }

            $sql = FeePaymentModel::where("receiptno", $receipt)->first();


            if (empty($sql)) {
                $feeLedger = new FeePaymentModel();
                $feeLedger->stuId = $indexno;
                $feeLedger->classes = $class;
                $feeLedger->paid = $amount;
                $feeLedger->paymentType = $paymenttype;
                $feeLedger->description = $details;
                $feeLedger->bank_date = $bank_date;


                $feeLedger->worker = $user;
                $feeLedger->bank = $bank;

                $feeLedger->receiptno = $receipt;
                $feeLedger->year = $year;
                $feeLedger->type = $feetype;
                $feeLedger->term = $sem;

                if ($feeLedger->save()) {
                      
                    $this->updateReceipt();
                        
                    $ptaoutstanding = number_format($request->input('pta'), 2, '.', ',');
                    $totalstanding = number_format($request->input('total'), 2, '.', ',');
                    $boardoutstanding = number_format($request->input('boarding'), 2, '.', ',');
                    $academicoutstanding = number_format($request->input('academic'), 2, '.', ',');

                    $academicLeft = 0.00;
                    $ptaLeft = 0.00;
                    $boardingLeft = 0.00;
                    $totalLeft = 0.00;
                   
                    //$academicLeft = $academicoutstanding - $amount;
                    //dd($academicLeft);
                    if ($type == "Academic") {
                        
                        $academicLeft = $academicoutstanding - $amount;
                        //dd( $academicoutstanding);
                        $totalLeft = @number_format($totalstanding, 2, '.', ',') - @number_format($academicLeft, 2, '.', ',');
                            // dd("jdjdjdj");
                        //dd("hy");
                    } elseif ($type == "PTA") {
                        $ptaLeft = $ptaoutstanding - $amount;
                        //dd( $ptaoutstanding);
                        $totalLeft = @number_format($totalstanding, 2, '.', ',') - @number_format($ptaLeft, 2, '.', ',');
                         //dd("jdjdjdj");
                    } elseif ($type == "Boarding") {
                        $boardingLeft = $boardoutstanding - $amount;
                        // dd( $boardingLeft);
                        $totalLeft = @number_format($totalstanding, 2, '.', ',') - @number_format($boardingLeft, 2, '.', ',');

                            // dd("jdjdjdj"); 
                    } 
                    else {

                    }

                    $balance = StudentModel::where("indexNo", $indexno)->get();


                    @$firstName = @$balance[0]->othernames;

                    $billOwing = (@$balance[0]->totalOwing - $amount) + $previousOwing;
                    if(!empty( $newClass)) {
                        StudentModel::where('indexNo', $indexno)->update(array('totalOwing' => $billOwing, 'currentClass' => $newClass, 'ptaOwing' => $ptaLeft, 'boardingOwing' => $boardingLeft, 'academicBillOwing' => $academicLeft, 'sysUpdate' => '1'));
                    }
                    else{
                        StudentModel::where('indexNo', $indexno)->update(array('totalOwing' => $billOwing,   'ptaOwing' => $ptaLeft, 'boardingOwing' => $boardingLeft, 'academicBillOwing' => $academicLeft, 'sysUpdate' => '1'));

                    }

                    $smsOwing = @StudentModel::where("indexNo", $indexno)->get();

                   //  dd($smsOwing);


                    $smsOwe = $smsOwing[0]->academicBillOwing + $smsOwing[0]->boardingOwing + $smsOwing[0]->ptaOwing;
                    \Session::put('pupil', $indexno);
                    if ($paymenttype == "Full payment") {
                        $message = "Hi $firstName, GHS$amount paid as $feetype  ";
                    }
                    $message = "Hi $firstName, GHS$amount paid as $feetype fees , you owe GHS$smsOwe ";
                    //  \DB::commit();
                   // $sys->firesms($message, @$balance[0]->parentPhone, $indexno);


                    $url = url("printreceipt/" . trim($receipt));
                    $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                    $request->session()->flash("success", "Payment successfully   $print_window");
                    return redirect("/pay_fees");
                }




            } else {
                //  return redirect("/students")->with("error", " <span style='font-weight:bold;font-size:13px;'> Payment already made with this receipt  number  </span>");
            }

       /* } else {
            return redirect("/dashboard")->with("message", "Unauthorized access detected.");
        }*/
    }

     public function index(Request $request, SystemController $sys){
         $array = $sys->getSemYear();
         $sem = $array[0]->term;
         $year = $array[0]->year;
         $fee = FeePaymentModel::query();

         if ($request->has('class') && trim($request->input('class')) != "") {
             $fee->where("classes", $request->input("class", ""));
         }

         if ($request->has('indexno') && trim($request->input('indexno')) != "") {
             $fee->where("stuId", '=', $request->input("indexno", ""));
         }
         if ($request->has('year') && trim($request->input('year')) != "") {
             $fee->where("year", "=", $request->input("year", ""));
         }



         if ($request->has('type') && trim($request->input('type'))) {
             $fee->where("type", "=", $request->input('type'));
         }
         if ($request->has('paytype') && trim($request->input('paytype'))) {
             $fee->where("paymentType", "=", $request->input('type'));
         }
         $data = $fee->groupBy('classes')->orderBy('created_at', 'DESC')->paginate(10000);

         $request->flashExcept("_token");
         \Session::put('students', $data);

         foreach ($data as $key => $row) {
             $a[] = $row->paid;
             //$data[$key]->TOTALS = array_sum($a);

             $t[] = $this->getTotalPayment($row->stuId, $row->term, $row->year);
             $data[$key]->paid = @array_sum($t);
         }

         $totals = @$sys->formatMoney($data[$key]->paid);
         return view('finance.reports.paid')->with("data", $data)
             ->with('program', $sys->getProgramList())
             ->with('year', $this->years())
             ->with('bank', $this->banks())
             ->with('nationality', $sys->getCountry())

             ->with('religion', $sys->getReligion())
             ->with('region', $sys->getRegions())
             ->with('department', $sys->getDepartmentList())
             ->with('class', $sys->getClassList())
             ->with('house', $sys->getHouseList())
             ->with('total', $totals);
     }
    public function printOldReceipt(Request $request)
    {

        if (@\Auth::user()->department == "Finance") {
            if ($request->isMethod("get")) {
                return view("finance.fees.printLostReceipt");
            } else {
                $sys = new SystemController();
                $array = $sys->getSemYear();
                $sem = $array[0]->SEMESTER;
                $year = $array[0]->YEAR;
                $student = explode(',', $request->input('q'));
                $student = $student[0];

                $sql = StudentModel::where("INDEXNO", $student)->orwhere("STNO", $student)->get();
                //dd($sql);
                if (count($sql) == 0) {
                    //echo "<script>alert('No fee payment receipt found for this student')</script>";
                    return redirect("/print/receipt")->with("error", "<span style='font-weight:bold;font-size:13px;'> $request->input('q') does not exist!</span>");
                } else {
                    $indexNo = $sql[0]->INDEXNO;
                    $receiptQuery = FeePaymentModel::where("INDEXNO", $indexNo)->where("YEAR", $year)->where("SEMESTER", $sem)->first();
                    if (!empty($receiptQuery)) {
                        $receipt = $receiptQuery->RECEIPTNO;
                        $url = url("printreceipt/" . trim($receipt));
                        $print_window = "<script >window.open('$url','','location=1,status=1,menubar=yes,scrollbars=yes,resizable=yes,width=1000,height=500')</script>";
                        $request->session()->flash("success", "Receipt printing .....   $print_window");
                        return redirect("/print/receipt");
                    } else {
                        return redirect("/print/receipt")->with("error", "<span style='font-weight:bold;font-size:13px;'>No receipt for this student was found in the system!</span>");

                    }
                }
            }

        } else {
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');

        }
    }

    public function banks()
    {

        $banks = \DB::table('banks')
            ->pluck('bname', 'id');
        return $banks;
    }

    public function programmes()
    {

        $program = \DB::table('tpoly_programme')->get();

        foreach ($program as $p => $value) {
            $programs[] = $value->PROGRAMMECODE;
        }
        return $programs;
    }

    public function programmeSearch()
    {

        $program = \DB::table('tpoly_programme')->get();

        foreach ($program as $p => $value) {
            $programs[] = $value->ID;
        }
        return $programs;
    }

    public function getReceipt()
    {
        \DB::beginTransaction();
        try {
            $receiptno_query = ReceiptModel::first();
            $receiptno = date('Y') . str_pad($receiptno_query->no, 5, "0", STR_PAD_LEFT);
            \DB::commit();
            return $receiptno;
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function updateReceipt()
    {
        \DB::beginTransaction();
        try {
            $query = ReceiptModel::first();

            $result = $query->increment("no");
            if ($result) {
                \DB::commit();
            }

        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function printreceiptLate(Request $request, $receiptno)
    {

        // $this->show_query();

        $transaction = Models\PaymentTransactions::where("RECEIPTNO", $receiptno)->with("student", "bank"
        )->first();

        if (empty($transaction)) {
            abort(434, "No Fee payment   with this receipt <span class='uk-text-bold uk-text-large'>{{$receiptno}}</span>");
        }

        $words = $this->convert($transaction->Credit_Amount);




        return view("finance.fees.late_receipt")->with("transaction", $transaction)->with('words', $words);


    }

    public function printreceipt(Request $request, $receiptno) {

        // $this->show_query();
        $sys = new SystemController();
        $array = $sys->getSemYear();
        $sem = $array[0]->term;
        $year = $array[0]->year;
        $transaction = Models\PaymentTransactions::where("Receipt_No", $receiptno)->first();



        if (empty($transaction)) {
            abort(434, "No Fee payment   with this receipt <span class='uk-text-bold uk-text-large'>{{$receiptno}}</span>");
        } else {




            $data = Models\RegistrationCard::where("Registration_No", $transaction->Registration_No)->first();

            $words = $this->convert($transaction->Credit_Amount);




            return view("finance.fees.receipt")->with("student", $data)
                ->with("transaction", $transaction)->with('words', $words)
                ->with("term", $sem)->with("year", $year);
        }
    }


    public function showUpload()
    {
        return view("finance.fees.upload");
    }



    public function convert_number($number)
    {

        if (($number < 0) || ($number > 999999999)) {
            return "$number";
        }

        $Gn = floor($number / 1000000); /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000); /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100); /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10); /* Tens (deca) */
        $n = $number % 10; /* Ones */

        $res = "";

        if ($Gn) {
            $res .= $this->convert_number($Gn) . " Million";
        }

        if ($kn) {
            $res .= (empty($res) ? "" : " ") .
                $this->convert_number($kn) . " Thousand";
        }

        if ($Hn) {
            $res .= (empty($res) ? "" : " ") .
                $this->convert_number($Hn) . " Hundred";
        }

        $ones = array(
            "",
            "One",
            "Two",
            "Three",
            "Four",
            "Five",
            "Six",
            "Seven",
            "Eight",
            "Nine",
            "Ten",
            "Eleven",
            "Twelve",
            "Thirteen",
            "Fourteen",
            "Fifteen",
            "Sixteen",
            "Seventeen",
            "Eighteen",
            "Nineteen");
        $tens = array(
            "",
            "",
            "Twenty",
            "Thirty",
            "Fourty",
            "Fifty",
            "Sixty",
            "Seventy",
            "Eighty",
            "Ninety");

        if ($Dn ||
            $n) {
            if (!empty($res)) {
                $res .= " and ";
            }

            if ($Dn <
                2) {
                $res .= $ones[$Dn *
                10 +
                $n];
            } else {
                $res .= $tens[$Dn];

                if ($n) {
                    $res .= "-" . $ones[$n];
                }
            }
        }

        if (empty($res)) {
            $res = "zero";
        }

        return $res;

//$thea=explode(".",$res);
    }

    public function convert($amt)
    {
//$amt = "190120.09" ;

        $amt = number_format($amt, 2, '.', '');
        $thea = explode(".", $amt);

//echo $thea[0];

        $words = $this->convert_number($thea[0]) . " Ghana Cedis ";
        if ($thea[1] >
            0) {
            $words .= $this->convert_number($thea[1]) . " Pesewas";
        }

        return $words;
    }



    public function createform()
    {
        $program = \DB::table('tpoly_programme')
            ->pluck('PROGRAMME', 'ID');
        return view('finance.fees.create')->with('program', $program)->with('year', $this->years())->with('country', $this->countries());

    }

    public function years()
    {

        for ($i = 2008; $i <= 2030; $i++) {
            $year = $i - 1 . "/" . $i;
            $years[$year] = $year;
        }
        return $years;
    }



    public function destroyPayment(Request $request)
    {
        \DB::beginTransaction();
        try {

            $query = Models\PaymentTransactions::where('Serial_No', $request->input("id"))->first();
            $studentIndexNo = $query->Registration_No;
            $amount = $query->Credit_Amount;
            if ($query) {

                $sql = Models\RegistrationCard::where("Registration_No", $studentIndexNo)->first();
                $paid = $sql->totalPayments-$amount;
                $owing = $sql->totalOwings+$amount;
                if (Models\PaymentTransactions::where('Serial_No', $request->input("id"))->update(array("Item_Status"=>"DELETED"))) {
                    Models\RegistrationCard::where("Registration_No", $studentIndexNo)->update(array("totalPayments" => $paid,"totalOwings"=>$owing));
                    \DB::commit();
                }

                return redirect()->back()->with("success", " <span style='font-weight:bold;font-size:13px;'> Payment for student with index number $studentIndexNo amounting GHC $amount successfully deleted!</span> ");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function deleteBill(Request $request)
    {
        \DB::beginTransaction();
        try {

            $query = Models\BillModel::where('id', $request->input("id"))->delete();

            if ($query) {

                    \DB::commit();


                return redirect()->back()->with("success", " <span style='font-weight:bold;font-size:13px;'>  Bill item successfully deleted!</span> ");
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function owing(Request $request,SystemController $sys){

         $student = StudentModel::query()->where("totalOwing",">",0);         

         if ($request->has('program') && trim($request->input('program')) != "") {
            $student->where("programme", $request->input("program", ""));
        }
        if ($request->has('class') && trim($request->input('class')) != "") {
            $student->where("currentClass", $request->input("class", ""));
        }
        if ($request->has('status') && trim($request->input('status')) != "") {
            $student->where("status", $request->input("status", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $student->where("studentType", $request->input("type", ""));
        }
        if ($request->has('group') && trim($request->input('group')) != "") {
            $student->where("yearGroup", $request->input("yearGroup", ""));
        }
        if ($request->has('nationality') && trim($request->input('nationality')) != "") {
            $student->where("nationality", $request->input("country", ""));
        }
        if ($request->has('region') && trim($request->input('region')) != "") {
            $student->where("region", $request->input("region", ""));
        }
        if ($request->has('gender') && trim($request->input('gender')) != "") {
            $student->where("gender", $request->input("gender", ""));
        }
        if ($request->has('sms') && trim($request->input('sms')) != "") {
            $student->where("SMS_SENT", $request->input("sms", ""));
        }
        if ($request->has('house') && trim($request->input('house')) != "") {
            $student->where("house", $request->input("house", ""));
        }
        
        if ($request->has('religion') && trim($request->input('religion')) != "") {
            $student->where("religion", $request->input("religion", ""));
        }
        if ($request->has('search') && trim($request->input('search')) != "" && trim($request->input('by')) != "") {
            // dd($request);
            $student->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%")
               ->orWhere("indexNo","LIKE", "%" . $request->input("search", "") . "%");
        }
        $data = $student->orderBy('currentClass')->orderBy('programme')->orderBy('indexNo')->paginate(300);

        $request->flashExcept("_token");

        \Session::put('students', $data);
        return view('finance.reports.owing')->with("data", $data)
                        ->with('year', $sys->years())
                        ->with('nationality', $sys->getCountry())
                         
                        ->with('religion', $sys->getReligion())
                        ->with('region', $sys->getRegions())
                        ->with('department', $sys->getDepartmentList())
                        ->with('class', $sys->getClassList())
                        ->with('house', $sys->getHouseList())
                        ->with('programme', $sys->getProgramList())
                      ;
        

    }


     public function paid(Request $request,SystemController $sys){

         $student = StudentModel::query()->where("totalOwing","=",0);         

         if ($request->has('program') && trim($request->input('program')) != "") {
            $student->where("programme", $request->input("program", ""));
        }
        if ($request->has('class') && trim($request->input('class')) != "") {
            $student->where("currentClass", $request->input("class", ""));
        }
        if ($request->has('status') && trim($request->input('status')) != "") {
            $student->where("status", $request->input("status", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $student->where("studentType", $request->input("type", ""));
        }
        if ($request->has('group') && trim($request->input('group')) != "") {
            $student->where("yearGroup", $request->input("yearGroup", ""));
        }
        if ($request->has('nationality') && trim($request->input('nationality')) != "") {
            $student->where("nationality", $request->input("country", ""));
        }
        if ($request->has('region') && trim($request->input('region')) != "") {
            $student->where("region", $request->input("region", ""));
        }
        if ($request->has('gender') && trim($request->input('gender')) != "") {
            $student->where("gender", $request->input("gender", ""));
        }
        if ($request->has('sms') && trim($request->input('sms')) != "") {
            $student->where("SMS_SENT", $request->input("sms", ""));
        }
        if ($request->has('house') && trim($request->input('house')) != "") {
            $student->where("house", $request->input("house", ""));
        }
        
        if ($request->has('religion') && trim($request->input('religion')) != "") {
            $student->where("religion", $request->input("religion", ""));
        }
        if ($request->has('search') && trim($request->input('search')) != "" && trim($request->input('by')) != "") {
            // dd($request);
            $student->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%")
               ->orWhere("indexNo","LIKE", "%" . $request->input("search", "") . "%");
        }
        $data = $student->orderBy('currentClass')->orderBy('programme')->orderBy('indexNo')->paginate(300);

        $request->flashExcept("_token");

        \Session::put('students', $data);
        return view('finance.reports.paid')->with("data", $data)
                        ->with('year', $sys->years())
                        ->with('nationality', $sys->getCountry())
                         
                        ->with('religion', $sys->getReligion())
                        ->with('region', $sys->getRegions())
                        ->with('department', $sys->getDepartmentList())
                        ->with('class', $sys->getClassList())
                        ->with('house', $sys->getHouseList())
                        ->with('programme', $sys->getProgramList())
                      ;
        

    }
}
