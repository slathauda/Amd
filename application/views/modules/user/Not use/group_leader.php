<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Micro Finance</li>
    <li>CSU Module</li>
    <li class="active">Group Leader</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Group Leader </strong></h3>
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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Group</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="grup" id="grup">
                                        <!--                                        <option value="0"> Select Group</option>-->
                                        <option value="all"> All Group</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Executive</label>
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
                                    <select class="form-control" name="cen_grp" id="cen_grp"
                                            onchange="getGrup(this.value,'grup',brch_grp.value,exc_grp.value,cen_grp.value)">
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
                                    <button type="button form-control  " onclick="srchGrpleder()"
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
                                           id="dataTbGrpLed" style="width: 100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">GROUP NO</th>
                                            <th class="text-center">CUS NO</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">MOBILE</th>
                                            <th class="text-center">MODE</th>
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

<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbGrpLed').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
       //  srchGrpleder();

    });

    function chckBtn(id) {
        if (id == 0) {
            document.getElementById('brch_grp').style.borderColor = "red";
        } else {
            document.getElementById('brch_grp').style.borderColor = "";
        }
    }

    function srchGrpleder() {                                                       // Search btn
        var brn = document.getElementById('brch_grp').value;
        var exc = document.getElementById('exc_grp').value;
        var cen = document.getElementById('cen_grp').value;
        var grp = document.getElementById('grup').value;

        if (brn == '0') {
            document.getElementById('brch_grp').style.borderColor = "red";
        } else {
            document.getElementById('brch_grp').style.borderColor = "";

            $('#dataTbGrpLed').DataTable().clear();
            $('#dataTbGrpLed').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 5]},
                    {className: "text-center", "targets": [0, 3, 4, 6, 7, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[10, "desc"]],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}, //cus no
                    {sWidth: '10%'}, // cus name
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchGrpledr',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        grp: grp
                    }
                }
            });
        }
    }

    function addGrpLedr(cusid, grpid, id) {
        //alert(cusid + '**' + cntid + '**' + id);

        $.ajax({
            url: '<?= base_url(); ?>user/chkgrpLeader',
            type: 'post',
            data: {
                // id: id,
                grpid: grpid,
                // typ: typ
            },
            dataType: 'json',
            success: function (response) {
                var lead = response[0]['grld'];
                if (lead == '0') {

                    swal({
                            title: "Are you sure?",
                            text: "This Member Chang to Center Leader",
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
                                var jqXHR = jQuery.ajax({
                                    type: "POST",
                                    url: "<?= base_url(); ?>User/addgrpLeader",
                                    data: {
                                        csid: cusid,
                                        grpid: grpid
                                    },
                                    dataType: 'json',
                                    success: function (data) {
                                        swal("Success!", "Group Leader Added Success", "success");
                                        window.setTimeout(function () {
                                            //  location = '<?= base_url(); ?>user/grup_ledr';
                                            srchGrpleder();
                                        }, 2000);
                                    },
                                    error: function () {
                                        swal("Failed!", "", "error");
                                        window.setTimeout(function () {
                                            // location = '<?= base_url(); ?>user/cent_mng';
                                            srchGrpleder();
                                        }, 2000);
                                    }
                                });
                            } else {
                                swal("Cancelled", " ", "error");
                            }
                        });
                } else if (lead != '0') {

                    swal({
                            title: "Leader Already Assigned!",
                            text: "Are you want to Replace Group Leader?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3bdd59",
                            confirmButtonText: "Yes, Replace it!",
                            cancelButtonText: "No, cancel it!",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function (isConfirm) {
                            if (isConfirm) {
                                swal("Replaced!", "Leader Successfully Replaced!", "success");
                                setTimeout(function () {
                                    $.ajax({
                                        url: '<?= base_url(); ?>user/addgrpLeader',
                                        type: 'post',
                                        data: {
                                            csid: cusid,
                                            grpid: grpid
                                        },
                                        dataType: 'json',
                                        success: function (response) {
                                            //location = '<?= base_url(); ?>customer/leder_assin';
                                            srchGrpleder();
                                        }
                                    });
                                }, 1000);
                            } else {
                                swal("Cancelled", "Member not updated", "error");
                            }
                        });
                }


            }
        });

    }

    function remvGrpLedr(cusid, grpid, id) {
        //alert(cusid + '**' + cntid + '**' + id);
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
                    swal("Rejected!", "Leader Reject Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>user/rmvgrpLeader',
                            type: 'post',
                            data: {
                                csid: cusid,
                                grpid: grpid
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                    srchGrpleder();
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Leader Not Rejected", "error");
                }
            });
    }


</script>












