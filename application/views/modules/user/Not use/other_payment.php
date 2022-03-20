<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Other Payment</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Other Payment </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus" title="New General Voucher"></i></span> Add Payment
                        </button> <!-- data-toggle="modal" data-target="#modalAdd" -->
                    <?php } ?>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<? /*= date("Y-m-d"); */ ?>">

                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Charge Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="pytp" id="pytp">
                                        <option value="all"> All Type</option>
                                        <?php
                                        foreach ($chginfo as $chg) {
                                            echo "<option value='$chg->chid'>$chg->modt</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<? /*= date("Y-m-d"); */ ?>">
                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4">
                            <!--<div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Voucher Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="vutp" id="vutp">
                                        <option value="all"> All Voucher</option>
                                        <option value="1"> Credit Voucher</option>
                                        <option value="2"> In cash Voucher</option>
                                        <option value="3"> General Voucher</option>

                                    </select>
                                </div>
                            </div>-->
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchPymt()"
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
                                           id="dataTbPaymt" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">PAY TYPE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center">MODE</th>
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

<!--  Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 75%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Payment Add
                </h4>
            </div>
            <form class="form-horizontal" id="pymt_add" name="pymt_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <!--<h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> Voucher Account
                                        Details </h3>-->

                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Payment Branch</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="pybrn" id="pybrn"
                                                            onchange="chckBtn(this.value,'pybrn');">
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
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Charge Type</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="chtp" id="chtp">
                                                        <option value="0"> -- Select Type --</option>
                                                        <?php
                                                        foreach ($chginfo as $chg) {
                                                            echo "<option value='$chg->chid'>$chg->modt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Loan No</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" placeholder="Loan No"
                                                           id="lnno" name="lnno"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn-sm btn-primary" id="srch"><span>
                                                    <i class="fa fa-search"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Pay Amount</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control" placeholder="Amount"
                                                           id="pyam" name="pyam"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Pay Type</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control" name="pymd" id="pymd">
                                                        <!--<option value="0"> -- Select Type --</option>-->
                                                        <?php
                                                        foreach ($payinfo as $pytp) {
                                                            if ($pytp->tmid == 8) {
                                                                echo "<option value='$pytp->tmid' selected>$pytp->dsnm</option>";
                                                            } else {
                                                                //echo "<option value='$pytp->tmid'>$pytp->dsnm</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Payee By</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="pyby" id="pyby">
                                                        <option value="0"> -- Select Pay By --</option>
                                                        <?php
                                                        foreach ($pay_by as $pyby) {
                                                            echo "<option value='$pyby->pyby'>$pyby->pydt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Payee At</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control" name="pyat" id="pyat">
                                                        <option value="0"> -- Select Pay At --</option>
                                                        <?php
                                                        foreach ($pay_at as $pyat) {
                                                            echo "<option value='$pyat->pyat'>$pyat->pydt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div id="lndtlDiv" style="display: none; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="cunm"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">NIC </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cunic"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cumob"></label>
                                                </div>
                                                <input type="hidden" class="form-control" id="lnid" name="lnid"/>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">DOC Charg </label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="docc"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">INS Charg </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="insc"></label>
                                                </div>
                                                <!--<div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cumob"></label>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="pymt_addBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- Edit / Approvel Model -->
<div class="modal" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead"><span id="hed"></span> <span
                            id="custyp"> </span></h4>
            </div>

            <form class="form-horizontal" id="pymt_edt" name="pymt_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Payment Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="pybrn_edt" id="pybrn_edt"
                                                            onchange="chckBtn(this.value,'pybrn_edt');">
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
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Charge Type</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control" name="chtp_edt" id="chtp_edt">
                                                        <option value="0"> -- Select Type --</option>
                                                        <?php
                                                        foreach ($chginfo as $chg) {
                                                            echo "<option value='$chg->chid'>$chg->modt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Loan No</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" placeholder="Loan No"
                                                           id="lnno_edt" name="lnno_edt"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn-sm btn-primary"
                                                            id="srch_edt"><span>
                                                    <i class="fa fa-search"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Pay Amount</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control" placeholder="Amount"
                                                           id="pyam_edt" name="pyam_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Pay Type</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control" name="pymd_edt" id="pymd_edt">
                                                        <?php
                                                        foreach ($payinfo as $pytp) {
                                                            if ($pytp->tmid == 8) {
                                                                echo "<option value='$pytp->tmid' selected>$pytp->dsnm</option>";
                                                            } else {
                                                                //echo "<option value='$pytp->tmid'>$pytp->dsnm</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Payee By</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="pyby_edt" id="pyby_edt">
                                                        <option value="0"> -- Select Pay By --</option>
                                                        <?php
                                                        foreach ($pay_by as $pyby) {
                                                            echo "<option value='$pyby->pyby'>$pyby->pydt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Payee At</label>
                                                <div class="col-md-6 col-xs-12">
                                                    <select class="form-control" name="pyat_edt" id="pyat_edt">
                                                        <option value="0"> -- Select Pay At --</option>
                                                        <?php
                                                        foreach ($pay_at as $pyat) {
                                                            echo "<option value='$pyat->pyat'>$pyat->pydt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="row" id="lndtlDiv_edt"
                                                 style="display: block;background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cunm_edt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">NIC </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cunic_edt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cumob_edt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">DOC Charg </label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="docc_edt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">INS Charg </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="insc_edt"></label>
                                                </div>
                                                <input type="hidden" class="form-control" id="lnid_edt"
                                                       name="lnid_edt"/>
                                                <input type="hidden" class="form-control" id="auid" name="auid"/>
                                                <input type="hidden" class="form-control" id="func" name="func"/>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--End View Model -->


</body>

<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbPaymt').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchPymt();

        $("#pymt_add").validate({  // Add validation
            rules: {
                pybrn: {
                    required: true,
                    notEqual: '0'
                },
                chtp: {
                    required: true,
                    notEqual: '0'
                },
                lnno: {
                    required: true,
                    notEqual: '0'
                },
                pyam: {
                    required: true,
                    notEqual: '0'
                },
                pyby: {
                    required: true,
                    notEqual: '0'
                },
                pyat: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                pybrn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                chtp: {
                    required: 'Please select Charge Type',
                    notEqual: "Please select Charge Type",
                },
                lnno: {
                    required: 'Please enter loan no',
                    notEqual: "Please enter loan no"
                },
                pyam: {
                    required: 'Please Enter Pay Amount ',
                    notEqual: "Please Enter Pay Amount"
                },
                pyby: {
                    required: 'Please select Pay By  ',
                    notEqual: "Please select Pay By  "
                },
                pyat: {
                    required: 'Select select Pay At',
                    notEqual: 'Select select Pay At',
                },
            }
        });

        $("#pymt_edt").validate({  // Edit validation
            rules: {
                pybrn_edt: {
                    required: true,
                    notEqual: '0'
                },
                chtp_edt: {
                    required: true,
                    notEqual: '0'
                },
                lnno_edt: {
                    required: true,
                    notEqual: '0'
                },
                pyam_edt: {
                    required: true,
                    notEqual: '0'
                },
                pyby_edt: {
                    required: true,
                    notEqual: '0'
                },
                pyat_edt: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                pybrn_edt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                chtp_edt: {
                    required: 'Please select Charge Type',
                    notEqual: "Please select Charge Type",
                },
                lnno_edt: {
                    required: 'Please enter loan no',
                    notEqual: "Please enter loan no"
                },
                pyam_edt: {
                    required: 'Please Enter Pay Amount ',
                    notEqual: "Please Enter Pay Amount "
                },
                pyby_edt: {
                    required: 'Please select Pay By ',
                    notEqual: "Please select Pay By "
                },
                pyat_edt: {
                    required: 'Select select Pay At',
                    notEqual: 'Select select Pay At',
                },
            }
        });

    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchPymt() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var pytp = document.getElementById('pytp').value;
        /* var vutp = document.getElementById('vutp').value;
         var frdt = document.getElementById('frdt').value;
         var todt = document.getElementById('todt').value;*/

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbPaymt').DataTable().clear();
            $('#dataTbPaymt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 4, 6]},
                    {className: "text-center", "targets": [0, 7, 8]},
                    {className: "text-right", "targets": [5]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "ASC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '10%'},   // customer name
                    {sWidth: '5%'},    // loan ni
                    {sWidth: '10%'},   // pay type
                    {sWidth: '5%'},    // amount
                    {sWidth: '8%'},    // date
                    {sWidth: '5%'},    // mode
                    {sWidth: '8%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchPymt',
                    type: 'post',
                    data: {
                        brn: brn,
                        pytp: pytp
                    }
                }
            });
        }
    }

    // load loan details
    $("#srch").on('click', function (e) {
        e.preventDefault();
        var lnno = document.getElementById("lnno").value;
        var chtp = document.getElementById("chtp").value;
        if (chtp != 0) {
            document.getElementById("chtp").style.borderColor = '';
            $.ajax({
                url: '<?= base_url(); ?>user/getLndtils',
                type: 'POST',
                data: {
                    lnno: lnno,
                    chtp: chtp
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        document.getElementById("lndtlDiv").style.display = 'block';
                        document.getElementById("cunm").innerHTML = data[0]['init'];
                        document.getElementById("cunic").innerHTML = data[0]['anic'];
                        document.getElementById("cumob").innerHTML = data[0]['mobi'];
                        document.getElementById("docc").innerHTML = numeral(data[0]['docg']).format('0,0.00');
                        document.getElementById("insc").innerHTML = numeral(data[0]['incg']).format('0,0.00');
                        document.getElementById("lnid").value = data[0]['lnid'];

                        // DOC & INS CHARGE PAYMENT
                        if (chtp == 1) {
                            document.getElementById("pyam").value = +data[0]['docg'] + +data[0]['incg'];
                        } else {
                            document.getElementById("pyam").value = 0;
                        }

                    } else {
                        document.getElementById("lndtlDiv").style.display = 'none';
                        document.getElementById("pyam").value = 0;
                        swal({title: "", text: "Invalide loan no", type: "warning"});
                    }
                },
            });
        } else {
            document.getElementById("chtp").style.borderColor = 'red';
        }
    });

    // payment add
    $("#pymt_addBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#pymt_add").valid()) {
            $('#modalAdd').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addPaymnt",
                data: $("#pymt_add").serialize(),
                dataType: 'json',

                success: function (data) {
                    if (data === true) {
                        swal({title: "", text: "Other payment added success", type: "success"},
                            function () {
                                location.reload();
                            }
                        );
                    } else if (data === false) {
                        swal({title: "", text: "Other payment added Failed", type: "error"},
                            function () {
                                location.reload();
                            }
                        );
                    } else if (data === 'alredy') {
                        swal({title: "", text: "This loan payment already added", type: "error"});
                    }

                },
                error: function () {
                    swal({title: "", text: "Other payment added Failed", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });
        } else {
        }
    });

    // edit payment
    function edtPymt(auid, typ) {

        if (typ == 'edt') {
            $('#hed').text("Update Payment");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approval Payment");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewPymnt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("pybrn_edt").value = response[i]['pybr'];
                    document.getElementById("chtp_edt").value = response[i]['pytp'];
                    document.getElementById("lnno_edt").value = response[i]['acno'];

                    document.getElementById("cunm_edt").innerHTML = response[i]['init'];
                    document.getElementById("cunic_edt").innerHTML = response[i]['anic'];
                    document.getElementById("cumob_edt").innerHTML = response[i]['mobi'];
                    document.getElementById("docc_edt").innerHTML = numeral(response[i]['docg']).format('0,0.00');
                    document.getElementById("insc_edt").innerHTML = numeral(response[i]['docg']).format('0,0.00');

                    document.getElementById("pyam_edt").value = response[i]['pymt'];
                    document.getElementById("pymd_edt").value = response[i]['pymd'];
                    document.getElementById("pyby_edt").value = response[i]['pyby'];
                    document.getElementById("pyat_edt").value = response[i]['pyat'];

                    document.getElementById("lnid_edt").value = response[i]['lnid'];
                    document.getElementById("auid").value = response[i]['auid'];

                }
            }
        })
    }

    // edit submit
    $("#pymt_edt").submit(function (e) {
        e.preventDefault();

        if ($("#pymt_edt").valid()) {
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
                        $('#modalEdit').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/edtPymnt",
                            data: $("#pymt_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchPymt();
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

    // edit load loan details
    $("#srch_edt").on('click', function (e) {
        e.preventDefault();
        var lnno = document.getElementById("lnno_edt").value;
        var chtp = document.getElementById("chtp_edt").value;
        if (chtp != 0) {
            document.getElementById("chtp_edt").style.borderColor = '';
            $.ajax({
                url: '<?= base_url(); ?>user/getLndtils',
                type: 'POST',
                data: {
                    lnno: lnno,
                    chtp: chtp
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        document.getElementById("lndtlDiv_edt").style.display = 'block';
                        document.getElementById("cunm_edt").innerHTML = data[0]['init'];
                        document.getElementById("cunic_edt").innerHTML = data[0]['anic'];
                        document.getElementById("cumob_edt").innerHTML = data[0]['mobi'];
                        document.getElementById("lnid_edt").value = data[0]['lnid'];
                        if (chtp == 1) {
                            document.getElementById("pyam_edt").value = data[0]['docg'];
                        } else if (chtp == 2) {
                            document.getElementById("pyam_edt").value = data[0]['incg'];
                        } else {
                            document.getElementById("pyam_edt").value = 0;
                        }
                    } else {
                        document.getElementById("lndtlDiv_edt").style.display = 'none';
                        document.getElementById("pyam_edt").value = 0;
                        swal({title: "", text: "Invalide loan no", type: "warning"});
                    }
                },
            });
        } else {
            document.getElementById("chtp_edt").style.borderColor = 'red';
        }
    });

    // VOUCHER APPROVAL btn
    $("#appbtn").on('click', function (e) {
        e.preventDefault();
        //var pytp = document.getElementById("pytp").value;
        document.getElementById("appbtn").disabled = true;
        $.ajax({
            url: '<?= base_url(); ?>user/vouApprvl',
            type: 'POST',
            data: $("#vou_approval").serialize(),
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                $('#modalView').modal('hide');
                document.getElementById("appbtn").disabled = false;
                srchPymt();
                swal({title: "", text: "Voucher approval done", type: "success"});
            },
            error: function (data, jqXHR, textStatus, errorThrown) {
                swal({title: "Failed", text: "Voucher approval Failed", type: "error"},
                    function () {
                        location.reload();
                    });
            }
        });
    });


    // payment reject
    function rejecPymt(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this process",
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
                        url: '<?= base_url(); ?>user/rejPymt',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            srchPymt();
                            swal({title: "", text: "Payment reject success", type: "success"});
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal("Failed!", "Payment Reject Failed", "error");
                            window.setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    });
                } else {
                    swal("Cancelled!", "Voucher Not Rejected", "error");
                }
            });
    }


</script>












