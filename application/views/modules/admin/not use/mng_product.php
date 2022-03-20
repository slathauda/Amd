<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/bootstrap/bootstrap-datepicker.js"></script>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/dist/js/plugins/bootstrap/bootstrap-timepicker.min.js"></script>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Micro Finance</li>
    <li>Loan Module</li>
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
                    <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#step1"><span><i
                                    class="fa fa-plus"></i></span> Add Product
                    </button>
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
                                            if ($branch['brch_id'] != '0') {
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
                                           id="dataTbPrdt">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH</th>
                                            <th class="text-center">TYPE</th>
                                            <th class="text-center">NAME</th>
                                            <th class="text-center">CODE</th>
                                            <th class="text-center">LOAN AMOUNT</th>
                                            <th class="text-center">RENTAL</th>
                                            <th class="text-center">NO OF RENT</th>
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
                            <li><a href="#">Service Charge</a></li>
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
                                                            onchange="">
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
                                                <label class="col-md-4  control-label">Product Branch</label>
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
                                                        <input type="text" class="form-control" name="prcd"
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of Installment</label>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="inrt" id="inrt"
                                                               placeholder="Rate" onkeyup="calInstal('rate');"
                                                               onfocus=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Installment</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="inst"
                                                               id="inst"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="tint" id="tint"
                                                               title="" placeholder="Total Interest"
                                                               onkeyup="calInstal('ttl');" onfocus=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="text" id="instDB" name="instDB">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-right" id="nxtBtn1" data-toggle="modal"
                            onclick="step2() "
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
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create2</h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">
                                    General Details </a></li>
                            <li class="active"><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charge</a></li>
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
                                                   id="dataTb">
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
                                                <?php
                                                for ($a = 0; $a <= 5; $a++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center">#</td>
                                                        <td class="text-right">PAYMENT</td>
                                                        <td class="text-right">INTEREST</td>
                                                        <td class="text-right">PRINCIPLE</td>
                                                        <td class="text-right">BALANCE</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
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
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create3</h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li class="active"><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charge</a></li>
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
                                                <label class="col-md-5  control-label">Panalty </label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pnty" id="pnty"
                                                            onchange="pnltyFunc(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="pnltyFuncDiv1">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Panalty Cal. On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pncl" id="pncl">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="pnltyFuncDiv2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Panalty Base On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pnbs" id="pnbs">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Start From</label>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnl_stdt" id="pnl_stdt" placeholder="Days"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnlrt" id="pnlrt" placeholder="Cal Rate"
                                                               title="%"/>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Multi Loans </label>
                                                <div class="col-md-6 ">
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
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="garentFuncDiv1">
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
                                    <br>
                                    <div class="row" id="garentFuncDiv2">
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
                                    <br>
                                    <div class="row">
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
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Product Create4</h4>
                    <div class="number">
                        <ul>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step3">Other
                                    Details</a></li>
                            <li class="active"><a href="#">Service Charge</a></li>
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
                                        <label class="col-md-4 col-xs-12 control-label">Category</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="prcat"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Name</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="prname"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan amount</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="pramt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="prist"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Doc Charges</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="docch"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch</label>
                                        <label class="col-md-4 col-xs-12 control-label" id="prbrnc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Code</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="prcod"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="nornt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Total Inter</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="ttint"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Insu Chrg</label>
                                        <label class="col-md-4 col-xs-6 control-label" id="inschg"></label>
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
                            <li><a href="#">Service Charge</a></li>
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
                                                            onchange="">
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
                                                <label class="col-md-4  control-label">Product
                                                    Branch</label>
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
                                                        <input type="text" class="form-control" name="prcdEdt"
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">No of
                                                    Installment</label>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="inrtEdt"
                                                               id="inrtEdt"
                                                               placeholder="Rate"
                                                               onkeyup="calInstalEdt('rate');"
                                                               onfocus=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Installment</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="instEdt"
                                                               id="instEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Total
                                                    Interest</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class="form-control" name="tintEdt"
                                                               id="tintEdt"
                                                               title="" placeholder="Total Interest"
                                                               onkeyup="calInstal('ttl');"
                                                               onfocus=""/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="instDBEdt" name="instDBEdt">
                                    </div>
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
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">
                                    General Details </a></li>
                            <li class="active"><a href="#">Schedule Details</a></li>
                            <li><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charge</a></li>
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
                                                   id="dataTb">
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
                                                <?php
                                                for ($a = 0; $a <= 5; $a++) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-center">#</td>
                                                        <td class="text-right">PAYMENT</td>
                                                        <td class="text-right">INTEREST</td>
                                                        <td class="text-right">PRINCIPLE</td>
                                                        <td class="text-right">BALANCE</td>
                                                    </tr>
                                                    <?php
                                                }
                                                ?>
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
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li class="active"><a href="#">Other Details</a></li>
                            <li><a href="#">Service Charge</a></li>
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
                                                <label class="col-md-5  control-label">Panalty </label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pnty" id="pnty"
                                                            onchange="pnltyFunc(this.value)">
                                                        <option value="1"> Enable</option>
                                                        <option value="0"> Disable</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" id="pnltyFuncDiv1">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Panalty Cal.
                                                    On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pncl" id="pncl">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="pnltyFuncDiv2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Panalty Base
                                                    On</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="pnbs" id="pnbs">
                                                        <?php
                                                        foreach ($execinfo as $exe) {
                                                            echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Start From</label>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnl_stdt" id="pnl_stdt"
                                                               placeholder="Days"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="pnlrt" id="pnlrt"
                                                               placeholder="Cal Rate"
                                                               title="%"/>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Multi Loans </label>
                                                <div class="col-md-6 ">
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
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="garentFuncDiv1">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Mutural
                                                    Guarantors</label>
                                                <div class="col-md-2 ">
                                                    <input type="checkbox" class="icheckbox" id="mugr"
                                                           name="mugr"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="nogr"
                                                               id="nogr"
                                                               placeholder="No of"
                                                               title="No of Guarantors"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">External
                                                    Guarantors</label>
                                                <div class="col-md-2 ">
                                                    <input type="checkbox" class="icheckbox" id="exgr"
                                                           name="exgr"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="noexgr"
                                                               id="noexgr" placeholder="No of "
                                                               title="No of External Guarantors"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row" id="garentFuncDiv2">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Mortgage</label>
                                                <div class="col-md-2 ">
                                                    <input type="checkbox" class="icheckbox" id="mrtg"
                                                           name="mrtg"/>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="motg"
                                                               id="motg"
                                                               placeholder="No of Mortgage"/>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Age Limit</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="aglmt"
                                                               id="aglmt"
                                                               placeholder="Age Limite"/>
                                                    </div>
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
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step1">General
                                    Details </a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step2">Schedule
                                    Details</a></li>
                            <li><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#step3">Other
                                    Details</a></li>
                            <li class="active"><a href="#">Service Charge</a></li>
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
        searchProduct();

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
//                cntnm: {
//                    required: true,
//                    remote: {
//                        url: "<?//= base_url(); ?>//user/chk_Centname",
//                        type: "post",
//                        data: {
//                            cnnm: function () {
//                                return $("#cntnm").val();
//                            },
//                            brnc: function () {
//                                return $("#brch_cnt").val();
//                            }
//                        }
//                    }
//                },
                prnm: {
                    required: true
                },
                prcd: {
                    required: true
                },
                lnamt: {
                    required: true,
                    digits: true
                },
                noins: {
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
                    required: 'Enter Product Code '
                },
                lnamt: {
                    required: 'Enter Loan Amount ',
                    digits: 'This is not a valid Number'
                },
                noins: {
                    required: 'Enter No of Instalment ',
                    digits: 'This is not a valid Number'
                },
            }
        });

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
                    required: true
                },
                lnamtEdt: {
                    required: true,
                    digits: true
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
                    required: 'Enter Product Code '
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
            }
        });


    });


    // Product add model
    function step2() {
        $("#nxtBtn1").on('click', function (e) { // step1 form
            e.preventDefault();
            if ($("#prdt_add").valid()) {
                $('#step1').modal('hide');
                $('#step2').modal('show');
            }
        });
    }

    function step3() {
        $('#step2').modal('hide');
        $('#step3').modal('show');
    }

    function step4() {
        $('#step3').modal('hide');
        $('#step4').modal('show');
    }

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

    function calInstal(typ) {
        var lnamt = document.getElementById('lnamt').value;     // loan amount
        var noins = document.getElementById('noins').value;     // no of installment
        var inrt = document.getElementById('inrt').value;       // interest rate
        var tint = document.getElementById('tint').value;       // total interest

        if (typ == 'rate') {
            //  var xx = ((+lnamt * (100 + +inrt)) / 100 ) / noins;
            var mm = -PMT((inrt / 100), noins, lnamt);
            // alert(mm);

            document.getElementById('inst').value = numeral(mm).format('0,0.0000');
            document.getElementById('instDB').value = numeral(mm).format('0.0000');

            var aa = (+mm * +noins) - lnamt;
            document.getElementById('tint').value = numeral(aa).format('0.00');

            console.log(aa);
        } else if (typ == 'ttl') {
//            var yy = ((+lnamt + +tint) ) / noins;
//            document.getElementById('inst').value = numeral(yy).format('0,0.0000');
//            document.getElementById('instDB').value = numeral(yy).format('0.0000');
//
//            var zz = (+tint / +lnamt) * 100;
//            document.getElementById('inrt').value = numeral(zz).format('0.0000');

            //var result = PMT(0.174 , 12 , 10000 , 0 , 0);
            //console.log(zz);

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
        } else {
            document.getElementById('pnltyFuncDiv1').style.display = "block";
            document.getElementById('pnltyFuncDiv2').style.display = "block";
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
                    {className: "text-left", "targets": [1, 2]},
                    {className: "text-center", "targets": [0, 3, 4, 7, 8]},
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

        alert(document.getElementById('inst').value);


        if ($("#prdt_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addProduct",
                data: $("#prdt_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    swal("Product Added Successfully!", data.message, "success");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>admin/product';
                    }, 2000000);
                },
                error: function () {
                    swal("Product Added Failed!", data.message, "error");
                    window.setTimeout(function () {
                        location = '<?= base_url(); ?>admin/product';
                    }, 2000000);

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
                    document.getElementById("prcat").innerHTML = response[i]['prtp'];
                    document.getElementById("prname").innerHTML = response[i]['prnm'];
                    document.getElementById("pramt").innerHTML = response[i]['lamt'];
                    document.getElementById("prist").innerHTML = response[i]['rent'];
                    document.getElementById("docch").innerHTML = response[i]['docc'];

                    document.getElementById("prbrnc").innerHTML = response[i]['brnm'];
                    document.getElementById("prcod").innerHTML = response[i]['prcd'];
                    document.getElementById("nornt").innerHTML = response[i]['nofr'];
                    document.getElementById("ttint").innerHTML = response[i]['inta'];
                    document.getElementById("inschg").innerHTML = response[i]['insc'];
                    // document.getElementById("prbrnc").innerHTML = response[i]['totm'];

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
                    document.getElementById("noinsEdt").value = response[i]['nofr'];
                    document.getElementById("inrtEdt").value = response[i]['inra'];
                    document.getElementById("instEdt").value = response[i]['rent'];
                    document.getElementById("tintEdt").value = response[i]['inta'];
                    document.getElementById("instDBEdt").value = response[i]['inta'];

                    document.getElementById("auid").value = response[i]['auid'];

                    document.getElementById("iamtEdt").value = response[i]['insc'];
                    document.getElementById("damtEdt").value = response[i]['docc'];

                    document.getElementById("dofrEdt").value = response[i]['dcac'];
                    document.getElementById("infrEdt").value = response[i]['icac'];

                    docFuncEdt(response[i]['dcac']);
                    insFuncEdt(response[i]['icac']);
                    //  document.getElementById("auid").value = response[i]['caid'];
                }
            }
        })
    }

    // product edit / approval modal
    function step2Edt() {
        $("#nxtBtn1Edt").on('click', function (e) { // step1 form
            e.preventDefault();
            if ($("#prdt_edt").valid()) {
                $('#step1Edt').modal('hide');
                $('#step2Edt').modal('show');
            }
        });
    }

    function step3Edt() {
        $('#step2Edt').modal('hide');
        $('#step3Edt').modal('show');
    }

    function step4Edt() {
        $('#step3Edt').modal('hide');
        $('#step4Edt').modal('show');
    }

    function calInstalEdt(typ) {
        var lnamt = document.getElementById('lnamtEdt').value;     // loan amount
        var noins = document.getElementById('noinsEdt').value;     // no of installment
        var inrt = document.getElementById('inrtEdt').value;       // interest rate


        var mm = -PMT((inrt / 100), noins, lnamt);

        document.getElementById('instEdt').value = numeral(mm).format('0,0.0000');
        document.getElementById('instDBEdt').value = numeral(mm).format('0.0000');

        var aa = (+mm * +noins) - lnamt;
        document.getElementById('tintEdt').value = numeral(aa).format('0.00');
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

        if ($("#prdt_edt").valid()) {
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
                        document.getElementById('edtbtn').disabled = true;

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>Admin/edtProduct",
                            data: $("#prdt_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                document.getElementById('edtbtn').disabled = false;
                                swal("Success!", " ", "success");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>Admin/product';
                                }, 3000);
                                // searchpettyCash();
                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
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
                    swal("Rejected!", "Center Reject Success", "success");
                    setTimeout(function () {
                        $.ajax({
                            url: '<?= base_url(); ?>user/rejCenter',
                            type: 'post',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            success: function (response) {
                                if (response) {
                                    // location = '<?= base_url(); ?>user/cent_mng';
                                    searchCenter();
                                }
                            }
                        });
                    }, 2000);
                } else {
                    swal("Cancelled!", "Center Not Rejected", "error");
                }
            });
    }


</script>












