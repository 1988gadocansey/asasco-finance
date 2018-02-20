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
                                    @if($sem==3)
                                    <tr>
                                            <td  align=""> <div  align="right" class="uk-text-success">Promote or Demote to class</div></td>
                                        <td>
                                          
                                             {!! Form::select('class', $class, old("class",""), ['class' => 'md-input parents' ,'placeholder' => 'Select class']);!!}

                                            <p class="uk-text-danger uk-text-small"  v-if="applicationForm.level.$error.required" >Level is required</p>

                                        </td>
                                        </tr>
                                    @endif
                                         
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
                                        <td  align=""> <div  align="right" class=" ">Fees Type</div></td>
                                        <td>

                                            {!!   Form::select('type', ['All' => 'Total Fees','Academic'=>'Academic Facility User Fees', 'PTA' => 'PTA','Boarding' => 'Boarding' ], null, ['class' => 'md-input ','required'=>'','id'=>"type",'v-model'=>'type','v-form-ctrl'=>'','v-select'=>'','placeholder' => 'select fee type']);!!}
                                            <p class="uk-text-danger uk-text-small"  v-if="applicationForm.type.$error.required" >Fee type  is required</p>

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
                                            $banks  ,
                                                null, 
                                                ['required'=>'','class' => 'md-input','v-model'=>'bank','v-form-ctrl'=>'','v-select'=>''] )  !!}


                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.bank.$error.required" >Bank  is required</p>

                                        </td>
                                        </tr>

                                        <tr>
                                            <td  align=""> <div  align="right" class=" ">Payment Mode</div></td>
                                        <td>
                                            <select name="payment_detail" required="" class="md-input" v-form-ctrl='' v-model='payment_detail' v-select=''>
                                                <option>Select payment type</option>
                                                <option value="Cash">Cash</option>
                                                 
                                                <option value="Bursery">Bursery</option>
                                                <option value="Overdraft">Overdraft</option>
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

                                        </td>
                                        </tr>

                                          <tr>
                                            <td  align=""> <div  align="right" >Index Number</div></td>
                                        <td>
                                            {{ $data[0]->indexNo}}
                                             <input type="hidden" name="student" id="student" value="{{ $data[0]->indexNo}}" />
                                            
                                        </td>
                                        </tr>

                                        <tr>
                                            <td  align=""> <div  align="right" >Full Name</div></td>
                                        <td>
                                            {{ $data[0]->name}}
                                            
                                        </td>
                                        </tr>
                                        <tr>
                                            <td  align=""> <div  align="right" >Current Class</div></td>
                                        <td>
                                            {{ $data[0]->currentClass}}
                                            <input type="hidden" name="currentClass"  value="{{ $data[0]->currentClass}}" />
                                        </td>
                                        </tr>
                                        <tr>
                                            <td  align=""> <div  align="right" >Programme</div></td>
                                        <td>
                                            {{ @$sys->getProgram($data[0]->programme)}}
                                             <input type="hidden" name="programme"  value="{{ $data[0]->code}}" />
                                           
                                        </td>
                                        </tr>


                                            <tr>
                                                <td  align=""> <div  align="right" class="uk-text-danger">Term Bills:</div></td>
                                                <td class="uk-text-bold">
                                                    GHS  {{ $data[0]->termBill}}

                                                </td>
                                            </tr>




                                            <tr>
                                                <td  align=""> <div  align="right" class="uk-text-primary">Academic Owings: </div></td>
                                                <td class="uk-text-bold">
                                                    GHS  {{  $data[0]->academicBillOwing}}
                                                    <input type="hidden" id="academic" onkeyup="recalculateSum();" name="academic" value="{{$data[0]->academicBillOwing}}"/>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td  align=""> <div  align="right" class="uk-text-primary">PTA Owings: </div></td>
                                                <td class="uk-text-bold">
                                                    GHS  {{  $data[0]->ptaOwing}}
                                                    <input type="hidden" id="pta" onkeyup="recalculateSum();" name="pta" value="{{$data[0]->ptaOwing}}"/>

                                                </td>
                                            </tr>
                                            @if($data[0]->studentType=="BOARDING")
                                                <tr>
                                                    <td  align=""> <div  align="right" class="uk-text-primary">Boarding Owings: </div></td>
                                                    <td class="uk-text-bold">
                                                        GHS  {{  $data[0]->boardingOwing}}
                                                        <input type="hidden" id="boarding" onkeyup="recalculateSum();" name="boarding" value="{{$data[0]->boardingOwing}}"/>

                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td  align=""> <div  align="right" class="uk-text-danger">Accumulated Owings b/f:</div></td>
                                                <td class="uk-text-bold">
                                                    GHS  {{ $data[0]->totalOwing}}
                                                    <input type="hidden" id="bill" onkeyup="recalculateSum();" name="total" value="{{$data[0]->totalOwing}}"/>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="" class="uk-text-bold"> <div  align="right" class="uk-text-success">Guardian Phone N<u>o</u>:</div></td>
                                                <td>

                                                    <input type="text" class="md-input" maxlength="10" min="10"  name="phone" value="{{$data[0]->parentPhone}}"/>

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