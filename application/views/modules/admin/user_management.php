<!DOCTYPE html>
<html class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>admin"><i class="fa fa-home"></i>Home</a></li>
                        <li><a href="">System Component</a></li>
                        <li class="active"><strong>User Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">User Management</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brnc" id="brnc"
                                            onchange="chckBtn(this.value,'brnc')">
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
                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="uslv" id="uslv"
                                            onchange="chckBtn(this.value,'uslv')">
                                        <option value='all'>-- All Level --</option>
                                        <?php
                                        foreach ($userlvl as $uslv) {
                                            if ($uslv->id == 1) {

                                            } else {
                                                echo "<option value='$uslv->id'>$uslv->lvnm </option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchUser()"
                                            class='btn-sm btn-primary' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table datatable table-bordered table-striped table-actions"
                                   id="dataTbUser" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center">NO</th>
                                    <th class="text-center">BRN</th>
                                    <!--<th class="text-center">IMG</th>-->
                                    <th class="text-center">USERNAME</th>
                                    <th class="text-center">NAME</th>
                                    <th class="text-center">MOBILE</th>
                                    <!--<th class="text-center">NIC</th>-->
                                    <th class="text-center">USER LEVEL</th>
                                    <!--<th class="text-center">JOIN DATE</th>-->
                                    <th class="text-center">LAST LOGIN</th>
                                    <th class="text-center">MODE</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Add New User </h4>
            </div>
            <form class="form-horizontal" id="user_add" name="user_add" enctype="multipart/form-data"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-8 col-xs-6">
                                                    <select class="form-control" name="brch" id="brch"
                                                            onchange="chckBtn(this.value,'brch')">
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

                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> First Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="fnme" id="fnme"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> User Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="usnm" id="usnm"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> NIC </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           onkeyup="checkNic1(this.value,'nic','subBtn')"
                                                           onchange="checkNic1(this.value,'nic','subBtn')"
                                                           name="nic" id="nic"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Civil Statues </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="civl" id="civl"
                                                            onchange="chckBtn(this.value,'civl')">
                                                        <option value='0'> Select Statues</option>
                                                        <?php
                                                        foreach ($cvlst as $cvl) {
                                                            echo "<option value='$cvl->cvid'>$cvl->cvdt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Contact </label>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control" name="tele" id="tele"
                                                           placeholder="Telephone"/>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control" name="mobi" id="mobi"
                                                           placeholder="Mobile"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                                <div class="col-md-8 col-xs-6">
                                                    <select class="form-control" name="uslv" id="uslv"
                                                            onchange="chckBtn(this.value,'uslv')">
                                                        <option value='0'>--Select Level--</option>
                                                        <?php
                                                        foreach ($userlvl as $uslv) {
                                                            if ($uslv->id != 1) {
                                                                echo "<option value='$uslv->id'>$uslv->lvnm </option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Last Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="lnme" id="lnme"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Email </label>
                                                <div class="col-md-8 ">
                                                    <input type="email" class="form-control" name="emil" id="emil"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> DOB / Gender </label>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control datepicker" name="dobi"
                                                           id="dobi" value=""/>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <select class="form-control" name="gend" id="gend"
                                                            onchange="chckBtn(this.value,'gend')">
                                                        <option value='0'> Select</option>
                                                        <option value='1'> Male</option>
                                                        <option value='2'> Female</option>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Permission Type </label>
                                                <div class="col-md-8 ">
                                                    Manual <input type="checkbox" checked="" id="prtp" name="prtp"
                                                                  class="iswitch iswitch-md iswitch-primary">Default
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Designation </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="desg" id="desg"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="row">
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label class="col-md-4  control-label"> Profile Image </label>
                                                 <div class="col-md-8">
                                                     <div class="kv-avatar center-block text-center" style="width:200px">
                                                         <input type="file" name="picture" id="avatar_1"
                                                                class="file-loading"></div>
                                                 </div>
                                             </div>
                                         </div>
                                         <div class="col-md-6">
                                             <div class="form-group">
                                                 <label class="col-md-4  control-label"> Snapshot </label>
                                                 <div class="col-md-8" id="cam">
                                                     <div id="my_cameraCanvas">
                                                         <div id="my_camera"></div>
                                                     </div>
                                                     <input type="button" class="btn btn-info" value="Take Snapshot"
                                                            onClick="take_snapshot()">
                                                 </div>

                                                 <div class="col-md-8">
                                                     <div id="results" style="display: none"></div>
                                                     <input type="hidden" id="camImg" name="camImg">
                                                 </div>
                                             </div>
                                         </div>

                                     </div>-->
                                    <span style="color: red">
                                        # Please fill the all input fields. <br>
                                        # Make sure you enter the valid e-mail id because system will send your login details to that e-mail address. <br>
                                        # Normally permission type is default, If you selected manual, Please finished the user creations then changed the custom permissions.
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="subBtn">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                    </button>
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
                <h4 class="modal-title" id="largeModalHead"> View User Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Branch</label>
                                            <label class="col-md-8  control-label" id="brch_vew"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">User Level</label>
                                            <label class="col-md-8  control-label" id="usrlv_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">First Name</label>
                                            <label class="col-md-8  control-label" id="frnm_vew"></label>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Last Name</label>
                                            <label class="col-md-8  control-label" id="lsnm_vew"></label>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">NIC</label>
                                            <label class="col-md-8  control-label" id="nic_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">DOB / Gender</label>
                                            <label class="col-md-8  control-label" id="dob_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Civil Statuesr</label>
                                            <label class="col-md-8  control-label" id="cvl_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Email</label>
                                            <label class="col-md-8 control-label" id="emil_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Contact</label>
                                            <label class="col-md-8  control-label" id="cnt_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Permission</label>
                                            <label class="col-md-8 control-label" id="per_vew"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">User Name</label>
                                            <label class="col-md-8  control-label" id="usnm_vew"> </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4  control-label">Designation</label>
                                            <label class="col-md-8  control-label" id="desg_vew"> </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Profile Image</label>
                                            <div class="kv-avatar center-block text-center"
                                                 style="width:200px">
                                                <div class="cropping-preview-wrap">
                                                    <div class="cropping-preview">
                                                        <img
                                                                src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                id="img1"
                                                                style="width: 160px; height: 160px; margin-left: -33px; margin-top: 13px;">
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Edit || Approval -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> </span> <span id="cuno"> </span></h4>
            </div>

            <form class="form-horizontal" id="user_edt" name="user_edt" enctype="multipart/form-data"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                                <div class="col-md-8 col-xs-6">
                                                    <select class="form-control" name="brch_edt" id="brch_edt"
                                                            onchange="chckBtn(this.value,'brch_edt')">
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
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> First Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="fnme_edt"
                                                           id="fnme_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> User Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="usnm_edt"
                                                           id="usnm_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> NIC </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           onchange="checkNic_edt(this.value,'nic_edt','btnNm')"
                                                           onkeyup="checkNic_edt(this.value,'nic_edt','btnNm')"
                                                           name="nic_edt" id="nic_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Civil Statues </label>
                                                <div class="col-md-8 ">
                                                    <select class="form-control" name="civl_edt" id="civl_edt"
                                                            onchange="chckBtn(this.value,'civl_edt')">
                                                        <option value='0'> Select Statues</option>
                                                        <?php
                                                        foreach ($cvlst as $cvl) {
                                                            echo "<option value='$cvl->cvid'>$cvl->cvdt</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Contact </label>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control" name="tele_edt"
                                                           id="tele_edt"
                                                           placeholder="Telephone"/>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control" name="mobi_edt"
                                                           id="mobi_edt"
                                                           placeholder="Mobile"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">User Level</label>
                                                <div class="col-md-8 col-xs-6">
                                                    <select class="form-control" name="uslv_edt" id="uslv_edt"
                                                            onchange="chckBtn(this.value,'uslv_edt')">
                                                        <option value='0'>--Select Level--</option>
                                                        <?php
                                                        foreach ($userlvl as $uslv) {
                                                            if ($uslv->id != 1) {
                                                                echo "<option value='$uslv->id'>$uslv->lvnm </option>";
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Last Name </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="lnme_edt"
                                                           id="lnme_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Email </label>
                                                <div class="col-md-8 ">
                                                    <input type="email" class="form-control" name="emil_edt"
                                                           id="emil_edt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> DOB / Gender </label>
                                                <div class="col-md-4 ">
                                                    <input type="text" class="form-control datepicker" name="dobi_edt"
                                                           id="dobi_edt" value="<?php echo date("Y-m-d"); ?>"/>
                                                </div>
                                                <div class="col-md-4 ">
                                                    <select class="form-control" name="gend_edt" id="gend_edt"
                                                            onchange="chckBtn(this.value,'gend')">
                                                        <option value='0'> Select</option>
                                                        <option value='1'> Male</option>
                                                        <option value='2'> Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Permission Type </label>
                                                <div class="col-md-8 ">
                                                    Manual <input type="checkbox" id="prtp_edt" name="prtp_edt"
                                                                  value="1"
                                                                  class="iswitch iswitch-md iswitch-primary">Default

                                                    <!--<label class="switch">
                                                        <input  type="checkbox"
                                                               value="1"/>Default
                                                        <span></span>
                                                    </label> Manual-->
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Designation </label>
                                                <div class="col-md-8 ">
                                                    <input type="text" class="form-control" name="desg_edt"
                                                           id="desg_edt"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--<div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Profile Image </label>
                                                <div class="col-md-8">
                                                    <div class="kv-avatar center-block text-center"
                                                         style="width:200px">
                                                        <input type="file" name="picture" id="avatar_2"
                                                               class="file-loading"/>
                                                    </div>
                                                    <input type="hidden" id="usrimg" name="usrimg">
                                                </div>
                                                <span id="file_error"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> <!-- A button for taking snaps --
                                            <div class="form-group">
                                                <label class="col-md-4  control-label"> Snapshot </label>
                                                <div class="col-md-8" id="camEdt">
                                                    <div id="my_cameraCanvasEdt">
                                                        <div id="my_cameraEdt"></div>
                                                    </div>
                                                    <input type="button" class="btn btn-info" value="Take Snapshot"
                                                           onClick="take_snapshotEdt()">
                                                </div>

                                                <div class="col-md-8" id="camResuEdt" style="display: none">
                                                    <div id="resultsEdt"></div>
                                                    <input type="hidden" id="camImgEdt" name="camImgEdt">
                                                </div>

                                            </div>
                                        </div>

                                    </div>-->
                                </div>
                                <span style="color: red">
                                         # Normally permission type is default, If you selected manual, Please finished the user creations then changed the custom permissions.
                                   </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" id="auid" name="auid">
                    <input type="hidden" id="stat" name="stat">

                    <button type="submit" class="btn btn-success" id="btnNm"></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit || Approval Model -->

<!-- END CONTAINER -->
</html>

<script>
    $().ready(function () {
        // Data Tables
        $('#dataTbUser').DataTable({
            destroy: true
        });

        $("#user_add").validate({  // add form validation
            rules: {
                brch: {
                    required: true,
                    notEqual: '0'
                },
                uslv: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                gend: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                civl: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                mobi: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                tele: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },

                nic: {
                    required: true
                },
                emil: {
                    required: true
                },
                funm: {
                    required: true
                },
                innm: {
                    required: true
                },
                fnme: {
                    required: true
                },
                lnme: {
                    required: true
                },
                dobi: {
                    required: true
                },
                usnm: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_usrnm",
                        type: "post",
                        data: {
                            usnm: function () {
                                return $("#usnm").val();
                            },
                        }
                    }
                },
                desg: {
                    required: true
                },
            },
            messages: {
                brch: {
                    required: 'select Branch',
                    notEqual: "select Branch"
                },
                uslv: {
                    required: 'select User Level',
                    notEqual: "select User Level",
                    min: "select User Level"
                },
                gend: {
                    required: 'select Gender',
                    notEqual: "select Gender",
                    min: "select Gender"
                },
                civl: {
                    required: 'Select Civil Statues',
                    notEqual: "Select Civil Statues",
                    min: "Select Civil Statues"
                },

                tamt: {
                    required: 'Enter Mobile',
                    digits: 'This is not a Mobile No',
                    minlength: 'This is not a Mobile No',
                    maxlength: 'This is not a Mobile No'
                },
                tele: {
                    digits: 'Not a Telephone No',
                    minlength: 'Not a Telephone No',
                    maxlength: 'Not a Telephone No'
                },

                nic: {
                    required: 'Enter Nic No'
                },
                emil: {
                    required: 'Enter Valide Email'
                },
                funm: {
                    required: 'Please Enter Full Name'
                },
                innm: {
                    required: 'Please Enter Initial Name'
                },

                fnme: {
                    required: 'Please Enter First Name'
                },
                lnme: {
                    required: 'Please Enter Last Name'
                },
                dobi: {
                    required: 'Please Enter Birthday'
                },
                usnm: {
                    required: 'Please Enter User Name',
                    remote: "User Name Already Exists"
                },
                desg: {
                    required: 'Enter User Designation'
                },

            }
        });

        $("#user_edt").validate({  // edt form validation
            rules: {
                brch_edt: {
                    required: true,
                    notEqual: '0'
                },
                uslv_edt: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                gend_edt: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                civl_edt: {
                    required: true,
                    notEqual: '0',
                    min: 1
                },
                mobi_edt: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                tele_edt: {
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },

                nic_edt: {
                    required: true
                },
                emil_edt: {
                    required: true
                },
                funm_edt: {
                    required: true
                },
                innm_edt: {
                    required: true
                },
                fnme_edt: {
                    required: true
                },
                lnme_edt: {
                    required: true
                },
                dobi_edt: {
                    required: true
                },
                usnm_edt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>admin/chk_usrnm_edt",
                        type: "post",
                        data: {
                            usnm: function () {
                                return $("#usnm").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            },
                        }
                    }
                },
                savatar_2: {
                    required: true,
                    extension: 'jpe?g,png',
                    uploadFile: true,
                },
                avatar_2: {
                    required: true,
                    extension: "xls|csv"
                },
                desg_edt: {
                    required: true
                },

            },
            messages: {
                brch_edt: {
                    required: 'select Branch',
                    notEqual: "select Branch"
                },
                uslv_edt: {
                    required: 'select User Level',
                    notEqual: "select User Level",
                    min: "select User Level"
                },
                gend_edt: {
                    required: 'select Gender',
                    notEqual: "select Gender",
                    min: "select Gender"
                },
                civl_edt: {
                    required: 'Select Civil Statues',
                    notEqual: "Select Civil Statues",
                    min: "Select Civil Statues"
                },

                tamt_edt: {
                    required: 'Enter Mobile',
                    digits: 'This is not a Mobile No',
                    minlength: 'This is not a Mobile No',
                    maxlength: 'This is not a Mobile No'
                },
                tele_edt: {
                    digits: 'Not a Telephone No',
                    minlength: 'Not a Telephone No',
                    maxlength: 'Not a Telephone No'
                },

                nic_edt: {
                    required: 'Enter Nic No'
                },
                emil_edt: {
                    required: 'Enter Valide Email'
                },
                funm_edt: {
                    required: 'Please Enter Full Name'
                },
                innm_edt: {
                    required: 'Please Enter Initial Name'
                },
                fnme_edt: {
                    required: 'Please Enter First Name'
                },
                lnme_edt: {
                    required: 'Please Enter Last Name'
                },
                dobi_edt: {
                    required: 'Please Enter Birthday'
                },
                usnm_edt: {
                    required: 'Please Enter User Name',
                    remote: "User Name Already Exists"
                },
                savatar_2: {
                    required: 'Please Enter User Name',
                    extension: "User Name Already Exists",
                    uploadFile: '',
                },
                desg_edt: {
                    required: 'Enter User Designation'
                }
            }
        });
        srchUser();
    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    /* SEARCH */
    function srchUser() {

        var brch = document.getElementById('brnc').value;
        var uslv = document.getElementById('uslv').value;

        if (brch == 0) {
            document.getElementById('brnc').style.borderColor = "red";
        } else {
            document.getElementById('brnc').style.borderColor = "";
            $('#dataTbUser').DataTable().clear();
            $('#dataTbUser').DataTable({
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
                "columnDefs": [
                    {className: "text-left", "targets": [2, 3,  5, 6]},
                    {className: "text-center", "targets": [0, 1,4, 7, 8]},
                    {className: "text-right", "targets": [0]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aaSorting": [[1, 'asc']],
                "aoColumns": [
                    {sWidth: '3%'},
                    {sWidth: '3%'},
                    {sWidth: '5%'},
                    //{sWidth: '5%'},
                    {sWidth: '15%'},    // name
                    //{sWidth: '3%'},
                    //{sWidth: '3%'},     // nic
                    {sWidth: '10%'},
                    {sWidth: '10%'},     // join date
                    {sWidth: '12%'},    // last login
                    {sWidth: '5%'},
                    {sWidth: '18%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>admin/srchUser',
                    type: 'post',
                    data: {
                        brch: brch,
                        uslv: uslv
                    }
                }
            });
        }
    }

    /* ADD */
    $("#user_add").submit(function (e) {
        e.preventDefault();

        if ($("#user_add").valid()) {
            var formObj = $(this);
            //var formURL = formObj.attr("action");
            var formData = new FormData(this);

            document.getElementById('subBtn').disabled = true;
            $('#modalAdd').modal('hide');

            $.ajax({
                url: "<?= base_url(); ?>admin/add_user",
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data, textStatus, jqXHR) {

                    srchUser();
                    swal({title: "", text: "New User Added Success!", type: "success"},
                        function () {
                            location.reload();
                        }
                    );
                },
                error: function (data, jqXHR, textStatus, errorThrown) {
                    swal({title: "", text: "User Added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    /* EDIT VIEW*/
    function edtUser(auid, typ) {
        if (typ == 'edt') {
            $('#hed').text("Update User");
            $('#btnNm').text("Update");
        } else if (typ == 'app') {
            $('#hed').text("Approval User");
            $('#btnNm').text("Approval");
        }

        //document.getElementById('camResuEdt').style.display = "none";
        //document.getElementById('camEdt').style.display = "block";
        //document.getElementById('camImgEdt').value = '';

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/userDtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("brch_edt").value = response[0]['brch'];
                document.getElementById("fnme_edt").value = response[0]['fnme'];
                document.getElementById("nic_edt").value = response[0]['unic'];
                document.getElementById("civl_edt").value = response[0]['civl'];
                document.getElementById("tele_edt").value = response[0]['tpno'];
                document.getElementById("mobi_edt").value = response[0]['almo'];

                document.getElementById("usnm_edt").value = response[0]['usnm'];
                document.getElementById("uslv_edt").value = response[0]['usmd'];
                document.getElementById("lnme_edt").value = response[0]['lnme'];
                document.getElementById("dobi_edt").value = response[0]['udob'];
                document.getElementById("gend_edt").value = response[0]['gend'];
                document.getElementById("emil_edt").value = response[0]['emid'];
                document.getElementById("desg_edt").value = response[0]['desg'];

                if (response[0]['prmd'] == 1) {
                    document.getElementById("prtp_edt").checked = false;
                } else {
                    document.getElementById("prtp_edt").checked = true;
                }
                document.getElementById("auid").value = response[0]['auid'];
                document.getElementById("stat").value = response[0]['stat'];

                //var uimg = response[0]['uimg'];
                //document.getElementById("usrimg").value = uimg;

            }
        })
    }

    /* EDIT SUBMIT*/
    $("#user_edt").submit(function (e) {
        //$("#btnNm").on('click', function (e) { // add form
        e.preventDefault();

        if ($("#user_edt").valid()) {
            var formObj = $(this);
            //  var formURL = formObj.attr("action");
            var formData = new FormData(this);
            document.getElementById("btnNm").disabled = true;

            $.ajax({
                url: '<?= base_url(); ?>Admin/user_update',
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,

                success: function (data, textStatus, jqXHR) {
                    $('#modalEdt').modal('hide');
                    srchUser();
                    document.getElementById("btnNm").disabled = false;
                    swal({title: "", text: "User Update Success!", type: "success"},
                        function () {
                            location.reload();
                        }
                    );
                    self.submitting = false;
                },
                error: function (data, jqXHR, textStatus, errorThrown) {
                    swal("Failed!", "User Update Failed", "error");
                    window.setTimeout(function () {
                        location.reload();
                    }, 2000);
                }
            });
        }
    });

    /* VIEW */
    function viewUser(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>admin/userDtils",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("brch_vew").innerHTML = response[i]['brnm'];
                    document.getElementById("usrlv_vew").innerHTML = response[i]['lvnm'];
                    document.getElementById("frnm_vew").innerHTML = response[i]['fnme'];
                    document.getElementById("lsnm_vew").innerHTML = response[i]['lnme'];
                    document.getElementById("nic_vew").innerHTML = response[i]['unic'];
                    document.getElementById("dob_vew").innerHTML = response[i]['udob'] + ' / ' + response[i]['gndt'];
                    document.getElementById("cvl_vew").innerHTML = response[i]['cvdt'];
                    document.getElementById("emil_vew").innerHTML = response[i]['emid'];
                    document.getElementById("cnt_vew").innerHTML = response[i]['almo'] + ' | ' + response[i]['tpno'];
                    if (response[i]['prmd'] == 0) {
                        document.getElementById("per_vew").innerHTML = 'Default Permission';
                    } else {
                        document.getElementById("per_vew").innerHTML = 'Manual Permission';
                    }
                    document.getElementById("usnm_vew").innerHTML = response[i]['usnm'];
                    document.getElementById("img1").src = "../uploads/userimg/" + response[i]['uimg'];
                    document.getElementById("desg_vew").innerHTML = response[i]['desg'];
                }
            }
        })
    }

    /* REJECT*/
    function rejecUser(id) {
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
                        url: '<?= base_url(); ?>Admin/rejUser',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            // $('#modalEdt').modal('hide');
                            srchUser();
                            swal({title: "", text: "User Reject Success!", type: "success"});
                        }
                    });
                } else {
                    swal("Cancelled!", "User Not Cancel", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvUser(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to recover this process",
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
                        url: '<?= base_url(); ?>admin/reactUser',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                // $('#modalEdt').modal('hide');
                                srchUser();
                                swal({title: "", text: "User Reactive Success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process Cancelled!", "", "error");
                }
            });
    }

    // user password reset
    function keyResetUser(id) {
        swal({
                title: "Are you sure ?",
                text: "Your password rest  123 & Eye 123456, Please confirms for process...",
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
                        url: '<?= base_url(); ?>admin/resetPass',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                srchUser();
                                swal({title: "", text: "Password reset Success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process Cancelled!", "", "error");
                }
            });
    }

    // LOCK USER UNLOCK
    function unlockUser(id) {
        swal({
                title: "Are you sure ?",
                text: "This user Unlock, Please confirms for process...",
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
                        url: '<?= base_url(); ?>admin/userUnlock',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response) {
                                srchUser();
                                swal({title: "", text: "user unlock success!", type: "success"});
                            }
                        }
                    });
                } else {
                    swal("Process Cancelled!", "", "error");
                }
            });
    }

</script>