<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\ProgrammeModel;
use App\Models; 
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
 use Symfony\Component\HttpKernel\Exception\HttpException;

class DepartmentController extends Controller
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
     public function log_query() {
        \DB::listen(function ($sql, $binding, $timing) {
            \Log::info('showing query', array('sql' => $sql, 'bindings' => $binding));
        }
        );
    }
 
    /**
     * Display a list of all of the user's task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function getIndex(Request $request)
    {
        
        return view('departments.index');
    }
    public function anyData(Request $request)
    {
         
        $department = Models\DepartmentModel::select([  'id','name']);


        return Datatables::of($department)
              
             ->addColumn('action', function ($department_) {
                 return "<a href=\"edit_department/$department_->id/id\" class=\"md-btn md-btn-primary md-btn-small md-btn-wave-light waves-effect waves-button waves-light\"><i title='click to edit' class=\"sidebar-menu-icon material-icons md-18\">edit</a>";
            
                //return' <td> <a href=" "><img class="" style="width:70px;height: auto" src="public/Albums/students/'.$student->INDEXNO.'.JPG" alt=" Picture of Employee Here"    /></a>df</td>';
                          
                                         
            })
            ->setRowId('id')
            ->setRowClass(function ($department_) {
                return $department_->id % 2 == 0 ? 'uk-text-success' : 'uk-text-primary';
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

     
    public function create(SystemController $sys) {
       if(@\Auth::user()->role=='Dean' || @\Auth::user()->department=='top'){
         
         return view('departments.create');
         }
        else{
             return redirect("/dashboard");
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
         
      if(@\Auth::user()->role=='Admin' || @\Auth::user()->department=='top'){
//        $this->validate($request, [
//            'name' => 'required',
//         
//        ]);
         
      
      $total=count($request->input('name'));
      $name=$request->input('name');
      
       
      for($i=0;$i<$total;$i++){
         $department=new Models\DepartmentModel();
         $department->name=$name[$i];
         
           
         $department->save();
          
      }
        
        return response()->json(['status'=>'success','message'=>'Department created successfully ']);
      
        
            }
        else{
             return redirect("/dashboard")->with("error","Trying to view a restricted page detected");
        }
          
       
    }
    // show form for edit resource
    public function edit($id, SystemController $sys){
       if(@\Auth::user()->role=='Admin' || @\Auth::user()->department=='top'){
        $department= Models\DepartmentModel::where("id", $id)->firstOrFail();
          return view('departments.edit')->with('data', $department);
                  
         }
        else{
           return redirect("/dashboard")->with("error","Trying to view a restricted page detected");
      
            }
    }

    public function update(Request $request){
     if(@\Auth::user()->role=='Admin' || @\Auth::user()->department=='top'){
       
        \DB::beginTransaction();
        try {
        $name = $request->input('name');
        $id = $request->input('id');
         
        $query = Models\DepartmentModel::where("id", $id)->update(array("name" => $name));
        \DB::commit();
         
  return response()->json(['status'=>'success','message'=>$name. ' Department updated successfully ']);
      
           
         } catch (\Exception $e) {
            \DB::rollback();
        }
        }
        else{
             return redirect("/dashboard")->with("error","Trying to view a restricted page detected");
      
        }
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
          Models\DepartmentModel::where("id",$request->input("id"))->delete();
       // return response()->json(['status'=>'success','message'=> ' Department deleted successfully ']);
  return redirect("/departments")->with("success","department deleted successfully");
    }
}
