<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Loan Termination</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Termination </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" onclick="addTermLn()"
                                data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Termination
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
                                            onchange="getExe(this.value,'exc',exc.value,'cen');chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <!--<div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <?php
                            /*                                        foreach ($stainfo as $stat) {
                                                                        echo "<option value='$stat->stid'>$stat->stnm</option>";
                                                                    }
                                                                    */ ?>
                                    </select>
                                </div>
                            </div>-->
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
                                    <button type="button form-control  " onclick="srchTrmiLoan()"
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
                                           id="dataTbLoan" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH / CENTER</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CUSTOMER NO</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">LOAN AMNT</th>
                                            <th class="text-center">CURNT BAL</th>
                                            <th class="text-center">RQS BY</th>
                                            <th class="text-center">RQS DATE</th>
                                            <th class="text-center">MODE</th>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Loan Termination</h4>
            </div>
            <form class="form-horizontal" id="loan_trmintion" name="loan_trmintion"
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

                                    <div class="row" id="cmntDiv" style="display: none">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Requested Comment</h3>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="4" id="remk"
                                                                  name="remk"></textarea>
                                                    </div>
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
                    <button type="submit" class="btn btn-success" id="addTrm" disabled>Requested</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  view & approval  -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="trmiLoan_app" name="trmiLoan_app"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Customer Details</h3>
                                        <div class="col-md-12">
                                            <div class="col-md-6" id="cusDtilsDiv_app" style="display: none">
                                                <table width="700" border="0" cellpadding="0" cellspacing="0" id="tr1">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4"><a class="popup" id="uimgA_app"
                                                                                       target="_blank"
                                                                                       href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                                       title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="uimg_app"
                                                                     width="100" height="100"></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2"><strong id="init_app"></strong></td>
                                                        <td><strong>Branch :</strong> &nbsp;&nbsp;<span
                                                                    id="brnm_app"></span></td>
                                                        <td><strong>Group No :</strong> &nbsp;&nbsp;<span
                                                                    id="grno_app"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="cuno_app"></span></td>
                                                        <td width="148">NIC: <strong><span
                                                                        id="anic_app"></span></strong>
                                                        </td>
                                                        <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span
                                                                    id="cntr_app"></span>
                                                        </td>
                                                        <td width="148"><strong>Type :</strong> &nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="hoad_app"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="mobi_app"></span></td>
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
                                                                        <td width="25%"><span id="acno_app"></span></td>
                                                                        <td width="25%">Product</td>
                                                                        <td width="25%"><span id="prcd_app"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_2">
                                                                        <td>Facility Date</td>
                                                                        <td><span id="indt_app"></span></td>
                                                                        <td>Maturity Date</td>
                                                                        <td><span id="mddt_app"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_3">
                                                                        <td>Amount</td>
                                                                        <td><span id="loam_app"></span></td>
                                                                        <td>Premium</td>
                                                                        <td><span id="inst_app"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_4">
                                                                        <td>Settlement Today</td>
                                                                        <td><span id="tdst_app"></span></td>
                                                                        <td>Status</td>
                                                                        <td><span id="stmt_app"></span></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                                <label class="col-md-4 control-label ">
                                                                    <a id="mrdt_app" href="" target="_blank"
                                                                       style="color: red"> More Details... </a> </label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="auid_app" name="auid_app">
                                    <input type="hidden" id="func" name="func">
                                    <input type="hidden" id="lnid_app" name="lnid_app">

                                    <div class="row" id="cmntDiv_rqs">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Requested Comment</h3>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="4" id="remk_rqs" readonly
                                                                  name="remk_rqs"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="cmntDiv_app" style="display: none;">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Approval Comment</h3>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="4" id="remk_app"
                                                                  name="remk_app"></textarea>
                                                    </div>
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
        // Data Tables
        $('#dataTbLoan').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $("#loan_trmintion").validate({  // validation
            rules: {
                lnno: {
                    required: true,
                    minlength: 19,
                    maxlength: 19
                },
                remk: {
                    required: true,
                },
            },
            messages: {
                lnno: {
                    required: 'Please select Branch',
                    minlength: "Please Enter Valid Loan No",
                    maxlength: "Please Enter Valid Loan No"
                },
                remk: {
                    required: 'Please Enter Comment',
                },
            }
        });


        $("#trmiLoan_app").validate({  // BRANCH EDIT VALIDATE
            rules: {
                remk_app: {
                    required: true,
                    notEqual: '0'
                }
            },
            messages: {
                remk_app: {
                    required: 'Please Enter Comment',
                }
            }
        });

        srchTrmiLoan();

    });

    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // SEARCH TERMINATION LOAN
    function srchTrmiLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        //var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbLoan').DataTable().clear();
            $('#dataTbLoan').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 7]},
                    {className: "text-center", "targets": [0, 7, 9, 10]},
                    {className: "text-right", "targets": [5, 6]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                //"order": [[3, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/getTrmiLn',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        //stat: stat
                    }
                }
            });
        }
    }

    // ADD TERMINATION BTN CLICK
    function addTermLn() {
        document.getElementById("cusDtilsDiv").style.display = 'none';
        document.getElementById("srchDiv").style.display = 'block';
        document.getElementById("cmntDiv").style.display = 'none';
    }

    // LOAD CUSTOMER DETAILS
    $("#srchLoan").on('click', function (e) { // add form
        e.preventDefault();

        var lnno = document.getElementById("lnno").value;
        if ($("#loan_trmintion").valid()) {

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
                        //document.getElementById("process_btn").style.display = 'block';
                        document.getElementById("cmntDiv").style.display = 'block';
                        document.getElementById("addTrm").disabled = false;

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
                       // var setVal = ((+response[0]['boc'] + +response[0]['boi'] + +response[0]['avpe']) - +response[0]['avcr']);
                        var setVal = (+response[0]['loam'] + +response[0]['inta'] + +response[0]['dpet'] + +response[0]['schg']) - +response[0]['ramt'];
                        document.getElementById("tdst").innerHTML = numeral(setVal).format('0,0.00');
                        document.getElementById("stmt").innerHTML = response[0]['nxpn'] + ' of ' + response[0]['noin'];

                        document.getElementById('uimg').src = "../uploads/cust_profile/" + response[0]['uimg'];
                        document.getElementById("uimgA").setAttribute("href", "../uploads/cust_profile/" + response[0]['uimg']);
                        document.getElementById("lnid").value = response[0]['lnid'];
                        document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['acno']);

                    } else {
                        document.getElementById("cusDtilsDiv").style.display = 'none';
                        document.getElementById("cmntDiv").style.display = 'none';
                        document.getElementById("addTrm").disabled = true;

                        document.getElementById("addTrm").style.display = 'none';
                        swal({title: "", text: "Invalide Running Loan", type: "warning"});
                    }
                },
            });

        } else {
            //  alert("Error");
        }
    });

    // ADD LOAN TERMINATION
    $("#loan_trmintion").submit(function (e) {
        e.preventDefault();

        if ($("#loan_trmintion").valid()) {
            swal({
                    title: "Are you sure..",
                    text: "This loan Termination requested",
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

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/addTermiLoan",
                            data: $("#loan_trmintion").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                $('#modalAdd').modal('hide');
                                swal({title: "", text: "Loan termination requested success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Loan termination requested failed", type: "error"},
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

    // VIEW & APPROVAL TERMINATION LOAN
    function appViwTermiLon(auid, func) {
        if (func == 'viw') {
            $('#hed').text("View Termination Loan");

            document.getElementById("subBtn").setAttribute("class", "hidden");
            document.getElementById("func").value = 1;
            document.getElementById("cmntDiv_app").style.display = 'none';

        } else if (func == 'app') {
            $('#hed').text("Approval Termination Loan");
            $('#btnNm').text("Approval");

            document.getElementById("subBtn").setAttribute("class", "btn btn-success");
            document.getElementById("func").value = 2;
            document.getElementById("cmntDiv_app").style.display = 'block';
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewTrmiLoanDtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {

                document.getElementById("cusDtilsDiv_app").style.display = 'block';

                document.getElementById("init_app").innerHTML = response[0]['sode'] + response[0]['init'];
                document.getElementById("brnm_app").innerHTML = response[0]['brnm'];
                document.getElementById("grno_app").innerHTML = response[0]['grno'];
                document.getElementById("cuno_app").innerHTML = response[0]['cuno'];
                document.getElementById("anic_app").innerHTML = response[0]['anic'];
                document.getElementById("cntr_app").innerHTML = response[0]['cnnm'];
                document.getElementById("hoad_app").innerHTML = response[0]['hoad'];
                document.getElementById("mobi_app").innerHTML = response[0]['mobi'];

                document.getElementById("acno_app").innerHTML = response[0]['acno'];
                document.getElementById("prcd_app").innerHTML = '(' + response[0]['prcd'] + ') ' + response[0]['prnm'];
                document.getElementById("indt_app").innerHTML = response[0]['indt'];
                document.getElementById("mddt_app").innerHTML = response[0]['mddt'];
                document.getElementById("loam_app").innerHTML = numeral(response[0]['loam']).format('0,0.00');
                document.getElementById("inst_app").innerHTML = numeral(response[0]['inam']).format('0,0.00') + ' x ' + response[0]['noin'];
               // var setVal = ((+response[0]['boc'] + +response[0]['boi'] + +response[0]['aboc'] + +response[0]['aboi'] + +response[0]['avpe']) -  +response[0]['avcr']);
                var setVal = (+response[0]['loam'] + +response[0]['inta'] + +response[0]['dpet'] + +response[0]['schg']) - +response[0]['ramt'];
                document.getElementById("tdst_app").innerHTML = numeral(setVal).format('0,0.00');
                document.getElementById("stmt_app").innerHTML = response[0]['nxpn'] + ' of ' + response[0]['noin'];

                document.getElementById('uimg_app').src = "../uploads/cust_profile/" + response[0]['uimg'];
                document.getElementById("uimgA_app").setAttribute("href", "../uploads/cust_profile/" + response[0]['uimg']);
                document.getElementById("mrdt_app").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['acno']);

                document.getElementById("remk_rqs").value = response[0]['rqmk'];
                document.getElementById("auid_app").value = response[0]['trid'];
                document.getElementById("lnid_app").value = response[0]['lnid'];

                if(response[0]['stat'] == 1){
                    document.getElementById("cmntDiv_app").style.display = 'block';
                    document.getElementById("remk_app").value = response[0]['apmk'];
                    document.getElementById("remk_app").readOnly  = true;
                }else{
                    //document.getElementById("cmntDiv_app").style.display = 'none';
                    document.getElementById("remk_app").value = '';
                    document.getElementById("remk_app").readOnly  = false;
                }
            }
        })
    }

    // APPROVAL SUBMIT
    $("#trmiLoan_app").submit(function (e) {
        e.preventDefault();

        if ($("#trmiLoan_app").valid()) {
            swal({
                    title: "Are you sure Loan Termination..",
                    text: "Your will not be able to recover this process",
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
                        $('#modalView').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/loanTerminApp",
                            data: $("#trmiLoan_app").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchTrmiLoan();
                                swal({title: "", text: "Cash deposit process success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Cash deposit Process failed", type: "error"},
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

    // TERMINATION CANCEL
    function rejecCshDep(id) {
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
                        url: '<?= base_url(); ?>user/rejecCshDep',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChbk();
                                swal({title: "Cash Deposit Reject success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Cheque book not Inactive", "error");
                }
            });
    }

    function reactvChqbk(id) {
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
                        url: '<?= base_url(); ?>user/reactChqbk',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchChbk();
                                swal({title: "", text: "Cheque book reactive success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process cancelled!", "", "error");
                }
            });
    }

</script>












