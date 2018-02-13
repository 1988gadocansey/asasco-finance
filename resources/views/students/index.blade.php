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
        @if(Session::has('error'))
            <div style="text-align: center" class="uk-alert uk-alert-danger" data-uk-alert="">
                {!! Session::get('error') !!}
            </div>
        @endif

        @if (count($errors) > 0)


            <div class="uk-alert uk-alert-danger  uk-alert-close" style="background-color: red;color: white"
                 data-uk-alert="">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!!$error  !!} </li>
                    @endforeach
                </ul>
            </div>

        @endif


    </div>
    <div class="uk-modal" id="new_task">
        <div class="uk-modal-dialog">
            <div class="uk-modal-header">
                <h4 class="uk-modal-title">Send sms here</h4>
            </div>
            <center><p>Insert the following placeholders into the message [NAME] [FIRSTNAME] [SURNAME] [INDEXNO] [BILLS]
                    [BILL_OWING] [PROGRAMME] </p></center>
            <form action="{!! url('/sms')!!}" method="POST">
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">


                <textarea cols="30" rows="4" name="message" class="md-input" required=""></textarea>


                <div class="uk-modal-footer uk-text-right">
                    <button type="submit" class="md-btn md-btn-flat md-btn-flat-primary md-btn-wave"
                            id="snippet_new_save"><i class="material-icons">smartphone</i>Send
                    </button>
                    <button type="button" class="md-btn md-btn-flat uk-modal-close md-btn-wave">Close</button>
                </div>
            </form>
        </div>
    </div>
    <h3 class="heading_b uk-margin-bottom">Students List</h3>
    <div style="" class="">
        <!--    <div class="uk-margin-bottom" style="margin-left:910px" >-->
        <div class="uk-margin-bottom" style="">
            <a href="#new_task" data-uk-modal="{ center:true }"> <i title="click to send sms to students"
                                                                    class="material-icons md-36 uk-text-success">phonelink_ring
                    message</i></a>

            <a href="#" class="md-btn md-btn-small md-btn-success uk-margin-right" id="printTable">Print Table</a>
            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                <button class="md-btn md-btn-small md-btn-success"> columns <i class="uk-icon-caret-down"></i></button>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown" id="columnSelector"></ul>
                </div>
            </div>


            <div style="margin-top: -5px" class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                <button class="md-btn md-btn-small md-btn-success uk-margin-small-top">Export <i
                            class="uk-icon-caret-down"></i></button>
                <div class="uk-dropdown">
                    <ul class="uk-nav uk-nav-dropdown">

                        <li class="uk-nav-divider"></li>
                        <li><a href="#" onClick="$('#ts_pager_filter').tableExport({type:'excel',escape:'false'});"><img
                                        src='{!! url("public/assets/icons/xls.png")!!}' width="24"/> Excel</a></li>
                        <li class="uk-nav-divider"></li>

                    </ul>
                </div>
            </div>


            <i title="click to print" onclick="javascript:printDiv('print')"
               class="material-icons md-36 uk-text-success">print</i>


        </div>
    </div>
    <!-- filters here -->
    @inject('fee', 'App\Http\Controllers\FeeController')
    @inject('sys', 'App\Http\Controllers\SystemController')
    {{--<div class="uk-width-xLarge-1-1">
        <div class="md-card">
            <div class="md-card-content">

                <form action=" "  method="get" accept-charset="utf-8" novalidate id="group">
                    {!!  csrf_field()  !!}
                    <div class="uk-grid" data-uk-grid-margin="">

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('program',
                                (['' => 'All programs'] + $programme ),
                                old("program",""),
                                ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select program'] )  !!}
                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('class',
                                (['' => 'All Classes'] + $class ),
                                old("class",""),
                                ['class' => 'md-input parent','id'=>"parent",'placeholder'=>'select class'] )  !!}

                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!  Form::select('gender', array('Male'=>'Male','Female' => 'Female'), null, ['placeholder' => 'select gender','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}

                            </div>
                        </div>


                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('department',
                                (['' => 'departments'] +$department  ),
                                old("department",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!  Form::select('status', array('Admitted'=>'Admitted','In School'=>'In school','Alumni' => 'Completed','Deferred' => 'Deferred','Dead' => 'Dead','Rasticated' => 'Rasticated'), null, ['placeholder' => 'select status of student','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}

                            </div>
                        </div>
                        @if( @\Auth::user()->department=='top')
                       <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('house',
                                (['' => 'by houses'] +$house  ),
                                old("house",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('nationality',
                                (['' => 'Nationality'] +$nationality  ),
                                old("nationality",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('region',
                                (['' => 'Search by Regions'] +$region  ),
                                old("region",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>
                        @if(@\Auth::user()->role!='FO')
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('religion',
                                (['' => 'Search by Religions'] +$religion  ),
                                old("religion",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>
                        @endif
                        @endif
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                {!! Form::select('group',
                                (['' => 'by graduating group'] +$year  ),
                                old("group",""),
                                ['class' => 'md-input parent','id'=>"parent"] )  !!}
                            </div>
                        </div>
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                           {!!  Form::select('type', array('Boarding'=>'Boarders','Day'=>'Day' ), null, ['placeholder' => 'select type of student','id'=>'parent','class'=>'md-input parent'],old("level","")); !!}


                            </div>
                        </div>
                         @if( @\Auth::user()->department=='top' ||@\Auth::user()->role=='FO')
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!  Form::select('fee', array('1'=>'Fee Owing','0' => 'Paid all'), null, ['placeholder' => 'Select fee status','id'=>'parent','class'=>'md-input parent'],old("action","")); !!}

                            </div>
                        </div>
                         @endif
                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">

                                {!!  Form::select('by', array('indexNo'=>'Search by Index Number','name'=>'Search by Name','required'=>''), null, ['placeholder' => 'select search type','class'=>'md-input'], old("","")); !!}
                            </div>
                        </div>

                        <div class="uk-width-medium-1-5">
                            <div class="uk-margin-small-top">
                                <input type="text" style=" " required=""  name="search"  class="md-input" placeholder="search student by index number or name">
                            </div>
                        </div>




                    </div>
                    <center>   <div class="uk-width-medium-1-10" style=" ">
                            <div class="uk-margin-small-top">

                                <button class="md-btn  md-btn-small md-btn-success uk-margin-small-top" type="submit"><i class="material-icons">search</i></button>
                            </div>
                        </div></center>
                </form>
            </div>
        </div>
    </div>--}}

    <!-- end filters -->
    <div class="uk-width-xLarge-1-1">
        <div class="md-card">
            <div class="md-card-content">


                <div class="uk-overflow-container" id='print'>
                    <center><span class="uk-text-success uk-text-bold">{!! $data->total()!!} Records</span></center>
                    <table class="uk-table uk-table-hover uk-table-align-vertical uk-table-nowrap tablesorter tablesorter-altair"
                           id="ts_pager_filter">
                        <thead>
                        <tr>
                            <th class="filter-false remove sorter-false">NO</th>

                            <th data-priority="6">NAME</th>
                            <th>PHOTO</th>
                            <th>INDEX N<u>O</u></th>

                            <th>PROGRAM</th>

                            <th>CLASS</th>


                            <th>GENDER</th>


                            <th>PARENT PHONE</th>


                            <th>TERM BILLS</th>
                            <th>PAID</th>
                            <th>OWINGS</th>


                            <th>YEAR GROUP</th>


                            <th>STATUS</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($data as $index=> $row)

                            <tr align="">
                                <td> {{ $data->perPage()*($data->currentPage()-1)+($index+1) }} </td>
                                <td> {{ strtoupper(@$row->name) }}</td>
                                <td><img class=" " style="width:65px;height:70px"
                                         src='{{url("public/albums/students/$row->indexNo.JPG")}} ' alt="photo"/></td>
                                <td> {{ @$row->indexNo }}</td>

                                <td>{!! strtoupper(@$row->program->name) !!}</td>
                                <td> {{ @$row->currentClass }}</td>
                                <td> {{ strtoupper(@$row->gender) }}</td>

                                <td> {{ @$row->parentPhone }}</td>


                                <td>GHC {{ @$row->termBill }}</td>
                                <td>0.00</td>
                                <td>GHC {{ @$row->totalOwing }}</td>

                                <td> {{ strtoupper(@$row->yearGroup) }}</td>
                                <td> {{ strtoupper(@$row->status) }}</td>



                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>
            </div>


        </div>
    </div></div>
@endsection
@section('js')
    <script type="text/javascript">

        $(document).ready(function () {

            $(".parent").on('change', function (e) {

                $("#group").submit();
            });
        });</script>
    <script src="{!! url('public/assets/js/select2.full.min.js') !!}"></script>
    <script>
        $(document).ready(function () {
            $('select').select2({width: "resolve"});
        });</script>

@endsection