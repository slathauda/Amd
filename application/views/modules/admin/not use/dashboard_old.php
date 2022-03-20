<!-- bootstrap js -->
<!--<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.3.min.js" type="text/javascript"></script>-->
<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" type="text/javascript"></script>-->
<script src="<?= base_url(); ?>assets/plugins/toastr/toastr.min.js" type="text/javascript"></script>
<link href="<?= base_url(); ?>assets/plugins/toastr/toastr.css" rel="stylesheet" type="text/css"/>

<script type="text/javascript">
    // Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "400",
        "hideDuration": "400",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
</script>

<?php
//$pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

//if ($pageWasRefreshed) {
    if (isset($_GET['message'])) {
        $message = $_GET['message'];
        if ($message === "success") {
            ?>
            <script>
                toastr.success('Welcome <?php
                    if (!empty($_SESSION['userId'])) {
                        echo $_SESSION['fname'] . " " . $_SESSION['lname'];
                    }
                    ?>..');
            </script>
            <?php
        }
    }
//}
?>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li class="active">Admin </li>
</ul>
<!-- END BREADCRUMB -->

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap">

    <div class="row">
        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong> Admin Dashboard </strong></h3>
                </div>
                <div class="panel-body">
                    <img src="<?= base_url(); ?>uploads/MFIs.jpg" style="width: 90%">
                </div>
            </div>

        </div>
    </div>

</div>
<!-- END PAGE CONTENT WRAPPER -->












