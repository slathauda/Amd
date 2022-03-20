<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Group Voucher</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Group Voucher </strong></h3>
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

                <form class="form-horizontal" id="grupVou" name="grupVou" action="" method="post">

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
                                                <th class="text-center">BRANCH /CENTER</th>
                                                <th class="text-center">CUSTOMER NAME</th>
                                                <th class="text-center">CUST NO</th>
                                                <th class="text-center">LOAN NO</th>
                                                <th class="text-center">PRODUCT</th>
                                                <th class="text-center">DOC</th>
                                                <th class="text-center">INS</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">TO BE PAID</th>
                                                <th class="text-center">OPTION</th>
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
                                            <th id="tot_amt"></th>
                                            <th></th>

                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" id="pnel_1">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3  col-xs-6 control-label">Paying Amount</label>
                                            <div class="col-md-3 col-xs-6">
                                                <input type="text" class="form-control" readonly id="pyamt"
                                                       name="pyamt"/>

                                                <input type="hidden" class="form-control" id="ttlamt"
                                                       name="ttlamt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-6 control-label">Pay Type</label>
                                            <div class="col-md-3 col-xs-6">
                                                <select class="form-control" name="pytp" id="pytp"
                                                        onchange="pytpchng(this.value)">
                                                    <option value="0"> Select Option</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- BANK CQU DETAILS -->
                                        <div id="chqDiv" style="display: none">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-6 control-label">Bank Account</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <select class="form-control" name="bknm" id="bknm"
                                                            onchange="loadChq(this.value)">
                                                        <option value="0"> Select Bank</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3  col-xs-6 control-label">Cheque No</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <select class="form-control" name="cqno" id="cqno"> </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3  col-xs-6 control-label">Cheque Date</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <input type="text" class="form-control datepicker" id="chdt"
                                                           placeholder="Payee Name" value="<?= date("Y-m-d"); ?>"
                                                           name="chdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3  col-xs-6 control-label">Cheque Pay Name</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <input type="text" class="form-control" id="chpynm"
                                                           placeholder="Cheque Pay Name" value="CASH"
                                                           name="chpynm"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END BANK CQU DETAILS -->

                                        <!-- ONLINE TRANSFER -->
                                        <div id="onlDiv" style="display: none">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-6 control-label">Bank Account</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <select class="form-control" name="bknm_onl" id="bknm_onl"
                                                            onchange="">
                                                        <option value="0"> Select Bank</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3  col-xs-6 control-label">Reference No</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <input type="text" class="form-control" id="rfno"
                                                           placeholder="Reference No" name="rfno"/>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END ONLINE TRANSFER -->

                                        <!-- SHOP VOUCHER DETAILS -->
                                        <div id="shopDiv" style="display: none">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-6 control-label">Shop Name</label>
                                                <div class="col-md-3 col-xs-6">
                                                    <select class="form-control" name="shpnm" id="shpnm"
                                                            onchange="loadChq(this.value)">
                                                        <option value="0"> Select Shop</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END SHOP VOUCHER DETAILS -->

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3  col-xs-6 control-label">Payee Name</label>
                                            <div class="col-md-3 col-xs-6">
                                                <input type="text" class="form-control" id="pynm"
                                                       placeholder="Payee Name" value="CASH"
                                                       name="pynm"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3  col-xs-6 control-label">Payee Contacts</label>
                                            <div class="col-md-3 col-xs-6">
                                                <input type="text" class="form-control" id="pycn"
                                                       placeholder="Payee Contacts"
                                                       name="pycn"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3  col-xs-6 control-label">Pay Date</label>
                                            <div class="col-md-3 col-xs-6">
                                                <input type="text" class="form-control datepicker" id="pydt"
                                                       value="<?= date("Y-m-d"); ?>"
                                                       name="pydt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3  col-xs-6 control-label">Pay Account</label>
                                            <div class="col-md-3 col-xs-6">
                                                <input type="text" class="form-control" id="pyac"
                                                       name="pyac" readonly/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="cuid" name="cuid">

                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="brnch" name="brnch">
                        <div class="panel-footer">
                            <?php if ($funcPerm[0]->inst == 1) { ?>
                                <button type="button" id="prcsBtn" class="btn btn-success pull-right">process</button>
                            <?php } ?>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        $('#dataTbVou').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchLoan();

        document.getElementById("pnel_1").style.display = "none";
        document.getElementById("prcsBtn").style.display = "none";
        document.getElementById("prcsBtn").disabled = false;

        $("#grupVou").validate({  // Product loan validation
            rules: {
                cqno: {
                    required: true,
                    notEqual: '0'
                },
                pynm: {
                    required: true,
                },
                pytp: {
                    required: true,
                    notEqual: '0'
                },
                bknm: {
                    notEqual: '0'
                },
                bkac: {
                    notEqual: '0'
                },
                shpnm: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                cqno: {
                    required: 'Select Cheque No',
                    notEqual: "Select Cheque No"
                },
                pynm: {
                    notEqual: "Enter Payee Name"
                },
                bknm: {
                    notEqual: "Select Bank Name"
                },
                bkac: {
                    notEqual: "Select Bank Account"
                },
                pytp: {
                    notEqual: "Select Pay Type"
                },
                shpnm: {
                    required: 'Select Shop',
                    notEqual: "Select Shop"
                },
            }
        });
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

        document.getElementById('brnch').value = brn;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbVou').DataTable().clear();
            $('#dataTbVou').DataTable({
                "destroy": true,
                "cache": false,
                "bPaginate": false,
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
                    {className: "text-center", "targets": [0, 5, 8, 9, 10]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[4, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '15%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '13%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // doc
                    {sWidth: '5%'},     // ins
                    {sWidth: '10%'},    // ln amt
                    {sWidth: '10%'},    // to paid amt
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/getGrupVouc',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;

                    if (display.length > 0) {
                        document.getElementById("pnel_1").style.display = "block";
                        document.getElementById("prcsBtn").style.display = "block";
                    } else {
                        document.getElementById("pnel_1").style.display = "none";
                        document.getElementById("prcsBtn").style.display = "none";
                    }

                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    //COLUMN 6 TTL
                    var t3 = api.column(6).data().reduce(function (a, b) {
                        // b = $(b).text();
                        return intVal(a) + intVal(b);
                    }, 0);
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
                    //COLUMN 8 TTL
                    var t4 = api.column(9).data().reduce(function (a, b) {
                        // b = $(b).text();
                        return intVal(a) + intVal(b);
                    }, 0);


                    //$(api.column(5).footer()).html('This page Total');
                    $(api.column(6).footer()).html(numeral(t3).format('0,0.00'));
                    $(api.column(7).footer()).html(numeral(t1).format('0,0.00'));
                    $(api.column(8).footer()).html(numeral(t2).format('0,0.00'));
                    document.getElementById('tot_amt').innerHTML = numeral(t4).format('0,0.00');
                    document.getElementById('pyamt').value = numeral(t4).format('0,0.00');
                    document.getElementById('ttlamt').value = t4;
                },
            });

            //calTotal();
        }
    }

    // CALCULETER TOTAL VALUE
    function calTotal(id, valu) {
        var len = document.getElementById('len').value;
        var tot_amt = '';

        for (var i = 0; i < len; i++) {
            if (document.getElementById('amt[' + i + ']').checked == true) {
                tot_amt = +tot_amt + +document.getElementById('amt[' + i + ']').value;
            }
        }

        if (tot_amt == 0) {
            document.getElementById("prcsBtn").disabled = true;
        } else {
            document.getElementById("prcsBtn").disabled = false;
        }

        document.getElementById('tot_amt').innerHTML = numeral(tot_amt).format('0,0.00');
        document.getElementById('pyamt').value = numeral(tot_amt).format('0,0.00');
        document.getElementById('ttlamt').value = tot_amt;
    }

    // LOAD PAYMENT TYPE
    function loadPytyp(cuid) {

        document.getElementById('chqDiv').style.display = "none";
        document.getElementById('onlDiv').style.display = "none";

        var len = document.getElementById('len').value;
        var ttcunt = 0;
        for (var i = 0; i < len; i++) {
            if (document.getElementById('amt[' + i + ']').checked == true) {
                ttcunt = +ttcunt + 1;

                if (ttcunt == 1) {
                    var cuid2 = document.getElementById('cuid[' + i + ']').value;
                    var bkdt = document.getElementById('bkdt[' + i + ']').value;
                }
            }
        }
        //console.log(ttcunt + '*' + cuid + '*' + cuid2 + '**' + bkdt);
        $.ajax({
            url: '<?= base_url(); ?>user/getPayType',
            type: 'post',
            data: {
                tcunt: ttcunt,
                cuid: cuid2,
                bkdt: bkdt
            },
            dataType: 'json',
            success: function (response) {
                var len = response['pytp'].length;

                if (ttcunt > 0) {
                    if (len != 0) {
                        $('#pytp').empty();
                        $('#pytp').append("<option value='0'>Select Pay Type </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response['pytp'][i]['tmid'];
                            var name = response['pytp'][i]['tem_name'];
                            var $el = $('#pytp');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#pytp').empty();
                        $('#pytp').append("<option value='0'>No Type</option>");
                    }
                } else {
                    $('#pytp').empty();
                    $('#pytp').append("<option value='0'>No Type</option>");
                }

                // CUSTOMER PAYEE DETAILS
                if (ttcunt == 1) {
                    document.getElementById("pynm").value = response['cudt'][0]['init'];
                    document.getElementById("pycn").value = response['cudt'][0]['mobi'];
                    document.getElementById("pyac").value = response['cudt'][0]['acno'];
                    document.getElementById("cuid").value = cuid2;
                } else {
                    document.getElementById("pynm").value = '';
                    document.getElementById("pycn").value = '';
                    document.getElementById("cuid").value = '';
                    document.getElementById("pyac").value = '';
                }
            }
        });
    }

    // PAYMENT TYPE CHANGE
    function pytpchng(id) {

        if (id == 0) {
            document.getElementById("pytp").style.borderColor = "red";
            document.getElementById('chqDiv').style.display = "none";
            document.getElementById('onlDiv').style.display = "none";
        } else {
            document.getElementById("pytp").style.borderColor = "";


            if (id == 2 || id == 10) {              // CHQ MODE
                document.getElementById('chqDiv').style.display = "block";
                document.getElementById('onlDiv').style.display = "none";
                document.getElementById('shopDiv').style.display = "none";
                loadbnk('bknm');

            } else if (id == 3 || id == 4) {        // BANK TT || ONLINE TRANSFER TYPE
                document.getElementById('onlDiv').style.display = "block";
                document.getElementById('chqDiv').style.display = "none";
                document.getElementById('shopDiv').style.display = "none";
                loadbnk('bknm_onl');

            } else if (id == 12 ) {       // SHOP VOUCHER
                document.getElementById('shopDiv').style.display = "block";
                document.getElementById('onlDiv').style.display = "none";
                document.getElementById('chqDiv').style.display = "none";
                loadShop();

            } else {
                document.getElementById('chqDiv').style.display = "none";
                document.getElementById('onlDiv').style.display = "none";
                document.getElementById('shopDiv').style.display = "none";
            }
        }
    }

    // LOAD GRNERAL VOUCHER PAY BANK
    function loadbnk(htmlid) {
        var brid = document.getElementById("brch").value;

        var htid = "#" + htmlid;
        $.ajax({
            url: '<?= base_url(); ?>user/getBankDtils',
            type: 'post',
            data: {
                id: brid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $(htid).empty();
                    $(htid).append("<option value='0'>Select Account </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $(htid);
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $(htid).empty();
                    $(htid).append("<option value='0'>No Account</option>");
                }
            }
        });
    }

    // LOAD BANK CHEQUE
    function loadChq(bkacc) {
        $.ajax({
            url: '<?= base_url(); ?>user/getChqDtils',
            type: 'post',
            data: {
                bkid: bkacc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#cqno').empty();
                    $('#cqno').append("<option value='0'>Select cheque leaf </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['cqid'];
                        var name = response[i]['cqno'];
                        var $el = $('#cqno');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#cqno').empty();
                    $('#cqno').append("<option value='0'>No cheque leaf</option>");
                }
            }
        });
    }

    // LOAD SHOP LIST
    function loadShop() {
        var brnc =   document.getElementById('brch').value;

        $.ajax({
            url: '<?= base_url(); ?>user/getShopDtils',
            type: 'post',
            data: {
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#shpnm').empty();
                    $('#shpnm').append("<option value='0'>Select Shop </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['spid'];
                        var name = response[i]['spnm'];
                        var $el = $('#shpnm');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#shpnm').empty();
                    $('#shpnm').append("<option value='0'>No Shop</option>");
                }
            }
        });
    }

    // click process btn
    $("#prcsBtn").on('click', function (e) {
        e.preventDefault();
        var pytp = document.getElementById("pytp").value;

        if ($("#grupVou").valid()) {

            if (pytp == 0) {
                document.getElementById("pytp").style.borderColor = "red";
            } else {
                // document.getElementById("pytp").style.borderColor = '';
                // document.getElementById("cqnm").style.borderColor = 'red';
                // document.getElementById("cqnm").style.borderColor = '';
                document.getElementById("prcsBtn").disabled = true;
                $.ajax({
                    url: '<?= base_url(); ?>user/addGroupVou',
                    type: 'POST',
                    data: $("#grupVou").serialize(),
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        swal({title: '', text: "Group IN cash Voucher Add Done ", type: "success"},
                            function () {
                                location.reload();
                            });
                        document.getElementById("prcsBtn").disabled = false;
                    },
                    error: function (data, jqXHR, textStatus, errorThrown) {
                        swal({title: "Failed", text: "Voucher Add Failed", type: "error"},
                            function () {
                                //location.reload();
                            });
                    }
                });
            }
        }
    });

    // load bank account details
    function getBkaccnt(bkid) {

        $.ajax({
            url: '<?= base_url(); ?>user/getBankaccnt',
            type: 'POST',
            data: {
                bkid: bkid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#bkac').empty();
                    $('#bkac').append("<option value='0'>Select Account</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' (' + response[i]['acno'] + ')';
                        var $el = $('#bkac');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#bkac').empty();
                    $('#bkac').append("<option value='0'>No Account</option>");
                }
            }
        });

    }


</script>












