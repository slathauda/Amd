<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Sales Report</li>
    <li class="active"> Debtor From Investment Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Debtor From Investment Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_dbt_invt" name="rpt_dbt_invt" class="form-horizontal" method="post">
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="prtp" id="prtp">
                                            <option value="all"> All Type</option>
                                            <?php
                                            foreach ($prtpinfo as $prtp) {
                                                echo "<option value='$prtp->prid'>$prtp->prna</option>";
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
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Age Rang From</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="frag" id="frag">
                                            <option value="-"> -- Select Age --</option>
                                            <option value="-100"> Age < 0</option>
                                            <option value="0"> Age 0</option>
                                            <option value="1"> Age 1</option>
                                            <option value="2"> Age 2</option>
                                            <option value="3"> Age 3</option>
                                            <option value="4"> Age 4</option>
                                            <option value="5"> Age 5</option>
                                            <option value="6"> Age 6</option>
                                            <option value="7"> Age 7</option>
                                            <option value="8"> Age 8</option>
                                            <option value="9"> Age 9</option>
                                            <option value="10"> Age 10</option>
                                            <option value="100"> Age >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Age Rang To</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="toag" id="toag">
                                            <option value="-"> -- Select Age --</option>
                                            <option value="-100"> Age < 0</option>
                                            <option value="0"> Age 0</option>
                                            <option value="1"> Age 1</option>
                                            <option value="2"> Age 2</option>
                                            <option value="3"> Age 3</option>
                                            <option value="4"> Age 4</option>
                                            <option value="5"> Age 5</option>
                                            <option value="6"> Age 6</option>
                                            <option value="7"> Age 7</option>
                                            <option value="8"> Age 8</option>
                                            <option value="9"> Age 9</option>
                                            <option value="10"> Age 10</option>
                                            <option value="100"> Age >10</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                           id="dataTbDbtInvst" width="120%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">CSU</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">PRDT</th>
                                            <th class="text-center">CUSTOMER</th>
                                            <th class="text-center">CUSTOMER NO</th>
                                            <th class="text-center">NIC</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">START</th>
                                            <th class="text-center">AMOUNT</th>

                                            <th class="text-center">ARREARS</th>
                                            <th class="text-center">AGE</th>
                                            <th class="text-center">LAST PAY</th>
                                            <th class="text-center">PAID AMT</th>
                                            <th class="text-center">CAP BAL</th>
                                            <th class="text-center">INT BAL</th>
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

<!-- LEDGER POPUP -->
<div class="modal" id="modalLeg" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
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
                                    </tr>
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
        $('#dataTbDbtInvst').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_dbt_invt").validate({  // Product loan validation
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
                prtp: {
                    required: true,
                    notEqual: '0'
                },
                frag: {
                    required: true,
                    notEqual: '-'
                },
                toag: {
                    required: true,
                    notEqual: '-'
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
                prtp: {
                    required: 'Please select Product Type',
                    notEqual: "Please select Product Type"
                },
                frag: {
                    required: 'Please select Age range',
                    notEqual: "Please select Age range"
                },
                toag: {
                    required: 'Please select Age range',
                    notEqual: "Please select Age range"
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
        if ($("#rpt_dbt_invt").valid()) {

            var brn = document.getElementById('brch').value;
            var prtp = document.getElementById('prtp').value;
            var ofcr = document.getElementById('exc').value;
            var cen = document.getElementById('cen').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;
            var frag = document.getElementById('frag').value;
            var toag = document.getElementById('toag').value;

            $('#dataTbDbtInvst').DataTable().clear();
            $('#dataTbDbtInvst').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 5, 6, 7, 8, 9]},
                    {className: "text-center", "targets": [0, 4, 12]},
                    {className: "text-right", "targets": [0, 10, 11, 13, 14, 15, 16]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '13%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},

                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/srchDbtInvst',
                    type: 'post',
                    data: {
                        brn: brn,
                        prtp: prtp,
                        ofcr: ofcr,
                        cen: cen,
                        frdt: frdt,
                        todt: todt,
                        frag: frag,
                        toag: toag,
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
                },
            });
        }
    });

    // EXCEL EXPORT
    $("#excel").click(function (e) {
        e.preventDefault();
        if ($("#rpt_dbt_invt").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cen = document.getElementById('cen').value;
            var prtp = document.getElementById('prtp').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;
            var frag = document.getElementById('frag').value;
            var toag = document.getElementById('toag').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>Excelrpt/debtorinvestment/' + brn + '/' + ofc + '/' + cen + '/' + prtp + '/' + frdt + '/' + todt + '/' + frag + '/' + toag;
        }
    });

    // VIEW LEDGER
    function vieLeg(lnid) {

        var arreas = 0;
        var prim = 0;

        $('#stp_tbl').DataTable().clear();
        $('#stp_tbl').DataTable({
            "destroy": true,
            "cache": false,
            //"scrollY": "400px",
            "scrollCollapse": true,
            "searching": false,
            "paging": false,
            "processing": true,
            "serverSide": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "columnDefs": [
                {className: "text-center", "targets": [0]},
                {className: "text-left", "targets": [1, 2, 3]},
                {className: "text-right", "targets": [4, 5, 6, 7, 8, 9, 10]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '13%'},
                {sWidth: '10%'},
                {sWidth: '15%'},
                {sWidth: '5%'}, // CAP
                {sWidth: '5%'},
                {sWidth: '5%'}, // PNLT
                {sWidth: '5%'},
                {sWidth: '5%'},     // DUE
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "rowCallback": function (row, data, index) {
                var pymt = parseFloat(data[9]),
                    duam = parseFloat(data[8]),
                    pnlt = parseFloat(data[6]),
                    $node = this.api().row(row).nodes().to$();

                if (pymt > 0) {
                    $node.addClass('info')
                } else if (pymt < 0) {
                    $node.addClass('danger')
                } else if (duam > 0 && pnlt > 0) {
                    $node.addClass('danger')
                }
                var x = data[8];
                x = x.replace(",", "");
                if (parseFloat(x) > parseFloat(prim)) {
                    prim = data[8].replace(",", "");
                }
                arreas = data[10].replace(",", "");
            },
            "ajax": {
                url: '<?= base_url(); ?>report/getLoanLeg',
                type: 'post',
                data: {
                    lnid: lnid,
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
                //COLUMN 4 TTL
                var t4 = api.column(4).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 7 TTL
                var t7 = api.column(7).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                //COLUMN 8 TTL
                var t8 = api.column(8).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 9 TTL
                var t9 = api.column(9).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 10 TTL
                var t10 = api.column(10).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));
                $(api.column(9).footer()).html(numeral(t9).format('0,0.00'));
                $(api.column(10).footer()).html(numeral(t10).format('0,0.00'));

            },
        });

    }


</script>












