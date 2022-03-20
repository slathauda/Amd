<?php

$this->load->model('Generic_model'); // load model
$data = $this->Generic_model->getData('com_det', array('cmne', 'synm'), array('stat' => 1));

//$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//echo $url;
//$re = (explode("/", $url));

//if (!empty($re[3])) {
//    $aa = $re[3];
//    $pgdt = $this->Generic_model->getData('user_page', array('pgnm'), array('stst' => 1, 'pgcd' => $aa));
//
//    $pgnm = $pgdt[0]->pgnm;
//} else {
//    $pgnm = '';
//}

?>

<!DOCTYPE html>
<html lang="en">

<!-- A L L   S Y S T E M   C S S -->

<link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/x-icon"/>    <!-- Favicon -->
<link rel="apple-touch-icon-precomposed" href="<?= base_url(); ?>assets/images/apple-touch-icon-57-precomposed.png">
<!-- For iPhone -->
<link rel="apple-touch-icon-precomposed" sizes="114x114"
      href="<?= base_url(); ?>assets/images/apple-touch-icon-114-precomposed.png">
<!-- For iPhone 4 Retina display -->
<link rel="apple-touch-icon-precomposed" sizes="72x72"
      href="<?= base_url(); ?>assets/images/apple-touch-icon-72-precomposed.png">    <!-- For iPad -->
<link rel="apple-touch-icon-precomposed" sizes="144x144"
      href="<?= base_url(); ?>assets/images/apple-touch-icon-144-precomposed.png">    <!-- For iPad Retina display -->

<!-- CORE CSS FRAMEWORK - START -->
<link href="<?= base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
<!-- CORE CSS FRAMEWORK - END -->

<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
<link href="<?= base_url(); ?>assets/plugins/morris-chart/css/morris.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/graph.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/detail.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/legend.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/extensions.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/rickshaw.min.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/rickshaw-chart/css/lines.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/icheck/skins/minimal/white.css" rel="stylesheet" type="text/css"
      media="screen"/>
<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->

<!-- CORE CSS TEMPLATE - START -->
<link href="<?= base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<!-- CORE CSS TEMPLATE - END -->


<!-- DATA TABLE SCRIPTS START -->
<link href="<?= base_url(); ?>assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<link href="<?= base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<!-- DATA TABLE SCRIPTS END -->


<!-- CORE JS FRAMEWORK - START -->
<script src="<?= base_url(); ?>assets/js/jquery-1.11.2.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/jquery.easing.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"
        type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>
<!-- CORE JS FRAMEWORK - END -->

<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/numeral-js.js"></script>

<!-- userTimeout -->
<script src="<?= base_url(); ?>assets/dist/js/jquery.userTimeout.js" type="text/javascript"></script>

<!-- validation-->
<script type="text/javascript"
        src="<?= base_url() ?>assets/dist/js/plugins/validationengine/languages/jquery.validationEngine-en.js"></script>
<script type="text/javascript"
        src="<?= base_url() ?>assets/dist/js/plugins/validationengine/jquery.validationEngine.js"></script>
<script type="text/javascript"
        src="<?= base_url() ?>assets/dist/js/plugins/jquery-validation/jquery.validate.js"></script>
<!-- END validation-->

<script type="text/javascript">  // common function
    $(document).userTimeout({
        logouturl: '<?= base_url() ?>welcome/auto_lgout',
        session: 900000 //15 Minutes    1's= 1000ms
    });

    // system time show function
    function timedMsg() {
        var t = setInterval("change_time();", 1000);
    }
    function change_time() {
        var d = new Date();
        var curr_hour = d.getHours();
        var curr_min = d.getMinutes();
        var curr_sec = d.getSeconds();
        if (curr_hour > 12)
            curr_hour = curr_hour - 12;

        if (curr_hour < 10) {
            var curr_hour2 = '0' + curr_hour;
        } else {
            var curr_hour2 = curr_hour;
        }
        if (curr_min < 10) {
            var curr_min2 = '0' + curr_min;
        } else {
            var curr_min2 = curr_min;
        }
        if (curr_sec < 10) {
            var curr_sec2 = '0' + curr_sec;
        } else {
            var curr_sec2 = curr_sec;
        }

        document.getElementById('Hour').innerHTML = curr_hour2 + ':';
        document.getElementById('Minut').innerHTML = curr_min2 + ':';
        document.getElementById('Second').innerHTML = curr_sec2;

        if (navigator.onLine) {
            document.getElementById("chk_cnntion").innerHTML = "<button class='btn btn-success btn-corner btn-xs'>ONLINE</button>";
        } else {
            document.getElementById("chk_cnntion").innerHTML = "<button class='btn btn-danger btn-corner btn-xs'>OFFLINE</button>";
        }

        //console.log(new Date().toLocaleTimeString());
        var crtm = new Date().toLocaleTimeString();
        if (crtm === '10:55:00 PM') {
            swal({title: "Reminder", text: "Please finish all work before 11 PM and quit..", type: "info"});
        } else if (crtm === '11:00:00 PM') {

            swal({title: "Time Over", text: "Your working times is over now.. \n Log Again Tomorrow", type: "info"},
                function () {
                    window.location.href = '<?= base_url() ?>welcome/schedule_lgout';
                });
        }
        /*else if (crtm === '10:00:00 AM') {
            swal({title: "Schedule time", text: "Please give me a few minutes.", type: "info"},
                function () {

                });
        } */
        else {
        }
    }
    timedMsg();
    // end system time show function

    // data table loading gif and data table panel refesh
    $(".panel-refresh").click(function () {
        function p_refresh_shown() {
            // setTimeout(function () {
            panel_refresh($(".panel-refresh").parents(".panel"), "hidden", function () {
            });
            // }, 10); //1000
        }

        panel_refresh($(".panel-refresh").parents(".panel"), "shown", p_refresh_shown);
    });
    // end data table loading gif and data table panel refesh

    // **********************************************
    //          jQuery customeiz validation
    // **********************************************
    // jquery validation not equel method
    jQuery.validator.addMethod("notEqual",
        function (value, element, param) {
            return this.optional(element) || value != param;
        }, "Please specify a different (non-default) value");

    jQuery.validator.addMethod("notEqualTo",
        function (value, element, param) {
            var notEqual = true;
            value = $.trim(value);
            for (i = 0; i < param.length; i++) {
                if (value == $.trim($(param[i]).val())) {
                    notEqual = false;
                }
            }
            return this.optional(element) || notEqual;
        },
        "Please enter a different value."
    );
    // end jquery validation not equel method

    $.validator.addMethod("greaterThan",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) < parseInt($otherElement.val(), 10);
        },
        "This value greater then other value."
    );
    $.validator.addMethod("lessThan",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) > parseInt($otherElement.val(), 10);
        },
        "This value less then other value."
    );

    // lessThanOrEqual
    $.validator.addMethod("lessThanOrEqual",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) >= parseInt($otherElement.val(), 10);
        },
        "This value less then other value."
    );

    // greaterThanOrEqual
    $.validator.addMethod("greaterThanOrEqual",
        function (value, element, param) {
            var $otherElement = $(param);
            return parseInt(value, 10) <= parseInt($otherElement.val(), 10);
        },
        "This value greater then other value."
    );

    // Validation method for currency
    /* https://gist.github.com/jonkemp/9094324#file-validate-currency-js */
    $.validator.addMethod("currency", function (value, element) {
        return this.optional(element) || /^(\d{1,3}(\,\d{3})*|(\d+))(\.\d{2})?/.test(value);
    }, "Please specify a valid amount");

    /*
     validate useing by class
     https://jqueryvalidation.org/jQuery.validator.addClassRules/#namerules
     jQuery.validator.addClassRules("name", {
     required: true,
     minlength: 2
     });*/

    // // Validation method for MAX DATE TODAY
    /* https://stackoverflow.com/questions/17310431/max-date-using-jquery-validation?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa */
    $.validator.addMethod("maxDate", function (value, element) {
        var curDate = new Date();
        var inputDate = new Date(value);
        if (inputDate < curDate)
            return true;
        return false;
    }, "Invalid Date!");   // error message

    $.validator.addMethod("minDate", function (value, element) {
        var curDate = new Date();
        var inputDate = new Date(value);
        //console.log( curDate + '**' + inputDate);
        if (inputDate > curDate)
            return true;
        return false;
    }, "Invalid Date!");   // error message

    // *********************************************
    //      END jQuery customeiz validation
    // **********************************************


    /*----------------CUSTOME DEFINE---------------------*/
    //HEADER SEARCH
    $(document).ready(function () {
        $('#sid').keydown(function (e) {

            if (e.which === 13) {
                e.preventDefault();
                var sid = $(this).val();
                var len = sid.length;

                //console.log(len);

                if (sid != '') {
                    if (len == 10 || len == 12 || len == 13 || len == 19) {
                        $.ajax({
                            url: '<?= base_url(); ?>user/nicSrch',
                            type: 'POST',
                            data: {
                                sid: sid
                            },
                            dataType: 'json',
                            success: function (response) {

                                var len = response.length;
                                if (len != '') {
                                    location = '<?= base_url(); ?>user/nicSearchDtils?sid=' + sid;

                                } else {
                                    document.getElementById('wrng_msgcontent').innerHTML = "Invalid searching values. <br/>Please enter Customer NIC or Account Number correctly.";
                                    $('#msg_warning').toggleClass("open");
                                }
                            }
                        });
                    } else {
                        document.getElementById('wrng_msgcontent').innerHTML = "Enter search value correctly and continue again.";
                        $('#msg_warning').toggleClass("open");
                        return false;
                    }

                } else {
                    document.getElementById('wrng_msgcontent').innerHTML = "Enter search value correctly and continue again.";
                    $('#msg_warning').toggleClass("open");
                    return false;
                }
            }
        });
    });

</script>


<head>
    <!-- META SECTION ## COMPANY NAME  -->
    <title> <?= $data[0]->cmne ?> </title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>


</head>
<!-- START PAGE CONTAINER -->




