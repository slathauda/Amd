<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Module</li>
    <li class="active"> Petty Cash Voucher</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Petty Cash Voucher </strong></h3>

                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Voucher
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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchPtyVouc()"
                                            class='btn-sm btn-primary panel-refresh' id="">
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
                                           id="dataTbPtyVou" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">VUNO</th>
                                            <th class="text-center"> ACCOUNT</th>
                                            <th class="text-center"> BILL REFARANCE</th>
                                            <th class="text-center"> PAY DATE</th>
                                            <th class="text-center"> PAY AMOUNT</th>
                                            <th class="text-center"> CREATE BY</th>
                                            <th class="text-center"> CREATE DATE</th>
                                            <th class="text-center"> STATUES</th>
                                            <th class="text-center"> OPTION</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Request New Petty Cash</h4>
            </div>
            <form class="form-horizontal" id="rqscash_add" name="rqscash_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brchRq" id="brchRq"
                                                            onchange="chckBtn(this.value,'brchRq');getUser(this.value);">
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
                                                <label class="col-md-4 col-xs-6 control-label">Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="rfac" id="rfac">
                                                        <option value="0">-- Select Account --</option>
                                                        <?php
                                                        foreach ($accountinfo as $acc) {
                                                            echo "<option value='$acc->auid'>$acc->hadr</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Pay Date</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="pydt"
                                                               value="<?= date('Y-m-d') ?>"
                                                               placeholder="Request Amount" id="pydt"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">User</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="user" id="user">
                                                        <option value="0">-- Select User --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Reference</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="rfnc"
                                                               placeholder="Short Description" id="rfnc"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="rqamt"
                                                               placeholder="Request Amount" id="rqamt"/>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="addAcc">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  Edit  -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="ptvou_edt" name="ptvou_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brchRqEdt" id="brchRqEdt"
                                                            onchange="chckBtn(this.value,'brchRqEdt');getUserEdt(this.value);">
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
                                                <label class="col-md-4 col-xs-6 control-label">Account</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="rfacEdt" id="rfacEdt">
                                                        <option value="0">-- Select Account --</option>
                                                        <?php
                                                        foreach ($accountinfo as $acc) {
                                                            echo "<option value='$acc->auid'>$acc->hadr</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Pay Date</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker"
                                                               name="pydtEdt"
                                                               value="<?= date('Y-m-d') ?>"
                                                               placeholder="Request Amount" id="pydtEdt"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">User</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="userEdt" id="userEdt">
                                                        <option value="0">-- Select User --</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Reference</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="rfncEdt"
                                                               placeholder="Short Description" id="rfncEdt"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="rqamtEdt"
                                                               placeholder="Request Amount" id="rqamtEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="func" name="func">
                                    <input type="hidden" id="auid" name="auid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Model -->


<script>
    $().ready(function () {

        $("#rqscash_add").validate({  //  ADD VALIDATE

            rules: {
                brchRq: {
                    required: true,
                    notEqual: '0'
                },
                user: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                rfac: {
                    required: true,
                    notEqual: '0'
                },

                rqamt: {
                    required: true,
                    digits: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_pty_value",
                        type: "post",
                        data: {
                            brn: function () {
                                return $("#brchRq").val();
                            },
                            amt: function () {
                                return $("#rqamt").val();
                            }
                        }
                    }
                },
            },
            messages: {
                brchRq: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                user: {
                    required: 'Please select user',
                    notEqual: 'Please select user'
                },
                rfac: {
                    required: 'Please select pay account',
                    notEqual: 'Please select pay account'
                },

                rqamt: {
                    required: 'Please enter Request Amount',
                    remote: 'Account Balance Not enough',
                },
            }

        });

        $("#ptvou_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                brchRqEdt: {
                    required: true,
                    notEqual: '0'
                },
                userEdt: {
                    required: true,
                    notEqual: 'all',
                    min: 1
                },
                rfacEdt: {
                    required: true,
                    notEqual: '0'
                },

                rqamtEdt: {
                    required: true,
                    digits: true,
                    remote: {
                        url: "<?= base_url(); ?>user/chk_pty_value",
                        type: "post",
                        data: {
                            brn: function () {
                                return $("#brchRqEdt").val();
                            },
                            amt: function () {
                                return $("#rqamtEdt").val();
                            }
                        }
                    }
                },
            },
            messages: {
                brchRqEdt: {
                    required: 'Please select branch',
                    notEqual: 'Please select branch'
                },
                userEdt: {
                    required: 'Please select user',
                    notEqual: 'Please select user'
                },
                rfacEdt: {
                    required: 'Please select pay account',
                    notEqual: 'Please select pay account'
                },

                rqamtEdt: {
                    required: 'Please enter Request Amount',
                    remote: 'Account Balance Not enough',
                },
            }
        });

        getUser();
        srchPtyVouc();
    });

    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // LOAD USER
    function getUser() {
        var brid = document.getElementById('brchRq').value;
        $.ajax({
            url: '<?= base_url(); ?>user/getUser',
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

    // LOAD USER EDIT
    function getUserEdt(brid, usid) {
        $.ajax({
            url: '<?= base_url(); ?>user/getUser',
            type: 'post',
            data: {
                brid: brid,
                uslv: 'all'
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#userEdt').empty();
                    $('#userEdt').append("<option value='all'> All User</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                        var $el = $('#userEdt');

                        if (id === usid) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#userEdt').empty();
                    $('#userEdt').append("<option value='no'>No User</option>");
                }
            }
        });

    }

    // Search btn
    function srchPtyVouc() {
        var brch = document.getElementById('brch').value;

        $('#dataTbPtyVou').DataTable().clear();
        $('#dataTbPtyVou').DataTable({
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
                {className: "text-left", "targets": [2, 3, 4, 5, 8]},
                {className: "text-center", "targets": [0, 1, 6, 9, 10,11]},
                {className: "text-right", "targets": [7]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[9, "desc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '3%'},
                {sWidth: '3%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '18%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '16%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchPtyvouc',
                type: 'post',
                data: {
                    brch: brch,
                }
            }
        });
    }

    // ADD MODEL
    $("#addAcc").click(function (e) { //  add form
        e.preventDefault();
        if ($("#rqscash_add").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/chk_pty_value",
                data: {
                    brn: function () {
                        return $("#brchRq").val();
                    },
                    amt: function () {
                        return $("#rqamt").val();
                    }
                },
                dataType: 'json',
                success: function (data) {

                   if(data == true){
                       var jqXHR = jQuery.ajax({
                           type: "POST",
                           url: "<?= base_url(); ?>user/addPtycashVouc",
                           data: $("#rqscash_add").serialize(),
                           dataType: 'json',
                           success: function (data) {
                               $('#modalAdd').modal('hide');
                               srchPtyVouc();
                               swal({title: "", text: "Petty Cash Add done!", type: "success"},
                                   function () {
                                       location.reload();
                                   });
                           },
                           error: function () {
                               swal({title: "", text: "Petty Cash Add Failed!", type: "error"},
                                   function () {
                                       location.reload();
                                   });
                           }
                       });
                   }else{
                       swal({title: "", text: "Account Balance Not enough", type: "info"});
                   }
                },

            });


        } else {
            //            alert("Error");
        }
    });

    // EDIT MODEL
    function edtPtyVouc(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Petty Cash Voucher");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Petty Cash Voucher");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewPtyVouc",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brchRqEdt").value = response[0]['brid'];
                document.getElementById("userEdt").value = response[0]['usrid'];
                document.getElementById("rfacEdt").value = response[0]['pyac'];
                document.getElementById("rfncEdt").value = response[0]['bref'];
                document.getElementById("rqamtEdt").value = response[0]['amut'];
                document.getElementById("pydtEdt").value = response[0]['pydt'];

                document.getElementById("auid").value = response[0]['ptid'];
                getUserEdt(response[0]['brid'], response[0]['usrid']);
            }
        })
    }

    // EDIT SUBMIT
    $("#subBtn").click(function (e) {
        e.preventDefault();

        if ($("#ptvou_edt").valid()) {
            swal({
                    title: "Are you sure this process",
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
                            url: "<?= base_url(); ?>user/edtPtyvouc",
                            data: $("#ptvou_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchPtyVouc();
                                swal({title: "", text: "Petty Cash process success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Process failed", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    function rejecPtyvouc(id) {
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
                        url: '<?= base_url(); ?>user/rejPtyvouc',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchPtyVouc();
                                swal({title: "Petty Cash Voucher Reject success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Cheque book not Inactive", "error");
                }
            });
    }

    // PRINT VOUCHER
    function ptyvoucPrint(auid) {
        window.open('<?= base_url(); ?>user/ptyVoucPrint/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
        srchPtyVouc();
    }

</script>












