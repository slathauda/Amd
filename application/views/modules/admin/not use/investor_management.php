<link rel="stylesheet" href="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.css"/>
<script type="text/javascript"
        src="<?= base_url(); ?>assets/plugins/timepicker2/dist/bootstrap-clockpicker.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/fileinput.js"></script>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Investment Module</li>
    <li class="active"> Investor Management</li>
</ul>
<!-- END BREADCRUMB -->
<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Investor Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Investor
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                    <div class="row form-horizontal">
                        <div class="col-md-5">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Mode</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="fill_mode" id="fill_mode">
                                        <option value="-">-- Select Mode --</option>
                                        <option value="all">All</option>
                                        <option value="1">investor</option>
                                        <option value="0">introducer</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status Type</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="fill_stat" id="fill_stat">
                                        <option value="-">-- Select Type --</option>
                                        <option value="all">All</option>
                                        <option value="1">Active</option>
                                        <option value="0">Pending</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label class="col-md-3 col-xs-12 text-right"></label>
                                <div class="col-md-8 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="searchInvestor()"
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
                                           id="dataTbInvestor" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">Investor Name</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">NIC</th>
                                            <th class="text-center">MOBILE</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mode</th>
                                            <th class="text-center">Status</th>
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
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Investor Create</h4>
            </div>
            <form class="form-horizontal" id="ins_add" name="ins_add" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Introduce </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="ivtp" name="ivtp" type="checkbox" value="1" checked/>
                                                        No <span></span> </label>
                                                    Yes
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Title </label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="titl" id="titl">
                                                        <option value="">Select Title</option>
                                                        <?php
                                                        foreach ($titlinfo1 as $tit) {
                                                            echo "<option value='$tit->soid'>$tit->sode</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Full Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase" id="funm"
                                                           name="funm"
                                                           placeholder="Full  Name" onkeyup="initinvestor(this.value)"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Name with Initial</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="innm"
                                                               placeholder="Name with Initial" id="innm"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="hoad"
                                                               placeholder="Home address" id="hoad"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">NIC</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase" id="nic"
                                                               name="nic" placeholder="NIC"
                                                               onchange="checkNicInv(this.value,'nic','subBtn')"
                                                               onkeyup="checkNicInv(this.value,'nic','subBtn')"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">DOB</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker valid"
                                                               id="idob" name="idob" placeholder="DOB"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="tele" id="tele"
                                                               placeholder="Telephone"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Mobile</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="mobi"
                                                               placeholder="Mobile" id="mobi"/>
                                                    </div>
                                                    <span id="sts2"></span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="mail" id="mail"
                                                               placeholder="Email"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">City</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="City"
                                                               id="city" name="city"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Remarks</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <textarea class="form-control" rows="4" id="remk" name="remk"
                                                                  placeholder="Remarks"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details Add
                                        </h3>
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-3 col-xs-12">
                                                <select onchange="chckBtn(this.value,'bkid[]')" class="form-control"
                                                        name="bkid[]" id="bkid[]"
                                                        onchange="">
                                                    <option value="0">Select Bank</option>
                                                    <?php
                                                    foreach ($bankinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <input type="text" class="form-control "
                                                       placeholder="Branch Name " name="bunm[]"
                                                       id="bunm[]"/>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <input type="text" class="form-control" name="acno[]" id="acno[]"
                                                       placeholder="Account Number"/>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" class="btn-sm btn-info" id="addrw"><span>
                                                    <i class="fa fa-plus"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="spit">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn">Submit</button>
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
                <h4 class="modal-title" id="largeModalHead">Investor Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Mode</label>
                                            <label class="col-md-4 control-label" id="ivtp_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Full Name</label>
                                            <label class="col-md-4  control-label" id="funm_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Name with Initial </label>
                                            <label class="col-md-4  control-label" id="innm_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Address</label>
                                            <label class="col-md-4  control-label" id="hoad_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">NIC</label>
                                            <label class="col-md-4  control-label text-uppercase" id="inic_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">DOB</label>
                                            <label class="col-md-4  control-label" id="idob_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Telephone</label>
                                            <label class="col-md-4  control-label" id="tele_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Mobile</label>
                                            <label class="col-md-4  control-label" id="mobi_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <label class="col-md-4 control-label" id="mail_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">City</label>
                                            <label class="col-md-4  control-label" id="city_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Remarks</label>
                                            <label class="col-md-4  control-label" id="remk_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="row">
                                    <div class="panel-body panel-body-table" style="padding:10px; ">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped"
                                                   id="accDtilTb" align="center" width="100%">
                                                <thead>
                                                <tr>

                                                    <th class="text-center">Bank Name</th>
                                                    <th class="text-center">Branch Name</th>
                                                    <th class="text-center">ACCOUNT NO</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>

                                                <th></th>
                                                <th></th>
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
            <form class="form-horizontal" id="ins_edit" name="ins_edit" action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Introduce </label>
                                                <div class="col-md-6 ">
                                                    <label class="switch">
                                                        <input id="edit_ivtp" name="edit_ivtp" type="checkbox" value="1"
                                                               checked/>
                                                        No <span></span> </label>
                                                    Yes
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Title </label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="edit_titl" id="edit_titl">
                                                        <option value="">Select Title</option>
                                                        <?php
                                                        foreach ($titlinfo1 as $tit) {
                                                            echo "<option value='$tit->soid'>$tit->sode</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Full Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           id="edit_funm"
                                                           name="edit_funm" placeholder="Full  Name"
                                                           onkeyup="initinvestor_edit(this.value)"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Name with Initial</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase"
                                                               name="edit_innm"
                                                               id="edit_innm" placeholder="Name with Initial"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Address</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="edit_hoad"
                                                               id="edit_hoad" placeholder="Home address"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">NIC</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-uppercase "
                                                               id="edit_nic" name="edit_nic" placeholder="NIC"
                                                               onchange="checkNicInv_edit(this.value,'edit_nic','subBtn_edit')"
                                                               onkeyup="checkNicInv_edit(this.value,'edit_nic','subBtn_edit')"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">DOB</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control datepicker valid"
                                                               id="edit_idob" name="edit_idob" placeholder="DOB"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Telephone </label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="edit_tele"
                                                               id="edit_tele" placeholder="Telephone"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Mobile</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="edit_mobi"
                                                               id="edit_mobi" placeholder="Mobile"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Email</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="email" class="form-control" name="edit_mail"
                                                               id="edit_mail" placeholder="Email"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">City</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" placeholder="City"
                                                               id="edit_city" name="edit_city"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="col-md-4  control-label">Remarks</label>
                                            <div class="col-md-6 ">
                                                <div class="form-group">
                                                    <input type="hidden" id="edit_auid" name="edit_auid">
                                                    <textarea class="form-control" rows="4" id="edit_remk"
                                                              name="edit_remk" placeholder="Remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details Edit
                                        </h3>
                                        <div id="edit_spit"></div>
                                    </div>

                                    <div class="row" id="addbanka" >
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Bank Details Add
                                        </h3>
                                        <div class="form-group">
                                            <label class="col-md-2 col-xs-12 control-label">Bank Details</label>
                                            <div class="col-md-3 col-xs-12">
                                                <select onchange="chckBtn(this.value,'edit_bkid1[]')" class="form-control"
                                                        name="edit_bkid1[]" id="edit_bkid1[]"
                                                        onchange="">
                                                    <option value="0">Select Bank</option>
                                                    <?php
                                                    foreach ($bankinfo as $bnk) {
                                                        echo "<option value='$bnk->bkid'>$bnk->bknm</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <input type="text" class="form-control "
                                                       placeholder="Branch Name " name="edit_bunm1[]"
                                                       id="edit_bunm1[]"/>
                                            </div>
                                            <div class="col-md-3 col-xs-12">
                                                <input type="text" class="form-control" name="edit_acno1[]" id="edit_acno1[]"
                                                       placeholder="Account Number"/>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" class="btn-sm btn-info" id="edittaddrw2"><span>
                                                    <i class="fa fa-plus"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="spitt">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="auid" name="auid"/>

                <input type="hidden" id="func" name="func"/>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn_edit">Submit</button>
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
        $('#dataTbInvestor').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        //
        // investor validation start
        // add form validation
        $("#ins_add").validate({
            rules: {
                titl: {
                    required: true,
                },
                funm: {
                    required: true,
                },
                innm: {
                    required: true,
                },
                hoad: {
                    required: true,
                },
                nic: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_nic_Inv",
                        type: "post",
                        data: {
                            nic: function () {
                                return $("#nic").val();
                            },
                        }
                    }
                },
                idob: {
                    required: true,
                },
                tele: {

                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                mobi: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                mail: {
                    required: true,
                },
                city: {
                    required: true,
                },
                'bkid[]': {
                    required: true,
                    notEqual: '0',
                },
                'acno[]': {
                    required: true,
                    digits: true,
                },
                'bunm[]': {
                    required: true,
                },
            },
            messages: {
                titl: {
                    required: 'Please fill the Title'
                },
                funm: {
                    required: 'Please fill the FullName'
                },
                innm: {
                    required: 'Name with Initial'
                },
                hoad: {
                    required: 'Please fill the Address'
                },
                nic: {
                    required: 'Please fill the NIC',
                    remote: 'NIC Already Exists'
                },
                idob: {
                    required: 'Please fill the Date of Birth'
                },
                tele: {
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                mobi: {
                    required: 'Please fill the Mobile Number',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                mail: {
                    required: 'Please fill the Email'
                },
                city: {
                    required: 'Please fill the City'
                },
                'bkid[]': {
                    required: 'Please fill the Bank Name',
                    notEqual: 'Please fill the Bank Name'
                },
                'acno[]': {
                    required: 'Please fill the Account number',
                    digits: 'Please add number'
                },
                'bunm[]': {
                    required: 'Please fill the brach'
                },
            }
        });
        //
        // edit/approval form validation
        $("#ins_edit").validate({
            rules: {
                edit_titl: {
                    required: true,
                },
                edit_funm: {
                    required: true,
                },
                edit_innm: {
                    required: true,
                },
                edit_hoad: {
                    required: true,
                },
                edit_nic: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_nic_Inv_edit",
                        type: "post",
                        data: {
                            nicc: function () {
                                return $("#edit_nic").val();
                            },
                            auidd: function () {
                                return $("#edit_auid").val();
                            }
                        }
                    }
                },
                edit_idob: {
                    required: true,
                },
                edit_tele: {

                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                edit_mobi: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                edit_mail: {
                    required: true,
                },
                edit_city: {
                    required: true,
                },
                'edit_bkid[]': {
                    required: true,
                    notEqual: '0',
                },
                'edit_acno[]': {
                    required: true,
                },
                'edit_bunm[]': {
                    required: true,
                },
            },
            messages: {
                edit_titl: {
                    required: 'Please fill the Title'
                },
                edit_funm: {
                    required: 'Please fill the FullName'
                },
                edit_innm: {
                    required: 'Name with Initial'
                },
                edit_hoad: {
                    required: 'Please fill the Address'
                },
                edit_nic: {
                    required: 'Please fill the NIC',
                    remote: 'NIC Already Exists'
                },
                edit_idob: {
                    required: 'Please fill the Date of Birth'
                },
                edit_tele: {

                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                edit_mobi: {
                    required: 'Please fill the Mobile Number',
                    digits: 'This is not a valid Phone Number',
                    minlength: 'This is not a valid Phone Number',
                    maxlength: 'This is not a valid Phone Number'
                },
                edit_mail: {
                    required: 'Please fill the Email'
                },
                edit_city: {
                    required: 'Please fill the City'
                },
                'edit_bkid[]': {
                    required: 'Please fill the Bank Name',
                    notEqual: 'Please fill the Bank Name'
                },
                'edit_acno[]': {
                    required: 'Please fill the Account number'
                },
                'edit_bunm[]': {
                    required: 'Please fill the Branch'
                },
            }
        });
    });
    // investor validation end
    //
    // investor initial name start
    // add initial name
    function initinvestor(funm) {
        var funm = funm.trim();
        var res = funm.split(" ");
        var size = (res.length) - 1;
        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }
        var shrt = initials + res.pop();
        document.getElementById('innm').value = shrt;
    }

    //
    //update initial name
    function initinvestor_edit(edit_funm) {
        var edit_funm = edit_funm.trim();
        var res = edit_funm.split(" ");
        var size = (res.length) - 1;
        var initials = '';
        for (var i = 0; i < size; i++) {
            initials += res[i][0] + '. ';
        }
        var shrt = initials + res.pop();
        document.getElementById('edit_innm').value = shrt;
    }

    //
    // investor initial name end
    //
    // investor nic to dob start
    //add nic
    function checkNicInv(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)
        var nicNo = nic;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);
            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }
            var mo = 0;
            var da = 0;
            var days = x;
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }
            if (mo < 10) {
                mo = '0' + mo;
            }
            if (da < 10) {
                da = '0' + days;
            }
            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);
            $('#idob').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;
        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {
            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);

            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }
            var mo = 0;
            var da = 0;
            var days = x;
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }
            if (mo < 10) {
                mo = '0' + mo;
            }
            if (da < 10) {
                da = '0' + days;
            }
            var today = +birthYear + "-" + (mo) + "-" + (da);
            $('#idob').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;
        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";
            document.getElementById(htid).disabled = true;
        }
    };

    //update nic
    function checkNicInv_edit(nic, vlid, htid) { // nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button)
        var nicNo = nic;
        var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            var birthYear = nicNo.substr(0, 2);
            var x = nicNo.substr(2, 3);
            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }
            var mo = 0;
            var da = 0;
            var days = x;
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }
            if (mo < 10) {
                mo = '0' + mo;
            }
            if (da < 10) {
                da = '0' + days;
            }
            var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);
            $('#edit_idob').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;
        } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {
            var birthYear = nicNo.substr(0, 4);
            var x = nicNo.substr(4, 3);
            if (x < 500) {
                // document.getElementById("gend").value = 1;
            } else {
                //  document.getElementById("gend").value = 2;
                x = +x - +500;
            }
            if (x.length == 2) {
                if (x < 10) {
                    x = x.substr(1, 1);
                } else if (x < 100) {
                    x = x.substr(0, 1);
                }
            } else if (x.length == 3) {
                if (x < 10) {
                    x = x.substr(2, 2);
                } else if (x < 100) {
                    x = x.substr(1, 2);
                }
            }
            var mo = 0;
            var da = 0;
            var days = x;
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }
            if (mo < 10) {
                mo = '0' + mo;
            }
            if (da < 10) {
                da = '0' + days;
            }
            var today = +birthYear + "-" + (mo) + "-" + (da);
            $('#edit_idob').val(today);
            document.getElementById(vlid).style.borderColor = "";
            document.getElementById(htid).disabled = false;
        } else {
            document.getElementById(vlid).focus();
            document.getElementById(vlid).style.borderColor = "red";

            document.getElementById(htid).disabled = true;
        }
    };
    //
    // investor nic end
    //
    //invester add load account start
    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function totcal() {
        var sum = 0;
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
        //document.getElementById('pyam').value = sum;
    }

    /* REF LINK  >>  https://stackoverflow.com/questions/28184177/dynamically-add-remove-rows-from-html-table */
    $('#addrw').click(function () {
        $('#spit').append(' <div class="form-group">' +
            '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
            '<div class="col-md-3 col-xs-12">' +
            '<select class="form-control" name="bkid[]" id="bkid[]" onchange="">' +
            '"<option value="0" >Select Bank</option>" ' +
            <?php
            foreach ($bankinfo as $bnk) {
                echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";
            }
            ?>
            ' </select>                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="bunm[]" id="bunm[]"placeholder = "Branch Name" / >                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="acno[]" id="acno[]"placeholder = "Account Number" / >                                     </div>' +
            '<div class="col-md-1">' +
            '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>'
        )
    });
    $('#spit').on('click', '#dltrw', function () {
        var sum = 0;
        $(this).closest('.form-group').remove();
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
    });
    //invester add load account end
    //



    //invester add load account start
    function chckBtn(id, inpu) {
        if (id == 0) {
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    function totcal() {
        var sum = 0;
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
        //document.getElementById('pyam').value = sum;
    }

    /* REF LINK  >>  https://stackoverflow.com/questions/28184177/dynamically-add-remove-rows-from-html-table */
    $('#edittaddrw2').click(function () {
        $('#spitt').append(' <div class="form-group">' +
            '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
            '<div class="col-md-3 col-xs-12">' +
            '<select class="form-control" name="bkid[]" id="bkid[]" onchange="">' +
            '"<option value="0" >Select Bank</option>" ' +
            <?php
            foreach ($bankinfo as $bnk) {
                echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";
            }
            ?>
            ' </select>                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="bunm[]" id="bunm[]"placeholder = "Branch Name" / >                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="acno[]" id="acno[]"placeholder = "Account Number" / >                                     </div>' +
            '<div class="col-md-1">' +
            '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>'
        )
    });

    $('#spitt').on('click', '#dltrw', function () {
        var sum = 0;
        $(this).closest('.form-group').remove();
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
    });

    //invester add load account end
    //


    //
    //investor search table start
    function searchInvestor() {
        var fill_mode = document.getElementById('fill_mode').value;
        var fill_stat = document.getElementById('fill_stat').value;
        if (fill_mode == '-') {
            document.getElementById('fill_mode').style.borderColor = "red";
            document.getElementById('fill_stat').style.borderColor = "";
        } else if (fill_stat == '-') {
            document.getElementById('fill_stat').style.borderColor = "red";
            document.getElementById('fill_mode').style.borderColor = "";
        }
        else {
            document.getElementById('fill_mode').style.borderColor = "";
            document.getElementById('fill_stat').style.borderColor = "";
            $('#dataTbInvestor').DataTable().clear();
            $('#dataTbInvestor').DataTable({
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
                    "targets": [1, 2, 4, 5] //column array names
                }, {
                    className: "text-center",
                    "targets": [0, 3, 6, 7, 8]
                },
                ],
                "order": [[7, "asc"]], //ASC  desc
                "aoColumns": [{ //columns (array)
                    sWidth: '5%' //columns width set (array)
                }, {
                    sWidth: '10%'
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
                    sWidth: '10%'
                }],
                "ajax": {
                    url: '<?= base_url(); ?>Admin/searchInvestor',
                    type: 'post',
                    data: {
                        fill_stat: fill_stat,
                        fill_mode: fill_mode,
                    }
                }
            });
        }
    }

    //investor search table end
    //
    // investor view start
    function viewins(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewIns",
            data: {
                auid: auid

            },
            dataType: 'json',
            success: function (response) {

                $('#accDtilTb').DataTable().clear();

                var t = $('#accDtilTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [0, 1, 2]},

                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '10%'},    // br
                        {sWidth: '10%'},

                    ],
                    "rowCallback": function (row, data, index) {
                        var curnt = data[7],
                            //  duam = parseFloat(data[8]),
                            // pnlt = parseFloat(data[6]),
                            $node = this.api().row(row).nodes().to$();

                        if (curnt == '-') {
                            $node.addClass('info')
                        }
//                        else if (pymt < 0) {
//                            $node.addClass('danger')
//                        } else if (duam > 0 && pnlt > 0) {
//                            $node.addClass('danger')
//                        }

                    },
                    // "order": [[5, "ASC"]], //ASC  desc
                });


                var len = response['inst'].length;
                var len2 = response['bank'].length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("funm_vew").innerHTML = response['inst'][i]['funm'];
                    document.getElementById("innm_vew").innerHTML = response['inst'][i]['innm'];
                    document.getElementById("hoad_vew").innerHTML = response['inst'][i]['hoad'];
                    document.getElementById("inic_vew").innerHTML = response['inst'][i]['inic'];
                    document.getElementById("idob_vew").innerHTML = response['inst'][i]['idob'];
                    document.getElementById("tele_vew").innerHTML = response['inst'][i]['tele'];
                    document.getElementById("mobi_vew").innerHTML = response['inst'][i]['mobi'];
                    document.getElementById("mail_vew").innerHTML = response['inst'][i]['mail'];
                    document.getElementById("city_vew").innerHTML = response['inst'][i]['city'];
                    document.getElementById("remk_vew").innerHTML = response['inst'][i]['remk'];
                    if (response['inst'][i]['ivtp'] == 1) {
                        document.getElementById("ivtp_vew").innerHTML = " <span class='label label-success'> Investor    </span>";
                    } else {
                        document.getElementById("ivtp_vew").innerHTML = " <span class='label label-warning'>  Introducer  </span>";
                    }
                }
                for (var ii = 0; ii < len2; ii++) {
                    t.row.add([

                        //console.log(response['bank'][ii]['acno']),
                        response['bank'][ii]['bknm'],
                        response['bank'][ii]['bunm'],
                        response['bank'][ii]['acno'],


                    ]).draw(false);
                }


            }
        })
    }

    //investor search table start
    function searchInvestor() {
        var fill_mode = document.getElementById('fill_mode').value;
        var fill_stat = document.getElementById('fill_stat').value;
        if (fill_mode == '-') {
            document.getElementById('fill_mode').style.borderColor = "red";
            document.getElementById('fill_stat').style.borderColor = "";
        } else if (fill_stat == '-') {
            document.getElementById('fill_stat').style.borderColor = "red";
            document.getElementById('fill_mode').style.borderColor = "";
        }
        else {
            document.getElementById('fill_mode').style.borderColor = "";
            document.getElementById('fill_stat').style.borderColor = "";
            $('#dataTbInvestor').DataTable().clear();
            $('#dataTbInvestor').DataTable({
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
                    "targets": [1, 2, 4, 5] //column array names
                }, {
                    className: "text-center",
                    "targets": [0, 3, 6, 7, 8]
                },
                ],
                "order": [[7, "asc"]], //ASC  desc
                "aoColumns": [{ //columns (array)
                    sWidth: '5%' //columns width set (array)
                }, {
                    sWidth: '10%'
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
                    sWidth: '10%'
                }],
                "ajax": {
                    url: '<?= base_url(); ?>Admin/searchInvestor',
                    type: 'post',
                    data: {
                        fill_stat: fill_stat,
                        fill_mode: fill_mode,
                    }
                }
            });
        }
    }

    //investor view end
    //
    // investor add form start
    $("#subBtn").click(function (e) {
        e.preventDefault();
        if ($("#ins_add").valid()) {
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>admin/addinv",
                data: $("#ins_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    $('#modalAdd').modal('hide');
                    swal({
                            title: "",
                            text: "Investor Added Successfully!",
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
                    }, 200);
                }
            });
        } else {
        }
    });
    // investor add form end
    //
    // investor edit from filling start
    function edtInves(auid, typ) {
        if (typ == 'edt') {
            $('#hed').text("Update Investor");
            $('#subBtn_edit').text("Update");
            document.getElementById("func").value = '1';
        } else if (typ == 'app') {
            $('#hed').text("Approval Investor");
            $('#subBtn_edit').text("Approvel");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/vewIns",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {

                var len = response['inst'].length;
                var len2 = response['bank'].length;

                // var len = response.length;
                if (len != 0) {

                    //  for (var i = 0; i < len; i++) {
                    document.getElementById("edit_titl").value = response['inst'][0] ['titl'];
                    document.getElementById("edit_funm").value = response['inst'][0]['funm'];
                    document.getElementById("edit_innm").value = response['inst'][0]['innm'];
                    document.getElementById("edit_hoad").value = response['inst'][0]['hoad'];
                    document.getElementById("edit_nic").value = response['inst'][0]['inic'];
                    document.getElementById("edit_idob").value = response['inst'][0]['idob'];
                    document.getElementById("edit_tele").value = response['inst'][0]['tele'];
                    document.getElementById("edit_mobi").value = response['inst'][0]['mobi'];
                    document.getElementById("edit_mail").value = response['inst'][0]['mail'];
                    document.getElementById("edit_city").value = response['inst'][0]['city'];
                    if (response['inst'][0]['stat'] == 1) {
                        document.getElementById('edit_nic').readOnly = true;
                        document.getElementById("addbanka").style.display = "none";
                           }
                    else {
                        document.getElementById('edit_nic').readOnly = false;
                        document.getElementById("addbanka").style.display = "block";
                    }
                    if (response['inst'][0]['ivtp'] == 1) {
                        document.getElementById("edit_ivtp").checked = true;
                    } else {
                        document.getElementById("edit_ivtp").checked = false;
                    }

                    document.getElementById("edit_remk").value = response['inst'][0]['remk'];
                    document.getElementById("edit_auid").value = response['inst'][0]['auid'];
                    //}
                }
                if (len2 != 0) {
                    //document.getElementById("bnid").value = response['bank'][0]['bnid'];


                    $("#edit_spit").html("");
                    for (var i = 0; i < len2; i++) {
                        if (i < 1) {
                            if (response['inst'][0]['stat'] == 0) {


                                $('#edit_spit').append(' <div class="form-group">' +
                                    '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    '<select class="form-control" name="edit_bkid[]" id="edit_bkid[' + i + ']" onchange="">' +
                                    '"<option value="0" >Select Bank</option>" ' +
                                    <?php
                                    foreach ($bankinfo as $bnk) {
                                        echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";

                                    }
                                    ?>
                                    ' </select>                                     </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control"  name="edit_bunm[]" id="edit_bunm[]"placeholder = "Brach Name" value = "' + response['bank'][i]['bunm'] + '" /> </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" name="edit_acno[]" id="edit_acno[]"placeholder = "Account Number" value = "' + response['bank'][i]['acno'] + '" /> </div>' +
                                    '<div class="col-md-1">' +
                                    '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>' +
                                    ' <input type="hidden" id="bnid[]" name="bnid[]" value="' + response['bank'][i]['bnid'] + '"/>'
                                )
                                document.getElementById('edit_bkid[' + i + ']').value = response['bank'][i]['bkid'];

                            }
                            else {

                                $('#edit_spit').append(' <div class="form-group">' +
                                    '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    '<select disabled class="form-control" name="edit_bkid[]" id="edit_bkid[' + i + ']" onchange="">' +
                                    '"<option value="0" >Select Bank</option>" ' +
                                    <?php
                                    foreach ($bankinfo as $bnk) {
                                        echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";

                                    }
                                    ?>
                                    ' </select>                                     </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" readonly   name="edit_bunm[]" id="edit_bunm[]"placeholder = "Brach Name" value = "' + response['bank'][i]['bunm'] + '" /> </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" readonly  name="edit_acno[]" id="edit_acno[]"placeholder = "Account Number" value = "' + response['bank'][i]['acno'] + '" /> </div>' +
                                    '<div class="col-md-1">' +
                                    '</div><br></div>' +
                                    ' <input type="hidden" id="bnid[]" name="bnid[]" value="' + response['bank'][i]['bnid'] + '"/>'
                                )
                                document.getElementById('edit_bkid[' + i + ']').value = response['bank'][i]['bkid'];

                            }


                        } else {

                            if (response['inst'][0]['stat'] == 0) {


                                $('#edit_spit').append(' <div class="form-group">' +
                                    '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    '<select class="form-control" name="edit_bkid[]" id="edit_bkid[' + i + ']" onchange="">' +
                                    '"<option value="0" >Select Bank</option>" ' +
                                    <?php
                                    foreach ($bankinfo as $bnk) {
                                        echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";
                                    }
                                    ?>
                                    ' </select>                                     </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" name="edit_bunm[]" id="edit_bunm[]"placeholder = "Branch Name" value = "' + response['bank'][i]['bunm'] + '"/>  </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" name="edit_acno[]" id="edit_acno[]"placeholder = "Account Number" value = "' + response['bank'][i]['acno'] + '"/>  </div>' +
                                    '<div class="col-md-1">' +
                                    '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>' +
                                    ' <input type="hidden" id="bnid[]" name="bnid[]" value="' + response['bank'][i]['bnid'] + '"/>'
                                )
                                document.getElementById('edit_bkid[' + i + ']').value = response['bank'][i]['bkid'];

                            }

                            else {
                                $('#edit_spit').append(' <div class="form-group">' +
                                    '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    '<select disabled class="form-control" name="edit_bkid[]" id="edit_bkid[' + i + ']" onchange="">' +
                                    '"<option value="0" >Select Bank</option>" ' +
                                    <?php
                                    foreach ($bankinfo as $bnk) {
                                        echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";
                                    }
                                    ?>
                                    ' </select>                                     </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" readonly name="edit_bunm[]" id="edit_bunm[]"placeholder = "Branch Name" value = "' + response['bank'][i]['bunm'] + '"/>  </div>' +
                                    '<div class="col-md-3 col-xs-12">' +
                                    ' <input type="text" class="form-control" readonly name="edit_acno[]" id="edit_acno[]"placeholder = "Account Number" value = "' + response['bank'][i]['acno'] + '"/>  </div>' +
                                    '<div class="col-md-1">' +
                                    '</div><br></div>' +
                                    ' <input type="hidden" id="bnid[]" name="bnid[]" value="' + response['bank'][i]['bnid'] + '"/>'
                                )
                                document.getElementById('edit_bkid[' + i + ']').value = response['bank'][i]['bkid'];
                            }

                        }


                    }
                }
            }
        })
    }


    /* REF LINK  >>  https://stackoverflow.com/questions/28184177/dynamically-add-remove-rows-from-html-table */
    $('#edit_addrw').click(function () {

       // console.log('aaaa');

        $('#edit_spit').append(' <div class="form-group">' +
            '<label class="col-md-2 col-xs-12 control-label">Bank Details</label>' +
            '<div class="col-md-3 col-xs-12">' +
            '<select class="form-control" name="edit_bkid[]" id="edit_bkid[]" onchange="">' +
            '"<option value="0" >Select Bank</option>" ' +
            <?php
            foreach ($bankinfo as $bnk) {
                echo "'" . '"<option value=' . "$bnk->bkid" . '>' . "$bnk->bknm" . '</option>"' . "' +";
            }
            ?>
            ' </select>                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="acno[]" id="acno[]"placeholder = "Account Number" / >                                     </div>' +
            '<div class="col-md-3 col-xs-12">' +
            ' <input type="text" class="form-control" name="bunm[]" id="bunm[]"placeholder = "Branch name" / >                                     </div>' +
            '<div class="col-md-1">' +
            '<button type="button" class="btn-sm btn-danger" id="dltrw"><span><i class="fa fa-close" title="Remove"></i></span></button></div><br></div>'
        )
    });
    $('#edit_spit').on('click', '#dltrw', function () {
        var sum = 0;
        $(this).closest('.form-group').remove();
        $(".form-group input[name='subamt[]']").each(function () {
            sum = sum + +this.value;
        });
       // document.getElementById('pyam').value = sum;
    });
    //invester add load account end

    //investor edit from filling end
    //
    // investor edit start
    $("#subBtn_edit").click(function (e) {
        e.preventDefault();
        var funcc = document.getElementById("func").value;
        if ($("#ins_edit").valid()) {
            var formData = new FormData(this);
            if (funcc == 1) {
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
                                url: "<?= base_url(); ?>admin/edit_investor",
                                data: $("#ins_edit").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    $('#modalEdt').modal('hide');
                                    searchInvestor();
                                    swal({
                                            title: "",
                                            text: "Investor Updated Successfully!",
                                            type: "success"
                                        },
                                        function () {
                                           location.reload();
                                        });
                                },
                                error: function () {
                                    swal("Investor Update Failed!", 'aaaa', "error");
                                    window.setTimeout(function () {
                                    }, 200);
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else if (funcc == 2) {
                var id = document.getElementById("auid").value;
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
                                url: "<?= base_url(); ?>admin/edit_investor",
                                data: $("#ins_edit").serialize(),
                                dataType: 'json',
                                success: function (response) {
                                    $('#modalEdt').modal('hide');
                                    swal({
                                            title: "",
                                            text: "Investor Approval Successfully!",
                                            type: "success"
                                        },
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function () {
                                    swal("investor Approval Failed!", 'aaaa', "error");
                                    window.setTimeout(function () {
                                        //location = '<?= base_url(); ?>admin/invstor';
                                    }, 2000);
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
                alert("contact system admin");
            }
        } else {
        }
    });
    // investor edit end
    //
    // investor reject start
    function rejecInves(auid) {
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
                        url: '<?= base_url(); ?>admin/rejInvestor',
                        type: 'post',
                        data: {
                            auid: auid
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                searchInvestor();

                                swal({
                                    title: "",
                                    text: "Insvester Reject Success!",
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
</script>