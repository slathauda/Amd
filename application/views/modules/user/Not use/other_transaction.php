<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Account Module</li>
    <li class="active"> Other Transactions</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Other Transactions </strong></h3>
                    <?php if ($funcPerm[0]->inst == 2) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus" title="New General Voucher"></i></span> General Voucher
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
                                            onchange="chckBtn(this.value,'brch')">
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
                                <label class="col-md-4 col-xs-6 control-label">Pay Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="pytp" id="pytp">
                                        <option value="all"> All Type</option>
                                        <?php
                                        foreach ($payinfo as $pay) {
                                            echo "<option value='$pay->tmid'>$pay->tem_name</option>";
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
                                <label class="col-md-4 col-xs-6 control-label">Voucher Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="vutp" id="vutp">
                                        <option value="all"> All Voucher</option>
                                        <option value="1"> Credit Voucher</option>
                                        <option value="2"> In cash Voucher</option>
                                        <option value="3"> General Voucher</option>

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchVou()"
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
                                           id="dataTbTransc" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRNC</th>
                                            <th class="text-center">ACC NAME</th>
                                            <th class="text-center">VOUCHER NO</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">CUST NAME</th>
                                            <th class="text-center">VOU TYPE</th>
                                            <th class="text-center">PAY TYPE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">TRNSF DATE</th>
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
    <div class="modal-dialog modal-lg" <!--style="width: 90%"-->>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
            <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New General Voucher
            </h4>
        </div>
        <form class="form-horizontal" id="vou_add" name="vou_add" action="" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> Voucher Account
                                    Details </h3>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Voucher Branch</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="vubrn" id="vubrn"
                                                    onchange="chckBtn(this.value,'vubrn');">
                                                <?php
                                                foreach ($branchinfo as $branch) {
                                                    if ($branch['brch_id'] == 'all') {
                                                    } else {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                }
                                                ?>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Account Name</label>
                                        <div class="col-md-8 col-xs-12">
                                            <select class="form-control" data-style="btn-success" id="acna"
                                                    name="acna">
                                                <option value="0" selected>Select Account</option>
                                                <?php
                                                foreach ($chrtaccinfo as $chrtac) {
                                                    echo "<option value='$chrtac->idfr'>($chrtac->idfr) $chrtac->hadr</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Short Narration</label>
                                        <div class="col-md-2 col-xs-12">
                                            <input type="text" class="form-control subamtclss" placeholder="Amount"
                                                   id="subamt[]" name="subamt[]" onchange="totcal()"/>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <input type="text" class="form-control" placeholder="Short Narration"
                                                   id="stnr[]" name="stnr[]"/>
                                        </div>
                                        <div class="col-md-1">
                                            <button type="button" class="btn-sm btn-info" id="addrw"><span>
                                                    <i class="fa fa-plus"></i></span>
                                            </button>
                                        </div>
                                    </div>

                                    <div id="spit">
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Pay Amounts</label>
                                        <div class="col-md-3 col-xs-12">
                                            <input type="text" class="form-control" placeholder="Amount" id="pyam"
                                                   readonly name="pyam"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 col-xs-12 control-label">Pay Date</label>
                                        <div class="col-md-3 col-xs-12">
                                            <input type="text" class="form-control datepicker" placeholder="date"
                                                   id="pydt" name="pydt" value="<?php echo date("Y-m-d"); ?>"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <h3 class="text-title"><span class="fa fa-money"></span> Pay Account Details
                                    </h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Pay Account</label>
                                            <div class="col-md-4 col-xs-12">
                                                <select class="form-control" name="pyac" id="pyac"
                                                        onchange="pymode(this.value)">
                                                    <option value="0" selected>Select Option</option>
                                                    <option value="8">Cash In Hand</option>
                                                    <option value="1">Cash At Bank</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="pymod" style="display:none;">
                                            <label class="col-md-3 col-xs-12 control-label">Pay Mode</label>
                                            <div class="col-md-4 col-xs-12">
                                                <select class="form-control" name="pymo" id="pymo"
                                                        onchange="chqDiv(this.value);loadbnk()">
                                                    <option value="0" selected>Select Option</option>
                                                    <option value="2">Cheque</option>
                                                    <option value="4">Online Transaction</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group" id="bacod" style="display:none;">
                                            <label class="col-md-3 col-xs-12 control-label text-left">Bank
                                                Account</label>
                                            <div class="col-md-4 col-xs-12">
                                                <select class="form-control" name="baco" id="baco"
                                                        onchange="chckBtn(this.value,'baco');loadChq(this.value)">
                                                    <option value="0">Select Bank Account</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="cqsw" style="display: none">
                                            <div class="form-group cqsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Cheque Number</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="cqno" id="cqno"> </select>
                                                </div>
                                            </div>
                                            <div class="form-group cqsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Cheque Date</label>
                                                <div class="col-md-4"><input type="text"
                                                                             class="form-control datepicker"
                                                                             name="cqdt" id="cqdt"
                                                                             value="<?php echo date("Y-m-d"); ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group cqsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Cheque Pay
                                                    Name</label>
                                                <div class="col-md-4"><input type="text" class="form-control"
                                                                             name="cqpn" id="cqpn" value="CASH"/>
                                                </div>
                                            </div>
                                            <div class="form-group cqsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Account Pay
                                                    Tag</label>
                                                <div class="col-md-8 col-xs-12">
                                                    <label class="switch">
                                                        <input id="ectp" name="ectp" type="checkbox" value="1"
                                                               checked/>Yes
                                                        <span></span>
                                                    </label> No
                                                </div>
                                            </div>
                                        </div>

                                        <div id="trsw" style="display: none">
                                            <div class="form-group trsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Transaction
                                                    Reference</label>
                                                <div class="col-md-4"><input type="text" class="form-control"
                                                                             name="trfn" id="trfn" value=""
                                                                             autocomplete="off"/></div>
                                            </div>
                                            <div class="form-group trsw" style="display:;">
                                                <label class="col-md-3 control-label text-left">Transaction
                                                    Date</label>
                                                <div class="col-md-4"><input type="text"
                                                                             class="form-control datepicker"
                                                                             name="efdt" id="efdt"
                                                                             value="<?php echo date("Y-m-d"); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">


                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">
                                <div class="row">
                                    <h3 class="text-title"><span class="fa fa-user"></span> Payee Details</h3>
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Payee Name</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Payee Name"
                                                       id="pyna" name="pyna"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Payee Address</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Payee Address"
                                                       id="pyad" name="pyad"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Payee Contacts</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" placeholder="Payee Contacts"
                                                       id="pyct" name="pyct"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="genvou_add">Submit</button>
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
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Bank Details</label>
                                            <label class="col-md-6 col-xs-6 control-label" id="bkdt"></label>
                                        </div>


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Voucher No</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="vuno"></label>
                                        </div>
                                        <input type="hidden" id="vuid" name="vuid">
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
                                                    <th class="text-center">AMOUNT</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12 label-default"></div>
                                    <div class="panel-body panel-body-table" style="padding:10px;" id="tb2">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-actions"
                                                   id="vouCstTb" width="100%">
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
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th colspan="6"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
        $('#dataTbTransc').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchVou();

        $("#vou_add").validate({  // Product loan validation
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

    function srchVou() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var pytp = document.getElementById('pytp').value;
        var vutp = document.getElementById('vutp').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbTransc').DataTable().clear();
            $('#dataTbTransc').DataTable({
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
                    {className: "text-left", "targets": [2, 3, 4, 5, 7, 9,11]},
                    {className: "text-center", "targets": [0, 1, 6, 8, 10]},
                    {className: "text-right", "targets": [8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[3, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},     // BRNC
                    {sWidth: '10%'},    // BNK / ACC NO
                    {sWidth: '10%'},    // VUNO
                    {sWidth: '10%'},    // CUST NO
                    {sWidth: '15%'},    // CUST NAME
                    {sWidth: '5%'},     // Vou type
                    {sWidth: '5%'},     // pay type
                    {sWidth: '5%'},     // amount
                    {sWidth: '12%'},    // TRNSF DATE
                    {sWidth: '5%'},     // mode
                    {sWidth: '10%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchOthrTrans',
                    type: 'post',
                    data: {
                        brn: brn,
                        pytp: pytp,
                        vutp: vutp,
                        frdt: frdt,
                        todt: todt
                    }
                }
            });
        }
    }

    // LOAD GRNERAL VOUCHER PAY BANK
    function loadbnk() {
        var brid = document.getElementById("vubrn").value;

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
                    $('#baco').empty();
                    $('#baco').append("<option value='0'>Select Account </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['acid'];
                        var name = response[i]['acnm'] + ' | ' + response[i]['acno'];
                        var $el = $('#baco');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#baco').empty();
                    $('#baco').append("<option value='0'>No Account</option>");
                }
            }
        });
    }
    // LOAD BANKK CHEQUE
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

    // voucher view and approval
    function viewVou(vuid, typ) {

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
            url: "<?= base_url(); ?>user/vewVou",
            data: {
                vuid: vuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['vudt'].length;
                var len2 = response['lndt'].length;

                var t = $('#vouDtilTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2]},
                        {className: "text-right", "targets": [3]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '50%'},
                        {sWidth: '20%'},
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

                        //COLUMN 6 TTL
                        var t3 = api.column(3).data().reduce(function (a, b) {
                            // b = $(b).text();
                            return intVal(a) + intVal(b);
                        }, 0);

                        $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));

                    },
                });
                t.clear().draw();

                for (var i = 0; i < len; i++) {
                    document.getElementById("cno").innerHTML = response['vudt'][i]['vuno'];
                    document.getElementById("pynm").innerHTML = response['vudt'][i]['pynm'];
                    document.getElementById("pytyp").innerHTML = response['vudt'][i]['dsnm']; // bnk_accunt.acnm,bnk_accunt.acno,chq_issu.cqno


                    if (response['vudt'][i]['mode'] == 1) {       // CREDIT VOUCHER
                        document.getElementById("bkdt").innerHTML = '-';

                        document.getElementById("custyp").innerHTML = "<span class='label label-default'> CREDIT VOUCHER </span> ";

                    } else if (response['vudt'][i]['mode'] == 2) {  // INCASH GROUP VOUCHER
                        if (response['vudt'][i]['pmtp'] == '2' || response['vudt'][i]['pmtp'] == '10') {
                            document.getElementById("bkdt").innerHTML = response['vudt'][i]['acnm'] + '  (' + response['vudt'][i]['acno'] + ')<br>'
                                + 'Chq No ' + response['vudt'][i]['cqno'];

                        } else if (response['vudt'][i]['pmtp'] == '3' || response['vudt'][i]['pmtp'] == '4') {
                            document.getElementById("bkdt").innerHTML = response['vudt'][i]['bknm'] + '  (' + response['vudt'][i]['bkbr'] + ' Branch )<br>'
                                + 'Acc No ' + response['vudt'][i]['cuac'];

                        } else {
                            document.getElementById("bkdt").innerHTML = '-';
                        }
                        document.getElementById("custyp").innerHTML = "<span class='label label-default'> INCASH GROUP </span> ";

                    } else if (response['vudt'][i]['mode'] == 3) {    // GENERAL VOUCHER
                        document.getElementById("custyp").innerHTML = "<span class='label label-default'> GENERAL VOUCHER </span> ";

                    }

                    document.getElementById("vuno").innerHTML = response['vudt'][i]['vuno'];
                    document.getElementById("vudt").innerHTML = response['vudt'][i]['vcrdt'];
                    document.getElementById("vuid").value = response['vudt'][i]['void'];

                    if (response['vudt'][i]['stat'] == 1) {
                        document.getElementById("mod").innerHTML = "<span class='label label-warning'> Pending </span> ";
                    } else if (response['vudt'][i]['stat'] == 2) {
                        document.getElementById("mod").innerHTML = "<span class='label label-success'> Approval </span> ";
                    } else if (response['vudt'][i]['stat'] == 0) {
                        document.getElementById("mod").innerHTML = "<span class='label label-danger'> Cancel </span> ";
                    }

                    t.row.add([
                        i + 1,
                        response['vudt'][i]['rfdc'],
                        response['vudt'][i]['pyac'] + ' (' + response['vudt'][i]['hadr'] + ')',
                        numeral(response['vudt'][i]['amut']).format('0,0.00')
                    ]).draw(false);
                }

                if (len2 != '') {
                    document.getElementById('tb2').style.display = "block";

                } else {
                    document.getElementById('tb2').style.display = "none";

                }

                var m = $('#vouCstTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1, 2, 4]},
                        {className: "text-center", "targets": [0]},
                        {className: "text-right", "targets": [3, 6, 7, 8, 9]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '15%'},    // branch
                        {sWidth: '20%'},    // cust name
                        {sWidth: '10%'},    // cust no
                        {sWidth: '15%'},    // loan no
                        {sWidth: '5%'},     // product
                        {sWidth: '5%'},     // doc
                        {sWidth: '5%'},     // ins
                        {sWidth: '5%'},    // loan amt
                        {sWidth: '5%'}

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

                        //COLUMN 6 TTL
                        var t1 = api.column(6).data().reduce(function (a, b) {
                            // b = $(b).text();
                            return intVal(a) + intVal(b);
                        }, 0);
                        //COLUMN 7 TTL
                        var t2 = api.column(7).data().reduce(function (a, b) {
                            // b = $(b).text();
                            return intVal(a) + intVal(b);
                        }, 0);
                        //COLUMN 8 TTL
                        var t3 = api.column(8).data().reduce(function (a, b) {
                            // b = $(b).text();
                            return intVal(a) + intVal(b);
                        }, 0);
                        //COLUMN 9 TTL
                        var t4 = api.column(9).data().reduce(function (a, b) {
                            // b = $(b).text();
                            return intVal(a) + intVal(b);
                        }, 0);

                        $(api.column(6).footer()).html(numeral(t1).format('0,0.00'));
                        $(api.column(7).footer()).html(numeral(t2).format('0,0.00'));
                        $(api.column(8).footer()).html(numeral(t3).format('0,0.00'));
                        $(api.column(9).footer()).html(numeral(t4).format('0,0.00'));

                    },
                });

                m.clear().draw();
                for (var a = 0; a < len2; a++) {
                    if (response['lndt'][a]['chmd'] == 2) {
                        var pyamt = +response['lndt'][a]['loam'] - (+response['lndt'][a]['docg'] + +response['lndt'][a]['incg'] );
                    } else {
                        var pyamt = +response['lndt'][a]['loam'];
                    }

                    m.row.add([
                        a + 1,
                        response['lndt'][a]['brcd'] + ' / ' + response['lndt'][a]['cnnm'],
                        response['lndt'][a]['init'],
                        response['lndt'][a]['cuno'],
                        response['lndt'][a]['acno'],
                        response['lndt'][a]['prtp'],
                        numeral(response['lndt'][a]['docg']).format('0,0.00'),
                        numeral(response['lndt'][a]['incg']).format('0,0.00'),
                        numeral(response['lndt'][a]['loam']).format('0,0.00'),
                        numeral(pyamt).format('0,0.00'),

                    ]).draw(false);
                }
            }
        })
    }

    // VOUCHER APPROVAL btn
    $("#appbtn").on('click', function (e) {
        e.preventDefault();
        //var pytp = document.getElementById("pytp").value;
        document.getElementById("appbtn").disabled = true;
        $.ajax({
            url: '<?= base_url(); ?>user/vouApprvl',
            type: 'POST',
            data: $("#vou_approval").serialize(),
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                $('#modalView').modal('hide');
                document.getElementById("appbtn").disabled = false;
                srchVou();
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

    // VOUCHER PRINT
    function vouPrint(id, mode) {
        if (mode == 2) { // IN CASH GROUP VOUCHER
            window.open('<?= base_url(); ?>user/vouPrint/' + id, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            srchVou();

        } else if (mode == 3) { // GENERAL VOUCHER
            window.open('<?= base_url(); ?>user/genVouPrint/' + id, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            srchVou();
        }
    }

    // VOUCHER REPRINT
    function vouReprint(auid, mode, lnid) {
        if (mode == 1) {        // CREDIT VOUCHER
            window.open('<?= base_url() ?>user/credit_voucher/' + lnid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            //swal.close(); // Hide the loading message
            srchVou();

        } else if (mode == 2) { // IN CASH GROUP VOUCHER
            window.open('<?= base_url(); ?>user/vouPrint/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            srchVou();

        } else if (mode == 3) { // GENERAL VOUCHER
            window.open('<?= base_url(); ?>user/genVouPrint/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            srchVou();

        }
    }

    // voucher reject
    function rejecVou(id) {
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
                        url: '<?= base_url(); ?>user/rejVou',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            srchVou();
                            swal({title: "", text: "Voucher reject success", type: "success"});

                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal("Failed!", "Voucher Reject Failed", "error");
                            window.setTimeout(function () {
                                location = '<?= base_url(); ?>user/vouc';
                            }, 2000);
                        }
                    });
                } else {
                    swal("Cancelled!", "Voucher Not Rejected", "error");
                }
            });
    }

    // general voucher
    function pymode(id) {
        if (id == 1) {
            document.getElementById("pymod").style.display = 'block';
            document.getElementById("bacod").style.display = 'block';
            document.getElementById("trsw").style.display = 'none';
            document.getElementById("cqsw").style.display = 'none';
        } else {
            document.getElementById("pymod").style.display = 'none';
            document.getElementById("bacod").style.display = 'none';
            document.getElementById("trsw").style.display = 'none';
            document.getElementById("cqsw").style.display = 'none';
        }
    }

    // general voucher
    function chqDiv(id) {
        if (id == '0') {
            document.getElementById("cqsw").style.display = 'none';
            document.getElementById("trsw").style.display = 'none';
        } else if (id == '2') {
            document.getElementById("cqsw").style.display = 'block';
            document.getElementById("trsw").style.display = 'none';
        } else if (id == '4') {
            document.getElementById("trsw").style.display = 'block';
            document.getElementById("cqsw").style.display = 'none';

        }
    }

    function totcal() {
        var sum = 0;
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
        document.getElementById('pyam').value = sum;
    }

    /* REF LINK  >>  https://stackoverflow.com/questions/28184177/dynamically-add-remove-rows-from-html-table */
    $('#addrw').click(function () {
        $('#spit').append(' <div class="form-group"><label class="col-md-3 col-xs-12 control-label"></label><div class="col-md-2 col-xs-12">' +
            '<input type="text" class="form-control subamtclss" autofocus placeholder="Amount" id="subamt[]" name="subamt[]" onchange="totcal()"  /></div><div class="col-md-4 col-xs-12">' +
            '<input type="text" class="form-control" placeholder="Short Narration" id="stnr" name="stnr[]" /></div><div class="col-md-1">' +
            '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>')
    });

    $('#spit').on('click', '#dltrw', function () {
        var sum = 0;
        $(this).closest('.form-group').remove();
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
        document.getElementById('pyam').value = sum;
    });

    // voucher add
    $("#genvou_add").on('click', function (e) {
        e.preventDefault();

        if ($("#vou_add").valid()) {

            $('#modalAdd').modal('hide');
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addVoucher",
                data: $("#vou_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "General voucher added success", type: "success"},
                        function () {
                            location.reload();
                        }
                    );
                },
                error: function () {
                    swal({title: "", text: "Voucher added Failed", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });
        } else {
            //    mng_loan        alert("Error");
        }
    });


</script>












