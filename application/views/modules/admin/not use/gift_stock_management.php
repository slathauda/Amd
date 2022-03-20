<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Syatem Setting</li>
    <li class="active">Gift Stock Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Gift Stock Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Stock
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
                                    <button type="button form-control  " onclick="srchGiftStck()"
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
                                           id="dataTbGfstck" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">GIFT TYPE</th>
                                            <th class="text-center">GIFT CODE</th>
                                            <th class="text-center">NO OF GIFT</th>
                                            <th class="text-center">PRICE</th>
                                            <th class="text-center">NO OF ISSUE</th>
                                            <th class="text-center">CRET BY</th>
                                            <th class="text-center">CRET DATE</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Add New Gift Stock</h4>
            </div>
            <form class="form-horizontal" id="stck_add" name="stck_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Gift Branch </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="brchGft" id="brchGft">
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Gift Type</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="gftp" id="gftp">
                                                            <option value="0"> Select Option</option>
                                                            <?php
                                                            foreach ($giftinfo as $gftp) {
                                                                echo "<option value='$gftp->gfid'>$gftp->gfnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of Count</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control" onkeyup="calTtlval()"
                                                               name="nfcn" id="nfcn" placeholder=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Price</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" onkeyup="calTtlval()"
                                                               name="prce" id="prce" placeholder="Price of one gift"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total Value</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="ttvl"
                                                               id="ttvl" placeholder="0" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Stock Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="stcd"
                                                               id="stcd" placeholder="Stock Code"/>
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

<!--  Edit Or Approval -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="stck_edt" name="stck_edt"
                  action="<?= base_url() ?>admin/edtBranch" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Gift Branch </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="brchGftEdt" id="brchGftEdt">
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
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Gift Type</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="gftpEdt" id="gftpEdt">
                                                            <option value="0"> Select Option</option>
                                                            <?php
                                                            foreach ($giftinfo as $gftp) {
                                                                echo "<option value='$gftp->gfid'>$gftp->gfnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of Count</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class="form-control" onkeyup="calTtlval()"
                                                               name="nfcnEdt" id="nfcnEdt" placeholder=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Price</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" onkeyup="calTtlval()"
                                                               name="prceEdt" id="prceEdt" placeholder="Price of one gift"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total Value</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="ttvlEdt"
                                                               id="ttvlEdt" placeholder="0" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Stock Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="stcdEdt"
                                                               id="stcdEdt" placeholder="Stock Code"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" id="auid" name="auid">
                                    <input type="hidden" id="func" name="func">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remkEdt"
                                                              name="remkEdt" placeholder="Remarks"></textarea>
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
<!--End Edit Model -->


<script>
    $().ready(function () {

        srchGiftStck();

        $("#stck_add").validate({  // BRANCH ADD VALIDATE
            rules: {
                brchGft: {
                    required: true,
                    notEqual: '0'
                },
                gftp: {
                    required: true,
                    notEqual: '0'
                },
                nfcn: {
                    required: true,
                    digits: true
                },
                prce: {
                    required: true,
                    currency: true
                },
                stcd: {
                    required: true,
                },

            },
            messages: {
                brchGft: {
                    required: 'Please Select branch name',
                    notEqual: 'Please Select branch name  '
                },
                gftp: {
                    required: 'Please Select Gift Type',
                    notEqual: 'Please Select Gift Type'
                },
                nfcn: {
                    required: 'Please Enter No of Count',
                    digits: 'Please Enter Valid Count '
                },
                prce: {
                    required: 'Please Enter Price',
                    notEqual: 'Please Enter Valid Price '
                },
                stcd: {
                    required: 'Please Enter Stock Code',
                },
            }
        });

        $("#stck_edt").validate({  // BRANCH EDITE VALIDATE
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
                    required: 'Please enter New Password',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number',
                    digits: 'This is not a valid Number'
                },
                breml_edt: {
                    required: 'Please Enter Branch Email '
                }
            }
        });
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // LOAD GIFT STOCK
    function srchGiftStck() {
        var brn = document.getElementById('brch').value;
        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbGfstck').DataTable().clear();
            $('#dataTbGfstck').DataTable({
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
                    {className: "text-center", "targets": [0, 3, 4, 6, 7, 8, 9, 10]},
                    {className: "text-right", "targets": [5]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchGifStock',
                    type: 'post',
                    data: {
                        brn: brn
                    }
                }
            });
        }
    }

    // GIFT TOTAL VALUE CALCULATION
    function calTtlval() {
        var nocn = document.getElementById('nfcn').value;
        var pcpr = document.getElementById('prce').value;

        document.getElementById('ttvl').value = (+nocn * +pcpr);
    }

    // STOCK ADD
    $("#stck_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#stck_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addGftStock",
                data: $("#stck_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "Gift Stock Add Success", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Gift Stock Add Failed", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    // EDIT GIFT STOCK
    function edtStck(auid,fun) {

        if(fun == 'edt'){
            $('#hed').text("Update Gift Stock");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;
        }else if(fun == 'app'){
            $('#hed').text("Approval Gift Stock");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewGiftStck",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brchGftEdt").value = response[i]['brco'];
                    document.getElementById("gftpEdt").value = response[i]['gftp'];
                    document.getElementById("nfcnEdt").value = response[i]['cunt'];
                    document.getElementById("prceEdt").value = response[i]['pric'];
                    document.getElementById("ttvlEdt").value = response[i]['ttvl'];
                    document.getElementById("stcdEdt").value = response[i]['stcd'];
                    document.getElementById("remkEdt").value = response[i]['remk'];

                    document.getElementById("auid").value = response[i]['auid'];
                }
            }
        })
    }

    // EDIT SAVE
    $("#stck_edt").submit(function (e) {
        e.preventDefault();

        if ($("#stck_edt").valid()) {
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
                            url: "<?= base_url(); ?>admin/edtGiftStck",
                            data: $("#stck_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchGiftStck();
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

    // STOCK REJECT
    function rejecStck(id) {
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
                        url: '<?= base_url(); ?>admin/rejGiftStck',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                srchGiftStck();
                                swal({title: "Gift reject Success !", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Gift Not Rejected", "error");
                }
            });
    }


</script>












