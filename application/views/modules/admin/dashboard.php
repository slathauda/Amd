<!DOCTYPE html>
<html class="">
<script src="<?= base_url(); ?>assets/dist/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/dist/toastr/toastr.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url(); ?>assets/js/dashboard.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


<body class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">

                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active"><strong>Admin Dashboard</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box nobox">
                <div class="content-body">

                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="r4_counter db_box">
                                <i class='pull-left fa fa-thumbs-up icon-md icon-rounded icon-primary'></i>
                                <div class="stats">
                                    <h4><strong>45%</strong></h4>
                                    <span>New Orders</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="r4_counter db_box">
                                <i class='pull-left fa fa-shopping-cart icon-md icon-rounded icon-orange'></i>
                                <div class="stats">
                                    <h4><strong>243</strong></h4>
                                    <span>New Products</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="r4_counter db_box">
                                <i class='pull-left fa fa-dollar icon-md icon-rounded icon-purple'></i>
                                <div class="stats">
                                    <h4><strong>$3424</strong></h4>
                                    <span>Profit Today</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="r4_counter db_box">
                                <i class='pull-left fa fa-users icon-md icon-rounded icon-warning'></i>
                                <div class="stats">
                                    <h4><strong>1433</strong></h4>
                                    <span>New Users</span>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End .row -->

                    <div class="row">

                        <div class="col-md-3 col-sm-5 col-xs-12">

                            <div class="r1_graph1 db_box">
                                <span class='bold'>98.95%</span>
                                <span class='pull-right'><small>SERVER UP</small></span>
                                <div class="clearfix"></div>
                                <span class="db_dynamicbar">Loading...</span>
                            </div>


                            <div class="r1_graph2 db_box">
                                <span class='bold'>2332</span>
                                <span class='pull-right'><small>USERS ONLINE</small></span>
                                <div class="clearfix"></div>
                                <span class="db_linesparkline">Loading...</span>
                            </div>


                            <div class="r1_graph3 db_box hidden-xs">
                                <span class='bold'>342/123</span>
                                <span class='pull-right'><small>ORDERS / SALES</small></span>
                                <div class="clearfix"></div>
                                <span class="db_compositebar">Loading...</span>
                            </div>

                        </div>


                        <div class="col-md-6 col-sm-7 col-xs-12">
                            <div class="r1_maingraph db_box">
                                            <span class='pull-left'>
                                                <i class='icon-purple fa fa-square icon-xs'></i>&nbsp;<small>PAGE VIEWS</small>&nbsp; &nbsp;<i
                                                        class='fa fa-square icon-xs icon-primary'></i>&nbsp;<small>UNIQUE VISITORS</small>
                                            </span>
                                <span class='pull-right switch'>
                                                <i class='icon-default fa fa-line-chart icon-xs'></i>&nbsp; &nbsp;<i
                                            class='icon-secondary fa fa-bar-chart icon-xs'></i>&nbsp; &nbsp;<i
                                            class='icon-secondary fa fa-area-chart icon-xs'></i>
                                            </span>

                                <div id="db_morris_line_graph" style="height:272px;width:95%;"></div>
                                <div id="db_morris_area_graph" style="height:272px;width:90%;display:none;"></div>
                                <div id="db_morris_bar_graph" style="height:272px;width:90%;display:none;"></div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="r1_graph4 db_box">
                                            <span class=''>
                                                <i class='icon-purple fa fa-square icon-xs icon-1'></i>&nbsp;<small>CPU USAGE</small>
                                            </span>
                                <canvas width='180' height='90' id="gauge-meter"></canvas>
                                <h4 id='gauge-meter-text'></h4>
                            </div>
                            <div class="r1_graph5 db_box col-xs-6">
                                    <span class=''><i class='icon-purple fa fa-square icon-xs icon-1'></i>&nbsp;<small>LONDON</small>&nbsp; &nbsp;<i
                                                class='fa fa-square icon-xs icon-2'></i>&nbsp;<small>PARIS</small></span>
                                <div style="width:120px;height:120px;margin: 0 auto;">
                                        <span class="db_easypiechart1 easypiechart" data-percent="66"><span
                                                    class="percent" style='line-height:120px;'></span></span>
                                </div>
                            </div>

                        </div>

                    </div> <!-- End .row -->
                </div>
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<div class="page-chatapi hideit">

    <div class="search-bar">
        <input type="text" placeholder="Search" class="form-control">
    </div>

    <div class="chat-wrapper">
        <h4 class="group-head">Groups</h4>
        <ul class="group-list list-unstyled">
            <li class="group-row">
                <div class="group-status available">
                    <i class="fa fa-circle"></i>
                </div>
                <div class="group-info">
                    <h4><a href="#">Work</a></h4>
                </div>
            </li>
            <li class="group-row">
                <div class="group-status away">
                    <i class="fa fa-circle"></i>
                </div>
                <div class="group-info">
                    <h4><a href="#">Friends</a></h4>
                </div>
            </li>

        </ul>


        <h4 class="group-head">Favourites</h4>
        <ul class="contact-list">

            <li class="user-row" id='chat_user_1' data-user-id='1'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clarine Vassar</a></h4>
                    <span class="status available" data-status="available"> Available</span>
                </div>
                <div class="user-status available">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_2' data-user-id='2'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Brooks Latshaw</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_3' data-user-id='3'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-3.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clementina Brodeur</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>

        </ul>


        <h4 class="group-head">More Contacts</h4>
        <ul class="contact-list">

            <li class="user-row" id='chat_user_4' data-user-id='4'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-4.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Carri Busey</a></h4>
                    <span class="status offline" data-status="offline"> Offline</span>
                </div>
                <div class="user-status offline">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_5' data-user-id='5'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-5.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Melissa Dock</a></h4>
                    <span class="status offline" data-status="offline"> Offline</span>
                </div>
                <div class="user-status offline">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_6' data-user-id='6'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Verdell Rea</a></h4>
                    <span class="status available" data-status="available"> Available</span>
                </div>
                <div class="user-status available">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_7' data-user-id='7'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Linette Lheureux</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_8' data-user-id='8'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-3.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Araceli Boatright</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_9' data-user-id='9'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-4.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clay Peskin</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_10' data-user-id='10'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-5.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Loni Tindall</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_11' data-user-id='11'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Tanisha Kimbro</a></h4>
                    <span class="status idle" data-status="idle"> Idle</span>
                </div>
                <div class="user-status idle">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_12' data-user-id='12'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Jovita Tisdale</a></h4>
                    <span class="status idle" data-status="idle"> Idle</span>
                </div>
                <div class="user-status idle">
                    <i class="fa fa-circle"></i>
                </div>
            </li>

        </ul>
    </div>

</div>

<!-- END CONTAINER -->


</body>

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
</script>

<?php
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
//if ($pageWasRefreshed) {
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    if ($message === "success") {
        ?>
        <script>
            toastr.success('Welcome <?php
                if (!empty($_SESSION['userId'])) {
                    echo $_SESSION['fname'] . " " . $_SESSION['lname'];
                }
                ?>..');
        </script>
        <?php
    }
}
//}

?>

</html>
