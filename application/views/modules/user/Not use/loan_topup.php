<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active">Topup Loan Management</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Topup Loan Management </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Topup Loan
                        </button> <!-- data-toggle="modal" data-target="#modalAdd" -->
                    <?php } ?>
                </div>

                <div class="panel-body">

                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="brch" id="brch"
                                            onchange="getExe(this.value,'exc',exc.value,'cen');chckBtn(this.value,'brch')">
                                        <?php
                                        foreach ($branchinfo as $branch) {
                                            echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Status</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="stat" id="stat">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($stainfo as $stat) {
                                            echo "<option value='$stat->stid'>$stat->stnm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="exc" id="exc"
                                            onchange="getCenter(this.value,'cen',brch.value)">
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
                                <label class="col-md-4 col-xs-6 control-label">Center</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="cen" id="cen">
                                        <?php
                                        foreach ($centinfo as $cen) {
                                            echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchLoan()"
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
                                           id="dataTbLoan" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH /CENTER</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">PRODUCT</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">RENTAL</th>
                                            <th class="text-center">PERIOD</th>
                                            <th class="text-center">MODE</th>
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

<!-- Loan Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create New Topup Loan
                </h4>
            </div>

            <form class="form-horizontal" id="loan_topup" name="loan_topup"
                  action="<?= base_url() ?>user/addLoan" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left"> Dynamic Loan</label>
                                            <div class="col-md-3">
                                                <label class="switch">
                                                    <input type="checkbox" class="switch" value="1" id="lntp"
                                                           name="lntp" onclick="loanType()" checked/>
                                                    <span></span>
                                                </label>
                                            </div>
                                            <label class="col-md-4 control-label text-left">Product Loan</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label text-left"> Group Guarantor</label>
                                            <div class="col-md-3">
                                                <label class="switch">
                                                    <input type="checkbox" class="switch" value="1" id="lncttp"
                                                           name="lncttp" onclick="loanCatType()"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                            <label class="col-md-4 control-label text-left">Individual
                                                Guarantor</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="panel-body">

                                <div class="col-md-6">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Applicant Loan Details
                                    </h3>
                                    <div class="form-group">
                                        <!--<label class="col-md-4 col-xs-12 control-label">Customer NIC</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="lnno" autofocus
                                                   name="lnno" placeholder="Customer Current Loan No" autocomplete="off"
                                                   value="" onkeyup="lnnoChck(this.value)"/>

                                            <div id="sts1"></div>
                                            <div class="col-md-12 col-xs-12" id="cusDtilsDiv" style="display: none">
                                                <table width="600" border="0" cellpadding="0" cellspacing="0" id="tr1">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup" id="uimgA" target="_blank"
                                                               href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                     class="img-circle img-thumbnail" alt="" id="uimg"
                                                                     width="100" height="100"></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2"><strong id="init"></strong></td>
                                                        <td><strong>Branch :</strong> &nbsp;&nbsp;<span
                                                                    id="brnm"></span></td>
                                                        <td><strong>Group :</strong> &nbsp;&nbsp;<span
                                                                    id="grno"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="cuno"></span></td>
                                                        <td width="148">NIC: <strong><span id="anic"></span></strong>
                                                        </td>
                                                        <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span
                                                                    id="cntr"></span>
                                                        </td>
                                                        <td width="148"><strong>Type :</strong> &nbsp;&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="hoad"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4"><span id="mobi"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <div class="table-responsive" id="fcdt"
                                                                 style="display: none">
                                                                <table width="100%"
                                                                       class="table table-bordered table-striped ">
                                                                    <thead>
                                                                    <tr>
                                                                        <th colspan="4" class="text-center"><strong>FACILITY
                                                                                DETAILS</strong>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr id="trow_1">
                                                                        <td width="25%" class="text-left">Facility No
                                                                        </td>
                                                                        <td width="25%"><span id="acno"></span></td>
                                                                        <td width="25%">Product</td>
                                                                        <td width="25%"><span id="prcd"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_2">
                                                                        <td>Facility Date</td>
                                                                        <td><span id="indt"></span></td>
                                                                        <td>Maturity Date</td>
                                                                        <td><span id="mddt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_3">
                                                                        <td>Amount</td>
                                                                        <td><span id="loam"></span></td>
                                                                        <td>Premium</td>
                                                                        <td><span id="inst"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_4">
                                                                        <td>Settlement Today</td>
                                                                        <td><span id="tdst"></span></td>
                                                                        <td>Status</td>
                                                                        <td><span id="stmt"></span></td>
                                                                    </tr>
                                                                    <tr id="trow_5">
                                                                        <td>Over Payment</td>
                                                                        <td><span id="ovpe"></span></td>
                                                                        <td></td>
                                                                        <td><span id="stmt22"></span></td>
                                                                    </tr>

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <label class="col-md-8 control-label" id="agdt"
                                                                   style="color: red"> </label>
                                                            <!-- arrees details-->
                                                            <label class="col-md-8 control-label" id="rtdt"
                                                                   style="color: red"> </label>
                                                            <!-- rental details-->
                                                            <label class="col-md-12 control-label" id="pydt"
                                                                   style="color: red"> </label>
                                                            <!-- payment details-->

                                                            <label class="col-md-8 control-label ">
                                                                <a id="mrdt" href="" target="_blank"
                                                                   style="color: red">View More Details... </a>
                                                            </label>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                                <input type="hidden" id="lnid" name="lnid">
                                                <input type="hidden" id="cusBrn" name="cusBrn">
                                                <input type="hidden" id="appid" name="appid">
                                                <input type="hidden" id="lnct" name="lnct">
                                                <input type="hidden" id="crnt_prtp" name="crnt_prtp">
                                                <input type="hidden" id="setBal" name="setBal">
                                                <input type="hidden" id="nic" name="nic">
                                                <input type="hidden" id="nwlnBal" name="nwlnBal">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Internal granter ( Group members) -->
                                <div class="col-md-6 col-xs-12" id="divGrpmb">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Guarantor Details
                                    </h3>
                                    <!-- <div class="panel-body">-->
                                    <div class="list-group list-group-contacts border-bottom">
                                        <div id="axx0"></div>
                                        <div id="axx1"></div>
                                        <div id="axx2"></div>
                                        <div id="axx3"></div>
                                        <div id="axx4"></div>
                                        <div id="axx5"></div>
                                        <div id="axx6"></div>
                                        <div id="axx7"></div>
                                        <div id="axx8"></div>
                                        <div id="axx9"></div>
                                    </div>

                                    <input type="hidden" id="grntLen" name="grntLen">
                                    <input type="hidden" id="grnCunt" name="grnCunt">
                                    <input type="hidden" id="grnTyp" name="grnTyp" value="1">
                                    <!--<div class="list-group list-group-contacts border-bottom">
                                            <div class="list-group-item">
                                                <div class="list-group-status status-online"></div>
                                                <img src="<? /*= base_url() */ ?>assets/images/users/user3.jpg"
                                                     class="pull-left"
                                                     alt="Nadia Ali">
                                                <span class="contacts-title">Nadia Ali</span>
                                                <p>Singer-Songwriter</p>
                                                <div class="list-group-controls">
                                                    <button class="btn btn-primary btn-rounded"><span
                                                                class="fa fa-pencil"></span></button>
                                                </div>
                                            </div>
                                            <a href="#" class="list-group-item">
                                                <div class="list-group-status status-online"></div>
                                                <img src="<? /*= base_url() */ ?>assets/images/users/user.jpg"
                                                     class="pull-left"
                                                     alt="Dmitry Ivaniuk">
                                                <span class="contacts-title">Dmitry Ivaniuk</span>
                                                <p>Web Developer/Designer</p>
                                                <div class="list-group-controls">
                                                    <button class="btn btn-primary btn-rounded"><span
                                                                class="fa fa-pencil"></span></button>
                                                </div>
                                            </a>
                                        </div>-->
                                    <!-- </div>-->
                                </div>
                                <!-- End Internal granter ( Group members) -->

                                <!-- External garanter  -->
                                <div class="col-md-6 col-xs-12" id="divgrnt" style="display: none">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Guarantor Details
                                    </h3>
                                    <div class="form-group">
                                        <!-- <label class="col-md-4 col-xs-12 control-label">First Guarantor</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="grn1"
                                                   name="grn1" placeholder="First Guarantor NIC"
                                                   onkeyup="nicCheck(this.id,'gr1')"/>

                                            <div id="sts2"></div>
                                            <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                   id="tr2">
                                                <tbody>
                                                <tr>
                                                    <td width="101" rowspan="4">
                                                        <a class="popup"
                                                           title="Click here to see the image..">
                                                            <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                 class="img-circle img-thumbnail" alt=""
                                                                 id="grn1Img"
                                                                 width="100" height="100"/></a></td>
                                                    <td width="10">&nbsp;</td>
                                                    <td colspan="2">
                                                        <strong><span id="grnm1"></span> </strong>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" id="fsgi" name="fsgi">
                                                    <td>&nbsp;</td>
                                                    <td width="118"><span id="grno1"></span></td>
                                                    <td width="129">NIC:
                                                        <strong id="gnic1"></strong></td>
                                                    <td width="167"><span id="grlnac1"></span><span
                                                                id="grlnpn1"></span>
                                                    </td>
                                                    <td width="175">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gadr1"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gphn1"></td>
                                                </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!--<label class="col-md-4 col-xs-12 control-label">Second Guarantor</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="grn2"
                                                   name="grn2" placeholder="Second Guarantor NIC"
                                                   onkeyup="nicCheck(this.id,'gr2')"/>

                                            <div id="sts3"></div>
                                            <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                   id="tr3">
                                                <tbody>
                                                <tr>
                                                    <td width="101" rowspan="4">
                                                        <a class="popup"
                                                           title="Click here to see the image..">
                                                            <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                 class="img-circle img-thumbnail" alt=""
                                                                 id="grn2Img"
                                                                 width="100" height="100"/></a></td>
                                                    <td width="10">&nbsp;</td>
                                                    <td colspan="2">
                                                        <strong><span id="grnm2"></span> </strong>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" id="segi" name="segi">
                                                    <td>&nbsp;</td>
                                                    <td width="118"><span id="grno2"></span></td>
                                                    <td width="129">NIC:
                                                        <strong id="gnic2"></strong></td>
                                                    <td width="167"><span id="grlnac2"></span><span
                                                                id="grlnpn2"></span>
                                                    </td>
                                                    <td width="175">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gadr2"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gphn2"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- <label class="col-md-4 col-xs-12 control-label">Third Guarantor</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="grn3"
                                                   name="grn3" placeholder="Third Guarantor NIC"
                                                   onkeyup="nicCheck(this.id,'gr3')"/>

                                            <div id="sts4"></div>
                                            <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                   id="tr4">
                                                <tbody>
                                                <tr>
                                                    <td width="101" rowspan="4">
                                                        <a class="popup"
                                                           title="Click here to see the image..">
                                                            <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                 class="img-circle img-thumbnail" alt=""
                                                                 id="grn3Img"
                                                                 width="100" height="100"/></a></td>
                                                    <td width="10">&nbsp;</td>
                                                    <td colspan="2">
                                                        <strong><span id="grnm3"></span> </strong>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" id="thgi" name="thgi">
                                                    <td>&nbsp;</td>
                                                    <td width="118"><span id="grno3"></span></td>
                                                    <td width="129">NIC:
                                                        <strong id="gnic3"></strong></td>
                                                    <td width="167"><span id="grlnac3"></span><span
                                                                id="grlnpn3"></span>
                                                    </td>
                                                    <td width="175">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gadr3"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gphn3"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!--  <label class="col-md-4 col-xs-12 control-label">Forth Guarantor</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="grn4"
                                                   name="grn4" placeholder="Forth Guarantor NIC"
                                                   onkeyup="nicCheck(this.id,'gr4')"/>

                                            <div id="sts5"></div>
                                            <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                   id="tr5">
                                                <tbody>
                                                <tr>
                                                    <td width="101" rowspan="4">
                                                        <a class="popup"
                                                           title="Click here to see the image..">
                                                            <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                 class="img-circle img-thumbnail" alt=""
                                                                 id="grn4Img"
                                                                 width="100" height="100"/></a></td>
                                                    <td width="10">&nbsp;</td>
                                                    <td colspan="2">
                                                        <strong><span id="grnm4"></span> </strong>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" id="fogi" name="fogi">
                                                    <td>&nbsp;</td>
                                                    <td width="118"><span id="grno4"></span></td>
                                                    <td width="129">NIC:
                                                        <strong id="gnic4"></strong></td>
                                                    <td width="167"><span id="grlnac4"></span><span
                                                                id="grlnpn4"></span>
                                                    </td>
                                                    <td width="175">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gadr4"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gphn4"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- <label class="col-md-4 col-xs-12 control-label">Fifth Guarantor</label>-->
                                        <div class="col-md-6 col-xs-12">
                                            <input type="text" class="form-control text-uppercase" id="grn5"
                                                   name="grn5" placeholder="Fifth Guarantor NIC"
                                                   onkeyup="nicCheck(this.id,'gr5')"/>

                                            <div id="sts6"></div>
                                            <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                   id="tr6">
                                                <tbody>
                                                <tr>
                                                    <td width="101" rowspan="4">
                                                        <a class="popup"
                                                           title="Click here to see the image..">
                                                            <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                 class="img-circle img-thumbnail" alt=""
                                                                 id="grn5Img"
                                                                 width="100" height="100"/></a></td>
                                                    <td width="10">&nbsp;</td>
                                                    <td colspan="2">
                                                        <strong><span id="grnm5"></span> </strong>
                                                    </td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <input type="hidden" id="figi" name="figi">
                                                    <td>&nbsp;</td>
                                                    <td width="118"><span id="grno5"></span></td>
                                                    <td width="129">NIC:
                                                        <strong id="gnic5"></strong></td>
                                                    <td width="167"><span id="grlnac5"></span><span
                                                                id="grlnpn5"></span>
                                                    </td>
                                                    <td width="175">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gadr5"></td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td colspan="4" id="gphn5"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End External garanter  -->
                            </div>

                            <div class="panel-body">
                                <h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> Facility Details</h3>

                                <div class="row">
                                    <div class="col-md-6" id="prdBase">  <!-- product base -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTyp" id="prdTyp"
                                                        onchange="getLoanPrdt(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($prductinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="fcamt" id="fcamt"
                                                        onchange="getLoanDur(this.value);getInstal()">
                                                    <option value="0"> Select Facility Amount</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dura" id="dura"
                                                        onchange="getInstal()">
                                                    <option value="0"> Select Rental</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Installment</label>
                                            <label class="col-md-8 col-xs-6 control-label"><span
                                                        id="insAmt"> </span> </label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Balance Amount</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" id="blamtPrd" readonly
                                                       name="blamtPrd"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="dynamic"> <!-- Dynamic -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdtpDyn" id="prdtpDyn"
                                                        onchange="abc(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($dynamicprd as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="dyn_fcamt"
                                                       onchange="calInstal()"
                                                       name="dyn_fcamt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dailyDiv" style="display: none">
                                            <!-- Only daily loan -->
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytp" id="dytp"
                                                        onchange="getLoanPrdtDyn(prdtpDyn.value,this.value)">
                                                    <option value="all"> xx</option>
                                                </select>
                                            </div>
                                        </div>  <!-- end Only daily loan -->

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_dura" id="dyn_dura"
                                                        onchange="calInstal()">
                                                    <option value="0"> select Duration</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Interest Rate</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_inrt" id="dyn_inrt"
                                                        onchange="calInstal()">
                                                    <option value="0"> Select Rate</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" readonly id="lnprim"
                                                       name="lnprim"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Balance Amount</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" id="blamtDyn" readonly
                                                       name="blamtDyn"/>
                                            </div>
                                        </div>

                                        <input type="hidden" id="dyn_ttlint" name="dyn_ttlint">
                                    </div>

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="<?= date('Y-m-d') ?>"
                                                       id="indt" name="indt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Distribute Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="<?= date('Y-m-d') ?>"
                                                       id="dsdt" name="dsdt"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Insurance Chg</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control" id="insu"
                                                       onchange="loanCurntBal()"
                                                       name="insu"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Document Chg</label>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="text" class="form-control" id="docu"
                                                       onchange="loanCurntBal()"
                                                       name="docu"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Charge Mode</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="crgmd" id="crgmd"
                                                        onchange="loanCurntBal()">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Customer Pay</option>
                                                    <option value="2" selected>Debit From Loan</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Charging Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_brn" id="coll_brn"
                                                        onchange="getExe(this.value,'coll_ofc',coll_ofc.value,'coll_cen');">
                                                    <?php
                                                    foreach ($branchinfo as $branch) {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_ofc" id="coll_ofc"
                                                        onchange="getCenter(this.value,'coll_cen',coll_brn.value)">
                                                    <?php
                                                    foreach ($execinfo as $exe) {
                                                        echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Center</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_cen" id="coll_cen">
                                                    <?php
                                                    foreach ($centinfo as $cen) {
                                                        echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Remarks</label>
                                            <div class="col-md-8 col-xs-12">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="cler">Clear</button>
                    <button type="submit" class="btn btn-success pull-right" id="lnaddBtn">Submit</button>
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
                <h4 class="modal-title " id="largeModalHead">Loan Details : <span id="cno"></span> <span
                            id="custyp"> </span></h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer NIC</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="cusnic"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Customer No</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="cusno"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Type</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lntyp"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Amount</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnamt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lninst"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Doc Charges</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lndoc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="insdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Branch</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="lnbrn"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Center</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="lncnt"></label>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-12 control-label">Customer Name</label>
                                        <label class="col-md-8 col-xs-12 control-label" id="cunme"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> <br> </label>
                                        <label class="col-md-8 col-xs-6 control-label" id="xx"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnprd"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnrnt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label"> Charge Mode </label>
                                        <label class="col-md-8 col-xs-6 control-label" id="chrmd"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Insu Chrg</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnins"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Distribute Date</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="disdt"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnofc"></label>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4 col-xs-6 control-label">Loan Status</label>
                                        <label class="col-md-8 col-xs-6 control-label" id="lnsts"></label>
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
    <div class="modal-dialog modal-lg" style="width: 95%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> </span> <span id="lnno5"> </span></h4>
            </div>
            <form class="form-horizontal" id="loan_edt" name="loan_edt" enctype="multipart/form-data"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left"> Dynamic Loan</label>
                                                <div class="col-md-3">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch" value="1" id="lntpEdt"
                                                               disabled name="lntpEdt" onclick="" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-4 control-label text-left">Product Loan</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left"> Group Guarantor</label>
                                                <div class="col-md-3">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch" value="1" id="lncttpEdt"
                                                               name="lncttpEdt" onclick="" checked disabled/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-4 control-label text-left">Individual
                                                    Guarantor</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <!-- <h3 class="text-title"><span class="fa fa-bookmark"></span> Customer Details</h3>-->
                                    <div class="col-md-6">
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Applicant Details
                                        </h3>
                                        <div class="form-group">
                                            <div class="col-md-6 col-xs-12">

                                                <div class="col-md-12 col-xs-12" style="display: block">
                                                    <table width="600" border="0" cellpadding="0" cellspacing="0"
                                                           id="tr1">
                                                        <tbody>
                                                        <tr>
                                                            <td width="101" rowspan="4">
                                                                <a class="popup" id="appimgEdtA" target="_blank"
                                                                   href="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                   title="Click here to see the image..">
                                                                    <img src="<?= base_url() ?>uploads/cust_profile/default-image.jpg"
                                                                         class="img-circle img-thumbnail" alt=""
                                                                         id="appimgEdt"
                                                                         width="100" height="100"></a></td>
                                                            <td width="10">&nbsp;</td>
                                                            <td colspan="2"><strong id="initEdt"></strong></td>
                                                            <td><strong>Branch :</strong> &nbsp;&nbsp;<span
                                                                        id="brnmEdt"></span></td>
                                                            <td><strong>Group No :</strong> &nbsp;&nbsp;<span
                                                                        id="grnoEdt"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td width="118"><span id="cunoEdt"></span></td>
                                                            <td width="148">NIC: <strong><span
                                                                            id="anicEdt"></span></strong>
                                                            </td>
                                                            <td width="175"><strong>Center :</strong> &nbsp;&nbsp;<span
                                                                        id="cntrEdt"></span>
                                                            </td>
                                                            <td width="148"><strong>Type :</strong> &nbsp;&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4"><span id="hoadEdt"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4"><span id="mobiEdt"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="5">
                                                                <div class="table-responsive" style="display: block">
                                                                    <table width="100%"
                                                                           class="table table-bordered table-striped ">
                                                                        <thead>
                                                                        <tr>
                                                                            <th colspan="4" class="text-center"><strong>FACILITY
                                                                                    DETAILS</strong>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr id="trow_1">
                                                                            <td width="25%" class="text-left">Facility
                                                                                No
                                                                            </td>
                                                                            <td width="25%"><span id="acnoEdt"></span>
                                                                            </td>
                                                                            <td width="25%">Product</td>
                                                                            <td width="25%"><span id="prcdEdt"></span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr id="trow_2">
                                                                            <td>Facility Date</td>
                                                                            <td><span id="indtEdt2"></span></td>
                                                                            <td>Maturity Date</td>
                                                                            <td><span id="mddtEdt"></span></td>
                                                                        </tr>
                                                                        <tr id="trow_3">
                                                                            <td>Amount</td>
                                                                            <td><span id="loamEdt"></span></td>
                                                                            <td>Premium</td>
                                                                            <td><span id="instEdt"></span></td>
                                                                        </tr>
                                                                        <tr id="trow_4">
                                                                            <td>Settlement Today</td>
                                                                            <td><span id="tdstEdt"></span></td>
                                                                            <td>Status</td>
                                                                            <td><span id="stmtEdt"></span></td>
                                                                        </tr>
                                                                        <tr id="trow_5">
                                                                            <td>Over Payment</td>
                                                                            <td><span id="ovpeEdt"></span></td>
                                                                            <td></td>
                                                                            <td><span id="stmt22"></span></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <label class="col-md-8 control-label ">
                                                                        <a id="mrdtEdt" href="" target="_blank"
                                                                           style="color: red">View More Details... </a>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                    <!-- loan auid-->
                                                    <input type="hidden" id="lnauid" name="lnauid">
                                                    <!-- function edit or approval-->
                                                    <input type="hidden" id="func" name="func">
                                                    <!-- loan type product or dynamic-->
                                                    <input type="hidden" id="lontype" name="lontype">
                                                    <!-- applict auid -->
                                                    <input type="hidden" id="appidEdt" name="appidEdt">
                                                    <input type="hidden" id="lnidEdt" name="lnidEdt">        <!-- -->
                                                    <input type="hidden" id="cusBrnEdt" name="cusBrnEdt">
                                                    <input type="hidden" id="crnt_prtpEdt" name="crnt_prtpEdt">
                                                    <input type="hidden" id="setBalEdt" name="setBalEdt">
                                                    <input type="hidden" id="nicEdt" name="nicEdt">
                                                    <input type="hidden" id="nwlnBalEdt" name="nwlnBalEdt">

                                                </div>
                                                <div id="sts1Edt"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12" id="divgrntEdt">
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Guarantor Details
                                        </h3>
                                        <div class="form-group">
                                            <!-- <label class="col-md-4 col-xs-12 control-label">First Guarantor</label>-->
                                            <div class="col-md-6 col-xs-12">
                                                <input type="hidden" class="form-control text-uppercase"
                                                       id="grn1Edt"
                                                       name="grn1Edt" placeholder="NIC"
                                                       onkeyup="nicCheck(this.id,'gr1Edt')"/>
                                                <input type="hidden" id="fsgiEdt" name="fsgiEdt">
                                                <div id="sts2Edt"></div>
                                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                       id="tr2Edt">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="gr1ImgEdt"
                                                                     width="100" height="100"/></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2">
                                                            <strong><span id="grnm1Edt"></span> </strong>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="grno1Edt"></span></td>
                                                        <td width="129">NIC:
                                                            <strong id="gnic1Edt"></strong></td>
                                                        <td width="167"><span id="grlnac1Edt"></span><span
                                                                    id="grlnpn1Edt"></span>
                                                        </td>
                                                        <td width="175">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gadr1Edt"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gphn1Edt"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<label class="col-md-4 col-xs-12 control-label">Second Guarantor</label>-->
                                            <div class="col-md-6 col-xs-12">
                                                <input type="hidden" class="form-control text-uppercase"
                                                       id="grn2Edt"
                                                       name="grn2Edt" placeholder="NIC"
                                                       onkeyup="nicCheck(this.id,'gr2Edt')"/>
                                                <input type="hidden" id="segiEdt" name="segiEdt">
                                                <div id="sts3Edt"></div>
                                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                       id="tr3Edt">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="gr2ImgEdt"
                                                                     width="100" height="100"/></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2">
                                                            <strong><span id="grnm2Edt"></span> </strong>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="grno2Edt"></span></td>
                                                        <td width="129">NIC:
                                                            <strong id="gnic2Edt"></strong></td>
                                                        <td width="167"><span id="grlnac2Edt"></span><span
                                                                    id="grlnpn2Edt"></span>
                                                        </td>
                                                        <td width="175">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gadr2Edt"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gphn2Edt"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<label class="col-md-4 col-xs-12 control-label">Third Guarantor</label>-->
                                            <div class="col-md-6 col-xs-12">
                                                <input type="hidden" class="form-control text-uppercase"
                                                       id="grn3Edt"
                                                       name="grn3Edt" placeholder="NIC"
                                                       onkeyup="nicCheck(this.id,'gr3Edt')"/>
                                                <input type="hidden" id="thgiEdt" name="thgiEdt">
                                                <div id="sts4Edt"></div>
                                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                       id="tr4Edt">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="gr3ImgEdt"
                                                                     width="100" height="100"/></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2">
                                                            <strong><span id="grnm3Edt"></span> </strong>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="grno3Edt"></span></td>
                                                        <td width="129">NIC:
                                                            <strong id="gnic3Edt"></strong></td>
                                                        <td width="167"><span id="grlnac3Edt"></span><span
                                                                    id="grlnpn3Edt"></span>
                                                        </td>
                                                        <td width="175">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gadr3Edt"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gphn3Edt"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<label class="col-md-4 col-xs-12 control-label">Forth Guarantor</label>-->
                                            <div class="col-md-6 col-xs-12">
                                                <input type="hidden" class="form-control text-uppercase"
                                                       id="grn4Edt"
                                                       name="grn4Edt" placeholder="NIC"
                                                       onkeyup="nicCheck(this.id,'gr4Edt')"/>
                                                <input type="hidden" id="fogiEdt" name="fogiEdt">
                                                <div id="sts5Edt"></div>
                                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                       id="tr5Edt">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="gr4ImgEdt"
                                                                     width="100" height="100"/></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2">
                                                            <strong><span id="grnm4Edt"></span> </strong>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="grno4Edt"></span></td>
                                                        <td width="129">NIC:
                                                            <strong id="gnic4Edt"></strong></td>
                                                        <td width="167"><span id="grlnac4Edt"></span><span
                                                                    id="grlnpn4Edt"></span>
                                                        </td>
                                                        <td width="175">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gadr4Edt"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gphn4Edt"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <!--<label class="col-md-4 col-xs-12 control-label">Fifth Guarantor</label>-->
                                            <div class="col-md-6 col-xs-12">
                                                <input type="hidden" class="form-control text-uppercase"
                                                       id="grn5Edt"
                                                       name="grn5Edt" placeholder="NIC"
                                                       onkeyup="nicCheck(this.id,'gr5Edt')"/>
                                                <input type="hidden" id="figiEdt" name="figiEdt">
                                                <div id="sts6Edt"></div>
                                                <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                       id="tr6Edt">
                                                    <tbody>
                                                    <tr>
                                                        <td width="101" rowspan="4">
                                                            <a class="popup"
                                                               title="Click here to see the image..">
                                                                <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                     class="img-circle img-thumbnail" alt=""
                                                                     id="gr5ImgEdt"
                                                                     width="100" height="100"/></a></td>
                                                        <td width="10">&nbsp;</td>
                                                        <td colspan="2">
                                                            <strong><span id="grnm5Edt"></span> </strong>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td width="118"><span id="grno5Edt"></span></td>
                                                        <td width="129">NIC:
                                                            <strong id="gnic5Edt"></strong></td>
                                                        <td width="167"><span id="grlnac5Edt"></span><span
                                                                    id="grlnpn5Edt"></span>
                                                        </td>
                                                        <td width="175">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gadr5Edt"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td colspan="4" id="gphn5Edt"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-thumbs-o-up"></span> Facility Details</h3>

                                    <div class="col-md-6" id="prdBaseEdt">  <!-- product base -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTypEdt" id="prdTypEdt"
                                                        onchange="getLoanPrdtEdt(this.value,coll_brnEdt.value);chckBtn(this.value,'prdTypEdt')">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($prductinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="fcamtEdt" id="fcamtEdt"
                                                        onchange="getLoanDurEdt(this.value,'',prdTypEdt.value,coll_brnEdt.value)">
                                                    <option value="0"> Select Facility Amount</option>
                                                </select>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">No of Rental</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="duraEdt" id="duraEdt"
                                                        onchange="getInstalEdt()">
                                                    <option value="0"> Select Rental</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Installment</label>
                                            <div class="col-md-8 col-xs-6">
                                                <label class="col-md-3 col-xs-6 control-label"><span
                                                            id="insAmtEdt"> </span> </label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Balance Amount</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" id="blamtPrdEdt" readonly
                                                       name="blamtPrdEdt"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="dynamicEdt"> <!-- Dynamic -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdtpDynEdt" id="prdtpDynEdt"
                                                        onchange="abcEdt(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($dynamicprd as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="dyn_fcamtEdt"
                                                       onchange="calInstalEdt()"
                                                       name="dyn_fcamtEdt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group" id="dailyDivEdt" style="display: none">
                                            <!-- Only daily loan -->
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytpEdt" id="dytpEdt"
                                                        onchange="getLoanPrdtDynEdt(prdtpDynEdt.value,this.value)">
                                                    <option value="all"> xx</option>
                                                </select>
                                            </div>
                                        </div>  <!-- end Only daily loan -->

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_duraEdt" id="dyn_duraEdt"
                                                        onchange="calInstalEdt()">
                                                    <option value="all"> select Duration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Interest Rate</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dyn_inrtEdt" id="dyn_inrtEdt"
                                                        onchange="calInstalEdt()">
                                                    <option value="all"> Select Rate</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" readonly id="lnprimEdt"
                                                       name="lnprimEdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Balance Amount</label>
                                            <div class="col-md-8 col-xs-12">
                                                <input type="text" class="form-control" id="blamtDynEdt" readonly
                                                       name="blamtDynEdt"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Dynamic -->
                                    <input type="hidden" id="dyn_ttlintEdt" name="dyn_ttlintEdt">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="" id="indtEdt" name="indtEdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Distribute Date</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control datepicker"
                                                       value="" id="dsdtEdt" name="dsdtEdt"/>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Insurance Chg</label>
                                            <div class="col-md-4 col-xs-12">
                                                <input type="text" class="form-control" id="insuEdt"
                                                       name="insuEdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Document Chg</label>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="text" class="form-control" id="docuEdt"
                                                       name="docuEdt"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Charge Mode</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="crgmdEdt" id="crgmdEdt"
                                                        onchange="loanCurntBalEdt()">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Customer Pay</option>
                                                    <option value="2" selected>Debit From Loan</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Charging Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_brnEdt" id="coll_brnEdt"
                                                        onchange="getExe(this.value,'coll_ofcEdt',exc.value,'coll_cenEdt');chckBtn(this.value,'coll_brnEdt')">
                                                    <?php
                                                    foreach ($branchinfo as $branch) {
                                                        echo "<option value='$branch[brch_id]'>$branch[brch_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Credit Officer</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_ofcEdt" id="coll_ofcEdt"
                                                        onchange="getCenter(this.value,'coll_cenEdt',brch.value);chckBtn(this.value,'coll_ofcEdt')">
                                                    <?php
                                                    foreach ($execinfo as $exe) {
                                                        echo "<option value='$exe[exe_id]'>$exe[exe_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Center</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_cenEdt" id="coll_cenEdt">
                                                    <?php
                                                    foreach ($centinfo as $cen) {
                                                        echo "<option value='$cen[cen_id]'>$cen[cen_name]</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">Remarks</label>
                                            <div class="col-md-8 col-xs-12">
                                                <textarea class="form-control" rows="4" id="remkEdt"
                                                          name="remk"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="pull-left">Hint prid : <span id="prid"></span> </span>
                    <button type="submit" class="btn btn-success" id="edtBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit / approvel Model -->


</body>

<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbLoan').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });
        srchLoan();
        loanType();
        document.getElementById('tr1').style.display = "none";
        document.getElementById('tr2').style.display = "none";
        document.getElementById('tr3').style.display = "none";
        document.getElementById('tr4').style.display = "none";
        document.getElementById('tr5').style.display = "none";
        document.getElementById('tr6').style.display = "none";

        var exgr =  <?= $policyLoan[3]->pov2 ?>
        //console.log(exgr);
        if (exgr == 4) {
            $("#grn5").css("display", "none");
        } else if (exgr == 3) {
            $("#grn5,#grn4").css("display", "none");
        } else if (exgr == 2) {
            $("#grn5,#grn4,#grn3").css("display", "none");
        }

        // $.validator.setDefaults({ignore: ''});

        $("#loan_topup").validate({  // Product loan validation
            rules: {
                coll_brn: {
                    required: true,
                    notEqual: 'all',
                    equalTo: '#cusBrn',
                },
                coll_ofc: {
                    required: true,
                    notEqual: 'all'
                },
                coll_cen: {
                    required: true,
                    notEqual: 'all'
                },
                prdTyp: {
                    required: true,
                    notEqual: '0'
                },
                fcamt: {
                    notEqual: '0'
                },
                dura: {
                    notEqual: '0'
                },
                nic: {
                    required: true,
                    minlength: 10
                },

                // dyanamic loan
                grn1: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn2', '#grn3', '#grn4', '#grn5']
                },
                grn2: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn3', '#grn4', '#grn5']
                },
                grn3: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn4', '#grn5']
                },
                grn4: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn3', '#grn5']
                },
                grn5: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn3', '#grn4']
                },
                prdtpDyn: {
                    notEqual: '0'
                },
                dytp: {
                    notEqual: '0'
                },
                dyn_dura: {
                    notEqual: '0'
                },
                dyn_inrt: {
                    notEqual: '0'
                },
                dyn_fcamt: {
                    required: true,
                },
                crgmd: {
                    notEqual: '0'
                },
            },
            messages: {
                coll_brn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    equalTo: "Please select Customer branch",
                },
                coll_ofc: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer"
                },
                coll_cen: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center"
                },
                prdTyp: {
                    required: 'Select Product Type',
                    notEqual: "Select Product Type"
                },
                fcamt: {
                    notEqual: "Select Facility Amount"
                },
                dura: {
                    notEqual: "Select Rental"
                },
                nic: {
                    required: 'Enter Applicant NIC'
                },
                // Dyanamic loan
                grn1: {
                    required: 'Enter First Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn2: {
                    required: 'Enter Second Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn3: {
                    required: 'Enter Thired Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn4: {
                    required: 'Enter Fourth Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn5: {
                    required: 'Enter Firth Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                prdtpDyn: {
                    notEqual: "Select Product Type"
                },
                dytp: {
                    notEqual: "Select Day Type"
                },
                dyn_dura: {
                    notEqual: "Select Payment duration"
                },
                dyn_inrt: {
                    notEqual: 'Select Interest Rate'
                },
                dyn_fcamt: {
                    required: "Enter Facility Amount"
                },
                crgmd: {
                    notEqual: 'Select Charge Mode'
                },
            }
        });

        $("#loan_edt").validate({  // Product loan validation
            rules: {
                coll_brnEdt: {
                    required: true,
                    notEqual: 'all',
                    equalTo: '#cusBrnEdt',
                },
                coll_ofcEdt: {
                    required: true,
                    notEqual: 'all'
                },
                coll_cenEdt: {
                    required: true,
                    notEqual: 'all'
                },
                prdTypEdt: {
                    required: true,
                    notEqual: '0'
                },
                fcamtEdt: {
                    notEqual: '0'
                },
                duraEdt: {
                    notEqual: '0'
                },
//                nicEdt: {
//                    required: true,
//                },

                // dyanamic loan
                grn1Edt: {
                    required: true,
                    notEqual: '#nicEdt'
                },
                grn2Edt: {
                    required: true,
                    notEqual: '#nicEdt'
                },
                prdtpDynEdt: {
                    notEqual: '0'
                },
                dytpEdt: {
                    notEqual: '0'
                },
                dyn_duraEdt: {
                    notEqual: '0'
                },
                dyn_inrtEdt: {
                    notEqual: '0'
                },
                dyn_fcamtEdt: {
                    required: true,
                },

            },
            messages: {
                coll_brnEdt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                    equalTo: "Please select Customer branch",
                },
                coll_ofcEdt: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer"
                },
                coll_cenEdt: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center"
                },
                prdTypEdt: {
                    required: 'Select Product Type',
                    notEqual: "Select Product Type"
                },
                fcamtEdt: {
                    notEqual: "Select Facility Amount"
                },
                duraEdt: {
                    notEqual: "Select Rental"
                },
//                nicEdt: {
//                    required: 'Enter Applicant NIC'
//                },
                // Dyanamic loan
                grn1Edt: {
                    required: 'Enter First Guarantor NIC',
                    notEqual: "Please Check NIC",
                },
                grn2Edt: {
                    required: 'Enter Second Guarantor NIC',
                    notEqual: "Please select Branch",
                },
                prdtpDynEdt: {
                    notEqual: "Select Product Type"
                },
                dytpEdt: {
                    notEqual: "Select Day Type"
                },
                dyn_duraEdt: {
                    notEqual: "Select Payment duration"
                },
                dyn_inrtEdt: {
                    notEqual: 'Select Interest Rate'
                },
                dyn_fcamtEdt: {
                    required: "Enter Facility Amount"
                },
            }
        });
    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // IF LOAN NO VALIDATE
    function lnnoChck(lnno) {

        if (lnno.length == 19) {
            document.getElementById('lnno').style.borderColor = "#e6e8ed";

            getLoanDetails(lnno);
        } else {
            document.getElementById('lnno').focus();
            document.getElementById('lnno').style.borderColor = "red";
            $('#sts1').text("");
        }
    }

    var pocy_arag = "<?= $policyTpup[0]->pov3 ?>";    //  policy arres age
    var pocy_tner = "<?= $policyTpup[1]->pov3 ?>";    //  Teneer %
    var pocy_pydt = "<?= $policyTpup[2]->pov3 ?>";    //  policy paid %
    var pocy_tptg = "<?= $policyTpup[3]->post ?>";    //  policy topup category

    // GET VALID LOAN DETAILS
    function getLoanDetails(lnno) {

        $.ajax({
            url: '<?= base_url(); ?>user/vewTpupCustDtils',
            type: 'POST',
            data: {
                lnno: lnno
            },
            dataType: 'json',
            success: function (response) {

                var len = response['cudt'].length;

                if (len > 0) {
                    if (response['cudt'][0]['ttl'] == null) {

                        document.getElementById("cusDtilsDiv").style.display = 'block';
                        document.getElementById('tr1').style.display = "block";
                        document.getElementById("lnno").style.display = 'none';

                        document.getElementById("init").innerHTML = response['cudt'][0]['sode'] + response['cudt'][0]['init'];
                        document.getElementById("brnm").innerHTML = response['cudt'][0]['brnm'];
                        document.getElementById("grno").innerHTML = response['cudt'][0]['grno'];
                        document.getElementById("cuno").innerHTML = response['cudt'][0]['cuno'];
                        document.getElementById("anic").innerHTML = response['cudt'][0]['anic'];
                        document.getElementById("cntr").innerHTML = response['cudt'][0]['cnnm'];
                        document.getElementById("hoad").innerHTML = response['cudt'][0]['hoad'];
                        document.getElementById("mobi").innerHTML = response['cudt'][0]['mobi'];

                        document.getElementById('uimg').src = "../uploads/cust_profile/" + response['cudt'][0]['uimg'];
                        document.getElementById("uimgA").setAttribute("href", "../uploads/cust_profile/" + response['cudt'][0]['uimg']);

                        document.getElementById("lnid").value = response['cudt'][0]['lnid'];
                        document.getElementById('lnct').value = response['cudt'][0]['lcnt'];
                        document.getElementById("cusBrn").value = setVal;

                        document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response['cudt'][0]['acno']);

                        /* customer branch*/
                        document.getElementById("cusBrn").value = response['cudt'][0]['brco'];
                        /* customer auid*/
                        document.getElementById("appid").value = response['cudt'][0]['apid'];
                        /* customer nic*/
                        document.getElementById("nic").value = response['cudt'][0]['anic'];
                        /* customer current loan product type*/
                        document.getElementById("crnt_prtp").value = response['cudt'][0]['prdtp'];

                        //ARREARS AGE
                        // $arc = round(($rd2['aboc']+$rd2['aboi'])/$rd2['inam'],2);
                        // Math.round(num * 100) / 100
                        // var n = num.toFixed(2);
                        var arag = ((+response['pydt'][0]['aboc'] + +response['pydt'][0]['aboi']) / +response['pydt'][0]['inam']).toFixed(2);

                        //PAID MORE THAN 60 FROM TOTAL
                        //$arc1 = round(($rd2['ttl']/($rd2['noin']*$rd2['inam']))*100,2);
                        var pydt = ((+response['pydt'][0]['ttl'] / (+response['pydt'][0]['noin'] * +response['pydt'][0]['inam'])) * 100).toFixed(2);

                        // console.log(pocy_arag + ' **' + pocy_pydt + 'x' + pocy_tner + ' **' + pocy_tptg);
                        if (arag > pocy_arag) { // arrers age 2
                            document.getElementById("agdt").innerHTML = "<strong>Arrears Age : " + arag + " <br/>Selected Loan arrears age more than (2), This can't process and see the details </strong>";
                            document.getElementById("lnaddBtn").style.display = 'none';

                        } else if (pydt < pocy_pydt) { // pydt < '60.00' || pydt < '60.0'
                            document.getElementById("pydt").innerHTML = "<strong>Paid Total : " + pydt + "% <br/>Selected Loan should more than 60% of repayment total, This can't process and see the details <br/></strong> ";
                            document.getElementById("lnaddBtn").style.display = 'none';

                        } else {

                            grpMnbDtils(response['cudt'][0]['anic']);
                            document.getElementById("rtdt").innerHTML = 'rental details';

                            document.getElementById("lnaddBtn").style.display = 'block';
                            document.getElementById("fcdt").style.display = 'block';
                            document.getElementById("acno").innerHTML = response['cudt'][0]['acno'];
                            document.getElementById("prcd").innerHTML = '(' + response['cudt'][0]['prcd'] + ') ' + response['cudt'][0]['prnm'];
                            document.getElementById("indt").innerHTML = response['cudt'][0]['indt'];
                            document.getElementById("mddt").innerHTML = response['cudt'][0]['mddt'];
                            document.getElementById("loam").innerHTML = numeral(response['cudt'][0]['loam']).format('0,0.00');
                            document.getElementById("inst").innerHTML = numeral(response['cudt'][0]['inam']).format('0,0.00') + ' x ' + response['cudt'][0]['noin'];
                            var setVal = (+response['cudt'][0]['boc'] + +response['cudt'][0]['boi'] + +response['cudt'][0]['avpe']) - +response['cudt'][0]['avcr'];
                            document.getElementById("tdst").innerHTML = numeral(setVal).format('0,0.00');
                            document.getElementById("ovpe").innerHTML = numeral(response['cudt'][0]['avcr']).format('0,0.00');
                            document.getElementById("stmt").innerHTML = response['cudt'][0]['nxpn'] + ' of ' + response['cudt'][0]['noin'];

                            document.getElementById("setBal").value = setVal;

                            // COLLECTER DETAILS LOAD
                            document.getElementById('coll_brn').value = response['cudt'][0]['brco'];
                            document.getElementById('coll_ofc').value = response['cudt'][0]['clct'];
                            document.getElementById('coll_cen').value = response['cudt'][0]['ccnt'];
                            getExeEdit(response['cudt'][0]['brco'], 'coll_ofc', response['cudt'][0]['clct'], 'coll_cen');
                            getCenterEdit(response['cudt'][0]['clct'], 'coll_cen', response['cudt'][0]['brco'], response['cudt'][0]['ccnt']);
                        }

                    } else {
                        swal({title: "", text: "Allready Topup Requested.", type: "info"});
                    }

                } else {
                    document.getElementById("cusDtilsDiv").style.display = 'none';

                    document.getElementById("lnaddBtn").style.display = 'none';
                    swal({title: "", text: "Invalide Running Loan", type: "warning"});
                }
            },
        });

    }

    // SEARCH TOPUP LOAN
    function srchLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        var stat = document.getElementById('stat').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbLoan').DataTable().clear();
            $('#dataTbLoan').DataTable({
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
                    {className: "text-left", "targets": [1, 2, 3, 4]},
                    {className: "text-center", "targets": [0, 5, 8, 9, 10]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[4, "desc"]], //ASC  desc
                "aoColumns": [
                    {sWidth: '5%'},
                    {sWidth: '10%'},    // br/cnt
                    {sWidth: '10%'},
                    {sWidth: '10%'},    //cust no
                    {sWidth: '15%'},    // ln no
                    {sWidth: '5%'},     // prdt
                    {sWidth: '5%'},     // amount
                    {sWidth: '5%'},     // rental
                    {sWidth: '5%'},     // period
                    {sWidth: '5%'},
                    {sWidth: '15%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/searchTpupLoan',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        stat: stat
                    }
                }
            });
        }
    }

    // VIEW LOAN DETAILS
    function viewLoan(auid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewLoan",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("cno").innerHTML = response[i]['acno'];
                    document.getElementById("cusnic").innerHTML = response[i]['anic'];
                    document.getElementById("cusno").innerHTML = response[i]['cuno'];
                    document.getElementById("lntyp").innerHTML = response[i]['lntpnm'];
                    document.getElementById("lnamt").innerHTML = parseFloat(response[i]['loam']).toFixed(2);
                    document.getElementById("lninst").innerHTML = parseFloat(response[i]['inam']).toFixed(2);
                    document.getElementById("lndoc").innerHTML = parseFloat(response[i]['docg']).toFixed(2);
                    document.getElementById("insdt").innerHTML = response[i]['indt'];
                    document.getElementById("lnbrn").innerHTML = response[i]['brnm'];
                    document.getElementById("lncnt").innerHTML = response[i]['cnnm'];

                    document.getElementById("chrmd").innerHTML = response[i]['chrmd'];

                    document.getElementById("cunme").innerHTML = response[i]['init'];
                    document.getElementById("lnprd").innerHTML = response[i]['prna'];
                    document.getElementById("lnrnt").innerHTML = response[i]['lnpr'] + ' ' + response[i]['pymd']; // parseFloat( ).toFixed(2);
                    document.getElementById("lnins").innerHTML = parseFloat(response[i]['incg']).toFixed(2); // insurance
                    document.getElementById("disdt").innerHTML = response[i]['acdt']; //
                    document.getElementById("lnofc").innerHTML = response[i]['fnme'] + ' ' + response[i]['lnme'];

                    document.getElementById("lnsts").innerHTML = "<span class='label label-success'>  " + response[i]['stnm'] + "  </span>";


                }
            }
        })
    }

    // If check product loan or dyanamic loan
    function loanType() {
        if (document.getElementById('lntp').checked == true) {
            document.getElementById('prdBase').style.display = "block";
            document.getElementById('dynamic').style.display = "none";
            // document.getElementById('divgrnt').style.display = "none";

            document.getElementById('insu').readOnly = true;
            document.getElementById('docu').readOnly = true;
        } else {
            document.getElementById('dynamic').style.display = "block";
            // document.getElementById('divgrnt').style.display = "block";
            document.getElementById('prdBase').style.display = "none";

            document.getElementById('insu').readOnly = false;
            document.getElementById('docu').readOnly = false;
            document.getElementById('insu').value = '0';
            document.getElementById('docu').value = '0';
        }
    }

    // if check group loan or individual loan
    function loanCatType() {
        var lncat = document.getElementById('lncttp').checked == true;

        if (document.getElementById('lncttp').checked == true) {
            document.getElementById('divgrnt').style.display = "block";
            document.getElementById('divGrpmb').style.display = "none";

            document.getElementById('grnTyp').value = 0; // Individual granter
        } else {
            document.getElementById('divgrnt').style.display = "none";
            document.getElementById('divGrpmb').style.display = "block";

            document.getElementById('grnTyp').value = 1;// Group granter
        }
    }

    // NIC VALIDATION
    function nicCheck(id, cuid) { // id = NIC cuid = input box id

        var nicNo = document.getElementById(id).value;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById(id).style.borderColor = "#e6e8ed";
            getCustomerDetils(nicNo, cuid);
        } else if (nicNo.length == 12) {
            getCustomerDetils(nicNo, cuid);
            document.getElementById(id).style.borderColor = "#e6e8ed";

        } else {
            document.getElementById(id).focus();
            document.getElementById(id).style.borderColor = "red";
            $('#sts1').text("");
        }
    }

    // GET VALIDATE CUSTOMER DETAILS
    function getCustomerDetils(nicNo, cuid) {

        var nic = document.getElementById('nic').value;
        var grn1 = document.getElementById('grn1').value;
        var grn2 = document.getElementById('grn2').value;
        var grn3 = document.getElementById('grn3').value;
        var grn4 = document.getElementById('grn4').value;
        var grn5 = document.getElementById('grn5').value;

        //alert(cuid);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getCustDetils',
            data: {
                id: nicNo
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (cuid == 'aplic') {
                    if (len != 0) {
                        var cust = response[0]['stat'];

                        // if (response[0]['prln'] == null && (response[0]['pen'] + +response[0]['act']) > 0) {  // check parallel loan active or not
                        if (<?php echo $policyLoan[0]->post ?> == 0
                    )
                        {  // check parallel loan active or not

                            if ((response[0]['pen'] + +response[0]['act']) > 0) {
                                $('#sts1').html("<font color='red'>parallel loans is Not Allowed...</font>");
                                document.getElementById('lnaddBtn').disabled = true;

                            } else if (response[0]['rgtp'] == 0) {
                                $('#sts1').html("<font color='red'>Guarantor NIC ...</font>");
                                document.getElementById('lnaddBtn').disabled = true;

                            } else {
                                if (cust == 3 || cust == 4) {
                                    document.getElementById('nic').style.display = "none";
                                    document.getElementById('tr1').style.display = "block";

                                    // document.getElementById('prlPrd').value = response[0]['prpd']; // if parallal product value

                                    document.getElementById('appid').value = response[0]['cuid'];
                                    document.getElementById('coll_brn').value = response[0]['brco'];
                                    document.getElementById('coll_ofc').value = response[0]['exec'];
                                    document.getElementById('coll_cen').value = response[0]['ccnt'];
                                    document.getElementById('appimg').src = "../uploads/cust_profile/" + response[0]['uimg'];

                                    getExeEdit(response[0]['brco'], 'coll_ofc', response[0]['exec'], 'coll_cen');
                                    getCenterEdit(response[0]['exec'], 'coll_cen', response[0]['brco'], response[0]['ccnt']);

                                    $('#cunm').text(response[0]['sode'] + response[0]['init']);
                                    $('#cuno').text(response[0]['cuno']);
                                    $('#anic').text(response[0]['anic']);
                                    $('#adrs').text(response[0]['hoad']);
                                    $('#phne').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                                    if (response[0]['act'] > 0) {
                                        document.getElementById('lnst1').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                                    } else {
                                        document.getElementById('lnst1').innerHTML = " ";
                                    }
                                    if (response[0]['pen'] > 0) {
                                        document.getElementById('lnst2').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                                    } else {
                                        document.getElementById('lnst2').innerHTML = " ";
                                    }
                                    $('#sts1').html("");
                                    document.getElementById('lnaddBtn').disabled = false;

                                    grpMnbDtils(nicNo);

                                } else if (cust == 1) {
                                    $('#sts1').html("<font color='red'>Customer does not activated...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 5) {
                                    $('#sts1').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 11) {
                                    $('#sts1').html("<font color='red'>Customer has been close, contact admin...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 9) {
                                    $('#sts1').html("<font color='red'>Customer has been Transfer Requested...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 10) {
                                    $('#sts1').html("<font color='red'>Customer has been Pending Transfer...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                }
                            }

                        }
                    else
                        if (<?= $policyLoan[0]->post ?> == 1
                    )
                        {
                            if (response[0]['rgtp'] == 0) {
                                $('#sts1').html("<font color='red'>Guarantor NIC ...</font>");
                                document.getElementById('lnaddBtn').disabled = true;
                            } else {
                                if (cust == 3 || cust == 4) {
                                    document.getElementById('nic').style.display = "none";
                                    document.getElementById('tr1').style.display = "block";

                                    // document.getElementById('prlPrd').value = response[0]['prpd']; // if parallal product value

                                    document.getElementById('appid').value = response[0]['cuid'];
                                    document.getElementById('coll_brn').value = response[0]['brco'];
                                    document.getElementById('coll_ofc').value = response[0]['exec'];
                                    document.getElementById('coll_cen').value = response[0]['ccnt'];
                                    document.getElementById('appimg').src = "../uploads/cust_profile/" + response[0]['uimg'];

                                    getExeEdit(response[0]['brco'], 'coll_ofc', response[0]['exec'], 'coll_cen');
                                    getCenterEdit(response[0]['exec'], 'coll_cen', response[0]['brco'], response[0]['ccnt']);

                                    $('#cunm').text(response[0]['sode'] + response[0]['init']);
                                    $('#cuno').text(response[0]['cuno']);
                                    $('#anic').text(response[0]['anic']);
                                    $('#adrs').text(response[0]['hoad']);
                                    $('#phne').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                                    if (response[0]['act'] > 0) {
                                        document.getElementById('lnst1').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                                    } else {
                                        document.getElementById('lnst1').innerHTML = " ";
                                    }
                                    if (response[0]['pen'] > 0) {
                                        document.getElementById('lnst2').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                                    } else {
                                        document.getElementById('lnst2').innerHTML = " ";
                                    }
                                    $('#sts1').html("");
                                    document.getElementById('lnaddBtn').disabled = false;

                                    grpMnbDtils(nicNo);

                                } else if (cust == 1) {
                                    $('#sts1').html("<font color='red'>Customer does not activated...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 5) {
                                    $('#sts1').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 11) {
                                    $('#sts1').html("<font color='red'>Customer has been close, contact admin...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 9) {
                                    $('#sts1').html("<font color='red'>Customer has been Transfer Requested...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                } else if (cust == 10) {
                                    $('#sts1').html("<font color='red'>Customer has been Pending Transfer...</font>");
                                    document.getElementById('lnaddBtn').disabled = true;
                                }
                            }
                        }

//                    $("#det1").html(data).show('slow');
//                    $("#idn1, #idn2").hide('slow');
//                    if(aa1 == 3){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='red'>Customer running a loan...</font>");
//                    } else if(aa1 == 0){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
//                    } else if(aa1 == 2){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='red'>Customer does not activated...</font>");
//                    }	else if(aa1 == 4){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='red'>Customer have pending loan...</font>");
//                    }	else if(aa1 == 5){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
//                    } else if(aa1 == 6){
//                        $("#det1").hide('slow');
//                        $('#sts1').html("<font color='red'>Customer has been suspended Please check NIC...</font>");
//                    }
                    } else {
                        $('#sts1').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
//                    $('#insAmt').text("Invalid Product ");
//                    document.getElementById('insu').value = '0';
//                    document.getElementById('docu').value = '0';
                    }
                } else if (cuid == 'gr1') {
                    if (nic == nicNo || grn2 == nicNo || grn3 == nicNo || grn4 == nicNo || grn5 == nicNo) {
                        //$('#sts2').html("<font color='red'>Customer sdfsfdsfsd...</font>");
                    } else if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn1').style.display = "none";
                            document.getElementById('tr2').style.display = "block";

                            document.getElementById('fsgi').value = response[0]['cuid'];
                            $('#grnm1').text(response[0]['sode'] + response[0]['init']);
                            $('#grno1').text(response[0]['cuno']);
                            $('#gnic1').text(response[0]['anic']);
                            $('#gadr1').text(response[0]['hoad']);
                            $('#gphn1').text(response[0]['mobi'] + ' /' + response[0]['tele']);
                            document.getElementById('grn1Img').src = "../uploads/cust_profile/" + response[0]['uimg'];

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac1').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac1').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn1').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn1').innerHTML = " ";
                            }
                            $('#sts2').html("");
                        } else if (cust == 1) {
                            $('#sts2').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts2').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        } else if (cust == 11) {
                            $('#sts2').html("<font color='red'>Customer has been close, contact admin...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 9) {
                            $('#sts2').html("<font color='red'>Customer has been Transfer Requested...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 10) {
                            $('#sts2').html("<font color='red'>Customer has been Pending Transfer...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        }
                    } else {
                        $('#sts2').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr2') {
                    if (nic == nicNo || grn1 == nicNo || grn3 == nicNo || grn4 == nicNo || grn5 == nicNo) {

                    } else if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn2').style.display = "none";
                            document.getElementById('tr3').style.display = "block";

                            document.getElementById('segi').value = response[0]['cuid'];
                            $('#grnm2').text(response[0]['sode'] + response[0]['init']);
                            $('#grno2').text(response[0]['cuno']);
                            $('#gnic2').text(response[0]['anic']);
                            $('#gadr2').text(response[0]['hoad']);
                            $('#gphn2').text(response[0]['mobi'] + ' /' + response[0]['tele']);
                            document.getElementById('grn2Img').src = "../uploads/cust_profile/" + response[0]['uimg'];

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac2').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac2').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn2').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn2').innerHTML = " ";
                            }
                            $('#sts3').html("");
                        } else if (cust == 1) {
                            $('#sts3').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts3').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        } else if (cust == 11) {
                            $('#sts3').html("<font color='red'>Customer has been close, contact admin...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 9) {
                            $('#sts3').html("<font color='red'>Customer has been Transfer Requested...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 10) {
                            $('#sts3').html("<font color='red'>Customer has been Pending Transfer...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        }
                    } else {
                        $('#sts3').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr3') {
                    if (nic == nicNo || grn1 == nicNo || grn2 == nicNo || grn4 == nicNo || grn5 == nicNo) {

                    } else if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn3').style.display = "none";
                            document.getElementById('tr4').style.display = "block";

                            document.getElementById('thgi').value = response[0]['cuid'];
                            $('#grnm3').text(response[0]['sode'] + response[0]['init']);
                            $('#grno3').text(response[0]['cuno']);
                            $('#gnic3').text(response[0]['anic']);
                            $('#gadr3').text(response[0]['hoad']);
                            $('#gphn3').text(response[0]['mobi'] + ' /' + response[0]['tele']);
                            document.getElementById('grn3Img').src = "../uploads/cust_profile/" + response[0]['uimg'];

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac3').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac3').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn3').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn3').innerHTML = " ";
                            }
                            $('#sts4').html("");
                        } else if (cust == 1) {
                            $('#sts4').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts4').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        } else if (cust == 11) {
                            $('#sts4').html("<font color='red'>Customer has been close, contact admin...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 9) {
                            $('#sts4').html("<font color='red'>Customer has been Transfer Requested...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 10) {
                            $('#sts4').html("<font color='red'>Customer has been Pending Transfer...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        }
                    } else {
                        $('#sts4').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr4') {
                    if (nic == nicNo || grn1 == nicNo || grn2 == nicNo || grn3 == nicNo || grn5 == nicNo) {

                    } else if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn4').style.display = "none";
                            document.getElementById('tr5').style.display = "block";

                            document.getElementById('fogi').value = response[0]['cuid'];
                            $('#grnm4').text(response[0]['sode'] + response[0]['init']);
                            $('#grno4').text(response[0]['cuno']);
                            $('#gnic4').text(response[0]['anic']);
                            $('#gadr4').text(response[0]['hoad']);
                            $('#gphn4').text(response[0]['mobi'] + ' /' + response[0]['tele']);
                            document.getElementById('grn4Img').src = "../uploads/cust_profile/" + response[0]['uimg'];

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac4').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac4').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn4').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn4').innerHTML = " ";
                            }
                            $('#sts5').html("");
                        } else if (cust == 1) {
                            $('#sts5').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts5').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        } else if (cust == 11) {
                            $('#sts5').html("<font color='red'>Customer has been close, contact admin...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 9) {
                            $('#sts5').html("<font color='red'>Customer has been Transfer Requested...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 10) {
                            $('#sts5').html("<font color='red'>Customer has been Pending Transfer...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        }
                    } else {
                        $('#sts5').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr5') {
                    if (nic == nicNo || grn1 == nicNo || grn2 == nicNo || grn3 == nicNo || grn4 == nicNo) {

                    } else if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn5').style.display = "none";
                            document.getElementById('tr6').style.display = "block";

                            document.getElementById('figi').value = response[0]['cuid'];
                            $('#grnm5').text(response[0]['sode'] + response[0]['init']);
                            $('#grno5').text(response[0]['cuno']);
                            $('#gnic5').text(response[0]['anic']);
                            $('#gadr5').text(response[0]['hoad']);
                            $('#gphn5').text(response[0]['mobi'] + ' /' + response[0]['tele']);
                            document.getElementById('grn5Img').src = "../uploads/cust_profile/" + response[0]['uimg'];

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac5').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac5').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn5').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn5').innerHTML = " ";
                            }
                            $('#sts6').html("");
                        } else if (cust == 1) {
                            $('#sts6').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts6').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        } else if (cust == 11) {
                            $('#sts6').html("<font color='red'>Customer has been close, contact admin...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 9) {
                            $('#sts6').html("<font color='red'>Customer has been Transfer Requested...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else if (cust == 10) {
                            $('#sts6').html("<font color='red'>Customer has been Pending Transfer...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        }
                    } else {
                        $('#sts6').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                }
            },
        });
    }

    // GROUP MEMBERS DETAILS SHOW
    function grpMnbDtils(nicNo) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getgrpMnbDtilsTpup',
            data: {
                apid: nicNo
            },
            dataType: 'json',
            success: function (response) {
                var len = response['mnber'].length;
                var arr = response['grnte'];

                document.getElementById('grntLen').value = len;
                //console.log(response['grnte'][0]);
                for (var i = 0; i < len; i++) {
                    if (i < 10) {
                        if (jQuery.inArray(response['mnber'][i]['cuid'], arr) !== -1) {
                            document.getElementById("axx" + i).innerHTML = "<div class='list-group-item'>" +
                                "<div class='list-group-status status-online'></div>" +
                                "<img src='../uploads/cust_profile/" + response['mnber'][i]['uimg'] + "'  class='pull-left' title='Granter image'>" +
                                "<span class='contacts-title'>" + response['mnber'][i]['sode'] + '' + response['mnber'][i]['init'] + ' | ' + response['mnber'][i]['anic'] + "</span>" +
                                "<p>" + response['mnber'][i]['cuno'] + ' | ' + response['mnber'][i]['mobi'] + ' | Grantor Loans' + "  <lable class='label label-info'>" + response['mnber'][i]['grcnt'] + "</lable>" + "</p>" +
                                "<div class='list-group-controls'>" +
                                "<input type='hidden' name='grid[" + i + "]'  value=" + response['mnber'][i]['cuid'] + " />" +
                                "<input type='checkbox' name='addm[" + i + "]' value=" + response['mnber'][i]['cuid'] + " id='checkbox[]'  class='icheckbox' checked  /></div></div> ";

                        } else {
                            document.getElementById("axx" + i).innerHTML = "<div class='list-group-item'>" +
                                "<div class='list-group-status status-online'></div>" +
                                "<img src='../uploads/cust_profile/" + response['mnber'][i]['uimg'] + "'  class='pull-left' title='Granter image'>" +
                                "<span class='contacts-title'>" + response['mnber'][i]['sode'] + '' + response['mnber'][i]['init'] + ' | ' + response['mnber'][i]['anic'] + "</span>" +
                                "<p>" + response['mnber'][i]['cuno'] + ' | ' + response['mnber'][i]['mobi'] + ' | Grantor Loans' + "  <lable class='label label-info'>" + response['mnber'][i]['grcnt'] + "</lable>" + "</p>" +
                                "<div class='list-group-controls'>" +
                                "<input type='hidden' name='grid[" + i + "]'  value=" + response['mnber'][i]['cuid'] + " />" +
                                "<input type='checkbox' name='addm[" + i + "]' value=" + response['mnber'][i]['cuid'] + " id='checkbox[]'  class='icheckbox'  /></div></div> ";
                        }
                    }
                }
            },
        });
    }

    function grnCount() {
        var cunt = $('[class="icheckbox"]:checked').length;
        document.getElementById('grnCunt').value = cunt;
    }

    // ************ product base **********
    function getLoanPrdt(prdtp) {  // load Facility Amount
        var brnc = document.getElementById('coll_brn').value;
        var lnct = document.getElementById('lnct').value;
        //console.log(lnct);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanProductTpup',
            data: {
                prdtp: prdtp,
                brnc: brnc,
                lnct: lnct,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                // if check top up loan type with system policy
                if (pocy_tptg == 0) {  // same product category

                    var crnt_prtp = document.getElementById("crnt_prtp").value;
                    if (crnt_prtp != prdtp) {   // current running loan product category != selected product category
                        $('#fcamt').empty();
                        $('#fcamt').append("<option value='0'> Any Product Type Not Allowed..</option>");

                        document.getElementById("fcamt").style.borderColor = 'red';

                    } else {
                        document.getElementById("fcamt").style.borderColor = '';
                        if (len != 0) {
                            $('#fcamt').empty();
                            $('#fcamt').append("<option value='0'>Select Facility </option>");
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['lamt'];
                                var name = response[i]['lamt'];
                                var $el = $('#fcamt');
                                $el.append($("<option></option>")
                                    .attr("value", id).text(name));
                            }
                        } else {
                            $('#fcamt').empty();
                            $('#fcamt').append("<option value='0'>No Facility</option>");
                        }
                    }

                } else {// any product category
                    if (len != 0) {
                        $('#fcamt').empty();
                        $('#fcamt').append("<option value='0'>Select Facility </option>");
                        for (var i = 0; i < len; i++) {
                            var id = response[i]['lamt'];
                            var name = response[i]['lamt'];
                            var $el = $('#fcamt');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#fcamt').empty();
                        $('#fcamt').append("<option value='0'>No Facility</option>");
                    }
                }
            },
        });
    }

    function getLoanDur(fcamt) { // Load Loan weeks
        var pdtp = document.getElementById('prdTyp').value;
        var brnc = document.getElementById('coll_brn').value;
        var lnct = document.getElementById('lnct').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanPeriodTpup',
            data: {
                fcamt: fcamt,
                pdtp: pdtp,
                brnc: brnc,
                lnct: lnct
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>Select Rental </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['nofr'] + '  | ' + response[i]['prcd'];
                        var $el = $('#dura');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>No Rental</option>");
                }
            },
        });
    }

    function getInstal() { // Load Loan instalment & Charges
        var dura = document.getElementById('dura').value;
        var cuid = document.getElementById('appid').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanInstalTpup',
            data: {
                id: dura,
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['lndt'].length;
                //console.log(<?php echo $policyLoan[1]->post ?>);

                // if check parallel product allow or not
                if (<?= $policyLoan[1]->post ?> == 1
                )
                {
                    document.getElementById('lnaddBtn').disabled = false;
                    if (len != 0) {
                        $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                        document.getElementById('insu').value = response['lndt'][0]['insc'];
                        document.getElementById('docu').value = response['lndt'][0]['docc'];

                        // NEW LOAN TTL VALUE
                        //document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                        document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'];
                        loanCurntBal();

                    } else {
                        $('#insAmt').text(" - ");
                        document.getElementById('insu').value = '0';
                        document.getElementById('docu').value = '0';
                        document.getElementById('blamtPrd').value = '';
                    }
                }
                else
                {
                    if (response['cudt'].length != 0) {
                        if (response['cudt'][0]['prid'] == dura) {
                            $('#insAmt').html("<font color='red'>parallel Product Not Allowed...</font>");
                            document.getElementById('lnaddBtn').disabled = true;
                        } else {
                            document.getElementById('lnaddBtn').disabled = false;
                            if (len != 0) {
                                $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                                document.getElementById('insu').value = response['lndt'][0]['insc'];
                                document.getElementById('docu').value = response['lndt'][0]['docc'];

                                // NEW LOAN TTL VALUE
                                //document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                                document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'];
                                loanCurntBal();

                            } else {
                                $('#insAmt').text(" - ");
                                document.getElementById('insu').value = '0';
                                document.getElementById('docu').value = '0';
                                document.getElementById('blamtPrd').value = '';
                            }
                        }
                    } else {
                        document.getElementById('lnaddBtn').disabled = false;
                        if (len != 0) {
                            $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                            document.getElementById('insu').value = response['lndt'][0]['insc'];
                            document.getElementById('docu').value = response['lndt'][0]['docc'];

                            // NEW LOAN TTL VALUE
                            //document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                            document.getElementById('nwlnBal').value = +response['lndt'][0]['lamt'];
                            loanCurntBal();

                        } else {
                            $('#insAmt').text(" - ");
                            document.getElementById('insu').value = '0';
                            document.getElementById('docu').value = '0';
                            document.getElementById('blamtPrd').value = '';
                        }
                    }
                }
            },
        });
    }

    // CHARGE MODE WISE LOAN BALACE CALCULATION
    function loanCurntBal() { // NEW LOAN TTL BALNCE

        var setBal = document.getElementById('setBal').value;       // TOPUP BALANCE
        var chtp = document.getElementById('crgmd').value;          // 1 - cust pay / 2 -debit loan
        var ins = document.getElementById('insu').value;            // INS CHRGE
        var doc = document.getElementById('docu').value;            // doc chrge
        var lntp = document.getElementById('lntp').value;           // Loan type

        if (document.getElementById('lntp').checked == true) { // PRODUCT LOAN

            var nwlnBal = document.getElementById('nwlnBal').value;     // NEW LOAN BALANCE

            if (chtp == 1) {
                var curnt_bal = numeral(+nwlnBal - +setBal).format('0.00');
            } else {
                var curnt_bal = numeral((+nwlnBal - (+setBal + +ins + +doc))).format('0.00');
            }
            //console.log(curnt_bal + ' ' + nwlnBal + ' ' + setBal + " " + ins + ' ' + doc);
            document.getElementById('blamtPrd').value = curnt_bal;

        } else {    // DYANAMIC LOAN

            var lnamt = document.getElementById('dyn_fcamt').value;      // Loan Amount
            var lnint = document.getElementById('dyn_ttlint').value;     // Loan Total Int

            //var nwlnBal = +lnamt + +lnint;
            var nwlnBal = +lnamt;

            if (chtp == 1) {
                var curnt_bal = numeral(+nwlnBal - +setBal).format('0.00');
            } else {
                var curnt_bal = numeral((+nwlnBal - (+setBal + +ins + +doc))).format('0.00');
            }

            //console.log('nwlnBal ' + nwlnBal + ' setBal ' + setBal + ' ins ' + ins + ' doc ' + doc);
            //console.log(curnt_bal + ' *** ' + lnamt + ' ' + lnint + ' ' + setBal + " " + ins + ' ' + doc);
            document.getElementById('blamtDyn').value = curnt_bal;
        }
        if (curnt_bal <= 0) {
            document.getElementById('lnaddBtn').disabled = true;
        } else {
            document.getElementById('lnaddBtn').disabled = false;
        }

    }


    // *********** Dynamic product **********
    function abc(prtp) {
        document.getElementById('dyn_fcamt').value = "";
        document.getElementById('lnprim').value = "";

        if (prtp == 6) {
            document.getElementById('dailyDiv').style.display = "block";

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>user/getDyType',
                data: {
                    prtp: prtp
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
            getLoanPrdtDyn(prtp, 0, 'add');
        }
    }

    function abcEdt(prtp, lcat) {
        if (prtp == 6) {
            document.getElementById('dailyDivEdt').style.display = "block";

            $.ajax({
                type: 'POST',
                url: '<?= base_url(); ?>user/getDyType',
                data: {
                    prtp: prtp
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
            // getLoanPrdtDynEdt(prtp, 0);
        }
    }

    function getLoanPrdtDyn(prdtp, daytp) {  // load duration and int rate

        if (prdtp == 6) {
            var x = " Days";
        } else if (prdtp == 7) {
            var x = " Weeks";
        } else if (prdtp == 8) {
            var x = " Months";
        } else if (prdtp == 9) {

        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getDynaPeriod',
            data: {
                prdtp: prdtp,
                daytp: daytp
            },
            dataType: 'json',
            success: function (response) {
                var len = response['nofr'].length;
                var len2 = response['rate'].length;

                if (len != 0) {
                    $('#dyn_dura').empty();
                    $('#dyn_dura').append("<option value='0'>Select Duration </option>");
                    for (var i = 0; i < len; i++) {

                        if (prdtp == 6) {
                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
                        } else {
                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x;
                        }

                        var $el = $('#dyn_dura');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#dyn_dura').empty();
                    $('#dyn_dura').append("<option value='0'>No Duration</option>");
                }

                if (len2 != 0) {
                    $('#dyn_inrt').empty();
                    $('#dyn_inrt').append("<option value='0'>Select Rate </option>");
                    for (var i = 0; i < len2; i++) {
                        var id = response['rate'][i]['inra'];
                        var name = response['rate'][i]['inra'] + ' %';
                        var $el = $('#dyn_inrt');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#dyn_inrt').empty();
                    $('#dyn_inrt').append("<option value='0'>No Rate</option>");
                }
            },
        });
    }

    function getLoanPrdtDynEdt(prdtp, daytp, noin, inra) {  // load duration and int rate

        if (prdtp == 6) {
            var x = " Days";
        } else if (prdtp == 7) {
            var x = " Weeks";
        } else if (prdtp == 8) {
            var x = " Months";
        } else if (prdtp == 9) {

        }

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getDynaPeriod',
            data: {
                prdtp: prdtp,
                daytp: daytp
            },
            dataType: 'json',
            success: function (response) {
                var len = response['nofr'].length;
                var len2 = response['rate'].length;


                if (len != 0) {
                    $('#dyn_duraEdt').empty();
                    $('#dyn_duraEdt').append("<option value='0'>Select Duration </option>");
                    for (var i = 0; i < len; i++) {

                        if (prdtp == 6) {
                            // var id = response['nofr'][i]['infm'];  කලින් තිබුන එක, product cat tb change එකෙන් පස්සේ change කරන ලදී.
                            var id = response['nofr'][i]['nofr'];
                            var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
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

                if (len2 != 0) {
                    $('#dyn_inrtEdt').empty();
                    $('#dyn_inrtEdt').append("<option value='0'>Select Rate </option>");
                    for (var i = 0; i < len2; i++) {
                        var id = response['rate'][i]['inra'];
                        var name = response['rate'][i]['inra'] + ' %';
                        var $el = $('#dyn_inrtEdt');
                        if (inra == id) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#dyn_inrtEdt').empty();
                    $('#dyn_inrtEdt').append("<option value='0'>No Rate</option>");
                }
            },
        });
    }

    function getLoanDur222(fcamt) { // Load Loan weeks
        var pdtp = document.getElementById('prdTyp').value;
        var brnc = document.getElementById('coll_brn').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanPeriodTpup',
            data: {
                fcamt: fcamt,
                pdtp: pdtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>Select Rental </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['nofr'];
                        var $el = $('#dura');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#dura').empty();
                    $('#dura').append("<option value='0'>No Rental</option>");
                }
            },
        });
    }

    function PMT(ir, np, pv, fv, type) {
        // follow the mng_product PMT function
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
    function calInstal(typ) {
        var lnamt = document.getElementById('dyn_fcamt').value;     // loan amount
        var noins = document.getElementById('dyn_dura').value;     // no of installment
        var inrt = document.getElementById('dyn_inrt').value;       // interest rate

        var prtp = document.getElementById('prdtpDyn').value;       // product type
        var dytp = document.getElementById('dytp').value;       // product type

        // console.log(mm);
        if (prtp == 6) { // Dynamic DL

            if (dytp == 5) {
                var dts = <?= $policyinfo[0]->pov1 ?>;
            } else if (dytp == 6) {
                var dts = <?= $policyinfo[0]->pov2 ?>;
            } else if (dytp == 7) {
                var dts = <?= $policyinfo[0]->pov3 ?>;
            }
            //$prm = round(($lam+((($lam*$inr)/100)*$mnth))/$qty,-1);
            //$prm = round(($lam + ((($lam * $inr) / 100) * ($mpd / 30))) / (($mpd / 30) * $dts), -1);

            var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);
            var aa = ( ((+noins / 30) * +dts) * (Math.ceil(mm / 10) * 10)  ) - +lnamt;

        } else if (prtp == 7) { // Dynamic WK
            // $lam = //LOAN AMOUNT
            // $qty = //MONTHS
            // $inr = ///INTERST
            // $mnth=($qty/4);
            // $prm = round(($lam+ ((($lam*$inr)/100)*$mnth)) /$qty,2);

            var mnth = (+noins / 4);
            var mm = (+lnamt + (((+lnamt * +inrt) / 100) * +mnth)) / +noins;
            var aa = ((+lnamt * +inrt) / 100) * +mnth;

        } else if (prtp == 8) { //Dynamic ML
            //var mm = -PMT((inrt / 100), noins, lnamt);
            //var aa = (+mm * +noins) - lnamt;

            // var mm = -PMT((inrt / 100), noins, lnamt);
            // var aa = (+mm * +noins) - lnamt;
            /* PMT CANCEL REQUEST BY MR SAJAYA 2018/08/21 */
            var xx = (+lnamt * +inrt) / 100;
            var aa = (+xx * +noins);            // TOTAL INTEREST
            var ttl = (+aa + +lnamt);
            var mm = (+ttl / +noins);           // PREMIUM
            // console.log('int ' + aa + 'inst ' + mm + 'ttl ' + ttl);

        } else if (prtp == 9) { // Dynamic Sp

        }

        //document.getElementById('lnprim').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
        //document.getElementById('dyn_ttlint').value = numeral(aa).format('0.00');

        document.getElementById('lnprim').value = numeral(mm).format('0.0000');             // PREMIUM
        document.getElementById('dyn_ttlint').value = numeral(aa).format('0.0000');         // TOTAL INTEREST

        loanCurntBal();
    }

    function calInstalEdt() {
        var lnamt = document.getElementById('dyn_fcamtEdt').value;     // loan amount
        var noins = document.getElementById('dyn_duraEdt').value;     // no of installment
        var inrt = document.getElementById('dyn_inrtEdt').value;       // interest rate

        var prtp = document.getElementById('prdtpDynEdt').value;       // product type
        var dytp = document.getElementById('dytpEdt').value;       // product type

        // console.log(mm);
        if (prtp == 6) { // Dynamic DL

            if (dytp == 5) {
                var dts = 22;
            } else if (dytp == 6) {
                var dts = 26;
            } else if (dytp == 7) {
                var dts = 30;
            }
            //$prm = round(($lam+((($lam*$inr)/100)*$mnth))/$qty,-1);
            //$prm = round(($lam + ((($lam * $inr) / 100) * ($mpd / 30))) / (($mpd / 30) * $dts), -1);

            var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);
            var aa = ( ((+noins / 30) * +dts) * (Math.ceil(mm / 10) * 10)  ) - +lnamt;

        } else if (prtp == 7) { // Dynamic WK
            // $lam = //LOAN AMOUNT
            // $qty = //MONTHS
            // $inr = ///INTERST
            // $mnth=($qty/4);
            // $prm = round(($lam+ ((($lam*$inr)/100)*$mnth)) /$qty,2);

            var mnth = (+noins / 4);
            var mm = (+lnamt + (((+lnamt * +inrt) / 100) * +mnth)) / +noins;
            var aa = ((+lnamt * +inrt) / 100) * +mnth;

        } else if (prtp == 8) { //Dynamic ML
            var mm = -PMT((inrt / 100), noins, lnamt);
            var aa = (+mm * +noins) - lnamt;

        } else if (prtp == 9) { // Dynamic Sp

        }

        document.getElementById('lnprimEdt').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
        document.getElementById('dyn_ttlintEdt').value = numeral(aa).format('0.00');

        loanCurntBal();
    }
    // *********** End Dynamic product **********

    // LOAN TOPUP SUBMIT
    $("#loan_topup").submit(function (e) { // add form
        e.preventDefault();
        grnCount();
        var grnTyp = document.getElementById("grnTyp").value;
        var grnCunt = document.getElementById("grnCunt").value;

        //console.log(grnTyp + '**' + grnCunt);

        if (grnTyp == 1) {
            if (grnCunt >= <?= $policyLoan[2]->pov1 ?> && grnCunt <= <?= $policyLoan[2]->pov2 ?> ) {
                // if(grnCunt >= 1 && grnCunt <= 3 ){
                if ($("#loan_topup").valid()) {
                    $('#modalAdd').modal('hide');
                    var jqXHR = jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>user/addLntopup",
                        data: $("#loan_topup").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            swal({title: "", text: "Topup Loan Added Success!", type: "success"},
                                function () {
                                    location.reload();
                                });
                        },
                        error: function (data, textStatus) {
                            swal({title: "Topup Loan Added Failed", text: textStatus, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                }
            } else {
                swal("", "Guarantor count not match with policy  ", "warning");
            }

        } else {
            if ($("#loan_topup").valid()) {
                $('#modalAdd').modal('hide');
                var jqXHR = jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>user/addLntopup",
                    data: $("#loan_topup").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        swal({title: "", text: "Topup Loan Added Success!", type: "success"},
                            function () {
                                location.reload();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Topup Loan Added Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        }
    });

    // LOAN EDIT DATA LOAD
    function edtLoan(auid, typ) {
        if (typ == 'viw') {
            $('#hed').text("View Topup Loan");
            document.getElementById('edtBtn').setAttribute("class", "hidden");

            $('input[type="text"], textarea').attr("readonly", true);
            $("select").attr("disabled", true);

        } else if (typ == 'edt') {
            $('#hed').text("Update Topup Loan");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';
            document.getElementById('edtBtn').setAttribute("class", "btn btn-success");

            //$('input[type="text"], textarea').attr('readonly', false);
            $("select").attr("disabled", false)

        } else if (typ == 'app') {
            $('#hed').text("Approval Topup Loan");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = '2';
            document.getElementById('edtBtn').setAttribute("class", "btn btn-success");

            //$('input[type="text"], textarea').attr('readonly', false);
            $("select").attr("disabled", false)

        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewTpupLoanEdt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {

                document.getElementById("prid").innerHTML = response['lndt'][0]['prid'] + ' lnid :' + auid;

                // LOAD GRANTER AND FACILITY DETAILS
                document.getElementById("lnauid").value = response['lndt'][0]['lnid'];
                document.getElementById("lnno5").innerHTML = response['lndt'][0]['acno'];
                document.getElementById("lontype").value = response['lndt'][0]['lntp']; // loan type hide

                if (response['lndt'][0]['lntp'] == 1) { // product loan
                    document.getElementById("lntpEdt").checked = true; // product
                    /// document.getElementById("divgrntEdt").style.display = "none";
                    document.getElementById("dynamicEdt").style.display = "none";
                    document.getElementById("prdBaseEdt").style.display = "block";

                } else { // dyanamic loan
                    document.getElementById("lntpEdt").checked = false;
                    //  document.getElementById("divgrntEdt").style.display = "block";
                    document.getElementById("dynamicEdt").style.display = "block";
                    document.getElementById("prdBaseEdt").style.display = "none";
                }

                if (response['lndt'][0]['grtp'] == 1) { // group granter
                    document.getElementById("lncttpEdt").checked = false;
                } else {  // indv granter
                    document.getElementById("lncttpEdt").checked = true;
                }

                document.getElementById("appidEdt").value = response['lndt'][0]['apid'];
                $('#cunmEdt').text(response['lndt'][0]['ainit']);
                $('#cunoEdt').text(response['lndt'][0]['acuno']);
                $('#anicEdt').text(response['lndt'][0]['aanic']);
                $('#adrsEdt').text(response['lndt'][0]['ahoad']);
                $('#phneEdt').text(response['lndt'][0]['amobi']);

                if (response['lndt'][0]['fsgi'] == 0) {
                    document.getElementById('tr2Edt').style.display = "none";
                } else if (response['lndt'][0]['fsgi'] != 0) {
                    document.getElementById('tr2Edt').style.display = "block";

                    // document.getElementById("grn1Edt").value = response['lndt'][0]['banic'];
                    document.getElementById("fsgiEdt").value = response['lndt'][0]['fsgi'];
                    $('#grnm1Edt').text(response['lndt'][0]['binit']);
                    $('#grno1Edt').text(response['lndt'][0]['bcuno']);
                    $('#gnic1Edt').text(response['lndt'][0]['banic']);
                    $('#gadr1Edt').text(response['lndt'][0]['bhoad']);
                    $('#gphn1Edt').text(response['lndt'][0]['bmobi']);
                    document.getElementById('gr1ImgEdt').src = "../uploads/cust_profile/" + response['lndt'][0]['buimg'];

                }
                if (response['lndt'][0]['segi'] == 0) {
                    document.getElementById('tr3Edt').style.display = "none";
                } else if (response['lndt'][0]['segi'] != 0) {
                    document.getElementById('tr3Edt').style.display = "block";

                    // document.getElementById("grn1Edt").value = response['lndt'][0]['banic'];
                    document.getElementById("segiEdt").value = response['lndt'][0]['segi'];
                    $('#grnm2Edt').text(response['lndt'][0]['cinit']);
                    $('#grno2Edt').text(response['lndt'][0]['ccuno']);
                    $('#gnic2Edt').text(response['lndt'][0]['canic']);
                    $('#gadr2Edt').text(response['lndt'][0]['choad']);
                    $('#gphn2Edt').text(response['lndt'][0]['cmobi']);
                    document.getElementById('gr2ImgEdt').src = "../uploads/cust_profile/" + response['lndt'][0]['cuimg'];

                }
                if (response['lndt'][0]['thgi'] == 0) {
                    document.getElementById('tr4Edt').style.display = "none";
                } else if (response['lndt'][0]['thgi'] != 0) {
                    document.getElementById('tr4Edt').style.display = "block";
                    // document.getElementById("grn1Edt").value = response['lndt'][0]['banic'];
                    document.getElementById("thgiEdt").value = response['lndt'][0]['thgi'];
                    $('#grnm3Edt').text(response['lndt'][0]['dinit']);
                    $('#grno3Edt').text(response['lndt'][0]['dcuno']);
                    $('#gnic3Edt').text(response['lndt'][0]['danic']);
                    $('#gadr3Edt').text(response['lndt'][0]['dhoad']);
                    $('#gphn3Edt').text(response['lndt'][0]['dmobi']);
                    document.getElementById('gr3ImgEdt').src = "../uploads/cust_profile/" + response['lndt'][0]['duimg'];

                }
                if (response['lndt'][0]['fogi'] == 0) {
                    document.getElementById('tr5Edt').style.display = "none";
                } else if (response['lndt'][0]['fogi'] != 0) {
                    document.getElementById('tr5Edt').style.display = "block";

                }
                if (response['lndt'][0]['figi'] == 0) {
                    document.getElementById('tr6Edt').style.display = "none";
                }
                else if (response['lndt'][0]['figi'] != 0) {

                }

                // if product loan
                if (response['lndt'][0]['lntp'] == 1) {
                    $('#insAmtEdt').text(response['lndt'][0]['inam']);
                    document.getElementById("prdTypEdt").value = response['lndt'][0]['prdtp'];
                    document.getElementById("fcamtEdt").value = response['lndt'][0]['loam'];
                    document.getElementById("duraEdt").value = response['lndt'][0]['lnpr'];

                    getLoanPrdtEdt(response['lndt'][0]['prdtp'], response['lndt'][0]['brco'], response['lndt'][0]['loam']);
                    getLoanDurEdt(response['lndt'][0]['loam'], response['lndt'][0]['lnpr'], response['lndt'][0]['prdtp'], response['lndt'][0]['brco']);

                    // CUSTOMER PAY
                    if (response['lndt'][0]['chmd'] == 1) {
                        var bal = +response['lndt'][0]['loam'] - +response['cudt'][0]['blam']; //+response['lndt'][0]['inta']
                    } else {
                        var bal = +response['lndt'][0]['loam'] - +response['cudt'][0]['blam'] - +response['lndt'][0]['docg'] - +response['lndt'][0]['incg']; //+ +response['lndt'][0]['inta']
                    }
                    //console.log(bal);
                    document.getElementById("blamtPrdEdt").value = bal;

                } else { // dynamic loan
                    document.getElementById("prdtpDynEdt").value = response['lndt'][0]['prdtp'];
                    document.getElementById("dyn_fcamtEdt").value = response['lndt'][0]['loam'];
                    document.getElementById("dytpEdt").value = response['lndt'][0]['lcat'];

                    document.getElementById("dyn_duraEdt").select = response['lndt'][0]['lnpr'];
                    document.getElementById("dyn_inrtEdt").value = response['lndt'][0]['lnpr'];
                    document.getElementById("lnprimEdt").value = response['lndt'][0]['inam'];

                    abcEdt(response['lndt'][0]['prdtp'], response['lndt'][0]['lcat']);
                    getLoanPrdtDynEdt(response['lndt'][0]['prdtp'], response['lndt'][0]['lcat'], response['lndt'][0]['lnpr'], response['lndt'][0]['inra']);

                    // CUSTOMER PAY
                    if (response['lndt'][0]['chmd'] == 1) {
                        var bal = +response['lndt'][0]['loam'] - +response['cudt'][0]['blam']; //+ +response['lndt'][0]['inta']
                    } else {
                        var bal = +response['lndt'][0]['loam'] - +response['cudt'][0]['blam'] - +response['lndt'][0]['docg'] - +response['lndt'][0]['incg']; //+ +response['lndt'][0]['inta']
                    }
                    //console.log(response['lndt'][0]['chmd'] + '**' + bal);
                    document.getElementById("blamtDynEdt").value = bal;
                }

                document.getElementById("dyn_ttlintEdt").value = response['lndt'][0]['inta'];

                document.getElementById("indtEdt").value = response['lndt'][0]['indt'];
                document.getElementById("dsdtEdt").value = response['lndt'][0]['acdt'];

                document.getElementById("insuEdt").value = response['lndt'][0]['incg'];
                document.getElementById("docuEdt").value = response['lndt'][0]['docg'];
                document.getElementById("crgmdEdt").value = response['lndt'][0]['chmd'];

                document.getElementById("coll_brnEdt").value = response['lndt'][0]['brco'];
                document.getElementById("coll_ofcEdt").value = response['lndt'][0]['clct'];
                document.getElementById("coll_cenEdt").value = response['lndt'][0]['ccnt'];

                // for auto load officer & center
                getExeEdit(response['lndt'][0]['brco'], 'coll_ofcEdt', response['lndt'][0]['clct'], 'coll_cenEdt');
                getCenterEdit(response['lndt'][0]['clct'], 'coll_cenEdt', response['lndt'][0]['brco'], response['lndt'][0]['ccnt']);

                // APPLICTI DATA LOAD
                document.getElementById("initEdt").innerHTML = response['cudt'][0]['sode'] + response['cudt'][0]['init'];
                document.getElementById("brnmEdt").innerHTML = response['cudt'][0]['brnm'];
                document.getElementById("grnoEdt").innerHTML = response['cudt'][0]['grno'];
                document.getElementById("cunoEdt").innerHTML = response['cudt'][0]['cuno'];
                document.getElementById("anicEdt").innerHTML = response['cudt'][0]['anic'];
                document.getElementById("cntrEdt").innerHTML = response['cudt'][0]['cnnm'];
                document.getElementById("hoadEdt").innerHTML = response['cudt'][0]['hoad'];
                document.getElementById("mobiEdt").innerHTML = response['cudt'][0]['mobi'];

                document.getElementById('appimgEdt').src = "../uploads/cust_profile/" + response['cudt'][0]['uimg'];
                document.getElementById("appimgEdtA").setAttribute("href", "../uploads/cust_profile/" + response['cudt'][0]['uimg']);

                document.getElementById("lnidEdt").value = response['cudt'][0]['lnid'];

                document.getElementById("mrdtEdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response['cudt'][0]['acno']);

                document.getElementById("acnoEdt").innerHTML = response['cudt'][0]['acno'];
                document.getElementById("prcdEdt").innerHTML = '(' + response['cudt'][0]['prcd'] + ') ' + response['cudt'][0]['prnm'];
                document.getElementById("indtEdt2").innerHTML = response['cudt'][0]['indt'];
                document.getElementById("mddtEdt").innerHTML = response['cudt'][0]['mddt'];
                document.getElementById("loamEdt").innerHTML = numeral(response['cudt'][0]['loam']).format('0,0.00');
                document.getElementById("instEdt").innerHTML = numeral(response['cudt'][0]['inam']).format('0,0.00') + ' x ' + response['cudt'][0]['noin'];
                //var setVal = (+response['cudt'][0]['boc'] + +response['cudt'][0]['boi'] + +response['cudt'][0]['aboc'] + +response['cudt'][0]['aboi'] + +response['cudt'][0]['avpe']) - +response['cudt'][0]['avcr'];
                document.getElementById("tdstEdt").innerHTML = numeral(response['cudt'][0]['blam']).format('0,0.00');
                document.getElementById("ovpeEdt").innerHTML = numeral(response['cudt'][0]['avcr']).format('0,0.00');
                document.getElementById("stmtEdt").innerHTML = response['cudt'][0]['nxpn'] + ' of ' + response['cudt'][0]['noin'];

                document.getElementById("setBalEdt").value = response['cudt'][0]['blam'];
                document.getElementById("nwlnBalEdt").value = +response['lndt'][0]['loam']; //+ +response['lndt'][0]['inta']

                /* customer branch*/
                document.getElementById("cusBrnEdt").value = response['cudt'][0]['brco'];
                /* customer auid*/
                document.getElementById("appidEdt").value = response['cudt'][0]['apid'];
                /* customer nic*/
                document.getElementById("nicEdt").value = response['cudt'][0]['anic'];
                /* customer current loan product type*/
                document.getElementById("crnt_prtpEdt").value = response['cudt'][0]['prdtp'];

            }
        })
    }

    function getLoanPrdtEdt(prdtp, brnc, loam) {  // load Facility Amount
        //var brnc = document.getElementById('coll_brnEdt').value;
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanProductTpup',
            data: {
                prdtp: prdtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#fcamtEdt').empty();
                    $('#fcamtEdt').append("<option value='0'>Select Facility </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['lamt'];
                        var name = response[i]['lamt'];
                        var $el = $('#fcamtEdt');
                        if (name == loam) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }

                    }
                } else {
                    $('#fcamtEdt').empty();
                    $('#fcamtEdt').append("<option value='0'>No Facility</option>");
                    $('#duraEdt').empty();
                    $('#duraEdt').append("<option value='0'>No Rental</option>");
                }
            },
        });
    }

    function getLoanDurEdt(fcamt, lnpr, pdtp, brnc) { // Load Loan weeks
        // var pdtp = document.getElementById('prdTypEdt').value;
        // var brnc = document.getElementById('coll_brnEdt').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanPeriodTpup',
            data: {
                fcamt: fcamt,
                pdtp: pdtp,
                brnc: brnc
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len != 0) {
                    $('#duraEdt').empty();
                    $('#duraEdt').append("<option value='0'>Select Rental </option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['auid'];
                        var name = response[i]['nofr'];
                        var $el = $('#duraEdt');
                        if (lnpr == name) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    }
                } else {
                    $('#duraEdt').empty();
                    $('#duraEdt').append("<option value='0'>No Rental</option>");
                }
            },
        });
    }

    var policyLoan = <?= $policyLoan[1]->post ?>;

    function getInstalEdt() { // Load product instalment & Charges
        var id = document.getElementById('duraEdt').value;
        var cuid = document.getElementById('appidEdt').value;

        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getLoanInstalTpup',
            data: {
                id: id,
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                // if check parallel product allow or not
                if (policyLoan == 1) {
                    document.getElementById('edtBtn').disabled = false;
                    if (len != 0) {
                        $('#insAmtEdt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                        document.getElementById('insuEdt').value = response['lndt'][0]['insc'];
                        document.getElementById('docuEdt').value = response['lndt'][0]['docc'];

                        // NEW LOAN TTL VALUE
                        //document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                        document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'];
                        loanCurntBalEdt();

                    } else {
                        $('#insAmtEdt').text("Invalid Product ");
                        document.getElementById('insuEdt').value = '0';
                        document.getElementById('docuEdt').value = '0';
                        document.getElementById('blamtPrdEdt').value = '';
                    }
                } else {
                    if (response['cudt'].length != 0) {
                        if (response['cudt'][0]['prid'] == dura) {
                            $('#insAmt').html("<font color='red'>parallel Product Not Allowed...</font>");
                            document.getElementById('edtBtn').disabled = true;
                        } else {
                            document.getElementById('edtBtn').disabled = false;
                            if (len != 0) {
                                $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                                document.getElementById('insuEdt').value = response['lndt'][0]['insc'];
                                document.getElementById('docuEdt').value = response['lndt'][0]['docc'];

                                // NEW LOAN TTL VALUE
                                //document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                                document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'];
                                loanCurntBalEdt();

                            } else {
                                $('#insAmt').text(" - ");
                                document.getElementById('insuEdt').value = '0';
                                document.getElementById('docuEdt').value = '0';
                                document.getElementById('blamtPrdEdt').value = '';
                            }
                        }
                    } else {
                        document.getElementById('edtBtn').disabled = false;
                        if (len != 0) {
                            $('#insAmt').text(numeral(response['lndt'][0]['rent']).format('0,0.00'));
                            document.getElementById('insuEdt').value = response['lndt'][0]['insc'];
                            document.getElementById('docuEdt').value = response['lndt'][0]['docc'];

                            // NEW LOAN TTL VALUE
                            //document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'] + +response['lndt'][0]['inta'];
                            document.getElementById('nwlnBalEdt').value = +response['lndt'][0]['lamt'];
                            loanCurntBalEdt();

                        } else {
                            $('#insAmt').text(" - ");
                            document.getElementById('insuEdt').value = '0';
                            document.getElementById('docuEdt').value = '0';
                            document.getElementById('blamtPrdEdt').value = '';
                        }
                    }
                }
            },
        });
    }

    // CHARGE MODE WISE LOAN BALACE CALCULATION EDIT
    function loanCurntBalEdt() { // NEW LOAN TTL BALNCE

        var setBal = document.getElementById('setBalEdt').value;       // TOPUP BALANCE
        var chtp = document.getElementById('crgmdEdt').value;          // 1 - cust pay / 2 -debit loan
        var ins = document.getElementById('insuEdt').value;            // INS CHRGE
        var doc = document.getElementById('docuEdt').value;            // doc chrge
        var lntp = document.getElementById('lontype').value;           // Loan type

        if (lntp == 1) { //
            var nwlnBal = document.getElementById('nwlnBalEdt').value;     // NEW LOAN BALANCE

            if (chtp == 1) {
                var curnt_bal = numeral(+nwlnBal - +setBal).format('0.00');
            } else {
                var curnt_bal = numeral((+nwlnBal - ( +setBal + +ins + +doc))).format('0.00');
            }
            document.getElementById('blamtPrdEdt').value = curnt_bal;
        } else {
            var lnamt = document.getElementById('dyn_fcamtEdt').value;      // Loan Amount
            var lnint = document.getElementById('dyn_ttlintEdt').value;     // Loan Total Int

            var nwlnBal = +lnamt + +lnint;
//            var nwlnBal = +lnamt ;

            if (chtp == 1) {
                var curnt_bal = numeral(+nwlnBal - +setBal).format('0.00');
            } else {
                var curnt_bal = numeral((+nwlnBal - (+setBal + +ins + +doc))).format('0.00');
            }
            document.getElementById('blamtDynEdt').value = curnt_bal;
        }
        if (curnt_bal <= 0) {
            document.getElementById('edtBtn').disabled = true;
        } else {
            document.getElementById('edtBtn').disabled = false;
        }
    }

    $("#loan_edt").submit(function (e) { // edit form
        e.preventDefault();

        var func = document.getElementById("func").value;
        if ($("#loan_edt").valid()) {
            if (func == 1) {
                $.ajax({
                    url: '<?= base_url(); ?>user/topupLoan_edt',
                    type: 'POST',
                    data: $("#loan_edt").serialize(),
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        $('#modalEdt').modal('hide');
                        swal({title: "success", text: "Loan Update success!", type: "success"},
                            function () {
                                location.reload();
                            });
                    },
                    error: function (data, jqXHR, textStatus, errorThrown) {
                        swal({title: "Loan update failed", type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            } else if (func == 2) {
                swal({
                        title: "Are you sure Approval ?",
                        text: "",
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
                            document.getElementById("edtBtn").disabled = true;
                            $('#modalEdt').modal('hide');
                            swal.close();

                            $.ajax({
                                url: '<?= base_url(); ?>user/topupLoan_edt',
                                type: 'POST',
                                data: $("#loan_edt").serialize(),
                                dataType: 'json',
                                success: function (data, textStatus, jqXHR) {

                                    srchLoan();
                                    document.getElementById("edtBtn").disabled = false;
                                    swal({title: "", text: "Loan Approval success!", type: "success"},
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function (data, textStatus, jqXHR) {
                                    document.getElementById("edtBtn").disabled = false;
                                    swal({
                                        title: "Loan Approval Failed",
                                        text: "Check again and contact system admin.. ",
                                        type: "error"
                                    }, function () {
                                        location.reload();
                                    });
                                }
                            });
                        } else {
                            swal("Cancelled", " ", "error");
                        }
                    });
            } else {
                alert("contact admin")
            }
        } else {
            //  alert("Error");
        }
    });

    // TOPUP REJECT
    function rejecLoan(id) {
        swal({
                title: "Are you sure?",
                text: "Your will not be able to recover this Loan",
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
                        url: '<?= base_url(); ?>user/rejTopLoan',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            srchLoan();
                            swal("Rejected!", "Loan Reject Success", "success");
                        },
                        error: function (response) {
                            swal({
                                    title: "",
                                    text: "Check again and contact system admin.. ",
                                    type: "error"
                                },
                            );
                        }
                    });

                } else {
                    swal("Cancelled!", "Loan Not Rejected", "error");
                }
            });
    }

    // AGREEMENT REPRINT
    function tpupAgrmPrint(lnid) {

        swal({
            title: "Please wait...",
            text: "Agreement generating..",
            //imageUrl: "<?= base_url() ?>assets/dist/img/loading.gif",
            showConfirmButton: false
        });
        setTimeout(function () {
            window.open('<?= base_url() ?>user/tpup_agrmnt_print/' + lnid, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
            swal.close(); // Hide the loading message
            srchLoan();
        }, 1000);

    }

    $("#cler").click(function (e) {
        location.reload();

        // $('#modalAdd').modal('show');
        // $('#modalAdd').removeData('bs.modal');
    })

</script>












