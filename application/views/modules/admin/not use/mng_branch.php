<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Master Data</li>
    <li class="active">Branch Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Branch Management </strong></h3>
                    <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                    class="fa fa-plus"></i></span> Add Branch
                    </button>
                </div>
                <div class="panel-body">


                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbBrnc">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH NAME</th>
                                            <th class="text-center">BRANCH CODE</th>
                                            <th class="text-center">BRANCH ADDRESS</th>
                                            <th class="text-center">TELEPHONE</th>
                                            <th class="text-center">EMAIL</th>
                                            <th class="text-center">WEB</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTION</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?php $i = 1;
                                        foreach ($branchinfo as $branch) { ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $branch->brnm ?></td>
                                                <td><?= $branch->brcd ?></td>
                                                <td><?= $branch->brad ?></td>
                                                <td><?= $branch->brtp ?></td>
                                                <td><?= $branch->brem ?></td>
                                                <td><?= $branch->brwb ?></td>
                                                <td><?php
                                                    if ($branch->stat == 0) {
                                                        echo " <span class='label label-warning' >  Inactive  </span> ";
                                                    } else {
                                                        echo " <span class='label label-success'> Active </span> ";
                                                    }
                                                    ?></td>
                                                <td><?php
                                                    if ($branch->stat == 0) {
                                                        echo "<button type='button' id='edt' disabled data-toggle='modal' data-target='#modalEdt' onclick='edtNmcust(id);' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                                                            "<button type='button' id='rej' disabled onclick='rejecNmCust( );' class='btn btn-default btn-condensed' title='Reject'><i class='fa fa-ban' aria-hidden='true'></i></button> ";

                                                    } else {

                                                        echo "<button type='button' data-toggle='modal' data-target='#modalEdt' onclick='edtBrn(" . $branch->brid . ");' class='btn  btn-default btn-condensed' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i></button> " .
                                                            "<button type='button' id='rej' onclick='rejecBrnc(" . $branch->brid . " );' class='btn btn-default btn-condensed' title='Inactive'><i class='fa fa-ban' aria-hidden='true'></i></button> ";


                                                    }

                                                    ?></td>
                                            </tr>
                                            <?php $i++;
                                        } ?>

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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Branch Create</h4>
            </div>
            <form class="form-horizontal" id="brnc_add" name="brnc_add"
                  action="<?= base_url() ?>admin/addBranch" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="brnm"
                                                               placeholder="Branch Name"
                                                               id="brnm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="brcd"
                                                               placeholder="Branch Code"
                                                               id="brcd"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control"
                                                               name="brad" id="brad" placeholder="Address"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control" name="brtp"
                                                               id="brtp" placeholder="Telephone"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control email"
                                                               name="breml" id="breml" placeholder="Email"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Web</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="brwb"
                                                               id="brwb" placeholder="Web"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Parallel Loans </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label class="switch">
                                                            <input id="prln" name="prln" type="checkbox" value="1"
                                                                   onchange="prlprduct(this.value)"
                                                                   checked/>Disable
                                                            <span></span>
                                                        </label> Enable
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="divprlprduct">
                                                <label class="col-md-4  control-label">Parallel Product</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label class="switch">
                                                            <input id="prpd" name="prpd" type="checkbox" value="1"
                                                                   checked/>Disable
                                                            <span></span>
                                                        </label> Enable
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
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
                                    <br>

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

<!--  Edit  -->
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
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="brnm_edt"
                                                               placeholder="Branch Name"
                                                               id="brnm_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="auid" name="auid">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="brcd_edt"
                                                               placeholder="Branch Code"
                                                               id="brcd_edt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control"
                                                               name="brad_edt" id="brad_edt" placeholder="Address"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control" name="brtp_edt"
                                                               id="brtp_edt" placeholder="Telephone"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control email"
                                                               name="breml_edt" id="breml_edt" placeholder="Email"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Web</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="brwb_edt"
                                                               id="brwb_edt" placeholder="Web"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Parallel Loans </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label class="switch">
                                                            <input id="prln_edt" name="prln_edt" type="checkbox"
                                                                   value="1"
                                                                   onchange="prlprduct_edt(this.value)"
                                                                   checked/>Disable
                                                            <span></span>
                                                        </label> Enable
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" id="divprlprduct_edt">
                                                <label class="col-md-4  control-label">Parallel Product</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <label class="switch">
                                                            <input id="prpd_edt" name="prpd_edt" type="checkbox"
                                                                   value="1"
                                                                   checked/>Disable
                                                            <span></span>
                                                        </label> Enable
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk_edt"
                                                              name="remk_edt" placeholder="Remarks"></textarea>
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
                    <button type="submit" class="btn btn-success"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Model -->


<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbBrnc').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "columnDefs": [
                {className: "text-left", "targets": [1,  3, 4, 5]},
                {className: "text-center", "targets": [0, 2, 7,8]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '20%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'}
            ],
        });
        // searchCenter();

        $("#brnc_add").validate({  // center add form validation
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
                    }
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
                    required: 'Please enter New Password',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    digits: 'This is not a valid Number'
                },
                breml: {
                    required: 'Please Enter Branch Email '
                }
            }
        });

        $("#cnt_edt").validate({
            rules: {
                brch_cnt_edt: {
                    required: true,
                    notEqual: "all"
                },
                cnt_exc_edt: {
                    required: true,
                    notEqual: "all"
                },
                cntnm_edt: {
                    required: true
                },
                mxmbr_edt: {
                    required: true,
                    digits: true
                }
            },
            messages: {
                brch_cnt_edt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                cnt_exc_edt: {
                    required: 'Please select Executive',
                    notEqual: "Please select Executive"
                },
                cntnm_edt: {
                    required: 'Please Enter Center Name'
                },
                mxmbr_edt: {
                    required: 'Please Enter Max Member ',
                    digits: 'This is not a valid Number'
                }
            }
        });

    });

    function prlprduct() {
        var cc = document.getElementById("prln").checked;
        if (cc == false) {
            document.getElementById("divprlprduct").style.display = "none";
            document.getElementById("prpd").checked = true;
        } else {
            document.getElementById("divprlprduct").style.display = "block";
            document.getElementById("prpd").checked = true;
        }

    }

    function prlprduct_edt() {
        var cc = document.getElementById("prln_edt").checked;
        if (cc == false) {
            document.getElementById("divprlprduct_edt").style.display = "none";
            document.getElementById("prpd_edt").checked = false;
            document.getElementById("prpd_edt").value = 0;
        } else {
            document.getElementById("divprlprduct_edt").style.display = "block";
            document.getElementById("prpd_edt").checked = true;
            document.getElementById("prpd_edt").value = 1;
        }

    }

    $("#brnc_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#brnc_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addBranch",
                data: $("#brnc_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal("Branch Added Successfully!", data.message, "success");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>admin/branch';
                    }, 3000);
                },
                error: function () {
                    swal("Center Added Failed!", data.message, "error");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>admin/branch';
                    }, 2000);
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function viewBranch(auid) {

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
                    document.getElementById("brch_cnt_vew").innerHTML = response[i]['brnm'];
                    document.getElementById("cnt_exc_vew").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];
                    document.getElementById("cntnm_vew").innerHTML = response[i]['cnnm'];
                    document.getElementById("coldy_vew").innerHTML = response[i]['cday'];
                    document.getElementById("mxmbr_vew").innerHTML = response[i]['mcus'];
                    document.getElementById("frotm_vew").innerHTML = response[i]['frtm'];
                    document.getElementById("totm_vew").innerHTML = response[i]['totm'];
                    document.getElementById("remk_vew").innerHTML = response[i]['rmks'];
                    //document.getElementById("auid").value = response[i]['caid'];
                }
            }
        })
    }

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
                    document.getElementById("brwb_edt").value = response[i]['brwb'];
                    document.getElementById("remk_edt").value = response[i]['remk'];
                    document.getElementById("auid").value = response[i]['brid'];

                    if (response[i]['prln'] == 1) {
                        document.getElementById("prln_edt").checked = true;
                        document.getElementById("divprlprduct_edt").style.display = "block";
                    } else {
                        document.getElementById("prln_edt").checked = false;
                        document.getElementById("divprlprduct_edt").style.display = "none";
                    }

                    if (response[i]['prpd'] == 1) {
                        document.getElementById("prpd_edt").checked = true;
                    } else {
                        document.getElementById("prpd_edt").checked = false;
                    }
                }
                //prlprduct_edt();
            }
        })
    }

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
                    swal("Rejected!", "Branch Inactive Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>admin/rejBranch',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                     location = '<?= base_url(); ?>admin/branch';
                                    //searchCenter();
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Branch Not Rejected", "error");
                }
            });
    }


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
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/edtBranch",
                            data: $("#brnc_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal("Success!", " ", "success");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>admin/branch';
                                }, 3000);
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


</script>












