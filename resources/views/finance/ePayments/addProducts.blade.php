@extends('layouts.app')

 
@section('style')
 
@endsection
 @section('content')
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
 <div class="uk-width-large-8-10"  >
 <div class="md-card">
     <div class="md-card-content"  >
 
 <center><h3 class="heading_a">Payment Product Creation</h3></center>
 <p>&nbsp;</p>
	<form class="uk-form uk-form-horizontal"  action="" method="post">

                              <input type="hidden" name="_token" value="{!!  csrf_token ()  !!}">
                                <div class="uk-form-row">
                                    <label for="form-h-it" class="uk-form-label">Purpose</label>
                                    <div class="uk-form-controls">
                                          </div>
                                </div>
                                <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Payment Name</label>
                                    <div class="uk-form-controls">
                                        <input name="payment_name" class="" placeholder="Brand Name for Payment" id="payment_name" value="{{ old("payment_name",@$paymentproduct->payment_name) }}">
                                    </div>
                                </div>
                                    <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Bank Account Number</label>
                                    <div class="uk-form-controls">
                                        <input name="account_no" placeholder="Enter Account No" id="account_no" value="{{  old("account_no",@$paymentproduct->account_no)  }}">
                                    </div>
                                </div>
                          <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Deadline of Payment</label>
                                    <div class="uk-form-controls">
                                        <input name="deadline" placeholder="PAYMENT WILL BE DISABLED AFTER DATE" id="deadline" data-uk-datepicker="{format:'YYYY-MM-DD'}"  value="{{  old("deadline",@$paymentproduct->deadline)}}"  class="form-control">
                                    </div>
                                </div>

<div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Payment Made Being</label>
                                    <div class="uk-form-controls">
                                <input name="payment_info" placeholder="WHAT SHOULD APPEAR ON RECEIPT"  value="{{ old("payment_info",@$paymentproduct->payment_info) }}"   id="payment_info">
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Part Payment Acceptable</label>
                                    <div class="uk-form-controls">
                                        {!! Form::select("accept_part_payment",array_combine(range(0,100,5),range(0,100,5)),old("accept_part_payment",@$paymentproduct->accept_part_payment) ,array("placeholder"=>"IS PART PAYMENT ACCEPTED" ,"id"=>"accept_part_payment"))  !!} % of amount
                                    </div>
                                </div>
                                <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Currency</label>
                                    <div class="uk-form-controls">
                                        {!! Form::select("currency",array("GHC"=>"GHC","POUNDS"=>"POUNDS","DOLLAR"=>"DOLLAR","EURO"=>"EURO"),old("currency",@$paymentproduct->currency) ,array( "id"=>"currency","placeholder"=>"Select Currency"))  !!}
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Default Transactional Value</label>
                                    <div class="uk-form-controls">
                                        <input name="default_value" placeholder="COST PER TRANSACTION"   id="default_value"  value="{{  old("default_value",@$paymentproduct->default_value)}}" >
                                    </div>
                                </div>
                               <div class="uk-form-row">
                                    <label for="form-h-ip" class="uk-form-label">Charge on Transaction</label>
                                    <div class="uk-form-controls">
                                        <input name="cot" placeholder="CHARGE ON TRANSACTION"   id="default_value"  value="{{  old("cot",@$paymentproduct->cot)}}" >
                                    </div>
                                </div>

                                <div class="uk-form-row">
                                    <label for="form-h-t" class="uk-form-label">Payment Period Info</label>
                                    <div class="uk-form-controls">
                                        <textarea  name="payment_period" id="payment_period"  rows="3" cols="30" id="form-h-t"  placeholder="LIKE YEAR:2013/2014 TERM:1 OR MONTH:JULY">
                                          {!!  trim(old("payment_period",@$paymentproduct->payment_period) ) !!}
                                        </textarea>
                                    </div>
                                </div>

<div class="uk-form-row">
                                    <label for="form-h-t" class="uk-form-label">Instruction to Follow After Payment</label>
                                    <div class="uk-form-controls">
                                        <textarea  name="usage_instruction" id="usage_instruction"  rows="3 " cols="30" id="form-h-t" placeholder="PLEASE ENTER WHAT THE PAYEE SHOULD DO AFTER PAYMENT">
                                          {{  old("usage_instruction",trim(@$paymentproduct->usage_instruction))  }}
                                        </textarea>
                                    </div>
                                </div>

                                       <div class="uk-form-row">
                                         <div class="uk-form-controls">
                                        <input class="md-btn md-btn-primary "  type="submit" name="submit" value="SAVE">
                                        <input class="md-btn md-btn-warning " type="reset" name="cancel" value="CANCEL">
                                    </div>
                                </div>


                            </form>
 
 
  </div>
 </div>
 </div>
 @endsection
@section('js')
<script>
        $(document).ready(function(){
            $("#form").on("submit",function(event){
                event.preventDefault();
       UIkit.modal.alert('Creating fees...');
         $(event.target).unbind("submit").submit();
    
                        
            });
            
    
                    
    
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