<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/smart_wizard.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/smart_wizard_theme_dots.min.css">
<script src="<?php echo base_url(); ?>assets/js/jquery.smartWizard.min.js"></script>
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
  .no-click {pointer-events: none;}
</style>

<div class="modal" id="client_info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header red"><h4><U>YOUR RESPONSE HAS BEEN RECORDED.</U></h4>
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div>
          <h5>THIS QRCODE IS THE SAME WITH LB-LAB ID AND YOU MAY PRESENT YOUR PERSONAL LB-LAB ID IN THE VACCINATION SITE FOR FASTER TRANSACTION.</h5>
        </div>
      <div id="id_details">
      <center><h3 class="black">LB LAB ID</h3>
        <div class="col-md-12" id="qrcode_dispay"></div></center>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="fname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>First Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="mname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Middle Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="lname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Last Name</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="number_display">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Contact Number</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="username_display">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Username</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="sex_display">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Sex</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">         
              <div class="col-md-12">         
                <div class="col-md-12 black wide" id="address_display">&nbsp;</div>
                <div class="col-md-12 wide " id='add_color'><hr class="noborder"><small>Address</small></div>
              </div>
            </div>
            <hr class="noborder green">
          </div>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
          <a id="download_id" href="#"><button class="btn btn-success"><i class="fa fa-download"></i> Download</button></a>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div>
          <h5 class="alert alert-info">For your clarifications, concerns and updates of record you may reach the Information and Communication Systems Office through:</h5>
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

<div class="modal" id="birthday_modal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" 
             data-dismiss="modal">Confirmation
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div class="form-row">
           <div class="form-group col-md-2">
            <label class="red">Confirm Birthday:</label>
           </div>
           <div class="form-group col-md-5">
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="hidden" id="qrcode_verify" name="qrcode_verify">
              <input type="text" id="cbirthday" name="cbirthday" placeholder="Date of Birth" class="form-control datepicker readonly"  required>
            </div>
          </div>
          <div class="form-group col-md-5">
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="number" id="cbirthyear" name="cbirthyear" placeholder="Birth Year" class="form-control" required="required" type="text" min="1900" max="2021" onKeyPress="if(this.value.length==4) return false;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
          <button id="submitBtn" class="btn btn-primary"><i class="fa fa-check"></i> Confirm</button>
        </div>
      </div>
    </div>
  </div>
</div>
 
      <div class="modal" id="instruction_modal" role="dialog" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header alert-success">
                    <h5 class="modal-title" id="exampleModalLabel">Instructions</h5> 
                    <button type="button" class="close" data-dismiss="modal" href="javascript: reload()">
                      <span aria-hidden="true">&times;</span>
                      <span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="smartwizard">
                        <ul>
                            <li><a href="#reminder">Reminder<br /><small>Read Carefully</small></a></li>
                            <li><a href="#step-1">Step 1<br /><small>Account Info</small></a></li>
                            <li><a href="#step-2">Step 2<br /><small>Employment Info</small></a></li>
                            <li><a href="#step-3">Step 3<br /><small>Upload Valid ID</small></a></li>
                            <li><a href="#step-4">Step 4<br /><small>Add Relative</small></a></li>
                            <li><a href="#step-5">Step 5<br /><small>Read Agreement</small></a></li>
                        </ul>
                        <div>
                            <div id="reminder">
                                <div>
                                  <h5 class="alert alert-warning btn-block text-justify"> 
                                    This registration is exclusive for registered A1 / Workers in Frontline Health Services to register his/her immediate relative who lives in the same residence / Household of A1.<br>
                                  </h5>
                                  <h5 class="alert alert-danger btn-block text-justify"> 
                                    Immediate relative must be registered to vaccination pre-registration first.<br>
                                    On the day of vaccination they will be required to show proof of relation to the registered A1.<br>
                                  </h5>
                                  <h5 class="alert alert-info btn-block text-justify"> 
                                    List of acceptable proof of A1 Category:<br>
                                      1. PRC Card<br>
                                      2. Certificate of Employment from hospital, clinic or other health related frontline establishment or institution<br>
                                      3. Certificate of Training
                                    </br>
                                  </h5>
                                </div>
                              </div>
                            <div id="step-1">
                                <div>
                                  <h2> <i class="fa fa-info red"></i> Step 1</h2><br>
                                   Scanning your registered LB Lab ID QR Code is required. Simply click Scan LB LAB-ID QR Code button in the registration form's upper right corner. <br>
             
                                    As shown in the picture below.<br><br>

                                    <img src="<?php echo base_url('assets/images/instructions/scanqr.jpg'); ?>" height="100%" width="100%"/> <br>
                                    After scanning your registered LB Lab ID, a confirmation screen will appear, prompting you to enter your birthday and birth year to ensure that you are using your own QR Code.
                                </div>
                            </div>
                            <div id="step-2">
                                <div>
                                  <h2> <i class="fa fa-info red"></i> Step 2 </h2><br>
                                  Fill out your employer details, particularly your place of work. You may also update your employer information.<br>
                                  As shown in the picture below.<br><br>
                                  <img src="<?php echo base_url('assets/images/instructions/employer.jpg'); ?>" height="100%" width="100%"/> 
                                </div>
                            </div>
                            <div id="step-3">
                                <div>
                                  <h2> <i class="fa fa-info red"></i> Step 3</h2><br>
                                    Valid id of registered A1 is required. This is for verification if registered A1 is a bonafide A1. <br>
                                    You may browse or capture your valid id.<br>

                                    As shown in the picture below.<br><br>
                                    <img src="<?php echo base_url('assets/images/instructions/validid.jpg'); ?>" height="100%" width="100%"/> <br>  
                                </div>
                            </div>
                            <div id="step-4">
                                <div>
                                  <h2> <i class="fa fa-info red"></i> Step 4 </h2><br>
                                  Click Add Relative to show pop up dialog box registration. Click Scan LB LAB-ID QR Code button to scan LB LAB ID QR Code of your immediate relative. <br>

                                  As shown in the picture below.<br><br>
                                  <img src="<?php echo base_url('assets/images/instructions/addrelativemodal.jpg'); ?>" height="100%" width="100%"/> <br>

                                  After scanning LB LAB ID of immediate relative, fill up the required information. Then click Add. <br>
                                  The name of the registered immediate relative will appear in the table below. You can remove a specific relative by clicking the red X button.<br>

                                  As shown in the picture below.<br><br>
                                  <img src="<?php echo base_url('assets/images/instructions/addrelativetable.jpg'); ?>" height="100%" width="100%"/> 
                                </div>
                            </div>
                            <div id="step-5">
                                <div>
                                  <h2> <i class="fa fa-info red"></i> Step 5 </h2><br>
                                  Make sure that you have read and understood the disclosure statement/agreement. Then click Submit<br>

                                  As shown in the picture below.<br><br>
                                  <img src="<?php echo base_url('assets/images/instructions/checknsubmit.jpg'); ?>" height="100%" width="100%"/> <br>

                                  Your registration will be subject to verification and you will receive confirmation message once the registration is accepted.
                                  Thank you.  
                                </div>
                            </div> 
                        </div>  
                        <button id="close_modal" data-dismiss="modal" class="btn btn-danger pull-left"><i class="fa fa-times"></i> Close</button>
                    </div> 
                </div>
            </div>
        </div>
      </div>  

<!---- MODAL DISABLE-->
<div class="modal fade" id="alert1_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-info">
        <h4>
          Information
        </h4>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </div>
      <!--Modal Body For Update -->
      <div class="modal-body table-responsive">
        <div id="disable_display">
          Please Register your immediate relative to vaccine pre-registration first. To register please click this <a href="https://www.mglb-covid19-tracker.com/Vaccination">link</a>.
        </div>
        <div class="modal-footer" align="right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>  
//variable for html2canvas
var getCanvas; // global variable
var element = $("#id_details"); // global variable
$(document).ready(function(){
  $('#smartwizard').smartWizard({
    selected: 0,
    theme: 'dots',
    autoAdjustHeight:true,
    transitionEffect:'fade',
    showStepURLhash: false, 
  });
  $("#download_id").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#download_id").attr("download", "mglb-contact-tracing-ID.png").attr("href", newData);
  });

  $('#submitBtn').click(function(){
    var birthday = $('#cbirthday').val() + ' ' + $('#cbirthyear').val();
    var qrcode_verify = $('#qrcode_verify').val();
    if(birthday!==' '){
      get_details(qrcode_verify,birthday);
    }else{
      toastr.warning('Please input birthday!');
    }
  })
});
</script>

