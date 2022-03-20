<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li class="active"> Day End Reconciliation</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Day End Reconciliation </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#step1"><span><i
                                        class="fa fa-plus" title=""></i></span> Today Reconciliation
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
                                            onchange="getExe(this.value,'ofcr',ofcr.value);chckBtn(this.value,'brch')">
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
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<?= date("Y-m-d"); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<?= date("Y-m-d"); ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchRecnsi()"
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
                                           id="dataTbRecons" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">DATE</th>
                                            <th class="text-center">TTL VALUE</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">PROCESS DATE/TIME</th>
                                            <th class="text-center">PROCESS USER</th>
                                            <th class="text-center">OPTION</th>
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
<form class="form-horizontal" id="recncil_add" name="recncil_add" action="" method="post">

    <!-- STEP 1 -->
    <div class="modal" id="step1" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation</h4>
                    <div class="number">
                        <ul>
                            <li class="active"><a href="#">Summery </a></li>
                            <li><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3</a></li>
                            <li><a href="#">Step 4</a></li>
                            <li><a href="#">Step 5</a></li>
                            <li><a href="#">Step 6</a></li>
                            <!--<li><a href="#">Step 7</a></li>-->

                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                                <div class="col-md-9 col-xs-6">
                                                    <select class="form-control" name="rncBrn" id="rncBrn"
                                                            onchange="chckBtn(this.value,'rncBrn');">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] == 'all') {
                                                            } else {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Date</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <input type="text" class="form-control datepicker" readonly
                                                           id="rcdt" name="rcdt" value="<?= date('Y-m-d'); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 text-right"></label>
                                                <div class="col-md-6 col-xs-12 text-right">
                                                    <button type="button form-control  " onclick="getRcnciData()"
                                                            class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" id="func" name="func">
                                        <input type="hidden" id="auid" name="auid">
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive" id="tbDiv" style="display: none;">
                                                <table class="table table-bordered dataTable table-striped table-actions"
                                                       id="tblSumry" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">NO</th>
                                                        <th class="text-center">CATEGORY</th>
                                                        <th class="text-center">TOTAL AMOUNT</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">1</td>
                                                        <td>Disbursement Loan</td>
                                                        <td id="amt1" align="right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">2</td>
                                                        <td>Disbursement RTN Loan</td>
                                                        <td id="amt2" align="right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">3</td>
                                                        <td>Denomination</td>
                                                        <td id="amt3" align="right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">4</td>
                                                        <td>General Voucher</td>
                                                        <td id="amt4" align="right"></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center">5</td>
                                                        <td>Petty Cash Details</td>
                                                        <td id="amt5" align="right"></td>
                                                    </tr>
                                                    </tbody>
                                                    <tfoot>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="ttl" class="text-right"></th>
                                                    </tfoot>

                                                    <input type="hidden" id="dsln" name="dsln"/>
                                                    <!-- DISBURS LOAN TTL-->
                                                    <input type="hidden" id="drln" name="drln"/>
                                                    <!-- DISBURS RTN LOAN TTL-->
                                                    <input type="hidden" id="tdnm" name="tdnm"/>
                                                    <!-- TTL DENOMINATION -->
                                                    <input type="hidden" id="ttgv" name="ttgv"/> <!-- TTL GENERAL VOU-->
                                                    <input type="hidden" id="ptch" name="ptch"/> <!-- TTL PRTTY CASH-->
                                                    <!--<input type="text" id="" name=""/>-->

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right" id="nxtBtn1" data-toggle="modal"
                            onclick="step2()"
                            title=" " data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- STEP 2 -->
    <div class="modal" id="step2" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation (Paid
                        Loan Check)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li class="active"><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3 </a></li>
                            <li><a href="#">Step 4 </a></li>
                            <li><a href="#">Step 5 </a></li>
                            <li><a href="#">Step 6 </a></li>
                        </ul>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered  "
                                                   id="dataTbPaidln" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">BRN/CNT</th>
                                                    <th class="text-center">CUST NAME</th>
                                                    <th class="text-center">LNNO</th>
                                                    <th class="text-center">PRDT</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">TO HAND</th>
                                                    <th class="text-center">PAYE BY</th>
                                                    <th class="text-center">PAYE DATE</th>
                                                    <th class="text-center">CHCK</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th><input type="hidden" id="len_pln" name="len_pln"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th id="tot_amt"></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step1">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" onclick="step3()"
                            id="nxtBtn2" data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- STEP 3 -->
    <div class="modal" id="step3" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation (Unpaid
                        Loan Check)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li><a href="#">Step 1</a></li>
                            <li class="active"><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3</a></li>
                            <li><a href="#">Step 4</a></li>
                            <li><a href="#">Step 5</a></li>
                            <li><a href="#">Step 6</a></li>

                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered  "
                                                   id="dataTbUnpaidln" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">BRN/CNT</th>
                                                    <th class="text-center">CUST NAME</th>
                                                    <th class="text-center">LNNO</th>
                                                    <th class="text-center">PRDT</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">TO HAND</th>
                                                    <th class="text-center">DISB BY</th>
                                                    <th class="text-center">DISB DATE</th>
                                                    <th class="text-center">CHCK</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th></th>
                                                <th><input type="hidden" id="len_upln" name="len_upln"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th id="tot_amt2"></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step2">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" onclick="step4()"
                            id="nxtBtn3" data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- STEP 4 -->
    <div class="modal" id="step4" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation
                        (Denomination Check )
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li><a href="#">Step 1 </a></li>
                            <li><a href="#">Step 2 </a></li>
                            <li class="active"><a href="#">Step 3 </a></li>
                            <li><a href="#">Step 4 </a></li>
                            <li><a href="#">Step 5 </a></li>
                            <li><a href="#">Step 6 </a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                   id="dataTbOfcdenomi" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">BRANCH</th>
                                                    <th class="text-center">OFFICER</th>
                                                    <th class="text-center">CENTERS</th>
                                                    <th class="text-center">REPAYMNTS</th>
                                                    <th class="text-center">CR BY</th>
                                                    <th class="text-center">COLLECTION</th>
                                                    <th class="text-center">SYSTEM TTL</th>
                                                    <th class="text-center">CHECK</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <th></th>
                                                <th><input type="hidden" id="len_dnm" name="len_dnm"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                                </tfoot>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step3">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" onclick="step5()"
                            data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- STEP 5 -->
    <div class="modal" id="step5" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation (General
                        Voucher)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3</a></li>
                            <li class="active"><a href="#">Step 4 </a></li>
                            <li><a href="#">Step 5 </a></li>
                            <li><a href="#">Step 6 </a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                   id="dataTbVoucher" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">BRANCH</th>
                                                    <th class="text-center">DATE</th>
                                                    <th class="text-center">VOUCHER NO</th>
                                                    <th class="text-center">CUSTOMER NAME</th>
                                                    <th class="text-center">VOU TYPE</th>
                                                    <th class="text-center">PAY TYPE</th>
                                                    <th class="text-center">AMOUNT</th>
                                                    <th class="text-center">CHECK</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <th></th>
                                                <th><input type="hidden" id="len_gnv" name="len_gnv"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step4">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal" onclick="step6()"
                            title=""
                            data-backdrop="static">Next
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- STEP 6 -->
    <div class="modal" id="step6" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation (Petty
                        Cash)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3</a></li>
                            <li><a href="#">Step 4</a></li>
                            <li class="active"><a href="#">Step 5 </a></li>
                            <li><a href="#">Step 6</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                   id="dataTbPtyVou" width="100%">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">NO</th>
                                                    <th class="text-center">BRCH</th>
                                                    <th class="text-center">OFFICER</th>
                                                    <th class="text-center">ACCOUNT</th>
                                                    <th class="text-center"> PAY DATE</th>
                                                    <th class="text-center"> PAY AMOUNT</th>
                                                    <th class="text-center"> CREATE BY</th>
                                                    <th class="text-center"> CREATE DATE</th>
                                                    <th class="text-center"> OPTION</th>
                                                </tr>
                                                </thead>
                                                <tfoot>
                                                <th></th>
                                                <th><input type="hidden" id="len_ptc" name="len_ptc"></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                </tfoot>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step5">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            onclick="step7()"
                            data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- STEP 7 -->
    <div class="modal" id="step7" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Reconciliation (Total
                        Denomination)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#">Summery </a></li>
                            <li><a href="#">Step 1</a></li>
                            <li><a href="#">Step 2</a></li>
                            <li><a href="#">Step 3</a></li>
                            <li><a href="#">Step 4</a></li>
                            <li><a href="#">Step 5</a></li>
                            <li class="active"><a href="#">Step 6 </a></li>

                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Collector Total</label>
                                                <div class="col-md-4 col-xs-12">
                                                    <input type="text" class="form-control"
                                                           placeholder="Total Amount" id="cttl" name="cttl"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-12 control-label">Remarks</label>
                                                <div class="col-md-4 col-xs-12">
                                                    <input type="text" class="form-control"
                                                           placeholder="Remarks" id="remk" name="remk"/>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row" id="derf">
                                             <div class="col-md-12">
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">Collector
                                                         Total</label>
                                                     <div class="col-md-4">
                                                         <input type="hidden" id="hctl" name="hctl" readonly/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total Amount" id="cttl" name="cttl"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">5000
                                                         x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i1 pybx"
                                                                placeholder="count"
                                                                id="x5000" name="x5000"
                                                                onkeyup='kydown(1,this.value,event,5000);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total 5000" id="st1" name="st1"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">2000
                                                         x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i2 pybx"
                                                                placeholder="count"
                                                                id="x2000" name="x2000"
                                                                onkeyup='kydown(2,this.value,event,2000);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total 2000" id="st2" name="st2"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">1000
                                                         x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i3 pybx"
                                                                placeholder="count"
                                                                id="x1000" name="x1000"
                                                                onkeyup='kydown(3,this.value,event,1000);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control "
                                                                placeholder="Total 1000" id="st3" name="st3"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">500
                                                         x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i4 pybx"
                                                                placeholder="count"
                                                                id="x500" name="x500"
                                                                onkeyup='kydown(4,this.value,event,500);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control "
                                                                placeholder="Total 500" id="st4" name="st4"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">100
                                                         x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i5 pybx"
                                                                placeholder="count"
                                                                id="x100" name="x100"
                                                                onkeyup='kydown(5,this.value,event,100);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control "
                                                                placeholder="Total 100" id="st5" name="st5"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">50 x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i6 pybx"
                                                                placeholder="count"
                                                                id="x50" name="x50"
                                                                onkeyup='kydown(6,this.value,event,50);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total 50" id="st6" name="st6"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">20 x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i7 pybx"
                                                                placeholder="count"
                                                                id="x20" name="x20"
                                                                onkeyup='kydown(7,this.value,event,20);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total 20" id="st7" name="st7"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">10 x</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i8 pybx"
                                                                placeholder="count"
                                                                id="x10" name="x10"
                                                                onkeyup='kydown(8,this.value,event,10);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control "
                                                                placeholder="Total 10" id="st8" name="st8"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">Coins</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i9 pybx"
                                                                placeholder="No of Coins"
                                                                id="coin" name="coin"
                                                                onkeyup='kydown(9,this.value,event);'/>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control i10 pybx"
                                                                onkeyup="calTotal()"
                                                                placeholder="Coins Total Amount" id="coinTtl"
                                                                name="coinTtl"/>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="col-md-4 col-xs-12 control-label">TOTAL</label>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="hidden" class="form-control" id="ctl1"
                                                                name="ctl1"
                                                                readonly/>
                                                         <input type="hidden" class="form-control" id="nocn"
                                                                name="nocn"
                                                                readonly/>
                                                         <input type="hidden" class="form-control" id="norp"
                                                                name="norp"
                                                                readonly/>
                                                         <input type="hidden" class="form-control" id="ttldnm"
                                                                name="ttldnm" readonly/>

                                                         <span id="stat" style="color:#FF0004;"></span>
                                                     </div>
                                                     <div class="col-md-4 col-xs-12">
                                                         <input type="text" class="form-control"
                                                                placeholder="Total Amount" id="ttlamt"
                                                                name="ttlamt"
                                                                readonly/>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>-->


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step6">Back
                    </button> <!-- onclick="step5()" -->
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            id="prsbtn"
                            data-backdrop="static">Process
                    </button>
                </div>

            </div>
        </div>
    </div>

</form>
<!--End Add Model -->

</body>
<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbRecons').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        // Data Tables
        $('#tblSumry').DataTable({
            destroy: true,
            "cache": false,
            searching: false,
            bPaginate: false,
        });

        $.validator.addClassRules("pybx", {
            digits: true,
            //currency : true
        });

        $.validator.addClassRules("pybxe", {
            digits: true,
        });

        $("#recncil_add").validate({
            rules: {
                rncBrn: {
                    required: true,
                    notEqual: '0'
                },
                dnusr: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                rncBrn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                dnusr: {
                    required: 'Please select user',
                    notEqual: "Please select user"
                },
            }
        });

        $("#dnom_edt").validate({  // Product loan validation
            rules: {
                dnmBrnEdt: {
                    required: true,
                    notEqual: '0'
                },
                dnusrEdt: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                dnmBrnEdt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                dnusrEdt: {
                    required: 'Please select user',
                    notEqual: "Please select user"
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

    function step2() {
        if ($("#recncil_add").valid()) {

            var brn = document.getElementById('rncBrn').value;
            var todt = document.getElementById('rcdt').value;

            $.ajax({
                url: "<?= base_url(); ?>User/chkAlrdyReconsi",
                type: "POST",
                data: {
                    brn: brn,
                    todt: todt
                },
                dataType: 'json',
                success: function (response) {
                    if (response === true) {
                        swal({title: "", text: "Already Today Reconciliation", type: "info"},);
                    } else {
                        $('#step1').modal('hide');
                        $('#step2').modal('show');

                        srchPaidln();
                    }
                },
                error: function () {
                    swal({title: "", text: "Denomination edit Failed", type: "error"},);

                }
            });
        }
    }

    function step3() {
        $('#step2').modal('hide');
        $('#step3').modal('show');
        srchUnpaidln();
    }

    function step4() {
        if ($("#recncil_add").valid()) {
            $('#step3').modal('hide');
            $('#step4').modal('show');
            srchDenomi();
        }
    }

    function step5() {
        if ($("#recncil_add").valid()) {
            $('#step4').modal('hide');
            $('#step5').modal('show');
            srchGenvou();
        }
    }

    function step6() {
        if ($("#recncil_add").valid()) {
            $('#step5').modal('hide');
            $('#step6').modal('show');
            srchPtycash();
        }
    }

    function step7() {
        if ($("#recncil_add").valid()) {
            $('#step6').modal('hide');
            $('#step7').modal('show');
            srchPtycash();
        }
    }


    // ENTER KEY PRESS NEXT INPUT AUTO FORCUS
    function kydown(indx, val, event, amt) {
        if (indx != 9) {
            var subttl = (+val * +amt);
            document.getElementById('st' + indx).value = subttl;
        }
        if (event.keyCode == 13) {
            if (indx == 9) {      // COINS
                document.getElementById('coinTtl').focus();
            } else {
                var x = indx + 1; // NEXT INPUT BOX
                $('.i' + x).focus();
            }
        }
        calTotal();
    }

    // CAL TOTAL VALUE
    function calTotal() {
        var ttl = 0;
        for (var i = 1; i < 9; i++) {
            ttl = +ttl + +document.getElementById('st' + i).value;
        }
        var ttl2 = +ttl + +document.getElementById('coinTtl').value;
        document.getElementById('ttlamt').value = numeral(ttl2).format('0,0.00');
        document.getElementById('ttldnm').value = ttl2;

        var tvl = ttl2;
        var svl = document.getElementById('ctl1').value;

    }

    //RECANCILATION SUMMERY  - STEP 0
    function getRcnciData() {
        var brn = document.getElementById('rncBrn').value;
        var rcdt = document.getElementById('rcdt').value;

        if (brn == '0') {
            document.getElementById('rncBrn').style.borderColor = "red";
        } else {
            document.getElementById('rncBrn').style.borderColor = "";
            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/getRcnciData",
                data: {
                    brn: brn,
                    rcdt: rcdt
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len > 0) {

                        document.getElementById('tbDiv').style.display = "block";
                        $('#tblSumry').DataTable().clear();

                        document.getElementById('amt1').innerHTML = parseFloat(response[0]['dsln']).toFixed(2);
                        document.getElementById('amt2').innerHTML = parseFloat(-response[0]['dsntln']).toFixed(2);
                        document.getElementById('amt3').innerHTML = parseFloat(response[0]['dnmt']).toFixed(2);
                        document.getElementById('amt4').innerHTML = parseFloat(-response[0]['gvam']).toFixed(2);
                        document.getElementById('amt5').innerHTML = parseFloat(-response[0]['ptmt']).toFixed(2);

                        document.getElementById('dsln').value = response[0]['dsln'];
                        document.getElementById('drln').value = response[0]['dsntln'];
                        document.getElementById('tdnm').value = response[0]['dnmt'];
                        document.getElementById('ttgv').value = response[0]['gvam'];
                        document.getElementById('ptch').value = response[0]['ptmt'];


                        var ttl = (+response[0]['dsln'] - +response[0]['dsntln'] + +response[0]['dnmt'] - +response[0]['gvam'] - +response[0]['ptmt']);
                        document.getElementById('ttl').innerHTML = numeral(ttl).format('0,0.00');

                    } else {
                        document.getElementById('tbDiv').style.display = "none";
                    }
                }
            })
        }
    }

    // DISBURS LOAN DETAILS - STEP 1
    function srchPaidln() {                                                       // Search btn
        var brn = document.getElementById('rncBrn').value;
        var todt = document.getElementById('rcdt').value;

        $('#dataTbPaidln').DataTable().clear();
        $('#dataTbPaidln').DataTable({
            "destroy": true,
            "cache": false,
            "bPaginate": false,
            "processing": true,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            //"serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [1, 2, 3, 7, 8]},
                {className: "text-center", "targets": [0, 4, 9]},
                {className: "text-right", "targets": [5, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[8, "ASC"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '15%'},    // ccnt / brco
                {sWidth: '15%'},    // cust name
                {sWidth: '5%'},    // cust no
                {sWidth: '5%'},     // nic
                {sWidth: '5%'},     // lnno
                {sWidth: '5%'},     //
                {sWidth: '15%'},     // tody pymt
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/getPaidln',
                type: 'post',
                data: {
                    brn: brn,
                    todt: todt
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                document.getElementById("len_pln").value = display.length;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
            },
        });
    }

    // DISBURS UNCHECK LOAN DETAILS - STEP 2
    function srchUnpaidln() {
        var brn = document.getElementById('rncBrn').value;
        var todt = document.getElementById('rcdt').value;

        $('#dataTbUnpaidln').DataTable().clear();
        $('#dataTbUnpaidln').DataTable({
            "destroy": true,
            "cache": false,
            "bPaginate": false,
            "processing": true,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            //"serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [1, 2, 3, 7, 8]},
                {className: "text-center", "targets": [0, 4, 9]},
                {className: "text-right", "targets": [5, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[8, "ASC"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '15%'},    // ccnt / brco
                {sWidth: '15%'},    // cust name
                {sWidth: '5%'},    // cust no
                {sWidth: '5%'},     // nic
                {sWidth: '5%'},     // lnno
                {sWidth: '5%'},     //
                {sWidth: '15%'},     // tody pymt
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>user/getUnpaidln',
                type: 'post',
                data: {
                    brn: brn,
                    todt: todt
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                document.getElementById("len_upln").value = display.length;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));

            },
        });

    }

    // DENOMINATION SEARCH  - STEP 3
    function srchDenomi() {
        var brn = document.getElementById('rncBrn').value;
        var todt = document.getElementById('rcdt').value;

        $('#dataTbOfcdenomi').DataTable().clear();
        $('#dataTbOfcdenomi').DataTable({
            "destroy": true,
            "cache": false,
            "processing": true,
            "bPaginate": false,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "columnDefs": [
                {className: "text-left", "targets": [1, 2]},
                {className: "text-center", "targets": [0, 3, 4, 5, 8]},
                {className: "text-right", "targets": [6, 7]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},    // br
                {sWidth: '10%'},    // ofcr
                {sWidth: '10%'},    // denomi date
                {sWidth: '10%'},    // pay type
                {sWidth: '10%'},     //
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>user/srchOfzerdnmi',
                type: 'post',
                data: {
                    brn: brn,
                    dte: todt
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                document.getElementById("len_dnm").value = display.length;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                //COLUMN 3 TTL
                var t3 = api.column(3).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(3).footer()).html(t3);
                //COLUMN 4 TTL
                var t4 = api.column(4).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(4).footer()).html(t4);
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

            },
        });
    }

    // GENERAL VOUCHER  - STEP 4
    function srchGenvou() {
        var brn = document.getElementById('rncBrn').value;
        var todt = document.getElementById('rcdt').value;

        $('#dataTbVoucher').DataTable().clear();
        $('#dataTbVoucher').DataTable({
            "destroy": true,
            "cache": false,
            "bPaginate": false,
            "processing": true,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "columnDefs": [
                {className: "text-left", "targets": [1, 2, 3, 4, 6]},
                {className: "text-center", "targets": [0, 5, 8]},
                {className: "text-right", "targets": [7]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[3, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},    // br
                {sWidth: '10%'},    // date
                {sWidth: '10%'},    // voucher no
                {sWidth: '15%'},    // customer name
                {sWidth: '10%'},     // Vou type
                {sWidth: '10%'},     // pay type
                {sWidth: '5%'},     // mode
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>user/getGenvouc',
                type: 'post',
                data: {
                    brn: brn,
                    todt: todt
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                document.getElementById("len_gnv").value = display.length;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                //COLUMN 7 TTL
                var t7 = api.column(7).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
            },
        });

    }

    // PETTY CASH DETAILS  - STEP 5
    function srchPtycash() {
        var brn = document.getElementById('rncBrn').value;
        var todt = document.getElementById('rcdt').value;

        $('#dataTbPtyVou').DataTable().clear();
        $('#dataTbPtyVou').DataTable({
            "destroy": true,
            "cache": false,
            "processing": true,
            "bPaginate": false,
            //"orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "columnDefs": [
                {className: "text-left", "targets": [2, 3, 4, 6, 7]},
                {className: "text-center", "targets": [0, 1, 8]},
                {className: "text-right", "targets": [5]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[2, "desc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/getPtycshtoday',
                type: 'post',
                data: {
                    brn: brn,
                    todt: todt
                }
            },
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                document.getElementById("len_ptc").value = display.length;

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                            i : 0;
                };
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
            },
        });
    }

    // ADD DENOMINATION
    // $("#edtbtn").click(function (e) {
    $("#prsbtn").on('click', function (e) {
        e.preventDefault();

        if ($("#recncil_add").valid()) {
            swal({
                    title: "Are you sure?",
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
                        document.getElementById('prsbtn').style.display = "none";

                        $('#modalAdd').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/addBrnchReconsi",
                            data: $("#recncil_add").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Branch Reconciliation Done", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Branch Reconciliation Failed", type: "error"},
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

    // SEARCH RECONCILIATION
    function srchRecnsi() {
        var brn = document.getElementById('brch').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbRecons').DataTable().clear();
            $('#dataTbRecons').DataTable({
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
                    {className: "text-left", "targets": [1, 6]},
                    {className: "text-center", "targets": [0, 2, 4, 5, 7]},
                    {className: "text-right", "targets": [3]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[2, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br
                    {sWidth: '10%'},    // date
                    {sWidth: '10%'},    // value
                    {sWidth: '10%'},    // stat
                    {sWidth: '10%'},    // process date time
                    {sWidth: '5%'},     // process  user
                    {sWidth: '5%'}      // option
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchReconsiltion',
                    type: 'post',
                    data: {
                        brn: brn,
                        frdt: frdt,
                        todt: todt
                    }
                }
            });

        }
    }

    // OLD RECONSILATION RUN
    function oldReconsi(auid) {

        $.ajax({
            url: "<?= base_url(); ?>User/getReconsidata",
            type: "POST",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                if (response.length > 0) {
                    document.getElementById('func').value = 1;
                    document.getElementById('auid').value = response[0]['rcid'];
                    document.getElementById('rncBrn').value = response[0]['brid'];
                    document.getElementById('rcdt').value = response[0]['date'];
                    $('#step1').modal('show');
                }
            },
            error: function () {
                swal({title: "", text: "Denomination edit Failed", type: "error"},);
            }
        });


    }


</script>