<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>System Schedule</li>
    <li class="active">Branch Schedule</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Branch Schedule </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add New
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
                                    <button type="button form-control  " onclick="srchSch()"
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
                                           id="dataTbBrnSch" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">branch</th>
                                            <th class="text-center">Holiday reason</th>
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
    <div class="modal-dialog modal-lg" style="width: 50%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Branch Holiday</h4>
            </div>
            <form class="form-horizontal" id="hlydy_add" name="hlydy_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-8 col-xs-6">
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
                                                <label class="col-md-4  control-label"> Date</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="hldt"
                                                               value="<?= date('Y-m-d') ?>" id="hldt"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-8 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk" placeholder="Remarks"></textarea>
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
                    <button type="submit" class="btn btn-success" id="addHolydy">Submit</button>
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
            <form class="form-horizontal" id="holydy_edt" name="holydy_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-8 col-xs-6">
                                                    <select class="form-control" name="brn_edt" id="brn_edt"
                                                            onchange="chckBtn(this.value,'brn_edt')">
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
                                                <label class="col-md-4  control-label"> Date</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker"
                                                               name="hldt_edt" readonly
                                                               value="<?= date('Y-m-d') ?>" id="hldt_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-8 ">
                                                    <textarea class="form-control" rows="4" id="remk_edt"
                                                              name="remk_edt" placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="hidden" id="func_edt" name="func_edt">
                                            <input type="hidden" id="auid" name="auid">
                                        </div>
                                    </div>

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

        srchSch();

        $("#hlydy_add").validate({  //  ADD VALIDATE
            rules: {
                hldt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnSche",
                        type: "post",
                        data: {
                            hldt: function () {
                                return $("#hldt").val();
                            },
                            brn: function () {
                                return $("#brn").val();
                            }
                        }
                    },
                    minDate: true
                },
                remk: {
                    required: true,
                },
                brn: {
                    required: true,
                    notEqual: '0'
                }
            },
            messages: {
                hldt: {
                    required: 'Please enter system holiday',
                    remote: 'System holiday already exists  '
                },
                brn: {
                    required: 'Please Select Branch',
                    notEqual: 'Please Select Branch  '
                }
            }
        });

        $("#holydy_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                hldt_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnSche_edt",
                        type: "post",
                        data: {
                            hldt_edt: function () {
                                return $("#hldt_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            },
                            brn: function () {
                                return $("#brn").val();
                            }
                        }
                    }
                },
                remk_edt: {
                    required: true,
                }
            },
            messages: {
                hldt_edt: {
                    required: 'Please enter system holiday',
                    remote: 'System holiday already exists  '
                }
            }
        });

    });

    // Search btn
    function srchSch() {

        var brn = document.getElementById("brch").value;
        if (brn == 0) {
            document.getElementById("brch").style.borderColor = "red";
        } else {
            document.getElementById("brch").style.borderColor = "";

            $('#dataTbBrnSch').DataTable().clear();
            $('#dataTbBrnSch').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3]},
                    {className: "text-center", "targets": [0, 4, 5, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[1, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchSchBrnc',
                    type: 'post',
                    data: {
                        brch: brn
                    }
                }
            });
        }
    }

    // ADD SUBMIT
    $("#addHolydy").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#hlydy_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addScheBrnc",
                data: $("#hlydy_add").serialize(),
                dataType: 'json',
                success: function (data) {

                    $('#modalAdd').modal('hide');
                    swal({title: "", text: "Branch holiday added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Branch holiday added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    // EDITE VIEW
    function edtHolyBrn(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Holidays");
            $('#btnNm').text("Update");
            document.getElementById("func_edt").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Relationship");
            $('#btnNm').text("Approval");
            document.getElementById("func_edt").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewschdBrnc",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brn_edt").value = response[0]['brcd'];
                document.getElementById("hldt_edt").value = response[0]['date'];
                document.getElementById("remk_edt").value = response[0]['hors'];
                document.getElementById("auid").value = response[0]['hoid'];
            }
        })
    }

    // EDITE SUBMIT
    $("#holydy_edt").submit(function (e) {
        e.preventDefault();

        if ($("#holydy_edt").valid()) {
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
                            url: "<?= base_url(); ?>admin/edtHolydaysBrn",
                            data: $("#holydy_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "Branch Schedule update success", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal("Failed!", "Branch Schedule update Failed", "error");
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

    function rejecHoly(id) {
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
                        url: '<?= base_url(); ?>admin/rejHolidayBrn',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                swal({title: "Branch schedule inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Branch schedule not inactive", "error");
                }
            });
    }

    function reactvHolydy(id) {
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
                        url: '<?= base_url(); ?>admin/reactHolyday',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                swal({title: "", text: "Holiday reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












