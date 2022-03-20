<style>

    td.details-control {
        text-align: center;
        color: forestgreen;
        cursor: pointer;
    }

    tr.shown td.details-control {
        text-align: center;
        color: red;
    }

    .grnter {
        outline: hidden;
        border: hidden;
        background: none
    }
</style>

<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Individual Repayment</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Individual Repayment </strong></h3>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" action="" method="post" name="srcLoan" id="srcLoan">
                        <div class="form-group">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="lnno" placeholder="Enter Loan No"
                                           autofocus value=""/>
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary panel-refresh" id="srchLoan">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="cudt_div" style="display: none">

        <div class="col-md-9">
            <!--            <div class="modal-body form-horizontal">-->
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default tabs">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="active"><a href="#tab-1" role="tab" data-toggle="tab">Running Loan</a></li>
                            <li><a href="#tab-2" role="tab" data-toggle="tab">--</a></li>
                            <li><a href="#tab-3" role="tab" data-toggle="tab"> -- </a></li>
                        </ul>

                        <div class="panel-body tab-content form-horizontal">
                            <div class="tab-pane active" id="tab-1">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Loan No</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="lon_no"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Type</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="lntp"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="prtp"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Start Date</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="stdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Next Due Date</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="nxdu"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Arrears</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="arbal"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Loan Amount</label>
                                        <label class="col-md-6 col-xs-12 control-label" id="lnamt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="rntl"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="inst"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Account Balance</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="acbal"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Settlement</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="slbal"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Last Pay Date</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="lst_pydt"></label>
                                    </div>
                                    <input type="hidden" id="setBal" name="setBal">

                                </div>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <p>System ID : - </p>
                            </div>
                            <div class="tab-pane" id="tab-3">
                                <h1>Tab 3 </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default ">

                        <form class="form-horizontal" id="indv_recpt" name="indv_recpt"
                              action="" method="post">
                            <div class="panel-body form-horizontal">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Paying Amount</label>
                                        <div class="col-md-6 col-xs-6">
                                            <input type="text" class="form-control" id="pyamt"
                                                   placeholder="Payment Amount"
                                                   name="pyamt"/>
                                        </div>
                                        <input type="hidden" id="lnauid" name="lnauid">
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Pay Type</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="pytp" id="pytp"
                                                    onchange="chqDiv(this.value)">
                                                <option value="0"> Select Option</option>
                                                <?php
                                                foreach ($payinfo as $pay) {
                                                    if ($pay->tmid == 8) {
                                                        echo "<option value='$pay->tmid' selected>$pay->tem_name</option>";
                                                    } else {
                                                        echo "<option value='$pay->tmid' disabled>$pay->tem_name</option>";
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div id="chqDiv" style="display: none">
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Cheque No</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input type="text" class="form-control" id="cqno"
                                                       placeholder="CHQ No" name="cqno"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Cheque Bank</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="chbk" id="chbk">
                                                    <option value="0"> Select Bank</option>
                                                    <?php
                                                    foreach ($bnkinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Cheque Date</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input type="text" class="form-control datepicker" id="chdt"
                                                       placeholder="Payee Name" value="<?= date("Y-m-d"); ?>"
                                                       name="chdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Remarks</label>
                                            <div class="col-md-6 col-xs-6">
                                               <textarea class="form-control" rows="3" id="chrk" placeholder="Referance"
                                                         name="chrk"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div id="onlDiv" style="display: none">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Transfer Bank</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="trbk" id="trbk">
                                                    <option value="0"> Select Bank</option>
                                                    <?php
                                                    foreach ($bnkinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Transfer Date</label>
                                            <div class="col-md-6 col-xs-6">
                                                <input type="text" class="form-control datepicker" id="trdt"
                                                       placeholder="Payee Name" value="<?= date("Y-m-d"); ?>"
                                                       name="trdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Remarks</label>
                                            <div class="col-md-6 col-xs-6">
                                               <textarea class="form-control" rows="3" id="trrk" placeholder="Referance"
                                                         name="trrk"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Pay Status</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="pyst" id="pyst">
                                                <option value="0"> Select Option</option>
                                                <option value="1"> Easy</option>
                                                <option value="2"> Normal</option>
                                                <option value="3"> Hardly</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Payee By</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="pyby" id="pyby">
                                                <option value="0"> Select Option</option>
                                                <?php
                                                foreach ($pay_by as $pby) {
                                                    echo "<option value='$pby->pyby'>$pby->pydt</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">Payee At</label>
                                        <div class="col-md-6 col-xs-6">
                                            <select class="form-control" name="pyat" id="pyat">
                                                <option value="0"> Select Option</option>
                                                <?php
                                                foreach ($pay_at as $pat) {
                                                    echo "<option value='$pat->pyat'>$pat->pydt</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4  col-xs-6 control-label">SMS Sending</label>
                                        <div class="col-md-6 col-xs-12">
                                            <label class="switch">
                                                <input id="smss" name="smss" type="checkbox" value="1"
                                                       checked/>Yes
                                                <span></span>
                                            </label> No
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="button" id="process_btn" class="btn btn-success pull-right">Submit
                                </button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!--            </div>-->
        </div>

        <div class="col-md-3">
            <!-- CONTACT ITEM -->
            <div class="panel panel-default">
                <div class="panel-body profile">
                    <div class="profile-image">
                        <img src="../uploads/cust_profile/default-image.jpg" id="img1" alt="Nadia Ali"/>
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name"><span id="init"></span></div>
                        <div class="profile-data-title"><span id="cuno1"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Name</label>
                            <label class="col-md-8 col-xs-12 control-label" id="funm"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Address</label>
                            <label class="col-md-8 col-xs-12 control-label" id="hoad"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Contact</label>
                            <label class="col-md-8 col-xs-12 control-label" id="mobi"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">NIC</label>
                            <label class="col-md-8 col-xs-12 control-label" id="anic"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">DOB</label>
                            <label class="col-md-8 col-xs-12 control-label" id="dob"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Occupation</label>
                            <label class="col-md-8 col-xs-12 control-label" id="occu"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">SMS Sending</label>
                            <label class="col-md-8 col-xs-12 control-label" id="sms"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Branch</label>
                            <label class="col-md-8 col-xs-12 control-label" id="brn"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Officer</label>
                            <label class="col-md-8 col-xs-12 control-label" id="exe"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Center</label>
                            <label class="col-md-8 col-xs-12 control-label" id="cnt"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Cust No</label>
                            <label class="col-md-8 col-xs-12 control-label" id="cuno2"></label>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Active Loan</label>
                            <label class="col-md-8 col-xs-12 control-label" id="acln"></label>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-md-4 col-xs-4">
                                <button class="friend popover-dismiss grnter" id="gr1" title="Granter Details"
                                        data-container="body" data-placement="top"
                                        data-content="Details">
                                    <img src="../uploads/cust_profile/default-image.jpg" id="grImg1"/>
                                </button>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <button class="friend popover-dismiss grnter" id="gr2" title="Granter Details"
                                        data-container="body" data-placement="top"
                                        data-content="Details">
                                    <img src="../uploads/cust_profile/default-image.jpg" id="grImg2"/>
                                    <!-- <span>Dmitry Ivaniuk</span> -->
                                </button>
                            </div>
                            <div class="col-md-4 col-xs-4">
                                <button class="friend popover-dismiss grnter" id="gr3" title="Granter Details"
                                        data-container="body" data-placement="top"
                                        data-content="Details">
                                    <img src="../uploads/cust_profile/default-image.jpg" id="grImg3"/>
                                    <!-- <span>Dmitry Ivaniuk</span> -->
                                </button>
                            </div>
                        </div>

                        <!--                        <p><small>Center </small><span id="cuno1"></span> </p>-->
                    </div>
                </div>
            </div>
            <!-- END CONTACT ITEM -->
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

        $("#srchLoan").validate({
            rules: {
                lnno: {
                    required: true,
                    length: 19
                },
            },
            messages: {
                lnno: {
                    required: 'Please select Branch',
                    length: "Please length",
                },
            }
        });

        $("#indv_recpt").validate({
            rules: {
                pyamt: {
                    required: true,
                    currency: true,
                    max: function () {
                        return parseInt($('#setBal').val());
                    }
                },

                pytp: {
                    required: true,
                    notEqual: '0'
                },
                cqno: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                },
                chbk: {
                    required: true,
                    notEqual: '0'
                },
                trbk: {
                    required: true,
                    notEqual: '0'
                },
                pyst: {
                    required: true,
                    notEqual: '0'
                },
                pyby: {
                    required: true,
                    notEqual: '0'
                },
                pyat: {
                    required: true,
                    notEqual: '0'
                },

            },
            messages: {
                pyamt: {
                    required: 'Please enter amount',
                    currency: 'This is not a valid currency'
                },
                pytp: {
                    required: 'Please select payment type',
                    notEqual: "Please select payment type"
                },
                cqno: {
                    required: 'Please enter chq no',
                },
                chbk: {
                    required: 'Please select chq bank',
                    notEqual: "Please select bank"
                },
                trbk: {
                    required: 'Please select bank',
                    notEqual: "Please select bank"
                },
                pyst: {
                    required: 'Please select status',
                    notEqual: "Please select status"
                },
                pyby: {
                    required: 'Please select payee',
                    notEqual: "Please select payee"
                },
                pyat: {
                    required: 'Please select payee at',
                    notEqual: "Please select payee at"
                },

            }
        });
    });


    function chckBtn(id, inpu) {
        // console.log(inpu);
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // loan loan details
    $("#srchLoan").on('click', function (e) {

        e.preventDefault();
        var lnno = document.getElementById('lnno').value;

        if (lnno.length == '' || lnno.length != 19) {
            document.getElementById('lnno').focus();
            document.getElementById('lnno').style.borderColor = "red";
        } else {
            document.getElementById('lnno').style.borderColor = "";

            $.ajax({
                url: '<?= base_url(); ?>user/getIndvLoan',
                type: 'post',
                data: {
                    lnno: lnno
                },
                dataType: 'json',
                success: function (response) {
                    var cudt = response['cudt'].length;
                    var lndt = response['lndt'].length;

                    if (cudt > 0) {
                        document.getElementById('cudt_div').style.display = "block";
                        document.getElementById("init").innerHTML = response['cudt'][0]['init'];
                        document.getElementById("cuno1").innerHTML = response['cudt'][0]['cuno'];
                        document.getElementById("funm").innerHTML = response['cudt'][0]['funm'];
                        document.getElementById("hoad").innerHTML = response['cudt'][0]['hoad'];
                        document.getElementById("mobi").innerHTML = response['cudt'][0]['mobi'];
                        document.getElementById("anic").innerHTML = response['cudt'][0]['anic'];
                        document.getElementById("dob").innerHTML = response['cudt'][0]['dobi'];
                        document.getElementById("occu").innerHTML = '--';
                        if (response['cudt'][0]['smst'] == 0) {
                            document.getElementById("sms").innerHTML = "<span class='label label-warning'> No </span> ";
                        } else if (response['cudt'][0]['smst'] == 1) {
                            document.getElementById("sms").innerHTML = "<span class='label label-success'> Yes </span> ";
                        }
                        document.getElementById("brn").innerHTML = response['cudt'][0]['brnm'];
                        document.getElementById("exe").innerHTML = response['cudt'][0]['fnme'];
                        document.getElementById("cnt").innerHTML = response['cudt'][0]['cnnm'];
                        document.getElementById("acln").innerHTML = response['cudt'][0]['aaln'];
                        document.getElementById("cuno2").innerHTML = response['cudt'][0]['cuno'];
                        document.getElementById("img1").src = "../uploads/cust_profile/" + response['cudt'][0]['uimg'];

                        var aaa = response['cudt'][0]['gr1nm'] + ' | ' + response['cudt'][0]['gr1no'];
                        $('#gr1').attr('data-content', aaa);
                        document.getElementById("grImg1").src = "../uploads/cust_profile/" + response['cudt'][0]['gr1img'];

                        $('#gr2').attr('data-content', response['cudt'][0]['gr2nm'] + " | " + response['cudt'][0]['gr2no']);
                        document.getElementById("grImg2").src = "../uploads/cust_profile/" + response['cudt'][0]['gr2img'];

                        $('#gr3').attr('data-content', response['cudt'][0]['gr3nm'] + " | " + response['cudt'][0]['gr3no']);
                        document.getElementById("grImg3").src = "../uploads/cust_profile/" + response['cudt'][0]['gr3img'];

                    } else {
                        document.getElementById('cudt_div').style.display = "none";
                        swal("Failed!", "Invalid Loan No", "error");
                    }

                    if (lndt > 0) {
                        //document.getElementById('cudt_div').style.display = "block";
                        document.getElementById("lon_no").innerHTML = response['lndt'][0]['acno'];
                        if (response['lndt'][0]['lntp'] == 1) {
                            var lntp = "Product Loan";
                        } else {
                            var lntp = "Dynamic Loan";
                        }
                        document.getElementById("lntp").innerHTML = lntp;
                        document.getElementById("prtp").innerHTML = response['lndt'][0]['prna'] + '|' + response['lndt'][0]['prcd'];
                        document.getElementById("stdt").innerHTML = response['lndt'][0]['acdt'];
                        document.getElementById("nxdu").innerHTML = response['lndt'][0]['nxdd'];

                        document.getElementById("lnamt").innerHTML = numeral(response['lndt'][0]['loam']).format('0,0.00');
                        document.getElementById("rntl").innerHTML = response['lndt'][0]['lnpr'] + ' ' + response['lndt'][0]['pymd'];
                        document.getElementById("inst").innerHTML = numeral(response['lndt'][0]['inam']).format('0,0.00');

                        var ac_bal = +response['lndt'][0]['boc'] + +response['lndt'][0]['boi'] +  + +response['lndt'][0]['avdb'] + +response['lndt'][0]['avpe'];
                        var setbal = +ac_bal - +response['lndt'][0]['avcr'];

                        document.getElementById("acbal").innerHTML = numeral(ac_bal).format('0,0.00');
                        document.getElementById("slbal").innerHTML = numeral(setbal).format('0,0.00');
                        document.getElementById("setBal").value =Math.ceil(setbal) ;

                        document.getElementById("arbal").innerHTML = numeral(+response['lndt'][0]['aboc'] + +response['lndt'][0]['aboi']).format('0,0.00');
                        document.getElementById("lst_pydt").innerHTML = response['lndt'][0]['crdt'] + ' | ' + numeral(response['lndt'][0]['ramt']).format('0,0.00');
                        document.getElementById("lnauid").value = response['lndt'][0]['lnid'];
                    }
                }
            });
        }
    });

    function chqDiv(id) {
        if (id == 10) {                     // CUSTOMER CHQ
            document.getElementById("chqDiv").style.display = 'block';
            document.getElementById("onlDiv").style.display = 'none';

        } else if (id == 3 || id == 4) {    // BANK TT || ONLINE TRANSFER
            document.getElementById("onlDiv").style.display = 'block';
            document.getElementById("chqDiv").style.display = 'none';

        } else {                            // CASH && OTHER
            document.getElementById("chqDiv").style.display = 'none';
            document.getElementById("onlDiv").style.display = 'none';
        }
    }


    // repayment process
    $("#process_btn").on('click', function (e) { // add form
        e.preventDefault();

        if ($("#indv_recpt").valid()) {
            document.getElementById("process_btn").disabled = true;
            var jqXHR = jQuery.ajax({
                url: '<?= base_url(); ?>user/addPyment',
                type: 'POST',
                data: $("#indv_recpt").serialize(),
                dataType: 'json',
                success: function (data) {
                    if (data == true) {
                        swal({title: "Success", text: "Repayment Add Done", type: "success"},
                            function () {
                                location.reload();
                            }
                        );
                        document.getElementById("process_btn").disabled = false;
                    } else {
                        swal({title: "Failed", text: "Repayment Add Failed", type: "error"},
                            function () {
                                location.reload();
                            }
                        );
                    }
                },
                error: function (data, jqXHR, textStatus, errorThrown) {
                    swal({title: "Failed", text: "Repayment Add Failed", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });

        } else {
            //  alert("Error");
        }
    });

    // data clear
    $("#cler_btn").on('click', function (e) { // add form
        e.preventDefault();
        $('.pybx').val('');
    });


</script>












