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

                                {!! Form::select('program',  $program , old("program",""), ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select programme']);!!}
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

                                {!!   Form::select('gender', [ ''=>'All Students', 'Male' => 'Males','Female' => 'Females' ], null, ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select gender']);!!}

                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!   Form::select('residence', [ ''=>'All Students', 'DAY' => 'Day Students','BOARDING' => 'Boarding Students' ], null, ['class' => 'md-input parent','id'=>"parent",'placeholder' => 'select residential status']);!!}

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

                            <th>BILL NO</th>

                            <th data-priority="critical">BILL CODE</th>
                            <th>BILL DESCRIPTION</th>
                            <th>BILL TYPE</th>
                            <th>DEBIT AMOUNT</th>

                            <th>GENDER</th>
                            <th>RESIDENCE STATUS</th>
                            <th>CLASS</th>
                            <th>PROGRAMME</th>
                            <th>YEAR</th>
                            <th>TERM</th>
                            <th>CREATED BY</th>

                            <th>ACTION</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $index=> $row)




                            <tr align="">
                                <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                <td> {{ @$row->Bill_No }}</td>
                                <td> {{ @$row->Item_Code }}</td>
                                <td> {{ @$row->Item_Description }}</td>
                                <td>{!! @ $row->Bill_Type !!}</td>
                                <td> {{ @$row->Debit_Amount}}</td>

                                <td> {{ @$row->Gender }}</td>
                                <td> {{ @$row->Residence }}</td>
                                <td> {{ @$row->Class }}</td>
                                <td> {{ @$row->Academic_Programme }}</td>

                                <td> {{ @$row->Academic_Year }}</td>
                                <td> {{ @$row->Academic_Term }}</td>

                                <td> {{ ucwords(@$row->Created_By )}}</td>

                                <td>

                                    {!!Form::open(['action' =>['FeeController@deleteBill', 'id'=>$row->id], 'method' => 'DELETE','name'=>'myform' ,'style' => 'display: inline;'])  !!}

                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this bill item??')" class="md-btn  md-btn-danger md-btn-small   md-btn-wave-light waves-effect waves-button waves-light" ><i  class="sidebar-menu-icon material-icons md-18">delete</i></button>
                                    <input type='hidden'   value='{{$row->id}}'/>
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