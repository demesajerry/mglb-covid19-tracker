<!DOCTYPE html>
<html>
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
<!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-179719337-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-179719337-1');
</script>
 -->
  <meta http-equiv="Cache-Control" content="no-store" />
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LAB-Tracker</title>
  <link rel="icon" href="<?php echo base_url('assets/images/lblogo.png'); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!--CSS FOR DATATABLE-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css'); ?>" />
  <link rel="stylesheet" href="<?=base_url();?>assets/bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fav5/css/all.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/main.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/skin-green.min.css">
  <script src="<?php echo base_url(); ?>assets/js/jquery-alert.js"></script>
  <!-- Google Font   
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/googleFont.css">
-->
  <!-- ./wrapper -->

  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/webcam.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/bootstrap-checkbox/dist/js/bootstrap-checkbox.js" defer></script>
</head>
<?php
//set the profile pic of user
//if with profile pic get pic
if(file_exists((FCPATH)."assets/images/user_photo/user".$userdata->userid.".jpg")) { 
    $image =  base_url()."assets/images/user_photo/user".$userdata->userid.".jpg?".time();
}
//else get blank pic icon
else{
$image = base_url().'assets/dist/img/portrait_placeholder.png"';}
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo base_url('assets/images/lblogo.png'); ?>" height="45" width="45"/>
</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo base_url('assets/images/lblogo.png'); ?>" height="45" width="45"/>LAB-Tracker</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell"></i>
              <span class="label label-danger" id="alert_count"></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header" id="alert_header_title"></li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu" id="restricted_client_list">
                </ul>
              </li>
              <li class="footer"><a href="#">See All Restricted Entries Today</a></li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php echo $image; ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $userdata->username; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo $image; ?>" class="img-circle" alt="User Image">

                <p>
                <?php echo $userdata->fullname; ?>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo base_url(); ?>Authentication/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
                <img src="<?php echo $image; ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <br>
          <p><?php echo $userdata->fullname; ?></p>
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <?php echo $links; ?>
      </ul>
    </section>    <!-- /.sidebar -->
  </aside>

    <?php  $this->load->view($content); ?>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>MGLB Covid-19 Tracker</b> Website v1.0
    </div>
    <strong>Copyright &copy; 2020 </strong>Developed by <b>MGLB - ICSO</b>
  </footer>
</div>

<!-- page script -->
</body>

  <!--DatePicker-->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
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

<!--Crop Image and upload-->
<!-- <script src="<?php echo base_url('assets/croppie/croppie.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/croppie/croppie.css'); ?>" />
 --><link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/qr-reader/dist/css/qrcode-reader.css">
<script src="<?php echo base_url(); ?>assets/js/qr-reader/dist/js/qrcode-reader.min.js?v=20190604"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-generator/jquery.qrcode.min.js"></script>
<script type="text/javascript" >
    function patients_list(id){
      $.ajax({
      type: "POST",
      url: "<?php echo base_url()."patients/patient_list"; ?>",
      data: {classification:0},
      success: function(data){ 
          var options='';
          options += `<option value='0'>UNKNOWN</option>`;
          $.each(data.patient_list, function(key, val){
            if(val.id == id){
              options += `<option value='${val.id}' selected>${val.patient_id}
                        </option>`;
            }else{
              options += `<option value='${val.id}'>${val.patient_id}
                        </option>`;
            }
          })
          $('#possible_link').html(options);
        }
      });
    }

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

  function convert_date_report(date){
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = parseInt(from.getMonth())+1;
    month   = month < 10? '0'+month:month;
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    converted_date = month + '-' + day + '-'+ yr;
    return converted_date;
  }


  function convert_datetime(date){
    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = from.getMonth();
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    h     = from.getHours() < 10? '0'+from.getHours():from.getHours();
    m     = from.getMinutes() < 10? '0'+from.getMinutes():from.getMinutes();
    d     = from.getSeconds() < 10? '0'+from.getSeconds():from.getSeconds();
    converted_date = monthNames[month] + ' ' + day + ', '+ yr +' @ '+ h + ":" + m + ":" + d;
;
    return converted_date;
  }

$(document).ready(function () {
  $('.checkbox').checkboxpicker();

 $('.daterange').daterangepicker({
  autoUpdateInput: false,
  autoApply: true,
  locale: {
      format: 'Y-MM-D'
    }
  });

 $('.daterange_full').daterangepicker({
  autoUpdateInput: false,
  autoApply: true,
  locale: {
      format: 'Y-MM-D'
    }
  });

 $('.daterange2').daterangepicker({
  autoUpdateInput: false,
  autoApply: true,
  locale: {
      format: 'Y-MM-D'
    }
  });
 
 $('.daterange').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('Y-MM-D') + ' - ' + picker.endDate.format('Y-MM-D'));
  });
 
 $('.daterange_full').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('MMM DD, Y') + ' - ' + picker.endDate.format('MMM DD, Y'));
  });

  $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

    $( "#dod" ).datepicker({
    //changeYear:true,
    changeMonth: true,
    //yearRange: "1910:2030",
    dateFormat: 'MM dd'
    });

    $('body').on('focus',".date2", function(){
        $(this).datepicker({
                changeYear:true,
                changeMonth: true,
                yearRange: "1920:2040",
                dateFormat: 'MM dd, yy'
                });
    });

    $( ".date" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1920:2040",
    dateFormat: 'MM dd, yy',
    showButtonPanel: true,
     closeText: 'Clear',
     onClose: function (dateText, inst) {
         if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
             document.getElementById(this.id).value = '';
         }
     }
    });

    $( ".datepicker" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2019:2030",
    dateFormat: 'yy-mm-dd',
    });

    $( ".datepicker-imm" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "2015:2030",
    dateFormat: 'yy-mm-dd'
    });

    $( ".birthday" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "-100:+0",
    dateFormat: 'yy-mm-dd',
    maxDate: '0'
    });

    $( ".eoq" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "-1:+1",
    dateFormat: 'yy-mm-dd',
    //maxDate: '0'
    });

    $('#payment_month').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy'
    }).focus(function() {
    var thisCalendar = $(this);
    $('.ui-datepicker-calendar').detach();
    $('.ui-datepicker-close').click(function() {
    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    thisCalendar.datepicker('setDate', new Date(year, month, 1));
      });
    });

    $('#fpayment_month').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    dateFormat: 'MM yy'
    }).focus(function() {
    var thisCalendar = $(this);
    $('.ui-datepicker-calendar').detach();
    $('.ui-datepicker-close').click(function() {
    var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
    var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
    thisCalendar.datepicker('setDate', new Date(year, month, 1));
      });
    });



 $('.select2').select2({ width: '100%' });
});
    $(".btnSubmit").one('click', function (event) {  
           event.preventDefault();
           $(this).prop('disabled', true);
     });
  function webcam() {
      Webcam.set({
        width: 220,
        height: 155,
        dest_width: 630,
        dest_height: 420,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach( '#my_camera' );
  }   

  function webcam_physical_exam() {
      Webcam.set({
        width: 400,
        height: 320,
        dest_width: 400,
        dest_height: 320,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach( '#my_camera' );
  }   

    function webcam_disposal() {
      Webcam.set({
        width: 220,
        height: 125,
        dest_width: 630,
        dest_height: 420,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach( '#my_camera' );
  }   

    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="220" height="155"/>';
            $('#pic_trigger').val('1');
            if($("#med_trigger").val()== "1"){
            $("#submit").removeAttr("disabled");
            }
        } );
    }

function check_alerts(){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url(); ?>"+'admin/check_alerts',
  success: function(data){
    var alert_list='';
    var alert_count = Object.keys(data).length;
    $.each(data, function(key, val){
    var time = val.datetime.split(' ');
      alert_list +=`<li class='markAsRead' alert_id='${val.alert_id}'>
                      <a href="#">
                        <div class="pull-left text text-success">
                          ${val.fullname}
                        </div>
                        <h4>
                          <small>Mark as read</small>
                        </h4>
                        <br>
                        <p class="text-left">${val.establishment} </p>
                        <p class="text-left"><i class="fa fa-clock-o"></i>${time[1]}</p>
                      </a>
                    </li>
                    `;
          });
    $('#alert_count').html(alert_count);
    $('#alert_header_title').html(`${alert_count} unread restricted client entries`);
    $('#restricted_client_list').html(alert_list);
  }
});
}

$('.navbar-custom-menu').on('click','.markAsRead',function(){
  //alert(this.getAttribute("alert_id"));
})

setInterval(function(){
check_alerts();
}, 300000);
check_alerts();

</script>
<style>
  body{
    font-size: 12px;
  }
  .sidebar-mini:not(.sidebar-mini-expand-feature).sidebar-collapse .sidebar-menu > li:hover > .treeview-menu {
    top: 40px !important;
  }
.modal-header-success {
    color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #5cb85c;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-warning {
  color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #f0ad4e;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-danger {
  color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #d9534f;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-info {
    color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #5bc0de;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.modal-header-primary {
  color:#fff;
    padding:9px 15px;
    border-bottom:1px solid #eee;
    background-color: #428bca;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
     border-top-left-radius: 5px;
     border-top-right-radius: 5px;
}
.uppercase {
  text-transform: uppercase;
  }
.hideme {
  display:none;
}
.user-panel {
height: 62px !important;
padding: 2px;
  }
.user-panel > .image > img {
  width: 100%;
  max-width: 45px;
  height: 45px;
}
.user-panel > .info {
  padding: 2px 2px 5px 5px;
}
table.dataTable {
  border-collapse: collapse;
}
table.dataTable thead th, table.dataTable thead td {
    padding: 10px 18px;
    border-bottom: 1px solid #111;
}
table.dataTable tbody td {
  vertical-align: top;
}
.dataTables_wrapper .dataTables_scroll div.dataTables_scrollBody>table>tbody>tr>td {
    vertical-align: top;
}
.checkbox{
  display: none;
}
div .dt-buttons{
   position: relative;
    display: inline-block;
    vertical-align: middle;
}
 
.dataTables_length{
    float : left;
}
.dataTables_length label{
font-weight: bold !important;    
}
.dataTables_filter label{
font-weight: bold !important;    
}
.dataTables_wrapper .dataTables_filter {
    float: right;
    text-align: right;
    font-weight: bold !important;
}
</style>
<script src="<?php echo base_url(); ?>assets/js/sha1.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/toastr/toastr.min.css">
<script src="<?php echo base_url(); ?>assets/js/toastr/toastr.min.js" type="text/javascript"></script>
</html>
