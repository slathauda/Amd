<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Report Master</li>
    <li class="active"> General Ledger</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> General Ledger </strong></h3>
                </div>
                <div class="panel-body ">
                    <form id="rpt_gl" name="rpt_gl" class="form-horizontal" method="post">
                        <div class="row ">
                            <div class="col-md-4">
                                <div class="form-group">
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
                                        <input type="text" class="form-control datepicker"
                                               placeholder="" id="frdt" name="frdt" value="<?= date("Y-m-d") ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Main Account</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="mnac" id="mnac"
                                                onchange="getChrt(this.value);chckBtn(this.value,'mnac')">
                                            <option value="0"> Select Main Account</option>
                                            <option value="all"> All Account</option>
                                            <?php
                                            foreach ($minacinfo as $mnac) {
                                                echo "<option value='$mnac->auid'>$mnac->name</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker"
                                               placeholder="" id="todt" name="todt" value="<?= date("Y-m-d") ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-6 control-label">Chart Of Account</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="chac" id="chac"
                                                onchange="chckBtn(this.value,'chac')">
                                            <option value="0"> Select Chart Account</option>
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
                                           id="dataTbGl" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">ACCOUNT</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center">TYPE</th>
                                            <th class="text-center">DESCRIPTION</th>
                                            <th class="text-center">DEBIT</th>
                                            <th class="text-center">CREDIT</th>
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
        $('#dataTbGl').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#rpt_gl").validate({  // Product loan validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                mnac: {
                    required: true,
                    notEqual: '0'
                },
                chac: {
                    required: true,
                    notEqual: '0'
                },
                /* cndy: {
                 required: true,
                 notEqual: '-'
                 },
                 prtp: {
                 required: true,
                 notEqual: '0'
                 },*/
            },
            messages: {
                brch: {
                    required: 'Please select branch',
                    notEqual: "Please select branch"
                },
                mnac: {
                    required: 'Please select Account',
                    notEqual: "Please select Account"
                },
                chac: {
                    required: 'Please select center',
                    notEqual: "Please select Chart Account"
                },
                /*  cndy: {
                 required: 'Please select Center Day',
                 notEqual: "Please select Center Day"
                 },
                 prtp: {
                 required: 'Please select Type',
                 notEqual: "Please select Type"
                 },*/
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

    // LOAD CHART OF ACCOUNT
    function getChrt(mnac) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>report/getChrtAcc',
            data: {
                mnac: mnac,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#chac').empty();
                    $('#chac').append("<option value='all'>All Chart Account </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['idfr'];
                        var name = response[i]['hadr'];
                        var $el = $('#chac');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#chac').empty();
                    $('#chac').append("<option value='0'>No Account</option>");
                }
            },
        });

    }

    // SEARCH
    $("#srch").click(function (e) {
        e.preventDefault();
        if ($("#rpt_gl").valid()) {
            var brn = document.getElementById('brch').value;
            var mnac = document.getElementById('mnac').value;
            var chac = document.getElementById('chac').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            $('#dataTbGl').DataTable().clear();
            $('#dataTbGl').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4, 5]},
                    {className: "text-center", "targets": [0]},
                    {className: "text-right", "targets": [6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[3, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '20%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>report/searchGl',
                    type: 'post',
                    data: {
                        brn: brn,
                        mnac: mnac,
                        chac: chac,
                        frdt: frdt,
                        todt: todt,
                    }
                },
                "footerCallback": function (row, data, start, end, display) {
                    var api = this.api(), data;
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    //THOUSAND COMMA
                    function addCommas(nStr) {
                        nStr += '';
                        x = nStr.split('.');
                        x1 = x[0];
                        x2 = x.length > 1 ? '.' + x[1] : '';
                        var rgx = /(\d+)(\d{3})/;
                        while (rgx.test(x1)) {
                            x1 = x1.replace(rgx, '$1' + ',' + '$2');
                        }
                        return x1 + x2;
                    }

                    //COLUMN 6 TTL
                    t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t6 = addCommas(t6);

                    pt6 = api.column(6, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt6 = addCommas(pt6);

                    $(api.column(6).footer()).html(
                        pt6 + '<br/> (' + t6 + ')' //pt7 +'<br/> ( '+ t7 +' Total )'
                    );

                    //COLUMN 7 TTL
                    t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    t7 = addCommas(t7);

                    pt7 = api.column(7, {page: 'current'}).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0).toFixed(2);
                    pt7 = addCommas(pt7);

                    $(api.column(7).footer()).html(pt7 + '<br/> (' + t7 + ')' //pt8 +'<br/> ( '+ t8 +' Total )'
                    );

                }
            });
        }
    });

    // PDF PRINT
    $("#print").click(function (e) {
        e.preventDefault();
        if ($("#rpt_gl").valid()) {

            var brn = document.getElementById('brch').value;
            var mnac = document.getElementById('mnac').value;
            var chac = document.getElementById('chac').value;
            var frdt = document.getElementById('frdt').value;
            var todt = document.getElementById('todt').value;

            var w = window.open('about:blank', '_blank');
            w.location.href = '<?= base_url(); ?>report/printGenerLedg/' + brn + '/' + mnac + '/' + chac + '/' + frdt + '/' + todt;

        }
    });

</script>












