<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Sales Report</li>
    <li class="active"> Depletion Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Depletion Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_depti" name="rpt_depti" class="form-horizontal" method="post">
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
                            </div>
                        </div>
                        <br>
                        <div class="row ">
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
                                           id="dataTbDeption" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRCH</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">PRDT</th>
                                            <th class="text-center">OPENING <br> STOCK</th>
                                            <th class="text-center">PRODUCT <br>INVESTMENT</th>
                                            <th class="text-center">NORMAL <br>DEPLETION</th>
                                            <th class="text-center">YEAR OPEN <br>STOCK %</th>
                                            <th class="text-center"><?= date('Y'); ?> YEAR EARLY<BR/>SET.DEP</th>
                                            <th class="text-center">MONTH OPEN<BR/>STOCK % EARLY</th>
                                            <th class="text-center">TOTAL<BR/>DEPLETION</th>
                                            <th class="text-center">CLOSING<BR/>STOCK</th>
                                            <th class="text-center">OFFICER<BR/>NORMAL INCOME</th>
                                            <th class="text-center">EARLY<BR/>SET INCOME</th>
                                            <th class="text-center">TOTAL<BR/>INCOME</th>
                                            <th class="text-center">PORTFOLIO</th>
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

</body>
<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbDeption').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_depti").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                exc: {
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
                exc: {
                    required: 'Please select officer',
                    notEqual: "Please select officer"
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
        if ($("#rpt_depti").valid()) {

            var brn = document.getElementById('brch').value;
            var ofcr = document.getElementById('exc').value;
            var prtp = document.getElementById('prtp').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            $('#dataTbDeption').DataTable().clear();
            $('#dataTbDeption').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "paging": true,
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
                    {className: "text-left", "targets": [2, 3]},
                    {className: "text-center", "targets": [0, 1,7,9]},
                    {className: "text-right", "targets": [4, 5, 6, 8, 10, 11, 12, 13, 14, 15]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                //"order": [[10, "asc"]], //ASC  desc
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
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/srchDepletion',
                    type: 'post',
                    data: {
                        brn: brn,
                        ofcr: ofcr,
                        prtp: prtp,
                        frdt: frdt,
                        todt: todt,
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
                    //COLUMN 9 TTL
                    t9 = api.column(9).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t9 = addCommas(t9);
                    $(api.column(9).footer()).html(t9);

                    //COLUMN 10 TTL
                    t10 = api.column(10).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t10 = addCommas(t10);
                    $(api.column(10).footer()).html(t10);
                     //COLUMN 11 TTL
                    t11 = api.column(11).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t11 = addCommas(t11);
                    $(api.column(11).footer()).html(t11);
                     //COLUMN 12 TTL
                    t12 = api.column(12).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t12 = addCommas(t12);
                    $(api.column(12).footer()).html(t12);
                     //COLUMN 13 TTL
                    t13 = api.column(13).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t13 = addCommas(t13);
                    $(api.column(13).footer()).html(t13);
                     //COLUMN 14 TTL
                    t14 = api.column(14).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t14 = addCommas(t14);
                    $(api.column(14).footer()).html(t14);
                     //COLUMN 15 TTL
                    t15 = api.column(15).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t15 = addCommas(t15);
                    $(api.column(15).footer()).html(t15);

                }
            });
        }
    });

    // EXCEL EXPORT
    $("#excel").click(function (e) {
        e.preventDefault();
        if ($("#rpt_depti").valid()) {

            var brn = document.getElementById('brch').value;
            var ofcr = document.getElementById('exc').value;
            var prtp = document.getElementById('prtp').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>excelrpt/depletion/' + brn + '/' + ofcr + '/' + prtp + '/' + frdt + '/' + todt;

        }
    });

</script>
