<?php
clearstatcache();
?>
<!DOCTYPE html>
<html class=" ">

<style>
    /* SANTA CSS */
    .santa {
        position: fixed;
        bottom: 10px;
        right: -500px;
    }

    .xmas-tree {
        position: fixed;
        bottom: -10px;
        right: 5px;
    }
    .jan_frst {
        position: fixed;
        bottom: -10px;
        right: 5px;
    }
    .april {
        position: fixed;
        bottom: 10px;
        right: 5px;
    }
    /* END SANTA CSS */

</style>

<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8"/>
    <title> Welcome to <?= $sysinfo[0]->synm ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/x-icon"/>
    <!-- Favicon -->
    <link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png">
    <!-- For iPhone -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="<?= base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">
    <!-- For iPhone 4 Retina display -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="<?= base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="<?= base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">
    <!-- For iPad Retina display -->


    <!-- CORE CSS FRAMEWORK - START -->
    <!--    <link href="-->
    <? //= base_url(); ?><!--assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css"-->
    <!--          media="screen"/>-->
    <link href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="<?= base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
    <!--    <link href="-->
    <? //= base_url(); ?><!--assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet"-->
    <!--          type="text/css"/>-->
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
    <link href="<?= base_url(); ?>assets/plugins/icheck/skins/square/orange.css" rel="stylesheet" type="text/css"
          media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="<?= base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <!-- CORE CSS TEMPLATE - END -->

    <!-- SNOW JS-->
    <?php
    $crntmn = date('m'); // 12 | 01
    $crntdt = date('m-d');
    if ($crntmn == 12 || $crntdt == '01-01') { ?>
        <script type="text/javascript" src="<?= base_url(); ?>assets/snow/snowstorm.js"></script>
    <?php } ?>
        <script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/jquery/jquery-ui.min.js"></script>

    <!-- END SNOW JS-->

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class=" login_page">


<div class="login-wrapper">
    <div id="login"
         class="login loginpage col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-offset-3 col-sm-6 col-xs-offset-2 col-xs-8">
        <!--<h1><a href="#" title="Login Page" tabindex="-1">Ultra xxx</a></h1>-->
        <h1><a href="#" title="Login Page" tabindex="-1">Ultra xxx</a></h1>

        <form name="loginForm" id="loginForm" action="<?= base_url(); ?>login/loginMe" method="post">
            <p>
                <input type="text" name="usname" id="usname" class="input" placeholder="Username"/></label>
            </p>
            <p>
                <input type="password" name="paswrd" id="paswrd" class="input" placeholder="Password"/></label>
            </p>
            <p class="submit">
                <input type="submit" name="wp-submit" id="wp-submit" class="btn btn-orange btn-block" value="Log In"/>
            </p>
        </form>

        <p id="nav">
        <div class="pull-left">
            &copy; 2018 - <?= $sysinfo[0]->cmne ?>
        </div>
        <div class="pull-right">
            <a href="" target="_blank"></a>
        </div>
        </p>
    </div>

    <!-- PROMOTION MONTHLY  IMG -->
    <?php


    if ($crntmn == 12) { ?>
    <div class="santa"><img src="<?= base_url(); ?>assets/Santa/images/christmas-sled-source_ulp.gif" alt=""></div>
    <div class="xmas-tree"><img src="<?= base_url(); ?>assets/Santa/images/Animated_Xmas-tree-animation.gif" alt="">
    </div>
    <?php }
    if ($crntdt == '01-01') { ?>
        <div class="jan_frst"><img src="<?= base_url(); ?>assets/Santa/images/january_first.png" alt=""></div>
    <?php }
    if ($crntmn == 04) { ?>
        <div class="april"><img src="<?= base_url(); ?>assets/Santa/images/april2.png" alt=""></div>
    <?php } ?>

    <!-- END PROMOTION -->

</div>
<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
</body>

<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/jquery-validation/jquery.validate.js"></script>

<script src="<?= base_url(); ?>assets/dist/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/dist/toastr/toastr.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "400",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $().ready(function () {
        $.validator.setDefaults({
            errorElement: 'small',
            errorClass: 'error',
            highlight: function (element) {
                $(element)
                    .closest('.form-group')
                    .addClass('has-error')
            },
            unhighlight: function (element) {
                $(element)
                    .closest('.form-group')
                    .removeClass('has-error')
            }
        });
        //====title details add form validation====
        $("#loginForm").validate({
            rules: {
                usname: {
                    required: true
                },
                paswrd: {
                    required: true
                }
            },
            messages: {
                usname: {
                    required: 'Please enter User Name'
                },
                paswrd: {
                    required: 'Please enter Password'
                }
            }
        });

        // SANTA MOVE
        var windowWidth = $(document).width();
        var santa = $('.santa');
        santa_right_pos = windowWidth + santa.width();
        santa.right = santa_right_pos;

        //$(document).snowfall({flakeCount: 100, maxSpeed: 5, maxSize: 5});
        function movesanta() {
            santa.animate({right: windowWidth + santa.width()}, 15000, function () {
                santa.css("right", "-500px");
                setTimeout(function () {
                    movesanta();
                }, 10000);
            });
        }

        movesanta();
// END SANTA MOVE

    });

</script>

<?php
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
//if ($pageWasRefreshed) {

if (isset($_GET['message'])) {
    $message = $_GET['message'];

    if ($message === "fail") {
        ?>
        <script type="text/javascript">
            //toastr.error('Error - Wrong login data!');
            toastr.error('Please check login data !');
        </script>
    <?php
    }else if ($message === "userlock") {
    ?>
        <script type="text/javascript">
            toastr.error('Your Account Lock ! Contact MIT !!');
        </script>
    <?php
    }else if ($message === "sys_update") {
    ?>
        <script type="text/javascript">
            toastr.error('System Update! !!');
        </script>
    <?php
    }else if ($message === "wrngTry1") { ?>
        <script type="text/javascript">
            toastr.error('Your are tried wrong password 1 times !!');
        </script>
    <?php
    }else if ($message === "wrngTry2") { ?>

        <script type="text/javascript">
            toastr.error('Your are tried wrong password 2 times !!');
        </script>
    <?php
    }else if ($message === "wrngTry3") { ?>
        <script type="text/javascript">
            toastr.error('Your are tried wrong password 3 times !!');
        </script>
    <?php
    }else if ($message === "wrngLgcd") { ?>
        <script type="text/javascript">
            toastr.error('Wrong Digital eye code !!');
        </script>
    <?php
    }
    //locked user day end reconsi 2018-11-13
    else if ($message === "Delock"){ ?>
        <script type="text/javascript">
            toastr.info("You Are Locked !<br/>Day End Reconciliation Is Not Done At Last Day, Please Concat Operation Manager..");
        </script>
        <?php
    }
    //end locked user day end reconsi 2018-11-13
}

//}

?>

</html>

