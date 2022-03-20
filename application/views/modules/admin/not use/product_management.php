<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>System Setting</li>
    <li class="active">Product Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Product Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#step1"><span><i
                                        class="fa fa-plus"></i></span> Add Product
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
                                <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="prdtp" id="prdtp">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($prdtypeinfo as $prdtyp) {
                                            echo "<option value='$prdtyp->prid'>$prdtyp->prna</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Statues</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <option value="2">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 text-right"></label>
                                <div class="col-md-8 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="searchProduct()"
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
                                           id="dataTbPrdt" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">TYPE</th>
                                            <th class="text-center">NAME</th>
                                            <th class="text-center">CODE</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">RENTAL</th>
                                            <th class="text-center">NO OF RENT</th>
                                            <th class="text-center">INDEX</th>
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
<form class="form-horizontal" id="prdt_add" name="prdt_add"
      action="<?= base_url() ?>admin/addProduct" method="post">

    <div class="modal" id="step1" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create</h4>
                    <div class="number">
                        <ul>
                            <li class="active"><a href="#">General Details </a></li>
                            <li><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges </a></li>
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
                                                <label class="col-md-4  control-label">Category Type</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="prd_cat" id="prd_cat"
                                                            onchange="abc(this.value)">
                                                        <option value="0"> Select Type</option>
                                                        <?php
                                                        foreach ($prdtypeinfo as $prdtyp) {
                                                            echo "<option value='$prdtyp->prid'>$prdtyp->prna</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Assign Branch</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="prd_brn" id="prd_brn"
                                                            onchange="">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] != '0' && $branch['brch_id'] != 'all') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control"
                                                               name="prnm" id="prnm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="prcd"
                                                               id="prcd"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Loan Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control"
                                                               name="lnamt" id="lnamt" onkeyup="calInstal()"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="nfinst">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of Installments</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="noins"
                                                               id="noins" onkeyup="calInstal()"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div id="dailyDiv" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="dytp" id="dytp"
                                                                onchange="getLoanPrdtDyn(prd_cat.value,this.value);calInstal()">
                                                            <option value="all"> --</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Payment
                                                        duration</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="dyn_dura" id="dyn_dura"
                                                                onchange="calInstal()">
                                                            <option value="0"> select Duration</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Interest % </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="inrt" id="inrt"
                                                               placeholder="Rate" onkeyup="calInstal();"
                                                               onfocus="" title="Interest Rate (%) per Payment"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Mode </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <select class="form-control" name="prd_md" id="prd_md"
                                                                onchange="calInstal()">
                                                            <option value="0"> Select Type</option>
                                                            <?php
                                                            foreach ($chrgmode as $chmd) {
                                                                echo "<option value='$chmd->pcid'>$chmd->chmd</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Installment</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="inst"
                                                               id="inst" disabled/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="tint" id="tint"
                                                               title="" placeholder="Total Interest" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="instDB" name="instDB">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Loan Index </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="lnid" id="lnid"
                                                               title="" placeholder="index"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <span style="color: red">
                                         # Can't added DDL, DWK, DML, IFD, IFW, IFM, DPD, DPW, DPM product code .
                                   </span>
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

    <div class="modal" id="step2" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create (2 Page)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">
                                    General Details </a></li>
                            <li class="active"><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges</a></li>
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
                                            <table class="table table-bordered table-striped table-actions"
                                                   id="dataTbSch">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">PAYMENT</th>
                                                    <th class="text-center">INTEREST</th>
                                                    <th class="text-center">PRINCIPLE</th>
                                                    <th class="text-center">BALANCE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th id="ttlpym"></th>
                                                <th id="ttlint"></th>
                                                <th id="ttlcap"></th>
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

    <div class="modal" id="step3" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create (3 Page)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li class="active"><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges</a></li>
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
                                                <label class="col-md-4  control-label">Penalty </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="pnty" id="pnty"
                                                            onchange="pnltyFunc(this.value)">
                                                        <option value="0"> Disable</option>
                                                        <option value="1"> Enable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="pnltyFuncDiv1" style="display: none">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Penalty Cal. On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pncl" id="pncl"
                                                            onchange="pnltyFunc2(this.value)">
                                                        <?php
                                                        foreach ($caltype as $clty) {
                                                            echo "<option value='$clty->auid'>$clty->cltp</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="pnltyFuncDiv2" style="display: none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Penalty Base On</label>
                                                <div class="col-md-4 ">
                                                    <select class="form-control" name="pnbs" id="pnbs">
                                                        <option value="0"> Select Type</option>
                                                        <?php
                                                        foreach ($calbase as $clbs) {
                                                            echo "<option value='$clbs->auid'>$clbs->clbs</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnl_stdt" id="pnl_stdt" placeholder="Start From"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Penalty Cal Rate (Y%)</label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnlrt" id="pnlrt" placeholder="Cal Rate"
                                                               title="Yearly Rate"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" id="pnltyFuncDiv3" style="display: none">
                                                <label class="col-md-4  control-label">Penalty Condition </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="pncd" id="pncd"
                                                            onchange="">
                                                        <option value="0"> Select</option>
                                                        <?php
                                                        foreach ($pnlcndit as $pncd) {
                                                            echo "<option value='$pncd->auid'>$pncd->pncd</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Multi Loans </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="prln" id="prln"
                                                            onchange="">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <!--  <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-5  control-label">If </label>
                                                  <div class="col-md-6 ">
                                                      <div class="form-group">
                                                          <select class="form-control" name="pdtp" id="pdtp"
                                                                  onchange="garentFunc(this.value)">
                                                              <option value="0"> Group Product</option>
                                                              <option value="1"> Individual Product</option>
                                                          </select>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>-->
                                    </div>
                                    <br>
                                    <!--  <div class="row" id="garentFuncDiv1">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-5  control-label">Mutural Guarantors</label>
                                                  <div class="col-md-2 ">
                                                      <input type="checkbox" class="icheckbox" id="mugr" name="mugr"/>
                                                  </div>
                                                  <div class="col-md-4">
                                                      <div class="form-group">
                                                          <input type="text" class="form-control" name="nogr" id="nogr"
                                                                 placeholder="No of" title="No of Guarantors"/>
                                                      </div>

                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label class="col-md-5  control-label">External Guarantors</label>
                                                  <div class="col-md-2 ">
                                                      <input type="checkbox" class="icheckbox" id="exgr" name="exgr"/>
                                                  </div>
                                                  <div class="col-md-4">
                                                      <div class="form-group">
                                                          <input type="text" class="form-control" name="noexgr"
                                                                 id="noexgr" placeholder="No of "
                                                                 title="No of External Guarantors"/>
                                                      </div>

                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                      <br>-->
                                    <!--<div class="row" id="garentFuncDiv2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Mortgage</label>
                                                <div class="col-md-2 ">
                                                    <input type="checkbox" class="icheckbox" id="mrtg" name="mrtg"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="motg" id="motg"
                                                               placeholder="No of Mortgage"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>-->
                                    <!--<div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Age Limit</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="aglmt" id="aglmt"
                                                               placeholder="Age Limite"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>-->

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

    <div class="modal" id="step4" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create (4 Page)
                    </h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step3">Other
                                    Details</a></li>
                            <li class="active"><a href="#">Service Charges</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3  control-label">Document Free</label>
                                                <div class="col-md-3 ">
                                                    <select class="form-control" name="dofr" id="dofr"
                                                            onchange="docFunc(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="dcrt" id="dcrt" placeholder="As Percentage"/>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="damt" id="damt" placeholder="As Amount"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3  control-label">Insurance Free</label>
                                                <div class="col-md-3 ">
                                                    <select class="form-control" name="infr" id="infr"
                                                            onchange="insFunc(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                                <!--   <div class="col-md-3 ">
                                                       <div class="form-group">
                                                           <input type="text" class="form-control"
                                                                  name="isrt" id="isrt" placeholder="As Percentage"/>
                                                       </div>
                                                   </div> -->
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="iamt" id="iamt" placeholder="As Amount"/>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal" data-toggle="modal"
                            data-target="#step3">Back
                    </button>
                    <button type="submit" class="btn btn-success pull-right" data-toggle="modal" onclick=""
                            title=" "
                            data-backdrop="static">Submit
                    </button>
                </div>

            </div>
        </div>
    </div>

</form>
<!--End Add Model -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">View Product Details</h4>
            </div>

            <div class="modal-body form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Category</label>
                                        <label class="col-md-6 col-xs-12 control-label" id="prcat"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Name</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="prname"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Loan amount</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="pramt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Instalment</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="prist"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Document Free</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="docch"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Loan Index </label>
                                        <label class="col-md-6 col-xs-6 control-label" id="indx"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-12 control-label">Branch</label>
                                        <label class="col-md-6 col-xs-12 control-label" id="prbrnc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Code</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="prcod"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">No of Rental</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="nornt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Total Inter</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="ttint"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Insurance Free</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="inschg"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-6 col-xs-6 control-label">Penalty</label>
                                        <label class="col-md-6 col-xs-6 control-label" id="pntl"></label>
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
<form class="form-horizontal" id="prdt_edt" name="prdt_edt"
      action="<?= base_url() ?>user/edtProduct" method="post">

    <div class="modal" id="step1Edt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span>
                        <span id="hed1"></span></h4>

                    <div class="number">
                        <ul>
                            <li class="active"><a href="#">General Details </a></li>
                            <li><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges</a></li>
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
                                                <label class="col-md-4  control-label">Category Type</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="prd_catEdt" id="prd_catEdt"
                                                            onchange="abcEdt(this.value)">
                                                        <option value="0"> Select Type</option>
                                                        <?php
                                                        foreach ($prdtypeinfo as $prdtyp) {
                                                            echo "<option value='$prdtyp->prid'>$prdtyp->prna</option>";
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Assign Branch</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="prd_brnEdt" id="prd_brnEdt"
                                                            onchange="">
                                                        <?php
                                                        foreach ($branchinfo as $branch) {
                                                            if ($branch['brch_id'] != '0' && $branch['brch_id'] != 'all') {
                                                                echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Name</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control"
                                                               name="prnmEdt" id="prnmEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Code</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="prcdEdt"
                                                               id="prcdEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Loan Amount</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control"
                                                               name="lnamtEdt" id="lnamtEdt"
                                                               onkeyup="calInstalEdt()"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="nfinstEdt">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of Installment</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="noinsEdt"
                                                               id="noinsEdt" onkeyup="calInstalEdt()"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>

                                    <div id="dailyDivEdt" style="display: none">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="dytpEdt" id="dytpEdt"
                                                                onchange="getLoanPrdtDynEdt(prd_catEdt.value,this.value);calInstalEdt()">
                                                            <option value="all"> xx</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Payment
                                                        duration</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="dyn_duraEdt" id="dyn_duraEdt"
                                                                onchange="calInstalEdt()">
                                                            <option value="0"> select Duration</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="inrtEdt"
                                                               id="inrtEdt"
                                                               placeholder="Rate"
                                                               onkeyup="calInstalEdt();"
                                                               onfocus=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Product Mode </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <select class="form-control" name="prd_mdEdt" id="prd_mdEdt"
                                                                onchange="calInstalEdt()">
                                                            <option value="0"> Select Type</option>
                                                            <?php
                                                            foreach ($chrgmode as $chmd) {
                                                                echo "<option value='$chmd->pcid'>$chmd->chmd</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Installment</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="instEdt"
                                                               id="instEdt" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="tintEdt"
                                                               id="tintEdt"
                                                               title="" placeholder="Total Interest" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="instDBEdt" name="instDBEdt">
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Loan Index </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="lnidEdt"
                                                               id="lnidEdt" title="" placeholder="index"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <span style="color: red">
                                         # Can't added DDL, DWK, DML, IFD, IFW, IFM, DPD, DPW, DPM product code .
                                   </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right" id="nxtBtn1Edt"
                            data-toggle="modal"
                            onclick="step2Edt() "
                            title=" " data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="step2Edt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span>
                        <span id="hed2"></span></h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1Edt">
                                    General Details </a></li>
                            <li class="active"><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges</a></li>
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
                                            <table class="table table-bordered table-striped table-actions"
                                                   id="dataTbSchEdt">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">PAYMENT</th>
                                                    <th class="text-center">INTEREST</th>
                                                    <th class="text-center">PRINCIPLE</th>
                                                    <th class="text-center">BALANCE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th id="ttlpymEdt"></th>
                                                <th id="ttlintEdt"></th>
                                                <th id="ttlcapEdt"></th>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                            data-toggle="modal"
                            data-target="#step1Edt">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            onclick="step3Edt()"
                            id="nxtBtn2Edt" data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="step3Edt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span>
                        <span id="hed3"></span></h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1Edt">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2Edt">Schedule
                                    Details</a></li>
                            <li class="active"><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charges</a></li>
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
                                                <label class="col-md-4  control-label">Penalty </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="pntyEdt" id="pntyEdt"
                                                            onchange="pnltyFuncEdt(this.value)">
                                                        <option value="0"> Disable</option>
                                                        <option value="1"> Enable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="pnltyFuncDiv1Edt" style="display: none">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Penalty Cal. On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pnclEdt" id="pnclEdt"
                                                            onchange="pnltyFunc2Edt(this.value)">
                                                        <?php
                                                        foreach ($caltype as $clty) {
                                                            echo "<option value='$clty->auid'>$clty->cltp</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="pnltyFuncDiv2Edt" style="display: none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Penalty Base On</label>
                                                <div class="col-md-4 ">
                                                    <select class="form-control" name="pnbsEdt" id="pnbsEdt">
                                                        <option value="0"> Select Type</option>
                                                        <?php
                                                        foreach ($calbase as $clbs) {
                                                            echo "<option value='$clbs->auid'>$clbs->clbs</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnl_stdtEdt" id="pnl_stdtEdt"
                                                               placeholder="Start From" title="Start From"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Penalty Cal Rate (Y%)</label>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnlrtEdt" id="pnlrtEdt" placeholder="Cal Rate"
                                                               title="Y %"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" id="pnltyFuncDiv3Edt" style="display: none">
                                                <label class="col-md-4  control-label">Penalty Condition </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="pncdEdt" id="pncdEdt"
                                                            onchange="">
                                                        <option value="0"> Select</option>
                                                        <?php
                                                        foreach ($pnlcndit as $pncd) {
                                                            echo "<option value='$pncd->auid'>$pncd->pncd</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Multi Loans </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="prlnEdt" id="prlnEdt"
                                                            onchange="">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5 control-label">Remark</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remkEdt"
                                                              name="remkEdt"></textarea>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                            data-toggle="modal"
                            data-target="#step2Edt">Back
                    </button>
                    <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            onclick="step4Edt()"
                            id="nxtBtn3Edt" data-backdrop="static">Next
                    </button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal" id="step4Edt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span>
                        <span id="hed4"></span></h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1Edt">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2Edt">Schedule
                                    Details</a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step3Edt">Other
                                    Details</a></li>
                            <li class="active"><a href="#">Service Charges</a></li>
                        </ul>
                    </div>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3  control-label">Document Free</label>
                                                <div class="col-md-3 ">
                                                    <select class="form-control" name="dofrEdt" id="dofrEdt"
                                                            onchange="docFuncEdt(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="dcrt" id="dcrt" placeholder="As Percentage"/>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="damtEdt" id="damtEdt"
                                                               placeholder="As Amount"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-3  control-label">Insurance
                                                    Free</label>
                                                <div class="col-md-3 ">
                                                    <select class="form-control" name="infrEdt" id="infrEdt"
                                                            onchange="insFuncEdt(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>
                                                    </select>
                                                </div>
                                                <!--   <div class="col-md-3 ">
                                                       <div class="form-group">
                                                           <input type="text" class="form-control"
                                                                  name="isrt" id="isrt" placeholder="As Percentage"/>
                                                       </div>
                                                   </div> -->
                                                <div class="col-md-3 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="iamtEdt" id="iamtEdt"
                                                               placeholder="As Amount"/>
                                                    </div>
                                                </div>
                                                <input type="hidden" id="func" name="func">
                                                <input type="hidden" name="auid" id="auid"/>
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
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"
                            data-toggle="modal"
                            data-target="#step3Edt">Back
                    </button>
                    <button type="submit" class="btn btn-success pull-right" data-toggle="modal" onclick=""
                            title=" " id="edtbtn"
                            data-backdrop="static"><span id="btnNm"></span>
                    </button>
                </div>

            </div>
        </div>
    </div>

</form>

<!--End Edit / approvel Model -->

<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbPrdt').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        //searchProduct();

        //$('#step1').modal('show');
        //  $('#modalView').modal('show');

        $("#prdt_add").validate({  // step1 validation
            rules: {
                prd_cat: {
                    required: true,
                    notEqual: '0'
                },
                prd_brn: {
                    required: true,
                    notEqual: 'all'
                },
                prnm: {
                    required: true
                },
                prcd: {
                    required: true,
                    minlength: 3,
                    maxlength: 3,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_prdcode",
                        type: "post",
                        data: {
                            prcd: function () {
                                return $("#prcd").val();
                            },
                            brco: function () {
                                return $("#prd_brn").val();
                            }
                        }
                    }
                },
                lnamt: {
                    required: true,
                    digits: true
                },
                noins: {
                    required: true,
                    digits: true
                },
                pncl: {
                    required: true,
                    notEqual: '0'
                },
                pnbs: {
                    required: true,
                    notEqual: '0'
                },
                lnid: {
                    required: true,
                    digits: true
                },
                inrt: {
                    required: true,
                    number: true
                },
                dytp: {
                    required: true,
                    notEqual: '0'
                },
                dyn_dura: {
                    required: true,
                    notEqual: '0'
                },
                prd_md: {
                    required: true,
                    notEqual: '0'
                },
                pncd: {
                    required: true,
                    notEqual: '0'
                },
                damt: {
                    required: true,
                    digits: true
                },
                iamt: {
                    required: true,
                    digits: true
                },
                pnlrt: {
                    required: true,
                    number: true
                },
                pnl_stdt: {
                    required: true,
                    digits: true
                },
            },
            messages: {
                prd_cat: {
                    required: 'Please select Category Type',
                    notEqual: "Please select Category Type",
                },
                prd_brn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                prnm: {
                    required: 'Enter Product Name '
                },
                prcd: {
                    required: 'Enter Product Code ',
                    remote: 'Product code already exists'
                },
                lnamt: {
                    required: 'Enter Loan Amount ',
                    digits: 'This is not a valid Number'
                },
                noins: {
                    required: 'Enter No of Instalment ',
                    digits: 'This is not a valid Number'
                },
                pncl: {
                    required: 'Enter No of Instalment ',
                    notEqual: "Please select penalty cal type"
                },
                pnbs: {
                    required: 'Enter No of Instalment ',
                    notEqual: "Please select penalty base"
                },
                lnid: {
                    required: 'Enter loan indes',
                    digits: 'This is not a valid Number'
                },
                inrt: {
                    required: 'Enter loan interest rate',
                    number: 'This is not a valid Number'
                },
                dytp: {
                    required: 'Please select day type',
                    notEqual: "Please select day type",
                },
                dyn_dura: {
                    required: 'Please select payment duration',
                    notEqual: "Please select payment duration",
                },
                pncd: {
                    required: 'Please select Penalty condition',
                    notEqual: "Please select Penalty condition",
                },
                prd_md: {
                    required: 'Please select product mode',
                    notEqual: "Please select product mode",
                },
                damt: {
                    required: 'Enter document free ',
                    digits: 'This is not a valid Number'
                },
                iamt: {
                    required: 'Enter insurance free ',
                    digits: 'This is not a valid Number'
                },
            }
        })

        $("#prdt_edt").validate({
            rules: {
                prd_catEdt: {
                    required: true,
                    notEqual: '0'
                },
                prd_brnEdt: {
                    required: true,
                    notEqual: 'all'
                },
                prnmEdt: {
                    required: true
                },
                prcdEdt: {
                    required: true,
                    minlength: 3,
                    maxlength: 3,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_prdcode_edt",
                        type: "post",
                        data: {
                            prcd: function () {
                                return $("#prcdEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },
                lnamtEdt: {
                    required: true,
                    digits: true,
                },
                noinsEdt: {
                    required: true,
                    digits: true
                },
                inrtEdt: {
                    required: true,
                },
                damtEdt: {
                    required: true,
                    digits: true
                },
                iamtEdt: {
                    required: true,
                    digits: true
                },
                pnclEdt: {
                    required: true,
                    notEqual: '0'
                },
                pnbsEdt: {
                    required: true,
                    notEqual: '0'
                },
                lnidEdt: {
                    required: true,
                    digits: true
                },
                dytpEdt: {
                    required: true,
                    notEqual: '0'
                },
                dyn_duraEdt: {
                    required: true,
                    notEqual: '0'
                },
                prd_mdEdt: {
                    required: true,
                    notEqual: '0'
                },
                pncdEdt: {
                    required: true,
                    notEqual: '0'
                },
                pnlrtEdt: {
                    required: true,
                    number: true
                },
                pnl_stdtEdt: {
                    required: true,
                    digits: true
                },
            },
            messages: {
                prd_catEdt: {
                    required: 'Please select Category Type',
                    notEqual: "Please select Category Type",
                },
                prd_brnEdt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch"
                },
                prnmEdt: {
                    required: 'Enter Product Name '
                },
                prcdEdt: {
                    required: 'Enter Product Code ',
                    remote: 'Product code already exists'
                },
                lnamtEdt: {
                    required: 'Enter Loan Amount ',
                    digits: 'This is not a valid Number'
                },
                noinsEdt: {
                    required: 'Enter No of Instalment ',
                    digits: 'This is not a valid Number'
                },
                inrtEdt: {
                    required: 'Enter Interest Rate ',
                },
                damtEdt: {
                    required: 'Enter Document Charge ',
                    digits: 'This is not a valid Number'
                },
                iamtEdt: {
                    required: 'Enter Insurance Charge ',
                    digits: 'This is not a valid Number'
                },
                pnclEdt: {
                    required: 'Enter No of Instalment ',
                    notEqual: "Please select penalty cal type"
                },
                pnbsEdt: {
                    required: 'Enter No of Instalment ',
                    notEqual: "Please select penalty base"
                },
                lnidEdt: {
                    required: 'Enter loan indes',
                    digits: 'This is not a valid Number'
                },
                dytpEdt: {
                    required: 'Please select day type',
                    notEqual: "Please select day type",
                },
                dyn_duraEdt: {
                    required: 'Please select payment duration',
                    notEqual: "Please select payment duration",
                },
                prd_mdEdt: {
                    required: 'Please select product mode',
                    notEqual: "Please select product mode",
                },
                pncdEdt: {
                    required: 'Please select Penalty condition',
                    notEqual: "Please select Penalty condition",
                },
            }
        })

    });

    // LOAD POLICY WISE 5D/6D/7D DAYS
    var d5 = "<?= $policyinfo[0]->pov1 ?>";
    var d6 = "<?= $policyinfo[0]->pov2 ?>";
    var d7 = "<?= $policyinfo[0]->pov3 ?>";

    var smln = "<?= $samelninfo[0]->post ?>";  // IF SAME LOAN AMOUNT & RENTAL (1 - ENABLE | 2 - DISABLE)

    // Product add model
    function step2() {
        var lnamt = document.getElementById('lnamt').value;
        var noins = document.getElementById('noins').value;
        var brnc = document.getElementById('prd_brn').value;
        var prct = document.getElementById('prd_cat').value;

        if (smln == 1) {
            if ($("#prdt_add").valid()) {
                $('#step1').modal('hide');
                $('#step2').modal('show');
            }
            schTblgenaration();

        } else {
            $.ajax({
                url: '<?= base_url(); ?>admin/chk_alrdyPrduct',
                type: 'post',
                data: {
                    lnamt: lnamt,
                    noins: noins,
                    brnc: brnc,
                    prct: prct
                },
                dataType: 'json',
                success: function (response) {
                    if (response === true) {
                        document.getElementById('lnamt').style.borderColor = "";
                        document.getElementById('noins').style.borderColor = "";

                        if ($("#prdt_add").valid()) {
                            $('#step1').modal('hide');
                            $('#step2').modal('show');
                        }
                        schTblgenaration();

                    } else if (response === false) {
                        swal("", "Same loan amount & rental loan already exist", "warning");

                        document.getElementById('lnamt').style.borderColor = "red";
                        document.getElementById('noins').style.borderColor = "red";
                    }
                }
            });
        }


    }

    function step3() {
        $('#step2').modal('hide');
        $('#step3').modal('show');
    }

    function step4() {
        if ($("#prdt_add").valid()) {
            $('#step3').modal('hide');
            $('#step4').modal('show');
        }
    }

    // *********** Daily product **********
    function abc(prtp) {
        if (prtp == 3) {
            document.getElementById('dailyDiv').style.display = "block";
            document.getElementById('nfinst').style.display = "none";

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>user/getDyType',
                data: {
                    prtp: 6
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;

                    if (len != 0) {
                        $('#dytp').empty();
                        $('#dytp').append("<option value='0'>Select Day Type </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['cldw'];
                            var name = response[i]['cldw'] + " Days WK";
                            var $el = $('#dytp');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#dytp').empty();
                        $('#dytp').append("<option value='0'>No Day Type</option>");
                    }
                }
            });
        } else {
            document.getElementById('dailyDiv').style.display = "none";
            document.getElementById('nfinst').style.display = "block";
            getLoanPrdtDyn(prtp, 0, 'add');
        }
    }

    function getLoanPrdtDyn(prdtp, daytp) {  // load duration and int rate

        if (prdtp == 3) {
            var x = " Days";
        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getDynaPeriod',
            data: {
                prdtp: 6,
                daytp: daytp
            },
            dataType: 'json',
            success: function (response) {
                var len = response['nofr'].length;

                if (len != 0) {
                    $('#dyn_dura').empty();
                    $('#dyn_dura').append("<option value='0'>Select Duration </option>");
                    for (var i = 0; i < len; i++) {

                        if (prdtp == 3) {

                            if (daytp == 5) {         // 5D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d5;
                            } else if (daytp == 6) {   // 6D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d6;
                            } else if (daytp == 7) {   // 7D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d7;
                            }

                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x + '  (' + aa + x + ')';
                        } else {
                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x;
                        }

                        var $el = $('#dyn_dura');
                        $el.append($("<option></option>").attr("value", id).text(name));
                    }
                } else {
                    $('#dyn_dura').empty();
                    $('#dyn_dura').append("<option value='0'>No Duration</option>");
                }
            },
        });
    }

    function abcEdt(prtp, lcat) {
        if (prtp == 3) {
            document.getElementById('dailyDivEdt').style.display = "block";
            document.getElementById('nfinstEdt').style.display = "none";

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>user/getDyType',
                data: {
                    prtp: 6
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;

                    if (len != 0) {
                        $('#dytpEdt').empty();
                        $('#dytpEdt').append("<option value='0'>Select Day Type </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['cldw'];
                            var name = response[i]['cldw'] + " Days WK";
                            var $el = $('#dytpEdt');
                            if (lcat == id) {
                                $el.append($("<option selected></option>")
                                    .attr("value", id).text(name));
                            } else {
                                $el.append($("<option></option>")
                                    .attr("value", id).text(name));
                            }
                        }
                    } else {
                        $('#dytpEdt').empty();
                        $('#dytpEdt').append("<option value='0'>No Day Type</option>");
                    }
                }
            });
        } else {
            document.getElementById('dailyDivEdt').style.display = "none";
            document.getElementById('nfinstEdt').style.display = "block";
            //getLoanPrdtDynEdt(prtp, 0);
        }
    }

    function getLoanPrdtDynEdt(prdtp, daytp, noin, inra) {  // load duration

        if (prdtp == 3) {
            var x = " Days";
        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getDynaPeriod',
            data: {
                prdtp: 6,
                daytp: daytp
            },
            dataType: 'json',
            success: function (response) {
                var len = response['nofr'].length;

                if (len != 0) {
                    $('#dyn_duraEdt').empty();
                    $('#dyn_duraEdt').append("<option value='0'>Select Duration </option>");
                    for (var i = 0; i < len; i++) {

                        if (prdtp == 3) {

                            if (daytp == 5) {         // 5D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d5;
                            } else if (daytp == 6) {   // 6D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d6;
                            } else if (daytp == 7) {   // 7D
                                var aa = (+response['nofr'][i]['nofr'] / 30) * +d6;
                            }

                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x + '  (' + aa + x + ')';
                        } else {
                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x;
                        }

                        var $el = $('#dyn_duraEdt');
                        if (noin == id) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option ></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#dyn_duraEdt').empty();
                    $('#dyn_duraEdt').append("<option value='0'>No Duration</option>");
                }
            },
        });
    }


    // *********** End Daily product **********

    // PMT calculation
    function PMT(ir, np, pv, fv, type) {
        /*
         * ir   - interest rate per month
         * np   - number of periods (months)
         * pv   - present value
         * fv   - future value
         * type - when the payments are due:
         *        0: end of the period, e.g. end of month (default)
         *        1: beginning of period
         */
        var pmt, pvif;
        fv || (fv = 0);
        type || (type = 0);
        if (ir === 0)
            return -(pv + fv) / np;
        pvif = Math.pow(1 + ir, np);
        pmt = -ir * pv * (pvif + fv) / (pvif - 1);
        if (type === 1)
            pmt /= (1 + ir);
        return pmt;
    }
    // Interest rate = 7%
    // Number of months = 12
    // Present value = €1000
    // PMT(0.07/12, 24, 1000) = -44.77257910314528
    // Due import = pmt.toFixed(2) * 24 = 1074.48
    // example   PMT(0.04018514064, 12, 10000) = 1066.67
    //var aa = -PMT(0.04018514064, 12, 10000);
    // alert(aa);

    function calInstal() {
        var cttp = document.getElementById('prd_cat').value;    // Category Type
        var lnamt = document.getElementById('lnamt').value;     // loan amount
        var noins = document.getElementById('noins').value;     // no of installment
        var inrt = document.getElementById('inrt').value;       // interest rate
        //var tint = document.getElementById('tint').value;     // total interest

        // DAILY LOAN
        if (cttp == 3) {
            var xc = document.getElementById('dyn_dura').value;     // no of installment
            var dytp = document.getElementById('dytp').value;       // product type

            if (dytp == 5) {
                var dts = d5;
            } else if (dytp == 6) {
                var dts = d6;
            } else if (dytp == 7) {
                var dts = d7;
            }
            noins = (+xc / 30 * +dts);

            /* NORMAL DL CALCULATION */
            //var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);
            //var aa = ( ((+noins / 30) * +dts) * ((mm / 10) * 10)  ) - +lnamt;

            var mm = -PMT((inrt / 100), noins, lnamt);
            var aa = (+mm * +noins) - lnamt;

            document.getElementById('inst').value = numeral(mm).format('0,0.00000000');
            document.getElementById('instDB').value = numeral(mm).format('0.00000000');
            document.getElementById('tint').value = numeral(aa).format('0.0000');

        } else {
            //  var xx = ((+lnamt * (100 + +inrt)) / 100 ) / noins;
            var mm = -PMT((inrt / 100), noins, lnamt);

            document.getElementById('inst').value = numeral(mm).format('0,0.00000000');
            document.getElementById('instDB').value = numeral(mm).format('0.00000000');

            var aa = (+mm * +noins) - lnamt;
            document.getElementById('tint').value = numeral(aa).format('0.0000');
        }

        schTblgenaration();
    }

    function monthlyflat_clac_dyn() {

        if (interestType == 1) {
            int = int * 12;
        }

        var tableBodyContent = "";

        var totalInterest = parseFloat(Math.round((((principal / 100) * (int * (ins / 12)))) * 100) / 100).toFixed(2);
        var totalPricipal = principal;

        var totalPaidInsterest = 0;
        var totalPaidPrincipal = 0;
        var paidInstallment = 0;

        var paybleprincipal = 0;
        var paybleprinterest = 0;
        var paybleinstallment = 0;

        if (RoundupMethode == 1) {

            if (RoundupToNearest == 0) {

                paybleprincipal = parseFloat(Math.round((principal / ins) * 100) / 100).toFixed(2);
                paybleprinterest = parseFloat(Math.round((((principal / 100) * (int * (ins / 12))) / ins) * 100) / 100).toFixed(2);
                paybleinstallment = parseFloat(Math.round((+paybleprincipal + +paybleprinterest) * 100) / 100).toFixed(2);

            } else {

                paybleprincipal = parseFloat(Math.round((principal / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
                paybleprinterest = parseFloat(Math.round((((principal / 100) * (int * (ins / 12))) / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
                paybleinstallment = parseFloat(Math.round((+paybleprincipal + +paybleprinterest) / RoundupToNearest) * RoundupToNearest).toFixed(2);
            }


        } else if (RoundupMethode == 2) {

            paybleprincipal = parseFloat(Math.ceil((principal / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
            paybleprinterest = parseFloat(Math.ceil((((principal / 100) * (int * (ins / 12))) / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
            paybleinstallment = parseFloat(Math.ceil((+paybleprincipal + +paybleprinterest) / RoundupToNearest) * RoundupToNearest).toFixed(2);


        } else {

            paybleprincipal = parseFloat(Math.floor((principal / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
            paybleprinterest = parseFloat(Math.floor((((principal / 100) * (int * (ins / 12))) / ins) / RoundupToNearest) * RoundupToNearest).toFixed(2);
            paybleinstallment = parseFloat(Math.floor((+paybleprincipal + +paybleprinterest) / RoundupToNearest) * RoundupToNearest).toFixed(2);

        }
        document.getElementById('custom_product_inst_max').value = paybleinstallment;


        for (var i = 1; i <= ins; i++) {

            if (RoundupMethode == 1) {
                principal = parseFloat(Math.round((+principal - paybleprincipal) * 100) / 100).toFixed(2);

            } else if (RoundupMethode == 2) {
                principal = parseFloat(Math.ceil(+principal - paybleprincipal)).toFixed(2);
            } else {
                principal = parseFloat(Math.floor(+principal - paybleprincipal)).toFixed(2);
            }

            //if principal is paid off
            if (principal < 0) {
                paybleprincipal = parseFloat(Math.round((+paybleprincipal + +principal) * 100) / 100).toFixed(2);
                paybleprinterest = parseFloat(Math.round((+paybleprinterest - +principal) * 100) / 100).toFixed(2);
                principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);

            }
            //end of installment
            if (i == ins) {
                paybleprincipal = parseFloat(Math.round((+paybleprincipal + +principal) * 100) / 100).toFixed(2);
                paybleprinterest = parseFloat(Math.round((+paybleprinterest - +principal) * 100) / 100).toFixed(2);
                principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);

                paybleinstallment = parseFloat(Math.round((paybleinstallment - ((+totalPaidInsterest + +paybleprinterest) - totalInterest)) * 100) / 100).toFixed(2);
                paybleprinterest = parseFloat(Math.round((paybleprinterest - ((+totalPaidInsterest + +paybleprinterest) - totalInterest)) * 100) / 100).toFixed(2);
            }

            tableBodyContent = tableBodyContent + "<tr><td>" + i + "</td><td>" + paybleinstallment + "</td><td>" + paybleprinterest + "</td><td>" + paybleprincipal + "</td><td>" + principal + "</td></tr>";

            totalPaidInsterest = +totalPaidInsterest + +paybleprinterest;
            paidInstallment = +paidInstallment + +paybleinstallment;
            totalPaidPrincipal = +totalPaidPrincipal + +paybleprincipal;


        }

        if (RoundupMethode == 1) {

            totalPaidInsterest = parseFloat(Math.round((totalPaidInsterest) * 100) / 100).toFixed(2);
            paidInstallment = parseFloat(Math.round((paidInstallment) * 100) / 100).toFixed(2);
            totalPaidPrincipal = parseFloat(Math.round((totalPaidPrincipal) * 100) / 100).toFixed(2);

        } else if (RoundupMethode == 2) {

            totalPaidInsterest = parseFloat(Math.ceil(totalPaidInsterest)).toFixed(2);
            paidInstallment = parseFloat(Math.ceil(paidInstallment)).toFixed(2);
            totalPaidPrincipal = parseFloat(Math.ceil(totalPaidPrincipal)).toFixed(2);

        } else {

            totalPaidInsterest = parseFloat(Math.floor(totalPaidInsterest)).toFixed(2);
            paidInstallment = parseFloat(Math.floor(paidInstallment)).toFixed(2);
            totalPaidPrincipal = parseFloat(Math.floor(totalPaidPrincipal)).toFixed(2);

        }

        tableBodyContent = tableBodyContent + "<tr><td></td><td><b>" + paidInstallment + "</b></td><td><b>" + totalPaidInsterest + "</b></td><td><b>" + totalPaidPrincipal + "</b></td><td></td></tr>";
        document.getElementById('custom_loanTable').innerHTML = tableBodyContent;
        document.getElementById('total_intrest').value = totalPaidInsterest;


    }


    // ADD MODEL SCHEDULE
    function schTblgenaration() {
        var lnamt = document.getElementById('lnamt').value;     // loan amount
        var noins = document.getElementById('noins').value;     // no of installment
        var inrt = document.getElementById('inrt').value;       // interest rate

        var prdct = document.getElementById('prd_cat').value;      // product catogry ( 3-DL / 4-WK/ 5-ML)
        var prdmd = document.getElementById('prd_md').value;       // product mode ( 1-redusing / 2-flat rate)

        var t = $('#dataTbSch').DataTable();
        $('#dataTbSch').DataTable({
            "destroy": true,
            "cache": false,
            "searching": false,
            paging: false,
            "processing": false,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "columnDefs": [
                {className: "text-center", "targets": [0]},
                {className: "text-right", "targets": [1, 2, 3, 4]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'}
            ],
        });

        var principal = lnamt;
        var int = inrt;

        var totInsamount = 0;
        var totInt = 0;
        var totprin = 0;

        if (prdmd == 1) {   // Redusing

            if (prdct == 3) {  // Daily product
                var xc = document.getElementById('dyn_dura').value;     // no of installment
                var dytp = document.getElementById('dytp').value;       // product type

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                noins = (+xc / 30 * +dts);
                var ins = noins;           // NO OF INSTALLMENT

                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int

                var pmt_int = int / 1200;
                var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));

                pymt = parseFloat(mm).toFixed(2);

                var totprin = 0;
                var ttlint = 0;
                var ttlcap = 0;
                var ttlrnt = 0;

                t.clear().draw();
                for (var i = 1; i <= ins; i++) {
                    var pyint = (+principal * +int / 100);

                    pyint = parseFloat(Math.round(+pyint * 100) / 100).toFixed(2);
                    principal = +principal - (+pymt - +pyint);
                    principal = parseFloat(Math.round(+principal * 100) / 100).toFixed(2);

                    if (principal < 0) {
                        pymt = parseFloat(+pymt + +principal).toFixed(2);
                        principal = parseFloat(Math.round(+principal * 10) / 10).toFixed(2);
                    }

                    var pycap = parseFloat(Math.round((+pymt - +pyint) * 100) / 100).toFixed(2);

                    // last rentel
                    if (i == ins) {

                        if (principal != (Math.round((+totprin + +pycap) / 1) * 1)) {
                            pycap = parseFloat(Math.round((+principal + +pycap) * 100) / 100).toFixed(2);
                        } else {
                            pyint = parseFloat(Math.round((+principal + +pyint) * 100) / 100).toFixed(2);
                        }
                        pymt = parseFloat(Math.round((+pyint + +pycap) * 100) / 100).toFixed(2);
                        principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);

                    }

                    t.row.add([
                        i,
                        pymt,
                        pyint,
                        pycap,
                        principal,
                    ]).draw(false);

                    ttlrnt = +ttlrnt + +pymt;
                    ttlint = +ttlint + +pyint;
                    ttlcap = +ttlcap + +pycap;

                    totInsamount = parseFloat(Math.round((+totInsamount + +pymt) * 100) / 100).toFixed(2);
                    totInt = parseFloat(Math.round((+totInt + +pyint) * 100) / 100).toFixed(2);
                    totprin = parseFloat(Math.round((+totprin + +pycap) * 100) / 100).toFixed(2);

                }

            } else {        // WK & ML
                ins = noins;

                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;

                var pmt_int = int / 1200;
                var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));

                pymt = parseFloat(mm).toFixed(2);
                var totprin = 0;
                var ttlint = 0;
                var ttlcap = 0;
                var ttlrnt = 0;

                t.clear().draw();
                for (var i = 1; i <= ins; i++) {
                    var pyint = (+principal * +int / 100);

                    pyint = parseFloat(Math.round(+pyint * 100) / 100).toFixed(2);
                    principal = +principal - (+pymt - +pyint);
                    principal = parseFloat(Math.round(+principal * 100) / 100).toFixed(2);

                    if (principal < 0) {
                        pymt = parseFloat(+pymt + +principal).toFixed(2);
                        principal = parseFloat(Math.round(+principal * 10) / 10).toFixed(2);
                    }
                    var pycap = parseFloat(Math.round((+pymt - +pyint) * 100) / 100).toFixed(2);

                    // last rentel
                    if (i == ins) {
                        if (principal != (Math.round((+totprin + +pycap) / 1) * 1)) {
                            pycap = parseFloat(Math.round((+principal + +pycap) * 100) / 100).toFixed(2);
                        } else {
                            pyint = parseFloat(Math.round((+principal + +pyint) * 100) / 100).toFixed(2);
                        }
                        pymt = parseFloat(Math.round((+pyint + +pycap) * 100) / 100).toFixed(2);
                        principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);
                    }

                    t.row.add([
                        i,
                        pymt,
                        pyint,
                        pycap,
                        principal,
                    ]).draw(false);

                    ttlrnt = +ttlrnt + +pymt;
                    ttlint = +ttlint + +pyint;
                    ttlcap = +ttlcap + +pycap;

                    totInsamount = parseFloat(Math.round((+totInsamount + +pymt) * 100) / 100).toFixed(2);
                    totInt = parseFloat(Math.round((+totInt + +pyint) * 100) / 100).toFixed(2);
                    totprin = parseFloat(Math.round((+totprin + +pycap) * 100) / 100).toFixed(2);
                }
            }

            $('#ttlpym').text(parseFloat(ttlrnt).toFixed(2));
            $('#ttlint').text(parseFloat(ttlint).toFixed(2));
            $('#ttlcap').text(parseFloat(ttlcap).toFixed(2));
            //  $('#ttlcap').text(parseFloat(Math.round(ttlcap)).toFixed(2));

        } else if (prdmd == 2) {  // flat rate

            if (prdct == 3) {
                var xc = document.getElementById('dyn_dura').value;     // no of installment
                var dytp = document.getElementById('dytp').value;       // product type

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                noins = (+xc / 30 * +dts);
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;
                ins = noins;

                /* var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);   // 1 rental payment
                 var aa = ( ((+noins / 30) * +dts) * ((mm / 10) * 10)  ) - +lnamt;                           // Total int
                 var totalInterest = aa;
                 noins = (noins / 30) * dts;
                 ins = noins;*/

            } else {
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;
                ins = noins;
            }
            var ttlint = 0;
            var ttlcap = 0;
            var ttlrnt = 0;

            var pybcap = parseFloat(Math.round((principal / ins) * 100) / 100).toFixed(2);
            var pybint = parseFloat(+mm - +pybcap).toFixed(2);

            // var pybrntl = parseFloat(Math.round((+pybcap + +pybint) * 100) / 100).toFixed(2);
            var pybrntl = parseFloat(mm).toFixed(2);

            t.clear().draw();
            for (var i = 1; i <= ins; i++) {
                principal = parseFloat(Math.round((+principal - pybcap) * 100) / 100).toFixed(2);

                //if principal is paid off
                if (principal < 0) {
                    pybcap = parseFloat(Math.round((+pybcap + +principal) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((+pybint - +principal) * 100) / 100).toFixed(2);
                    principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);
                }

                // last installment
                if (i == ins) {
                    pybcap = parseFloat(Math.round((+pybcap + +principal) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((+pybint - +principal) * 100) / 100).toFixed(2);
                    principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);

                    pybrntl = parseFloat(Math.round((pybrntl - ((+ttlint + +pybint) - totalInterest)) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((pybint - ((+ttlint + +pybint) - totalInterest)) * 100) / 100).toFixed(2);
                }
                t.row.add([
                    i,
                    pybrntl,
                    pybint,
                    pybcap,
                    principal,
                ]).draw(false);

                ttlint = +ttlint + +pybint;
                ttlrnt = +ttlrnt + +pybrntl;
                ttlcap = +ttlcap + +pybcap;
            }

            $('#ttlpym').text(parseFloat(ttlrnt).toFixed(2));
            $('#ttlint').text(parseFloat(ttlint).toFixed(2));
            $('#ttlcap').text(parseFloat(ttlcap).toFixed(2));
            // $('#ttlcap').text(parseFloat(ttlcap).toFixed(2));
        }
    }


    function chckBtn(id) {
        if (id == 0) {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";
        }
    }

    function pnltyFunc(val) { // 1 enable 0 disable
        if (val == 0) {
            document.getElementById('pnltyFuncDiv1').style.display = "none";
            document.getElementById('pnltyFuncDiv2').style.display = "none";
            document.getElementById('pnltyFuncDiv3').style.display = "none";

            document.getElementById('pncl').value = 0;
        } else {
            document.getElementById('pnltyFuncDiv1').style.display = "block";
            //document.getElementById('pnltyFuncDiv2').style.display = "block";
            document.getElementById('pnltyFuncDiv3').style.display = "block";
        }
    }
    function pnltyFunc2(val) { // 1 enable 0 disable
        if (val == 0) {
            // document.getElementById('pnltyFuncDiv1').style.display = "none";
            document.getElementById('pnltyFuncDiv2').style.display = "none";
        } else {
            // document.getElementById('pnltyFuncDiv1').style.display = "block";
            document.getElementById('pnltyFuncDiv2').style.display = "block";
        }
    }

    function pnltyFuncEdt(val) { // 1 enable 0 disable
        if (val == 0) {
            document.getElementById('pnltyFuncDiv1Edt').style.display = "none";
            document.getElementById('pnltyFuncDiv2Edt').style.display = "none";
            document.getElementById('pnltyFuncDiv3Edt').style.display = "none";

            document.getElementById('pnclEdt').value = 0;
        } else {
            document.getElementById('pnltyFuncDiv1Edt').style.display = "block";
            document.getElementById('pnltyFuncDiv2Edt').style.display = "block";
            document.getElementById('pnltyFuncDiv3Edt').style.display = "block";
        }
    }

    function pnltyFunc2Edt(val) { // 1 enable 0 disable
        if (val == 0) {
            // document.getElementById('pnltyFuncDiv1').style.display = "none";
            document.getElementById('pnltyFuncDiv2Edt').style.display = "none";
        } else {
            // document.getElementById('pnltyFuncDiv1').style.display = "block";
            document.getElementById('pnltyFuncDiv2Edt').style.display = "block";
        }
    }

    function garentFunc(val) { // 0 group product 1 inv prd
        if (val == 1) {
            document.getElementById('garentFuncDiv1').style.display = "none";
            document.getElementById('garentFuncDiv2').style.display = "none";
        } else {
            document.getElementById('garentFuncDiv1').style.display = "block";
            document.getElementById('garentFuncDiv2').style.display = "block";
        }
    }

    function docFunc(val) { // 0 disable  1 enable
        if (val == 0) {
            document.getElementById('damt').style.display = "none";
        } else {
            document.getElementById('damt').style.display = "block";
        }
    }

    function insFunc(val) { // 0 disble 1 enable
        if (val == 0) {
            document.getElementById('iamt').style.display = "none";
        } else {
            document.getElementById('iamt').style.display = "block";
        }
    }

    function searchProduct() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var prtp = document.getElementById('prdtp').value;
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbPrdt').DataTable().clear();
            $('#dataTbPrdt').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3]},
                    {className: "text-center", "targets": [0, 4, 7, 8, 9, 10]},
                    {className: "text-right", "targets": [0, 5, 6]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                // "order": [[10, "desc"]],
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'},
                    {sWidth: '10%'}, // name
                    {sWidth: '5%'},
                    {sWidth: '5%'}, // loan amt
                    {sWidth: '5%'}, //
                    {sWidth: '5%'}, //  index
                    {sWidth: '5%'}, // no of rent
                    {sWidth: '10%'},
                    {sWidth: '13%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>admin/srchProduct',
                    type: 'post',
                    data: {
                        brn: brn,
                        prtp: prtp,
                        stat: stat
                    }
                }
            });
        }
    }

    $("#prdt_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        // alert(document.getElementById('inst').value);
        if ($("#prdt_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addProduct",
                data: $("#prdt_add").serialize(),
                dataType: 'json',

                success: function (data) {
                    searchProduct();
                    $('#step4').modal('hide');
                    swal({title: "", text: "Product added success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function (data, textStatus) {
                    swal({title: "Product added failed", text: data, type: "error"},
                        function () {
                            //location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    function viewPrdt(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewProduct",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("prcat").innerHTML = response[i]['prna'];
                    document.getElementById("prname").innerHTML = response[i]['prnm'];
                    document.getElementById("pramt").innerHTML = numeral(response[i]['lamt']).format('0,0.00');
                    document.getElementById("prist").innerHTML = numeral(response[i]['rent']).format('0,0.00');
                    document.getElementById("docch").innerHTML = numeral(response[i]['docc']).format('0,0.00');

                    document.getElementById("prbrnc").innerHTML = response[i]['brnm'];
                    document.getElementById("prcod").innerHTML = response[i]['prcd'];
                    document.getElementById("nornt").innerHTML = response[i]['nofr'];
                    document.getElementById("ttint").innerHTML = numeral(response[i]['inta']).format('0,0.00');
                    document.getElementById("inschg").innerHTML = numeral(response[i]['insc']).format('0,0.00');

                    document.getElementById("indx").innerHTML = response[i]['lcnt'];
                    if (response[i]['pnst'] == 0) {
                        document.getElementById("pntl").innerHTML = "<span class='label label-danger'> Disable </span>";
                    } else {
                        document.getElementById("pntl").innerHTML = "<span class='label label-success'> Enable </span>";
                    }
//                    document.getElementById("pntl").innerHTML = response[i]['totm'];
//                    document.getElementById("prbrnc").innerHTML = response[i]['totm'];
//                    document.getElementById("prbrnc").innerHTML = response[i]['totm'];
//                    document.getElementById("prbrnc").innerHTML = response[i]['totm'];
//                    document.getElementById("prbrnc").innerHTML = response[i]['totm'];

                }
            }
        })
    }

    function edtPrdt(auid, typ) {

        $('#step1Edt').modal('show');

        if (typ == 'edt') {
            $('#hed1,#hed2,#hed3,#hed4').text("Update Product");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed1,#hed2,#hed3,#hed4').text("Approval Product");
            $('#btnNm').text("Approvel");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>Admin/edtDataPrdt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("prd_catEdt").value = response[i]['prtp'];
                    document.getElementById("prd_brnEdt").value = response[i]['brid'];
                    document.getElementById("prnmEdt").value = response[i]['prnm'];
                    document.getElementById("prcdEdt").value = response[i]['prcd'];
                    document.getElementById("lnamtEdt").value = response[i]['lamt'];

                    document.getElementById("inrtEdt").value = response[i]['inra'];
                    document.getElementById("instEdt").value = response[i]['rent'];
                    document.getElementById("instDBEdt").value = response[i]['rent'];
                    document.getElementById("tintEdt").value = response[i]['inta'];
                    document.getElementById("prd_mdEdt").value = response[i]['prmd'];
                    // DAILY PRODUCT
                    if (response[i]['prtp'] == 3) {
                        document.getElementById('dailyDivEdt').style.display = "block";
                        document.getElementById('nfinstEdt').style.display = "none";

                        abcEdt(response[i]['prtp'], response[i]['cldw']);
                        getLoanPrdtDynEdt(3, response[i]['cldw'], response[i]['nofr']);
                    } else {
                        document.getElementById('dailyDivEdt').style.display = "none";
                        document.getElementById('nfinstEdt').style.display = "block";

                        document.getElementById("noinsEdt").value = response[i]['nofr'];
                    }
                    // END DAILY PRODUCT
                    document.getElementById("auid").value = response[i]['auid'];
                    document.getElementById("iamtEdt").value = response[i]['insc'];
                    document.getElementById("damtEdt").value = response[i]['docc'];

                    document.getElementById("dofrEdt").value = response[i]['dcac'];
                    document.getElementById("infrEdt").value = response[i]['icac'];
                    docFuncEdt(response[i]['dcac']);
                    insFuncEdt(response[i]['icac']);

                    document.getElementById("lnidEdt").value = response[i]['lcnt'];
                    document.getElementById("pntyEdt").value = response[i]['pnst'];
                    document.getElementById("pnclEdt").value = response[i]['pntp'];
                    document.getElementById("pnbsEdt").value = response[i]['pnbs'];
                    document.getElementById("pnl_stdtEdt").value = response[i]['stfm'];
                    document.getElementById("pnlrtEdt").value = response[i]['clrt'];
                    document.getElementById("prlnEdt").value = response[i]['prln'];
                    document.getElementById("remkEdt").value = response[i]['rmks'];
                    document.getElementById("pncdEdt").value = response[i]['pncd'];

                    pnltyFuncEdt(response[i]['pnst']);
                    pnltyFunc2Edt(response[i]['pntp']);
                }
            }
        })
    }

    // product edit / approval modal
    function step2Edt() {
        var lnamt = document.getElementById('lnamtEdt').value;
        var noins = document.getElementById('noinsEdt').value;
        var auid = document.getElementById('auid').value;
        var brnc = document.getElementById('prd_brnEdt').value;
        var prct = document.getElementById('prd_catEdt').value;

        if (smln == 1) {
            if ($("#prdt_edt").valid()) {
                $('#step1Edt').modal('hide');
                $('#step2Edt').modal('show');
            }
            schTblgenarationEdt();
        } else {
            $.ajax({
                url: '<?= base_url(); ?>admin/chk_alrdyPrduct_edt',
                type: 'post',
                data: {
                    lnamt: lnamt,
                    noins: noins,
                    auid: auid,
                    brnc: brnc,
                    prct: prct,
                },
                dataType: 'json',
                success: function (response) {
                    if (response === true) {
                        document.getElementById('lnamtEdt').style.borderColor = "";
                        document.getElementById('noinsEdt').style.borderColor = "";

                        if ($("#prdt_edt").valid()) {
                            $('#step1Edt').modal('hide');
                            $('#step2Edt').modal('show');
                        }
                        schTblgenarationEdt();

                    } else if (response === false) {
                        swal("", "Same loan amount & rental loan already exist", "warning");

                        document.getElementById('lnamtEdt').style.borderColor = "red";
                        document.getElementById('noinsEdt').style.borderColor = "red";
                    }
                }
            });
        }
    }

    function step3Edt() {
        $('#step2Edt').modal('hide');
        $('#step3Edt').modal('show');
    }

    function step4Edt() {
        if ($("#prdt_edt").valid()) {
            $('#step3Edt').modal('hide');
            $('#step4Edt').modal('show');
        }
    }

    function calInstalEdt() {
        var cttp = document.getElementById('prd_catEdt').value;    // Category Type
        var lnamt = document.getElementById('lnamtEdt').value;     // loan amount
        var noins = document.getElementById('noinsEdt').value;     // no of installment
        var inrt = document.getElementById('inrtEdt').value;       // interest rate

        // DAILY LOAN
        if (cttp == 3) {
            var xc = document.getElementById('dyn_duraEdt').value;     // no of installment
            var dytp = document.getElementById('dytpEdt').value;       // product type

            if (dytp == 5) {
                var dts = d5;
            } else if (dytp == 6) {
                var dts = d6;
            } else if (dytp == 7) {
                var dts = d7;
            }
            noins = (+xc / 30 * +dts);

            var mm = -PMT((inrt / 100), noins, lnamt);
            var aa = (+mm * +noins) - lnamt;

            document.getElementById('instEdt').value = numeral(mm).format('0,0.00000000');
            document.getElementById('instDBEdt').value = numeral(mm).format('0.00000000');
            document.getElementById('tintEdt').value = numeral(aa).format('0.0000');

        } else {
            var mm = -PMT((inrt / 100), noins, lnamt);

            document.getElementById('instEdt').value = numeral(mm).format('0,0.0000000');
            document.getElementById('instDBEdt').value = numeral(mm).format('0.0000000');

            var aa = (+mm * +noins) - lnamt;
            document.getElementById('tintEdt').value = numeral(aa).format('0.0000');
        }
        //schTblgenarationEdt();
    }

    function schTblgenarationEdt() {
        var lnamt = document.getElementById('lnamtEdt').value;     // loan amount
        var noins = document.getElementById('noinsEdt').value;     // no of installment
        var inrt = document.getElementById('inrtEdt').value;       // interest rate

        var prdct = document.getElementById('prd_catEdt').value;      // product catogry ( 3-DL / 4-WK/ 5-ML)
        var prdmd = document.getElementById('prd_mdEdt').value;       // product mode ( 1-redusing / 2-flat rate)

        var m = $('#dataTbSchEdt').DataTable();
        $('#dataTbSchEdt').DataTable({
            "destroy": true,
            "cache": false,
            "searching": false,
            paging: false,
            "processing": false,
            "orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "columnDefs": [
                {className: "text-center", "targets": [0]},
                {className: "text-right", "targets": [1, 2, 3, 4]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '10%'}
            ],
        });

        principal = lnamt;
        int = inrt;

        var totInsamount = 0;
        var totInt = 0;
        var totprin = 0;

        if (prdmd == 1) {   // Redusing

            if (prdct == 3) {  // Daily product

                var xc1 = document.getElementById('dyn_duraEdt').value;     // no of installment
                var dytp = document.getElementById('dytpEdt').value;        // product type

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                noins = (+xc1 / 30 * +dts);
                var ins = noins;           // NO OF INSTALLMENT
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int

                var pmt_int = int / 1200;
                var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));
                pymt = parseFloat(mm).toFixed(2);

                var totprin = 0;
                var ttlint = 0;
                var ttlcap = 0;
                var ttlrnt = 0;

                m.clear().draw();
                for (var i = 1; i <= ins; i++) {
                    var pyint = (+principal * +int / 100);

                    pyint = Math.round(+pyint * 100) / 100;
                    principal = +principal - (+pymt - +pyint);
                    principal = Math.round(+principal * 100) / 100;

                    if (principal < 0) {
                        pymt = +pymt + +principal;
                        principal = Math.round(+principal * 10) / 10;
                    }
                    var pycap = Math.round((+pymt - +pyint) * 100) / 100;

                    // last rentel
                    if (i == ins) {
                        if (principal != (((+totprin + +pycap) / 1) * 1)) {
                            pycap = Math.round((+principal + +pycap) * 100) / 100;
                        } else {
                            pyint = Math.round((+principal + +pyint) * 100) / 100;
                        }
                        pymt = Math.round((+pyint + +pycap) * 100) / 100;
                        principal = Math.round((+principal - +principal) * 100) / 100;
                    }

                    m.row.add([
                        i,
                        parseFloat(pymt).toFixed(2),
                        parseFloat(pyint).toFixed(2),
                        parseFloat(pycap).toFixed(2),
                        parseFloat(principal).toFixed(2)
                    ]).draw(false);

                    ttlrnt = +ttlrnt + +pymt;
                    ttlint = +ttlint + +pyint;
                    ttlcap = +ttlcap + +pycap;

                    totInsamount = parseFloat(Math.round((+totInsamount + +pymt) * 100) / 100).toFixed(5);
                    totInt = parseFloat(Math.round((+totInt + +pyint) * 100) / 100).toFixed(5);
                    totprin = parseFloat(Math.round((+totprin + +pycap) * 100) / 100).toFixed(5);
                }
            } else {        // WK & ML
                ins = noins;
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;

                var pmt_int = int / 1200;
                var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));

                pymt = parseFloat(mm).toFixed(5);
                var totprin = 0;
                var ttlint = 0;
                var ttlcap = 0;
                var ttlrnt = 0;

                m.clear().draw();
                for (var i = 1; i <= ins; i++) {
                    var pyint = (+principal * +int / 100);

                    pyint = Math.round(+pyint * 100) / 100;
                    principal = +principal - (+pymt - +pyint);
                    principal = Math.round(+principal * 100) / 100;

                    if (principal < 0) {
                        pymt = +pymt + +principal;
                        principal = Math.round(+principal * 10) / 10;
                    }
                    var pycap = Math.round((+pymt - +pyint) * 100) / 100;

                    // last rentel
                    if (i == ins) {

                        if (principal != (((+totprin + +pycap) / 1) * 1)) {
                            pycap = Math.round((+principal + +pycap) * 100) / 100;
                        } else {
                            pyint = Math.round((+principal + +pyint) * 100) / 100;
                        }
                        pymt = Math.round((+pyint + +pycap) * 100) / 100;
                        principal = Math.round((+principal - +principal) * 100) / 100;
                    }

                    m.row.add([
                        i,
                        parseFloat(pymt).toFixed(2),
                        parseFloat(pyint).toFixed(2),
                        parseFloat(pycap).toFixed(2),
                        parseFloat(principal).toFixed(2)
                    ]).draw(false);

                    ttlrnt = +ttlrnt + +pymt;
                    ttlint = +ttlint + +pyint;
                    ttlcap = +ttlcap + +pycap;

                    totInsamount = parseFloat(Math.round((+totInsamount + +pymt) * 100) / 100).toFixed(5);
                    totInt = parseFloat(Math.round((+totInt + +pyint) * 100) / 100).toFixed(5);
                    totprin = parseFloat(Math.round((+totprin + +pycap) * 100) / 100).toFixed(5);
                }
            }

            $('#ttlpymEdt').text(parseFloat(ttlrnt).toFixed(2));
            $('#ttlintEdt').text(parseFloat(ttlint).toFixed(2));
            $('#ttlcapEdt').text(parseFloat(ttlcap).toFixed(2));
            //  $('#ttlcap').text(parseFloat(Math.round(ttlcap)).toFixed(2));

        } else if (prdmd == 2) {  // flat rate

            if (prdct == 3) {
                var xc = document.getElementById('dyn_duraEdt').value;     // no of installment
                var dytp = document.getElementById('dytpEdt').value;       // product type

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                noins = (+xc / 30 * +dts);
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;
                ins = noins;

            } else {
                var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                var aa = (+mm * +noins) - lnamt;            // Total int
                var totalInterest = aa;
                ins = noins;
            }
            var ttlint = 0;
            var ttlcap = 0;
            var ttlrnt = 0;

            var pybcap = parseFloat(Math.round((principal / ins) * 100) / 100).toFixed(2);
            var pybint = parseFloat(+mm - +pybcap).toFixed(2);
            var pybrntl = parseFloat(mm).toFixed(2);

            m.clear().draw();
            for (var i = 1; i <= ins; i++) {
                principal = parseFloat(Math.round((+principal - pybcap) * 100) / 100).toFixed(2);

                //if principal is paid off
                if (principal < 0) {
                    pybcap = parseFloat(Math.round((+pybcap + +principal) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((+pybint - +principal) * 100) / 100).toFixed(2);
                    principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);
                }
                // last installment
                if (i == ins) {
                    pybcap = parseFloat(Math.round((+pybcap + +principal) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((+pybint - +principal) * 100) / 100).toFixed(2);
                    principal = parseFloat(Math.round((+principal - +principal) * 100) / 100).toFixed(2);

                    pybrntl = parseFloat(Math.round((pybrntl - ((+ttlint + +pybint) - totalInterest)) * 100) / 100).toFixed(2);
                    pybint = parseFloat(Math.round((pybint - ((+ttlint + +pybint) - totalInterest)) * 100) / 100).toFixed(2);
                }
                m.row.add([
                    i,
                    pybrntl,
                    pybint,
                    pybcap,
                    principal,
                ]).draw(false);

                ttlint = +ttlint + +pybint;
                ttlrnt = +ttlrnt + +pybrntl;
                ttlcap = +ttlcap + +pybcap;
            }

            $('#ttlpymEdt').text(parseFloat(ttlrnt).toFixed(2));
            $('#ttlintEdt').text(parseFloat(ttlint).toFixed(2));
            $('#ttlcapEdt').text(parseFloat(ttlcap).toFixed(2));
            // $('#ttlcap').text(parseFloat(ttlcap).toFixed(2));
        }
    }

    function docFuncEdt(val) { // 0 disable  1 enable
        if (val == 0) {
            document.getElementById('damtEdt').style.display = "none";
        } else {
            document.getElementById('damtEdt').style.display = "block";
        }
    }

    function insFuncEdt(val) { // 0 disble 1 enable
        if (val == 0) {
            document.getElementById('iamtEdt').style.display = "none";
        } else {
            document.getElementById('iamtEdt').style.display = "block";
        }
    }


    $("#prdt_edt").submit(function (e) {
        e.preventDefault();
        var xx = document.getElementById('func').value;

        if ($("#prdt_edt").valid()) {

            if (xx == 1) {         // UPDATE PRODUCT
                swal({
                        title: "Are you sure update this product?",
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
                            $('#step1Edt,#step2Edt,#step3Edt,#step4Edt').modal('hide');

                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Admin/edtProduct",
                                data: $("#prdt_edt").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    searchProduct();
                                    swal({title: "", text: "Product update success!", type: "success"});
                                },
                                error: function (data, textStatus) {
                                    swal({title: "Error", text: textStatus, type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });

            } else if (xx == 2) {  // APPROVAL PRODUCT
                swal({
                        title: "Are you sure approval this product ?",
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
                            $('#step1Edt,#step2Edt,#step3Edt,#step4Edt').modal('hide');

                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>Admin/edtProduct",
                                data: $("#prdt_edt").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    searchProduct();
                                    swal({title: "", text: "Product approval Success!", type: "success"});
                                },
                                error: function (data, textStatus) {
                                    swal({title: "Error", text: textStatus, type: "error"},
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
            else {
                alert("Contact system admin ");
            }
        }
    });

    function rejecPrdt(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this check",
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
                    swal("Rejected!", "Product Cancel Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>admin/rejPrduct',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                    searchProduct();
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Product Not cancel", "error");
                }
            });
    }


</script>












