<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>MGLB-COVID19-TRACKER</title>
  <link rel="icon" href="<?php echo base_url('assets/images/lblogo.png'); ?>">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<!--   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
 -->  <!--CSS FOR DATATABLE-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css'); ?>" />
  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/css/sb-admin-2.min.css" rel="stylesheet">
  <!--CSS FOR DATATABLE-->
<!--   
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatables/datatables.min.css'); ?>" />
<link href="<?php echo base_url('assets/js/tree/Themes/smoothness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/tree/CSS/jHTree.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/tree/js/jQuery.jHTree.js'); ?>"></script>
 -->  
<script src="<?php echo base_url(); ?>assets/js/webcam.min.js"></script>
<script src="<?php echo base_url('assets/js/tree/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script type="text/javascript">
$(function () {
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
   $(".sidebar").toggleClass("toggled");
  }
});
</script>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
          <img src="<?php echo base_url('assets/images/lblogo.png'); ?>" height="45" width="45"/>
        <div class="sidebar-brand-text mx-3">COVID19-Tracker</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">
      <!-- Heading -->
      <div class="sidebar-heading">
        Contact Tracing
      </div>
      <!-- Nav Item - Pages Collapse Menu -->
      <?php 
      if(isset($this->session->userdata['user'])){
      ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Client_profile">
          <i class="fa fa-user"></i>
          <span>Profile</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Health_declaration">
          <i class="fa fa-hospital"></i>
          <span>Health Declaration</span></a>
      </li>
      <?php 
      }
      ?> 
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Contact_tracing/registration">
          <i class="fa fa-address-card"></i>
          <span>Registration</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Vaccination">
          <i class="fa fa-syringe"></i>
          <span>Vaccine Pre-Registration</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Vaccination/verifier">
          <i class="fa fa-search"></i>
          <span>Pre-Registration Verifier</span></a>
      </li>
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow navbar-fixed-top">
                <!-- Sidebar Toggler (Sidebar) -->
        <button class="rounded-circle border-0" id="sidebarToggle">
          <i class="fa fa-bars"></i>
        </button>
        Ligtas Ang Bayan Laban sa Covid-19
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                  <?php
                    if(isset($this->session->userdata['user'])){
                       echo $this->session->userdata['user']['fullname'];
                    }else{
                      echo 'Login';
                    }
                  ?>
                </span>
                <img class="img-profile  rounded-circle" src="<?php echo base_url('assets/images/icon/user.jfif'); ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <?php
                    if(isset($this->session->userdata['user'])){
                  ?>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" id="logout-btn">
                      <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Logout
                    </a>
                  <?php
                    }else{
                  ?>
                    <a class="dropdown-item" href="#" id="login-btn">
                      <i class="fas fa-sign-in-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                      Login
                    </a>
                  <?php
                    }
                  ?>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->

    <?php  $this->load->view($content); ?>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; MGLB - ICSO 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>
  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a href="#" class="btn btn-primary" id="confirm_logout">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Login Modal-->
  <div class="modal fade" id="loginModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Sign in</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form  method="post">
        <div class="modal-body">
            <div class="form-group has-feedback">
              <input type="text" class="form-control" id="login_username" placeholder="Username">
              <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
              <input type="password" id="login_password" class="form-control" placeholder="Password">
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button type="button" id="btnlogin" class="btn btn-primary btn-flat">Sign In</button>
        </div>
      </form>
      </div>
    </div>
  </div>

</body>

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
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
 --><!-- FastClick -->
<!-- <script src="<?php echo base_url(); ?>assets/bower_components/fastclick/lib/fastclick.js"></script>
 --><!-- AdminLTE App -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>
 --><!-- AdminLTE for demo purposes -->
<!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
 -->
<!-- <script src="<?php echo base_url(); ?>assets/admin2/js/canvas.js"></script>
 -->
 <link href="<?php echo base_url('assets/js/tree/Themes/ui-lightness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/html5-qrcode.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/qr-reader/dist/css/qrcode-reader.css">
<script src="<?php echo base_url(); ?>assets/js/qr-reader/dist/js/qrcode-reader.min.js?v=20190604"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-generator/jquery.qrcode.min.js"></script>

<script type="text/javascript">
var url = '<?php echo base_url(); ?>';
  $('#login-btn').click(function(){
    $('#loginModal').modal('show');
  });

  $('#logout-btn').click(function(){
    $('#logoutModal').modal('show');
  });

  $('#confirm_logout').click(function(){
    window.location.href = "<?php echo base_url(); ?>/Authentication/client_logout";
  });
   $('.select2').select2();
  function convert_date_full(date){
    const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun",
                        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = from.getMonth();
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    converted_date = monthNames[month] + ' ' + day + ', '+ yr;
    return converted_date;
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

  function convert_date_M_D(date){
    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];

    var from    = new Date(date),
    yr      = from.getFullYear();
    month   = from.getMonth();
    day     = from.getDate() < 10? '0'+from.getDate():from.getDate();
    converted_date = monthNames[month] + ' ' + day;
    return converted_date;
  }

    $( ".datepicker" ).datepicker({
    //changeYear:true,
    changeMonth: true,
    //yearRange: "-100:+0",
    dateFormat: 'MM dd',
    //maxDate: '0'
    });

  function oddeven_scheme(brgyCode,citymunCode){
    var d = new Date();
    var day = d.getDay();
    var odd = ["43411001", "43411004", "43411005", "43411006", "43411015", "43411013", "43411011"];
    var even = ["43411002", "43411003", "43411007", "43411008", "43411010", "43411012", "43411014"];
    if($.inArray(brgyCode, even) !== -1 || $.inArray(brgyCode, odd) !== -1){
      if ((day % 2 === 0 && $.inArray(brgyCode, even) !== -1) || (day % 2 !== 0 && $.inArray(brgyCode, odd) !== -1)) {
        return true;
      }else{
        return false;
      }
    }else{
      return true;
    }
  }
  function oddeven_color(brgyCode){
    var odd = ["43411001", "43411004", "43411005", "43411006", "43411015", "43411013", "43411011"];
    var even = ["43411002", "43411003", "43411007", "43411008", "43411010", "43411012", "43411014"];
    if($.inArray(brgyCode, even) !== -1){
      return 'bg-warning';
    }else{
      return 'bg-success';
    }
  }
function webcam() {
      Webcam.set({
        width: 300,
        height: 200,
        // dest_width: 630,
        // dest_height: 420,
        image_format: 'jpeg',
        jpeg_quality: 100,
        'constraints':{
        facingMode: "environment"
        }
    });
    Webcam.attach( '#my_camera' );
  }   

  function take_snapshot() {
    Webcam.snap( function(data_uri) {  
      $(".image-tag").val(data_uri);
      document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="75%" height="75%"/>';
      $('#pic_trigger').val('1');
      if($("#med_trigger").val()== "1"){
      $("#submit").removeAttr("disabled");
      }
    });
  }
function dataURItoBlob(dataURI) {
    var binary = atob(dataURI.split(',')[1]);
    var array = [];
    for(var i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
    return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
  }
function get_extension(dataurl){
  var extension = dataurl.substring(dataurl.indexOf('/') + 1, dataurl.indexOf(';base64'));
  if(extension == 'jpeg'){
    extension = 'jpg';
  }
  return extension;
}
$(document).ready(function(){
  
  $('#btnlogin').on('click', function(){
    $(this).addClass("disabled"); 
    login();    
  });
}); 
$(document).keypress(function(event){
var keycode = (event.keyCode ? event.keyCode : event.which);
  if(keycode == '13'){
    $('#btnlogin').addClass("disabled"); 
    login();  
  }
});    
function login()
{
  var username = $('#login_username').val();
  var password = $('#login_password').val();        
  $.ajax({
    type: "POST",
    url: url + "Authentication/user_login",
    data: {
      username: username,
      password: password
    },
    success: function(e){       
      $('#btnlogin').removeClass("disabled");
      if(e != "Completed"){ 
        alert(e);
      } else{
        window.location = url+"Client_profile";
      }
    }       
  });
}
</script>
<!-- <script src="<?php echo base_url(); ?>assets/js/compressor/vue.min.js" crossorigin="anonymous"></script>
<script src="<?php echo base_url(); ?>assets/js/compressor/compressor.js"></script>
<script src="<?php echo base_url(); ?>assets/js/compressor/main.js"></script>
 -->
<script src="<?php echo base_url(); ?>assets/admin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin2/js/sb-admin-2.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/toastr/toastr.min.css">
<script src="<?php echo base_url(); ?>assets/js/toastr/toastr.min.js" type="text/javascript"></script>
</html>
