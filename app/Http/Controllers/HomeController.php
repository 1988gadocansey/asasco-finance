<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
 
use App\User;
 

class HomeController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
        
        $user=@\Auth::user()->id;
        $date=new \Datetime();
        @User::where("id", $user)->update(array("last_login"=>$date));
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(SystemController $sys)
    {
         if(@\Auth::user()->phone==""){
            return view("users.updateProfile");
        }
        else{
        $lastVisit=\Carbon\Carbon::createFromTimeStamp(strtotime(@\Auth::user()->last_login))->diffForHumans();
         
        $academicDetails=$sys->getSemYear();
        $sem=$academicDetails[0]->term;
        $year=$academicDetails[0]->year;
       
        //$studentDetail=Models\StudentModel::query()->where('STATUS','In School')->sum("BILLS");
        $total=@Models\StudentModel::query()->where('STATUS','In School')->count("ID");
       //$registered= @Models\AcademicRecordsModel::query()->where('lecturer',@\Auth::user()->staffID)->count("id");
       
        //$totalOwing=@$sys->formatMoney($studentDetail);
        //Payment details
       //$totalPaid=Models\FeePaymentModel::query()->where('SEMESTER',$sem)->where('YEAR',$year)->sum("AMOUNT");
        
       //$paid=@$sys->formatMoney($totalPaid);
        
        // statistics
         $male=@Models\StudentModel::query()->where("gender","Male")->where('status','In school')->count();
      $female=@Models\StudentModel::query()->where("gender","Female")->where('status','In school')->count();
      $workers=@Models\WorkerModel::count();
      
        return view('dashboard')->with('male', $male)
                                ->with('female', $female)
                                  ->with('worker', $workers)
                                  ->with('total', $total)
                                 
                                ->with('sem', $sem)
                                ->with('year', $year)
                                ->with('lastVisit', $lastVisit);
                           
        
         
        }
    }
    public function accountStatement(Request $request, SystemController $sys) {
        $student=@\Auth::user()->username;
        
         
        $academicDetails=$sys->getSemYear();
        $sem=$academicDetails[0]->SEMESTER;
        $year=$academicDetails[0]->YEAR;
       
        $studentDetail=Models\StudentModel::query()->where('STATUS','In School')->where('INDEXNO',$student)->first();
        
         
        $outstandingBill=@$sys->formatMoney($studentDetail->BILL_OWING);
        $SemesterBill=@$sys->formatMoney($studentDetail->BILLS);
          //Payment details
        $paymentDetail=  Models\FeePaymentModel::query()->where('INDEXNO',$student)->orderBy('LEVEL','DESC')->orderBy('YEAR','DESC')->orderBy('SEMESTER','DESC')->paginate(100);
        return view("students.account_statement")->with("transaction", $paymentDetail)
                ->with('balance', $outstandingBill)
                ->with('semesterBill', $paymentDetail);
    }
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function buildChart(Request $request)
    {
         $viewer = User::select(\DB::raw("SUM(id) as count"))
        ->orderBy("created_at")
        ->groupBy(\DB::raw("year(created_at)"))
        ->get()->toArray();
    $viewer = array_column($viewer, 'count');
    
    $click = User::select(\DB::raw("SUM(id) as count"))
        ->orderBy("created_at")
        ->groupBy(\DB::raw("year(created_at)"))
        ->get()->toArray();
    $click = array_column($click, 'count');
    
    return view('graph')
            ->with('viewer',json_encode($viewer,JSON_NUMERIC_CHECK))
            ->with('click',json_encode($click,JSON_NUMERIC_CHECK));
    }
    public function getLaraChart()
    {
    	$lava = new Lavacharts; // See note below for Laravel

		$popularity = $lava->DataTable();
		$data = \App\Models\CountryUser::select("name as 0","total_users as 1")->get()->toArray();

		$popularity->addStringColumn('Country')
		           ->addNumberColumn('Popularity')
		           ->addRows($data);

		$lava->GeoChart('Popularity', $popularity);

        return view('graph',compact('lava'));
    }
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Task $task)
    {
        $this->authorize('destroy', $task);

        $task->delete();

        return redirect('/tasks');
    }
}
