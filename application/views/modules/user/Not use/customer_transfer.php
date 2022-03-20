<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>-->
<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Customer Module</li>
    <li>Customer Transfer</li>
    <li class="active">Center Transfer</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Center Transfer </strong></h3>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch_cst" id="brch_cst"
                                            onchange="getExe(this.value,'exc_cust',exc_cust.value,'cen_cust');chckBtn(this.value,'brch_cst')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            if ($branch['brch_id'] != 'all') {
                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <!--   <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <?php
                            foreach ($stainfo as $stat) {
                                echo "<option value='$stat->stid'>$stat->stnm</option>";
                            }
                            ?>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc_cust" id="exc_cust"
                                            onchange="getCenter(this.value,'cen_cust',brch_cst.value)">
                                        <?php
                                        foreach ($execinfo as $exe) {
                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cen_cust" id="cen_cust">
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchCustmer()"
                                            class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbCustList" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">CUST ID</th>
                                            <th class="text-center">NAME</th>
                                            <th class="text-center">NIC</th>
                                            <th class="text-center">MOBILE</th>
                                            <th class="text-center">ADDRESS</th>
                                            <th class="text-center">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Customer Details : <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!--                        <div class="panel panel-default">-->
                        <div class="panel-body">
                            <div class="col-md-12">
                                <!-- START TABS -->
                                <div class="panel panel-default tabs">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Location</a>
                                        </li>
                                        <li><a href="#tab2" role="tab" data-toggle="tab">General</a></li>
                                        <li id="tb3"><a href="#tab3" id="ttb3" role="tab"> Family</a></li>
                                        <li id="tb4"><a href="#tab4" id="ttb4" role="tab"> Business</a></li>
                                        <li id="tb5"><a href="#tab5" id="ttb5" role="tab">Family Assess.</a>
                                        </li>
                                        <li id="tb6"><a href="#tab6" id="ttb6" role="tab">Summery</a></li>
                                        <li id="tb7"><a href="#tab7" id="ttb7" role="tab">Document</a></li>
                                    </ul>
                                    <div class="panel-body tab-content">
                                        <div class="tab-pane active" id="tab1">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4  col-xs-6 control-label">Branch</label>
                                                        <label class="control-label"
                                                               id="vew_brnc"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Executive</label>
                                                        <label class="control-label"
                                                               id="vew_exc"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Center</label>

                                                        <label class="control-label"
                                                               id="vew_cnt"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Group</label>

                                                        <label class="control-label"
                                                               id="vew_grup"></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 col-xs-6 control-label">GPS
                                                            Longitude</label>
                                                        <label class="control-label"
                                                               id="vew_lng">aaaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">GPS Latitude</label>
                                                        <label class="control-label"
                                                               id="vew_ltu"></label>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4  col-xs-6 control-label">Full
                                                            Name</label>
                                                        <label class="control-label"
                                                               id="vew_funm">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Initial Name</label>
                                                        <label class="control-label"
                                                               id="vew_innm">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Address</label>
                                                        <label class="control-label"
                                                               id="vew_adrs">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Nic</label>
                                                        <label class="control-label"
                                                               id="vew_nic">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Date of Birth </label>
                                                        <label class="control-label"
                                                               id="vew_dob">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 col-xs-6 control-label">Gender</label>
                                                        <label class="control-label"
                                                               id="vew_gnd">aaaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  col-xs-6 control-label">User
                                                            Profile</label>
                                                        <div class="kv-avatar center-block text-center"
                                                             style="width:200px">
                                                            <div class="cropping-preview-wrap">
                                                                <div class="cropping-preview">
                                                                    <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                         id="img1"
                                                                         style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">

                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Mobile</label>
                                                        <label class="control-label"
                                                               id="vew_tel">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Eduction</label>
                                                        <label class="control-label"
                                                               id="vew_edu">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Civil Statues</label>
                                                        <label class="control-label"
                                                               id="vew_cvl">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">GS ward</label>
                                                        <label class="control-label"
                                                               id="vew_gs">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">SMS Sending</label>
                                                        <label class="control-label"
                                                               id="vew_sms">aa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5  col-xs-6 control-label">Spouse
                                                            Name</label>
                                                        <label class="control-label"
                                                               id="vew_spnm">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Spouse NIC</label>
                                                        <label class="control-label"
                                                               id="vew_spid">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Occupation</label>
                                                        <label class="control-label"
                                                               id="vew_socc">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5 col-xs-6 control-label">Applicant
                                                            Relationship</label>
                                                        <label class="control-label"
                                                               id="vew_aprl">aaaaa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5 control-label">Family Member</label>
                                                        <label class="control-label"
                                                               id="vew_fmmb">cc</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Moveble Property</label>
                                                        <label class="control-label"
                                                               id="vew_mvpr">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Immovebale
                                                            Property</label>
                                                        <label class="control-label"
                                                               id="vew_impr">aaaa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5  col-xs-6 control-label">Business</label>
                                                        <label class="control-label"
                                                               id="vew_bus">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Business Address</label>
                                                        <label class="control-label"
                                                               id="vew_buad">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Registration No</label>
                                                        <label class="control-label"
                                                               id="vew_bsrg">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Duration</label>
                                                        <label class="control-label"
                                                               id="vew_bsdu">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Business Place</label>
                                                        <label class="control-label"
                                                               id="vew_bspl">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Business
                                                            Telephone</label>
                                                        <label class="control-label"
                                                               id="vew_bstp">aaaa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 col-xs-6 control-label">Business
                                                            Income</label>
                                                        <label class="control-label"
                                                               id="vew_bsic">aaaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Other Income</label>
                                                        <label class="control-label"
                                                               id="vew_otic">vv</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Total Income</label>
                                                        <label class="control-label"
                                                               id="vew_ttic">vv</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Direct Income</label>
                                                        <label class="control-label"
                                                               id="vew_diic">vv</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Other Income</label>
                                                        <label class="control-label"
                                                               id="vew_dioi">vv</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Total Income</label>
                                                        <label class="control-label"
                                                               id="vew_ttoi">vv</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab5">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4  col-xs-6 control-label">Spouse
                                                            Income</label>
                                                        <label class="control-label"
                                                               id="vew_spin">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Other Income</label>
                                                        <label class="control-label"
                                                               id="vew_osin">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Total Income</label>
                                                        <label class="control-label"
                                                               id="vew_ttis">aaaa</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5  col-xs-6 control-label">Food</label>
                                                        <label class="control-label"
                                                               id="vew_food">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Cloth</label>
                                                        <label class="control-label"
                                                               id="vew_clth">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Water</label>
                                                        <label class="control-label"
                                                               id="vew_wate">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Electricity</label>
                                                        <label class="control-label"
                                                               id="vew_elec">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Medicine</label>
                                                        <label class="control-label"
                                                               id="vew_medc">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Education</label>
                                                        <label class="control-label"
                                                               id="vew_educ">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Transport</label>
                                                        <label class="control-label"
                                                               id="vew_tran">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Others</label>
                                                        <label class="control-label"
                                                               id="vew_otex">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Total Expenses</label>
                                                        <label class="control-label"
                                                               id="vew_ttex">aaaa</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-md-6  col-xs-6 control-label">Loan
                                                            Instalment</label>
                                                        <label class="control-label"
                                                               id="vew_lnin">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6  control-label">Other Loans</label>
                                                        <label class="control-label"
                                                               id="vew_otln">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6  control-label">Insurance
                                                            Instalment</label>
                                                        <label class="control-label"
                                                               id="vew_inis">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-6  control-label">NET Cash In Hand</label>
                                                        <label class="control-label"
                                                               id="vew_ncih">aaaa</label>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab7">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">NIC Copy</label>
                                                        <div class="kv-avatar center-block text-center"
                                                             style="width:200px">
                                                            <div class="cropping-preview-wrap">
                                                                <div class="cropping-preview">
                                                                    <img src="<?= base_url() ?>uploads/document-default.png"
                                                                         id="img2"
                                                                         style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">GS Certificate</label>
                                                        <div class="kv-avatar center-block text-center"
                                                             style="width:200px">
                                                            <div class="cropping-preview-wrap">
                                                                <div class="cropping-preview">
                                                                    <img src="<?= base_url() ?>uploads/document-default.png"
                                                                         id="img3"
                                                                         style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4 col-xs-6 control-label">Bus.
                                                            Location</label>
                                                        <div class="kv-avatar center-block text-center"
                                                             style="width:200px">
                                                            <div class="cropping-preview-wrap">
                                                                <div class="cropping-preview">
                                                                    <img src="<?= base_url() ?>uploads/document-default.png"
                                                                         id="img4"
                                                                         style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Other</label>
                                                        <div class="kv-avatar center-block text-center"
                                                             style="width:200px">
                                                            <div class="cropping-preview-wrap">
                                                                <div class="cropping-preview">
                                                                    <img src="<?= base_url() ?>uploads/document-default.png"
                                                                         id="img5"
                                                                         style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END TABS -->
                            </div>
                        </div>
                        <!--                        </div>-->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Customer transfer model -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:80%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"> Current Customer : <span id="hed"> </span> <span
                            id="cuno"> </span></h4>
            </div>
            <form class="form-horizontal" id="cust_trnsf" name="cust_trnsf" action=" " method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default tabs">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#tab-1" role="tab" data-toggle="tab"
                                                          onclick="shwhide('1')">Details</a></li>
                                    <li><a href="#tab-2" role="tab" data-toggle="tab"
                                           onclick="shwhide('2')">History </a></li>
                                </ul>

                                <div class="panel-body tab-content">
                                    <div class="tab-pane active" id="tab-1">
                                        <div class="panel-body">
                                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Current Customer
                                                Details
                                            </h3>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Full Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label" id="funm_trns">Full
                                                        Name</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">NIC</label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="nic_trns">NIC</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Officer</label>
                                                    <label class="col-md-8-xs-12 control-label" id="exe_trns">Customer
                                                        No</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Group No</label>
                                                    <label class="col-md-8-xs-12 control-label" id="grp_trns">Customer
                                                        No</label>
                                                </div>
                                            </div>

                                            <input type="hidden" name="cur_exe" id="cur_exe">
                                            <input type="hidden" name="cur_cnt" id="cur_cnt">
                                            <input type="hidden" name="cur_grp" id="cur_grp">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label"> Address</label>
                                                    <label class="col-md-8 col-xs-12 control-label" id="hoad_trns">
                                                        Address</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Customer No</label>
                                                    <label class="col-md-8-xs-12 control-label" id="cuno_trns">Customer
                                                        No</label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Center</label>
                                                    <label class="col-md-8-xs-12 control-label" id="cnt_trns">Customer
                                                        No</label>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="panel-body">
                                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Transferring
                                                Location
                                            </h3>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                                    <div class="col-md-8 col-xs-12">
                                                        <select class="form-control" name="brch_trnsf" id="brch_trnsf"
                                                                onchange="getExe(this.value,'exc_trnsf',exc_trnsf.value,'cen_trnsf');chckBtn(this.value,'brch_trnsf')">
                                                            <?php
                                                            foreach ($branchinfo as $branch) {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-6 control-label">Officer</label>
                                                    <div class="col-md-8 col-xs-6">
                                                        <select class="form-control" name="exc_trnsf" id="exc_trnsf"
                                                                onchange="getCenter(this.value,'cen_trnsf',brch_trnsf.value);getGrup(this.value,'edtcust',brch_trnsf.value,exc_trnsf.value,'all')">
                                                            <?php
                                                            foreach ($execinfo as $exe) {
                                                                echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-6 control-label">Center</label>
                                                    <div class="col-md-8 col-xs-6">
                                                        <select class="form-control" name="cen_trnsf" id="cen_trnsf"
                                                                onchange="getGrup(this.value,'grup_trnsf',brch_trnsf.value,exc_trnsf.value,cen_trnsf.value)">
                                                            <?php
                                                            foreach ($centinfo as $cen) {
                                                                echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-6 control-label">Group</label>
                                                    <div class="col-md-8 col-xs-6">
                                                        <select class="form-control" name="grup_trnsf" id="grup_trnsf">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label">Remark</label>
                                                    <div class="col-md-8 ">
                                                    <textarea class="form-control" rows="4" id="trrs"
                                                              name="trrs" placeholder="Transfer Reason"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab-2">

                                        <div class="table-responsive">
                                            <table class="table table-bordered  table-actions" id="trsfTb" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Customer No</th>
                                                    <th class="text-center">Branch</th>
                                                    <th class="text-center">Officer</th>
                                                    <th class="text-center">Center</th>
                                                    <th class="text-center">Group</th>
                                                    <th class="text-center">From</th>
                                                    <th class="text-center">To</th>
                                                    <th class="text-center">Duration</th>
                                                    <th class="text-center">Transfer by</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                    <input type="hidden" id="auid" name="auid"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="subBtn"> Transfer</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Customer transfer model -->


</body>

<script>
    $().ready(function () {

        // Data Tables
        $('#dataTbCustList').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $('#trsfTb').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });


        //srchCustmer();

        $("#cust_trnsf").validate({  // center add form validation
            rules: {
                brch_trnsf: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                exc_trnsf: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                cen_trnsf: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                grup_trnsf: {
                    required: true,
                    notEqual: 'all',
                    min: 1,
                    remote: {
                        url: "<?= base_url(); ?>user/grup_memb_count",
                        type: "post",
                        data: {
                            grid: function () {
                                return $("#grup_trnsf").val();
                            }
                        }
                    }
                },
            },
            messages: {
                brch_trnsf: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                exc_trnsf: {
                    required: 'Please enter Officer',
                    notEqual: "Please select Officer",
                    min: "Please select Officer"
                },
                cen_trnsf: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                grup_trnsf: {
                    required: 'Please Enter Group',
                    notEqual: "Please select Group",
                    min: "Please select Group",
                    remote: "Member Limit Executing",
                },
            }
        });
    });


    function chckBtn(id, inpu) {
        //console.log(inpu);
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function shwhide(a) {
        if (a == 1) {
            //  document.getElementById("subBtn").removeAttribute("class");
            document.getElementById("subBtn").setAttribute("class", "btn btn-success");
        } else {
            // document.getElementById("subBtn").removeAttribute("class");
            document.getElementById("subBtn").setAttribute("class", "hidden");
        }
    }

    function srchCustmer() {                                                       // Search btn
        var brn = document.getElementById('brch_cst').value;
        var exc = document.getElementById('exc_cust').value;
        var cen = document.getElementById('cen_cust').value;
        //var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch_cst').style.borderColor = "red";
        } else {
            document.getElementById('brch_cst').style.borderColor = "";

            $('#dataTbCustList').DataTable().clear();
            $('#dataTbCustList').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 4, 5, 7]},
                    {className: "text-center", "targets": [0, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "ASC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},     // exe
                    {sWidth: '10%'},     // cnt
                    {sWidth: '10%'},      // cus id
                    {sWidth: '10%'},     // name
                    {sWidth: '5%'},      // nic
                    {sWidth: '5%'},      // mobile
                    {sWidth: '25%'},     // address
                    {sWidth: '8%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/customer_list',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen
                    }
                }
            });
        }
    }

    function transferCust(auid, typ) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewCustmer",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("funm_trns").innerHTML = response[i]['funm'];
                    document.getElementById("nic_trns").innerHTML = response[i]['anic'];
                    document.getElementById("hoad_trns").innerHTML = response[i]['hoad'];
                    document.getElementById("cuno_trns").innerHTML = response[i]['cuno'];

                    document.getElementById("exe_trns").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];
                    document.getElementById("cnt_trns").innerHTML = response[i]['cnnm'];
                    document.getElementById("grp_trns").innerHTML = response[i]['grnm'];

                    document.getElementById("cur_exe").value = response[i]['exec'];
                    document.getElementById("cur_cnt").value = response[i]['ccnt'];
                    document.getElementById("cur_grp").value = response[i]['grno'];


                    $('#cuno').text(response[i]['cuno']);
                    document.getElementById("auid").value = response[i]['cuauid'];
                }
            }
        });

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/CusttrzfHis",
            data: {
                cuid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                $('#trsfTb').DataTable().clear();
                var t = $('#trsfTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1, 2, 3]},
                        {className: "text-center", "targets": [0, 4, 5, 6]},
                        {className: "text-right", "targets": [0, 7]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '15%'},    // br
                        {sWidth: '15%'},
                        {sWidth: '15%'},    // cnt
                        {sWidth: '5%'},     //
                        {sWidth: '10%'},     // frdt
                        {sWidth: '10%'},     // todt
                        {sWidth: '10%'},     // todt
                        {sWidth: '15%'}
                    ],
                    "rowCallback": function (row, data, index) {
                        var curnt = data[7],
                            $node = this.api().row(row).nodes().to$();
                        if (curnt == '-') {
                            $node.addClass('info')
                        }
                    }
                });

                for (var i = 0; i < len; i++) {
                    var a = moment(response[i]['frdt'], 'YYYY/MM/DD');
                    var b = moment(response[i]['todt'], 'YYYY/MM/DD');
                    var days = b.diff(a, 'd');

                    if (days < 0) { //|| days == 0
                        var dur = "-";
                    } else {
                        var dur = days + " Days";
                    }

                    t.row.add([
                        response[i]['cuno'],
                        response[i]['brnm'],
                        response[i]['fnme'],
                        response[i]['cnnm'],
                        response[i]['grno'],
                        response[i]['frdt'],
                        response[i]['todt'],
                        dur,
                        // response[i]['todt'],
                        response[i]['trus']
                    ]).draw(false);
                }
            }
        })
    }

    $("#cust_trnsf").submit(function (e) { // add form
        e.preventDefault();

        var c_ex = document.getElementById("cur_exe").value;
        var c_cn = document.getElementById("cur_cnt").value;
        var c_gp = document.getElementById("cur_grp").value;

        var n_ex = document.getElementById("exc_trnsf").value;
        var n_cn = document.getElementById("cen_trnsf").value;
        var n_gp = document.getElementById("grup_trnsf").value;

        var auid = document.getElementById("auid").value;

        if ($("#cust_trnsf").valid()) {

            if (c_ex === n_ex && c_cn === n_cn && c_gp === n_gp) {
                swal({title: "", text: "Same transfer details", type: "warning"})
            } else {

                $.ajax({
                    url: '<?= base_url(); ?>user/getCustRnloan',
                    type: 'POST',
                    data: {
                        auid: auid
                    },
                    dataType: 'json',
                    success: function (data) {

                        if ((data > 0 && c_ex === n_ex && c_cn !== n_cn) || (data > 0 && c_ex !== n_ex && c_cn === n_cn) || (data > 0 && c_ex !== n_ex && c_cn !== n_cn) ) {
                            swal({title: "", text: "Customer Have Approved Or Running Loan", type: "warning"})
                        } else {

                            swal({
                                    title: "Are you sure Transfer This Customer ?",
                                    text: "",
                                    type: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3bdd59",
                                    confirmButtonText: "Yes",
                                    cancelButtonText: "No",
                                    closeOnConfirm: false,
                                    closeOnCancel: false
                                },
                                function (isConfirm) {
                                    if (isConfirm) {
                                        $('#modalEdt').modal('hide');

                                        $.ajax({
                                            url: '<?= base_url(); ?>user/customer_transfer',
                                            type: 'POST',
                                            data: $("#cust_trnsf").serialize(),
                                            dataType: 'json',
                                            success: function (data) {
                                                srchCustmer();
                                                swal({title: "", text: "Customer Transfer Success!", type: "success"},
                                                    function () {
                                                        //  location.reload();
                                                    }
                                                );
                                            },
                                            error: function () {
                                                swal("Failed!", "Customer Transfer", "error");
                                                window.setTimeout(function () {
                                                    // location = '<?= base_url(); ?>user/cust_trnsf';
                                                }, 2000);
                                            }
                                        });
                                    } else {
                                        swal("Cancelled", " ", "error");
                                    }
                                });
                        }
                    },
                });

            }
        } else {
            //  alert("Error");
        }
    });

    function viewCust(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewCustmer",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    if (response[i]['cuty'] == 1) {
                        document.getElementById("custyp").innerHTML = " <span class='label label-success'>  Normal  </span>";

                        $('#tb3').attr('class', 'disabled');
                        $('#tb4').attr('class', 'disabled');
                        $('#tb5').attr('class', 'disabled');
                        $('#tb6').attr('class', 'disabled');
                        $('#tb7').attr('class', 'disabled');

                        document.getElementById('ttb3').setAttribute('data-toggle', '');
                        document.getElementById('ttb4').setAttribute('data-toggle', '');
                        document.getElementById('ttb5').setAttribute('data-toggle', '');
                        document.getElementById('ttb6').setAttribute('data-toggle', '');
                        document.getElementById('ttb7').setAttribute('data-toggle', '');

                    } else {
                        document.getElementById("custyp").innerHTML = " <span class='label label-success'> Advance   </span>";

                        $('#tb3').attr('class', '');
                        $('#tb4').attr('class', ' ');
                        $('#tb5').attr('class', ' ');
                        $('#tb6').attr('class', ' ');
                        $('#tb7').attr('class', ' ');

                        document.getElementById('ttb3').setAttribute('data-toggle', 'tab');
                        document.getElementById('ttb4').setAttribute('data-toggle', 'tab');
                        document.getElementById('ttb5').setAttribute('data-toggle', 'tab');
                        document.getElementById('ttb6').setAttribute('data-toggle', 'tab');
                        document.getElementById('ttb7').setAttribute('data-toggle', 'tab');
                    }
                    document.getElementById("cno").innerHTML = response[i]['cuno'];

                    document.getElementById("vew_brnc").innerHTML = response[i]['brnm'];
                    document.getElementById("vew_exc").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];
                    document.getElementById("vew_cnt").innerHTML = response[i]['cnnm'];
                    document.getElementById("vew_grup").innerHTML = response[i]['grnm'];
                    document.getElementById("vew_lng").innerHTML = response[i]['gplg'];
                    document.getElementById("vew_ltu").innerHTML = response[i]['gplt'];


                    document.getElementById("vew_funm").innerHTML = response[i]['funm'];
                    document.getElementById("vew_innm").innerHTML = response[i]['init'];
                    document.getElementById("vew_adrs").innerHTML = response[i]['hoad'];
                    document.getElementById("vew_nic").innerHTML = response[i]['anic'];
                    document.getElementById("vew_dob").innerHTML = response[i]['dobi'];
                    document.getElementById("vew_gnd").innerHTML = response[i]['gndt']; // gender
                    document.getElementById("vew_tel").innerHTML = response[i]['mobi'];
                    document.getElementById("vew_edu").innerHTML = response[i]['eddt']; //
                    document.getElementById("vew_cvl").innerHTML = response[i]['cvdt'];
                    document.getElementById("vew_gs").innerHTML = response[i]['gsaw'];
                    if (response[i]['smst'] == 1) {
                        document.getElementById("vew_sms").innerHTML = " <span class='label label-success'>  YES  </span>";
                    } else {
                        document.getElementById("vew_sms").innerHTML = " <span class='label label-warning'>  NO  </span>";
                    }

                    document.getElementById("vew_spnm").innerHTML = response[i]['sunm'];
                    document.getElementById("vew_spid").innerHTML = response[i]['snic'];
                    document.getElementById("vew_socc").innerHTML = response[i]['occu'];
                    document.getElementById("vew_aprl").innerHTML = response[i]['redt'];
                    document.getElementById("vew_fmmb").innerHTML = response[i]['fmem'];
                    document.getElementById("vew_mvpr").innerHTML = response[i]['mopr'];
                    document.getElementById("vew_impr").innerHTML = response[i]['impr'];

                    document.getElementById("vew_bus").innerHTML = response[i]['buss'];
                    document.getElementById("vew_buad").innerHTML = response[i]['bsad'];
                    document.getElementById("vew_bsrg").innerHTML = response[i]['rgno'];
                    document.getElementById("vew_bsdu").innerHTML = response[i]['dura'];
                    document.getElementById("vew_bspl").innerHTML = response[i]['bupl'];
                    document.getElementById("vew_bstp").innerHTML = response[i]['butp'];
                    document.getElementById("vew_bsic").innerHTML = response[i]['bsin'];
                    document.getElementById("vew_otic").innerHTML = response[i]['obin'];
                    document.getElementById("vew_ttic").innerHTML = response[i]['ttib'];
                    document.getElementById("vew_diic").innerHTML = response[i]['diin'];
                    document.getElementById("vew_dioi").innerHTML = response[i]['odin'];
                    document.getElementById("vew_ttoi").innerHTML = response[i]['ttid'];

                    document.getElementById("vew_spin").innerHTML = response[i]['spin'];
                    document.getElementById("vew_osin").innerHTML = response[i]['osin'];
                    document.getElementById("vew_ttis").innerHTML = response[i]['ttis'];
                    document.getElementById("vew_food").innerHTML = response[i]['food'];
                    document.getElementById("vew_clth").innerHTML = response[i]['clth'];
                    document.getElementById("vew_wate").innerHTML = response[i]['wate'];
                    document.getElementById("vew_elec").innerHTML = response[i]['elec'];
                    document.getElementById("vew_medc").innerHTML = response[i]['medc'];
                    document.getElementById("vew_educ").innerHTML = response[i]['educ'];
                    document.getElementById("vew_tran").innerHTML = response[i]['tran'];
                    document.getElementById("vew_otex").innerHTML = response[i]['otex'];
                    document.getElementById("vew_ttex").innerHTML = response[i]['ttex']

                    document.getElementById("vew_lnin").innerHTML = response[i]['lnin'];
                    document.getElementById("vew_otln").innerHTML = response[i]['otln'];
                    document.getElementById("vew_inis").innerHTML = response[i]['inis'];
                    document.getElementById("vew_ncih").innerHTML = response[i]['ncih'];

                    document.getElementById("img1").src = "../uploads/cust_profile/" + response[i]['uimg'];
                    document.getElementById("img2").src = "../uploads/user_document/" + response[i]['img_nic'];
                    document.getElementById("img3").src = "../uploads/user_document/" + response[i]['img_gscr'];
                    document.getElementById("img4").src = "../uploads/user_document/" + response[i]['img_bslc'];
                    document.getElementById("img5").src = "../uploads/user_document/" + response[i]['img_othr'];

                }
            }
        })
    }


</script>












