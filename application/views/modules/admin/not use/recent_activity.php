<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>General</li>
    <li class="active">Recent Activity</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Recent Activity </strong></h3>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getUser(this.value);chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <!--   <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="uslv" id="uslv"
                                            onchange="chckBtn(this.value,'uslv')">
                                        <option value="0"> Select User Level</option>
                                        <?php
                            //foreach ($uslvlinfo as $uslvl) {
                            //   echo "<option value='$uslvl->id'>$uslvl->lvnm</option>";
                            //}
                            ?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">User</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="user" id="user"
                                            onchange="chckBtn(this.value,'user')">
                                        <option value="0"> Select User</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Activity</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="act" id="act">
                                        <option value="all"> All</option>
                                        <option value="Add"> Add</option>
                                        <option value="Edit"> Edit</option>
                                        <option value="Approval"> Approval</option>
                                        <option value="Reject"> Reject</option>
                                        <option value="Login"> Login</option>
                                        <option value="Logout"> Logout</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchActv()"
                                            class='btn-sm btn-primary panel-refresh' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="panel panel-default ">
                                <div class="panel-body">
                                    <div class="panel-body panel-body-table">
                                        <div class="table-responsive">
                                            <table class="table datatable  table-striped table-actions"
                                                   id="dataTbRcnt" width="100%"> <!-- table-bordered -->
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">USER</th>
                                                    <th class="text-center">Activity Log</th>
                                                    <th class="text-center">DATE and TIME</th>
                                                    <th class="text-center">Login Ip</th>
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
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->


<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbRcnt').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "All"]
            ]
        });

        //$( "#datepicker" ).datepicker({  maxDate: new Date() });
        //   var today = new Date();
//            jQuery("#frdt, #todt").datepicker({
//
//                //dateFormat: "yy-mm-dd",
//                gotoCurrent: true,
//                changeYear: true,
//                changeMonth: true,
////                firstDay: today,
//                maxDate : 0,
//
//                selectOtherMonths: true
////                beforeShowDay: disableMonday
//            });

        srchActv();
    });

    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function getUser(brid) {
        $.ajax({
            url: '<?= base_url(); ?>admin/getUser',
            type: 'post',
            data: {
                brid: brid,
                uslv: 'all'
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#user').empty();
                    $('#user').append("<option value='all'> All User</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                        var $el = $('#user');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#user').empty();
                    $('#user').append("<option value='no'>No User</option>");
                }
            }
        });

    }


    // Search btn
    function srchActv() {    // Search btn
        var brn = document.getElementById('brch').value;
        var user = document.getElementById('user').value;
        var act = document.getElementById('act').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbRcnt').DataTable().clear();
            $('#dataTbRcnt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                searching: true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [

                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0, 4]},
                    {className: "text-right", "targets": [3]},
                    {className: "text-nowrap", "targets": [0]},

                    //  image add this function
                    //  Search Add  View Update Approval Reject
                    {
                        /*https://datatables.net/examples/advanced_init/column_render.html*/
                        "render": function (data, type, row) {
                            var act = row[2];

                            var sr = act.search(/Search/i);
                            var ad = act.search(/Add/i);
                            var vw = act.search(/View/i);
                            var up = act.search(/Update/i);
                            var up2 = act.search(/Edit/i);
                            var ap = act.search(/Approval/i);
                            var rj = act.search(/Reject/i);
                            var rj2 = act.search(/Inactive /i);
                            var rj3 = act.search(/Close /i);

                            var reac = act.search(/Reactive /i);
                            var upg = act.search(/Upgrade /i);

                            var lgi = act.search(/Login /i);
                            var lgo = act.search(/Logout /i);

                            var prnt = act.search(/print /i);
                            var rpnt = act.search(/Reprint /i);

                            var expt = act.search(/Export/i);

                            if (sr > 0) {
                                return '<i class="fa fa-search"></i> ' + data;

                            } else if (ad > 0) {
                                return '<i class="fa fa-plus"></i> ' + data;
                            } else if (vw > 0) {
                                return '<i class="fa fa-eye"></i> ' + data;

                            } else if (up > 0 || up2 > 0) {
                                return '<i class="fa fa-edit"></i> ' + data;

                            } else if (ap > 0) {
                                return '<i class="fa fa-check"></i> ' + data;

                            } else if (rj > 0 || rj2 > 0 || rj3 > 0) {
                                return '<i class="fa fa-close"></i> ' + data;

                            } else if (reac > 0 || upg > 0) {
                                return '<i class="glyphicon glyphicon-wrench"></i> ' + data;

                            } else if (lgi > 0) {
                                return '<i class="fa fa-sign-in"></i> ' + data;

                            } else if (lgo > 0) {
                                return '<i class="fa fa-sign-out"></i> ' + data;

                            } else if (prnt > 0 || rpnt > 0) {
                                return '<i class="fa fa-print"></i> ' + data;

                            } else if (expt > 0 ) {
                                return '<i class="fa fa-file-excel-o"></i> ' + data;

                            } else {
                                return data;
                            }
                        },
                        "targets": 2
                    }

                ],
                "order": [[3, "desc"]],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '30%'}, // name
                    {sWidth: '18%'},
                    {sWidth: '10%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchActivit',
                    type: 'post',
                    data: {
                        brn: brn,
                        user: user,
                        act: act,
                        frdt: frdt,
                        todt: todt
                    }
                },
            });
        }
    }

</script>












