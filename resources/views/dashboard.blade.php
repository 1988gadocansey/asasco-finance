@extends('layouts.app')


@section('style')
    <!-- additional styles for plugins -->
    <!-- weather icons -->
    <link rel="stylesheet" href="public/assets/plugins/weather-icons/css/weather-icons.min.css" media="all">
    <!-- metrics graphics (charts) -->
    <link rel="stylesheet" href="public/assets/plugins/metrics-graphics/dist/metricsgraphics.css">
    <!-- chartist -->
    <link rel="stylesheet" href="public/assets/plugins/chartist/dist/chartist.min.css">

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

    @inject('sys', 'App\Http\Controllers\SystemController')


    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable ">
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class=""><i class="sidebar-menu-icon material-icons md-36">access_time</i></span></div>
                    <span class="uk-text-bold uk-text-small">Last Visit</span>
                    <h5 class="uk-margin-remove"><span class="uk-text-small uk-text-success"> {{$lastVisit}}</span></h5>
                </div>
            </div>
        </div>

        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class=""><i class="sidebar-menu-icon material-icons md-36">event_note</i></span></div>
                    <span class="uk-text-muted uk-text-small">Academic Calender</span>
                    <h5 class="uk-margin-remove"><span class="uk-text-small uk-text-success "> Semester {{$sem}} : Year {{$year}}</span></h5>
                </div>
            </div>
        </div>


        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class=""><i class="sidebar-menu-icon material-icons md-36">event_note</i></span></div>
                    <span class="uk-text-muted uk-text-small">Total Male Students</span>
                    <h5 class="uk-margin-remove"><span class="uk-text-small uk-text-success "> Males = {{$male}}  </span></h5>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class=""><i class="sidebar-menu-icon material-icons md-36">event_note</i></span></div>
                    <span class="uk-text-muted uk-text-small">Total Female  Students</span>
                    <h5 class="uk-margin-remove"><span class="uk-text-small uk-text-success "> Females = {{$female}}  </span></h5>
                </div>
            </div>
        </div>


    </div>

    <div class="uk-grid uk-grid-width-small-1-2 uk-grid-width-large-1-3 uk-grid-width-xlarge-1-5 uk-text-center uk-sortable sortable-handler" id="dashboard_sortable_cards" data-uk-sortable data-uk-grid-margin>


            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <a  href='{{url("/pay/fees")}}'>  <img src="{{url('public/assets/img/dashboard/results.png')}}"/></a>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3 class="uk-text-center uk-text-upper">
                                PAY FEES
                            </h3>
                        </div>
                        Print Official result for students after they have paid at the Accounts Office
                    </div>
                </div>
            </div>
             <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <a  href='{{url("/upload/marks")}}'>  <img src="{{url('public/assets/img/dashboard/results.png')}}"/></a>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3 class="uk-text-center uk-text-upper">
                                UPLOAD BILLS
                            </h3>
                        </div>
                        <p>Upload term bills here</p>
                        <button class="md-btn md-btn-primary">More</button>
                    </div>
                </div>
            </div>


            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <a  href='{{url("class/list")}}'>  <img src="{{url('public/assets/img/dashboard/classlist.png')}}"/></a>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3 class="uk-text-center uk-text-upper">
                                VIEW PAYMENTS
                            </h3>
                        </div>
                        View all students payments
                    </div>
                </div>
            </div>

                <div>
                    <div class="md-card md-card-hover md-card-overlay">
                        <div class="md-card-content">
                            <a  href='{{url("/workers")}}'>  <img src="{{url('public/assets/img/dashboard/classgroup.png')}}"/></a>
                        </div>
                        <div class="md-card-overlay-content">
                            <div class="uk-clearfix md-card-overlay-header">
                                <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                                <h3 class="uk-text-center uk-text-upper">
                                    STAFF <small>(Total {{$worker}})</small>
                                </h3>
                            </div>
                            View your staffs
                        </div>
                    </div>
                </div>

            <div>
                <div class="md-card md-card-hover md-card-overlay">
                    <div class="md-card-content">
                        <a  href='{{url("/students")}}'>  <img src="{{url('public/assets/img/dashboard/classgroup.png')}}"/></a>
                    </div>
                    <div class="md-card-overlay-content">
                        <div class="uk-clearfix md-card-overlay-header">
                            <i class="md-icon material-icons md-card-overlay-toggler">&#xE5D4;</i>
                            <h3 class="uk-text-center uk-text-upper">
                                STUDENTS <small>(Total {{$total}})</small>
                            </h3>
                        </div>
                        View your students
                    </div>
                </div>
            </div>





    </div>





    <!-- tasks -->
    <!--<div class="uk-grid" data-uk-grid-margin data-uk-grid-match="{target:'.md-card-content'}">
        <div class="uk-width-medium-1-2">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-overflow-container">
                      loading data from student portal ....
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="md-card">
                <div class="md-card-content">
                    <h3 class="heading_a uk-margin-bottom">Statistics</h3>
                    <div id="ct-chart" class="chartist"></div>
                </div>
            </div>
        </div>
    </div>-->









@endsection
@section('js')
    <!-- d3 -->
    <script src="public/assets/plugins/d3/d3.min.js"></script>
    <!-- metrics graphics (charts) -->
    <script src="public/assets/plugins/metrics-graphics/dist/metricsgraphics.min.js"></script>
    <!-- chartist (charts) -->
    <script src="public/assets/plugins/chartist/dist/chartist.min.js"></script>
    <!-- maplace (google maps) -->
    <script src="public/assets/plugins/maplace-js/dist/maplace.min.js"></script>
    <!-- peity (small charts) -->
    <script src="public/assets/plugins/peity/jquery.peity.min.js"></script>
    <!-- easy-pie-chart (circular statistics) -->
    <script src="public/assets/plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <!-- countUp -->
    <script src="public/assets/plugins/countUp.js/dist/countUp.min.js"></script>
    <!-- handlebars.js -->
    <script src="public/assets/plugins/handlebars/handlebars.min.js"></script>
    <script src="public/assets/js/custom/handlebars_helpers.min.js"></script>
    <!-- CLNDR -->
    <script src="public/assets/plugins/clndr/clndr.min.js"></script>
    <!-- fitvids -->
    <script src="public/assets/plugins/fitvids/jquery.fitvids.js"></script>

    <!--  dashbord functions -->
    <script src="public/assets/js/pages/dashboard.min.js"></script>

@endsection