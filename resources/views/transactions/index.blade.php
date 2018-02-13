@extends('layouts.app')


@section('style')

@endsection
@section('content')

<div class="md-card-content">
<div style="text-align: center;display: none" class="uk-alert uk-alert-success" data-uk-alert="">

    </div>



    <div style="text-align: center;display: none" class="uk-alert uk-alert-danger" data-uk-alert="">

    </div>

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
<div class="uk-modal" id="new_task">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h4 class="uk-modal-title">Send sms  here</h4>
        </div>
          <center> <p>Insert the following placeholders into the message [name] [cardno]   </p></center>
      
          <form  accept-charset="utf-8"    method="POST" id='form'>
            <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 

            
            <textarea cols="30" rows="4" name="message"class="md-input" required=""></textarea>


            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat md-btn-flat-primary md-btn-wave send" id="snippet_new_save"><i   class="material-icons"   >smartphone</i>Send</button>    
                <button type="button" class="md-btn md-btn-flat uk-modal-close md-btn-wave">Close</button>
            </div>
        </form>
    </div>
</div>
<h3 class="heading_b uk-margin-bottom">Transactions List</h3>
<div style="" class="">
<!--    <div class="uk-margin-bottom" style="margin-left:910px" >-->
<div class="uk-margin-bottom" style="" >
        <a  href="#new_task" data-uk-modal="{ center:true }"> <i title="click to send sms to library users"   class="material-icons md-36 uk-text-success"   >phonelink_ring message</i></a>

        <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
            </div>
        </div>





        <div style="margin-top: -5px" class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown">
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'csv', escape: 'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>

                    <li class="uk-nav-divider"></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'excel', escape: 'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'doc', escape: 'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'powerpoint', escape: 'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                    <li class="uk-nav-divider"></li>

                </ul>
            </div>
        </div>




        <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>


         <a href="{{url('/transactions')}}" ><i   title="reload this page" class="uk-icon-refresh uk-icon-medium "></i></a>
        

    </div>
</div>
<!-- filters here -->
 
@inject('sys', 'App\Http\Controllers\SystemController')
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                {!!  csrf_field()  !!}
                <div class="uk-grid" data-uk-grid-margin="">

                   <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">   
                                <div class="uk-input-group">
                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                             <input type="text"  style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="start date ">
                             </div>
                         </div>
                        </div>

                        <div class="uk-width-medium-1-5">
                            
                            <div class="uk-margin-small-top">    
                               <div class="uk-input-group">
                                        <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span> 
                            <input type="text" style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="end date">
                               </div>
                            </div>
                        </div>
                     <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            
                            {!!  Form::select('status', array(''=>'All status','pending'=>'Borrowed books','returned' => 'Returned books'), null, ['placeholder' => 'select status','id'=>'parent','class'=>'md-input parent'],old("status","")); !!}

                        </div>
                    </div>
                     <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top"> 
                                <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button> 
                      
                        </div>
                       </div>
                    
                      
                    </div>
                   

                </div>
  
            </form> 
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
                            <th class="filter-false remove sorter-false" >NO</th>
 
                            <th data-priority="6">NAME</th>
                             
                            <th>PHOTO</th>
                            <th>CARD N<u>O</u></th>
                              <th data-priority="">PHONE N<u>O</u></th>
                            <th data-priority="">BOOK</th>
                            <th data-priority="">STATUS</th>
                          
                            <th data-priority="">GIVEN OUT BY</th>
                            <th data-priority="">DATE BORROWED</th>
                            <th data-priority="">DATE RETURNED</th>
                            
                            
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($data as $index=> $row) 




                        <tr align="">
                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                            <td> {{ strtoupper(@$row->member->name) }}</td>
                        
                           <td><img   style="width:120px;height: auto;"  <?php
                                        $pic = $row->member->cardNo;
                                        echo $sys->picture("{!! url(\"public/albums/staff/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/albums/staff/$pic.jpg")}}' alt=" picture here"    /></td>
                            <td> {{ strtoupper(@$row->member->cardNo) }}</td>
                             
                            <td> {{  @$row->member->contact}}</td>
                            
                            <td> {{ strtoupper(@$row->book->book_title) }}</td>
                            <td> {{ strtoupper(@$row->borrow_status) }}</td>
                           
                             
                            <td> {{strtoupper( @$row->users->name) }} </td>
                           
                            
                           
                            <td> {{   @$row->created_at }}</td>
                            <td> {{   @$row->updated_at }}</td>
                             
                  

                        </tr>
                        @endforeach
                    </tbody>

                </table>
                   {!! (new Landish\Pagination\UIKit($data->appends(old())))->render() !!}
            </div>
        </div>


    </div>
     
</div> 
@endsection
@section('js')
<script type="text/javascript">

    $(document).ready(function () {

        $(".parent").on('change', function (e) {

            $("#group").submit();

        });
    });

</script>
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
     $(document).ready(function () {
         $('select').select2({width: "resolve"});


     });


</script>
<script>
                    $(document).ready(function(){
            $('.send').on('click', function(e){


                    
                    UIkit.modal.confirm("Are you sure every data is accurate?? "
                            , function(){
                            modal = UIkit.modal.blockUI("<div class='uk-text-center'>Send sms to members <br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>");
                                    //setTimeout(function(){ modal.hide() }, 500) })()            
                                    $.ajax({
                                     
                                            type: "POST",
                                            url:"{{url('/sms/reminder')}}",
                                            data: $('#form').serialize(), //your form data to post goes 
                                            dataType: "json",
                                    }).done(function(data){
                //  var objData = jQuery.parseJSON(data);
                modal.hide();
                        //                                    
                        //                                     UIkit.modal.alert("Action completed successfully");

                        //alert(data.status + data.data);
                        if (data.status == 'success'){
                $(".uk-alert-success").show();
                        $(".uk-alert-success").text(data.status + " " + data.message);
                        $(".uk-alert-success").fadeOut(4000);
                       window.location.href="{{url('/transactions')}}";
                }
                else{
                $(".uk-alert-danger").show();
                        $(".uk-alert-danger").text(data.status + " " + data.message);
                        $(".uk-alert-danger").fadeOut(4000);
                }


                });
                            }
                    );
            });
            
             
            });</script>
<script src="assets/js/components_notifications.min.js"></script>
@endsection