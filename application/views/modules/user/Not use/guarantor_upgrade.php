<!--<link href="--><?php //echo base_url(); ?><!--assets/dist/custom_css/fileinput.css" rel="stylesheet" type="text/css"/>-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/dist/js/fileinput.js"></script>-->
<!--<script src="--><?php //echo base_url(); ?><!--assets/dist/js/numeral-js.js" type="text/javascript"></script>-->

<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Customer Module</li>
    <li class="active">Guarantor Upgrade</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Guarantor Upgrade </strong></h3>
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
                                <label class="col-md-4 col-xs-6 control-label">Guarantor Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat"
                                            onchange="chckBtn(this.value,'stat')">
                                        <option value="0"> Select Guarantor Type</option>
                                        <option value="1"> Current Guarantor</option>
                                        <option value="2"> Upgraded Guarantor</option>

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
                                    <button type="button form-control  " onclick="srchGuranter()"
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
                                           id="dataTbGrnt" width="100%">
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

</body>

<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbGrnt').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        srchGuranter();
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchGuranter() {                                                       // Search btn
        var brn = document.getElementById('brch_cst').value;
        var exc = document.getElementById('exc_cust').value;
        var cen = document.getElementById('cen_cust').value;
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch_cst').style.borderColor = "red";
        } else if (stat == 0) {
            document.getElementById('stat').style.borderColor = "red";
        } else {
            document.getElementById('stat').style.borderColor = "";
            document.getElementById('brch_cst').style.borderColor = "";

            $('#dataTbGrnt').DataTable().clear();
            $('#dataTbGrnt').DataTable({
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
                    url: '<?= base_url(); ?>user/searchGrnt',
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

    function upgrdeGrnt(id) { // customer auid
        swal({
                title: "Are you sure upgrade",
                text: "Your will not be able to reverse this process",
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
                        url: '<?= base_url(); ?>user/upgrdeGrant',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchGuranter();
                                swal({title: "", text: "Guarantor Upgrade Success!", type: "success"});
                            } else {
                                swal({title: "Not process ", text: "Contact system admin !", type: "warning"});
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Guarantor not upgrade", "error");
                }
            });
    }


</script>












