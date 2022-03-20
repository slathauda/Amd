<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li> General</li>
    <li class="active">Permission Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Permission Management </strong></h3>
                    <!--  <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                      class="fa fa-plus"></i></span> Add Branch
                      </button>  -->
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Permission Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="prtp" id="prtp"
                                            onchange="chngTyp(this.value);chckBtn(this.value,'prtp')">
                                        <option value="0"> Select Type</option>
                                        <option value="1"> Default Permission</option>
                                        <option value="2"> Manual Permission</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="usr" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">User</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="user" id="user"
                                            onchange="chckBtn(this.value,'user')">
                                        <option value="0"> Select User</option>
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
                                        <option value="0"> Select User Level</option>
                                        <?php
                                        foreach ($uslvlinfo as $uslvl) {
                                            echo "<option value='$uslvl->id'>$uslvl->lvnm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" id="brn" style="display: none">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getUser(this.value,uslv.value);chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchPerm()"
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
                            <div class="panel panel-default tabs" id="taba" style="display: none">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Basic
                                            Permission</a>
                                    </li>
                                    <li><a href="#tab-2" role="tab" data-toggle="tab"> Advance Permission</a></li>
                                    <li><a href="#tab-3" role="tab" data-toggle="tab"> -- </a></li>
                                </ul>

                                <div class="panel-body tab-content">

                                    <div class="tab-pane active" id="tab-1">
                                        <div class="btn-group pull-right" style="margin-bottom: 1%">
                                            <button class="btn btn-info dropdown-toggle" data-toggle="modal"
                                                    data-target="#modalAdd" onclick="mdulAdd()">
                                                <i class="fa fa-plus"></i> Add Module
                                            </button>
                                        </div>

                                        <form class="form-horizontal" id="edt_prmi" name="edt_prmi" action=""
                                              method="post">
                                            <div class="panel-body panel-body-table">
                                                <div class="table-responsive">
                                                    <table class="table datatable table-bordered table-striped table-actions"
                                                           id="dataTbPer" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th class="text-center">MENU / MODULE</th>
                                                            <th class="text-center">MENU TYPE</th>
                                                            <th class="text-center">VIEW</th>
                                                            <th class="text-center">ADD</th>
                                                            <th class="text-center">EDIT</th>
                                                            <th class="text-center">DELETE</th>
                                                            <th class="text-center">APPROVAL</th>
                                                            <th class="text-center" style="color: red">Re Active</th>
                                                            <th class="text-center">ALL</th>
                                                            <th class="text-center">PAGE ACCESS</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <input type="hidden" name="len" id="len">
                                            <div class="panel-footer">
                                                <button type="submit" class="btn btn-success pull-right">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="tab-pane" id="tab-2">

                                        <form class="form-horizontal" id="advedt_prmi" name="advedt_prmi" action=""
                                              method="post">
                                            <div class="panel-body panel-body-table">

                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-actions"
                                                           id="dataTbPerAdv">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th class="text-center">MENU</th>
                                                            <th class="text-center">MENU TYPE</th>
                                                            <th class="text-center">PRINT</th>
                                                            <th class="text-center">REPRINT</th>
                                                            <th class="text-center">ALL</th>
                                                        </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                            <input type="hidden" name="lensp" id="lensp">
                                            <div class="panel-footer">
                                                <button type="submit" class="btn btn-success pull-right">Submit</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                    <div class="tab-pane" id="tab-3">
                                        <h1>Tab 3 </h1>
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

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Module Add</h4>
            </div>
            <form class="form-horizontal" id="mdul_add" name="mdul_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">

                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="dataTbmdl">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">MODULE PAGE</th>
                                                <th class="text-center">MODULE TYPE</th>
                                                <th class="text-center">ADD</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mdlen" id="mdlen">
                            <input type="hidden" name="uslvl" id="uslvl">
                            <input type="hidden" name="usid" id="usid">
                            <input type="hidden" name="ptp" id="ptp">
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

<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbPer').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
        });
        $('#dataTbmdl').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
        });
        $('#dataTbPerAdv').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
        });
    });

    function chngTyp(tp) {

        if (tp == 2) {
            document.getElementById('usr').style.display = "block";
            document.getElementById('brn').style.display = "block";
        } else {
            document.getElementById('usr').style.display = "none";
            document.getElementById('brn').style.display = "none";
        }
    }

    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function getUser(brid, uslv) {
        $.ajax({
            url: '<?= base_url(); ?>admin/getUser',
            type: 'post',
            data: {
                brid: brid,
                uslv: uslv
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#user').empty();
                    $('#user').append("<option value='0'>Select User</option>");
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
    function srchPerm() {
        var prtp = document.getElementById('prtp').value;
        var uslv = document.getElementById('uslv').value;
        var brch = document.getElementById('brch').value;
        var user = document.getElementById('user').value;

        if (prtp == 0) {
            document.getElementById('prtp').style.borderColor = "red";
        }
        if (uslv == 0) {
            document.getElementById('uslv').style.borderColor = "red";
        }

        if (brch == 0) {
            document.getElementById('brch').style.borderColor = "red";
        }
        if (user == 0) {
            document.getElementById('user').style.borderColor = "red";
        }
        if (prtp == 1) {
            if (uslv != 0) {
                srchPermOrgin();
            }
        } else if (prtp == 2) {
            if (uslv != 0 && brch != 0 && user != 0) {
                srchPermOrgin();
            }
        }
    }

    function srchPermOrgin() {
        $('#taba a:first').tab('show');
        $('#dataTbPer').DataTable().clear();
        $('#dataTbPerAdv').DataTable().clear();

        var prtp = document.getElementById('prtp').value;
        var uslv = document.getElementById('uslv').value;
        var brch = document.getElementById('brch').value;
        var user = document.getElementById('user').value;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/srchPermis",
            data: {
                prtp: prtp,
                uslv: uslv,
                brch: brch,
                user: user
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                document.getElementById('taba').style.display = "block";


                // Basic setting
                $('#dataTbPer').DataTable().clear();
                var t = $('#dataTbPer').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2, 3, 4, 5, 6, 7, 8, 9, 10]},
                        {className: "text-right", "targets": [0]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '30%'},
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
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;
                        document.getElementById("len").value = display.length;
                    },
                });
                for (var i = 0; i < len; i++) {
                    var hid = "<label class=''><input type='hidden' name='prid[" + i + "]'  value=" + response[i]['prid'] + " /> </label>";

                    if (response[i]['mntp'] == 1) {
                        var mntp = "<label class='label label-success'> Admin</label>";
                    } else {
                        var mntp = "<label class='label label-info'> User</label>";
                    }

                    if (response[i]['view'] == 1) {
                        var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='view' value=" + response[i]['view'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var viw = "<label class=''><input type='checkbox' name='view[" + i + "]' title='view' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }
                    if (response[i]['inst'] == 1) {
                        var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='add' value=" + response[i]['inst'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var inst = "<label class=''><input type='checkbox' name='inst[" + i + "]' title='add' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }
                    if (response[i]['edit'] == 1) {
                        var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='edit' value=" + response[i]['edit'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var edit = "<label class=''><input type='checkbox' name='edit[" + i + "]' title='edit' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }
                    if (response[i]['rejt'] == 1) {
                        var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='reject/delete' value=" + response[i]['rejt'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var rejt = "<label class=''><input type='checkbox' name='rejt[" + i + "]' title='reject/delete' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }
                    if (response[i]['apvl'] == 1) {
                        var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='approval' value=" + response[i]['apvl'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var apvl = "<label class=''><input type='checkbox' name='apvl[" + i + "]' title='approval' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }

                    if (response[i]['reac'] == 1) {
                        var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='reactive' value=" + response[i]['reac'] + " id='checkbox-1'  class='icheckbox " + i + "' checked='checked'/> </label>";
                    } else {
                        var reac = "<label class=''><input type='checkbox' name='reac[" + i + "]' title='reactive' value='1' id='checkbox-1'  class='icheckbox " + i + "' /> </label>";
                    }

                    var all = "<label class=''><input type='checkbox' name='all[" + i + "]' value='' id='checkbox-1' onclick='chckall(" + i + ",this.checked)'  class='icheckbox' /> </label>";

                    if (response[i]['pgac'] == 1) {
                        var pgac = " <label class='switch switch-small'><input type='checkbox' name='pgac[" + i + "]' title='page access' checked value = '1'/> <span></span> </label> ";
                    } else {
                        var pgac = " <label class='switch switch-small'><input type='checkbox' name='pgac[" + i + "]' title='page access' value = '1'/> <span></span> </label> ";
                    }

                    t.row.add([
                        i + 1,
                        response[i]['pgnm'] + ' (' + response[i]['aid'] + ')' + hid,
                        mntp,
                        viw,
                        inst,
                        edit,
                        rejt,
                        apvl,
                        reac,
                        all,
                        pgac
                    ]).draw(false);
                }
            }
        });

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/srchPermisAdvn",
            data: {
                prtp: prtp,
                uslv: uslv,
                brch: brch,
                user: user
            },
            dataType: 'json',
            success: function (response) {
                var len2 = response.length;

                // advance setting
                $('#dataTbPerAdv').DataTable().clear();
                var t2 = $('#dataTbPerAdv').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    bAutoWidth: false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2, 3, 4, 5]},
                        {className: "text-nowrap", "targets": [0]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '50%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'}
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;
                        document.getElementById("lensp").value = display.length;
                    },
                });
                for (var a = 0; a < len2; a++) {
                    if (response[a]['mntp'] == 1) {
                        var mntp = "<label class='label label-success'> Admin</label>";
                    } else {
                        var mntp = "<label class='label label-info'> User</label>";
                    }

                    var hid = "<label class=''><input type='hidden' name='prid[" + a + "]'  value=" + response[a]['prid'] + " /> </label>";

                    if (response[a]['prnt'] == 1) {
                        var prnt = "<label class=''><input type='checkbox' name='prnt[" + a + "]' title='Print' value=" + response[a]['prnt'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                    } else {
                        var prnt = "<label class=''><input type='checkbox' name='prnt[" + a + "]' title='Print' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                    }
                    if (response[a]['rpnt'] == 1) {
                        var rpnt = "<label class=''><input type='checkbox' name='rpnt[" + a + "]' title='Reprint' value=" + response[a]['rpnt'] + " id='checkbox-1'  class='icheckbox " + a + "' checked='checked'/> </label>";
                    } else {
                        var rpnt = "<label class=''><input type='checkbox' name='rpnt[" + a + "]' title='Reprint' value='1' id='checkbox-1'  class='icheckbox " + a + "' /> </label>";
                    }

                    var all = "<label class=''><input type='checkbox' name='all[" + a + "]' value='' id='checkbox-1' onclick='chckallAdv(" + a + ",this.checked)'  class='icheckbox' /> </label>";

                    t2.row.add([
                        a + 1,
                        response[a]['pgnm'] + ' (' + response[a]['aid'] + ')' + hid,
                        mntp,
                        prnt,
                        rpnt,
                        all
                    ]).draw(false);
                }
            }
        })

    }

    function chckall(prid, isChecked) {
        if (isChecked) {
            $("." + prid).each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("." + prid).each(function () {
                $(this).prop("checked", false);
            });
        }
    }

    function chckallAdv(prid, isChecked) {
        if (isChecked) {
            $("." + prid).each(function () {
                $(this).prop("checked", true);
            });
        } else {
            $("." + prid).each(function () {
                $(this).prop("checked", false);
            });
        }
    }

    // normal permision form submit
    $("#edt_prmi").submit(function (e) { // permission add form
        e.preventDefault();

        var len = document.getElementById('len').value;
        if (len > 0) {
            if ($("#edt_prmi").valid()) {
                var jqXHR = jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>admin/edtPermin",
                    data: $("#edt_prmi").serialize(),
                    dataType: 'json',
                    success: function (response) {
                        srchPerm();
                        swal({title: "", text: "Permission Update Successfully", type: "success"},
                            function () {
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Update Error", text: textStatus, type: "error"},
                            function () {
                            });
                    }
                });
            } else {
            }
        } else {
            swal("NO Permission Updates", '', "error");
        }


    });

    // advance form submit
    $("#advedt_prmi").submit(function (e) { // permission add form
        e.preventDefault();
        if ($("#advedt_prmi").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/edtPerminAdvan",
                data: $("#advedt_prmi").serialize(),
                dataType: 'json',
                success: function (response) {
//                    swal("Advance Permission Update Successfully!", response.message, "success");
//                    window.setTimeout(function () {
//                        location = '<?//= base_url(); ?>//admin/permis';
//                    }, 3000);
                    srchPerm();
                    swal({title: "", text: "Permission Update Successfully", type: "success"},
                        function () {
                            //location.reload();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Update Error", text: textStatus, type: "error"},
                        function () {
                            //location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    // new module add function
    function mdulAdd() {
        var prtp = document.getElementById('prtp').value;
        var uslv = document.getElementById('uslv').value;
        var brch = document.getElementById('brch').value;
        var user = document.getElementById('user').value;

        document.getElementById("uslvl").value = uslv;
        document.getElementById("usid").value = user;
        document.getElementById("ptp").value = prtp;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/srchModul",
            data: {
                prtp: prtp,
                uslv: uslv,
                brch: brch,
                user: user
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                $('#dataTbmdl').DataTable().clear();
                var t = $('#dataTbmdl').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2, 3]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '30%'},    // br
                        {sWidth: '10%'},
                        {sWidth: '10%'},
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;
                        document.getElementById("mdlen").value = display.length;
                    },
                });
                for (var i = 0; i < len; i++) {
                    if (response[i]['mntp'] == 1) {
                        var mntp = "<label class='label label-success'> Admin</label>";
                    } else {
                        var mntp = "<label class='label label-info'> User</label>";
                    }

                    var hid = "<label class=''><input type='hidden' name='aid[" + i + "]'  value=" + response[i]['aid'] + " /> </label>";
                    var viw = "<label class=''><input type='checkbox' name='addm[" + i + "]' value='1' id='checkbox-1'  class='icheckbox' /> </label>";

                    t.row.add([
                        i + 1,
                        '(' + response[i]['aid'] + ') ' + response[i]['pgnm'] + hid,
                        mntp,
                        viw,
                    ]).draw(false);
                }
            }
        })
    }

    $("#mdul_add").submit(function (e) { // permission add form
        e.preventDefault();
        if ($("#mdul_add").valid()) {

            $('#modalAdd').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addModul",
                data: $("#mdul_add").serialize(),
                dataType: 'json',
                success: function (response) {
                    srchPerm();
                    swal({title: "", text: "New module add Success", type: "success"},
                        function () {
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Error", text: textStatus, type: "error"},
                        function () {
                        });
                }
            });
        } else {
        }
    });

    // end new module add function
</script>












