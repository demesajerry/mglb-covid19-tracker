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
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-qrcode"></i> <?php echo $userdata->name; ?> SCANNER</h1>
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
  var group_id = <?= $userdata->group_id; ?>;
  var est_id = <?= $userdata->userid; ?>;
  var display_info;
  var qrcode = qrcode;
  var timer = 6000;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>Establishment/add_entry",
    //dataType: "JSON",
    data:{qrcode:qrcode,group_id:group_id,est_id:est_id},
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
          var sex ='';
          if(data.userinfo.sex == 1){
            sex = 'MALE';
          }
          if(data.userinfo.sex == 0){
            sex = 'FEMALE';
          }
          var birthday = convert_date(data.userinfo.birthday);
          var text='text-white';
          var color = data.userinfo.template;
          var icon = 'check';
          var message = 'Allowed to Enter Establishment.';
          var brgyCode = data.userinfo.brgyCode;
          var citymunCode = data.userinfo.citymunCode;
          var oddeven_exemption = data.oddeven_exemption;
          if(data.userinfo.status == 1 || data.userinfo.status == 4){
            var scheme = true;//oddeven_scheme(brgyCode,citymunCode);
            if(scheme == false && data.userinfo.group_id == null && data.userinfo.oddeven_exemption == 0 && oddeven_exemption == 0){
              // text ='text-white';
              color = 'bg-info';
              icon = 'ban';
              message = 'Not Allowed  to enter.<br>Odd - Even Scheme ordinance';
              sound_oddeven.play();
            }
            if(data.userinfo.active==0){
              // text ='text-white';
              color = 'bg-danger';
              icon = 'ban';
              message = '<strong>Not Allowed!<strong><br>Account disabled by MGLB. Please call 536-3857 for clarification and reactivation.';
            }
            //to be added if apor status is needed in ECQ
            // if(data.userinfo.apor == 0){
            //   // text ='text-white';
            //   color = 'bg-info';
            //   icon = 'ban';
            //   message = 'Not Allowed  to enter.<br> Not an APOR';
            //   sound_oddeven.play();
            // }
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
          else{
            timer = 8000;
              color =data.userinfo.template;
              text ='text-white';
              icon = 'ban';
              message = 'Not allowed to enter.<br>Quarantine Restriction'
            display_info = `<div class="col-xl-12 col-md-12 mb-12">
                              <div class="card border-left-${color} shadow h-100 py-2 ${color}  ${text}">
                                <div class="card-body">
                                  <div class="row no-gutters align-items-center">
                                    <div class="col mr-3">
                                      <div class="text-lg font-weight-bold text-primary text-uppercase mb-1 text-title text-center">
                                       <i class="fas fa-${icon} fa-8x text-gray-300"></i>
                                      </div>
                                      <div class="text-lg font-weight-bold text-default text-uppercase mb-1 text-center">
                                        ${message} 
                                      </div>
                                      <div class="text-lg font-weight-bold text-default text-uppercase mb-1 text-center">
                                       <hr>
                                      </div>
                                      <div class="h5 mb-0 font-weight-bold text-gray-800"> </div>
                                    </div>
                                    <div class="col mr-2">
                                      <div class="text-lg font-weight-bold text-default text-uppercase mb-1">
                                        Please report to Municipal Health Office<hr>
                                      </div>
                                      <div class="text-lg font-weight-bold text-default text-uppercase mb-1">
                                        Phone number: 536-3857<hr>
                                      </div>
                                      <div class="text-lg font-weight-bold text-default text-uppercase mb-1">
                                        Or call your supervisor.<hr>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            `;  
          sound.play();
            var url = "<?php echo base_url(); ?>Establishment/alert_sms";
          $.ajax({
            type: "POST",
            url: url,
            //dataType: "JSON",
            data:{
                  name:`${data.userinfo.lname}, ${data.userinfo.fname} `,
                  contact_number:data.userinfo.contact_number,
                  brgyDesc:data.userinfo.brgyDesc,
                  status:data.userinfo.status,
                  track_id:data.track_id,
                  }
          })
        }
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
