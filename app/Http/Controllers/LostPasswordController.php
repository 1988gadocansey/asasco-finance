<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

 
class LostPasswordController extends Controller
{
     

    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct()
    {
         
    }
     public function firesms($message,$phone){
          
         
        
        //print_r($contacts);
        if (!empty($phone)&& !empty($message)) {
             
            

                 
                //$key = "83f76e13c92d33e27895";
                $message = urlencode($message);
                $phone=$phone; // because most of the numbers came from excel upload
                 
                 $phone="+233".\substr($phone,-9);
            $url = 'http://txtconnect.co/api/send/'; 
            $fields = array( 
            'token' => \urlencode('a166902c2f552bfd59de3914bd9864088cd7ac77'), 
            'msg' => \urlencode($message), 
            'from' => \urlencode("TPOLY"), 
            'to' => \urlencode($phone), 
            );
            $fields_string = ""; 
                    foreach ($fields as $key => $value) { 
                    $fields_string .= $key . '=' . $value . '&'; 
                    } 
                    \rtrim($fields_string, '&'); 
                    $ch = \curl_init(); 
                    \curl_setopt($ch, \CURLOPT_URL, $url); 
                    \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true); 
                    \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true); 
                    \curl_setopt($ch, \CURLOPT_POST, count($fields)); 
                    \curl_setopt($ch, \CURLOPT_POSTFIELDS, $fields_string); 
                    \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0); 
                    $result2 = \curl_exec($ch); 
                    \curl_close($ch); 
                    $data = \json_decode($result2); 
                    $output=@$data->error;
                    if ($output == "0") {
                   $result="Message was successfully sent"; 
                   
                    }else{ 
                    $result="Message failed to send. Error: " .  $output; 
                     
                    } 
                   
                
                
               
            }
        
    }
   
    /**
     *  
     *
     * @param  Request  $request
     * @return Response
     */
    public function sendNewPassword(Request $request)
    {
        $this->validate($request, [

           
            'email' => 'required|email',
            
             
        ]);
        
        
       $email=$request['email'];
       $sendPass=strtoupper(str_random(7));
       $message="Hi, please use this password  $sendPass to login . Change it immediately after you login.";
       $password = bcrypt(strtoupper($sendPass));
       $query=  \App\User::where('email',$email)->first();
        
        if(!empty($query)){
           if( \App\User::where('email',$email)->update(array('password'=>$password))){
               // fire sms
               
                $this->firesms($message, $query->phone) ;
           }
        }
        else{
              return redirect("/")->withErrors(array("<span style='font-weight:bold;font-size:13px;'>Email or phone number not recognized.. try again </span> "));
         
        }
                
             
         if($query){
              return redirect("/")->with("success","<span style='font-weight:bold;font-size:13px;'>Password reset changed.. </span> ");
         
         }
    }

    /**
     * Create a new task.
     *
     * @param  Request  $request
     * @return Response
     */
     

     
}
