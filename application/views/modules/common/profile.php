<!DOCTYPE html>
<html class="">

<!-- START CONTENT -->
<section id="main-content" class=" ">
    <section class="wrapper" style=''>

        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
            <div class="page-title">
                <div class="pull-left hidden-xs">
                    <ol class="breadcrumb">
                        <li><a href="<?= base_url(); ?>user"><i class="fa fa-home"></i>Home</a></li>
                        <li class="active"><strong>My Profile</strong></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="col-lg-12">
            <section class="box ">
                <header class="panel_header">
                    <h3 class="title pull-left">Edit Profile</h3>
                </header>

                <form action="<?= base_url() ?>welcome/usr_update" class="form-horizontal" id="usr_update"
                      name="usr_update" method="post">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?php
                            if (!empty($usrinfo)) {
                                foreach ($usrinfo as $user) {
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">First Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="fnm" id="fnm"
                                                           value="<?= $user->fnme; ?>"/>

                                                    <input type="hidden" class="form-control" name="uid" id="uid"
                                                           value="<?= $user->auid; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">NIC</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="nic" id="nic"
                                                           value="<?= $user->unic; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Mobile No</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="mo_no" id="mo_no"
                                                           value="<?= $user->tpno; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Branch</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="brch"
                                                           value="<?= $user->brnm; ?>" readonly/>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Last Name</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="lsnm" id="lsnm"
                                                           value="<?= $user->lnme; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="emil" id="emil"
                                                           value="<?= $user->emid; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Alert No</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="al_no" id="al_no"
                                                           value="<?= $user->almo; ?>"/>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">User Level</label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control" name="uslv" id="uslv"
                                                           value="<?= $user->lvnm; ?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="panel-footer">
                            <a href="#" class="btn btn-primary" data-toggle="modal"
                               data-target="#modal_change_password">Change password</a>
                            <button type="submit" class="btn btn-success pull-right">Submit</button>
                        </div>
                    </div>
                </form>

            </section>
        </div>

    </section>
</section>
<!-- END CONTENT -->

<!-- MODALS -->
<div class="modal animated fadeIn" id="modal_change_password" tabindex="-1" role="dialog"
     aria-labelledby="smallModalHead" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="updt_pass" action="<?= base_url() ?>welcome/upd_pass" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span
                                class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="smallModalHead">Change password</h4>
                </div>
                <div class="modal-body form-horizontal form-group">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Old Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="cur_pss" id="cur_pss"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">New Password</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="nw_pswd" id="nw_pswd"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Repeat New</label>
                        <div class="col-md-9">
                            <input type="password" class="form-control" name="re_nw_pswd" id="re_nw_pswd"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Proccess</button> <!-- data-dismiss="modal" -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- EOF MODALS -->
<!-- END CONTAINER -->
</html>

<script type="text/javascript">
    $().ready(function () {
        $("#updt_pass").validate({  // password validation
            rules: {
                cur_pss: {
                    required: true
                },
                nw_pswd: {
                    required: true
                },
                re_nw_pswd: {
                    required: true,
                    equalTo: "#nw_pswd"
                }
            },
            messages: {
                cur_pss: {
                    required: 'Please enter Current Password'
                },
                nw_pswd: {
                    required: 'Please enter New Password'
                },
                re_nw_pswd: {
                    required: 'Please Retype New Password',
                    equalTo: 'This value not match with New Password'
                }
            }
        });

        $("#usr_update").validate({
            rules: {
                fnm: {
                    required: true
                },
                lsnm: {
                    required: true
                },
                emil: {
                    required: true,
                    email: true
                },
                nic: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                mo_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                al_no: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                fnm: {
                    required: 'Please enter First Name'
                },
                lsnm: {
                    required: 'Please enter Last Name'
                },
                e_mail: {
                    required: 'Please enter E-mail',
                    email: 'This is not a valid E-mail address'
                },
                nic: {
                    required: 'Please enter NIC',
                    minlength: 'This is not a valid NIC',
                    maxlength: 'This is not a valid NIC '
                },
                mo_no: {
                    digits: 'This is not a valid Telephone number',
                    minlength: 'This is not a valid Telephone number',
                    maxlength: 'This is not a valid Telephone number'
                },
                al_no: {
                    digits: 'This is not a valid Telephone number',
                    minlength: 'This is not a valid Telephone number',
                    maxlength: 'This is not a valid Telephone number'
                }

            }
        });

    });

    $("#updt_pass").submit(function (e) { // update password form
        e.preventDefault();
        if ($("#updt_pass").valid()) {

            $('#modal_change_password').modal('hide');

            var jqXHR = jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>welcome/upd_pass",
                data: $("#updt_pass").serialize(),
                dataType: 'json',
                success: function (response) {
                    if (response == true) {
                        swal({title: "", text: "Password Update Successfully!", type: "success"},
                            function () {
                                location = '<?= base_url(); ?>welcome/logout';
                            });
                    }
                    else {
                        swal({title: "", text: "Password Update Failed.. ", type: "error"},
                            function () {
                                location = '<?= base_url(); ?>welcome/profile';
                            });
                    }
                }
            });
        } else {
            //            alert("Error");
        }
    });

    $("#usr_update").submit(function (e) { // update password form

        e.preventDefault();
        if ($("#usr_update").valid()) {
            swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover this information!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3bdd59",
                    confirmButtonText: "Yes, update it!",
                    cancelButtonText: "No, cancel it!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        var jqXHR = jQuery.ajax({
                            type: "POST",
                            url: "<?= base_url(); ?>welcome/usr_update",
                            data: $("#usr_update").serialize(),
                            dataType: 'json',
                            success: function (data) {
                                swal("Updated!", "User Profile has been updated.", "success");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>welcome/profile';
                                }, 2000);
                            },
                            error: function () {
                                swal(" User Profile Update Failed!", "You", "error");
                                window.setTimeout(function () {
                                    location = '<?= base_url(); ?>welcome/profile';
                                }, 2000);
                            }
                        });
                    } else {
                        swal("Cancelled", "User Profile not updated", "error");
                    }
                }
            )

        }
    });


</script>


