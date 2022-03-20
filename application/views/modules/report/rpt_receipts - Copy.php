<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Account Report</li>
    <li class="active"> Receipts Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Receipts Report </strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_rcept" name="rpt_rcept" class="form-horizontal" method="post">
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
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
                            </div>
                        </div>
                        <br>
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker" placeholder="date"
                                               id="frdt" name="frdt" value="<?= date("Y-m-d"); ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker" placeholder="date"
                                               id="todt" name="todt" value="<?= date("Y-m-d"); ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Receipts Type</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="rctp" id="rctp">
                                            <option value="all">All Type</option>
                                            <option value="1">General Receipts </option>
                                            <option value="2">Repeyment Receipts </option>
                                            <option value="3">Deposit Receipts </option>
                                            <option value="4">Topup Receipts </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 text-right"></label>
                                    <div class="col-md-6 col-xs-12 text-right">
                                        <button type="button form-control  "
                                                class='btn-sm btn-primary panel-refresh' id="srch">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                        <button type="button form-control" id="print"
                                                class='btn-sm btn-info'>
                                            <i class="fa fa-print"></i> Print
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbRecpt" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">PAY MODE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">CR DATE</th>
                                            <th class="text-center">CR BY</th>
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

</body>
<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbRecpt').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_rcept").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                exc: {
                    required: true,
                    notEqual: '0'
                },
                cen: {
                    required: true,
                    notEqual: '0'
                },
                rctp: {
                    required: true,
                    notEqual: '0'
                },

            },
            messages: {
                brch: {
                    required: 'Please select Account',
                    notEqual: "Please select Account"
                },
                exc: {
                    required: 'Please enter Pay Account',
                    notEqual: "Please select Pay Account"
                },
                cen: {
                    required: 'Please enter Pay Account',
                    notEqual: "Please select Pay Account"
                },
                rctp: {
                    required: 'Please enter Pay Account',
                    notEqual: "Please select Pay Account"
                },

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

    // SEARCH
    $("#srch").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rcept").valid()) {

            var brn = document.getElementById('brch').value;

            $('#dataTbRecpt').DataTable().clear();
            $('#dataTbRecpt').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 5, 8, 9]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[4, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '10%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '10%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // period
                    {sWidth: '5%'},
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchRcverLoan',
                    type: 'post',
                    data: {
                        brn : brn
                    }

                }
            });

        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rcept").valid()) {

            var brn = document.getElementById('brch').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printReceipts' + brn + '/' + brn;

        }
    });


</script>












