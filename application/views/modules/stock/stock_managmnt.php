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
                        <li><a href="">Stock Control</a></li>
                        <li class="active"><strong>Stock Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Stock Management</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Supply</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="sply" id="sply"
                                            onchange="chckBtn(this.value,'sply')">
                                        <option value="all"> All Supply</option>
                                        <?php
                                        foreach ($spplyinfo as $sply) {
                                            echo "<option value='$sply->spid'>$sply->spnm</option>";
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
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker"
                                           name="frdt" id="frdt" value="<?= date('Y-m-d') ?>"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4  control-label">To Date</label>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <input type="text" class="form-control datepicker"
                                               name="todt" id="todt" value="<?= date('Y-m-d') ?>"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchStck()"
                                            class='btn-sm btn-primary' id="">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-4">

                         </div>-->
                    </div>
                </div>

                <div class="content-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <table class="table datatable table-bordered table-striped table-actions"
                                   id="dataTbStck" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center"> NO</th>
                                    <th class="text-center"> STK NO</th>
                                    <th class="text-center"> SUPPLY</th>
                                    <th class="text-center"> TOTAL</th>
                                    <th class="text-center"> CR DATE</th>
                                    <th class="text-center"> CR BY</th>
                                    <th class="text-center"> STATUS</th>
                                    <th class="text-center"> OPTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                </tfoot>
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
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Stock Add</h4>
            </div>
            <form class="form-horizontal" id="po_add" name="po_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Supply Name</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="spid" id="spid"
                                                            onchange="chckBtn(this.value,'spid');">
                                                        <option value="0"> -- Select Supply --</option>
                                                        <?php
                                                        foreach ($spplyinfo as $spply) {
                                                            echo "<option value='$spply->spid'>$spply->spcd | $spply->spnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Order Date</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control datepicker"
                                                           name="ordt" id="ordt" value="<?= date('Y-m-d') ?>"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Reference Details</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control"
                                                           name="rfdt" id="rfdt" placeholder="Reference No"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Delivery To </label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="whid" id="whid"
                                                            onchange="chckBtn(this.value,'whid');">
                                                        <option value="0"> -- Select Warehouse --</option>
                                                        <?php
                                                        foreach ($whuseinfo as $whuse) {
                                                            echo "<option value='$whuse->whid'>$whuse->whcd | $whuse->whnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="panel-body">

                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Category</label>
                                                    <div class="col-md-8 ">
                                                        <div class="form-group">
                                                            <select class="form-control" name="ctgr" id="ctgr"
                                                                    onchange="chckBtn(this.value,'ctgr'); getItm(this.value)">
                                                                <option value="all">-- All Category --</option>
                                                                <?php
                                                                foreach ($ctgryinfo as $ctgry) {
                                                                    echo "<option value='$ctgry->ctid'>$ctgry->ctnm </option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Item Name</label>
                                                    <div class="col-md-8 ">
                                                        <div class="form-group">
                                                            <select class="form-control" name="itnm" id="itnm"
                                                                    onchange="chckBtn(this.value,'itnm')">
                                                                <option value="0">-- Select Item --</option>
                                                                <?php
                                                                foreach ($iteminfo as $item) {
                                                                    echo "<option value='$item->itid'>$item->pbcd | $item->itnm</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Quantity</label>
                                                    <div class="col-md-8 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="qnty" placeholder="Quantity" id="qnty"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Cost Value</label>
                                                    <div class="col-md-8 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="csvl" placeholder="Cost Value" id="csvl"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Sales Value</label>
                                                    <div class="col-md-8 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="slvl" placeholder="Sales Value" id="slvl"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Display</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="dsvl" placeholder="Display Value" id="dsvl"/>
                                                        </div>
                                                    </div>
                                                    &nbsp;
                                                    <button type="button" class="btn-sm btn-info" id="addrw"
                                                            onclick="abc()">
                                                        <span><i class="fa fa-plus"></i></span>
                                                    </button>
                                                </div>
                                                <input type="hidden" id="leng" name="leng">
                                            </div>
                                        </div>


                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                            <table class="table table-bordered  table-actions" id="poTbl" style="">
                                                <thead>
                                                <tr>
                                                    <th width="" class="text-center">CODE | NAME</th>
                                                    <th width="" class="text-center">QTY</th>
                                                    <th width="" class="text-center">COST</th>
                                                    <th width="" class="text-center">SALES</th>
                                                    <th width="" class="text-center">DISPLAY</th>
                                                    <th width="" class="text-center">TOTAL</th>
                                                    <th width="" class="text-center">REMOVE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th id="ttlQt"></th>
                                                <th id="ttcs"></th>
                                                <th id="ttsl"></th>
                                                <th id="ttds"></th>
                                                <th id="ttlSub"></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Remarks </label>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                         <textarea class="form-control" name="remk" id="remk"
                                                                   rows="4" placeholder="Description"> </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label"> Total</label>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-right"
                                                               name="sbttl" placeholder=" Total" id="sbttl"
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
                    <button type="submit" class="btn btn-success" id="addAcc">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- View Model -->
<div class="modal" id="modalView" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">View Center Details</h4>
            </div>
            <form class="form-horizontal" id="vou_approval" name="vou_approval"
                  action="" method="post">
                <div class="modal-body form-horizontal">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Supply Name</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="spnm"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label">Order Date</label>
                                            <label class="col-md-4 col-xs-6 control-label" id="vordt"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Reference Details</label>
                                            <label class="col-md-4 col-xs-12 control-label" id="rfno"></label>
                                        </div>
                                        <input type="hidden" id="vuid" name="vuid">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-6 control-label"> Delivery Location </label>
                                            <label class="col-md-8 col-xs-6 control-label" id="dvlc"></label>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-md-12 label-default"></div>
                                    <br>
                                    <div class="panel-body panel-body-table">
                                        <table class="table datatable table-bordered table-striped table-actions"
                                               id="viePoTb" width="100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">NO</th>
                                                <th class="text-center">CODE | NAME</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">COST</th>
                                                <th class="text-center">SALES</th>
                                                <th class="text-center">DISPLY</th>
                                                <th class="text-center">TOTAL</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                            <th></th>
                                            <th> Total</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 col-xs-12 control-label">Remarks </label>
                                            <label class="col-md-4 col-xs-12 control-label text-right"
                                                   id="vw_remk"></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-9 col-xs-12 control-label tx-align">Total</label>
                                            <label class="col-md-3 col-xs-12 control-label tx-align"
                                                   id="vw_sbtl"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--End View Model -->

<!--  Edit || Approval -->
<div class="modal" id="modalEdt" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 80%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="po_edt" name="po_edt"
                  action="" method="post">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Supply Name</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="spidEdt" id="spidEdt"
                                                            onchange="chckBtn(this.value,'spidEdt');">
                                                        <option value="0"> -- Select Supply --</option>
                                                        <?php
                                                        foreach ($spplyinfo as $spply) {
                                                            echo "<option value='$spply->spid'>$spply->spcd | $spply->spnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Order Date</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control datepicker"
                                                           name="ordtEdt" id="ordtEdt" value="<?= date('Y-m-d') ?>"/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Reference Details</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <input type="text" class="form-control"
                                                           name="rfdtEdt" id="rfdtEdt" placeholder="Reference No"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Delivery To </label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="whidEdt" id="whidEdt"
                                                            onchange="chckBtn(this.value,'whidEdt');">
                                                        <option value="0"> -- Select Warehouse --</option>
                                                        <?php
                                                        foreach ($whuseinfo as $whuse) {
                                                            echo "<option value='$whuse->whid'>$whuse->whcd | $whuse->whnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <!-- <div class="row">
                                        <h3 class="text-title"><span class="fa fa-money"></span> Order Details </h3>
                                        <div class="col-md-12">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Item Name</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <select class="form-control" name="itnmEdt" id="itnmEdt"
                                                                    onchange="chckBtn(this.value,'itnmEdt')">
                                                                <option value="0">-- Select Item --</option>
                                                                <?php
                                    /*                                                                foreach ($iteminfo as $item) {
                                                                                                        echo "<option value='$item->itid'>$item->pbcd | $item->itnm</option>";
                                                                                                    }
                                                                                                    */ ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Quantity</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="qntyEdt" placeholder="Quantity" id="qntyEdt"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Unit Price</label>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control"
                                                                   name="untpEdt" placeholder="Unit Price"
                                                                   id="untpEdt"/>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                        </div>
                                    </div>-->
                                    <!--                                    <button type="button" class="btn-sm btn-info" id="addrwEdt"-->
                                    <!--                                            onclick="abcEdt()"><span>-->
                                    <!--                                                    <i class="fa fa-plus"></i></span>-->
                                    <!--                                    </button>-->

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Category</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="ctgrEdt" id="ctgrEdt"
                                                                onchange="chckBtn(this.value,'ctgrEdt');getItmEdt(this.value)">
                                                            <option value="all">-- All Category --</option>
                                                            <?php
                                                            foreach ($ctgryinfo as $ctgry) {
                                                                echo "<option value='$ctgry->ctid'>$ctgry->ctnm </option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Item Name</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <select class="form-control" name="itnmEdt" id="itnmEdt"
                                                                onchange="chckBtn(this.value,'itnmEdt')">
                                                            <option value="0">-- Select Item --</option>
                                                            <?php
                                                            foreach ($iteminfo as $item) {
                                                                echo "<option value='$item->itid'>$item->pbcd | $item->itnm</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Quantity</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="qntyEdt" placeholder="Quantity" id="qntyEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Cost Value</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="csvlEdt" placeholder="Cost Value" id="csvlEdt"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Sales Value</label>
                                                <div class="col-md-8 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="slvlEdt" placeholder="Sales Value" id="slvlEdt"/>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Display</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control"
                                                               name="dsvlEdt" placeholder="Display Value" id="dsvlEdt"/>
                                                    </div>
                                                </div>
                                                &nbsp;
                                                <button type="button" class="btn-sm btn-info" id="addrwEdt"
                                                        onclick="abcEdt()">
                                                    <span><i class="fa fa-plus"></i></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="lengEdt" name="lengEdt">
                                    <input type="hidden" id="prvTbLeng" name="prvTbLeng">

                                    <br>
                                    <div class="row">
                                        <div class="table-responsive" style="padding: 10px 25px 10px 10px ">
                                            <table class="table table-bordered  table-actions" id="poTblEdt" style="">
                                                <thead>
                                                <tr>
                                                    <th width="" class="text-center">CODE | NAME</th>
                                                    <th width="" class="text-center">QTY</th>
                                                    <th width="" class="text-center">COST</th>
                                                    <th width="" class="text-center">SALES</th>
                                                    <th width="" class="text-center">DISPLAY</th>
                                                    <th width="" class="text-center">TOTAL</th>
                                                    <th width="" class="text-center">REMOVE</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                <th></th>
                                                <th class="text-right" id="ttlQtEdt"></th>
                                                <th class="text-right" id="ttlQtcst"></th>
                                                <th class="text-right" id="ttlQtsl"></th>
                                                <th class="text-right" id="ttlQtds"></th>
                                                <th class="text-right" id="ttlSubEdt"></th>
                                                <th></th>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-5  control-label">Remarks</label>
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                         <textarea class="form-control" name="remkEdt" id="remkEdt"
                                                                   rows="4" placeholder="Description"> </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-6  control-label">Total</label>
                                                <div class="col-md-4 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control text-right"
                                                               name="ttlEdt" placeholder="Total" id="ttlEdt" readonly/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="func" name="func">
                                <input type="hidden" id="auid" name="auid">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="subBtn"><span id="btnNm"></span></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

        $('#poTbl').DataTable({
            searching: false,
            bPaginate: false,
            "ordering": false,
            destroy: true,
            "cache": false,
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
        });

        //  ADD VALIDATE
        $("#po_add").validate({
            rules: {
                spid: {
                    required: true,
                    notEqual: '0'
                },
                whid: {
                    required: true,
                    notEqual: '0'
                },

                qnty: {
                    notEqual: '0',
                    digits: true
                },

                csvl: {
                    currency: true,
                    notEqual: 0,
                },
                slvl: {
                    currency: true,
                    notEqual: 0,
                    //lessThanOrEqual : '#csvl'
                },
                dsvl: {
                    currency: true,
                    notEqual: 0,
                    //lessThanOrEqual : '#slvl'
                },

                ttl: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },
            },
            messages: {
                spid: {
                    required: 'Please select supply',
                    notEqual: 'Please select supply'
                },
                whid: {
                    required: 'Please select warehouse',
                    notEqual: 'Please select warehouse'
                },

                itnm: {
                    required: 'Please select item',
                    notEqual: 'Please select item'
                },
                qnty: {
                    digits: 'Please enter Quantity',
                },
                csvl: {
                    currency: 'Please Enter Value',
                    notEqual: 0,
                },
                slvl: {
                    currency: 'Please Enter Value',
                    notEqual: 0,
                    greaterThanOrEqual: '#csvl'
                },
                dsvl: {
                    currency: 'Please Enter Value',
                    notEqual: 0,
                    greaterThanOrEqual: '#slvl'
                },
            }
        });

        // EDIT VALIDATE
        $("#po_edt").validate({

            rules: {
                spidEdt: {
                    required: true,
                    notEqual: '0'
                },
                whidEdt: {
                    required: true,
                    notEqual: '0'
                },

                /*itnm: {
                 required: true,
                 notEqual: '0'
                 },*/
                qntyEdt: {
                    notEqual: '0',
                    digits: true
                },
                untpEdt: {
                    notEqual: '0',
                    currency: true
                },
                dsrtEdt: {
                    currency: true
                },
                dsvlEdt: {
                    currency: true
                },
                txrtEdt: {
                    currency: true
                },
                otchgEdt: {
                    digits: true
                },
                ttlEdt: {
                    required: true,
                    notEqual: '0',
                    currency: true
                },
            },
            messages: {
                spidEdt: {
                    required: 'Please select supply',
                    notEqual: 'Please select supply'
                },
                whidEdt: {
                    required: 'Please select warehouse',
                    notEqual: 'Please select warehouse'
                },

                itnmEdt: {
                    required: 'Please select item',
                    notEqual: 'Please select item'
                },
                qntyEdt: {
                    digits: 'Please enter Quantity',
                },
                untpEdt: {
                    //required: 'Please enter Quantity',
                },
                txrtEdt: {
                    currency: 'Not a rate',
                },
                otchgEdt: {
                    //required: 'Please enter Quantity',
                },
            }
        });

        document.getElementById("addAcc").setAttribute("class", "hidden");
        srchStck();
    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    // XXXXXXXXXXXXXXXXXXXXX ADD XXXXXXXXXXXXXXXXXXX
    // LOAD ITEM
    function getItm(ctid) {
        $.ajax({
            url: '<?= base_url(); ?>stock/getItem',
            type: 'post',
            data: {
                ctid: ctid,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#itnm').empty();
                    $('#itnm').append("<option value='0'> -- Select Item --</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['itid'];
                        var name = response[i]['itcd'] + ' | ' + response[i]['itnm'];
                        var $el = $('#itnm');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#itnm').empty();
                    $('#itnm').append("<option value='0'>-- No Item --</option>");
                }
            }
        });
    }

    // TEMPARY TABLE ADDEING DATA
    function abc() {
        var itnm = document.getElementById('itnm').value;
        var qnty = document.getElementById('qnty').value;
        var csvl = document.getElementById('csvl').value;
        var slvl = document.getElementById('slvl').value;
        var dsvl = document.getElementById('dsvl').value;
        //var untp = document.getElementById('untp').value;
        // console.log('**' + csvl + ' x ' + slvl + ' v ' + dsvl);

        var per = '';

        if (itnm == 0) {
            document.getElementById('itnm').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('itnm').style.borderColor = "";
            per = 1;
        }
        if (qnty == '' || qnty == 0) {
            document.getElementById('qnty').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('qnty').style.borderColor = "";
            per = 1;
        }
        if (csvl == '' || csvl == 0) {
            document.getElementById('csvl').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('csvl').style.borderColor = "";
            per = 1;
        }
        if (slvl == '' || slvl == 0 || slvl < csvl) {
            document.getElementById('slvl').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('slvl').style.borderColor = "";
            per = 1;
        }
        if (dsvl == '' || dsvl == 0 || dsvl < slvl) {
            document.getElementById('dsvl').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('dsvl').style.borderColor = "";
            per = 1;
        }
        //console.log('cs ' + csvl + ' sl ' + slvl + ' ds ' + dsvl + ' per ' + per);

        if (per == 1) {

            var csvl = parseFloat(document.getElementById('csvl').value);
            var slvl = parseFloat(document.getElementById('slvl').value);
            var dsvl = parseFloat(document.getElementById('dsvl').value);

            var leng = document.getElementById('leng').value;

            var lengN = +leng + +1;
            document.getElementById('leng').value = lengN;

            //$('#poTbl').DataTable().clear();
            var t = $('#poTbl').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [0]},
                    {className: "text-center", "targets": [6]},
                    {className: "text-right", "targets": [1, 2, 3, 4, 5]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '30%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '8%'},    // cnt
                    {sWidth: '8%'},     //
                    {sWidth: '8%'},
                    {sWidth: '8%'},
                    {sWidth: '5%'}
                ],
                "rowCallback": function (row, data, index) {
                },
                // "order": [[5, "ASC"]], //ASC  desc
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/getItemDtils",
                data: {
                    itnm: itnm
                },
                dataType: 'json',
                success: function (response) {
                    var itcd_n = response[0]['itcd'];
                    var itnm_n = response[0]['itnm'];

                    t.row.add([
                        itcd_n + ' | ' + itnm_n + '<input type="hidden" name="itnmcd[]" value="' + itnm + ' ">',     // ITEM CODE
                        numeral(qnty).format('0,0') + '<input type="hidden" name="qunty[]" value="' + qnty + ' ">',         // QUNT
                        numeral(csvl).format('0,0.00') + '<input type="hidden" name="csvlpr[]" value="' + csvl + ' ">',     // COST PRICE
                        numeral(slvl).format('0,0.00') + '<input type="hidden" name="slvlpr[]" value="' + slvl + ' ">',     // SALE PRICE
                        numeral(dsvl).format('0,0.00') + '<input type="hidden" name="dsvlpr[]" value="' + dsvl + ' ">',     // DISP PRICE
                        numeral(( +qnty * +csvl)).format('0,0.00') + '<input type="hidden" name="unttl[]" value="' + ( +qnty * +csvl) + ' ">',
                        '<button type="button" class="btn-sm btn-danger" id="dltrw" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                    ]).draw(false);

                    var ttlQt = 0;
                    var ttlSub = 0;
                    var csvlpr = 0;
                    var slvlpr = 0;
                    var dsvlpr = 0;

                    $(" input[name='qunty[]']").each(function () {
                        ttlQt = ttlQt + +this.value;
                    });
                    $(" input[name='csvlpr[]']").each(function () {
                        csvlpr = csvlpr + +this.value;
                    });
                    $(" input[name='slvlpr[]']").each(function () {
                        slvlpr = slvlpr + +this.value;
                    });
                    $(" input[name='dsvlpr[]']").each(function () {
                        dsvlpr = dsvlpr + +this.value;
                    });
                    $(" input[name='unttl[]']").each(function () {
                        ttlSub = ttlSub + +this.value;
                    });

                    document.getElementById('ttlQt').innerHTML = ttlQt;
                    document.getElementById('ttlSub').innerHTML = numeral(ttlSub).format('0,0.00');
                    document.getElementById('ttcs').innerHTML = numeral(csvlpr).format('0,0.00');
                    document.getElementById('ttsl').innerHTML = numeral(slvlpr).format('0,0.00');
                    document.getElementById('ttds').innerHTML = numeral(dsvlpr).format('0,0.00');
                    document.getElementById('sbttl').value = ttlSub;

                    calTtl();
                }
            });

            //document.getElementById('ctgr').value = 0;
            document.getElementById('itnm').value = 0;
            document.getElementById('qnty').value = '';
            document.getElementById('csvl').value = '';
            document.getElementById('slvl').value = '';
            document.getElementById('dsvl').value = '';
        }
    }

    // TABLE DATA REMOVE
    $('#poTbl tbody').on('click', '#dltrw', function () {
        var table = $('#poTbl').DataTable();

        table
            .row($(this).parents('tr'))
            .remove()
            .draw();

        var leng = document.getElementById('leng').value;
        document.getElementById('leng').value = +leng - +1;

        var ttlQt = 0;
        var ttlSub = 0;
        $(" input[name='qunty[]']").each(function () {
            ttlQt = ttlQt + +this.value;
        });
        $(" input[name='unttl[]']").each(function () {
            ttlSub = ttlSub + +this.value;
        });

        document.getElementById('ttlQt').innerHTML = ttlQt;
        document.getElementById('ttlSub').innerHTML = numeral(ttlSub).format('0,0.00');
        document.getElementById('sbttl').value = ttlSub;
        calTtl();
    });


    // CAL TOTAL
    function calTtl() {
        var sbttl = document.getElementById('sbttl').value;
        //document.getElementById('ttlAmt').value = sbttl;

        if (document.getElementById('leng').value > 0) {
            document.getElementById("addAcc").removeAttribute("class");
            document.getElementById("addAcc").setAttribute("class", "btn btn-success");
        } else {
            document.getElementById("addAcc").setAttribute("class", "hidden");
        }
    }

    // XXXXXXXXXXXXXXXXXXXXX EDIT XXXXXXXXXXXXXXXXXXX

    // LOAD ITEM
    function getItmEdt(ctid) {
        $.ajax({
            url: '<?= base_url(); ?>stock/getItem',
            type: 'post',
            data: {
                ctid: ctid,
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;

                if (len != 0) {
                    $('#itnmEdt').empty();
                    $('#itnmEdt').append("<option value='0'> -- Select Item --</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response[i]['itid'];
                        var name = response[i]['itcd'] + ' | ' + response[i]['itnm'];
                        var $el = $('#itnmEdt');
                        $el.append($("<option></option>")
                            .attr("value", id).text(name));
                    }
                } else {
                    $('#itnmEdt').empty();
                    $('#itnmEdt').append("<option value='0'>-- No Item --</option>");
                }
            }
        });
    }

    // TEMPARY TABLE ADDEING DATA
    function abcEdt() {
        var itnm = document.getElementById('itnmEdt').value;
        var qnty = document.getElementById('qntyEdt').value;
        var csvl = document.getElementById('csvlEdt').value;
        var slvl = document.getElementById('slvlEdt').value;
        var dsvl = document.getElementById('dsvlEdt').value;

        var per = '';
        if (itnm == 0) {
            document.getElementById('itnmEdt').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('itnmEdt').style.borderColor = "";
            per = 1;
        }
        if (qnty == '' || qnty == 0) {
            document.getElementById('qntyEdt').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('qntyEdt').style.borderColor = "";
            per = 1;
        }
        if (csvl == '' || csvl == 0) {
            document.getElementById('csvlEdt').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('csvlEdt').style.borderColor = "";
            per = 1;
        }
        if (slvl == '' || slvl == 0 || slvl < csvl) {
            document.getElementById('slvlEdt').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('slvlEdt').style.borderColor = "";
            per = 1;
        }
        if (dsvl == '' || dsvl == 0 || dsvl < slvl) {
            document.getElementById('dsvlEdt').style.borderColor = "red";
            per = 0;
        } else {
            document.getElementById('dsvlEdt').style.borderColor = "";
            per = 1;
        }

        if (per == 1) {
            var csvl = parseFloat(document.getElementById('csvlEdt').value);
            var slvl = parseFloat(document.getElementById('slvlEdt').value);
            var dsvl = parseFloat(document.getElementById('dsvlEdt').value);

            var leng = document.getElementById('lengEdt').value;
            var lengN = +leng + +1;
            document.getElementById('lengEdt').value = lengN;

            var t = $('#poTblEdt').DataTable({
                destroy: true,
                searching: false,
                bPaginate: false,
                "ordering": false,
                "columnDefs": [
                    {className: "text-left", "targets": [0]},
                    {className: "text-center", "targets": [6]},
                    {className: "text-right", "targets": [1, 2, 3, 4, 5]},
                    {className: "text-nowrap", "targets": [1]}
                ],
                "aoColumns": [
                    {sWidth: '30%'},
                    {sWidth: '5%'},    // br
                    {sWidth: '5%'},    // cnt
                    {sWidth: '5%'},     //
                    {sWidth: '5%'},
                    {sWidth: '5%'},
                    {sWidth: '5%'}
                ],
            });

            $.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/getItemDtils",
                data: {
                    itnm: itnm
                },
                dataType: 'json',
                success: function (response) {
                    var itcd_n = response[0]['itcd'];
                    var itnm_n = response[0]['itnm'];

                    t.row.add([
                        itcd_n + ' | ' + itnm_n + '<input type="hidden" name="itnmcdEdt_n[]" value="' + itnm + ' ">',     // ITEM CODE
                        numeral(qnty).format('0,0') + '<input type="hidden" name="quntyEdt_n[]" value="' + qnty + ' ">',         // QUNT
                        numeral(csvl).format('0,0.00') + '<input type="hidden" name="csvlEdt_n[]" value="' + csvl + ' ">',     // COST PRICE
                        numeral(slvl).format('0,0.00') + '<input type="hidden" name="slvlEdt_n[]" value="' + slvl + ' ">',     // SALE PRICE
                        numeral(dsvl).format('0,0.00') + '<input type="hidden" name="dsvlEdt_n[]" value="' + dsvl + ' ">',     // DISP PRICE
                        numeral(( +qnty * +csvl)).format('0,0.00') + '<input type="hidden" name="unttlEdt_n[]" value="' + ( +qnty * +csvl) + ' ">',
                        '<button type="button" class="btn-sm btn-danger" id="dltrwEdt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'

                    ]).draw(false);

                    calTtlEdt();
                }
            });

            // SET DEFAULT
            document.getElementById('itnmEdt').value = 0;
            document.getElementById('qntyEdt').value = '';
            document.getElementById('csvlEdt').value = '';
            document.getElementById('slvlEdt').value = '';
            document.getElementById('dsvlEdt').value = '';
        }
    }

    // TABLE DATA REMOVE
    $('#poTblEdt tbody').on('click', '#dltrwEdt', function () {
        var table = $('#poTblEdt').DataTable();
        table
            .row($(this).parents('tr'))
            .remove()
            .draw();

        var leng = document.getElementById('lengEdt').value;
        document.getElementById('lengEdt').value = +leng - +1;

        var ttlQtEdt = 0;
        var ttlSubEdt = 0;
        var ttlQtcst = 0;
        var ttlQtsl = 0;
        var ttlQtds = 0;

        $(" input[name='quntyEdt[]']").each(function () {
            ttlQtEdt = ttlQtEdt + +this.value;
        });
        $(" input[name='unttlEdt[]']").each(function () {
            ttlSubEdt = ttlSubEdt + +this.value;
        });

        $(" input[name='csvlEdt[]']").each(function () {
            ttlQtcst = ttlQtcst + +this.value;
        });
        $(" input[name='slvlEdt[]']").each(function () {
            ttlQtsl = ttlQtsl + +this.value;
        });
        $(" input[name='dsvlEdt[]']").each(function () {
            ttlQtds = ttlQtds + +this.value;
        });

        document.getElementById('ttlQtEdt').innerHTML = ttlQtEdt;
        document.getElementById('ttlQtcst').innerHTML = numeral(ttlQtcst).format('0,0.00');
        document.getElementById('ttlQtsl').innerHTML = numeral(ttlQtsl).format('0,0.00');
        document.getElementById('ttlQtds').innerHTML = numeral(ttlQtds).format('0,0.00');

        document.getElementById('ttlSubEdt').innerHTML = numeral(ttlSubEdt).format('0,0.00');
        calTtlEdt();
    });

    // CAL TOTAL
    function calTtlEdt() {

        var ttlQtEdt = 0;
        var ttlQtEdt_n = 0;
        $(" input[name='quntyEdt[]']").each(function () {
            ttlQtEdt = ttlQtEdt + +this.value;
        });
        $(" input[name='quntyEdt_n[]']").each(function () {
            ttlQtEdt_n = ttlQtEdt_n + +this.value;
        });

        var ttlSubEdt = 0;
        var ttlSubEdt_n = 0;
        $(" input[name='unttlEdt[]']").each(function () {
            ttlSubEdt = ttlSubEdt + +this.value;
        });
        $(" input[name='unttlEdt_n[]']").each(function () {
            ttlSubEdt_n = ttlSubEdt_n + +this.value;
        });
        document.getElementById('ttlQtEdt').innerHTML = +ttlQtEdt + +ttlQtEdt_n;
        document.getElementById('ttlSubEdt').innerHTML = numeral(+ttlSubEdt + +ttlSubEdt_n).format('0,0.00');

        var ttlQtcst = 0;
        var ttlQtcst_n = 0;
        $(" input[name='csvlEdt[]']").each(function () {
            ttlQtcst = ttlQtcst + +this.value;
        });
        $(" input[name='csvlEdt_n[]']").each(function () {
            ttlQtcst_n = ttlQtcst_n + +this.value;
        });

        var ttlQtsl = 0;
        var ttlQtsl_n = 0;
        $(" input[name='slvlEdt[]']").each(function () {
            ttlQtsl = ttlQtsl + +this.value;
        });
        $(" input[name='slvlEdt_n[]']").each(function () {
            ttlQtsl_n = ttlQtsl_n + +this.value;
        });

        var ttlQtds = 0;
        var ttlQtds_n = 0;
        $(" input[name='dsvlEdt[]']").each(function () {
            ttlQtds = ttlQtds + +this.value;
        });
        $(" input[name='dsvlEdt_n[]']").each(function () {
            ttlQtds_n = ttlQtds_n + +this.value;
        });
        //console.log(ttlQtcst + " * " +ttlQtcst_n );
        //console.log('AA');
        document.getElementById('ttlQtcst').innerHTML = numeral(+ttlQtcst + +ttlQtcst_n).format('0,0.00');
        document.getElementById('ttlQtsl').innerHTML = numeral(+ttlQtsl + +ttlQtsl_n).format('0,0.00');
        document.getElementById('ttlQtds').innerHTML = numeral(+ttlQtds + +ttlQtds_n).format('0,0.00');


        //var dsvl = document.getElementById('dsvlEdt').value;
        document.getElementById('ttlEdt').value = numeral(+ttlSubEdt + +ttlSubEdt_n).format('0.00');

        if (document.getElementById('lengEdt').value > 0) {
            document.getElementById("subBtn").removeAttribute("class");
            document.getElementById("subBtn").setAttribute("class", "btn btn-success");
        } else {
            document.getElementById("subBtn").setAttribute("class", "hidden");
        }
    }

    // XXXXXXXXXXXXXXXXXXXXX END EDIT XXXXXXXXXXXXXXXXXXX


    /* SEARCH */
    function srchStck() {
        var sply = document.getElementById('sply').value;   // SPPLY
        var frdt = document.getElementById('frdt').value;   // FROM
        var todt = document.getElementById('todt').value;   // TO

        $('#dataTbStck').DataTable().clear();
        $('#dataTbStck').DataTable({
            "destroy": true,
            "cache": false,
            "processing": true,
            //"orderable": false,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-fw" style="font-size:20px;color:red;"></i><span class=""> Loading...</span> '
            },
            "lengthMenu": [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            "serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [1, 2, 5]},
                {className: "text-center", "targets": [0, 4, 6, 7]},
                {className: "text-right", "targets": [3]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[5, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '3%'},
                {sWidth: '5%'},
                {sWidth: '15%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '15%'},
            ],
            "ajax": {
                url: '<?= base_url(); ?>stock/srchStck',
                type: 'post',
                data: {
                    sply: sply,
                    frdt: frdt,
                    todt: todt,
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
                //COLUMN 3 TTL
                var t3 = api.column(3).data().reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
            },

        });
    }

    /* ADD */
    $("#addAcc").click(function (e) { //  add form
        e.preventDefault();
        if ($("#po_add").valid()) {
            $('#modalAdd').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/addStock",
                data: $("#po_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    srchStck();
                    swal({title: "", text: "Stock Added Success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "Stock Added Failed !", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });

    /* VIEW ITEM */
    function viewStck(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/vewStockList",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response['poitem'].length;

                document.getElementById("spnm").innerHTML = response['podtil'][0]['spnm'];
                document.getElementById("vordt").innerHTML = response['podtil'][0]['oddt'];
                document.getElementById("rfno").innerHTML = response['podtil'][0]['rfno'];
                document.getElementById("dvlc").innerHTML = response['podtil'][0]['whnm'] + ' (' + response['podtil'][0]['whcd'] + ' )';
                document.getElementById("vw_remk").innerHTML = response['podtil'][0]['remk'];
                document.getElementById("vw_sbtl").innerHTML = numeral(response['podtil'][0]['sbtl']).format('0,0.00');

                var m = $('#viePoTb').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [1]},
                        {className: "text-center", "targets": [0]},
                        {className: "text-right", "targets": [2, 3, 4, 5, 6]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '5%'},
                        {sWidth: '20%'},    //
                        {sWidth: '5%'},    //
                        {sWidth: '5%'},    //
                        {sWidth: '5%'},     //
                        {sWidth: '5%'},     //
                        {sWidth: '5%'}
                    ],
                    "footerCallback": function (row, data, start, end, display) {
                        var api = this.api(), data;

                        // Remove the formatting to get integer data for summation
                        var intVal = function (i) {
                            return typeof i === 'string' ?
                                i.replace(/[\$,]/g, '') * 1 :
                                typeof i === 'number' ?
                                    i : 0;
                        };

                        //COLUMN 2 TTL
                        var t2 = api.column(2).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(2).footer()).html(numeral(t2).format('0,0'));
                        //COLUMN 3 TTL
                        var t3 = api.column(3).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(3).footer()).html(numeral(t3).format('0,0.00'));
                        //COLUMN 4 TTL
                        var t4 = api.column(4).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(4).footer()).html(numeral(t4).format('0,0.00'));
                        //COLUMN 5 TTL
                        var t5 = api.column(5).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(5).footer()).html(numeral(t5).format('0,0.00'));
                        //COLUMN 6 TTL
                        var t6 = api.column(6).data().reduce(function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0);
                        $(api.column(6).footer()).html(numeral(t6).format('0,0.00'));

                    },
                });

                m.clear().draw();
                for (var a = 0; a < len; a++) {
                    m.row.add([
                        a + 1,
                        response['poitem'][a]['itcd'] + ' | ' + response['poitem'][a]['itnm'],
                        response['poitem'][a]['qnty'],
                        numeral(response['poitem'][a]['csvl']).format('0,0.00'),
                        numeral(response['poitem'][a]['slvl']).format('0,0.00'),
                        numeral(response['poitem'][a]['dsvl']).format('0,0.00'),
                        numeral(response['poitem'][a]['sbtt']).format('0,0.00'),
                    ]).draw(false);
                }
            }
        })
    }

    /* EDIT VIEW*/
    function edtStck(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Stock");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Stock");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/vewStockList",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("spidEdt").value = response['podtil'][0]['spid'];
                document.getElementById("whidEdt").value = response['podtil'][0]['whid'];
                document.getElementById("ordtEdt").value = response['podtil'][0]['oddt'];
                document.getElementById("rfdtEdt").value = response['podtil'][0]['rfno'];
                document.getElementById("remkEdt").value = response['podtil'][0]['remk'];

                document.getElementById("ttlEdt").value = response['podtil'][0]['totl'];
                document.getElementById("auid").value = response['podtil'][0]['stid'];

                // SUB DETAILS TABLE
                var len = response['poitem'].length;
                document.getElementById("lengEdt").value = len;
                document.getElementById("prvTbLeng").value = len;

                $('#poTblEdt').DataTable().clear();
                var t = $('#poTblEdt').DataTable({
                    destroy: true,
                    searching: false,
                    bPaginate: false,
                    "ordering": false,
                    "columnDefs": [
                        {className: "text-left", "targets": [0]},
                        {className: "text-center", "targets": [6]},
                        {className: "text-right", "targets": [1, 2, 3, 4, 5]},
                        {className: "text-nowrap", "targets": [1]}
                    ],
                    "aoColumns": [
                        {sWidth: '25%'},
                        {sWidth: '5%'},    // br
                        {sWidth: '5%'},    // cnt
                        {sWidth: '5%'},     //
                        {sWidth: '5%'},
                        {sWidth: '5%'},
                        {sWidth: '5%'}
                    ],
                    "rowCallback": function (row, data, index) {
                    },
                });

                for (var a = 0; a < len; a++) {
                    var itcd_n = response['poitem'][a]['itcd'];
                    var itid = response['poitem'][a]['itid'];
                    var itnm_n = response['poitem'][a]['itnm'];

                    var qnty = response['poitem'][a]['qnty'];
                    var csvl = response['poitem'][a]['csvl'];
                    var sbid = response['poitem'][a]['sbid'];
                    var slvl = response['poitem'][a]['slvl'];
                    var dsvl = response['poitem'][a]['dsvl'];

                    t.row.add([
                        itcd_n + ' | ' + itnm_n + '<input type="hidden" name="itnmcdEdt[]" value="' + itid + ' ">'
                        + '<input type="hidden" name="sbid[]" value="' + sbid + '">',        // ITEM CODE
                        numeral(qnty).format('0,0') + '<input type="hidden" name="quntyEdt[]" value="' + qnty + ' ">',
                        numeral(csvl).format('0,0.00') + '<input type="hidden" name="csvlEdt[]" value="' + csvl + ' ">',
                        numeral(slvl).format('0,0.00') + '<input type="hidden" name="slvlEdt[]" value="' + slvl + ' ">',
                        numeral(dsvl).format('0,0.00') + '<input type="hidden" name="dsvlEdt[]" value="' + dsvl + ' ">',
                        numeral(( +qnty * +csvl)).format('0,0.00') + '<input type="hidden" name="unttlEdt[]" value="' + ( +qnty * +csvl) + ' ">',
                        '<button type="button" class="btn-sm btn-danger" id="dltrwEdt" onclick=""><span><i class="fa fa-close" title="Remove"></i></span></button>'
                    ]).draw(false);

                    var ttlQtEdt = 0;
                    var ttlSubEdt = 0;
                    $(" input[name='quntyEdt[]']").each(function () {
                        ttlQtEdt = ttlQtEdt + +this.value;
                    });
                    $(" input[name='unttlEdt[]']").each(function () {
                        ttlSubEdt = ttlSubEdt + +this.value;
                    });
                    document.getElementById('ttlQtEdt').innerHTML = ttlQtEdt;
                    document.getElementById('ttlSubEdt').innerHTML = numeral(ttlSubEdt).format('0,0.00');
                    //document.getElementById('sbttlEdt').value = ttlSubEdt;


                    var ttlQtcst = 0;
                    var ttlQtsl = 0;
                    var ttlQtds = 0;
                    $(" input[name='csvlEdt[]']").each(function () {
                        ttlQtcst = ttlQtcst + +this.value;
                    });
                    $(" input[name='slvlEdt[]']").each(function () {
                        ttlQtsl = ttlQtsl + +this.value;
                    });
                    $(" input[name='dsvlEdt[]']").each(function () {
                        ttlQtds = ttlQtds + +this.value;
                    });
                    document.getElementById('ttlQtcst').innerHTML = numeral(ttlQtcst).format('0,0.00');
                    document.getElementById('ttlQtsl').innerHTML = numeral(ttlQtsl).format('0,0.00');
                    document.getElementById('ttlQtds').innerHTML = numeral(ttlQtds).format('0,0.00');
                }
            }
        })
    }

    /* EDIT SUBMIT*/
    $("#subBtn").click(function (e) {
        e.preventDefault();

        if ($("#po_edt").valid()) {
            swal({
                    title: "Are you sure this process",
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
                        $('#modalEdt').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>stock/edtStock",
                            data: $("#po_edt").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchStck();
                                swal({title: "", text: "Stock Update success", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Stock Update failed", type: "error"},
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

    /* REJECT*/
    function rejecPo(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process ",
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
                        url: '<?= base_url(); ?>Hire_purchase/rejtPo',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchStck();
                                swal({title: "Po Reject success !", text: "", type: "success"});
                            } else {
                                swal({title: "error !", text: response, type: "error"});
                            }
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "error", text: errorThrown, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled !", "po not reject", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvStck(id) {
        swal({
                title: "Are you sure ?",
                text: "Your will not be able to revers this process ",
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
                        url: '<?= base_url(); ?>Hire_purchase/reactItem',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchStck();
                                swal({title: "Item Reactive success !", text: "", type: "success"});
                            } else {
                                swal({title: "error !", text: response, type: "error"});
                            }
                        },
                        error: function (data, jqXHR, textStatus, errorThrown) {
                            swal({title: "error", text: errorThrown, type: "error"},
                                function () {
                                    location.reload();
                                });
                        }
                    });
                } else {
                    swal("Cancelled !", "Item not active", "error");
                }
            });
    }

</script>