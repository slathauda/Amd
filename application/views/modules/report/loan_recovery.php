<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li class="active"> Loan Recovery</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Recovery </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add New
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
                                    <button type="button form-control  " onclick="srchRecveryLoan()"
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
                                           id="dataTbRcver" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH /CENTER</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">LN AMT</th>
                                            <th class="text-center">ARR AGE</th>
                                            <th class="text-center">ARR AMT</th>
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

<!-- Loan Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Add New Arrears Loan
                </h4>
            </div>
            <form class="form-horizontal" id="loan_add" name="loan_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="arr_brn" id="arr_brn"
                                                        onchange="getExe(this.value,'arr_ofc',exc.value,'arr_cen');">
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
                                            <label class="col-md-4 col-xs-6 control-label"> Officer</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="arr_ofc" id="arr_ofc"
                                                        onchange="getCenter(this.value,'arr_cen',brch.value)">
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
                                                <select class="form-control" name="arr_cen" id="arr_cen">
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
                                                        class='btn-sm btn-primary panel-refresh'>
                                                    <i class="fa fa-search"></i> Search
                                                </button>
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
                                                           id="dataTbLn" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">NO</th>
                                                            <th class="text-center">BRANCH /CENTER</th>
                                                            <th class="text-center">LOAN NO</th>
                                                            <th class="text-center">CUST NO</th>
                                                            <th class="text-center">CUSTOMER NAME</th>
                                                            <th class="text-center">LN AMT</th>
                                                            <th class="text-center">ARR AGE</th>
                                                            <th class="text-center">ARR AMT</th>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title " id="largeModalHead">Loan Details : <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Branch</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="lnbrn"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Center</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="lncnt"></label>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Customer Name</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="cunme"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Customer NIC</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="cusnic"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Customer No</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="cusno"></label>
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lnofc"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="xx"></label>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Customer Address</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="cuad"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Customer Mobile </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="cumb"></label>
                                        </div>
                                        <!--<div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="xx"></label>
                                        </div>-->
                                        <hr>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Loan Type</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lntyp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Loan Amount</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lnamt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lninst"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Doc Charges</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lndoc"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="insdt"></label>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Arrest Amount</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="armt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Last Repayment</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lpam"></label>
                                        </div>
                                        <div class="form-group" id="ltr1" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">1 Letter Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="1ltd"></label>
                                        </div>
                                        <div class="form-group" id="ltr2" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">2 Letter Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="2ltd"></label>
                                        </div>
                                        <div class="form-group" id="ltr3" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">3 Letter Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="3ltd"></label>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Product Name</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lnprd"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lnrnt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                            <label class="col-md-4 col-xs-6 control-label" id="zz"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Insu Chrg</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lnins"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Distribute Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="disdt"></label>
                                        </div>
                                        <hr>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Arrest Age</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="arag"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Repayment Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="lpdt"></label>
                                        </div>

                                    </div>
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
<!--End View Model -->

<!-- LOAN COMMENT -->
<div class="modal" id="modalCmnt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-comments"></span> Loan Status
                    Comments <span id="lnno"></span></h4>
            </div>
            <div class="modal-body">

                <!-- START CONTENT FRAME BODY -->
                <div class="content-frame-body content-frame-body-left">
                    <div class="messages messages-img">
                        <div id="cmmnt">
                        </div>
                    </div>

                    <div class="panel panel-default push-up-10">
                        <div class="panel-body panel-body-search">

                            <form class="" id="rcvery_cmnt_add" name="rcvery_cmnt_add" action="" method="post">
                                <div class="input-group">
                                    <input type="text" name="cmnt" id="cmnt" class="form-control" required
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
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


</body>

<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbRcver').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchLoan();
        srchRecveryLoan();
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // ARRES LOAN
    function srchLoan() {                                                       // Search btn
        var brn = document.getElementById('arr_brn').value;
        var exc = document.getElementById('arr_ofc').value;
        var cen = document.getElementById('arr_cen').value;
        // var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('arr_brn').style.borderColor = "red";
        } else {
            document.getElementById('arr_brn').style.borderColor = "";

            $('#dataTbLn').DataTable().clear();
            $('#dataTbLn').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 5, 8, 9]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[4, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '10%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '10%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // period
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Report/srchArrLoan',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen
                    }
                }
            });
        }
    }

    function recvryAdd(lnid) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this Loan",
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
                    $('#modalAdd').modal('hide');
                    var jqXHR = jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>Report/recvryAdd",
                        data: {
                            lnid: lnid
                        },
                        dataType: 'json',
                        success: function (data) {

                            swal({title: "", text: "Recovery add success", type: "success"},
                                function () {
                                    location.reload();
                                });
                        },
                        error: function () {
                            swal({title: "", text: "Process failed", type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled", " ", "error");
                }
            });


    }

    // RECOVERY LOAN
    function srchRecveryLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        // var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('arr_brn').style.borderColor = "red";
        } else {
            document.getElementById('arr_brn').style.borderColor = "";

            $('#dataTbRcver').DataTable().clear();
            $('#dataTbRcver').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 5, 8, 9]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[4, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '10%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '10%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // period
                    {sWidth: '5%'},
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>Report/srchRcverLoan',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen
                    }
                }
            });
        }
    }

    function viewDetails(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Report/vewRcveryLoan",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("cno").innerHTML = response[i]['acno'];
                    document.getElementById("cusnic").innerHTML = response[i]['anic'];
                    document.getElementById("cusno").innerHTML = response[i]['cuno'];
                    document.getElementById("lntyp").innerHTML = response[i]['lntpnm'];
                    document.getElementById("lnamt").innerHTML = numeral(response[i]['loam']).format('0,0.00');
                    document.getElementById("lninst").innerHTML = numeral(response[i]['inam']).format('0,0.00');
                    document.getElementById("lndoc").innerHTML = numeral(response[i]['docg']).format('0,0.00');
                    document.getElementById("insdt").innerHTML = response[i]['indt'];
                    document.getElementById("lnbrn").innerHTML = response[i]['brnm'];
                    document.getElementById("lncnt").innerHTML = response[i]['cnnm'];

                    document.getElementById("cuad").innerHTML = response[i]['hoad'];
                    document.getElementById("cumb").innerHTML = response[i]['mobi'];
                    document.getElementById("cunme").innerHTML = response[i]['init'];
                    document.getElementById("lnprd").innerHTML = response[i]['prnm'];
                    document.getElementById("lnrnt").innerHTML = response[i]['lnpr'] + ' ' + response[i]['pymd']; //
                    document.getElementById("lnins").innerHTML = numeral(response[i]['incg']).format('0,0.00'); // insurance
                    document.getElementById("disdt").innerHTML = response[i]['acdt']; //
                    document.getElementById("lnofc").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];

                    document.getElementById("armt").innerHTML = numeral(+response[i]['aboc'] + +response[i]['aboi']).format('0,0.00');
                    document.getElementById("arag").innerHTML = response[i]['cage'];
                    document.getElementById("lpam").innerHTML = numeral(response[i]['ramt']).format('0,0.00');
                    document.getElementById("lpdt").innerHTML = response[i]['crdt'];
                    document.getElementById("1ltd").innerHTML = response[i]['flsdt'];
                    document.getElementById("2ltd").innerHTML = response[i]['slsdt'];
                    document.getElementById("3ltd").innerHTML = response[i]['tlsdt'];

                    if(response[i]['flsby'] != 0){
                        document.getElementById("ltr1").style.display = 'block';
                    }else {
                        document.getElementById("ltr1").style.display = 'none';
                    }
                    if(response[i]['slsby'] != 0){
                        document.getElementById("ltr2").style.display = 'block';
                    }else {
                        document.getElementById("ltr2").style.display = 'none';
                    }
                    if(response[i]['tlsby'] != 0){
                        document.getElementById("ltr3").style.display = 'block';
                    }else {
                        document.getElementById("ltr3").style.display = 'none';
                    }
                }
            }
        })
    }

    // letter print
    function ltrPrint(rcid, ltct) {
        swal({
            title: "Please wait...",
            text: "Letter generating..",
            imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        srchRecveryLoan();
        setTimeout(function () {
            window.open('<?= base_url() ?>Report/letter_print/' + rcid + '/' + ltct, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            swal.close(); // Hide the loading message
           // srchRecveryLoan();
        }, 2000);

    }

    // letter send
    function ltrSend(rcid, ltct) {
        swal({
                title: "Are you sure letter send?",
                text: "",
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
                        url: '<?= base_url(); ?>Report/letter_send',
                        type: 'post',
                        data: {
                            rcid: rcid,
                            ltct: ltct
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal({title: "Process Done", text: "", type: "success"});
                            srchRecveryLoan();
                            /*swal({title: "Process Done", text: "", type: "success"},
                             function () {
                             location.reload();
                             });*/
                        }
                    });
                } else {
                    swal("Not process", "", "error");
                }
            });
    }

    // Loan mode change
    function chngMode(rcid, lnid) {
        swal({
                title: "Are you sure this Recovery loan mode chang to normal mode ?",
                text: "",
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
                        url: '<?= base_url(); ?>Report/recvry_modechng',
                        type: 'post',
                        data: {
                            rcid: rcid,
                            lnid: lnid
                        },
                        dataType: 'json',
                        success: function (response) {
                            swal({title: "Process Done", text: "", type: "success"});
                            srchRecveryLoan();
                            /*swal({title: "Process Done", text: "", type: "success"},
                             function () {
                             location.reload();
                             });*/
                        }
                    });
                } else {
                    swal("Not process", "", "error");
                }
            });
    }

    function viewCommnt(lnid) {
        document.getElementById('lnid').value = lnid;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Report/getLoanCommnt",
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

    // LOAN COMMENT ADD
    $("#rcvery_cmnt_add").submit(function (e) {
        e.preventDefault();
        var lnid = document.getElementById('lnid').value;

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Report/addRcveryCmnt",
            data: $("#rcvery_cmnt_add").serialize(),
            dataType: 'json',
            success: function (data) {
                //swal("Success!", " ", "success");
                document.getElementById('cmnt').value = '';
                viewCommnt(lnid);
            },
            error: function () {
                swal("Failed!", "", "error");
            }
        });
    });

</script>












