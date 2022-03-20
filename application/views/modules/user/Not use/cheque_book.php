<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Master</li>
    <li class="active"> Cheque Book</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Cheque Book </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Book
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
                                            onchange="chckBtn(this.value,'brch');loadbnkacc(this.value,'bnkacc')">
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
                                        <option value="all"> All Account</option>
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
                                           id="dataTbChbk" width="100%">
                                        <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">NO</th>
                                            <th rowspan="2" class="text-center">BRANCH</th>
                                            <th rowspan="2" class="text-center">ACCOUNT NO</th>
                                            <th rowspan="2" class="text-center">LEAF STRT</th>
                                            <th rowspan="2" class="text-center">NO OF LEAF</th>

                                            <th colspan="3" class="text-center">LAST ISSUE</th>
                                            <th colspan="2" class="text-center">CREATE</th>

                                            <th rowspan="2" class="text-center">STATUS</th>
                                            <th rowspan="2" class="text-center">ACTION</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">LEAF NO</th>
                                            <th class="text-center">BY</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center"> BY</th>
                                            <th class="text-center"> DATE</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Cheque Book</h4>
            </div>
            <form class="form-horizontal" id="chqbk_add" name="chqbk_add"
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
                                                    <select class="form-control" name="brch" id="brch"
                                                            onchange="chckBtn(this.value,'brch');loadbnkacc(this.value,'bkac','')">
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
                                                <label class="col-md-4  control-label">Start Page No</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="stpg"
                                                               placeholder="Book Start Page NO" id="stpg"/>
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
                                                        <option value="0"> --Select Account--</option>
                                                        <?php
                                                        foreach ($bnkaccinfo as $bnkacc) {
                                                            echo "<option value='$bnkacc->acid'>$bnkacc->acnm | $bnkacc->acno</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of page</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="nfpg"
                                                               placeholder="No of page" id="nfpg"/>
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
            <form class="form-horizontal" id="chqbk_edt" name="chqbk_edt"
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
                                                <label class="col-md-4  control-label">Start Page No</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="stpg_edt"
                                                               placeholder="Book Start Page NO" id="stpg_edt"/>
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
                                                <label class="col-md-4  control-label">No of page</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="nfpg_edt"
                                                               placeholder="No of page" id="nfpg_edt"/>
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

        $("#chqbk_add").validate({  //  ADD VALIDATE

            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                bkac: {
                    required: true,
                    notEqual: 'all'
                },
                stpg: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                },
                nfpg: {
                    required: true,
                    digits: true
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
                stpg: {
                    required: 'Enter cheque page start no'
                },
                nfpg: {
                    required: 'Enter no of page'
                },
            }

        });

        $("#chqbk_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                brch_edt: {
                    required: true,
                    notEqual: '0'
                },
                bkac_edt: {
                    required: true,
                    notEqual: 'all'
                },
                stpg_edt: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                },
                nfpg_edt: {
                    required: true,
//                    remote: {
//                        url: "<?//= base_url(); ?>//admin/chk_bnkacno_edt",
//                        type: "post",
//                        data: {
//                            bnk: function () {
//                                return $("#bnk_edt").val();
//                            },
//                            acno: function () {
//                                return $("#acno_edt").val();
//                            },
//                            auid: function () {
//                                return $("#auid").val();
//                            }
//                        }
//                    },
                    digits: true
                },
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
                stpg_edt: {
                    required: 'Enter account name'
                },
                nfpg_edt: {
                    required: 'Enter account no'
                },
            }
        });

    });

    // Search btn
    function srchChbk() {
        var brch = document.getElementById('brch').value;
        var bkid = document.getElementById('bnkacc').value;

        $('#dataTbChbk').DataTable().clear();
        $('#dataTbChbk').DataTable({
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
                {className: "text-left", "targets": [1, 2, 3, 5, 7, 8, 9]},
                {className: "text-center", "targets": [0, 4, 6, 10, 11]},
                {className: "text-nowrap", "targets": [1]}
            ],
            //"order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '7%'},
                {sWidth: '8%'},
                {sWidth: '7%'},
                {sWidth: '8%'},
                {sWidth: '5%'},
                {sWidth: '10%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchChqbook',
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
//                    $('#' + htid).append("<option value='0'> --Select Account-- </option>");
                    $('#' + htid).append("<option value='all'> All Account </option>");
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

    $("#addAcc").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#chqbk_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addCheqbook",
                data: $("#chqbk_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    srchChbk();
                    swal({title: "", text: "Cheque book added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Cheque book added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtChqbk(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Cheque Book");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Cheque Book");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewChqbk",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brch_edt").value = response[0]['brid'];
                document.getElementById("bkac_edt").value = response[0]['bkac'];
                document.getElementById("stpg_edt").value = response[0]['pgst'];
                document.getElementById("nfpg_edt").value = response[0]['nfpg'];

                document.getElementById("auid").value = response[0]['cqid'];

                loadbnkacc(response[0]['brid'], 'bkac_edt', response[0]['bkac']);
            }
        })
    }

    $("#chqbk_edt").submit(function (e) {
        e.preventDefault();

        if ($("#chqbk_edt").valid()) {
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
                            url: "<?= base_url(); ?>user/edtChqbook",
                            data: $("#chqbk_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchChbk();
                                swal({title: "", text: "Cheque book process success", type: "success"},
                                    function () {
                                        // location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Process failed", type: "error"},
                                    function () {
                                        //location.reload();
                                    });
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    function rejecChqbk(id) {
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
                        url: '<?= base_url(); ?>user/rejChqbk',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChbk();
                                swal({title: "Cheque book inactive success !", text: "", type: "success"});
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












