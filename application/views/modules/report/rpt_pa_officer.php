<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Pa Report</li>
    <li class="active"> Officer Wise Pa Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Officer Wise Pa Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_paOfc" name="rpt_paOfc" class="form-horizontal" method="post">
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
                                           id="dataTbPaofc" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">RANG</th>
                                            <th class="text-center">LOAN SUM</th>
                                            <th class="text-center">CAP + INT SUM</th>
                                            <th class="text-center">CUS COUNT</th>
                                            <th class="text-center">DEBTOR SUM</th>
                                            <th class="text-center">DEBTOR SUM %</th>
                                            <th class="text-center">CAP SUM</th>
                                            <th class="text-center">PORTFOLIO SUM</th>
                                            <th class="text-center">VIEW</th>
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
        $('#dataTbPaofc').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_paOfc").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                exc: {
                    required: true,
                    notEqual: '0'
                },
                /*  cen: {
                 required: true,
                 notEqual: '0'
                 },
                 cndy: {
                 required: true,
                 notEqual: '-'
                 },
                 frag: {
                 required: true,
                 notEqual: '-'
                 },
                 toag: {
                 required: true,
                 notEqual: '-'
                 },*/
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
                exc: {
                    required: 'Please select officer',
                    notEqual: "Please select officer"
                },
                cen: {
                    required: 'Please select center',
                    notEqual: "Please select center"
                },
                cndy: {
                    required: 'Please select Center Day',
                    notEqual: "Please select Center Day"
                },
                frag: {
                    required: 'Please select Arrears Age',
                    notEqual: "Please select Arrears Age"
                },
                toag: {
                    required: 'Please select Arrears Age',
                    notEqual: "Please select Arrears Age"
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
        if ($("#rpt_paOfc").valid()) {

            var brn = document.getElementById('brch').value;
            var prtp = document.getElementById('prtp').value;
            var ofcr = document.getElementById('exc').value;


            $('#dataTbPaofc').DataTable().clear();
            $('#dataTbPaofc').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "paging": false,
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
                    {className: "text-center", "targets": [0, 1,4, 9]},
                    {className: "text-right", "targets": [2, 3,  5, 6, 7, 8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                //"order": [[10, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/srchPaOfcr',
                    type: 'post',
                    data: {
                        brn: brn,
                        prtp: prtp,
                        ofcr: ofcr
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

                    //COLUMN 2 TTL
                    t1 = api.column(2).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t1 = addCommas(t1);
                    $(api.column(2).footer()).html(t1);

                    //COLUMN 3 TTL
                    t3 = api.column(3).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t3 = addCommas(t3);
                    $(api.column(3).footer()).html(t3);

                    //COLUMN 4 TTL
                    t4 = api.column(4).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(t4);

                    //COLUMN 5 TTL
                    t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t5 = addCommas(t5);
                    $(api.column(5).footer()).html(t5);

                    //COLUMN 6 TTL
                    t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t6 = addCommas(t6);
                    $(api.column(6).footer()).html(t6);

                    //COLUMN 7 TTL
                    t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t7 = addCommas(t7);
                    $(api.column(7).footer()).html(t7);

                    //COLUMN 8 TTL
                    t8 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t8 = addCommas(t8);
                    $(api.column(8).footer()).html(t8);

                }
            });
        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_paOfc").valid()) {

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
    function vieLeg(typ) {

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

        var brid = document.getElementById('brch').value;
        var prid = document.getElementById('prtp').value;
        var exec = document.getElementById('exc').value;


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
                    exc: exec
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












