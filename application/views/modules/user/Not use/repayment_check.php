<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Loan Repayment Check</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Repayment Check</strong></h3>
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class=" form-control datepicker" placeholder="" id="todt"
                                           name="todt" value="<?= date("Y-m-d"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchPayment()"
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
                        <form id="rpymtCancl" name="rpymtCancl" action="" method="post">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">
                                    <div class="table-responsive"> <!-- table-striped table-hover -->
                                        <table class="table table-bordered  "
                                               id="dataTbRpymt" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">BRANCH</th>
                                                <th class="text-center">CUST NAME</th>
                                                <th class="text-center">CUST NO</th>
                                                <th class="text-center">NIC</th>
                                                <th class="text-center">LNNO</th>
                                                <th class="text-center">RECP NO</th>
                                                <th class="text-center">AMOUNT</th>
                                                <th class="text-center">DATE</th>
                                                <th class="text-center">CREATE BY</th>
                                                <th class="text-center">OPTION</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
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
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!--<div class="row">
                                        <div class="form-group col-md-12">
                                            <button type="button" id="process_btn"
                                                    class="btn btn-sm btn-danger pull-right">Cancellation
                                            </button>
                                        </div>
                                    </div>-->

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

<!-- REJECT Model -->
<div class="modal" id="modalReject" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-md" <!--style="width: 90%"-->>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
            <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Repayment Cancel <span
                        id="amt"></span>
            </h4>
        </div>
        <form class="form-horizontal" id="recept_reject" name="recept_reject" action="" method="post">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <!-- <div class="panel panel-default">
                             <div class="panel-body">-->
                        <div class="col-md-9">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Cancel Reason</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="resn" id="resn">
                                        <option value="0"> -- Select Reason --</option>
                                        <?php
                                        foreach ($recptrtn as $recpt) {
                                            echo "<option value='$recpt->rtid'>$recpt->rtds</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <input type="hidden" id="reid" name="reid">
                            </div>
                        </div>
                        <!--  </div>
                      </div>-->
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="cnsBtn">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</div>
<!--End REJECT Model -->

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
        //srchPayment();

        $("#recept_reject").validate({  // center add form validation
            rules: {
                resn: {
                    required: true,
                    notEqual: '0',
                },
            },
            messages: {
                resn: {
                    required: 'Please select Cancel Reason',
                    notEqual: "Please select Cancel Reason",
                },
            }
        });
        $.validator.addClassRules("pybx", {
            // digits: true,
            currency: true
        });
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // Repayment Loan Load
    function srchPayment() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var todt = document.getElementById('todt').value;


        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbRpymt').DataTable().clear();
            $('#dataTbRpymt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "paging": false,
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
                    {className: "text-left", "targets": [1, 2, 3, 9]},
                    {className: "text-center", "targets": [0, 4, 5, 6, 10]},
                    {className: "text-right", "targets": [5, 7, 8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[8, "ASC"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '15%'},    // ccnt / brco
                    {sWidth: '15%'},    // cust name
                    {sWidth: '5%'},    // cust no
                    {sWidth: '5%'},     // nic
                    {sWidth: '5%'},     // lnno
                    {sWidth: '5%'},     //
                    {sWidth: '5%'},     // bal
                    {sWidth: '15%'},     // tody pymt
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/getRepaymt',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        todt: todt
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    document.getElementById("len").value = display.length;

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
                    $(api.column(7).footer()).html(numeral(t1).format('0,0.00'));

                },
            });
        }
    }

    // REPAYMENT CANCEL
    function recptReject(auid, remt) {
        document.getElementById('reid').value = auid;
        $('#amt').text(" | Repayment Amount " + remt);
    }

    // repayment cancel process
    $("#cnsBtn").on('click', function (e) { // add form
        e.preventDefault();

        if ($("#recept_reject").valid()) {

            swal({
                title: "Please wait...",
                text: "Processing",
                imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
                showConfirmButton: false
            });

            document.getElementById("cnsBtn").disabled = true; // modalReject
            $('#modalReject').modal('hide');

            $.ajax({
                url: '<?= base_url(); ?>user/repymtCancel',
                type: 'POST',
                data: $("#recept_reject").serialize(),
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {

                    swal({title: "", text: "Repayment cancel success", type: "success"},
                        function () {
                            srchPayment();
                            document.getElementById("cnsBtn").disabled = false;

                            //location.reload();
                        }
                    );
                },
                error: function (data, jqXHR, textStatus) {
                    swal({title: "Repayment cancel Failed", text: "Contact system admin", type: "error"},
                        function () {
                            //location.reload();
                        }
                    );
                }
            });
        } else {
            //  alert("Error");
        }
    });


</script>












