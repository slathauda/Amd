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
                        <li><a href="">System Component</a></li>
                        <li class="active"><strong>Branch Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Branch Management</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>

                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat"
                                            onchange="chckBtn(this.value,'stat')">
                                        <option value="-"> -- Select --</option>
                                        <option value="1"> Active </option>
                                        <option value="0"> Inactive </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brnc" id="brnc"
                                            onchange="chckBtn(this.value,'brnc')">

                                        <option> xx</option>
                                        <option> xx</option>
                                        <option> xx</option>
                                        <?php

                                        //foreach ($branchinfo as $branch) {
                                        // if ($branch[brch_id] == 0) {
                                        // } else {
                                        //   echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        // }
                                        // }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="uslv" id="uslv"
                                            onchange="chckBtn(this.value,'uslv')">
                                        <option value='all'>-- All Level --</option>
                                        <option> xx</option>
                                        <option> xx</option>
                                        <?php
                                        //foreach ($userlvl as $uslv) {
                                        //}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="uslv" id="uslv"
                                            onchange="chckBtn(this.value,'uslv')">
                                        <option value='all'>-- All Level --</option>
                                        <option> xx</option>
                                        <option> xx</option>
                                        <?php
                                        //foreach ($userlvl as $uslv) {
                                        //}
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="uslv" id="uslv"
                                            onchange="chckBtn(this.value,'uslv')">
                                        <option value='all'>-- All Level --</option>
                                        <option> xx</option>
                                        <option> xx</option>
                                        <?php
                                        //foreach ($userlvl as $uslv) {
                                        //}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchUser()"
                                            class='btn-sm btn-primary panel-refresh' id="">
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
                            <table id="dataTbBrnc" class="table table-striped dt-responsive  table-actions"
                                   cellspacing="0"
                                   width="100%">

                                <!--                                <table class="table datatable table-bordered table-striped table-actions"-->
                                <!--                                       id="dataTbBrnc" width="100%">-->

                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">NAME</th>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">ADDRESS</th>
                                    <th class="text-center">TELEPHONE</th>
                                    <th class="text-center">EMAIL</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Branch Create</h4>
            </div>
            <form class="form-horizontal" id="brnc_add" name="brnc_add"
                  action="<?= base_url() ?>admin/addBranch" method="post" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="brnm"
                                                           placeholder="Branch Name"
                                                           id="brnm"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Code</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="brcd"
                                                           placeholder="Branch Code"
                                                           id="brcd"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control"
                                                           name="brad" id="brad" placeholder="Address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="brtp"
                                                           id="brtp" placeholder="Telephone"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control email"
                                                           name="breml" id="breml" placeholder="Email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-8 ">
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
            <form class="form-horizontal" id="brnc_edt" name="brnc_edt"
                  action="<?= base_url() ?>admin/edtBranch" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="brnm_edt"
                                                           placeholder="Branch Name"
                                                           id="brnm_edt"/>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="auid" name="auid">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Code</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control text-uppercase disabled"
                                                           name="brcd_edt"
                                                           placeholder="Branch Code"
                                                           id="brcd_edt"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control"
                                                           name="brad_edt" id="brad_edt" placeholder="Address"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="brtp_edt"
                                                           id="brtp_edt" placeholder="Telephone"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control email"
                                                           name="breml_edt" id="breml_edt" placeholder="Email"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-8 ">
                                                <textarea class="form-control" rows="3" id="remk_edt"
                                                          name="remk_edt" placeholder="Remarks"></textarea>
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
                    <button type="submit" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
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

        srchBranch();

        $("#brnc_add").validate({  // BRANCH ADD VALIDATE
            rules: {
                brnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnchName",
                        type: "post",
                        data: {
                            brnm: function () {
                                return $("#brnm").val();
                            }
                        }
                    }
                },
                brcd: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnchCode",
                        type: "post",
                        data: {
                            brcd: function () {
                                return $("#brcd").val();
                            }
                        }
                    },
                    maxlength: 2,
                    minlength: 2,
                },
                brad: {
                    required: true
                },
                brtp: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                breml: {
                    required: true
                },
                duamt: {
                    required: true,
                    notEqual: 0
                }
            },
            messages: {
                brnm: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                brcd: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                brad: {
                    required: 'Please select Branch'
                },
                brtp: {
                    required: 'Please enter valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    digits: 'This is not a valid Number'
                },
                breml: {
                    required: 'Please Enter Branch Email '
                },
                duamt: {
                    required: 'Please Enter Dual Approval Amount',
                    notEqual: 'Please Enter Dual Approval Amount'
                },
            }
        });

        $("#brnc_edt").validate({  // BRANCH EDITE VALIDATE
            rules: {

                brnm_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnchName_edt",
                        type: "post",
                        data: {
                            brnm: function () {
                                return $("#brnm_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },
                brcd_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnchCode_edt",
                        type: "post",
                        data: {
                            brcd: function () {
                                return $("#brcd_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    },
                    maxlength: 2,
                    minlength: 2,
                },
                brad_edt: {
                    required: true
                },
                brtp_edt: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                breml_edt: {
                    required: true
                },
                duamt_edt: {
                    required: true,
                    notEqual: 0
                }
            },
            messages: {
                brnm_edt: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                brcd_edt: {
                    required: 'Please Enter Center Name',
                    remote: 'Name Already Exists  '
                },
                brad_edt: {
                    required: 'Please select Branch'
                },
                brtp_edt: {
                    required: 'Please enter valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    digits: 'This is not a valid Number'
                },
                breml_edt: {
                    required: 'Please Enter Branch Email '
                },
                duamt_edt: {
                    required: 'Please Enter Dual Approval Amount',
                    notEqual: 'Please Enter Dual Approval Amount'
                },
            }
        });
    });

    function chckBtn(id,httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    /* SEARCH */
    function srchBranch() {

        $('#dataTbBrnc').DataTable().clear();
        $('#dataTbBrnc').DataTable({
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
                {className: "text-left", "targets": [1, 3, 5]},
                {className: "text-center", "targets": [0, 2, 4, 6, 7]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '20%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>admin/srchBrnch',
                type: 'post',
                data: {}
            }
        });
    }

    /* ADD */
    $("#brnc_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#brnc_add").valid()) {
            $('#modalAdd').modal('hide');
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addBranch",
                data: $("#brnc_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "Branch Added Successfully", text: '', type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "Branch Added Failed", text: '', type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    /* EDIT VIEW*/
    function edtBrn(auid) {

        $('#hed').text("Update Branch");
        $('#btnNm').text("Update");

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewBranch",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brcd_edt").value = response[i]['brcd'];
                    document.getElementById("brnm_edt").value = response[i]['brnm'];
                    document.getElementById("brad_edt").value = response[i]['brad'];
                    document.getElementById("brtp_edt").value = response[i]['brtp'];
                    document.getElementById("breml_edt").value = response[i]['brem'];
                    document.getElementById("remk_edt").value = response[i]['remk'];
                    document.getElementById("auid").value = response[i]['brid'];
                    document.getElementById("brcd_edt").value = response[i]['brcd'];

                    if (response[i]['brcust'] > 0) {
                        document.getElementById("brcd_edt").readOnly = true;
                    } else {
                        document.getElementById("brcd_edt").readOnly = false;
                    }
                }
            }
        })
    }

    /* EDIT SUBMIT*/
    $("#brnc_edt").submit(function (e) {
        e.preventDefault();

        if ($("#brnc_edt").valid()) {
            swal({
                    title: "Are you sure Update Branch?",
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
                        document.getElementById('subBtn').disabled = true;

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/edtBranch",
                            data: $("#brnc_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchBranch();
                                swal({title: "Branch Update Success!", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                    // location = '<?= base_url(); ?>admin/branch';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }


    });

    /* REJECT*/
    function rejecBrnc(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this check",
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
                        url: '<?= base_url(); ?>admin/rejBranch',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                srchBranch();
                                swal({title: "Branch Inactive Success !", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Branch Not Rejected", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvBrnc(id) {
        swal({
                title: "Are you sure ?",
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
                        url: '<?= base_url(); ?>admin/reactBranch',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {

                                srchBranch();
                                swal({title: "", text: "Branch Reactive Success!", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        }
                    });

                } else {
                    swal("Process Cancelled!", "", "error");
                }
            });
    }


</script>