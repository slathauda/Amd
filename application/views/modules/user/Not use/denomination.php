<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Payment Module</li>
    <li class="active"> Denomination</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Denomination </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus" title=""></i></span> Add Denomination
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
                            <!--<div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="frdt" id="frdt"
                                           value="<? /*= date("Y-m-d"); */ ?>">

                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="ofcr" id="ofcr"
                                            onchange="">
                                        <?php
                                        foreach ($execinfo as $exe) {
                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" name="todt" id="todt"
                                           value="<? /*= date("Y-m-d"); */ ?>">

                                </div>
                            </div>-->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker"
                                           id="srdt" name="srdt" value="<?= date('Y-m-d'); ?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchVou()"
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
                                           id="dataTbDeomi" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRNC</th>
                                            <th class="text-center">OFFICER</th>
                                            <th class="text-center">DENOMI DATE</th>
                                            <th class="text-center">REFERANCE NO</th>
                                            <th class="text-center">CENTER</th>
                                            <th class="text-center">REPAYMENT</th>
                                            <th class="text-center">VALUE</th>
                                            <th class="text-center">CR DATE</th>
                                            <th class="text-center">CR BY</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">OPTION</th>
                                        </tr>
                                        </thead>
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

<!--  Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Add Denomination </h4>
            </div>
            <form class="form-horizontal" id="dnom_add" name="dnom_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="row form-horizontal">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                                <div class="col-md-9 col-xs-6">
                                                    <select class="form-control" name="dnmBrn" id="dnmBrn"
                                                            onchange="chckBtn(this.value,'dnmBrn'); getOfcr(this.value,'dnusr',dnusr.value);">
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
                                                <label class="col-md-3 col-xs-6 control-label">Officer</label>
                                                <div class="col-md-9 col-xs-6">
                                                    <select class="form-control" name="dnusr" id="dnusr"
                                                            onchange="loadDelomi()">
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
                                                <label class="col-md-3 col-xs-12 control-label">Date</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <input type="text" class="form-control datepicker"
                                                           onchange="loadDelomi()"
                                                           id="dndt" name="dndt" value="<?= date('Y-m-d'); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table datatable table-bordered table-striped table-actions"
                                                       id="tbOfcrCollt" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">NO</th>
                                                        <th class="text-center">CENTER</th>
                                                        <th class="text-center">No Of REPAYMENT</th>
                                                        <th class="text-center">REPAYMENT VALUE</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
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

                                <div class="panel-body">
                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Denomination Details
                                        </h3>

                                        <div class="row" id="derf" style="display:none;">
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
                                                    <label class="col-md-4 col-xs-12 control-label">5000 x</label>
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
                                                    <label class="col-md-4 col-xs-12 control-label">2000 x</label>
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
                                                    <label class="col-md-4 col-xs-12 control-label">1000 x</label>
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
                                                    <label class="col-md-4 col-xs-12 control-label">500 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control i4 pybx"
                                                               placeholder="count"
                                                               id="x500" name="x500"
                                                               onkeyup='kydown(4,this.value,event,500);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 500" id="st4" name="st4" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">100 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control i5 pybx"
                                                               placeholder="count"
                                                               id="x100" name="x100"
                                                               onkeyup='kydown(5,this.value,event,100);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 100" id="st5" name="st5" readonly/>
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
                                                               placeholder="Total 50" id="st6" name="st6" readonly/>
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
                                                               placeholder="Total 20" id="st7" name="st7" readonly/>
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
                                                               placeholder="Total 10" id="st8" name="st8" readonly/>
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
                                                        <input type="hidden" class="form-control" id="ctl1" name="ctl1"
                                                               readonly/>
                                                        <input type="hidden" class="form-control" id="nocn" name="nocn"
                                                               readonly/>
                                                        <input type="hidden" class="form-control" id="norp" name="norp"
                                                               readonly/>
                                                        <input type="hidden" class="form-control" id="ttldnm"
                                                               name="ttldnm" readonly/>

                                                        <span id="stat" style="color:#FF0004;"></span>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total Amount" id="ttlamt" name="ttlamt"
                                                               readonly/>
                                                    </div>
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
                    <button type="button" class="btn btn-success" id="addBtn">Process</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!--  Edit Model -->
<div class="modal" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Edit Denomination </h4>
            </div>
            <form class="form-horizontal" id="dnom_edt" name="dnom_edt" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">

                                <div class="panel-body">
                                    <div class="row form-horizontal">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-3 col-xs-12 control-label">Branch</label>
                                                <div class="col-md-9 col-xs-6">
                                                    <select class="form-control" name="dnmBrnEdt" id="dnmBrnEdt"
                                                            onchange="chckBtn(this.value,'dnmBrnEdt'); getOfcr(this.value,'dnusrEdt',dnusr.value);">
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
                                                <label class="col-md-3 col-xs-6 control-label">Officer</label>
                                                <div class="col-md-9 col-xs-6">
                                                    <select class="form-control" name="dnusrEdt" id="dnusrEdt"
                                                            onchange="loadDelomiEdt()">
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
                                                <label class="col-md-3 col-xs-12 control-label">Date</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <input type="text" class="form-control" readonly
                                                           id="dndtEdt" name="dndtEdt" value="<?= date('Y-m-d'); ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table datatable table-bordered table-striped table-actions"
                                                       id="tbOfcrColltEdt" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">NO</th>
                                                        <th class="text-center">CENTER</th>
                                                        <th class="text-center">No Of REPAYMENT</th>
                                                        <th class="text-center">REPAYMENT VALUE</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
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

                                <div class="panel-body">
                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-user"></span> Denomination Details
                                        </h3>

                                        <div class="row" id="derfEdt" style="display:block;">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Collector
                                                        Total</label>
                                                    <div class="col-md-4">
                                                        <input type="hidden" id="hctl" name="hctl" readonly/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total Amount" id="cttlEdt" name="cttlEdt"
                                                               readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">5000 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei1 pybxe"
                                                               placeholder="count"
                                                               id="x5000Edt" name="x5000Edt"
                                                               onkeyup='kydownEdt(1,this.value,event,5000);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total 5000" id="est1" name="est1"
                                                               readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">2000 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei2 pybxe"
                                                               placeholder="count"
                                                               id="x2000Edt" name="x2000Edt"
                                                               onkeyup='kydownEdt(2,this.value,event,2000);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total 2000" id="est2" name="est2"
                                                               readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">1000 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei3 pybxe"
                                                               placeholder="count"
                                                               id="x1000Edt" name="x1000Edt"
                                                               onkeyup='kydownEdt(3,this.value,event,1000);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 1000" id="est3" name="est3"
                                                               readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">500 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei4 pybxe"
                                                               placeholder="count"
                                                               id="x500Edt" name="x500Edt"
                                                               onkeyup='kydownEdt(4,this.value,event,500);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 500" id="est4" name="est4" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">100 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei5 pybxe"
                                                               placeholder="count"
                                                               id="x100Edt" name="x100Edt"
                                                               onkeyup='kydownEdt(5,this.value,event,100);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 100" id="est5" name="est5" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">50 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei6 pybxe"
                                                               placeholder="count"
                                                               id="x50Edt" name="x50Edt"
                                                               onkeyup='kydownEdt(6,this.value,event,50);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total 50" id="est6" name="est6" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">20 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei7 pybxe"
                                                               placeholder="count"
                                                               id="x20Edt" name="x20Edt"
                                                               onkeyup='kydownEdt(7,this.value,event,20);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total 20" id="est7" name="est7" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">10 x</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei8 pybxe"
                                                               placeholder="count"
                                                               id="x10Edt" name="x10Edt"
                                                               onkeyup='kydownEdt(8,this.value,event,10);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control "
                                                               placeholder="Total 10" id="est8" name="est8" readonly/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">Coins</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei9 pybxe"
                                                               placeholder="No of Coins"
                                                               id="coinEdt" name="coinEdt"
                                                               onkeyup='kydownEdt(9,this.value,event);'/>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control ei10 pybxe"
                                                               onkeyup="calTotalEdt()"
                                                               placeholder="Coins Amount" id="coinTtlEdt"
                                                               name="coinTtlEdt"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-12 control-label">TOTAL</label>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="hidden" class="form-control" id="ctl1Edt"
                                                               name="ctl1Edt"
                                                               readonly/>
                                                        <input type="hidden" class="form-control" id="ttldnmEdt"
                                                               name="ttldnmEdt" readonly/>
                                                        <input type="hidden" class="form-control" id="auid"
                                                               name="auid"/>

                                                        <input type="hidden" class="form-control" id="nocnEdt"
                                                               name="nocnEdt"
                                                               readonly/>
                                                        <input type="hidden" class="form-control" id="norpEdt"
                                                               name="norpEdt"
                                                               readonly/>
                                                        <span id="stat" style="color:#FF0004;"></span>
                                                    </div>
                                                    <div class="col-md-4 col-xs-12">
                                                        <input type="text" class="form-control"
                                                               placeholder="Total Amount" id="ttlamtEdt"
                                                               name="ttlamtEdt"
                                                               readonly/>
                                                    </div>
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
                    <button type="button" class="btn btn-success" id="edtBtn">Process</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit Model -->


</body>
<script>

    $().ready(function () {

        // Data Tables
        $('#dataTbDeomi').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        // Data Tables
        $('#tbOfcrCollt').DataTable({
            destroy: true,
            "cache": false,
            searching: false,
            bPaginate: false,
        });

        document.getElementById('addBtn').setAttribute("class", "hidden");


        $.validator.addClassRules("pybx", {
           // digits: true,
            currency : true
        });

        $.validator.addClassRules("pybxe", {
            //digits: true,
            currency : true
        });

        $("#dnom_add").validate({  // Product loan validation
            rules: {
                dnmBrn: {
                    required: true,
                    notEqual: '0'
                },
                dnusr: {
                    required: true,
                    notEqual: '0'
                },
            },
            messages: {
                dnmBrn: {
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

    // LOAD DENOMINATION USER LOAD
    function getOfcr(id, idexc) {  // id - branch id / idexc - executive html id

        var x = "#" + idexc;  // executive id html
        var branch_id = id;

        if (branch_id == 0) {
            $(x).empty();
            $(x).append("<option value='0'>--Select Officer--</option>");
        } else {
            $.ajax({
                url: '<?= base_url(); ?>user/getExecutive',
                type: 'post',
                data: {
                    brch_id: branch_id
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len != 0) {
                        $(x).empty();
                        $(x).append("<option value='0'> -- Select Officer --</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['auid'];
                            var name = response[i]['fnme'] + ' ' + response[i]['lnme'];
                            var $el = $(x);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $(x).empty();
                        $(x).append("<option value='0'>No Officer</option>");
                    }
                }
            });
        }
    }

    // LOAD TODAY COLLECTION
    function loadDelomi() {
        var brn = document.getElementById('dnmBrn').value;
        var usr = document.getElementById('dnusr').value;
        var dndt = document.getElementById('dndt').value;

        if (brn == '0') {
            document.getElementById('dnmBrn').style.borderColor = "red";
        } else {
            document.getElementById('dnmBrn').style.borderColor = "";

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/chkAlrdyDenomi",
                data: {
                    brn: brn,
                    usr: usr,
                    dndt: dndt
                },
                dataType: 'json',
                success: function (response) {
                    if (response === true) {
                        swal({title: "", text: "Already added Denomination.", type: "info"});

                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/getTdyColl",
                            data: {
                                brn: brn,
                                usr: usr,
                                dndt: dndt
                            },
                            dataType: 'json',
                            success: function (response) {
                                var len = response.length;
                                if (len > 0) {
                                    document.getElementById('derf').style.display = "block";
                                } else {
                                    document.getElementById('derf').style.display = "none";
                                }

                                $('#tbOfcrCollt').DataTable().clear();
                                var t = $('#tbOfcrCollt').DataTable({
                                    destroy: true,
                                    searching: false,
                                    bPaginate: false,
                                    "ordering": false,
                                    "columnDefs": [
                                        {className: "text-left", "targets": [1]},
                                        {className: "text-center", "targets": [0, 2]},
                                        {className: "text-right", "targets": [0, 3]},
                                        {className: "text-nowrap", "targets": [1]}
                                    ],
                                    "aoColumns": [
                                        {sWidth: '10%'},
                                        {sWidth: '15%'},
                                        {sWidth: '10%'},
                                        {sWidth: '10%'}
                                    ],
                                    "footerCallback": function (row, data, start, end, display) {
                                        var api = this.api(), data;
                                        // converting to interger to find total
                                        var intVal = function (i) {
                                            return typeof i === 'string' ?
                                                i.replace(/[\$,]/g, '') * 1 :
                                                typeof i === 'number' ?
                                                    i : 0;
                                        };
                                        // computing column Total of the complete result
                                        //COLUMN 2 TTL
                                        var t2 = api.column(2).data().reduce(function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0);
                                        $(api.column(2).footer()).html(t2);

                                        //COLUMN 3 TTL
                                        var t3 = api.column(3).data().reduce(function (a, b) {
                                            return intVal(a) + intVal(b);
                                        }, 0);
                                        $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
                                        document.getElementById('cttl').value = numeral(t3).format('0,0.00');

                                        document.getElementById('ctl1').value = t3;
                                        document.getElementById('nocn').value = len;
                                        document.getElementById('norp').value = t2;
                                    },
                                });

                                for (var i = 0; i < len; i++) {

                                    t.row.add([
                                        i + 1,
                                        response[i]['cnnm'],
                                        response[i]['nrp'],
                                        parseFloat(response[i]['ttl']).toFixed(2)
                                    ]).draw(false);
                                }
                            }
                        })
                    }
                }
            })
        }
    }

    // EDIT TODAY COLLECTION
    function loadDelomiEdt() {
        var brn = document.getElementById('dnmBrnEdt').value;
        var usr = document.getElementById('dnusrEdt').value;
        var dndt = document.getElementById('dndtEdt').value;
        var auid = document.getElementById('auid').value;

        if (brn == '0') {
            document.getElementById('dnmBrn').style.borderColor = "red";
        } else {
            document.getElementById('dnmBrn').style.borderColor = "";

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/getTdyCollEdt",
                data: {
                    brn: brn,
                    usr: usr,
                    dndt: dndt,
                    auid : auid
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;
                    if (len > 0) {
                        document.getElementById('derf').style.display = "block";
                    } else {
                        document.getElementById('derf').style.display = "none";
                    }

                    $('#tbOfcrColltEdt').DataTable().clear();
                    var t = $('#tbOfcrColltEdt').DataTable({
                        destroy: true,
                        searching: false,
                        bPaginate: false,
                        "ordering": false,
                        "columnDefs": [
                            {className: "text-left", "targets": [1]},
                            {className: "text-center", "targets": [0, 2]},
                            {className: "text-right", "targets": [0, 3]},
                            {className: "text-nowrap", "targets": [1]}
                        ],
                        "aoColumns": [
                            {sWidth: '10%'},
                            {sWidth: '15%'},
                            {sWidth: '10%'},
                            {sWidth: '10%'}
                        ],
                        "footerCallback": function (row, data, start, end, display) {
                            var api = this.api(), data;
                            // converting to interger to find total
                            var intVal = function (i) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '') * 1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };
                            // computing column Total of the complete result
                            //COLUMN 2 TTL
                            var t2 = api.column(2).data().reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                            $(api.column(2).footer()).html(t2);

                            //COLUMN 3 TTL
                            var t3 = api.column(3).data().reduce(function (a, b) {
                                return intVal(a) + intVal(b);
                            }, 0);
                            $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
                            document.getElementById('cttlEdt').value = numeral(t3).format('0,0.00');

                            document.getElementById('ctl1Edt').value = t3;
                            document.getElementById('nocnEdt').value = len;
                            document.getElementById('norpEdt').value = t2;
                        },
                    });

                    for (var i = 0; i < len; i++) {

                        t.row.add([
                            i + 1,
                            response[i]['cnnm'],
                            response[i]['nrp'],
                            parseFloat(response[i]['ttl']).toFixed(2)
                        ]).draw(false);
                    }
                }
            })
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

        var tvl = ttl2; // COLLETION VALUE
        var svl = document.getElementById('ctl1').value; // SYSTEM VALUE

        //console.log(tvl + '**' + Math.round(tvl) + 'xxx' + svl);

        // PROCESS BTN SHOW HIDE
        //if ((tvl == svl) || tvl == (Math.round(svl))) {
        if (tvl == svl) {
            document.getElementById('addBtn').removeAttribute("class");
            document.getElementById('addBtn').setAttribute("class", "btn btn-success");
        } else {
            document.getElementById('addBtn').setAttribute("class", "hidden");
        }
    }

    // ********* EDIT ***************
    // ENTER KEY PRESS NEXT INPUT AUTO FORCUS
    function kydownEdt(indx, val, event, amt) {
        if (indx != 9) {
            var subttl = (+val * +amt);
            document.getElementById('est' + indx).value = subttl;
        }
        if (event.keyCode == 13) {
            if (indx == 9) {      // COINS
                document.getElementById('coinTtl').focus();
            } else {
                var x = indx + 1; // NEXT INPUT BOX
                $('.ei' + x).focus();
            }
        }
        calTotalEdt();
    }

    // CAL TOTAL VALUE
    function calTotalEdt() {
        var ttl = 0;
        for (var i = 1; i < 9; i++) {
            ttl = +ttl + +document.getElementById('est' + i).value;
        }
        var ttl2 = +ttl + +document.getElementById('coinTtlEdt').value;
        document.getElementById('ttlamtEdt').value = numeral(ttl2).format('0,0.00');
        document.getElementById('ttldnmEdt').value = ttl2;

        var tvl = ttl2;
        var svl = document.getElementById('ctl1Edt').value;

        // PROCESS BTN SHOW HIDE
        if (tvl == svl) {
            document.getElementById('edtBtn').removeAttribute("class");
            document.getElementById('edtBtn').setAttribute("class", "btn btn-success");
        } else {
            document.getElementById('edtBtn').setAttribute("class", "hidden");
        }
    }
    // ************* END EDIT ***************

    // ADD DENOMINATION
    $("#addBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#dnom_add").valid()) {
            $('#modalAdd').modal('hide');
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addDenomi",
                data: $("#dnom_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal({title: "", text: "Denomination added success", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Denomination added Failed", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    function srchVou() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exe = document.getElementById('ofcr').value;
        var srdt = document.getElementById('srdt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbDeomi').DataTable().clear();
            $('#dataTbDeomi').DataTable({
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
                    {className: "text-left", "targets": [ 2, 8]},
                    {className: "text-center", "targets": [0, 1,3, 4, 5, 6, 9, 10,11]},
                    {className: "text-right", "targets": [ 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[3, "asc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '10%'},    // ofcr
                    {sWidth: '10%'},    // denomi date
                    {sWidth: '10%'},     // rfcd
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '8%'},    // pay type
                    {sWidth: '10%'},     //
                    {sWidth: '7%'},
                    {sWidth: '8%'},
                    {sWidth: '10%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchDenomi',
                    type: 'post',
                    data: {
                        brn: brn,
                        exe: exe,
                        srdt: srdt
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


                    //COLUMN 5 TTL
                    var t5 = api.column(5).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(5).footer()).html(t5);
                    //COLUMN 6 TTL
                    var t6 = api.column(6).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(6).footer()).html(t6);
                    //COLUMN 7 TTL
                    var t7 = api.column(7).data().reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
                    $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));


                },
            });
        }
    }

    // EDIT DENOMINATION
    function edtDenomi(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewDnomin",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("dnmBrnEdt").value = response[i]['brco'];
                    document.getElementById("dnusrEdt").value = response[i]['dnsr'];
                    document.getElementById("dndtEdt").value = response[i]['dndt'];

                    document.getElementById("x5000Edt").value = response[i]['x5000'];
                    document.getElementById("x2000Edt").value = response[i]['x2000'];
                    document.getElementById("x1000Edt").value = response[i]['x1000'];
                    document.getElementById("x500Edt").value = response[i]['x500'];
                    document.getElementById("x100Edt").value = response[i]['x100'];
                    document.getElementById("x50Edt").value = response[i]['x50'];
                    document.getElementById("x20Edt").value = response[i]['x20'];
                    document.getElementById("x10Edt").value = response[i]['x10'];

                    document.getElementById("coinEdt").value = response[i]['coin'];
                    document.getElementById("coinTtlEdt").value = response[i]['cott'];

                    document.getElementById("ctl1Edt").value = response[i]['cntt'];
                    document.getElementById("nocnEdt").value = response[i]['nocn'];
                    document.getElementById("norpEdt").value = response[i]['norp'];
                    document.getElementById("ttldnmEdt").value = response[i]['dntt'];
                    document.getElementById("auid").value = response[i]['dnid'];

                    loadDelomiEdt();
                }
            }
        })
    }

    // $("#edtbtn").click(function (e) {
    $("#edtBtn").on('click', function (e) {
        e.preventDefault();

        if ($("#dnom_edt").valid()) {
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
                        $('#modalEdit').modal('hide');
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>User/edtDenomin",
                            data: $("#dnom_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal({title: "", text: "Denomination edit success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Denomination edit Failed", type: "error"},
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


    // reject denomination
    function rejecDenomi(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this Voucher",
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
                        url: '<?= base_url(); ?>user/rejDenomi',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (data, textStatus, jqXHR) {
                            srchVou();
                            swal({title: "", text: "Denomination reject success", type: "success"});
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal("Failed!", "Denomination Reject Failed", "error");
                        }
                    });
                } else {
                    swal("Cancelled!", "Denomination Not Rejected", "error");
                }
            });
    }

    /* function totcal() {
     var sum = 0;
     $(".form-group input[name='subamt[]']").each(function () {
     sum = sum + +this.value;
     });
     document.getElementById('pyam').value = sum;
     }*/

    // TODAY DENOMINATION PRINT
    function printDenomi(auid) {
        //window.open('<?= base_url() ?>user/printDenomiPdf/' + auid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');

        var w = window.open('about:blank', '_blank');
        w.location.href = '<?= base_url(); ?>Report/printDenomiPdf/' + auid ;

        srchVou();
    }

</script>