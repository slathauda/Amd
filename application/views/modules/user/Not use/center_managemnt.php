<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.css"/>

<script type="text/javascript"
        src="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.js"></script>


<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Micro Finance</li>
    <li>CSU Module</li>
    <li class="active">CSU Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">


    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Center Management </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Center
                        </button>
                    <?php } ?>

                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getExe(this.value,'exc');chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
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
                                    <select class="form-control" name="exc" id="exc">
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
                                <label class="col-md-4 col-xs-6 control-label">Status Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="3">Pending</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 text-right"></label>
                                <div class="col-md-8 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="searchCenter()"
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
                                           id="dataTbCenter" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">CNT NO</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">COL DAY</th>
                                            <th class="text-center">CNT LEDER</th>
                                            <th class="text-center">CUST</th>
                                            <th class="text-center">LOANS</th>
                                            <th class="text-center">CUS MAX</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTION</th>
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

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Center Create</h4>
            </div>
            <form class="form-horizontal" id="cnt_add" name="cnt_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="brch_cnt" id="brch_cnt"
                                                            onchange="getExe(this.value,'cnt_exc');chckBtn(this.value,'brch_cnt')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch[brch_id] != '0') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Officer</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="cnt_exc" id="cnt_exc">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Center Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="cntnm"
                                                               placeholder="Center Name"
                                                               id="cntnm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Collection Day</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="coldy" id="coldy">
                                                            <?php
                                                            foreach ($cendays as $cndy) {
                                                                echo "<option value='$cndy->dyid'>$cndy->cday</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">From Time</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control timepicker24"
                                                               name="frotm" id="frotm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">To Time</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control timepicker24"
                                                               name="totm"
                                                               id="totm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Max Member</label>
                                                <div class="col-md-6 ">
                                                        <input type="text" class="form-control" id="mxmbr"
                                                               name="mxmbr"
                                                               value="<?php echo $policy[0]->pov2 ?>" readonly
                                                               placeholder="Max Member">
                                                    <input type="hidden" class="form-control" id="mimb" name="mimb"
                                                           value="<?= $policy[0]->pov1 ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">GPS Location</label>
                                                <div class="col-md-6 ">
                                                        <button type="button" onclick="getLocation()"
                                                                class="btn btn-info">Get
                                                            Location
                                                        </button>
                                                    <span id="sts2"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Longitude</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               placeholder="GPS Longitude" id="gplg" name="gplg"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Latitude</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               placeholder="GPS Latitude"
                                                               id="gplt" name="gplt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addCntr">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Center Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch</label>
                                            <label class="col-md-4  control-label" id="brch_cnt_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Officer</label>
                                            <label class="col-md-4  control-label" id="cnt_exc_vew"></label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Center Name</label>
                                            <label class="col-md-4  control-label" id="cntnm_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Collection Day</label>
                                            <label class="col-md-4  control-label" id="coldy_vew"></label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">From Time</label>
                                            <label class="col-md-4  control-label" id="frotm_vew"> </label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-4  control-label">To Time</label>
                                            <label class="col-md-4  control-label" id="totm_vew"> </label>

                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Max Member</label>
                                            <label class="col-md-4  control-label" id="mxmbr_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Remarks</label>
                                            <label class="col-md-8 control-label" id="remk_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Longitude</label>
                                            <label class="col-md-4  control-label" id="gplg_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Latitude</label>
                                            <label class="col-md-4 control-label" id="gplt_vew"></label>
                                        </div>
                                    </div>
                                </div>

                                <br>
                            </div>
                        </div>
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
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="cnt_edt" name="cnt_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch</label>
                                                <div class="col-md-6 ">

                                                    <select class="form-control" name="brch_cnt_edt"
                                                            id="brch_cnt_edt"
                                                            onchange="getExe(this.value,'cnt_exc_edt');chckBtn(this.value,'brch_cnt_edt')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch[brch_id] != '0') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="func" name="func"/>
                                        <input type="hidden" id="auid" name="auid"/>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Officer</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="cnt_exc_edt"
                                                            id="cnt_exc_edt">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Center Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="cntnm_edt"
                                                               id="cntnm_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Collection Day</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="coldy_edt"
                                                                id="coldy_edt">
                                                            <?php
                                                            foreach ($cendays as $cndy) {
                                                                echo "<option value='$cndy->dyid'>$cndy->cday</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">From Time</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control timepicker24"
                                                           name="frotm_edt" id="frotm_edt"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">To Time</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control timepicker24"
                                                           name="totm_edt"
                                                           id="totm_edt"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Max Member</label>
                                                <div class="col-md-6 ">
                                                        <input type="text" class="form-control" id="mxmbr_edt"
                                                               name="mxmbr_edt"
                                                               readonly
                                                               placeholder="Max Member">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">GPS Location</label>
                                                <div class="col-md-6 ">
                                                        <button type="button" onclick="getLocation_edt()"
                                                                class="btn btn-info">Get
                                                            Location
                                                        </button>
                                                    <span id="sts2_edt"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Longitude</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               placeholder="GPS Longitude" id="gplg_edt"
                                                               name="gplg_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Latitude</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               placeholder="GPS Latitude"
                                                               id="gplt_edt" name="gplt_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk_edt"
                                                              name="remk_edt"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addCntr">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit / approvel Model -->

<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbCenter').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        searchCenter();

        $("#cnt_add").validate({  // center add form validation
            rules: {
                brch_cnt: {
                    required: true,
                    notEqual: 'all'
                },
                cnt_exc: {
                    required: true,
                    notEqual: 'all'
                },
                cntnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_Centname",
                        type: "post",
                        data: {
                            cnnm: function () {
                                return $("#cntnm").val();
                            },
                            brnc: function () {
                                return $("#brch_cnt").val();
                            }
                        }
                    }
                },
                mxmbr: {
                    required: true,
                    digits: true
                },
                ngrp: {
                    required: true,
                    digits: true
                },

            },
            messages: {
                brch_cnt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                cnt_exc: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer"
                },
                cntnm: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                mxmbr: {
                    required: 'Please Enter Max Member ',
                    digits: 'This is not a valid Number'
                },
                ngrp: {
                    required: 'Please Enter No of Group ',
                    digits: 'This is not a valid Number'
                }
            }
        });

        $("#cnt_edt").validate({
            rules: {
                brch_cnt_edt: {
                    required: true,
                    notEqual: "all"
                },
                cnt_exc_edt: {
                    required: true,
                    notEqual: "all"
                },
                cntnm_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_Centname_edt",
                        type: "post",
                        data: {
                            cnnm: function () {
                                return $("#cntnm_edt").val();
                            },
                            brnc: function () {
                                return $("#brch_cnt_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },
                mxmbr_edt: {
                    required: true,
                    digits: true,
                    max: $("#mxmbr").val(),
                }
            },
            messages: {
                brch_cnt_edt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                cnt_exc_edt: {
                    required: 'Please select Officer',
                    notEqual: "Please select Officer"
                },
                cntnm_edt: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                mxmbr_edt: {
                    required: 'Please Enter Max Member ',
                    digits: 'This is not a valid Number',
                    max: "Max Member Limit "
                }
            }
        });

        //var input = $('#input-a');
        var input = $('#frotm,#totm,#frotm_edt,#totm_edt');
        input.clockpicker({
            autoclose: true
        });

    });

    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function searchCenter() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else if (exc == '0') {
            document.getElementById('exc').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            //  $('#dataTbCenter').DataTable().clear();

            $('#dataTbCenter').DataTable().clear();
            $('#dataTbCenter').DataTable({
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
                    {className: "text-left", "targets": [2, 4, 5, 6]},
                    {className: "text-center", "targets": [0, 1, 3, 7, 8, 9, 10, 11]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[10, "desc"]],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'}, //cnter
                    {sWidth: '5%'},
                    {sWidth: '13%'}, //cnt leder
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchCenter',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        stat: stat
                    }
                }
            });
        }
    }


    $("#addCntr").click(function (e) { // center add form
        e.preventDefault();
        if ($("#cnt_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addCenter",
                data: $("#cnt_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');

                    swal({title: "", text: " Center Added !", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal("Center Added Failed!", data.message, "error");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>user/cent_mng';
                    }, 2000);

                }
            });
        } else {
            //    mng_loan        alert("Error");
        }
    });

    function viewCnter(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewCenter",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brch_cnt_vew").innerHTML = response[i]['brnm'];
                    document.getElementById("cnt_exc_vew").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];
                    document.getElementById("cntnm_vew").innerHTML = response[i]['cnnm'];
                    document.getElementById("coldy_vew").innerHTML = response[i]['cday'];
                    document.getElementById("mxmbr_vew").innerHTML = response[i]['mcus'];
                    document.getElementById("frotm_vew").innerHTML = response[i]['frtm'];
                    document.getElementById("totm_vew").innerHTML = response[i]['totm'];
                    document.getElementById("remk_vew").innerHTML = response[i]['rmks'];
                    document.getElementById("gplg_vew").innerHTML = response[i]['gplg'];
                    document.getElementById("gplt_vew").innerHTML = response[i]['gplt'];
                    //document.getElementById("auid").value = response[i]['caid'];
                }
            }
        })
    }

    function edtCnter(auid, typ) {

        if (typ == 'edt') {
            $('#hed').text("Update Center");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approvel Center");
            $('#btnNm').text("Approvel");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewCenter",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brch_cnt_edt").value = response[i]['brco'];
                    // document.getElementById("cnt_exc_edt").value = response[i]['usid'];
                    document.getElementById("cntnm_edt").value = response[i]['cnnm'];
                    document.getElementById("coldy_edt").value = response[i]['cody'];
                    document.getElementById("mxmbr_edt").value = response[i]['mcus'];
                    document.getElementById("frotm_edt").value = response[i]['frtm'];
                    document.getElementById("totm_edt").value = response[i]['totm'];
                    document.getElementById("remk_edt").value = response[i]['rmks'];
                    document.getElementById("gplg_edt").value = response[i]['gplg'];
                    document.getElementById("gplt_edt").value = response[i]['gplt'];
                    document.getElementById("auid").value = response[i]['caid'];

                    // for auto load officer & center
                    getExeEdit(response[i]['brco'], 'cnt_exc_edt', response[i]['usid']);
                    //  getCenterEdit(response[i]['usid'], 'coll_cenEdt', response[i]['brco'], response[i]['ccnt']);
                }

            }
        })
    }

    // $("#edtbtn").click(function (e) {
    $("#cnt_edt").submit(function (e) {
        e.preventDefault();

        if ($("#cnt_edt").valid()) {
            swal({
                    title: "Are you sure?",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3bdd59",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/edtCenter",
                            data: $("#cnt_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                $('#modalEdt').modal('hide');

                                searchCenter();
                                swal({title: "", text: " Success!", type: "success"});

                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    function rejecCnter(id) {
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
                        url: '<?= base_url(); ?>user/rejCenter',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                searchCenter();
                                swal({title: "", text: "Center Reject Success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Center Not Rejected", "error");
                }
            });
    }

    function reactCnter(id) {
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
                        url: '<?= base_url(); ?>user/reatCenter',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                searchCenter();
                                swal({title: "", text: "Center Reactive Success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process Cancelled!", "", "error");
                }
            });
    }

</script>











