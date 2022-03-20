<link href="<?php echo base_url(); ?>assets/dist/custom_css/fileinput.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/dist/js/fileinput.js"></script>

<!--<link href="<?/*= base_url(); */?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?/*= base_url(); */?>assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" media="screen"/>

<script src="<?/*= base_url(); */?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?/*= base_url(); */?>assets/plugins/datepicker/js/datepicker.js" type="text/javascript"></script>-->

<script type="text/javascript" src="<?= base_url() ?>assets/dist/js/plugins/bootstrap/bootstrap-datepicker.js"></script>


<style>
    .kv-avatar {
        display: inline-block;
    }

    .kv-avatar .fileinput {
        display: table-cell;
        width: 213px;
        height: 83px;
    }
</style>

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
                        <li><a href="">General</a></li>
                        <li class="active"><strong>Company Info</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Company Info</h3>
                </header>

                <div class="content-body">

                    <form class="form-horizontal" id="compny_dtil" name="compny_dtil" enctype="multipart/form-data"
                          action="" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Company Name</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control" id="cpnm"
                                               name="cpnm" value="<?= $compnyinfo[0]->cmne ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Company Address</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control" id="cpadd" name="cpadd"
                                               value="<?= $compnyinfo[0]->cadd ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Company Phone</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control" id="cpph" name="cpph"
                                               value="<?= $compnyinfo[0]->ctel ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Register Date</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control datepicker" data-start-view="0" id="rgdt"
                                               name="rgdt"
                                               value="<?= $compnyinfo[0]->regd ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  control-label"> Report Logo </label>
                                    <div class="col-md-6">
                                        <div class="kv-avatar center-block text-center" style="/*width:250px;*/">
                                            <input type="file" name="picture" id="avatar_1"
                                                   class="file-loading"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="rplg" name="rplg" value="<?= $compnyinfo[0]->rplg ?>">
                                <input type="hidden" id="auid" name="auid" value="<?= $compnyinfo[0]->cmid ?>">
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">System Name</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control text-uppercase" id="synm"
                                               placeholder="Pay " name="synm" value="<?= $compnyinfo[0]->synm ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Email</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="email" class="form-control" id="emil"
                                               placeholder="Pay Date" name="emil"
                                               value="<?= $compnyinfo[0]->ceml ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Hotline</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control" id="mobi"
                                               placeholder="Hotline" name="mobi"
                                               value="<?= $compnyinfo[0]->chot ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4  col-xs-6 control-label">Register No</label>
                                    <div class="col-md-6 col-xs-6">
                                        <input type="text" class="form-control text-uppercase" id="rgno"
                                               placeholder="Pay Date" name="rgno"
                                               value="<?= $compnyinfo[0]->regn ?>"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                </div>
                                <!-- <div class="form-group">
                                    <label class="col-md-4  control-label"> Company Logo <br>(For Front
                                        Page)</label>
                                    <div class="col-md-6">
                                        <div class="kv-avatar center-block text-center" style="width:250px;">
                                            <input type="file" name="picture2" id="avatar_2"
                                                   class="file-loading"></div>
                                    </div>
                                </div>
                                <input type="hidden" id="cplg" name="cplg" value="<? /*= $compnyinfo[0]->cplg */ ?>">-->
                            </div>

                        </div>
                        <div class="row">
                            <div class="pull-right">
                                <button type="submit" id="process_btn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

</html>

<script>
    $().ready(function () {

        // REPORT LOGO
        $("#avatar_1").fileinput({
            overwriteInitial: true,
            maxFileSize: 500,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="fa fa-folder-open" aria-hidden="true"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            removeTitle: 'Remove',
            elErrorContainer: '#kv-avatar-errors-1',
            msgErrorClass: 'alert alert-block alert-danger',
            defaultPreviewContent: '<img src="<?= base_url() ?>uploads/report_logo/<?= $compnyinfo[0]->rplg ?>" alt="" style="width:150px;height:100px">',
            layoutTemplates: {
                main2: '{preview} {remove} {browse}'
            },
            allowedFileExtensions: ["jpg", "png", "jpeg"]
        });

        $("#compny_dtil").validate({  // validation
            rules: {
                cpnm: {
                    required: true,
                },
                cpadd: {
                    required: true,
                },
                cpph: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
                synm: {
                    required: true,
                },
                emil: {
                    required: true,
                },
                mobi: {
                    required: true,
                    minlength: 10,
                    maxlength: 10,
                    digits: true
                },
            },
            messages: {
                cpnm: {
                    required: 'Please Enter Company Name',
                },
                cpadd: {
                    required: 'Please Enter Company Address',
                },
                cpph: {
                    required: 'Please Enter Company Phone',
                    minlength: 'This not a valid no',
                    maxlength: 'This not a valid no',
                },
                synm: {
                    required: 'Please Enter System Name',
                },
                emil: {
                    required: 'Please Enter Email',
                },
                mobi: {
                    required: 'Please Enter Company Hotline',
                    minlength: 'This not a valid no',
                    maxlength: 'This not a valid no',
                },
            }
        });

    });


    /* ADD */
    $("#compny_dtil").submit(function (e) {
        e.preventDefault();

        if ($("#compny_dtil").valid()) {

            var formObj = $(this);
            var formData = new FormData(this);
            $.ajax({
                url: "<?= base_url(); ?>admin/updateBranding",
                type: 'POST',
                data: formData,
                mimeType: "multipart/form-data",
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    swal({title: "", text: "Branding Update success", type: "success"},
                        function () {
                            location.reload();
                        }
                    );
                },
                error: function () {
                    swal({title: "Branding Update Failed", text: "Contact system admin", type: "error"},
                        function () {
                            location.reload();
                        }
                    );
                }
            });

        }
    });


</script>