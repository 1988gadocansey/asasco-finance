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
 
 <h5>Students  daily payments</h5>
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

               <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                   {!!  csrf_field()  !!}
                   <div class="uk-grid" data-uk-grid-margin="">

                       {{--<div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">

                               {!! Form::select('program', $programme, old("program",""), ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select programme']);!!}
                           </div>
                       </div>--}}
                       <div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">

                               {!! Form::select('class', $class, old("class",""), ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'All Classes']);!!}

                           </div>
                       </div>

                       <div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">
                               <div class="uk-input-group">
                                   <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                   <input type="text"  style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="Start of Financial Year ">
                               </div>
                           </div>
                       </div>

                       <div class="uk-width-medium-1-5">

                           <div class="uk-margin-small-top">
                               <div class="uk-input-group">
                                   <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                   <input type="text" style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="End of Financial Year">
                               </div>
                           </div>
                       </div>

                       <div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">
                               <input type="text" style=" " required=""  name="search"  class="md-input" placeholder="search student by index number or name">
                           </div>
                       </div>
                       <div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">



                               {!!  Form::select('by', ['indexNo'=>'Search by Index Number','NAME'=>'Search by Name' ], null, ['placeholder' => 'select search type','class'=>'md-input'] ); !!}


                           </div>
                       </div>





                       <div class="uk-width-medium-1-5">
                           <div class="uk-margin-small-top">
                               <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button>
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
  

     <div class="uk-overflow-container" id='print'>
         <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter"> 
                                  <thead>
                                        <tr>
                                     <th class="filter-false remove sorter-false" data-priority="6">NO</th>
                                     
                                     
                                     <th>INDEXNO</th>
                                      <th data-priority="critical">NAME</th>
                                      <th>Class</th>

                                      
                                      <th>YEAR</th>
                                      <th>BANK</th>
                                       <th>AMOUNT</th>
                                      <th>PAYMENT TYPE</th>
                                      <th>RECEIPT</th>
                                     
                                      <th>DATE OF PAYMENT</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                         @foreach($data as $index=> $row) 
                                         
                                        
                                        
                                         
                                        <tr align="">
                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                               <td> {{ @$row->stuId }}</td>
                                            <td> {{ @$row->student->name }}</td>
                                            <td> {{ @$row->classes }}</td>


                                            
                                             <td> {{ @$row->year }}</td>
                                            <td> {{ @$row->bankdetails->bname }}</td>
                                             <td> {{ @$fee->getTotalPayment($row->stuId,$row->term,$row->year) }}</td>
                                          
                                            <td> {{ @$row->paymentType }}</td>
                                            <td> {{ @$row->receiptno }}</td>
                                           
                                            <td> {{$row->created_at->diffForHumans() }}</td>
                                            
                                           
                                              
                                        </tr>
                                         @endforeach
                                    </tbody>
                                    
                             </table>
         <div style="margin-left: 643px" class="uk-text-bold uk-text-success"><td colspan=" ">TOTAL PAID GHC<u>  {{ $total }}</u></td></div>
          {!! $data->links() !!}
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