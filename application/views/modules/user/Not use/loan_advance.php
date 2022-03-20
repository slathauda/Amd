<body>
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>Loan Module</li>
    <li class="active">Advance Loan</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>Advance Loan </strong></h3>
                    <?php if ($funcPerm[0]->inst == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" id="newLoan"
                                data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> New Loan
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
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" placeholder="date"
                                           id="frdt" name="frdt" value="<?= date("Y-m-d"); ?>"/>
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
                                <label class="col-md-4 col-xs-6 control-label">To Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker" placeholder="date"
                                           id="todt" name="todt" value="<?= date("Y-m-d"); ?>"/>
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
                                           id="dataTbadvnLoan" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">BRANCH /CENTER</th>
                                            <th class="text-center">CUSTOMER NAME</th>
                                            <th class="text-center">CUST NO</th>
                                            <th class="text-center">LOAN NO</th>
                                            <th class="text-center">PRDT</th>
                                            <th class="text-center">AMOUNT</th>
                                            <th class="text-center">RENTAL</th>
                                            <th class="text-center">PERIOD</th>
                                            <th class="text-center">MODE</th>
                                            <th class="text-center">DATE</th>
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
    <div class="modal-dialog modal-lg" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Create New Advance Loan
                </h4>
            </div>
            <form class="form-horizontal" id="adlnAdd" name="adlnAdd"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left"> Down Payment
                                                    Loan</label>
                                                <div class="col-md-3">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch" value="1" id="lntp"
                                                               name="lntp" onclick="loanType()" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-4 control-label text-left">Interest Free
                                                    Loan</label>
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
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Applicant Details
                                        </h3>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <input type="text" class="form-control text-uppercase" id="nic"
                                                           name="nic" placeholder="Applicant NIC" autocomplete="off"
                                                           autofocus
                                                           onkeyup="nicCheck(this.id,'aplic')"/>
                                                    <div id="sts1"></div>
                                                    <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                           id="tr1">
                                                        <tbody>
                                                        <tr>
                                                            <td width="101" rowspan="4">
                                                                <a class="popup"
                                                                   title="Click here to see the image..">
                                                                    <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                         class="img-circle img-thumbnail" alt=""
                                                                         id="appimg"
                                                                         width="100" height="100"/></a></td>
                                                            <td width="10">&nbsp;</td>
                                                            <td colspan="2">
                                                                <strong><span id="cunm"></span> </strong>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td width="118"><span id="cuno"></span></td>
                                                            <input type="hidden" id="appid" name="appid">
                                                            <input type="hidden" id="prlPrd" name="prlPrd">
                                                            <input type="hidden" id="lnct" name="lnct">


                                                            <td width="129">NIC:
                                                                <strong id="anic"></strong></td>
                                                            <td width="167"><span id="lnst1"></span><span
                                                                        id="lnst2"></span>
                                                            </td>
                                                            <td width="175">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4" id="adrs"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4" id="phne"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row" id="divLstcmnt" style="display: none">
                                                <div class="form-group">
                                                    <label class="col-md-3 col-xs-6 control-label"
                                                           style="color: darkorange"> Comment</label>
                                                    <label class="col-md-9 col-xs-6 control-label">
                                                        <span id="lscmnt"> </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12" id="prvsDiv" style="display: none;">
                                                    <table class="table table-bordered  table-actions" id="prvstb">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Loan No</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
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

                                    <!-- INTEREST FREE -->
                                    <div class="col-md-6" id="intFree">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTyp" id="prdTyp"
                                                        onchange="abc(this.value)">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($intprdinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="fcamt"
                                                       onchange="calInstal()" onkeyup="calInstal()"
                                                       name="fcamt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Hidden Value </label>
                                            <div class="col-md-3 col-xs-3">
                                                <label class="switch switch-small">
                                                    <input id="hid" name="hid" type="checkbox" value="1"
                                                           onchange="hidenVal();calInstal()"/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                            <div class="col-md-4 col-xs-3" id="hidnVal" style="display: none">
                                                <span id="rbdv" style="display: inline-block;">
                                                <input type="text" class="form-control" placeholder="Hidden Value"
                                                       id="hdvl" name="hdvl" onchange="calInstal()"
                                                       onkeyup="calInstal()">
                                                </span>
                                            </div>
                                        </div>

                                        <!-- DAIELY TYPE -->
                                        <div class="form-group" id="dailyDiv" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytp" id="dytp"
                                                        onchange="getLoanPrdtDyn(prdTyp.value,this.value)">
                                                    <option value="0"> --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- END DAIELY TYPE -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment Duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inpr" id="inpr"
                                                        onchange="calInstal()">
                                                    <option value="0"> select Duration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="lnprim" readonly
                                                       name="lnprim"/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ttlint" name="ttlint">
                                    </div>
                                    <!-- END INTEREST FREE -->

                                    <!-- DOWN PAYMENT LOAN -->
                                    <div class="col-md-6" id="dwnPymt">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTyp_dp" id="prdTyp_dp"
                                                        onchange="abc(this.value);calInstal()">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($dwnprdinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="fcamt_dp"
                                                       onchange="calInstal()" onkeyup="calInstal()"
                                                       name="fcamt_dp" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Down Payment </label>
                                            <div class="col-md-3 col-xs-3">
                                                <label class="switch switch-small">
                                                    <input id="dwp" name="dwp" type="checkbox" value="1"
                                                           onchange="downPymt();calInstal()"/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                            <div class="col-md-4 col-xs-3" id="dwnVal" style="display: none">
                                                <span id="rbdv" style="display: inline-block;">
                                                <input type="text" class="form-control" placeholder="Down Payment"
                                                       id="dwpy" name="dwpy" onchange="calInstal()"
                                                       onkeyup="calInstal()">
                                                </span>
                                            </div>
                                        </div>

                                        <!-- DAIELY TYPE -->
                                        <div class="form-group" id="dailyDiv_dp" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytp_dp" id="dytp_dp"
                                                        onchange="getLoanPrdtDyn(prdTyp_dp.value,this.value)">
                                                    <option value="0"> --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- END DAIELY TYPE -->

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment Duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inpr_dp" id="inpr_dp"
                                                        onchange="calInstal()">
                                                    <option value="0"> select Duration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="rateDiv">
                                            <label class="col-md-4 col-xs-6 control-label">Interest Rate</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inrt_dp" id="inrt_dp"
                                                        onchange="calInstal()">
                                                    <option value="0"> Select Rate</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="lnprim_dp" readonly
                                                       name="lnprim_dp"/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ttlint_dp" name="ttlint_dp">
                                    </div>
                                    <!-- END DOWN PAYMENT LOAN -->

                                    <!-- Date & Charge -->
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
                                                       name="insu"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Document Chg</label>
                                            <div class="col-md-4 col-xs-6">
                                                <input type="text" class="form-control" id="docu"
                                                       name="docu"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Charge Mode</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="crgmd" id="crgmd">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Customer Pay</option>
                                                    <option value="2" selected>Debit From Loan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Rental cal Type</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="cltp" id="cltp">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Redusing</option>
                                                    <option value="2" selected>Flat Rate</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Date & Charge -->
                                </div>

                                <!-- Charging Details -->
                                <div class="panel-body">
                                    <h3 class="text-title"><span class="fa fa-bookmark"></span> Charging Details</h3>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Branch</label>
                                            <div class="col-md-6 col-xs-6">
                                                <select class="form-control" name="coll_brn" id="coll_brn"
                                                        onchange="getExe(this.value,'coll_ofc',exc.value,'coll_cen');">
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
                                                        onchange="getCenter(this.value,'coll_cen',brch.value)">
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
                                <!-- End Charging Details-->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" id="cler">Clear</button>
                    <button type="submit" class="btn btn-success" id="lnaddBtn">Submit</button>
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
                <span class="pull-left">Hint prid : <span id="prid"></span> </span>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Edit / approvel -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"> </span> <span id="lnno5"> </span></h4>
            </div>
            <form class="form-horizontal" id="advnLoanEdt" name="advnLoanEdt" enctype="multipart/form-data"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label text-left">Down Payment
                                                    Loan </label>
                                                <div class="col-md-3">
                                                    <label class="switch">
                                                        <input type="checkbox" class="switch" value="1" id="lntpEdt"
                                                               disabled
                                                               name="lntpEdt" onclick="" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-4 control-label text-left">Interest Free
                                                    Loan </label>
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
                                <input type="hidden" id="lnauid" name="lnauid">
                                <input type="hidden" id="func" name="func">
                                <input type="hidden" id="lontype" name="lontype">
                                <div class="panel-body">
                                    <!-- <h3 class="text-title"><span class="fa fa-bookmark"></span> Customer Details</h3>-->
                                    <div class="col-md-6">
                                        <h3 class="text-title"><span class="fa fa-bookmark"></span> Applicant Details
                                        </h3>
                                        <div class="form-group">

                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <div id="sts1Edt"></div>
                                                    <table width="700" border="0" cellpadding="0" cellspacing="0"
                                                           id="tr1Edt">
                                                        <tbody>
                                                        <tr>
                                                            <td width="101" rowspan="4">
                                                                <a class="popup" href=""
                                                                   id="appimgEdtA"
                                                                   title="Click here to see the image..">
                                                                    <img src="<?= base_url() ?>assets/images/users/1.jpg"
                                                                         class="img-circle img-thumbnail" alt=""
                                                                         id="appimgEdt"
                                                                         width="100" height="100"/></a></td>
                                                            <td width="10">&nbsp;</td>
                                                            <td colspan="2">
                                                                <strong><span id="cunmEdt"></span> </strong>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td width="118"><span id="cunoEdt"></span></td>
                                                            <input type="hidden" id="appidEdt" name="appidEdt">
                                                            <td width="129">NIC:
                                                                <strong id="anicEdt"></strong></td>
                                                            <td width="167"><span id="lnst1Edt"></span><span
                                                                        id="lnst2Edt"></span>
                                                            </td>
                                                            <td width="175">&nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4" id="adrsEdt"></td>
                                                        </tr>
                                                        <tr>
                                                            <td>&nbsp;</td>
                                                            <td colspan="4" id="phneEdt"></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <br>
                                            <div class="row">
                                                <div class="col-md-12 col-xs-12" id="prvsDivEdt"
                                                     style="display: none;">
                                                    <table class="table table-bordered  table-actions" id="prvstbEdt">
                                                        <thead>
                                                        <tr>
                                                            <th class="text-center">Loan No</th>
                                                            <th class="text-center">Status</th>
                                                            <th class="text-center">Remarks</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>

                                                    </table>
                                                </div>
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


                                    <!-- INTEREST FREE -->
                                    <div class="col-md-6" id="intFreEdt">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTypEdt" id="prdTypEdt"
                                                        onchange="abcEdt(this.value,'');calInstalEdt()">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($intprdinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="fcamtEdt"
                                                       onchange="calInstalEdt()" onkeyup="calInstalEdt()"
                                                       name="fcamtEdt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Hidden Value </label>
                                            <div class="col-md-3 col-xs-3">
                                                <label class="switch switch-small">
                                                    <input id="hidEdt" name="hidEdt" type="checkbox" value="1"
                                                           onchange="hidenValEdt();calInstalEdt()"/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                            <div class="col-md-4 col-xs-3" id="hidnValEdt" style="display: none">
                                                <span id="rbdv" style="display: inline-block;">
                                                <input type="text" class="form-control" placeholder="Hidden Value"
                                                       id="hdvlEdt" name="hdvlEdt"
                                                       onchange="calInstalEdt();calInstalEdt()">
                                                </span>
                                            </div>
                                        </div>

                                        <!-- DAIELY TYPE -->
                                        <div class="form-group" id="dailyDivEdt" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytpEdt" id="dytpEdt"
                                                        onchange="getLoanPrdtDynEdt(prdTypEdt.value,this.value,'')">
                                                    <option value="0"> --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- END DAIELY TYPE -->
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment Duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inprEdt" id="inprEdt"
                                                        onchange="calInstalEdt()">
                                                    <option value="0"> select Duration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="lnprimEdt" readonly
                                                       name="lnprimEdt"/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ttlintEdt" name="ttlintEdt">
                                    </div>
                                    <!-- END INTEREST FREE -->

                                    <!-- DOWN PAYMENT LOAN -->
                                    <div class="col-md-6" id="dwnPymtEdt">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Product Type</label>
                                            <div class="col-md-8 col-xs-12">
                                                <select class="form-control" name="prdTyp_dpEdt" id="prdTyp_dpEdt"
                                                        onchange="abcEdt(this.value);calInstalEdt()">
                                                    <option value="0"> Select Product Type</option>
                                                    <?php
                                                    foreach ($dwnprdinfo as $prduct) {
                                                        echo "<option value='$prduct->prid'>$prduct->prna </option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Facility Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="fcamt_dpEdt"
                                                       onchange="calInstalEdt()" onkeyup="calInstalEdt()"
                                                       name="fcamt_dpEdt" placeholder="Amount"/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Down Payment </label>
                                            <div class="col-md-3 col-xs-3">
                                                <label class="switch switch-small">
                                                    <input id="dwpEdt" name="dwpEdt" type="checkbox" value="1"
                                                           onchange="downPymtEdt();calInstalEdt()"/>No
                                                    <span></span>
                                                </label> Yes
                                            </div>
                                            <div class="col-md-4 col-xs-3" id="dwnValEdt" style="display: none">
                                                <span id="rbdv" style="display: inline-block;">
                                                <input type="text" class="form-control" placeholder="Down Payment"
                                                       id="dwpyEdt" name="dwpyEdt" onchange="calInstalEdt()"
                                                       onkeyup="calInstalEdt()">
                                                </span>
                                            </div>
                                        </div>

                                        <!-- DAIELY TYPE -->
                                        <div class="form-group" id="dailyDiv_dpEdt" style="display: none">
                                            <label class="col-md-4 col-xs-6 control-label">Day Type</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="dytp_dpEdt" id="dytp_dpEdt"
                                                        onchange="getLoanPrdtDyn(prdTyp_dp.value,this.value)">
                                                    <option value="0"> --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- END DAIELY TYPE -->

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Payment Duration</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inpr_dpEdt" id="inpr_dpEdt"
                                                        onchange="calInstalEdt()">
                                                    <option value="0"> select Duration</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="rateDiv">
                                            <label class="col-md-4 col-xs-6 control-label">Interest Rate</label>
                                            <div class="col-md-8 col-xs-6">
                                                <select class="form-control" name="inrt_dpEdt" id="inrt_dpEdt"
                                                        onchange="calInstalEdt()">
                                                    <option value="0"> Select Rate</option>

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4  col-xs-6 control-label">Premium Amount</label>
                                            <div class="col-md-8 col-xs-6">
                                                <input type="text" class="form-control" id="lnprim_dpEdt" readonly
                                                       name="lnprim_dpEdt"/>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ttlint_dpEdt" name="ttlint_dpEdt">
                                    </div>
                                    <!-- END DOWN PAYMENT LOAN -->

                                    <!-- DATES & CHARGES -->
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
                                                <select class="form-control" name="crgmdEdt" id="crgmdEdt">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Customer Pay</option>
                                                    <option value="2" selected>Debit From Loan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Rental Cal Type</label>
                                            <div class="col-md-4 col-xs-6">
                                                <select class="form-control" name="cltpEdt" id="cltpEdt">
                                                    <option value="0"> Select Mode</option>
                                                    <option value="1">Redusing</option>
                                                    <option value="2" selected>Flat Rate</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- DATES & CHARGES -->

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
                                            <label class="col-md-3 col-xs-12 control-label">Comment</label>
                                            <div class="col-md-8 col-xs-12">
                                                <textarea class="form-control" rows="2" id="remkEdt"
                                                          name="remkEdt" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 col-xs-12 control-label">New Comment</label>
                                            <div class="col-md-8 col-xs-12">
                                                <textarea class="form-control" rows="2" id="remkNew"
                                                          name="remkNew"></textarea>
                                                <label>
                                                    <a id="mrdt" href="" target="_blank" style="color: red"> More
                                                        Details... </a> </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="edtBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Edit / approvel Model -->

<!-- LEDGER POPUP -->
<div class="modal" id="modalLeg" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:95%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">Account Ledger <span id="aa1"></span></h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="row">
                        <div class="modal-body scroll" style="height:500px;" id="ac_stp">
                            <div class="table-responsive">
                                <table class="table datatable table-bordered table-actions"
                                       id="stp_tbl" width="100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Reference</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Capital</th>
                                        <th class="text-center">Interest</th>
                                        <th class="text-center">Penalty</th>
                                        <th class="text-center">Other</th>
                                        <th class="text-center">Due</th>
                                        <th class="text-center">Payment</th>
                                        <th class="text-center">Arrears</th>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END LEDGER POPUP -->

</body>

<script>

    $().ready(function () {
        // Data Tables
        $('#dataTbadvnLoan').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        //$('#modalAdd').modal('show');

        srchLoan();
        loanType();
        document.getElementById('tr1').style.display = "none";
        document.getElementById('tr2').style.display = "none";
        document.getElementById('tr3').style.display = "none";
        document.getElementById('tr4').style.display = "none";
        document.getElementById('tr5').style.display = "none";
        document.getElementById('tr6').style.display = "none";
        document.getElementById('prvsDiv').style.display = "none";

        var exgr = <?= $policy[3]->pov2; ?>;

        if (exgr == 4) {
            $("#grn5").css("display", "none");
        } else if (exgr == 3) {
            $("#grn5,#grn4").css("display", "none");
        } else if (exgr == 2) {
            $("#grn5,#grn4,#grn3").css("display", "none");
        } else if (exgr == 1) {
            $("#grn5,#grn4,#grn3,#grn2").css("display", "none");
        }

        // $.validator.setDefaults({ignore: ''});

        $("#adlnAdd").validate({  // Product loan validation
            rules: {
                coll_brn: {
                    required: true,
                    notEqual: 'all'
                },
                coll_ofc: {
                    required: true,
                    notEqual: 'all'
                },
                coll_cen: {
                    required: true,
                    notEqual: 'all'
                },
                grn1: {
                    required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn2', '#grn3', '#grn4', '#grn5']
                },
                grn2: {
                    //required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn3', '#grn4', '#grn5']
                },
                grn3: {
                    //required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn4', '#grn5']
                },
                grn4: {
                    //required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn3', '#grn5']
                },
                grn5: {
                    //required: true,
                    minlength: 10,
                    notEqualTo: ['#nic', '#grn1', '#grn2', '#grn3', '#grn4']
                },
                nic: {
                    required: true,
                    minlength: 10
                },
                prdTyp: {
                    required: true,
                    notEqual: '0'
                },
                prdTyp_dp: {
                    notEqual: '0'
                },
                fcamt: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },
                fcamt_dp: {
                    required: true,
                    currency: true
                },
                hdvl: {
                    required: true,
                    notEqual: '0',
                    currency: true,
                    greaterThan: "#fcamt"
                },
                dwpy: {
                    required: true,
                    currency: true,
                    greaterThan: "#fcamt_dp"
                },
                inpr: {
                    notEqual: '0'
                },
                inpr_dp: {
                    notEqual: '0'
                },

                dytp: {
                    notEqual: '0'
                },
                dytp_dp: {
                    notEqual: '0'
                },
                inrt_dp: {
                    notEqual: '0'
                },

            },
            messages: {
                coll_brn: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
                },
                coll_ofc: {
                    required: 'Please enter New Password',
                    notEqual: "Please select Officer"
                },
                coll_cen: {
                    required: 'Please Enter Center Name',
                    notEqual: "Please select Center"
                },
                grn1: {
                    required: 'Enter First Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn2: {
                    //required: 'Enter Second Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn3: {
                    //required: 'Enter Thired Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn4: {
                    //required: 'Enter Fourth Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                grn5: {
                    //required: 'Enter Firth Guarantor NIC',
                    notEqualTo: "This NIC already enter",
                },
                nic: {
                    required: 'Enter Applicant NIC'
                },

                prdTyp: {
                    required: 'Select Product Type',
                    notEqual: "Select Product Type"
                },
                prdTyp_dp: {
                    notEqual: "Select Product Type"
                },

                fcamt: {
                    notEqual: "Select Facility Amount"
                },
                fcamt_dp: {
                    required: 'Enter Facility Amount'
                },

                hdvl: {
                    required: "Enter Hidden Amount",
                    notEqual: "Enter Hidden Amount",
                    greaterThan: "Hidden value greater than facility amount",
                },
                dwpy: {
                    required: 'Enter Facility Amount',
                    currency: 'Enter Facility Amount',
                    greaterThan: 'Down payment greater than facility amount',
                },

                inpr: {
                    notEqual: "Select Rental"
                },
                inpr_dp: {
                    notEqual: "Select Payment duration"
                },

                dytp_dp: {
                    notEqual: "Select Day Type"
                },
                inrt_dp: {
                    notEqual: 'Select Interest Rate'
                },

            }
        });

        $("#advnLoanEdt").validate({  // Product loan validation
            rules: {
                coll_brnEdt: {
                    required: true,
                    notEqual: 'all'
                },
                coll_ofcEdt: {
                    required: true,
                    notEqual: 'all'
                },
                coll_cenEdt: {
                    required: true,
                    notEqual: 'all'
                },
                grn1Edt: {
                    required: true,
                    notEqual: '#nicEdt'
                },
                grn2Edt: {
                    required: true,
                    notEqual: '#nicEdt'
                },


                prdTypEdt: {
                    required: true,
                    notEqual: '0'
                },
                prdTyp_dpEdt: {
                    required: true,
                    notEqual: '0'
                },

                fcamtEdt: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },
                fcamt_dpEdt: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },

                hdvlEdt: {
                    required: true,
                    notEqual: '0',
                    currency: true,
                    greaterThan: "#fcamtEdt"
                },
                dwpyEdt: {
                    required: true,
                    notEqual: '0',
                    currency: true,
                    greaterThan: "#fcamt_dpEdt"
                },

                inprEdt: {
                    notEqual: '0'
                },
                inpr_dpEdt: {
                    notEqual: '0'
                },

                dytpEdt: {
                    notEqual: '0'
                },
                dytp_dpEdt: {
                    notEqual: '0'
                },

                inrt_dpEdt: {
                    notEqual: '0'
                },

            },
            messages: {
                coll_brnEdt: {
                    required: 'Please select Branch',
                    notEqual: "Please select Branch",
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
                    required: 'Please Enter Facility Amount',
                    notEqual: 'Please Enter Facility Amount',
                    currency: 'Please Enter Valide Amount'
                },
                hdvlEdt: {
                    required: 'Please Enter hidden value',
                    notEqual: 'Please Enter hidden value',
                    currency: 'Please Enter Amount',
                    greaterThan: 'Hidden value greater than facility amount'
                },
                inprEdt: {
                    notEqual: 'Please select payment duration',
                },
                //
                grn1Edt: {
                    required: 'Enter First Guarantor NIC',
                    notEqual: "Please Check NIC",
                },
                grn2Edt: {
                    required: 'Enter Second Guarantor NIC',
                    notEqual: "Please select Branch",
                },
                // #2z
                prdTyp_dpEdt: {
                    notEqual: 'Select Product Type'
                },
                fcamt_dpEdt: {
                    required: 'Enter Facility Amount',
                    notEqual: 'Enter Facility Amount',
                    currency: 'Enter Facility Amount'
                },

                dytpEdt: {
                    notEqual: 'Select Day Type'
                },
                dytp_dpEdt: {
                    notEqual: 'Select Day Type'
                },
                inpr_dpEdt: {
                    notEqual: 'Select Payment duration'
                },
                inrt_dpEdt: {
                    notEqual: 'Select Interest Rate'
                },

            }
        });
    });

    // ADD LOAN CLICK
    $("#newLoan").on('click', function (e) {
        e.preventDefault();

        loanType();
        document.getElementById('tr1').style.display = "none";
        document.getElementById('tr2').style.display = "none";
        document.getElementById('tr3').style.display = "none";
        document.getElementById('tr4').style.display = "none";
        document.getElementById('tr5').style.display = "none";
        document.getElementById('tr6').style.display = "none";
        document.getElementById('prvsDiv').style.display = "none";

        document.getElementById('nic').style.display = "block";
        document.getElementById('divGrpmb').style.display = "none";
        document.getElementById('divLstcmnt').style.display = "none";
        document.getElementById('nic').focus();
        document.getElementById('nic').value = '';
        document.getElementById('coll_ofc').value = 'all';
        document.getElementById('coll_cen').value = 'all';

    });

    function chckBtn(id, inpu) {
        if (id == 0) { //brch_cst
            document.getElementById(inpu).style.borderColor = "red";
        } else {
            document.getElementById(inpu).style.borderColor = "";
        }
    }

    // LOAD DATA TABLE
    function srchLoan() {                                                       // Search btn
        var brn = document.getElementById('brch').value;
        var exc = document.getElementById('exc').value;
        var cen = document.getElementById('cen').value;
        var stat = document.getElementById('stat').value;
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        if (brn == '0') {
            document.getElementById('brch').style.borderColor = "red";
        } else {
            document.getElementById('brch').style.borderColor = "";

            $('#dataTbadvnLoan').DataTable().clear();
            $('#dataTbadvnLoan').DataTable({
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
                    {className: "text-center", "targets": [0, 5, 8, 9, 10, 11]},
                    {className: "text-right", "targets": [0, 6, 7]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "order": [[10, "desc"]], //ASC  desc
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
                    {sWidth: '8%'},
                    {sWidth: '15%'}
                ],

                "ajax": {
                    url: '<?= base_url(); ?>user/srchAdvncLoan',
                    type: 'post',
                    data: {
                        brn: brn,
                        exc: exc,
                        cen: cen,
                        stat: stat,
                        frdt: frdt,
                        todt: todt,
                    }
                }
            });
        }
    }

    // VIEW LOAN
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
                    if (response[i]['lntp'] == 3) {

                        var loam = +response[i]['loam'] + +response[i]['inta'];
                    } else if (response[i]['lntp'] == 4) {

                        var loam = +response[i]['loam'] + +response[i]['pyam'];
                    }
                    document.getElementById("lnamt").innerHTML = parseFloat(loam).toFixed(2);
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

                    document.getElementById("prid").innerHTML = response[i]['prid'] + ' lnid :' + auid;
                }
            }
        })
    }

    // If check product loan or dyanamic loan
    function loanType() {
        if (document.getElementById('lntp').checked == true) {          // INT FREE LOAN
            document.getElementById('intFree').style.display = "block";
            document.getElementById('dwnPymt').style.display = "none";
            // document.getElementById('divgrnt').style.display = "none";
            //document.getElementById('insu').readOnly = true;
            //document.getElementById('docu').readOnly = true;
            document.getElementById('insu').value = '0';
            document.getElementById('docu').value = '0';

            document.getElementById('cltp').value = '2';
            $('#cltp').attr("disabled", true);

        } else {                      // DOWN PAYMENT LOAN

            document.getElementById('dwnPymt').style.display = "block";
            document.getElementById('intFree').style.display = "none";

            document.getElementById('insu').value = '0';
            document.getElementById('docu').value = '0';

            document.getElementById('cltp').value = '2';
            $('#cltp').attr("disabled", false);
        }
    }

    // if check group guarantor or individual guarantor
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

    function nicCheck(id, cuid) {       // id = NIC / cuid = input box id

        var nicNo = document.getElementById(id).value;
        if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {
            document.getElementById(id).style.borderColor = "#e6e8ed";
            getCustomerDetils(nicNo, cuid);

        } else if (nicNo.length == 12) {
            document.getElementById(id).style.borderColor = "#e6e8ed";
            getCustomerDetils(nicNo, cuid);

        } else {
            document.getElementById(id).focus();
            document.getElementById(id).style.borderColor = "red";
            $('#sts1').text("");
        }
    }

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
                        if (<?php echo $policy[0]->post ?> == 0
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
                                    document.getElementById('prvsDiv').style.display = "block";

                                    // CUSTOMER COMMENT PANEL
                                    if (response[0]['cmnt'] != null) {
                                        document.getElementById('divLstcmnt').style.display = "block";
                                        document.getElementById("lscmnt").innerHTML = response[0]['cmnt'] + " - By (" + response[0]['usnm'] + ' ' + response[0]['crdt'] + ')';
                                    } else {
                                        document.getElementById("lscmnt").innerHTML = "No Comment";
                                    }
                                    // END CUSTOMER COMMENT PANEL

                                    // document.getElementById('prlPrd').value = response[0]['prpd']; // if parallal product value
                                    document.getElementById('appid').value = response[0]['cuid'];
                                    document.getElementById('lnct').value = response[0]['lcnt'];
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
                                    prvsLoan(response[0]['cuid']);

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
                        if (<?= $policy[0]->post; ?> == 1
                    )
                        {
                            if (response[0]['rgtp'] == 0) {
                                $('#sts1').html("<font color='red'>Guarantor NIC ...</font>");
                                document.getElementById('lnaddBtn').disabled = true;
                            } else {
                                if (cust == 3 || cust == 4) {
                                    document.getElementById('nic').style.display = "none";
                                    document.getElementById('tr1').style.display = "block";
                                    document.getElementById('prvsDiv').style.display = "block";

                                    // CUSTOMER COMMENT PANEL
                                    if (response[0]['cmnt'] != null) {
                                        document.getElementById('divLstcmnt').style.display = "block";
                                        document.getElementById("lscmnt").innerHTML = response[0]['cmnt'] + " - By (" + response[0]['usnm'] + ' ' + response[0]['crdt'] + ')';
                                    } else {
                                        document.getElementById("lscmnt").innerHTML = "No Comment";
                                    }
                                    // END CUSTOMER COMMENT PANEL

                                    // document.getElementById('prlPrd').value = response[0]['prpd']; // if parallal product value

                                    document.getElementById('appid').value = response[0]['cuid'];
                                    document.getElementById('lnct').value = response[0]['lcnt'];
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
                                    prvsLoan(response[0]['cuid']);

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
                } else if (cuid == 'aplicEdt') { // aplicate edit
                    if (len != 0) {

                        alert('Test aa1');
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            // document.getElementById('nicEdt').style.display = "none";
                            document.getElementById('tr1Edt').style.display = "block";


                            document.getElementById('appidEdt').value = response[0]['cuid'];
                            document.getElementById('coll_brnEdt').value = response[0]['brco'];
                            document.getElementById('coll_ofcEdt').value = response[0]['exec'];
                            document.getElementById('coll_cenEdt').value = response[0]['ccnt'];

                            $('#cunmEdt').text(response[0]['sode'] + response[0]['init']);
                            $('#cunoEdt').text(response[0]['cuno']);
                            $('#anicEdt').text(response[0]['anic']);
                            $('#adrsEdt').text(response[0]['hoad']);
                            $('#phneEdt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('lnst1Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('lnst1Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('lnst2Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('lnst2Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts1Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts1Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts1Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr1Edt') { // 1 granter edit
                    alert('Test aa2');
                    if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn1Edt').style.display = "none";
                            document.getElementById('tr2Edt').style.display = "block";

                            document.getElementById('fsgiEdt').value = response[0]['cuid'];
                            $('#grnm1Edt').text(response[0]['sode'] + response[0]['init']);
                            $('#grno1Edt').text(response[0]['cuno']);
                            $('#gnic1Edt').text(response[0]['anic']);
                            $('#gadr1Edt').text(response[0]['hoad']);
                            $('#gphn1Edt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac1Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac1Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn1Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn1Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts2Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts2Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts2Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr2Edt') { // 2 granter edit
                    if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn2Edt').style.display = "none";
                            document.getElementById('tr3Edt').style.display = "block";

                            document.getElementById('segiEdt').value = response[0]['cuid'];
                            $('#grnm2Edt').text(response[0]['sode'] + response[0]['init']);
                            $('#grno2Edt').text(response[0]['cuno']);
                            $('#gnic2Edt').text(response[0]['anic']);
                            $('#gadr2Edt').text(response[0]['hoad']);
                            $('#gphn2Edt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac2Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac2Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn2Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn2Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts3Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts3Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts3Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr3Edt') { // 3 granter edit
                    alert('Test aa3');
                    if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn3Edt').style.display = "none";
                            document.getElementById('tr4Edt').style.display = "block";

                            document.getElementById('thgiEdt').value = response[0]['cuid'];
                            $('#grnm3Edt').text(response[0]['sode'] + response[0]['init']);
                            $('#grno3Edt').text(response[0]['cuno']);
                            $('#gnic3Edt').text(response[0]['anic']);
                            $('#gadr3Edt').text(response[0]['hoad']);
                            $('#gphn3Edt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac3Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac3Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn3Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn3Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts4Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts4Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts4Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr4Edt') { // 4 granter edit
                    if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn4Edt').style.display = "none";
                            document.getElementById('tr5Edt').style.display = "block";

                            document.getElementById('fogiEdt').value = response[0]['cuid'];
                            $('#grnm4Edt').text(response[0]['sode'] + response[0]['init']);
                            $('#grno4Edt').text(response[0]['cuno']);
                            $('#gnic4Edt').text(response[0]['anic']);
                            $('#gadr4Edt').text(response[0]['hoad']);
                            $('#gphn4Edt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac4Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac4Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn4Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn4Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts5Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts5Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts5Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                } else if (cuid == 'gr5Edt') { // 5 granter edit
                    if (len != 0) {
                        var cust = response[0]['stat'];
                        if (cust == 3 || cust == 4) {
                            document.getElementById('grn5Edt').style.display = "none";
                            document.getElementById('tr6Edt').style.display = "block";

                            document.getElementById('figiEdt').value = response[0]['cuid'];
                            $('#grnm5Edt').text(response[0]['sode'] + response[0]['init']);
                            $('#grno5Edt').text(response[0]['cuno']);
                            $('#gnic5Edt').text(response[0]['anic']);
                            $('#gadr5Edt').text(response[0]['hoad']);
                            $('#gphn5Edt').text(response[0]['mobi'] + ' /' + response[0]['tele']);

                            if (response[0]['act'] > 0) {
                                document.getElementById('grlnac5Edt').innerHTML = " <span class='label label-success'>" + response[0]['act'] + " Active</span> ";
                            } else {
                                document.getElementById('grlnac5Edt').innerHTML = " ";
                            }
                            if (response[0]['pen'] > 0) {
                                document.getElementById('grlnpn5Edt').innerHTML = " <span class='label label-danger'>" + response[0]['pen'] + " Pending</span> ";
                            } else {
                                document.getElementById('grlnpn5Edt').innerHTML = " ";
                            }
                        } else if (cust == 1) {
                            $('#sts6Edt').html("<font color='red'>Customer does not activated...</font>");
                        } else if (cust == 5) {
                            $('#sts6Edt').html("<font color='red'>Customer has been rejected Please check NIC...</font>");
                        }
                    } else {

                        $('#sts6Edt').html("<font color='blue'>No any customer's from this <STRONG>NIC</STRONG></font>");
                    }
                }
            },
        });
    }

    // LOAD CUSTOMER GROUP MEMBER DETAILS
    function grpMnbDtils(nicNo) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>user/getgrpMnbDtils',
            data: {
                apid: nicNo
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                document.getElementById('grntLen').value = len;
                document.getElementById('divGrpmb').style.display = "block";

                for (var i = 0; i < len; i++) {
                    if (i > 9) {
                    } else {
                        document.getElementById("axx" + i).innerHTML = "<div class='list-group-item'>" +
                            "<div class='list-group-status status-online'></div>" +
                            "<img src='../uploads/cust_profile/" + response[i]['uimg'] + "'  class='pull-left' alt='Granter image'>" +
                            "<span class='contacts-title'>" + response[i]['sode'] + '' + response[i]['init'] + "</span> " + ' - ' + response[i]['cuno'] +
                            "<p>" + response[i]['anic'] + ' | ' + response[i]['mobi'] + ' | ' + "<label style='color: red' > Active " + response[i]['act'] + " </label>" + "</p>" +
                            "<div class='list-group-controls'>" +
                            "<input type='hidden' name='grid[" + i + "]'  value=" + response[i]['cuid'] + " />" +
                            "<input type='checkbox' name='addm[" + i + "]' value=" + response[i]['cuid'] + " id='checkbox-1'  class='icheckbox' /></div></div> ";
                    }
                }
            },
        });
    }

    // LOAD CUSTOMER PERVIOS LOAN DETAILS
    function prvsLoan(cuid) { // customer id
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getPrvesloan",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $('#prvstb').DataTable().clear();

                var t = $('#prvstb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '15%'},
                        {sWidth: '5%'}
                    ],
                    "rowCallback": function (row, data, index) {
                        var age = data[2];
                        //$node = this.api().row(row).nodes().to$();
                        if (age > 0) {
                            $(row).find('td:eq(2)').addClass('danger')
                        } else if (age <= 0) {
                            $(row).find('td:eq(9)').addClass('success')
                        }
                    },
                    // "order": [[5, "ASC"]], //ASC  desc
                });
                // t.clear().draw();

                for (var i = 0; i < len; i++) {
                    t.row.add([
                        "<a href='#' id='trfsBtn' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(" + response[i]['lnid'] + ")'> " + response[i]['acno'] + " </a>",
                        response[i]['stnm'],
                        response[i]['cage']
                    ]).draw(false);
                }
            }
        })
    }

    // LOAD CUSTOMER LOAN DETAILS EDIT
    function prvsLoanEdt(cuid) { // customer id
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getPrvesloan",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $('#prvstbEdt').DataTable().clear();

                var t = $('#prvstbEdt').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0, 2]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '15%'},
                        {sWidth: '5%'}
                    ],
                    "rowCallback": function (row, data, index) {
                        var age = data[2];
                        //$node = this.api().row(row).nodes().to$();
                        // $node.addClass('danger')
                        //$node.addClass('info')

                        if (age > 0) {
                            $(row).find('td:eq(2)').addClass('danger')
                        } else if (age <= 0) {
                            $(row).find('td:eq(9)').addClass('success')
                        }
                    },
                    // "order": [[5, "ASC"]], //ASC  desc
                });
                // t.clear().draw();

                for (var i = 0; i < len; i++) {
                    t.row.add([
                        "<a href='#' id='trfsBtn' data-toggle='modal' data-target='#modalLeg' onclick='vieLeg(" + response[i]['lnid'] + ")'> " + response[i]['acno'] + " </a>",
                        response[i]['stnm'],
                        response[i]['cage']
                    ]).draw(false);
                }
            }
        })
    }

    function grnCount() {
        var cunt = $('[class="icheckbox"]:checked').length;
        document.getElementById('grnCunt').value = cunt;
    }

    // ************ INTEREST FREE LOAN **********
    // HIDDEN VALUE ENABLE DISABLE
    function hidenVal() {
        var checkBox = document.getElementById("hid");
        if (checkBox.checked === true) {
            document.getElementById("hidnVal").style.display = "block";
        } else {
            document.getElementById("hidnVal").style.display = "none";
            document.getElementById("hdvl").value = 0;
        }
    }

    // EDIT
    function hidenValEdt() {
        var checkBox = document.getElementById("hidEdt");
        if (checkBox.checked === true) {
            document.getElementById("hidnValEdt").style.display = "block";
        } else {
            document.getElementById("hidnValEdt").style.display = "none";
            document.getElementById("hdvlEdt").value = 0;
        }
    }

    // ************ DOWN PAYMENT LOAN **********
    function downPymt() {
        var checkBox = document.getElementById("dwp");
        if (checkBox.checked === true) {
            document.getElementById("dwnVal").style.display = "block";
        } else {
            document.getElementById("dwnVal").style.display = "none";
            document.getElementById("dwpy").value = 0;
        }
    }

    // EDIT
    function downPymtEdt() {
        var checkBox = document.getElementById("dwpEdt");
        if (checkBox.checked === true) {
            document.getElementById("dwnValEdt").style.display = "block";
        } else {
            document.getElementById("dwnValEdt").style.display = "none";
            document.getElementById("dwpyEdt").value = 0;
        }
    }

    // LOAD PERIOD & INT RATE
    function abc(prtp) {

        if (document.getElementById('lntp').checked == true) {  // INREREST FREE

            if (prtp == 9) {
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

        } else {      // DOWN PAYMENT LOAN

            if (prtp == 12) {
                document.getElementById('dailyDiv_dp').style.display = "block";

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
                            $('#dytp_dp').empty();
                            $('#dytp_dp').append("<option value='0'>Select Day Type </option>");
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['cldw'];
                                var name = response[i]['cldw'] + " Days WK";
                                var $el = $('#dytp_dp');
                                $el.append($("<option></option>")
                                    .attr("value", id).text(name));
                            }
                        } else {
                            $('#dytp_dp').empty();
                            $('#dytp_dp').append("<option value='0'>No Day Type</option>");
                        }
                    }
                });
            } else {
                document.getElementById('dailyDiv_dp').style.display = "none";
                getLoanPrdtDyn(prtp, 0, 'add');
            }
        }
    }

    // LOAD LOAN DURATION
    function getLoanPrdtDyn(prdtp, daytp) {
        var lntp = document.getElementById('lntp').value;

        console.log(prdtp);

        if (prdtp == 9 || prdtp == 12) {
            var x = " Days";
        } else if (prdtp == 10 || prdtp == 13) {
            var x = " Weeks";
        } else if (prdtp == 11 || prdtp == 14) {
            var x = " Months";
        } else {
            var x = " - ";
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

                if (document.getElementById('lntp').checked == true) {  // INREREST FREE
                    // LOAD DURATION
                    if (len != 0) {
                        $('#inpr').empty();
                        $('#inpr').append("<option value='0'>Select Duration </option>");
                        for (var i = 0; i < len; i++) {

                            if (prdtp == 9) {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
                            } else {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x;
                            }

                            var $el = $('#inpr');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#inpr').empty();
                        $('#inpr').append("<option value='0'>No Duration</option>");
                    }

                } else {      // DOWN PAYMENT LOAN

                    // LOAD DURATION
                    if (len != 0) {
                        $('#inpr_dp').empty();
                        $('#inpr_dp').append("<option value='0'>Select Duration </option>");
                        for (var i = 0; i < len; i++) {

                            if (prdtp == 12) {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
                            } else {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x;
                            }

                            var $el = $('#inpr_dp');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#inpr_dp').empty();
                        $('#inpr_dp').append("<option value='0'>No Duration</option>");
                    }

                    // LOAD RATE
                    if (len2 != 0) {
                        $('#inrt_dp').empty();
                        $('#inrt_dp').append("<option value='0'>Select Rate </option>");
                        for (var i = 0; i < len2; i++) {
                            var id = response['rate'][i]['inra'];
                            var name = response['rate'][i]['inra'] + ' %';
                            var $el = $('#inrt_dp');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#inrt_dp').empty();
                        $('#inrt_dp').append("<option value='0'>No Rate</option>");
                    }

                }
            },
        });
    }

    // CALCULATION INSTALLMENT
    var d5 = <?= $policyinfo[0]->pov1 ?>;
    var d6 = <?= $policyinfo[0]->pov2 ?>;
    var d7 = <?= $policyinfo[0]->pov3 ?>;

    function calInstal() {
        if (document.getElementById('lntp').checked == true) {  // INTEREST FREE Loan

            var lnamt = document.getElementById('fcamt').value;     // loan amount
            var noins = document.getElementById('inpr').value;      // no of installment
            var hdvl = document.getElementById('hdvl').value;       // HIDDEN VALUE
            var prtp = document.getElementById('prdTyp').value;     // product type
            var dytp = document.getElementById('dytp').value;       // product type

            if (prtp == 9) {        // INTEREST FREE DL
                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }

                var mm = (+lnamt / ((+noins / 30) * +dts));     // PREMIUM
                var aa = hdvl;                                  // TOTAL INTEREST

            } else if (prtp == 10) {        // INTEREST FREE WK

                //var mnth = (+noins / 4);
                var mm = (+lnamt / +noins);     // PREMIUM
                var aa = hdvl;                  // TOTAL INTEREST

            } else if (prtp == 11) {            //INTEREST FREE ML

                var mm = (+lnamt / +noins);     // PREMIUM
                var aa = hdvl;                  // TOTAL INTEREST

            } else {

            }
            // ROUND NEAREST 10
            //document.getElementById('lnprim').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
            document.getElementById('lnprim').value = numeral(mm).format('0.0000');     // PREMIUM
            document.getElementById('ttlint').value = numeral(aa).format('0.0000');     // TOTAL INTEREST

        } else {      // DOWN PAYMENT LOAN

            var prtp = document.getElementById('prdTyp_dp').value;      // product type
            var lnamt = document.getElementById('fcamt_dp').value;      // loan amount
            var noins = document.getElementById('inpr_dp').value;       // no of installment
            var inrt = document.getElementById('inrt_dp').value;        // interest rate
            var dwpy = document.getElementById('dwpy').value;           // DOWN PAYMENT VALUE
            var dytp = document.getElementById('dytp_dp').value;        // product type

            lnamt = +lnamt - +dwpy;

            if (prtp == 12) {        // DOWN PAYMENT DL

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                var mm = (+lnamt + ((+lnamt * +inrt) / 100)) / ((+noins / 30) * +dts);  // PREMIUM
                var aa = ( ((+noins / 30) * +dts) * mm ) - +lnamt;                     // TOTAL INTEREST

            } else if (prtp == 13) {            // DOWN PAYMENT WK

                // var mnth = (+noins / 4);
                // var mm = (+lnamt + (((+lnamt * +inrt) / 100) * +mnth)) / +noins;
                // var aa = ((+lnamt * +inrt) / 100) * +mnth;

                var mnth = (+noins / 4);
                var mm = (+lnamt + ((+lnamt * +inrt) / 100) * +mnth) / +noins;      // PREMIUM
                var aa = ((+noins * mm ) - +lnamt);                         // TOTAL INTEREST

            } else if (prtp == 14) {            //DOWN PAYMENT ML

                var mm = (+lnamt / +noins);             // PREMIUM
                var aa = ((+noins * mm ) - +lnamt);     // TOTAL INTEREST

            } else {

            }
            // ROUND NEAREST 10
            //document.getElementById('lnprim').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
            document.getElementById('lnprim_dp').value = numeral(mm).format('0.0000');     // PREMIUM
            document.getElementById('ttlint_dp').value = numeral(aa).format('0.0000');     // TOTAL INTEREST

        }
    }

    // EDIT LOAD PERIOD & INT RATE
    function abcEdt(prtp, lcat, lnpr, inrt) {        // prdtp , lcat , loan prid, int rate

        //console.log(' prdtp ' + prtp + ' lcat ' + lcat + ' lnpr ' + lnpr + ' inrt ' + inrt);

        if (document.getElementById('lntpEdt').checked == true) {  // INREREST FREE

            if (prtp == 9) {
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

            }
            getLoanPrdtDynEdt(prtp, lcat, lnpr, '');

        } else {      // DOWN PAYMENT LOAN

            if (prtp == 12) {
                document.getElementById('dailyDiv_dpEdt').style.display = "block";

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
                            $('#dytp_dpEdt').empty();
                            $('#dytp_dpEdt').append("<option value='0'>Select Day Type </option>");
                            for (var i = 0; i < len; i++) {
                                var id = response[i]['cldw'];
                                var name = response[i]['cldw'] + " Days WK";
                                var $el = $('#dytp_dpEdt');
                                if (lcat == id) {
                                    $el.append($("<option selected></option>")
                                        .attr("value", id).text(name));
                                } else {
                                    $el.append($("<option></option>")
                                        .attr("value", id).text(name));
                                }
                            }
                        } else {
                            $('#dytp_dpEdt').empty();
                            $('#dytp_dpEdt').append("<option value='0'>No Day Type</option>");
                        }
                    }
                });
            } else {

                document.getElementById('dailyDiv_dpEdt').style.display = "none";

            }
            getLoanPrdtDynEdt(prtp, lcat, lnpr, inrt);
        }
    }

    // EDIT LOAD LOAN DURATION
    function getLoanPrdtDynEdt(prdtp, daytp, noin, inrt) {        // prdtp , lcat , loan prid , int rate

        var lntp = document.getElementById('lntpEdt').value;

        console.log('lntp ' + lntp + ' prdtp ' + prdtp + ' daytp ' + daytp + ' noin ' + noin);

        if (prdtp == 9 || prdtp == 12) {
            var x = " Days";
        } else if (prdtp == 10 || prdtp == 13) {
            var x = " Weeks";
        } else if (prdtp == 11 || prdtp == 14) {
            var x = " Months";
        } else {
            var x = " - ";
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

                if (document.getElementById('lntpEdt').checked == true) {  // INREREST FREE LOAN

                    // LOAD DURATION
                    if (len != 0) {
                        $('#inprEdt').empty();
                        $('#inprEdt').append("<option value='0'>Select Duration </option>");
                        for (var i = 0; i < len; i++) {

                            if (prdtp == 9) {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
                            } else {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x;
                            }

                            var $el = $('#inprEdt');
                            if (noin == id) {
                                $el.append($("<option selected></option>")
                                    .attr("value", id).text(name));
                            } else {
                                $el.append($("<option ></option>")
                                    .attr("value", id).text(name));
                            }
                        }
                    } else {
                        $('#inprEdt').empty();
                        $('#inprEdt').append("<option value='0'>No Duration</option>");
                    }

                } else {      // DOWN PAYMENT LOAN

                    // LOAD DURATION
                    if (len != 0) {
                        $('#inpr_dpEdt').empty();
                        $('#inpr_dpEdt').append("<option value='0'>Select Duration </option>");
                        for (var i = 0; i < len; i++) {

                            if (prdtp == 12) {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x + '  (' + response['nofr'][i]['infm'] + x + ')';
                            } else {
                                var id = response['nofr'][i]['nofr'];
                                var name = response['nofr'][i]['nofr'] + x;
                            }

                            var $el = $('#inpr_dpEdt');
                            if (noin == id) {
                                $el.append($("<option selected></option>")
                                    .attr("value", id).text(name));
                            } else {
                                $el.append($("<option ></option>")
                                    .attr("value", id).text(name));
                            }
                        }
                    } else {
                        $('#inpr_dpEdt').empty();
                        $('#inpr_dpEdt').append("<option value='0'>No Duration</option>");
                    }

                    // LOAD RATE
                    if (len2 != 0) {
                        $('#inrt_dpEdt').empty();
                        $('#inrt_dpEdt').append("<option value='0'>Select Rate </option>");
                        for (var i = 0; i < len2; i++) {
                            var id = response['rate'][i]['inra'];
                            var name = response['rate'][i]['inra'] + ' %';
                            var $el = $('#inrt_dpEdt');
                            if (inrt == id) {
                                $el.append($("<option selected></option>")
                                    .attr("value", id).text(name));
                            } else {
                                $el.append($("<option ></option>")
                                    .attr("value", id).text(name));
                            }
                        }
                    } else {
                        $('#inrt_dpEdt').empty();
                        $('#inrt_dpEdt').append("<option value='0'>No Rate</option>");
                    }

                }
            },
        });
    }

    // EDIT CALCULATION INSTALLMENT
    function calInstalEdt() {

        // INTEREST FREE LOAN
        if (document.getElementById('lntpEdt').checked == true) {

            var lnamt = document.getElementById('fcamtEdt').value;     // loan amount
            var noins = document.getElementById('inprEdt').value;      // no of installment
            var hdvl = document.getElementById('hdvlEdt').value;       // HIDDEN VALUE
            var prtp = document.getElementById('prdTypEdt').value;     // product type
            var dytp = document.getElementById('dytpEdt').value;       // product type

            if (prtp == 9) {        // INTEREST FREE DL
                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }

                var mm = (+lnamt / ((+noins / 30) * +dts));     // PREMIUM
                var aa = hdvl;                                  // TOTAL INTEREST

            } else if (prtp == 10) {        // INTEREST FREE WK

                //var mnth = (+noins / 4);
                var mm = (+lnamt / +noins);     // PREMIUM
                var aa = hdvl;                  // TOTAL INTEREST

            } else if (prtp == 11) {            //INTEREST FREE ML

                var mm = (+lnamt / +noins);     // PREMIUM
                var aa = hdvl;                  // TOTAL INTEREST

            } else {

            }
            // ROUND NEAREST 10
            //document.getElementById('lnprim').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
            document.getElementById('lnprimEdt').value = numeral(mm).format('0.0000');     // PREMIUM
            document.getElementById('ttlintEdt').value = numeral(aa).format('0.0000');     // TOTAL INTEREST

        } else {      // DOWN PAYMENT LOAN

            var prtp = document.getElementById('prdTyp_dpEdt').value;      // product type
            var lnamt = document.getElementById('fcamt_dpEdt').value;      // loan amount
            var noins = document.getElementById('inpr_dpEdt').value;       // no of installment
            var inrt = document.getElementById('inrt_dpEdt').value;        // interest rate
            var dwpy = document.getElementById('dwpyEdt').value;           // DOWN PAYMENT VALUE
            var dytp = document.getElementById('dytp_dpEdt').value;        // product type

            lnamt = +lnamt - +dwpy;

            if (prtp == 12) {        // DOWN PAYMENT DL

                if (dytp == 5) {
                    var dts = d5;
                } else if (dytp == 6) {
                    var dts = d6;
                } else if (dytp == 7) {
                    var dts = d7;
                }
                var mm = (+lnamt + ((+lnamt * +inrt) / 100)) / ((+noins / 30) * +dts);  // PREMIUM
                var aa = ( ((+noins / 30) * +dts) * mm ) - +lnamt;                     // TOTAL INTEREST

            } else if (prtp == 13) {            // DOWN PAYMENT WK

                var mm = (+lnamt + ((+lnamt * +inrt) / 100)) / +noins;      // PREMIUM
                var aa = ((+noins * mm ) - +lnamt);                         // TOTAL INTEREST

            } else if (prtp == 14) {            //DOWN PAYMENT ML

                var mm = (+lnamt / +noins);             // PREMIUM
                var aa = ((+noins * mm ) - +lnamt);     // TOTAL INTEREST

            } else {

            }
            // ROUND NEAREST 10
            //document.getElementById('lnprim').value = numeral(Math.ceil(mm / 10) * 10).format('0.00');
            document.getElementById('lnprim_dpEdt').value = numeral(mm).format('0.0000');     // PREMIUM
            document.getElementById('ttlint_dpEdt').value = numeral(aa).format('0.0000');     // TOTAL INTEREST

        }
    }


    // ADVANCE LOAN ADD SUBMIT
    $("#adlnAdd").submit(function (e) { // add form
        e.preventDefault();
        grnCount();
        var grnTyp = document.getElementById("grnTyp").value;
        var grnCunt = document.getElementById("grnCunt").value;

        console.log(grnTyp + '**' + grnCunt);

        if (grnTyp == 1) {
            if (grnCunt >= <?= $policy[2]->pov1 ?> && grnCunt <= <?= $policy[2]->pov2 ?> ) {
                // if(grnCunt >= 1 && grnCunt <= 3 ){
                if ($("#adlnAdd").valid()) {
                    $('#modalAdd').modal('hide');
                    var jqXHR = jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>user/addAdvnceLoan",
                        data: $("#adlnAdd").serialize(),
                        dataType: 'json',
                        success: function (data) {
                            srchLoan();
                            swal({title: "", text: "Advance Loan Added Success!", type: "success"},
                                function () {
                                    location.reload();
                                });
                        },
                        error: function (data, textStatus) {
                            swal({title: "Advance Loan Added Failed", text: textStatus, type: "error"},
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
            if ($("#adlnAdd").valid()) {
                $('#modalAdd').modal('hide');
                var jqXHR = jQuery.ajax({
                    type: "POST",
                    url: "<?= base_url(); ?>user/addAdvnceLoan",
                    data: $("#adlnAdd").serialize(),
                    dataType: 'json',
                    success: function (data) {
                        srchLoan();
                        swal({title: "", text: "Advance Loan Added Success!", type: "success"},
                            function () {
                                location.reload();
                            });
                    },
                    error: function (data, textStatus) {
                        swal({title: "Advance Loan Added Failed", text: textStatus, type: "error"},
                            function () {
                                location.reload();
                            });
                    }
                });
            }
        }
    });

    // LOAD EDIT LOAN DETAILS
    function edtLoan(auid, typ) {
        if (typ == 'edt') {
            $('#hed').text("Update Loan");
            $('#btnNm').text("Update");
            document.getElementById("func").value = '1';

        } else if (typ == 'app') {
            $('#hed').text("Approval Loan");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = '2';
        }
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewLoanEdt",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("lnauid").value = response[0]['lnid'];
                document.getElementById("lnno5").innerHTML = response[0]['acno'];
                document.getElementById("lontype").value = response[0]['lntp']; // loan type hide

                if (response[0]['lntp'] == 3) {             // INT FREE LOAN
                    document.getElementById("lntpEdt").checked = true; // product
                    document.getElementById("dwnPymtEdt").style.display = "none";
                    document.getElementById("intFreEdt").style.display = "block";
                    document.getElementById('cltpEdt').disabled = true;     // Rental Cal Type

                } else {                                    // DOWN PAYMENT LOAN
                    document.getElementById("lntpEdt").checked = false;
                    document.getElementById("dwnPymtEdt").style.display = "block";
                    document.getElementById("intFreEdt").style.display = "none";
                    document.getElementById('cltpEdt').disabled = false;    // Rental Cal Type
                }

                if (response[0]['grtp'] == 1) { // group granter
                    document.getElementById("lncttpEdt").checked = false;
                } else {  // indv granter
                    document.getElementById("lncttpEdt").checked = true;
                }

                //document.getElementById("nicEdt").value = response[0]['aanic'];
                document.getElementById("appidEdt").value = response[0]['apid'];
                $('#cunmEdt').text(response[0]['ainit']);
                $('#cunoEdt').text(response[0]['acuno']);
                $('#anicEdt').text(response[0]['aanic']);
                $('#adrsEdt').text(response[0]['ahoad']);
                $('#phneEdt').text(response[0]['amobi']);
                document.getElementById('appimgEdt').src = "../uploads/cust_profile/" + response[0]['auimg'];
                document.getElementById('appimgEdtA').src = "../uploads/cust_profile/" + response[0]['auimg'];

                if (response[0]['fsgi'] == 0) {
                    document.getElementById('tr2Edt').style.display = "none";
                } else if (response[0]['fsgi'] != 0) {
                    document.getElementById('tr2Edt').style.display = "block";

                    // document.getElementById("grn1Edt").value = response[0]['banic'];
                    document.getElementById("fsgiEdt").value = response[0]['fsgi'];
                    $('#grnm1Edt').text(response[0]['binit']);
                    $('#grno1Edt').text(response[0]['bcuno']);
                    $('#gnic1Edt').text(response[0]['banic']);
                    $('#gadr1Edt').text(response[0]['bhoad']);
                    $('#gphn1Edt').text(response[0]['bmobi']);
                    document.getElementById('gr1ImgEdt').src = "../uploads/cust_profile/" + response[0]['buimg'];
                }

                if (response[0]['segi'] == 0) {
                    document.getElementById('tr3Edt').style.display = "none";
                } else if (response[0]['segi'] != 0) {
                    document.getElementById('tr3Edt').style.display = "block";

                    // document.getElementById("grn1Edt").value = response[0]['banic'];
                    document.getElementById("segiEdt").value = response[0]['segi'];
                    $('#grnm2Edt').text(response[0]['cinit']);
                    $('#grno2Edt').text(response[0]['ccuno']);
                    $('#gnic2Edt').text(response[0]['canic']);
                    $('#gadr2Edt').text(response[0]['choad']);
                    $('#gphn2Edt').text(response[0]['cmobi']);
                    document.getElementById('gr2ImgEdt').src = "../uploads/cust_profile/" + response[0]['cuimg'];

                }
                if (response[0]['thgi'] == 0) {
                    document.getElementById('tr4Edt').style.display = "none";
                } else if (response[0]['thgi'] != 0) {
                    document.getElementById('tr4Edt').style.display = "block";
                    // document.getElementById("grn1Edt").value = response[0]['banic'];
                    document.getElementById("thgiEdt").value = response[0]['thgi'];
                    $('#grnm3Edt').text(response[0]['dinit']);
                    $('#grno3Edt').text(response[0]['dcuno']);
                    $('#gnic3Edt').text(response[0]['danic']);
                    $('#gadr3Edt').text(response[0]['dhoad']);
                    $('#gphn3Edt').text(response[0]['dmobi']);
                    document.getElementById('gr3ImgEdt').src = "../uploads/cust_profile/" + response[0]['duimg'];

                }
                if (response[0]['fogi'] == 0) {
                    document.getElementById('tr5Edt').style.display = "none";
                } else if (response[0]['fogi'] != 0) {
                    document.getElementById('tr5Edt').style.display = "block";
                    // document.getElementById("grn1Edt").value = response[0]['banic'];
                    //  document.getElementById("fogiEdt").value = response[0]['fogi'];
                    //$('#grnm4Edt').text(response[0]['binit']);
                    //   $('#grno4Edt').text(response[0]['bcuno']);
                    // $('#gnic4Edt').text(response[0]['banic']);
                    //      $('#gadr4Edt').text(response[0]['bhoad']);
                    //    $('#gphn4Edt').text(response[0]['bmobi']);
                    //  document.getElementById('gr4ImgEdt').src = "../uploads/cust_profile/" + response[0]['buimg'];

                }
                if (response[0]['figi'] == 0) {
                    document.getElementById('tr6Edt').style.display = "none";
                } else if (response[0]['figi'] != 0) {
                    // document.getElementById("grn1Edt").value = response[0]['banic'];
                    //         document.getElementById("figiEdt").value = response[0]['figi'];
                    //       $('#grnm5Edt').text(response[0]['binit']);
                    //     $('#grno5Edt').text(response[0]['bcuno']);
                    //   $('#gnic5Edt').text(response[0]['banic']);
                    // $('#gadr5Edt').text(response[0]['bhoad']);
                    //       $('#gphn5Edt').text(response[0]['bmobi']);
                    //     document.getElementById('gr5ImgEdt').src = "../uploads/cust_profile/" + response[0]['buimg'];
                }


                if (response[0]['lntp'] == 3) {                 // IF INT FREE LOAN
                    $('#insAmtEdt').text(response[0]['inam']);
                    document.getElementById("prdTypEdt").value = response[0]['prdtp'];
                    document.getElementById("fcamtEdt").value = +response[0]['loam'] + +response[0]['inta'];
                    document.getElementById("lnprimEdt").value = response[0]['inam'];
                    document.getElementById("ttlintEdt").value = response[0]['inta'];

                    if (response[0]['inta'] > 0) {      // IF HIDE VALUE ENABLE

                        document.getElementById("hidEdt").checked = true;
                        document.getElementById('hidnValEdt').style.display = "block";
                        document.getElementById('hdvlEdt').value = response[0]['inta'];

                    } else {
                        document.getElementById("hidEdt").checked = false;
                        document.getElementById('hidnValEdt').style.display = "none";
                        document.getElementById('hdvlEdt').value = 0;
                    }

                    abcEdt(response[0]['prdtp'], response[0]['lcat'], response[0]['noin'], response[0]['inra']);   // prdtp , lcat , loan prid, int rate
                    //getLoanPrdtDynEdt(response[0]['prdtp'], response[0]['lcat'], response[0]['lnpr']);    // prdtp , daytp , loan prid


                } else {                        // IF DOWN PAYMENT LOAN

                    document.getElementById("prdTyp_dpEdt").value = response[0]['prdtp'];
                    document.getElementById("fcamt_dpEdt").value = +response[0]['loam'] + +response[0]['pyam'];
                    document.getElementById("lnprim_dpEdt").value = response[0]['inam'];
                    document.getElementById("ttlint_dpEdt").value = response[0]['inta'];

                    if (response[0]['hdpy'] == 1) {      // IF DOWN PAYMENT ENABLE

                        document.getElementById("dwpEdt").checked = true;
                        document.getElementById('dwnValEdt').style.display = "block";
                        document.getElementById('dwpyEdt').value = response[0]['pyam'];

                    } else {
                        document.getElementById("dwpEdt").checked = false;
                        document.getElementById('dwnValEdt').style.display = "none";
                        document.getElementById('dwpyEdt').value = 0;
                    }

                    abcEdt(response[0]['prdtp'], response[0]['lcat'], response[0]['noin'], response[0]['inra']);   // prdtp , lcat , loan prid, int rate
                    //getLoanPrdtDynEdt(response[0]['prdtp'], response[0]['lcat'], response[0]['lnpr']);    // prdtp , daytp , loan prid

                    if (response[0]['prdtp'] == 12) {
                        //  getLoanPrdtDynEdt(response[0]['prdtp'], response[0]['lcat'], response[0]['noin'], response[0]['inra']); // prdtp , lcat , loan prid , int rate
                    }

                }

                document.getElementById("indtEdt").value = response[0]['indt'];
                document.getElementById("dsdtEdt").value = response[0]['acdt'];

                document.getElementById("insuEdt").value = response[0]['incg'];
                document.getElementById("docuEdt").value = response[0]['docg'];
                document.getElementById("crgmdEdt").value = response[0]['chmd'];

                document.getElementById("coll_brnEdt").value = response[0]['brco'];
                document.getElementById("coll_ofcEdt").value = response[0]['clct'];
                document.getElementById("coll_cenEdt").value = response[0]['ccnt'];

                if (response[0]['cmnt'] != null) {
                    document.getElementById("remkEdt").innerHTML = response[0]['cmnt'] + " - By (" + response[0]['usnm'] + ' ' + response[0]['crdt'] + ')';
                } else {
                    document.getElementById("remkEdt").innerHTML = "No Comment";
                }
                document.getElementById("mrdt").setAttribute("href", "<?= base_url() ?>user/nicSearchDtils?sid=" + response[0]['aanic']);

                if (response[0]['prdtp'] == 3) {
                    $('#insAmtEdt2').text('( ' + response[0]['lcat'] + 'D | C`RNT ' + response[0]['noin'] + ')');
                } else {
                    $('#insAmtEdt2').text('');
                }

                // for auto load officer & center
                getExeEdit(response[0]['brco'], 'coll_ofcEdt', response[0]['clct'], 'coll_cenEdt');
                getCenterEdit(response[0]['clct'], 'coll_cenEdt', response[0]['brco'], response[0]['ccnt']);

                document.getElementById('prvsDivEdt').style.display = "block";
                prvsLoanEdt(response[0]['apid']);
            }
        })
    }

    // LOAN EDIT SUBMIT
    $("#advnLoanEdt").submit(function (e) { // edit form
        e.preventDefault();

        var func = document.getElementById("func").value;
        if ($("#advnLoanEdt").valid()) {

            if (func == 1) {
                $.ajax({
                    url: '<?= base_url(); ?>user/advncLoan_edit',
                    type: 'POST',
                    data: $("#advnLoanEdt").serialize(),
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
                            swal.close();
                            $('#modalEdt').modal('hide');

                            $.ajax({
                                url: '<?= base_url(); ?>user/advncLoan_edit',
                                type: 'POST',
                                data: $("#advnLoanEdt").serialize(),
                                dataType: 'json',
                                success: function (data) {

                                    srchLoan();
                                    document.getElementById("edtBtn").disabled = false;

                                    if (data === 'Dual') {
                                        swal({title: "", text: "Loan Dual Approval Request!", type: "info"},
                                            function () {
                                                location.reload();
                                            });
                                    } else if (data === 'appr') {
                                        swal({title: "", text: "Loan Approval success!", type: "success"},
                                            function () {
                                                location.reload();
                                            });
                                    }
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
                alert("contact system admin")
            }
        } else {
            //  alert("Error");
        }
    });

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
                    swal.close();
                    $.ajax({
                        url: '<?= base_url(); ?>user/rejLoan',
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

    $("#cler").click(function (e) {
        location.reload();

        // $('#modalAdd').modal('show');
        // $('#modalAdd').removeData('bs.modal');
    })

    // VIEW LEDGER
    function vieLeg(lnid) {

        var arreas = 0;
        var prim = 0;

        $('#stp_tbl').DataTable().clear();
        $('#stp_tbl').DataTable({
            "destroy": true,
            "cache": false,
            //"scrollY": "400px",
            "scrollCollapse": true,
            "searching": false,
            "paging": false,
            "processing": true,
            "serverSide": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "columnDefs": [
                {className: "text-center", "targets": [0]},
                {className: "text-left", "targets": [1, 2, 3]},
                {className: "text-right", "targets": [4, 5, 6, 7, 8, 9, 10]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '13%'},
                {sWidth: '10%'},
                {sWidth: '15%'},
                {sWidth: '5%'}, // CAP
                {sWidth: '5%'},
                {sWidth: '5%'}, // PNLT
                {sWidth: '5%'},
                {sWidth: '5%'},     // DUE
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "rowCallback": function (row, data, index) {
                var pymt = parseFloat(data[9]),
                    duam = parseFloat(data[8]),
                    pnlt = parseFloat(data[6]),
                    $node = this.api().row(row).nodes().to$();

                if (pymt > 0) {
                    $node.addClass('info')
                } else if (pymt < 0) {
                    $node.addClass('danger')
                } else if (duam > 0 && pnlt > 0) {
                    $node.addClass('danger')
                }
                var x = data[8];
                x = x.replace(",", "");
                if (parseFloat(x) > parseFloat(prim)) {
                    prim = data[8].replace(",", "");
                }
                arreas = data[10].replace(",", "");
            },
            "ajax": {
                url: '<?= base_url(); ?>report/getLoanLeg',
                type: 'post',
                data: {
                    lnid: lnid,
                }
            },
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
                //COLUMN 4 TTL
                var t4 = api.column(4).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 7 TTL
                var t7 = api.column(7).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                //COLUMN 8 TTL
                var t8 = api.column(8).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 9 TTL
                var t9 = api.column(9).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 10 TTL
                var t10 = api.column(10).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));
                $(api.column(9).footer()).html(numeral(t9).format('0,0.00'));
                $(api.column(10).footer()).html(numeral(t10).format('0,0.00'));

            },
        });

    }


</script>












