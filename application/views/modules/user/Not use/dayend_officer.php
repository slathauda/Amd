<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Officer Dayend</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Officer Dayend </strong></h3>
                </div>
                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getExe(this.value,'ofcr',ofcr.value);chckBtn(this.value,'brch')">
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
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="ofcr" id="ofcr"
                                            onchange="">
                                        <?php
                                        foreach ($execinfo as $exe) {
                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<? /*= date("Y-m-d"); */ ?>">

                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label"> Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date("Y-m-d"); ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchDenomi()"
                                            class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <button type="button form-control  " onclick="printDenomi()"
                                            class='btn-sm btn-info'><i class="fa fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="form-horizontal" id="ofcrDyend" name="ofcrDyend" action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">
                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="dataTbOfcdenomi" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">BRANCH</th>
                                                <th class="text-center">OFFICER</th>
                                                <th class="text-center">5000</th>
                                                <th class="text-center">2000</th>
                                                <th class="text-center">1000</th>
                                                <th class="text-center">500</th>
                                                <th class="text-center">100</th>
                                                <th class="text-center">50</th>
                                                <th class="text-center">20</th>
                                                <th class="text-center">10</th>
                                                <th class="text-center">CENTERS</th>
                                                <th class="text-center">REPAYMNTS</th>
                                                <th class="text-center">CR BY</th>
                                                <th class="text-center">Denomination</th>
                                                <th class="text-center">SYSTEM TTL</th>
                                                <th class="text-center">CHECK</th>
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
                                            </tfoot>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <input type="hidden" id="len" name="len">
                                <input type="hidden" name="tody" id="tody" value="<?= date("Y-m-d"); ?>">
                                <div class="panel-footer">
                                    <?php if ($funcPerm[0]->inst == 1) { ?>
                                        <button type="button" id="prcsBtn" class="btn btn-success pull-right">process
                                        </button>
                                    <?php } ?>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->


</body>
<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbOfcdenomi').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        document.getElementById('prcsBtn').setAttribute("class", "hidden");

        $("#dnom_add").validate({  // Product loan validation
            rules: {
                dnmBrn: {
                    required: true,
                    notEqual: '0'
                },
                dnusr: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                dnmBrn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                dnusr: {
                    required: 'Please select user',
                    notEqual: "Please select user"
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

    // DENOMINATION SEARCH
    function srchDenomi() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exe = document.getElementById('ofcr').value;
        var dte = document.getElementById('frdt').value;

        var tody = document.getElementById('tody').value;


//        if (dte === tody) {
//            document.getElementById('prcsBtn').removeAttribute("class");
//            document.getElementById('prcsBtn').setAttribute("class", "btn btn-success pull-right");
//        } else {
//            document.getElementById('prcsBtn').setAttribute("class", "hidden");
//        }

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbOfcdenomi').DataTable().clear();
            $('#dataTbOfcdenomi').DataTable({
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
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0, 3, 4, 5, 7, 8, 9, 10, 11, 12, 16]},
                    {className: "text-right", "targets": [14, 15]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[3, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br
                    {sWidth: '10%'},    // ofcr
                    {sWidth: '10%'},    // denomi date
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // pay type
                    {sWidth: '10%'},     //
                    {sWidth: '10%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchOfcrDenomi',
                    type: 'post',
                    data: {
                        brn: brn,
                        exe: exe,
                        dte: dte
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;

                    if (display.length > 0) {
                        document.getElementById('prcsBtn').removeAttribute("class");
                        document.getElementById('prcsBtn').setAttribute("class", "btn btn-success pull-right");
                    } else {
                        document.getElementById('prcsBtn').setAttribute("class", "hidden");
                    }

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    //COLUMN 3 TTL
                    var t3 = api.column(3).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(3).footer()).html(t3);
                    //COLUMN 4 TTL
                    var t4 = api.column(4).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(4).footer()).html(t4);
                    //COLUMN 5 TTL
                    var t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(5).footer()).html(t5);
                    //COLUMN 6 TTL
                    var t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(6).footer()).html(t6);
                    //COLUMN 7 TTL
                    var t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(7).footer()).html(t7);
                    //COLUMN 8 TTL
                    var t8 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(8).footer()).html(t8);
                    //COLUMN 9 TTL
                    var t9 = api.column(9).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(9).footer()).html(t9);
                    //COLUMN 10 TTL
                    var t10 = api.column(10).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(10).footer()).html(t10);
                    //COLUMN 11 TTL
                    var t11 = api.column(11).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(11).footer()).html(t11);
                    //COLUMN 12 TTL
                    var t12 = api.column(12).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(12).footer()).html(t12);

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

                },
            });
        }
    }

    // ADD DENOMINATION
    $("#prcsBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#ofcrDyend").valid()) {

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addOfcrDyend",
                data: $("#ofcrDyend").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "Denomination added success", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Denomination added Failed", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    // DENOMINATION PRINT
    function printDenomi() {
        var brn = document.getElementById('brch').value;
        var exe = document.getElementById('ofcr').value;
        var dte = document.getElementById('frdt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printDayend/' + brn + '/' + exe + '/' + dte;
        }
    }

</script>