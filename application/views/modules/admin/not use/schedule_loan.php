<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>System Schedule</li>
    <li class="active">Loan Schedule</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Schedule </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add New
                        </button>
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchLnSche()"
                                            class='btn-sm btn-primary panel-refresh'>
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbloan" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">branch</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">loan no</th>
                                            <th class="text-center">Holiday reason</th>
                                            <th class="text-center">create by</th>
                                            <th class="text-center">create date</th>
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

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create Loan Holiday</h4>
            </div>
            <form class="form-horizontal" id="hlydy_add" name="hlydy_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Customer Details</h3>
                                        <div class="col-md-12">
                                            <div class="col-md-4" id="srchDiv">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="lnno"
                                                               name="lnno" placeholder="Enter Loan No" autofocus/>
                                                        <span class="input-group-btn">
                                                            <button class="btn btn-primary panel-refresh" id="srchLoan">                                                    Search                                                </button>                                            </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6" id="cusDtilsDiv" style="display: none">
                                                <table width="700" border="0" cellpadding="0" cellspacing="0" id="tr1">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4"><a class="popup" id="uimgA"
                                                                                       target="_blank"
                                                                                       href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                                       title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                     class="img-circle img-thumbnail" alt="" id="uimg"
                                                                     width="100" height="100"></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2"><strong id="init"></strong></td>
                                                        <td><strong>Branch :</strong> &nbsp;&nbsp;<span
                                                                    id="brnm"></span></td>
                                                        <td><strong>Group No :</strong> &nbsp;&nbsp;<span
                                                                    id="grno"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="cuno"></span></td>
                                                        <td width="148">NIC: <strong><span id="anic"></span></strong>
                                                        </td>
                                                        <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span
                                                                    id="cntr"></span>
                                                        </td>
                                                        <td width="148"><strong>Type :</strong> &nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="hoad"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="mobi"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4">
                                                            <div class="table-responsive">
                                                                <table width="100%"
                                                                       class="table table-bordered table-striped ">
                                                                    <thead>
                                                                    <tr>
                                                                        <th colspan="4" class="text-center"><strong>FACILITY
                                                                                DETAILS</strong>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr id="trow_1">
                                                                        <td width="25%" class="text-left">Facility No
                                                                        </td>
                                                                        <td width="25%"><span id="acno"></span></td>
                                                                        <td width="25%">Product</td>
                                                                        <td width="25%"><span id="prcd"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_2">
                                                                        <td>Facility Date</td>
                                                                        <td><span id="indt"></span></td>
                                                                        <td>Maturity Date</td>
                                                                        <td><span id="mddt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_3">
                                                                        <td>Amount</td>
                                                                        <td><span id="loam"></span></td>
                                                                        <td>Premium</td>
                                                                        <td><span id="inst"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_4">
                                                                        <td>Settlement Today</td>
                                                                        <td><span id="tdst"></span></td>
                                                                        <td>Status</td>
                                                                        <td><span id="stmt"></span></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <label class="col-md-4 control-label ">
                                                                    <a id="mrdt" href="" target="_blank"
                                                                       style="color: red"> More Details... </a> </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="lnid" name="lnid">
                                    <input type="hidden" id="brnc" name="brnc">

                                    <div class="row" id="cmntDiv">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Schedule Details</h3>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Date</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="hldt"
                                                               value="<?= date('Y-m-d') ?>" id="hldt"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-8 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk" placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="addHolydy">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  Edit  -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="holydy_edt" name="holydy_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Customer Details</h3>
                                        <div class="col-md-12">

                                            <div class="col-md-6" id="cusDtilsDiv">
                                                <table width="700" border="0" cellpadding="0" cellspacing="0" id="tr1">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4"><a class="popup" id="uimgA_edt"
                                                                                       target="_blank"
                                                                                       href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                                       title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                     class="img-circle img-thumbnail" alt="" id="uimg_edt"
                                                                     width="100" height="100"></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2"><strong id="init_edt"></strong></td>
                                                        <td><strong>Branch :</strong> &nbsp;&nbsp;<span
                                                                    id="brnm_edt"></span></td>
                                                        <td><strong>Group No :</strong> &nbsp;&nbsp;<span
                                                                    id="grno_edt"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="cuno_edt"></span></td>
                                                        <td width="148">NIC: <strong><span id="anic_edt"></span></strong>
                                                        </td>
                                                        <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span
                                                                    id="cntr_edt"></span>
                                                        </td>
                                                        <td width="148"><strong>Type :</strong> &nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="hoad_edt"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="mobi_edt"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4">
                                                            <div class="table-responsive">
                                                                <table width="100%"
                                                                       class="table table-bordered table-striped ">
                                                                    <thead>
                                                                    <tr>
                                                                        <th colspan="4" class="text-center"><strong>FACILITY
                                                                                DETAILS</strong>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr id="trow_1">
                                                                        <td width="25%" class="text-left">Facility No
                                                                        </td>
                                                                        <td width="25%"><span id="acno_edt"></span></td>
                                                                        <td width="25%">Product</td>
                                                                        <td width="25%"><span id="prcd_edt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_2">
                                                                        <td>Facility Date</td>
                                                                        <td><span id="indt_edt"></span></td>
                                                                        <td>Maturity Date</td>
                                                                        <td><span id="mddt_edt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_3">
                                                                        <td>Amount</td>
                                                                        <td><span id="loam_edt"></span></td>
                                                                        <td>Premium</td>
                                                                        <td><span id="inst_edt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_4">
                                                                        <td>Settlement Today</td>
                                                                        <td><span id="tdst_edt"></span></td>
                                                                        <td>Status</td>
                                                                        <td><span id="stmt_edt"></span></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <label class="col-md-4 control-label ">
                                                                    <a id="mrdt" href="" target="_blank"
                                                                       style="color: red"> More Details... </a> </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="auid" name="auid">
                                    <input type="hidden" id="brnc" name="brnc">
                                    <input type="hidden" id="hoid" name="hoid">
                                    <input type="hidden" id="func" name="func">

                                    <div class="row" id="cmntDiv">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Schedule Details</h3>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Date</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker" name="hldt_edt"
                                                               value="<?= date('Y-m-d') ?>" id="hldt_edt" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Remarks</label>
                                                <div class="col-md-8 ">
                                                    <textarea class="form-control" rows="4" id="remk_edt"
                                                              name="remk_edt" placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Model -->


<script>
    $().ready(function () {

        srchLnSche();

        $("#hlydy_add").validate({  //  ADD VALIDATE
            rules: {
                lnno: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_lnnoSche",
                        type: "post",
                        data: {
                            lnno: function () {
                                return $("#lnno").val();
                            },
                        }
                    },
                },
                hldt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnSche",
                        type: "post",
                        data: {
                            hldt: function () {
                                return $("#hldt").val();
                            },
                            brn: function () {
                                return $("#brn").val();
                            }
                        }
                    },
                    minDate: true
                },
                remk: {
                    required: true,
                },

            },
            messages: {
                hldt: {
                    required: 'Please enter system holiday',
                    remote: 'System holiday already exists  '
                },
                brn: {
                    required: 'Please Select Branch',
                    notEqual: 'Please Select Branch  '
                }
            }
        });

        $("#holydy_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                hldt_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_brnSche_edt",
                        type: "post",
                        data: {
                            hldt_edt: function () {
                                return $("#hldt_edt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            },
                            brn: function () {
                                return $("#brn").val();
                            }
                        }
                    }
                },
                remk_edt: {
                    required: true,
                }
            },
            messages: {
                hldt_edt: {
                    required: 'Please enter system holiday',
                    remote: 'System holiday already exists  '
                }
            }
        });

    });

    // SEARCH LOAN HOLIDAY LIST
    function srchLnSche() {

        var brn = document.getElementById("brch").value;
        if (brn == 0) {
            document.getElementById("brch").style.borderColor = "red";
        } else {
            document.getElementById("brch").style.borderColor = "";

            $('#dataTbloan').DataTable().clear();
            $('#dataTbloan').DataTable({
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
                // "serverSide": true,
                "columnDefs": [
                    {className: "text-left", "targets": [1, 2, 4]},
                    {className: "text-center", "targets": [0, 3, 5, 6, 7, 8]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[4, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/srchLonHolydy',
                    type: 'post',
                    data: {
                        brn: brn
                    }
                }
            });
        }
    }

    // LOAD CUSTOMER DETAILS
    $("#srchLoan").on('click', function (e) { // add form
        e.preventDefault();
        var lnno = document.getElementById("lnno").value;

        $.ajax({
            url: '<?= base_url(); ?>user/vewCustStlDtils',
            type: 'POST',
            data: {
                lnno: lnno
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len > 0) {
                    document.getElementById("cusDtilsDiv").style.display = 'block';
                    document.getElementById("srchDiv").style.display = 'none';
                    document.getElementById("cmntDiv").style.display = 'block';

                    document.getElementById("init").innerHTML = response[0]['sode'] + response[0]['init'];
                    document.getElementById("brnm").innerHTML = response[0]['brnm'];
                    document.getElementById("grno").innerHTML = response[0]['grno'];
                    document.getElementById("cuno").innerHTML = response[0]['cuno'];
                    document.getElementById("anic").innerHTML = response[0]['anic'];
                    document.getElementById("cntr").innerHTML = response[0]['cnnm'];
                    document.getElementById("hoad").innerHTML = response[0]['hoad'];
                    document.getElementById("mobi").innerHTML = response[0]['mobi'];

                    document.getElementById("acno").innerHTML = response[0]['acno'];
                    document.getElementById("prcd").innerHTML = '(' + response[0]['prcd'] + ') ' + response[0]['prnm'];
                    document.getElementById("indt").innerHTML = response[0]['indt'];
                    document.getElementById("mddt").innerHTML = response[0]['mddt'];
                    document.getElementById("loam").innerHTML = numeral(response[0]['loam']).format('0,0.00');
                    document.getElementById("inst").innerHTML = numeral(response[0]['inam']).format('0,0.00') + ' x ' + response[0]['noin'];
                    var setVal = ((+response[0]['boc'] + +response[0]['boi'] + +response[0]['aboc'] + +response[0]['aboi'] + +response[0]['avpe']) - +response[0]['avcr']);
                    document.getElementById("tdst").innerHTML = numeral(setVal).format('0,0.00');
                    document.getElementById("stmt").innerHTML = response[0]['nxpn'] + ' of ' + response[0]['noin'];

                    document.getElementById('uimg').src = "../uploads/cust_profile/" + response[0]['uimg'];
                    document.getElementById("uimgA").setAttribute("href", "../uploads/cust_profile/" + response[0]['uimg']);
                    document.getElementById("lnid").value = response[0]['lnid'];
                    document.getElementById("brnc").value = response[0]['brco'];
                    document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['acno']);

                } else {
                    document.getElementById("cusDtilsDiv").style.display = 'none';
                    document.getElementById("cmntDiv").style.display = 'none';
                    swal({title: "", text: "Invalide Running Loan", type: "warning"});
                }
            },
        });
    });
    // ADD LOAN HOLIDAY
    $("#addHolydy").click(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#hlydy_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addLoanHolydy",
                data: $("#hlydy_add").serialize(),
                dataType: 'json',
                success: function (data) {

                    $('#modalAdd').modal('hide');
                    swal({title: "", text: "Loan holiday added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Loan holiday added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });
    // EDIT VIEW LOAN HOLIDAY

    function edtHolydt(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Holidays");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Relationship");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewHolydyLon",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len > 0) {
                    document.getElementById("hldt_edt").value = response[0]['date'];
                    document.getElementById("remk_edt").value = response[0]['hors'];
                    document.getElementById("auid").value = response[0]['hoid'];

//                    document.getElementById("cusDtilsDiv").style.display = 'block';
//                    document.getElementById("srchDiv").style.display = 'none';
//                    document.getElementById("cmntDiv").style.display = 'block';

                    document.getElementById("init_edt").innerHTML = response[0]['sode'] + response[0]['init'];
                    document.getElementById("brnm_edt").innerHTML = response[0]['brnm'];
                    document.getElementById("grno_edt").innerHTML = response[0]['grno'];
                    document.getElementById("cuno_edt").innerHTML = response[0]['cuno'];
                    document.getElementById("anic_edt").innerHTML = response[0]['anic'];
                    document.getElementById("cntr_edt").innerHTML = response[0]['cnnm'];
                    document.getElementById("hoad_edt").innerHTML = response[0]['hoad'];
                    document.getElementById("mobi_edt").innerHTML = response[0]['mobi'];

                    document.getElementById("acno_edt").innerHTML = response[0]['acno'];
                    document.getElementById("prcd_edt").innerHTML = '(' + response[0]['prcd'] + ') ' + response[0]['prnm'];
                    document.getElementById("indt_edt").innerHTML = response[0]['indt'];
                    document.getElementById("mddt_edt").innerHTML = response[0]['mddt'];
                    document.getElementById("loam_edt").innerHTML = numeral(response[0]['loam']).format('0,0.00');
                    document.getElementById("inst_edt").innerHTML = numeral(response[0]['inam']).format('0,0.00') + ' x ' + response[0]['noin'];
                    var setVal = ((+response[0]['boc'] + +response[0]['boi'] + +response[0]['aboc'] + +response[0]['aboi'] + +response[0]['avpe']) - +response[0]['avcr']);
                    document.getElementById("tdst_edt").innerHTML = numeral(setVal).format('0,0.00');
                    document.getElementById("stmt_edt").innerHTML = response[0]['nxpn'] + ' of ' + response[0]['noin'];

                    document.getElementById('uimg_edt').src = "../uploads/cust_profile/" + response[0]['uimg'];
                    document.getElementById("uimgA_edt").setAttribute("href", "../uploads/cust_profile/" + response[0]['uimg']);
                    //document.getElementById("lnid_edt").value = response[0]['lnid'];
                    //document.getElementById("brnc_edt").value = response[0]['brco'];
                    document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['acno']);

                } else {
                    document.getElementById("cusDtilsDiv").style.display = 'none';
                    document.getElementById("cmntDiv").style.display = 'none';
                    swal({title: "", text: "Invalide Running Loan", type: "warning"});
                }
            }
        })
    }
    // EDIT SUBMIT LOAN HOLIDAY
    $("#holydy_edt").submit(function (e) {
        e.preventDefault();

        if ($("#holydy_edt").valid()) {
            swal({
                    title: "Are you sure ",
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
                            url: "<?= base_url(); ?>admin/edtHolydays",
                            data: $("#holydy_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "Loan holiday update success", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    // REJECT LOAN HOLIDAY
    function rejecHolyLoan(id) {
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
                        url: '<?= base_url(); ?>admin/rejLoanHolidy',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                swal({title: "Loan holiday inactive success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Loan holiday not inactive", "error");
                }
            });
    }

    function reactvHolydy(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process",
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
                        url: '<?= base_url(); ?>admin/reactHolyday',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                swal({title: "", text: "Holiday reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












