<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Issue Cheques</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Issue Cheques </strong></h3>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="chckBtn(this.value,'brch');loadbnkacc(this.value,'bnkacc')">
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
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Bank Account</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="bnkacc" id="bnkacc"
                                            onchange="chckBtn(this.value,'bnkacc')">
                                        <option value="all"> All Account</option>
                                        <?php
                                        foreach ($bnkaccinfo as $bnkacc) {
                                            echo "<option value='$bnkacc->acid'>$bnkacc->acnm | $bnkacc->acno</option>";
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
                                    <button type="button form-control  " onclick="srchIsuuChq()"
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
                                           id="dataTbIssuChq" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">BANK</th>
                                            <th class="text-center">ACCOUNT NAME</th>
                                            <th class="text-center">ACCOUNT NO</th>
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


<!-- View  Model -->
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


</body>

<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbIssuChq').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        loadbnkacc(document.getElementById('brch').value,'bnkacc');
        //srchIsuuChq();
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchIsuuChq() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var bkac = document.getElementById('bnkacc').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbIssuChq').DataTable().clear();
            $('#dataTbIssuChq').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4, 5]},
                    {className: "text-center", "targets": [0, 6, 8, 9]},
                    {className: "text-right", "targets": [7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[5, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // brn
                    {sWidth: '10%'},    // bank
                    {sWidth: '10%'},    // acc nm
                    {sWidth: '5%'},     // acc no
                    {sWidth: '5%'},     // chq no
                    {sWidth: '5%'},     // chq date
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     //
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchIsuuChq',
                    type: 'post',
                    data: {
                        brn: brn,
                        bkac: bkac,
                    }
                }
            });
        }
    }

    // LOAD BRANCH WISE BANK ACCOUNT
    function loadbnkacc(brid, htid, edt) {
        $.ajax({
            url: '<?= base_url(); ?>user/getBankAccount',
            type: 'post',
            data: {
                id: brid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#' + htid).empty();
//                    $('#' + htid).append("<option value='0'> Select Account </option>");
                    $('#' + htid).append("<option value='all'> All Account </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $('#' + htid);

                        if (edt == id) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#' + htid).empty();
                    $('#' + htid).append("<option value='0'>No Account</option>");
                }
            }
        });
    }

    // cheque view
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
            url: "<?= base_url(); ?>user/vewIssueChq",
            data: {
                chqid: chqid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len > 0) {
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
                } else {
                    document.getElementById("acnm").innerHTML = '';
                    document.getElementById("acno").innerHTML = '';
                    document.getElementById("pynm").innerHTML = '';
                    document.getElementById("amt").innerHTML = '';
                    document.getElementById("vuno").innerHTML = '';
                    document.getElementById("chno").innerHTML = '';
                    document.getElementById("chdt").innerHTML = '';
                    document.getElementById("crby").innerHTML = '';
                    document.getElementById("crdt").innerHTML = '';
                    document.getElementById("mod").innerHTML = "<span class='label label-warning'> Pending </span> ";
                }
            }
        })
    }

</script>












