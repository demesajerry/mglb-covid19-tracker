<style>
#loader {
    position: fixed;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    display: none;
}
.disable{
  pointer-events: none;
  opacity: 0.4;
} 
#display{
  background: url("<?php echo base_url('assets/images/logo_trans2.png'); ?>");
  min-height: 500px;
  color:black;
  font-size: 20px;
}
</style>
<?php  $this->load->view('template/loader'); ?>
<?php  $this->load->view('vaccination/qr-reader-verifier'); ?>
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><img src="<?php echo base_url('assets/images/mglb.png'); ?>" width='70px' height='70px'/>LOS BAÑOS LAGUNA RESBAKUNA</h1>
  </div>
  <!-- Content Row -->
  <div class="row" id="main_div">
    <!--DISPLAY-->
    <div class="col-xl-12 col-lg-8 card" id="display_info">
      <div class="col-xl-12 col-md-12 mb-12" id="display">
        NAME: <?= $details->fullname ?>
      </div>
  <!-- Content Row -->
    </div>
<!-- /.container-fluid -->
  </div>
</div>
</div>
<script>
$(document).ready(function() {
  $('#loader').hide();
  $('#backtoscan').click(function(){
    $('html, body').animate({ scrollTop: $('#qr-reader').offset().top }, 'slow');
  })
});
</script>
<script src="<?php echo base_url(); ?>assets/admin2/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.min.js"></script>
