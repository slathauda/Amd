<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.css"/>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.js"></script>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Investment Module</li>
    <li class="active"> Investor Payment</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Investor Payment </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Payment
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">

                        <div class="row">

                            <div class="col-md-6">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Status Type</label>
                                        <div class="col-md-6 col-xs-6">

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button form-control  " onclick="searchInvestorBank()"
                                                class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6"></div>
                            <br><br> <br>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body panel-body-table" style="padding:10px;">
                                    <div class="table-responsive">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="dataTbInsPayment" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">NIC</th>
                                                <th class="text-center">Mobile</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Mode</th>
                                                <th class="text-center">Total Amount</th>
                                                <th class="text-center">Total Rate</th>
                                                <th class="text-center">Pay Amount</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
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
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Investment Payment</h4>
                </div>
                <form class="form-horizontal" id="addinPy_Add" name="insvest_Add" action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label"> Date</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class=" form-control datepicker"
                                                                   placeholder="" id="todt" name="todt"
                                                                   value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Investor Nic
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="inic" id="inic"
                                                               placeholder="Investor Nic" on
                                                               onkeyup="srchIns(this.id);"/>
                                                        <input type="text" id="auid" name="auid"/>
                                                        <input type="hidden" id="bnid" name="bnid"/>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="col-md-6">
                                                <div id="insDiv" style="display: none; background-color: #e8e8e8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                        <label class="col-md-9 col-xs-12 control-label"
                                                               id="innm"></label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Nic </label>
                                                        <label class="col-md-6 col-xs-12 control-label"
                                                               id="inicc"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                        <label class="col-md-6 col-xs-12 control-label"
                                                               id="mobii"></label>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Select Amount </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control" name="pyam" id="pyam"
                                                                onchange="chckBtn(this.value,'pyam'); getInst(this.id);">
                                                            <input type="text" id="invd" name="invd"/>
                                                            <input type="text" id="invd" name="invd"/>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay Account No </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control" name="acno" id="acno"
                                                                onchange="srchInsPynt(this.id);">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Total Period </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" readonly
                                                               placeholder="" id="perid" name="perid">

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay Mode </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" readonly
                                                               placeholder="" id="dunm" name="dunm">

                                                    </div>
                                                </div>

                                                <!--                                                <div class="form-group">-->
                                                <!--                                                    <label class="col-md-6  control-label"> Total Interest-->
                                                <!--                                                    </label>-->
                                                <!--                                                    <div class="col-md-6 ">-->
                                                <!--                                                        <input type="text" class="form-control" name="toin" id="toin"-->
                                                <!--                                                               placeholder="Interest"/>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label"> Interest left To Pay
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="amnt" id="amnt"
                                                               placeholder="Pay Amount"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Remarks
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" placeholder="remarks"
                                                               id="remk" name="remk"/>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div id="insDivPy" style="display: none; background-color: #e8e8e8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Total
                                                            Payments</label>
                                                        <label class="col-md-9 col-xs-12 control-label"
                                                               id="topyy"></label>
                                                    </div>



                                                </div>


                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="addInPy">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--End Add Model -->


    <!-- View Model -->
    <div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead">Invester Bank Details</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Inverster Name</label>
                                                <label class="col-md-6  control-label" id="insbank_insname_vew"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Inverster Nic</label>
                                                <label class="col-md-6  control-label" id="insbank_nic_vew"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Bank Name</label>
                                                <label class="col-md-6  control-label"
                                                       id="insbank_bankname_vew"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Branch Name</label>
                                                <label class="col-md-6  control-label" id="insbank_branch_vew"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Account Type </label>
                                                <label class="col-md-6  control-label"
                                                       id="insbank_accounttype_vew"></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Account </label>
                                                <label class="col-md-6  control-label"
                                                       id="insbank_account_vew"> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Name On Account </label>
                                                <label class="col-md-6  control-label" id="accountuser_vew"> </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Remarks </label>
                                                <label class="col-md-6  control-label" id="remarks_vew"> </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!--End View Model -->


    <!--  Edit / approvel -->
    <div class="modal" id="modaledit" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
                </div>
                <form class="form-horizontal" id="addinPy_Add" name="insvest_Add" action="" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <br>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label"> Date</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class=" form-control datepicker"
                                                                   placeholder="" id="edit_todt" name="edit_todt"
                                                                   value="<?= date('Y-m-d') ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Investor Nic
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="edit_inic" id="edit_inic"
                                                               placeholder="Investor Nic" on
                                                               onkeyup="srchIns(this.id,'edit_inic');"/>
                                                        <input type="text" id="edit_auid" name="edit_auid"/>
                                                        <input type="hidden" id="bnid" name="bnid"/>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="col-md-6">
                                                <div id="insDiv" style="display: none; background-color: #e8e8e8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                        <label class="col-md-9 col-xs-12 control-label"
                                                               id="edit_innm"></label>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Nic </label>
                                                        <label class="col-md-6 col-xs-12 control-label"
                                                               id="edit_inicc"></label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                        <label class="col-md-6 col-xs-12 control-label"
                                                               id="edit_mobii"></label>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Select Amount </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control" name="edit_pyam" id="edit_pyam"
                                                                onchange="chckBtn(this.value,'pyam'); getInst(this.id);">
                                                            <input type="text" id="edit_invd" name="invd"/>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay Account No </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control" name="edit_acno" id="edit_acno"
                                                                onchange="srchInsPynt(this.id);">
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Total Period </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" readonly
                                                               placeholder="" id="edit_perid" name="edit_perid">

                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay Mode </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" readonly
                                                               placeholder="" id="edit_dunm" name="edit_dunm">

                                                    </div>
                                                </div>

                                                <!--                                                <div class="form-group">-->
                                                <!--                                                    <label class="col-md-6  control-label"> Total Interest-->
                                                <!--                                                    </label>-->
                                                <!--                                                    <div class="col-md-6 ">-->
                                                <!--                                                        <input type="text" class="form-control" name="toin" id="toin"-->
                                                <!--                                                               placeholder="Interest"/>-->
                                                <!--                                                    </div>-->
                                                <!--                                                </div>-->
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label"> Interest left To Pay
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="edit_amnt" id="edit_amnt"
                                                               placeholder="Pay Amount"/>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Remarks
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control" placeholder="remarks"
                                                               id="edit_remk" name="edit_remk"/>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-6">
                                                <div id="insDivPy" style="display: none; background-color: #e8e8e8">
                                                    <div class="form-group">
                                                        <label class="col-md-3 col-xs-12 control-label">Total
                                                            Payments</label>
                                                        <label class="col-md-9 col-xs-12 control-label"
                                                               id="edit_topyy"></label>
                                                    </div>



                                                </div>


                                            </div>


                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="editInPy">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--End Edit / approvel Model -->

    <script>
        $().ready(function () {
            // Data Tables show entries
            $('#dataTbInsPayment').DataTable({
                destroy: true,
                "cache": false,
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
            });

            searchInvestorPayment();

            // add form validation start
            $("#ins_Bank_Add").validate({
                rules: {
                    inic: {
                        required: true,
                    },
                    bkid: {
                        required: true,
                        notEqual: '0',
                    },
                    bkbr: {
                        required: true,
                    },
                    actp: {
                        required: true,
                    },
                    acno: {
                        required: true,
                        digits: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/nic_Accno",
                            type: "post",
                            data: {
                                acno: function () {
                                    return $("#acno").val();
                                },
                            }
                        }
                    },
                    bunm: {
                        required: true,
                    },

                },
                messages: {
                    inic: {
                        required: 'Plase enter nic number',
                    },
                    bkid: {
                        required: 'Please select Bank Name',
                    },
                    bkbr: {
                        required: 'Please enter Branch',
                    },
                    actp: {
                        required: 'Please enter Account Type',
                    },
                    acno: {
                        required: 'Please enter Account No',
                        digits: 'Invalid Account Number',
                        remote: 'already inserted'
                    },
                    bunm: {
                        required: 'Name On Account ',
                    },

                }
            });
            // add form validation end
            // edit form validation start
            $("#ins_Bank_Edit").validate({
                rules: {
                    edit_Inic: {
                        required: true,

                    },
                    edit_Bkid: {
                        required: true,
                        notEqual: '0',
                    },
                    edit_Bkbr: {
                        required: true,
                    },
                    edit_actp: {
                        required: true,
                    },
                    edit_Acno: {
                        required: true,
                        digits: true,
                        remote: {
                            url: "<?= base_url(); ?>admin/nic_Accno_edit",
                            type: "post",
                            data: {
                                edit_Acno: function () {
                                    return $("#edit_Acno").val();
                                },
                                edit_Bnid: function () {
                                    return $("#edit_Bnid").val();
                                }
                            }
                        }


                    },
                    edit_Bunm: {
                        required: true,
                    },

                },
                messages: {
                    edit_Inic: {
                        required: 'Plase enter nic number',
                    },
                    edit_Bkid: {
                        required: 'Please select Bank Name',
                    },
                    edit_Bkbr: {
                        required: 'Please enter Branch',
                    },
                    edit_actp: {
                        required: 'Please enter Account Type',
                    },
                    edit_Acno: {
                        required: 'Please enter Account No',
                        digits: 'Invalid Account Number',
                        remote: 'already inserted'
                    },
                    edit_Bunm: {
                        required: 'Name On Account ',
                    },
                }
            });
            // edit form validation end
        });
        //


        //add investment load nic start
        function srchIns() {
            var inic = document.getElementById("inic").value;
            if (inic.length == 10 || inic.length == 12) {
                document.getElementById("inic").style.borderColor = "";
                $.ajax({
                    url: '<?= base_url(); ?>admin/getInvest_Inpy',
                    type: 'POST',
                    data: {
                        inic: inic,
                    },
                    dataType: 'json',
                    success: function (data) {
                        var len = data.length;
                        if (len > 0) {
                            document.getElementById("insDiv").style.display = 'block';
                            document.getElementById("innm").innerHTML = data[0]['innm'];
                            //  document.getElementById("hoad").innerHTML = data[0]['hoad'];
                            document.getElementById("inicc").innerHTML = data[0]['inic'];
                            document.getElementById("mobii").innerHTML = data[0]['mobi'];
                            document.getElementById("auid").value = data[0]['auid'];
                            document.getElementById("bnid").value = data[0]['bnid'];
                            document.getElementById("addInPy").style.display = '';
                            getamount();
                            getaccount();


                        } else {
                            document.getElementById("insDiv").style.display = 'none';
                            document.getElementById("inic").style.borderColor = "red";
                            document.getElementById("addInPy").style.display = 'none';
                            swal({
                                title: "",
                                text: "Invalide nic no Or no active investor Or no active bank",
                                type: "warning"
                            });
                        }
                    },
                });
            } else {
                document.getElementById("inic").style.borderColor = "red";
                document.getElementById("insDiv").style.display = 'none';
                document.getElementById("addInPy").style.display = 'none';
            }
        };
        //add investment load nic end


        // get amount start
        function getamount(edt) {
            var auid = document.getElementById("auid").value;



            $.ajax({
                url: '<?= base_url(); ?>admin/getamount',
                type: 'POST',
                data: {
                    auid: auid,
                },
                dataType: 'json',
                success: function (response) {

                    var len = response.length;
                    if (len != 0) {

                        $('#pyam').empty();
                        $('#pyam').append("<option value=''> -- Select Amount -- </option>");
                        for (var i = 0; i < len; i++) {
                            // var id = response[i]['inv'];
                            var bnid = response[i]['invd'];

                            var name = response[i]['amnt'];
                            var $el = $('#pyam');
                            if (edt == bnid) {
                                //  console.log(name);
                                $el.append($("<option selected></option>")
                                    .attr("value", bnid).text(name));


                            } else {
                                $el.append($("<option></option>")
                                    .attr("value", bnid).text(name));
                            }



                        }
                    } else {
                        $('#pyam').empty();
                        $('#pyam').append("<option value='0'>No Amount</option>");
                    }
                },
            });

        };
        //get invester account end
        // get  account start
        function getaccount(edt) {

            var auid = document.getElementById("auid").value;
            $.ajax({
                url: '<?= base_url(); ?>admin/getaccount',
                type: 'POST',
                data: {
                    auid: auid,
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len != 0) {
                        $('#acno').empty();
                        $('#acno').append("<option value=''> -- Select Account No -- </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['inid'];
                            var bnid = response[i]['bnid'];
                            var name = response[i]['acno'];
                            var $el = $('#acno');
                            if (edt == id) {
                                $el.append($("<option ></option>")
                                    .attr("value", bnid).text(name));
                            } else {
                                $el.append($("<option></option>")
                                    .attr("value", bnid).text(name));
                            }
                        }

                    } else {
                        $('#acno').empty();
                        $('#acno').append("<option value='0'>No Account</option>");
                    }

                },
            });
        };
        //get invester account end

        // get total invest start
        //function getToInst(id) {
        //
        //    var pyam = document.getElementById(id).value;
        //    console.log(pyam);
        //
        //    $.ajax({
        //        url: '<?//= base_url(); ?>//admin/getToInst',
        //        type: 'POST',
        //        data: {
        //            pyam: pyam,
        //        },
        //        dataType: 'json',
        //        success: function (response) {
        //
        //            console.log(response[0]['amnt']);
        //            var aa = response[0]['amnt'];
        //            var bb = response[0]['tort'];
        //            var cc = aa * (bb / 100);
        //
        //           // document.getElementById("toin").value = cc;
        //
        //
        //        }
        //
        //    });
        //
        //};
        //get total invest end

        //get invest start
        function getInst(id) {
            var todt = document.getElementById("todt").value;
            var invd = document.getElementById(id).value;
            $.ajax({
                url: '<?= base_url(); ?>admin/getInst',
                type: 'POST',
                data: {
                    invd: invd,
                },
                dataType: 'json',
                success: function (response) {
                    var pamd = response[0]['pamd'];
                    var stdt = response[0]['stdt'];
                    var mnrt = response[0]['mnrt'];
                    var amnt = response[0]['amnt'];
                    document.getElementById("perid").value = response[0]['perd'];
                    document.getElementById("dunm").value =  response[0]['dunm'];
                    ;
                    console.log(response[0]['perd'])
                    if (pamd == 1) {
                        var dt = new Date(todt);
                        dt.setDate(dt.getDate() - 1);
                        // console.log(dt + 'daily');

                    }

                    else if
                    (pamd == 2) {
                        var dt = new Date(todt);
                        dt.setDate(dt.getDate() - 7);
                        // console.log(dt + 'weekly');

                    }

                    else if (pamd == 3) {

                        var dt = new Date(todt);
                        dt.setDate(dt.getDate() - 30);
                        // console.log(dt + 'month');

                    }

                    else if (pamd == 4) {

                        var dt = new Date(todt);
                        dt.setDate(dt.getDate() - 90);
                        // console.log(dt + 'month');

                    }

                    else if (pamd == 5) {

                        var dt = new Date(todt);
                        dt.setDate(dt.getDate() - 365);
                        //console.log(dt + 'month');

                    }
                    var date1 = new Date(dt);
                    var date2 = new Date(todt);
                    // console.log(date1 + 'aaaa');
                    // console.log(date2 + 'bbbbb');
                    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
                    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
                    //
                    // console.log(timeDiff + 'diffDays');
                    // console.log(diffDays + 'datttt');

                    var invest = (amnt * mnrt / 100) * diffDays;

                    // console.log(invest + 'xxxxxxxxx');

                    document.getElementById("amnt").value = invest;


                }

            });


        }

        //get invest end

        //add interrest payment load start
        function srchInsPynt() {
            console.log('yyyyyyyy')
            var pyam = document.getElementById("pyam").value;
            var acno = document.getElementById("acno").value;

            console.log(pyam);

            $.ajax({
                url: '<?= base_url(); ?>admin/getInpy',
                type: 'POST',
                data: {
                    pyam: pyam,
                    acno: acno
                },
                dataType: 'json',
                success: function (data) {
                    console.log('bbbbbbbbb');
                    var len = data.length;

                    if (len > 0) {
                        console.log(data[0]['amunt']);
                        document.getElementById("insDivPy").style.display = 'block';
                        document.getElementById("topyy").innerHTML = data[0]['amunt'];


                    } else {
                        document.getElementById("insDivPy").style.display = 'none';
                        swal({
                            title: "",
                            text: "Invalide nic no Or no active investor Or no active bank",
                            type: "warning"
                        });
                    }
                },
            });

        };
        //add interrest payment end


        // payment add form start
        $("#addInPy").click(function (e) {
            e.preventDefault();
            //  if ($(insvest_Add).valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addInPy",
                data: $("#addinPy_Add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    swal({
                            title: "Investment Add",
                            text: " Investment Added !",
                            type: "success"
                        },
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal("Investment Failed!", 'aaaa', "error");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>admin/addInPy';
                    }, 20000);
                }
            });
            // } else {
            // }
        });
        // payment add form end


        //

        //button check start
        function chckBtn(id, inpu) {
            if (id == 0) {
                document.getElementById(inpu).style.borderColor = "red";
            } else {
                document.getElementById(inpu).style.borderColor = "";
            }
        }

        //button check end
        //
        //investor bank search table start
        function searchInvestorPayment() {

            // var fill_stat = document.getElementById('fill_stat').value;
            // if (fill_stat == '-') {
            //     document.getElementById('fill_stat').style.borderColor = "red";
            // }
            // else{
            // document.getElementById('fill_stat').style.borderColor = "";
            $('#dataTbInsPayment').DataTable().clear();
            $('#dataTbInsPayment').DataTable({
                "destroy": true,
                "cache": false,
                "processing": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                },
                "lengthMenu": [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "All"]
                ],
                "serverSide": true,
                "columnDefs": [{
                    className: "text-left", //column text align adjust
                    "targets": [1, 2, 3, 4] //column array names
                }, {
                    className: "text-center",
                    "targets": [0, 5, 8,9,10]
                },
                    {
                        className: "text-right",
                        "targets": [6, 7, 8]
                    }

                ],
                //"order": [[7, "asc"]], //ASC  desc
                "aoColumns": [ //columns (array)
                    {
                        sWidth: '5%' //columns width set (array)
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '5%'
                    },
                    {
                        sWidth: '5%'
                    },
                    {
                        sWidth: '5%'
                    },
                    {
                        sWidth: '5%'
                    },

                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/searchInvestPyment',
                    type: 'post',
                    data: {
                        //  fill_stat: fill_stat,
                    }
                }
            });
            // }
        }
        //investor search table end
        //

        // payment  edit from filling start
        function editPaymt(invd, typ) {
            if (typ == 'edt') {
                $('#hed').text("Update Investment ");
                $('#editInsvest').text("Update");
                document.getElementById("edit_func").value = '1';
            } else if (typ == 'app') {
                $('#hed').text("Approval Investment  :");
                $('#editInsvest').text("Approvel");
                document.getElementById("edit_func").value = '2';
            }
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/vewinvest",
                data: {
                    invd: invd
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    for (var i = 0; i < len; i++) {
                        document.getElementById("bnid_edit").value = response[i]['ivid'];
                        document.getElementById("inic_edit").value = response[i]['inic'];
                        document.getElementById("amnt_edit").value = response[i]['amnt'];
                        document.getElementById("tort_edit").value = response[i]['tort'];
                        document.getElementById("stdt_edit").value = response[i]['stdt'];
                        document.getElementById("perd_edit").value = response[i]['perd'];
                        document.getElementById("mtdt_edit").value = response[i]['mtdt'];
                        document.getElementById("inrt_edit").value = response[i]['inrt'];
                        document.getElementById("remk_edit").value = response[i]['remk'];
                        document.getElementById("acno_edit").value = response[i]['acno'];
                        document.getElementById("pamd_edit").value = response[i]['pamd'];
                        document.getElementById("idnm_edit").value = response[i]['idnm'];
                        document.getElementById("idcm_edit").value = response[i]['idcm'];
                        document.getElementById("idac_edit").value = response[i]['idac'];
                        document.getElementById("edit_invd").value = response[i]['invd'];
                        if (response[i]['inpy'] == 1) {
                            document.getElementById("inpy_edit").checked = true;
                        } else {
                            document.getElementById("inpy_edit").checked = false;
                        }
                        if (response[i]['idpy'] == 1) {
                            document.getElementById("idpy_edit").checked = true;
                        } else {
                            document.getElementById("idpy_edit").checked = false;
                        }
                        srchInsEdit(response[i]['inic'], 'inic_edit');
                        srchIntroEdit(response[i]['idnm'], 'idnm_edit');
                        insdDtiledit();
                        indDtiledit();
                    }
                }
            })
        }

        //payment bank edit from filling end

        //edit investment load nic start
        function srchInsEdit(nic, htmlid) {
            var inic_edit = document.getElementById(htmlid).value;
            if (inic_edit.length == 10 || inic_edit.length == 12) {
                document.getElementById("inic_edit").style.borderColor = "";
                $.ajax({
                    url: '<?= base_url(); ?>admin/getInvest_InvEdit',
                    type: 'POST',
                    data: {
                        inic_edit: inic_edit,
                    },
                    dataType: 'json',
                    success: function (data) {
                        var len = data.length;
                        if (len > 0) {
                            document.getElementById("insDiv_Edit").style.display = 'block';
                            document.getElementById("innm_Edit").innerHTML = data[0]['innm'];
                            document.getElementById("hoad_Edit").innerHTML = data[0]['hoad'];
                            document.getElementById("inicc_Edit").innerHTML = data[0]['inic'];
                            document.getElementById("mobii_Edit").innerHTML = data[0]['mobi'];
                            document.getElementById("auid_edit").value = data[0]['auid'];
                            document.getElementById("bnid_edit").value = data[0]['bnid'];
                            document.getElementById("editInsvest").style.display = '';
                            loadbankacc_edit();
                        } else {
                            document.getElementById("insDiv_Edit").style.display = 'none';
                            document.getElementById("inic_edit").style.borderColor = "red";
                            document.getElementById("editInsvest").style.display = 'none';
                            swal({
                                title: "",
                                text: "Invalide nic no Or no active investor Or no active bank",
                                type: "warning"
                            });
                        }
                    },
                });
            } else {
                document.getElementById("inic_edit").style.borderColor = "red";
                document.getElementById("insDiv_Edit").style.display = 'none';
                document.getElementById("editInsvest").style.display = 'none';
            }
        };





    </script>