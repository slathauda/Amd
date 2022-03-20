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
                        <li class="active"><strong>Supply Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Supply Management</h3>
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
                                        <option value="all"> All</option>
                                        <option value="1"> Active</option>
                                        <option value="2"> Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchSupply()"
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
                                   id="dataTbSupply" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">CODE</th>
                                    <th class="text-center">NAME</th>
                                    <th class="text-center">ADDRESS</th>
                                    <th class="text-center">MOBILE</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Supply Create</h4>
            </div>
            <form class="form-horizontal" id="supply_add" name="supply_add" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Supply Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           placeholder="Supply Name"
                                                           name="spnm" id="spnm"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="2" id="addr"
                                                              name="addr" placeholder="Address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Phone</label>
                                                <div class="col-md-3 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Mobile" name="mobi" id="mobi"/>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Telephone" name="tele" id="tele"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <input type="email" class="form-control"
                                                           placeholder="Email" name="emil" id="emil"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Bank Name</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="bknm" id="bknm" onchange="chckBtn(this.value,'bknm');getBrnch(this.value)">
                                                        <option value="-"> -- Select Bank --</option>
                                                        <option value="0"> No Bank</option>
                                                        <?php
                                                        foreach ($bankinfo as $bank) {
                                                            echo "<option value='$bank->bkid'>$bank->bknm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="brnm" id="brnm" onchange="chckBtn(this.value,'brnm')">
                                                        <option value="-"> -- Select Bank Branch --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account No</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Account No" name="acno" id="acno"/>
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
                                <div class="row form-horizontal">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Supply Name</label>
                                            <label class="col-md-6  control-label" id="vewSpp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Address</label>
                                            <label class="col-md-6  control-label" id="vewAdd"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Phone</label>
                                            <label class="col-md-2  control-label" id="vewMob"></label>

                                            <label class="col-md-2  control-label">Tele</label>
                                            <label class="col-md-2  control-label" id="vewTel"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Email </label>
                                            <label class="col-md-6  control-label" id="vewEml"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Bank Name</label>
                                            <label class="col-md-6  control-label" id="vewBnk"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch Name</label>
                                            <label class="col-md-6  control-label" id="vewBnc"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Account No</label>
                                            <label class="col-md-6  control-label" id="vewAcc"> </label>
                                        </div>

                                    </div>
                                </div>
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
            <form class="form-horizontal" id="spply_edt" name="spply_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Supply Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           placeholder="Supply Name"
                                                           name="spnmEdt" id="spnmEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="2" id="addrEdt"
                                                              name="addrEdt" placeholder="Address"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Phone</label>
                                                <div class="col-md-3 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Mobile" name="mobiEdt" id="mobiEdt"/>
                                                </div>
                                                <div class="col-md-3 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Telephone" name="teleEdt" id="teleEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <input type="email" class="form-control"
                                                           placeholder="Email" name="emilEdt" id="emilEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Bank Name</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="bknmEdt" id="bknmEdt">
                                                        <option value="-"> -- Select Bank --</option>
                                                        <option value="0"> No Bank</option>
                                                        <?php
                                                        foreach ($bankinfo as $bank) {
                                                            echo "<option value='$bank->bkid'>$bank->bknm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Branch Name" name="brnmEdt" id="brnmEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Account No</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Account No" name="bkacEdt" id="bkacEdt"/>
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
                                        <input type="hidden" id="func" name="func">
                                    </div>
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

        srchSupply();

        // ADD VALIDATE
        $("#supply_add").validate({
            rules: {
                spnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>Stock/chk_supply",
                        type: "post",
                        data: {
                            spnm: function () {
                                return $("#spnm").val();
                            }
                        }
                    }
                },
                addr: {
                    required: true,
                },
                mobi: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                emil: {
                    required: true,
                },
                bknm: {
                    required: true,
                    notEqual: '-'
                },
                acno: {
                    digits: true
                },

            },
            messages: {
                spnm: {
                    required: 'Please enter supply name',
                    remote: 'Supply name already exists  '
                },
                addr: {
                    required: 'Please enter supply address',
                },
                mobi: {
                    required: 'Please enter supply mobile',
                    minlength: 'Invalid phone No ',
                    maxlength: 'Invalid phone No '
                },
                emil: {
                    required: 'Please enter supply email',
                },
                bknm: {
                    required: 'Please select bank name',
                    notEqual: 'Please select bank name',
                },

            }
        });

        // EDIT VALIDATE
        $("#spply_edt").validate({
            rules: {
                spnmEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>Stock/chk_supply_edit",
                        type: "post",
                        data: {
                            spnm: function () {
                                return $("#spnmEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            },
                        }
                    }
                },
                addrEdt: {
                    required: true,
                },
                mobiEdt: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                emilEdt: {
                    required: true,
                },
                bknmEdt: {
                    required: true,
                    notEqual: '-'
                },
                bkacEdt: {
                    digits: true
                },
            },
            messages: {
                spnmEdt: {
                    required: 'Please enter supply name',
                    remote: 'Supply name already exists  '
                },
                addrEdt: {
                    required: 'Please enter supply address',
                },
                mobiEdt: {
                    required: 'Please enter supply mobile',
                    minlength: 'Invalid phone No ',
                    maxlength: 'Invalid phone No '
                },
                emilEdt: {
                    required: 'Please enter supply email',
                },
                bknmEdt: {
                    required: 'Please select bank name',
                    notEqual: 'Please select bank name',
                },
                bkacEdt: {
                    digits: 'Please enter valid account no',
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

    // LOAD BANK BRANCH
    function getBrnch(bkid) {
        $.ajax({
            url: '<?= base_url(); ?>user/getBankBrnc',
            type: 'post',
            data: {
                bkid: bkid,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#brnm').empty();
                    $('#brnm').append("<option value='-'> -- Select Branch -- </option>");
                    for (var a = 0; a < len; a++) {
                        var id = response[a]['auid'];
                        var name = response[a]['brcd'] +' | '+response[a]['brnm'] ;
                        var $el = $('#brnm');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#brnm').empty();
                    $('#brnm').append("<option value='0'> -- No Branch -- </option>");
                }
            }
        });
    }

    /* SEARCH */
    function srchSupply() {

        $('#dataTbSupply').DataTable().clear();
        $('#dataTbSupply').DataTable({
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
            "serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [2, 3, 5]},
                {className: "text-center", "targets": [0, 1, 4, 6, 7, 8]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[1, "desc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '2%'},
                {sWidth: '3%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '15%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>Stock/srchSupply',
                type: 'post',
                data: {}
            }
        });
    }

    /* ADD */
    $("#addBtn").click(function (e) {
        e.preventDefault();
        if ($("#supply_add").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Stock/chk_supply",
                data: $("#supply_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data == true) {

                        $('#modalAdd').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Stock/addSupply",
                            data: $("#supply_add").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchSupply();
                                swal({title: "", text: "Supply added success!", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Supply added Failed!", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal({title: "", text: "Supply name already exists", type: "info"});
                    }
                },
            });
        }
    });

    /* VIEW */
    function viewSpply(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Stock/vewSupply",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("vewSpp").innerHTML = response[i]['spnm'];
                    document.getElementById("vewAdd").innerHTML = response[i]['addr'];
                    document.getElementById("vewMob").innerHTML = response[i]['mobi'];
                    document.getElementById("vewTel").innerHTML = response[i]['tele'];
                    document.getElementById("vewEml").innerHTML = response[i]['emil'];
                    document.getElementById("vewBnk").innerHTML = response[i]['bknm'];
                    document.getElementById("vewBnc").innerHTML = response[i]['brnm'];
                    document.getElementById("vewAcc").innerHTML = response[i]['bkac'];

                }
            }
        })
    }

    /* EDIT VIEW*/
    function edtSpply(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Supply");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Supply");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Stock/vewSupply",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("spnmEdt").value = response[0]['spnm'];
                document.getElementById("addrEdt").value = response[0]['addr'];
                document.getElementById("mobiEdt").value = response[0]['mobi'];
                document.getElementById("teleEdt").value = response[0]['tele'];
                document.getElementById("emilEdt").value = response[0]['emil'];

                document.getElementById("brnmEdt").value = response[0]['brnm'];
                document.getElementById("remkEdt").value = response[0]['dscr'];

                document.getElementById("auid").value = response[0]['spid'];

                if (response[0]['bkid'] == null) {
                    document.getElementById("bknmEdt").value = 0;
                } else {
                    document.getElementById("bknmEdt").value = response[0]['bkid'];
                }

                if (response[0]['bkac'] == null) {
                    document.getElementById("bkacEdt").value = 0;
                } else {
                    document.getElementById("bkacEdt").value = response[0]['bkac'];
                }

                //getMdlEdt(response[0]['ctid'], response[0]['mdid'], response[0]['tpid']); // catid,mdlid,typid
            }
        })
    }

    /* EDIT SUBMIT*/
    $("#edtBtn").click(function (e) {
        e.preventDefault();

        if ($("#spply_edt").valid()) {
            swal({
                    title: "Are you sure update Brand ?",
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
                            url: "<?= base_url(); ?>Stock/edtSupply",
                            data: $("#spply_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchSupply();
                                swal({title: "Brand Update Success", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal("Failed !", "", "error");
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

    /* REJECT*/
    function rejecSppy(id) {
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
                        url: '<?= base_url(); ?>Stock/rejSupply',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchSupply();
                                swal({title: "Supply inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Supply Not Inactive", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvSppy(id) {
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
                        url: '<?= base_url(); ?>Stock/reactSupply',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchSupply();
                                swal({title: "", text: "Supply reactive success!", type: "success"});
                            }
                        }
                    });

                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }


</script>