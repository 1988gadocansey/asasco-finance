<?php

namespace App\Http\Controllers;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models;
use App\User;
use App\Models\AcademicRecordsModel;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;


class SettingsController extends Controller
{
   

    /**
     * Create a new controller instance.
     *
     *  
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        
    }

    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function index(Request $request)
    {
        return view('settings.index');
    }
     public function showSync(Request $request)
    {
        return view('settings.sync');
    }
    public function updateProfile(Request $request) {
        $phone=$request->input("phone");
       $query= User::where("id",@\Auth::user()->id)->update(array("phone"=>$phone));
       if($query){
           return redirect("/dashboard")->with("success", " <span style='font-weight:bold;font-size:13px;'> Phone Number updated successfully </span> ");;
       }
    else{
        return redirect()->back();
    }
        
    }
    public function logs(Request $request,SystemController $sys)
    {
          $log= Models\ActivityModel::query() ;
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("PROGRAMME", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("COURSE_LEVEL", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("COURSE_SEMESTER", "=", $request->input("semester", ""));
        }
         
        
        $data = $log->orderBy('created_at')->paginate(500);
        
        $request->flashExcept("_token");
          
         
        return view('settings.log')->with("data", $data);
                         
    }
    public function smsLogs(Request $request,SystemController $sys)
    {
          $sms= Models\MessagesModel::query() ;
         if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $courses->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('program') && trim($request->input('program')) != "") {
            $courses->where("PROGRAMME", $request->input("program", ""));
        }
        if ($request->has('level') && trim($request->input('level')) != "") {
            $courses->where("COURSE_LEVEL", $request->input("level", ""));
        }
        if ($request->has('semester') && trim($request->input('semester')) != "") {
            $courses->where("COURSE_SEMESTER", "=", $request->input("semester", ""));
        }
         
        
        $data = $sms->orderBy('dates')->paginate(500);
        
        $request->flashExcept("_token");
          
         
        return view('settings.sms')->with("data", $data);
                         
    }
    public function updateUsers(Request $request) {
        if ($request->isMethod("get")) {

                return view('users.update');
            } else {

                set_time_limit(36000);
                 $file = $request->file('file');
            
                $ext = strtolower($file->getClientOriginalExtension());
                 $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions
              
                    if (in_array($ext, $valid_exts)) {
                        // Moves file to folder on server
                        // $file->move($destination, $name);

                        $path = $request->file('file')->getRealPath();
                        $data = Excel::load($path, function($reader) {
                                    
                                })->get();
                      //  $total = count($data);

                        if (!empty($data) && $data->count()) {
                            foreach ($data as $value => $row) {
                               
                                $staff = $row->staff;
                                $position = $row->position;
                                $phone = $row->phone;
                                $department = $row->department;
                                $email = $row->email;
                                
                                User::where("fund",$staff)->update(array("phone"=>$phone,"role"=>$position,
                                        "department"=>$department,"email"=>$email
                                        ));
                            }
                        }
                    }
                    else{
                        dd("File format not support. Only Excel file is allowed");
                    }
            }
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
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
