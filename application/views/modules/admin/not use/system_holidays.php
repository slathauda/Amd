<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>System Setting</li>
    <li class="active">System Holidays</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> System Holidays </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add New
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbHoly" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Holiday reason </th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create System Holiday</h4>
            </div>
            <form class="form-horizontal" id="hlydy_add" name="hlydy_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Holidate</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="hldt"
                                                               placeholder="Holidate"
                                                               id="hldt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Holiday Reason</label>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Holiday </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="hldt_edt"
                                                               placeholder="Branch Name"
                                                               id="hldt_edt"/>
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

        srchHolydys();

        $("#hlydy_add").validate({  //  ADD VALIDATE
            rules: {
                hldt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_hldt",
                        type: "post",
                        data: {
                            hldt: function () {
                                return $("#hldt").val();
                            }
                        }
                    }
                }
            },
            messages: {
                hldt: {
                    required: 'Please enter system holiday',
                    remote: 'System holiday already exists  '
                }
            }
        });

        $("#holydy_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                hldt_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_hldt_edt",
                        type: "post",
                        data: {
                            hldt_edt: function () {
                                return $("#hldt_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
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
    function srchHolydys() {

        $('#dataTbHoly').DataTable().clear();
        $('#dataTbHoly').DataTable({
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
                {className: "text-center", "targets": [0, 3, 4, 5,6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[4, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>admin/srchHolydys',
                type: 'post',
                data: {}
            }
        });
    }

    $("#addHolydy").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#hlydy_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addHolydy",
                data: $("#hlydy_add").serialize(),
                dataType: 'json',
                success: function (data) {

                    $('#modalAdd').modal('hide');
                    srchHolydys();
                    swal({title: "", text: "System holiday added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "System holiday added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtHolydt(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Holidays");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Relationship");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewHolydt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("hldt_edt").value = response[0]['date'];
                document.getElementById("remk_edt").value = response[0]['hors'];
                document.getElementById("auid").value = response[0]['hoid'];
            }
        })
    }

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
                            url: "<?= base_url(); ?>admin/edtHolydays",
                            data: $("#holydy_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchHolydys();
                                swal({title: "System holiday update success", text: "", type: "success"},
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
                        url: '<?= base_url(); ?>admin/rejHoliday',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchHolydys();
                                swal({title: "Relationship inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Relationship Not Inactive", "error");
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
                                srchHolydys();
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












