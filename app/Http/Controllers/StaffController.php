<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Excel;

class StaffController extends Controller {

    /**
     * Create a new controller instance.
     *

     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }

    public function index(Request $request, SystemController $sys) {
        $staff = Models\WorkerModel::query();





        if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $staff->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('category') && trim($request->input('category')) != "") {
            $staff->where("empStatus", $request->input("category", ""));
        }

        if ($request->has('department') && trim($request->input('department')) != "") {
            $staff->where("department", $request->input("department", ""));
        }
        if ($request->has('gender') && trim($request->input('gender')) != "") {
            $staff->where("sex", $request->input("status", ""));
        }
        if ($request->has('marital') && trim($request->input('marital')) != "") {
            $staff->where("marital", $request->input("marital", ""));
        }
         if ($request->has('designation') && trim($request->input('designation')) != "") {
            $staff->where("designation", $request->input("designation", ""));
        }
        if ($request->has('leave') && trim($request->input('leave')) != "") {
            $staff->where("leave", $request->input("leave", ""));
        }
        $data = $staff->orderBy('emp_number')->paginate(500);

        $request->flashExcept("_token");
        $religion = $sys->getReligion();
        $region = $sys->getRegions();
        $department = $sys->getDepartmentList();
         \Session::put('staff', $data);
        return view('staff.index')->with("data", $data)->with("data", $data)
                        ->with('library', $sys->getLibraries())->with('region', $region)->with("department", $department)
                        ->with('religion', $religion)->with("designation", $this->designation());
    }

    public function edit($id,SystemController $sys) {
        $data = Models\WorkerModel::where("id", $id)->firstOrFail();
         $region = $sys->getRegions();
        $department = $sys->getDepartmentList();
        $religion = $sys->getReligion();
        return view('staff.edit')->with('data', $data)->with('region', $region)->with("department", $department)
                        ->with('religion', $religion);
    }

    public function designation() {
          $data= \DB::table('staffs')->groupBy("designation")->orderBy("designation")
                ->lists('designation', 'designation');
         return $data;
    }
    public function create(Request $request, SystemController $sys) {
        $region = $sys->getRegions();
        $department = $sys->getDepartmentList();
        $religion = $sys->getReligion();
        return view('staff.create')
                        ->with('region', $region)->with("department", $department)
                        ->with('religion', $religion);
    }

    public function store(Request $request, SystemController $sys) {
        \DB::beginTransaction();
        $this->validate($request, [
            'department' => 'required',
            'education' => 'required',
            'grade' => 'required',
            'position' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'surname' => 'required',
                 'fname' => 'required',
            'contact' => 'required',
            'residence' => 'required',
        ]);
        try {
            $user = @\Auth::user()->organization;



            $gender = $request->input('gender');
            $category = $request->input('category');

            $dob = $request->input('dob');
            $kname = $request->input('kname');
            $kphone = $request->input('kphone');
            $kaddress = $request->input('kaddress');
            $krelation = $request->input('krelation');


            $grade = $request->input('grade');

            $designation = $request->input('designation');
            $education = $request->input('education');
            $department = $request->input('department');
            $leave = $request->input('leave');

            $residence = $request->input('residence');
            $phone = $request->input('phone');
            $region = $request->input('region');
            $religion = $request->input('religion');
            $residentAddress = $request->input('contact');

            $hometown = $request->input('hometown');

            $title = $request->input('title');

            $fname = $request->input('fname');

            $lname = $request->input('surname');
            $othername = $request->input('othernames');
            $position = $request->input('position');
            $marital = $request->input('marital_status');
            $ssnit = $request->input('ssnit');
            $dependent = $request->input('dependents');
            $joined = $request->input('joined');
            $name = $lname . ' ' . $othername . ' ' . $fname;
            $email = $request->input('email');
            $sql = \DB::table('staff_id')->get();
            $staffNo = $sql[0]->CODE;
            $empNumber = "ASASCO".date("Y") . $staffNo;


            $query = new Models\WorkerModel();
            $query->name = $name;
            $query->title = $title;
            $query->surname = $lname;
            $query->firstname = $fname;
            $query->othernames = $othername;
            $query->sex = $gender;
            $query->dob = $dob;
            $query->address = $residentAddress;
            $query->region = $region;
            $query->religion = $religion;
            $query->hometown = $hometown;
            $query->emp_number = $empNumber;
            $query->empStatus = $category;
            $query->leaves = $leave;
            $query->dateHired = $joined;
            $query->placeofresidence = $residence;
            $query->kinName = $kname;
            $query->kinPhone = $kphone;
            $query->kinAddress = $kaddress;
            $query->kinRelation = $krelation;
            $query->department = $department;
            $query->education = $education;
            $query->grade = $grade;
            $query->position = $position;
            $query->phone = $phone;

            $query->nationality = "GHANAIAN";
            $query->dependentsNo = $dependent;

            $query->designation = $designation;
            $query->ssnit = $ssnit;
            $query->marital = $marital;
 
            $query->email = $email;
          


            if ($query->save()) {
                \DB::table('staff_id')->increment('CODE');
                \DB::commit();

                return response()->json(['status' => 'success', 'message' => $name . ' added successfully ']);
            } else {

                return response()->json(['status' => 'error', 'message' => 'Error adding staff ']);
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    public function directory(Request $request) {
        $query = Models\WorkerModel::query()->paginate(30);
        return view("staff.directory")->with("data", $query);
    }

    public function update(Request $request) {
         \DB::beginTransaction();
        $this->validate($request, [
            'department' => 'required',
            'education' => 'required',
            'grade' => 'required',
            'position' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'surname' => 'required',
            'contact' => 'required',
            'residence' => 'required',
        ]);
        try {
            $user = @\Auth::user()->organization;


            $id = $request->input('id');
            $gender = $request->input('gender');
            $category = $request->input('category');

            $dob = $request->input('dob');
            $kname = $request->input('kname');
            $kphone = $request->input('kphone');
            $kaddress = $request->input('kaddress');
            $krelation = $request->input('krelation');


            $grade = $request->input('grade');

            $designation = $request->input('designation');
            $education = $request->input('education');
            $department = $request->input('department');
            $leave = $request->input('leave');

            $residence = $request->input('residence');
            $phone = $request->input('phone');
            $region = $request->input('region');
            $religion = $request->input('religion');
            $residentAddress = $request->input('contact');

            $hometown = $request->input('hometown');

            $title = $request->input('title');

            $fname = $request->input('fname');

            $lname = $request->input('surname');
            $othername = $request->input('othernames');
            $position = $request->input('position');
            $marital = $request->input('marital_status');
            $ssnit = $request->input('ssnit');
            $dependent = $request->input('dependents');
            $joined = $request->input('joined');
            $name = $lname . ' ' . $othername . ' ' . $fname;
            $email = $request->input('email');
            
            $query=  Models\WorkerModel::where("id",$id)->update(array(
                
                "firstname"=>$fname,
                "surname"=>$lname,
                "othernames"=>$othername,
                "name"=>$name,
                "sex"=>$gender,
                "designation"=>$designation,
                "department"=>$department,
                "position"=>$position,
                "grade"=>$grade,
                "ssnit"=>$ssnit,
                 "phone"=>$phone,
                "placeofresidence"=>$residence,
                "region"=>$region,
                "religion"=>$religion,
                "dob"=>$dob,
                 "address"=>$residentAddress,
                "marital"=>$marital,
                "education"=>$education,
                "hometown"=>$hometown,
                "kinRelation"=>$krelation,
                "kinName"=>$kname,
                "kinAddress"=>$kaddress,
                "kinPhone"=>$kphone,
                "leaves"=>$leave,
                "empStatus"=>$category,
                "dependentsNo"=>$dependent,
                "email"=>$email,
                "title"=>$title,
                "dateHired"=>$joined
                
                
            ));
            

    


            if ($query) {
             
                \DB::commit();

                return response()->json(['status' => 'success', 'message' => $name . ' updated successfully ']);
            } else {

                return response()->json(['status' => 'error', 'message' => 'Error updating staff ']);
            }
        } catch (\Exception $e) {
            \DB::rollback();
        }
    }
    /**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request) {
        Models\WorkerModel::where("id", $request->input("id"))->delete();
        return redirect("/workers")->with("success", "Worker deleted successfully");
    }

}
