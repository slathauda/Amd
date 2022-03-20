<style>
    td.details-control {
        text-align: center;
        color: forestgreen;
        cursor: pointer;
    }

    tr.shown td.details-control {
        text-align: center;
        color: red;
    }
</style>

<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Loan Repayment</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Repayment </strong></h3>
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
                                            if ($branch['brch_id'] != 'all') {
                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Group No</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="grup" id="grup">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($stainfo as $stat) {
                                            echo "<option value='$stat->stid'>$stat->stnm</option>";
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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Product Type </label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="prtp" id="prtp">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($prductinfo as $prd) {
                                            echo "<option value='$prd->prid'>$prd->prtp</option>";
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
                                    <select class="form-control" name="cen" id="cen"
                                            onchange="getGrup(this.value,'grup',brch.value,exc.value,cen.value)">
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
                        <form id="rpymt" name="rpymt" action="" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">
                                    <div class="table-responsive"> <!-- table-striped table-hover -->
                                        <table class="table table-bordered  "
                                               id="dataTbRpymt" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">GNO</th>
                                                <th class="text-center">BRN /CNT</th>
                                                <th class="text-center">CUST NAME</th>
                                                <th class="text-center">LNNO</th>
                                                <th class="text-center">NIC</th>
                                                <th class="text-center">MODE</th>
                                                <th class="text-center">ARR</th>
                                                <th class="text-center">BAL</th>
                                                <th class="text-center">TDY PAID</th>
                                                <th class="text-center">PYMT</th>
                                                <th class="text-center">PY BY</th>
                                                <th class="text-center">PY AT</th>
                                                <th class="text-center ">SMS</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th><input type="hidden" id="len" name="len"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th id="tot_amt"></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-10">
                                            <p style="font-size: 11px">*Today paid loans show on <span
                                                        style="font-weight: bold; color: #ff9999"> RED </span> color
                                                &nbsp;&nbsp;
                                                * Settlement Balance show on <span
                                                        style="font-weight: bold;color: red"> RED </span> color
                                            </p>

                                        </div>
                                        <div class="form-group col-md-1">
                                            <button type="button" id="cler_btn" class="btn btn-sm btn-danger pull-left"
                                                    style="display: block;">Clear
                                            </button>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <button type="button" id="process_btn"
                                                    class="btn btn-sm btn-success pull-right"
                                                    style="display: none;">Process
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
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
                <h4 class="modal-title" id="largeModalHead">Account Ledger & Loan Comment <span id="aa1"></span></h4>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="panel panel-default tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Account Ledger</a>
                            </li>
                            <li><a href="#tab2" role="tab" data-toggle="tab">Loan Comment</a></li>
                        </ul>
                        <div class="panel-body tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="row">
                                    <div class="modal-body scroll" style="height:400px;" id="ac_stp">
                                        <div class="table-responsive">
                                            <table class="table datatable table-bordered table-actions"
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
                            <div class="tab-pane" id="tab2">
                                <div class="row">
                                    <!-- START CONTENT FRAME BODY -->
                                    <div class="content-frame-body content-frame-body-left">
                                        <div class="messages messages-img">
                                            <div id="cmmnt">
                                            </div>
                                        </div>
                                        <div class="panel panel-default push-up-10">
                                            <div class="panel-body panel-body-search">

                                                <form class="" id="cmnt_add" name="cmnt_add" action="" method="post">
                                                    <div class="input-group">
                                                        <input type="text" name="cmnt" id="cmnt" class="form-control"
                                                               required
                                                               placeholder="Your comment..."/>

                                                        <input type="hidden" name="lnid" id="lnid">
                                                        <div class="input-group-btn">
                                                            <button type="submit" class="btn btn-default">Send</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END CONTENT FRAME BODY -->

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
<!-- END LEDGER POPUP -->

</body>

<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbRpymt').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        //srchLoan();
        //calTotal();

        $.validator.addClassRules("pybx", {
            // digits: true,
            currency: true
        });

        /*$("#rpymt").validate({
         rules: {
         'amt[]': {
         required: true,
         max: 100
         }
         }
         });*/

        /*$.validator.addClassRules("blnx", {
         // digits: true,
         // currency: true
         max: function () {
         return parseInt($('bln[]').val());
         }
         });*/

    });

    // ENTER KEY DOWN
    function kydown(indx, val, event) {
        var len = document.getElementById('len').value;
        if (event.keyCode == 13) {
            if (val == 0 || val > 2) {

                if ((indx + 1) == len) {
                    //var x = indx ;
                    document.getElementById('process_btn').focus();
                } else {
                    var x = indx + 1;
                    document.getElementById('amt[' + x + ']').focus();
                }
                document.getElementById('amt[' + indx + ']').style.borderColor = '';
                document.getElementById("process_btn").style.display = "block";
            } else {
                document.getElementById('amt[' + indx + ']').focus();
                document.getElementById('amt[' + indx + ']').style.borderColor = 'red';
                document.getElementById("process_btn").style.display = "none";
            }
        }
    }

    // CAL TOTAL
    function calTotal() {
        var len = document.getElementById('len').value;
        var tot_amt = '';
        for (var i = 0; i < len; i++) {
            tot_amt = +tot_amt + +document.getElementById('amt[' + i + ']').value;
        }
        document.getElementById('tot_amt').innerHTML = numeral(tot_amt).format('0,0.00');

        console.log(tot_amt);
        if (tot_amt > 0) {
            document.getElementById("process_btn").disabled = false;
        } else {
            document.getElementById("process_btn").disabled = true;
        }
    }

    function chckBtn(id, inpu) {

        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // Repayment Loan Load
    function srchLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        var grp = document.getElementById('grup').value;
        var prd = document.getElementById('prtp').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbRpymt').DataTable().clear();
            $('#dataTbRpymt').DataTable({
                "destroy": true,
                "cache": false,
                "paging": false,
                //"info": false,
                "processing": true,
                "bFilter": false, //hide Search bar
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
                    {className: "text-center", "targets": [0, 1, 4, 5, 6, 10, 11, 12, 13]},
                    {className: "text-right", "targets": [5, 7, 8, 9]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "orderable": true,
                //"order": [[1, "ASC"],[5, "ASC"]], //ASC  desc
                "aaSorting": [[5, 'asc']],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '15%'},    // ccnt / brco
                    {sWidth: '20%'},    // cust name
                    {sWidth: '5%'},    // cust no
                    {sWidth: '5%'},     // nic
                    {sWidth: '5%'},     // lnno
                    {sWidth: '5%'},     //
                    {sWidth: '5%'},     // bal
                    {sWidth: '5%'},     // tody pymt
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/getLoanRepaymt',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        grp: grp,
                        prd: prd
                    }
                },
                "rowCallback": function (row, data, index) {
                    var curnt = data[7],
                        tdpy = data[9],
                        $node = this.api().row(row).nodes().to$();
                    if (tdpy != 0) {
                        $node.addClass('danger');
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;

                    if (display.length > 0) {
                        document.getElementById("process_btn").style.display = "block";
                    } else {
                        document.getElementById("process_btn").style.display = "none";
                    }

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    //COLUMN 7 TTL
                    var t1 = api.column(7).data().reduce(function (a, b) {
                        // b = $(b).text();
                        return intVal(a) + intVal(b);
                    }, 0);
                    //COLUMN 8 TTL
                    var t2 = api.column(8).data().reduce(function (a, b) {
                        // b = $(b).text();
                        return intVal(a) + intVal(b);
                    }, 0);
                    //COLUMN 9 TTL
                    var t3 = api.column(9).data().reduce(function (a, b) {
                        // b = $(b).text();
                        return intVal(a) + intVal(b);
                    }, 0);

                    //$(api.column(5).footer()).html('This page Total');
                    $(api.column(7).footer()).html(numeral(t1).format('0,0.00'));
                    $(api.column(8).footer()).html(numeral(t2).format('0,0.00'));
                    $(api.column(9).footer()).html(numeral(t3).format('0,0.00'));
                },
            });
        }
    }

    // repayment process
    $("#process_btn").on('click', function (e) { // add form
        e.preventDefault();

        // var func = document.getElementById("func").value;
        if ($("#rpymt").valid()) {

            swal({
                title: "Please wait...",
                text: "Processing",
                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                showConfirmButton: false
            });

            document.getElementById("process_btn").disabled = true;
            $.ajax({
                url: '<?= base_url(); ?>user/repymtAdd',
                type: 'POST',
                data: $("#rpymt").serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    swal({title: "", text: "Repayment Add Done", type: "success"},
                        function () {
                            //location.reload();
                        }
                    );
                    srchLoan();
                    document.getElementById("process_btn").disabled = false;
                },
                error: function (data, jqXHR, textStatus) {
                    swal({title: "Repayment Add Failed", text: "Contact system admin", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });
        } else {
            //  alert("Error");
        }
    });

    // data clear
    $("#cler_btn").on('click', function (e) { // add form
        e.preventDefault();
        $('.pybx').val('');
        document.getElementById("process_btn").disabled = true;
    });


    // VIEW LEDGER
    function vieLeg(lnid) {
        document.getElementById('lnid').value = lnid;
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
        loanCmment(lnid);
    }

    // LOAN COMMENT ADD
    $("#cmnt_add").submit(function (e) {
        e.preventDefault();
        var lnid = document.getElementById('lnid').value;

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>User/addLncmnt",
            data: $("#cmnt_add").serialize(),
            dataType: 'json',
            success: function (data) {
                //swal("Success!", " ", "success");
                document.getElementById('cmnt').value = '';
                loanCmment(lnid);

            },
            error: function () {
                swal("Failed!", "", "error");
            }
        });
    });

    // VIEW LOAN COMMENT
    function loanCmment(lnid) {
        document.getElementById('lnid').value = lnid;
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getLoanCommnt",
            data: {
                lnid: lnid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                var str = "";
                for (var i = 0; i < len; i++) {
                    var y = 0;

                    if (i > 0) {
                        y = i - 1;
                        if (response[y]['crby'] === response[i]['crby']) {

                            if (x == 'in') {
                                var x = "in";
                            } else {
                                var x = "";
                            }
                        } else {
                            if (x == 'in') {
                                var x = "";
                            } else {
                                var x = "in";
                            }
                        }
                    } else {
                        var x = "in";
                    }

                    if (response[i]['cmmd'] == 0) {
                        var m = "Red";
                    } else {
                        var m = "";
                    }
                    str = str + '<div class="item item-visible ' + x + '">' +
                        '<div class="image"><img src="../uploads/user_default.png" alt="John Doe"></div>' +
                        '<div class="text"  style="border-color: ' + m + '"> <div class="heading"><a href="#"> ' + response[i]['usr'] + '</a>' +
                        '<span class="date">' + response[i]['crdt'] + '</span></div>' + response[i]['cmnt'] + '</div> </div> ';
                }
                //append the markup to the DOM
                $("#cmmnt").html(str);
            }
        })
    }

</script>


