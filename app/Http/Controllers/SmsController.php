<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Auth;
use DB;
use Response;

class SmsController extends Controller
{
    /**
     * Create a new controller instance.
     *

     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        //  $this->log_query();
    }
    public function smsMember(Request $request, SystemController $sys) {
        ini_set('max_execution_time', 6000); //300 seconds = 5 minutes
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
 
        public function smsStaff(Request $request, SystemController $sys) {
        ini_set('max_execution_time', 6000); //300 seconds = 5 minutes
        $message = $request->input("message", "");
        $query = \Session::get('staff');



        foreach ($query as $rtmt => $member) {
             
            $newstring = str_replace("]", "", "$message");
            $finalstring = str_replace("[", "$", "$newstring");
            eval("\$finalstring =\"$finalstring\" ;");
            if ($sys->firesms($finalstring, $member->phone, $member->emp_number)) {
                \Session::forget('staff');
              
                 } else {
                
                    
                 }
        }
             return response()->json(['status' => 'success', 'message' =>   ' sms sent successfully ']);
        
        
    }
    
     public function alert(Request $request, SystemController $sys) {
        ini_set('max_execution_time', 6000); //300 seconds = 5 minutes
        $message = $request->input("message", "");
        $query = \Session::get('query');

 $sql= \DB::table('transactions')->join('member','transactions.member_id', '=', 'member.member_id')->where("borrow_status",$query)->select("member.contact","member.name","member.cardNo")->get();
       

        foreach ($sql as $data=> $member) {
            $name= $member->name;
             
            $phone = $member->contact;
            $cardNo = $member->cardNo;
             
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
} 