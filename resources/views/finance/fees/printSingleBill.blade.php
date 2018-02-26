@extends('layouts.printlayout')

@section('content')
    <style>
        @page {
            size: A4;
        }
        body{
            background-image:url("{{url('public/assets/img/background.jpgs') }}");
            background-repeat: no-repeat;
            background-attachment: fixed;
            line-height:1.5;
        }
        .watermark {

            position:absolute;
            overflow:hidden;
        }

        .watermark::after {
            content: "";
            background:url();
            opacity: 0.2;
            top: 0;
            left: 30;
            bottom: 0;
            right: 0;
            position: absolute;
            z-index: -1;
            background-size: contain;
            content: " ";
            display: block;
            position: absolute;
            height: 100%;
            width: 100%;
            background-repeat: no-repeat;
        }
        @media print {
            .watermark {
                display: block;
            table {float: none !important; }
            div { float: none !important; }
        }
        .uk-grid, to {display: inline !important} s
                                                  #page1	{page-break-before:always;}
        .condition	{page-break-before:always;}
        #page2	{page-break-before:always;}
        .school	{page-break-before:always;}
        .page9	{page-break-inside:avoid; page-break-after:auto}
        a,
        a:visited {
            text-decoration: underline;
        }
        body{font-size: 14px}
        size:A4;
        a[href]:after {
            content: " (" attr(href) ")";
        }

        abbr[title]:after {
            content: " (" attr(title) ")";
        }


        a[href^="javascript:"]:after,
        a[href^="#"]:after {
            content: "";
        }
        .uk-grid, to {display: inline !important}


    </style>
    <div align="" style="margin-left:-44px">


            <div   class="uk-grid" data-uk-grid-margin>
                <div class="uk-grid-1-1 uk-container-center">
                    @inject('sys', 'App\Http\Controllers\SystemController')
                    <?php for ($i = 1; $i <= 1; $i++) {?>


                    <table   border="0">
                        <tr>
                            <td width="10">&nbsp;</td>
                            <td width="722"><div align="center" >
                                    <div  class=" uk-margin-bottom-remove" >

                                        <img src='{{url("public/assets/img/logo.png")}}' style="width:100px;height: auto"/>
                                        <h3>{{strtoupper("Asamankese Senior High School")}}</h3></div>
                                    <span class="uk-text-bold uk-margin-top-remove uk-text-upper">STUDENT'S Bill For {{$year}} Academic Year, Term {{$sem}}
                          </span>
                                    <br/>
                                    <br/>
                                    @if($sem==3)
                                        <span class="uk-text-bold uk-margin-top-remove uk-text-upper">
                                                Next Term Begins:
                                            {!!$sys->nextYear($year)!!}&nbsp;, Term {!!$sys->nextTerm($sem)!!}
                      </span>
                                    @endif

                                </div>
                                <div align="center"></div></td>
                        </tr>
                    </table>
                    <div>
                        <p>STUDENT'S NAME: &nbsp;&nbsp; {{$name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            BILL CATEGORY: &nbsp;&nbsp; {{strtoupper($residence)}}
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp
                            Form: &nbsp;&nbsp; {{$class}}</p>
                    </div>
                    <div>
                        <p style="margin-left: 266px">Debit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;

                            Credit</p>
                    </div>

                    <table border="1" class="uk-table uk-table-striped">

                        <thead>
                        <th class="uk-text-bold">BILL ITEM</th>
                        <th>GHS</th>

                        <th>BILL ITEM</th>
                        <th>GHS</th>

                        </thead>
                        <tbody>
                        <tr>
                            <td>Arears from last term</td>
                            <td>0.00</td>

                            <td>Credit from last sem</td>
                            <td>0.0</td>


                        </tr>
                        @foreach($bills as $index=> $row)

                            <tr align="">
                                <td>{{$row->Item_Description}}</td>
                                <td>{{$row->Debit_Amount}} <?php    $total[]=$row->Debit_Amount;?></td>
                                <td>{{$row->Credit_Amount}} <?php    $credit[]=$row->Credit_Amount;?></td>

                            </tr>

                        @endforeach
                        <tr>
                            <td colspan="">TOTAL DEBIT<div style="" class="uk-text-bold uk-text-danger"> </div></td>
                            <td>{{number_format(array_sum($total),2)}}</td>

                            <td colspan="">TOTAL CREDIT<div style="" class="uk-text-bold uk-text-danger"> </div></td>
                            <td>{{number_format(array_sum($credit),2)}}</td>


                        </tr>



                        </tbody>
                    </table>



                    <?php }
                    ?>
                    <div>
                        <p>Next Term Begins :12th May,<?php echo date("Y");?></p>
                        <p>1.Payments must be made on or before opening of term failure which student will be refused the remittance</p>
                        <p>2. All payments must be made by Ghana Commercial Bank Order made payable to the headmaster Asamankese Senior High School</p>
                        <p>3. These bill must be shown when payment is made through post. Please send bill with your remittance</p>
                    </div>


                    <div align="center">
                        <p>............................................</p>
                        <p>(ACCOUNTANT)</p>
                    </div>
                    <div class="visible-print text-center" align="center"  >
                        <p>
                        <center> <?php
                            echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($term, "C39+") . '" alt="barcode"   />';
                            ?>    </center>
                        </p>

                    </div>
                </div>

            </div>
        </div>




@endsection

@section('js')
    <script type="text/javascript">

        $(document).ready(function(){
          //  window.print();
//window.close();
        });

    </script>

@endsection