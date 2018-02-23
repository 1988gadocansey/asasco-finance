@extends('layouts.app')


@section('style')

@endsection
@section('content')

    <div class="md-card-content">

        @if(Session::has('success'))
            <div style="text-align: center" class="uk-alert uk-alert-success" data-uk-alert="">
                {!! Session::get('success') !!}
            </div>
        @endif


        @if (count($errors) > 0)


            <div class="uk-alert uk-alert-danger  uk-alert-close" style="background-color: red;color: white" data-uk-alert="">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!!$error  !!} </li>
                    @endforeach
                </ul>
            </div>

        @endif


    </div>

    <h5>Students  Ledger</h5>
    <div style="">
        <div class="uk-margin-bottom" style="margin-left:1021px" >
            <!--         <a  href="#new_task" data-uk-modal="{ center:true }"> <i title="click to send sms to students owing"   class="material-icons md-36 uk-text-success"   >phonelink_ring message</i></a>-->

            <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
                </div>
            </div>
        </div>
    </div>
    <!-- filters here -->
    @inject('fee', 'App\Http\Controllers\FeeController')
    @inject('sys', 'App\Http\Controllers\SystemController')
    <div class="uk-width-xLarge-1-1">
        <div class="md-card">
            <div class="md-card-content">

                <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                    {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!! Form::select('program', $program, old("program",""), ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select programme']);!!}
                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!   Form::select('class', [  'SHS 1' => 'SHS1','SHS2' => 'SHS 2','SHS 3' => 'SHS3'], null, ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select class']);!!}

                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!! Form::select('year', $year, old("year",""), ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select academic year']);!!}
                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!   Form::select('term', [  '1' => '1st Term','2' => '2nd Term','3' => '3rd Term'], null, ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select term']);!!}

                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!   Form::select('type', [  'Cash' => 'Cash','Direct-Pay In' => 'Direct-Pay In','Bankers Draft' => 'Bankers Draft'], null, ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select payment method']);!!}

                            </div>
                        </div>


                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                    <input type="text"  style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("from_date") }}" name="from_date" id="invoice_dp" class="md-input" placeholder="Start of Financial Year ">
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-5">

                            <div class="uk-margin-small-top">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                    <input type="text" style="" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="{{ old("to_date") }}" name="to_date"  class="md-input" placeholder="End of Financial Year">
                                </div>
                            </div>
                        </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                <input type="text" style=" " required=""  name="indexno"  class="md-input" placeholder="search student registration ">
                            </div>
                        </div>





                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button>
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


                <div class="uk-overflow-container" id='print'>
                    <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                    <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair" id="ts_pager_filter">
                        <thead>
                        <tr>
                            <th class="filter-false remove sorter-false" data-priority="6">NO</th>

                            <th>TRANSACTION DESCRIPTION</th>
                            <th>PAYMENT NO</th>
                            <th data-priority="critical">NAME</th>
                            <th>PROGRAMME</th>
                            <th>CLASS</th>

                            <th>YEAR</th>
                            <th>TERM</th>
                            <th>BANK</th>
                            <th>AMOUNT</th>
                            <th>PAYMENT METHOD</th>
                            <th>RECEIPT</th>

                            <th>BANK DATE</th>
                            <th>STATUS</th>
                            <th>RECEIVED BY</th>
                            <th>ACTION</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $index=> $row)




                            <tr align="">
                                <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                <td> {{ @$row->transaction_description }}</td>
                                <td> {{ @$row->Registration_No }}</td>
                                <td> {{ @$row->studentDetails->First_Name.' '.$row->studentDetails->Surname }}</td>
                                <td>{!! @ $row->Academic_Programme !!}</td>
                                <td> {{ @$row->studentDetails->Currently_In_Class }}</td>

                                <td> {{ @$row->Academic_Year }}</td>
                                <td> {{ @$row->Academic_Term }}</td>
                                <td> {{ @$row->bankdetails->bname }}</td>
                                <td> {{ @$row->Credit_Amount }}</td>

                                <td> {{ @$row->Payment_Method }}</td>
                                <td> {{ @$row->Receipt_No }}</td>

                                <td> {{ @$row->bank_date }}</td>
                                <td> {{ @$row->Item_Status }}</td>
                                <td> {{ ucwords(@$row->Received_By) }}</td>

                                <td>
                                    <a onclick="return MM_openBrWindow('{{url("printreceipt/" . trim(@$row->Receipt_No))}}', 'mark', 'width=800,height=500')" ><i title='Click to print receipt of this payment .. please allow popups on browser' class="md-icon material-icons">book</i></a>

                                    {!!Form::open(['action' =>['FeeController@destroyPayment', 'id'=>$row->Serial_No], 'method' => 'DELETE','name'=>'myform' ,'style' => 'display: inline;'])  !!}

                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this payment??')" class="md-btn  md-btn-danger md-btn-small   md-btn-wave-light waves-effect waves-button waves-light" ><i  class="sidebar-menu-icon material-icons md-18">delete</i></button>
                                    <input type='hidden'   value='{{$row->ID}}'/>
                                    {!! Form::close() !!}


                                </td>

                            </tr>
                        @endforeach
                        </tbody>

                    </table>
                    <div style="margin-left: 1089px" class="uk-text-bold uk-text-success"><td colspan=" ">TOTAL PAID GHC<u> {{$total}} </u></td></div>
                    {!! $data->links() !!}
                </div>
            </div>


        </div>
    </div></div>
@endsection
@section('js')
    <script type="text/javascript">

        $(document).ready(function(){

            $(".parent").on('change',function(e){

                $("#group").submit();

            });
        });

    </script>
    <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
    <script>
        $(document).ready(function(){
            $('select').select2({ width: "resolve" });


        });


    </script>
    <!--  notifications functions -->
    <script src="public/assets/js/components_notifications.min.js"></script>
@endsection