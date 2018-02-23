<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta description="Student portal for takoradi tech uni" author="Gad Ocansey +233243348522"/>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <link rel="icon" type="image/png" href="public/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="public/assets/img/favicon-32x32.png" sizes="32x32">

    <title>Fees Collection |  Asamankese Senior High School</title>


    <!-- uikit -->
    <link rel="stylesheet" href="{!! url('public/assets/plugins/uikit/css/uikit.almost-flat.min.css') !!} " media="all">


    <link rel="stylesheet" href="{!! url('public/assets/css/main.min.css') !!}" media="all">

    <link rel="stylesheet" href="{!! url('public/assets/css/themes/themes_combined.min.css') !!}" media="all">

    <link rel="stylesheet" href="{!! url('plugins/sweet-alert/sweet-alert.min.css') !!}" media="all">
    <!-- font awesome -->
    <link rel="stylesheet" href="{!! url('public/assets/css/select2.min.css') !!}" media="all">
    <link rel="stylesheet" href="{!! url('public/assets/css/dropify.css') !!}" media="all">
    <link rel="stylesheet" href="{!! url( 'datatables/css/jquery.dataTables.min.css')  !!}" >
    <link rel="stylesheet" href="{!! url( 'datatables/css/dataTables.uikit.min.css')  !!}" >
 <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> 

   <!-- style switcher -->
    <link rel="stylesheet" href="{!! url('public/assets/css/style_switcher.min.css')  !!}" media="all">
  
    @yield('style')

</head>
<body class="top_menu">
    <!-- main header -->
    <header id="header_main">
        <div class="header_main_content">
            <nav class="uk-navbar">
                <div class="main_logo_top">
                    <a href="/dashboard"><img src="{{url('public/assets/img/logo.png')}}" alt=""  style="width: 63px"/></a>

                </div>

                <!-- secondary sidebar switch -->
                <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                    <span class="sSwitchIcon"></span>
                </a>

                <div class="uk-navbar-flip">
                    <ul class="uk-navbar-nav user_actions">
                        <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
                          <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                            <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span class="uk-badge">16</span></a>
                            <div class="uk-dropdown uk-dropdown-xlarge">
                                <div class="md-card-content">
                                    <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                        <li class="uk-width-1-2 uk-active"><a href="#" class="js-uk-prevent uk-text-small">Messages (12)</a></li>
                                        <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Alerts (4)</a></li>
                                    </ul>
                                    <ul id="header_alerts" class="uk-switcher uk-margin">
                                        <li>
                                            <ul class="md-list md-list-addon">
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <span class="md-user-letters md-bg-cyan">ao</span>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="pages_mailbox.html">Consequatur ut repudiandae.</a></span>
                                                        <span class="uk-text-small uk-text-muted">Et sunt qui quod aut laborum et nisi.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <img class="md-user-image md-list-addon-avatar" src="public/assets/img/avatars/avatar_07_tn.png" alt=""/>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="pages_mailbox.html">Sunt sequi.</a></span>
                                                        <span class="uk-text-small uk-text-muted">Beatae quibusdam sed possimus pariatur optio repellendus.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <span class="md-user-letters md-bg-light-green">qi</span>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="pages_mailbox.html">Et voluptatum ut.</a></span>
                                                        <span class="uk-text-small uk-text-muted">Est et nostrum dignissimos suscipit nihil animi voluptatem quam.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <img class="md-user-image md-list-addon-avatar" src="public/assets/img/avatars/avatar_02_tn.png" alt=""/>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="pages_mailbox.html">Similique iure et.</a></span>
                                                        <span class="uk-text-small uk-text-muted">Laborum et alias veritatis accusamus sit consequatur quod.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <img class="md-user-image md-list-addon-avatar" src="public/assets/img/avatars/avatar_09_tn.png" alt=""/>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading"><a href="pages_mailbox.html">Repellendus consequuntur.</a></span>
                                                        <span class="uk-text-small uk-text-muted">Nesciunt et id eum quas est soluta aut et.</span>
                                                    </div>
                                                </li>
                                            </ul>
                                            <div class="uk-text-center uk-margin-top uk-margin-small-bottom">
                                                <a href="page_mailbox.html" class="md-btn md-btn-flat md-btn-flat-primary js-uk-prevent">Show All</a>
                                            </div>
                                        </li>
                                        <li>
                                            <ul class="md-list md-list-addon">
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons uk-text-warning">&#xE8B2;</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading">Repudiandae accusantium.</span>
                                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Et fugit ipsum quia non ducimus quo.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons uk-text-success">&#xE88F;</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading">Eos earum qui.</span>
                                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Accusamus nisi vitae dolorem et vel repudiandae ratione tenetur.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading">Rerum accusantium.</span>
                                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Ut voluptatem eos sapiente hic qui molestiae.</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="md-list-addon-element">
                                                        <i class="md-list-addon-icon material-icons uk-text-primary">&#xE8FD;</i>
                                                    </div>
                                                    <div class="md-list-content">
                                                        <span class="md-list-heading">Id molestias.</span>
                                                        <span class="uk-text-small uk-text-muted uk-text-truncate">Excepturi delectus rem doloribus quia fugiat.</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                             <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                            
                            <a href="#" class="user_action_image">
                                 <span class="" style="color:white"  >Hi {{@Auth::user()->name}}</span>
                 
                                
                                  <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav js-uk-prevent">


                                    <li>
                                        <a href="{{ url('/logout') }}"
                                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="header_main_search_form">
            <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>

        </div>
    </header><!-- main header end -->
    <div id="top_bar">
        <div class="md-top-bar">
            <ul id="menu_top" class="uk-clearfix">
                <li class="uk-hidden-small"><a href='{!! url("/dashboard") !!}'><i class="material-icons">&#xE88A;</i><span>Home</span></a></li>
                {{--<li class="uk-hidden-small"><a href='{!! url("/biodataUpdate") !!}'><i title='my profile' class="material-icons">account_circle</i><span>My Profile</span></a></li>--}}
                {{----}}
                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="sidebar-menu-icon material-icons md-18">book</i><span>Students</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href='{!! url("/students") !!}'>View Students</a></li>

                         </ul>
                    </div>
                </li>

                 <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="sidebar-menu-icon material-icons md-18">work</i><span>Finances</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href='{!! url("/pay") !!}'>Pay Fees</a></li>
                           {{-- <li><a href='{!! url("/student/owing") !!}'>View Students owing</a></li>
                            <li><a href='{!! url("/student/paid") !!}'>View Students Paid</a></li>--}}
                            <li><a href='{!! url("/transactions/ledger") !!}'>View daily payments</a></li>

                         </ul>
                    </div>
                </li>

                <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="sidebar-menu-icon material-icons md-18">home</i><span>Uploads</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li><a href='{!! url("/upload/bills") !!}'>Upload bills</a></li>
                            <li><a href='{!! url("/upload/payments") !!}'>Upload Statement from Bank</a></li>
                        </ul>
                    </div>
                </li>

                 <li data-uk-dropdown class="uk-hidden-small">
                    <a href="#"><i class="sidebar-menu-icon material-icons md-18">lock</i><span>My Account</span></a>
                    <div class="uk-dropdown uk-dropdown-scrollable">
                        <ul class="uk-nav uk-nav-dropdown">
                            <li>
                                <a href="{{ url('/logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
            
                         </ul>
                    </div>
                </li>
                   <li data-uk-dropdown="justify:'#top_bar'" class="uk-visible-small">
                <a href="#"><i class="material-icons">&#xE5D2;</i><span>Menu</span></a>
                <div class="uk-dropdown uk-dropdown-width-2">
                    <div class="uk-grid uk-dropdown-grid" data-uk-grid-margin>
                        <div class="uk-width-1-2">
                            <ul class="uk-nav uk-nav-dropdown ">
                                 <li><a href='{!! url("/dashboard") !!}'>Home</a></li>
                                 <li><a href='{!! url("/biodataUpdate") !!}'>My Profile</a></li>
                                 <li><a href='{!! url("/course_registration") !!}'>Register Course</a></li>
                                 <li><a href='{!! url("registeredCourses") !!}'>View Registered Courses</a></li>
                                   <li><a href='{!! url("/result/transcript/provisonal") !!}'>View Semester Results</a></li>
                            <li><a href='#'onclick="return alert('coming soon')">Apply for official transcript</a></li>
                             <li><a href='{!! url("/statement_account") !!}'>Print Statement of accounts</a></li>
                             <li><a href='#' onclick="return alert('coming soon')">Teaching Timetable</a></li>
                            <li><a href='#'onclick="return alert('coming soon')">Examination Timetable</a></li>
            
                            </ul>
                        </div>
                    </div>
                </div>
                   </li>
            </ul>
        </div>
    </div>

    <div id="page_content">
        <div id="page_content_inner">




            @yield('content')


        </div>
    </div><!-- common functions -->
     <br/>
            <div class="footer uk-text-small"><center><?php date("Y");?> All Rights Reserved | Asamankese SHS - Powered by Gad Ocansey +233243348522 </center></div>

    <script src="{!! url('public/assets/js/common.min.js') !!}"></script>
    <script src="{!! url('public/assets/js/dropify.min.js') !!}"></script>
    <script src="{!! url('public/assets/js/file_input.min.js') !!}"></script>
    <!-- uikit functions -->
    <script src="{!! url('public/assets/js/uikit_custom.min.js') !!}"></script>

    <!-- altair common functions/helpers -->
    <script src="{!! url('public/assets/js/altair_admin_common.min.js') !!}"></script>

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

    <script src="{!! url('public/datatables/js/dataTables.uikit.min.js') !!}"></script> 
    <script src="{!! url('public/datatables/js/plugins_datatables.min.js') !!}"></script>
    <script src="{!! url('public/datatables/js/datatables_uikit.min.js') !!}"></script>

     <script>
        $(function() {
            if(isHighDensity) {
                // enable hires images
                altair_helpers.retina_images();
            }
            if(Modernizr.touch) {
                // fastClick (touch devices)
                FastClick.attach(document.body);
            }
        });
        $window.load(function() {
            // ie fixes
            altair_helpers.ie_fix();
        });
    </script>
     <div id="style_switcher">
        <div id="style_switcher_toggle"><i class="material-icons">&#xE8B8;</i></div>
        <div class="uk-margin-medium-bottom">
            <h4 class="heading_c uk-margin-bottom">Colors</h4>
            <ul class="switcher_app_themes" id="theme_switcher">
                <li class="app_style_default active_theme" data-app-theme="">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_a" data-app-theme="app_theme_a">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_b" data-app-theme="app_theme_b">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_c" data-app-theme="app_theme_c">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_d" data-app-theme="app_theme_d">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_e" data-app-theme="app_theme_e">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_f" data-app-theme="app_theme_f">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_g" data-app-theme="app_theme_g">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_h" data-app-theme="app_theme_h">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
                <li class="switcher_theme_i" data-app-theme="app_theme_i">
                    <span class="app_color_main"></span>
                    <span class="app_color_accent"></span>
                </li>
            </ul>
        </div>
        <div class="uk-visible-large uk-margin-medium-bottom">
            <h4 class="heading_c">Sidebar</h4>
            <p>
                <input type="checkbox" name="style_sidebar_mini" id="style_sidebar_mini" data-md-icheck />
                <label for="style_sidebar_mini" class="inline-label">Mini Sidebar</label>
            </p>
        </div>
        <div class="uk-visible-large uk-margin-medium-bottom">
            <h4 class="heading_c">Layout</h4>
            <p>
                <input type="checkbox" name="style_layout_boxed" id="style_layout_boxed" data-md-icheck />
                <label for="style_layout_boxed" class="inline-label">Boxed layout</label>
            </p>
        </div>
        <div class="uk-visible-large">
            <h4 class="heading_c">Main menu accordion</h4>
            <p>
                <input type="checkbox" name="accordion_mode_main_menu" id="accordion_mode_main_menu" data-md-icheck />
                <label for="accordion_mode_main_menu" class="inline-label">Accordion mode</label>
            </p>
        </div>
    </div>

    <script>
        $(function() {
            var $switcher = $('#style_switcher'),
                $switcher_toggle = $('#style_switcher_toggle'),
                $theme_switcher = $('#theme_switcher'),
                $mini_sidebar_toggle = $('#style_sidebar_mini'),
                $boxed_layout_toggle = $('#style_layout_boxed'),
                $accordion_mode_toggle = $('#accordion_mode_main_menu'),
                $body = $('body');


            $switcher_toggle.click(function(e) {
                e.preventDefault();
                $switcher.toggleClass('switcher_active');
            });

            $theme_switcher.children('li').click(function(e) {
                e.preventDefault();
                var $this = $(this),
                    this_theme = $this.attr('data-app-theme');

                $theme_switcher.children('li').removeClass('active_theme');
                $(this).addClass('active_theme');
                $body
                    .removeClass('app_theme_a app_theme_b app_theme_c app_theme_d app_theme_e app_theme_f app_theme_g app_theme_h app_theme_i')
                    .addClass(this_theme);

                if(this_theme == '') {
                    localStorage.removeItem('altair_theme');
                } else {
                    localStorage.setItem("altair_theme", this_theme);
                }

            });

            // hide style switcher
            $document.on('click keyup', function(e) {
                if( $switcher.hasClass('switcher_active') ) {
                    if (
                        ( !$(e.target).closest($switcher).length )
                        || ( e.keyCode == 27 )
                    ) {
                        $switcher.removeClass('switcher_active');
                    }
                }
            });

            // get theme from local storage
            if(localStorage.getItem("altair_theme") !== null) {
                $theme_switcher.children('li[data-app-theme='+localStorage.getItem("altair_theme")+']').click();
            }


        // toggle mini sidebar

            // change input's state to checked if mini sidebar is active
            if((localStorage.getItem("altair_sidebar_mini") !== null && localStorage.getItem("altair_sidebar_mini") == '1') || $body.hasClass('sidebar_mini')) {
                $mini_sidebar_toggle.iCheck('check');
            }

            $mini_sidebar_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_sidebar_mini", '1');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_sidebar_mini');
                    location.reload(true);
                });


        // toggle boxed layout

            if((localStorage.getItem("altair_layout") !== null && localStorage.getItem("altair_layout") == 'boxed') || $body.hasClass('boxed_layout')) {
                $boxed_layout_toggle.iCheck('check');
                $body.addClass('boxed_layout');
                $(window).resize();
            }

            $boxed_layout_toggle
                .on('ifChecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.setItem("altair_layout", 'boxed');
                    location.reload(true);
                })
                .on('ifUnchecked', function(event){
                    $switcher.removeClass('switcher_active');
                    localStorage.removeItem('altair_layout');
                    location.reload(true);
                });

        // main menu accordion mode
            if($sidebar_main.hasClass('accordion_mode')) {
                $accordion_mode_toggle.iCheck('check');
            }

            $accordion_mode_toggle
                .on('ifChecked', function(){
                    $sidebar_main.addClass('accordion_mode');
                })
                .on('ifUnchecked', function(){
                    $sidebar_main.removeClass('accordion_mode');
                });


        });
    </script>

    @yield('js')

    <script type="text/javascript">
                $.ajaxSetup({
                headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
                });    </script>
    <script>
                // load parsley config (altair_admin_common.js)
                altair_forms.parsley_validation_config();
                // load extra validators
                altair_forms.parsley_extra_validators();    </script>

    <script src="{!! url('public/assets/js/jquery.form.js') !!}"></script>
    <script src="{!! url('public/assets/js/jquery.validate.min.js') !!}"></script>

    <script language="javascript" type="text/javascript">
                function printDiv(divID) {
                //Get the HTML of div
                var divElements = document.getElementById(divID).innerHTML;
                        //Get the HTML of whole page
                        var oldPage = document.body.innerHTML;
                        //Reset the page's HTML with div's HTML only
                        document.body.innerHTML =
                        "<html><head><title></title></head><body>" +
                        divElements + "</body>";
                        //Print Page
                        window.print();
                        //Restore orignal HTML
                        document.body.innerHTML = oldPage;
                }
    </script>
    <script>

        function MM_openBrWindow(theURL, winName, features) { //v2.0
        window.open(theURL, winName, features);
        }

        function recalculateTranAmt(){
        var copies = document.getElementById("copies").value;
                var price = parseFloat(document.getElementById("price").value);
                document.getElementById("amount").value = (copies * price);
        }
    </script>
    <script>


        $(document).ready(function(){

        function checkFormElements(){}



        $("#insertPaymentRow").bind('click', function(){

        var numOrgs = $(" table#paymentTable tr[payment_row]").length + 1;
                var newOrg = $("table#paymentTable tr:first ").clone(true);
                $(newOrg).children(' td#insertPaymentCell ').html('<button  type="button" id="removePaymentRow_' + numOrgs + '" class="md-btn md-btn-danger md-btn-small uk-margin-small-top" ><i class="sidebar-menu-icon material-icons">remove</i>  Remove</button>');
                var amountLine = $(newOrg).children('td')[2];
                $(amountLine).children(':last-child').prop('value', '');
                var amountInput = $(amountLine).children(':last-child');
                $(amountInput).prop('id', 'amt_' + numOrgs);
                $(newOrg).attr('id', 'paymentRow_' + numOrgs);
                $(newOrg).insertAfter($("table#paymentTable tr:last"));
                $('#removePaymentRow_' + numOrgs).bind("click", function(){
// $(amountInput).trigger('keyup');
        $('#paymentRow_' + numOrgs).remove();
                var count = 0;
                });
// $('#amt_'+numOrgs).bind('focus',function(){
//   console.log('hello from here');
// });

//});


                $('#paymentTable .pay_type  :selected').parent().each(function(){
        if ($(this).prop('selectedIndex') <= 0){
        //$('#new_payment_individual_form :submit').prop('disabled','disabled');
        //  $('#alertInfo').css('display','block').html("Please select a payment type!");
        }
        });
//console.log($(this).prop('name')+"->"+$('#paymentTable .pay_type  :selected').parent().length);

                });
                $('#save').on('click', function(e) {
        return (function(modal){ modal = UIkit.modal.blockUI("<div class='uk-text-center'>Processing data<br/><img class='uk-thumbnail uk-margin-top' src='{!! url('public/assets/img/spinners/spinner_success.gif')  !!}' /></div>"); setTimeout(function(){ modal.hide() }, 50000) })();
                });
                });    </script>
    <!-- google web fonts -->
    <script>
                 WebFontConfig = {
                google: {
                families: [
                        'Source+Code+Pro:400,700:latin',
                        'Roboto:400,300,500,700,400italic:latin'
                ]
                }
                };
                (function() {
                var wf = document.createElement('script');
                        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                        wf.type = 'text/javascript';
                        wf.async = 'true';
                        var s = document.getElementsByTagName('script')[0];
                        s.parentNode.insertBefore(wf, s);
                })();      </script>
    <script src="{!!url('public/assets/plugins/tablesorter/dist/js/jquery.tablesorter.min.js')!!}"></script>
    <script src="{!!url('public/assets/plugins/tablesorter/dist/js/jquery.tablesorter.widgets.min.js')!!}"></script>
    <script src="{!!url('public/assets/plugins/tablesorter/dist/js/widgets/widget-alignChar.min.js')!!}"></script>
    <script src="{!!url('public/assets/plugins/tablesorter/dist/js/widgets/widget-columnSelector.min.js')!!}"></script>
    <script src="{!!url('public/assets/plugins/tablesorter/dist/js/widgets/widget-print.min.js')!!}"></script>
    <!--  tablesorter functions -->
    <script src="{!!url('public/assets/js/pages/plugins_tablesorter.min.js')!!}"></script>
    
</body>
</html>