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
<h5 class="heading_c uk-margin-bottom">Fee Payments by Programs Summary Statistics</h5>
   
 <div style="">
     <div class="uk-margin-bottom" style="margin-left:1000px" >
         <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>
                   
          <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
             <button class="md-btn md-btn-small md-btn-success"> show/hide columns <i class="uk-icon-caret-down"></i></button>
             <div class="uk-dropdown">
                 <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
             </div>
         </div>
         <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                                <button class="md-btn md-btn-small md-btn-success uk-margin-right">Export <i class="uk-icon-caret-down"></i></button>
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
 <!-- filters here -->
  @inject('fee', 'App\Http\Controllers\FeeController')
   @inject('sys', 'App\Http\Controllers\SystemController')
  
 <div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                {!!  csrf_field()  !!}
                <div class="uk-grid" data-uk-grid-margin="">

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('program', 
                            (['' => 'All programs'] + $programme ), 
                            old("program",""),
                            ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select program'] )  !!}
                        </div>
                    </div>
                    
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('department', 
                            (['' => 'departments'] +$department  ), 
                            old("department",""),
                            ['class' => 'md-input parent','id'=>"parent"] )  !!}
                        </div>
                    </div>
                     <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('school', 
                            (['' => 'by schools'] +$school  ), 
                            old("school",""),
                            ['class' => 'md-input parent','id'=>"parent"] )  !!}
                        </div>
                    </div>
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('type', 
                            (['' => 'by programme types'] +$type  ), 
                            old("type",""),
                            ['class' => 'md-input parent','id'=>"parent"] )  !!}
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
          <center><span class="uk-text-success uk-text-bold">{!! $programcode->total()!!} Records</span></center>
        
                 <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
                                  <thead>
                                        <tr>
                                             <th class="uk-width-1-10">PROGRAMS</th>
                                            <th class=" uk-text-small"  >NO. OF STUDENTS</th>
                                            
                                            <th>LEVEL 100 </th>
                                            <th>LEVEL 200 </th>
                                            <th>LEVEL 300 </th>
                                            <th>LEVEL 400 </th>
                                            <th>BTECH TOPUP 1  </th>
                                            <th>BTECH TOPUP 2 </th>
<!--                                            <th>TOTAL </th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                         
                                     @foreach($programcode as $index=> $row) 
                                     <tr>

                                         <td>{{$row->PROGRAMME}}</td>
                                         <td class=''>{{$sys->getStudentsTotalPerProgram($row->PROGRAMMECODE)}}<?php $total[] = $sys->getStudentsTotalPerProgram($row->PROGRAMMECODE) ?></td>
                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'100')}} <?php $a[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '100') ?></td>
                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'200')}}<?php $b[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '200') ?></td>
                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'300')}}<?php $c[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '300') ?></td>
                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'400')}}<?php $d[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '400') ?></td>

                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'400/1')}}<?php $e[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '400/1') ?></td>
                                         <td class=''>{{$sys->getTotalPaymentByProgram($row->PROGRAMMECODE,'400/2')}}<?php $f[] = $sys->getTotalPaymentByProgram($row->PROGRAMMECODE, '400/2') ?></td>
   <!--                                      <td class='md-bg-cyan-100 uk-text-small'>0.000</td>-->
                                     </tr>
                                        @endforeach
                                         <tr><td class='md-bg-cyan-100 uk-text-small'>Total</td>
                  <td class="uk-text-bold uk-text-success">{{array_sum($total)}}</td>
                  <td> <div style= "" class="uk-text-bold uk-text-success">   GHC  {{$sys->formatMoney(array_sum($a))}} </div></td>
                  <td  class="uk-text-bold uk-text-success">   GHC  {{$sys->formatMoney(array_sum($b))}} </td>
                  <td  class="uk-text-bold uk-text-success">  GHC  {{$sys->formatMoney(array_sum($c))}} </td>
                  <td  class="uk-text-bold uk-text-success">   GHC  {{$sys->formatMoney(array_sum($d))}} </td>
                  <td  class="uk-text-bold uk-text-success">   GHC  {{$sys->formatMoney(array_sum($e))}} </td>
                  <td  class="uk-text-bold uk-text-success">   GHC  {{$sys->formatMoney(array_sum($f))}} </td>
              </tr>
                                       
                                         
                                    </tbody>
                                    
                             </table>
          <table>
             
          </table>
        
           
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