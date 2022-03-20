<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Cheques</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Cheques </strong></h3>
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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date("Y-m-d"); ?>">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Voucher Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="vutp" id="vutp">
                                        <option value="all"> All Voucher</option>
                                        <option value="1"> Credit Voucher</option>
                                        <option value="2"> In cash Voucher</option>
                                        <option value="3"> General Voucher</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<?= date("Y-m-d"); ?>">

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label"> Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all"> All Type</option>
                                        <option value="0"> Pending</option>
                                        <option value="1"> Approval</option>
                                        <option value="2"> Cancel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchChq()"
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
                                           id="dataTbVoucher" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">VOUCHER NO</th>
                                            <th class="text-center">TYPE</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CHQ NO</th>
                                            <th class="text-center">CHQ DATE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">OPTION</th>
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

<!-- View / Approvel Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Cheque Details <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>

            <form class="form-horizontal" id="chq_approval" name="chq_approval"
                  action="" method="post">
                <div class="modal-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Account Name </label>
                                            <label class="col-md-4 col-xs-12 control-label" id="acnm"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Account No </label>
                                            <label class="col-md-4 col-xs-12 control-label" id="acno"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Pay Name</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="pynm"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Voucher No</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="vuno"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Statues</label>
                                            <label class="col-md-4 col-xs-12 control-label"><span
                                                        id="mod"></span></label>
                                        </div>


                                    </div>
                                    <div class="col-md-6">

                                        <input type="hidden" id="cqid" name="cqid">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Cheque No </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="chno"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Cheque Amount</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="amt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Cheque Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="chdt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Create By</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="crby"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Create Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="crdt"></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="appbtn">Approval</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End View Model -->

<!-- Cheq No Change Model -->
<div class="modal" id="modalChqChange" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Cheque No Change </h4>
            </div>

            <form class="form-horizontal" id="chq_nochng" name="chq_nochng" action="" method="post">
                <div class="modal-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Cheque Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="chqbrn" id="chqbrn"
                                                            onchange="chckBtn(this.value,'chqbrn'); abc12();">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] == 'all') {
                                                            } else {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label text-left">Bank
                                                Account</label>
                                            <div class="col-md-6 col-xs-12">
                                                <select class="form-control" name="baco2" id="baco2"
                                                        onchange="chckBtn(this.value,'baco2');loadChq(this.value)">
                                                    <option value="0">Select Bank Account</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group cqsw">
                                            <label class="col-md-3 control-label text-left">Cheque Number</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="cqno2" id="cqno2">
                                                    <option value='0'>Select Cheque Leaf</option>
                                                </select>
                                            </div>
                                        </div>
                                        <input type="hidden" id="cqid2" name="cqid2">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="prssBtn">Process</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End View Model -->

</body>

<script>
    $().ready(function () {

        // Data Tables
        $('#dataTbVoucher').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchChq();

        $("#chq_nochng").validate({  // Product loan validation
            rules: {
                chqbrn: {
                    required: true,
                    notEqual: '0'
                },
                baco2: {
                    required: true,
                    notEqual: '0'
                },
                cqno2: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                chqbrn: {
                    required: 'Please select Cheque Branch',
                    notEqual: "Please select Cheque Branch",
                },
                baco2: {
                    required: 'Please select Bank Account',
                    notEqual: "Please select Bank Account"
                },
                cqno2: {
                    required: 'Please select Cheque Number ',
                    notEqual: "Please select Cheque Number "
                },
            }
        });

    });

    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchChq() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var stat = document.getElementById('stat').value;
        var vutp = document.getElementById('vutp').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbVoucher').DataTable().clear();
            $('#dataTbVoucher').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 4, 5]},
                    {className: "text-center", "targets": [0, 3, 8, 9]},
                    {className: "text-right", "targets": [7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[6, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br
                    {sWidth: '10%'},    // voucher no
                    {sWidth: '5%'},    // type
                    {sWidth: '15%'},    // customer name
                    {sWidth: '15%'},    // chq no
                    {sWidth: '5%'},    // chq date
                    {sWidth: '5%'},    // amount
                    {sWidth: '5%'},     //
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchChq',
                    type: 'post',
                    data: {
                        brn: brn,
                        stat: stat,
                        vutp: vutp,
                        frdt: frdt,
                        todt: todt
                    }
                }
            });
        }
    }

    // voucher view and approval
    function viewChq(chqid, typ) {

        if (typ == 'app') {
            //  document.getElementById('appbtn').style.display = 'block';
            document.getElementById('appbtn').removeAttribute("class");
            document.getElementById('appbtn').setAttribute("class", "btn btn-success");
        } else {
            // document.getElementById('appbtn').style.display = 'none';
            document.getElementById('appbtn').removeAttribute("class");
            document.getElementById('appbtn').setAttribute("class", "hidden");
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewChq",
            data: {
                chqid: chqid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                for (var i = 0; i < len; i++) {
                    document.getElementById("acnm").innerHTML = response[i]['acnm'];
                    document.getElementById("acno").innerHTML = response[i]['acno'];
                    document.getElementById("pynm").innerHTML = response[i]['pynm'];
                    document.getElementById("amt").innerHTML = numeral(response[i]['cqam']).format('0,0.00');
                    document.getElementById("vuno").innerHTML = response[i]['vuno'];
                    document.getElementById("chno").innerHTML = response[i]['cqno'];
                    document.getElementById("chdt").innerHTML = response[i]['cqdt'];
                    document.getElementById("crby").innerHTML = response[i]['fnme'];
                    document.getElementById("crdt").innerHTML = response[i]['isdt'];

                    if (response[i]['stat'] == 0) {
                        document.getElementById("mod").innerHTML = "<span class='label label-warning'> Pending </span> ";
                    } else if (response[i]['stat'] == 1) {
                        document.getElementById("mod").innerHTML = "<span class='label label-success'> Approval </span> ";
                    } else if (response[i]['stat'] == 2) {
                        document.getElementById("mod").innerHTML = "<span class='label label-danger'> Cancel </span> ";
                    }

                    document.getElementById("cqid").value = response[i]['cqid'];

                }
            }
        })
    }

    // click process btn
    $("#appbtn").on('click', function (e) {
        e.preventDefault();
        //var pytp = document.getElementById("pytp").value;
        document.getElementById("appbtn").disabled = true;
        $.ajax({
            url: '<?= base_url(); ?>user/chqApprvl',
            type: 'POST',
            data: $("#chq_approval").serialize(),
            dataType: 'json',
            success: function (response) {

                $('#modalView').modal('hide');
                document.getElementById("appbtn").disabled = false;
                srchChq();
                swal({title: "", text: "Cheque approval done", type: "success"});
            },
            error: function (response) {
                swal("Failed!", "Cheque Approval Failed", "error");
                window.setTimeout(function () {
                    location = '<?= base_url(); ?>user/chqu';
                }, 2000);
            }
        });

    });

    // chq print
    function chqPrint(id) {
        var d1 = '/' + id;
        var d2 = '/' + 0;
        var d3 = '/' + 0;
        window.open('<?= base_url(); ?>user/cheqPrint' + d1 + d2 + d3, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
        srchChq();
    }

    // voucher reject
    function rejecChq(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this Voucher",
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
                        url: '<?= base_url(); ?>user/rejChq',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal("Rejected!", "Cheque Reject Success", "success");
                            window.setTimeout(function () {
                                location = '<?= base_url(); ?>user/chqu';
                            }, 3000);
                        },
                        error: function (response) {
                            swal("Failed!", "Cheque Reject Failed", "error");
                            window.setTimeout(function () {
                                location = '<?= base_url(); ?>user/chqu';
                            }, 2000);
                        }
                    });
                } else {
                    swal("Cancelled!", "Cheque Not Rejected", "error");
                }
            });
    }

    // chq reprint
    function chqReprint(id) {
        swal({
                title: "Cheque Reprint",
                text: "Choose reprint option",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3bdd59",
                confirmButtonText: "Chq No change",
                cancelButtonText: "Reprint Only",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    changChqNo(id);
                    swal.close();
                } else {
                    var d1 = '/' + id;
                    var d2 = '/' + 1;
                    var d3 = '/' + 0;
                    window.open('<?= base_url(); ?>user/cheqPrint' + d1 + d2 + d3, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
                    location.reload();
                }
            });
    }

    // CHQ LEAF CHANGE & REPRINT
    function changChqNo(id) {
        $('#modalChqChange').modal('show');
        $.ajax({
            url: '<?= base_url(); ?>user/getOtherChqLeaf',
            type: 'post',
            data: {
                id: id
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById('chqbrn').value = response[0]['brco'];
                document.getElementById('baco2').value = response[0]['accid'];

                document.getElementById('cqid2').value = id;
                loadbnk();
                loadChq(response[0]['accid']);
            },
            error: function (response) {
                swal("Error!", "Contact System Admin", "error");
            }
        });
    }

    // VOUCHER BRANCH ON CHANGE
    function abc12() {
        document.getElementById('baco2').value = 0;
        document.getElementById('cqno2').value = 0;
        loadbnk();
    }

    // LOAD GRNERAL VOUCHER PAY BANK
    function loadbnk() {
        var brid = document.getElementById("chqbrn").value;

        $.ajax({
            url: '<?= base_url(); ?>user/getBankDtils',
            type: 'post',
            data: {
                id: brid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#baco2').empty();
                    $('#baco2').append("<option value='0'>Select Account </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $('#baco2');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#baco2').empty();
                    $('#baco2').append("<option value='0'>No Account</option>");
                }
            }
        });
    }
    // LOAD BANKK CHEQUE
    function loadChq(bkacc) {
        $.ajax({
            url: '<?= base_url(); ?>user/getChqDtils',
            type: 'post',
            data: {
                bkid: bkacc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#cqno2').empty();
                    $('#cqno2').append("<option value='0'>Select cheque leaf </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['cqid'];
                        var name = response[i]['cqno'];
                        var $el = $('#cqno2');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#cqno2').empty();
                    $('#cqno2').append("<option value='0'>No cheque leaf</option>");
                }
            }
        });
    }

    // NEW CHQ NO CHANGE & PROCESS
    $("#prssBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#chq_nochng").valid()) {
            swal({
                    title: "Are you sure?",
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
                        document.getElementById('prssBtn').style.display = "none";
                        $('#modalChqChange').modal('hide');

                        var d1 = '/' + document.getElementById('cqid2').value;
                        var d2 = '/' + document.getElementById('cqno2').value;

                        window.open('<?= base_url(); ?>user/chqNochange' + d1 + d2, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
                        location.reload();

                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

</script>
