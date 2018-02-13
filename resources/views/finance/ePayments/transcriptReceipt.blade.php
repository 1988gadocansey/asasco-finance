@extends('layouts.printlayout')

@section('content')

 <div align="" style="margin-left: 12px">
      
         <div class="md-card">
             <div   class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid-1-1 uk-container-center">
                     @inject('sys', 'App\Http\Controllers\SystemController')
                  <?php for ($i = 1; $i <= 2; $i++) {?>

  <table width="200" border="0">
        <tr>
          <td   style="border:dashed; text-align: left;"><table width="738" height="451" border="0" cellspacing="1">
            <tr>
              <td colspan="4">
                  <table width="742" height="139" border="0">
                    <tr>
                      <td width="10">&nbsp;</td>
                      <td width="722"><div align="center" >
                        <div  class=" uk-margin-bottom-remove" >
                            
                            <img src='{{url("assets/img/logo.png")}}' style="width:100px;height: auto"/>
                            <h3>Takoradi Polytechnic - Finance Office</h3></div>
                        <span class="uk-text-bold uk-margin-top-remove">Transcript Application Payment
                          </span>
                               
                      </div>
                      <div align="center"></div></td>
                    </tr>
                    </table>
              </td>
            </tr>
            <tr>
              <td colspan="4"><table width="769" border="0">
                <tr>
                  <td><table width="758" border="0">
                    <tr>
                      <td width="103"><div align="right"><strong>
                                                Date:</strong></div></td>
                      <td width="281" >  {!! date('D, d/m/Y, g:i a',strtotime($transaction->TRANSDATE))  !!}&nbsp;</td>
                      <td width="172"><div align="right"><strong>Receipt No.</strong></div></td>
                      <td width="184" >{!!  $transaction->RECEIPTNO; !!}&nbsp;</td>
                      </tr>
                    <tr>
                        <td align="right"><strong>Programme:</strong></td>
                      <td>{!! $sys->getProgram($transaction->student->PROGRAMMECODE )!!}</td>
                      <td><div align="right"><strong>Level:</strong></div></td>
                      <td >{!! $transaction->student->LEVEL !!}</td>
                      </tr>
                  </table></td>
                </tr>
              </table></td>
              </tr>
            <tr>
              <td width="164"><strong>Name</strong></td>
              <td width="602" colspan="3" style=" border-bottom-style:dotted"><strong>{!!$transaction->student->NAME !!}</strong></td>
            </tr>
            <tr>
                <td width="164"><strong>N<u>o</u> of copies</strong></td>
              <td width="602" colspan="3" style=" border-bottom-style:dotted"><strong>{!!$transaction->NO_COPIES !!}</strong></td>
            
            </tr>
            
            <tr>
              <td><strong>Amount Paid</strong></td>
              <td colspan="3" style=" border-bottom-style:dotted"><strong>GHC{!! $transaction->AMOUNT!!}.00</strong>&nbsp;(<span > {!! $words !!}</span> )</td>
            </tr>
            
            <tr>
                
           
            <tr>
                
            </tr>
            <tr>
              <td colspan="4" align="center">&nbsp;
                <div style="width:90%">Go to Academic Affairs/Students Records Management Section to print your transcript</div></td>
            </tr>
          </table></td>
        </tr>
      </table>

 <?php }
?>

                  </div>
                </div>

         </div>
    
 
 </div>
  
        
 @endsection
 
@section('js')
 <script type="text/javascript">
  
$(document).ready(function(){
window.print();
//window.close();
});

</script>
  
@endsection