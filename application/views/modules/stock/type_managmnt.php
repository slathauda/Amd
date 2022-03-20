<!DOCTYPE html>
<html class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="">Stock Component</a></li>
                        <li class="active"><strong>Type (Size) Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Type (Size) Management</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Category</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="ctgr" id="ctgr"
                                            onchange="chckBtn(this.value,'ctgr')">
                                        <option value="all"> All Category</option>
                                        <?php
                                        foreach ($ctgryinfo as $ctgry) {
                                            echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchType()"
                                            class='btn-sm btn-primary' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table datatable table-bordered table-striped table-actions"
                                   id="dataTbTyp" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">CATEGORY</th>
                                    <th class="text-center">TYPE</th>
                                    <th class="text-center">CREATE BY</th>
                                    <th class="text-center">CREATE DATE</th>
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
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Type Create</h4>
            </div>
            <form class="form-horizontal" id="typ_add" name="typ_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Category</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="ctnm" id="ctnm"
                                                            onchange="chckBtn(this.value,'ctnm')">
                                                        <option value="0">-- Select Category --</option>
                                                        <?php
                                                        foreach ($ctgryinfo as $ctgry) {
                                                            echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Type Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           placeholder="Type Name"
                                                           name="tpnm" id="tpnm"/>
                                                </div>
                                            </div>
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
                    <button type="submit" id="addBtn" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">View Center Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch</label>
                                            <label class="col-md-4  control-label" id="brch_cnt_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Executive</label>
                                            <label class="col-md-4  control-label" id="cnt_exc_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Center Name</label>
                                            <label class="col-md-4  control-label" id="cntnm_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Collection Day</label>
                                            <label class="col-md-4  control-label" id="coldy_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">From Time</label>
                                            <label class="col-md-4  control-label" id="frotm_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">To Time</label>
                                            <label class="col-md-4  control-label" id="totm_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Max Member</label>
                                            <label class="col-md-4  control-label" id="mxmbr_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Remark</label>
                                            <label class="col-md-4 control-label" id="remk_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Edit || Approval -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="mdel_edt" name="mdel_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Category</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="ctnmEdt" id="ctnmEdt"
                                                                onchange="chckBtn(this.value,'ctnmEdt')">
                                                            <option value="0">-- Select Category --</option>
                                                            <?php
                                                            foreach ($ctgryinfo as $ctgry) {
                                                                echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Type Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               placeholder="Model Name"
                                                               name="tpnmEdt" id="tpnmEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remkEdt"
                                                              name="remkEdt" placeholder="Remarks"></textarea>
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
                    <button type="submit" class="btn btn-success" id="edtBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit || Approval Model -->

<!-- END CONTAINER -->
</html>

<script>
    $().ready(function () {

        srchType();

        //  ADD VALIDATE
        $("#typ_add").validate({
            rules: {
                ctnm: {
                    required: true,
                    notEqual: 0,
                },
                tpnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_tpnm",
                        type: "post",
                        data: {
                            ctnm: function () {
                                return $("#ctnm").val();
                            },
                            tpnm: function () {
                                return $("#tpnm").val();
                            }
                        }
                    }
                }
            },
            messages: {
                ctnm: {
                    required: 'Please select category',
                    notEqual: 'Please select category '
                },
                tpnm: {
                    required: 'Please enter Type name',
                    remote: 'Type name already exists  '
                }
            }
        });

        //  Edit VALIDATE
        $("#mdel_edt").validate({
            rules: {
                ctnmEdt: {
                    required: true,
                    notEqual: 0,
                },
                tpnmEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_tpnm_edt",
                        type: "post",
                        data: {
                            tpnm: function () {
                                return $("#tpnmEdt").val();
                            },
                            ctnm: function () {
                                return $("#ctnmEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                }
            },
            messages: {
                ctnmEdt: {
                    required: 'Please select category',
                    notEqual: 'Please select category '
                },
                tpnmEdt: {
                    required: 'Please enter Type name',
                    remote: 'Type name already exists  '
                }
            }
        });
    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    /* SEARCH */
    function srchType() {
        var ctgr = document.getElementById('ctgr').value;
        var stat = document.getElementById('stat').value;

        $('#dataTbTyp').DataTable().clear();
        $('#dataTbTyp').DataTable({
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
                {className: "text-center", "targets": [0, 4, 5, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[0, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>stock/srchType',
                type: 'post',
                data: {
                    ctgr: ctgr,
                    stat: stat,
                }
            }
        });
    }

    /* ADD */
    $("#addBtn").click(function (e) {
        e.preventDefault();
        if ($("#typ_add").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/chk_tpnm",
                data: $("#typ_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data == true) {

                        $('#modalAdd').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>stock/addType",
                            data: $("#typ_add").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchType();
                                swal({title: "", text: "Size (Type) added success!", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Size (Type) added Failed!", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });

                    } else {
                        swal({title: "", text: "Size (Type) Name already exists", type: "info"});
                    }
                },
            });
        }
    });

    /* EDIT VIEW*/
    function edtType(auid) {
        $('#hed').text("Update Size");
        $('#btnNm').text("Update");
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/vewType",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("ctnmEdt").value = response[0]['ctid'];
                document.getElementById("tpnmEdt").value = response[0]['tpnm'];
                document.getElementById("remkEdt").value = response[0]['remk'];
                document.getElementById("auid").value = response[0]['tpid'];
            }
        })
    }

    /* EDIT SUBMIT*/
    $("#edtBtn").click(function (e) {
        e.preventDefault();

        if ($("#mdel_edt").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/chk_tpnm_edt",
                data: {
                    tpnm: function () {
                        return $("#tpnmEdt").val();
                    },
                    ctnm: function () {
                        return $("#ctnmEdt").val();
                    },
                    auid: function () {
                        return $("#auid").val();
                    }
                },
                dataType: 'json',
                success: function (data) {
                    if (data == true) {

                        swal({
                                title: "Are you sure update model ?",
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
                                        url: "<?= base_url(); ?>stock/edtType",
                                        data: $("#mdel_edt").serialize(),
                                        dataType: 'json',
                                        success: function (data) {
                                            srchType();
                                            swal({title: "Type Update Success", text: "", type: "success"},
                                                function () {
                                                    location.reload();
                                                });
                                        },
                                        error: function () {
                                            swal({title: "Type Update Failed", text: "", type: "error"},
                                                function () {
                                                    location.reload();
                                                });
                                        }
                                    });
                                } else {
                                    swal("Cancelled", " ", "error");
                                }
                            });

                    } else {
                        swal({title: "", text: "Type Name already exists", type: "info"});
                    }
                },
            });
        }
    });

    /* REJECT*/
    function rejecTyp(id) {
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
                        url: '<?= base_url(); ?>stock/rejType',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchType();
                                swal({title: "Type inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Type Not Inactive", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvTyp(id) {
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
                        url: '<?= base_url(); ?>stock/reactType',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchType();
                                swal({title: "", text: "Type reactive success!", type: "success"});
                            }
                        }
                    });

                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>