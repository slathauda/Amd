<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Pa Report</li>
    <li class="active"> Branch Wise Pa Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Branch Wise Pa Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_paBrn" name="rpt_paBrn" class="form-horizontal" method="post">
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
                    </form>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbPabrn" width="100%">
                                        <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">BRNC</th>
                                            <th rowspan="2" class="text-center">PRD</th>
                                            <th colspan="2" class="text-center">< 0</th>
                                            <th colspan="2" class="text-center">0 - 1</th>
                                            <th colspan="2" class="text-center">1 - 2</th>
                                            <th colspan="2" class="text-center">2 - 3</th>
                                            <th colspan="2" class="text-center">3 - 4</th>
                                            <th colspan="2" class="text-center">4 - 5</th>
                                            <th colspan="2" class="text-center">5 - 6</th>
                                            <th colspan="2" class="text-center">> 6</th>
                                            <th rowspan="2" class="text-center">TOTAL</th>
                                            <th rowspan="2" class="text-center">TOTAL %</th>

                                        </tr>
                                        <tr>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>
                                            <th class="text-center">TOTAL</th>
                                            <th class="text-center">TOTAL %</th>

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

<!-- LEDGER POPUP -->
<div class="modal" id="modalLeg" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Pa Ledger <span id="aa1"></span></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="modal-body scroll" style="height:500px;" id="ac_stp">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered  table-actions"
                                       id="leg_tbl" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">BRNC</th>
                                        <th class="text-center">CSU</th>
                                        <th class="text-center">OFFCER</th>
                                        <th class="text-center">PRDS</th>

                                        <th class="text-center">CUSTOMER</th>
                                        <th class="text-center">NIC</th>
                                        <th class="text-center">MOBILE</th>
                                        <th class="text-center">LNNO</th>

                                        <th class="text-center">LN AMNT</th>
                                        <th class="text-center">PERIOD</th>
                                        <th class="text-center">LN IDX</th>
                                        <th class="text-center">FU RNT</th>
                                        <th class="text-center">RNTL</th>

                                        <th class="text-center">CAP BAL</th>
                                        <th class="text-center">INT BAL</th>
                                        <th class="text-center">ARR CAP</th>
                                        <th class="text-center">ARR INT</th>
                                        <th class="text-center">PENALTY</th>

                                        <th class="text-center">LN BAL</th>
                                        <th class="text-center">ARR AMT</th>
                                        <th class="text-center">ARR AGE</th>
                                        <th class="text-center">LST DATE</th>
                                        <th class="text-center">LST PAYMNT</th>
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
        $('#dataTbPabrn').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_paBrn").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },

                /* prtp: {
                 required: true,
                 notEqual: 'all'
                 },*/
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
        if ($("#rpt_paBrn").valid()) {

            var brn = document.getElementById('brch').value;
            var prtp = document.getElementById('prtp').value;


            $('#dataTbPabrn').DataTable().clear();
            $('#dataTbPabrn').DataTable({
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
                    {className: "text-center", "targets": [0, 1, 3, 5, 7, 9, 11, 13, 15, 17]},
                    {
                        className: "text-right",
                        "targets": [2, 4, 6, 8, 10, 12, 14, 16, 18, 19]
                    },
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[10, "asc"]], //ASC  desc
                "aoColumns": [
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
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/srchPaBrnch',
                    type: 'post',
                    data: {
                        brn: brn,
                        prtp: prtp,
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

                    //THOUSAND COMMA
                    function addCommas(nStr) {
                        nStr += '';
                        x = nStr.split('.');
                        x1 = x[0];
                        x2 = x.length > 1 ? '.' + x[1] : '';
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        }
                        return x1 + x2;
                    }

                    //COLUMN 1 TTL
                    t1 = api.column(2).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t1 = addCommas(t1);

                    pt1 = api.column(2, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt1 = addCommas(pt1);

                    $(api.column(2).footer()).html(
                        pt1 + '<br/> (' + t1 + ')' //pt7 +'<br/> ( '+ t7 +' Total )'
                    );

                    //COLUMN 3 TTL
                    t3 = api.column(4).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t3 = addCommas(t3);

                    pt3 = api.column(4, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt3 = addCommas(pt3);

                    $(api.column(4).footer()).html(pt3 + '<br/> (' + t3 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );

                    //COLUMN 5 TTL
                    t5 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t5 = addCommas(t5);

                    pt5 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt5 = addCommas(pt5);

                    $(api.column(6).footer()).html(pt5 + '<br/> (' + t5 + ')'
                    );

                    //COLUMN 7 TTL
                    t7 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t7 = addCommas(t7);

                    pt7 = api.column(8, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt7 = addCommas(pt7);

                    $(api.column(8).footer()).html(pt7 + '<br/> (' + t7 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );

                    //COLUMN 9 TTL
                    t9 = api.column(10).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t9 = addCommas(t9);

                    pt9 = api.column(10, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt9 = addCommas(pt9);

                    $(api.column(10).footer()).html(
                        pt9 + '<br/> (' + t9 + ')' //pt7 +'<br/> ( '+ t7 +' Total )'
                    );

                    //COLUMN 11 TTL
                    t11 = api.column(12).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t11 = addCommas(t11);

                    pt11 = api.column(12, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt11 = addCommas(pt11);

                    $(api.column(12).footer()).html(pt11 + '<br/> (' + t11 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );

                    //COLUMN 13 TTL
                    t13 = api.column(14).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t13 = addCommas(t13);

                    pt13 = api.column(14, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt13 = addCommas(pt13);

                    $(api.column(14).footer()).html(pt13 + '<br/> (' + t13 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );

                    //COLUMN 15 TTL
                    t1 = api.column(16).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t15 = addCommas(t1);

                    pt15 = api.column(16, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt15 = addCommas(pt15);

                    $(api.column(16).footer()).html(
                        pt15 + '<br/> (' + t15 + ')' //pt7 +'<br/> ( '+ t7 +' Total )'
                    );

                    //COLUMN 17 TTL
                    t17 = api.column(18).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t17 = addCommas(t17);

                    pt17 = api.column(18, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt17 = addCommas(pt17);

                    $(api.column(18).footer()).html(pt17 + '<br/> (' + t17 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );
                }

            });
        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_paBrn").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var prtp = document.getElementById('prtp').value;
            var frag = document.getElementById('frag').value;
            var toag = document.getElementById('toag').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printArresAge/' + brn + '/' + ofc + '/' + cnt + '/' + prtp + '/' + frag + '/' + toag;

        }
    });

    // VIEW LEDGER
    function vieLeg(brid, prid, typ) {

        switch (typ) {
            case 1:
                code = '< 0';
                break;
            case 2:
                code = '0 - 1';
                break;
            case 3:
                code = '1 - 2';
                break;
            case 4:
                code = '2 - 3';
                break;
            case 5:
                code = '3 - 4';
                break;
            case 6:
                code = '4 - 5';
                break;
            case 7:
                code = '5 - 6';
                break;
            case 8:
                code = '> 6';
                break;
            case 9:
                code = 'All';
                break;
            default:
                code = 'No';
        }
        $('#aa1').text(code); //  Search Type SHOW

        var arreas = 0;
        var prim = 0;

        $('#leg_tbl').DataTable().clear();
        $('#leg_tbl').DataTable({
            "destroy": true,
            "cache": false,
            //"scrollY": "400px",
            "scrollCollapse": true,
            "orderable": false,
            "searching": false,
            "paging": false,
            "processing": true,
            "serverSide": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "columnDefs": [
                {className: "text-center", "targets": [0, 22]},
                {className: "text-left", "targets": [1, 2, 3, 5]},
                {
                    className: "text-right",
                    "targets": [4, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 23]
                },
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '13%'},
                {sWidth: '10%'},
                {sWidth: '15%'},
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
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>report/getPaLeg',
                type: 'post',
                data: {
                    brid: brid,
                    prid: prid,
                    typ: typ,
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
                //COLUMN 9 TTL
                var t9 = api.column(9).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 13 TTL
                var t13 = api.column(13).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 14 TTL
                var t14 = api.column(14).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 15
                var t15 = api.column(15).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 16 TTL
                var t16 = api.column(16).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 17 TTL
                var t17 = api.column(17).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 18 TTL
                var t18 = api.column(18).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 19 TTL
                var t19 = api.column(19).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 20 TTL
                var t20 = api.column(20).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 23 TTL
                var t23 = api.column(23).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(9).footer()).html(numeral(t9).format('0,0.00'));
                $(api.column(13).footer()).html(numeral(t13).format('0,0.00'));
                $(api.column(14).footer()).html(numeral(t14).format('0,0.00'));
                $(api.column(15).footer()).html(numeral(t15).format('0,0.00'));
                $(api.column(16).footer()).html(numeral(t16).format('0,0.00'));
                $(api.column(17).footer()).html(numeral(t17).format('0,0.00'));
                $(api.column(18).footer()).html(numeral(t18).format('0,0.00'));
                $(api.column(19).footer()).html(numeral(t19).format('0,0.00'));
                $(api.column(20).footer()).html(numeral(t20).format('0,0.00'));
                $(api.column(23).footer()).html(numeral(t23).format('0,0.00'));

            },
        });
    }


</script>












