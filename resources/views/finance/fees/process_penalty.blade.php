@extends('layouts.app')

 
   
@section('style')
 
        <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
<style>
    .md-card{
        width: auto;
         
    
    
    
    }
</style>
@endsection
 @section('content')
  @inject('sys', 'App\Http\Controllers\SystemController')
 <div align="center">
  <h5> Late Registration Penalty  for {!! $sem !!} Semester  | {!! $year !!} Academic Year</h5>
             <hr>
             <form method="POST" action="{{ url('processPayment') }}" accept-charset="utf-8"  name="applicationForm"  v-form>
                 <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
            
                  <div align="center">
                    <legend align=" " class="style1">Personal Records of {!! $data[0]->TITLE.$data[0]->NAME!!}</legend>
                  </div>
     <div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
                <div class="uk-width-medium-1-2">
                    <div class="md-card">
                        <div class="md-card-content">
                            <table width="741" border="0">
                        <tr>
                            <td width="495"><div class="divcurve" style=" ">



                                    <table   class="">
                                         <tr>
                                            <th  align=""> <div  align="right" >Receipt No</div></th>
                                        <td>
                                            {{ $receipt}}
                                            <input type="hidden" name="receipt"   value="{{ $receipt}}" />
                                             <input type="hidden" name="type"   value="Late Registration Penalty" />
                                            
                                        </td>
                                        </tr>
                                        <tr>
                                            <th  align=""> <div  align="right" >Index Number</div></th>
                                        <td>
                                            {{ $data[0]->INDEXNO}}
                                             
                                        </td>
                                        </tr>
                                         
                                        <tr>
                                            <th  align=""> <div  align="right" >Full Name</div></th>
                                        <td>
                                            {{ $data[0]->NAME}}
                                            <input type="hidden" name="student" id="student" value="{{ $data[0]->INDEXNO}}" />
                                            
                                        </td>
                                        </tr>
                                        <tr>
                                            <th  align=""> <div  align="right" >Level</div></th>
                                        <td>
                                            {{ $data[0]->LEVEL}}
                                            <input type="hidden" name="level" id="level" value="{{ $data[0]->LEVEL}}" />
                                            <input type="hidden" name="phone" id="phone" value="{{ $data[0]->TELEPHONENO}}" />
                                             
                                        </td>
                                        </tr>
                                        <tr>
                                            <th  align=""> <div  align="right" >Programme</div></th>
                                        <td>
                                            {{ $data[0]->PROGRAMMECODE}}
                                             <input type="hidden" name="programme"  value="{{ $data[0]->PROGRAMMECODE}}" />
                                           
                                        </td>
                                        </tr>
                                        
                                         <tr>
                                            <th  align=""> <div  align="right" class="uk-text-success">Amount Paying GHC</div></th>
                                        <td>
                                            <input type="text" id="pay" required=""  onkeyup="recalculateSum();"  v-model="amount" v-form-ctrl=""  name="amount"   class="md-input">
                                             <p class="uk-text-danger uk-text-small"  v-if="applicationForm.amount.$error.required" >Payment amount is required</p>

                                            
                                        </td>
                                        </tr>
                                         
                                         
                                           
                                        
                                    </table>
                                </div>
                            </td></tr>
                        
                                        
                         
                                     </table>
                        </div>
                    </div>
                </div>
                <div class="uk-grid uk-grid-medium uk-grid-width-medium-1-2 uk-grid-width-large-1-3">
                    <div class="md-card">
                        <div class="md-card-content md-card-head md-bg-light-blue-600">
                             <table   border="0" bordercolor="">
                         <tr>
                             <td><a href=" "><img class="" style="width:150px;height: auto;margin-top: -46px"  <?php
                                     $pic = $data[0]->INDEXNO;
                                     echo $sys->picture("{!! url(\"albums/students/$pic.JPG\") !!}", 90)
                                     ?>   src='{{url("albums/students/$pic.JPG")}}' alt=" Picture of Student Here"    /></a></td> 

                         <p align="center">&nbsp;</p></td>
                         </tr>


                     </table>
                        </div>
                    </div>
                </div>
          
            </div>
                 <div class="uk-grid" align='center'>
                     <div class="uk-width-1-1">
                         <button  v-show="applicationForm.$valid" type="submit" class="md-btn md-btn-primary"><i class="fa fa-save" ></i>Accept</button>
                     </div>
                 </div>

             </form>
 </div>
  
 @endsection
 
@section('js')
 
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