<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Loan Penalty Remove</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Penalty Remove</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h3 class="text-title"><span class="fa fa-user"></span> Customer Details</h3>
                        <div class="col-md-12">
                            <div class="col-md-4">
                                <form class="form-horizontal" action="" method="post" name="srcLoan" id="srcLoan">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="lnno" name="lnno"
                                                   placeholder="Enter Loan No" autofocus/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary panel-refresh" id="srchLoan">
                                                    Search
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6" id="cusDtilsDiv" style="display: none">
                                <table width="700" border="0" cellpadding="0" cellspacing="0" id="tr1">
                                    <tbody>
                                    <tr>
                                        <td width="101" rowspan="4"><a class="popup" id="uimgA" target="_blank"
                                                                       href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                       title="Click here to see the image..">
                                                <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                     class="img-circle img-thumbnail" alt="" id="uimg"
                                                     width="100" height="100"></a></td>
                                        <td width="10">&nbsp;</td>
                                        <td colspan="2"><strong id="init"></strong></td>
                                        <td><strong>Branch :</strong> &nbsp;&nbsp;<span id="brnm"></span></td>
                                        <td><strong>Group No :</strong> &nbsp;&nbsp;<span id="grno"></span></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td width="118"><span id="cuno"></span></td>
                                        <td width="148">NIC: <strong><span id="anic"></span></strong></td>
                                        <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span id="cntr"></span>
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
                                                <table width="100%" class="table table-bordered table-striped ">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="4" class="text-center"><strong>FACILITY
                                                                DETAILS</strong>
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr id="trow_1">
                                                        <td width="25%" class="text-left">Facility No</td>
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
                                                    <tr id="trow_5">
                                                        <td style="color: red">Penalty</td>
                                                        <td style="color: red"><span id="pnty"></span></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <label class="col-md-4 control-label ">
                                                    <a id="mrdt" href="" target="_blank" style="color: red"> More
                                                        Details... </a> </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> Remove Penalty </h3>

                        <form class="form-horizontal" id="loan_stl" name="loan_stl" action="" method="post">
                            <div class="panel-body form-horizontal">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Remove Date</label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control" id="pydt"
                                                   placeholder="Pay Date" name="pydt" value="<?= date('Y-m-d') ?>"
                                                   readonly/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Remove Branch</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="brch" id="brch"
                                                    onchange="chckBtn(this.value,'brch')">
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
                                        <label class="col-md-4  col-xs-6 control-label">Rebate For Penalty </label>
                                        <div class="col-md-2 col-xs-12">
                                            <label class="switch switch-small">
                                                <input id="rbt" name="rbt" type="checkbox" value="1"
                                                       onchange="rbtTyp()"/>No
                                                <span></span>
                                            </label> Yes
                                        </div>
                                        <div class="col-md-2 col-xs-12" id="rbtTyp" style="display: none">
                                            <label class="switch switch-small">
                                                <input id="rbtp" name="rbtp" type="checkbox" value="1"
                                                       checked onchange="rbtCal()"/> %
                                                <span></span>
                                            </label> Rs.
                                        </div>
                                        <div class="col-md-2 col-xs-12" id="rbtVal" style="display: none">
                                                <span id="rbdv" style="display: inline-block;">
                                                <input type="text" class="form-control" placeholder="Rebate"
                                                       id="rbmt" name="rbmt" onkeyup="rbtCal()">
                                                </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Remove Amount</label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control" id="pyamt"
                                                   placeholder="Payment Amount" readonly
                                                   name="pyamt"/>
                                        </div>
                                        <input type="hidden" id="lnid" name="lnid">
                                        <input type="hidden" id="amut" name="amut">
                                    </div>

                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="button" id="process_btn" class="btn btn-success pull-right">Process
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->

</body>

<script>

    $().ready(function () {

        $("#loan_stl").validate({  // validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                rbmt: {
                    required: true,
                    notEqual: '0',
                    number: true
                },
                pytp: {
                    required: true,
                    notEqual: '0'
                },
                pyamt: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                brch: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                rbmt: {
                    required: 'Please enter Value',
                    notEqual: "Please enter Value"
                },
                pytp: {
                    required: 'Please select Pay Type',
                    notEqual: "Please select Pay Type"
                },
                pyamt: {
                    required: 'Please enter value ',
                    notEqual: "Please enter value"
                },
            }
        });

        $("#srcLoan").validate({  // validation
            rules: {
                lnno: {
                    required: true,
                    minlength: 19,
                    maxlength: 19
                }
            },
            messages: {
                lnno: {
                    required: 'Please select Branch',
                    minlength: "Please Enter Valid Loan No",
                    maxlength: "Please Enter Valid Loan No"
                }
            }
        });

        document.getElementById("process_btn").style.display = 'none';

    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // LOAD CUSTOMER DETAILS
    $("#srchLoan").on('click', function (e) { // add form
        e.preventDefault();

        var lnno = document.getElementById("lnno").value;
        if ($("#srcLoan").valid()) {

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
                        document.getElementById("process_btn").style.display = 'block';

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
                        var setVal = (+response[0]['loam'] + +response[0]['inta'] + +response[0]['dpet'] + +response[0]['schg']) - +response[0]['ramt'];
                        document.getElementById("tdst").innerHTML = numeral(setVal).format('0,0.00');
                        document.getElementById("stmt").innerHTML = response[0]['nxpn'] + ' of ' + response[0]['noin'];
                        document.getElementById("pnty").innerHTML = numeral(response[0]['avpe']).format('0,0.00');

                        document.getElementById('uimg').src = "../uploads/cust_profile/" + response[0]['uimg'];
                        document.getElementById("uimgA").setAttribute("href", "../uploads/cust_profile/" + response[0]['uimg']);
                        document.getElementById("lnid").value = response[0]['lnid'];
                        document.getElementById("pyamt").value = response[0]['avpe'];
                        document.getElementById("amut").value = response[0]['avpe'];

                        document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['acno']);

                        if(response[0]['avpe'] <= 0 ){ // IF PENELTY <= 0 ; PROCESS BTN SHOW HIDE
                            document.getElementById("process_btn").style.display = 'none';
                        }else{
                            document.getElementById("process_btn").style.display = 'block';
                        }
                    } else {
                        document.getElementById("cusDtilsDiv").style.display = 'none';

                        document.getElementById("process_btn").style.display = 'none';
                        swal({title: "", text: "Invalide Running Loan", type: "warning"});
                    }
                },
            });

        } else {
            //  alert("Error");
        }
    });

    // REBATE ENABLE DISABLE
    function rbtTyp() {
        var checkBox = document.getElementById("rbt");
        if (checkBox.checked === true) {
            document.getElementById("rbtTyp").style.display = "block";
            document.getElementById("rbtVal").style.display = "block";
        } else {
            document.getElementById("rbtTyp").style.display = "none";
            document.getElementById("rbtVal").style.display = "none";
        }
    }

    // REBATE CALCULATION
    function rbtCal() {
        var amt = document.getElementById("amut").value;
        var rbvl = document.getElementById("rbmt").value;

        if (document.getElementById("rbtp").checked === true) {

            var new_amt = +amt - +rbvl;
            document.getElementById("pyamt").value = new_amt;
        } else {

            var new_amt = +amt - (+amt * +rbvl) / 100;
            document.getElementById("pyamt").value = new_amt;
        }

        if (new_amt >= 0) {
            document.getElementById("process_btn").disabled = false;
        } else {
            document.getElementById("process_btn").disabled = true;
        }
        var rbtp = document.getElementById("rbtp").value;
    }

    // Penalty remove process
    $("#process_btn").on('click', function (e) { // add form
        e.preventDefault();

        if ($("#loan_stl").valid()) {
            swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this Process",
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
                        document.getElementById("process_btn").disabled = true;

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/removePenalty",
                            data: $("#loan_stl").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Penalty remove process success", type: "success"},
                                    function () {
                                        location.reload();
                                    }
                                );
                            },
                            error: function () {
                                swal({
                                        title: "Penalty remove process Failed",
                                        text: "Contact system admin",
                                        type: "error"
                                    },
                                    function () {
                                        location.reload();
                                    }
                                );
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });


</script>












