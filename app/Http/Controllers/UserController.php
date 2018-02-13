<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Models;
use Validator;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
 
class UserController extends Controller
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
    public function getIndex(Request $request)
    {
        
        return view('users.users');
    }
    public function anyData(Request $request)
    {
         if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Admin"){
        
       
       $staffs = User::join('staffs', 'users.fund', '=', 'staffs.emp_number')
           ->select(['users.id','staffs.name','staffs.emp_number', 'users.name','users.email', 'users.role','users.department']);
         
         }
          

        return Datatables::of($staffs)
                         
             
               
            ->addColumn('Photo', function ($staff) {
               // return '<a href="#edit-'.$student->ID.'" class="md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light">View</a>';
            
                return' <a href="#"><img class="md-user-image-large" style="width:60px;height: auto" src="public/albums/staff/'.$staff->fund.'.jpg" alt=" Picture of Staff Here"    /></a>';
                          
                                         
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
      public function createStaffAccount(Request $request, SystemController $sys)
    { 
        if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Admin"){
        $staffID = $request['staffID'];
         
            $checker = $sys->getStaffAccount($staffID);
            
            $username = $request['name'];
            $confirm = $request['confirm'];
            $department = $request['department'];
            $role = $request['role'];

            $phone = $request['phone'];
            $email = $request['email'];
            $real = strtoupper($request['password']);
            if(!empty($checker[0]->emp_number)){
          //$this->validate($request, [
              $this->validate($request, [
            
            'name' => 'required|max:255',
            'phone' => 'required|max:10',
            'password' => 'required|min:7',
            'staffID' => 'required',
          
        ]);
              User::create([
            'name' => $username,
             'department' =>$department,
                 'role' =>$role,
                  'fund' =>$staffID,
                  'phone' =>$phone,
                 'email' =>$email,
            'password' => bcrypt($real),
        ]);
             
                     return redirect("/power_users")->with("success","<span style='font-weight:bold;font-size:13px;'> Account successfully created for $staffID and password $real  </span> ");
//            
//             }
//             else{
//               return redirect("/power_users")->with("success","<span style='font-weight:bold;font-size:13px;'> Account successfully created for $staffID and password $real  </span> ");
//             }
       }
       else{
           return redirect("/power_users")->with("error","<span style='font-weight:bold;font-size:13px;'> Staff with ID $staffID does not  . </span> ");
           
        }}
        else{
            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
        }
    }

//     public function createStudentAccount(Request $request, SystemController $sys)
//    { 
//        if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Admin"){
//        
//       $checker=  $sys->getStaffAccount($request['username']);
//      
//       $username=$request['username'];
//       $confirm=$request['confirm'];
//       $department=$request['department'];
//       $role=$request['role'];
//       $staffID=$request['staffID'];
//       $real=strtoupper($request['password']);
//       if(!empty($checker)){
//          //$this->validate($request, [
//              $this->validate($request, [
//            
//            'username' => 'required|max:255|unique:users',
//            'password' => 'required|min:7|unique:users',
//        ]);
//             users::create([
//            'username' => $username,
//             'department' =>$department,
//                 'role' =>$role,
//                  'staffID' =>$staffID,
//            'password' => bcrypt($real),
//        ]);
//             if($confirm!=$real){
//                   return redirect("/users")->with("error","<span style='font-weight:bold;font-size:13px;'> Passwords do not match  </span> ");
//         
//             }
//             else{
//               return redirect("/users")->with("success","<span style='font-weight:bold;font-size:13px;'> Account successfully created for $username and password $real  </span> ");
//             }
//       }
//       else{
//           return redirect("/users")->with("error","<span style='font-weight:bold;font-size:13px;'> Staff with indexno $username does not exist . </span> ");
//           
//        }}
//        else{
//            throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');
//        }
//    }
    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
         
       
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
