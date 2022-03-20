<link href="<?php echo base_url(); ?>assets/dist/custom_css/fileinput.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/dist/js/fileinput.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/numeral-js.js" type="text/javascript"></script>

<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Customer Module</li>
    <li class="active">Customer Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Customer Management </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>  <!--  !empty($funcPerm) &&  -->
                        <button class="btn-sm btn-info pull-right" onclick="selectAddcust()">
                            <span><i class="fa fa-plus"></i></span> Add Customer
                        </button> <!-- data-toggle="modal" data-target="#modalAdd" -->
                    <?php } ?>

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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="grtp" id="grtp"
                                            onchange="">
                                        <option value="all">All Type</option>
                                        <option value="1">Customer</option>
                                        <option value="0">Guarantor</option>

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

<!-- Normal Cust Add Model -->
<div class="modal" id="modalAdd_nmcust" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 70%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Normal Customer Registration
                </h4>
            </div>
            <form class="form-horizontal" id="normalCust_add" name="normalCust_add" enctype="multipart/form-data"
                  action="<?= base_url() ?>user/addNmlCust" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">Guarantor </label>
                                                <div class="col-md-3">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch" value="1" id="cutp"
                                                               name="cutp" onclick="" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-4 control-label text-left">Customer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">

                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Location Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="brch_adcust" id="brch_adcust"
                                                        onchange="getExe(this.value,'exc_adcust',exc_adcust.value,'cen_adcust');chckBtn(this.value,'brch_adcust')">
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
                                                <select class="form-control" name="exc_adcust" id="exc_adcust"
                                                        onchange="getCenter(this.value,'cen_adcust',brch_adcust.value);getGrup(this.value,'grup',brch_adcust.value,exc_adcust.value,'all')">
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
                                                <select class="form-control" name="cen_adcust" id="cen_adcust"
                                                        onchange="getGrup(this.value,'grup',brch_adcust.value,exc_adcust.value,cen_adcust.value)">
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
                                                <select class="form-control" name="grup" id="grup">
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
                                                <button type="button" onclick="getLocation()" class="btn btn-info">Get
                                                    Location
                                                </button>
                                            </div>
                                            <div class="col-md-3" style="top:3px;left: 10px;bottom: 3px">
                                                <span id="sts2"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label" style="margin-left: ">Longitude</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="GPS Longitude"
                                                       id="gplg" name="gplg"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Latitude</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="GPS Latitude"
                                                       id="gplt" name="gplt"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Personal Details</h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="titl" id="titl">
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
                                                       placeholder="Full Name" id="funm" name="funm"
                                                       onkeyup="initname(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Initial Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Initial with Name" id="init" name="init"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">NIC</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase" id="nic"
                                                       name="nic" placeholder="NIC"
                                                       onchange="checkNic1(this.value,'nic','addnmcust')"
                                                       onkeyup="checkNic1(this.value,'nic','addnmcust')"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="gend" id="gend">
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
                                                <div class="kv-avatar center-block text-center" style="width:200px">
                                                    <input type="file" name="picture" id="avatar_1"
                                                           class="file-loading"></div>

                                            </div>
                                        </div>

                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label"> Address</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Home Address"
                                                       id="hoad" name="hoad"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Telephone</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control"
                                                       placeholder="Telephone" id="tele" name="tele"/>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control" placeholder="Mobile"
                                                       id="mobi" name="mobi"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Date Of Birth</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class=" form-control datepicker"
                                                       placeholder="Date Of Birth" id="dobi" name="dobi"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Education</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="edun" id="edun">
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
                                                <select class="form-control" name="cist" id="cist">
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
                                                <input type="text" class="form-control" placeholder="GS Ward" id="gsaw"
                                                       name="gsaw"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">SMS Sending</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="smst" name="smst" type="checkbox" value="1" checked/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="bkdt" name="bkdt" type="checkbox" value="1"
                                                           onchange="bnkDtil()"/> No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body" id="bnkDiv" style="display: none">

                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="bknm" id="bknm"
                                                        onchange="chckBtn(this.value,'bknm')">
                                                    <option value="0">Select Option</option>
                                                    <?php
                                                    foreach ($bnkinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Branch</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Bank Branch"
                                                       id="bkbr" name="bkbr"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Account No</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Account No"
                                                       id="acno" name="acno"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addnmcust">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

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
                                                    <div class="form-group">
                                                        <label class="col-md-4 control-label">Bank Details</label>
                                                        <label class="control-label"
                                                               id="vew_bkdt">aa</label>
                                                    </div>
                                                    <div id="bk1">
                                                        <div class="form-group">
                                                            <label class="col-md-4 control-label">Bank Name</label>
                                                            <label class="control-label"
                                                                   id="vew_bknm">aa</label>
                                                        </div>
                                                        <div class="form-group" id="bk2">
                                                            <label class="col-md-4 control-label">Bank Branch</label>
                                                            <label class="control-label"
                                                                   id="vew_bkbr">aa</label>
                                                        </div>
                                                        <div class="form-group" id="bk3">
                                                            <label class="col-md-4 control-label">Account No</label>
                                                            <label class="control-label"
                                                                   id="vew_acno">aa</label>
                                                        </div>
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
                                                        <label class="col-md-5  control-label">Movable Property</label>
                                                        <label class="control-label"
                                                               id="vew_mvpr">aaaa</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Immovable
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

<!--  Edit / approvel -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> </span> <span id="cuno"> </span></h4>
            </div>
            <form class="form-horizontal" id="nmcust_edt" name="nmcust_edt" enctype="multipart/form-data"
                  action=" " method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Location Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="brch_edtcust" id="brch_edtcust"
                                                        onchange="getExe(this.value,'exc_edtcust',exc_edtcust.value,'cen_adcust');chckBtn(this.value,'brch_edtcust')">
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
                                                <select class="form-control" name="exc_edtcust" id="exc_edtcust"
                                                        onchange="getCenter(this.value,'cen_edtcust',brch_edtcust.value);getGrup(this.value,'edtcust',brch_edtcust.value,exc_edtcust.value,'all')">
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
                                                <select class="form-control" name="cen_edtcust" id="cen_edtcust"
                                                        onchange="getGrup(this.value,'grup_edtcust',brch_edtcust.value,exc_edtcust.value,cen_edtcust.value)">
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
                                                <select class="form-control" name="grup_edtcust" id="grup_edtcust">
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">GPS Location</label>
                                            <div class="col-md-3">
                                                <button type="button" onclick="getLocation_edt()" class="btn btn-info">
                                                    Get
                                                    Location
                                                </button>
                                            </div>
                                            <div class="col-md-3" style="top:3px;left: 10px;bottom: 3px">
                                                <span id="sts2_edt"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label" style="margin-left: ">Longitude</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="GPS Longitude"
                                                       id="gplg_edt" name="gplg_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Latitude</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="GPS Latitude"
                                                       id="gplt_edt" name="gplt_edt"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" id="nm_stat" name="nm_stat" value="">
                                <input type="hidden" id="func" name="func"/>
                                <input type="hidden" id="auid" name="auid"/>


                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Customer Details</h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="titl_edt" id="titl_edt">
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
                                                       placeholder="Full Name" id="funm_edt" name="funm_edt"
                                                       onkeyup="initname2(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Initial Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Initial with Name" id="init_edt" name="init_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">NIC</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase" id="nic_edt"
                                                       name="nic_edt" placeholder="NIC"
                                                       onchange="checkNic_edt(this.value,'nic_edt','nmcuEdt')"
                                                       onkeyup="checkNic_edt(this.value,'nic_edt','nmcuEdt')"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="gend_edt" id="gend_edt">
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
                                                <div class="kv-avatar center-block text-center" style="width:200px">
                                                    <input id="avatar_2" name="picture" type="file"
                                                           class="file-loading">
                                                </div>
                                            </div>
                                            <input type="hidden" id="nmusrpict" name="nmusrpict"/>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label"> Address</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Home Address"
                                                       id="hoad_edt" name="hoad_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Telephone</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control"
                                                       placeholder="Telephone" id="tele_edt" name="tele_edt"/>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control" placeholder="Mobile"
                                                       id="mobi_edt" name="mobi_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Date Of Birth</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class=" form-control datepicker"
                                                       placeholder="Date Of Birth" id="dobi_edt" name="dobi_edt"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Education</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="edun_edt" id="edun_edt">
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
                                                <select class="form-control" name="cist_edt" id="cist_edt">
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
                                                       id="gsaw_edt"
                                                       name="gsaw_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">SMS Sending</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="smst_edt" name="smst_edt" type="checkbox" value="1"
                                                           checked/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="bkdt_edt" name="bkdt_edt" type="checkbox" value="1"
                                                           onchange="bnkDtil_edt()"/> No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body" id="bnkDiv_edt" style="display: none">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details</h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="bknm_edt" id="bknm_edt"
                                                        onchange="chckBtn(this.value,'bknm_edt')">
                                                    <option value="0">Select Option</option>
                                                    <?php
                                                    foreach ($bnkinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Branch</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Bank Branch"
                                                       id="bkbr_edt" name="bkbr_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Account No</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Account No"
                                                       id="acno_edt" name="acno_edt"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="nmcuEdt"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit / approvel Model -->

<!-- Advance Customer Add Model -->

<form id="form1" name="form1" class="form-horizontal" enctype="multipart/form-data" method="post">

    <div class="modal" id="step_1" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
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
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Location Details</h3>
                            <div id="form-step-0" role="form" data-toggle="validator">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="form-control" name="adv_brch" id="adv_brch"
                                                    onchange="getExe(this.value,'adv_exc',adv_exc.value,'adv_cen');chckBtn(this.value,'adv_brch')">
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
                                            <select class="form-control" name="adv_exc" id="adv_exc"
                                                    onchange="getCenter(this.value,'adv_cen',adv_brch.value);getGrup(this.value,'adv_grup',adv_brch.value,adv_exc.value,'all')">
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
                                            <select class="form-control" name="adv_cen" id="adv_cen"
                                                    onchange="getGrup(this.value,'adv_grup',adv_brch.value,adv_exc.value,adv_cen.value)">
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
                                            <select class="form-control" name="adv_grup" id="adv_grup">
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
                                            <button type="button" onclick="getLocation2()" class="btn btn-info">
                                                Get
                                                Location
                                            </button>
                                        </div>
                                        <div class="col-md-3" style="top:3px;left: 10px;bottom: 3px">
                                            <span id="sts22"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label"
                                               style="margin-left: ">Longitude</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control "
                                                   placeholder="GPS Longitude"
                                                   id="adv_gplg" name="adv_gplg"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Latitude</label>
                                        <div class="col-md-8 col-xs-12">
                                            <input type="text" class="form-control" placeholder="GPS Latitude"
                                                   id="adv_gplt" name="adv_gplt"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Customer Details
                                    </h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Title</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_titl" id="adv_titl">
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
                                                       placeholder="Full Name" id="adv_funm" name="adv_funm"
                                                       onkeyup="initnameAdv(this.value)"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Initial Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       placeholder="Initial with Name" id="adv_init"
                                                       name="adv_init"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">NIC</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control text-uppercase"
                                                       id="adv_nic"
                                                       name="adv_nic" placeholder="NIC"
                                                       onchange="checkNicAdv(this.value,'adv_nic','gotoStep2')"
                                                       onkeyup="checkNicAdv(this.value,'adv_nic','gotoStep2')"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Gender</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_gend" id="adv_gend">
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
                                                    <input type="file" name="adv_cust_pro" id="avatar_3"
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
                                                       id="adv_hoad" name="adv_hoad"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Telephone</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control"
                                                       placeholder="Telephone" id="adv_tele" name="adv_tele"/>
                                            </div>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="  form-control" placeholder="Mobile"
                                                       id="adv_mobi" name="adv_mobi"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Date Of
                                                Birth</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class=" form-control datepicker"
                                                       placeholder="Date Of Birth" id="adv_dobi"
                                                       name="adv_dobi"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Education</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_edun" id="adv_edun">
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
                                                <select class="form-control" name="adv_cist" id="adv_cist">
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
                                                       id="adv_gsaw" name="adv_gsaw"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">SMS Sending</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="adv_smst" name="adv_smst" type="checkbox"
                                                           value="1"
                                                           checked/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="adv_bkdt" name="adv_bkdt" type="checkbox" value="1"
                                                           onchange="adv_bnkDtil()"/> No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel-body" id="adv_bnkDiv" style="display: none">

                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details</h3>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Bank Name</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <select class="form-control" name="adv_bknm" id="adv_bknm"
                                                            onchange="chckBtn(this.value,'adv_bknm')">
                                                        <option value="0">Select Option</option>
                                                        <?php
                                                        foreach ($bnkinfo as $bnk) {
                                                            echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Bank Branch</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input type="text" class="form-control" placeholder="Bank Branch"
                                                           id="adv_bkbr" name="adv_bkbr"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Account No</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <input type="text" class="form-control" placeholder="Account No"
                                                           id="adv_acno" name="adv_acno"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success pull-right" id="gotoStep2">Go to step 2
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="step_2" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
                    </h4>

                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li class="active"><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery </a></li>
                            <li><a href="#">Total Summery</a></li>
                            <li><a href="#">Document</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body" style="height: auto">
                    <div class="panel panel-default ">
                        <div class="panel-body" style="height: auto">
                            <h3 class="text-title"><span class="fa fa-bookmark"></span> Family & Spouse Details
                            </h3>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Spouse Name</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control text-uppercase"
                                               placeholder="Spouse Name" id="sunm" name="sunm"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Spouse NIC</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control text-uppercase" id="spnic"
                                               name="spnic" placeholder="NIC"
                                               onchange="checkNicSpc(this.value,'spnic','gotoStep3')"
                                               onkeyup="checkNicSpc(this.value,'spnic','gotoStep3')"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Family Member</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" id="fmem"
                                                name="fmem">
                                            <option value="0"> Select No of Member</option>
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
                                        <!--                                            <input type="text" class="form-control" id="fmem"-->
                                        <!--                                                   name="fmem" placeholder="Family Member"/>-->
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Movable Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" id="mopr"
                                               name="mopr" placeholder="Movable Property"/>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Applicant
                                        Relationship</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" name="apre" id="apre">
                                            <option value="">Select Option</option>
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
                                               id="occu" name="occu"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Immovable Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Immovable Property" id="impr" name="impr"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                                    data-toggle="modal"
                                    data-target="#step_1">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep3">Go to step 3
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="step_3" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
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
                                               placeholder="Business " id="buss" name="buss"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Business Address</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Business Address" id="bsad" name="bsad"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Registration No</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Registration No" id="rgno" name="rgno"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Duration</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Duration"
                                               id="dura" name="dura"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business Place</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class=" form-control"
                                               placeholder="Business Place" id="bupl" name="bupl"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Business Telephone</label>
                                    <div class="col-md-3 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Telephone" id="butp" name="butp"/>
                                    </div>
                                    <div class="col-md-5 col-xs-12">
                                        <input type="text" class="form-control email" placeholder="Email"
                                               id="beml" name="beml"/>
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
                                               placeholder="Business Income" id="bsin" name="bsin"
                                               onkeyup="bsc_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Income" id="obin" name="obin"
                                               onkeyup="bsc_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Total Income" id="ttib" name="ttib"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label"> Direct Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Direct Income"
                                               id="diin" name="diin" onkeyup="dire_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class=" form-control"
                                               placeholder="Other Income" id="odin" name="odin"
                                               onkeyup="dire_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Total Income" id="ttid" name="ttid"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"
                                    data-target="#step_2">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep4">Go to step 4
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="step_4" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
                    </h4>

                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li class="active"><a href="#">Family Summery </a></li>
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
                                               placeholder="Spouse Income" id="spin" name="spin"
                                               onkeyup="spou_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Income" id="osin" name="osin"
                                               onkeyup="spou_ttl()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Total Income</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" value="0"
                                               placeholder="Total Income" id="ttis" name="ttis"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Food</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Food"
                                               id="food" name="food" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Cloth</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Cloth"
                                               id="clth" name="clth" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Water</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Water"
                                               id="wate" name="wate" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Electricity</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Electricity"
                                               id="elec" name="elec" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Medicine</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Medicine"
                                               id="medc" name="medc" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Education</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Education"
                                               id="educ" name="educ" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Transport</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Transport"
                                               id="tran" name="tran" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Others</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Others"
                                               id="otex" name="otex" onkeyup="ttl_expen()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Total Expenses</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" placeholder="Total Expenses"
                                               id="ttex" name="ttex"/>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"
                                    data-target="#step_3">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep5" onclick="ttl_sum()">
                                Go to step 5
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="step_5" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
                    </h4>

                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery </a></li>
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
                                               placeholder="Loan Instalment" id="lnin" name="lnin"
                                               onkeyup="ttl_sum()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Other Loans</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Other Loans" id="otln" name="otln" onkeyup="ttl_sum()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Insurance Instalment</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="Insurance Instalment" id="inis" name="inis"
                                               onkeyup="ttl_sum()"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">NET Cash In Hand</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control"
                                               placeholder="NET Cash In Hand" id="ncih" name="ncih"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"
                                    data-target="#step_4">Back
                            </button>
                            <button type="button" class="btn btn-success pull-right" id="gotoStep6">Go to step 6
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="step_6" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width: 80%; height: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Advance Customer
                        Registration
                    </h4>

                    <div class="number">
                        <ul>
                            <li><a href="#">General Details </a></li>
                            <li><a href="#">Family Details</a></li>
                            <li><a href="#">Business Details</a></li>
                            <li><a href="#">Family Summery </a></li>
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
                                    <label class="col-md-3 col-xs-12 control-label"> NIC Copy </label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:200px">
                                            <input type="file" name="img_nic" id="avatar_4"
                                                   class="file-loading"/></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">GS Certificate </label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:200px">
                                            <input type="file" name="img_gscr" id="avatar_5"
                                                   class="file-loading"/></div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Bus. Location
                                    </label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:200px">
                                            <input type="file" name="img_bslc" id="avatar_6"
                                                   class="file-loading"/></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">Other</label>
                                    <div class="col-md-8 col-xs-12">
                                        <div class="kv-avatar center-block text-center" style="width:200px">
                                            <input type="file" name="img_othr" id="avatar_7"
                                                   class="file-loading"/></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal"
                                    data-target="#step_5">Back
                            </button>
                            <button type="submit" id="addAdvForm" class="btn btn-success pull-right">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!--End Advance Customer -->

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
                                                       onchange="checkNicAdv_edt(this.value,'adv_nic_edt','gotoStep2_edt')"
                                                       onkeyup="checkNicAdv_edt(this.value,'adv_nic_edt','gotoStep2_edt')"/>
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
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-8 col-xs-12">
                                                <label class="switch">
                                                    <input id="adv_bkdt_edt" name="adv_bkdt_edt" type="checkbox" value="1"
                                                           onchange="adv_bnkDtil_edt()"/> No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body" id="adv_bnkDiv_edt" style="display: none">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details</h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="adv_bknm_edt" id="adv_bknm_edt"
                                                        onchange="chckBtn(this.value,'adv_bknm_edt')">
                                                    <option value="0">Select Option</option>
                                                    <?php
                                                    foreach ($bnkinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Bank Branch</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Bank Branch"
                                                       id="adv_bkbr_edt" name="adv_bkbr_edt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Account No</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Account No"
                                                       id="adv_acno_edt" name="adv_acno_edt"/>
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
                                               name="spnic_edt" placeholder="NIC"
                                               onchange="checkNicSpc(this.value,'spnic_edt','gotoStep3_edt')"
                                               onkeyup="checkNicSpc(this.value,'spnic_edt','gotoStep3_edt')"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Family Member</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" id="fmem_edt"
                                                name="fmem_edt">
                                            <option value="0"> Select No of Member</option>
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
                                    <label class="col-md-4 col-xs-12 control-label">Movable Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="form-control" id="mopr_edt"
                                               name="mopr_edt" placeholder="Movable Property"/>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 control-label">Applicant
                                        Relationship</label>
                                    <div class="col-md-8 col-xs-12">
                                        <select class="form-control" name="apre_edt" id="apre_edt">
                                            <option value="">Select Option</option>
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
                                    <label class="col-md-4 col-xs-12 control-label">Immovable Property</label>
                                    <div class="col-md-8 col-xs-12">
                                        <input type="text" class="  form-control"
                                               placeholder="Immovable Property" id="impr_edt" name="impr_edt"/>
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
<!--                    </div>-->

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

    $("#avatar_4,#avatar_5,#avatar_6,#avatar_7").fileinput({
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
            main2: '{preview} {remove} {browse}'
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
        // $('#modalAdd_nmcust').modal('show');
        // $('#step_1').modal('show');


        $("#normalCust_add").validate({  // center add form validation
            rules: {
                brch_adcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                exc_adcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                cen_adcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                grup: {
                    required: true,
                    notEqual: 'all',
                    min: 1,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_cust_count",
                        type: "post",
                        data: {
                            cen: function () {
                                return $("#cen_adcust").val();
                            },
                            grp: function () {
                                return $("#grup").val();
                            }
                        }
                    }
                },


                titl: {
                    required: true
                },
                funm: {
                    required: true
                },
                nic: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_nic",
                        type: "post",
                        data: {
                            nic: function () {
                                return $("#nic").val();
                            },
                        }
                    }
                },
                hoad: {
                    required: true
                },
                tele: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                mobi: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_mobile",
                        type: "post",
                        data: {
                            mobi: function () {
                                return $("#mobi").val();
                            }
                        }
                    }
                },
                dobi: {
                    required: true
                },
                edun: {
                    required: true
                },
                cist: {
                    required: true
                },
                bknm: {
                    required: true,
                    notEqual: '0',
                },
                bkbr: {
                    required: true
                },
                acno: {
                    required: true,
                    digits: true,
                },
            },
            messages: {
                brch_adcust: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                exc_adcust: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer",
                    min: "Please select Officer"
                },
                cen_adcust: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                grup: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Group",
                    min: "Please select Group",
                    remote: "Max Customer Count Exists"
                },


                titl: {
                    required: 'Please select Title'
                },
                funm: {
                    required: 'Please Enter Customer Name'
                },
                nic: {
                    required: 'Please Enter NIC',
                    remote: 'NIC Already Exists'
                },
                hoad: {
                    required: 'Please Enter Address'
                },
                tele: {
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                mobi: {
                    required: 'Please Enter Mobile',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    remote: 'Mobile Already Exists'
                },
                edun: {
                    required: 'Please select Education '
                },
                cist: {
                    required: 'Please select Civil Status'
                },
                bknm: {
                    required: 'Please select Bank Name ',
                    notEqual: 'Please select Bank Name ',
                },
                bkbr: {
                    required: 'Please Enter Bank Branch '
                },
                acno: {
                    required: 'Please Enter Account No ',
                },
            }
        });

        $("#nmcust_edt").validate({  // center add form validation
            rules: {
                brch_edtcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                exc_edtcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                cen_edtcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                grup_edtcust: {
                    required: true,
                    notEqual: 'all',
                    min: 1,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_custEdt_count",
                        type: "post",
                        data: {
                            cen: function () {
                                return $("#cen_edtcust").val();
                            },
                            grp: function () {
                                return $("#grup_edtcust").val();
                            }
                        }
                    }
                },

                titl_edt: {
                    required: true
                },
                funm_edt: {
                    required: true
                },
                nic_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_nic_edt",
                        type: "post",
                        data: {
                            nic: function () {
                                return $("#nic_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },
                hoad_edt: {
                    required: true
                },
                tele_edt: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                mobi_edt: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_mobile_edt",
                        type: "post",
                        data: {
                            mobi: function () {
                                return $("#mobi_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },
                dobi_edt: {
                    required: true
                },
                edun_edt: {
                    required: true
                },
                cist_edt: {
                    required: true
                },
                bknm_edt: {
                    required: true,
                    notEqual: '0',
                },
                bkbr_edt: {
                    required: true
                },
                acno_edt: {
                    required: true,
                    digits: true,
                },

            },
            messages: {
                brch_edtcust: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                exc_edtcust: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer",
                    min: "Please select Officer"
                },
                cen_edtcust: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                grup_edtcust: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Group",
                    min: "Please select Group",
                    remote: "Max Customer Count Exists"
                },

                titl_edt: {
                    required: 'Please select Title'
                },
                funm_edt: {
                    required: 'Please Enter Customer Name'
                },
                nic_edt: {
                    required: 'Please Enter NIC',
                    remote: 'NIC Already Exists'
                },
                hoad_edt: {
                    required: 'Please Enter Address'
                },
                tele_edt: {
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                mobi_edt: {
                    required: 'Please Enter Mobile',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    remote: 'Mobile Already Exists'
                },
                edun_edt: {
                    required: 'Please select Education '
                },
                cist_edt: {
                    required: 'Please select Civil Status'
                },
                bknm_edt: {
                    required: 'Please select Bank Name ',
                    notEqual: 'Please select Bank Name ',
                },
                bkbr_edt: {
                    required: 'Please Enter Bank Branch '
                },
                acno_edt: {
                    required: 'Please Enter Account No ',
                },
            }
        });


        // Advance customer add
        $('#form1').validate({
            rules: {
                adv_brch: {
                    required: true,
                    notEqual: 'all',
                    min: 0
                },
                adv_exc: {
                    required: true,
                    notEqual: 'all',
                    min: 0
                },
                adv_cen: {
                    required: true,
                    notEqual: 'all',
                    min: 0
                },
                adv_grup: {
                    required: true,
                    notEqual: 'all',
                    min: 0,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_cust_count",
                        type: "post",
                        data: {
                            cen: function () {
                                return $("#adv_cen").val();
                            },
                            grp: function () {
                                return $("#adv_grup").val();
                            }
                        }
                    }
                },
                adv_titl: {
                    required: true
                },
                adv_funm: {
                    required: true
                },
                adv_nic: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_nic",
                        type: "post",
                        data: {
                            nic: function () {
                                return $("#adv_nic").val();
                            }
                        }
                    }
                },
                adv_hoad: {
                    required: true
                },
                adv_dobi: {
                    required: true
                },
                adv_tele: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                adv_mobi: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_mobile",
                        type: "post",
                        data: {
                            mobi: function () {
                                return $("#adv_mobi").val();
                            }
                        }
                    }
                },
                adv_edun: {
                    required: true
                },
                adv_cist: {
                    required: true
                },
                ncih: {
                    required: true
                },

            },
            messages: {
                brch_advcust: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                adv_exc: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer",
                    min: "Please select Officer"
                },
                adv_cen: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                adv_grup: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Group",
                    min: "Please select Group",
                    remote: "Max Customer Count Exists"
                },
                adv_titl: {
                    required: 'Please select Title'
                },
                adv_funm: {
                    required: 'Please Enter Customer Name'
                },
                adv_nic: {
                    required: 'Please Enter NIC',
                    remote: 'NIC Already Exists'
                },
                adv_hoad: {
                    required: 'Please Enter Address'
                },
                adv_tele: {
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                adv_mobi: {
                    required: 'Please Enter Mobile',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    remote: 'Mobile Already Exists'
                },
                adv_edun: {
                    required: 'Please select Education '
                },
                adv_cist: {
                    required: 'Please select Civil Status'
                },
                ncih: {
                    required: 'This field is required.'
                },

            }
        });

        $('#form5').validate({
            // rules
            rules: {
                ncih: {
                    required: true
                }
            },
            messages: {
                ncih: {
                    required: 'Enter Net Cash In Hand'
                }
            }
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
                adv_dobi_edt: {
                    required: true
                },
                adv_hoad_edt: {
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

        //srchCustmer();
    });

    // advance customer add wizard button action
    $('#gotoStep2').on('click', function () {
        if ($('#form1').valid()) {              // code to reveal step 2
            $('#step_1').modal('hide');
            $('#step_2').modal('show');
        }
    });

    $('#gotoStep3').on('click', function () {
        if ($('#form1').valid()) {             // code to reveal step 3
            $('#step_2').modal('hide');
            $('#step_3').modal('show');
        }
    });

    $('#gotoStep4').on('click', function () {
        if ($('#form1').valid()) {             // code to reveal step 4
            $('#step_3').modal('hide');
            $('#step_4').modal('show');
        }
    });

    $('#gotoStep5').on('click', function () {
        if ($('#form1').valid()) {             // code to reveal step 5
            $('#step_4').modal('hide');
            $('#step_5').modal('show');
        }
    });

    $('#gotoStep6').on('click', function () {
        if ($('#form1').valid()) {             // code to reveal step 6
            $('#step_5').modal('hide');
            $('#step_6').modal('show');
        }
    });
    // end advance customer add wizard button action

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
        var grtp = document.getElementById('grtp').value;

        if (brn == '0') {
            document.getElementById('brch_cst').style.borderColor = "red";
            // } else if (grtp == 0) {
            //     document.getElementById('grtp').style.borderColor = "red";

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
                    {sWidth: '8%'},     // type
                    {sWidth: '5%'},     // stat
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchCust',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        stat: stat,
                        grtp: grtp
                    }
                }
            });
        }
    }

    function selectAddcust() {
        swal({
                title: "Please Select The \n Customer Registration Type..",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#3bdd59",
                cancelButtonColor: '#998822',
                confirmButtonText: "Normal",
                cancelButtonText: "Advance",
                closeOnConfirm: true,
                closeOnCancel: true
            }, function (isConfirm) {
                if (isConfirm) {
                    //alert("normal");
                    $('#modalAdd_nmcust').modal('show');
                } else {
                    //alert("advance");
                    $('#step_1').modal('show');
                }
            }
        );
    }

    function initname(fullnm) {  // normal cus register
        var fulnm = fullnm.trim();

        var res = fulnm.split(" ");
        var size = (res.length) - 1;

        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }

        var shrt = initials + res.pop();
        document.getElementById('init').value = shrt;
    }

    function initname2(fullnm) { // normal cus edite
        var fulnm = fullnm.trim();

        var res = fulnm.split(" ");
        var size = (res.length) - 1;

        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }

        var shrt = initials + res.pop();
        document.getElementById('init_edt').value = shrt;
    }

    function initnameAdv(fullnm) {  // advance cus register
        var fulnm = fullnm.trim();

        var res = fulnm.split(" ");
        var size = (res.length) - 1;

        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }

        var shrt = initials + res.pop();
        document.getElementById('adv_init').value = shrt;
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
    // NORMAL CUSTOMER
    function bnkDtil() {
        var bkdt = document.getElementById("bkdt");
        if (bkdt.checked == true) {
            document.getElementById("bnkDiv").style.display = "block";
        } else {
            document.getElementById("bnkDiv").style.display = "none";
        }
    }
    function bnkDtil_edt() {
        var bkdt = document.getElementById("bkdt_edt");
        if (bkdt.checked == true) {
            document.getElementById("bnkDiv_edt").style.display = "block";
        } else {
            document.getElementById("bnkDiv_edt").style.display = "none";
        }
    }

    // ADVANCE CUSTOMER
    function adv_bnkDtil() {
        var bkdt = document.getElementById("adv_bkdt");
        if (bkdt.checked == true) {
            document.getElementById("adv_bnkDiv").style.display = "block";
        } else {
            document.getElementById("bnkDiv").style.display = "none";
        }
    }
    function adv_bnkDtil_edt() {
        var bkdt = document.getElementById("adv_bkdt_edt");
        if (bkdt.checked == true) {
            document.getElementById("adv_bnkDiv_edt").style.display = "block";
        } else {
            document.getElementById("adv_bnkDiv_edt").style.display = "none";
        }
    }

    // normal customer scripet
    $("#normalCust_add").submit(function (e) { // add form
        e.preventDefault();
        if ($("#normalCust_add").valid()) {
            var formObj = $(this);
            var formURL = formObj.attr("action");
            var formData = new FormData(this);

            swal({
                title: "Processing...",
                text: "Image uploading and data saveing..",
                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                showConfirmButton: false
            });

            $.ajax({
                url: formURL,
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,

                success: function (data, textStatus, jqXHR) {
                    $('#modalAdd_nmcust').modal('hide');
                    srchCustmer();
                    swal({title: "", text: "Normal Customer Added successful", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function (data, jqXHR, textStatus, errorThrown) {
                    swal(" Added Failed!", "You", "error");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>user/cust_mng';
                    }, 2000);
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtNmcust(auid, typ) {
        if (typ == 'edt') {
            $('#hed').text("Update Customer :");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approval Customer :");
            $('#btnNm').text("Approvel");
            document.getElementById("func").value = '2';
        }
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
                    document.getElementById("brch_edtcust").value = response[i]['brco'];
                    document.getElementById("exc_edtcust").value = response[i]['exec'];
                    document.getElementById("cen_edtcust").value = response[i]['ccnt'];

                    // for auto load officer & center
                    getExeEdit(response[i]['brco'], 'exc_edtcust', response[i]['exec'], 'cen_adcust');
                    getCenterEdit(response[i]['exec'], 'cen_edtcust', response[i]['brco'], response[i]['ccnt']);

                    document.getElementById("gplg_edt").value = response[i]['gplg'];
                    document.getElementById("gplt_edt").value = response[i]['gplt'];
                    document.getElementById("titl_edt").value = response[i]['titl'];
                    document.getElementById("funm_edt").value = response[i]['funm'];
                    document.getElementById("init_edt").value = response[i]['init'];
                    document.getElementById("nic_edt").value = response[i]['anic'];
                    document.getElementById("gend_edt").value = response[i]['gend'];
                    document.getElementById("hoad_edt").value = response[i]['hoad'];
                    document.getElementById("tele_edt").value = response[i]['tele'];
                    document.getElementById("mobi_edt").value = response[i]['mobi'];
                    document.getElementById("dobi_edt").value = response[i]['dobi'];
                    document.getElementById("edun_edt").value = response[i]['edun'];
                    document.getElementById("cist_edt").value = response[i]['cist'];
                    document.getElementById("gsaw_edt").value = response[i]['gsaw'];

                    document.getElementById("bknm_edt").value = response[i]['bkid'];
                    document.getElementById("bkbr_edt").value = response[i]['bkbr'];
                    document.getElementById("acno_edt").value = response[i]['acno'];

                    if (response[i]['smst'] == 1) {
                        document.getElementById("smst_edt").checked = true;
                    } else {
                        document.getElementById("smst_edt").checked = false;
                    }

                    var rol = <?= $_SESSION['role']?>;
                        $('#cuno').text(response[i]['cuno']);
                    if ((response[i]['stat'] == 3 || response[i]['stat'] == 4 || response[i]['stat'] > 4)) {
                        document.getElementById("brch_edtcust").disabled = true;
                        document.getElementById("exc_edtcust").disabled = true;
                        document.getElementById("cen_edtcust").disabled = true;
                        document.getElementById("grup_edtcust").disabled = true;
                        //document.getElementById("nic_edt").disabled = true;
                        if(rol == 1 || rol == 2 ){
                            document.getElementById("nic_edt").readOnly  = false;
                        }else{
                            document.getElementById("nic_edt").readOnly  = true;
                        }
                        // CUSTOMER BANK DETAILS
                        document.getElementById("bkdt_edt").disabled = true;
                        document.getElementById("bknm_edt").disabled = true;
                        document.getElementById("bkbr_edt").disabled = true;
                        document.getElementById("acno_edt").disabled = true;

                    } else {
                        document.getElementById("brch_edtcust").disabled = false;
                        document.getElementById("exc_edtcust").disabled = false;
                        document.getElementById("cen_edtcust").disabled = false;
                        document.getElementById("grup_edtcust").disabled = false;
                        document.getElementById("nic_edt").readOnly  = false;
                        // CUSTOMER BANK DETAILS
                        document.getElementById("bkdt_edt").disabled = false;
                        document.getElementById("bknm_edt").disabled = false;
                        document.getElementById("bkbr_edt").disabled = false;
                        document.getElementById("acno_edt").disabled = false;
                    }

                    if (response[i]['bkdt'] == 1) {
                        document.getElementById("bkdt_edt").checked = true;
                        document.getElementById("bnkDiv_edt").style.display = 'block';
                    } else {
                        document.getElementById("bkdt_edt").checked = false;
                        document.getElementById("bnkDiv_edt").style.display = 'none';
                    }

                    var uimg = response[i]['uimg'];
                    document.getElementById("nmusrpict").value = uimg;
                    $("#avatar_2").fileinput('refresh', {
                        overwriteInitial: true,
                        maxFileSize: 1000,
                        cache: false,
                        showClose: false,
                        showCaption: false,
                        showUpload: true,
                        browseLabel: '',
                        removeLabel: '',
                        browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
                        removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                        removeTitle: 'Remove',
                        elErrorContainer: '#kv-avatar-errors-1',
                        msgErrorClass: 'alert alert-block alert-danger',
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/cust_profile/' + uimg + '" alt="Your Company Logo" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });

                    var $el = $('#grup_edtcust');
                    $($el).empty();
                    $el.append($("<option></option>")
                        .attr("value", response[i]['grno']).text(response[i]['grnm']));

                    document.getElementById("auid").value = response[i]['cuauid'];
                    document.getElementById("nm_stat").value = response[i]['stat'];
                }
            }
        })
    }

    $("#nmcust_edt").submit(function (e) { // edit form
        e.preventDefault();
        var funcc = document.getElementById("func").value;

        if ($("#nmcust_edt").valid()) {
            // var formObj = $(this);
            // var formURL = formObj.attr("action");
            var formData = new FormData(this);

            if (funcc == 1) {
                swal({
                        title: "Are you sure edit ?",
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

                            swal({
                                title: "Processing...",
                                text: "Image uploading and data saveing..",
                                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                                showConfirmButton: false
                            });

                            $('#modalEdt').modal('hide');
                            $.ajax({
                                url: '<?= base_url(); ?>user/normal_cust_edt',
                                type: 'POST',
                                data: formData,
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,

                                success: function (data, textStatus, jqXHR) {
                                    srchCustmer();
                                    swal({title: "", text: "Customer Update Success!", type: "success"},
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function (data, textStatus) {
                                    swal({title: "Update Error", text: textStatus, type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else if (funcc == 2) {

                var id = document.getElementById("auid").value;
                swal({
                        title: "Are you sure Approval ?",
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
                            swal({
                                title: "Processing...",
                                text: "Image uploading and data saveing..",
                                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                                showConfirmButton: false
                            });

                            $('#modalEdt').modal('hide');
                            $.ajax({
                                url: '<?= base_url(); ?>user/normal_cust_edt',
                                type: 'POST',
                                data: formData,
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (response) {

                                    $.ajax({
                                        url: '<?= base_url(); ?>user/getCustNo',
                                        type: 'post',
                                        data: {
                                            id: id
                                        },
                                        dataType: 'json',
                                        success: function (no) {
                                            //  if (response === true) {
                                            srchCustmer();
                                            swal({
                                                    title: "Approval Success",
                                                    text: "Customer No " + no[0]['cuno'],
                                                    type: "success"
                                                },
                                                function () {
                                                    location.reload();
                                                });
                                            // }
                                        }
                                    });
                                },
                                error: function (data, textStatus) {
                                    swal({title: "Approval Error", text: textStatus, type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
                alert("contact system admin");
            }
        } else {
            //  alert("Error");
        }
    });


    // advance customer scripet
    //$("#addAdvForm").on('click', function (e) { // add form
    $("#form1").submit(function (e) {
        e.preventDefault();
        if ($('#form1').valid()) {

            var formObj = $(this);
            //var formURL = formObj.attr("action");
            var formData = new FormData(this);

            swal({
                title: "Processing...",
                text: "Image uploading and data saveing..",
                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                showConfirmButton: false
            });
            $('#step_6').modal('hide');
            $.ajax({
                //url: formURL,
                url: '<?= base_url(); ?>user/addAdvnCust',
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {
                    swal({
                        title: "", text: "Advance Customer Added successful", type: "success"
                    }, function () {
                        location.reload();
                    });
                },
                error: function (data, jqXHR, textStatus, errorThrown) {

                    swal({
                        title: "", text: "Customer Added Failed", type: "error"
                    }, function () {
                        location.reload();
                    });
                }
            });
        }
    });

    function edtAdvncust(auid, typ) {
        if (typ == 'edt') {
            $('#hed21,#hed22,#hed23,#hed24,#hed25,#hed26').text("Advance Customer Update :");
            $('#btnNm2').text("Update");
            document.getElementById("func_advn").value = '1';

        } else if (typ == 'app') {
            $('#hed21,#hed22,#hed23,#hed24,#hed25,#hed26').text("Advance Customer Approval :");
            $('#btnNm2').text("Approval");
            document.getElementById("func_advn").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewAdvnCustmer",
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
                    document.getElementById("fmem_edt").value = response[i]['fmem'];
                    document.getElementById("mopr_edt").value = response[i]['mopr'];
                    document.getElementById("apre_edt").value = response[i]['apre'];
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

                    // BANK DETAILS
                    document.getElementById("adv_bknm_edt").value = response[i]['bkid'];
                    document.getElementById("adv_bkbr_edt").value = response[i]['bkbr'];
                    document.getElementById("adv_acno_edt").value = response[i]['acno'];

                    if (response[i]['bkdt'] == 1) {
                        document.getElementById("adv_bkdt_edt").checked = true;
                        document.getElementById("adv_bnkDiv_edt").style.display = 'block';
                    } else {
                        document.getElementById("adv_bkdt_edt").checked = false;
                        document.getElementById("adv_bnkDiv_edt").style.display = 'none';
                    }


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
                    var nic = response[i]['img_nic'];       //avatar_44
                    var grsc = response[i]['img_gscr'];     //avatar_55
                    var buslc = response[i]['img_bslc'];    //avatar_66
                    var othr = response[i]['img_othr'];     //avatar_77

                    document.getElementById("avt33").value = uspic;
                    document.getElementById("avt44").value = nic;
                    document.getElementById("avt55").value = grsc;
                    document.getElementById("avt66").value = buslc;
                    document.getElementById("avt77").value = othr;


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
                    $("#avatar_44").fileinput('refresh', {
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
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/user_document/' + nic + ' " alt="Customer Document" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });
                    $("#avatar_55").fileinput('refresh', {
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
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/user_document/' + grsc + ' " alt="Customer Document" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });
                    $("#avatar_66").fileinput('refresh', {
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
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/user_document/' + buslc + ' " alt="Customer Document" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });
                    $("#avatar_77").fileinput('refresh', {
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
                        defaultPreviewContent: '<img src="<?= base_url() ?>uploads/user_document/' + othr + ' " alt="Customer Document" style="width:160px">',
                        layoutTemplates: {
                            main2: '{preview} {remove} {browse}'
                        },
                        allowedFileExtensions: ["jpg", "png", "gif", "jpeg"]
                    });

                    var $el = $('#adv_grup_edt');
                    $($el).empty();
                    $el.append($("<option></option>")
                        .attr("value", response[i]['grno']).text(response[i]['grnm']));

                    document.getElementById("auid_advn").value = response[i]['cuid'];
                    document.getElementById("stat_advn").value = response[i]['stat'];
                }
            }
        })
    }

    // adv cust update
    $("#form_edt1").submit(function (e) { // edite form
        e.preventDefault();
        var func = document.getElementById("func_advn").value;

        if ($('#form_edt1').valid()) {
            var formObj = $(this);
            //var formURL = formObj.attr("action");
            var formData = new FormData(this);

            if (func == 1) {
                $('#advCust_edt6').modal('hide');
                swal({
                    title: "Processing...",
                    text: "Image uploading and data saveing..",
                    imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                    showConfirmButton: false
                });

                $.ajax({
                    url: '<?= base_url(); ?>user/advnCust_edt',
                    type: 'POST',
                    data: formData,
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data, textStatus, jqXHR) {
                        srchCustmer();
                        swal({title: "", text: "Advance Customer Update Success !", type: "success"},
                            function () {
                                location.reload();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            } else if (func == 2) {
                swal({
                        title: "Are you sure Approval ?",
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
                            swal.close();

                            swal({
                                title: "Processing...",
                                text: "Image uploading and data saveing..",
                                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                                showConfirmButton: false
                            });

                            $.ajax({
                                url: '<?= base_url(); ?>user/advnCust_edt',
                                type: 'POST',
                                data: formData,
                                mimeType: "multipart/form-data",
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function (data, textStatus, jqXHR) {
                                    srchCustmer();
                                    swal({title: "", text: "Advance Customer Approval Success!", type: "success"},
                                        function () {
                                             location.reload();
                                        });
                                },
                                error: function (textStatus) {
                                    swal({title: "Update Error", text: textStatus, type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
                alert("contact admin")
            }
        }
    });


    function checkNicSpc(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)
        var nicNo = nic;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById(vlid).style.borderColor = "#e6e8ed";
            document.getElementById(htid).disabled = false;

        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {
            document.getElementById(vlid).style.borderColor = "#e6e8ed";
            document.getElementById(htid).disabled = false;

        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";
            document.getElementById(htid).disabled = true;
        }
    }


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
                    document.getElementById("vew_grup").innerHTML = response[i]['grnm'];
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
                    // BANK DETAILS
                    if (response[i]['bkdt'] == 1) {
                        document.getElementById("vew_bkdt").innerHTML = " <span class='label label-success'>  YES  </span>";
                        document.getElementById("bk1").style.display = 'block';
                    } else {
                        document.getElementById("vew_bkdt").innerHTML = " <span class='label label-warning'>  NO  </span>";
                        document.getElementById("bk1").style.display = 'none';
                    }
                    document.getElementById("vew_bknm").innerHTML = response[i]['bknm'];
                    document.getElementById("vew_bkbr").innerHTML = response[i]['bkbr'];
                    document.getElementById("vew_acno").innerHTML = response[i]['acno'];
                    // END BANK DETAILS
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












