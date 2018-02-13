@extends('layouts.app')

 
   
@section('style')
 
        <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
<style>
     
</style>
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
  @inject('sys', 'App\Http\Controllers\SystemController')
   
 <div align="center">
     <h4 class="heading_b uk-margin-bottom">Fee Payments Section</h4>
  
     <h4 class="uk-text-bold uk-text-danger">Allow pop ups on your browser please!!!!!</h4>
     <p class="uk-text-primary uk-text-bold uk-text-small">Hotlines 0505284060 (Gad), 0246091283(Kojo),0276363053(Timo)</p>
  <h5 > Fee Payment  for {!! $sem !!} Semester  | {!! $year !!} Academic Year</h5>
             <hr>
             
           <form id='form' method="POST" action="{{ url('processPayment') }}" accept-charset="utf-8"  name="applicationForm"  v-form>
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
            
            
            <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">
                            <div class="uk-overflow-container">
                                <table>
                                    <tr>
                                            <td  align=""> <div  align="right" class="uk-text-success">Update Level/Year</div></td>
                                        <td>
                                          
                                              {!!  Form::select('level', array('400/1'=>'BTECH level 1','400/2'=>'BTECH level 2','1'=>'1st years','2' => '2nd years', '3' => '3rd years','4' => '4th years'), null, ['placeholder' => 'select level','required'=>'','class'=>'md-input parent','v-model'=>'level','v-form-ctrl'=>'','v-select'=>''],old("level","")); !!}
                                              <p class="uk-text-danger uk-text-small"  v-if="applicationForm.level.$error.required" >Level is required</p>

                                        </td>
                                        </tr>
                                         
                                         <tr>
                                            <td  align=""> <div  align="right" class="uk-text-success">Amount Paying GHC</div></td>
                                        <td>
                                            <input type="text" id="pay" required=""  onkeyup="recalculateSum();"  v-model="amount" v-form-ctrl=""  name="amount"   class="md-input">
                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.amount.$error.required" >Payment amount is required</p>

                                            
                                        </td>
                                        </tr>
                                        
                                        <tr>
                                            <td  align=""> <div  align="right" class="uk-text-success">Previous owing (if any) GHC</div></td>
                                        <td>
                                            <input type="text"     name="prev-owing"   class="md-input">
                                            
                                            
                                        </td>
                                        </tr>
                                        
                                        
                                        
                                        <tr>
                                            <td align=""> <div  align="right" class="uk-text-primary">Balance GHC</div></td>
                                        <td>
                                            <input type="text"  disabled=""    id="amount_left" onkeyup="recalculateSum();" readonly="readonly"   class="md-input">
                                          
                                            
                                            
                                        </td>
                                        </tr>
                                         <tr>
                                            <td  align=""> <div  align="right" >Date of Payment at bank</div></td>
                                        <td>
                                            <input type="text" required=""  data-uk-datepicker="{format:'DD/MM/YYYY'}" v-model="bank_date" v-form-ctrl=""     name="bank_date"  class="md-input">
                                          
                                            
                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.bank_date.$error.required" >Bank date is required</p>

                                        </td>
                                        </tr>
                                         
                                         <tr>
                                            <td  align=""> <div  align="right" class=" ">Bank Account</div></td>
                                        <td>
                                           {!! Form::select('bank', 
                                            (['' => 'Select bank account ']+$banks ), 
                                                null, 
                                                ['required'=>'','class' => 'md-input','v-model'=>'bank','v-form-ctrl'=>'','v-select'=>''] )  !!}


                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.bank.$error.required" >Bank  is required</p>

                                        </td>
                                        </tr>
                                          
                                        <tr>
                                            <td  align=""> <div  align="right" class=" ">Payment Type</div></td>
                                        <td>
                                            <select name="payment_detail" required="" class="md-input" v-form-ctrl='' v-model='payment_detail' v-select=''>
                                                <option>Select payment type</option>
                                                <option value="PAY IN SLIP">PAY IN SLIP</option>
                                                 
                                                <option value="Bursery">Bursery</option>
                                                <option value="Receipt">Receipt</option>
                                                <option value="Scholarship">Scholarship</option>
                                            </select>
                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.payment_detail.$error.required" >Payment type is required</p>

                                            
                                        </td>
                                        </tr>
                                    </table>
                                <p></p>
                                    
                                <center>
                     
                         <button  v-show="applicationForm.$valid" type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Submit</button>
                    
                  
            </center>
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
                                            <td  align=""> <div  align="right" >Receipt No</div></td>
                                        <td>
                                            {{ $receipt}}
                                            <input type="hidden" name="receipt"   value="{{ $receipt}}" />
                                            <input type="hidden" name="stno"   value="{{ $data[0]->STNO}}" />
                                            
                                        </td>
                                        </tr>
                                             @if($data[0]->YEAR==1 ||$data[0]->YEAR=='400/1' )
                                        <tr>
                                            <td  align=""> <div  align="right" >Admission Number</div></td>
                                        <td>
                                            {{ $data[0]->STNO}}
                                             <input type="hidden" name="student" id="student" value="{{ $data[0]->STNO}}" />
                                            
                                        </td>
                                        </tr>
                                         @else
                                          <tr>
                                            <td  align=""> <div  align="right" >Index Number</div></td>
                                        <td>
                                            {{ $data[0]->INDEXNO}}
                                             <input type="hidden" name="student" id="student" value="{{ $data[0]->INDEXNO}}" />
                                            
                                        </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td  align=""> <div  align="right" >Full Name</div></td>
                                        <td>
                                            {{ $data[0]->NAME}}
                                            
                                        </td>
                                        </tr>
                                        <tr>
                                            <td  align=""> <div  align="right" >Level</div></td>
                                        <td>
                                            {{ $data[0]->LEVEL}}
                                              
                                        </td>
                                        </tr>
                                        <tr>
                                            <td  align=""> <div  align="right" >Programme</div></td>
                                        <td>
                                            {{ @$sys->getProgram($data[0]->PROGRAMMECODE)}}
                                             <input type="hidden" name="programme"  value="{{ $data[0]->PROGRAMMECODE}}" />
                                           
                                        </td>
                                        </tr>
                                       
                                        <tr>
                                            <td  align=""> <div  align="right" class="uk-text-danger">SCHOOL FEES</div></td>
                                        <td>
                                          GHC  {{ $data[0]->BILLS}}
                                            <input type="hidden" id="bill" onkeyup="recalculateSum();" name="bill" value="{{$data[0]->BILL_OWING}}"/>
                                      
                                        </td>
                                        </tr>
                                          
                                         
                                         <tr>
                                            <td  align=""> <div  align="right" class="uk-text-primary">ACCUMULATED FEES OWING </div></td>
                                        <td>
                                          GHC  {{  $data[0]->BILL_OWING}}
                                            </td>
                                        </tr>
                                         <tr>
                                            <td align=""> <div  align="right" class="uk-text-success">Phone N<u>o</u></div></td>
                                        <td>
                                          
                                            <input type="text" class="md-input" maxlength="10" min="10"  name="phone" value="{{$data[0]->TELEPHONENO}}"/>
                                      
                                        </td>
                                        </tr>
                                        </table>
                                    </td>
                                    <td valign="top">
                                        <img   style="width:150px;height: auto;"  <?php
                                        $pic = $data[0]->INDEXNO;
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
            $("#form").on("submit",function(event){
                event.preventDefault();
       UIkit.modal.alert('Processing Fee Payments.Please wait.....');
         $(event.target).unbind("submit").submit();
    
                        
            });
            
    
                    
    
    });
</script>
 <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
  <script>


//code for ensuring vuejs can work with select2 select boxes
Vue.directive('select', {
  twoWay: true,
  priority: 1000,
  params: [ 'options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2({
        data: this.params.options,
         width: "resolve"
      })
      .on('change', function () {
        self.vm.$set(this.name,this.value)
        Vue.set(self.vm.$data,this.name,this.value)
      })
  },
  update: function (newValue,oldValue) {
    $(this.el).val(newValue).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
})


var vm = new Vue({
  el: "body",
  ready : function() {
  },
 data : {
   
   
 options: [    ]  
    
  },
   
})

</script>
             
 </div>
  
 @endsection
 
@section('js')
 <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
  <script>


//code for ensuring vuejs can work with select2 select boxes
Vue.directive('select', {
  twoWay: true,
  priority: 1000,
  params: [ 'options'],
  bind: function () {
    var self = this
    $(this.el)
      .select2({
        data: this.params.options,
         width: "resolve"
      })
      .on('change', function () {
        self.vm.$set(this.name,this.value)
        Vue.set(self.vm.$data,this.name,this.value)
      })
  },
  update: function (newValue,oldValue) {
    $(this.el).val(newValue).trigger('change')
  },
  unbind: function () {
    $(this.el).off().select2('destroy')
  }
})


var vm = new Vue({
  el: "body",
  ready : function() {
  },
 data : {
   
   
 options: [    ]  
    
  },
   
})

</script>
@endsection