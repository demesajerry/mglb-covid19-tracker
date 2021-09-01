<style>
  hr.noborder{
    margin-top: 0 !important;
    margin-bottom: 0 !important;
        padding-right:0px !important;
    padding-left: .25rem !important;

  }
  hr.green{
    border-top: 1px solid green;
  }
  .black{
    color: black;
  }
  .wide{
    padding-right:0px !important;
    padding-left: .25rem !important;
  }
  #cbirthday{z-index:9999 !important}
</style>

<div class="modal" id="info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
        Please read... <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div>
          <h5 class="alert alert-info">This is Covid-19 Vaccination Verifier.
          You may scan your LB LAB-ID QR Code for faster verification. Just Click Scan LB LAB-ID QR Code, <br>
          or <br>You may enter manually your first name, middle name, last name, date of birth and birth year.</h5>
        </div>
        <div>
          For your clarifications and concerns you may reach the Information and Communication Systems Office through:
          <h5>Facebook Page: <a href='https://www.facebook.com/MGLB-Information-and-Communication-Systems-Office-ICSO-106964871173349'><i class="fab fa-facebook-square" aria-hidden="true"></i> MGLB ICSO</a></h5>
          <h5>GMAIL: <u style="color: blue;"><i class="fab fa-google" aria-hidden="true"> </i>mglbicso2020@gmail.com</u></h5>
          <h5>Land Line: <u style="color: blue;">530-2952 Local 108</u></h5>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="notify_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <p id="header_text" class="h5 red"></p>
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
          <center>
            <img data-no-retina="" class="img-responsive img-bordered-primary" id="notifi-img" src="">
          </center>
          <div class="alert alert-primary" id="alert_message" role="alert"></div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
  $('#submitBtn').click(function(){
    var qrcode_verify = $('#qrcode_verify').val();
      get_details(qrcode_verify);
  })
});
</script>

