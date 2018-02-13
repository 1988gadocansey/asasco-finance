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

class classMemberController extends Controller {

    /**
     * Create a new controller instance.
     *

     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        //  $this->log_query();
    }

    
    public function discharges(Request $request, SystemController $sys) {
        $books = Models\BookModel::query()->where("status","!=","BORROWED");
       
 



        if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $books->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('status') && trim($request->input('status')) != "") {
            $books->where("status", $request->input("status", ""));
        }
         
        $data = $books->orderBy('book_title')->orderBy('status')->paginate(500);

        $request->flashExcept("_token");
 
        return view('books.discharge')->with("data", $data)->with('library', $sys->getLibraries());
                        
    }
    
     public function charges(Request $request, SystemController $sys) {
        $books = Models\BookModel::query()->where("status" ,"BORROWED");
       
 



        if ($request->has('search') && trim($request->input('search')) != "") {
            // dd($request);
            $books->where($request->input('by'), "LIKE", "%" . $request->input("search", "") . "%");
        }
        if ($request->has('status') && trim($request->input('status')) != "") {
            $books->where("status", $request->input("status", ""));
        }
         
        $data = $books->orderBy('book_title')->orderBy('status')->paginate(500);

        $request->flashExcept("_token");
 
        return view('books.charge')->with("data", $data)->with('library', $sys->getLibraries());
                        
    }
    
    public function processClassTeacherReport(Request $request, SystemController $sys) {
         // checked if we are in current or new academic year ie new term or new year
        $array = $sys->getSemYear();
        $term = $array[0]->term;
        $year = $array[0]->year;
        
        $firstSQL = Models\ClassMembersModel::orderBy("id", "DESC")->select("year", "term")->first();
        $years = $firstSQL->year;
        $terms = $firstSQL->term;
        //dd($terms);
         $secondSQL = Models\ClassModel::orderBy("name")->select("name", "nextClass")->get();
       
         foreach ($secondSQL as $row){
               $class[]=$row->name;
                $nextclass[$row->name]=$row->nextClass;
         }
        //$class[]="ALUMNI";
                
     
        $indexno=$request->input("student") ;

        $class_id=$request->input("id") ;
        $attend=$request->input("attendance") ;
        $conduct=$request->input("conduct") ;		
        $attitude=$request->input("attitude") ;		
        $interest=$request->input("interest") ;		
         $form=$request->input("class") ;
        $class_teacher=$request->input("teacher") ;
        $promoted=$request->input("promotion") ;
         $counter=  $request->input("upper") ;
	//dd($counter);	   
   for($i=0;$i<$counter;$i++){
 

        $student=$indexno[$i];

        $id=$class_id[$i];
        $attend_=$attend[$i];
         $conduct_=$conduct[$i];		
        $attitude_=$attitude[$i];		
        $interest_=$interest[$i];		
          $form_=$form[$i];		
       
        $class_teacher_=$class_teacher[$i];
         
        
        $promoted_=$promoted[$i];
 
         
             if($year==$years && $term==$terms){
                 //dd($years);
                     Models\ClassMembersModel::where("id",$id)->update(
                            array(
                                "attendance"=>$attend_,
                                "promotedTo"=>$promoted_,
                                "conduct"=>$conduct_,
                                "interest"=>$interest_,
                                "attitude"=>$attitude_,
                                "form_mast_report"=>$class_teacher_,

                            )
                            );
             
             }
             else{
                 $data=new Models\ClassMembersModel();
                 $data->class=$form_;
                 $data->student=$student;
                 $data->attendance=$attend_;
                 $data->promotedTo=$promoted_;
                 $data->conduct=$conduct_;
                 $data->interest=$interest_;
                 $data->attitude=$attitude_;
                 $data->form_mast_report=$class_teacher_;
                 $data->term=$term;
                 $data->year=$year;
                 $data->save();
                      
                         
               
             }
             
             



        }
        return response()->json(['status'=>'success','message'=>' report successfully saved']);
      

     

    }
    
    public function processHeadMasterReport(Request $request, SystemController $sys) {
         // checked if we are in current or new academic year ie new term or new year
        $array = $sys->getSemYear();
        $term = $array[0]->term;
        $year = $array[0]->year;
        
        $firstSQL = Models\ClassMembersModel::orderBy("year", "DESC")->select("year", "term")->first();
        $years = $firstSQL->year;
        $terms = $firstSQL->term;

         $secondSQL = Models\ClassModel::orderBy("name")->select("name", "nextClass")->get();
       
         foreach ($secondSQL as $row){
               $class[]=$row->name;
                $nextclass[$row->name]=$row->nextClass;
         }
        //$class[]="ALUMNI";
                
      $form=$request->input("class") ;
        $indexno=$request->input("student") ;

        $class_id=$request->input("id") ;
         
         $counter=  $request->input("upper") ;
           $headmaster=$request->input("headmaster") ;
	//dd($headmaster);	   
   for($i=0;$i<$counter;$i++){
 

        $student=$indexno[$i];

        $id=$class_id[$i];
           $form_=$form[$i];
         $headmaster_=$headmaster[$i];
       
        
         
         
             if($year==$years && $term==$terms){
                 //dd($years);
                     Models\ClassMembersModel::where("id",$id)->update(
                            array(
                                
                                "head_mast_report"=>$headmaster_,

                            )
                            );
             
             }
             else{
                 $data=new Models\ClassMembersModel();
                 $data->class=$form_;
                 $data->student=$student;
                 
                 $data->head_mast_report=$headmaster_;
                 $data->term=$term;
                 $data->year=$year;
                 $data->save();
                      
                         
               
             }
             
             



        }
        return response()->json(['status'=>'success','message'=>' report successfully saved']);
      

     

    }
    
    public function processHouseMasterReport(Request $request, SystemController $sys) {
         // checked if we are in current or new academic year ie new term or new year
        $array = $sys->getSemYear();
        $term = $array[0]->term;
        $year = $array[0]->year;
        
        $firstSQL = Models\ClassMembersModel::orderBy("year", "DESC")->select("year", "term")->first();
        $years = $firstSQL->year;
        $terms = $firstSQL->term;

         $secondSQL = Models\ClassModel::orderBy("name")->select("name", "nextClass")->get();
       
         foreach ($secondSQL as $row){
               $class[]=$row->name;
                $nextclass[$row->name]=$row->nextClass;
         }
        //$class[]="ALUMNI";
                
     
        $indexno=$request->input("student") ;

        $class_id=$request->input("id") ;
       		
         $form=$request->input("class") ;
         
        $housemaster=$request->input("housemaster") ;
         $counter=  $request->input("upper") ;
	//dd($counter);	   
   for($i=0;$i<$counter;$i++){
 

        $student=$indexno[$i];

        $id=$class_id[$i];
       		
          $form_=$form[$i];		
       
       $housemaster_=$housemaster[$i];
         
        
 
         
             if($year==$years && $term==$terms){
                 //dd($years);
                     Models\ClassMembersModel::where("id",$id)->update(
                            array(
                                 
                                "house_mast_report"=>$housemaster_,

                            )
                            );
             
             }
             else{
                 $data=new Models\ClassMembersModel();
                 $data->class=$form_;
                 $data->student=$student;
                 
                 $data->house_mast_report=$housemaster_;
                 $data->term=$term;
                 $data->year=$year;
                 $data->save();
                      
                         
               
             }
             
             



        }
        return response()->json(['status'=>'success','message'=>' report successfully saved']);
      

     

    }
    
    
    public function classHouseMasterReport(Request $request, SystemController $sys) {
        
        $array = $sys->getSemYear();
                $term = $array[0]->term;
                $year = $array[0]->year;
                $house=$sys->houses(@\Auth::user()->fund);
                $teacherDetails=$sys->teacherGender();
                $data= \DB::table('classmembers')
                
                 ->join('student', 'student.indexNo', '=', 'classmembers.student')
                ->where('student.house', $house)
                ->where('classmembers.term', $term)
                 ->where('classmembers.year', $year)
                ->where('student.status', "In School")
                         ->where('student.gender', strtoupper($teacherDetails->sex))
                  ->select("student.name" ,"student.indexno","classmembers.id","classmembers.total","classmembers.class","classmembers.attendance"
                          , "classmembers.conduct","classmembers.house_mast_report","classmembers.interest","classmembers.promotedTo","classmembers.attitude","classmembers.position","classmembers.form_mast_report");
                  


       if ($request->has('classs') && trim($request->input('classs')) != "") {
             $data->where("classmembers.class", $request->input("classs", ""));
        }
        
        if ($request->has('term') && trim($request->input('term')) != "") {
            $data->where("classmembers.term", $request->input("term", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
             $data ->where("classmembers.year", $request->input("year", ""));
        }
        
          
        $request->flashExcept("_token");
 
        
         
        $query=  $data->paginate(100);
        
        return view('house.houseMasterReport')->with("data", $query)->with("class",$sys->getClassList())
                        ->with('year', $sys->years())->with("house", $sys->housemaster())
                ;
        
                        
    }

    public function classTeacherRemarks(Request $request, SystemController $sys) {
        
        $array = $sys->getSemYear();
                $term = $array[0]->term;
                $year = $array[0]->year;
                $class=$sys->getTeacherClass(@\Auth::user()->fund);
                $data= \DB::table('classmembers')
                
                 ->join('student', 'student.indexNo', '=', 'classmembers.student')
                ->where('classmembers.class', $class)
                ->where('classmembers.term', $term)
                 ->where('classmembers.year', $year)
                ->where('student.status', "In School")
                     ->select("student.name" ,"student.indexno","classmembers.id","classmembers.total","classmembers.class","classmembers.attendance"
                          , "classmembers.conduct","classmembers.interest","classmembers.form_mast_report","classmembers.house_mast_report","classmembers.promotedTo","classmembers.attitude","classmembers.position","classmembers.form_mast_report");
               


       if ($request->has('classs') && trim($request->input('classs')) != "") {
             $data->where("classmembers.class", $request->input("classs", ""));
        }
        
        if ($request->has('term') && trim($request->input('term')) != "") {
            $data->where("classmembers.term", $request->input("term", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
             $data ->where("classmembers.year", $request->input("year", ""));
        }
        
          
        $request->flashExcept("_token");
 
        
         
        $query=  $data->paginate(100);
        
        return view('classes.classTeacherRemarks')->with("data", $query)->with("class",$sys->getClassList())
                        ->with('year', $sys->years())->with("sem", $term)->with("conduct", $sys->conduct())
                        ->with("interest", $sys->interest())->with("classTeacherReport", $sys->classTeacherReport())
                ->with("attitude", $sys->attitude())->with("form", $sys->forms())
                ;
        
                        
    }

   public function headMastersReport(Request $request, SystemController $sys) {
        
        $array = $sys->getSemYear();
                $term = $array[0]->term;
                $year = $array[0]->year;
                //$class=$sys->getTeacherClass(@\Auth::user()->fund);
                $data= \DB::table('classmembers')
                
                 ->join('student', 'student.indexNo', '=', 'classmembers.student')
                 
                ->where('classmembers.term', $term)
                 ->where('classmembers.year', $year)
                ->where('student.status', "In School")
                  ->select("student.name" ,"student.indexno","classmembers.id","classmembers.total","classmembers.class","classmembers.attendance"
                          , "classmembers.conduct","classmembers.interest","classmembers.head_mast_report","classmembers.form_mast_report","classmembers.house_mast_report","classmembers.promotedTo","classmembers.attitude","classmembers.position","classmembers.form_mast_report");
                  


       if ($request->has('classs') && trim($request->input('classs')) != "") {
             $data->where("classmembers.class", $request->input("classs", ""));
        }
        
        if ($request->has('term') && trim($request->input('term')) != "") {
            $data->where("classmembers.term", $request->input("term", ""));
        }
        if ($request->has('year') && trim($request->input('year')) != "") {
             $data ->where("classmembers.year", $request->input("year", ""));
        }
        
          
        $request->flashExcept("_token");
 
        
         
        $query=  $data->paginate(100);
        
        return view('classes.headMastersReport')->with("data", $query)->with("class",$sys->getClassList())
                        ->with('year', $sys->years())->with("sem", $term)  ;
                
        
                        
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(SystemController $sys) {
        
        return view('books.create')
                         ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SystemController $sys) {

        set_time_limit(36000);
        /* transaction is used here so that any errror rolls
         *  back the whole process and prevents any inserts or updates
         */

        \DB::beginTransaction();
 try {
        $library = @\Auth::user()->organization;


         
        $title = $request->input('title');
        $copyno = $request->input('copyno');

        $status = $request->input('status');
        $category = $request->input('category');
        $edition = $request->input('edition');
        
         
        $publication= $request->input('publication');
        $place = $request->input('place');
        $publisher = $request->input('publisher');

        $copies = $request->input('copies');

        $accention = $request->input('accention');
        
        $isbn = $request->input('isbn');

        $copyright = $request->input('copyright');
        $received = $request->input('received');
        $added = $request->input('added');
        $collation = $request->input('collation');
        
        $class = $request->input('class');
        $format = $request->input('format');
        $location = $request->input('location');
        $type = $request->input('type');
        $author= $request->input('author');
        $series= $request->input('series');
        
        $query = new Models\BookModel();
        $query->book_title = $title;
        $query->copyno = $copyno;
        $query->author= $author;
        $query->category = $category;
        $query->accention_no = $accention;
        $query->date_published=$publication;
        $query->place_of_publication = $place;
        $query->book_copies = $copies;
        $query->book_pub = $publisher;
        $query->isbn = $isbn;
        $query->copyright_year = $copyright;
        $query->date_receive = $received;
        $query->date_added = $added;
        $query->collation= $collation;
        $query->class_mark = $class;
        $query->format = $format;
        $query->series = $series;
        $query->type = $type;
        $query->location= $location;
        
        $query->edition = $edition;
        $query->status = $status;
          
        if ($query->save()) {
            //\DB::table('cardno')->increment('no');
            \DB::commit();

            return response()->json(['status' => 'success', 'message' => $title . ' added successfully ']);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Error adding book ']);
        }
         } catch (\Exception $e) {
            \DB::rollback();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, SystemController $sys, Request $request) {

        

        // make sure only students who are currently in school can update their data
        $query = Models\MemberModel::where('member_id', $id)->first();
        $transaction = @Models\BorrowModel::where('member_id', $id)->first();
         
        return view('members.show')->with('data', $query)
            ->with("transaction",$transaction);
                         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, SystemController $sys, Request $request) {
        //

        $query = Models\BookModel::where('book_id', $id)->firstorFail();



         
        return view('books.edit')->with('data', $query);
                     
                         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
            \DB::beginTransaction();
 try {
        
         
        $title = $request->input('title');
        $copyno = $request->input('copyno');

        $status = $request->input('status');
        $category = $request->input('category');
        $edition = $request->input('edition');
        
         
        $publication= $request->input('publication');
        $place = $request->input('place');
        $publisher = $request->input('publisher');

        $copies = $request->input('copies');

        $accention = $request->input('accention');
        
        $isbn = $request->input('isbn');

        $copyright = $request->input('copyright');
        $received = $request->input('received');
        $added = $request->input('added');
        $collation = $request->input('collation');
        
        $class = $request->input('class');
        $format = $request->input('format');
        $location = $request->input('location');
        $type = $request->input('type');
        $author= $request->input('author');
        $series= $request->input('series');
         $id= $request->input('id');
        $query= Models\BookModel::where("book_id",$id)->update(array(
            
            "book_title"=>$title,
            "copyno"=>$copyno,
            "author"=>$author,
            "edition"=>$edition,
            "category"=>$category,
            "accention_no"=>$accention,
            "date_published"=>$publication,
            "place_of_publication"=>$place,
            "book_copies"=>$copies,
            "book_pub"=>$publisher,
            "isbn"=>$isbn,
            "copyright_year"=>$copyright,
            "date_receive"=>$received,
            "date_added"=>$added,
            "collation"=>$collation,
            "class_mark"=>$class,
            "format"=>$format,
            "series"=>$series,
            "type"=>$type,
            "location"=>$location,
            "status"=>$status
             
            
        ));

        if ($query) {
             
            \DB::commit();

            return response()->json(['status' => 'success', 'message' => $title . ' updated successfully ']);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Error updating book ']);
        }
         } catch (\Exception $e) {
            \DB::rollback();
        }
    }

     
    public function bookUploadForm() {
        return view("books.upload");
    }

    public function uploadBooks(Request $request, SystemController $sys) {

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $user = \Auth::user()->organization;
            $ext = strtolower($file->getClientOriginalExtension());
            $valid_exts = array('csv', 'xls', 'xlsx'); // valid extensions

            $path = $request->file('file')->getRealPath();

            if (in_array($ext, $valid_exts)) {
                $data = Excel::load($path, function($reader) {
                            
                        })->get();

                if (!empty($data) && $data->count()) {
                  
                    foreach ($data as $key => $value) {

                       set_time_limit(36000);
       

         $library = @\Auth::user()->organization;


         
        $title = $value->book_title;
        $copyno = $value->copyno ;

        $status = $value->status ;
        $category =$value->category ;
        $edition = $value->edition ;
        
         
        $publication= $value->date_published ;
        $place = $value->place_of_publication ;
        $publisher = $value->book_pub ;

        $copies = $value->book_copies;

        $accention =$value->accention_no ;
        
        $isbn = $value->isbn ;

        $copyright = $value->copyright_year ;
        $received =$value->date_receive ;
        $added =$value->date_added ;
        $collation =$value->collation ;
        
        $class =$value->class_mark ;
        $format =$value->format ;
        $location = $value->location ;
        $type =$value->type ;
        $author= $value->author;
        $series= $value->series;
        
        $query = new Models\BookModel();
        $query->book_title = $title;
        $query->copyno = $copyno;
        $query->author= $author;
        $query->category = $category;
        $query->accention_no = $accention;
        $query->date_published=$publication;
        $query->place_of_publication = $place;
        $query->book_copies = $copies;
        $query->book_pub = $publisher;
        $query->isbn = $isbn;
        $query->copyright_year = $copyright;
        $query->date_receive = $received;
        $query->date_added = $added;
        $query->collation= $collation;
        $query->class_mark = $class;
        $query->format = $format;
        $query->series = $series;
        $query->type = $type;
        $query->location= $location;
        
        $query->edition = $edition;
        $query->status = $status;
         $query->library= $library;

         $query->save();
            

              }
                    
                 }

  // return response()->json(['status' => 'success', 'message' => $name . ' added successfully ']);
    
          return redirect("/books")->with("success","Books uploaded successfully");
                 } 
             else {
                    return response()->json(['status' => 'error', 'message' => 'Error uploading books ']);
     
               }
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        //
        Models\LibraryModel::where("id",$request->input("id"))->delete();
        return redirect("/books")->with("success","Book deleted successfully");
    }

}
