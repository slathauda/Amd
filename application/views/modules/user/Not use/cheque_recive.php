<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Master</li>
    <li class="active"> Recived Cheque</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Recived Cheque </strong></h3>

                    <?php /*if ($funcPerm[0]->inst == 1) { */ ?><!--
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New
                        </button>
                    --><?php /*} */ ?>
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
                        <!--<div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Bank Account</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="bnkacc" id="bnkacc"
                                            onchange="chckBtn(this.value,'bnkacc')">
                                        <option value="0"> Select Bank Account</option>
                                    </select>

                                </div>
                            </div>
                        </div>-->
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
                                           id="dataTbChq" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">REFERENCE NO</th>
                                            <th class="text-center">RECIVED BANK</th>
                                            <th class="text-center">CHEQUE NO</th>
                                            <th class="text-center">CHEQUE DATE</th>
                                            <th class="text-center">CHEQUE AMOUNT</th>
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


<!--  Add Model  -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> Cheque Deposit</span></h4>
            </div>
            <form class="form-horizontal" id="chq_depost" name="chq_depost"
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
                                                               readonly placeholder="Amount" id="dpamt_edt"/>
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
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn"><span id="btnNm"> Deposit</span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->


<script>
    $().ready(function () {

        $("#chq_depost").validate({  // BRANCH EDIT VALIDATE
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
        //var bkid = document.getElementById('bnkacc').value;

        $('#dataTbChq').DataTable().clear();
        $('#dataTbChq').DataTable({
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
                {className: "text-left", "targets": [1, 2, 3, 7]},
                {className: "text-center", "targets": [0, 5, 8, 9, 10]},
                {className: "text-right", "targets": [4, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[8, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchRecvChq',
                type: 'post',
                data: {
                    brch: brch
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


    function deposChq(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewRecvChq",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brch_edt").value = response[0]['brco'];
                document.getElementById("dpamt_edt").value = response[0]['cqam'];
                document.getElementById("auid").value = response[0]['cqid'];

                loadbnkacc(response[0]['brco'], 'bkac_edt', '');

                //document.getElementById("bkac_edt").value = response[0]['bkac'];
                //document.getElementById("nfpg_edt").value = response[0]['nfpg'];
            }
        })
    }

    // CHQ DEPOSIT SAVE
    $("#chq_depost").submit(function (e) {
        e.preventDefault();

        if ($("#chq_depost").valid()) {
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
                            url: "<?= base_url(); ?>user/addRecvChq",
                            data: $("#chq_depost").serialize(),
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












