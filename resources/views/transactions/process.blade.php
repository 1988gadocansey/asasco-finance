@extends('layouts.app')

 
   
@section('style')
 
        <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
<style>
     
</style>
@endsection
 @section('content')
 <div class="md-card-content">
     <div style="text-align: center;display: none" class="uk-alert uk-alert-success" data-uk-alert="">

    </div>



    <div style="text-align: center;display: none" class="uk-alert uk-alert-danger" data-uk-alert="">

    </div>
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
  @inject('sys', 'App\Http\Controllers\SystemController')
   
 <div align="center">
     <h4 class="heading_b uk-margin-bottom">Book Borrowing Section</h4>
  
     <h4 class="uk-text-bold uk-text-danger">Allow pop ups on your browser please!!!!!</h4>
     <p>1. Click on the + icon to select the books </p>
     <p>2. Click on submit to complete the transaction</p>
              <hr>
             
              <form id='form' method="POST"   accept-charset="utf-8"  name="applicationForm"  v-form>
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
            
            
            <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-overflow-container">
                               <table id="paymentTable" class="uk-table"border="0" style="font-weight:bold">
	  <tr id="paymentRow" payment_row="payment_row"> 
              <td>Book &nbsp;
                                
	      <select placeholder='select books' class="md-input" style="width:290px" name="book[]" required="required" class= 'md-input'v-model='book' v-form-ctrl='' v-select=''>
                                           <option selected="">select books</option>
                                           @foreach($sql as $item)
                                        
                                          <option value="{{$item->book_id}}">{{$item->book_title}} - {{$item->author}} - {{$item->book_pub}} - {{$item->edition}} - {{$item->isbn}}  </option>
                                        @endforeach
                                      </select>
              
              
              </td>
	   
          
	  <td valign="top" id="insertPaymentCell"><button  type="button" id="insertPaymentRow" class="md-btn md-btn-primary md-btn-small " title='click to add more ' ><i class="sidebar-menu-icon material-icons">add</i></button></td></tr>
	   
      </table>
      <table align="center">
       
          <tr><td><input type="button" value="Save"  v-show="applicationForm.$valid"  class="md-btn client  md-btn-success uk-margin-small-top">
      <input type="reset" value="Cancel" class="md-btn   md-btn-default uk-margin-small-top">
    </td></tr></table>
                                <p></p>
                                    
                              
                            </div>
                        </div>
                    </div>
                    
                  
                
                </div>
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">
                         <table>
                                <tr>
                                    <td>
                                        <table>
                                            <tr>
                                            <td  align=""> <div  align="right" >Card Number:</div></td>
                                        <td class="uk-text-bold">
                                            {{ @$data[0]->cardNo}}
                                             <input type="hidden" name="member"   value="{{ @$data[0]->indexNo}}" />
                                            
                                        </td>
                                        </tr>
                                           
                                        <tr>
                                            <td  align=""> <div  align="right" >Full Name</div></td>
                                            <td class="uk-text-bold">
                                            {{ @$data[0]->name}}
                                               <input type="hidden" name="name" id="name" value="{{ @$data[0]->name}}" />
                                           
                                        </td>
                                        </tr>
                                       
                                          <tr>
                                            <td  align=""> <div  align="right" >Phone:</div></td>
                                        <td class="uk-text-bold">
                                            {{ $data[0]->phone}}
                                             <input type="hidden" name="phone" id="phone" value="{{ $data[0]->phone}}" />
                                            
                                        </td>
                                        </tr>
                                         
                                          <tr>
                                            <td  align=""> <div  align="right" >Class:</div></td>
                                        <td class="uk-text-bold">
                                            {{ $data[0]->currentClass}}
                                             
                                        </td>
                                        </tr>
                                         
                                        </table>
                                    </td>
                                    <td valign="top">
                                        <img   style="width:150px;height: auto;"  <?php
                                        $pic = $data[0]->indexNo;
                                        echo $sys->picture("{!! url(\"public/albums/students/$pic.jpg\") !!}", 90)
                                        ?>   src='{{url("public/albums/students/$pic.jpg")}}' alt="  Affix student picture here"    />
                                    </td>
                                </tr>
                            </table>
                                </div>
                    </div>
                  
                </div>
            
            
            
             
    </form>
             
    
 @endsection
 
@section('js')
 
  
  
 <script>
                    $(document).ready(function(){
            $('.client').on('click', function(e){


                    
                    UIkit.modal.confirm("Are you sure every data is accurate?? "
                            , function(){
                            modal = UIkit.modal.blockUI("<div class='uk-text-center'>Processing transaction ...  <br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner.gif')  !!}' /></div>");
                                    //setTimeout(function(){ modal.hide() }, 500) })()            
                                    $.ajax({
                                     
                                            type: "POST",
                                            url:"{{url('/books/process')}}",
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
  
@endsection