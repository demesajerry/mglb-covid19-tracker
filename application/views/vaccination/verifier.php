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

</style>
<?php  $this->load->view('template/loader'); ?>
<?php  $this->load->view('vaccination/qr-reader-verifier'); ?>
<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-qrcode"></i> Vaccine Pre-Registration Verifier / Self Assessment</h1>
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
<?php  $this->load->view('vaccination/qr-reader-verifier'); ?>
<script>
  function get_details(qrcode){
  $('#display_info').html('');
  var qrcode = qrcode;
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>vaccination/client_verify",
    dataType: "JSON",
    data:{qrcode:qrcode},
    beforeSend: function() {
      $('#main_div').addClass('disable');
    },
    success: function(data){
      $('#main_div').removeClass('disable');
      $('#loader').hide();
      if(data){
        if(data.date_reg==null){
          var color = 'danger'
          var message = 'Client Not Yet Registered To Pre-Vaccination!';
          var text = 'text-green';
          var icon = 'ban';
          var name = data.lname+', '+data.fname;
          var date_reg = 'NOT YET REGISTERED';
          var texted_status = '';
          var vaccinated_status = '';
          var category = '';
        }else{
          var color = 'success'
          var message = 'Client Already Registered To Pre-Vaccination!';
          var text = 'text-green';
          var icon = 'check';
          var name = data.lname+', '+data.fname;
          var date_reg = convert_date_full(data.date_reg);
          var latest = convert_date_full(data.latest);
          if(data.reply!=null){
            var texted_status = `Already Texted (${convert_date_full(data.date_texted)})`;
            if(data.reply!=''){
              var reply = data.reply;
              if(new Date(data.date_reg) <= new Date(data.latest)){
              var advice = '<h5 style="color:red !important;"><strong>NOTE</strong>: If Not Yet Vaccinated PLEASE FOLLOW UP TO MGLB - ICSO (530-2952 Local 108)</h5>'
              }else{
              var advice = '<h5 style="color:red !important;">Follow up is not yet neccesary. Please wait for your schedule.<br>If category is wrong, You can update this through this <a href="https://www.mglb-covid19-tracker.com/Vaccination">link</a></h5>'
              }
            }else{
              var reply = 'No Reply';
              if(new Date(data.date_reg) <= new Date(data.latest)){
              var advice = '<h5 style="color:red !important;"><strong>NOTE</strong>: If Not Yet Vaccinated PLEASE FOLLOW UP TO MGLB - ICSO (530-2952 Local 108)</h5>'
              }else{
              var advice = '<h5 style="color:red !important;">Follow up is not yet neccesary. Please wait for your schedule.<br>If category is wrong, You can update this through this <a href="https://www.mglb-covid19-tracker.com/Vaccination">link</a></h5>'
              }
            }
          }else{
            var texted_status = 'Not yet Texted';
            var reply = '';
            var advice = '<h5 style="color:red;">Follow up is not yet neccesary. Please wait for your schedule.<br>If category is wrong, You can update this through this <a href="https://www.mglb-covid19-tracker.com/Vaccination">link</a></h5>';
          }

          var vaccinated_status = data.is_vaccinated==1?'Already Vaccinated':'Not Yet Vaccinated';
          var category = data.priority_group; //+ ' - ' + data.description;
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
                                      ${message} <br>
                                      ${advice}
                                    </div>
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1 text-center">
                                     <hr>
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"> </div>
                                  </div>
                                  <div class="col mr-2">
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                      Name: ${name}<hr>
                                    </div>
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                      Date Reg: ${date_reg}<hr>
                                    </div>
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                      Texted Status:  <br>${texted_status}<br>
                                      Reply: ${reply}
                                      <hr>
                                    </div>
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                     ${vaccinated_status}
                                    </div>
                                    <div class="text-md font-weight-bold text-default text-uppercase mb-1">
                                     Category: ${category}
                                     <br>
                                     Latest date of registration already scheduled for this category: <br>${latest}
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          `;    
        }else{
          display_info = '<h6>QR CODE NOT REGISTERED</h6>'
        }      
      $('#display_info').html(display_info);
      $('html, body').animate({ scrollTop: $('#display_info').offset().top }, 'slow');
    },
    complete: function (data) {
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
