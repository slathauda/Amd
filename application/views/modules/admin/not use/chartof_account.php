<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Master</li>
    <li class="active">Chart Of Account</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Chart Of Account </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Account
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Main Account</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="macc" id="macc" onchange="">
                                        <option value="all"> All Account</option>
                                        <?php
                                        foreach ($mainacc as $macc) {
                                            echo "<option value='$macc->auid'>$macc->name</option>";
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
                                    <button type="button form-control  " onclick="srchChrtAcc()"
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
                                           id="dataTbChacc" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">MAIN ACCOUNT</th>
                                            <th class="text-center">CHART OF ACCOUNT NAME</th>
                                            <th class="text-center">IDENTIFIER</th>
                                            <th class="text-center">create by</th>
                                            <th class="text-center">create date</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Chart Of Account</h4>
            </div>
            <form class="form-horizontal" id="chacc_add" name="chacc_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Main Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="min_acc" id="min_acc" onchange="chckBtn(this.value,'min_acc')">
                                                        <option value="0"> Select Account</option>
                                                        <?php
                                                        foreach ($mainacc as $macc) {
                                                            echo "<option value='$macc->auid'>$macc->name</option>";
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

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account Idfr</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acidf"
                                                               placeholder="Account identifier"
                                                               id="acidf"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk" placeholder="Remarks"></textarea>
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
            <form class="form-horizontal" id="chrtacc_edt" name="chrtacc_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Main Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="min_accEdt" id="min_accEdt" onchange="chckBtn(this.value,'min_acc')">
                                                        <option value="0"> Select Account</option>
                                                        <?php
                                                        foreach ($mainacc as $macc) {
                                                            echo "<option value='$macc->auid'>$macc->name</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acnmEdt"
                                                               placeholder="Account Name"
                                                               id="acnmEdt"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account Idfr</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="acidfEdt"
                                                               placeholder="Account identifier"
                                                               id="acidfEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk_edt"
                                                              name="remk_edt" placeholder="Remarks"></textarea>
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

       // srchChrtAcc();

        $("#chacc_add").validate({  //  ADD VALIDATE
            rules: {
                min_acc: {
                    required: true,
                    notEqual : '0'
                },
                acnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_accname",
                        type: "post",
                        data: {
                            acnm: function () {
                                return $("#acnm").val();
                            }
                        }
                    },
                },
                acidf: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_accidfr",
                        type: "post",
                        data: {
                            acidf: function () {
                                return $("#acidf").val();
                            }
                        }
                    },
                    minlength : 3,
                    maxlength: 3,
                    digits :true
                }
            },
            messages: {
                min_acc: {
                    required:  'Please select main account',
                    notEqual :  'Please select main account'
                },
                acnm: {
                    required: 'Please enter account name',
                    remote: 'Account name already exists  '
                },
                acidf: {
                    required: 'Please enter account idfr',
                    remote: 'Idfr already exists  '
                }
            }
        });

        $("#chrtacc_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                min_accEdt: {
                    required: true,
                    notEqual : '0'
                },
                acnmEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_accname_edt",
                        type: "post",
                        data: {
                            acnm: function () {
                                return $("#acnmEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    },
                },
                acidfEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_accidfr_edt",
                        type: "post",
                        data: {
                            acidf: function () {
                                return $("#acidfEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    },
                    minlength : 3,
                    maxlength: 3,
                    digits :true
                }
            },
            messages: {
                min_accEdt: {
                    required:  'Please select main account',
                    notEqual :  'Please select main account'
                },
                acnmEdt: {
                    required: 'Please enter account name',
                    remote: 'Account name already exists  '
                },
                acidfEdt: {
                    required: 'Please enter account idfr',
                    remote: 'Idfr already exists  '
                }
            }
        });

    });

    // Search btn
    function srchChrtAcc() {
        var macc = document.getElementById('macc').value;

        $('#dataTbChacc').DataTable().clear();
        $('#dataTbChacc').DataTable({
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
                {className: "text-left", "targets": [1, 2]},
                {className: "text-center", "targets": [0, 3, 4, 5, 6, 7]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '7%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>admin/srchChrtAcc',
                type: 'post',
                data: {
                    macc: macc
                }
            }
        });
    }

    $("#addAcc").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#chacc_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addChrtAccoun",
                data: $("#chacc_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    srchChrtAcc();
                    swal({title: "", text: "Chart of account added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Chart of account added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtChrtacc(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Chart Of Account");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Chart Of Account");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewChrtacc",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("min_accEdt").value = response[0]['acid'];
                document.getElementById("acnmEdt").value = response[0]['hadr'];
                document.getElementById("acidfEdt").value = response[0]['idfr'];
                document.getElementById("remk_edt").value = response[0]['remk'];
                document.getElementById("auid").value = response[0]['auid'];
            }
        })
    }

    $("#chrtacc_edt").submit(function (e) {
        e.preventDefault();

        if ($("#chrtacc_edt").valid()) {
            swal({
                    title: "Are you sure ",
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
                            url: "<?= base_url(); ?>admin/edtChrtaccunt",
                            data: $("#chrtacc_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchChrtAcc();
                                swal({title: "Chart of account update success", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
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

    function rejecChrtAcc(id) {
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
                        url: '<?= base_url(); ?>admin/rejChtAcc',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChrtAcc();
                                swal({title: "Chart of account inactive success !", text: "", type: "success"});
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

    function reactvChrtacc(id) {
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
                        url: '<?= base_url(); ?>admin/reactChrtacc',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChrtAcc();
                                swal({title: "", text: "Chart of account reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












