
<!doctype html>
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="icon" type="image/png" href="public/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="public/assets/img/favicon-32x32.png" sizes="32x32">

    <title>Portal | Takoradi Technical University</title>


    <!-- uikit -->
    <link rel="stylesheet" href="{!! url('public/assets/plugins/uikit/css/uikit.almost-flat.min.css') !!} " media="all">

    
    <link rel="stylesheet" href="{!! url('public/assets/css/main.min.css') !!}" media="all">
     <link rel="stylesheet" href="{!! url('public/assets/css/combined.min.css') !!}" media="all">
   
     <link rel="stylesheet" href="{!! url('plugins/sweet-alert/sweet-alert.min.css') !!}" media="all">
     <!-- font awesome -->
      <link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
     <link rel="stylesheet" href="{!! url( 'datatables/css/jquery.dataTables.min.css')  !!}" >
   <link rel="stylesheet" href="{!! url( 'datatables/css/dataTables.uikit.min.css')  !!}" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    
    @yield('style')
 
</head>
<body class=" ">
     
    <!-- main sidebar end -->

    <div id="page_content">
        <div id="page_content_inner">

            <div class="md-card">
                <div
                    
                <div   class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid-1-1 uk-container-center">
                  @yield('content')
                  </div>
                </div>
            </div>

          
            </div>

        </div>
    </div>
      
</body>
   <script src="{!! url('public/assets/js/common.min.js') !!}"></script>
<!-- uikit functions -->
<script src="{!! url('public/assets/js/uikit_custom.min.js') !!}"></script>

<!-- altair common functions/helpers -->
<script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>
<script src="{!! url('public/assets/js/uikit/uikit.min.js') !!}"></script>
 
 <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script src='{!! url( "public/assets/plugins/sweet-alert/sweet-alert.min.js")  !!}' ></script>

<script src="{!! url('public/assets/js/vue.min.js') !!}"></script>
<script src="{!! url('public/assets/js/vue-form.min.js') !!}"></script>
<script src="{!! url('public/assets/js/jquery-ui.min.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/tableExport.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jquery.base64.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/html2canvas.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/libs/sprintf.js') !!}"></script>

<script src="{!! url('public/assets/tableexport/jspdf/jspdf.js') !!}"></script>
<script src="{!! url('public/assets/tableexport/jspdf/libs/base64.js') !!}"></script>
 <script src="{!! url('datatables/js/jquery.dataTables.min.js') !!}"></script>
  
 <script src="{!! url('datatables/js/dataTables.uikit.min.js') !!}"></script> 
  <script src="{!! url('datatables/js/plugins_datatables.min.js') !!}"></script>
 <script src="{!! url('datatables/js/datatables_uikit.min.js') !!}"></script> 
 
     @yield('js')

     <script type="text/javascript">
    $.ajaxSetup({
       headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });
    </script>
   <script>
    // load parsley config (altair_admin_common.js)
    altair_forms.parsley_validation_config();
    // load extra validators
    altair_forms.parsley_extra_validators();
    </script>
   <script>
$(document).ready(function(){
  $('select').select2({ width: "resolve" });

  
});


</script>
<script>
         function recalculateSum()
            {
                var num1 = parseFloat(document.getElementById("pay").value);
                var num2 = parseFloat(document.getElementById("bill").value);
                 
                  
                     
                        document.getElementById("amount_left").value =( num2-  num1)    ;
                     
                    
            }         
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}      
						
function printpage()
{
   type=document.getElementById("type").value;
      draft=document.getElementById("draft").value;

  if(draft==''){ alert('PLEASE TYPE DRAFT NO');
  return false;
  }
  
  if(type==''){ alert('PLEASE SELECT PAYMENT TYPE');
  return false;
  }
  
   pay=document.getElementById("pay").value;
   stuid=document.getElementById("indexno").value;
   receipt=document.getElementById("receiptno").value;
   draft=document.getElementById("draft").value;
  
   
	 
	
	 

 
}
      </script>