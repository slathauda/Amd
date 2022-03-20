<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Loan Disbursement Check</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Disbursement Check </strong></h3>
                    <!--                     <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                                         class="fa fa-plus"></i></span> New Loan
                                         </button> <!-- data-toggle="modal" data-target="#modalAdd" -->
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
                                <label class="col-md-4 col-xs-6 control-label">Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <option value="0">Uncheck Loan</option>
                                        <option value="1">Check Loan</option>

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
                        <form id="dsbs_chck" name="dsbs_chck" action="" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">
                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="dataTbVou" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">BRN /CNT</th>
                                                <th class="text-center">CUSTOMER NAME</th>
                                                <th class="text-center">CUSTOMER NO</th>
                                                <th class="text-center">LOAN NO</th>
                                                <th class="text-center">PRODUCT</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">PERIOD</th>
                                                <th class="text-center">MODE</th>
                                                <th class="text-center">DISB DATE</th>
                                                <th class="text-center">CHECK BY</th>
                                                <th class="text-center">CHECK DATE</th>
                                                <th class="text-center">CHECK</th>
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
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-md-12">
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
        //srchLoan();
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
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbVou').DataTable().clear();
            $('#dataTbVou').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4, 9, 10]},
                    {className: "text-center", "targets": [0, 5, 7, 8, 11, 12]},
                    {className: "text-right", "targets": [0, 6]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[9, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '13%'},    // cust name
                    {sWidth: '10%'},    // cust no
                    {sWidth: '12%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // period
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '12%'},
                    {sWidth: '3%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchDisbursLoan',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        stat: stat
                    },
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;

                    if (display.length > 0) {
                        document.getElementById("process_btn").style.display = "block";
                    } else {
                        document.getElementById("process_btn").style.display = "none";
                    }
                },
            });
        }
    }

    // check process
    $("#process_btn").on('click', function (e) { // add form
        e.preventDefault();

        swal({
            title: "Please wait...",
            text: "Processing",
            imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });

        document.getElementById("process_btn").disabled = true;
        $.ajax({
            url: '<?= base_url(); ?>user/dsbsAdd',
            type: 'POST',
            data: $("#dsbs_chck").serialize(),
            dataType: 'json',
            success: function (data, textStatus, jqXHR) {

                swal({title: "", text: "Disbursement Check Done", type: "success"},
                    function () {
                        //location.reload();
                        srchLoan();
                        document.getElementById("process_btn").disabled = false;
                    }
                );
            },
            error: function (data, jqXHR, textStatus) {
                swal({title: "Disbursement Check Failed", text: "Contact system admin", type: "error"},
                    function () {
                        //location.reload();
                        srchLoan();
                    }
                );
            }
        });
    });

</script>












