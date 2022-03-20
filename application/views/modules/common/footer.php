<?php
$this->load->model('Generic_model'); // load model
$data = $this->Generic_model->getData('com_det', array('cmne', 'synm', 'indt'), array('stat' => 1));
?>
<!DOCTYPE html>
<div class="fter">
    © <?= date_format(date_create($data[0]->indt), "Y") . " - " . $data[0]->cmne ?> | Powered By
    <a href="http://gemusolution.com/" target="_blank">gamusolution</a> v 1.0 (<?= date("Y-m-d"); ?>)&nbsp;&nbsp;&nbsp;
</div>

<!-- MESSAGE BOX-->
<div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Are you sure you want to log out?</p>
                <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <a href="<?= base_url() ?>welcome/logout" class="btn btn-success btn-lg">Yes</a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->


<!-- A L L  S Y S T E M  J S -->

<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
<script src="<?= base_url(); ?>assets/plugins/rickshaw-chart/vendor/d3.v3.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/rickshaw-chart/js/Rickshaw.All.js"></script>
<script src="<?= base_url(); ?>assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/morris-chart/js/raphael-min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/morris-chart/js/morris.min.js" type="text/javascript"></script>
<!--<script src="--><? //= base_url(); ?><!--assets/plugins/jvectormap/jquery-jvectormap-2.0.1.min.js" type="text/javascript"></script>-->
<!--<script src="--><? //= base_url(); ?><!--assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>-->
<script src="<?= base_url(); ?>assets/plugins/gauge/gauge.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/icheck/icheck.min.js" type="text/javascript"></script>


<!-- CORE TEMPLATE JS - START -->
<script src="<?= base_url(); ?>assets/js/scripts.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS - END -->

<!-- Sidebar Graph - START -->
<script src="<?= base_url(); ?>assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/js/chart-sparkline.js" type="text/javascript"></script>
<!-- Sidebar Graph - END -->


<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->
<script src="<?= base_url(); ?>assets/plugins/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/TableTools/js/dataTables.tableTools.min.js"
        type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js"
        type="text/javascript"></script>
<script src="<?= base_url(); ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.js"
        type="text/javascript"></script>
<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


<script src="<?= base_url() ?>assets/dist/sweetalert/sweetalert.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>assets/dist/sweetalert/sweetalert.css" rel="stylesheet" type="text/css"/>

<!-- DATA TABLE -->
<link href="<?= base_url() ?>assets/plugins/datatables/css/jquery.dataTables.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url() ?>assets/plugins/datatables/extensions/TableTools/css/dataTables.tableTools.min.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<link href="<?= base_url() ?>assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<link href="<?= base_url() ?>assets/plugins/datatables/extensions/Responsive/bootstrap/3/dataTables.bootstrap.css"
      rel="stylesheet"
      type="text/css" media="screen"/>
<!-- END DATA TABLE -->

<link href="<?= base_url() ?>assets/plugins/jquery-ui/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css"
      media="screen"/>
<!--<link href="<? /*= base_url() */ ?>assets/plugins/datepicker/css/datepicker.css" rel="stylesheet" type="text/css"
      media="screen"/>-->
<!--<link href="<? /*= base_url() */ ?>assets/plugins/daterangepicker/css/daterangepicker-bs3.css" rel="stylesheet"
      type="text/css"
      media="screen"/>-->
<!--<link href="<? /*= base_url() */ ?>assets/plugins/timepicker/css/timepicker.css" rel="stylesheet" type="text/css"
      media="screen"/>-->
<!--<link href="<? /*= base_url() */ ?>assets/plugins/datetimepicker/css/datetimepicker.min.css" rel="stylesheet" type="text/css"
      media="screen"/>-->
<link href="<?= base_url() ?>assets/plugins/colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet"
      type="text/css"
      media="screen"/>
<link href="<?= base_url() ?>assets/plugins/ios-switch/css/switch.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>assets/plugins/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url() ?>assets/plugins/select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>assets/plugins/typeahead/css/typeahead.css" rel="stylesheet" type="text/css"
      media="screen"/>
<link href="<?= base_url() ?>assets/plugins/multi-select/css/multi-select.css" rel="stylesheet" type="text/css"
      media="screen"/>
<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->


