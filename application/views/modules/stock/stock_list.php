<!DOCTYPE html>
<html class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="">Stock Control</a></li>
                        <li class="active"><strong>Stock List</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Stock List</h3>
                    <!--<button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>-->
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Supply</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="sply" id="sply"
                                            onchange="chckBtn(this.value,'sply')">
                                        <option value="all"> All Supply</option>
                                        <?php
                                        foreach ($spplyinfo as $sply) {
                                            echo "<option value='$sply->spid'>$sply->spnm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker"
                                           name="frdt" id="frdt" value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4  control-label">To Date</label>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker"
                                               name="todt" id="todt" value="<?= date('Y-m-d') ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchStckList()"
                                            class='btn-sm btn-primary' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">

                         </div>-->
                    </div>
                </div>

                <div class="content-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table datatable table-bordered table-striped table-actions"
                                   id="dataTbStck" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center"> NO</th>
                                    <th class="text-center"> STK NO</th>
                                    <th class="text-center">BCODE</th>
                                    <th class="text-center">CODE | NAME</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">AQTY</th>
                                    <th class="text-center">COST</th>
                                    <th class="text-center">SALES</th>
                                    <th class="text-center">DISPLY</th>
                                    <!--<th class="text-center"> COST TTL</th>-->
                                    <th class="text-center"> CR DATE</th>
                                    <th class="text-center"> MODE</th>
                                    <th class="text-center"> OPTION</th>
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
                    </div>
                </div>
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">View Item List</h4>
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
                                            <label class="col-md-4 col-xs-12 control-label">Stock No</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="stcno"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Code & Name</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="cdnme"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Barcode</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="bcde"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Quenty </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="qunty"></label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 label-default"></div>
                                    <br>
                                    <div class="panel-body panel-body-table">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="viePoTb" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">Serial No</th>
                                                <th class="text-center">Imie No</th>
                                                <th class="text-center">Part No</th>
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Remarks </label>
                                            <label class="col-md-4 col-xs-12 control-label text-right"
                                                   id="vw_remk"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-9 col-xs-12 control-label tx-align">Total</label>
                                            <label class="col-md-3 col-xs-12 control-label tx-align"
                                                   id="vw_sbtl"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Edit || Approval -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true"
     style="overflow: scroll;">
    <div class="modal-backdrop in" style="height: 100%; z-index: -10"></div>
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="stk_edt" name="stk_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Stock No</label>
                                                <label class="col-md-4 col-xs-6 control-label" id="stkno"></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Code & Name</label>
                                                <label class="col-md-4 col-xs-6 control-label" id="cdnm"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Barcode</label>
                                                <label class="col-md-4 col-xs-6 control-label" id="bcode"></label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Quenty</label>
                                                <label class="col-md-4 col-xs-6 control-label" id="qtny"> </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-10"></div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-sm btn-info" data-toggle='modal'
                                                    data-target='#modal_gennummedt'>Generate No
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                            <table class="table table-bordered  table-actions" id="stkTblEdt" style="">
                                                <thead>
                                                <tr>
                                                    <th width="" class="text-center">BAR CODE</th>
                                                    <th width="" class="text-center">SERIAL NO</th>
                                                    <th width="" class="text-center">IMEI NO</th>
                                                    <th width="" class="text-center">PART NO</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                <input type="hidden" id="func" name="func">
                                <input type="hidden" id="auid" name="auid">
                                <input type="hidden" id="lengEdt" name="lengEdt">
                                <input type="hidden" id="qutyaa" name="qutyaa">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit || Approval Model -->

<!--GENERATE NUMBER MODAL-->
<div class="modal" id="modal_gennummedt" tabindex="-2" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true"
     style="margin-top: 10%">
    <div class="modal-backdrop in" style="height: 100%; z-index: -10"></div>
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead">Generate Number</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Type</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control"
                                                    name="notypeedt" id="notypeedt">
                                                <option value="0"> -- Select Type --
                                                </option>
                                                <!--<option value="1"> Barcode No</option>-->
                                                <option value="2"> Serial No</option>
                                                <option value="3"> IMEI No</option>
                                                <option value="4"> Part No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">If
                                            Sequence</label>
                                        <div class="col-md-6 ">
                                            <label class="switch">
                                                No
                                                <input onchange="squenceedt()"
                                                       class="iswitch iswitch-md iswitch-primary"
                                                       name="sameedt" id="sameedt"
                                                       type="checkbox" value="1"/>
                                                Yes <span></span> </label>
                                        </div>
                                        <br>
                                    </div>
                                    <div class="form-group" id="seqeedt"
                                         style="display: block">
                                        <label class="col-md-4 col-xs-6 control-label">
                                            Enter No.
                                        </label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control"
                                                   id="normlnumedt" name="normlnumedt">
                                        </div>
                                    </div>
                                    <div class="form-group" id="strtedt"
                                         style="display: none">
                                        <label class="col-md-4 col-xs-6 control-label">
                                            Start No.
                                        </label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control"
                                                   id="strtnumedt" name="strtnumedt">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" onclick="gennumberedt();"
                        class="btn btn-success "
                        id="cp_accept">Accept
                </button>
                <button type="button" data-dismiss="modal"
                        class="btn btn-default">Close
                </button>
            </div>
        </div>
    </div>
</div>
<!--GENERATE NUMBER MODAL-->

<!-- END CONTAINER -->
</html>

<script>
    $().ready(function () {

        srchStckList();
    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }


    /* SEARCH */
    function srchStckList() {
        var sply = document.getElementById('sply').value;   // SPPLY
        var frdt = document.getElementById('frdt').value;   // FROM
        var todt = document.getElementById('todt').value;   // TO

        $('#dataTbStck').DataTable().clear();
        $('#dataTbStck').DataTable({
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
                {className: "text-left", "targets": [1, 3]},
                {className: "text-center", "targets": [0, 2, 9, 10]},
                {className: "text-right", "targets": [3, 4, 5, 6, 7, 8]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[1, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '3%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '30%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
            ],
            "ajax": {
                url: '<?= base_url(); ?>stock/srchStckList',
                type: 'post',
                data: {
                    sply: sply,
                    frdt: frdt,
                    todt: todt,
                }
            },
            "rowCallback": function (row, data, index) {
                var avqt = data[4],
                    tdpy = data[9],
                    $node = this.api().row(row).nodes().to$();
                if (avqt == 0) {
                    $node.addClass('danger');
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
                //COLUMN 3 TTL
//                var t3 = api.column(3).data().reduce(function (a, b) {
//                    return intVal(a) + intVal(b);
//                }, 0);
//                $(api.column(3).footer()).html(numeral(t3).format('0,0'));
                //COLUMN 4 TTL
                var t4 = api.column(4).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(4).footer()).html(numeral(t4).format('0,0'));
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(5).footer()).html(numeral(t5).format('0,0'));
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                //COLUMN 7 TTL
                var t7 = api.column(7).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                //COLUMN 8 TTL
                var t8 = api.column(8).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));
            },
        });
    }

    /* ADD */
    $("#addAcc").click(function (e) { //  add form
        e.preventDefault();
        if ($("#po_add").valid()) {
            //$('#modalAdd').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/addStock",
                data: $("#po_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    srchStck();
                    swal({title: "", text: "Purchase Order Add Success!", type: "success"},
                        function () {
                            //location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Purchase Order Add Failed !", type: "error"},
                        function () {
                            // location.reload();
                        });
                }
            });
        }
    });

    /* VIEW ITEM */
    function viewStck(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/getStock",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['sub'].length;

                document.getElementById("stcno").innerHTML = response['main'][0]['stno'];
                document.getElementById("cdnme").innerHTML = response['main'][0]['itcd'] + ' | ' + response['main'][0]['itcd'];
                document.getElementById("bcde").innerHTML = response['main'][0]['icde'];
                document.getElementById("qunty").innerHTML = response['main'][0]['qnty'];

                var m = $('#viePoTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": []},
                        {className: "text-center", "targets": [0]},
                        {className: "text-right", "targets": [1, 2, 3]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '10%'},
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
                    },
                });

                m.clear().draw();
                for (var a = 0; a < len; a++) {
                    m.row.add([
                        a + 1,
                        response['sub'][a]['srno'],
                        response['sub'][a]['btno'],
                        response['sub'][a]['prno'],
                    ]).draw(false);
                }
            }
        })
    }

    /* EDIT VIEW*/
    function edtDetils(auid, func) {
        //if (func == 'edt') {
        $('#hed').text("Edit Stock Details");
        $('#btnNm').text("Update");


        //} else if (func == 'app') {
        //    $('#hed').text("Approval Purachase Order");
        //    $('#btnNm').text("Approval");
        //    document.getElementById("func").value = 2;
        //}

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Stock/getStock",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {

                if (response['main'].length > 0) {
                    document.getElementById("stkno").innerHTML = response['main'][0]['stno'];
                    document.getElementById("bcode").innerHTML = response['main'][0]['icde'];
                    document.getElementById("cdnm").innerHTML = response['main'][0]['itcd'] + ' | ' + response['main'][0]['itcd'];
                    document.getElementById("qtny").innerHTML = response['main'][0]['qnty'];
                    document.getElementById("qutyaa").value = response['main'][0]['qnty'];
                }

                var stat = response['main'][0]['stat'];
                // stck added item
                if (stat == 2) {
                    document.getElementById("func").value = 2;
                } else {
                    document.getElementById("func").value = 1;
                }

                var len = response['main'][0]['qnty'];
                document.getElementById("lengEdt").value = response['main'][0]['qnty'];
                document.getElementById("auid").value = response['main'][0]['sbid'];

                // DETAILS TABLE
                $('#stkTblEdt').DataTable().clear();
                var t = $('#stkTblEdt').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": []},
                        {className: "text-center", "targets": [0, 1, 2, 3]},
                        {className: "text-right", "targets": []},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '10%'},   //
                        {sWidth: '10%'},    //
                        {sWidth: '10%'}
                    ],
                    "rowCallback": function (row, data, index) {
                    },
                });

                // update
                if (stat == 2) {
                    for (var a = 0; a < len; a++) {
                        var tbid = response['main'][0]['sbid'];
                        t.row.add([
                            '<input type="text" name="bcode[]" id="bcode_' + a + '" value="' + response['main'][0]['icde'] + '" readonly/>' + '<input type="hidden" name="dtid[]" value="' + response['sub'][a]['dtid'] + ' "/>',        // ITEM CODE
                            '<input type="text" name="serno[]" id="serno_' + a + '" value="' + response['sub'][a]['srno'] + '"/>',        // ITEM CODE
                            '<input type="text" name="batno[]" id="batno_' + a + '" value="' + response['sub'][a]['btno'] + '"/>',        // ITEM CODE
                            '<input type="text" name="prtno[]" id="prtno_' + a + '" value="' + response['sub'][a]['prno'] + '"/>',        // ITEM CODE

                        ]).draw(false);
                    }
                } else {    // insert
                    for (var a = 0; a < len; a++) {
                        var tbid = response['main'][0]['sbid'];
                        t.row.add([
                            '<input type="text" name="bcode[]" id="bcode_' + a + '" value="' + response['main'][0]['icde'] + '" readonly/>' + '<input type="hidden" name="tbid[]" value="' + response['main'][0]['sbid'] + ' "/>',        // ITEM CODE
                            '<input type="text" name="serno[]" id="serno_' + a + '" value=""/>',        // ITEM CODE
                            '<input type="text" name="batno[]" id="batno_' + a + '" value=""/>',        // ITEM CODE
                            '<input type="text" name="prtno[]" id="prtno_' + a + '" value=""/>',        // ITEM CODE

                        ]).draw(false);
                    }
                }
            }
        })
    }

    function squenceedt() {
        if (document.getElementById('sameedt').checked == true) {
            document.getElementById('strtedt').style.display = 'block';
            document.getElementById('seqeedt').style.display = 'none';
        } else {
            document.getElementById('strtedt').style.display = 'none';
            document.getElementById('seqeedt').style.display = 'block';
        }
    }

    //generate number
    function gennumberedt() {
        var type = document.getElementById('notypeedt').value;
        //check
        //if (document.getElementById('bulkid').value == 1) {

        if (document.getElementById('sameedt').checked == true) {
            var qunt = document.getElementById('qutyaa').value;
            var number = document.getElementById('strtnumedt').value;
            for (a = 0; a < qunt; a++) {

                if (type == 1) {     // barcode
                    var m = "bcode_" + a;
                    document.getElementById(m).value = number;
                    number++;

                } else if (type == 2) { // seril no
                    var n = "serno_" + a;
                    document.getElementById(n).value = number;
                    number++;
                }
                else if (type == 3) {   // batch no
                    var o = "batno_" + a;
                    document.getElementById(o).value = number;
                    number++;
                }
                else if (type == 4) {   // part no
                    var p = "prtno_" + a;
                    document.getElementById(p).value = number;
                    number++;
                }
                else if (type == 5) {
                    var p = "abcno1_" + a;
                    document.getElementById(p).value = number;
                    number++;
                }
                else if (type == 6) {
                    var p = "xyzno1_" + a;
                    document.getElementById(p).value = number;
                    number++;
                }
            }
        }
        else {
            var qunt = document.getElementById('qutyaa').value;
            var number = document.getElementById('normlnumedt').value;
            for (a = 0; a < qunt; a++) {

                if (type == 1) {            // barcode
                    var m = "bcode_" + a;
                    document.getElementById(m).value = number;

                } else if (type == 2) {     // seril no
                    var n = "serno_" + a;
                    document.getElementById(n).value = number;
                }
                else if (type == 3) {       // batch no
                    var o = "batno_" + a;
                    document.getElementById(o).value = number;
                }
                else if (type == 4) {
                    var p = "prtno_" + a;   // part no
                    document.getElementById(p).value = number;
                }
                else if (type == 5) {
                    var p = "abcno1_" + a;
                    document.getElementById(p).value = number;
                }
                else if (type == 6) {
                    var p = "xyzno1_" + a;
                    document.getElementById(p).value = number;
                }
            }
        }
        // }
        /* else {
         if (document.getElementById('sameedt').checked == true) {
         var qunt = document.getElementById('qutyaa').value;
         var number = document.getElementById('strtnumedt').value;
         for (a = 0; a < qunt; a++) {
         if (type == 1) {
         var m = "serno_" + a;
         document.getElementById(m).value = number;
         number++;
         } else if (type == 2) {
         var n = "batno_" + a;
         document.getElementById(n).value = number;
         number++;
         }
         else if (type == 3) {
         var o = "prtno_" + a;
         document.getElementById(o).value = number;
         number++;
         }
         else if (type == 4) {
         var p = "brcod_" + a;
         document.getElementById(p).value = number;
         number++;
         }
         else if (type == 5) {
         var p = "abcno_" + a;
         document.getElementById(p).value = number;
         number++;
         }
         else if (type == 6) {
         var p = "xyzno_" + a;
         document.getElementById(p).value = number;
         number++;
         }
         }
         }
         else {
         var qunt = document.getElementById('qutyaa').value;
         var number = document.getElementById('normlnumedt').value;
         for (a = 0; a < qunt; a++) {
         if (type == 1) {
         var m = "serno_" + a;
         document.getElementById(m).value = number;
         } else if (type == 2) {
         var n = "batno_" + a;
         document.getElementById(n).value = number;
         }
         else if (type == 3) {
         var o = "prtno_" + a;
         document.getElementById(o).value = number;
         }
         else if (type == 4) {
         var p = "brcod_" + a;
         document.getElementById(p).value = number;
         }
         else if (type == 5) {
         var p = "abcno_" + a;
         document.getElementById(p).value = number;
         }
         else if (type == 6) {
         var p = "xyzno_" + a;
         document.getElementById(p).value = number;
         }
         }
         }

         }*/
    }

    /* EDIT SUBMIT*/
    $("#subBtn").click(function (e) {
        e.preventDefault();

        if ($("#stk_edt").valid()) {
            swal({
                    title: "Are you sure this process",
                    text: "",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3bdd59",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#modalEdt').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>stock/addStkSubDtils",
                            data: $("#stk_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchStckList();
                                swal({title: "", text: " Stock List details update success", type: "success"},
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
    });

    /* REJECT*/
    function rejecPo(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process ",
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
                        url: '<?= base_url(); ?>Hire_purchase/rejtPo',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchStckList();
                                swal({title: "Po Reject success !", text: "", type: "success"});
                            } else {
                                swal({title: "error !", text: response, type: "error"});
                            }
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "error", text: errorThrown, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled !", "po not reject", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvStck(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process ",
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
                        url: '<?= base_url(); ?>Hire_purchase/reactItem',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchStckList();
                                swal({title: "Item Reactive success !", text: "", type: "success"});
                            } else {
                                swal({title: "error !", text: response, type: "error"});
                            }
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "error", text: errorThrown, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled !", "Item not active", "error");
                }
            });
    }

</script>