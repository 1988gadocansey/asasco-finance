<?php
 
namespace App\Http\Controllers;
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
class ReportController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

         
    }
     public function studentLedger(Request $request, SystemController $sys) {
          if(@\Auth::user()->role=='FO' || @\Auth::user()->department=='Finance' || @\Auth::user()->department=='top'){
              $array=$sys->getSemYear();
              $sem=$array[0]->SEMESTER;
              $year=$array[0]->YEAR;
              $student=  explode(',',$request->input('q'));
              $student=$student[0];
        
              /* balance b/d ie
               * bill owing from students table
               * NB we treating students as a debtors 
               * in this case except the school
               * doesn't follow the accrual concept and
               * opperates soly cash accounting
               */
              $balanceBD= StudentModel::where("INDEXNO",$student)->first();
              
              $transactions=FeePaymentModel::where("INDEXNO",$student)->paginate(100);
               return view("finance.reports.studentLedger")->with("student",$balanceBD)
                       ->with("sem",$sem)
                       ->with("year",$year)
                       ->with("data",$transactions);
                  
          }
          else{
              return redirect("/dashboard");
          }
     }
     public function programLedger(Request $request, SystemController $sys) {
         if (@\Auth::user()->role == 'FO' || @\Auth::user()->department == 'Finance' || @\Auth::user()->department == 'top') {
            $array = $sys->getSemYear();
            $sem = $array[0]->SEMESTER;
            $year = $array[0]->YEAR;
            if ($request->isMethod("get")) {

                return view('finance.reports.ledgerPrograms')
                                ->with('program', $sys->getProgramList())
                                ->with('year', $sys->years());
            } else {
                /* balance b/d ie
                 * bill owing from students table
                 * NB we treating students as a debtors 
                 * in this case except the school
                 * doesn't follow the accrual concept and
                 * opperates soly cash accounting
                 */
                $program=$request->input("program");
                $level=$request->input("level");
                $fiscalYear=$request->input("year");
                $balanceBD = StudentModel::where("PROGRAMMECODE", $program)
                        ->where("YEAR",$level)
                        ->paginate(7800);
                 
                $transactions = FeePaymentModel::join("tpoly_students", 'tpoly_feedetails.INDEXNO', '=', 'tpoly_students.INDEXNO')
                        ->where("tpoly_students.YEAR",$level)
                        ->paginate(7800);
                $programm=$sys->getProgram($request->input('program'));
               
                return view("finance.reports.ledgerPrograms")->with("query", $balanceBD)
                                ->with("sems", $sem)
                                ->with("years", $year)
                                 ->with('program', $sys->getProgramList())
                                ->with('year', $sys->years()) 
                                ->with('programme', $programm)
                                 ->with('level', $request->input("level", "")) 
                                ->with("data", $transactions);
            }
        } else {
            return redirect("/dashboard");
        }
    }
     public function showBills(Request $request, SystemController $sys) {
          if(@\Auth::user()->role=='FO' || @\Auth::user()->department=='Finance' || @\Auth::user()->department=='top'){
              $array=$sys->getSemYear();
              $sem=$array[0]->SEMESTER;
              $year=$array[0]->YEAR;
              
              $query=Models\BillModel::query()->paginate(500);
               return view("finance.reports.bills")->with("data",$query)
                  ->with("program",$sys->getProgramList());
          }
          else{
              return redirect("/dashboard");
          }
     }
    public function getTotalPayment($student, $term, $yearr) {
        $sys = new SystemController();
        $array = $sys->getSemYear();
        if ($term == "" && $yearr == "") {
            $term = $array[0]->SEMESTER;
            $yearr = $array[0]->YEAR;
        }

        $fee = FeePaymentModel::query()->where('YEAR', '=', $yearr)->where('SEMESTER', $term)->where('INDEXNO', $student)->sum('AMOUNT');
        return $fee;
    }
    public function summaryPayment(Request $request, SystemController $sys) {
              $array=$sys->getSemYear();
              $sem=$array[0]->SEMESTER;
              $year=$array[0]->YEAR;
//            $admitted=FeePaymentModel::join('tpoly_students','tpoly_students.INDEXNO', '=', 'tpoly_feedetails.INDEXNO')
//                 
//                 ->where('tpoly_students.LEVEL','100')
//                 ->orWhere('tpoly_students.LEVEL','400/1')
//                 ->orderby("tpoly_programme.PROGRAMME")
//                 ->lists('tpoly_programme.PROGRAMME', 'tpoly_programme.PROGRAMMECODE');
//             

           $freshers=  StudentModel::where("LEVEL",'100')->orWhere("LEVEL",'400/1')->count();
           $registered=  StudentModel::where("REGISTERED",'1')->count();
           return view("finance.reports.summaryPayment");
    }

    public function summaryPaymentPrograms(Request $request, SystemController $sys) {
               

        $programs=  Models\ProgrammeModel::query();
        if ($request->has('school') && trim($request->input('school')) != "") {
                
                               $programs->whereHas('departments', function($q)use ($request) {

            $q->whereHas('school', function($q)use ($request) {
                $q->whereIn('FACCODE', [$request->input('school')]);
            });
             });
         
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $programs->where("PROGRAMMECODE", $request->input("program", ""));
        }
        if ($request->has('department') && trim($request->input('department')) != "") {
            $programs->where("DEPTCODE", $request->input("department", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $programs->where("TYPE", $request->input("TYPE", ""));
        }
        $data=$programs->orderBy("PROGRAMME")->orderBy("TYPE")->paginate(500);
                   
            
           return view("finance.reports.summaryPrograms")
           ->with("programcode",$data)
           ->with('department', $sys->getDepartmentList())
                        ->with('school', $sys->getSchoolList())
                        ->with('programme', $sys->getProgramList())
                        ->with('type', $sys->getProgrammeTypes());
    }
    
    // this one is for FO
    public function summaryPaymentPrograms2(Request $request, SystemController $sys) {
               
              $array=$sys->getSemYear();
              $year=$array[0]->YEAR;
             
        $sql= Models\StudentModel::select("PROGRAMMECODE",'YEAR','LEVEL')->where("SYSUPDATE","1");
        if ($request->has('school') && trim($request->input('school')) != "") {
                
                               $sql->whereHas('departments', function($q)use ($request) {

            $q->whereHas('school', function($q)use ($request) {
                $q->whereIn('FACCODE', [$request->input('school')]);
            });
             });
         
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $sql->where("PROGRAMMECODE", $request->input("program", ""));
        }
        if ($request->has('department') && trim($request->input('department')) != "") {
            $sql->where("DEPTCODE", $request->input("department", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $sql->where("TYPE", $request->input("TYPE", ""));
        }
        $data=$sql->orderBy("PROGRAMMECODE")->orderBy("YEAR")->groupBy("PROGRAMMECODE")
                ->groupBy("YEAR")
                ->paginate(10000);
                   
            
           return view("finance.reports.paymentByPrograms")
           ->with("data",$data)
                   ->with("year",$year)
           ->with('department', $sys->getDepartmentList())
                        ->with('school', $sys->getSchoolList())
                        ->with('programme', $sys->getProgramList())
                        ->with('type', $sys->getProgrammeTypes());
    }
    
 public function summaryOwingsPrograms(Request $request, SystemController $sys) {
               

        $programs=  Models\ProgrammeModel::query();
        if ($request->has('school') && trim($request->input('school')) != "") {
                
                               $programs->whereHas('departments', function($q)use ($request) {

            $q->whereHas('school', function($q)use ($request) {
                $q->whereIn('FACCODE', [$request->input('school')]);
            });
             });
         
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $programs->where("PROGRAMMECODE", $request->input("program", ""));
        }
        if ($request->has('department') && trim($request->input('department')) != "") {
            $programs->where("DEPTCODE", $request->input("department", ""));
        }
        if ($request->has('type') && trim($request->input('type')) != "") {
            $programs->where("TYPE", $request->input("TYPE", ""));
        }
        $data=$programs->orderBy("PROGRAMME")->orderBy("TYPE")->paginate(500);
                   
            
           return view("finance.reports.summaryOwing")
           ->with("programcode",$data)
           ->with('department', $sys->getDepartmentList())
                        ->with('school', $sys->getSchoolList())
                        ->with('programme', $sys->getProgramList())
                        ->with('type', $sys->getProgrammeTypes());
    }
}