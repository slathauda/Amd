<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>System Setting</li>
    <li class="active">Use Level Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Use Level Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <!--<button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Level
                        </button>-->
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
                                           id="dataTbUlvl" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">level</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> User Level Create</h4>
            </div>
            <form class="form-horizontal" id="lvl_add" name="lvl_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Level Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="lvnm"
                                                               placeholder="Branch Name"
                                                               id="lvnm"/>
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
                    <button type="submit" class="btn btn-success">Submit</button>
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
            <form class="form-horizontal" id="uslvl_edt" name="uslvl_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Level Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="lvnm_edt"
                                                               placeholder="Branch Name"
                                                               id="lvnm_edt"/>
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

        srchUsrlvl();

        $("#lvl_add").validate({  // BRANCH ADD VALIDATE
            rules: {
                lvnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_lvnm",
                        type: "post",
                        data: {
                            lvnm: function () {
                                return $("#lvnm").val();
                            }
                        }
                    }
                }
            },
            messages: {
                lvnm: {
                    required: 'Please enter level name',
                    remote: 'Level name already exists  '
                }
            }
        });

        $("#uslvl_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                lvnm_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_lvnm_edt",
                        type: "post",
                        data: {
                            lvnm_edt: function () {
                                return $("#lvnm_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                }
            },
            messages: {
                lvnm_edt: {
                    required: 'Please enter level name',
                    remote: 'Level name already exists  '
                }
            }
        });

    });

    // Search btn
    function srchUsrlvl() {

        $('#dataTbUlvl').DataTable().clear();
        $('#dataTbUlvl').DataTable({
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
                {className: "text-center", "targets": [0, 3, 4, 5]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[4, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>admin/srchUsrlevl',
                type: 'post',
                data: {}
            }
        });
    }

    $("#lvl_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#lvl_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addUserlvl",
                data: $("#lvl_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    srchUsrlvl();
                    swal({title: "", text: "User level added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "User level added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function edtLvl(auid) {
        $('#hed').text("Update User Level");
        $('#btnNm').text("Update");
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewUslvl",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("lvnm_edt").value = response[0]['lvnm'];
                document.getElementById("remk_edt").value = response[0]['remk'];
                document.getElementById("auid").value = response[0]['id'];
            }
        })
    }

    $("#uslvl_edt").submit(function (e) {
        e.preventDefault();

        if ($("#uslvl_edt").valid()) {
            swal({
                    title: "Are you sure update branch?",
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
                            url: "<?= base_url(); ?>admin/edtUselvel",
                            data: $("#uslvl_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchUsrlvl();
                                swal({title: "User Level Update Success", text: "", type: "success"},
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

    function rejecUsrLv(id) {
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
                        url: '<?= base_url(); ?>admin/rejUserLvel',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchUsrlvl();
                                swal({title: "User level inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "User Level Not Inactive", "error");
                }
            });
    }

    function reactvUsrLv(id) {
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
                        url: '<?= base_url(); ?>admin/reactUserLvel',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchUsrlvl();
                                swal({title: "", text: "User level reactive success!", type: "success"});
                            }
                        }
                    });

                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












