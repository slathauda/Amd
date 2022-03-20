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
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Status</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="rcst" id="rcst">
                                            <option value="all">All Type</option>
                                            <option value="1">Active Receipts</option>
                                            <option value="0">Cancel Receipts</option>
                                        </select>
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
                                            <option value="1">General Receipts</option>
                                            <option value="2">Repeyment Receipts</option>
                                            <option value="3">Deposit Receipts</option>
                                            <option value="4">Topup Receipts</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 text-right"></label>
                                    <div class="col-md-6 col-xs-12 text-right">
                                        <button type="button form-control  "
                                                class='btn btn-sm btn-primary panel-refresh' id="srch">
                                            <i class="fa fa-search"></i> Search
                                        </button>

                                        <div class="button btn-group pull-right" style="padding-left: 3px">
                                            <button class="btn btn-sm btn-danger dropdown-toggle"
                                                    data-toggle="dropdown"><i class="fa fa-bars"></i> Export
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a href="#" id="print"><img
                                                                src='<?= base_url(); ?>assets/dist/img/icons/pdf.png'
                                                                width="24"/> PDF</a></li>
                                                <li><a href="#" id="excel"><img
                                                                src='<?= base_url(); ?>assets/dist/img/icons/xls.png'
                                                                width="24"/> EXCEL</a></li>
                                            </ul>
                                        </div>

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
                                            <th class="text-center">RECEIPTS NO</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">PAY STATUS</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">PAY TYPE</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">CR DATE</th>
                                            <th class="text-center">CR BY</th>
                                            <th class="text-center">OPTION</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        </tfoot>
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
                    required: 'Please select branch',
                    notEqual: "Please select branch"
                },
                exc: {
                    required: 'Please select officer',
                    notEqual: "Please select officer"
                },
                cen: {
                    required: 'Please select center',
                    notEqual: "Please select center"
                },
                rctp: {
                    required: 'Please select receipt type',
                    notEqual: "Please select receipt type"
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

    // SEARCH
    $("#srch").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rcept").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;
            var rctp = document.getElementById('rctp').value;
            var rcst = document.getElementById('rcst').value;

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
                    {className: "text-left", "targets": [2, 3, 4, 5, 6, 10, 11, 12]},
                    {className: "text-center", "targets": [0, 1, 8, 9]},
                    {className: "text-right", "targets": [0, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[10, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '4%'},
                    {sWidth: '4%'},    // BRN
                    {sWidth: '10%'},   //
                    {sWidth: '10%'},   // NAME
                    {sWidth: '8%'},    //
                    {sWidth: '8%'},    // MODE
                    {sWidth: '10%'},   //
                    {sWidth: '5%'},    // AMOUNT
                    {sWidth: '5%'},    // PAY TYPE
                    {sWidth: '5%'},    //
                    {sWidth: '10%'},   // DATE
                    {sWidth: '5%'},    //
                    {sWidth: '8%'}     //
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/searchRecpt',
                    type: 'post',
                    data: {
                        brn: brn,
                        ofc: ofc,
                        cnt: cnt,
                        frdt: frdt,
                        todt: todt,
                        rctp: rctp,
                        rcst: rcst,
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    //COLUMN 7 TTL
                    var t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                },
            });

        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rcept").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;
            var rctp = document.getElementById('rctp').value;
            var rcst = document.getElementById('rcst').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printReceipts/' + brn + '/' + ofc + '/' + cnt + '/' + frdt + '/' + todt + '/' + rctp + '/' + rcst;

        }
    });

    // RECEIPTS SEND
    function sendRecipt(auid) {
        swal({
            title: "Developing...||| ",
            text: "Receipts generating..",
            imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        setTimeout(function () {
            swal.close(); // Hide the loading message
        }, 1000);

    }

    // RECEIPTS PRINT
    function prntRecipt(auid) {

        swal({
            title: "Please wait...",
            text: "Receipts generating..",
            imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        setTimeout(function () {
            window.open('<?= base_url() ?>user/reciptPrint/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            swal.close(); // Hide the loading message

        }, 1000);

    }


</script>

