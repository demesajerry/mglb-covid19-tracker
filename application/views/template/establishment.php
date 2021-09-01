<!DOCTYPE html>
<html lang="en">
<?php header("Access-Control-Allow-Origin: https://www.mglb-covid19-tracker.com/Authentication/est"); ?>
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
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>COVID19-Tracker - Dashboard</title>
  <link rel="icon" href="<?php echo base_url('assets/images/lblogo.png'); ?>">

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<!--   <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
 -->  <!--CSS FOR DATATABLE-->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/datatable/dataTables.min.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/js/datatable/buttons.css" />
  <!-- jQuery 3 -->
  <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/admin2/css/sb-admin-2.min.css" rel="stylesheet">
  <!--CSS FOR DATATABLE-->
<link href="<?php echo base_url('assets/js/tree/Themes/smoothness/jquery-ui-1.10.4.custom.min.css'); ?>" rel="stylesheet" />
<link href="<?php echo base_url('assets/js/tree/CSS/jHTree.css'); ?>" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url('assets/js/tree/js/jquery-ui-1.10.4.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/tree/js/jQuery.jHTree.js'); ?>"></script>
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
      <?php if($this->session->userdata('est_logged_in')->userid != 670){ ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Establishment/scan">
          <i class="fa fa-qrcode"></i>
          <span>Scan Entry</span></a>
      </li>
      <?php }if(in_array($this->session->userdata('est_logged_in')->report,array(1))){?>
<!--       <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url();?>Est_reports/">
          <i class="fa fa-folder"></i>
          <span>Reports</span></a>
      </li>
 -->      <?php } ?>
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

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter"></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
<!--                 <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                  </div>
                </a>
 -->            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-danger badge-counter"></span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
<!--                 <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="dropdown-list-image mr-3">
                    <img class="rounded-circle" src="https://source.unsplash.com/fn_BT9fwg_E/60x60" alt="">
                    <div class="status-indicator bg-success"></div>
                  </div>
                  <div class="font-weight-bold">
                    <div class="text-truncate">Hi there! I am wondering if you can help me with a problem I've been having.</div>
                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                  </div>
                </a>
 -->                
                 <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $userdata->name ?></span>
                <img class="img-profile rounded-circle" src="<?php echo base_url('assets/images/icon/user.jfif'); ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
<!--                 <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
 -->                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal" id="logout-btn">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
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
  <script type="text/javascript" src="<?php echo base_url('assets/js/datatable/dataTables.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/datatable/buttons.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/datatable/print.js'); ?>"></script>
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
   $('.daterange').daterangepicker({
  autoUpdateInput: false,
  autoApply: true,
  locale: {
      format: 'Y-MM-D'
    }
  });

 $('.daterange').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('Y-MM-DD') + ' To ' + picker.endDate.format('Y-MM-DD'));
  });

  $('#logout-btn').click(function(){
    $('#logoutModal').modal('show');
  });

  $('#confirm_logout').click(function(){
    window.location.href = "<?php echo base_url(); ?>/Authentication/est_logout";
  });

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
    var day = d.getDate();
    var odd = ["43411001", "43411004", "43411005", "43411006", "43411015", "43411013", "43411011"];
    var even = ["43411002", "43411003", "43411007", "43411008", "43411010", "43411012", "43411014"];
    if(citymunCode == 43411){
      console.log((day % 2 === 0) + '-' + ($.inArray(brgyCode, even) !== -1));
      if ((day % 2 === 0 && $.inArray(brgyCode, even) !== -1) || (day % 2 !== 0 && $.inArray(brgyCode, odd) !== -1)) {
          return true;
      }else{
          return false;
      }
    }else{
      if((day % 2 === 0 && citymunCode == 43402) || (day % 2 !== 0 && citymunCode != 43402)){
        return true;
      }else{
        return false
      }
    }
  }
</script>
<script src="<?php echo base_url(); ?>assets/admin2/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
