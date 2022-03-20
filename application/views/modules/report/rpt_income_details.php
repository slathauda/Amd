<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Sales Report</li>
    <li class="active"> Income Details Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Income Details Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_income" name="rpt_income" class="form-horizontal" method="post">
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
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
                                    <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker"
                                               id="frdt" name="frdt" value="<?= date("Y-m-d") ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker"
                                               id="todt" name="todt" value="<?= date("Y-m-d") ?>"/>
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
                        <br>
                        <div class="row">
                        </div>
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbIncome" width="100%">
                                        <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">NO</th>
                                            <th rowspan="2" class="text-center">BRCH</th>

                                            <th colspan="3" class="text-center">LOAN AS PORTFOLIO</th>
                                            <th colspan="2" class="text-center">INVESTMENT</th>
                                            <th colspan="2" class="text-center">SHOULD COLLECTED</th>
                                            <th colspan="2" class="text-center">INCOME</th>
                                            <th colspan="2" class="text-center">FUTURE INCOME</th>
                                            <th colspan="2" class="text-center">DEBTOR</th>
                                            <th colspan="2" class="text-center">DOC/INSU FEE</th>

                                            <th rowspan="2" class="text-center">PENALTY RECVD</th>
                                            <th rowspan="2" class="text-center">TARGET</th>
                                            <th rowspan="2" class="text-center">ACHIVE %</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">CURRENT</th>
                                            <th class="text-center">FINISHED</th>
                                            <th class="text-center">TERMINATED</th>
                                            <th class="text-center">CUMILATIVE</th>
                                            <th class="text-center">MONTHLY</th>
                                            <th class="text-center">CAP</th>
                                            <th class="text-center">INT</th>
                                            <th class="text-center">CAP</th>
                                            <th class="text-center">INT</th>
                                            <th class="text-center">BAL CAP</th>
                                            <th class="text-center">BAL INT</th>
                                            <th class="text-center">DUE CAP</th>
                                            <th class="text-center">DUE INT</th>
                                            <th class="text-center">DOC</th>
                                            <th class="text-center">INSU</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
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

<!-- CURRENT DETAILS POPUP -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">LOAN SUMMERY | <span id="aa1"></span>
                </h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="modal-body scroll" style="height:500px;" id="ac_stp">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-actions"
                                       id="sumry_tb" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Customer Name</th>
                                        <th class="text-center">Loan No</th>
                                        <th class="text-center">Loan Amount</th>
                                        <th class="text-center">Paid Amount</th>
                                        <!--  <th class="text-center">Portfolio</th> -->
                                        <th class="text-center">Arrears Capital</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Arrears Amount</th>
                                        <th class="text-center">Balance</th>
                                        <!-- <th width="60"><span id="sd1"></span></th> -->
                                        <th class="text-center">AGE</th>
                                        <th class="text-center">Status</th>
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
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
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
<!-- /CURRENT DETAILS POPUP -->

<!-- LEDGER POPUP -->
<div class="modal" id="modalLeg" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Account Ledger <span id="aa1"></span></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="modal-body scroll" style="height:500px;" id="ac_stp">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered  table-actions"
                                       id="stp_tbl" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Reference</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Capital</th>
                                        <th class="text-center">Interest</th>
                                        <th class="text-center">Penalty</th>
                                        <th class="text-center">Other</th>
                                        <th class="text-center">Due</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Arrears</th>
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
                                    </tfoot>
                                    <tbody>
                                    </tbody>
                                </table>
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
<!-- END LEDGER POPUP -->


</body>
<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbIncome').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_income").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                prtp: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                brch: {
                    required: 'Please select branch',
                    notEqual: "Please select branch"
                },
                prtp: {
                    required: 'Please select Product Type',
                    notEqual: "Please select Product Type"
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
        if ($("#rpt_income").valid()) {

            var brn = document.getElementById('brch').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            $('#dataTbIncome').DataTable().clear();
            $('#dataTbIncome').DataTable({
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
                    {className: "text-left", "targets": []},
                    {className: "text-center", "targets": [0, 1]},
                    {className: "text-right", "targets": [0, 2, 3, 4, 5, 6,7, 8, 9,10, 11, 12,13, 14, 15,16, 17, 18,19]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
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

                "ajax": {
                    url: '<?= base_url(); ?>report/srchIncom',
                    type: 'post',
                    data: {
                        brn: brn,
                        frdt: frdt,
                        todt: todt,
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // converting to interger to find total
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };
                    // computing column Total of the complete result
                    //COLUMN 2 TTL
                    var t2 = api.column(2).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(2).footer()).html(numeral(t2).format('0,0.00'));
                    //COLUMN 3 TTL
                    var t3 = api.column(3).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
                    //COLUMN 4 TTL
                    var t4 = api.column(4).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                    //COLUMN 5 TTL
                    var t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                    //COLUMN 6 TTL
                    var t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                    //COLUMN 7 TTL
                    var t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                    //COLUMN 8 TTL
                    var t8 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));

                    //COLUMN 9 TTL
                    var t9 = api.column(9).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(9).footer()).html(numeral(t9).format('0,0.00'));
                    //COLUMN 10 TTL
                    var t10 = api.column(10).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(10).footer()).html(numeral(t10).format('0,0.00'));
                    //COLUMN 11 TTL
                    var t11 = api.column(11).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(11).footer()).html(numeral(t11).format('0,0.00'));
                    //COLUMN 12 TTL
                    var t12 = api.column(12).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(12).footer()).html(numeral(t12).format('0,0.00'));
                    //COLUMN 13 TTL
                    var t13 = api.column(13).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(13).footer()).html(numeral(t13).format('0,0.00'));
                    //COLUMN 14 TTL
                    var t14 = api.column(14).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(14).footer()).html(numeral(t14).format('0,0.00'));
                    //COLUMN 15 TTL
                    var t15 = api.column(15).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(15).footer()).html(numeral(t15).format('0,0.00'));
                    //COLUMN 16 TTL
                    var t16 = api.column(16).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(16).footer()).html(numeral(t16).format('0,0.00'));
                    //COLUMN 17 TTL
                    var t17 = api.column(17).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(17).footer()).html(numeral(t17).format('0,0.00'));
                    //COLUMN 18 TTL
                    var t18 = api.column(18).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(18).footer()).html(numeral(t18).format('0,0.00'));
                    //COLUMN 19 TTL
                    var t19 = api.column(19).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(19).footer()).html(numeral(t19).format('0,0.00'));


                },
            });
        }
    });

    // EXCEL EXPORT
    $("#excel").click(function (e) {
        e.preventDefault();
        if ($("#rpt_income").valid()) {

            var brn = document.getElementById('brch').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>excelrpt/incomeDetails/' + brn + '/' + frdt + '/' + todt ;

        }
    });

</script>












