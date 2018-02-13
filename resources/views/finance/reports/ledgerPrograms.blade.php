@extends('layouts.app')


@section('style')

@endsection
@section('content')

 

<div style="">
    <h5 class="heading_c uk-margin-bottom">Generate Cummulative Fee Report by Program</h5>  

    <div class="uk-margin-bottom" style="margin-left:1000px" >
        <i title="click to print" onclick="javascript:printDiv('print')" class="material-icons md-36 uk-text-success"   >print</i>

        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success"> show/hide columns <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
            </div>
        </div>
        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
            <button class="md-btn md-btn-small md-btn-success uk-margin-right">Export <i class="uk-icon-caret-down"></i></button>
            <div class="uk-dropdown">
                <ul class="uk-nav uk-nav-dropdown">
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'csv', escape: 'false'});"><img src='{!! url("public/assets/icons/csv.png")!!}' width="24"/> CSV</a></li>

                    <li class="uk-nav-divider"></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'excel', escape: 'false'});"><img src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> XLS</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'doc', escape: 'false'});"><img src='{!! url("public/assets/icons/word.png")!!}' width="24"/> Word</a></li>
                    <li><a href="#" onClick ="$('#ts_pager_filter').tableExport({type: 'powerpoint', escape: 'false'});"><img src='{!! url("public/assets/icons/ppt.png")!!}' width="24"/> PowerPoint</a></li>
                    <li class="uk-nav-divider"></li>

                </ul>
            </div>
        </div>
    </div>

</div>
<!-- filters here -->
@inject('fee', 'App\Http\Controllers\FeeController')
@inject('help', 'App\Http\Controllers\SystemController')
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            <form action=""  method="POST" accept-charset="utf-8" novalidate id="group">
                {!!  csrf_field()  !!}
                <div class="uk-grid" data-uk-grid-margin="">

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('program', 
                            (['' => 'All programs'] +$program ), 
                            old("program",""),
                            ['class' => 'md-input parent','required'=>"",'placeholder'=>'select program'] )  !!}
                        </div>
                    </div>
                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!!  Form::select('level', array( '1'=>'1st years','2' => '2nd years', '3' => '3rd years','4'=>'4th years','400/1'=>'BTECH level 1','400/2'=>'BTECH level 2'), null, ['placeholder' => 'select level','required'=>"",'class'=>'md-input parent'],old("level","")); !!}

                        </div>
                    </div>

                    <div class="uk-width-medium-1-5">
                        <div class="uk-margin-small-top">
                            {!! Form::select('year', 
                            (['' => 'Select year'] +$year ), 
                            old("year",""),
                            ['class' => 'md-input parent','id'=>"parent"] )  !!}
                        </div>
                    </div>







                    <div class="uk-width-medium-1-10"  style="" >                            
                        <div class="uk-margin-small-top">
                            <button type="submit" class="md-btn md-btn-flat md-btn-primary md-btn-wave" id="snippet_new_save">Search</button>    

                        </div>
                    </div>



                </div>

            </form> 
        </div>
    </div>
</div>

<!-- end filters -->
<div class="uk-width-xLarge-1-1">
    <div class="md-card">
        <div class="md-card-content">

            @if(!empty($query))
            <div class="uk-overflow-container" id='print'>
                <center><span class="heading_c uk-margin-bottom">Cummulative fee report for {!! $programme !!}  Level  {{ @$level }}</span> </center>
                <center><span class="uk-text-success uk-text-bold">{!! $query->total()!!} Records</span></center>

                <div align="" style="margin-left: 12px">
                    <style>
                        td{
                            font-size: 13px
                        }

                    </style>
                    <div class="md-card">

                        <div   class="uk-grid" data-uk-grid-margin>
                            
                             @foreach($query as $index=> $student) 
                           
                                <div id="print">

                                    <table  border="0" cellspacing="0" align="center">
                                        <tr></tr>
                                        <tr>
                                            <th height="341" valign="top" class="bod" scope="row"><table width="100%" border="0">
                                            <tr>
                                                <th align="center" valign="middle" scope="row"><table width="882" height="113" border="0">
                                                <tr>
                                                    <th align="center" valign="middle" scope="row"><table style="" width="882" height="113" border="0" align="left">
                                                    
                                                </table>
                                                <table>
                                                    <tr>
                                                        <td align="center"><div class="" style="margin-left:-490px">DEPARTMENT: {{ strtoupper($help->getDepartmentName($help->getProgramDepartment($student->PROGRAMMECODE))) }}</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center"><div class="" style="margin-left:-470px;text-align:">SCHOOL: {{ strtoupper($help->getSchoolName($help->getSchoolCode($help->getProgramDepartment($student->PROGRAMMECODE)))) }}</div></td>
                                                    </tr>
                                                    <tr>
                                                        <td  ><div style="margin-left:11px"><hr></hr></div></td>
                                                    </tr>

                                                </table>
                                                </tr>


                                            </table>
                                            <hr>
                                            <div align="center">

                                                <table border='0' class="uk-table" align="center"  width='900px'>
                                                    <tr>
                                                        <td width="" style="width:69%">
                                                            <div class="table-responsive" style="margin-left:15.5%">
                                                                <table border='0' class="uk-table uk-table-nowrap uk-table-no-border" width=""  style="margin-left:-1%" >
                                                                    <tbody><tr>
                                                                            <td style="">NAME</td> <td style="padding-right: 36px;">{{strtoupper($student->NAME)}}</td>
                                                                        </tr>

                                                                        <tr>

                                                                            <td style="padding-right: px;">INDEX NO</td> <td style="padding-right: 93px;">{{$student->INDEXNO}}</td>



                                                                        </tr>

                                                                        <tr>
                                                                            <td>LEVEL</td> <td style="padding-right: 203px;">{{$student->LEVEL}}</td>
                                                                        </tr>


                                                                        <tr>
                                                                            <td>PROGRAMME</td> <td style="padding-right: 177px;"> {{strtoupper($student->program->PROGRAMME)}}</td>
                                                                        </tr>



                                                                    </tbody></table> </div>
                                                        </td>

                                                        <td width="237" align="left" valign="top"><table class="uk-table" width="237" border="0"  style="margin-left:-13%;">
                                                                <tr>
                                                                    <td width="202" border='0' ><div style="float:right;"><img style="width:130px;height:auto"  class=" " style=" margin-left: 26%" {!! $help->picture('{{url("public/albums/students/$student->INDEXNO")}}',210) !!} src='{{url("public/albums/students/$student->INDEXNO".'.jpg')}}' alt=" Picture of Student Here" /></div>

                                                                </tr>
                                                            </table></td>
                                                    </tr>
                                                    </tr>
                                                </table> <!-- end basic infos -->


                                                <table class="uk-table uk-table-nowrap uk-table-hover" id=""> 
                                                    <thead>
                                                        <tr  class="uk-text-upper">
                                                            <th>NO</th>
                                                            <th>DATE</th>


                                                            <th>DESCRIPTION</th>

                                                            <th>DEBIT</th>
                                                            <th>CREDIT</th>
                                                            <th>BALANCE</th>

                                                            <th>TYPE</th> 


                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr class="uk-table-middle">
                                                            <td>#</td>
                                                            <td>{{$years}}/{{$sems}}</td>
                                                            <td>Balance b/d to {{$years}}/{{$sems}} academic year </td>
                                                            @if($student->BILL_OWING>0)

                                                            <td>{{$student->BILL_OWING}}</td>
                                                            @else
                                                            <td>0</td>
                                                            @endif
                                                            @if($student->BILL_OWING<=0)

                                                            <td>{{$student->BILL_OWING}}</td>
                                                            @else
                                                            <td>0</td>
                                                            @endif
                                                            <td>{{$student->BILL_OWING}}</td>
                                                            <td>
                                                                @if($student->BILL_OWING<=0)
                                                                Credit
                                                                @else
                                                                Debit
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr class="uk-table-middle">
                                                            <td>#</td>
                                                            <td>{{$years}}/{{$sems}}</td>
                                                            <td> {{$years}}/{{$sems}} academic year fees </td>
                                                            @if($student->BILLS>0)

                                                            <td>{{$student->BILLS}}</td>
                                                            @else
                                                            <td>0</td>
                                                            @endif
                                                            @if($student->BILLS<=0)

                                                            <td>{{$student->BILLS}}</td>
                                                            @else
                                                            <td>0</td>
                                                            @endif
                                                            <td>{{$student->BILLS}}</td>
                                                            <td>
                                                                @if($student->BILLS<=0)
                                                                Credit
                                                                @else
                                                                Debit
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <?php $balance = $student->BILL_OWING + $student->BILLS; ?>
                                                        @foreach($data as $index=> $row) 


                                                        <tr class="uk-table-middle">
                                                            <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>

                                                            <td> {{ @date('d/m/Y',strtotime($row->TRANSDATE))	 }}</td>

                                                            <td> {{ @$row->PAYMENTTYPE  }} of {{$row->FEE_TYPE}} with Receipt No. {{@$row->RECEIPTNO}}</td>
                                                            <td></td>
                                                            <td> {{ $help->formatMoney(@$row->AMOUNT) }}</td>
                                                            <td><?php $balance-=$row->AMOUNT ?> {{$balance}}</td>
                                                            <td>Credit</td>


                                                        </tr>
                                                        @endforeach

                                                    </tbody>

                                                </table>





                                            </div>

                                            </div>
                                            </tr>
                                        </table></th>
                                        </tr>
                                        <tr></tr>
                                    </table>

                                    <div>
                                    </div>
                                </div>
                             @endforeach

                        </div>

                    </div>
                </div>
                @endif

            </div>
        </div></div>


    @endsection
    @section('js')
   <script type="text/javascript">

    

</script>
<script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
<script>
     $(document).ready(function () {
         $('select').select2({width: "resolve"});


     });


</script>
    @endsection