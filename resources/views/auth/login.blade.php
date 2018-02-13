<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Finance Asamankese">
    <meta name="author" content="Gad Ocansey">
    <title>Asamankese | Fees Collections</title>
    <meta name="msapplication-TileColor" content="#9f00a7">

    <!-- Favicons-->
    <link rel="icon" href="assets/favicon.png" sizes="32x32">
    <!-- Favicons-->
    <link rel="apple-touch-icon-precomposed" href="assets/favicon.png">
    <!-- For iPhone -->
    <meta name="msapplication-TileColor" content="#00bcd4">
    <meta name="msapplication-TileImage" content="assets/favicon.png">
    <!-- For Windows Phone -->


    <!-- CORE CSS-->

    <link href='{!! url( "public/logins/css/materialize.css")  !!}' type="text/css" rel="stylesheet" media="screen,projection">
    <link href='{!! url( "public/logins/css/style.css")  !!}' type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->
    <link href="public/logins/css/custom-style.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="public/logins/css/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">

    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <link href="public/logins/css/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
    <link href="public/logins/js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

</head>

<body class="blue-grey">
<!-- Start Page Loading -->
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
</div>
<!-- End Page Loading -->
<div>
    <!-- if there are login errors, show them here -->
    @if (count($errors) > 0)

        <div class="uk-form-row">
            <div class="alert alert-danger" style="background-color: red;color: white">

                <ul>
                    @foreach ($errors->all() as $error)
                        <li> {!!  $error  !!} </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="input-field col s12 center">
        <img src="public/assets/img/logo.png" alt="" class="" style="width:120px;height:auto">
        <p class="center login-form-text" style='color:#1a337e'> Fees Collection  and Management System</p>
    </div>
</div>

<div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
        <form class="login-form"  method="POST"  action="{{ url('login') }}">
            {!! csrf_field() !!}
            <div>&nbsp;</div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-social-person-outline prefix"></i>
                    <input id="username" type="text" required=""    name="fund">
                    <label for="username" class="login-form-text">Index Number</label>
                </div>
            </div>
            <div class="row margin">
                <div class="input-field col s12">
                    <i class="mdi-action-lock-outline prefix"></i>
                    <input id="password" type="password" required="" name="password">
                    <label class="login-form-text" for="password">Password</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m12 l12  login-text">
                    <input type="checkbox" id="remember-me" />
                    <label class="login-form-text" for="remember-me">Remember me</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <table>
                        <tr>
                            <Td><button type="submit" class="btn waves-effect waves-light col s12">Login</button></Td>
                            <td class="login-form-text"><a  href="http://www.help.ttuportal.com" >Help and Enquiries??</a></td>

                        </tr>
                    </table>
                </div>
            </div>


        </form>

    </div>

</div>
<div class="row">
    <center><small style="font-size: 11px">&copy <?php echo  date('Y'); ?> | Asamankese - Designed by Gad Ocansey  0243348522</small></center>
</div>


<!-- ================================================
  Scripts
  ================================================ -->

<!-- jQuery Library -->
<script type="text/javascript" src="public/logins/js/jquery-1.11.2.min.js"></script>
<!--materialize js-->
<script type="text/javascript" src="public/logins/js/materialize.js"></script>
<!--prism-->
<script type="text/javascript" src="public/logins/js/prism.js"></script>
<!--scrollbar-->
<script type="text/javascript" src="public/logins/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<!--plugins.js - Some Specific JS codes for Plugin Settings-->
<script type="text/javascript" src="public/logins/js/plugins.js"></script>

</body>
</html>
