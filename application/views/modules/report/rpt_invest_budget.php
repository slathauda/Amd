<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Module</li>
    <li>Sales Report</li>
    <li class="active"> Investment & Budget Report</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Investment & Budget Report</strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_invrst" name="rpt_invrst" class="form-horizontal" method="post">
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
                                        <select class="form-control" name="prtp" id="prtp"
                                                onchange="loadPrdt(this.value)">
                                            <option value="0"> -- Select Type --</option>
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
                                    <label class="col-md-4 col-xs-6 control-label">Product</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="prdt" id="prdt">
                                            <option value="0"> -- Select product --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
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
                                           id="dataTbInvst" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRNC</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">PRD TYPE</th>
                                            <th class="text-center">PRODUCT</th>
                                            <th class="text-center">BUDG AMT</th>
                                            <th class="text-center">ACTI AMT</th>
                                            <th class="text-center">ACTI AMT %</th>
                                            <th class="text-center">PEND AMT</th>
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
        $('#dataTbInvst').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_invrst").validate({  // Product loan validation
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
                prdt: {
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
                    required: 'Please select Officer',
                    notEqual: "Please select Officer"
                },
                prtp: {
                    required: 'Please select Product Type',
                    notEqual: "Please select Product Type"
                },
                prdt: {
                    required: 'Please select Product',
                    notEqual: "Please select Product"
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

    // LOAD PRODUCT
    function loadPrdt(prtp) {

        var brnc = document.getElementById('brch').value;
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>report/getProduct',
            data: {
                prtp: prtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#prdt').empty();
                    /* $('#prdt').append("<option value='0'> -- Select Product   </option>");*/
                    $('#prdt').append("<option value='all'> All Product </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['prnm'];
                        var $el = $('#prdt');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#prdt').empty();
                    $('#prdt').append("<option value='0'>-- No Product --</option>");
                }
            },
        });

    }

    // SEARCH
    $("#srch").click(function (e) {
        e.preventDefault();
        if ($("#rpt_invrst").valid()) {

            var brn = document.getElementById('brch').value;
            var exc = document.getElementById('exc').value;
            var prtp = document.getElementById('prtp').value;
            var prdt = document.getElementById('prdt').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            $('#dataTbInvst').DataTable().clear();
            $('#dataTbInvst').DataTable({
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
                    {className: "text-center", "targets": [0]},
                    {className: "text-right", "targets": [0, 5, 6, 7, 8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[2, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/srchInverst',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        prtp: prtp,
                        prdt: prdt,
                        frdt: frdt,
                        todt: todt,
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
                    //COLUMN 5 TTL
                    var t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                    //COLUMN 6 TTL
                    var t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));

                    //COLUMN 8 TTL
                    var t8 = api.column(8).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));

                },
            });
        }
    });

    // EXCDL EXPORT
    $("#excel").click(function (e) {
        e.preventDefault();
        if ($("#rpt_invrst").valid()) {

            var brn = document.getElementById('brch').value;
            var exc = document.getElementById('exc').value;
            var prtp = document.getElementById('prtp').value;
            var prdt = document.getElementById('prdt').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>excelrpt/investNbuget/' + brn + '/' + exc + '/' + prtp + '/' + prdt + '/' + frdt + '/' + todt;

        }
    });


</script>












