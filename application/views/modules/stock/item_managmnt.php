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
                        <li class="active"><strong>Item Management</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Item Management</h3>
                    <button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group form-horizontal">
                                <label class="col-md-4 col-xs-6 control-label">Category</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="srct" id="srct"
                                            onchange="chckBtn(this.value,'srct')">
                                        <option value="all"> All Category</option>
                                        <?php
                                        foreach ($ctgryinfo as $ctgry) {
                                            echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
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
                                <label class="col-md-4 col-xs-6 control-label">Brand</label>
                                <div class="col-md-6 col-xs-6">
                                    <select class="form-control" name="srbr" id="srbr"
                                            onchange="chckBtn(this.value,'srbr')">
                                        <option value="all">All Brand</option>
                                        <?php
                                        foreach ($brndinfo as $brnd) {
                                            echo "<option value='$brnd->brid'>$brnd->brnm</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4  control-label">Model</label>
                                <div class="col-md-6 ">
                                    <div class="form-group">
                                        <select class="form-control" name="srmd" id="srmd"
                                                onchange="chckBtn(this.value,'srmd')">
                                            <option value="all">All Model</option>
                                            <?php
                                            foreach ($modelinfo as $model) {
                                                echo "<option value='$model->mdid'>$model->mdnm</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchItem()"
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
                                   id="dataTbItem" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center"> NO</th>
                                    <th class="text-center"> B:CODE</th>
                                    <th class="text-center"> CATEGORY</th>
                                    <th class="text-center"> BRAND</th>
                                    <th class="text-center"> MODEL</th>
                                    <th class="text-center"> SIZE/TYPE</th>
                                    <th class="text-center"> CODE</th>
                                    <th class="text-center"> NAME</th>
                                    <th class="text-center"> CREATE</th>
                                    <!--<th class="text-center"> CREATE DATE</th>-->
                                    <th class="text-center"> STATUS</th>
                                    <th class="text-center"> OPTION</th>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Item Create</h4>
            </div>
            <form class="form-horizontal" id="item_add" name="item_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Item Type</label>
                                                <label class="col-md-2 control-label text-left"> Non Stock </label>
                                                <div class="col-md-2">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               class="iswitch iswitch-md iswitch-primary" value="1"
                                                               id="sttp"
                                                               name="sttp" onclick="" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-2 control-label text-left">Stock </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Category</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="ctgr" id="ctgr"
                                                            onchange="chckBtn(this.value,'ctgr');getMdl(this.value,'#modl',2 )">
                                                        <option value="0">-- Select Category --</option>
                                                        <?php
                                                        foreach ($ctgryinfo as $ctgry) {
                                                            echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Brand</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brnd" id="brnd"
                                                            onchange="chckBtn(this.value,'brnd')">
                                                        <option value="0">-- Select Brand --</option>
                                                        <?php
                                                        foreach ($brndinfo as $brnd) {
                                                            echo "<option value='$brnd->brid'>$brnd->brnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Model</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="modl" id="modl"
                                                            onchange="chckBtn(this.value,'modl')">
                                                        <option value="0">-- Select Model --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Size (Type)</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="type" id="type"
                                                            onchange="chckBtn(this.value,'type')">
                                                        <option value="0">-- Select Type --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Item Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="itnm"
                                                           placeholder="Item Name" id="itnm"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Public Code</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="pbcd"
                                                           placeholder="Public Code" id="pbcd"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Inter Code</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="itcd"
                                                           placeholder="Inter Code" id="itcd"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Warranty</label>
                                                <label class="col-md-1 control-label text-left"> No </label>
                                                <div class="col-md-1">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               class="iswitch iswitch-md iswitch-primary" value="1"
                                                               id="wrtp"
                                                               name="wrtp" onclick="warnty(1)" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-1 control-label text-left"> Yes </label>
                                            </div>
                                            <div id="wrntyDiv">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Warranty Mode</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="wrmd" id="wrmd"
                                                                onchange="chckBtn(this.value,'wrmd')">
                                                            <option value="-">-- Select Mode --</option>
                                                            <?php
                                                            foreach ($wrntyinfo as $wrnty) {
                                                                echo "<option value='$wrnty->wrid'>$wrnty->wrds</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Warranty Period</label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="wrpr"
                                                               placeholder="Warranty Period" id="wrpr"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Description</label>
                                                <div class="col-md-6 ">
                                                        <textarea class="form-control" name="remk" id="remk"
                                                                  rows="4" placeholder="Description"> </textarea>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead">View Center Details</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row form-horizontal">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Item Type</label>
                                            <label class="col-md-6  control-label" id="vewIttp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Category</label>
                                            <label class="col-md-6  control-label" id="vewCat"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Brand</label>
                                            <label class="col-md-6  control-label" id="vewBrnd"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Model</label>
                                            <label class="col-md-6  control-label" id="vewMdl"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Size (Type)</label>
                                            <label class="col-md-6  control-label" id="vewTyp"></label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Name</label>
                                            <label class="col-md-6  control-label" id="vewName"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Code</label>
                                            <label class="col-md-6  control-label" id="vewCde"> </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6  control-label">Public Code</label>
                                            <label class="col-md-6  control-label" id="vewPbcd"> </label>
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
                <h4 class="modal-title" id="largeModalHead"><span id="hed"></span></h4>
            </div>
            <form class="form-horizontal" id="item_edt" name="item_edt"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div cass="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Item Type</label>
                                                <label class="col-md-2 control-label text-left"> Non Stock </label>
                                                <div class="col-md-2">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               class="iswitch iswitch-md iswitch-primary" value="1"
                                                               id="sttpEdt"
                                                               name="sttpEdt" onclick="" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-2 control-label text-left">Stock </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Category</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="ctgrEdt" id="ctgrEdt"
                                                            onchange="chckBtn(this.value,'ctgrEdt');getMdl(this.value,'#modlEdt',3 )">
                                                        <option value="0">-- Select Category --</option>
                                                        <?php
                                                        foreach ($ctgryinfo as $ctgry) {
                                                            echo "<option value='$ctgry->ctid'>$ctgry->ctnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Brand</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="brndEdt" id="brndEdt"
                                                            onchange="chckBtn(this.value,'brndEdt')">
                                                        <option value="0">-- Select Brand --</option>
                                                        <?php
                                                        foreach ($brndinfo as $brnd) {
                                                            echo "<option value='$brnd->brid'>$brnd->brnm</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Model</label>
                                                <div class="col-md-6 ">
                                                    <select class="form-control" name="modlEdt" id="modlEdt"
                                                            onchange="chckBtn(this.value,'modlEdt')">
                                                        <option value="0">-- Select Model --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Size (Type)</label>
                                                <div class="col-md-6 col-xs-6">
                                                    <select class="form-control" name="typeEdt" id="typeEdt"
                                                            onchange="chckBtn(this.value,'typeEdt')">
                                                        <option value="0">-- Select Type --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Name</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="itnmEdt" placeholder="Item Name" id="itnmEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Public Code</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="pbcdEdt" placeholder="Item Code" id="pbcdEdt"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Inter Code</label>
                                                <div class="col-md-6 ">
                                                    <input type="text" class="form-control text-uppercase"
                                                           name="itcdEdt" placeholder="Item Code" id="itcdEdt"/>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4 col-xs-6 control-label">Warranty</label>
                                                <label class="col-md-1 control-label text-left"> No </label>
                                                <div class="col-md-1">
                                                    <label class="switch">
                                                        <input type="checkbox"
                                                               class="iswitch iswitch-md iswitch-primary" value="1"
                                                               id="wrtpEdt"
                                                               name="wrtpEdt" onclick="warnty(2)" checked/>
                                                        <span></span>
                                                    </label>
                                                </div>
                                                <label class="col-md-1 control-label text-left"> Yes </label>
                                            </div>
                                            <div id="wrntyDivEdt">
                                                <div class="form-group">
                                                    <label class="col-md-4 col-xs-6 control-label">Warranty Mode</label>
                                                    <div class="col-md-6 col-xs-6">
                                                        <select class="form-control" name="wrmdEdt" id="wrmdEdt"
                                                                onchange="chckBtn(this.value,'wrmdEdt')">
                                                            <option value="-">-- Select Mode --</option>
                                                            <?php
                                                            foreach ($wrntyinfo as $wrnty) {
                                                                echo "<option value='$wrnty->wrid'>$wrnty->wrds</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-4  control-label">Warranty Period</label>
                                                    <div class="col-md-6 ">
                                                        <input type="text" class="form-control" name="wrprEdt"
                                                               placeholder="Warranty Period" id="wrprEdt"/>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Description</label>
                                                <div class="col-md-6 ">
                                                        <textarea class="form-control" name="remkEdt" id="remkEdt"
                                                                  rows="4" placeholder="Description"> </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="auid" name="auid">
                    <input type="hidden" id="func" name="func">
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
        //  ADD VALIDATE
        $("#item_add").validate({  //  ADD VALIDATE

            rules: {
                ctgr: {
                    required: true,
                    notEqual: '0'
                },
                brnd: {
                    required: true,
                    notEqual: '0',
                },
                modl: {
                    required: true,
                    notEqual: '0'
                },
                type: {
                    required: true,
                    notEqual: '0'
                },
                itnm: {
                    required: true,
                },

                pbcd: {
                    //required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_pubcode",
                        type: "post",
                        data: {
                            ctgr: function () {
                                return $("#ctgr").val();
                            },
                            pbcd: function () {
                                return $("#pbcd").val();
                            }
                        }
                    }
                },
                itcd: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_itmcode",
                        type: "post",
                        data: {
                            ctgr: function () {
                                return $("#ctgr").val();
                            },
                            itcd: function () {
                                return $("#itcd").val();
                            }
                        }
                    },
                    maxlength:12
                },

                wrmd: {
                    required: true,
                    notEqual: '-'
                },
                wrpr: {
                    required: true,
                    notEqual: 0,
                    digits: true
                },
            },
            messages: {
                ctgr: {
                    required: 'Please select Category',
                    notEqual: 'Please select Category'
                },
                brnd: {
                    required: 'Please select Brand',
                    notEqual: 'Please select Brand'
                },
                modl: {
                    required: 'Please select Model',
                    notEqual: 'Please select Model'
                },
                type: {
                    required: 'Please select Type',
                    notEqual: 'Please select Type'
                },
                itnm: {
                    required: 'Please enter Item Name',
                },
                itcd: {
                    required: 'Please enter Item Code',
                    remote: 'Item Code already exist this Category',
                },
                pbcd: {
                    required: 'Please enter Public Code',
                    remote: 'Public Code already exist',
                },

                wrmd: {
                    required: 'Please Select Warranty Type',
                    notEqual: 'Please Select Warranty Type',
                },
                wrpr: {
                    required: 'Please Enter Warranty Period',
                    notEqual: 'Please Enter Warranty Period'
                },
            }

        });

        //  Edit VALIDATE
        $("#item_edt").validate({  // BRANCH EDIT VALIDATE
            rules: {
                ctgrEdt: {
                    required: true,
                    notEqual: '0'
                },
                brndEdt: {
                    required: true,
                    notEqual: '0',
                },
                modlEdt: {
                    required: true,
                    notEqual: '0'
                },
                typeEdt: {
                    required: true,
                    notEqual: '0'
                },
                itnmEdt: {
                    required: true,
                },

                wrmdEdt: {
                    required: true,
                    notEqual: '-',
                },
                wrprEdt: {
                    required: true,
                    notEqual: 0,
                    digits: true
                },

                itcdEdt: {
                    required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_itmcode_edt",
                        type: "post",
                        data: {
                            ctgr: function () {
                                return $("#ctgrEdt").val();
                            },
                            itcd: function () {
                                return $("#itcdEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    },
                    maxlength:12
                },
                pbcdEdt: {
                    //required: true,
                    remote: {
                        url: "<?= base_url(); ?>stock/chk_pubcode_edt",
                        type: "post",
                        data: {
                            ctgr: function () {
                                return $("#ctgrEdt").val();
                            },
                            pbcd: function () {
                                return $("#pbcdEdt").val();
                            },
                            auid: function () {
                                return $("#auid").val();
                            }
                        }
                    }
                },

            },
            messages: {
                ctgrEdt: {
                    required: 'Please select Category',
                    notEqual: 'Please select Category'
                },
                brndEdt: {
                    required: 'Please select Brand',
                    notEqual: 'Please select Brand'
                },
                modlEdt: {
                    required: 'Please select Model',
                    notEqual: 'Please select Model'
                },
                typeEdt: {
                    required: 'Please select Type',
                    notEqual: 'Please select Type'
                },
                itnmEdt: {
                    required: 'Please enter Item Name',
                },
                itcdEdt: {
                    required: 'Please enter Item Code',
                    remote: 'Item Code already exist',
                },
                pbcdEdt: {
                    required: 'Please enter Public Code',
                    remote: 'Public Code already exist',
                },
                wrmdEdt: {
                    required: 'Please Select Warranty Type',
                    notEqual: 'Please Select Warranty Type',
                },
                wrprEdt: {
                    required: 'Please Enter Warranty Period',
                    notEqual: 'Please Enter Warranty Period'
                },
            }
        });

        srchItem();

    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    // LOAD MODEL / TYPE
    function getMdl(id, html, tp) {
        $.ajax({
            url: '<?= base_url(); ?>stock/getSubCat',
            type: 'post',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (response) {
                var len = response['mdle'].length;
                var len2 = response['type'].length;

                // TABLE SEARCH FILTER
                if (tp == 1) {

                    if (len != 0) {
                        $(html).empty();
                        $(html).append("<option value='all'>All Model</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response['mdle'][i]['mdid'];
                            var name = response['mdle'][i]['mdnm'];
                            var $el = $(html);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $(html).empty();
                        $(html).append("<option value='0'>-- No Model --</option>");
                    }
                } else {

                    if (len != 0) {
                        $(html).empty();
                        $(html).append("<option value='0'>Select Model</option>");
                        for (var i = 0; i < len; i++) {
                            var id = response['mdle'][i]['mdid'];
                            var name = response['mdle'][i]['mdnm'];
                            var $el = $(html);
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $(html).empty();
                        $(html).append("<option value='0'>-- No Model --</option>");
                    }
                }

                // ADD MODEL
                if (tp == 2) {
                    if (len2 != 0) {
                        $('#type').empty();
                        $('#type').append("<option value='0'> Select Type </option>");
                        for (var a = 0; a < len2; a++) {
                            var id = response['type'][a]['tpid'];
                            var name = response['type'][a]['tpnm'];
                            var $el = $('#type');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#type').empty();
                        $('#type').append("<option value='0'>-- No Type --</option>");
                    }

                } else if (tp == 3) {    // EDIT MODEL
                    if (len2 != 0) {
                        $('#typeEdt').empty();
                        $('#typeEdt').append("<option value='0'> Select Type </option>");
                        for (var a = 0; a < len2; a++) {
                            var id = response['type'][a]['tpid'];
                            var name = response['type'][a]['tpnm'];
                            var $el = $('#typeEdt');
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }
                    } else {
                        $('#typeEdt').empty();
                        $('#typeEdt').append("<option value='0'>-- No Type --</option>");
                    }
                }
            }
        });

    }

    // LOAD MODEL / TYPE EDIT
    function getMdlEdt(id, mdlid, typid) {  // catid,mdlid,typid
        $.ajax({
            url: '<?= base_url(); ?>stock/getSubCat',
            type: 'post',
            data: {
                id: id,
            },
            dataType: 'json',
            success: function (response) {
                var len = response['mdle'].length;
                var len2 = response['type'].length;

                if (len != 0) {
                    $('#modlEdt').empty();
                    $('#modlEdt').append("<option value='0'>Select Model</option>");
                    for (var i = 0; i < len; i++) {
                        var id = response['mdle'][i]['mdid'];
                        var name = response['mdle'][i]['mdnm'];
                        var $el = $('#modlEdt');

                        if (id == mdlid) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }

                        /*$el.append($("<option></option>")
                         .attr("value", id).text(name));*/
                    }
                } else {
                    $('#modlEdt').empty();
                    $('#modlEdt').append("<option value='0'>-- No Model --</option>");
                }

                if (len2 != 0) {
                    $('#typeEdt').empty();
                    $('#typeEdt').append("<option value='0'> Select Type </option>");
                    for (var a = 0; a < len2; a++) {
                        var id = response['type'][a]['tpid'];
                        var name = response['type'][a]['tpnm'];
                        var $el = $('#typeEdt');

                        if (id == typid) {
                            $el.append($("<option selected></option>")
                                .attr("value", id).text(name));
                        } else {
                            $el.append($("<option></option>")
                                .attr("value", id).text(name));
                        }

                        /*$el.append($("<option></option>")
                         .attr("value", id).text(name));*/
                    }
                } else {
                    $('#typeEdt').empty();
                    $('#typeEdt').append("<option value='0'>-- No Type --</option>");
                }

            }
        });

    }

    // WARRANTY DIV
    function warnty(tp) {

        if (tp == 1) {
            if (document.getElementById('wrtp').checked == true) {
                document.getElementById('wrntyDiv').style.display = "block";
            } else {
                document.getElementById('wrntyDiv').style.display = "none";
            }
        } else if (tp == 2) {
            if (document.getElementById('wrtpEdt').checked == true) {
                document.getElementById('wrntyDivEdt').style.display = "block";
            } else {
                document.getElementById('wrntyDivEdt').style.display = "none";
            }
        }
    }

    /* SEARCH */
    function srchItem() {
        var srct = document.getElementById('srct').value;   //CATEGORY
        var srbr = document.getElementById('srbr').value;   //BRAND
        var srmd = document.getElementById('srmd').value;   //MODE
        var stat = document.getElementById('stat').value;   // stat

        $('#dataTbItem').DataTable().clear();
        $('#dataTbItem').DataTable({
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
                {className: "text-left", "targets": [2, 3, 4, 5, 6, 7]},
                {className: "text-center", "targets": [0, 1, 8, 9, 10]},
                {className: "text-right", "targets": []},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[0, "asc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '3%'},
                {sWidth: '3%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '10%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '15%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>stock/srchItem',
                type: 'post',
                data: {
                    srct: srct,
                    srbr: srbr,
                    srmd: srmd,
                    stat: stat,
                }
            }
        });
    }

    /* ADD */
    $("#addAcc").click(function (e) { //  add form
        e.preventDefault();
        if ($("#item_add").valid()) {

            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>stock/chk_itmcode",
                data: {
                    ctgr: function () {
                        return $("#ctgr").val();
                    },
                    itcd: function () {
                        return $("#itcd").val();
                    }
                },
                dataType: 'json',
                success: function (data) {
                    if (data == true) {
                        $('#modalAdd').modal('hide');

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>stock/additem",
                            data: $("#item_add").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchItem();
                                swal({title: "", text: "Item Add Success!", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal({title: "", text: "Item Add Failed !", type: "error"},
                                    function () {
                                        location.reload();
                                    });
                            }
                        });
                    } else {
                        swal({title: "", text: "Item Code already exist this Category", type: "info"});
                    }
                },
            });
        }
    });

    // VIEW ITEM
    function viewItem(auid) {

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/vewItem",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("vewCat").innerHTML = response[i]['ctnm'];
                    document.getElementById("vewBrnd").innerHTML = response[i]['brnm'];
                    document.getElementById("vewMdl").innerHTML = response[i]['mdnm'];
                    document.getElementById("vewTyp").innerHTML = response[i]['tpnm'];
                    document.getElementById("vewName").innerHTML = response[i]['itnm'];
                    document.getElementById("vewCde").innerHTML = response[i]['itcd'];
                    document.getElementById("vewPbcd").innerHTML = response[i]['pbcd'];

                    if (response[i]['sttp'] == 1) {
                        document.getElementById("vewIttp").innerHTML = "<span class='label label-success'> Stock </span>";
                    } else {
                        document.getElementById("vewIttp").innerHTML = "<span class='label label-warning'> Non Stock </span>";
                    }
                }
            }
        })
    }

    /* EDIT VIEW*/
    function edtItem(auid, func) {
        if (func == 'edt') {
            $('#hed').text("Update Item");
            $('#btnNm').text("Update");
            document.getElementById("func").value = 1;

        } else if (func == 'app') {
            $('#hed').text("Approval Item");
            $('#btnNm').text("Approval");
            document.getElementById("func").value = 2;
        }

        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>stock/vewItem",
            data: {
                auid: auid
            },
            dataType: 'json',
            success: function (response) {
                document.getElementById("ctgrEdt").value = response[0]['ctid'];
                document.getElementById("brndEdt").value = response[0]['brid'];
                document.getElementById("modlEdt").value = response[0]['mdid'];
                document.getElementById("typeEdt").value = response[0]['tpid'];
                document.getElementById("itnmEdt").value = response[0]['itnm'];
                document.getElementById("itcdEdt").value = response[0]['itcd'];
                document.getElementById("pbcdEdt").value = response[0]['pbcd'];
                document.getElementById("remkEdt").value = response[0]['dscr'];

                if (response[0]['sttp'] == 1) {         // STOCK ITEM
                    document.getElementById("sttpEdt").checked = true;
                } else {
                    document.getElementById("sttpEdt").checked = false;
                }

                // WARRANTY
                document.getElementById("wrmdEdt").value = response[0]['wrtp'];
                document.getElementById("wrprEdt").value = response[0]['pird'];
                if (response[0]['ifwr'] == 1) {         // WARRANTY IN
                    document.getElementById("wrtpEdt").checked = true;
                    document.getElementById("wrntyDivEdt").style.display = 'block';
                } else {
                    document.getElementById("wrtpEdt").checked = false;
                    document.getElementById("wrntyDivEdt").style.display = 'none';
                }

                document.getElementById("auid").value = response[0]['itid'];
                getMdlEdt(response[0]['ctid'], response[0]['mdid'], response[0]['tpid']); // catid,mdlid,typid
            }
        })
    }

    /* EDIT SUBMIT*/
    $("#subBtn").click(function (e) {
        e.preventDefault();

        var func = document.getElementById('func').value;

        if ($("#item_edt").valid()) {
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

                        if(func == 1){

                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>stock/edtItem",
                                data: $("#item_edt").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    srchItem();
                                    swal({title: "", text: "Item Update success", type: "success"},
                                        function () {
                                            location.reload();
                                        });
                                },
                                error: function () {
                                    swal({title: "", text: "Update Process failed", type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        }else if(func == 2){

                            var jqXHR = jQuery.ajax({
                                type: "POST",
                                url: "<?= base_url(); ?>stock/edtItem",
                                data: $("#item_edt").serialize(),
                                dataType: 'json',
                                success: function (data) {
                                    swal({title: "", text: "Item Approval success", type: "success"});
                                    srchItem();
                                },
                                error: function () {
                                    swal({title: "", text: "Approval Process failed", type: "error"},
                                        function () {
                                            location.reload();
                                        });
                                }
                            });
                        }
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });
        }
    });

    /* REJECT*/
    function rejecItem(id) {
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
                        url: '<?= base_url(); ?>stock/rejItem',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchItem();
                                swal({title: "Item Reject success !", text: "", type: "success"});
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
                    swal("Cancelled !", "Item not Inactive", "error");
                }
            });
    }

    /* REACTIVE*/
    function reactvItem(id) {
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
                        url: '<?= base_url(); ?>stock/reactItem',
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response === true) {
                                srchItem();
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