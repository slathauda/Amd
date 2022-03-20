<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active"> Loan Topup</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Loan Topup</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h3 class="text-title"><span class="fa fa-user"></span> Customer Details</h3>
                        <div class="col-md-12">
                            <div class="col-md-4" id="lnsrcDiv">
                                <form class="form-horizontal" action="" method="post" name="srcLoan" id="srcLoan">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="lnno" name="lnno"
                                                   placeholder="Enter Loan No" autofocus value="KB/DB7/18/0001/0001"/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary" id="srchLoan"> <!--panel-refresh-->
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
                                            <div class="table-responsive" id="fcdt" style="display: none">
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
                                                    </tbody>
                                                </table>

                                                <label class="col-md-8 control-label" id="agdt"
                                                       style="color: red"> </label> <!-- arrees details-->
                                                <label class="col-md-8 control-label" id="rtdt"
                                                       style="color: red"> </label> <!-- rental details-->
                                                <label class="col-md-12 control-label" id="pydt"
                                                       style="color: red"> </label> <!-- payment details-->

                                                <label class="col-md-8 control-label ">
                                                    <a id="mrdt" href="" target="_blank" style="color: red">View More
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
                        <form class="form-horizontal" id="loan_tpup" name="loan_tpup" action="" method="post">
                            <div class="panel-body form-horizontal">
                                <div class="col-md-12">
                                    <h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> New Facility Details
                                    </h3>
                                    <input type="hidden" id="lnid" name="lnid">
                                    <input type="hidden" id="cusBrn" name="cusBrn">
                                    <input type="hidden" id="appid" name="appid">
                                    <input type="hidden" id="crnt_prtp" name="crnt_prtp">
                                    <input type="text" id="setBal" name="setBal">

                                    <div class="col-md-6" id="prdBase">  <!-- product base -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-6 col-xs-12">
                                                <select class="form-control" name="prdTyp" id="prdTyp"
                                                        onchange="getLoanPrdt(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($prductinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="fcamt" id="fcamt"
                                                        onchange="getLoanDur(this.value);getInstal()">
                                                    <option value="0"> Select Facility Amount</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="dura" id="dura"
                                                        onchange="getInstal()">
                                                    <option value="0"> Select Rental</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Installment</label>
                                            <label class="col-md-6 col-xs-6 control-label"><span
                                                        id="insAmt"> </span> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Balance Amount</label>
                                            <label class="col-md-6 col-xs-6 control-label"><span
                                                        id="balAmt">  </span> </label>
                                        </div>
                                    </div>
                                    <!-- Dynamic -->
                                    <div class="col-md-6" id="dynamic" style="display: none">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdtpDyn" id="prdtpDyn"
                                                        onchange="abc(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($dynamicprd as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="dyn_fcamt"
                                                       onchange="calInstal()"
                                                       name="dyn_fcamt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dailyDiv" style="display: none">
                                            <!-- Only daily loan -->
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytp" id="dytp"
                                                        onchange="getLoanPrdtDyn(prdtpDyn.value,this.value)">
                                                    <option value="all"> xx</option>
                                                </select>
                                            </div>
                                        </div>  <!-- end Only daily loan -->

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_dura" id="dyn_dura"
                                                        onchange="calInstal()">
                                                    <option value="0"> select Duration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Interest Rate</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_inrt" id="dyn_inrt"
                                                        onchange="calInstal()">
                                                    <option value="0"> Select Rate</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" readonly id="lnprim"
                                                       name="lnprim"/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="dyn_ttlint" name="dyn_ttlint">
                                    </div>
                                    <!-- End Dynamic -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="<?= date('Y-m-d') ?>"
                                                       id="indt" name="indt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Distribute Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="<?= date('Y-m-d') ?>"
                                                       id="dsdt" name="dsdt"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Insurance Chg</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control" id="insu"
                                                       name="insu" placeholder="Insurance Chg"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Document Chg</label>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="text" class="form-control" id="docu"
                                                       name="docu" placeholder="Document Chg"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Charge Mode</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="crgmd" id="crgmd">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Customer Pay</option>
                                                    <option value="2" selected>Debit From Loan</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <h3 class="text-title"><span class="fa fa-bus"></span> Collector Details
                                    </h3>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="cl_brn" id="cl_brn"
                                                        onchange="getExe(this.value,'cl_ofc',cl_ofc.value,'cl_cen');">
                                                    <?php
                                                    foreach ($branchinfo as $branch) {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="cl_ofc" id="cl_ofc"
                                                        onchange="getCenter(this.value,'cl_cen',cl_brn.value)">
                                                    <?php
                                                    foreach ($execinfo as $exe) {
                                                        echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Center</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="cl_cen" id="cl_cen">
                                                    <?php
                                                    foreach ($centinfo as $cen) {
                                                        echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

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

        $("#loan_tpup").validate({  // validation
            ignore: [],
            rules: {
                prdTyp: {
                    required: true,
                    notEqual: '0'
                },
                fcamt: {
                    required: true,
                    notEqual: '0'
                },
                dura: {
                    required: true,
                    notEqual: '0'
                },

                cl_brn: {
                    required: true,
                    notEqual: 'all',
                    equalTo: '#cusBrn',
                },
                cl_ofc: {
                    required: true,
                    notEqual: 'all'
                },
                cl_cen: {
                    required: true,
                    notEqual: 'all'
                },


                rbmt: {
                    required: true,
                    notEqual: '0',
                    digits: true
                },
                pytp: {
                    required: true,
                    notEqual: 'all'
                },
            },
            messages: {
                prdTyp: {
                    required: 'Please select product type',
                    notEqual: "Please select product type",
                },
                fcamt: {
                    required: 'Please select Facility Amount',
                    notEqual: "Please select Facility Amount",
                },
                dura: {
                    required: 'Please select duration',
                    notEqual: "Please select duration",
                },
                cl_brn: {
                    required: 'Please select branch',
                    notEqual: "Please select branch",
                    equalTo: "Please select Customer branch",
                },
                cl_ofc: {
                    required: 'Please select Credit Officer',
                    notEqual: "Please select Credit Officer",
                },
                cl_cen: {
                    required: 'Please select Center',
                    notEqual: "Please select Center",
                },


                rbmt: {
                    required: 'Please enter Value',
                    notEqual: "Please enter Value"
                },
                pytp: {
                    required: 'Please select Pay Type',
                    notEqual: "Please select Pay Type"
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
                url: '<?= base_url(); ?>user/vewTpupCustDtils',
                type: 'POST',
                data: {
                    lnno: lnno
                },
                dataType: 'json',
                success: function (response) {

                    var len = response['cudt'].length;

                    if (len > 0) {
                        if (response['cudt'][0]['clno'] == null) {

                            document.getElementById("cusDtilsDiv").style.display = 'block';
                            document.getElementById("lnsrcDiv").style.display = 'none';

                            document.getElementById("init").innerHTML = response['cudt'][0]['sode'] + response['cudt'][0]['init'];
                            document.getElementById("brnm").innerHTML = response['cudt'][0]['brnm'];
                            document.getElementById("grno").innerHTML = response['cudt'][0]['grno'];
                            document.getElementById("cuno").innerHTML = response['cudt'][0]['cuno'];
                            document.getElementById("anic").innerHTML = response['cudt'][0]['anic'];
                            document.getElementById("cntr").innerHTML = response['cudt'][0]['cnnm'];
                            document.getElementById("hoad").innerHTML = response['cudt'][0]['hoad'];
                            document.getElementById("mobi").innerHTML = response['cudt'][0]['mobi'];

                            document.getElementById('uimg').src = "../uploads/cust_profile/" + response['cudt'][0]['uimg'];
                            document.getElementById("uimgA").setAttribute("href", "../uploads/cust_profile/" + response['cudt'][0]['uimg']);

                            document.getElementById("lnid").value = response['cudt'][0]['lnid'];
                            document.getElementById("cusBrn").value = setVal;

                            document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response['cudt'][0]['acno']);

                            document.getElementById("cusBrn").value = response['cudt'][0]['brco'];
                            /* customer branch*/
                            document.getElementById("appid").value = response['cudt'][0]['apid'];
                            /* customer auid*/
                            document.getElementById("crnt_prtp").value = response['cudt'][0]['prdtp'];
                            /* customer current loan product type*/


                            //ARREARS AGE
                            // $arc = round(($rd2['aboc']+$rd2['aboi'])/$rd2['inam'],2);
                            // Math.round(num * 100) / 100
                            // var n = num.toFixed(2);
                            var arag = ((+response['pydt'][0]['aboc'] + +response['pydt'][0]['aboi']) / +response['pydt'][0]['inam']).toFixed(2);

                            //PAID MORE THAN 60 FROM TOTAL
                            //$arc1 = round(($rd2['ttl']/($rd2['noin']*$rd2['inam']))*100,2);
                            var pydt = ((+response['pydt'][0]['ttl'] / +response['pydt'][0]['noin'] * +response['pydt'][0]['inam']) * 100).toFixed(2);

                            if (arag > 2) {
                                document.getElementById("agdt").innerHTML = "<strong>Arrears Age : " + arag + " <br/>Selected Loan arrears age more than (2), This can't process and see the details </strong>";
                            } else if (pydt < '60.00' || pydt < '60.0') {
                                document.getElementById("pydt").innerHTML = "<strong>Paid Total : " + pydt + "% <br/>Selected Loan should more than 60% of repayment total, This can't process and see the details <br/></strong> ";
                            } else {
                                document.getElementById("rtdt").innerHTML = 'rental details';

                                document.getElementById("process_btn").style.display = 'block';
                                document.getElementById("fcdt").style.display = 'block';
                                document.getElementById("acno").innerHTML = response['cudt'][0]['acno'];
                                document.getElementById("prcd").innerHTML = '(' + response['cudt'][0]['prcd'] + ') ' + response['cudt'][0]['prnm'];
                                document.getElementById("indt").innerHTML = response['cudt'][0]['indt'];
                                document.getElementById("mddt").innerHTML = response['cudt'][0]['mddt'];
                                document.getElementById("loam").innerHTML = numeral(response['cudt'][0]['loam']).format('0,0.00');
                                document.getElementById("inst").innerHTML = numeral(response['cudt'][0]['inam']).format('0,0.00') + ' x ' + response['cudt'][0]['noin'];
                                var setVal = (+response['cudt'][0]['boc'] + +response['cudt'][0]['boi'] + +response['cudt'][0]['aboc'] + +response['cudt'][0]['aboi'] + +response['cudt'][0]['avpe']) - +response['cudt'][0]['avcr'];
                                document.getElementById("tdst").innerHTML = numeral(setVal).format('0,0.00');
                                document.getElementById("stmt").innerHTML = response['cudt'][0]['nxpn'] + ' of ' + response['cudt'][0]['noin'];

                                document.getElementById("setBal").value = setVal;
                            }

                        } else {
                            swal({title: "", text: "Allready Topup Requested.", type: "info"});
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

    // ************ product base **********
    // load Facility Amount
    function getLoanPrdt(prdtp) {
        var brnc = document.getElementById('cusBrn').value;
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanProduct',
            data: {
                prdtp: prdtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                // console.log(<?php echo $policy[3]->post ?>);

                // if check top up loan type with system policy
                <?php
                if ($policy[3]->post == 0){  // same product category
                ?>
                var crnt_prtp = document.getElementById("crnt_prtp").value;

                if (crnt_prtp != prdtp) {   // current running loan product category != selected product category
                    $('#fcamt').empty();
                    $('#fcamt').append("<option value='0'> Any Product Type Not Allowed..</option>");

                    document.getElementById("fcamt").style.borderColor = 'red';

                } else {
                    document.getElementById("fcamt").style.borderColor = '';
                    if (len != 0) {
                        $('#fcamt').empty();
                        $('#fcamt').append("<option value='0'>Select Facility </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['lamt'];
                            var name = response[i]['lamt'];
                            var $el = $('#fcamt');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#fcamt').empty();
                        $('#fcamt').append("<option value='0'>No Facility</option>");
                    }
                }

                <?php }else { ?> // any product category

                if (len != 0) {
                    $('#fcamt').empty();
                    $('#fcamt').append("<option value='0'>Select Facility </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['lamt'];
                        var name = response[i]['lamt'];
                        var $el = $('#fcamt');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#fcamt').empty();
                    $('#fcamt').append("<option value='0'>No Facility</option>");
                }
                <?php } ?>
            },
        });
    }

    // Load Loan weeks
    function getLoanDur(fcamt) {
        var pdtp = document.getElementById('prdTyp').value;
        var brnc = document.getElementById('cusBrn').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanPeriod',
            data: {
                fcamt: fcamt,
                pdtp: pdtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>Select Rental </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['nofr'];
                        var $el = $('#dura');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>No Rental</option>");
                }
            },
        });
    }

    // Load Loan instalment & Charges
    function getInstal() {
        var dura = document.getElementById('dura').value;
        var cuid = document.getElementById('appid').value;
        var setBal = document.getElementById('setBal').value;
        var crnt_prtp = document.getElementById('crnt_prtp').value;

        $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>user/getLoanInstal',
                data: {
                    id: dura,
                    cuid: cuid
                },
                dataType: 'json',
                success: function (response) {
                    var len = response['lndt'].length;
                    //console.log(<?php echo $policy[1]->post ?>);
                    // if check parallel product allow or not
                    <?php
                    if ($policy[1]->post == 1){
                    ?>

                    document.getElementById('process_btn').style.display = 'block';
                    if (len != 0) {
                        $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                        document.getElementById('insu').value = response['lndt'][0]['insc'];
                        document.getElementById('docu').value = response['lndt'][0]['docc'];

                        document.getElementById('balAmt').innerHTML = numeral((+response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'] + +response['lndt'][0]['insc'] + +response['lndt'][0]['docc']) - +setBal).format('0,0.00');
                    } else {
                        $('#insAmt').text(" - ");
                        document.getElementById('insu').value = '0';
                        document.getElementById('docu').value = '0';

                        document.getElementById('balAmt').innerHTML = '-;'
                    }
                    <?php  } else  { ?>
                    if (response['cudt'].length != 0) {
                        //console.log(response['cudt'][0]['prid']+'   ***'+ dura);
                        if (response['cudt'][0]['prid'] == dura) {
                            $('#insAmt').html("<font color='red'>parallel Product Not Allowed...</font>");
                            document.getElementById('process_btn').style.display = 'none';
                        } else {
                            document.getElementById('process_btn').style.display = 'block';
                            if (len != 0) {
                                $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                                document.getElementById('insu').value = response['lndt'][0]['insc'];
                                document.getElementById('docu').value = response['lndt'][0]['docc'];

                                document.getElementById('balAmt').innerHTML = numeral((+response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'] + +response['lndt'][0]['insc'] + +response['lndt'][0]['docc'] ) - +setBal).format('0,0.00');
                            } else {
                                $('#insAmt').text(" - ");
                                document.getElementById('insu').value = '0';
                                document.getElementById('docu').value = '0';
                            }
                        }
                    } else {
                        document.getElementById('process_btn').style.display = 'block';
                        if (len != 0) {
                            $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                            document.getElementById('insu').value = response['lndt'][0]['insc'];
                            document.getElementById('docu').value = response['lndt'][0]['docc'];

                            document.getElementById('balAmt').innerHTML = numeral((+response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'] + +response['lndt'][0]['insc'] + +response['lndt'][0]['docc']) - +setBal).format('0,0.00');

                        } else {
                            $('#insAmt').text(" - ");
                            document.getElementById('insu').value = '0';
                            document.getElementById('docu').value = '0';
                        }
                    }
                    <?php } ?>
                },
            }
        )
        ;
    }
    // ************ END product base **********


    //  loan topup process
    $("#process_btn").on('click', function (e) { // add form
        e.preventDefault();

        if ($("#loan_tpup").valid()) {
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
                            url: "<?= base_url(); ?>User/addLntopup",
                            data: $("#loan_tpup").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Loan Topup Requested success", type: "success"},
                                    function () {
                                        //location.reload();
                                    }
                                );
                            },
                            error: function () {
                                swal({
                                        title: "Loan Topup Requested Failed",
                                        text: "Contact system admin",
                                        type: "error"
                                    },
                                    function () {
                                        //location.reload();
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












