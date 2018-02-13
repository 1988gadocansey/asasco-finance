@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
  
   <div class="md-card-content">
        
 @if($messages=Session::get("success"))

    <div class="uk-form-row">
        <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">

              <ul>
                @foreach ($messages as $message)
                  <li> {!!  $message  !!} </li>
                @endforeach
          </ul>
    </div>
  </div>
@endif
 
  
     @if (count($errors) > 0)

    
        <div class="uk-alert uk-alert-danger  uk-alert-close" style="background-color: red;color: white" data-uk-alert="">

              <ul>
                @foreach ($errors->all() as $error)
                  <li>{!!$error  !!} </li>
                @endforeach
               </ul>
        </div>
   
@endif
 
 
 </div>
 
 <h5>Students  payment reports</h5>  
 <div style="">
     <div class="uk-margin-bottom" style="margin-left:1021px" >
<!--         <a  href="#new_task" data-uk-modal="{ center:true }"> <i title="click to send sms to students owing"   class="material-icons md-36 uk-text-success"   >phonelink_ring message</i></a>-->

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
            
                <form action="{!!    url('view_payments_master')  !!}"  method="get" accept-charset="utf-8" novalidate id="group">
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
                           {!!  Form::select('level', array('50'=>'50','100'=>'1st years','200' => '2nd years', '300' => '3rd years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ['placeholder' => 'select level','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}
                            
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
                         

                        
                         <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">                            
                                <input type="text" style=" "   name="indexno"  class="md-input" placeholder="search student by index number">
                            </div>
                        </div>
                        
                        
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                  {!!  Form::select('type', array('Part payment'=>'Part payment of school fees','Full payment'=>'Full payment of school fees','Late Registration Fee'=>'Late Registration Fee'), null, ['placeholder' => 'select payment type','id'=>'parent','class'=>'md-input parent'], old("type","")); !!}
                         </div>
                        </div>
                         
                         <div class="uk-width-medium-1-10" style=" ">
                            <div class="uk-margin-small-top">                            
                          
                            <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button> 
                            </div>
                        </div>
                        
                    
                    </div>
                   
                </form> 
        </div>
    </div>
 </div>
 
 <!-- end filters -->
 <div class="uk-width-xLarge-1-1">
 <div class="md-card">
 <div class="md-card-content">
  

     <div class="uk-overflow-container" id='print'>
         <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
                                  <thead>
                                        <tr>
                                     <th class="filter-false remove sorter-false" data-priority="6">NO</th>
                                     
                                     
                                     <th>INDEXNO</th>
                                      <th data-priority="critical">NAME</th>
                                      <th>PROGRAMME</th>
                                      <th>LEVEL</th> 
                                      
                                      <th>YEAR</th>
                                      <th>BANK</th>
                                       <th>AMOUNT</th>
                                      <th>PAYMENT TYPE</th>
                                      <th>RECEIPT</th>
                                     
                                      <th>BANK DATE</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                         @foreach($data as $index=> $row) 
                                         
                                        
                                        
                                         
                                        <tr align="">
                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                               <td> {{ @$row->INDEXNO }}</td>
                                            <td> {{ @$row->student->NAME }}</td>
                                            <td>{!! @$sys->getProgram($row->PROGRAMME )!!}</td>
                                            <td> {{ @$row->LEVEL }}</td>
                                            
                                             <td> {{ @$row->YEAR }}</td>
                                            <td> {{ @$row->bank->NAME }}</td>
                                             <td> {{ @$fee->getTotalPayment($row->INDEXNO,$row->SEMESTER,$row->YEAR) }}</td>
                                          
                                            <td> {{ @$row->PAYMENTTYPE }}</td>
                                            <td> {{ @$row->RECEIPTNO }}</td>
                                           
                                            <td> {{ @$row->BANK_DATE }}</td>
                                            
                                           
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    
                             </table>
         <div style="margin-left: 1089px" class="uk-text-bold uk-text-success"><td colspan=" ">TOTAL PAID GHC<u>  {{ $total }}</u></td></div>
          {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
     </div>
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
 <!--  notifications functions -->
    <script src="public/assets/js/components_notifications.min.js"></script>
@endsection