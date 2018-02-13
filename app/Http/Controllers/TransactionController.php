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

class TransactionController extends Controller
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
     public function showForm() {
        return view('transactions.profile');
    }
 
    public function index(Request $request, SystemController $sys) {
        $sql= Models\BorrowModel::query();
       
  
         
        if ($request->has('status') && trim($request->input('status')) != "") {
            $sql->where("borrow_status", $request->input("status", ""));
        }
         
         if ($request->has('from_date') && $request->has('to_date')) {
            //$fee->whereBetween('TRANSDATE', [$request->input('from_date'), $request->input('to_date')]);
            $sql->whereBetween(\DB::raw('DATE(timestamp)'), array($request->input('from_date'), $request->input('to_date')));
        }
         
        $data = $sql->orderBy('due_date')->paginate(500);

        $request->flashExcept("_token");
    \Session::put('query', $request->input('status'));
        return view('transactions.index')->with("data", $data)
                       ;
    }
    public function showMember(Request $request) {
        $student=  explode(',',$request->input('q'));
        $student=$student[0];
        
        $sql= Models\StudentModel::where("indexNo",$student)->get();
        //dd($sql);
         $data= Models\BookModel::where("status","!=","BORROWED")->select("book_title","book_id","author","edition","book_pub","isbn")->get();
        //dd($data);
         return view("transactions.process")->with("data",$sql)->with("sql", $data);
    }
     
     public function showReturn(Request $request) {
        $student=  explode(',',$request->input('q'));
        $student=$student[0];
        
        $sql= Models\MemberModel::where("cardNo",$student)->get();
        
       // $data= Models\BookModel::where("status","=","BORROWED")->where("member_id",$student)->lists("book_title","book_id");
            $data= \DB::table('transactions')->join('books','transactions.book_id', '=', 'books.book_id')->where("status","=","BORROWED")->where("borrow_status","=","pending")->where("member_id",$student)->lists("books.book_title","transactions.book_id");
          
         return view("transactions.return")->with("data",$sql)->with("sql", $data);
    }
      /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request, SystemController $sys)
    {
        $user=@\Auth::user()->fund;
      $total=count($request->input('book'));
      $book=$request->input('book');
      $phone=$request->input('phone');
      $name=$request->input('name');
        $member=$request->input('member');
      $date= date('d/m/Y', strtotime("+7 days"));  // add 7 days to current date
     //  dd($request);
      for($i=0;$i<$total;$i++){
         $query=new Models\BorrowModel();
        
         $query->book_id=$book[$i];
           $query->member_id=$member;
             $query->librarian=$user;
           $query->borrow_status="pending";
           $query->due_date=$date;
           $query->user=$user;
         $query->save();
         @Models\BookModel::where("book_id",$book[$i])->update(array("status"=>"BORROWED"));
      }
      $message="Hi $name thanks for visiting our library. Date for returning the books is ".$date;
      @$sys->firesms($message, $phone, $member);
        
        return response()->json(['status'=>'success','message'=>'Book borrowed  successfully ']);
      
        
          
          
    }
     public function storeReturn(Request $request, SystemController $sys)
    {
        $user=@\Auth::user()->fund;
      $total=count($request->input('book'));
      $book=$request->input('book');
      $phone=$request->input('phone');
      $name=$request->input('name');
        $member=$request->input('member');
      $date= \Carbon\CarbonInterval::create($week=1)->fn();
       
      for($i=0;$i<$total;$i++){
          
          
        @Models\BorrowModel::where("book_id",$book[$i])->update(array("borrow_status"=>"returned"));
         @Models\BookModel::where("book_id",$book[$i])->update(array("status"=>"AVALIABLE"));
      }
      $message="Hi $name thanks for returning books to the library thanks.";
      @$sys->firesms($message, $phone, $member);
        
        return response()->json(['status'=>'success','message'=>'Book returned successfully ']);
      
        
          
          
    }
     public function smsMember(Request $request, SystemController $sys) {
        ini_set('max_execution_time', 3000); //300 seconds = 5 minutes
        $message = $request->input("message", "");
        $query = \Session::get('members');



        foreach ($query as $rtmt => $member) {
            $name= $member->name;
             
            $cardno = $member->cardno;
            $status = $member->status;
            $category = $member->category;
            
            $newstring = str_replace("]", "", "$message");
            $finalstring = str_replace("[", "$", "$newstring");
            eval("\$finalstring =\"$finalstring\" ;");
            if ($sys->firesms($finalstring, $member->contact, $member->cardno)) {
                \Session::forget('members');
              
                 } else {
                
                    
                 }
        }
             return response()->json(['status' => 'success', 'message' =>   ' sms sent successfully ']);
        
        
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
