<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Master</li>
    <li class="active"> Cash at Bank</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Cash At Bank </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Deposit
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
                                            onchange="chckBtn(this.value,'brch');loadbnkSrch(this.value,'bnkacc')">
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
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Bank Account</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="bnkacc" id="bnkacc"
                                            onchange="chckBtn(this.value,'bnkacc')">
                                        <option value="0"> --Select Account--</option>
                                        <?php
                                        foreach ($bnkaccinfo as $bnkacc) {
                                            echo "<option value='$bnkacc->acid'>$bnkacc->acnm | $bnkacc->acno</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchChbk()"
                                            class='btn-sm btn-primary panel-refresh' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbBkacc" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">BANK</th>
                                            <th class="text-center">ACC NAME</th>
                                            <th class="text-center">ACC NO</th>
                                            <th class="text-center">DEBIT</th>
                                            <th class="text-center">CREDIT</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">DEPOSIT BY</th>
                                            <th class="text-center">DEPOSIT DATE</th>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Cash Deposit</h4>
            </div>
            <form class="form-horizontal" id="bnk_deposit" name="bnk_deposit"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="bkbr" id="bkbr"
                                                            onchange="chckBtn(this.value,'bkbr');loadbnkacc(this.value,'bkac','')">
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
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Deposit Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="dpamt"
                                                               placeholder="Amount" id="dpamt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Bank Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="bkac" id="bkac"
                                                            onchange="chckBtn(this.value,'bkac')">
                                                        <option value="0"> --Select Bank Account--</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="remk"
                                                               placeholder="Remarks" id="remk"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addAcc">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  Edit  -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="cshDepst_edt" name="cshDepst_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brch_edt" id="brch_edt"
                                                            onchange="chckBtn(this.value,'brch_edt');loadbnkacc(this.value,'bkac_edt','')">
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
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Deposit Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="dpamt_edt"
                                                               placeholder="Amount" id="dpamt_edt"/>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Bank Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="bkac_edt" id="bkac_edt"
                                                            onchange="chckBtn(this.value,'bkac_edt')">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="remk_edt"
                                                               placeholder="Remarks" id="remk_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="auid" name="auid">
                                        <input type="hidden" id="func" name="func">
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Model -->


<script>
    $().ready(function () {

        $("#bnk_deposit").validate({  //  ADD VALIDATE

            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                bkac: {
                    required: true,
                    notEqual: '0'
                },
                dpamt: {
                    required: true,
                    currency: true,
                },

            },
            messages: {
                brch: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                bkac: {
                    required: 'Please select bank account',
                    notEqual: 'Please select bank account'
                },
                dpamt: {
                    required: 'Enter Deposit Amount',
                    currency: 'Enter Currency Amount',
                },
            }

        });

        $("#cshDepst_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                brch_edt: {
                    required: true,
                    notEqual: '0'
                },
                bkac_edt: {
                    required: true,
                    notEqual: 'all'
                },
                dpamt_edt: {
                    required: true,
                    currency: true,
                }
            },
            messages: {
                brch_edt: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                bkac_edt: {
                    required: 'Please select bank',
                    notEqual: 'Please select bank'
                },
                dpamt_edt: {
                    required: 'Enter Deposit Amount',
                    currency: 'Enter Currency Amount',
                }
            }
        });

        loadbnkacc('', 'bkac', '');
    });

    // Search btn
    function srchChbk() {
        var brch = document.getElementById('brch').value;
        var bkid = document.getElementById('bnkacc').value;

        $('#dataTbBkacc').DataTable().clear();
        $('#dataTbBkacc').DataTable({
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
                {className: "text-left", "targets": [1, 2, 3, 9]},
                {className: "text-center", "targets": [0, 7, 10, 11]},
                {className: "text-right", "targets": [5, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            //"order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '3%'},
                {sWidth: '8%'},
                {sWidth: '8%'},
                {sWidth: '8%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '10%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchBankcash',
                type: 'post',
                data: {
                    brch: brch,
                    bkid: bkid
                }
            }
        });
    }

    // LOAD BRANCH WISE BANK ACCOUNT
    function loadbnkacc(brid, htid, edt) {

      var  brid =  document.getElementById("bkbr").value;
        $.ajax({
            url: '<?= base_url(); ?>user/getBankAccount',
            type: 'post',
            data: {
                id: brid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#' + htid).empty();
                    $('#' + htid).append("<option value='0'> -- Select Account -- </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $('#' + htid);

                        if (edt == id) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#' + htid).empty();
                    $('#' + htid).append("<option value='0'>No Account</option>");
                }
            }
        });
    }

    function loadbnkSrch(brid, htid, edt) {

        //var  brid =  document.getElementById("bkbr").value;
        $.ajax({
            url: '<?= base_url(); ?>user/getBankAccount',
            type: 'post',
            data: {
                id: brid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#' + htid).empty();
                    $('#' + htid).append("<option value='0'> -- Select Account -- </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $('#' + htid);

                        if (edt == id) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#' + htid).empty();
                    $('#' + htid).append("<option value='0'>No Account</option>");
                }
            }
        });
    }

    // ADD NEW DEPOSIT
    $("#addAcc").click(function (e) {
        e.preventDefault();
        if ($("#bnk_deposit").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addNewDeposit",
                data: $("#bnk_deposit").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    srchChbk();
                    swal({title: "", text: "New deposit added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "New deposit added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
        }
    });

    // EDIT CASH DEPOSIT
    function edtCshDep(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Cash Deposit");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Deposit");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewDepstAmt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brch_edt").value = response[0]['brid'];
                document.getElementById("bkac_edt").value = response[0]['acid'];
                document.getElementById("dpamt_edt").value = response[0]['dbam'];
                document.getElementById("remk_edt").value = response[0]['remk'];
                document.getElementById("auid").value = response[0]['trid'];

                // CHQ DEPOSIT
                if (response[0]['pytp'] == 2) {
                    document.getElementById("dpamt_edt").readOnly = true;
                } else {
                    document.getElementById("dpamt_edt").readOnly = false;
                }
                loadbnkacc(response[0]['brid'], 'bkac_edt', response[0]['acid']);
            }
        })
    }

    // EDIT CASH DEPOSIT SAVE
    $("#cshDepst_edt").submit(function (e) {
        e.preventDefault();

        if ($("#cshDepst_edt").valid()) {
            swal({
                    title: "Are you sure this process",
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
                        $('#modalEdt').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/edtDepstAmt",
                            data: $("#cshDepst_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchChbk();
                                swal({title: "", text: "Cash deposit process success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Cash deposit Process failed", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    function rejecCshDep(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process ",
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
                        url: '<?= base_url(); ?>user/rejecCshDep',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChbk();
                                swal({title: "Cash Deposit Reject success !", text: "", type: "success"});
                            } else {
                                swal({title: "error !", text: response, type: "error"});
                            }
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "error", text: errorThrown, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled !", "Cheque book not Inactive", "error");
                }
            });
    }

    function reactvChqbk(id) {
        swal({
                title: "Are you sure ?",
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
                        url: '<?= base_url(); ?>user/reactChqbk',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChbk();
                                swal({title: "", text: "Cheque book reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












