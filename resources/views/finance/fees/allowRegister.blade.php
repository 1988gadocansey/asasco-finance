@extends('layouts.app')

 
   
@section('style')
 
        <script src="{!! url('public/assets/js/jquery.min.js') !!}"></script>
 
        <script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
 
    <link rel="stylesheet" href="{!! url('public/assets/css/jquery-ui.css') !!}" media="all">
        
@endsection
 @section('content')
  <div class="md-card-content">
@if(Session::has('success'))
            <div style="text-align: center" class="uk-alert uk-alert-success  uk-alert-close" data-uk-alert="">
                {!! Session::get('success') !!}
            </div>
 @endif
 
  
     @if (Session::has('error'))

    
        <div class="uk-alert uk-alert-danger  uk-alert-close" style="background-color: red;color: white" data-uk-alert="">
  {!! Session::get('error') !!}
               
        </div>
   
@endif
 
 
 </div>
 <div align="center">
     <h3 class="heading_b uk-margin-bottom">Special Registration Protocol</h3>
 <div class="uk-width-small-1-2">
     <div class="md-card">
         <div class="md-card-content" style="height: 300px;">
             <h5 >Search student  by Name or Index Number or Admission Number here</h5>
            
             <form method="POST" action=""  accept-charset="utf-8"  name="applicationForm"  v-form>
                  <input type="hidden" name="_token" value="{!! csrf_token() !!}"> 
             <div class="uk-grid" data-uk-grid-margin>
                 
                 <div class="uk-width-medium-1-2">
                     <div class="uk-form-row">
                         <div class="uk-grid" data-uk-grid-margin>
                             <div class="uk-width-1-1">

                                 <input type="text" value="" id="q" class="md-input md-input-success" required="" name="q" placeholder="begin typing  here... " v-model="q" v-form-ctrl=""/>
                             </div>

                         </div>
                     </div>
                     <p>&nbsp;</p>
                     <div class="uk-grid"  >
                         <div class="uk-width-1-1">
                             <input type="submit"  v-show="applicationForm.$valid" class="md-btn md-btn-primary" value="Go"  />
                         </div>
                     </div>
                 </div>
             </div>
             </div>
             </form>
         </div>
     </div>
 </div>
  
  <script type="text/javascript">
           //Javascript
$(function()
{
	 $( "#q" ).autocomplete({
	  source: "{{ url('search/autocomplete') }}",
	  minLength: 3,
	  select: function(event, ui) {
	  	$('#q').val(ui.item.value);
                
	  }
	});
});
        </script>
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