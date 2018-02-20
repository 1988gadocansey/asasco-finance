@extends('layouts.printlayout')

@section('content')
<style>
@media print{@page {size: landscape}}

</style>

    <div align="" style="margin-left: 12px">

        <div class="md-card" >
            <div   class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid-1-1 uk-container-center">
                    @inject('sys', 'App\Http\Controllers\SystemController')
                    <?php for ($i = 1; $i <= 1; $i++) {?>

                    <table   border="0">
                        <tr>
                            <td   style="border:dashed; text-align: left;"><table width="738" height="451" border="0" cellspacing="1">
                                    <tr>
                                        <td colspan="4">
                                            <table   border="0">
                                                <tr>
                                                    <td width="10">&nbsp;</td>
                                                    <td width="722"><div align="center" >
                                                            <div  class=" uk-margin-bottom-remove" >

                                                                <img src='{{url("public/assets/img/logo.PNG")}}' style="width:100px;height: auto"/>
                                                                <h3>Asamankese Senior High School - Accounts Office</h3></div>
                                                            <span class="uk-text-bold uk-margin-top-remove  ">{!! $transaction->type !!} Fees Payment Receipt
                          </span>
                                                            <P></P>
                                                            <span class="uk-text-bold">Total Academic year fees GHC{!!  @$student->termBill!!}</span>

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
                                                                <td width="281" >  {!! date('D, d/m/Y, g:i a',strtotime(@$transaction->dates))  !!}&nbsp;</td>
                                                                <td width="172"><div align="right"><strong>Receipt No.</strong></div></td>
                                                                <td width="184" >{!!  @$transaction->receiptno; !!}&nbsp;</td>
                                                            </tr>
                                                            <tr>

                                                                <td><div align="right"><strong>Class:</strong></div></td>
                                                                <td >{!! @$student->currentClass !!}</td>
                                                                <td><div align="right"><strong>Term /Year:</strong></div></td>
                                                                <td >{!! @$term !!}/{!! @$year !!}</td>
                                                            </tr>
                                                        </table></td>
                                                </tr>
                                            </table></td>
                                    </tr>
                                    <tr>
                                        <td width="164"><strong>Index Number</strong></td>
                                        <td width="602" colspan="3" style=" border-bottom-style:dotted"><strong>{!!@$student->indexNo !!}</strong></td>
                                    </tr>
                                    <tr>
                                        <td width="164"><strong>Name</strong></td>
                                        <td width="602" colspan="3" style=" border-bottom-style:dotted"><strong><span class=''>{!!ucwords(@$student->name) !!}</span></strong></td>
                                    </tr>
                                    <tr>
                                    </tr>
                                    <tr>
                                        <td><strong>Cashier's Name  </strong></td>
                                        <td colspan="3" style=" border-bottom-style:dotted"><strong>{!! ucwords(@$transaction->staff->name)!!}</strong></td>
                                    </tr>

                                    <tr>
                                        <td><strong>Payment Type  </strong></td>
                                        <td colspan="3" style=" border-bottom-style:dotted"><strong>{!!  ucwords($transaction->type)!!} fees</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Amount Paid</strong></td>
                                        <td colspan="3" style=" border-bottom-style:dotted"><strong>GHC{!! @$transaction->paid!!}.00</strong>&nbsp;(<span > {!! $words !!}</span> )</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Balance</strong></td>
                                        <td colspan="3" style=" border-bottom-style:dotted"><strong>GHC{!! @$student->totalOwing!!}.00</strong>&nbsp;</td>
                                    </tr>
                                    <tr>


                                    <tr>

                                    </tr>

                                    <tr>
                                        <td colspan="4" align="center">&nbsp;
                                            <center><p style="margin-left:-100px"><?php
                                                    echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($student->indexNo, "C39+") . '" alt="barcode"   />';
                                                    ?>   </p></center>
                                        </td>
                                    </tr><?php  \Session::forget('pupil');?>
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