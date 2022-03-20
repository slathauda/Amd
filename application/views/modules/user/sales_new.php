<!DOCTYPE html>
<html class="">

<body class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active"><strong>New Sales</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <form class="form-horizontal" id="addCrt" name="addCrt"
                      action="" method="post">
                    <header class="panel_header">
                        <h5 class="title pull-left">Billed To </h5>
                        <div class="col-md-3" style="padding-top: 10px">
                            <input type="text" class="form-control text-uppercase"
                                   value="Cash Customer" autofocus
                                   name="cusNm" id="cusNm" onkeyup="cusNam(event);"/>
                        </div>
                        <div class="col-md-3" style="padding-top: 10px">
                            <label class="col-md-5  control-label">Bill Branch</label>
                            <div class="col-md-7 col-xs-6">
                                <select class="form-control" name="inbrn" id="inbrn"
                                        onchange="">
                                    <?php
                                    foreach ($branchinfo as $branch) {
                                        if ($branch['brch_id'] == 'all' || $branch['brch_id'] == 0) {
                                        } else {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3" style="padding-top: 10px">
                            <label class="col-md-5  control-label">Bill Date</label>
                            <label class="col-md-7  control-label"><?= date('Y-m-d') ?></label>
                        </div>

                        <button type="button" class="btn btn-sm btn-info btn-corner pull-right" id="adItmBtn">
                            <span><i class="fa fa-plus"></i></span> Add Item
                        </button>
                    </header>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!-- start -->
                                <div class="row" id="divAditm" style="display: none">
                                    <div class="col-md-12 col-sm-12 col-xs-12">

                                        <div class="col-md-4">
                                            <!--<div class="form-group">
                                                <label class="col-md-5  control-label">Barcode</label>
                                                <div class="col-md-7 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               placeholder="Barcode" name="brcd" id="brcd"
                                                               onkeyup="srchItm(event,this.value)"/>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Item Name</label>
                                                <div class="col-md-8 ">
                                                    <input class="form-control" list="itnm" name="itnm"
                                                           onkeyup="srchItm(event,this.value)"
                                                           onchange="srchItm(event,this.value)"
                                                           onclick="this.value=''">
                                                    <datalist id="itnm">
                                                        <?php
                                                        foreach ($itmDet as $itm) {
                                                            echo "<option value='$itm->icde | $itm->itcd | $itm->itnm '> </option>";
                                                        }
                                                        ?>
                                                    </datalist>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 control-label">BarCode</label>
                                                <label class="col-md-8 control-label" id="itbcd"> - </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Item Name</label>
                                                <label class="col-md-8 control-label" id="itmNm">-</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Item Code</label>
                                                <label class="col-md-8 control-label" id="itmCd">-</label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Sales Price</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control "
                                                           placeholder="Sales Price"
                                                           name="itmSlpr" id="itmSlpr"/>
                                                    <input type="hidden" name="itmCshpr" id="itmCshpr"
                                                           title="itn cost prc"/>
                                                    <input type="hidden" name="ttlItm" id="ttlItm"
                                                           title="ttl itm cunt"/>
                                                    <input type="hidden" name="itmBcde" id="itmBcde" title="itm Bcde"/>
                                                    <input type="hidden" name="itmDspr" id="itmDspr" title="dis val"/>
                                                    <input type="hidden" name="itmNmTxb" id="itmNmTxb"
                                                           title="itmNmTxb"/>
                                                    <input type="hidden" name="itmCdTxb" id="itmCdTxb"
                                                           title="itmCdTxb"/>
                                                    <input type="hidden" name="itmStkid" id="itmStkid"
                                                           title="itmStkid"/>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Quantity</label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control"
                                                           placeholder="Quantity"
                                                           name="qunty" id="qunty"/>
                                                </div>
                                            </div>
                                            <div class=" col-md-12">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-6">
                                                    <button type="button" class="btn btn-sm btn-success btn-corner"
                                                            id="addToCrt"> Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <table class="table datatable table-bordered table-striped table-actions"
                                                   id="dataTbItm" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center info" style="color: red">COST</th>
                                                    <th class="text-center">DISPLAY</th>
                                                    <th class="text-center">SALES</th>
                                                    <th class="text-center">OPT</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-4">
                                            <table class="table datatable table-bordered table-striped table-actions"
                                                   id="dataTbStck" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">SERIAL NO</th>
                                                    <th class="text-center">IMEI NO</th>
                                                    <!--<th class="text-center">PART NO</th>-->
                                                    <th class="text-center">ADD</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" id="divOdrSumm" style="display: none">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <h3>Order summary</h3><br>
                                        <div class="panel-body panel-body-table" style="padding:10px;">
                                            <div class="table-responsive">
                                                <table class="table table-hover invoice-table" id="sumryTb"
                                                       style="width: 100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center"> BCODE</th>
                                                        <th class="text-center"> ITEM CODE & NAME</th>
                                                        <th class="text-center"> VALUE</th>
                                                        <th class="text-center"> DISCOUNT</th>
                                                        <th class="text-center"> SALES</th>
                                                        <th class="text-center"> QTY</th>
                                                        <th class="text-center"> SUB TTL</th>
                                                        <th class="text-center"> OPTION</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                                    <!-- <tr>
                                                         <td>BS-200</td>
                                                         <td class="text-center">$10.99</td>
                                                         <td class="text-center">1</td>
                                                         <td class="text-right">$10.99</td>
                                                     </tr>

                                                     <tr>
                                                         <td class="thick-line"></td>
                                                         <td class="thick-line"></td>
                                                         <td class="thick-line text-center"><h4>Subtotal</h4></td>
                                                         <td class="thick-line text-right"><h4>$1670.99</h4></td>
                                                     </tr>
                                                     <tr>
                                                         <td class="no-line"></td>
                                                         <td class="no-line"></td>
                                                         <td class="no-line text-center"><h4>Shipping</h4></td>
                                                         <td class="no-line text-right"><h4>$15</h4></td>
                                                     </tr>
                                                     <tr>
                                                         <td class="no-line"></td>
                                                         <td class="no-line"></td>
                                                         <td class="no-line text-center"><h4>VAT</h4></td>
                                                         <td class="no-line text-right"><h4>$150.23</h4></td>
                                                     </tr>
                                                     <tr>
                                                         <td class="no-line"></td>
                                                         <td class="no-line"></td>
                                                         <td class="no-line text-center"><h4>Total</h4></td>
                                                         <td class="no-line text-right"><h3 style='margin:0px;'
                                                                                            class="text-primary">
                                                                 $1985.99</h3>
                                                         </td>
                                                     </tr>-->
                                                    </tbody>

                                                    <tfoot>
                                                    <tr>
                                                        <td class="no-line"></td>
                                                        <td class="no-line text-center"><h4>Total</h4></td>
                                                        <td class="no-line text-right">
                                                            <h4 style='margin:0px;' class="text-primary"
                                                                id="ttlDsvl"></h4>
                                                        </td>
                                                        <td class="no-line text-right">
                                                            <h4 style='margin:0px;' class="text-primary"
                                                                id="ttlDisc"></h4>
                                                        </td>
                                                        <td class="no-line text-right">
                                                            <h4 style='margin:0px;' class="text-primary"
                                                                id="ttlSlvl"></h4>
                                                        </td>
                                                        <td class="no-line text-right">
                                                            <h4 style='margin:0px;' class="text-primary"
                                                                id="ttlQuty"></h4>
                                                        </td>
                                                        <td class="no-line text-right">
                                                            <h4 style='margin:0px;' class="text-primary"
                                                                id="ttlSub"></h4>
                                                        </td>
                                                        <td class="no-line"></td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                <input type="hidden" id="ttlQutyHd" name="ttlQutyHd"/>
                                                <input type="hidden" id="ttlSubHd" name="ttlSubHd"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>
                                    <br>
                                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                        <a href="#" target="" class="btn btn-purple btn-md" id="PrntBtn">
                                            <i class="fa fa-print"></i> &nbsp; Process </a>
                                        <!--<a href="#" target="_blank" class="btn btn-orange btn-md">
                                            <i class="fa fa-send"></i> &nbsp; Send </a>-->
                                    </div>
                                </div>

                                <div class="clearfix"></div>
                                <br>

                                <!-- end -->
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </section>
</section>
<!-- END CONTENT -->


<div class="page-chatapi hideit">
    <div class="search-bar">
        <input type="text" placeholder="Search" class="form-control">
    </div>
    <div class="chat-wrapper">
        <h4 class="group-head">Groups</h4>
        <ul class="group-list list-unstyled">
            <li class="group-row">
                <div class="group-status available">
                    <i class="fa fa-circle"></i>
                </div>
                <div class="group-info">
                    <h4><a href="#">Work</a></h4>
                </div>
            </li>
            <li class="group-row">
                <div class="group-status away">
                    <i class="fa fa-circle"></i>
                </div>
                <div class="group-info">
                    <h4><a href="#">Friends</a></h4>
                </div>
            </li>

        </ul>


        <h4 class="group-head">Favourites</h4>
        <ul class="contact-list">

            <li class="user-row" id='chat_user_1' data-user-id='1'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clarine Vassar</a></h4>
                    <span class="status available" data-status="available"> Available</span>
                </div>
                <div class="user-status available">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_2' data-user-id='2'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Brooks Latshaw</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_3' data-user-id='3'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-3.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clementina Brodeur</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>

        </ul>


        <h4 class="group-head">More Contacts</h4>
        <ul class="contact-list">

            <li class="user-row" id='chat_user_4' data-user-id='4'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-4.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Carri Busey</a></h4>
                    <span class="status offline" data-status="offline"> Offline</span>
                </div>
                <div class="user-status offline">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_5' data-user-id='5'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-5.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Melissa Dock</a></h4>
                    <span class="status offline" data-status="offline"> Offline</span>
                </div>
                <div class="user-status offline">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_6' data-user-id='6'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Verdell Rea</a></h4>
                    <span class="status available" data-status="available"> Available</span>
                </div>
                <div class="user-status available">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_7' data-user-id='7'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Linette Lheureux</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_8' data-user-id='8'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-3.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Araceli Boatright</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_9' data-user-id='9'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-4.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Clay Peskin</a></h4>
                    <span class="status busy" data-status="busy"> Busy</span>
                </div>
                <div class="user-status busy">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_10' data-user-id='10'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-5.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Loni Tindall</a></h4>
                    <span class="status away" data-status="away"> Away</span>
                </div>
                <div class="user-status away">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_11' data-user-id='11'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-1.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Tanisha Kimbro</a></h4>
                    <span class="status idle" data-status="idle"> Idle</span>
                </div>
                <div class="user-status idle">
                    <i class="fa fa-circle"></i>
                </div>
            </li>
            <li class="user-row" id='chat_user_12' data-user-id='12'>
                <div class="user-img">
                    <a href="#"><img src="<?= base_url(); ?>assets/data/profile/avatar-2.png" alt=""></a>
                </div>
                <div class="user-info">
                    <h4><a href="#">Jovita Tisdale</a></h4>
                    <span class="status idle" data-status="idle"> Idle</span>
                </div>
                <div class="user-status idle">
                    <i class="fa fa-circle"></i>
                </div>
            </li>

        </ul>
    </div>
</div>

<!-- END CONTAINER -->
</body>

<script type="text/javascript">

    $().ready(function () {

        //  ADD VALIDATE
        $("#addCrt").validate({
            rules: {
                cusNm: {
                    required: true,
                    //notEqual: '0'
                },
                itnm: {
                    required: true,
                    notEqual: '0'
                },
                itmSlpr: {
                    required: true,
                    notEqual: '0',
                    digits: true,
                    lessThanOrEqual: '#itmCshpr'
                },
                qunty: {
                    required: true,
                    notEqual: '0',
                    digits: true,
                    equalTo: '#ttlItm'
                },


                dsrt: {
                    currency: true
                },
                dsvl: {
                    currency: true
                },
                txrt: {
                    notEqual: '0',
                    currency: true
                },
                otchg: {
                    digits: true
                },
                ttl: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },
            },
            messages: {
                cusNm: {
                    required: 'Please Enter Customer ',
                },
                itnm: {
                    required: 'Please select Item ',
                },
                itmSlpr: {
                    required: 'Please Enter Sales Value',
                    lessThanOrEqual: 'Sales Value Less Then Cost Value'
                },
                qunty: {
                    required: 'Please Enter Quantity',
                    equalTo: 'Not match total Quantity and Select item',
                },


                qnty: {
                    digits: 'Please enter Quantity',
                },
                untp: {
                    //required: 'Please enter Quantity',
                },
                txrt: {
                    currency: 'Not a rate',
                },
                otchg: {
                    //required: 'Please enter Quantity',
                },
            }
        });

    });

    // SEARCH BARCODE DETAILS
    function srchItm(event, srchCd) {
        //console.log( ' ** ' + srchCd);
        var res = srchCd.split("|");
        if (event.keyCode == 13) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/getBrcdDetils",
                data: {
                    bcde: res[0],
                },
                dataType: 'json',
                success: function (data) {
                    if (data['itdtil'].length > 0) {

                        //document.getElementById('itnm').value = data['itdtil'][0]['itnm'];
                        document.getElementById('itbcd').innerHTML = data['itdtil'][0]['icde'];
                        document.getElementById('itmNm').innerHTML = data['itdtil'][0]['itnm'];
                        document.getElementById('itmCd').innerHTML = data['itdtil'][0]['itcd'];

                        document.getElementById('itmNmTxb').value = data['itdtil'][0]['itnm'];
                        document.getElementById('itmCdTxb').value = data['itdtil'][0]['itcd'];

                        document.getElementById('itmBcde').value = res[0];

                        if (data['stkpric'].length > 0) {
                            var m = $('#dataTbItm').DataTable({
                                destroy: true,
                                searching: false,
                                bPaginate: false,
                                "ordering": false,
                                "columnDefs": [
                                    {className: "text-center", "targets": [3]},
                                    {className: "text-right", "targets": [0, 1, 2]},
                                    {className: "text-nowrap", "targets": [1]}
                                ],
                                "aoColumns": [
                                    {sWidth: '20%'},
                                    {sWidth: '20%'},
                                    {sWidth: '20%'},
                                    {sWidth: '5%'}
                                ],
                            });

                            m.clear().draw();
                            for (var a = 0; a < data['stkpric'].length; a++) {
                                m.row.add([
                                    numeral(data['stkpric'][a]['csvl']).format('0,0.00'),
                                    numeral(data['stkpric'][a]['dsvl']).format('0,0.00'),
                                    numeral(data['stkpric'][a]['slvl']).format('0,0.00'),
                                    "<input type='checkbox' id='chckBx_" + data['stkpric'][a]['sbid'] + "' " +
                                    "value='" + data['stkpric'][a]['sbid'] + "' class='icheck-minimal-red aax' onclick='loadSeril(this.id,this.value)' />",
                                ]).draw(false);
                            }
                        } else {
                            var m = $('#dataTbItm').DataTable({
                                destroy: true,
                                searching: false,
                                bPaginate: false,
                                "ordering": false,
                                "columnDefs": [
                                    {className: "text-center", "targets": [3]},
                                    {className: "text-right", "targets": [0, 1, 2]},
                                    {className: "text-nowrap", "targets": [1]}
                                ],
                                "aoColumns": [
                                    {sWidth: '20%'},
                                    {sWidth: '20%'},
                                    {sWidth: '20%'},
                                    {sWidth: '5%'}
                                ],
                            });
                            m.clear().draw();
                        }

                    } else {
                        swal({title: "", text: "No item this code", type: "info"},);
                        document.getElementById('brcd').style.borderColor = 'red';
                    }

                    var mm = $('#dataTbStck').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-center", "targets": [2]},
                            {className: "text-right", "targets": [0, 1]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '20%'},
                            {sWidth: '20%'},
                            {sWidth: '5%'}
                        ],
                    });
                    mm.clear().draw();
                },
                error: function () {
                }
            });
        }
    }

    // SEARCH ITEM DETAILS
    function loadSeril(ckbxid, stsbid) {

        //$("#ckbxid").prop("checked", true);

        if (document.getElementById(ckbxid).checked) {

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/getItmSubDetils",
                data: {
                    stsbid: stsbid,
                },
                dataType: 'json',
                success: function (data) {
                    if (data['seriDet'].length > 0) {

                        document.getElementById('itmStkid').value = stsbid;

                        var mm = $('#dataTbStck').DataTable({
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-center", "targets": [2]},
                                {className: "text-left", "targets": [0, 1]},
                                {className: "text-nowrap", "targets": [1]}
                            ],
                            "aoColumns": [
                                {sWidth: '20%'},
                                {sWidth: '20%'},
                                {sWidth: '5%'}
                            ],
                        });

                        var ttlDsvl = '';
                        $(" input[name='itSril[]']").each(function () {
                            if ($(" input[name='itSril[]']").length > 0) {
                                ttlDsvl = ttlDsvl + this.value + ',';
                            } else {
                                ttlDsvl = ttlDsvl + this.value;
                            }
                        });
                        // var ddx = [];
                        var ddx = ttlDsvl;
                        mm.clear().draw();
                        for (var a = 0; a < data['seriDet'].length; a++) {

                            if (jQuery.inArray(data['seriDet'][a]['dtid'], ddx) !== -1) {
                                //console.log('IN');
                            } else {
                                mm.row.add([
                                    data['seriDet'][a]['srno'], // + "<input type='text' name='isuItmId[]' value='" + data['seriDet'][a]['dtid'] + "' />"
                                    data['seriDet'][a]['btno'],
                                    "<input type='checkbox' id='isuItm_" + data['seriDet'][a]['dtid'] + "' value='" + data['seriDet'][a]['dtid'] + "' name='isuItm[]'  class='icheckbox_minimal chk' onclick='isuItmCunt(this.value)' />",
                                ]).draw(false);
                            }
                        }

                        document.getElementById('itmCshpr').value = data['itmPric'][0]['csvl']; // ITEM COST VALUE
                        document.getElementById('itmSlpr').value = data['itmPric'][0]['slvl'];  // ITEM SALES VALUE
                        document.getElementById('itmDspr').value = data['itmPric'][0]['dsvl'];  // ITEM DISPLY VALUE

                    } else {
                        swal({title: "", text: "No Stock Available..", type: "info"},);

                        var mm = $('#dataTbStck').DataTable({
                            destroy: true,
                            searching: false,
                            bPaginate: false,
                            "ordering": false,
                            "columnDefs": [
                                {className: "text-center", "targets": [2]},
                                {className: "text-left", "targets": [0, 1]},
                                {className: "text-nowrap", "targets": [1]}
                            ],
                            "aoColumns": [
                                {sWidth: '20%'},
                                {sWidth: '20%'},
                                {sWidth: '5%'}
                            ],
                        });
                        mm.clear().draw();
                    }
                },
                error: function () {
                }
            });
        } else {
            var mm = $('#dataTbStck').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-center", "targets": [2]},
                    {className: "text-right", "targets": [0, 1]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '20%'},
                    {sWidth: '20%'},
                    {sWidth: '5%'}
                ],
            });
            mm.clear().draw();
        }
    }

    // ADD ITEM BTN
    function cusNam(event) {
        if (event.keyCode == 13) {
            if ($("#addCrt").valid()) {
                //document.getElementById('divAditm').style.display = 'none';
                document.getElementById('divAditm').style.display = 'block';
            }
        }
    }

    // ADD ITEM ONCLICK
    $("#adItmBtn").click(function (e) { //  add form
        e.preventDefault();

        if ($("#addCrt").valid()) {
            //document.getElementById('divAditm').style.display = 'none';
            document.getElementById('divAditm').style.display = 'block';
        }
    });

    // ITEM ADD TO CART
    $("#addToCrt").click(function (e) { //  add form
        e.preventDefault();
        if ($("#addCrt").valid()) {
            //$('#modalAdd').modal('hide');

            document.getElementById('divAditm').style.display = 'none';
            document.getElementById('divOdrSumm').style.display = 'block';

            var m = $('#sumryTb').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "columnDefs": [
                    {className: "text-left", "targets": [0, 1]},
                    {className: "text-center", "targets": [7]},
                    {className: "text-right", "targets": [2, 3, 4, 5, 6]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '10%'},
                    {sWidth: '20%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'}
                ],
            });
            //m.clear().draw();

            var qty = document.getElementById('ttlItm').value;  // quenty
            var slprc = document.getElementById('itmSlpr').value;  // sales price
            var itmBcde = document.getElementById('itmBcde').value;  // Item Barcode

            var icde = document.getElementById('itmNmTxb').value;   // ITEM NAME
            var itnm = document.getElementById('itmCdTxb').value;   // ITEM CODE
            var dsvl = document.getElementById('itmDspr').value;   // ITEM DISPLY VALUE

            var stkid = document.getElementById('itmStkid').value;   // ITEM STOCK ID

            /* https://www.codexworld.com/how-to/get-selected-checkboxes-value-using-jquery/ */
            // Declare a checkbox array
            var chkArray = [];
            // Look for all checkboxes that have a specific class and was checked
            $(".chk:checked").each(function () {
                chkArray.push($(this).val());
            });
            // Join the array separated by the comma
            var selected;
            selected = chkArray.join(',');
            // Check if there are selected checkboxes
            /*if(selected.length > 0){
             alert("Selected checkboxes value: " + selected);
             }else{
             alert("Please select at least one checkbox.");
             }*/
            m.row.add([
                itmBcde + "<input type='hidden' id='addIcd[]' name='addIcd[]' value='" + itmBcde + "' />" + "<input type='hidden' id='stkid[]' name='stkid[]' value='" + stkid + "' />",
                icde + ' ' + itnm + "<input type='hidden' id='itSril[]' name='itSril[]' value='" + selected + "' />",
                numeral(dsvl).format('0,0.00') + "<input type='hidden' id='itDsvl[]' name='itDsvl[]' value='" + dsvl + "' />",
                numeral(+dsvl - +slprc).format('0,0.00') + "<input type='hidden' id='itDisc[]' name='itDisc[]' value='" + (+dsvl - +slprc) + "' />",
                numeral(slprc).format('0,0.00') + "<input type='hidden' id='itSlvl[]' name='itSlvl[]' value='" + slprc + "' />",
                qty + "<input type='hidden' id='itAdqt[]' name='itAdqt[]' value='" + qty + "' />",
                numeral(+qty * +slprc).format('0,0.00') + "<input type='hidden' id='itSbvl[]' name='itSbvl[]' value='" + (+qty * +slprc) + "' />",
                "<button type='button' class='btn-xs btn-danger' id='dltrw' onclick=''><span><i class='fa fa-close' title='Remove'></i></span></button>",
            ]).draw(false);

            calTtl();
            clerData();
        }
    });

    // TABLE DATA REMOVE
    $('#sumryTb tbody').on('click', '#dltrw', function () {
        var table = $('#sumryTb').DataTable();
        table
            .row($(this).parents('tr'))
            .remove()
            .draw();
        calTtl();
    });

    // CAL TOTAL
    function calTtl() {
        var ttlDsvl = 0;
        var ttlDisc = 0;
        var ttlSlvl = 0;
        var ttlQuty = 0;
        var ttlSub = 0;

        $(" input[name='itDsvl[]']").each(function () {
            ttlDsvl = ttlDsvl + +this.value;
        });
        $(" input[name='itSlvl[]']").each(function () {
            ttlSlvl = ttlSlvl + +this.value;
        });
        $(" input[name='itAdqt[]']").each(function () {
            ttlQuty = ttlQuty + +this.value;
        });
        $(" input[name='itSbvl[]']").each(function () {
            ttlSub = ttlSub + +this.value;
        });
        $(" input[name='itDisc[]']").each(function () {
            ttlDisc = ttlDisc + +this.value;
        });

        //document.getElementById('ttlDsvl').innerHTML = ttlQt;
        document.getElementById('ttlDsvl').innerHTML = numeral(ttlDsvl).format('0,0.00');
        document.getElementById('ttlSlvl').innerHTML = numeral(ttlSlvl).format('0,0.00');
        document.getElementById('ttlQuty').innerHTML = ttlQuty;
        document.getElementById('ttlSub').innerHTML = numeral(ttlSub).format('0,0.00');
        document.getElementById('ttlDisc').innerHTML = numeral(ttlDisc).format('0,0.00');

        //document.getElementById('ttlDsvlHd').value = ttlDsvl;
        //document.getElementById('ttlSlvlHd').value = ttlSlvl;
        document.getElementById('ttlQutyHd').value = ttlQuty;
        document.getElementById('ttlSubHd').value = ttlSub;
        document.getElementById('ttlDiscHd').value = ttlDisc;

        //console.log(' ttlDsvl ' + ttlDsvl + ' ttlSlvl ' + ttlSlvl + ' ttlQuty ' + ttlQuty);
    }

    // CLEAR DATA
    function clerData() {

        document.getElementById('itnm').value = '';
        document.getElementById('itmSlpr').value = '';
        document.getElementById('qunty').value = '';

        document.getElementById('itbcd').innerHTML = '-';
        document.getElementById('itmNm').innerHTML = '-';
        document.getElementById('itmCd').innerHTML = '-';

        var m = $('#dataTbItm').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
            "columnDefs": [
                {className: "text-center", "targets": [3]},
                {className: "text-right", "targets": [0, 1, 2]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '20%'},
                {sWidth: '20%'},
                {sWidth: '20%'},
                {sWidth: '5%'}
            ],
        });
        m.clear().draw();

        var mm = $('#dataTbStck').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
            "columnDefs": [
                {className: "text-center", "targets": [2]},
                {className: "text-right", "targets": [0, 1]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '20%'},
                {sWidth: '20%'},
                {sWidth: '5%'}
            ],
        });
        mm.clear().draw();

    }

    // ISSUE ITEM COUNT
    function isuItmCunt() {
        var ttlQt = 0;
        var ttlSub = 0;
        //$(" input[name='isuItm[]']").each(function () {
        //ttlQt =  $('[name="isuItm[]"]:checked').length;
        //ttlQt = ttlQt + +this.value;
        //});
        ttlQt = $('[name="isuItm[]"]:checked').length;
        //console.log(ttlQt);
        document.getElementById('ttlItm').value = ttlQt;
        //$("#qunty").val = ttlQt;
        $("#qunty").val(ttlQt);
    }

    // INVOICE SUBMIT
    $("#PrntBtn").click(function (e) {
        e.preventDefault();

        if ($("#addCrt").valid()) {
            swal({
                    title: "Are you sure process",
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
                        //$('#modalEdt').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/addInvoice",
                            data: $("#addCrt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                var auid = data;
                                console.log(auid);
                                swal({
                                        title: "",
                                        text: " Invoice Process Success.",
                                        type: "success",
                                        timer: 1000},
                                    function () {
                                        window.open('<?= base_url(); ?>user/invoicPrint/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
                                        //srchVou();
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Process failed", type: "error"},
                                    function () {
                                        // location.reload();
                                    });
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

</script>

</html>
