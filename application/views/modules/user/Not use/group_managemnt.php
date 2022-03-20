<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Micro Finance</li>
    <li>CSU Module</li>
    <li class="active">Group Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Group Management </strong></h3>

                    <?php if (!empty($funcPerm) && $funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Group
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch_grp" id="brch_grp"
                                            onchange="getExe(this.value,'exc_grp',exc_grp.value,'cen_grp');chckBtn(this.value,'brch_grp')">
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
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc_grp" id="exc_grp"
                                            onchange="getCenter(this.value,'cen_grp',brch_grp.value);chckBtn(this.value,'cm_brn')">
                                        <?php
                                        foreach ($execinfo as $exe) {
                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cen_grp" id="cen_grp">
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="searchGrup()"
                                            class='btn-sm btn-primary panel-refresh' id="pc_refresh">
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
                                           id="dataTbGroup" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">GROUP NO</th>
                                            <th class="text-center">GROUP LEADER</th>
                                            <th class="text-center">GROUP MEMBERS</th>
                                            <th class="text-center">MAX MEMBERS</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Group</h4>
            </div>
            <form class="form-horizontal" id="addGrup" name="addGrup"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="brch_cnt" id="brch_cnt"
                                                            onchange="getExe(this.value,'cnt_exc')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch[brch_id] != '0') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Group Name</label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="grnm"
                                                               id="grnm" autofocus/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Officer</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="cnt_exc" id="cnt_exc"
                                                            onchange="getCenter(this.value,'cent',brch_cnt.value)">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Max Member</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" id="mxmbr" name="mxmbr"
                                                               value="<?= $policy[0]->pov2 ?>" readonly>
                                                    </div>

                                                    <input type="hidden" class="form-control" id="mimb" name="mimb"
                                                           value="<?= $policy[0]->pov1 ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Center</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="cent" id="cent">
                                                        <?php
                                                        foreach ($centinfo as $cen) {
                                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
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
                    <button type="submit" class="btn btn-success" id="grpAdd">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  Edit Modal -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Update Group</h4>
            </div>
            <form class="form-horizontal" id="grp_edt" name="grp_edt"
                  action="<?= base_url() ?>user/edtGrup" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch</label>
                                                <label class="col-md-6  control-label" id="brch_grp_edt"></label>

                                            </div>
                                        </div>

                                        <input type="hidden" id="auid" name="auid"/>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-8  control-label">Group No</label>
                                                <label class="col-md-2  control-label" id="gr_no_edt"> </label>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Officer</label>
                                                <label class="col-md-6  control-label" id="grp_exc_edt"></label>

                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-8  control-label">Current Members</label>
                                                <label class="col-md-2  control-label" id="nof_mb_edt"> </label>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Center</label>
                                                <label class="col-md-6  control-label" id="cnt_grp_edt"></label>

                                            </div>
                                        </div>
                                        <!--   <div class="col-md-6">
                                               <div class="form-group">
                                                   <label class="col-md-8  control-label">Max Members</label>
                                                   <div class="col-md-4 ">
                                                       <div class="form-group">
                                                           <input type="text" class="form-control" id="mxmbr_edt"
                                                                  name="mxmbr_edt">
                                                       </div>

                                                   </div>
                                               </div>
                                           </div> -->

                                    </div>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit / approvel Model -->


<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbGroup').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        //searchGrup();

        $("#grp_edt").validate({  // center add form validation
            /* rules: {
             mxmbr_edt: {
             required: true,
             digits: true
             }
             },
             messages: {
             mxmbr_edt: {
             required: 'Please Enter Max Members ',
             digits: 'Invalide'
             }
             } */
        });

        $("#addGrup").validate({  // center add form validation
            rules: {
                brch_cnt: {
                    required: true,
                    notEqual: 'all'
                },
                cnt_exc: {
                    required: true,
                    notEqual: 'all'
                },
                cent: {
                    required: true,
                    notEqual: 'all',
                },
                grnm: {
                    required: true,
                    digits: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_Grupname",
                        type: "post",
                        data: {
                            grnm: function () {
                                return $("#grnm").val();
                            },
                            cent: function () {
                                return $("#cent").val();
                            }
                        }
                    }
                },
                /*  mxmbr: {
                 required: true,
                 digits: true
                 }*/
            },
            messages: {
                brch_cnt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                cnt_exc: {
                    required: 'Please select Officer',
                    notEqual: "Please select Officer",
                },
                cent: {
                    required: 'Please select Center',
                    notEqual: "Please select Center",
                },

                grnm: {
                    required: 'Please Enter Group No',
                    digits: 'Please Enter Valide No',
                    remote: 'No Already Exists  '
                },
                /*  mxmbr: {
                 required: 'Please Enter Max Members ',
                 digits: 'Please Enter Max Member'
                 } */
            }
        });

    });

    function chckBtn(id) {
        if (id == 0) {
            document.getElementById('brch_grp').style.borderColor = "red";
        } else {
            document.getElementById('brch_grp').style.borderColor = "";
        }
    }


    function searchGrup() {                                                       // Search btn
        var brn = document.getElementById('brch_grp').value;
        var exc = document.getElementById('exc_grp').value;
        var cen = document.getElementById('cen_grp').value;
        // var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch_grp').style.borderColor = "red";
        } else {
            document.getElementById('brch_grp').style.borderColor = "";

            $('#dataTbGroup').DataTable().clear();
            $('#dataTbGroup').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 3, 5]},
                    {className: "text-center", "targets": [0, 4, 6, 7, 8, 9]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[10, "desc"]],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'}, //gdp mmbr
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchGroup',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        // stat: stat
                    }
                }
            });
        }
    }

    // grpAdd

    $("#grpAdd").click(function (e) { // cenyer add form
        e.preventDefault();
        var grnm2 = document.getElementById('grnm').value;
        var cent2 = document.getElementById('cent').value;

        if ($("#addGrup").valid()) {

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/chk_Grupname",
                data: {
                    grnm: grnm2,
                    cent: cent2
                },
                dataType: 'json',
                success: function (data) {
                    if (data === true) {
                        $('#modalAdd').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/addGrup",
                            data: $("#addGrup").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({
                                    title: "", text: "Group Create Successfully!", type: "success"
                                }, function () {
                                    location.reload();
                                });

                            },
                            error: function () {
                                swal("Group Create Failed!", data.message, "error");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>user/grup_mng';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Group No Already Exists", data.message, "error");
                    }
                }
            });
        } else {
            //            alert("Error");
        }
    });


    function edtGrup(auid, typ) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewGrup",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['selectgrp'].length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brch_grp_edt").innerHTML = response['selectgrp'][i]['brnm'];
                    document.getElementById("grp_exc_edt").innerHTML = response['selectgrp'][i]['fnme'] + " " + response['selectgrp'][i]['lnme'];
                    document.getElementById("cnt_grp_edt").innerHTML = response['selectgrp'][i]['cnnm'];
                    document.getElementById("nof_mb_edt").innerHTML = response['selectgrp'][i]['mebr'];
                    document.getElementById("gr_no_edt").innerHTML = response['selectgrp'][i]['grno'];
                    // document.getElementById("mxmbr_edt").value = response['selectgrp'][i]['mxmb'];

                    document.getElementById("auid").value = response['selectgrp'][i]['grpid'];
                }

            }
        })
    }

    $("#grp_edt").submit(function (e) {
        e.preventDefault();

        if ($("#grp_edt").valid()) {
            swal({
                    title: "Are you sure?",
                    text: "Update Group Details",
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
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/edtGroup",
                            data: $("#grp_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal("Success!", " ", "success");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>user/grup_mng';
                                }, 2000);
                                // searchpettyCash();
                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }


    });

    function rejGrp(id) {
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
                    swal("Rejected!", "Group Reject Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>user/rejGroup',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                    searchGrup();
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Center Not Rejected", "error");
                }
            });
    }


</script>












