<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models;
use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
 
class PasswordController extends Controller
{
     
    /**
     * Create a new controller instance.
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
    public function getIndex(Request $request, SystemController $sys)
    {
        
        return view('students.passwords')->with("programme",$sys->getProgramByIDList());
    }
    public function anyData(Request $request)
    {
         if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Dean"|| @\Auth::user()->role=="HOD" || @\Auth::user()->role=="Admin"){
        
       
        $students = Models\StudentModel::join('tpoly_programme', 'tpoly_students.PROGRAMMECODE', '=', 'tpoly_programme.PROGRAMMECODE')->join('tpoly_log_portal', 'tpoly_log_portal.username', '=', 'tpoly_students.INDEXNO')
           ->select(['tpoly_students.ID', 'tpoly_students.NAME','tpoly_students.INDEXNO', 'tpoly_programme.PROGRAMME','tpoly_students.LEVEL','tpoly_students.INDEXNO','tpoly_students.STATUS','tpoly_log_portal.real_password']);
         
         }
         else{
              $students = Models\StudentModel::join('tpoly_log_portal', 'tpoly_log_portal.username', '=', 'tpoly_students.INDEXNO')
           ->select(['tpoly_students.ID', 'tpoly_students.NAME', 'tpoly_students.PROGRAMMECODE','tpoly_students.LEVEL','tpoly_students.INDEXNO','tpoly_students.STATUS','tpoly_log_portal.real_password']) 
            ->whereHas('programme', function($q) {
            $q->whereHas('departments', function($q) {
                $q->whereIn('DEPTCODE', array(@\Auth::user()->department));
            });
        });          
                      
         }

        return Datatables::of($students)
                         
             
               ->editColumn('id', '{!! $ID!!}')
            ->addColumn('Photo', function ($student) {
               // return '<a href="#edit-'.$student->ID.'" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>';
            
                return' <a href="#"><img class="md-user-image-large" style="width:60px;height: auto" src="public/albums/students/'.$student->INDEXNO.'.jpg" alt=" Picture of Student Here"    /></a>';
                          
                                         
            })
              
            
            ->setRowId('id')
             
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

     public function createStudentAccount(Request $request, SystemController $sys)
    { 
    $checker=  $sys->getStudent($request['username']);
       
       $username=$request['username'];
       $confirm=$request['confirm'];
        $level=$request['level'];
         $program=$request['program'];
       $real=strtoupper($request['password']);
       if(!empty($checker)){
          //$this->validate($request, [
              $this->validate($request, [
            
            'username' => 'required|max:255|unique:tpoly_log_portal',
            'password' => 'required|min:7|unique:tpoly_log_portal',
                  'level' => 'required'
                   
        ]);
               $str = 'abcdefhkmnprtuvwxyz234678';
                    $shuffled = str_shuffle($str);
                    $vcode = substr($shuffled,0,9);
                   $real=strtoupper($vcode);
             Models\PortalPasswordModel::create([
            'username' => $username,
             'real_password' =>$real,
                  'level' =>$level,
                 'programme' =>$program,
            'password' => bcrypt($real),
        ]);
             if($confirm!=$real){
                   return redirect("/search_password")->with("error","<span style='font-weight:bold;font-size:13px;'> Passwords do not match  </span> ");
         
             }
             else{
               return redirect("/search_password")->with("success","<span style='font-weight:bold;font-size:13px;'> Account successfully created for $username and password $real  </span> ");
             }
       }
       else{
           return redirect("/search_password")->with("error","<span style='font-weight:bold;font-size:13px;'> Student with indexno $username does not exist . </span> ");
           
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
         
       
    }
     public function showChange(Request $request)
    {
          return view('users.reset');
       
    }
     public function reset(Request $request)
    {
         $this->validate($request, [

            'oldPass' => 'required',
            'password' => 'required|min:7',
            'confirm' => 'required|min:7',
             
        ]);
        $checker= @\Auth::user()->password;
     
       $user= @\Auth::user()->id;
       $password=$request['password'];
       $oldPassword=$request['oldPass'];
       $confirm=$request['confirm'];
         //NB bycrpt always change per seconds so we can't do $password==$checker ..IMPOSSIBLE
      if(\Hash::check($oldPassword, $checker)){
       if($password==$confirm){
         $query=  \App\User::where('id',$user)->update(array('password'=>bcrypt($password)));
             
         if($query){
              return redirect("/logout")->with("success","<span style='font-weight:bold;font-size:13px;'>Password successfully changed.. </span> ");
         
         }
       }
       else{
           return redirect("/change_password")->with("error","<span style='font-weight:bold;font-size:13px;'>Password do not match . </span> ");
           
       }
      }
      else{
           return redirect("/change_password")->with("error","<span style='font-weight:bold;font-size:13px;'> This password does not exist . </span> ");
        
      }
       
    }
    // show form for edit resource
    public function edit($id){
        }

    public function update(Request $request, $id){
        
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
        
    }
}
