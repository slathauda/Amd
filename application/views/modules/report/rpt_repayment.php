<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>General Report</li>
    <li class="active"> Repayment Sheet</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Repayment Sheet </strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_rpymt" name="rpt_rpymt" class="form-horizontal" method="post">
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
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
                                                onchange="getGrupXX(this.value,'grup',brch.value,exc.value,cen.value)">
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
                                                <li><a href="#" id="atend"><img
                                                                src='<?= base_url(); ?>assets/dist/img/icons/pdf.png'
                                                                width="24"/> ATTENDANCES</a></li>
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
                                           id="dataTbRpymt" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">GNO</th>
                                            <th class="text-center">BRCH / CNTR</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CUSTOMER NIC</th>
                                            <th class="text-center">MOBILE</th>
                                            <th class="text-center">LOAN AMNT</th>
                                            <th class="text-center">RENTAL</th>
                                            <th class="text-center">ARRESS</th>
                                            <th class="text-center">CURR BAL</th>
                                            <th class="text-center">AGE</th>
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

        $("#rpt_rpymt").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                /*exc: {
                 required: true,
                 notEqual: 'all'
                 },*/
                cen: {
                    required: true,
                    notEqual: 'all'
                },
            },
            messages: {
                brch: {
                    required: 'Please select branch',
                    notEqual: "Please select branch"
                },
                /*exc: {
                 required: 'Please select officer',
                 notEqual: "Please select officer"
                 },*/
                cen: {
                    required: 'Please select center',
                    notEqual: "Please select center"
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
        if ($("#rpt_rpymt").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var grp = document.getElementById('grup').value;
            var prd = document.getElementById('prtp').value;

            $('#dataTbRpymt').DataTable().clear();
            $('#dataTbRpymt').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "orderable": true,
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
                    {className: "text-center", "targets": [0, 1, 4, 5, 10]},
                    {className: "text-right", "targets": [0, 6, 7, 8, 9]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[2, "asc"],[4, "asc"]], //ASC  desc
                "aaSorting": [[4, 'asc']],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/searchRepymnt',
                    type: 'post',
                    data: {
                        brn: brn,
                        ofc: ofc,
                        cnt: cnt,
                        grp: grp,
                        prd: prd,

                    }
                }
            });
        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rpymt").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var grp = document.getElementById('grup').value;
            var prd = document.getElementById('prtp').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printRepymnt/' + brn + '/' + ofc + '/' + cnt + '/' + grp + '/' + prd;
        }
    });

    // ATTENDANCE PRINT
    $("#atend").click(function (e) {
        e.preventDefault();
        if ($("#rpt_rpymt").valid()) {

            var brn = document.getElementById('brch').value;
            var ofc = document.getElementById('exc').value;
            var cnt = document.getElementById('cen').value;
            var grp = document.getElementById('grup').value;
            var prd = document.getElementById('prtp').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printCustAttnd/' + brn + '/' + ofc + '/' + cnt + '/' + grp + '/' + prd;
        }
    });


    function getGrupXX(id, htid, brnid, excid, cenid) { // id value,html value,brnch id,exe id,cen id

        var m = "#" + htid; // group html id
        $(m).empty();
        $(m).append("<option value='-'>Select Group</option>");

        $.ajax({
            url: '<?= base_url(); ?>user/getGrup',
            type: 'post',
            data: {
                brn_id: brnid,
                exe_id: excid,
                cen_id: cenid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $(m).empty();
                    $(m).append("<option value='all'>All Group</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['grpid'];
                        var name = response[i]['cnnm'] + ' - ' + response[i]['grno'];
                        var $el = $(m);
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $(m).empty();
                    $(m).append("<option value='no'>No Group</option>");
                }
            }
        });
    }

</script>












