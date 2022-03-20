<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Loan Disbursement</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Disbursement (Credit Voucher)</strong></h3>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getExe(this.value,'exc',exc.value,'cen');chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <!--    <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <?php
                            foreach ($stainfo as $stat) {
                                echo "<option value='$stat->stid'>$stat->stnm</option>";
                            }
                            ?>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc" id="exc"
                                            onchange="getCenter(this.value,'cen',brch.value)">
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
                                    <select class="form-control" name="cen" id="cen">
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
                                    <button type="button form-control  " onclick="srchLoan()"
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
                                           id="dataTbVou" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRAN /CENTER</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">PRDT</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">PERIOD</th>
                                            <th class="text-center">GROUP VNO</th>
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

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Loan Details <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer Nic</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="cusnic"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Customer No</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="cusno"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Type</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lntyp"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Amount</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnamt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lninst"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Doc Charges</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lndoc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="insdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="lnbrn"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Center</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="lncnt"></label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer Name</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="cunme"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                        <label class="col-md-4 col-xs-6 control-label" id="xx"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnprd"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnrnt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                        <label class="col-md-4 col-xs-6 control-label" id="zz"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Insu Chrg</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnins"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Distribute Date</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="disdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnofc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Statues</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lnsts"></label>
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


</body>

<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbVou').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        //srchLoan();
    });

    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function srchLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        // var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbVou').DataTable().clear();
            $('#dataTbVou').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 5, 7, 8, 9,10]},
                    {className: "text-right", "targets": [0, 6]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "desc"],[9, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '15%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '12%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // period
                    {sWidth: '10%'},     // vuno
                    {sWidth: '5%'},
                    {sWidth: '10%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchCrdtVou',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen
                    }
                }
            });
        }
    }

    // agrement print
    function agrmtprint(lnid) {

        swal({
            title: "Please wait...",
            text: "Agreement generating..",
            //imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        setTimeout(function () {
            $.ajax({
                url: '<?= base_url(); ?>user/agrement_print',
                type: 'post',
                data: {
                    lnid: lnid
                },
                dataType: 'json',
                success: function (response) {
                    window.open('<?= base_url() ?>user/agrmnt_print_pdf/' + lnid, 'popup', 'width=1000,height=600,scrollbars=no,resizable=no');
                    swal.close(); // Hide the loading message
                    srchLoan();
                }
            });
        }, 1000);

    }

    // AGREMENT REPRINT
    function agReprint(lnid) {

        swal({
            title: "Please wait...",
            text: "Agreement generating..",
            //imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        setTimeout(function () {
            window.open('<?= base_url() ?>user/agrmnt_print_pdf/' + lnid, 'popup', 'width=1000,height=600,scrollbars=no,resizable=no');
            swal.close(); // Hide the loading message
            srchLoan();
        }, 1000);

    }

    // loan disbursment and credit voucher print
    function loanDisburs(lnid) {
        swal({
            title: "Please wait...",
            text: "Voucher Processing",
            imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });

        setTimeout(function () {
            $.ajax({
                url: '<?= base_url(); ?>user/vouch_issue',
                type: 'post',
                data: {
                    lnid: lnid
                },
                dataType: 'json',
                success: function (response) {
                    window.open('<?= base_url() ?>user/credit_voucher/' + lnid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
                    swal.close(); // Hide the loading message
                    srchLoan();
                },
                error: function (data, textStatus, jqXHR) {
                    swal({
                            title: "Voucher issuee Failed",
                            text: "contact system admin.. ",
                            type: "error"
                        },
                        function () {
                            //location.reload();
                        }
                    );
                }
            });
        }, 1000);

    }

    function viewVouch(id) {
        var d1 = '/' + id;
        window.open('<?= base_url(); ?>account/credit_voucher' + d1, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
    }

</script>












