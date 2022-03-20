<!DOCTYPE html>
<html lang="en">
<body>
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE SIDEBAR -->
    <div class="page-sidebar">
        <!-- START X-NAVIGATION -->
        <ul class="x-navigation x-navigation-hover">  <!-- added x-navigation-hover for mouse over-->
            <li class="xn-logo">
                <a href="#">ATLANT </a>
                <a href="#" class="x-navigation-control"></a>
            </li>
            <li class="xn-profile">
                <a href="#" class="profile-mini">
                    <img src="<?= base_url(); ?>uploads/userimg/<?= $_SESSION['uimg']; ?>"
                         alt="<?= $_SESSION['fname']; ?>"/>
                </a>
                <div class="profile">
                    <div class="profile-image">
                        <!--<img src="<? /*= base_url(); */ ?>assets/images/users/1.jpg" alt="John Doe"/>-->
                        <img src="<?= base_url(); ?>uploads/userimg/<?= $_SESSION['uimg']; ?>"
                             alt="<?= $_SESSION['fname']; ?>"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name"><?php
                            if (!empty($_SESSION['userId'])) {
                                echo $_SESSION['fname'] . " " . $_SESSION['lname'];
                            }
                            ?> </div>
                        <div class="profile-data-title"><?php echo $_SESSION['roleText']; ?></div>
                    </div>
                    <div class="profile-controls">
                        <a href="<?= base_url() ?>welcome/profile" class="profile-control-right1"><span
                                    class="fa fa-info"></span></a>
                        <a href="" class="profile-control-right"><span class="fa fa-envelope"></span></a>
                    </div>
                </div>
            </li>
            <li>
                <a href="<?= base_url(); ?>Admin"><span class="fa fa-dashboard"></span> <span
                            class="xn-text">Dashboard</span></a>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-globe"></span> <span class="xn-text">Genaral</span></a>
                <ul>
                    <?php if (in_array("brand", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/brand> <span class='fa fa-sliders'></span>  Branding </a></li>";
                    } ?>
                    <?php if (in_array("policy", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/policy> <span class='fa fa-list-alt'></span> Policy Management </a></li>";
                    } ?>
                    <?php if (in_array("recn_actv", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/recn_actv> <span class='fa fa-sliders'></span> Recent Activity </a></li>";
                    } ?>
                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-cogs"></span> <span class="xn-text">System Setting</span></a>
                <ul>
                    <?php if (in_array("branch", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/branch> <span class='fa fa-columns'></span> Branch Management </a></li>";
                    } ?>
                    <?php if (in_array("product", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/product> <span class='fa fa-columns'></span> Product Management </a></li>";
                    } ?>
                    <?php if (in_array("userMng", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/userMng> <span class='fa fa-users'></span> User Management </a></li>";
                    } ?>

                    <?php if (in_array("userLvl", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/userLvl> <span class='fa fa-sitemap'></span> User Level </a></li>";
                    } ?>
                    <?php if (in_array("relation", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/relation> <span class='fa fa-sitemap'></span> Relationship Master </a></li>";
                    } ?>
                    <?php if (in_array("eduction", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/eduction> <span class='fa fa-sitemap'></span> Customer Education </a></li>";
                    } ?>

                    <?php if (in_array("gift_stck", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/gift_stck> <span class='fa fa-gift'></span> Promotion Stock Management</a></li>";
                    } ?>


                    <!-- <li><a href="<? /*= base_url() */ ?>Admin/"><span class="fa fa-user"></span> Title Master</a></li>
                    <li><a href="<? /*= base_url() */ ?>Admin/"><span class="fa fa-male"></span> Gender Master</a></li>
                    <li><a href="<? /*= base_url() */ ?>Admin/"><span class="fa fa-mars-double"></span> Civil Statues</a></li>-->


                    <!--<li class="xn-openable">
                        <a href="#"><span class="fa fa-briefcase"></span> Business Master</a>
                        <ul>
                            <li><a href="<? /*= base_url() */ ?>Admin/"><span class="fa fa-building"></span> Major Sectors</a>
                            </li>
                            <li><a href="<? /*= base_url() */ ?>Admin/"><span class="fa fa-building-o"></span> Sub Sector</a>
                            </li>
                        </ul>
                    </li>-->
                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-columns"></span> <span class="xn-text">Advance Setting</span></a>
                <ul>
                    <?php if (in_array("permis", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/permis> <span class='fa fa-columns'></span> Permission Management </a></li>";
                    } ?>
                    <?php if (in_array("target", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/target> <span class='fa fa-line-chart'></span> Target Management </a></li>";
                    } ?>
                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-sliders"></span> <span class="xn-text">System Holidays</span></a>
                <ul>
                    <?php if (in_array("sysholy", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/sysholy> <span class='fa fa-calendar'></span> System Schedule </a></li>";
                    } ?>
                    <?php if (in_array("brnc_shdu", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/brnc_shdu> <span class='fa fa-calendar'></span> Branch Schedule </a></li>";
                    } ?>
                    <?php if (in_array("loan_shdu", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/loan_shdu> <span class='fa fa-calendar'></span> Loan Schedule </a></li>";
                    } ?>


                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-book"></span><span class="xn-text"> Account Master </span></a>
                <ul>
                    <?php if (in_array("chrt_acc", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/chrt_acc> <span class='fa fa-credit-card-alt'></span> Chart Of Account</a></li>";
                    } ?>
                    <?php if (in_array("bank_acc", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/bank_acc> <span class='fa fa-university'></span> Bank Account</a></li>";
                    } ?>
                    <!-- --><?php /*if (in_array("cheq_book", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/cheq_book> <span class='fa fa-money'></span> Cheque Book</a></li>";
                    } */ ?>


                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-book"></span> <span class="xn-text">Report Master</span></a>
                <ul>
                    <?php if (in_array("rprt_gl", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Report/rprt_gl> <span class='fa fa-book'></span> General Ledger</a></li>";
                    } ?>
                    <?php if (in_array("bal_sheet", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Report/bal_sheet> <span class='fa fa-book'></span> Balance Sheet</a></li>";
                    } ?>
                    <?php if (in_array("rprt_pnl", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Report/rprt_pnl> <span class='fa fa-book'></span> Profit & Loss</a></li>";
                    } ?>
                    <?php if (in_array("rprt_tb", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Report/rprt_tb> <span class='fa fa-book'></span> Trail Balance</a></li>";
                    } ?>
                </ul>
            </li>

            <li class="xn-openable">
                <a href="#"><span class="fa fa-book"></span> <span class="xn-text">Investment Module</span></a>
                <ul>
                    <?php if (in_array("invstor", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/invstor> <span class='fa fa-book'></span> Investor Management</a></li>";
                    } ?>
                    <?php if (in_array("invest", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/invest> <span class='fa fa-book'></span> Investment </a></li>";
                    } ?>
                    <?php if (in_array("invst_pymt", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "Admin/invst_pymt> <span class='fa fa-book'></span> Invest Payment</a></li>";
                    } ?>

                </ul>
            </li>


            <li class="xn-openable">
                <a href="#"><span class="fa fa-thumbs-o-up"></span> <span class="xn-text">System Support </span></a>
                <ul>
                    <?php if (in_array("loan_clcu", $permission, TRUE)) {
                        echo "<li><a href=" . base_url() . "uploads/gdcsupporting/amortise.php target='_blank'> <span class='fa fa-calculator'></span> Loan Calculator </a></li>";
                    } ?>

                    <!--<li><a href="<? /*= base_url() */ ?>uploads/gdcsupporting/amortise.php" target="_blank"><span class="fa fa-calculator"></span> Loan Calculator </a>
                    </li>-->
                </ul>
            </li>

        </ul>
        <!-- END X-NAVIGATION -->
    </div>
    <!-- END PAGE SIDEBAR -->

    <!--
   ***************************************************
   ******************* END PAGE SIDEBAR **************
   ***************************************************
   -->

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <!-- START X-NAVIGATION VERTICAL -->
        <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
            <!-- TOGGLE NAVIGATION -->
            <li class="xn-icon-button">
                <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
            </li>
            <!-- END TOGGLE NAVIGATION -->
            <!-- ONLINE -->
            <li class="xn-icon-button2"><a id="chk_cnntion" title="Network status:"> </a></li>
            <li class="xn-icon-button1">
                <a>LK Time : <span id="timecontainer2"></span>
                    <span id="Hour"></span>
                    <span id="Minut"></span>
                    <span id="Second"></span>
                    <span id="am"><?= date("A") . ' ' . date("(D)") ?></span>
                </a>

                <!--                <script type="text/javascript">new showLocalTime("timecontainer2", "server-php", 330, "short")</script>-->
            </li>
            <!-- ONLINE -->
            <!-- NIC SEARCH -->
            <li class="xn-search">
                <form role="form" method="post">
                    <input type="text" name="sid" id="sid" placeholder="Search..." autocomplete="off"/>
                </form>
            </li>
            <!-- END NIC SEARCH -->
            <!-- POWER OFF -->
            <li class="xn-icon-button pull-right last">
                <a href="#"><span class="fa fa-power-off"></span></a>
                <ul class="xn-drop-left animated zoomIn">
                    <?php if ($_SESSION['role'] == 1 || $_SESSION['role'] == 2) { ?>
                        <li><a href="<?= base_url() ?>user"><span class="fa fa-user"></span> User </a></li>
                        <?php
                    }
                    ?>

                    <li><a href="<?= base_url() ?>welcome/lockscrn"><span class="fa fa-lock"></span> Lock Screen</a>
                    </li>
                    <li><a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Sign
                            Out</a></li>
                </ul>
            </li>
            <!-- END POWER OFF -->
            <!-- MESSAGES -->
            <li class="xn-icon-button pull-right">
                <a href="#"><span class="fa fa-comments"></span></a>
                <!-- <div class="informer informer-danger">4</div>-->
                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-comments"></span> Messages</h3>
                        <div class="pull-right">
                            <span class="label label-danger">4 new</span>
                        </div>
                    </div>
                    <div class="panel-body list-group list-group-contacts scroll" style="height: auto;">
                        <a href="#" class="list-group-item">
                            <div class="list-group-status status-online"></div>
                            <img src="" class="pull-left" alt="John Doe"/>
                            <span class="contacts-title">John Doe</span>
                            <p>Praesent placerat tellus id augue condimentum</p>
                        </a>

                    </div>
                    <div class="panel-footer text-center">
                        <a href="pages-messages.html">Show all messages</a>
                    </div>
                </div>
            </li>
            <!-- END MESSAGES -->
            <!-- TASKS -->
            <li class="xn-icon-button pull-right">
                <a href="#"><span class="fa fa-tasks"></span></a>
                <!-- <div class="informer informer-warning">3</div>-->
                <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                    <div class="panel-heading">
                        <h3 class="panel-title"><span class="fa fa-tasks"></span> Tasks</h3>
                        <div class="pull-right">
                            <span class="label label-warning">3 active</span>
                        </div>
                    </div>
                    <div class="panel-body list-group scroll" style="height: auto;">
                        <a class="list-group-item" href="#">
                            <strong>Phasellus augue arcu, elementum</strong>
                            <div class="progress progress-small progress-striped active">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                     aria-valuemin="0" aria-valuemax="100" style="width: 50%;">50%
                                </div>
                            </div>
                            <small class="text-muted">John Doe, 25 Sep 2017 / 50%</small>
                        </a>
                    </div>
                    <div class="panel-footer text-center">
                        <a href="pages-tasks.html">Show all tasks</a>
                    </div>
                </div>
            </li>
            <!-- END TASKS -->
            <!-- ERRORS -->
            <?php
            $this->load->model('Generic_model'); // load model
            $error = $this->Generic_model->getData('err_log', '', array('stat' => 0));

            if ($_SESSION['role'] == 1 && sizeof($error) > 0) { ?>
                <li class="xn-icon-button pull-right">
                    <a href="#"><span class="fa fa-warning"></span></a>
                    <div class="informer informer-warning"> <?= sizeof($error); ?> </div>
                    <div class="panel panel-primary animated zoomIn xn-drop-left xn-panel-dragging">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Error Log Have <label
                                        class="label label-danger"><?= sizeof($error); ?></label> Errors..
                                Please Resolve It..</h3>
                        </div>
                    </div>
                </li>
            <?php } ?>
            <!-- END ERRORS -->
            <!-- LANG BAR -->
            <li class="xn-icon-button pull-right">
                <a href="#"><span class="flag flag-lk"></span></a>
            </li>
            <!-- END LANG BAR -->
        </ul>
        <!-- END X-NAVIGATION VERTICAL -->