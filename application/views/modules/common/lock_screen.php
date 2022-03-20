<!DOCTYPE html>
<html lang="en" class="body-full-height">

<?php
$usnm = $_SESSION['username'];
$pass = $_SESSION['uimg'];
$uid = $_SESSION['userId'];

$_SESSION['username'] = '';
$_SESSION['userId'] = '';
//$_SESSION['uimg'] = '';

?>

<head>
    <!-- META SECTION -->
    <title> Screen Lock </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <link rel="icon" href="<?= base_url(); ?>assets/dist/img/favicon.ico" type="image/x-icon"/>
    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="<?= base_url(); ?>assets/dist/css/theme-default.css"/>
    <!-- EOF CSS INCLUDE -->
</head>

<body>

<div class="lockscreen-container">
    <div class="lockscreen-box animated fadeInDown">
        <div class="lsb-access">
            <div class="lsb-box">
                <div class="fa fa-lock"></div>
                <div class="user animated fadeIn">
                    <img src="<?= base_url(); ?>uploads/userimg/<?= $_SESSION['uimg']; ?>"
                         alt="<?= $_SESSION['fname']; ?>" title="<?= $usnm; ?>"/>
                    <div class="user_signin animated fadeIn">
                        <div class="fa fa-sign-in"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lsb-form animated fadeInDown">
            <form action="<?= base_url(); ?>login/loginMe" method="post" class="form-horizontal" method="post" name="loginForm"
                  id="loginForm">
                <div class="form-group sign-in animated fadeInDown">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-user"></span>
                            </div>
                            <input type="text" class="form-control" id="usname" name="usname" value="<?= $usnm; ?>"
                                   placeholder="Your login"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <span class="fa fa-lock"></span>
                            </div>
                            <input type="password" class="form-control" id="paswrd" name="paswrd"
                                   placeholder="Password"/>
                        </div>
                    </div>
                </div>
                <input type="submit" class="hidden"/>
            </form>
        </div>
    </div>
</div>
<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/jquery/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/bootstrap/bootstrap.min.js"></script>
<!-- END PLUGINS -->

<!-- START TEMPLATE -->
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/actions.js"></script>

<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/jquery-validation/jquery.validate.js"></script>
<!-- END TEMPLATE -->
<!-- END SCRIPTS -->

<script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>


</body>
</html>

<script type="text/javascript">

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
            errorClass: 'warning',
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

    });

</script>




