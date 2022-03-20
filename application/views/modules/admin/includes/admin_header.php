<style>
    .now_time {
        text-decoration: none !important;
        cursor: pointer;
        background-color: transparent;
        color: #0a0b0d;
    }

     .blink_me {
         animation: blinker 3s linear infinite;
     }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
    }
</style>

<head>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class=" " id="main_body">
<!-- START TOPBAR -->
<div class='page-topbar' id="page_topbar"> <!-- sidebar_shift -->
    <div class='logo-area'></div>

    <div class='quick-area'>
        <div class='pull-left'>
            <ul class="info-menu left-links list-inline list-unstyled">
                <li class="sidebar-toggle-wrap">
                    <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>

                <!-- ONLINE -->
                <li class="">
                    <a id="chk_cnntion" title="Network status:"></a>
                </li>
                <!-- DATE TIME-->
                <li class="">
                    <a class="now_time"><b> LK Time : <span id="timecontainer2"></span>
                            <span id="Hour"></span>
                            <span id="Minut"></span>
                            <span id="Second"></span>
                            <span id="am"><?= date("A") . date(" (D)") ?></span>
                        </b> </a>
                </li>

                <li class="hidden-sm hidden-xs searchform">
                    <div class="input-group">
                                <span class="input-group-addon input-focus">
                                    <i class="fa fa-search"></i>
                                </span>
                        <form action="http://jaybabani.com/ultra-admin-html/search-page.html" method="post">
                            <input type="text" class="form-control animated fadeIn" placeholder="Search & Enter">
                            <input type='submit' value="">
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <div class='pull-right'>
            <ul class="info-menu right-links list-inline list-unstyled">


               <!-- <li class="chat-toggle-wrapper">
                    <a href="#" data-toggle="chatbar" class="toggle_chat">
                        <i class="fa fa-comments"></i>
                        <span class="badge badge-warning">9</span>
                    </a>
                </li>-->

                <li class="message-toggle-wrapper">
                    <a href="#" data-toggle="dropdown" class="toggle">
                        <i class="fa fa-envelope"></i>
                        <span class="badge badge-primary">7</span>
                    </a>
                    <ul class="dropdown-menu messages animated fadeIn" data-placement="left">

                        <li class="list">

                            <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                <li class="unread status-available">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-1.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Clarine Vassar</strong>
                                                        <span class="time small">- 15 mins ago</span>
                                                        <span class="profile-status available pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-away">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-2.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Brooks Latshaw</strong>
                                                        <span class="time small">- 45 mins ago</span>
                                                        <span class="profile-status away pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-busy">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-3.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Clementina Brodeur</strong>
                                                        <span class="time small">- 1 hour ago</span>
                                                        <span class="profile-status busy pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-offline">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-4.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Carri Busey</strong>
                                                        <span class="time small">- 5 hours ago</span>
                                                        <span class="profile-status offline pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-offline">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-5.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Melissa Dock</strong>
                                                        <span class="time small">- Yesterday</span>
                                                        <span class="profile-status offline pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-available">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-1.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Verdell Rea</strong>
                                                        <span class="time small">- 14th Mar</span>
                                                        <span class="profile-status available pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-busy">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-2.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Linette Lheureux</strong>
                                                        <span class="time small">- 16th Mar</span>
                                                        <span class="profile-status busy pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" status-away">
                                    <a href="#">
                                        <div class="user-img">
                                            <img src="<?= base_url() ?>assets/data/profile/avatar-3.png"
                                                 alt="user-image"
                                                 class="img-circle img-inline">
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Araceli Boatright</strong>
                                                        <span class="time small">- 16th Mar</span>
                                                        <span class="profile-status away pull-right"></span>
                                                    </span>
                                            <span class="desc small">
                                                        Sometimes it takes a lifetime to win a battle.
                                                    </span>
                                        </div>
                                    </a>
                                </li>

                            </ul>

                        </li>

                        <li class="external">
                            <a href="#">
                                <span>Read All Messages</span>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="notify-toggle-wrapper">
                    <a href="#" data-toggle="dropdown" class="toggle">
                        <i class="fa fa-bell"></i>
                        <span class="badge badge-orange">3</span>
                    </a>
                    <ul class="dropdown-menu notifications animated fadeIn">
                        <li class="total">
                                    <span class="small">
                                        You have <strong>3</strong> new notifications.
                                        <a href="#" class="pull-right">Mark all as Read</a>
                                    </span>
                        </li>
                        <li class="list">

                            <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                <li class="unread available"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Server needs to reboot</strong>
                                                        <span class="time small">15 mins ago</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class="unread away"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-envelope"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>45 new messages</strong>
                                                        <span class="time small">45 mins ago</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" busy"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Server IP Blocked</strong>
                                                        <span class="time small">1 hour ago</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" offline"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>10 Orders Shipped</strong>
                                                        <span class="time small">5 hours ago</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" offline"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>New Comment on blog</strong>
                                                        <span class="time small">Yesterday</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" available"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Great Speed Notify</strong>
                                                        <span class="time small">14th Mar</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>
                                <li class=" busy"> <!-- available: success, warning, info, error -->
                                    <a href="#">
                                        <div class="notice-icon">
                                            <i class="fa fa-times"></i>
                                        </div>
                                        <div>
                                                    <span class="name">
                                                        <strong>Team Meeting at 6PM</strong>
                                                        <span class="time small">16th Mar</span>
                                                    </span>
                                        </div>
                                    </a>
                                </li>

                            </ul>

                        </li>

                        <li class="external">
                            <a href="#">
                                <span>Read All Notifications</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- POWER & SETTING -->
                <li class="profile">
                    <a href="#" data-toggle="dropdown" class="toggle">
                        <i class="fa fa-power-off"></i>
                    </a>
                    <ul class="dropdown-menu profile animated fadeIn">

                        <?php
                        //$spst = $this->Generic_model->getSpecStting('msve');
                        if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { //|| $_SESSION['role'] == $spst?>
                            <li><a href="<?= base_url() ?>user"> <i class="fa fa-user"></i>User </a></li>
                            <?php
                        }
                        ?>
                        <!--<li><a href="#profile"> <i class="fa fa-user"></i> Profile </a></li>-->
                        <li><a href="#help"> <i class="fa fa-lock"></i> Lock Account </a></li>
                        <li><a href="<?= base_url() ?>welcome/logout"> <i class="fa fa-sign-out">
                                </i> Logout </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

</div>
<!-- END TOPBAR -->
</body>
<!-- START CONTAINER -->
<div class="page-container row-fluid">

    <script>
        var h = window.innerHeight;
    </script>

    <!-- SIDEBAR - START -->
    <div class="page-sidebar expandit" id="sidebar">
        <!-- MAIN MENU - START -->
        <div class="page-sidebar-wrapper" id="main-menu-wrapper" style="height: 100vh ">

            <!-- USER INFO - START -->
            <div class="profile-info row">
                <div class="profile-image col-md-4 col-sm-4 col-xs-4">
                    <a href="<?= base_url() ?>welcome/profile">
                        <img src="<?= base_url() ?>uploads/userimg/user_default.png" class="img-responsive img-circle">
                    </a>
                </div>
                <div class="profile-details col-md-8 col-sm-8 col-xs-8">
                    <h3>
                        <a href="<?= base_url() ?>welcome/profile">
                            <?php
                            if (!empty($_SESSION['userId'])) {
                                echo $_SESSION['fname'] . " " . $_SESSION['lname'];
                            }
                            ?>
                        </a>
                        <!-- Available statuses: online, idle, busy, away and offline -->
                        <span class="profile-status online"></span>
                    </h3>
                    <p class="profile-title"><?= $_SESSION['roleText']; ?></p>
                </div>
            </div>
            <!-- USER INFO - END -->

            <!-- SIDE MENU - START -->
            <ul class='wraplist' id="wraplist" style="height: inherit !important;">
                <li class="open">
                    <a href="<?= base_url(); ?>Admin">
                        <i class="fa fa-dashboard"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li class="">
                    <a href="#">
                        <i class="fa fa-suitcase"></i>
                        <span class="title"> General  </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array("cmpny_info", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "admin/cmpny_info> <span class='fa fa-user'></span> Company Info </a></li>";
                        }
                        if (in_array("activty_log", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "admin/activty_log> <span class='fa fa-sliders'></span> Activity Log </a></li>";
                        }
                        if (in_array("permis", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "admin/permis> <span class='fa fa-sitemap'></span> Permission Management </a></li>";
                        }
                        ?>
                    </ul>
                </li>

                <li class="">
                    <a href="#">
                        <i class="fa fa-cogs"></i>
                        <span class="title"> System Component </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php
                        if (in_array("brnch_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Admin/brnch_mng> <span class='fa fa-sitemap'></span> Branch Management </a></li>";
                        }
                        if (in_array("user_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Admin/user_mng> <span class='fa fa-user'></span> User Management </a></li>";
                        }

                        if (in_array("chrt_acc", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Admin/chrt_acc> <span class='fa fa-credit-card'></span> Chart Of Account</a></li>";
                        }
                        if (in_array("bank_acc", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Admin/bank_acc> <span class='fa fa-university'></span> Bank Account</a></li>";
                        }
                        /*if (in_array("trnsf_respond", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "dsd/trnsf_respond> <span class='fa fa-sitemap'></span> Pending Customer Requests </a></li>";
                        }*/
                        ?>
                    </ul>
                </li>
                <!-- STOCK COMPONENT -->
                <li class="">
                    <a href="#">
                        <i class="fa fa-sliders"></i>
                        <span class="title">Stock Component</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if (in_array("sply_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/sply_mng> <span class='fa fa-users'></span> Supply Management</a></li>";
                        } ?>
                        <?php if (in_array("ware_house", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/ware_house> <span class='fa fa-home'></span> Warehouse Management</a></li>";
                        } ?>
                        <?php if (in_array("brnd_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/brnd_mng> <span class='fa fa-sliders'></span> Brands Management</a></li>";
                        } ?>

                        <?php if (in_array("cate_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/cate_mng> <span class='fa fa-sitemap'></span> Category Management </a></li>";
                        } ?>
                        <?php if (in_array("mdl_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/mdl_mng> <span class='fa fa-columns'></span> Model Management</a></li>";
                        } ?>
                        <?php if (in_array("type_mng", $permission, TRUE)) {
                            echo "<li><a href=" . base_url() . "Stock/type_mng> <span class='fa fa-users'></span> Size (Type) Management</a></li>";
                        } ?>

                    </ul>
                </li>


                <!-- REPORT -->
                <li class="">
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <span class="title">Report</span>
                        <span class="arrow "></span><!--<span class="label label-orange">NEW</span>-->
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a class="" href="ui-calendar.html">Calendar</a>
                        </li>
                    </ul>
                </li>

                <li class="">
                    <a href="#">
                        <i class="fa fa-gift"></i>
                        <span class="title">Support</span>
                        <span class="arrow "></span><span class="label label-orange blink_me">NEW</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <?php echo "<li><a href=" . base_url() . "admin/faq> <span class='fa fa-question'></span> FAQ </a></li>"; ?>
                        </li>

                    </ul>
                </li>
                <!--<li class="">
                    <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span class="title">Mailbox</span>
                        <span class="arrow "></span><span class="label label-orange">4</span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a class="" href="mail-inbox.html">Inbox</a>
                        </li>
                        <li>
                            <a class="" href="mail-compose.html">Compose</a>
                        </li>
                        <li>
                            <a class="" href="mail-view.html">View</a>
                        </li>
                    </ul>
                </li>-->
            </ul>
            <!-- SIDE MENU - END -->

        </div>
        <!-- MAIN MENU - END -->


        <!-- MINI CHAART-->
        <!--<div class="project-info" id="mini_chart">
            <div class="block1">
                <div class="data">
                    <span class='title'>New&nbsp;Orders</span>
                    <span class='total'>2,345</span>
                </div>
                <div class="graph">
                    <span class="sidebar_orders">...</span>
                </div>
            </div>

            <div class="block2">
                <div class="data">
                    <span class='title'>Visitors</span>
                    <span class='total'>345</span>
                </div>
                <div class="graph">
                    <span class="sidebar_visitors">...</span>
                </div>
            </div>

        </div>-->
        <!-- END MINI CHART-->

    </div>
    <!--  SIDEBAR - END -->
