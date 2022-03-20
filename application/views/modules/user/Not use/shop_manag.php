<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>user">Home</a></li>
    <li>Promotion Module</li>
    <li class="active">Shop Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Shop Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Shop
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="chckBtn(this.value,'brch')">
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchShop()"
                                            class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbShop" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRNC</th>
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
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Shop Create</h4>
            </div>
            <form class="form-horizontal" id="shop_add" name="shop_add" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="brch" id="brch"
                                                            onchange="chckBtn(this.value,'brch')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] != 'all') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Shop Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           placeholder="Shop Name"
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
                                                <label class="col-md-4  control-label">Contact Person Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Contact Person" name="cntnm" id="cntnm"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Contact Telephone</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Contact Telephone" name="cntph" id="cntph"/>
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
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Shop Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row form-horizontal">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch Name</label>
                                            <label class="col-md-6  control-label" id="vewBrn"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Shop Name</label>
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
                                            <label class="col-md-4  control-label">Contact Person</label>
                                            <label class="col-md-6  control-label" id="vewCnpr"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Contact Telephone</label>
                                            <label class="col-md-6  control-label" id="vewCnph"> </label>
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

<!--  Edit  -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-md">
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
                                                <label class="col-md-4  control-label">Branch Name</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="brchEdt" id="brchEdt"
                                                            onchange="chckBtn(this.value,'brchEdt')">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] != 'all') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Shop Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           placeholder="Shop Name"
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
                                                <label class="col-md-4  control-label">Contact Person Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Contact Person" name="cntnmEdt" id="cntnmEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Contact Telephone</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Contact Telephone" name="cntphEdt" id="cntphEdt"/>
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
<!--End Edit Model -->


<script>
    $().ready(function () {

        srchShop();

        // ADD VALIDATE
        $("#shop_add").validate({
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                spnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_shop",
                        type: "post",
                        data: {
                            spnm: function () {
                                return $("#spnm").val();
                            },
                            brch: function () {
                                return $("#brch").val();
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
                cntnm: {
                    required: true,
                },
                cntph: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },

            },
            messages: {
                brch: {
                    required: 'Please select branch name',
                    notEqual: 'Please select branch name',
                },
                spnm: {
                    required: 'Please enter shop name',
                    remote: 'Shop name already exists  '
                },
                addr: {
                    required: 'Please enter shop address',
                },
                mobi: {
                    required: 'Please enter shop mobile',
                    minlength: 'Invalid phone No ',
                    maxlength: 'Invalid phone No '
                },
                emil: {
                    required: 'Please enter supply email',
                },
            }
        });

        // EDIT VALIDATE
        $("#spply_edt").validate({
            rules: {
                brchEdt: {
                    required: true,
                    notEqual: '0'
                },
                spnmEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_shop_edit",
                        type: "post",
                        data: {
                            spnm: function () {
                                return $("#spnmEdt").val();
                            },
                            brch: function () {
                                return $("#brchEdt").val();
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
                cntnmEdt: {
                    required: true,
                },
                cntphEdt: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
            },
            messages: {
                spnmEdt: {
                    required: 'Please enter shop name',
                    remote: 'shop name already exists  '
                },
                addrEdt: {
                    required: 'Please enter shop address',
                },
                mobiEdt: {
                    required: 'Please enter shop mobile',
                    minlength: 'Invalid phone No ',
                    maxlength: 'Invalid phone No '
                },
                emilEdt: {
                    required: 'Please enter shop email',
                },

            }
        });
    });

    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // Search btn
    function srchShop() {

       var brch =  document.getElementById('brch').value;

       if(brch == 0){
           document.getElementById('brch').style.borderColor = "red";
       }else{
           document.getElementById('brch').style.borderColor = "";

        $('#dataTbShop').DataTable().clear();
        $('#dataTbShop').DataTable({
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
                {className: "text-left", "targets": [2, 3, 4]},
                {className: "text-center", "targets": [0, 1, 5, 6, 7, 8]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[1, "desc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '8%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchShop',
                type: 'post',
                data: {
                    brch :brch
                }
            }
        });
       }
    }

    // ADD FORM
    $("#addBtn").click(function (e) {
        e.preventDefault();
        if ($("#shop_add").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/chk_shop",
                data: $("#shop_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data == true) {

                        $('#modalAdd').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/addShop",
                            data: $("#shop_add").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchShop();
                                swal({title: "", text: "Shop added success!", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Shop added Failed!", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal({title: "", text: "Shop name already exists", type: "info"});
                    }
                },
            });
        }
    });

    // VIEW ITEM
    function viewShop(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewShop",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("vewBrn").innerHTML = response[i]['brnm'];
                    document.getElementById("vewSpp").innerHTML = response[i]['spnm'];
                    document.getElementById("vewAdd").innerHTML = response[i]['addr'];
                    document.getElementById("vewMob").innerHTML = response[i]['mobi'];
                    document.getElementById("vewTel").innerHTML = response[i]['tele'];
                    document.getElementById("vewEml").innerHTML = response[i]['emil'];
                    document.getElementById("vewCnpr").innerHTML = response[i]['cnpr'];
                    document.getElementById("vewCnph").innerHTML = response[i]['cnph'];

                }
            }
        })
    }

    // EDIT MODEL
    function edtShop(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Shop");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Shop");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewShop",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brchEdt").value = response[0]['brid'];
                document.getElementById("spnmEdt").value = response[0]['spnm'];
                document.getElementById("addrEdt").value = response[0]['addr'];
                document.getElementById("mobiEdt").value = response[0]['mobi'];
                document.getElementById("teleEdt").value = response[0]['tele'];
                document.getElementById("emilEdt").value = response[0]['emil'];

                document.getElementById("cntnmEdt").value = response[0]['cnpr'];
                document.getElementById("cntphEdt").value = response[0]['cnph'];
                document.getElementById("remkEdt").value = response[0]['dscr'];
                document.getElementById("auid").value = response[0]['spid'];

            }
        })
    }

    // EDIT FORM
    $("#edtBtn").click(function (e) {
        e.preventDefault();

        if ($("#spply_edt").valid()) {
            swal({
                    title: "Are you sure update Shop ?",
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
                            url: "<?= base_url(); ?>user/edtShop",
                            data: $("#spply_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchShop();
                                swal({title: "Shop Update Success", text: "", type: "success"},
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

    // REJECT
    function rejecShop(id) {
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
                        url: '<?= base_url(); ?>user/rejShop',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchShop();
                                swal({title: "Shop inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Shop Not Inactive", "error");
                }
            });
    }

    // REACTIVE
    function reactvShop(id) {
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
                        url: '<?= base_url(); ?>user/reactShop',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchShop();
                                swal({title: "", text: "Shop reactive success!", type: "success"});
                            }
                        }
                    });

                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>

