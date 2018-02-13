<?php

namespace App\Http\Controllers;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Models\MessagesModel; 
use App\Models; 
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
 
class SystemController extends Controller
{
     
    /**
     * Create a new controller instance.
     *
     * @param  TaskRepository  $tasks
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        
    }
   public function getPhone($stuId){
     $data= \DB::table('student')->where("indexNo",$stuId)->first();
     return $data->parentPhone;
             
     
 }
 public function getIndexNo1($program){
          
        $data= \DB::table('classes')->where("name",$program)->first();
     return $data->name.'-'.date("y");
    
    }
 public function getName($stuId){
     $data= \DB::table('student')->where("indexNo",$stuId)->first();
     return $data->name;
             
     
 }
 public function getCourseGrade($courseId,$year,$term,$student) {
     
     $data= \DB::table('assesmentsheet')->where("indexNo",$student)
             ->where("year",$year)
             ->where("term",$term)
             ->where("courseCode",$courseId)
             ->select("total")
             ->first();
     
     return @$data->total;
     
  }
 public function getShortCode($course) {
     $data= \DB::table('courses')->where("code",$course)->first();
     return $data;
     
 
  }
     public function getLibraries() {
        $library = Models\LibraryModel::
                select('name', 'id')->orderBy("name")->get();
         return $library;
       
    }
     public function getProgramList2() {
         $program= Models\ProgrammeModel::orderBy("name")->
                pluck('name', "code");
         return $program;
       
         
    }
    public function getSignature($teacher){
         
        
        $query=  \DB::table('staffs')->where("emp_number",$teacher)->select("firstname","surname")->first();
         
        
        $fname=  str_split(@$query->firstname);
                                   $f= $fname[0];
				 $lname=  str_split(@$query->surname);
                                 $l=$lname[0];
                                  
                                 return $f.'.'.$l;
                              
     
    }

    public function age($birthdate, $pattern = 'eu')
        {
            $patterns = array(
                'eu'    => 'd/m/Y',
                'mysql' => 'Y-m-d',
                'us'    => 'm/d/Y',
                'gh'    => 'd-m-Y',
            );

            $now      = new \DateTime();
            $in       = \DateTime::createFromFormat($patterns[$pattern], $birthdate);
            $interval = $now->diff($in);
            return $interval->y;
        }
     public function getReligion() {
         $religion = \DB::table('religion')
                ->pluck('religion', 'religion');
        return $religion;
    }
    public function getCountry() {
         $country = \DB::table('countries')->orderBy("name")->orderBy('name')
                ->pluck('name', 'name');
        return $country;
    }
    
     public function getRegions() {
         $region = \DB::table('regions')
                ->pluck('Name', 'Name');
        return $region;
    }
    public function getProgramByIDList() {
      if( @\Auth::user()->department=='top' || @\Auth::user()->role=='FO'){
       
         $program = \DB::table('programme')->orderBy("PROGRAMME")
                ->pluck('PROGRAMME', 'ID');
         return $program;
      }
      else{
         // $user_department= @\Auth::user()->department;
         $program = \DB::table('programme')->orderBy("PROGRAMME")
                ->pluck('PROGRAMME', 'ID');
         return $program;
      }
         
    }
     public function getDepartmentByIDList() {
         
       if( @\Auth::user()->department=='top'|| @\Auth::user()->role=='FO'){
         $department = \DB::table('tpoly_department')->orderBy("DEPARTMENT")
                ->pluck('DEPARTMENT', 'ID');
         return $department;
       }
       elseif( @\Auth::user()->role=='Registrar' ){
         $user_department= @\Auth::user()->department;
           $department = \DB::table('tpoly_department')->where('FACCODE',$user_department)->orderBy("DEPARTMENT")
                ->pluck('DEPARTMENT', 'ID');
         return $department;
        }
       else{
             $user_department= @\Auth::user()->department;
           $department = \DB::table('tpoly_department')->where('DEPTCODE',$user_department)
                ->pluck('DEPARTMENT', 'ID');
         return $department;
       }
         
    }
    public function getDepartmentList() {
        if(@\Auth::user()->role=='Registrar'){
         $department = \DB::table('departments')->where('deptcode',@\Auth::user()->department)->orderBy("deptcode")
                ->pluck('name', 'deptcode');
         return $department;
        }
        elseif(@\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Lecturer' ){
            $department = \DB::table('departments')->where('deptcode',@\Auth::user()->department)->orderBy("deptcode")
                 ->pluck('name', 'deptcode');
         return $department;
        }
        else{
            $department = \DB::table('departments')->orderBy("deptcode")
                ->pluck('name', 'deptcode');
         return $department;
        }
    }
    public function getGradeSystemIDList() {
         
         
         $grade = \DB::table('gradingsystem')
                ->pluck('type', 'type');
         return $grade;
       
         
    }
    public function getIndexNo($stuId) {
        $sql= \DB::table('student')->where("id",$stuId)->first();
        return $sql->indexNo;
    }
    public function getHouseList() {
         
         
         $school = \DB::table('house')->orderBy("house")
                ->pluck('house', 'house');
         return $school;
       
         
    }
    public function getClasssList() {
         
         
         $school = \DB::table('house')->orderBy("house")
                ->pluck('house', 'house');
         return $school;
       
         
    }
     public function geSubjectCombinations() {
         
         
         $combination = \DB::table('subjectcombination')->orderBy("Combination")
                ->pluck('Combination', 'Combination');
         return  $combination;
       
         
    }
    public function getTotalGenderByHouse($house,$gender) {
         
         
         $total= \DB::table('student')->where("house",$house)->where("gender",$gender)
                ->count();
         return $total;
       
         
    }
    
    public function getProgrammeTypes() {
         
         
         $school = \DB::table('programme')->where("TYPE","!=","")->groupBy("TYPE")->orderBy("TYPE")
                ->pluck('TYPE', 'TYPE');
         return $school;
       
         
    }
     public function getStudentProgram($program) {
         
         
         $info = \DB::table('programme')->where("code",$program)->first();
               
         return $info->name;
            
         
    }
    public function getStudentAccountInfo($indexno) {
         
         
         $info = \DB::table('tpoly_log_portal')->where("username",$indexno)->first();
             if(!empty($info )){    
         return $info->biodata_update;
             }
         
    }
    public function getYearBill($year,$level,$program) {
         
         
         $fee = \DB::table('tpoly_bills')->where("PROGRAMME",$program)
                 ->where('LEVEL',$level)
                  ->where('YEAR',$year)
                 ->first();
         
                if(!empty($fee)){
         return $fee->AMOUNT;
                }
                else{
                   throw new HttpException(Response::HTTP_UNAUTHORIZED, 'The program that you are adding the student does not have school fees in the system.create the school fee for the program first. Go back');
      
                    }
       
         
    }
    public function getYearBillInject($year,$level,$program) {
         
         
         $fee = \DB::table('tpoly_bills')->where("PROGRAMME",$program)
                 ->where('LEVEL',$level)
                  ->where('YEAR',$year)
                 ->first();
         
                if(!empty($fee)){
         return $fee->AMOUNT;
                }
                else{
                  return 0;
                    }
       
         
    }
    public function graduatingGroup($indexNo) {
         $index= @explode("-",$indexNo);
         
         $group_="20".($index[1] + 3)."/"."20".($index[1] + 4);
         
         return @$group_;
               
    }
    public function getProgramDepartment($program){
        
        $department = \DB::table('programme')->where('PROGRAMMECODE',$program)->get();
                 
        return @$department[0]->DEPTCODE;
     
    }
     public function getClass($cgpa){
        
        $class = \DB::table('tpoly_classes')->where('lowerBoundary','<=',$cgpa)
                ->where("upperBoundary",">=",$cgpa)
                ->first();
                 
        return @$class->class;
     
    }
    public function getLecturer($lecturer){
        
        $staff = \DB::table('staffs')->where('emp_number',$lecturer)->get();
                 
        return @$staff;
     
    }
    public function getLecturerFromStaffID($lecturer){
        
        $staff = @\DB::table('tpoly_staffs')->where('emp_number',$lecturer)->get();
                 
        return @$staff[0]->id;
     
    }

    public function getDepartmentName($deptCode){
        
        $department = \DB::table('tpoly_department')->where('DEPTCODE',$deptCode)->get();
                 
        return @$department[0]->DEPARTMENT;
     
    }
    
    
    public function getSchoolCode($dept){
        
        $school = \DB::table('tpoly_department')->where('DEPTCODE',$dept)->get();
                 
        return @$school[0]->FACCODE;
     
    }
    public function courseSearchByCode() {

        $course = \DB::table('tpoly_courses')->get();
                
         foreach($course as $p=>$value){
             $courses[]=$value->COURSE_CODE;
         }
         return $courses;
    }
    public function programmeSearchByCode() {

        $program = \DB::table('programme')->get();
                
         foreach($program as $p=>$value){
             $programs[]=$value->code;
         }
         return $programs;
    }
    public function programmeCategorySearchByCode() {

        $program = \DB::table('programme')->get();
                
         foreach($program as $p=>$value){
             $programs[]=$value->SLUG;
         }
         return $programs;
    }
    public function studentSearchByIndexNo($program) {

        $arr = \DB::table('tpoly_students')->where("PROGRAMMECODE",$program)->get();
       //dd($arr);
         foreach($arr as $p=>$value){
             $objects[]=$value->INDEXNO;
         }
         return $objects;
    }
    public function studentSearchByCode($year,$sem,$course,$student) {

        $studentArr= @\DB::table('tpoly_academic_record')->where('year',$year)
        ->where('term',$sem)
        ->where('courseCode',$course)
        ->where('indexno',$student)
        ->get();

           if(!empty($studentArr)){      
             foreach($studentArr as $p=>$value){
                 $array[]=$value->indexno;
             }
             return @$array;
            }
            else{

            }
    }
    
     public function getSchoolName($dept){
        
        $faculty = \DB::table('tpoly_faculty')->where('FACCODE',$dept)->get();
                 
        return @$faculty[0]->FACULTY;
     
    }
     public function getProgrammeMinCredit($program) {
          $programme = \DB::table('programme')->where('PROGRAMMECODE',$program)->get();
                 
        return @$programme[0]->MINCREDITS;
    }
    public function getProgramCode($name){
        
        $programme = \DB::table('programme')->where('name',$name)->get();
                 
        return @$programme[0]->code;
     
    }
    public function getProgramName($code){
        
        $programme = \DB::table('programme')->where('code',$code)->get();
                 
        return @$programme[0]->name;
     
    }
      
    
     
    // this is purposely for select box 
    public function getProgramList() {
//        if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Accountant"|| @\Auth::user()->department=="Finance" ){
//         $program = \DB::table('programme')->orderby("name")
//                ->pluck('name', 'code');
//         return $program;
//        }
//        elseif( @\Auth::user()->role=='lecturer' ){
//         $user_school= @\Auth::user()->department;
//              $program = \DB::table('programme')->join('departments','departments.deptCode', '=', 'programme.deptCode')->where('departments.deptCode',$user_school)->orderby("programme.name")->pluck('programme.name', 'programme.code');
//             return $program;
//         
//         
//        }
//        else{
//              $user_department= @\Auth::user()->department;
//              $program = \DB::table('programme')->where('deptCode',$user_department)->orderby("name")
//                ->pluck('name', 'code');
//         return $program;
//        }
          $program = \DB::table('programme')->orderby("name")
                ->pluck('name', 'code');
         return $program;
    }
    public function interest() {
        $interest = \DB::table('interest')->orderby("interest")
                ->select('interest', 'interest')->get();
         return $interest;
    
    }
    public function conduct() {
        $conduct = \DB::table('conduct')->orderby("con")
                ->select('con', 'con')->get();
         return $conduct;
    
    }
    public function forms() {
        $form = \DB::table('classes')->orderby("name")
                ->select('name', 'name')->get();
         return $form;
    
    }
     public function housemaster() {
        $form = \DB::table('housemasterreport')->orderby("con")
                ->select('con', 'con')->get();
         return $form;
    
    }
    public function attitude() {
        $attitude = \DB::table('attitude')->orderby("att")
                ->select('att', 'att')->get();
         return $attitude;
    
    }
    public function classTeacherReport() {
        $conduct = \DB::table('classteacherreport')->orderby("con")
                ->select('con', 'con')->get();
         return $conduct;
    
    }
    
     public function getClassList() {
//        if( @\Auth::user()->department=='top' || @\Auth::user()->role=="Accountant"|| @\Auth::user()->department=="Finance" ){
//         $class = \DB::table('classes')->groupBy('name')->orderby("name")
//                ->pluck('name', 'name');
//         return $class;
//        }
//        elseif( @\Auth::user()->role=='lecturer' ){
//          $user_class= @\Auth::user()->classes;
//              $program = \DB::table('classes')->where('name',$user_class)->groupBy('name')->orderby("name")
//                ->pluck('name', 'name');
//         return $class;
//         
//        }
//        else{
//             $user_class= @\Auth::user()->classes;
//              $class = \DB::table('classes')->where('name',$user_class)->groupBy('name')->orderby("name")
//                ->pluck('name', 'name');
//         return $class;
//        }
           $class = \DB::table('classes')->groupBy('name')->orderby("name")
                ->pluck('name', 'name');
         return $class;
    }
    
    
    
    
     public function totalRegistered($sem,$year,$course,$level,$lecturer) {
if(@\Auth::user()->role=='Lecturer' || @\Auth::user()->role=='HOD' ||@\Auth::user()->role=='Dean'){
        
        $query=Models\AcademicRecordsModel::where('term',$sem)
                ->where('year',$year)
                ->where('class',$level)

                ->where('staff',$lecturer)
                ->where('courseCode',$course)->get();
            }
            else{
                  $query=Models\AcademicRecordsModel::where('term',$sem)
                ->where('year',$year)
                ->where('class',$level)

                
                ->where('courseCode',$course)->get();
            }
                
        return count($query);
            
    }
    public function years() {

        for ($i = 2016; $i <= 2018; $i++) {
            $year = $i - 1 . "/" . $i;
            $years[$year] = $year;
        }
        return $years;
    }

    // this is purposely for select box 
    public function getCourseList() {
         $course = \DB::table('courses')->where("name","!=","")->orderBy("name")->pluck("name","code");
                return $course;
       
         
    }
    
    public function getMountedCourseList() {
 
         $query= Models\CourseModel::where("code","!=","")->list("code","name");
         return $query;
             
         
    }
    public function getMountedCourseListLecturer($staffID) {
 $array=  $this->getSemYear();
     $term=$array[0]->term;
   $year=$array[0]->year;
         $query= \DB::table('subjectallocations')->where("subject","!="," ")
                 ->where("year",$year)
                 ->where("term",$term)
                 ->where("teacherId",$staffID)->pluck("subject","subject");
         return $query;
             
         
    }
    // this is purposely for select box 
    public function getLectureList() {
        
         $lecturer = \DB::table('staffs')->where('designation','Teacher')
                  ->orderby("Name")
                ->pluck('name', 'emp_number');
         return $lecturer;
       
         
    }
     public function getLectureListAllocation() {
        
         $lecturer = \DB::table('staffs')->select('name', 'emp_number')->where('designation','Teacher')
                  ->orderby("name")->get();
                
         return $lecturer;
       
         
    }
     public function getLectureList_All() {
        
         $lecturer = \DB::table('staffs')->orderby("Name")
                 
                ->pluck('name', 'emp_number');
         return $lecturer;
       
         
    }
     public function getClassSelectBoxEdit() {
        
         $class = \DB::table('classes')->orderby("Name")
                 
                ->pluck('name', 'name');
         return $class;
       
         
    }
     // this is purposely for select box 
    public function getUsers() {
         $user= \DB::table('users')
                ->pluck('name', 'id');
         return $user;
       
         
    }
    public function department() {
         $department= \DB::table('departments')->orderby("name")
                ->pluck('name', 'deptCode');
         return $department;
       
         
    }
    public function WASSCE_Grades() {
         $grade= \DB::table('waecgrades')
                ->pluck('grade', 'grade');
         return $grade;
       
         
    }
    
//     public function firesms($message,$phone,$receipient){
//          
//         
//        
//        //print_r($contacts);
//        if (!empty($phone)&& !empty($message)&& !empty($receipient)) {
//            //$sender = "TPOLY-FEES";
//                 
//                //$key = "83f76e13c92d33e27895";
//                $message = urlencode($message);
//                $phone=$phone; // because most of the numbers came from excel upload
//                 
//                 $phone="+233".\substr($phone,1,9);
//            $url = 'http://txtconnect.co/api/send/'; 
//            $fields = array( 
//            'token' => \urlencode('a166902c2f552bfd59de3914bd9864088cd7ac77'), 
//            'msg' => \urlencode($message), 
//            'from' => \urlencode("TPOLY"), 
//            'to' => \urlencode($phone), 
//            );
//            $fields_string = ""; 
//                    foreach ($fields as $key => $value) { 
//                    $fields_string .= $key . '=' . $value . '&'; 
//                    } 
//                    \rtrim($fields_string, '&'); 
//                    $ch = \curl_init(); 
//                    \curl_setopt($ch, \CURLOPT_URL, $url); 
//                    \curl_setopt($ch, \CURLOPT_RETURNTRANSFER, true); 
//                    \curl_setopt($ch, \CURLOPT_FOLLOWLOCATION, true); 
//                    \curl_setopt($ch, \CURLOPT_POST, count($fields)); 
//                    \curl_setopt($ch, \CURLOPT_POSTFIELDS, $fields_string); 
//                    \curl_setopt($ch, \CURLOPT_SSL_VERIFYPEER, 0); 
//                    $result2 = \curl_exec($ch); 
//                    \curl_close($ch); 
//                    $data = \json_decode($result2); 
//                    $output=@$data->error;
//                    if ($output == "0") {
//                   $result="Message was successfully sent"; 
//                   
//                    }else{ 
//                    $result="Message failed to send. Error: " .  $output; 
//                     
//                    } 
//                     
//                
//                $array=  $this->getSemYear();
//                $sem=$array[0]->SEMESTER;
//                $year=$array[0]->YEAR;
//                  $user = \Auth::user()->id;
//                  $sms=new MessagesModel();
//                    $sms->dates=\DB::raw("NOW()");
//                    $sms->message=$message;
//                    $sms->phone=$phone;
//                    $sms->status=$result;
//                    $sms->type="Fees reminder";
//                    $sms->sender=$user;
//                    $sms->term=$sem;
//                    $sms->year=$year;
//                    $sms->receipient=$receipient;
//                     
//                   $sms->save();
//            }
//        
//    }
//    
   public function firesms($message,$phone,$receipient){
          
         
        
        //print_r($contacts);
        if (!empty($phone)&& !empty($message)&& !empty($receipient)) {
             \DB::beginTransaction();
            try {

                 
                $phone="+233".\substr($phone,1,9);
            $phone = str_replace(' ', '', $phone);
                 $phone = str_replace('-', '', $phone);
                 if (!empty($message) && !empty($phone)) {
           // $key = "83f76e13c92d33e27895"; //your unique API key;
            //$message=urlencode($message); //encode url;
        $sender_id="Library";

        $url = "http://sms.gadeksystems.com/smsapi?key=$key&to=$phone&msg=$message&sender_id=$sender_id";
        //print_r($url);
        $result = file_get_contents($url); //call url and store result;

                   if ($result = 1000) {

                   $result="Message was successfully sent"; 
                   
                    }else{ 
                    $result="Message failed to send. Error: " .  $result; 
                     
                    } 
                     
                
                 
                  $user = \Auth::user()->fund;
                  $sms=new MessagesModel();
                    $sms->dates=\DB::raw("NOW()");
                    $sms->message=$message;
                    $sms->phone=$phone;
                    $sms->status=$result;
                    $sms->type="reminder";
                    $sms->sent_by=$user;
                     
                    $sms->receipient=$receipient;
                     
                   $sms->save();
                   \DB::commit();
            }
            
                    }
            catch (\Exception $e) {
                \DB::rollback();
            }
        }
        
    }
   
    
    /**
     * Get current sem and year
     *
     * @param  Request  $request
     * @return Response
     */
    public function getSemYear()
    {
        $sql =\DB::table('academicsettings')->where('id', \DB::raw("(select max(`ID`) from academicsettings)"))->get();
        return $sql;
    }
     public function houses(){
            $teacher=@\Auth::user()->fund;
             
             $data=\DB::table('house')->where('master',$teacher)->first();
             return $data->house;
      }
      
       public function teacherGender(){
            $teacher=@\Auth::user()->fund;
             
             $data=\DB::table('staffs')->where('emp_number',$teacher)->first();
             return $data;
      }
      
      
      
    public function getProgram($code){
        
        $programme = \DB::table('programme')->where('code',$code)->get();
                 
        return @$programme[0]->name;
     
    }
     
    public function getStudentPassword($user){
        
        $userArr = \DB::table('tpoly_log_portal')->where('username',$user)->get();
                 
        return @$userArr[0]->real_password;
     
    }
    public function getProgramArray($code){
        
        $programme = \DB::table('programme')->where('code',$code)->get();
                 
        return @$programme;
     
    }
     public function getStudentByID($id){
        
        $student = \DB::table('tpoly_students')->where('ID',$id)->get();
                 
        return @$student[0]->INDEXNO;
     
    }
    public function getStudentIDfromIndexno($indexno) {
        $student = \DB::table('tpoly_students')->where('INDEXNO',$indexno)->get();
                 
        return  @$student[0]->ID;
    }
    public function getStudentNameByID($id){
        
        $student = \DB::table('tpoly_students')->where('ID',$id)->get();
                 
        return @$student[0]->NAME;
     
    }
     public function getStudent($indexNo){
        
        $student = \DB::table('tpoly_students')->where('INDEXNO',$indexNo)->get();
                 
        return @$student;
     
    }
    public function getTeacherClass($staff) {
        $array = $this->getSemYear();

        $year = $array[0]->year;
        $term = $array[0]->term;
       $query= \DB::table('classes')->where('teacherId',$staff)->where('year',$year)
                ->where('term',$term)
                ->get();
         //dd($query);
             return $query[0]->name;
    }
     public function getStudentsTotalPerProgramLevel($program,$level){
         $array = $this->getSemYear();

        $year = $array[0]->YEAR;
        $sem = $array[0]->SEMESTER;
        $total = \DB::table('tpoly_academic_record')
                ->leftjoin('tpoly_students', 'tpoly_students.ID', '=', 'tpoly_academic_record.id')
                ->where('tpoly_students.PROGRAMMECODE', "'$program'")
                ->where('tpoly_academic_record.level', "'$level'")
                ->where('tpoly_academic_record.year', "'$year'")
                ->where('tpoly_academic_record.sem', $sem)
                ->count("*");
        return $total;
    }
     public function getStudentsTotalPerProgram($program,$level=NULL){
        if($level==NULL){
        $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)
                ->where("SYSUPDATE","1")
                ->count();
        return $total;
        }
        else{
            $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)
                 ->where("LEVEL",$level)
                ->where("SYSUPDATE","1")
                ->count();
        return $total;
        }
        
     
    }
      public function getStudentsTotalPerProgram2($level){
         
        $total = \DB::table('tpoly_students')->where('LEVEL',$level)
                ->where("SYSUPDATE","1")
                ->count();
        return $total;
        
         
     
    }
     public function getTotalStudentsByProgramCount($program,$level){
         $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $total= \DB::table('tpoly_students')
               ->join('tpoly_feedetails', 'tpoly_feedetails.INDEXNO', '=', 'tpoly_students.INDEXNO')
            
               ->where('tpoly_students.PROGRAMMECODE',$program)
                   ->where('tpoly_feedetails.LEVEL',$level)
                 ->where('tpoly_feedetails.YEAR',$year)
            ->count("tpoly_feedetails.ID");
 
      return @$total;
        
    }
    public function getTotalPaymentByProgram($program,$level){
         $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $amount= \DB::table('tpoly_students')
               ->join('tpoly_feedetails', 'tpoly_feedetails.INDEXNO', '=', 'tpoly_students.INDEXNO')
            
               ->where('tpoly_students.PROGRAMMECODE',$program)
                   ->where('tpoly_feedetails.LEVEL',$level)
                 ->where('tpoly_feedetails.YEAR',$year)
            ->sum("tpoly_feedetails.AMOUNT");
 
      return @$amount;
        
    }
     public function getTotalRegistered($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.REGISTERED',1)
            ->count("tpoly_students.ID");
 
      return @$total;
        
    }
     public function getTotalOwingbyProgram($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.STATUS','In School')
            ->sum("tpoly_students.BILL_OWING");
 
      return @$total;
        
    }
    public function getTotalStudentOwing($program,$level){
         
         $total= \DB::table('tpoly_students')
                   ->where('tpoly_students.PROGRAMMECODE',$program)
                    ->where('tpoly_students.LEVEL',$level)
                 ->where('tpoly_students.STATUS','In School')
            ->where("tpoly_students.BILL_OWING",">",0)
            ->count("tpoly_students.ID");
      return @$total;
        
    }
     public function getTotalBillForProgram($program,$level ){
          $array=$this->getSemYear();
             
              $year=$array[0]->YEAR;
         $amount= \DB::table('tpoly_bills')
                   ->where('tpoly_bills.PROGRAMME',$program)
                    ->where('tpoly_bills.LEVEL',$level)
                 ->where('tpoly_bills.YEAR',$year)
            ->first();
 
      return @$amount->AMOUNT;
        
    }
     public function getStaffAccount($id){
        
        $staff = \DB::table('staffs')->where('emp_number',$id)->get();
                 
        return $staff;
     
    }
    public function getProgramCodeByID($id){
        
        $programme = \DB::table('programme')->where('ID',$id)->get();
                 
        return @$programme[0]->PROGRAMMECODE;
     
    }
    // return course array based on code
    public function getCourseByCodeObject($id) {
        $mount = \DB::table('subjectallocations')->where('id',$id)->first();
         
         $course = \DB::table('courses')->where('code',$id)->first();
                 
        return @$course;
    }
     public function getCourseByCode($code) {
         $course = \DB::table('courses')->where('code',$code)->get();
                 
        return @$course[0]->ID;
    }
    public function getCourseByCode2($code,$program) {
         $course = \DB::table('tpoly_courses')->where('COURSE_CODE',$code)
                 ->where("PROGRAMME",$program)
                 ->get();
                 
        return @$course[0]->ID;
    }
    public function getProgramByID($id) {
         $programme = \DB::table('programme')->where('ID',$id)->get();
                 
        return @$programme[0]->PROGRAMME;
    }
     public function getProgramByGradeSystem($program) {
         $programme = \DB::table('programme')->where('code',$program)->get();
                 
        return @$programme[0]->gradeSystem;
    }
    public function getCourseProgrammeMounted($course) {
        
         $data= \DB::table('subjectallocations')->where('id',$course)->get();
                 
        $courseInfo=@$data[0]->subject;
       $progInfo= \DB::table('courses')->where('code',$course)->get();
       
       return $progInfo[0]->pcode;
    }
    public function getCourseProgramme($course) {
        
         $programme= \DB::table('tpoly_courses')->where('ID',$course)->get();
                 
        return @$programme[0]->PROGRAMME;
    }
    public function getGrade($mark,$type){
        
        $grade = \DB::table('gradingsystem')
                ->where('lower','<=',$mark)
                ->where('upper','>=',$mark)
                ->where('type','WASSCE')
                ->get();
                 
        return $grade;
     
    }
     public function getGradeScore($mark,$type){
        
        $grade = \DB::table('gradingsystem')
                ->where('lower','<=',$mark)
                ->where('upper','>=',$mark)
                ->where('type',$type)
                ->first();
                 
        return @$grade->grade;
     
    }
     
     public function getCourseCodeByID($id){
         
         $course = \DB::table('courses')->where('code',$id)->get();
                 
        return @$course[0]->code;
   
    }
    
    public function getCourseCodeByIDArray($id){
         
         $course= \DB::table('courses')->where('code',$id)
              ->get();
 
      return @$course;
   
    }
    public function getCourseMountedInfo($id){
         
         $course= \DB::table('subjectallocations')->where('id',$id)
              ->get();
 
      return @$course;
   
    }
    
    
    public function getCourseByIDCode($code){
         
          $course= \DB::table('tpoly_academic_record')
            ->leftjoin('tpoly_mounted_courses', 'tpoly_academic_record.course', '=', 'tpoly_mounted_courses.ID')
            ->leftjoin('tpoly_courses', 'tpoly_mounted_courses.COURSE', '=', 'tpoly_courses.ID')
            ->select('tpoly_academic_record.course')->where('tpoly_courses.COURSE_CODE',$code)
            ->get();
 
      return @$course[0]->course;
   
    }
     public function getCourseByID($id){
        
        $course = \DB::table('courses')->where('code',$id)->get();
                 
        return @$course[0]->name;
     
    }
     public function getCourse($id){
        
        $course = \DB::table('courses')->where('id',$id)->get();
                 
        return @$course[0]->name;
     
    }
    public function getCourseObject($code){
        
        $course = \DB::table('courses')->where('code',$code)->get();
                 
        return @$course;
     
    }
     public function getTotalFeeByProrammeLevel($program,$level){
       $program=  $this->getProgramCodeByID($program);
        $total = \DB::table('tpoly_students')->where('PROGRAMMECODE',$program)->where('YEAR',$level)->where('STATUS','=','In school')->COUNT('*');
                // dd($total);
        return @$total;
     
    }
   public function picture($path,$target){
                if(file_exists($path)){
                        $mypic = getimagesize($path);

                 $width=$mypic[0];
                        $height=$mypic[1];

                if ($width > $height) {
                $percentage = ($target / $width);
                } else {
                $percentage = ($target / $height);
                }

                //gets the new value and applies the percentage, then rounds the value
                 $width = round($width * $percentage);
                $height = round($height * $percentage);

               return "width=\"$width\" height=\"$height\"";



            }else{}
        
       
        }
        
        
	public function pictureid($stuid) {

        return str_replace('/', '', $stuid);
    }
     
    function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
    }
    public function formatCurrency($amount) {
       return number_format($amount,3);
            
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
