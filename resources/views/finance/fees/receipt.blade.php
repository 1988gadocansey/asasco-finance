@extends('layouts.printlayout')

@section('content')
<style>
@media print{@page {size: landscape}}

</style>

    <div align="" style="margin-left: 12px">
 
                    @inject('sys', 'App\Http\Controllers\SystemController')
                    <?php for ($i = 1; $i <= 1; $i++) {?>

                    <table  width="1000"   border="0" cellspacing="1">
                                    <tr>
                                         
                                                    <td>  <img src='{{url("public/assets/img/logo.PNG")}}' style="width:70px;height: auto;margin-top:-48px; margin-left:80px"/>
                                                              
 
                                                              </td>
                                                    <td style="text-align:center;text-transform:uppercase;margin-left:20px" class="uk-text-upper"> 
                                                             

                                                                <p>Asamankese Senior High School  <br/>
                                                               Asamankese,E/R <br/>
                                                                 Tel, +23348383838 <br/> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span   class="uk-text-success">OFFICIAL RECEIPTS</span>
                                                  
                                                                 </p>
                                                                <h4 class="uk-text-success"> Accounts Office</h4>
                                                                
                                                                <hr>
                                                    </td>

                                                            
                                                
                                     </tr>
                                     
                                      
                                          

                     </table>
                     <p> <span class="uk-text-bold">TOTAL ACADEMIC YEAR SCHOOL FEES:   GHC{!!  @$student->termBill!!}</span>
                         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                      <span class="uk-text-bold">RECEIPT NO:   {!!  @$transaction->receiptno; !!}</span>
                         &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                         &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
                         <span class="uk-text-bold uk-text-upper">DATE:  {!! date("F j, Y, g:i a",strtotime(@$transaction->dates))  !!}</span>
                     </p>

                    <p class="uk-text-bold uk-text-upper">RECEIVED FROM : {!!ucwords(@$student->name) !!}</p>
                    <p class="uk-text-bold uk-text-upper">THE SUM OF :   GHC {!! @$transaction->paid!!}  &nbsp;(<span > {!! $words !!}</span> )</p>
                    <p class="uk-text-bold uk-text-upper">PAYMENT OF FEES FOR :   {!! ucwords($transaction->type)!!} fees FOR {!! @$student->currentClass !!}  </p>

                    <p class="uk-text-bold uk-text-upper">RECEIVED BY : {!! ucwords(@$transaction->staff->name)!!}</p>




                    <?php }
                    ?>


                </div>

        

@endsection

@section('js')
    <script type="text/javascript">

        $(document).ready(function(){
           // window.print();
//window.close();
        });

    </script>

@endsection