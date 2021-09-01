</body>

</html>
  <link rel="stylesheet" href="<?=base_url();?>assets/bower_components/select2/dist/css/select2.min.css">
  <!--DatePicker-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<!--DATERANGE PICKER -->
<script src="<?php echo base_url(); ?>assets/js/daterange/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/daterange/daterangepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/daterange/daterangepicker.css">
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="<?php echo base_url(); ?>assets/bower_components/select2/dist/js/select2.full.min.js"></script>

  <!--call datatable print, pdf, excel button and select row required to be put after the datatable table -->
  <script type="text/javascript" src="<?php echo base_url('assets/datatables/datatables.min.js'); ?>"></script>
<!-- SlimScroll -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>

<!-- <script src="<?php echo base_url('assets/croppie/croppie.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/croppie/croppie.css'); ?>" />
 --><script src="<?php echo base_url(); ?>assets/admin2/js/canvas.js"></script>
<link href="<?php echo base_url('assets/js/tree/Themes/ui-lightness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/html5-qrcode.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/qr-reader/dist/css/qrcode-reader.css">
<script src="<?php echo base_url(); ?>assets/js/qr-reader/dist/js/qrcode-reader.min.js?v=20190604"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-generator/jquery.qrcode.min.js"></script>

<script type="text/javascript">
   $('.select2').select2();
  function convert_date(date){
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = from.getMonth();
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    converted_date = monthNames[month] + ' ' + day + ', '+ yr;
    return converted_date;
  }
      $( ".datepicker" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "-100:+0",
    dateFormat: 'M dd, yy',
    maxDate: '0'
    });

  function oddeven_scheme(brgyCode,citymunCode){
    var d = new Date();
    var day = d.getDay();
    var odd = ["043411001", "043411004", "043411005", "043411006", "043411015", "043411013", "043411011"];
    var even = ["043411002", "043411003", "043411007", "043411008", "043411010", "043411012", "043411014"];
    if ((day % 2 === 0 && even.includes(brgyCode)) || (day % 2 != 0 && odd.includes(brgyCode)) ) {
      return true;
    }else{
      return false;
    }
  }
</script>
<script src="<?php echo base_url(); ?>assets/admin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin2/js/sb-admin-2.min.js"></script>
