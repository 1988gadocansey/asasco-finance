<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\StudentModel;
use App\Models\ProgrammeModel;
use App\Models;
use App\User;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Excel;

class ClassController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request, SystemController $sys) {
        if ($request->isMethod("get")) {
            if ($request->user()->isSupperAdmin || @\Auth::user()->department == "top") {

                $class = Models\ClassModel::query();
            }

            if ($request->has('teacher') && trim($request->input('teacher')) != "") {
                $class->where("teacherID", $request->input("teacher", ""));
            }
            if ($request->has('search') && trim($request->input('search')) != "") {
                $class->where("name", $request->input("search", ""));
            }
            $data = $class->orderBy("name")->paginate(100);

            $request->flashExcept("_token");

            return view("classes.index")->with("data", $data)->with("teacher", $sys->getLectureList_All())->with("class", $sys->getClassList());
        } else {

            \DB::beginTransaction();
            try {

                $this->validate($request, [
                    'name' => 'required',
                     
                    'teacher' => 'required',
                ]);

                $name=$request->input('name');
                $array = $sys->getSemYear();
                $sem = $array[0]->term;
                $year = $array[0]->year;
                $class = new Models\ClassModel();
                $class->teacherId = $request->input('teacher');
                $class->nextClass = $request->input('next');
                $class->name = $request->input('name');
                $class->year = $year;
                $class->year = $sem;
                if ($class->save()) {
                    \DB::commit();

                    return redirect("/classes")->with("success", " <span style='font-weight:bold;font-size:13px;'>$name successfully created</span> ");
                } else {

                    return redirect("/classes")->with("error", " <span style='font-weight:bold;font-size:13px;'>Error saving $name !</span> ");
                }
            } catch (\Exception $e) {
                \DB::rollback();
            }
        }
    }

   // show form for edit resource
    public function edit(Request $request,$edit,SystemController $sys){
        if (@\Auth::user()->department == 'top' || @\Auth::user()->role == 'HOD' || @\Auth::user()->role == 'Support') {
           

                $class= Models\ClassModel::where("id", $edit)->firstOrFail();
                
                return view('classes.edit')->with('data', $class)->with("key",$edit)
                                ->with("teacher", $sys->getLectureList_All())->with("class", $sys->getClassSelectBoxEdit())
                                  ;
        }
        else{
            // throw new HttpException(Response::HTTP_UNAUTHORIZED, 'This action is unauthorized.');

            return redirect("/dashboard");
        }
    }
    
     public function update(Request $request, SystemController $sys){
         $this->validate($request, [


                    'next' => 'required',
                    'name' => 'required',
                    'teacher' => 'required',
                    
                ]);
                     $id=$request->input("id");
                  $name=$request->input("name");
                    $nextClass=$request->input("next");
                    $teacher=$request->input("teacher");
                   // dd($program);
                \DB::beginTransaction();
                try {
                   
                    $query = @Models\ClassModel::where("id", $id)->update(array("name" => $name, "nextClass" => $nextClass, "teacherId" => $teacher));
                    \DB::commit();
                  
                       if( $query){
                        return response()->json(['status'=>'success','message'=>$name.' edited successfully ']);
      
                       }
                       else{
                           return response()->json(['status'=>'error','message'=>$name.' editing failed. try again ']);
       
                       }
                    
                } catch (\Exception $e) {
                    \DB::rollback();
                }
           
     }
    
    
    public function destroy(Request $request,   SystemController $sys)
    {
        //dd($request->input("id"));
       if(@\Auth::user()->role=='Admin' ||  @\Auth::user()->department=='top'){
            
            
            $query1= Models\StudentModel::where('currentClass',$request->input("id"))->count();
             
          
            
             if($query1==0){
                   
                $query1= Models\ClassModel::where('name',$request->input("id"))->delete();
            
                  \DB::commit();
               return redirect("/classes")->with("success","<span style='font-weight:bold;font-size:13px;'> Class  successfully deleted!</span> ");
         
             }
             else{
                 
                  
               return redirect("/classes")->with("error","<span style='font-weight:bold;font-size:13px;'>Whoops!! you cannot delete this class because it contains students .. In order to delete this,first move all the students in this class into another class</span> ");
             }
            
          } 
//          
           
        
       else {
           // abort(434, "{!!<b>Unauthorize Access detected</b>!!}");
            redirect("/dashboard");
        }
         
    }
}
