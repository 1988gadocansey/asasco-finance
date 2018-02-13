@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
  
   <div class="md-card-content">
@if(Session::has('success'))
            <div style="text-align: center" class="uk-alert uk-alert-success  uk-alert-close" data-uk-alert="">
                {!! Session::get('success') !!}
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
 <div class="uk-width-xLarge-1-1">
 <div class="md-card">
 <div class="md-card-content">
<h5>Fees Ledger</h5>  
  

     <div class="uk-overflow-container">
                <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap" id="gad"> 
                                  <thead>
                                        <tr>
                                     <th>NO</th>
                                     <th>INDEXNO</th>
                                     <th >AMOUNT</th>
                                      <th>PAYMENT TYPE</th> 
                                      <th>PAYMENT DETAILS</th>
                                   
                                      <th>LEVEL</th>
                                      <th>BANK</th>
                                      <th>TRANSACTION ID</th>
                                      <th>RECEIPT NO</th>
                                      <th>FEE TYPE</th>
                                      <th>YEAR</th>
                                      <th>SEMESTER</th>
                                    
                                       
                                       <th>TRANSACTION DATE</th>
                                           
                                           
                                        </tr>
                                    </thead>
                                    
                             </table>
     </div>
 
 </div>
 </div></div>
@endsection
@section('js')
 
<script>
    
 
 var oTable = $('#gad').DataTable({
      
        processing: true,
        serverSide: true,
        ajax: {
            url:  "{!! route('view_payments.data') !!}" 
            
        },
         columns: [
            {data: 'ID', name: 'ID'},
            {data: 'INDEXNO', name: 'INDEXNO'},
            {data: 'AMOUNT', name: 'AMOUNT'},
            {data: 'PAYMENTTYPE', name: 'PAYMENTTYPE'},
            {data: 'PAYMENTDETAILS', name: 'PAYMENTDETAILS'},
            {data: 'LEVEL', name: 'LEVEL'},
            {data: 'BANK', name: 'BANK'},
            {data: 'TRANSACTION_ID', name: 'TRANSACTION_ID'},
            {data: 'RECEIPTNO', name: 'RECEIPTNO'},
            {data: 'FEE_TYPE', name: 'FEE_TYPE'},
            {data: 'YEAR', name: 'YEAR'},
            {data: 'SEMESTER', name: 'SEMESTER'},
             {data: 'TRANSDATE', name: 'TRANSDATE'}
        ]
    });
     $(document).ready(function(){
// console.log($('select[name="status"]'));
$(".jump").on('change',function(e){
 
  $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });
 
});
});

    
</script>
 <!--  notifications functions -->
    <script src="public/assets/js/components_notifications.min.js"></script>
@endsection