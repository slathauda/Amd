<link href="<?php echo base_url(); ?>assets/dist/custom_css/fileinput.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/dist/js/fileinput.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/numeral-js.js" type="text/javascript"></script>

<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Customer Module</li>
    <li class="active">Customer Upgrade</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Customer Upgrade </strong></h3>
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
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status</label>
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
                            </div>
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
                                           id="dataTbCust" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">CUST ID</th>
                                            <th class="text-center">NAME</th>
                                            <th class="text-center">NIC</th>
                                            <th class="text-center">MOBILE</th>
                                            <th class="text-center">TYPe</th>
                                            <th class="text-center">STATUS</th>
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
    <div class="modal-dialog modal-lg" style="width: 80%">
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
                                                        <label class="col-md-4  control-label">Officer</label>
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
                                                        <label class="col-md-3 control-label">Full
                                                            Name</label>
                                                        <label class="control-label "
                                                               id="vew_funm">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3  control-label">Initial Name</label>
                                                        <label class="control-label"
                                                               id="vew_innm">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3  control-label">Address</label>
                                                        <label class="control-label"
                                                               id="vew_adrs">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3  control-label">NIC</label>
                                                        <label class="control-label"
                                                               id="vew_nic">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3  control-label">Date of Birth </label>
                                                        <label class="control-label"
                                                               id="vew_dob">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-6 control-label">Gender</label>
                                                        <label class="control-label"
                                                               id="vew_gnd">aaaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3  col-xs-6 control-label">Customer
                                                            Picture</label>
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

                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> Telephone </label>
                                                        <label class="control-label"
                                                               id="vew_tel">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label"> Mobile</label>
                                                        <label class="control-label"
                                                               id="vew_mob">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Eduction</label>
                                                        <label class="control-label"
                                                               id="vew_edu">aa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Civil Status</label>
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
                                                        <label class="control-label"><strong
                                                                    id="vew_ttic"></strong></label>
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
                                                        <label class="control-label"><strong
                                                                    id="vew_ttoi"></strong></label>
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

                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5  col-xs-6 control-label">Food</label>
                                                        <label class="control-label text-right"
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
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <hr>
                                                        <label class="col-md-4  control-label">Total Income</label>
                                                        <label class="control-label text-right"><strong
                                                                    id="vew_ttis"> </strong></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <hr>
                                                        <label class="col-md-5  control-label">Total Expenses</label>
                                                        <label class="control-label text-right"> <strong
                                                                    id="vew_ttex"> </strong></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane" id="tab6">
                                            <div class="row">
                                                <div class="col-md-9">
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
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <hr>
                                                        <label class="col-md-6  control-label">NET Cash In Hand</label>
                                                        <label class="control-label"><strong
                                                                    id="vew_ncih"></strong></label>
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


<!-- Advance Customer Edit / appr Model -->
<form id="form_edt1" name="form_edt1" class="form-horizontal" method="post" enctype="multipart/form-data">

    <div class="modal" id="advCust_edt1" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead">
                        <span class="fa fa-tag"> </span>
                        <span id="hed21"> </span> <span id="adv_cuno1"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li class="active"><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery</a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">

                        <div class="panel-body" style="height: auto">

                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Location Details
                            </h3>
                            <div id="form-step-0" role="form" data-toggle="validator">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="form-control" name="adv_brch_edt" id="adv_brch_edt"
                                                    onchange="getExe(this.value,'adv_exc_edt',adv_exc_edt.value,'adv_cen_edt');chckBtn(this.value,'adv_brch_edt')">
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
                                            <select class="form-control" name="adv_exc_edt" id="adv_exc_edt"
                                                    onchange="getCenter(this.value,'adv_cen_edt',adv_brch_edt.value);getGrup(this.value,'adv_grup_edt',adv_brch_edt.value,adv_exc_edt.value,'all')">
                                                <?php
                                                foreach ($execinfo as $exe) {
                                                    echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-6 control-label">Center</label>
                                        <div class="col-md-8 col-xs-6">
                                            <select class="form-control" name="adv_cen_edt" id="adv_cen_edt"
                                                    onchange="getGrup(this.value,'adv_grup_edt',adv_brch_edt.value,adv_exc_edt.value,adv_cen_edt.value)">
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
                                            <select class="form-control" name="adv_grup_edt" id="adv_grup_edt">
                                                <!--                                        <option value="0"> Select Group</option>-->
                                                <option value="all"> All Group</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">GPS Location</label>
                                        <div class="col-md-3">
                                            <button type="button" onclick="getLocation2_edt()" class="btn btn-info">
                                                Get
                                                Location
                                            </button>
                                        </div>
                                        <div class="col-md-3" style="top:3px;left: 10px;bottom: 3px">
                                            <span id="sts22_edt"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label"
                                               style="margin-left: ">Longitude</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control"
                                                   placeholder="GPS Longitude"
                                                   id="adv_gplg_edt" name="adv_gplg_edt"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Latitude</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" placeholder="GPS Latitude"
                                                   id="adv_gplt_edt" name="adv_gplt_edt"/>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="stat_advn" name="stat_advn" value="">
                                <input type="hidden" id="func_advn" name="func_advn"/>
                                <input type="hidden" id="auid_advn" name="auid_advn"/>

                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Customer Details
                                    </h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_titl_edt"
                                                        id="adv_titl_edt">
                                                    <option value="">Select Title</option>
                                                    <?php
                                                    foreach ($titlinfo as $tit) {
                                                        echo "<option value='$tit->soid'>$tit->sode</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Full Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Full Name" id="adv_funm_edt"
                                                       name="adv_funm_edt"
                                                       onkeyup="initnameAdv_edt(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Initial Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Initial with Name" id="adv_init_edt"
                                                       name="adv_init_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">NIC</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       id="adv_nic_edt"
                                                       name="adv_nic_edt" placeholder="NIC"
                                                       onchange="checkNicAdv_edt()" onkeyup="checkNicAdv_edt()"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_gend_edt"
                                                        id="adv_gend_edt">
                                                    <option value="">Select Gender</option>
                                                    <?php
                                                    foreach ($geninfo as $gen) {
                                                        echo "<option value='$gen->gnid'>$gen->gndt</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Customer Picture</label>

                                            <div class="col-md-8 col-xs-12">
                                                <div class="kv-avatar center-block text-center"
                                                     style="width:200px">
                                                    <input type="file" name="advPicEdt" id="avatar_33"
                                                           class="file-loading"/></div>

                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label"> Address</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Home Address"
                                                       id="adv_hoad_edt" name="adv_hoad_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Telephone</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control"
                                                       placeholder="Telephone" id="adv_tele_edt"
                                                       name="adv_tele_edt"/>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control" placeholder="Mobile"
                                                       id="adv_mobi_edt" name="adv_mobi_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Date Of
                                                Birth</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class=" form-control datepicker"
                                                       placeholder="Date Of Birth" id="adv_dobi_edt"
                                                       name="adv_dobi_edt"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Education</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_edun_edt"
                                                        id="adv_edun_edt">
                                                    <option value="">Select Option</option>
                                                    <?php
                                                    foreach ($eduinfo as $edu) {
                                                        echo "<option value='$edu->edid'>$edu->eddt</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Civil Status</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_cist_edt"
                                                        id="adv_cist_edt">
                                                    <option value="">Choose Option</option>
                                                    <?php
                                                    foreach ($cvlinfo as $cvl) {
                                                        echo "<option value='$cvl->cvid'>$cvl->cvdt</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">GS Ward</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="GS Ward"
                                                       id="adv_gsaw_edt" name="adv_gsaw_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">SMS Sending</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="adv_smst_edt" name="adv_smst_edt" type="checkbox"
                                                           value="1"
                                                           checked/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="panel-footer">
                            <!--                                <button type="button" class="btn btn-default" id="backStep2">Back</button>-->
                            <button type="button" class="btn btn-success pull-right" id="gotoStep2_edt">Go to step 2
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="advCust_edt2" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"> </span>
                        <span id="hed22"> </span> <span id="adv_cuno2"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li class="active"><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery</a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">

                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Family & Spouse
                                Details
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Spouse Name</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control text-uppercase"
                                               placeholder="Spouse Name" id="sunm_edt" name="sunm_edt"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Spouse NIC</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control text-uppercase" id="spnic_edt"
                                               name="spnic_edt" placeholder="NIC" onchange="checkNicSpc_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Family Member</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" id="fmem_edt"
                                                name="fmem_edt">
                                            <option value="0" selected> Select No of Member</option>
                                            <option value="1"> 1</option>
                                            <option value="2"> 2</option>
                                            <option value="3"> 3</option>
                                            <option value="4"> 4</option>
                                            <option value="5"> 5</option>
                                            <option value="6"> 6</option>
                                            <option value="7"> 7</option>
                                            <option value="8"> 8</option>
                                            <option value="9"> 9</option>
                                            <option value="10"> 10</option>
                                        </select>
                                        <!--                                            <input type="text" class="form-control" id="fmem_edt"-->
                                        <!--                                                   name="fmem_edt" placeholder="Family Member"/>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Moveble Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" id="mopr_edt"
                                               name="mopr_edt" placeholder="Moveble Property"/>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Applicant
                                        Relationship</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" name="apre_edt" id="apre_edt">
                                            <option value="0">Select Option</option>
                                            <?php
                                            foreach ($relinfo as $rel) {
                                                echo "<option value='$rel->reid'>$rel->redt</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Occupation</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder=" Occupation"
                                               id="occu_edt" name="occu_edt"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Immovebale Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Immovebale Property" id="impr_edt" name="impr_edt"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#advCust_edt1">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep3_edt">Go to step 3
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="advCust_edt3" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"> </span>
                        <span id="hed23"> </span> <span id="adv_cuno3"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li class="active"><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery</a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">
                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Business
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business </label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Business " id="buss_edt" name="buss_edt"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Business Address</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Business Address" id="bsad_edt" name="bsad_edt"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Registration No</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Registration No" id="rgno_edt" name="rgno_edt"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Duration</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Duration"
                                               id="dura_edt" name="dura_edt"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business Place</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class=" form-control"
                                               placeholder="Business Place" id="bupl_edt" name="bupl_edt"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business Telephone</label>
                                    <div class="col-md-3 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Telephone" id="butp_edt" name="butp_edt"/>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Email"
                                               id="beml_edt" name="beml_edt"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row"><br></div>
                            <div class="row"><br></div>

                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Income
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Business Income" id="bsin_edt" name="bsin_edt"
                                               onkeyup="bsc_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Income" id="obin_edt" name="obin_edt"
                                               onkeyup="bsc_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Total Income" id="ttib_edt" name="ttib_edt"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Direct Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Direct Income"
                                               id="diin_edt" name="diin_edt" onkeyup="dire_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class=" form-control"
                                               placeholder="Other Income" id="odin_edt" name="odin_edt"
                                               onkeyup="dire_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Total Income" id="ttid_edt" name="ttid_edt"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#advCust_edt2">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep4_edt">Go to step 4
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="advCust_edt4" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"> </span>
                        <span id="hed24"> </span> <span id="adv_cuno4"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li class="active"><a href="#">Family Summery</a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">
                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Family Assessment &
                                Expenses
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Spouse Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Spouse Income" id="spin_edt" name="spin_edt"
                                               onkeyup="spou_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Income" id="osin_edt" name="osin_edt"
                                               onkeyup="spou_ttl_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Total Income" id="ttis_edt" name="ttis_edt"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Food</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Food"
                                               id="food_edt" name="food_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Cloth</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Cloth"
                                               id="clth_edt" name="clth_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Water</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Water"
                                               id="wate_edt" name="wate_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Electricity</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Electricity"
                                               id="elec_edt" name="elec_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Medicine</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Medicine"
                                               id="medc_edt" name="medc_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Education</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Education"
                                               id="educ_edt" name="educ_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Transport</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Transport"
                                               id="tran_edt" name="tran_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Others</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Others"
                                               id="otex_edt" name="otex_edt" onkeyup="ttl_expen_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Total Expenses</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Total Expenses"
                                               id="ttex_edt" name="ttex_edt"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#advCust_edt3">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep5_edt"
                                    onclick="ttl_sum_edt()">Go to step 5
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="advCust_edt5" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"> </span>
                        <span id="hed25"> </span> <span id="adv_cuno5"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery</a></li>
                            <li class="active"><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">
                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Total Summery
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Loan Instalment</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Loan Instalment" id="lnin_edt" name="lnin_edt"
                                               onkeyup="ttl_sum_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Loans</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Loans" id="otln_edt" name="otln_edt"
                                               onkeyup="ttl_sum_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Insurance Instalment</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Insurance Instalment" id="inis_edt" name="inis_edt"
                                               onkeyup="ttl_sum_edt()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">NET Cash In Hand</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="NET Cash In Hand" id="ncih_edt" name="ncih_edt"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#advCust_edt4">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep6_edt">Go to step 6
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="advCust_edt6" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"> </span>
                        <span id="hed26"> </span> <span id="adv_cuno6"> </span>
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery</a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li class="active"><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">
                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Document
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">NIC Copy</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:300px">
                                            <input type="file" name="advNicEdt" id="avatar_44"
                                                   class="file-loading"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">GS Certificate</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:300px">
                                            <input type="file" name="advGscEdt" id="avatar_55"
                                                   class="file-loading"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Bus. Location</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:300px">
                                            <input type="file" name="advBulEdt" id="avatar_66"
                                                   class="file-loading"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:300px">
                                            <input type="file" name="advOthEdt" id="avatar_77"
                                                   class="file-loading"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="avt33" name="avt33"/>
                            <input type="hidden" id="avt44" name="avt44"/>
                            <input type="hidden" id="avt55" name="avt55"/>
                            <input type="hidden" id="avt66" name="avt66"/>
                            <input type="hidden" id="avt77" name="avt77"/>

                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#advCust_edt5">Back
                            </button>
                            <button type="submit" class="btn btn-success pull-right" id="btnNm2"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<!--End Advance Customer -->

</body>

<script>
    // File upload
    $("#avatar_1,#avatar_3").fileinput({
        overwriteInitial: true,
        maxFileSize: 1000,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        removeTitle: 'Remove',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg" alt="Customer Picture" style="width:160px">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse}'
        },
        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
    });

    $("#avatar_44,#avatar_55,#avatar_66,#avatar_77").fileinput({
        overwriteInitial: true,
        maxFileSize: 1000,
        showClose: false,
        showCaption: false,
        browseLabel: '',
        removeLabel: '',
        browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
        uploadIcon: '<i class="glyphicon "></i>',
        removeTitle: 'Remove',
        elErrorContainer: '#kv-avatar-errors-1',
        msgErrorClass: 'alert alert-block alert-danger',
        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/document-default.png" alt="Customer Document" style="width:160px">',
        layoutTemplates: {
            main2: '{preview} {remove} {browse} '
        },
        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
    });

    // End File upload

    $().ready(function () {

        // Data Tables
        $('#dataTbCust').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        //  Advance customer edit
        $('#form_edt1').validate({
            rules: {
                brch_advcust_edt: {
                    required: true,
                    notEqual: 'all'
                },
                adv_exc_edt: {
                    required: true,
                    notEqual: 'all'
                },
                adv_cen_edt: {
                    required: true,
                    notEqual: 'all'
                },
                adv_grup_edt: {
                    required: true,
                    notEqual: 'all',
                    remote: {
                        url: "<?= base_url(); ?>user/chk_custEdt_count",
                        type: "post",
                        data: {
                            cen: function () {
                                return $("#adv_cen_edt").val();
                            },
                            grp: function () {
                                return $("#adv_grup_edt").val();
                            }
                        }
                    }
                },
                adv_titl_edt: {
                    required: true
                },
                adv_funm_edt: {
                    required: true
                },
                adv_nic_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_nic_edt",
                        type: "post",
                        data: {
                            nic: function () {
                                return $("#adv_nic_edt").val();
                            },
                            auid: function () {
                                return $("#auid_advn").val();
                            },
                        }
                    }
                },
                adv_hoad_edt: {
                    required: true
                },
                adv_dobi_edt: {
                    required: true
                },
                adv_tele_edt: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                adv_mobi_edt: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_mobile_edt",
                        type: "post",
                        data: {
                            mobi: function () {
                                return $("#adv_mobi_edt").val();
                            },
                            cuid: function () {
                                return $("#auid_advn").val();
                            },
                        }
                    }
                },
                adv_edun_edt: {
                    required: true
                },
                adv_cist_edt: {
                    required: true
                },
                ncih_edt: {
                    required: true
                },

            },
            messages: {
                brch_advcust_edt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                adv_exc_edt: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer"
                },
                adv_cen_edt: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center"
                },
                adv_grup_edt: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Group",
                    remote: "Max Customer Count Exists"
                },
                adv_titl_edt: {
                    required: 'Please select Title'
                },
                adv_funm_edt: {
                    required: 'Please Enter Customer Name'
                },
                adv_nic_edt: {
                    required: 'Please Enter NIC',
                    remote: 'NIC Already Exists'
                },
                adv_hoad: {
                    required: 'Please Enter Address'
                },
                adv_tele_edt: {
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                adv_mobi_edt: {
                    required: 'Please Enter Mobile',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    remote: 'Mobile Already Exists'
                },
                adv_edun_edt: {
                    required: 'Please select Education '
                },
                adv_cist_edt: {
                    required: 'Please select Civil Status'
                },
                ncih_edt: {
                    required: 'This field is required.'
                },

            }
        });

        $('#form_edt5').validate({
            // rules
            rules: {
                ncih_edt: {
                    required: true
                }
            },
            messages: {
                ncih_edt: {
                    required: 'Enter Net Cash In Hand'
                }
            }
        });

        srchCustmer();
    });


    // advance customer edit wizard button action
    $('#gotoStep2_edt').on('click', function () {
        if ($('#form_edt1').valid()) {              // code to reveal step 2
            $('#advCust_edt1').modal('hide');
            $('#advCust_edt2').modal('show');
        }
    });

    $('#gotoStep3_edt').on('click', function () {
        if ($('#form_edt1').valid()) {             // code to reveal step 3
            $('#advCust_edt2').modal('hide');
            $('#advCust_edt3').modal('show');
        }
    });

    $('#gotoStep4_edt').on('click', function () {
        if ($('#form_edt1').valid()) {             // code to reveal step 4
            $('#advCust_edt3').modal('hide');
            $('#advCust_edt4').modal('show');
        }
    });

    $('#gotoStep5_edt').on('click', function () {
        if ($('#form_edt1').valid()) {             // code to reveal step 5
            $('#advCust_edt4').modal('hide');
            $('#advCust_edt5').modal('show');
        }
    });

    $('#gotoStep6_edt').on('click', function () {
        if ($('#form_edt1').valid()) {             // code to reveal step 6
            $('#advCust_edt5').modal('hide');
            $('#advCust_edt6').modal('show');
        }
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchCustmer() {                                                       // Search btn
        var brn = document.getElementById('brch_cst').value;
        var exc = document.getElementById('exc_cust').value;
        var cen = document.getElementById('cen_cust').value;
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch_cst').style.borderColor = "red";
        } else {
            document.getElementById('brch_cst').style.borderColor = "";

            $('#dataTbCust').DataTable().clear();
            $('#dataTbCust').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3, 4, 5, 6, 7]},
                    {className: "text-center", "targets": [0, 1, 8, 9, 10]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[9, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '10%'},    //exc
                    {sWidth: '10%'},
                    {sWidth: '10%'},    // cus id
                    {sWidth: '10%'},    // name
                    {sWidth: '5%'},     // nic
                    {sWidth: '5%'},     // mobile
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchNmcust',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        stat: stat
                    }
                }
            });
        }
    }

    function initnameAdv_edt(fullnm) {  // advance cus edt
        var fulnm = fullnm.trim();

        var res = fulnm.split(" ");
        var size = (res.length) - 1;

        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }

        var shrt = initials + res.pop();
        document.getElementById('adv_init_edt').value = shrt;
    }

    function upgrdCust(auid) {

            $('#hed21,#hed22,#hed23,#hed24,#hed25,#hed26').text(" Customer upgrade :");
            $('#btnNm2').text("Upgrade");
            document.getElementById("func_advn").value = '1';

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewnmcustdtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("adv_brch_edt").value = response[i]['brco'];
                    document.getElementById("adv_exc_edt").value = response[i]['exec'];
                    document.getElementById("adv_cen_edt").value = response[i]['ccnt'];

                    // for auto load officer & center
                    getExeEdit(response[i]['brco'], 'adv_exc_edt', response[i]['exec'], 'adv_cen_edt');
                    getCenterEdit(response[i]['exec'], 'adv_cen_edt', response[i]['brco'], response[i]['ccnt']);

                    document.getElementById("adv_gplg_edt").value = response[i]['gplg'];
                    document.getElementById("adv_gplt_edt").value = response[i]['gplt'];
                    document.getElementById("adv_titl_edt").value = response[i]['titl'];
                    document.getElementById("adv_funm_edt").value = response[i]['funm'];
                    document.getElementById("adv_init_edt").value = response[i]['init'];
                    document.getElementById("adv_nic_edt").value = response[i]['anic'];
                    document.getElementById("adv_gend_edt").value = response[i]['gend'];
                    document.getElementById("adv_hoad_edt").value = response[i]['hoad'];
                    document.getElementById("adv_tele_edt").value = response[i]['tele'];
                    document.getElementById("adv_mobi_edt").value = response[i]['mobi'];
                    document.getElementById("adv_dobi_edt").value = response[i]['dobi'];
                    document.getElementById("adv_edun_edt").value = response[i]['edun'];
                    document.getElementById("adv_cist_edt").value = response[i]['cist'];
                    document.getElementById("adv_gsaw_edt").value = response[i]['gsaw'];
                    //document.getElementById("adv_smst_edt").value = response[i]['smst'];
                    if (response[i]['smst'] == 1) {
                        document.getElementById("adv_smst_edt").checked = true;
                    } else {
                        document.getElementById("adv_smst_edt").checked = false;
                    }

                    $('#adv_cuno1,#adv_cuno2,#adv_cuno3,#adv_cuno4,#adv_cuno5,#adv_cuno6').text(response[i]['cuno']);
                    // Step #2
                    document.getElementById("sunm_edt").value = response[i]['sunm'];
                    document.getElementById("spnic_edt").value = response[i]['snic'];
                    //document.getElementById("fmem_edt").value = response[i]['fmem'];
                    document.getElementById("mopr_edt").value = response[i]['mopr'];
                    //document.getElementById("apre_edt").value = response[i]['apre'];
                    document.getElementById("occu_edt").value = response[i]['occu'];
                    document.getElementById("impr_edt").value = response[i]['impr'];
                    // Step #3
                    document.getElementById("buss_edt").value = response[i]['buss'];
                    document.getElementById("bsad_edt").value = response[i]['bsad'];
                    document.getElementById("rgno_edt").value = response[i]['rgno'];
                    document.getElementById("dura_edt").value = response[i]['dura'];
                    document.getElementById("bupl_edt").value = response[i]['bupl'];
                    document.getElementById("butp_edt").value = response[i]['butp'];
                    document.getElementById("beml_edt").value = response[i]['beml'];
                    document.getElementById("bsin_edt").value = response[i]['bsin'];
                    document.getElementById("obin_edt").value = response[i]['obin'];
                    document.getElementById("ttib_edt").value = response[i]['ttib'];
                    document.getElementById("diin_edt").value = response[i]['diin'];
                    document.getElementById("odin_edt").value = response[i]['odin'];
                    document.getElementById("ttid_edt").value = response[i]['ttid'];
                    // Step #4
                    document.getElementById("spin_edt").value = response[i]['spin'];
                    document.getElementById("osin_edt").value = response[i]['osin'];
                    document.getElementById("ttis_edt").value = response[i]['ttis'];
                    document.getElementById("food_edt").value = response[i]['food'];
                    document.getElementById("clth_edt").value = response[i]['clth'];
                    document.getElementById("wate_edt").value = response[i]['wate'];
                    document.getElementById("elec_edt").value = response[i]['elec'];
                    document.getElementById("medc_edt").value = response[i]['medc'];
                    document.getElementById("educ_edt").value = response[i]['educ'];
                    document.getElementById("tran_edt").value = response[i]['tran'];
                    document.getElementById("otex_edt").value = response[i]['otex'];
                    document.getElementById("ttex_edt").value = response[i]['ttex'];
                    // Step #5
                    document.getElementById("lnin_edt").value = response[i]['lnin'];
                    document.getElementById("otln_edt").value = response[i]['otln'];
                    document.getElementById("inis_edt").value = response[i]['inis'];
                    document.getElementById("ncih_edt").value = response[i]['ncih'];
                    // Step #6
                    //document.getElementById("adv_sdmst_edt").value = response[i]['smdst'];


                    if (response[i]['stat'] == 3 || response[i]['stat'] == 4) {
                        document.getElementById("adv_brch_edt").disabled = true;
                        document.getElementById("adv_exc_edt").disabled = true;
                        document.getElementById("adv_cen_edt").disabled = true;
                        document.getElementById("adv_grup_edt").disabled = true;
                        document.getElementById("adv_nic_edt").disabled = true;

                    } else {
                        document.getElementById("adv_brch_edt").disabled = false;
                        document.getElementById("adv_exc_edt").disabled = false;
                        document.getElementById("adv_cen_edt").disabled = false;
                        document.getElementById("adv_grup_edt").disabled = false;
                        document.getElementById("adv_nic_edt").disabled = false;
                    }


                    var uspic = response[i]['uimg'];        //avatar_33
                    document.getElementById("avt33").value = uspic;


                    $("#avatar_33").fileinput('refresh', {
                        overwriteInitial: true,
                        maxFileSize: 1000,
                        cache: false,
                        showClose: false,
                        showCaption: false,
                        browseLabel: '',
                        removeLabel: '',
                        browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                        removeTitle: 'Remove',
                        elErrorContainer: '#kv-avatar-errors-1',
                        msgErrorClass: 'alert alert-block alert-danger',
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/cust_profile/' + uspic + ' " alt="Customer Picture" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });

                    var $el = $('#adv_grup_edt');
                    $($el).empty();
                    $el.append($("<option></option>")
                        .attr("value", response[i]['grno']).text(response[i]['grnm']));

                    document.getElementById("auid_advn").value = response[i]['ccuid'];
                    document.getElementById("stat_advn").value = response[i]['stat'];
                }
            }
        })
    }

    // adv cust update
    $("#form_edt1").submit(function (e) { // edite form
        e.preventDefault();

        if ($('#form_edt1').valid()) {
            var formObj = $(this);
            //var formURL = formObj.attr("action");
            var formData = new FormData(this);

                swal({
                        title: "Are you sure upgrade customer ?",
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
                            $('#advCust_edt6').modal('hide');
                            $.ajax({
                                url: '<?= base_url(); ?>user/cust_upgrade',
                                type: 'POST',
                                data: formData,
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (data, textStatus, jqXHR) {
                                    srchCustmer();
                                    swal({title: "", text: "Customer upgrade Success!", type: "success"},
                                        function () {
                                            // location.reload();
                                        });
                                },
                                error: function (textStatus) {
                                    swal({title: "Upgrade Error", text: textStatus, type: "error"},
                                        function () {
                                           // location.reload();
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });

        }
    });


    function checkNicSpc() {
        var nicNo = document.getElementById("spnic").value;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById('spnic').style.borderColor = "#e6e8ed";
        } else if (nicNo.length == 12) {
            document.getElementById('spnic').style.borderColor = "#e6e8ed";
        } else {
            document.getElementById('spnic').focus(0);
            document.getElementById('spnic').style.borderColor = "red";
        }
    };

    function checkNicSpc_edt() {
        var nicNo = document.getElementById("spnic_edt").value;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById('spnic_edt').style.borderColor = "#e6e8ed";
        } else if (nicNo.length == 12) {
            document.getElementById('spnic_edt').style.borderColor = "#e6e8ed";
        } else {
            document.getElementById('spnic_edt').focus(0);
            document.getElementById('spnic_edt').style.borderColor = "red";
        }
    };

    // business income
    function bsc_ttl() {
        var a = document.getElementById('bsin').value;
        var b = document.getElementById('obin').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttib').value = c;
    }

    function bsc_ttl_edt() {
        var a = document.getElementById('bsin_edt').value;
        var b = document.getElementById('obin_edt').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttib_edt').value = c;
    }

    // direct income
    function dire_ttl() {
        var a = document.getElementById('diin').value;
        var b = document.getElementById('odin').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttid').value = c;
    }

    function dire_ttl_edt() {
        var a = document.getElementById('odin_edt').value;
        var b = document.getElementById('diin_edt').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttid_edt').value = c;
    }

    // family income
    function spou_ttl() {
        var a = document.getElementById('spin').value;
        var b = document.getElementById('osin').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttis').value = c;
    }

    function spou_ttl_edt() {
        var a = document.getElementById('spin_edt').value;
        var b = document.getElementById('osin_edt').value;
        var c = 0;
        c = +a + +b;
        document.getElementById('ttis_edt').value = c;
    }

    // total expenses
    function ttl_expen() {
        var c = 0;
        c = +document.getElementById('food').value + +document.getElementById('clth').value + +document.getElementById('wate').value + +document.getElementById('elec').value +
            +document.getElementById('medc').value + +document.getElementById('educ').value + +document.getElementById('tran').value + +document.getElementById('otex').value;
        document.getElementById('ttex').value = c;
    }

    function ttl_expen_edt() {
        var c = 0;
        c = +document.getElementById('food_edt').value + +document.getElementById('clth_edt').value + +document.getElementById('wate_edt').value + +document.getElementById('elec_edt').value +
            +document.getElementById('medc_edt').value + +document.getElementById('educ_edt').value + +document.getElementById('tran_edt').value + +document.getElementById('otex_edt').value;
        document.getElementById('ttex_edt').value = c;
    }

    // total summery
    function ttl_sum() {
        var c = 0;
        c = (+document.getElementById('ttib').value + +document.getElementById('ttid').value + +document.getElementById('ttis').value) - +document.getElementById('lnin').value -
            +document.getElementById('otln').value - +document.getElementById('inis').value - +document.getElementById('ttex').value;
        document.getElementById('ncih').value = c;
    }

    function ttl_sum_edt() {
        var c = 0;
        c = (+document.getElementById('ttib_edt').value + +document.getElementById('ttid_edt').value + +document.getElementById('ttis_edt').value) - +document.getElementById('lnin_edt').value -
            +document.getElementById('otln_edt').value - +document.getElementById('inis_edt').value - +document.getElementById('ttex_edt').value;
        document.getElementById('ncih_edt').value = c;
    }

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
                    document.getElementById("vew_grup").innerHTML = response[i]['grno'];
                    document.getElementById("vew_lng").innerHTML = response[i]['gplg'];
                    document.getElementById("vew_ltu").innerHTML = response[i]['gplt'];


                    var nm = response[i]['funm'];
                    var xc = response[i]['funm'].length;
                    if (xc < 40) {
                        document.getElementById("vew_funm").innerHTML = nm;
                    } else {
                        var a = nm.substring(0, 40);
                        var b = nm.substring(40, xc);
                        document.getElementById("vew_funm").innerHTML = a + '<br>' + b;
                    }

                    document.getElementById("vew_innm").innerHTML = response[i]['init'];
                    // document.getElementById("vew_adrs").innerHTML = response[i]['hoad'];

                    var add = response[i]['hoad'];
                    var ab = response[i]['hoad'].length;
                    if (ab < 40) {
                        document.getElementById("vew_adrs").innerHTML = add;
                    } else {
                        var x = add.substring(0, 40);
                        var y = add.substring(40, ab);
                        document.getElementById("vew_adrs").innerHTML = x + '<br>' + y;
                    }

                    var b = moment(new Date().getFullYear());
                    new Date();
                    var d = new Date(response[i]['dobi']);
                    var c = d.getFullYear();
                    var xx = +b - +c;
                    var dur = xx + " Year";
                    //console.log(b + '*' + c + '**' + xx);

                    document.getElementById("vew_nic").innerHTML = response[i]['anic'];
                    document.getElementById("vew_dob").innerHTML = response[i]['dobi'] + ' (' + dur + ')';
                    document.getElementById("vew_gnd").innerHTML = response[i]['gndt']; // gender
                    document.getElementById("vew_tel").innerHTML = response[i]['tele'];
                    document.getElementById("vew_mob").innerHTML = response[i]['mobi'];
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
                    document.getElementById("vew_mvpr").innerHTML = numeral(response[i]['mopr']).format('0,0.00');
                    document.getElementById("vew_impr").innerHTML = numeral(response[i]['impr']).format('0,0.00');  // numeral(rr).format('$0,0.00')

                    document.getElementById("vew_bus").innerHTML = response[i]['buss'];
                    document.getElementById("vew_buad").innerHTML = response[i]['bsad'];
                    document.getElementById("vew_bsrg").innerHTML = response[i]['rgno'];
                    document.getElementById("vew_bsdu").innerHTML = response[i]['dura'] + ' Years';
                    document.getElementById("vew_bspl").innerHTML = response[i]['bupl'];
                    document.getElementById("vew_bstp").innerHTML = response[i]['butp'];
                    document.getElementById("vew_bsic").innerHTML = numeral(response[i]['bsin']).format('0,0.00');
                    document.getElementById("vew_otic").innerHTML = numeral(response[i]['obin']).format('0,0.00');
                    document.getElementById("vew_ttic").innerHTML = numeral(response[i]['ttib']).format('0,0.00');
                    document.getElementById("vew_diic").innerHTML = numeral(response[i]['diin']).format('0,0.00');
                    document.getElementById("vew_dioi").innerHTML = numeral(response[i]['odin']).format('0,0.00');
                    document.getElementById("vew_ttoi").innerHTML = numeral(response[i]['ttid']).format('0,0.00');

                    document.getElementById("vew_spin").innerHTML = numeral(response[i]['spin']).format('0,0.00');
                    document.getElementById("vew_osin").innerHTML = numeral(response[i]['osin']).format('0,0.00');
                    document.getElementById("vew_ttis").innerHTML = numeral(response[i]['ttis']).format('0,0.00');
                    document.getElementById("vew_food").innerHTML = numeral(response[i]['food']).format('0,0.00');
                    document.getElementById("vew_clth").innerHTML = numeral(response[i]['clth']).format('0,0.00');
                    document.getElementById("vew_wate").innerHTML = numeral(response[i]['wate']).format('0,0.00');
                    document.getElementById("vew_elec").innerHTML = numeral(response[i]['elec']).format('0,0.00');
                    document.getElementById("vew_medc").innerHTML = numeral(response[i]['medc']).format('0,0.00');
                    document.getElementById("vew_educ").innerHTML = numeral(response[i]['educ']).format('0,0.00');
                    document.getElementById("vew_tran").innerHTML = numeral(response[i]['tran']).format('0,0.00');
                    document.getElementById("vew_otex").innerHTML = numeral(response[i]['otex']).format('0,0.00');
                    document.getElementById("vew_ttex").innerHTML = numeral(response[i]['ttex']).format('0,0.00');

                    document.getElementById("vew_lnin").innerHTML = numeral(response[i]['lnin']).format('0,0.00');
                    document.getElementById("vew_otln").innerHTML = numeral(response[i]['otln']).format('0,0.00');
                    document.getElementById("vew_inis").innerHTML = numeral(response[i]['inis']).format('0,0.00');
                    document.getElementById("vew_ncih").innerHTML = numeral(response[i]['ncih']).format('0,0.00');

                    if (response[i]['uimg'] != null) {
                        document.getElementById("img1").src = "../uploads/cust_profile/" + response[i]['uimg'];
                    }
                    if (response[i]['img_nic'] != null) {
                        document.getElementById("img2").src = "../uploads/user_document/" + response[i]['img_nic'];
                    }
                    if (response[i]['img_gscr'] != null) {
                        document.getElementById("img3").src = "../uploads/user_document/" + response[i]['img_gscr'];
                    }
                    if (response[i]['img_bslc'] != null) {
                        document.getElementById("img4").src = "../uploads/user_document/" + response[i]['img_bslc'];
                    }
                    if (response[i]['img_othr'] != null) {
                        document.getElementById("img5").src = "../uploads/user_document/" + response[i]['img_othr'];
                    }

                }
            }
        })
    }

    // if pending customer have rejected and active & approval customer have close
    function rejecNmCust(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this check",
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
                    $.ajax({
                        url: '<?= base_url(); ?>user/rejNormlCust',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchCustmer();
                                swal({title: "", text: "Customer Reject Success!", type: "success"});
                            } else {
                                swal({title: "Not process ", text: "Contact system admin !", type: "warning"});
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Customer Not Rejected", "error");
                }
            });
    }

    function closeCust(id) {
        $.ajax({
            url: '<?= base_url(); ?>user/checkCustLoan',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                if (response == 0) {
                    swal({
                            title: "Are you sure?",
                            text: "Your will not be able to revers this process",
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
                                $.ajax({
                                    url: '<?= base_url(); ?>user/closeCustmer',
                                    type: 'post',
                                    data: {
                                        id: id
                                    },
                                    dataType: 'json',
                                    success: function (response) {
                                        if (response === true) {
                                            srchCustmer();
                                            swal({title: "", text: "Customer Close Success!", type: "success"});
                                        } else {
                                            swal({
                                                title: "Not process ",
                                                text: "Contact system admin !",
                                                type: "warning"
                                            });
                                        }
                                    }
                                });
                            } else {
                                swal("Cancelled!", "Customer Not Close", "error");
                            }
                        });
                } else {
                    swal("Can't Process", "Customer have Running Loan", "warning");
                }
            }
        });
    }

    function reactvCust(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to revers this process",
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
                    $.ajax({
                        url: '<?= base_url(); ?>user/reactCustm',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchCustmer();
                                swal({title: "", text: "Customer Reactive Success!", type: "success"});
                            } else {
                                swal({title: "Not process ", text: "Contact system admin !", type: "warning"});
                            }
                        },
                        error: function (data, textStatus) {
                            swal({title: "Update Error", text: textStatus, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled", "", "error");
                }
            });
    }


</script>












