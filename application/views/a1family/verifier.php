<style>
  #qrr-container {
    max-width: 800px !Important;
}
@media (min-width: 576px)
  #qrr-container {
    max-width: 500px  !Important;
    margin: 1.75rem auto  !Important;
}
  #openreader-multi{
    padding-right: 10px !important;
  }
  .red { color: red; }
  #barcode_btn{ cursor: pointer; }
  .select2-container .select2-selection--single {
   height: inherit !important;
}
.fade.in {
  opacity: 1;
}
.modal.in .modal-dialog {
  -webkit-transform: translate(0, 0);
  -o-transform: translate(0, 0);
  transform: translate(0, 0);
}
.modal-backdrop.in {
  opacity: 0.5;
}
#valid_id_td_display{
  display: block;
    max-width:230px;
    max-height:250px;
    width: auto;
    height: auto;
}
.right{
  float: right;
}
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
.select2-container .select2-selection--single .select2-selection__rendered {
    display: block;
    width: 100% !important;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #6e707e;
    background-color: #fff;
    background-clip: padding-box;
    border: 0px solid #d1d3e2;
    border-radius: .35rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
.py-5 {
    padding-top: 1rem!important;
}
.smallmargin{
      margin-bottom: 0rem !important;
}
#showpass{
  cursor: pointer;
}
.ui-datepicker-year
{
 display:none !important;   
}
.radio-br{
  width: 300px;
  display:inline-block;
}
.radio-inline{
  width: 150px;
  display:inline-block;
}
.radio-div{
  border-bottom: 1px solid !important;
}
@media only screen and (min-width: 541px) {
  .control-label{
    width: 150px !important;
    font-weight: bold !important;
  }
}

@media only screen and (max-width: 540px) {
  .control-label{
    width: 140px !important;
    display: block;
    font-weight: bold !important;
  }
}
</style>
<!-- <button class="asd">asd</button>
-->
  <section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-search"></i> COVID-19 Vaccination Pre-Registration Verifier</h2>
        <div class="row" id="registration_div">
            <div class="col-md-12 py-12 border">
              <div id="reg_details">
                <div>
                <center>
                  <button class="qrcode-reader btn btn-info btn-block" type="button" id="openreader-multi" 
                    data-qrr-target="#qrcode" ><i class="fa fa-search"></i> 
                    Scan LB LAB-ID<br> QR Code
                  </button>
                <h1>OR</h1>
                </center>
                </div>

                <div>
                <center><h4>Fill with your details</h4></center>
                <small class="red"><u>Inputs with RED icons/text are REQUIRED.</u></small>
                <form id="form_verify" method='POST' enctype="multipart/form-data">
                  <input type="hidden" name="userid" id="userid">
                  <input type="hidden" name="qrcode" id="qrcode">

                  <div class="alert alert-info" style="display: none; width: 900px;">
                      
                  </div>
                  <div class="alert alert-danger" style="display: none; width: 900px;">
                      
                  </div>
                  
                  <div class="form-group col-md-12 red">
                    <hr class="noborder">
                      Client Information
                  </div>

                    <div class="form-row">
                      <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="fname" name="fname" placeholder="First Name" class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="mname" name="mname" placeholder="Middle Name" class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="lname" name="lname" placeholder="Last Name" class="form-control" type="text" required="required">
                          </div>
                      </div>   
                        <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id="birthday" name="birthday" placeholder="Date of Birth" class="form-control datepicker readonly"  required>
                          </div>
                        </div>
                        <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="number" id="birthyear" name="birthyear" placeholder="Birth Year" class="form-control" required="required" type="text" min="1900" max="2020" onKeyPress="if(this.value.length==4) return false;">
                          </div>
                        </div> 
                       </div>

                    <div class="form-row">
                      <button type="submit" class="btn btn-success btn-block" id="submit"><i class="fa fa-search"></i>Verify</button>
                    </div>
                </form>
              </div>
              </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    $( ".datepicker_full" ).datepicker({
    changeYear:true,
    changeMonth: true,
    //yearRange: "-100:+0",
    dateFormat: 'MM dd yy',
    //maxDate: '0'
    });

  function get_details(qrcode){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>vaccination/search_clientqr",
      dataType: "JSON",
      data:{qrcode:qrcode},
      async:true,
        beforeSend: function() {
          $('#notifi-img').attr("src","");
          $('#registration_div').addClass('disable');
          $('#loader').show();
          $('#submit').prop('disabled', true);
        },
        complete: function(){
          $('#registration_div').removeClass('disable');
          $('#loader').hide();
          $('#submit').prop('disabled', false);  
        },
      success: function(data){
        if(data){
          $('#header_text').html('Client Already Registered!');
          $('#notifi-img').attr("src","<?php echo base_url().'assets/images/check.gif' ?>");
          $('#notify_modal').modal('show');
          $('#alert_message').html('The Municipal Health Office will call / text you for your schedule.');
        }else{
          $('#header_text').html('Client Not Yet Registered!');
          $('#notifi-img').attr("src","<?php echo base_url().'assets/images/norecord.png' ?>");
          $('#alert_message').html("If verification via client's info, Please double check your inputs. <br>To register you may click this <a href='<?= base_url()."Vaccination" ?>'>LINK.</a>");
          $('#notify_modal').modal('show');
        }
      },
    });
  }

$(document).ready(function(){
  $(".readonly").keydown(function(e){
    e.preventDefault();
    });  
  $('#loader').hide();
   
  $("#form_verify").submit(function(e){
      e.preventDefault(); 
        $.ajax({ 
        type: 'POST', 
        url: url+'vaccination/clientExist', 
        data:$(this).serialize(), 
        dataType: 'json',
        async:true,
        beforeSend: function() {
          $('#notifi-img').attr("src","");
          $('#registration_div').addClass('disable');
          $('#loader').show();
          $('#submit').prop('disabled', true);
        },
        complete: function(){
          $('#registration_div').removeClass('disable');
          $('#loader').hide();
          $('#submit').prop('disabled', false);  
        },
        success: function (data) { 
        if(data){
          $('#header_text').html('Client Already Registered!');
          $('#notifi-img').attr("src","<?php echo base_url().'assets/images/check.gif' ?>");
          $('#notify_modal').modal('show');
          $('#alert_message').html('The Municipal Health Office will call / text you for your schedule.');
        }else{
          $('#header_text').html('Client Not Yet Registered!');
          $('#notifi-img').attr("src","<?php echo base_url().'assets/images/norecord.png' ?>");
          $('#alert_message').html("If verification via client's info, Please double check your inputs. <br>To register you may click this <a href='<?= base_url()."Vaccination" ?>'>LINK.</a>");
          $('#notify_modal').modal('show');
        }
          $('#form_verify').trigger("reset");
        },
        error: function(xhr, status, error) {
          alert('Something went error.')
        }
      });
    }); 

});
</script>
<script>
  $(function(){
    // overriding path of JS script and audio 
    $.qrCodeReader.jsQRpath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.js";
    $.qrCodeReader.beepPath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep.mp3";
    // bind all elements of a given class
    $(".qrcode-reader").qrCodeReader({
      callback: function(code) {
        get_details(code);
      }
    });
  });
</script>
<?php  $this->load->view('vaccination/confirmation_modal-verifier'); ?>
<?php  $this->load->view('template/loader'); ?>
