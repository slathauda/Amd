<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>General</li>
    <li class="active">Policy Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Policy Management </strong></h3>
                </div>

                <div class="panel-body">
                    <form method="post" action="" name="policy" id="policy">
                        <div class="panel-body">
                            <div class="row form-horizontal">

                                <class
                                ="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th style="text-align: center">PNo</th>
                                        <th class="col-md-2" style="text-align: center">Policy Name</th>
                                        <th class="col-md-6" style="text-align: center">Policy Description</th>
                                        <th style="text-align: center">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- 01 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[0]->poid ?></td>
                                        <td><strong>   <?= $policyinfo[0]->ponm ?></strong></td>
                                        <td><?= $policyinfo[0]->pods ?> </td>
                                        <td>
                                            <div class="col-md-6"><input type="number" id="cnmb_min"
                                                                         name="cnmb_min"
                                                                         value="<?php echo $policyinfo[0]->pov1 ?>"
                                                                         class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-6"><input type="number" id="cnmb_max"
                                                                         name="cnmb_max"
                                                                         value="<?= $policyinfo[0]->pov2 ?>"
                                                                         class="form-control" placeholder="Max">
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- 02 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[1]->poid ?></td>
                                        <td><strong> <?= $policyinfo[1]->ponm ?></strong></td>
                                        <td><?= $policyinfo[1]->pods ?> </td>
                                        <td>
                                            <div class="col-md-6"><input type="number" id="gpmb_min"
                                                                         name="gpmb_min"
                                                                         value="<?= $policyinfo[1]->pov1 ?>"
                                                                         class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-6"><input type="number" id="gpmb_max"
                                                                         name="gpmb_max"
                                                                         value="<?= $policyinfo[1]->pov2 ?>"
                                                                         class="form-control" placeholder="Max">
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- 03 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[2]->poid ?></td>
                                        <td><strong>  <?= $policyinfo[2]->ponm ?></strong></td>
                                        <td><?= $policyinfo[2]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[2]->post == 1) {
                                                $chk = "checked";
                                            } else {
                                                $chk = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="prln" name="prln" type="checkbox"
                                                       value="1" <?= $chk ?>/>Disable
                                                <span></span>
                                            </label> Enable
                                        </td>
                                    </tr>
                                    <!-- 04 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[3]->poid ?></td>
                                        <td><strong> <?= $policyinfo[3]->ponm ?></strong></td>
                                        <td><?= $policyinfo[3]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[3]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="prpd" name="prpd" type="checkbox"
                                                       value="1" <?= $chk2 ?>/>Disable
                                                <span></span>
                                            </label> Enable
                                        </td>
                                    </tr>
                                    <!-- 05 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[4]->poid ?></td>
                                        <td><strong> <?= $policyinfo[4]->ponm ?></strong></td>
                                        <td><?= $policyinfo[4]->pods ?> </td>
                                        <td>
                                            <div class="col-md-6"><input type="number" id="ingr_min"
                                                                         name="ingr_min"
                                                                         value="<?= $policyinfo[4]->pov1 ?>"
                                                                         class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-6"><input type="number" id="ingr_max"
                                                                         name="ingr_max"
                                                                         value="<?= $policyinfo[4]->pov2 ?>"
                                                                         class="form-control" placeholder="Max">
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- 06 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[5]->poid ?></td>
                                        <td><strong> <?= $policyinfo[5]->ponm ?></strong></td>
                                        <td><?= $policyinfo[5]->pods ?> </td>
                                        <td>
                                            <div class="col-md-6"><input type="number" id="exgr_min"
                                                                         name="exgr_min"
                                                                         value="<?= $policyinfo[5]->pov1 ?>"
                                                                         class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-6"><input type="number" id="exgr_max"
                                                                         name="exgr_max"
                                                                         value="<?= $policyinfo[5]->pov2 ?>"
                                                                         class="form-control" placeholder="Max">
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- 07 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[6]->poid ?></td>
                                        <td><strong> <?= $policyinfo[6]->ponm ?></strong></td>
                                        <td><?= $policyinfo[6]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[6]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="rpvl" name="rpvl" type="checkbox"
                                                       value="1" <?= $chk2 ?>/>Last Payment
                                                <span></span>
                                            </label> Installment
                                        </td>
                                    </tr>
                                    <!-- 08 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[7]->poid ?></td>
                                        <td><strong> <?= $policyinfo[7]->ponm ?></strong></td>
                                        <td><?= $policyinfo[7]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[7]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="rptg" name="rptg" type="checkbox"
                                                       value="1" <?= $chk2 ?>/>Tag Disable
                                                <span></span>
                                            </label> Tag Enable
                                        </td>
                                    </tr>

                                    <!-- 09 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[8]->poid ?></td>
                                        <td><strong> <?= $policyinfo[8]->ponm ?></strong></td>
                                        <td><?= $policyinfo[8]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[8]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="rctp" name="rctp" type="checkbox" data-toggle="modal"
                                                       data-target="#modalAdd"
                                                       value="1" <?= $chk2 ?> onchange="recverTp()"/> Duration
                                                <span></span>
                                            </label> Age
                                        </td>
                                    </tr>
                                    <!-- 10 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[9]->poid ?></td>
                                        <td><strong> <?= $policyinfo[9]->ponm ?></strong></td>
                                        <td><?= $policyinfo[9]->pods ?> </td>
                                        <td>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <input type="number" id="tpag" name="tpag"
                                                       value="<?= $policyinfo[9]->pov3 ?>"
                                                       class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-3"></div>
                                        </td>
                                    </tr>
                                    <!-- 11 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[10]->poid ?></td>
                                        <td><strong> <?= $policyinfo[10]->ponm ?></strong></td>
                                        <td><?= $policyinfo[10]->pods ?> </td>
                                        <td>
                                            <div class="col-md-3"></div>
                                            <div class="input-group col-md-6">
                                                <input type="number" id="tpup_tenr" name="tpup_tenr"
                                                       value="<?= $policyinfo[10]->pov3 ?>"
                                                       class="form-control" placeholder="Min">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </td>
                                    </tr>
                                    <!-- 12 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[11]->poid ?></td>
                                        <td><strong> <?= $policyinfo[11]->ponm ?></strong></td>
                                        <td><?= $policyinfo[11]->pods ?> </td>
                                        <td>
                                            <div class="col-md-3"></div>
                                            <div class="input-group col-md-6">
                                                <input type="number" id="tpup_pymt" name="tpup_pymt"
                                                       value="<?= $policyinfo[11]->pov3 ?>"
                                                       class="form-control" placeholder="Min">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                            <div class="col-md-3"></div>
                                        </td>
                                    </tr>
                                    <!-- 13 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[12]->poid ?></td>
                                        <td><strong> <?= $policyinfo[12]->ponm ?></strong></td>
                                        <td><?= $policyinfo[12]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[12]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="tpup_typ" name="tpup_typ" type="checkbox"
                                                       value="1" <?= $chk2 ?>/> Same category
                                                <span></span>
                                            </label> Any category
                                        </td>
                                    </tr>
                                    <!-- 14 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[13]->poid ?></td>
                                        <td><strong> <?= $policyinfo[13]->ponm ?></strong></td>
                                        <td><?= $policyinfo[13]->pods ?> </td>
                                        <td>
                                            <label class="col-md-1"> 5D</label>
                                            <div class="col-md-3"><input type="number" id="lncl5" name="lncl5"
                                                                         value="<?= $policyinfo[13]->pov1 ?>"
                                                                         class="form-control" placeholder="5D">
                                            </div>
                                            <label class="col-md-1"> 6D</label>
                                            <div class="col-md-3"><input type="number" id="lncl6" name="lncl6"
                                                                         value="<?= $policyinfo[13]->pov2 ?>"
                                                                         class="form-control" placeholder="6D">
                                            </div>
                                            <label class="col-md-1"> 7D</label>
                                            <div class="col-md-3"><input type="number" id="lncl7" name="lncl7"
                                                                         value="<?= $policyinfo[13]->pov3 ?>"
                                                                         class="form-control" placeholder="7D">
                                            </div>

                                        </td>
                                    </tr>
                                    <!-- 15 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[14]->poid ?></td>
                                        <td><strong> <?= $policyinfo[14]->ponm ?></strong></td>
                                        <td><?= $policyinfo[14]->pods ?> </td>
                                        <td>
                                            <div class="col-md-3"></div>
                                            <div class="col-md-6">
                                                <input type="number" id="mxpt" name="mxpt"
                                                       value="<?= $policyinfo[14]->pov2 ?>"
                                                       class="form-control" placeholder="Min">
                                            </div>
                                            <div class="col-md-3"></div>
                                        </td>
                                    </tr>
                                    <!-- 16 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[15]->poid ?></td>
                                        <td><strong> <?= $policyinfo[15]->ponm ?></strong></td>
                                        <td><?= $policyinfo[15]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[15]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="prdindx" name="prdindx" type="checkbox"
                                                       value="1" <?= $chk2 ?>/> Disable
                                                <span></span>
                                            </label> Enable
                                        </td>
                                    </tr>
                                    <!-- 17 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[16]->poid ?></td>
                                        <td><strong> <?= $policyinfo[16]->ponm ?></strong></td>
                                        <td><?= $policyinfo[16]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[16]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="tprdindx" name="tprdindx" type="checkbox"
                                                       value="1" <?= $chk2 ?>/> Disable
                                                <span></span>
                                            </label> Enable
                                        </td>
                                    </tr>
                                    <!-- 18 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[17]->poid ?></td>
                                        <td><strong> <?= $policyinfo[17]->ponm ?></strong></td>
                                        <td><?= $policyinfo[17]->pods ?> </td>

                                        <td align='center'>
                                            <?php if ($policyinfo[17]->post == 1) {
                                                $chk2 = "checked";
                                            } else {
                                                $chk2 = "";
                                            } ?>
                                            <label class="switch">
                                                <input id="samln" name="samln" type="checkbox"
                                                       value="1" <?= $chk2 ?>/> Disable
                                                <span></span>
                                            </label> Enable
                                        </td>
                                    </tr>

                                    <!-- 19 -->
                                    <tr>
                                        <td align="center"><?= $policyinfo[18]->poid ?></td>
                                        <td><strong> <?= $policyinfo[18]->ponm ?></strong></td>
                                        <td><?= $policyinfo[18]->pods ?> </td>
                                        <td align='center'>
                                            <button type="button" class="btn btn-info btn-sm" onclick="penltyMdl()">
                                                Update Penalty
                                            </button>
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-success pull-right">Process</button>
                </div>
                </form>

            </div>
        </div>
    </div>
</div>

</div>
<!-- END PAGE CONTENT WRAPPER -->


<!-- RECOVER TYPE CHANGE MODALS -->
<div class="modal animated fadeIn" id="modal_recver" tabindex="-1" role="dialog"
     aria-labelledby="smallModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="smallModalHead"></h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="recver_form" name="recver_form" action=""
                      method="post">
                    <div class="panel-body panel-body-table">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tbRecvedata">
                                <thead>
                                <tr>
                                    <th class="text-center">PRODUCT</th>
                                    <th class="text-center">1 LETTER</th>
                                    <th class="text-center">2 LETTER</th>
                                    <th class="text-center">3 LETTER</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" name="lensp" id="lensp">
                    <input type="hidden" name="rcvTp" id="rcvTp">
                    <div class="panel-footer">
                        <button type="button" class="btn btn-success pull-right" id="addRecvr">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- END MODALS -->

<!-- PENELTY MODALS -->
<div class="modal animated fadeIn" id="modal_penelty" tabindex="-1" role="dialog"
     aria-labelledby="smallModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="">Penalty Update</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="pnlty_form" name="pnlty_form" action=""
                      method="post">
                    <div class="panel-body panel-body-table">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-4  control-label">Product Type </label>
                                                        <div class="col-md-8 ">
                                                            <select class="form-control" name="prtp" id="prtp"
                                                                    onchange="pnltyDetils(this.value)">
                                                                <option value="0"> Select Product Type</option>
                                                                <?php
                                                                foreach ($prdtypeinfo as $prdtp) {
                                                                    echo "<option value='$prdtp->prid'>$prdtp->prtp  | $prdtp->prna</option>";
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
                                                                       name="pnl_stdt" id="pnl_stdt"
                                                                       placeholder="Start From"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-md-5  control-label">Penalty Cal Rate
                                                            (Y%)</label>
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
                                                        <label class="col-md-4  control-label">Penalty
                                                            Condition </label>
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
                                            </div>
                                            <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer">
                        <button type="button" class="btn btn-success pull-right" id="addPnlty">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- END MODALS -->


<script>
    $().ready(function () {
        $("#policy").validate({  // center add form validation
            rules: {
                cnmb_min: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 75,
                    greaterThan: "#cnmb_max"
                },
                cnmb_max: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 75,
                    lessThan: "#cnmb_min"
                },
                gpmb_min: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 75,
                    greaterThan: "#gpmb_max"
                },
                gpmb_max: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 75,
                    lessThan: "#gpmb_min"
                },
                ingr_min: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 6,
                    greaterThan: "#ingr_max"
                },
                ingr_max: {
                    required: true,
                    digits: true,
                    min: 2,
                    max: 6,
                    lessThan: "#ingr_min"
                },
                exgr_min: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 5,
                    greaterThan: "#exgr_max"
                },
                exgr_max: {
                    required: true,
                    digits: true,
                    min: 2,
                    max: 5,
                    lessThan: "#exgr_min"
                },

                tpag: {
                    number: true,
                    min: 0,
                    max: 100,
                },
                tpup_tenr: {
                    number: true,
                    min: 0,
                    max: 100,
                },
                tpup_pymt: {
                    number: true,
                    min: 0,
                    max: 100,
                },
                lncl5: {
                    number: true,
                    min: 0,
                },
                lncl6: {
                    number: true,
                    min: 0,
                },
                lncl7: {
                    number: true,
                    min: 0,
                },

                mxpt: {
                    number: true,
                    min: 0,
                },


            },
            messages: {
//                brch_cnt: {
//                    required: 'Please select Branch',
//                    notEqual: "Please select Branch",
//                },
//                cnt_exc: {
//                    required: 'Please enter New Password',
//                    notEqual: "Please select Executive"
//                },
//                cntnm: {
//                    required: 'Please Enter Center Name',
//                    remote: 'Name Already Exists  '
//                },
//                mxmbr: {
//                    required: 'Please Enter Max Member ',
//                    digits: 'This is not a valid Number'
//                },
//                ngrp: {
//                    required: 'Please Enter No of Group ',
//                    digits: 'This is not a valid Number'
//                }
            }
        });

        $("#pnlty_form").validate({  // center add form validation
            rules: {
                prtp: {
                    required: true,
                    notEqual: 0
                },
                pncl: {
                    required: true,
                    notEqual: 0
                },
                pnbs: {
                    required: true,
                    notEqual: 0
                },
                pnl_stdt: {
                    required: true,
                    digits: true,
                },
                pnlrt: {
                    required: true,
                    number: true,
                },
                pncd: {
                    required: true,
                },
            },
            messages: {
                prtp: {
                    required: 'Please select Product Type',
                    notEqual: "Please select Product Type",
                },
                pncl: {
                    required: 'Please select Penalty Cal. On',
                    notEqual: "Please select Penalty Cal. On"
                },
                pnbs: {
                    required: 'Please select Penalty Base On',
                },
                /*mxmbr: {
                 required: 'Please Enter Max Member ',
                 digits: 'This is not a valid Number'
                 },
                 ngrp: {
                 required: 'Please Enter No of Group ',
                 digits: 'This is not a valid Number'
                 }*/
            }
        });

        $('#tbRecvedata').DataTable({
            destroy: true,
            searching: false,
            bPaginate: false,
            "ordering": false,
        });
    });

    // RECEOVERY TYPE
    function recverTp(id) {
        var rctp = document.getElementById("rctp").value;

        if ($('[name="rctp"]').is(':checked')) {

            console.log('checked');
            $('#modal_recver').modal('show');
            document.getElementById("smallModalHead").innerHTML = "Edit Recover Age Details";

            $('#tbRecvedata').DataTable().clear();

            recverTpLoad(1);
        }
        else {
            console.log('not checked');
            $('#modal_recver').modal('show');
            document.getElementById("smallModalHead").innerHTML = "Edit Recover Duration Details";

            recverTpLoad(2);
        }
    }

    function recverTpLoad(tp) {  // 1 age / 2 duration

        document.getElementById("rcvTp").value = tp;
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/loadRcverdata",
            data: {
                tp: tp
            },
            dataType: 'json',
            success: function (response) {
                var len2 = response.length;

                $('#tbRecvedata').DataTable().clear();
                var t2 = $('#tbRecvedata').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    bAutoWidth: false,
                    "columnDefs": [
                        {className: "text-left", "targets": [0]},
                        {className: "text-center", "targets": [1, 2, 3]},
                        {className: "text-nowrap", "targets": [0]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'},
                        {sWidth: '10%'}
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;
                        document.getElementById("lensp").value = display.length;
                    },
                });
                for (var a = 0; a < len2; a++) {
                    var hid = "<label class=''><input type='hidden' name='prid[" + a + "]'  value=" + response[a]['prid'] + " /> </label>";
                    var fslt = "<input type='text' class='form-control' name='fslt[" + a + "]' id='fslt' value=" + response[a]['fltr'] + ">";
                    var sclt = "<input type='text' class='form-control' name='sclt[" + a + "]' id='sclt' value=" + response[a]['sltr'] + ">";
                    var thlt = "<input type='text' class='form-control' name='thlt[" + a + "]' id='thlt' value=" + response[a]['tltr'] + ">";

                    t2.row.add([
                        response[a]['prna'],
                        fslt,
                        sclt,
                        thlt + hid
                    ]).draw(false);
                }
            }
        })
    }

    //  add recover form
    $("#addRecvr").click(function (e) {
        e.preventDefault();
        if ($("#recver_form").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addRecverData",
                data: $("#recver_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modal_recver').modal('hide');

                    swal({title: "", text: "Cheque book added success!", type: "success"},
                        function () {
                            // location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Cheque book added Failed!", type: "error"},
                        function () {
                            // location.reload();
                        });
                }
            });
        } else {
            //            alert("Error");
        }
    });

    // POLICY SUBMIT
    $("#policy").submit(function (e) { // add form
        e.preventDefault();
        if ($("#policy").valid()) {

            swal({
                    title: "Are you sure?",
                    text: "System Policy Change",
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
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>admin/addPollicy",
                            data: $("#policy").serialize(),
                            dataType: 'json',
                            success: function (response) {
                                swal({title: "", text: "Policy Update Successfully!", type: "success"}, function () {
                                    location.reload();
                                });
                            },
                            error: function () {
                                swal({title: "", text: "Policy Update Failed!", type: "error"}, function () {
                                    location.reload();
                                });
                            }
                        });
                    } else {
                        swal("Cancelled!", "Policy Update Cancel", "error");
                    }
                });
        } else {
            //    mng_loan        alert("Error");
        }
    });

    // PENELTY MODEL
    function penltyMdl() {
        $('#modal_penelty').modal('show');
    }

    // PRODUCT TYPE WISE PENALTY DETAILS LOAD
    function pnltyDetils(prtp) {

        if (prtp == 0) {
            document.getElementById('prtp').style.borderColor = "red";
        } else {
            document.getElementById('prtp').style.borderColor = "";

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>Admin/getDynmicPnalty",
                data: {
                    prtp: prtp
                },
                dataType: 'json',
                success: function (response) {
                    var len = response.length;

                    if (len > 0) {

                        for (var i = 0; i < len; i++) {
                            document.getElementById("pnty").value = response[i]['pnst'];
                            document.getElementById("pncl").value = response[i]['pntp'];
                            document.getElementById("pnbs").value = response[i]['pnbs'];
                            document.getElementById("pnl_stdt").value = response[i]['stfm'];
                            document.getElementById("pnlrt").value = response[i]['clrt'];
                            document.getElementById("prln").value = response[i]['prln'];
                            document.getElementById("remk").value = response[i]['rmks'];
                            document.getElementById("pncd").value = response[i]['pncd'];

                            pnltyFunc(response[i]['pnst']);
                            pnltyFunc2(response[i]['pntp']);
                        }
                    } else {
                        document.getElementById("pnty").value = 0;
                        document.getElementById("pncl").value = 0;
                        document.getElementById("pnbs").value = 0;
                        document.getElementById("pnl_stdt").value = 0;
                        document.getElementById("pnlrt").value = 0;
                        document.getElementById("prln").value = 0;
                        document.getElementById("remk").value = '';
                        document.getElementById("pncd").value = 0;

                        pnltyFunc(0);
                        pnltyFunc2(0);
                    }
                }
            })
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
    // PENALTY FORM SUBMIT
    $("#addPnlty").click(function (e) {
        e.preventDefault();
        if ($("#pnlty_form").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/dynamicPenalty",
                data: $("#pnlty_form").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modal_penelty').modal('hide');

                    swal({title: "", text: "Penalty Update success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Penalty Update Failed!", type: "error"},
                        function () {
                            // location.reload();
                        });
                }
            });
        }
    });


</script>











