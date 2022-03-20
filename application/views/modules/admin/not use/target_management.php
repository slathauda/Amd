<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li> Advance Setting</li>
    <li class="active">Target Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Target Management </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>  <!--  !empty($funcPerm) &&  -->
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Target
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brnc" id="brnc"
                                            onchange="getExe(this.value,'ofcr',ofcr.value,'cent');chckBtn(this.value,'brnc')">
                                        <!--                                        <option value='0'>All Branch</option>-->
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Select Duration</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="per" id="per">
                                        <option value="all"> All Duration</option>
                                        <?php
                                        foreach ($targtdurat as $trg) {
                                            echo "<option value='$trg->auid'>$trg->dunm</option>";
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
                                    <select class="form-control" name="ofcr" id="ofcr"
                                            onchange="getCenter(this.value,'cent',brnc.value);chckBtn(this.value,'ofcr')">
                                        <option value='0'>--Select Officer--</option>
                                        <?php
                                        foreach ($execinfo as $exe) {
                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cent" id="cent"
                                            onchange="chckBtn(this.value,'cent')">
                                        <option value='0'>--Select Center--</option>
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchTarg()"
                                            class='btn-sm btn-primary panel-refresh' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
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
                                   id="dataTbTarg" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">TYPE</th>
                                    <th class="text-center">PERSON</th>
                                    <th class="text-center">DURATION</th>
                                    <th class="text-center">FROM DATE</th>
                                    <th class="text-center">TO DATE</th>
                                    <th class="text-center">AMOUNT</th>
                                    <th class="text-center">MODE</th>
                                    <th class="text-center">CREATE BY</th>
                                    <th class="text-center">DATE</th>
                                    <th class="text-center">ARCHIVE</th>
                                    <th class="text-center">ARCH %</th>
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
<!-- END PAGE CONTENT WRAPPER -->

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Add New Target</h4>
            </div>
            <form class="form-horizontal" id="targt_add" name="targt_add"
                  action="" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Target Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="trtp" id="trtp"
                                            onchange="chngTyp(this.value);chckBtn(this.value,'trtp')">
                                        <option value="0"> Select Type</option>
                                        <?php
                                        foreach ($targettype as $trtp) {
                                            echo "<option value='$trtp->auid'>$trtp->tpnm</option>";
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
                            <div class="form-group" id="cmpDv" style="display: none;">
                                <label class="col-md-4 col-xs-6 control-label">Company</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cmpn" id="cmpn"
                                            onchange="chckBtn(this.value,'cmpn')">
                                        <?php
                                        foreach ($compinfo as $comp) {
                                            echo "<option value='$comp->cmid'>$comp->cmne</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="brnDv" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getExe(this.value,'exc',exc.value,'cen');chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            if ($branch['brch_id'] == 'all') {
                                            } else {
                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="cntDv" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cen" id="cen"
                                            onchange="chckBtn(this.value,'cen')">
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group" id="exeDv" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc" id="exc"
                                            onchange="getCenter(this.value,'cen',brch.value);chckBtn(this.value,'exc')">
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
                                <label class="col-md-4 col-xs-6 control-label">Target Duration</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="durt" id="durt"
                                            onchange="chckBtn(this.value,'durt')">
                                        <option value="0"> Select Duration</option>
                                        <?php
                                        foreach ($targtdurat as $trg) {
                                            echo "<option value='$trg->auid'>$trg->dunm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4  control-label">From Date</label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control datepicker" name="frdt"
                                           id="frdt" value="<?= date('Y-m-d'); ?>"
                                           onchange="calDura(this.value,durt.value)"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4  control-label">Target Amount </label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control" name="tamt"
                                           id="tamt"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4  control-label">To Date</label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control datepicker" name="todt"
                                           id="todt" value="<?= date('Y-m-d'); ?>"/>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
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
                <h4 class="modal-title" id="largeModalHead">Target Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Target Type</label>
                                            <label class="col-md-4  control-label" id="trtp_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch</label>
                                            <label class="col-md-4  control-label" id="brn_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Officer</label>
                                            <label class="col-md-4  control-label" id="exe_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Center</label>
                                            <label class="col-md-4  control-label" id="cnt_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Target Duration</label>
                                            <label class="col-md-4  control-label" id="trdu_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Target Amount</label>
                                            <label class="col-md-4 control-label" id="tram_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">From Date</label>
                                            <label class="col-md-4  control-label" id="frdt_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">To Date</label>
                                            <label class="col-md-4 control-label" id="todt_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Create By</label>
                                            <label class="col-md-4  control-label" id="crby_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Create Date</label>
                                            <label class="col-md-8 control-label" id="crdt_vew"></label>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> </span> <span id="cuno"> </span></h4>
            </div>

            <form class="form-horizontal" id="targt_edt" name="targt_edt"
                  action="" method="post">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Target Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="trtp_edt" id="trtp_edt"
                                            onchange="chngTyp_edt(this.value);chckBtn(this.value,'trtp_edt')">
                                        <option value="0"> Select Type</option>
                                        <?php
                                        foreach ($targettype as $trtp) {
                                            echo "<option value='$trtp->auid'>$trtp->tpnm</option>";
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
                            <div class="form-group" id="cmpDv_edt" style="display: none;">
                                <label class="col-md-4 col-xs-6 control-label">Company</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cmpn_edt" id="cmpn_edt"
                                            onchange="chckBtn(this.value,'cmpn_edt')">
                                        <?php
                                        foreach ($compinfo as $comp) {
                                            echo "<option value='$comp->cmid'>$comp->cmne</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="brnDv_edt" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch_edt" id="brch_edt"
                                            onchange="getExe(this.value,'exc_edt',exc_edt.value,'cen_edt');chckBtn(this.value,'brch_edt')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            if ($branch['brch_id'] == 'all') {
                                            } else {
                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="cntDv_edt" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cen_edt" id="cen_edt"
                                            onchange="chckBtn(this.value,'cen_edt')">
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="form-group" id="exeDv_edt" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc_edt" id="exc_edt"
                                            onchange="getCenter(this.value,'cen_edt',brch_edt.value);chckBtn(this.value,'exc_edt')">
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
                                <label class="col-md-4 col-xs-6 control-label">Target Duration</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="durt_edt" id="durt_edt"
                                            onchange="chckBtn(this.value,'durt_edt')">
                                        <option value="0"> Select Duration</option>
                                        <?php
                                        foreach ($targtdurat as $trg) {
                                            echo "<option value='$trg->auid'>$trg->dunm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4  control-label">From Date</label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control datepicker" name="frdt_edt"
                                           id="frdt_edt" value="<?= date('Y-m-d'); ?>"
                                           onchange="calDura_edt(this.value,durt_edt.value)"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4  control-label">Target Amount </label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control" name="tamt_edt"
                                           id="tamt_edt"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4  control-label">To Date</label>
                                <div class="col-md-6 ">
                                    <input type="text" class="form-control datepicker" name="todt_edt"
                                           id="todt_edt" value="<?= date('Y-m-d'); ?>"/>
                                </div>
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" id="func" name="func">
                    <input type="hidden" id="auid" name="auid">
                    <input type="hidden" id="stat" name="stat">
                    <button type="submit" class="btn btn-success" id="btnNm"></button>
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
        $('#dataTbTarg').DataTable({
            destroy: true
        });

        $("#targt_add").validate({  // add form validation
            rules: {
                trtp: {
                    required: true,
                    notEqual: '0'
                },
                cmpn: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                brch: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                exc: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                cen: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                durt: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                tamt: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 10
                },
                todt: {
                    required: true,
                    notEqual: $("#frdt").val()
                }
            },
            messages: {
                trtp: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                cmpn: {
                    required: 'Please select Company Name',
                    notEqual: "Please select Company Name",
                    min: "Please select Officer"
                },
                brch: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                exc: {
                    required: 'Please Select Officer',
                    notEqual: "Please Select Officer",
                    min: "Please Select Officer"
                },
                cen: {
                    required: 'Please Select Center',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                durt: {
                    required: 'Please Select Duration',
                    notEqual: "Please select Duration",
                    min: "Please select Duration"
                },
                tamt: {
                    required: 'Please Enter Amount',
                    digits: 'This is not a Amount',
                    minlength: 'This is not a Amount',
                    maxlength: 'This is not a Amount'
                },
                todt: {
                    required: 'Please select Target Duration',
                    notEqual: "Select Target Start Date"
                }
            }
        });
        $("#targt_edt").validate({  // edt form validation
            rules: {
                trtp: {
                    required: true,
                    notEqual: '0'
                },
                cmpn: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                brch: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                exc: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                cen: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                durt: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                tamt: {
                    required: true,
                    digits: true,
                    minlength: 1,
                    maxlength: 10
                },
                todt: {
                    required: true,
                    notEqual: $("#frdt").val()
                }
            },
            messages: {
                trtp: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                cmpn: {
                    required: 'Please select Company Name',
                    notEqual: "Please select Company Name",
                    min: "Please select Officer"
                },
                brch: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    min: "Please select Branch"
                },
                exc: {
                    required: 'Please Select Officer',
                    notEqual: "Please Select Officer",
                    min: "Please Select Officer"
                },
                cen: {
                    required: 'Please Select Center',
                    notEqual: "Please select Center",
                    min: "Please select Center"
                },
                durt: {
                    required: 'Please Select Duration',
                    notEqual: "Please select Duration",
                    min: "Please select Duration"
                },
                tamt: {
                    required: 'Please Enter Amount',
                    digits: 'This is not a Amount',
                    minlength: 'This is not a Amount',
                    maxlength: 'This is not a Amount'
                },
                todt: {
                    required: 'Please select Target Duration',
                    notEqual: "Select Target Start Date"
                }
            }
        });
        srchTarg();
    });


    $("#targt_add").submit(function (e) {
        e.preventDefault();

        if ($("#targt_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/chkTarget",
                data: $("#targt_add").serialize(),
                dataType: 'json',
                success: function (response) {

                    if (response == 0) { // Already No Target
                        swal({
                                title: "Are you sure Add This Target?",
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
                                        url: "<?= base_url(); ?>admin/addTarget",
                                        data: $("#targt_add").serialize(),
                                        dataType: 'json',
                                        success: function (response) {
                                            swal("Success!", " ", "success");
                                            window.setTimeout(function () {
                                                location = '<?= base_url(); ?>admin/target';
                                            }, 3000);
                                        },
                                        error: function () {
                                            swal("Failed!", "", "error");
                                            window.setTimeout(function () {
                                                // location = '<?= base_url(); ?>admin/branch';
                                            }, 2000);
                                        }
                                    });
                                } else {
                                    swal("Cancelled", " ", "error");
                                }
                            });
                    } else {
                        swal("Same Target Already Exiest !", "", "error");
                    }
                },
                error: function () {
                    swal("Failed!", "", "error");
                    window.setTimeout(function () {
                        // location = '<?= base_url(); ?>admin/branch';
                    }, 2000);
                }
            });
        }
    });

    function chngTyp(tp) {

        if (tp == 1) {
            document.getElementById('cmpDv').style.display = "block";
            document.getElementById('brnDv').style.display = "none";
            document.getElementById('exeDv').style.display = "none";
            document.getElementById('cntDv').style.display = "none";
        } else if (tp == 2) {
            document.getElementById('cmpDv').style.display = "none";
            document.getElementById('brnDv').style.display = "block";
            document.getElementById('exeDv').style.display = "none";
            document.getElementById('cntDv').style.display = "none";
        } else if (tp == 3) {
            document.getElementById('cmpDv').style.display = "none";
            document.getElementById('brnDv').style.display = "block";
            document.getElementById('exeDv').style.display = "block";
            document.getElementById('cntDv').style.display = "none";
        } else if (tp == 4) {
            document.getElementById('cmpDv').style.display = "none";
            document.getElementById('brnDv').style.display = "block";
            document.getElementById('exeDv').style.display = "block";
            document.getElementById('cntDv').style.display = "block";
        } else {
            document.getElementById('cmpDv').style.display = "none";
            document.getElementById('brnDv').style.display = "none";
            document.getElementById('exeDv').style.display = "none";
            document.getElementById('cntDv').style.display = "none";
        }
    }

    function chngTyp_edt(tp) {

        if (tp == 1) {
            document.getElementById('cmpDv_edt').style.display = "block";
            document.getElementById('brnDv_edt').style.display = "none";
            document.getElementById('exeDv_edt').style.display = "none";
            document.getElementById('cntDv_edt').style.display = "none";
        } else if (tp == 2) {
            document.getElementById('cmpDv_edt').style.display = "none";
            document.getElementById('brnDv_edt').style.display = "block";
            document.getElementById('exeDv_edt').style.display = "none";
            document.getElementById('cntDv_edt').style.display = "none";
        } else if (tp == 3) {
            document.getElementById('cmpDv_edt').style.display = "none";
            document.getElementById('brnDv_edt').style.display = "block";
            document.getElementById('exeDv_edt').style.display = "block";
            document.getElementById('cntDv_edt').style.display = "none";
        } else if (tp == 4) {
            document.getElementById('cmpDv_edt').style.display = "none";
            document.getElementById('brnDv_edt').style.display = "block";
            document.getElementById('exeDv_edt').style.display = "block";
            document.getElementById('cntDv_edt').style.display = "block";
        } else {
            document.getElementById('cmpDv_edt').style.display = "none";
            document.getElementById('brnDv_edt').style.display = "none";
            document.getElementById('exeDv_edt').style.display = "none";
            document.getElementById('cntDv_edt').style.display = "none";
        }
    }

    function calDura(frdt, prid) {
        if (prid == 1) {
            var duprd = 365;
        } else if (prid == 2) {
            var duprd = 185;
        } else if (prid == 3) {
            var duprd = 120;
        } else if (prid == 4) {
            var duprd = 30;
        }
        var date = new Date(frdt);
        var newdate = new Date(date);
        newdate.setDate(newdate.getDate() + +duprd);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        var calTodt = y + '-' + mm + '-' + dd;

        document.getElementById('todt').value = formatDate(calTodt);
    }

    function calDura_edt(frdt, prid) {
        if (prid == 1) {
            var duprd = 365;
        } else if (prid == 2) {
            var duprd = 185;
        } else if (prid == 3) {
            var duprd = 120;
        } else if (prid == 4) {
            var duprd = 30;
        }
        var date = new Date(frdt);
        var newdate = new Date(date);
        newdate.setDate(newdate.getDate() + +duprd);
        var dd = newdate.getDate();
        var mm = newdate.getMonth() + 1;
        var y = newdate.getFullYear();
        var calTodt = y + '-' + mm + '-' + dd;

        document.getElementById('todt_edt').value = formatDate(calTodt);
    }

    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // Search btn
    function srchTarg() {
        var brch = document.getElementById('brnc').value;
        var exe = document.getElementById('ofcr').value;
        var cnt = document.getElementById('cent').value;
        var per = document.getElementById('per').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brch == 0) {
            document.getElementById('brnc').style.borderColor = "red";
        } else {
            document.getElementById('brnc').style.borderColor = "";
            $('#dataTbTarg').DataTable().clear();
            $('#dataTbTarg').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                //"orderable": false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 8, 9]},
                    {className: "text-center", "targets": [0, 4, 7, 12]},
                    {className: "text-right", "targets": [0, 5, 6, 10, 11]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[8, "ASC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'}, //typ
                    {sWidth: '20%'},
                    {sWidth: '5%'}, // duration
                    {sWidth: '5%'}, // from
                    {sWidth: '5%'}, // to
                    {sWidth: '10%'}, // amt
                    {sWidth: '5%'}, //
                    {sWidth: '5%'}, //cr by
                    {sWidth: '5%'},//   date
                    {sWidth: '5%'}, //
                    {sWidth: '5%'}, // %
                    {sWidth: '20%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchTarget',
                    type: 'post',
                    data: {
                        brch: brch,
                        exe: exe,
                        cnt: cnt,
                        per: per,
                        frdt: frdt,
                        todt: todt
                    }
                }
            });
        }
    }

    // Edit view data
    function edtTrgt(auid, typ) {
        if (typ == 'edt') {
            $('#hed').text("Update Target");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approval Target");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/taretDtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("trtp_edt").value = response[0]['trtp'];
                chngTyp_edt(response[0]['trtp']);

                document.getElementById("cmpn_edt").value = response[0]['cmid'];
                document.getElementById("brch_edt").value = response[0]['brid'];
                //document.getElementById("exc_edt").value = response[0]['usid'];
                //document.getElementById("cen_edt").value = response[0]['cnnt'];

                // for auto load officer & center
                getExeEdit(response[0]['brid'], 'exc_edt', response[0]['usid'], 'cen_edt');
                getCenterEdit(response[0]['usid'], 'cen_edt', response[0]['brid'], response[0]['cnnt']);

                document.getElementById("durt_edt").value = response[0]['dura'];
                document.getElementById("frdt_edt").value = response[0]['frdt'];
                document.getElementById("todt_edt").value = response[0]['todt'];
                document.getElementById("tamt_edt").value = response[0]['amut'];
                document.getElementById("auid").value = response[0]['auid'];
                document.getElementById("stat").value = response[0]['stat'];

            }
        })
    }

    // edite & approval submit
    $("#targt_edt").submit(function (e) { // add form
        e.preventDefault();

        var func = document.getElementById("func").value;

        if ($("#targt_edt").valid()) {
            if (func == 1) {
                // alert('AA');
                $.ajax({
                    url: '<?= base_url(); ?>Admin/target_update',
                    type: 'POST',
                    data: $("#targt_edt").serialize(),
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        swal("Success!", " Target Update Success", "success");
                        window.setTimeout(function () {
                            location = '<?= base_url(); ?>admin/target';
                        }, 3000);
                    },
                    error: function (data, jqXHR, textStatus, errorThrown) {
                        swal("Failed!", "Target Update", "error");
                        window.setTimeout(function () {
                            location = '<?= base_url(); ?>admin/target';
                        }, 2000);
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
                            $.ajax({
                                url: '<?= base_url(); ?>Admin/target_update',
                                type: 'POST',
                                data: $("#targt_edt").serialize(),
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {
                                    swal("Success!", "Target Approval Success ", "success");
                                    window.setTimeout(function () {
                                        location = '<?= base_url(); ?>admin/target';
                                    }, 3000);
                                },
                                error: function () {
                                    swal("Failed!", "", "error");
                                    window.setTimeout(function () {
                                        // location = '<?= base_url(); ?>admin/target';
                                    }, 2000);
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
                alert("contact admin")
            }
        } else {
            //  alert("Error");
        }
    });

    // Target Cancel
    function rejecTarget(id) {
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
                    swal("Rejected!", "Target Reject Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>Admin/rejTarget',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    location = '<?= base_url(); ?>admin/target';
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Target Not Cancel", "error");
                }
            });
    }

    function viewTarg(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Admin/taretDtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("trtp_vew").innerHTML = response[i]['tpnm'] + ' Target';
                    document.getElementById("brn_vew").innerHTML = response[i]['brnm'];
                    if (response[i]['fnme'] == null) {
                        document.getElementById("exe_vew").innerHTML = '- -';
                    } else {
                        document.getElementById("exe_vew").innerHTML = response[i]['fnme'];
                    }

                    if (response[i]['cnnm'] == null) {
                        document.getElementById("cnt_vew").innerHTML = '- -';
                    } else {
                        document.getElementById("cnt_vew").innerHTML = response[i]['cnnm'];
                    }

                    document.getElementById("trdu_vew").innerHTML = response[i]['dunm'];
                    document.getElementById("tram_vew").innerHTML = numeral(response[i]['amut']).format('0,0.00');
                    document.getElementById("frdt_vew").innerHTML = response[i]['frdt'];
                    document.getElementById("todt_vew").innerHTML = response[i]['todt'];

                    document.getElementById("crby_vew").innerHTML = response[i]['crusr'];
                    document.getElementById("crdt_vew").innerHTML = response[i]['crdt'];
                }
            }
        })
    }


</script>












