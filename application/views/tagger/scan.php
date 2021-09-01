<style>
#loader {
    position: fixed;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.disable{
  pointer-events: none;
  opacity: 0.4;
} 

</style>

<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-qrcode"></i> <?php echo $userdata->fullname.' ( '.$userdata->brgyDesc.' ) '; ?> TAGGER</h1>
  </div>
  <!-- Content Row -->
  <div class="row" id="main_div">
    <!--DISPLAY-->
    <div class="col-xl-4 col-lg-4 card">
      <div class="row">
        <div class="col-md-12">         
          <div id="loadingMessage">🎥 Unable to access video stream (please make sure you have a webcam enabled)</div>
          <center><canvas id="canvas" hidden></canvas></center>
          <div id="output" hidden>
            <div id="outputMessage">No QR code detected.</div>
            <div hidden><b>Data:</b> <span id="outputData"></span></div>
            <input type="hidden" class="form-control" name="qrcode" id="qrcode" >
          </div>
        </div>
      </div>
    </div>
    <!--DISPLAY-->
    <div class="col-xl-8 col-lg-8 card" id="display_info">
      <div class="col-xl-12 col-md-12 mb-12">
    </div>
  <!-- Content Row -->
</div>
<!-- /.container-fluid -->
</div>
</div>
</div>
<?php  $this->load->view('template/loader'); ?>
<?php  $this->load->view('establishment/qr-reader'); ?>
<script>
var timeout;  // has to be a global variable
var sound = document.createElement("audio");
var sound_oddeven = document.createElement("audio");
sound.src = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep2.mp3";
sound_oddeven.src = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep3.mp3";
function add_track(qrcode){
  $('#display_info').html('');
  var tagger_id = <?= $userdata->tagger_id; ?>;
  var brgyCode = <?= $userdata->brgyCode; ?>;
  var display_info;
  var qrcode = qrcode;
  var timer = 10000;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Tagger/add_entry",
    //dataType: "JSON",
    data:{qrcode:qrcode, tagger_id:tagger_id, brgyCode: brgyCode},
    beforeSend: function() {
      $('#main_div').addClass('disable');
      $('#loader').show();
    },
    success: function(data){
      $('#main_div').removeClass('disable');
      $('#loader').hide();
      if(data.error_log == 1){
          display_info = `<div class="alert alert-warning">
                            <center>
                              <div style="display:inline-block;vertical-align:top;">
                                <img src="<?php echo base_url('assets/images/icon/warning.png'); ?>" height="150" width="150"/>
                              </div>
                              <div style="display:inline-block;">
                                <div><h2>QR Code not Recognize!</h2></div>
                                <div><h5>Try Re-Scanning Again or</h5></div>
                                <div><h5>Scan a valid QR Code</h5></div>
                              </div>
                            </center>
                          </div>
                          `;
        }else{
          var sex = data.userinfo.sex == 1?'MALE':'FEMALE';
          var birthday = convert_date(data.userinfo.birthday);
          var text='text-white';;
          var color = data.userinfo.template;
          var icon = 'check';
          var message = 'SUCCESSFULLY TAGGED AS APOR.';
          var brgyCode = data.userinfo.brgyCode;
          var citymunCode = data.userinfo.citymunCode;
            if(data.error_log==2){
              // text ='text-white';
              color = 'bg-warning';
              icon = 'ban';
              message = '<strong>CANNOT BE TAGGED!<strong><br>Account is registered in other barangay';
            }
            if(data.error_log==3){
              // text ='text-white';
              color = 'bg-info';
              icon = 'ban';
              message = '<strong>CANNOT BE TAGGED!<strong><br>ALREADY TAGGED AS APOR';
            }
            display_info = `<div class="col-xl-12 col-md-12 mb-12">
                              <div class="card border-left-${color} shadow h-100 py-2 ${color}  ${text}">
                                <div class="card-body">
                                  <div class="row no-gutters align-items-center">
                                    <div class="col mr-3">
                                      <div class="text-lg font-weight-bold text-primary text-uppercase mb-1 text-title text-center">
                                       <i class="fas fa-${icon} fa-8x text-gray-300"></i>
                                      </div>
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1 text-center">
                                        ${message} 
                                      </div>
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1 text-center">
                                       <hr>
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800"> </div>
                                    </div>
                                    <div class="col mr-2">
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                        Name: ${data.userinfo.fname} ${data.userinfo.lname}<hr>
                                      </div>
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                        Age: ${data.userinfo.age}<hr>
                                      </div>
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                        Sex:  ${sex}<hr>
                                      </div>
                                      <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                       Address: <br><p class="">${data.userinfo.brgyDesc}, ${data.userinfo.citymunDesc}</p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            `;          
        }
      $('#display_info').html(display_info);
      $('html, body').animate({ scrollTop: $('#display_info').offset().top }, 'slow');

      clearTimeout(timeout);
    },
    complete: function (data) {
    timeout = setInterval(function () {
        $('#display_info').html('');
      }, timer);
    }
  });
}
$(document).ready(function() {
  $('#loader').hide();
  $('#backtoscan').click(function(){
    $('html, body').animate({ scrollTop: $('#qr-reader').offset().top }, 'slow');
  })
});
</script>
<script src="<?php echo base_url(); ?>assets/admin2/js/sb-admin-2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.min.js"></script>
