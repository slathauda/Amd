<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.css"/>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.js"></script>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Investment Module</li>
    <li class="active"> Investment</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Investment Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Investment
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
                                            <select class="form-control" name="fill_stat" id="fill_stat">
                                                <option value="-">-- Select Status --</option>
                                                <option value="all">All</option>
                                                <option value="1">Active</option>
                                                <option value="0">Pending</option>
                                                <option value="2">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="button form-control  " onclick="searchInvest()"
                                                class='btn-sm btn-primary panel-refresh' id="pc_refresh">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6"></div>
                            <br>
                            <br>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbInsBank" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">NIC</th>
                                            <th class="text-center">Mobile</th>
                                            <th class="text-center">Account Number</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Total Rate</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">Maturity date</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTION</th>
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
<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Investment Create</h4>
            </div>
            <form class="form-horizontal" id="insvest_Add" name="insvest_Add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Investor Nic
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" name="inic" id="inic"
                                                           placeholder="Investor Nic" on onkeyup="srchIns(this.id);"/>
                                                    <input type="hidden" id="auid" name="auid"/>
                                                    <input type="hidden" id="bnid" name="bnid"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Amount
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" name="amnt" id="amnt"
                                                           placeholder="Amount"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Total Rate (Monthly Rate %)
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" name="tort" id="tort"
                                                           placeholder="Total Rate (Monthly Rate)"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Start Date</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class=" form-control datepicker text-uppercase"
                                                               placeholder="" id="stdt" name="stdt"
                                                               value="<?= date('Y-m-d') ?>" onclick="formatDate()">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Period
                                                </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" onclick="formatDate()" name="perd"
                                                                id="perd">
                                                            <option value="">Select Period</option>

                                                            <option value="3">Three Month</option>
                                                            <option value="6">Six Month</option>
                                                            <option value="12">One year</option>
                                                            <option value="24">Two Year</option>
                                                            <option value="36">Three Year</option>
                                                            <option value="48">Four Year</option>
                                                            <option value="60">Five Year</option>
                                                            <option value="0">Non Expired</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Maturity date(renew date)
                                                </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group ">
                                                        <input type="text" class=" form-control text-uppercase "
                                                               placeholder="Maturity date(renew date)" id="mtdt"
                                                               name="mtdt">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Investor Rate
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" name="inrt"
                                                           onkeyup="calRateset();loadind();" id="inrt"
                                                           placeholder="Investor Rate"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Remarks
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control text-uppercase" placeholder="remarks"
                                                           id="remk" name="remk"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Investor Pay mode
                                                </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="inpy" name="inpy" type="checkbox" value="1" checked
                                                               onchange="insdDtil()"/> Pay <span></span> </label> Re
                                                    Investment
                                                </div>
                                            </div>

                                            <div class="panel-body" id="insdDiv" style="display: none">
                                                <h3 class="text-title"><span class="fa fa-bookmark"></span> Investor
                                                    paying
                                                </h3>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Account No </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control text-uppercase" name="acno" id="acno"
                                                                onchange="chckBtn(this.value,'acno');">
                                                        </select>

                                                        <input type="hidden" name="bkid" id="bkid">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay mode
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <select class="form-control text-uppercase" name="pamd" id="pamd">
                                                                <option value="">Pay mode</option>
                                                                <option value="1">DL</option>
                                                                <option value="7">WK</option>
                                                                <option value="30">ML</option>
                                                                <option value="90">QT</option>
                                                                <option value="365">AN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div id="insDiv" style="display: none; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label" id="innm"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Address </label>
                                                    <label class="col-md-6 col-xs-12 control-label" id="hoad"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Nic </label>
                                                    <label class="col-md-6 col-xs-12 control-label" id="inicc"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label" id="mobii"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Introduce paying
                                                </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="idpy" name="idpy" type="checkbox" value="1"
                                                               onchange="indDtil()"/> No
                                                        <span></span>
                                                    </label> Yes
                                                </div>
                                            </div>

                                            <div class="panel-body" id="indDiv" style="display: none">
                                                <h3 class="text-title"><span class="fa fa-bookmark"></span> Introduce
                                                    paying
                                                </h3>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce Nic
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control text-uppercase" name="idnm" id="idnm"
                                                               placeholder="Introduce Nic"
                                                               onkeyup="srchIntro()"  onchange="srchIntro()"/>
                                                        <input type="hidden" id="indauid" name="indauid">
                                                        <input type="hidden" id="indbnid" name="indbnid">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce commission(%)
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control text-uppercase" readonly
                                                               placeholder="Introduce commission" id="idcm"
                                                               name="idcm"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce Account
                                                    </label>
                                                    <div class="col-md-6">
                                                        <select class="form-control text-uppercase" name="idac" id="idac"
                                                                onchange="chckBtn(this.value,'idac');">
                                                            <option value=""> Account Number</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">

                                            <div id="indDivv"
                                                 style="display: none;    margin-top: 97px; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label" id="ind"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="indmobi"></label>
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
                    <button type="submit" class="btn btn-success" id="addInsvest">Submit</button>
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
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Investment Details</h4>
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
                                            <label class="col-md-6  control-label" id="innm_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Investor pay mode </label>
                                            <label class="col-md-6  control-label" id="inpy_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Inverster Nic</label>
                                            <label class="col-md-6  control-label" id="inic_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Pay mode </label>
                                            <label class="col-md-6  control-label" id="pamd_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Amount</label>
                                            <label class="col-md-6  control-label" id="amnt_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Account Number </label>
                                            <label class="col-md-6  control-label" id="acno_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Total Rate</label>
                                            <label class="col-md-6  control-label" id="tort_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Introduce paying </label>
                                            <label class="col-md-6  control-label" id="idpy_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Start Date
                                            </label>
                                            <label class="col-md-6  control-label" id="stdt_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Introruce Name </label>
                                            <label class="col-md-6  control-label" id="idnm_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Period </label>
                                            <label class="col-md-6  control-label" id="perd_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Introduce commission </label>
                                            <label class="col-md-6  control-label" id="idcm_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Maturity date(renew date) </label>
                                            <label class="col-md-6  control-label" id="mtdt_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">


                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Remarks </label>
                                            <label class="col-md-6  control-label" id="remk_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Investor Rate </label>
                                            <label class="col-md-6  control-label" id="inrt_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6">
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
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="insvest_edit" name="insvest_edit" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Investor Nic
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" name="inic_edit"
                                                           id="inic_edit" placeholder="Investor Nic" on
                                                           onkeyup="srchInsEdit(this.id,'inic_edit');"/>
                                                    <input type="hidden" id="auid_edit" name="auid_edit"/>
                                                    <input type="hidden" id="bnid_edit" name="bnid_edit"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Amount
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control" name="amnt_edit"
                                                           id="amnt_edit" placeholder="Amount"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Total Rate (Monthly Rate %)
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control" name="tort_edit" onkeyup="calRatesetedit();loadindedit();"
                                                           id="tort_edit" placeholder="Total Rate (Monthly Rate)"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Start Date</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class=" form-control datepicker"
                                                               placeholder="" id="stdt_edit" name="stdt_edit"
                                                               value="<?= date('Y-m-d') ?>" onclick="formatDate()">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Period
                                                </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <select class="form-control" onclick="formatDate()"
                                                                name="perd_edit" id="perd_edit">
                                                            <option value="">Select Period</option>
                                                            <option value="3">Three Month</option>
                                                            <option value="6">Six Month</option>
                                                            <option value="12">One year</option>
                                                            <option value="24">Two Year</option>
                                                            <option value="36">Three Year</option>
                                                            <option value="48">Four Year</option>
                                                            <option value="60">Five Year</option>
                                                            <option value="0">Non Expired</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Maturity date(renew date)
                                                </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group  bootstrap-timepicker">
                                                        <input type="text" class=" form-control "
                                                               placeholder="Maturity date(renew date)" id="mtdt_edit"
                                                               name="mtdt_edit">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Investor Rate
                                                </label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control" name="inrt_edit"
                                                           id="inrt_edit" onkeyup="calRatesetedit();loadindedit();" placeholder="Amount"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Remarks
                                                </label>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" placeholder="remarks"
                                                           id="remk_edit" name="remk_edit"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Investor Pay mode
                                                </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="inpy_edit" name="inpy_edit" type="checkbox" value="1"
                                                               checked onchange="insdDtiledit()"/> Pay <span></span>
                                                    </label> Re Investment
                                                </div>
                                            </div>
                                            <div class="panel-body" id="insdDivedit" style="display: none">
                                                <h3 class="text-title"><span class="fa fa-bookmark"></span> Introduce
                                                    paying
                                                </h3>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Account No </label>
                                                    <div class="col-md-6 ">
                                                        <select class="form-control" name="acno_edit" id="acno_edit"
                                                                onchange="chckBtn(this.value,'acno_edit');">
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Pay mode
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <select class="form-control" name="pamd_edit"
                                                                    id="pamd_edit">
                                                                <option value="">Pay mode</option>
                                                                <option value="1">DL</option>
                                                                <option value="2">WK</option>
                                                                <option value="3">ML</option>
                                                                <option value="4">QT</option>
                                                                <option value="5">AN</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="insDiv_Edit" style="display: none; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="innm_Edit"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Address </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="hoad_Edit"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Nic </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="inicc_Edit"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="mobii_Edit"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6 control-label">Introduce paying
                                                </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="idpy_edit" name="idpy_edit" type="checkbox" value="1"
                                                               onchange="indDtiledit()"/> No
                                                        <span></span>
                                                    </label> Yes
                                                </div>
                                            </div>
                                            <input type="hidden" id="edit_invd" name="edit_invd">
                                            <input type="hidden" id="edit_func" name="edit_func"/>
                                            <div class="panel-body" id="indDivedit" style="display: block">
                                                <h3 class="text-title"><span class="fa fa-bookmark"></span> Introduce
                                                    paying
                                                </h3>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce Nic
                                                    </label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="idnm_edit"
                                                               id="idnm_edit" placeholder="Introduce Nic"
                                                               onkeyup="srchIntroEdit(this.id,'idnm_edit');"/>
                                                        <input type="hidden" id="indauidedit" name="indauidedit">
                                                        <input type="hidden" id="indbnidedit" name="indbnidedit">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce commission(%)
                                                    </label>
                                                    <div class="col-md-6">
                                                        <input type="text" class="form-control"
                                                               placeholder="Introduce commission" id="idcm_edit"
                                                               name="idcm_edit"/>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-6  control-label">Introduce Account
                                                    </label>
                                                    <div class="col-md-6">
                                                        <select class="form-control" name="idac_edit" id="idac_edit"
                                                                onchange="chckBtn(this.value,'idac_edit');">
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="indDivveditt"
                                                 style="margin-top: 106px;display: none; background-color: #e8e8e8">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Name</label>
                                                    <label class="col-md-9 col-xs-12 control-label"
                                                           id="indnameedit"></label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-12 control-label">Mobile </label>
                                                    <label class="col-md-6 col-xs-12 control-label"
                                                           id="indmobileedit"></label>
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
                    <button type="submit" class="btn btn-success" id="editInsvest">Submit</button>
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
        $('#dataTbInsBank').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        searchInvest();
        // add form validation
        $("#insvest_Add").validate({
            rules: {
                inic: {
                    required: true,
                },
                amnt: {
                    required: true,
                    number: true
                },
                tort: {
                    required: true,
                    number: true,
                    // greaterThan: "#inrt"
                },
                stdt: {
                    required: true,
                },
                perd: {
                    required: true,
                },
                mtdt: {
                    required: true,
                },
                inrt: {
                    required: true,
                    greaterThanOrEqual: "#tort"
                },
                acno: {
                    required: true,
                },
                pamd: {
                    required: true,
                },
                idnm: {
                    required: true,
                },
                idcm: {
                    // required: true,

                },
                idac: {
                    required: true,
                },
            },
            messages: {
                inic: {
                    required: 'Plase enter nic number',
                },
                amnt: {
                    required: 'Please select Bank Name',
                    number: 'Invalid'
                },
                tort: {
                    required: 'Please enter number ',
                    number: 'Invalid'
                },
                stdt: {
                    required: 'Please enter date ',
                },
                perd: {
                    required: 'Please select value ',

                },
                mtdt: {
                    required: 'Please enter date',
                },
                inrt: {
                    required: 'Please enter number ',
                    greaterThanOrEqual: 'Please enter value same or less than total rate '
                },
                acno: {
                    required: 'Please select value ',
                },

                pamd: {
                    required: 'Please select value ',
                },
                idnm: {
                    required: 'Please enter value ',
                    notEqual: "#inic"
                },
                idcm: {
                    // required: 'Please enter number ',
                    // greaterThan:'Please enter value less than investor rate'
                },
                idac: {
                    required: 'Please select value ',
                },
            }
        });
        //
        // edit form validation
        $("#insvest_edit").validate({
            rules: {
                inic_edit: {
                    required: true,
                },
                amnt_edit: {
                    required: true,
                    number: true
                },
                tort_edit: {
                    required: true,
                    number: true
                },
                stdt_edit: {
                    required: true,
                },
                perd_edit: {
                    required: true,
                },
                mtdt_edit: {
                    required: true,
                },
                inrt_edit: {
                    required: true,
                    greaterThanOrEqual: "#tort_edit"
                },
                acno_edit: {
                    required: true,
                },
                pamd_edit: {
                    required: true,
                },
                idnm_edit: {
                    required: true,
                },
                idcm_edit: {
                    required: true,
                    greaterThan: "#inrt_edit",
                },
                idac_edit: {
                    required: true,
                },
            },
            messages: {
                inic_edit: {
                    required: 'Plase enter nic number',
                },
                amnt_edit: {
                    required: 'Please select Bank Name',
                    number: 'Invalid'
                },
                tort_edit: {
                    required: 'Please enter number ',
                    number: 'Invalid'
                },
                stdt_edit: {
                    required: 'Please enter date ',
                },
                perd_edit: {
                    required: 'Please select value ',

                },
                mtdt_edit: {
                    required: 'Please enter date',
                },
                inrt_edit: {
                    required: 'Please enter number ',
                    greaterThanOrEqual: 'Please enter value less than total rate'
                },
                acno_edit: {
                    required: 'Please select value ',
                },

                pamd_edit: {
                    required: 'Please select value ',
                },
                idnm_edit: {
                    required: 'Please enter value ',
                },
                idcm_edit: {
                    required: 'Please enter number ',
                    greaterThan: 'Please enter value less than investor rate'

                },
                idac_edit: {
                    required: 'Please select value ',
                },
            }
        });
        //
    });

    //




//hide pay mode end


    //invester rate validation start
    function calRateset() {
        var tort = document.getElementById('tort').value;
        var inrt = document.getElementById('inrt').value;
        var idcm = tort - inrt;
        document.getElementById('idcm').value = idcm;
    }
    function calRatesetedit() {
        var tort = document.getElementById('tort_edit').value;
        var inrt = document.getElementById('inrt_edit').value;
        var idcm = tort - inrt;
        document.getElementById('idcm_edit').value = idcm;
    }



    //invester rate validation end
    //Maturity date(renew date) start
    function formatDate2(a) {
        var stdt = document.getElementById('stdt').value;
        var perd = document.getElementById('perd').value;
        if (perd >= 12) {
            var aaa = (+perd / 12);
            //  var perd = 0;
        } else if (perd < 12) {
            var perd;
            var aaa = 0;
        }
        var d = new Date(stdt),
            month = '' + (d.getMonth() + +1 + +perd),
            day = '' + d.getDate(),
            year = d.getFullYear() + +aaa;

        if (month > 12) {
            var bbb = (+month - +12);
            month2 = bbb;
            year2 = +year + +1;
        } else {
            month2 = month;
            year2 = +year;
        }
        if (month2.length < 2) month2 = '0' + month2;
        //   if (month2.length == null) month2 = '0' + month2;
        if (day.length < 2) day = '0' + day;
        var aa = [year, month2, day].join('-');
        document.getElementById('mtdt').value = aa;
    }

    function formatDate() {
        var stdt = document.getElementById('stdt').value;
        var perd = document.getElementById('perd').value;

        // CHECK NO OF YEAR
        if (perd >= 12) {
            var aaa = (+perd / 12);
            perd = 0;

        } else if (perd < 12) {
            var aaa = 0;
            perd = perd;
        }

        var d = new Date(stdt),
            month = '' + (d.getMonth() + +1 + +perd),
            day = '' + d.getDate(),
            year = d.getFullYear() + +aaa;

        if (month > 12) {
            var bbb = (+month - +12);
            var month = +bbb;
            year = +year + +1;

        } else {
            var month = +month;
            year = +year;
        }

        /*
         var num = 1024,
         str = num.toString(),
         len = str.length;
         console.log(len);
         */

        if (month.toString().length < 2) var month = '0' + month;

        if (day.length < 2) day = '0' + day;
        var aa = [year, month, day].join('-');
        document.getElementById('mtdt').value = aa;
    }

    //Maturity date(renew date) end
    //
    //add load Investor Pay mode div start
    function insdDtil() {
        var inpy = document.getElementById("inpy");
        if (inpy.checked == true) {
            document.getElementById("insdDiv").style.display = "none";

        } else {
            document.getElementById("insdDiv").style.display = "block";
        }
    }

    //add load Investor Pay mode div end
    //
    //edit load Investor Pay mode div start
    function insdDtiledit() {
        var inpy = document.getElementById("inpy_edit");
        if (inpy.checked == true) {
            document.getElementById("insdDivedit").style.display = "none";
        } else {
            document.getElementById("insdDivedit").style.display = "block";
        }
    }

    //edit load Investor Pay mode div end
    //
    //add load Introduce Pay mode div start

    function loadind() {
        var tort = document.getElementById("tort").value;
        var inrt = document.getElementById("inrt").value;

        // console.log(tort);
        // console.log(inrt);
        if ( tort < inrt) {
            document.getElementById("idpy").checked = true;
            document.getElementById("indDiv").style.display = "block";
            //  document.getElementById("indDivv").style.display = "block";
        } else {
            document.getElementById("idpy").checked = false;
            document.getElementById("indDiv").style.display = "none";
        }
    }
    function loadindedit() {
        var tort = document.getElementById("tort_edit").value;
        var inrt = document.getElementById("inrt_edit").value;

        // console.log(tort);
        // console.log(inrt);
        if ( tort < inrt) {
            document.getElementById("idpy_edit").checked = true;
            document.getElementById("indDivedit").style.display = "block";
          //  document.getElementById("indDivv").style.display = "block";
        } else {
            document.getElementById("idpy_edit").checked = false;
            document.getElementById("indDivedit").style.display = "none";
        }
    }

    function indDtil() {
        var idpy = document.getElementById("idpy");
        if (idpy.checked == true) {
            document.getElementById("indDiv").style.display = "block";
            //document.getElementById("indDivv").style.display = "block";
        } else {
            document.getElementById("indDiv").style.display = "none";
            document.getElementById("indDivv").style.display = "none";
        }
    }

    //add load Introduce Pay mode div end
    //edit load Introduce Pay mode div start
    function indDtiledit() {
        var idpy = document.getElementById("idpy_edit");
        if (idpy.checked == true) {
            document.getElementById("indDivedit").style.display = "block";
            document.getElementById("indDivveditt").style.display = "block";
        } else {
            document.getElementById("indDivedit").style.display = "none";
            document.getElementById("indDivveditt").style.display = "none";
        }
    }

    //edit load Introduce Pay mode div start
    //
    //add investment load nic start
    function srchIns() {
        var inic = document.getElementById("inic").value;
        if (inic.length == 10 || inic.length == 12) {
            document.getElementById("inic").style.borderColor = "";
            $.ajax({
                url: '<?= base_url(); ?>admin/getInvest_Inv',
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
                        document.getElementById("hoad").innerHTML = data[0]['hoad'];
                        document.getElementById("inicc").innerHTML = data[0]['inic'];
                        document.getElementById("mobii").innerHTML = data[0]['mobi'];
                        document.getElementById("auid").value = data[0]['auid'];
                        document.getElementById("bnid").value = data[0]['bnid'];
                        document.getElementById("addInsvest").style.display = '';
                        loadbankacc();
                    } else {
                        document.getElementById("insDiv").style.display = 'none';
                        document.getElementById("inic").style.borderColor = "red";
                        document.getElementById("addInsvest").style.display = 'none';
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
            document.getElementById("addInsvest").style.display = 'none';
        }
    };
    //add investment load nic end
    //
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
    //edit investor load nic end
    //
    //add Introduce load nic start
    function srchIntro() {

        var inic = document.getElementById('inic').value;
        var idnm = document.getElementById('idnm').value;
        if (inic == idnm) {
            document.getElementById("idnm").style.borderColor = "red";
            document.getElementById("addInsvest").style.display = 'none';
            swal({
                title: "",
                text: "Same Investor NIC ",
                type: "warning"
            });

        } else if (idnm.length == 10 || idnm.length == 12) {
            document.getElementById("idnm").style.borderColor = "";
            $.ajax({
                url: '<?= base_url(); ?>admin/getIntroduce',
                type: 'POST',
                data: {
                    idnm: idnm,
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        document.getElementById("indDivv").style.display = 'block';
                        document.getElementById("ind").innerHTML = data[0]['innm'];
                        document.getElementById("indmobi").innerHTML = data[0]['mobi'];
                        document.getElementById("indauid").value = data[0]['auid'];
                        document.getElementById("indbnid").value = data[0]['bnid'];
                        document.getElementById("addInsvest").style.display = '';
                        loadindbankacc();
                    } else {
                        document.getElementById("indDivv").style.display = 'none';
                        document.getElementById("idnm").style.borderColor = "red";
                        document.getElementById("addInsvest").style.display = 'none';
                        swal({
                            title: "",
                            text: "Invalide nic no",
                            type: "warning"
                        });
                    }
                },
            });
        } else {
            document.getElementById("idnm").style.borderColor = "red";
            document.getElementById("indDivv").style.display = 'none';
            document.getElementById("addInsvest").style.display = 'none';
        }
    };
    //add Introduce load nic end
    //edit Introduce load nic start
    function srchIntroEdit(nic, htmlidd) {

        var inic_edit = document.getElementById('inic_edit').value;
        var idnm_edit = document.getElementById(htmlidd).value;
        if (inic_edit == idnm_edit) {
            document.getElementById("idnm_edit").style.borderColor = "red";
            document.getElementById("editInsvest").style.display = 'none';
            //console.log(inic + 'aaaaa');

        }


        else if (idnm_edit.length == 10 || idnm_edit.length == 12) {
            document.getElementById("idnm_edit").style.borderColor = "";
            $.ajax({
                url: '<?= base_url(); ?>admin/getIntroduceedit',
                type: 'POST',
                data: {
                    idnm_edit: idnm_edit,
                },
                dataType: 'json',
                success: function (data) {
                    var len = data.length;
                    if (len > 0) {
                        document.getElementById("indDivveditt").style.display = 'block';
                        document.getElementById("indnameedit").innerHTML = data[0]['innm'];
                        document.getElementById("indmobileedit").innerHTML = data[0]['mobi'];
                        document.getElementById("indauidedit").value = data[0]['auid'];
                        document.getElementById("indbnidedit").value = data[0]['bnid'];
                        document.getElementById("editInsvest").style.display = '';
                        loadindbankacc_edit();
                    } else {
                        document.getElementById("indDivveditt").style.display = 'none';
                        document.getElementById("idnm_edit").style.borderColor = "red";
                        document.getElementById("editInsvest").style.display = 'none';
                        swal({
                            title: "",
                            text: "Invalide nic no",
                            type: "warning"
                        });
                    }
                },
            });

        } else {
            document.getElementById("idnm_edit").style.borderColor = "red";
            document.getElementById("indDivveditt").style.display = 'none';
            document.getElementById("editInsvest").style.display = 'none';
        }

    };
    //edit Introduce load nic end
    //
    // get invester account start
    function loadbankacc(edt) {
        var auid = document.getElementById("auid").value;
        $.ajax({
            url: '<?= base_url(); ?>admin/getBankAcc',
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
                        var bkid = response[i]['bkid'];
                        var $el = $('#acno');
                        if (edt == id) {
                            $el.append($("<option selected></option>")
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
    //
    // get edit invester account start
    function loadbankacc_edit(edit) {
        var auid_edit = document.getElementById("auid_edit").value;
        var bnid_edit = document.getElementById("bnid_edit").value;
        $.ajax({
            url: '<?= base_url(); ?>admin/getBankAccEdit',
            type: 'POST',
            data: {
                auid_edit: auid_edit,
                bnid_edit: bnid_edit,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#acno_edit').empty();
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['inid'];
                        var bnid_edit = response[i]['bnid'];
                        var name = response[i]['acno'];
                        var $el = $('#acno_edit');

                        if (edt == bnid_edit) {
                            $el.append($("<option selected></option>")
                                .attr("value", bnid_edit).text(name));

                        } else {
                            $el.append($("<option></option>")
                                .attr("value", bnid_edit).text(name));
                        }
                    }
                } else {
                    $('#acno_edit').empty();
                    $('#acno_edit').append("<option value='0'>No Account</option>");
                }
            },
        });
    };
    //get invester account end
    //get introducer account start
    function loadindbankacc(edt) {
        var indauid = document.getElementById("indauid").value;
        var indbnid = document.getElementById("indbnid").value;
        $.ajax({
            url: '<?= base_url(); ?>admin/getIndBankAcc',
            type: 'POST',
            data: {
                indauid: indauid,
                indbnid: indbnid,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#idac').empty();
                    $('#idac').append("<option value=''>-- Select Account No -- </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['inid'];
                        var name = response[i]['acno'];
                        var bnid = response[i]['bnid'];
                        var $el = $('#idac');
                        if (edt == id) {
                            $el.append($("<option selected></option>")
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
    //get introducer account end
    //
    // get edit introducer account start
    function loadindbankacc_edit(edt) {
        var indauidedit = document.getElementById("indauidedit").value;
        var indbnidedit = document.getElementById("indbnidedit").value;
        $.ajax({
            url: '<?= base_url(); ?>admin/getIndBankAccedit',
            type: 'POST',
            data: {
                indauidedit: indauidedit,
                indbnidedit: indbnidedit,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#idac_edit').empty();
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['inid'];
                        var bnid_edit = response[i]['bnid'];
                        var name = response[i]['acno'];
                        var $el = $('#idac_edit');
                        if (edt == bnid_edit) {
                            $el.append($("<option selected></option>")
                                .attr("value", bnid_edit).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", bnid_edit).text(name));
                        }
                    }
                } else {
                    $('#idac_edit').empty();
                    $('#idac_edit').append("<option value='0'>No Account</option>");
                }
            },
        });
    };
    //get invester account end
    //
    //investor bank search table start
    function searchInvest() {
        var fill_stat = document.getElementById('fill_stat').value;
        if (fill_stat == '-') {
            document.getElementById('fill_stat').style.borderColor = "red";
        } else {
            document.getElementById('fill_stat').style.borderColor = "";
            $('#dataTbInsBank').DataTable().clear();
            $('#dataTbInsBank').DataTable({
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
                    "targets": [1, 2,] //column array names
                }, {
                    className: "text-center",
                    "targets": [0, 3, 7, 8, 9, 10]
                },
                    {
                        className: "text-right",
                        "targets": [4, 5, 6]
                    }
                ],
                "order": [
                    [9, "asc"]
                ], //ASC  desc
                "aoColumns": [
                    //columns (array)
                    {
                        sWidth: '5%'
                        //columns width set (array)
                    }, {
                        sWidth: '8%'
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
                        sWidth: '8%'
                    }, {
                        sWidth: '8%'
                    }, {
                        sWidth: '5%'
                    }, {
                        sWidth: '12%'
                    },
                ],
                "ajax": {
                    url: '<?= base_url(); ?>admin/searchInvestment',
                    type: 'post',
                    data: {
                        fill_stat: fill_stat,
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
                    $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                },

            });
        }
    }

    //investor search table end
    //
    // investor add form start
    $("#addInsvest").click(function (e) {
        e.preventDefault();
        if ($(insvest_Add).valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addinvest",
                data: $("#insvest_Add").serialize(),
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
                        location = '<?= base_url(); ?>admin/addinvest';
                    }, 20000);
                }
            });
        } else {
        }
    });
    // investor add form end
    //
    // investment  edit from filling start
    function editinsvest(invd, typ) {
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

    //investor bank edit from filling end
    //
    // investor bank edit start
    $("#editInsvest").click(function (e) {
        e.preventDefault();
        if ($("#insvest_edit").valid()) {
            var edit_func = document.getElementById("edit_func").value;
            var formData = new FormData(this);
            if (edit_func == 1) {
                swal({
                        title: "Are you sure edit?",
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
                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>admin/edit_Invest",
                                data: $("#insvest_edit").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    $('#modalEdt').modal('hide');
                                    swal({
                                            title: "Investoraaa Update",
                                            text: " Success  !",
                                            type: "success"
                                        },
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function () {
                                    swal("Investor Bank Added Failed!", 'aaaa', "error");
                                    window.setTimeout(function () {
                                    }, 2000);
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else if (edit_func == 2) {
                var id = document.getElementById("edit_invd").value;
                swal({
                        title: "Are you sure Approval?",
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
                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>admin/edit_Invest",
                                data: $("#insvest_edit").serialize(),
                                dataType: 'json',
                                success: function (response) {
                                    $('#modalEdt').modal('hide');
                                    swal({
                                            title: "Approval Success",
                                            type: "success"
                                        },
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function () {
                                    swal("investor Added Failed!", 'aaaa', "error");
                                    window.setTimeout(function () {
                                        location = '<?= base_url(); ?>admin/invstor';
                                    }, 2000);
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
            }
        }
    });
    // investor edit end
    //
    //invest view start
    function vewInvest(invd) {
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
                    document.getElementById("innm_vew").innerHTML = response[i]['innm'];
                    document.getElementById("inic_vew").innerHTML = response[i]['inic'];
                    document.getElementById("amnt_vew").innerHTML = response[i]['amnt'];
                    document.getElementById("tort_vew").innerHTML = response[i]['tort'];
                    document.getElementById("stdt_vew").innerHTML = response[i]['stdt'];
                    document.getElementById("mtdt_vew").innerHTML = response[i]['mtdt'];
                    document.getElementById("inrt_vew").innerHTML = response[i]['inrt'];
                    document.getElementById("pamd_vew").innerHTML = response[i]['dunm'];
                    document.getElementById("acno_vew").innerHTML = response[i]['acno'];
                    document.getElementById("idpy_vew").innerHTML = response[i]['idpy'];
                    document.getElementById("idnm_vew").innerHTML = response[i]['full'];
                    document.getElementById("idcm_vew").innerHTML = response[i]['idcm'];
                    document.getElementById("remk_vew").innerHTML = response[i]['remk'];
                    if (response[i]['perd'] == 0) {
                        document.getElementById("perd_vew").innerHTML = " Non Expired ";
                    } else {
                        document.getElementById("perd_vew").innerHTML = response[i]['perd'] + " Month";
                    }
                    if (response[i]['inpy'] == 1) {
                        document.getElementById("inpy_vew").innerHTML = " <span class='label label-success'>  Re Investment    </span>";
                    } else {
                        document.getElementById("inpy_vew").innerHTML = " <span class='label label-warning'> Pay </span>";
                    }
                    if (response[i]['idpy'] == 1) {
                        document.getElementById("idpy_vew").innerHTML = " <span class='label label-success'>  Yes    </span>";
                    } else {
                        document.getElementById("idpy_vew").innerHTML = " <span class='label label-warning'> No </span>";
                    }
                }
            }
        })
    }

    //invest bank view end
    //
    // investor reject start
    function rejInvest(invd) {
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
                    $.ajax({
                        url: '<?= base_url(); ?>admin/rejInvest',
                        type: 'post',
                        data: {
                            invd: invd
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                swal({
                                    title: "Insvest Reject",
                                    text: "Insvest Reject Success!",
                                    type: "success"
                                });
                            }
                        }
                    });
                } else {
                    swal("Cancelled!", "Insvester Not Rejected", "error");
                }
            });
    }

    // investor reject end
    //
    //button check start
    function chckInBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    //button check end
</script>