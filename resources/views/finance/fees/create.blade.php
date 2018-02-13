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

         <h5 class=" ">Creating   Fees   here</h5>
         <form action="{{url('/create_fees')}}" method="POST" id="form" accept-charset="utf-8"  name="applicationForm"  v-form>
             <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
               <div class="uk-grid" data-uk-grid-margin>
              
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <div class="uk-grid">
                                    <div class="uk-width-medium-1-2">
                                        <label>Fee Name</label>
                                        <input type="text" class="md-input" name="name"  v-model="name" v-form-ctrl=""   required="" value="{{ old('name') }}"/>
                                         <p class="uk-text-danger uk-text-small"  v-if="applicationForm.name.$error.required" >Fee Name  is required</p>

                                    </div>
                                    <div class="uk-width-medium-1-2">
                                        <label>Fee Type</label>
                                        <input type="text" class="md-input" name="type"   value="{{ old('type') }}" />
                                    </div>
                                </div>
                            </div>
                             
                             
                                <div class="uk-form-row">
                                <label>Fee Description</label>
                                <input type="text" class="md-input md-input" name="description" value="{{ old('description') }}"   />
                      
                            </div>
                                 <div class="uk-form-row">
                                <label>Level</label>
                                <p></p>
                                {{ Form::select('level', array(''=>'select level','All'=>'All','50'=>'50','1'=>'1st years','2' => '2nd years', '3' => '3rd years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ["required"=>"required",'class' => 'md-input','v-model'=>'level','v-form-ctrl'=>'','v-select'=>'']) }}
                                  <p class="uk-text-danger uk-text-small"  v-if="applicationForm.level.$error.required" >Level is required</p>

                               </div>
                               <div class="uk-form-row">
                                <label>Academic year</label>
                                <p></p>
                                       {!! Form::select('year', 
                                (array(''=>'Select year','2015/2016' => '2015/2016', '2016/2017' => '2016/2017','2017/2018'=>'2017/2018','2018/2019'=>'2018/2019') ), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','v-model'=>'year','v-form-ctrl'=>'','v-select'=>''] )  !!}
                                    <p class="uk-text-danger uk-text-small"  v-if="applicationForm.year.$error.required" >Year is required</p>

                             </div>
                       
                             <div class="uk-form-row">
                                <label>Student Type</label>
                                <p></p>
                                       {!! Form::select('country', 
                                (['' => 'Select Nationality'] + $country), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','v-model'=>'country','v-form-ctrl'=>'','v-select'=>''] )  !!}
                                    <p class="uk-text-danger uk-text-small"  v-if="applicationForm.country.$error.required" >Student type is required</p>

                               </div>
               
                        </div>
                        <div class="uk-width-medium-1-2">
                            <div class="uk-form-row">
                                <label>Amount</label>
                                <input type="text" class="md-input md-input" name="amount" value="{{ old('amount') }}" required="" v-model='amount' v-form-ctrl='' />
                                 <p class="uk-text-danger uk-text-small"  v-if="applicationForm.amount.$error.required" >Amount is required</p>

                            </div>
                            
                              <div class="uk-form-row">
                                <label>Session Type</label>
                                <p></p>
                                {{ Form::select('stype', array(''=>'select session','Regular'=>'Regular', 'Evening'=>'Evening'), null, ["required"=>"required",'class' => 'md-input','v-model'=>'stype','v-form-ctrl'=>'','v-select'=>'']) }}
                                 <p class="uk-text-danger uk-text-small"  v-if="applicationForm.stype.$error.required" >Student type is required</p>

                               </div>
               
                             <div class="uk-form-row">
                                <label>Programme</label>
                                <p></p>
                                       {!! Form::select('programme', 
                                ([''=>'select programme','All' => 'All Programmes'] + $program), 
                                    null, 
                                    ["required"=>"required",'class' => 'md-input','v-model'=>'programme','v-form-ctrl'=>'','v-select'=>''] )  !!}
                                    <p class="uk-text-danger uk-text-small"  v-if="applicationForm.programme.$error.required" >programme is required</p>

                               </div>
                            <div class="uk-form-row">
                                <label>Semester</label>
                                <p></p>
                                {{ Form::select('semester', array(''=>'select semester','1'=>'1', '2'=>'2','3'=>'3'), null, ["required"=>"required",'class' => 'md-input','v-model'=>'semester','v-form-ctrl'=>'','v-select'=>'']) }}
                                  <p class="uk-text-danger uk-text-small"  v-if="applicationForm.semester.$error.required" >Semester is required</p>

                               </div>
                 
                             
                            
                                  
                             
                        </div>
                             
                        </div>
                    </div>
                     
              

                 <div class="uk-grid" align='center'>
                            <div class="uk-width-1-1">
                                <button type="submit" v-show="applicationForm.$valid" class="md-btn md-btn-success"><i class="fa fa-save" ></i>Save</button>
                            </div>
                </div>
                    <p>&nbsp;</p>
        </form>
     </div>
 </div>
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