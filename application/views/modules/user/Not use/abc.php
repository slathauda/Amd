<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Micro Finance</li>
    <li>CSU Module</li>
    <li class="active">CSU Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Center Management </strong></h3>
                    <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modal_large"><span><i
                                    class="fa fa-plus"></i></span> Add Center
                    </button>
                </div>
                <div class="panel-body">

                        <div class="row form-horizontal">
                            <div class="col-md-4">
                                <div class="form-group form-horizontal">
                                    <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="brch" id="brch"
                                                onchange="getExe(this.value);zeroOpt(this.value,'cm_brn')">
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
                                    <label class="col-md-4 col-xs-6 control-label">Executive</label>
                                    <div class="col-md-6 col-xs-6">
                                        <select class="form-control" name="exc" id="exc">
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
                                    <label class="col-md-3 col-xs-12 text-right"></label>
                                    <div class="col-md-8 col-xs-12 text-right">
                                        <button type="button form-control" onclick="searchCenter()"
                                                class='btn-sm btn-primary'>
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
                                           id="dataTbCenter">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
<!--                                            <th class="text-center">PRODUCTS</th>-->
                                            <th class="text-center">EXECUTIVE</th>
                                            <th class="text-center">CNT NO</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">COLLEC DAY</th>
                                            <th class="text-center">CUST</th>
                                            <th class="text-center">LOANS</th>
                                            <th class="text-center">CUS MAX</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTION</th>
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

<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Large Modal</h4>
            </div>
            <div class="modal-body">
                Some content in modal example
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $().ready(function () {
       // Data Tables
        $('#dataTbCenter').DataTable({
            destroy: true,
            "lengthMenu": [
                [100, 250, 500, 1000, -1],
                [100, 250, 500, 1000, "All"]
            ],
        });

        searchCenter();

//        $('#leg_tbl').DataTable({
//            destroy: true
//        });

    });

    function searchCenter() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        // var cen = document.getElementById('center').value;
        // var prd = document.getElementById('prd_type').value;
        // var age = document.getElementById('age').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else if (exc == '0') {
            document.getElementById('exc').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            //  $('#dataTbCenter').DataTable().clear();

            $('#dataTbCenter').DataTable().clear();
            $('#dataTbCenter').DataTable({
                "destroy": true,
                //"cache": false,
                "processing": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [100, 250, 500, 1000, -1],
                    [100, 250, 500, 1000, "All"]
                ],
                "serverSide": true,
                "columnDefs": [
                    //{className: "text-right", "targets": [7, 8, 9]},
                    //{className: "text-center", "targets": [0, 10, 11]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>user/searchCenter',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc
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

                    // $(api.column(6).footer()).html('This page Total');
                    $(api.column(7).footer()).html(numeral(t1).format('0,0.00'));
                    $(api.column(8).footer()).html(numeral(t2).format('0,0.00'));
                    $(api.column(9).footer()).html(numeral(t3).format('0,0.00'));
                }
            });


//            $.ajax({
//                url: '<?//= base_url(); ?>//user/searchCenter',
//                type: 'post',
//                data: {
//                    brn: brn,
//                    exc: exc
//                },
//                dataType: 'json',
//                success: function (response) {
//                    var options = '';
//                    var len = response.length;
//                    var t = $('#dataTbCenter').DataTable();
//                    // var tot_cubl = '0';
//                    // var tot_ramt = '0';
//                    t.clear().draw();
//                    for (var i = 0; i < len; i++) {
//                        // var rr = response[i]['curr_tot_balance'];
//                        //  var cubl = numeral(rr).format('$0,0.00');
//                        //  var rr2 = response[i]['ramt'];
//                        //  var ramt = numeral(rr2).format('$0,0.00');
//
//                        // tot_cubl = +tot_cubl + +response[i]['curr_tot_balance'];
//                        //  tot_ramt = +tot_ramt + +response[i]['ramt'];
//
//                        t.row.add([
//                            i + 1,
//                            response[i]['brnm'],
//                            response[i]['fnme'] + ' ' + response[i]['lnme'],
//                            response[i]['cnno'],
//                            response[i]['cnnm'],
//                            response[i]['cody'],
//                            response[i]['ccus'],
//                            'loans',
//                            response[i]['mcus'],
//                            response[i]['stat'],
//                            options
//
//
//                        ]).draw(false);
//
//                    }
//                    // alert(tot_cubl + '**' + tot_ramt);
////                    document.getElementById('tot_cubl2').value = tot_cubl;
////                    document.getElementById('tot_ramt2').value = tot_ramt;
////
//                }
//            });


        }
    }

</script>












