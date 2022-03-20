<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="<?= base_url(); ?>admin">Home</a></li>
    <li class="active">System Developer Comment</li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> System Developer Comment </strong></h3>
                    <?php if ($userlvl[0]->usmd == 1) { ?>
                        <button class="btn-sm btn-info pull-right" data-toggle="modal" data-target="#modalAdd"><span><i
                                        class="fa fa-plus"></i></span> Add Comment
                        </button>
                    <?php } ?>
                </div>
                <div class="panel-body">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body panel-body-table" style="padding:10px;">
                                <div class="table-responsive">
                                    <table class="table datatable table-bordered table-striped table-actions"
                                           id="dataTbDvlp" width="100%">
                                        <thead>
                                        <tr>
                                            <th class="text-center">NO</th>
                                            <th class="text-center">MODULE</th>
                                            <th class="text-center">COMMENT</th>
                                            <th class="text-center">COMMENT BY</th>
                                            <th class="text-center">COMMENT DATE</th>
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

<!-- Add Model -->
<div class="modal" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> New Comment </h4>
            </div>
            <form class="form-horizontal" id="cmnt_add" name="cmnt_add"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Module</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="mdle"
                                                               placeholder="Module"
                                                               id="mdle"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Comment</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="remk"
                                                              name="remk" placeholder="Comment"></textarea>
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
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Add Model -->

<!-- edit Model -->
<div class="modal" id="modaledit" name="modaledit" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                            class="sr-only">Close</span></button>
                <h4 class="modal-title" id="largeModalHead"><span class="fa fa-tag"></span> Edit Comment </h4>
            </div>
            <form class="form-horizontal" id="commEdit" name="commEdit"
                  action="" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4  control-label">Module</label>
                                                <div class="col-md-6 ">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="mmdle"
                                                               placeholder=""
                                                               id="mmdle"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Comment</label>
                                                <div class="col-md-6 ">
                                                    <textarea class="form-control" rows="4" id="cchng"
                                                              name="cchng" placeholder=""></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="chid" name="chid">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="subBtn" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End edit Model -->

<script>
    $().ready(function () {

        srchDvlpCmnt();

        $("#cmnt_add").validate({  // BRANCH ADD VALIDATE
            rules: {
                mdle: {
                    required: true,
                },
                remk: {
                    required: true,
                }
            },
            messages: {
                mdle: {
                    required: 'Please enter module name',
                },
                remk: {
                    required: 'Please enter comment',
                }
            }
        });

    });

    // Search btn
    function srchDvlpCmnt() {

        $('#dataTbDvlp').DataTable().clear();
        $('#dataTbDvlp').DataTable({
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
            // "serverSide": true,
            "columnDefs": [
                {className: "text-left", "targets": [1, 2]},
                {className: "text-center", "targets": [0, 3, 4,5]},
                {className: "text-nowrap", "targets": [1]}
            ],
            "order": [[4, "desc"]], //ASC  desc
            "aoColumns": [
                {sWidth: '2%'},
                {sWidth: '10%'},
                {sWidth: '20%'},
                {sWidth: '5%'},
                {sWidth: '5%'},
                {sWidth: '5%'}
            ],
            "ajax": {
                url: '<?= base_url(); ?>user/srchCmment',
                type: 'post',
                data: {}
            }
        });
    }

    $("#cmnt_add").submit(function (e) { // cenyer add form
        e.preventDefault();
        if ($("#cmnt_add").valid()) {  // modalAdd
            $('#modalAdd').modal('hide');
            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>user/addDvlpCommnt",
                data: $("#cmnt_add").serialize(),
                dataType: 'json',
                success: function (data) {
                    srchDvlpCmnt();
                    swal({title: "", text: "New Comment Add Success!", type: "success"},
                        function () {
                            location.reload();
                        });
                },
                error: function () {
                    swal({title: "", text: "New Comment Added Failed!", type: "error"},
                        function () {
                            location.reload();
                        });
                }
            });
        }
    });



    function edtcomt(chid) {
        $.ajax({
            type: "POST",
            url: "<?= base_url(); ?>user/vewCmment",
            data: {
                chid: chid
            },
            dataType: 'json',
            success: function (response) {
                var len = response.length;
                for (var i = 0; i < len; i++) {
                    document.getElementById("mmdle").value = response[i]['mdle'];
                    document.getElementById("cchng").value = response[i]['chng'];
                    document.getElementById("chid").value = response[i]['chid'];

                }

            }
        })
    }


    $("#commEdit").submit(function (e) {
        e.preventDefault();
            swal({
                    title: "Are you sure Update Comment?",
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
                        $('#modaledit').modal('hide');
                        document.getElementById('subBtn').disabled = true;

                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>user/edtCmment",
                            data: $("#commEdit").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                srchDvlpCmnt();
                                swal({title: "Comment Update Success!", text: "", type: "success"},
                                    function () {
                                        location.reload();
                                    });
                            },
                            error: function () {
                                swal("Failed!", "", "error");
                                window.setTimeout(function () {
                                    // location = '<?= base_url(); ?>admin/branch';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", " ", "error");
                    }
                });



    });









</script>












