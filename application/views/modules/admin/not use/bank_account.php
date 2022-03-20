<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Master</li>
    <li class="active">Bank Account</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Bank Account </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Account
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
                                            onchange="chckBtn(this.value,'brch')">
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
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchBnkAcc()"
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
                                           id="dataTbBnkac" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">BANK</th>
                                            <th class="text-center">ACC NAME</th>
                                            <th class="text-center">ACC NO</th>
                                            <th class="text-center">CRE BY</th>
                                            <th class="text-center">CRE DATE</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Bank Account</h4>
            </div>
            <form class="form-horizontal" id="bnkacc_add" name="bnkacc_add"
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
                                                    <select class="form-control" name="brn" id="brn"
                                                            onchange="chckBtn(this.value,'brn')">
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
                                                <label class="col-md-4  control-label">Account Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acnm"
                                                               placeholder="Account Name"
                                                               id="acnm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Bank Name</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="bnk" id="bnk"
                                                            onchange="chckBtn(this.value,'bnk')">
                                                        <option value="0"> -- Select Bank --</option>
                                                        <?php
                                                        foreach ($bankinfo as $bank) {
                                                            echo "<option value='$bank->bkid'>$bank->bknm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account No</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acno"
                                                               placeholder="Account NO"
                                                               id="acno"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            <form class="form-horizontal" id="bnkacc_edt" name="bnkacc_edt"
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
                                                            onchange="chckBtn(this.value,'brch_edt')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acnm_edt"
                                                               placeholder="Account Name"
                                                               id="acnm_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Bank Name</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="bnk_edt" id="bnk_edt"
                                                            onchange="chckBtn(this.value,'bnk_edt')">
                                                        <option value="0"> Select Bank</option>
                                                        <?php
                                                        foreach ($bankinfo as $bank) {
                                                            echo "<option value='$bank->bkid'>$bank->bknm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account No</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acno_edt"
                                                               placeholder="Account NO"
                                                               id="acno_edt"/>
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

        $("#bnkacc_add").validate({  //  ADD VALIDATE
            rules: {
                brn: {
                    required: true,
                    notEqual: '0'
                },
                bnk: {
                    required: true,
                    notEqual: '0'
                },
                acnm: {
                    required: true
                },
                acno: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_bnkacno",
                        type: "post",
                        data: {
                            bnk: function () {
                                return $("#bnk").val();
                            },
                            acno: function () {
                                return $("#acno").val();
                            }
                        }
                    },
                    digits: true
                },
            },
            messages: {
                brn: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                bnk: {
                    required: 'Please select bank',
                    notEqual: 'Please select bank'
                },
                acnm: {
                    required: 'Enter account name'
                },
                acno: {
                    required: 'Enter account no',
                    remote: 'Account no already exists  '
                },
            }
        });

        $("#bnkacc_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                brch_edt: {
                    required: true,
                    notEqual: '0'
                },
                bnk_edt: {
                    required: true,
                    notEqual: '0'
                },
                acnm_edt: {
                    required: true
                },
                acno_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_bnkacno_edt",
                        type: "post",
                        data: {
                            bnk: function () {
                                return $("#bnk_edt").val();
                            },
                            acno: function () {
                                return $("#acno_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    },
                    digits: true
                },
            },
            messages: {
                brch_edt: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                bnk_edt: {
                    required: 'Please select bank',
                    notEqual: 'Please select bank'
                },
                acnm_edt: {
                    required: 'Enter account name'
                },
                acno_edt: {
                    required: 'Enter account no',
                    remote: 'Account no already exists  '
                },
            }
        });

    });

    // Search btn
    function srchBnkAcc() {
        var brch = document.getElementById('brch').value;

        $('#dataTbBnkac').DataTable().clear();
        $('#dataTbBnkac').DataTable({
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
            // "serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [1, 2, 3, 4, 5]},
                {className: "text-center", "targets": [0, 6, 7, 8]},
                {className: "text-nowrap", "targets": [1]}
            ],
            //"order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '7%'},
                {sWidth: '5%'},
                {sWidth: '7%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>admin/srchBnkAcc',
                type: 'post',
                data: {
                    brch: brch
                }
            }
        });
    }

    $("#addAcc").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#bnkacc_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addBnkAccoun",
                data: $("#bnkacc_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    srchBnkAcc();
                    swal({title: "", text: "Bank account added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Bank account added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtBnkacc(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Bank Account");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Bank Account");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewBnkacc",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brch_edt").value = response[0]['brco'];
                document.getElementById("bnk_edt").value = response[0]['bkid'];
                document.getElementById("acnm_edt").value = response[0]['acnm'];
                document.getElementById("acno_edt").value = response[0]['acno'];
                document.getElementById("auid").value = response[0]['acid'];
            }
        })
    }

    $("#bnkacc_edt").submit(function (e) {
        e.preventDefault();

        if ($("#bnkacc_edt").valid()) {
            swal({
                    title: "Are you sure ",
                    text: "Update bank account details",
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
                            url: "<?= base_url(); ?>admin/edtBankaccunt",
                            data: $("#bnkacc_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchBnkAcc();
                                swal({title: "", text: "Bank account update success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Update Failed", type: "error"},
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

    function rejecBnkAcc(id) {
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
                        url: '<?= base_url(); ?>admin/rejbnkAcc',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchBnkAcc();
                                swal({title: "Bank account inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Chart of account Not Inactive", "error");
                }
            });
    }

    function reactvBankacc(id) {
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
                        url: '<?= base_url(); ?>admin/reactBankacc',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchBnkAcc();
                                swal({title: "", text: "Bank account reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












