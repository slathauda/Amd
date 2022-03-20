<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <!-- <li>Payment Module</li>-->
    <li class="active"> Gift Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Gift Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus" title="New Gift Distrubution"></i></span> New Gift
                        </button> <!-- data-toggle="modal" data-target="#modalAdd" -->
                    <?php } ?>
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
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date("Y-m-d"); ?>">

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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<?= date("Y-m-d"); ?>">

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
                                    <button type="button form-control  " onclick="srchGift()"
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
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbGiftCust" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRNC/CNT</th>
                                            <th class="text-center">CUST NAME</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">CUST MOBILE</th>
                                            <th class="text-center">GIFT TYPE</th>
                                            <th class="text-center">GIFT COUNT</th>
                                            <th class="text-center">RQS USER</th>
                                            <th class="text-center">RQS DATE</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">OPTION</th>
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

<!--  Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Gift Request
                </h4>
            </div>
            <form class="form-horizontal" id="gift_add" name="gift_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row form-horizontal">
                                        <div class="col-md-4">
                                            <div class="form-group form-horizontal">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brchUsr" id="brchUsr"
                                                            onchange="getExe(this.value,'excUsr',excUsr.value,'cenUsr');chckBtn(this.value,'brchUsr')">
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
                                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control datepicker" name="bdfrdt" id="bdfrdt"
                                                           value="<?= date("Y-m-d"); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="excUsr" id="excUsr"
                                                            onchange="getCenter(this.value,'cenUsr',brchUsr.value)">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control datepicker" name="bdtodt" id="bdtodt"
                                                           value="<?= date("Y-m-d"); ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="cenUsr" id="cenUsr">
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
                                                    <button type="button form-control  " onclick="srchCust()"
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
                                        <div class="panel panel-default">
                                            <div class="panel-body panel-body-table" style="padding:10px;">
                                                <div class="table-responsive">
                                                    <table class="table datatable table-bordered table-striped table-actions"
                                                           id="dataTbCustList" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th class="text-center">BRNC / CENT</th>
                                                            <th class="text-center">CUST NAME</th>
                                                            <th class="text-center">CUST NO</th>
                                                            <th class="text-center">CUST NIC</th>
                                                            <th class="text-center">CUST MOBILE</th>
                                                            <th class="text-center">BIRTH DAY</th>
                                                            <th class="text-center">YEARS</th>
                                                            <th class="text-center">GIFT TYPE</th>
                                                            <th class="text-center">COUNT</th>
                                                            <th class="text-center">OPTION</th>
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
                                <input type="hidden" id="len" name="len">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="gengift_add">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- View / Approvel Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Voucher Details : <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>

            <form class="form-horizontal" id="vou_approval" name="vou_approval"
                  action="" method="post">
                <div class="modal-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Payee Name</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="pynm"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Pay Type</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="pytyp"></label>
                                        </div>
                                        <!--<div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Bank Details</label>
                                            <label class="col-md-6 col-xs-6 control-label" id="bkdt"></label>
                                        </div>-->


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Voucher No</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="vuno"></label>
                                        </div>
                                        <input type="hidden" id="vuid" name="vuid">
                                        <input type="hidden" id="gfid" name="gfid">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Voucher Date </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="vudt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Voucher Type</label>
                                            <label class="col-md-4 col-xs-6 control-label"><span
                                                        id="mod"></span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 label-default"></div>

                                    <div class="panel-body panel-body-table" style="padding:10px; ">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped"
                                                   id="vouDtilTb" align="center" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">BILL NO</th>
                                                    <th class="text-center">DESCRIPTION</th>
                                                    <th class="text-center">ACCOUNT NO / NAME</th>
                                                    <th class="text-center">GIFT COUNT</th>
                                                    <th class="text-center">GIFT VALUE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12 label-default"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left">Hint : <span id="hint"></span> </span>
                    <button type="button" class="btn btn-success" id="appbtn">Approval</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End View Model -->


</body>

<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbGiftCust', '#dataTbCustList').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchGift();

        $("#gift_add").validate({  // Product loan validation
            rules: {
                acna: {
                    required: true,
                    notEqual: '0'
                },
                pyac: {
                    required: true,
                    notEqual: '0'
                },
                baco: {
                    required: true,
                    notEqual: '0'
                },
                pymo: {
                    required: true,
                    notEqual: '0'
                },

                cqno: {
                    required: true,
                    notEqual: '0'
                },
                pyna: {
                    required: true,
                },

                pyad: {
                    required: true,
                },
                pyct: {
                    required: true,
                },

                pyam: {
                    required: true,
                    digits: true
                },
                'subamt[]': {
                    required: true,
                    digits: true
                },
                'stnr[]': {
                    required: true
                },

            },
            messages: {
                acna: {
                    required: 'Please select Account',
                    notEqual: "Please select Account",
                },
                pyac: {
                    required: 'Please enter Pay Account',
                    notEqual: "Please select Pay Account"
                },
                baco: {
                    required: 'Please Enter Bank ',
                    notEqual: "Please select Bank "
                },
                pymo: {
                    required: 'Please Enter Pay Mode ',
                    notEqual: "Please select Pay Mode "
                },
                cqno: {
                    required: 'Select Cheque Leaf',
                    notEqual: 'Select Cheque Leaf',
                },
                pyna: {
                    required: 'Enter Payee Name',
                },
                pyad: {
                    required: 'Enter Payee Address',
                },
                pyct: {
                    required: 'Enter Payee Contacts',
                },
                pyam: {
                    required: 'Enter Amount',
                    digits: 'This is not a valid Number'
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

    // LOAD CUSTOMER LIST
    function srchCust() {  // Search btn
        var brn = document.getElementById('brchUsr').value;
        var off = document.getElementById('excUsr').value;
        var cnt = document.getElementById('cenUsr').value;
        var frdt = document.getElementById('bdfrdt').value;
        var todt = document.getElementById('bdtodt').value;

        if (brn == '0') {
            document.getElementById('brchUsr').style.borderColor = "red";
        } else {
            document.getElementById('brchUsr').style.borderColor = "";

            $('#dataTbCustList').DataTable().clear();
            $('#dataTbCustList').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": true,
                "paging": false,
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
                    {className: "text-center", "targets": [0, 5, 6, 7, 8, 10]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[6, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br
                    {sWidth: '15%'},    // name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '10%'},    // customer nic
                    {sWidth: '10%'},    // cust mobile
                    {sWidth: '10%'},    // cust bday
                    {sWidth: '10%'},    // cust year
                    {sWidth: '5%'},     // gift type
                    {sWidth: '5%'},     // count
                    {sWidth: '5%'}     // option
                ],
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;
                },
                "ajax": {
                    url: '<?= base_url(); ?>user/getBdyCustList',
                    type: 'post',
                    data: {
                        brn: brn,
                        off: off,
                        cnt: cnt,
                        frdt: frdt,
                        todt: todt,
                    }
                }
            });
        }
    }

    // LOAD GIFT LIST
    function srchGift() {
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbGiftCust').DataTable().clear();
            $('#dataTbGiftCust').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4, 5, 7]},
                    {className: "text-center", "targets": [0, 6, 8, 9, 10]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // BRN / CNT
                    {sWidth: '10%'},    // CUST NAME
                    {sWidth: '10%'},     // CUST NO
                    {sWidth: '5%'},     // CUST MOBILE
                    {sWidth: '5%'},     // GIFT TYPE
                    {sWidth: '5%'},     // COUNT
                    {sWidth: '5%'},     // RQS USER
                    {sWidth: '5%'},     // RQS DATE
                    {sWidth: '5%'},     // MODE
                    {sWidth: '13%'}     // OPTION
                ],
                "ajax": {
                    url: '<?= base_url(); ?>user/srchGift',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        frdt: frdt,
                        todt: todt
                    }
                }
            });
        }
    }


    // voucher view and approval
    function viewGifVou(gfid, typ) {

        if (typ == 'app') {
            //  document.getElementById('appbtn').style.display = 'block';
            document.getElementById('appbtn').removeAttribute("class");
            document.getElementById('appbtn').setAttribute("class", "btn btn-success");

        } else {
            // document.getElementById('appbtn').style.display = 'none';
            document.getElementById('appbtn').removeAttribute("class");
            document.getElementById('appbtn').setAttribute("class", "hidden");
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewGiftVou",
            data: {
                gfid: gfid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['vudt'].length;

                var t = $('#vouDtilTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2, 3]},
                        {className: "text-right", "targets": [4]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '50%'},
                        {sWidth: '20%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'}

                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

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
                    },
                });
                t.clear().draw();

                for (var i = 0; i < len; i++) {
                    document.getElementById("cno").innerHTML = response['vudt'][i]['vuno'];
                    document.getElementById("pynm").innerHTML = response['vudt'][i]['pynm'];
                    document.getElementById("pytyp").innerHTML = response['vudt'][i]['tem_name']; // bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno
                    document.getElementById("custyp").innerHTML = "<span class='label label-default'> GIFT VOUCHER </span> ";

                    document.getElementById("vuno").innerHTML = response['vudt'][i]['vuno'];
                    document.getElementById("vudt").innerHTML = response['vudt'][i]['vcrdt'];
                    document.getElementById("vuid").value = response['vudt'][i]['void'];
                    document.getElementById("gfid").value = response['vudt'][i]['auid'];

                    if (response['vudt'][i]['stat'] == 1) {
                        document.getElementById("mod").innerHTML = "<span class='label label-warning'> Pending </span> ";
                    } else if (response['vudt'][i]['stat'] == 2) {
                        document.getElementById("mod").innerHTML = "<span class='label label-success'> Approval </span> ";
                    } else if (response['vudt'][i]['stat'] == 0) {
                        document.getElementById("mod").innerHTML = "<span class='label label-danger'> Cancel </span> ";
                    }
                    document.getElementById("hint").innerHTML = "gfid " + response['vudt'][i]['auid'] + ' | vuid ' + response['vudt'][i]['void'];

                    t.row.add([
                        i + 1,
                        response['vudt'][i]['rfdc'],
                        response['vudt'][i]['pyac'] + ' (' + response['vudt'][i]['hadr'] + ')',
                        response['vudt'][i]['gfcn'],
                        numeral(response['vudt'][i]['amut']).format('0.00')
                    ]).draw(false);
                }
            }
        })
    }

    // VOUCHER & GIFT APPROVAL
    $("#appbtn").on('click', function (e) {
        e.preventDefault();

        document.getElementById("appbtn").disabled = true;
        $.ajax({
            url: '<?= base_url(); ?>user/giftVouApprvl',
            type: 'POST',
            data: $("#vou_approval").serialize(),
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                $('#modalView').modal('hide');
                document.getElementById("appbtn").disabled = false;
                srchGift();
                swal({title: "", text: "Voucher approval done", type: "success"});
            },
            error: function (data, jqXHR, textStatus, errorThrown) {
                swal({title: "Failed", text: "Voucher approval Failed", type: "error"},
                    function () {
                        location.reload();
                    });
            }
        });
    });

    // Gift VOUCHER PRINT
    function vouGifPrint(id) {
        window.open('<?= base_url(); ?>user/gifVouPrint/' + id, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
        srchGift();
    }

    // voucher reject
    function rejecGifVou(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this Voucher",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3bdd59",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: '<?= base_url(); ?>user/rejGifVou',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            srchGift();
                            swal({title: "Failed", text: "Gift Voucher reject success", type: "success"},
                                function () {
                                    //location.reload();
                                });
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "Failed", text: "Gift Voucher Reject Failed", type: "error"},
                                function () {
                                    //location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled!", "Gift Voucher Not Rejected", "error");
                }
            });
    }


    //REQUEST GIFT ADD
    function rqstGift(cuid) {
        console.log(cuid + ' ** ');
        var brco = document.getElementById('brchUsr').value;
        $.ajax({
            url: '<?= base_url(); ?>user/addRqustGift',
            type: 'POST',
            data: $("#gift_add").serialize(),

            dataType: 'json',
            success: function (data, textStatus, jqXHR) {


                srchCust();
                srchGift();
                swal({title: "", text: "Gift Request Done", type: "success"});
            },
            error: function (data, jqXHR, textStatus, errorThrown) {
                swal({title: "Failed", text: "Gift Request Failed", type: "error"},
                    function () {
                        //location.reload();
                    });
            }
        });
    }


    //REQUEST GIFT ADD
    $("#gengift_add").on('click', function (e) {
        e.preventDefault();

        if ($("#gift_add").valid()) {

            //$('#modalAdd').modal('hide');
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addRqustGift",
                data: $("#gift_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "Gift Request Done", type: "success"},
                        function () {
                            srchCust();
                            srchGift();
                        }
                    );
                },
                error: function () {
                    swal({title: "", text: "Gift Request Failed", type: "error"},
                        function () {
                            srchCust();
                            srchGift();
                        }
                    );
                }
            });
        } else {
            //    mng_loan        alert("Error");
        }
    });


</script>












