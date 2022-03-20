<link href="<?php echo base_url(); ?>assets/dist/custom_css/fileinput.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url(); ?>assets/dist/js/fileinput.js"></script>

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

<body class="">
<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li>General</li>
    <li class="active"> Branding</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Branding</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <h3 class="text-title"><span class="fa fa-bank"></span> Company Information </h3>

                        <form class="form-horizontal" id="compny_dtil" name="compny_dtil" enctype="multipart/form-data"
                              action="" method="post">
                            <div class="panel-body form-horizontal">

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
                                            <input type="text" class="form-control datepicker" id="rgdt" name="rgdt"
                                                   value="<?= $compnyinfo[0]->regd ?>"/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-4  control-label"> Report Logo </label>
                                        <div class="col-md-6">
                                            <div class="kv-avatar center-block text-center" style="width:250px;">
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
                                                   placeholder="Pay Date" name="mobi"
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
                                        <label class="col-md-4  control-label"> Company Logo <br>(For Front Page)</label>
                                        <div class="col-md-6">
                                            <div class="kv-avatar center-block text-center" style="width:250px;">
                                                <input type="file" name="picture2" id="avatar_2"
                                                       class="file-loading"></div>
                                        </div>
                                    </div>
                                    <input type="hidden" id="cplg" name="cplg" value="<?= $compnyinfo[0]->cplg ?>">
                                </div>
                            </div>
                            <div class="panel-footer">
                                <button type="submit" id="process_btn" class="btn btn-success pull-right">Process
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->

</body>

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
        // COMPANY LOGO
        $("#avatar_2").fileinput({
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
            defaultPreviewContent: '<img src="<?= base_url() ?>uploads/compny_logo/<?= $compnyinfo[0]->cplg ?>" alt="" style="width:150px;height:100px">',
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


    //  process
    //$("#process_btn").on('click', function (e) { // add form
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












