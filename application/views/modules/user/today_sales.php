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
                        <li><a href="">User</a></li>
                        <li class="active"><strong>Today Sales</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Today Sales</h3>
                    <!--<button type="button" class="btn btn-info btn-corner pull-right" data-toggle="modal"
                            data-target="#modalAdd">
                        <span><i class="fa fa-plus"></i></span> Add New
                    </button>-->
                </header>

                <div class="content-body">
                    <div class="row form-horizontal">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker"
                                           value="<?= date('Y-m-d') ?>" name="frdt" id="frdt"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-6 control-label">From Date</label>
                                <div class="col-md-6 col-xs-6">
                                    <input type="text" class="form-control datepicker"
                                           value="<?= date('Y-m-d') ?>" name="todt" id="todt"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-md-4 col-xs-12 text-right"></label>
                                <div class="col-md-6 col-xs-12 text-right">
                                    <button type="button form-control  " onclick="srchSles()"
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
                                   id="dataTbSls" width="100%">
                                <thead>
                                <tr>
                                    <th class="text-center"> NO</th>
                                    <th class="text-center"> INVO NO</th>
                                    <th class="text-center"> CUSTOMER NAME</th>
                                    <th class="text-center"> DATE</th>
                                    <th class="text-center"> AMOUNT</th>
                                    <th class="text-center"> CRBY</th>
                                    <th class="text-center"> CRDT</th>
                                    <th class="text-center"> OPTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <th colspan="4"></th>
                                <th></th>
                                <th colspan="3"></th>
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
        srchSles();
    });

    function chckBtn(id, httml) {
        if (id == '-') {
            document.getElementById(httml).style.borderColor = "red";
        } else {
            document.getElementById(httml).style.borderColor = "";
        }
    }

    /* SEARCH */
    function srchSles() {
        var frdt = document.getElementById('frdt').value;
        var todt = document.getElementById('todt').value;

        $('#dataTbSls').DataTable().clear();
        $('#dataTbSls').DataTable({
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
                {className: "text-left", "targets": [2, 5, 6]},
                {className: "text-center", "targets": [0, 1, 3, 7]},
                {className: "text-right", "targets": [4]},
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
                {sWidth: '10%'},
                {sWidth: '10%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/getSales',
                type: 'post',
                data: {
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

                //COLUMN 4 TTL
                var t1 = api.column(4).data().reduce(function (a, b) {
                    // b = $(b).text();
                    return intVal(a) + intVal(b);
                }, 0);
                $(api.column(4).footer()).html(numeral(t1).format('0,0.00'));

            },
        });
    }

    /* VIEW*/
    function vewInvo(id) {
        window.open('<?= base_url(); ?>user/invoicPrint/' + id, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
    }

    /* REPRINT*/
    function reprint(id) {
        window.open('<?= base_url(); ?>user/invoicPrint/' + id, 'popup', 'width=800,height=600,scrollbars=no,resizable=no');
    }


</script>