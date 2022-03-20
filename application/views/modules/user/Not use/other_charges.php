<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Other Charges</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Other Charges </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus" title="New General Voucher"></i></span> Add Charge
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Charge Add
                </h4>
            </div>
            <form class="form-horizontal" id="chrg_add" name="chrg_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">

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
                                                <label class="col-md-6 col-xs-12 control-label">Charge Amount</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control" placeholder="Amount"
                                                           id="cham" name="cham"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Remarks</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <textarea class="form-control" rows="3" id="remk" name="remk"></textarea>
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
                    <button type="button" class="btn btn-success" id="chrg_addBtn">Submit</button>
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
                                        <div class="col-md-6 col-xs-12">

                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Loan No</label>
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" placeholder="Loan No"
                                                           id="lnnoEdt" name="lnnoEdt"/>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn-sm btn-primary" id="srchEdt"><span>
                                                    <i class="fa fa-search"></i></span>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Charge Type</label>
                                                <div class="col-md-6">
                                                    <select class="form-control" name="chtpEdt" id="chtpEdt">
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
                                                <label class="col-md-6 col-xs-12 control-label">Charge Amount</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control" placeholder="Amount"
                                                           id="chamEdt" name="chamEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 col-xs-12 control-label">Remarks</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <textarea class="form-control" rows="3" id="remkEdt" name="remkEdt"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="lndtlDivEdt" style="display: block; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="cunmEdt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">NIC </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cunicEdt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cumobEdt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">DOC Charg </label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="doccEdt"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">INS Charg </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="inscEdt"></label>
                                                </div>
                                                <!--<div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="cumob"></label>
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" class="form-control" id="lnidEdt" name="lnidEdt"/>
                                    <input type="hidden" class="form-control" id="auid" name="auid"/>
                                    <input type="hidden" class="form-control" id="func" name="func"/>

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

        $("#chrg_add").validate({  // Add validation
            rules: {

                chtp: {
                    required: true,
                    notEqual: '0'
                },
                lnno: {
                    required: true,
                    notEqual: '0'
                },
                cham: {
                    required: true,
                    notEqual: '0'
                },
                remk: {
                    required: true,
                    notEqual: '0'
                },

            },
            messages: {

                chtp: {
                    required: 'Please select Charge Type',
                    notEqual: "Please select Charge Type",
                },
                lnno: {
                    required: 'Please enter loan no',
                    notEqual: "Please enter loan no"
                },
                cham: {
                    required: 'Please Enter Charge Amount ',
                    notEqual: "Please Enter Charge Amount"
                },
                remk: {
                    required: 'Please Enter Charge Remarks  ',
                    notEqual: "Please Enter Charge Remarks  "
                },

            }
        });

        $("#pymt_edt").validate({  // Edit validation
            rules: {

                chtpEdt: {
                    required: true,
                    notEqual: '0'
                },
                lnnoEdt: {
                    required: true,
                    notEqual: '0'
                },
                chamEdt: {
                    required: true,
                    notEqual: '0'
                },
                remkEdt: {
                    required: true,
                    notEqual: '0'
                },

            },
            messages: {

                chtpEdt: {
                    required: 'Please select Charge Type',
                    notEqual: "Please select Charge Type",
                },
                lnnoEdt: {
                    required: 'Please enter loan no',
                    notEqual: "Please enter loan no"
                },
                chamEdt: {
                    required: 'Please Enter Charge Amount ',
                    notEqual: "Please Enter Charge Amount"
                },
                remkEdt: {
                    required: 'Please Enter Charge Remarks  ',
                    notEqual: "Please Enter Charge Remarks  "
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
                    url: '<?= base_url(); ?>user/srchLnchrgs',
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

        $.ajax({
            url: '<?= base_url(); ?>user/getaddLndtils',
            type: 'POST',
            data: {
                lnno: lnno,
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

                } else {
                    document.getElementById("lndtlDiv").style.display = 'none';
                    document.getElementById("pyam").value = 0;
                    swal({title: "", text: "Invalide loan no", type: "warning"});
                }
            },
        });

    });

    // payment add
    $("#chrg_addBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#chrg_add").valid()) {
            $('#modalAdd').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addCharge",
                data: $("#chrg_add").serialize(),
                dataType: 'json',

                success: function (data) {
                    if (data === true) {
                        swal({title: "", text: "Loan Charges added success", type: "success"},
                            function () {
                                location.reload();
                            }
                        );
                    } else if (data === false) {
                        swal({title: "", text: "Loan Charges added Failed", type: "error"},
                            function () {
                                location.reload();
                            }
                        );
                    }
                },
                error: function () {
                    swal({title: "", text: "Loan Charges added Failed", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });
        } else {
        }
    });

    // EDIT CHARGES
    function edtChrgs(auid, typ) {

        if (typ == 'edt') {
            $('#hed').text("Update Charges");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approval Charges");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewChrge",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {

                    document.getElementById("chtpEdt").value = response[i]['chtp'];
                    document.getElementById("lnnoEdt").value = response[i]['acno'];
                    document.getElementById("cunmEdt").innerHTML = response[i]['init'];
                    document.getElementById("cunicEdt").innerHTML = response[i]['anic'];
                    document.getElementById("cumobEdt").innerHTML = response[i]['mobi'];
                    document.getElementById("doccEdt").innerHTML = numeral(response[i]['docg']).format('0,0.00');
                    document.getElementById("inscEdt").innerHTML = numeral(response[i]['docg']).format('0,0.00');

                    document.getElementById("chamEdt").value = response[i]['camt'];
                    document.getElementById("remkEdt").value = response[i]['remk'];
                    document.getElementById("lnidEdt").value = response[i]['lnid'];
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
                            url: "<?= base_url(); ?>User/edtCharge",
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

    // EDIT LOAN SEARCH OTHER LOAN
    $("#srchEdt").on('click', function (e) {
        e.preventDefault();
        var lnno = document.getElementById("lnnoEdt").value;

            $.ajax({
                url: '<?= base_url(); ?>user/getaddLndtils',
                type: 'POST',
                data: {
                    lnno: lnno,
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        document.getElementById("lndtlDivEdt").style.display = 'block';
                        document.getElementById("cunmEdt").innerHTML = data[0]['init'];
                        document.getElementById("cunicEdt").innerHTML = data[0]['anic'];
                        document.getElementById("cumobEdt").innerHTML = data[0]['mobi'];
                        document.getElementById("lnidEdt").value = data[0]['lnid'];

                    } else {
                        document.getElementById("lndtlDivEdt").style.display = 'none';
                        document.getElementById("chamEdt").value = 0;
                        swal({title: "", text: "Invalide loan no", type: "warning"});
                    }
                },
            });
    });


    // payment reject
    function rejecChrg(id) {
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
                        url: '<?= base_url(); ?>user/rejCharg',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            srchPymt();
                            swal({title: "", text: "Charges reject success", type: "success"});
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal("Failed!", "Charges Reject Failed", "error");
                            window.setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    });
                } else {
                    swal("Cancelled!", "Charges Not Rejected", "error");
                }
            });
    }


</script>












