<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>-->
<script src="<?= base_url(); ?>assets/plugins/moment.2.9.0.min.js" type="text/javascript"></script>

<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/morris/morris.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>assets/dist/js/plugins/morris/raphael-min.js"></script>

<style>
    /** Dialog box onclick color change **/
    .dclg {
        background-color: #66BB6A;
        color: white;
        font-size: 11px;
        padding: 2px 10px;
        text-shadow: 0 0 black;
    }

    /*COMMENT NOTIFICATION*/
    /* http://jsfiddle.net/rahilsondhi/FdmHf/4/ */
    /*  http://www.cssportal.com/blog/create-css-notification-badge/ */
    .badge1 {
        position: relative;
        z-index: 1;
    }

    .badge1[data-badge]:after {
        content: attr(data-badge);
        position: absolute;
        top: -10px;
        right: -10px;
        font-size: .7em;
        background: red; /*green*/
        color: white;
        width: 18px;
        height: 18px;
        text-align: center;
        line-height: 18px;
        /*border-radius:50%;*/
        border-radius: 3px;
        box-shadow: 0 0 1px #333;
    }

    /* END COMMENT NOTIFICATION*/

    a:hover {
        cursor: pointer;
    }

</style>

<body>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>">Home</a></li>
    <li class="active">Customer & Facility Details</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">
    <div class="row">
        <div class="col-md-12">
            <!-- START TABS -->
            <div class="panel panel-default tabs">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Client Details</a></li>
                    <li><a href="#tab-second" role="tab" data-toggle="tab">Security</a></li>
                    <li><a href="#tab-3" role="tab" data-toggle="tab" id="cus_cmnt"
                           onclick="custCmment();custCommntSeen()">General
                            Comment</a></li>
                    <li><a href="#tab-4" role="tab" data-toggle="tab">Members </a></li>
                    <li><a href="#tab-5" role="tab" data-toggle="tab">Guarantors </a></li>
                    <li><a href="#tab-6" role="tab" data-toggle="tab">Guarantee </a></li>
                </ul>
                <div class="panel-body tab-content">
                    <div class="tab-pane active" id="tab-first">
                        <p>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tbody>
                            <tr>
                                <td width="15%" valign="top">&nbsp;</td>
                                <td width="35%" height="35" align="center"><strong>CUSTOMER INFORMATION</strong></td>
                                <td colspan="2" align="center"><strong>CUSTOMER STATUS</strong></td>
                            </tr>
                            <tr>
                                <td width="15%" valign="top">
                                    <div class="text-center" id="user_image">
                                        <a class="popup profile-mini"
                                           href="<?= base_url() ?>uploads/cust_profile/<?= $cust[0]->uimg ?>"
                                           title="Click here to see the image..">
                                            <img src="<?= base_url(); ?>uploads/cust_profile/<?= $cust[0]->uimg ?>"
                                                 class="img-thumbnail" width="100" height="100"
                                                 style="border-radius:50%;"/></a>
                                    </div>
                                    <input type="hidden" name="cuid" id="cuid" value="<?= $cust[0]->cuid ?>">
                                </td>
                                <td width="38%" valign="top" style="padding: 5px">
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td><strong><?= $cust[0]->sode . '' . $cust[0]->init ?></strong></td>
                                        </tr>
                                        <tr>
                                            <td><?= $cust[0]->funm ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= $cust[0]->hoad ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= "Mobile :  " . $cust[0]->mobi . " | Tel : " . $cust[0]->tele; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Registered
                                                On <?= $cust[0]->crdt . " &nbsp; By : " . $cust[0]->fnme; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Occupation : <?php ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Status : <?php if ($cust[0]->stat == 0) { ?>
                                                    <span class="label label-yellow label-sm ">Inactive</span>
                                                <?php } else if ($cust[0]->stat == 1) { ?>
                                                    <span class="label label-warning label-sm">Pending</span>
                                                <?php } else if ($cust[0]->stat == 3 || $cust[0]->stat == 4) { ?>
                                                    <span class="label label-success label-sm">Active</span>
                                                <?php } else if ($cust[0]->stat == 5) { ?>
                                                    <span class="label label-danger label-sm">Rejected</span>
                                                <?php } else if ($cust[0]->stat == 7) { ?>
                                                    <span class="label label-danger label-sm">Suspended</span>
                                                <?php } else if ($cust[0]->stat == 9) { ?>
                                                    <span class="label label-warning label-sm">Transfer Requested</span>
                                                <?php } else if ($cust[0]->stat == 10) { ?>
                                                    <span class="label label-warning label-sm">Approval Transfer</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Loan Status :
                                                <?php
                                                if (sizeof($lnar1) > 0) {
                                                    echo '<span class="label label-success"> Running Loan </span>';
                                                } else if (sizeof($lnar2) > 0) {
                                                    echo '<span class="label label-yellow">Closed Loan</span>';
                                                } else if (sizeof($lnar3) > 0) {
                                                    echo '<span class="label label-indi">Inative Loan</span>';
                                                } else if (sizeof($lnar4) > 0) {
                                                    echo '<span class="label label-danger">Terminate Loan</span>';
                                                } else {
                                                    echo '<span class="label label-danger">Pending Loan</span>';
                                                }
                                                ?>

                                                <?php //if ($rc1 > 0) {
                                                //                                                    if (($lst1['durg'] + $lst1['nxpn']) == 0 && ($lst1['boc'] + $lst1['boi'] + $lst1['aboc'] + $lst1['aboi']) > 0) {
                                                //                                                        ?>
                                                <!--                                                        <span class="label label-danger label-form">Pending Over</span>-->
                                                <!--                                                    --><?php //} else if (($lst1['durg'] + $lst1['nxpn']) > 0 && ($lst1['aboc'] + $lst1['aboi']) > 0) { ?>
                                                <!--                                                        <span class="label label-warning label-form">Arrears</span>-->
                                                <!--                                                    --><?php //} else { ?>
                                                <!--                                                        <span class="label label-success label-form">Running</span>-->
                                                <!--                                                    --><?php //}
                                                //                                                } else {
                                                //                                                    'No Current Loans';
                                                //                                                } ?><!--</td>-->
                                        </tr>
                                        <tr>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td width="25%" valign="top" style="padding: 5px">
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td width="50%">Customer No</td>
                                            <td width="50%"> <?php
                                                if ($cust[0]->trst == 1) {
                                                    $tr = "<a href='#' id='trfsBtn' data-toggle='modal' data-target='#trsf_modal'>  <span class='label label-default' title='Transfer Customer (More details )'>Tr</span> </a>";
                                                } else {
                                                    $tr = "";
                                                }
                                                echo $cust[0]->cuno . " " . $tr;
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>NIC No</td>
                                            <td><?= $cust[0]->anic ?></td>
                                        </tr>
                                        <tr>
                                            <td>Branch</td>
                                            <td><?= $cust[0]->brnm ?></td>
                                        </tr>
                                        <tr>
                                            <td>Center</td>
                                            <td title="SYS Code : <?= $cust[0]->cnno ?>"><?= $cust[0]->cnnm; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Type</td>
                                            <td><?= $cust[0]->rgmd . ' | ' . $cust[0]->cumd ?></td>
                                        </tr>
                                        <tr>
                                            <td>Member Type</td>
                                            <td><?= $cust[0]->cutp ?></td>
                                        </tr>
                                        <tr>
                                            <td>Group No</td>
                                            <td><span class="label label-info">
                                            <?= $cust[0]->grno; ?></span></td>
                                        </tr>
                                        <tr>
                                            <td>Current Facilities</td>
                                            <td><span class="label label-success"><?= sizeof($lnar1); ?> </span></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Rate</td>
                                            <td><span class="label label-brown">1</span></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                                <td width="25%" valign="top" style="padding: 5px">
                                    <table class="table table-striped">
                                        <tbody>
                                        <tr>
                                            <td width="50%">Date Of Brith</td>
                                            <td width="50%">
                                                <?= $cust[0]->dobi; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Age</td>
                                            <td>
                                                <?php
                                                echo date_diff(date_create($cust[0]->dobi), date_create('today'))->y . " Year  ";
                                                $today = date("m-d");
                                                //$today = '01-01';
                                                $tobdy = date("m-d", strtotime($cust[0]->dobi));
                                                if ($today == $tobdy) {
                                                    echo "  <i class='fa fa-birthday-cake' style='color:red' title='Today s birthday '></i>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Facilities</td>
                                            <td><?php if (sizeof($lnar1) > 0) {
                                                    echo '<span class="label label-success" title="Running">' . sizeof($lnar1) . '</span>';
                                                } else {
                                                    echo '<span class="label label-success" title="Running">0</span>';
                                                } ?>
                                                <?php if (sizeof($lnar2) > 0) {
                                                    echo '<span class="label label-yellow" title="Pending">' . sizeof($lnar2) . '</span>';
                                                } else {
                                                    echo '<span class="label label-yellow" title="Pending">0</span>';
                                                } ?>
                                                <?php if (sizeof($lnar3) > 0) {
                                                    echo '<span class="label label-indi" title="Finished">' . sizeof($lnar3) . '</span>';
                                                } else {
                                                    echo '<span class="label label-indi" title="Finished">0</span>';
                                                } ?>
                                                <?php if (sizeof($lnar4) > 0) {
                                                    echo '<span class="label label-danger" title="Terminate">' . sizeof($lnar4) . '</span>';
                                                } else {
                                                    echo '<span class="label label-danger" title="Terminate">0</span>';
                                                } ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Last Repayment</td>
                                            <td>
                                                <?php
                                                if (!empty($lnar1)) {
                                                    echo number_format($lnar1[0]->ramt, 2, '.', ',');
                                                } else {
                                                    echo " - ";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Repay Handle By</td>
                                            <td>
                                                <?php
                                                if (!empty($lnar1)) {
                                                    echo " <a href='#' title='Date/Time :" . $lnar1[0]->crdt . " '> " . $lnar1[0]->crb . "</a> ";
                                                } else {
                                                    echo " - ";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Next Schedule Date</td>
                                            <td><?php
                                                if (!empty($lnar1)) {
                                                    echo $lnar1[0]->nxdd;
                                                } else {
                                                    echo " - ";
                                                }
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>SMS Sending Status</td>
                                            <td>
                                                <?php if ($cust[0]->smst == 0) {
                                                    echo '<span class="label label-warning" title="Not Sending"><i class="fa fa-times"></i> NO</span>';
                                                } else {
                                                    echo '<span class="label label-success" title="Sending"><i class="fa fa-check"></i> YES</span>';
                                                } ?></td>
                                        </tr>
                                        <tr>
                                            <td>Last SMS Send</td>
                                            <td>
                                                <?php
                                                if (!empty($lnar1)) {
                                                    echo $lnar1[0]->ssdt;
                                                } else {
                                                    echo " - ";
                                                }
                                                //echo $lnar1[0]->ssdt;
                                                ?></td>
                                        </tr>
                                        <tr>
                                            <td>Customer Location</td>
                                            <td><i class="glyphicon glyphicon-road"></i></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </p>
                    </div>
                    <div class="tab-pane" id="tab-second">
                        <p>System ID : <?= $cust[0]->cuid; ?></p>
                    </div>
                    <div class="tab-pane" id="tab-3" onclick="custCmment()">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <!-- START CONTENT FRAME BODY -->
                                <div class="content-frame-body content-frame-body-left">
                                    <div class="messages messages-img">
                                        <div id="cust_cmmnt">
                                        </div>
                                    </div>
                                    <div class="panel panel-default push-up-10">
                                        <div class="panel-body panel-body-search">
                                            <form class="" id="cust_cmnt_add" name="cust_cmnt_add" action=""
                                                  method="post">
                                                <div class="input-group">
                                                    <input type="text" name="cust_cmnt" id="cust_cmnt"
                                                           class="form-control" required
                                                           placeholder="Your comment..."/>
                                                    <input type="hidden" id="ccuid" name="ccuid">
                                                    <div class="input-group-btn">
                                                        <button type="submit" class="btn btn-default">Send</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                                <!-- END CONTENT FRAME BODY -->

                            </div>

                        </div>

                    </div>

                    <div class="tab-pane" id="tab-4">
                        <h1>Tab 4 </h1>
                    </div>
                    <div class="tab-pane" id="tab-5">
                        <h1>Tab 5 </h1>
                    </div>
                    <div class="tab-pane" id="tab-6">
                        <h1>Tab 6 </h1>

                    </div>
                </div>
            </div>
            <!-- END TABS -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- START ACCORDION -->
            <div class="panel-group accordion">
                <div class="panel panel-success">
                    <div class="panel-heading ">
                        <h4 class="panel-title">
                            <a href="#acc_one" <?php
                            if (sizeof($agdt) > 0) {
                                echo "class='badge1' data-badge='" . sizeof($agdt) . "' ";
                            } ?> >
                                Operative Facilities (<?= sizeof($lnar1) ?>)
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body " id="acc_one">
                        <?php if (sizeof($lnar1) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-actions">
                                    <thead>
                                    <tr>
                                        <th width="" class="text-center">Facility No</th>
                                        <th width="" class="text-center">Product</th>
                                        <th width="" class="text-center">Started</th>
                                        <th width="" class="text-center">Maturity</th>
                                        <th width="" class="text-center">Period</th>
                                        <th width="" class="text-center">Facility</th>
                                        <th width="" class="text-center">Acc Balance</th>
                                        <th width="" class="text-center">Arrears</th>
                                        <th width="" class="text-center">Penalty</th>
                                        <th width="" class="text-center">Settlement</th>
                                        <th width="" class="text-center">Age</th>
                                        <th width="" class="text-center">Status</th>
                                        <th width="" class="text-center">Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $ttamt1 = $ttacbl = $ttarr1 = $ttpnt1 = $ttset1 = 0;

                                    for ($i = 0; $i < sizeof($lnar1); $i++) {
                                        $ln_bal = ($lnar1[$i]->boc + $lnar1[$i]->boi + $lnar1[$i]->avdb + $lnar1[$i]->avpe);
                                        ?>
                                        <tr id="trow_">
                                            <td class="text-center"
                                                title="CNT ID: <?= '(' . $lnar1[$i]->ccnt . ') ' . $lnar1[$i]->cnnm; ?>">
                                                <strong><?= $lnar1[$i]->acno; ?></strong> <?php ; ?></td>
                                            <td class="text-left"><?= '(' . $lnar1[$i]->prcd . ') ' . $lnar1[$i]->prnm; ?></td>
                                            <td class="text-center"><?= $lnar1[$i]->sydt; ?></td>
                                            <td class="text-center"><?= $lnar1[$i]->madt; ?></td>
                                            <td class="text-center"><a
                                                        title="Rental : <?= number_format($lnar1[$i]->inam, 2); ?>/="><?= $lnar1[$i]->noin . ' ' . $lnar1[$i]->pymd; ?></a>
                                            </td>
                                            <td class="text-right"><?= number_format($lnar1[$i]->loam, 0); ?>/=</td>
                                            <td class="text-right">
                                                <a title="CAP : <?= number_format($lnar1[$i]->boc, 2); ?> | INT : <?= number_format($lnar1[$i]->boi, 2); ?>"> <?= number_format($ln_bal, 2); ?></a>
                                            </td>
                                            <td class="text-right">
                                                <a title="CAP : <?= number_format($lnar1[$i]->aboc, 2); ?> | INT : <?= number_format($lnar1[$i]->aboi, 2); ?>"> <?= number_format(($lnar1[$i]->aboc + $lnar1[$i]->aboi), 2); ?></a>
                                            </td>
                                            <td class="text-right"><?= number_format($lnar1[$i]->avpe, 2); ?></td>
                                            <td class="text-right"><a
                                                        title="Over Payment : <?= number_format($lnar1[$i]->avcr, 2); ?>"><?= number_format($ln_bal - $lnar1[$i]->avcr, 2); ?></a>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $ag = $lnar1[$i]->cage;
                                                if ($ag >= 5) {
                                                    $cls = "label-danger";
                                                } else if ($ag < 5 && $ag >= 3) {
                                                    $cls = "label-warning";
                                                } else if ($ag < 3 && $ag > 0) {
                                                    $cls = "label-info";
                                                } else if ($ag <= 0) {
                                                    $cls = "label-success";
                                                }
                                                echo "<span class='label " . $cls . "'> $ag  </span>";
                                                ?>
                                            </td>
                                            <td class="text-center"><?= $lnar1[$i]->nxpn . ' Of ' . $lnar1[$i]->noin; ?></td>
                                            <td class="text-center">
                                                <a href='#' id='b1' class='btn btn-default btn-condensed'
                                                   title='More Details' data-toggle="modal" data-target="#o1_mdt"
                                                   onclick="viewMoreDet(<?= $lnar1[$i]->lnid; ?>)">
                                                    <i class='fa fa-edit'></i></a>&nbsp;
                                                <a href='#' id='<?= $lnar1[$i]->acno; ?>'
                                                   class='btn btn-default btn-condensed b2' title='Account Step'
                                                   onclick="viewLagerPopup(<?= $lnar1[$i]->lnid; ?>,0,id)"
                                                   data-toggle="modal" data-target="#o1_leg"><i class='fa fa-book'></i></a>&nbsp;
                                                <?php
                                                if ($lnar1[$i]->cmnt > 0) {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed badge1' data-badge='" . $lnar1[$i]->cmnt . "'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar1[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                } else {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar1[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $ttamt1 = $ttamt1 + $lnar1[$i]->loam;
                                        $ttacbl = $ttacbl + ($lnar1[$i]->boc + $lnar1[$i]->boi);
                                        $ttarr1 = $ttarr1 + ($lnar1[$i]->aboc + $lnar1[$i]->aboi);
                                        $ttpnt1 = $ttpnt1 + $lnar1[$i]->avpe;
                                        $ttset1 = $ttset1 + $ln_bal - $lnar1[$i]->avcr;
                                    } ?>

                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">&nbsp;</th>
                                        <th width="90" class="text-right"><?= number_format($ttamt1, 0); ?>/=</th>
                                        <th width="90" class="text-right"><?= number_format($ttacbl, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttarr1, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttpnt1, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttset1, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o6, 2); ?></th>
                                        <th colspan="2" class="text-center">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#acc_two">
                                Closed Facilities (<?= sizeof($lnar2) ?>)
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body" id="acc_two">
                        <?php if (sizeof($lnar2) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-actions">
                                    <thead>
                                    <tr>
                                        <th width="" class="text-center">Facility No</th>
                                        <th width="" class="text-center">Product</th>
                                        <th width="" class="text-center">Started</th>
                                        <th width="" class="text-center">Maturity</th>
                                        <th width="" class="text-center">Period</th>
                                        <th width="" class="text-center">Facility</th>
                                        <th width="" class="text-center">Acc Balance</th>
                                        <th width="" class="text-center">Arrears</th>
                                        <th width="" class="text-center">Penalty</th>
                                        <th width="" class="text-center">Settlement</th>
                                        <th width="" class="text-center">Age</th>
                                        <th width="" class="text-center">Status</th>
                                        <th width="" class="text-center">Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $ttamt2 = $ttacb2 = $ttarr2 = $ttpnt2 = $ttset2 = 0;
                                    for ($i = 0; $i < sizeof($lnar2); $i++) {
                                        $ln_bal = ($lnar2[$i]->boc + $lnar2[$i]->boi + $lnar2[$i]->avdb + $lnar2[$i]->avpe); /* $lnar2[$i]->aboc + $lnar2[$i]->aboi + */
                                        ?>
                                        <tr id="trow_2">
                                            <td class="text-center"
                                                title="CNT ID: <?php echo '(' . $lnar2[$i]->ccnt . ') ' . $lnar2[$i]->cnnm; ?>">
                                                <strong><?= $lnar2[$i]->acno; ?></strong> <?php ; ?></td>
                                            <td class="text-center"><?= '(' . $lnar2[$i]->prcd . ') ' . $lnar2[$i]->prnm; ?></td>
                                            <td class="text-center"><?= $lnar2[$i]->sydt; ?></td>
                                            <td class="text-center"><?= $lnar2[$i]->madt; ?></td>
                                            <td class="text-center"><a href="#"
                                                                       title="Rental : <?= number_format($lnar2[$i]->inam, 2); ?>/="><?= $lnar2[$i]->noin . ' ' . $lnar2[$i]->pymd; ?></a>
                                            </td>
                                            <td class="text-right"><?= number_format($lnar2[$i]->loam, 0); ?>/=</td>
                                            <td class="text-right"><?= number_format($ln_bal, 2); ?></td>
                                            <td class="text-right"><?= number_format(($lnar2[$i]->aboc + $lnar2[$i]->aboi), 2); ?></td>
                                            <td class="text-right"><?= number_format($lnar2[$i]->avpe, 2); ?></td>
                                            <td class="text-right"><?= number_format($ln_bal - $lnar2[$i]->avcr, 2); ?></td>
                                            <td class="text-center"><?= $lnar2[$i]->cage ?></td>
                                            <td class="text-center"><?= $lnar2[$i]->stnm ?></td>
                                            <td class="text-center">
                                                <a href='#' id='b1' class='btn btn-default btn-condensed'
                                                   title='More Details' data-toggle="modal" data-target="#o1_mdt"
                                                   onclick="viewMoreDet(<?= $lnar2[$i]->lnid; ?>)">
                                                    <i class='fa fa-edit'></i></a>&nbsp;
                                                <a href='#' id='<?php echo $lnar2[$i]->acno; ?>'
                                                   class='btn btn-default btn-condensed b2' title='Account Step'
                                                   onclick="viewLagerPopup(<?= $lnar2[$i]->lnid; ?>,0,id)"
                                                   data-toggle="modal" data-target="#o1_leg"><i class='fa fa-book'></i></a>&nbsp;
                                                <?php
                                                if ($lnar2[$i]->cmnt > 0) {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed badge1' data-badge='" . $lnar2[$i]->cmnt . "'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar2[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                } else {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar2[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $ttamt2 = $ttamt2 + $lnar2[$i]->loam;
                                        $ttacb2 = $ttacb2 + ($lnar2[$i]->boc + $lnar2[$i]->boi);
                                        $ttarr2 = $ttarr2 + ($lnar2[$i]->aboc + $lnar2[$i]->aboi);
                                        $ttpnt2 = $ttpnt2 + $lnar2[$i]->avpe;
                                        $ttset2 = $ttset2 + $ln_bal - $lnar2[$i]->avcr;
                                    } ?>

                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">&nbsp;</th>
                                        <th width="90" class="text-right"><?= number_format($ttamt2, 0); ?>/=</th>
                                        <th width="90" class="text-right"><?= number_format($ttacb2, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttarr2, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttpnt2, 2); ?></th>
                                        <th width="90" class="text-right"><?= number_format($ttset2, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o6, 2); ?></th>
                                        <th colspan="2" class="text-center">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#acc_3">
                                Inactive Facilities (<?= sizeof($lnar3) ?>)
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body" id="acc_3">
                        <?php if (sizeof($lnar3) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-actions">
                                    <thead>
                                    <tr>
                                        <th width="" class="text-center">Facility No</th>
                                        <th width="" class="text-center">Product</th>
                                        <th width="" class="text-center">Started</th>
                                        <th width="" class="text-center">Maturity</th>
                                        <th width="" class="text-center">Period</th>
                                        <th width="" class="text-center">Facility</th>
                                        <th width="" class="text-center">Acc Balance</th>
                                        <th width="" class="text-center">Arrears</th>
                                        <th width="" class="text-center">Penalty</th>
                                        <th width="" class="text-center">Settlement</th>
                                        <th width="" class="text-center">Age</th>
                                        <th width="" class="text-center">Status</th>
                                        <th width="" class="text-center">Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                    <?php $tlmt3 = $tacb3 = $tarr3 = $tpnty3 = 0;
                                    for ($i = 0; $i < sizeof($lnar3); $i++) {
                                        $ln_bal = ($lnar3[$i]->boc + $lnar3[$i]->boi + $lnar3[$i]->avdb + $lnar3[$i]->avpe);
                                        ?>
                                        <tr id="trow_3">
                                            <td class="text-center"
                                                title="CNT ID: <?php echo '(' . $lnar3[$i]->ccnt . ') ' . $lnar3[$i]->cnnm; ?>">
                                                <strong><?= $lnar3[$i]->acno; ?></strong> <?php ; ?></td>
                                            <td class="text-center"><?= '(' . $lnar3[$i]->prcd . ') ' . $lnar3[$i]->prnm; ?></td>
                                            <td class="text-center"><?= $lnar3[$i]->sydt; ?></td>
                                            <td class="text-center"><?= $lnar3[$i]->madt; ?></td>
                                            <td class="text-center"><a href="#"
                                                                       title="Rental : <?= number_format($lnar3[$i]->inam, 2); ?>/="><?= $lnar3[$i]->lnpr . ' ' . $lnar3[$i]->pymd; ?></a>
                                            </td>
                                            <td class="text-right"><?= number_format($lnar3[$i]->loam, 0); ?>/=</td>
                                            <td class="text-right"><?= number_format($ln_bal, 2); ?></td>
                                            <td class="text-right"><?= number_format(($lnar3[$i]->aboc + $lnar3[$i]->aboi), 2); ?></td>
                                            <td class="text-right"><?= number_format($lnar3[$i]->avpe, 2); ?></td>
                                            <td class="text-right"><?= number_format($ln_bal - $lnar3[$i]->avcr, 2); ?></td>
                                            <td class="text-center"><?= $lnar3[$i]->cage ?></td>
                                            <td class="text-center"><?= $lnar3[$i]->stnm; ?></td>
                                            <td class="text-center">
                                                <a href='#' id='b1' class='btn btn-default btn-condensed'
                                                   title='More Details' data-toggle="modal" data-target="#o1_mdt"
                                                   onclick="viewMoreDet(<?= $lnar3[$i]->lnid; ?>)">
                                                    <i class='fa fa-edit'></i></a>&nbsp;
                                                <a href='#' id='<?php echo $lnar3[$i]->acno; ?>'
                                                   class='btn btn-default btn-condensed b2' title='Account Step'
                                                   onclick="viewLagerPopup(<?= $lnar3[$i]->lnid; ?>,0,id)"
                                                   data-toggle="modal" data-target="#o1_leg"><i class='fa fa-book'></i></a>&nbsp;
                                                <?php
                                                if ($lnar3[$i]->cmnt > 0) {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed badge1' data-badge='" . $lnar3[$i]->cmnt . "'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar3[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                } else {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar3[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                        <?php $tlmt3 = $tlmt3 + $lnar3[$i]->loam;
                                        $tacb3 = $tacb3 + $tacb3;
                                        $tarr3 = $tarr3 + $tarr3;
                                        $tpnty3 = $tpnty3 + $tpnty3;
                                    } ?>

                                    </tbody>
                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">&nbsp;</th>
                                        <th width="90" class="text-right"><?php echo number_format($tlmt3, 0); ?>/=</th>
                                        <th width="90" class="text-right"><?php echo number_format($tacb3, 2); ?></th>
                                        <th width="90" class="text-right"><?php echo number_format($tarr3, 2); ?></th>
                                        <th width="90" class="text-right"><?php echo number_format($tpnty3, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o5, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o6, 2); ?></th>
                                        <th colspan="2" class="text-center">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a href="#acc_4">
                                Terminate Facilities (<?= sizeof($lnar4) ?>)
                            </a>
                        </h4>
                    </div>
                    <div class="panel-body" id="acc_4">
                        <?php if (sizeof($lnar4) > 0) { ?>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-actions">
                                    <thead>
                                    <tr>
                                        <th width="" class="text-center">Facility No</th>
                                        <th width="" class="text-center">Product</th>
                                        <th width="" class="text-center">Started</th>
                                        <th width="" class="text-center">Maturity</th>
                                        <th width="" class="text-center">Period</th>
                                        <th width="" class="text-center">Facility</th>
                                        <th width="" class="text-center">Acc Balance</th>
                                        <th width="" class="text-center">Arrears</th>
                                        <th width="" class="text-center">Penalty</th>
                                        <th width="" class="text-center">Settlement</th>
                                        <th width="" class="text-center">Age</th>
                                        <th width="" class="text-center">Status</th>
                                        <th width="" class="text-center">Options</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tbody>
                                    <?php $tlmt4 = $tacb4 = $tarr4 = $tpnty4 = 0;
                                    for ($i = 0; $i < sizeof($lnar4); $i++) { ?>
                                        <tr id="trow_4">
                                            <td class="text-center"
                                                title="CNT ID: <?php echo '(' . $lnar4[$i]->ccnt . ') ' . $lnar4[$i]->cnnm; ?>">
                                                <strong><?= $lnar4[$i]->acno; ?></strong> <?php ; ?></td>
                                            <td class="text-center"><?= '(' . $lnar4[$i]->prcd . ') ' . $lnar4[$i]->prnm; ?></td>
                                            <td class="text-center"><?= $lnar4[$i]->sydt; ?></td>
                                            <td class="text-center"><?= $lnar4[$i]->madt; ?></td>
                                            <td class="text-center"><a href="#"
                                                                       title="Rental : <?= number_format($lnar4[$i]->inam, 2); ?>/="><?= $lnar4[$i]->lnpr . ' ' . $lnar4[$i]->pymd; ?></a>
                                            </td>
                                            <td class="text-right"><?= number_format($lnar4[$i]->loam, 0); ?>/=</td>
                                            <td class="text-right">**</td>
                                            <td class="text-right"><?= number_format(($lnar4[$i]->aboc + $lnar4[$i]->aboi), 2); ?></td>
                                            <td class="text-right"><?= number_format($lnar4[$i]->avpe, 2); ?></td>
                                            <td class="text-right">-</td>
                                            <td class="text-center"> *</td>
                                            <td class="text-center"><?= $lnar4[$i]->durg . ' Of ' . $lnar4[$i]->noin; ?></td>
                                            <td class="text-center">
                                                <a href='#' id='b1' class='btn btn-default btn-condensed'
                                                   title='More Details' data-toggle="modal" data-target="#o1_mdt"
                                                   onclick="viewMoreDet(<?= $lnar4[$i]->lnid; ?>)">
                                                    <i class='fa fa-edit'></i></a>&nbsp;
                                                <a href='#' id='<?php echo $lnar4[$i]->acno; ?>'
                                                   class='btn btn-default btn-condensed b2' title='Account Step'
                                                   onclick="viewLagerPopup(<?= $lnar4[$i]->lnid; ?>,0,id)"
                                                   data-toggle="modal" data-target="#o1_leg"><i class='fa fa-book'></i></a>&nbsp;
                                                <?php
                                                if ($lnar4[$i]->cmnt > 0) {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed badge1' data-badge='" . $lnar4[$i]->cmnt . "'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar4[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                } else {
                                                    echo " <a href='#' id='b3' class='btn btn-default btn-condensed'
                                                   title='Comments' data-toggle='modal' data-target='#o1_com'
                                                   onclick='loanCmment(" . $lnar4[$i]->lnid . ")'><i class='fa fa-comments'></i></a>";
                                                }
                                                ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $tlmt4 = $tlmt4 + $lnar4[$i]->loam;
                                        $tacb4 = $tacb4 + $tacb4;
                                        $tarr4 = $tarr4 + $tarr4;
                                        $tpnty4 = $tpnty4 + $tpnty4;
                                    } ?>

                                    </tbody>

                                    </tbody>
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">&nbsp;</th>
                                        <th width="90" class="text-right"><?php echo number_format($tlmt4, 0); ?>/=</th>
                                        <th width="90" class="text-right"><?php echo number_format($tacb4, 2); ?></th>
                                        <th width="90" class="text-right"><?php echo number_format($tarr4, 2); ?></th>
                                        <th width="90" class="text-right"><?php echo number_format($tpnty4, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o5, 2); ?></th>
                                        <th width="90" class="text-right"><?php //echo number_format($o6, 2); ?></th>
                                        <th colspan="2" class="text-center">&nbsp;</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- END ACCORDION -->
        </div>
    </div>
    <br/>

    <!-- POPUP -->
    <!-- Transfer Details -->
    <div class="modal" id="trsf_modal" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:80%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead">Transfer Details</h4>
                </div>
                <div class="modal-body ">
                    <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                        <table class="table table-bordered  table-actions" id="trsfTb" style="">
                            <thead>
                            <tr>
                                <th width="" class="text-center">Customer No</th>
                                <th width="" class="text-center">Branch</th>
                                <th width="" class="text-center">Officer</th>
                                <th width="" class="text-center">Center</th>
                                <th width="" class="text-center">Group</th>
                                <th width="" class="text-center">From</th>
                                <th width="" class="text-center">To</th>
                                <th width="" class="text-center">Duration</th>
                                <th width="" class="text-center">Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>

                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--MORE DETAILS-->
    <div class="modal" id="o1_mdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead">More Details : <span id="bb1"></span></h4>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Loan Type</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="lntyp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Loan Amount</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="lnamt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Charges</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="lndoc"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Inspection Date</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="insdt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Next Date</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="nxdt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Balance</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="bal"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Other Charges</label>
                                            <label class="col-md-8 col-xs-12 control-label" id="chrg"></label>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Product Type</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="lnprd"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Instalment</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="lnrnt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Charge Mode </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="chrmd"></label>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Distribute Date</label>
                                            <label class="col-md-8 col-xs-6 control-label" id="disdt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Maturity Date </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="mtdt"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Arrears </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="arbl"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Over Paymnt </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="ovpr"></label>
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

    <!-- LEDGER POPUP -->
    <div class="modal" id="o1_leg" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="width:95%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead">Loan No : <span id="aa1"></span></h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <!--                        <div class="col-md-12">-->

                        <div class="panel panel-default tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Account Step</a>
                                </li>
                                <li><a href="#tab2" role="tab" data-toggle="tab">Schedule</a></li>
                                <li><a href="#tab3" role="tab" data-toggle="tab">Payment</a></li>
                                <li><a href="#tab4" role="tab" data-toggle="tab">Contract Entry</a></li>
                                <li><a href="#tab5" role="tab" data-toggle="tab">Charges </a></li>
                                <li><a href="#tab6" role="tab" data-toggle="tab">Payment Chart </a></li>
                            </ul>
                            <div class="panel-body tab-content">
                                <div class="tab-pane active" id="tab1">

                                    <div class="row">
                                        <div class="form-group">
                                            <input type="hidden" id="aclnid">
                                            <input type="hidden" id="aclnno">
                                            <div class="col-md-5 pull-right">
                                                <td class="text-center">
                                                    <a harf="#" id="0" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> All </span></a>
                                                    <a harf="#" id="2" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> Payment </span></a>
                                                    <a harf="#" id="3" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> PRM </span></a>
                                                    <a harf="#" id="4" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> Penalty </span></a>
                                                    <a harf="#" id="5" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> Cancel </span></a>
                                                    <a harf="#" id="1" onclick="lagerVw(this.id)" class="btn"> <span
                                                                id="x1"> Other</span></a>
                                                    <input type="button" name="print" id="prnt"
                                                           class="btn btn-info btn-sm"
                                                           onclick="leadgerPrint(document.getElementById('aclnid').value)"
                                                           value="Print"/>
                                                </td>
                                            </div>
                                        </div>
                                    </div>
                                    <!--                                        <div class="modal-body">-->
                                    <div class="row">
                                        <div class="modal-body scroll" style="height:400px;" id="ac_stp">
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
                                                        <th class="text-center">AGE</th>
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
                                    <!--                                        </div>-->

                                </div>
                                <div class="tab-pane" id="tab2">

                                    <div class="row">
                                        <div class="modal-body scroll" style="height:400px;" id="ac_stp">
                                            <div class="table-responsive">
                                                <table class="table datatable table-bordered table-striped table-actions"
                                                       id="sch_tbl" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">schedule Dates</th>
                                                        <th class="text-center">Installments</th>
                                                        <th class="text-center">payments</th>
                                                        <th class="text-center">cap</th>
                                                        <th class="text-center">int</th>
                                                        <th class="text-center">cap due</th>
                                                        <th class="text-center">int due</th>
                                                        <th class="text-center">ttl due</th>
                                                        <th class="text-center">is scheduled</th>
                                                        <th class="text-center">Paid Date</th>
                                                    </tr>
                                                    </thead>

                                                    <tfoot>
                                                    <th></th>
                                                    <th></th>
                                                    <th id="ttl_rntl"></th>
                                                    <th id="ttl_pymt"></th>
                                                    <th id="ttl_capt"></th>
                                                    <th id="ttl_int"></th>
                                                    <th id="ttl_ducp"></th>
                                                    <th id="ttl_duin"></th>
                                                    <th id="ttl_due"></th>
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
                                <div class="tab-pane" id="tab3">

                                    <div class="row">
                                        <div class="modal-body scroll" style="height:400px;" id="ac_stp">
                                            <div class="table-responsive">
                                                <table class="table datatable table-bordered table-striped table-actions"
                                                       id="pymt_tbl" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">Recipt No</th>
                                                        <th class="text-center">pay amount</th>
                                                        <th class="text-center">payment Date</th>
                                                        <th class="text-center">create user</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
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
                                <div class="tab-pane" id="tab4">

                                    <div class="row">
                                        <div class="modal-body scroll" style="height:400px;" id="ac_stp">
                                            <div class="table-responsive">
                                                <table class="table datatable table-bordered table-striped table-actions"
                                                       id="accl_tbl" width="100%">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th class="text-center">acc Date</th>
                                                        <th class="text-center">description</th>
                                                        <th class="text-center">referance</th>
                                                        <th class="text-center">acc split</th>
                                                        <th class="text-center">debit</th>
                                                        <th class="text-center">credit</th>
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
                                                    </tfoot>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <!-- TAB 5 CHARGES -->
                                <div class="tab-pane" id="tab5">
                                    <div class="row">
                                        <P>DDD</P>
                                    </div>
                                </div>
                                <!-- TAB 6 PAYMENT CHART -->
                                <div class="tab-pane" id="tab6">

                                </div>

                            </div>
                        </div>
                        <!--                        </div>-->
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END LEDGER POPUP -->

    <!-- LOAN COMMENT -->
    <div class="modal" id="o1_com" tabindex="-1" role="dialog" aria-labelledby="largeModalHead"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="largeModalHead"><span class="fa fa-comments"></span> Loan Status
                        Comments</h4>
                </div>
                <div class="modal-body">

                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body content-frame-body-left">
                        <div class="messages messages-img">
                            <div id="cmmnt">
                            </div>
                        </div>

                        <div class="panel panel-default push-up-10">
                            <div class="panel-body panel-body-search">

                                <form class="" id="cmnt_add" name="cmnt_add" action="" method="post">
                                    <div class="input-group">
                                        <input type="text" name="cmnt" id="cmnt" class="form-control" required
                                               placeholder="Your comment..."/>

                                        <input type="hidden" name="lnid" id="lnid">
                                        <div class="input-group-btn">
                                            <button type="submit" class="btn btn-default">Send</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>
                    <!-- END CONTENT FRAME BODY -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!--/ -->

</div>
<!-- PAGE CONTENT WRAPPER -->


<script type="text/javascript">

    $().ready(function () {

        $('#trsfTb').DataTable({
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        $('#stp_tbl').DataTable({
            destroy: true,
            "cache": false,
        });

        $('#sch_tbl').DataTable({
            destroy: true,
            "cache": false,
        });

        $('#pymt_tbl').DataTable({
            destroy: true,
            "cache": false,
        });

        $('#accl_tbl').DataTable({
            destroy: true,
            "cache": false,
        });

        getCmnCunt();
    });

    // GET CUSTOMER COMMENT COUNT
    function getCmnCunt() {
        var cuid = document.getElementById('cuid').value;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getUnseenCustCommnt",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                if (len > 0) {
                    document.getElementById("cus_cmnt").setAttribute("class", "badge1");
                    document.getElementById("cus_cmnt").setAttribute("data-badge", len);
                } else {
                    document.getElementById("cus_cmnt").removeAttribute("class");
                    document.getElementById("cus_cmnt").removeAttribute("data-badge");
                }
            }
        })
    }


    function DifferenceInDays(firstDate, secondDate) {
        return Math.round((secondDate - firstDate) / (1000 * 60 * 60 * 24));
    }

    // CUSTOMER TRANSFER HISTORY DETAILS
    $("#trfsBtn").on('click', function (e) { // add form
        e.preventDefault();
        var cuid = document.getElementById('cuid').value;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getNicCusttrnsfer",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                $('#trsfTb').DataTable().clear();

                var t = $('#trsfTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1, 2, 3]},
                        {className: "text-center", "targets": [0, 4, 5, 6]},
                        {className: "text-right", "targets": [0, 7]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '10%'},
                        {sWidth: '10%'},    // br
                        {sWidth: '15%'},
                        {sWidth: '15%'},    // cnt
                        {sWidth: '5%'},     //
                        {sWidth: '10%'},     // frdt
                        {sWidth: '10%'},     // todt
                        {sWidth: '10%'},     // todt
                        {sWidth: '15%'}
                    ],
                    "rowCallback": function (row, data, index) {
                        var curnt = data[7],
                            //  duam = parseFloat(data[8]),
                            // pnlt = parseFloat(data[6]),
                            $node = this.api().row(row).nodes().to$();

                        if (curnt == '-') {
                            $node.addClass('info')
                        }
                        /* else if (pymt < 0) {
                         $node.addClass('danger')
                         } else if (duam > 0 && pnlt > 0) {
                         $node.addClass('danger')
                         }*/
                    },
                    // "order": [[5, "ASC"]], //ASC  desc
                });
                // t.clear().draw();
                for (var i = 0; i < len; i++) {
                    var a = moment(response[i]['frdt'], 'YYYY/MM/DD');
                    var b = moment(response[i]['todt'], 'YYYY/MM/DD');
                    var days = b.diff(a, 'd');

                    if (days < 0) { //|| days == 0
                        var dur = "-";
                        var todt = 'Still';
                    } else {
                        var dur = days + " Days";
                        var todt = response[i]['todt'];
                    }

                    t.row.add([
                        response[i]['cuno'],
                        response[i]['brnm'],
                        response[i]['usnm'],
                        response[i]['cnnm'],
                        response[i]['grno'],
                        response[i]['frdt'],
                        todt,
                        dur,
                        response[i]['trrs']
                    ]).draw(false);
                }
            }
        })

    });
    // END CUSTOMER TRANSFER

    // ACCOUNT LEDGER POPUP
    function viewLagerPopup(id, typ, no) {  // id-loan id/typ - / no-loan no
        viewLager(id, typ, no);
        viewSche(id);
        viewPymt(id);
        viewAccEnty(id);
    }

    function viewLager(id, typ, no) {
        $('#aa1').text(no); // LOAN NO
        document.getElementById('aclnid').value = id;
        document.getElementById('aclnno').value = no;

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
                {className: "text-right", "targets": [4, 5, 6, 7, 8, 9, 10, 11]},
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
                url: '<?= base_url(); ?>user/getLoanLeg',
                type: 'post',
                data: {
                    lnid: id,
                    typ: typ
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
                    return "TEST";
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));
                $(api.column(7).footer()).html(numeral(t7).format('0,0.00'));
                $(api.column(8).footer()).html(numeral(t8).format('0,0.00'));
                $(api.column(9).footer()).html(numeral(t9).format('0,0.00'));
                if (typ == '1' | typ == null) {
                    $(api.column(10).footer()).html("CA: " + parseFloat(intVal(arreas / prim)).toFixed(2));
                } else {
                    $(api.column(10).footer()).html(numeral(t10).format('0,0.00'));
                }
            },
        });

    }
    // END ACCOUNT LEDGER POPUP

    //LEDGER POPUP CATEGORY CHANG
    function lagerVw(typ) {
        var id = document.getElementById('aclnid').value;
        var no = document.getElementById('aclnno').value;

        viewLager(id, typ, no);
        $('#' + typ).addClass("dclg").siblings().removeClass("dclg");
    }
    // END POPUP CATEGORY CHANG


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

    function number_format(number, decimals, decPoint, thousandsSep) {
        decimals = Math.abs(decimals) || 0;
        number = parseFloat(number);

        if (!decPoint || !thousandsSep) {
            decPoint = '.';
            thousandsSep = ',';
        }

        var roundedNumber = Math.round(Math.abs(number) * ('1e' + decimals)) + '';
        var numbersString = decimals ? (roundedNumber.slice(0, decimals * -1) || 0) : roundedNumber;
        var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
        var formattedNumber = "";

        while (numbersString.length > 3) {
            formattedNumber += thousandsSep + numbersString.slice(-3)
            numbersString = numbersString.slice(0, -3);
        }

        if (decimals && decimalsString.length === 1) {
            while (decimalsString.length < decimals) {
                decimalsString = decimalsString + decimalsString;
            }
        }

        return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
    }

    function calc_rate(pv, payno, pmt) {
        var gh = parseFloat(100); // maximum value
        var gm = parseFloat(2.5); // first guess
        var gl = parseFloat(0); // minimum value
        var gp = parseFloat(0); // result of test calculation

        do {
            gp = calc_payment(pv, payno, gm, 6);

            if (gp > pmt) { // guess is too high
                gh = gm;
                gm = gm + gl;
                gm = gm / 2;
            }
            if (gp < pmt) { // guess is too low
                gl = gm;
                gm = gm + gh;
                gm = gm / 2;
            }
            if (gm == gh) break;
            if (gm == gl) break;
            int = number_format(gm, 9, ".", ""); // round it to 9 decimal places

        } while (gp !== pmt);

        console.log('int ' + int)

        return int;
    }

    function calc_payment(pv, payno, int, accuracy) {
        // check that required values have been supplied
        var int = int / 100;
        var value1 = int * Math.pow((1 + int), payno);
        var value2 = Math.pow((1 + int), payno) - 1;
        var pmt = pv * (value1 / value2);
        var pmt = number_format(pmt, accuracy, ".", ",");

        console.log('pmt ' + pmt + " xx" + Math.pow(4, 3))

        return pmt;
    }


    // VIEW LOAN SCHEDUL
    function viewSche(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getLoanSch",
            data: {
                lnid: id
            },
            dataType: 'json',
            success: function (response) {

                $('#sch_tbl').DataTable().clear();
                var t = $('#sch_tbl').DataTable({
                    "destroy": true,
                    "cache": false,
                    //"scrollY": "400px",
                    "scrollCollapse": true,
                    "searching": false,
                    "paging": false,
                    "processing": true,
                    //"serverSide": true,
                    "language": {
                        processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
                    },
                    "columnDefs": [
                        {className: "text-center", "targets": [0, 1, 9, 10]},
                        {className: "text-left", "targets": []},
                        {className: "text-right", "targets": [2, 3, 4, 5, 6, 7, 8]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '10%'},
                        {sWidth: '5%'},
                        {sWidth: '5%'},
                        {sWidth: '5%'}, // CAP
                        {sWidth: '5%'},
                        {sWidth: '5%'}, // PNLT
                        {sWidth: '5%'},
                        {sWidth: '5%'}, // DUE
                        {sWidth: '5%'},
                        {sWidth: '5%'}
                    ],
                    // "order": [[5, "ASC"]], //ASC  desc
                });

                var len1 = response['lndt'].length;         // loan details
                var now2 = response['lndt'][0]['sydt'];
                var prmd = response['lndt'][0]['prtp'];     // 1 - reducing / 2 - flate
                var prdtp = response['lndt'][0]['prdtp'];   // 3,6- DL / 4,7 - WK / 5,8 - ML

                var lnamt = response['lndt'][0]['loam'];    // loan amount
                var noins = response['lndt'][0]['noin'];    // no of installment
                var inrt = response['lndt'][0]['inra'];     // interest rate

                // var pymt = response['lndt'][0]['inam'];     //
                var principal = lnamt;
                var int = inrt;
                var ins = noins;

                if (prdtp == 3 || prdtp == 6) {         // DL  & DDL
                    var dts = 1;

                    var mm = response['lndt'][0]['inam'];   // PREMIUM
                    var aa = response['lndt'][0]['inta'];   // TOTAL INTEREST
                    var ins = response['lndt'][0]['inam'];  // NO OF INSTALLMENT
                    pymt = parseFloat(mm).toFixed(2);

                    //var ins = noins;           // NO OF INSTALLMENT 50
                    var mm2 = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                    var aa2 = (+mm * +noins) - lnamt;            // Total int
                    //      $rate = calc_rate($principal, $number, $payment);
                    console.log(lnamt + ' * ' + noins + ' * ' + mm)
                    //var ss = calc_rate(lnamt, noins, mm);
                    //console.log(ss);
                    // var int = 0.526469341;
                    // console.log('ins ' + ins + 'mm ' + mm + 'aa ' + aa + ' **** ' + ' mm2 ' + mm2 + 'aa2 ' + aa2 + 'pymt ' + pymt);
                    //var pmt_int = int / 1200;
                    //var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));

                    var totprin = 0;
                    var ttlint = 0;
                    var ttlcap = 0;
                    var ttlrnt = 0;


                } else if (prdtp == 4) {  // WK
                    var dts = 7;
                    var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                    var aa = (+mm * +noins) - lnamt;            // Total int
                    var totalInterest = aa;
                    var pmt_int = int / 1200;
                    var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));
                    pymt = parseFloat(mm).toFixed(2);

                } else if (prdtp == 7) {  // DWK

                    var dts = 7;
                    var mnth = (+noins / 4);
                    var mm = (+lnamt + (((+lnamt * +inrt) / 100) * +mnth)) / +noins;
                    var aa = ((+lnamt * +inrt) / 100) * +mnth;
                    pymt = parseFloat(mm).toFixed(2);

                } else if (prdtp == 5 || prdtp == 8) {  // ML & DML
                    var dts = 30;
                }

                var date = new Date(now2);

                // Reducing
                if (prmd == 1) {

                    var totprin = 0;
                    /*var ttlint = 0;
                     var ttlcap = 0;
                     var ttlrnt = 0;
                     var ttlpymt = 0;*/

                    var ttl_rntl = 0;
                    var ttl_pymt = 0;
                    var ttl_capt = 0;
                    var ttl_int = 0;
                    var ttl_ducp = 0;
                    var ttl_duin = 0;
                    var ttl_due = 0;
                    for (var i = 0; i < noins; i++) {
                        // SCHEDUL DATE
                        var newdate = new Date(date);
                        newdate.setDate(newdate.getDate() + +dts);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var y = newdate.getFullYear();
                        if (dd < 10) {
                            var dd2 = "0" + dd;
                        } else {
                            var dd2 = dd;
                        }
                        if (mm < 10) {
                            var mm2 = "0" + mm;
                        } else {
                            var mm2 = mm;
                        }
                        var nxdate = y + '-' + mm2 + '-' + dd2;
                        // END SCHEDUL DATE

                        // SCHEDULE DATA
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
                        // END SCHEDULE DATA

                        // GET PAYMENT DETAILS
                        var ln = response['lgdt'].length;
                        var avcp = avin = ttl = 0;
                        var ledt = '-';

                        for (var x = 0; x < ln; x++) {
                            if (nxdate == response['lgdt'][x]['ledt']) {
                                var vv = response['lgdt'][x]['ledt'];

                                var avcp = +response['lgdt'][x]['avcp'] * -1;
                                var avin = +response['lgdt'][x]['avin'] * -1;
                                var ttl = response['lgdt'][x]['ttl'];

                                if (ttl >= response['lndt'][0]['inam']) {
                                    ttl = ttl;
                                    var ledt = response['lgdt'][x]['ledt'];
                                } else {
                                    ttl = 0;
                                    var ledt = '-';
                                }
                                // console.log('nxdate ' + nxdate + '* ' + vv + ' avcp ' + avcp + ' avin ' + avin + ' ttl' + ttl);

                            } else {
                                var vv = '-';
                                // console.log('nxdate ' + nxdate + '* ' + vv);
                            }
                        }
                        // END PAYMENT DETAILS

                        var inst = (response['lndt'][0]['inam']);

                        if (ttl >= inst) {
                            var ducp = 0;
                            var duit = 0;
                        } else {
                            var ducp = (  +pycap - +avcp );
                            var duit = (  +pyint - +avin);
                        }

                        var ttdu = ( +ducp + +duit);

                        if (inst == ttdu)
                            var st = 'Pending';
                        else if (inst > ttdu && ttdu > 0)
                            var st = 'Pending';
                        else if (ttdu < 1)
                            var st = 'Yes';

                        //console.log('pycap ' + pycap + 'pyint ' + pyint + 'avcp ' + avcp + 'avin ' + avin);

                        t.row.add([
                            i + 1,
                            nxdate, // NEXT DATE
                            numeral(inst).format('0,0.00'),   // RENTAL
                            numeral(ttl).format('0,0.00'),    // PAYMENT
                            numeral(avcp).format('0,0.00'),   // CAP
                            numeral(avin).format('0,0.00'),   // INT
                            numeral(ducp).format('0,0.00'),   // DUE CAP
                            numeral(duit).format('0,0.00'),   // DUE INT

                            // pycap + ' | ' + avcp + '|' + numeral(ducp).format('0,0.00'),   // DUE CAP
                            // pyint + ' | ' + avin + '|' + numeral(duit).format('0,0.00'),   // DUE INT
                            numeral(ttdu).format('0,0.00'),
                            st,
                            ledt
                        ]).draw(false);

                        date = nxdate;
                        ttl_rntl = +ttl_rntl + +inst;
                        ttl_pymt = +ttl_pymt + +ttl;
                        ttl_capt = +ttl_capt + +avcp;
                        ttl_int = +ttl_int + +avin;
                        ttl_ducp = +ttl_ducp + +ducp;
                        ttl_duin = +ttl_duin + +duit;
                        ttl_due = +ttl_due + +ttdu;

                        totInsamount = parseFloat(Math.round((+totInsamount + +pymt) * 100) / 100).toFixed(2);
                        totInt = parseFloat(Math.round((+totInt + +pyint) * 100) / 100).toFixed(2);
                        totprin = parseFloat(Math.round((+totprin + +pycap) * 100) / 100).toFixed(2);
                    }
                    $('#ttl_rntl').text(numeral(ttl_rntl).format('0,0.00'));
                    $('#ttl_pymt').text(numeral(ttl_pymt).format('0,0.00'));
                    $('#ttl_capt').text(numeral(ttl_capt).format('0,0.00'));
                    $('#ttl_int').text(numeral(ttl_int).format('0,0.00'));
                    $('#ttl_ducp').text(numeral(ttl_ducp).format('0,0.00'));
                    $('#ttl_duin').text(numeral(ttl_duin).format('0,0.00'));
                    $('#ttl_due').text(numeral(ttl_due).format('0,0.00'));

                } else if (prmd == 2) {  // Flat

                    var lnamt = response['lndt'][0]['loam'];     // loan amount
                    var noins = response['lndt'][0]['noin'];     // no of installment
                    var inrt = response['lndt'][0]['inra'];       // interest rate
                    // var prdct = document.getElementById('prd_cat').value;      // product catogry ( 3-DL / 4-WK/ 5-ML)
                    // var prdmd = document.getElementById('prd_md').value;       // product mode ( 1-redusing / 2-flat rate)

                    principal = lnamt;
                    int = inrt;

                    var totInsamount = 0;
                    var totInt = 0;
                    var totprin = 0;

                    var mm = -PMT((inrt / 100), noins, lnamt);  // 1 rental payment
                    var aa = (+mm * +noins) - lnamt;            // Total int
                    var totalInterest = aa;
                    ins = noins;

                    var ttlint = 0;
                    var ttlcap = 0;
                    var ttlrnt = 0;
                    var ttlpymt = 0;

                    var pybcap = parseFloat(Math.round((principal / ins) * 100) / 100).toFixed(2);
                    var pybint = parseFloat(+mm - +pybcap).toFixed(2);

                    var pybrntl = parseFloat(mm).toFixed(2);

                    for (var i = 0; i < noin; i++) {
                        // SCHEDUL DATE
                        var newdate = new Date(date);
                        newdate.setDate(newdate.getDate() + 7);
                        var dd = newdate.getDate();
                        var mm = newdate.getMonth() + 1;
                        var y = newdate.getFullYear();

                        if (dd < 10) {
                            var dd2 = "0" + dd;
                        } else {
                            var dd2 = dd;
                        }
                        if (mm < 10) {
                            var mm2 = "0" + mm;
                        } else {
                            var mm2 = mm;
                        }
                        var nxdate = y + '-' + mm2 + '-' + dd2;
                        // END SCHEDUL DATE

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
                            i + 1,
                            nxdate,
                            parseFloat(response['lndt'][0]['inam']).toFixed(2),
                            '-',
                            '-',
                            '-',
                            pybcap,
                            pybint,
                            pybrntl,
                            '-',
                            '-'
                        ]).draw(false);

                        date = nxdate;
                        ttlrnt = +ttlrnt + +response['lndt'][0]['inam'];
                        ttlint = +ttlint + +pybint;
                        ttlpymt = +ttlpymt + +pybrntl;
                        ttlcap = +ttlcap + +pybcap;
                    }
                    /*$('#ttl_rntl').text(parseFloat(ttlrnt).toFixed(2));
                     $('#ttl_due').text(parseFloat(ttlpymt).toFixed(2));
                     $('#ttl_duin').text(parseFloat(ttlint).toFixed(2));
                     $('#ttl_ducp').text(parseFloat(ttlcap).toFixed(2));*/
                    $('#ttl_rntl').text(numeral(ttlrnt).format('0,0.00'));
                    $('#ttl_due').text(numeral(ttlpymt).format('0,0.00'));
                    $('#ttl_duin').text(numeral(ttlint).format('0,0.00'));
                    $('#ttl_ducp').text(numeral(ttlcap).format('0,0.00'));
                }
            }
        })
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

        principal = lnamt;
        int = inrt;

        var totInsamount = 0;
        var totInt = 0;
        var totprin = 0;

        if (prdmd == 1) {   // Redusing

            if (prdct == 3) {  // Daily product
                var noins = document.getElementById('dyn_dura').value;     // no of installment
                var dytp = document.getElementById('dytp').value;       // product type

                if (dytp == 5) {
                    var dts = 22;
                } else if (dytp == 6) {
                    var dts = 26;
                } else if (dytp == 7) {
                    var dts = 30;
                }

                var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);   // 1 rental payment
                var aa = ( ((+noins / 30) * +dts) * ((mm / 10) * 10)  ) - +lnamt;                           // Total int
                var totalInterest = aa;

                noins = (noins / 30) * dts;
                ins = noins;

                //console.log(ins)
                var pmt_int = int / 1200;
                var pymt = pmt_int * -principal * Math.pow((1 + pmt_int), ins) / (1 - Math.pow((1 + pmt_int), ins));

                pymt = parseFloat(mm).toFixed(2);

                var totprin = 0;

                var ttlint = 0;
                var ttlcap = 0;
                var ttlrnt = 0;

                //principal  = mm;

                principal = mm * ins;

                t.clear().draw();
                for (var i = 1; i <= ins; i++) {

                    var pyint = (+principal * +int / 100);

                    //console.log('py1 ' + pyint + ' pr ' + principal + ' int ' + int)

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
                        //console.log(principal+ '**'+ (Math.round((+totprin + +pycap) / 1) * 1) );

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

                    //console.log('py1 ' + pyint + 'pr ' + principal + 'int ' + int)

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
                        //console.log(principal+ '**'+ (Math.round((+totprin + +pycap) / 1) * 1) );

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
                var noins = document.getElementById('dyn_dura').value;     // no of installment
                var dytp = document.getElementById('dytp').value;       // product type

                if (dytp == 5) {
                    var dts = 22;
                } else if (dytp == 6) {
                    var dts = 26;
                } else if (dytp == 7) {
                    var dts = 30;
                }

                var mm = (+lnamt + (((+lnamt * +inrt) / 100) * (+noins / 30) )) / ((+noins / 30) * +dts);   // 1 rental payment
                var aa = ( ((+noins / 30) * +dts) * ((mm / 10) * 10)  ) - +lnamt;                           // Total int
                var totalInterest = aa;
                noins = (noins / 30) * dts;
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
            //var pybcap = parseFloat(Math.round((principal / ins) * 100) / 100).toFixed(2);
            //var pybint = parseFloat(Math.round((((principal / 100) * (int * (ins / 12))) / ins) * 100) / 100).toFixed(2);
            var pybint = parseFloat(+mm - +pybcap).toFixed(2);

            // var pybrntl = parseFloat(Math.round((+pybcap + +pybint) * 100) / 100).toFixed(2);
            var pybrntl = parseFloat(mm).toFixed(2);

            // console.log(principal + ' **' + ins);
            // console.log(pybcap + ' **' + pybint);

            t.clear().draw();
            for (var i = 1; i <= ins; i++) {
                principal = parseFloat(Math.round((+principal - pybcap) * 100) / 100).toFixed(2);

                //console.log('py1 ' + pybint + 'pr ' + principal + 'int' + int)

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

    // VIEW LOAN PAYMENT
    function viewPymt(id) {
        $('#pymt_tbl').DataTable().clear();
        $('#pymt_tbl').DataTable({
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
                {className: "text-center", "targets": [0, 3]},
                {className: "text-left", "targets": [1]},
                {className: "text-right", "targets": [2]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>user/getLoanPymnt',
                type: 'post',
                data: {
                    lnid: id
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
                //COLUMN 2 TTL
                var t4 = api.column(2).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(2).footer()).html(numeral(t4).format('0,0.00'));
            },
        });

    }

    // VIEW LOAN PAYMENT
    function viewAccEnty(id) {
        $('#accl_tbl').DataTable().clear();
        $('#accl_tbl').DataTable({
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
                {className: "text-left", "targets": [1, 2, 3, 4]},
                {className: "text-right", "targets": [5, 6]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "aoColumns": [
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '10%'},
                {sWidth: '15%'},
                {sWidth: '15%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],

            "ajax": {
                url: '<?= base_url(); ?>user/getLnaccEnty',
                type: 'post',
                data: {
                    lnid: id
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
                //COLUMN 5 TTL
                var t5 = api.column(5).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                //COLUMN 6 TTL
                var t6 = api.column(6).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

                // Update footer by showing the total with the reference of the column index
                $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));

            },
        });

    }

    // VIEW LOAN COMMENT
    function loanCmment(lnid) {
        document.getElementById('lnid').value = lnid;
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getLoanCommnt",
            data: {
                lnid: lnid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                var str = "";
                for (var i = 0; i < len; i++) {
                    var y = 0;

                    if (i > 0) {
                        y = i - 1;
                        if (response[y]['crby'] === response[i]['crby']) {

                            if (x == 'in') {
                                var x = "in";
                            } else {
                                var x = "";
                            }
                        } else {
                            if (x == 'in') {
                                var x = "";
                            } else {
                                var x = "in";
                            }
                        }
                    } else {
                        var x = "in";
                    }

                    if (response[i]['cmmd'] == 0) {
                        var m = "Red";
                    } else {
                        var m = "";
                    }
                    str = str + '<div class="item item-visible ' + x + '">' +
                        '<div class="image"><img src="../uploads/user_default.png" alt="John Doe"></div>' +
                        '<div class="text"  style="border-color: ' + m + '"> <div class="heading"><a href="#"> ' + response[i]['usr'] + '</a>' +
                        '<span class="date">' + response[i]['crdt'] + '</span></div>' + response[i]['cmnt'] + '</div> </div> ';
                }
                //append the markup to the DOM
                $("#cmmnt").html(str);
            }
        })
    }

    // LOAN COMMENT ADD
    $("#cmnt_add").submit(function (e) {
        e.preventDefault();
        var lnid = document.getElementById('lnid').value;

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>User/addLncmnt",
            data: $("#cmnt_add").serialize(),
            dataType: 'json',
            success: function (data) {
                //swal("Success!", " ", "success");
                document.getElementById('cmnt').value = '';
                loanCmment(lnid);

            },
            error: function () {
                swal("Failed!", "", "error");
            }
        });
    });

    // VIEW CUSTOMER COMMENT
    function custCmment() {
        var cuid = document.getElementById('cuid').value;
        document.getElementById('ccuid').value = cuid;

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/getCustCommnt",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                var str = "";
                for (var i = 0; i < len; i++) {
                    var y = 0;

                    if (i > 0) {
                        y = i - 1;
                        if (response[y]['crby'] === response[i]['crby']) {

                            if (x == 'in') {
                                var x = "in";
                            } else {
                                var x = "";
                            }
                        } else {
                            if (x == 'in') {
                                var x = "";
                            } else {
                                var x = "in";
                            }
                        }
                    } else {
                        var x = "in";
                    }

                    if (response[i]['cmmd'] == 0) {
                        var m = "Red";
                    } else {
                        var m = "";
                    }
                    str = str + '<div class="item item-visible ' + x + '">' +
                        '<div class="image"><img src="../uploads/user_default.png" alt="John Doe"></div>' +
                        '<div class="text"  style="border-color: ' + m + '"> <div class="heading"><a href="#"> ' + response[i]['usr'] + '</a>' +
                        '<span class="date">' + response[i]['crdt'] + '</span></div>' + response[i]['cmnt'] + '</div> </div> ';
                }
                //append the markup to the DOM
                $("#cust_cmmnt").html(str);
            }
        })

    }

    // CUSTOMER COMMENT ADD
    $("#cust_cmnt_add").submit(function (e) {
        e.preventDefault();
        var ccuid = document.getElementById('ccuid').value;

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>User/addCustcmnt",
            data: $("#cust_cmnt_add").serialize(),
            dataType: 'json',
            success: function (data) {
                //swal("Success!", " ", "success");
                document.getElementById('cust_cmnt').value = '';
                custCmment();
                getCmnCunt();
            },
            error: function () {
                swal("Failed!", "", "error");
            }
        });
    });

    // CUSTOMER COMMENT SEEN
    function custCommntSeen() {
        var cuid = document.getElementById('cuid').value;

        var jqXHR = jQuery.ajax({
            type: "POST",
            url: "<?= base_url(); ?>User/custCommntSeen",
            data: {
                cuid: cuid
            },
            dataType: 'json',
            success: function (data) {
                getCmnCunt();
            },
            error: function () {
                swal("Failed!", "", "error");
            }
        });
    };

    // VIEW LOAN MORE DETAILS
    function viewMoreDet(lnid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewMoreDetails",
            data: {
                lnid: lnid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("bb1").innerHTML = response[i]['acno'];
                    document.getElementById("lntyp").innerHTML = response[i]['lntpnm'];

                    document.getElementById("lnamt").innerHTML = numeral(response[i]['loam']).format('0,0.00');
                    document.getElementById("lndoc").innerHTML = "<span style='color: red'>DOC </span>" + parseFloat(response[i]['docg']).toFixed(2) + "| <span style='color: red'>INS </span>" + parseFloat(response[i]['incg']).toFixed(2);
                    document.getElementById("insdt").innerHTML = response[i]['indt'];
                    document.getElementById("nxdt").innerHTML = response[i]['nxdd'];
                    document.getElementById("bal").innerHTML = "<span style='color: red'>CAP </span>" + numeral(response[i]['boc']).format('0,0.00') + "| <span style='color: red'>INT </span>" + numeral(response[i]['boi']).format('0,0.00');
                    document.getElementById("chrg").innerHTML = "<span style='color: red'>SVCH </span>" + numeral(response[i]['avdb']).format('0,0.00') + "| <span style='color: red'>PNLT </span>" + numeral(response[i]['avpe']).format('0,0.00');

                    document.getElementById("chrmd").innerHTML = response[i]['chrmd'];

                    document.getElementById("lnprd").innerHTML = response[i]['prna'];
                    document.getElementById("lnrnt").innerHTML = response[i]['lnpr'] + ' (' + response[i]['pymd'] + ') x ' + numeral(response[i]['inam']).format('0,0.00');
                    document.getElementById("disdt").innerHTML = response[i]['acdt']; //
                    document.getElementById("mtdt").innerHTML = response[i]['madt'];
                    document.getElementById("arbl").innerHTML = "<span style='color: red'>CAP </span>" + numeral(response[i]['aboc']).format('0,0.00') + "| <span style='color: red'>INT </span>" + numeral(response[i]['aboi']).format('0,0.00');
                    document.getElementById("ovpr").innerHTML = numeral(response[i]['avcr']).format('0,0.00');

                    document.getElementById("lnsts").innerHTML = response[i]['stnm'];
                    document.getElementById("prid").innerHTML = response[i]['prid'] + ' lnid :' + lnid;
                }
            }
        })

    }

    // LEDGER PRINT
    function leadgerPrint(lnid) {
        //console.log(lnid);
        var w = window.open('about:blank', '_blank');
        w.location.href = '<?= base_url(); ?>Report/printLoanleg/' + lnid;
    }

    // PAYMENT CHART GRAFT
    function paymentChrt() {

        $("#dashboard-line-1").addClass("panel-fullscreen");

        /* Line dashboard chart */
        Morris.Line({
            element: 'dashboard-line-1',
            data: [
                {y: '2014-10-10', a: 2, b: 4},
                {y: '2014-10-11', a: 4, b: 6},
                {y: '2014-10-12', a: 7, b: 10},
                {y: '2014-10-13', a: 5, b: 7},
                {y: '2014-10-14', a: 6, b: 9},
                {y: '2014-10-15', a: 9, b: 12},
                {y: '2014-10-16', a: 18, b: 20}
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Sales', 'Event'],
            resize: true,
            hideHover: true,
            xLabels: 'day',
            gridTextSize: '10px',
            lineColors: ['#3FBAE4', '#33414E'],
            gridLineColor: '#E5E5E5'
        });
        /* EMD Line dashboard chart */

    }

</script>

