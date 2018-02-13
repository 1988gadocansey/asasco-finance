@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
  
   <div class="md-card-content">
 @if(Session::has('success'))
            <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
                {!! Session::get('success') !!}
            </div>
 @endif
 
    @if(Session::has('error'))
            <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
                {!! Session::get('error') !!}
            </div>
 @endif
 
 </div>
 <div style="">
     <div class="uk-margin-bottom" style="margin-left:900px" >
          
                            <button class="md-btn md-btn-success md-btn-small" data-uk-modal="{target:'#modal_overflow'}">Click me for help</button>
                            <div id="modal_overflow" class="uk-modal">
                                <div class="uk-modal-dialog uk-alert uk-alert-info">
                                    <button type="button" class="uk-modal-close uk-close"></button>
                                    <h2 class="heading_a">Don't get stack... </h2>
                                    <p>How to approve or delete created fees?? </p>
                                    <div class="uk-overflow-container">
                                        <h2 class="heading_b">Follow this</h2>
                                        <p>1. you can use the filters bellow eg you want all first years fee. select the drop down containing the levels/years and select first years...it applies to all others</p>
                                        <p>2. you can now click on approve or delete fee</p>
                                     <h2 class="heading_b">Show or Hide columns</h2>
                                     <p>1. you can use click on the columns button which is automatically select as auto meanings show all columns 
                                     tick the columns you want to view or show visible here
                                     </p>
                                      <h2 class="heading_b">Print Table</h2>
                                     <p>1.You probably like to print out the fee table for use. this can easily be done by clicking the print button or printer icon
                                     </p>
                                      <h2 class="heading_b">Export Data</h2>
                                     <p>You might want to save the report into excel, word or powerpoint documents... this so easy as
                                         click on the export button located at the top and select your desired option
                                     </p>
                                    </div>
                                     
                                </div>
                            </div>
         <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
         <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
             <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
             <div class="uk-dropdown">
                 <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
             </div>
         </div>
          
                            
     </div>
   
 </div>
 <!-- filters here -->
  @inject('fee', 'App\Http\Controllers\FeeController')
   @inject('sys', 'App\Http\Controllers\SystemController')
 <div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">
            
                <form action=""  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('program', 
                                (['' => 'All programs'] +$program ), 
                                  old("program",""),
                                    ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select program'] )  !!}
                         </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                             {!!  Form::select('level', array( '1'=>'1st years','2' => '2nd years', '3' => '3rd years','4'=>'4th years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ['placeholder' => 'select level','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}
                           </div>
                        </div>
                        
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                    {!! Form::select('year', 
                                (['' => 'Select year'] +$year ), 
                                  old("year",""),
                                    ['class' => 'md-input parent','id'=>"parent"] )  !!}
                         </div>
                        </div>
                        
                          
                         

                       
                           <div class="uk-width-medium-1-10" style=" ">
                            <div class="uk-margin-small-top">  
                            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i class="uk-icon-caret-down"></i></button>
                                <div class="uk-dropdown">
                                    <ul class="uk-nav uk-nav-dropdown">
                                         <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'csv',escape:'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>
                                           
                                            <li class="uk-nav-divider"></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'excel',escape:'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'doc',escape:'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                                            <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type:'powerpoint',escape:'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                                            <li class="uk-nav-divider"></li>
                                           
                                    </ul>
                                </div>
                            </div>
                        </div>
                           </div>
                            
                        <div class="uk-width-medium-1-10"  style="" >                            
                            <div class="uk-margin-small-top">
                                 <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>
                   
                            </div>
                          </div>
                         
                        
                        
                    
                    </div>
                   
                </form> 
        </div>
    </div>
 </div>
 <div class="uk-width-xLarge-1-1">
 <div class="md-card">
 <div class="md-card-content">
          <h5>Proposed Fees</h5>  
    
      
     <div class="uk-overflow-container">
           <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
       
            <table class="uk-table uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">                     <thead>
                     <thead>
                            <tr>
                                <th></th>
                                     <th>NO</th>
                                     <th>NAME</th> 
                                     <th>FEE TYPE</th> 
                                    
                                     <th>PROGRAMME</th>
                                      <th>LEVEL</th>
                                       <th >AMOUNT</th>
                                       <th>TOTAL STUDENTS</th>
                                       <th>PROPOSED AMOUNT</th>
                                     
                                      <th>YEAR</th> 
                                     
                                     <th>STUDENT TYPE</th>
                                     
                                      
                                      
                                       <th>ACTION</th>
                                           
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                         @foreach($data as $index=> $row) 
                                          
                                        <tr align="">
                                              <td><input type="checkbox" data-md-icheck class="ts_checkbox"></td>
                                            <td> {{ @$row->ID }} </td>
                                              
                                            <td> {{ @$row->NAME }}</td> 
                                            <td> {{ @$row->FEE_TYPE }}</td>
                                             <td>{{ @$row->program->PROGRAMME}}</td>
                                            <td> {{ @$row->LEVEL }}yr</td>
                                             <td style="text-align: center"><span class="uk-text-success uk-text-bold"> {{ @$row->AMOUNT }}</span></td>
                                          
                                            <td style="text-align: center"><span class="uk-text-success uk-text-bold"> {{ @$row->TOTALSTUDENTS }}</span></td>
                                             <td style="text-align: center"><span class="uk-text-success uk-text-bold"> GHC {{ @$row->TOTALAMOUNT }}</span></td>
                                          
                                             <td> {{ @$row->YEAR }}</td> 
                                           
                                            <td> {{ @$row->NATIONALITY }}</td>
                                           
                                            
                                           
                                            <td>
     
                                                 @if($row->STATUS=='approved')
                                                  
                                                 <span class='uk-text-success'>Approved ready</span> 
                                                 
                                                 @else
                                                    
                                                    {!!Form::open(['action' =>['FeeController@destroy', 'id'=>$row->ID], 'method' => 'DELETE','name'=>'myform' ,'style' => 'display: inline;'])  !!}

                                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this fee component??')" class="md-btn  md-btn-danger md-btn-small   md-btn-wave-light waves-effect waves-button waves-light" ><i  class="sidebar-menu-icon material-icons md-18">delete</i></button>
                                                        <input type='hidden'   value='{{$row->ID}}'/>  
                                                     {!! Form::close() !!}

                                                  <button title='click to approve fees' type="button" class="md-btn  md-btn-primary md-btn-small   md-btn-wave-light waves-effect waves-button waves-light" onclick="UIkit.modal.confirm('Are you sure you want to bill student with this fee item?', function(){   return window.location.href='run_bill/{!!$row->ID!!}/id'     ; });"><i  class="sidebar-menu-icon material-icons md-18">done</i></button> 

                                                  @endif


                                                
                                            
                                            
                                            </td>
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    
                             </table>
            <div style="margin-left: 750px" class="uk-text-bold uk-text-success"><td colspan=" "> PROPOSED FEES GHC<u>  {{ $totalProposed }}</u></td></div>
      
          {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
     </div>

 </div>
 </div></div>
@endsection
@section('js')
 
   
 <script type="text/javascript">
      
$(document).ready(function(){
 
$(".parent").on('change',function(e){
 
   $("#group").submit();
 
});
});

</script>
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
@endsection