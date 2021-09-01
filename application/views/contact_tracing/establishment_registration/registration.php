
<style>
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
</style>
<!-- <button class="asd">asd</button>
 -->  <section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-building"></i> Establishment Registration</h2>
        <div class="row" id="registration_div">
            <div class="col-md-3 bg-primary text-white text-center ">
                <div class=" ">
                    <div class="card-body">
                         <img src="<?php echo base_url('assets/images/registration.webp'); ?>" style="width:30%">
                        <h2 class="py-3">Registration</h2>
                        <p>Municipal Government of<br>Los Baños, Laguna <br>Contact Tracing Site</p>
                        <div class="message" id="message"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 py-5 border">
              <div id="reg_details">
                <h4>Please fill with your details</h4><small class="red"><u>Inputs in RED are REQUIRED.</u></small>
                <form id="registration_form" method='POST' enctype="multipart/form-data">
                    <div class="form-row">
                      <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-building red"></i> </span>
                             </div>
                            <input id="name" name="name" placeholder="Establishment / Business Name / Account Location" class="form-control" type="text" required="required">
                          </div>
                          <hr class="noborder">
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-8">
                        Establishment Address
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-group">
                          <div class="form-check">
                            <input name="uplb" class="form-check-input" type="checkbox" value="1" id="uplb">
                            <label class="form-check-label" for="uplb">
                              <small>UPLB Community</small>
                            </label>
                          </div>
                        </div>
                      </div>                      
                      <div class="form-group col-md-12">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card red"></i> </span>
                             </div>
                            <input id="address" name="address" placeholder="Building / Street / No." class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card red"></i> </span>
                             </div>
                              <select id="provCode" name="provCode" class="form-control select2" required="required">
                                <option value="" disabled selected>Select Province</option>
                              <?php foreach($prov_list as $prov){ ?>
                              <!--Initial selected is LAGUNA ProvCode=0434-->
                                <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card red"></i> </span>
                             </div>
                            <select id="citymunCode" name="citymunCode" class="form-control select2" required="required">
                                <option value="" disabled selected>Select City / Municipality</option>
                              <?php foreach($municipality_list as $mun){ ?>
                              <!--Initial selected is LAGUNA ProvCode=0434-->
                                <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card red"></i> </span>
                             </div>
                              <select id="brgyCode" name="brgyCode" class="form-control select2" required="required">
                                <option value="" disabled selected>Select Brgy</option>
                                <?php foreach($brgy_list as $val){ ?>
                                <!--Initial selected is LAGUNA ProvCode=0434-->
                                  <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                                <?php } ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group col-md-12">
                          <hr class="noborder">
                      </div>
                    </div>
                    <div class="form-row">
                       <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="far fa-id-badge"></i></span>
                            </div>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control" required="required" type="text" required="required">
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-user-shield red"></i> </span>
                            </div>
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control" required="required" type="text" required="required">
                          </div>
                        </div>

                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                            </div>
                            <input id="contact_person" name="contact_person" placeholder="Contact Person" class="form-control" required="required" type="text">
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-phone red"></i> </span>
                            </div>
                            <input id="contact_number" name="contact_number" placeholder="Contact Number" class="form-control" required="required" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;">
                          </div>
                        </div>
                      </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="1" id="agree" required="required">
                                  <label class="form-check-label" for="agree">
                                    <small>I hereby authorize Municipality of Los Baños Laguna, to collect my data indicated herein for the purpose of effective control of the COVID-19 infection. I understand that my personal information is protected by RA 10173, Data Privacy Act of 2012, and that I am required by RA 11469, Bayanihan to Heal as One Act, to provide truthful information.</small>
                                  </label>
                                </div>
                              </div>
                          </div>
                    </div>
                    <div class="form-row">
                      <button type="submit" class="btn btn-success" id="submit">Submit</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
function arrayContains(needle, arrhaystack)
{
    return (arrhaystack.indexOf(needle) > -1);
}
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.valid_id_display').html(`<img id="" src="${e.target.result}" alt="your image" height="75%" width="75%" />`);
    }
  reader.readAsDataURL(input.files[0]);
  }
}
function get_mun(val,selected,brgy){
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>General/municipality_list",
    dataType: "JSON",
    data:'provCode='+val,
    success: function(data){
        if(data != false){
            municipality_list = "<option value='' disabled selected>Select City</option>";
            jQuery.each(data, function(i, val) {
              if(selected == val.citymunCode){
                municipality_list +="<option value='"+val.citymunCode+"' selected>"+val.citymunDesc+"</option>";
              }else{
                municipality_list +="<option value='"+val.citymunCode+"'>"+val.citymunDesc+"</option>";
              }
            });
        }
    },
    complete: function (data) {
        $("#citymunCode").html(municipality_list);
        $("#brgyCode").html("<option value='' disabled selected>Select Municipality / City First</option>");
        //get_brgy(selected,brgy);
    }
  });
}

function get_brgy(val){
  if(val!=''){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>General/brgy_list",
      dataType: "JSON",
      data:{citymunCode:val},
      success: function(data){
          if(data != false){
              brgy_list = "<option value='' disabled selected>Select Brgy</option>";
              jQuery.each(data, function(i, val) {
                  brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
              });
          }
      },
      complete: function (data) {
          $("#brgyCode").html(brgy_list);
      }
    });
  }else{
    brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
    $("#brgyCode").html(brgy_list);
  }
}
$(document).ready(function(){
  $('#loader').hide();
  $("#provCode").change(function() {
    var val = $(this).val();
    get_mun(val);
  });  
  $("#citymunCode").change(function() {
    var val = $(this).val();
    get_brgy(val);
  });  

  $("#registration_form").submit(function(e){
    e.preventDefault();
    $('input[type=text]').val (function () {
      if(this.id!='username'){
        return this.value.toUpperCase();
      }else{
        return this.value;
      }
    })
    $('input[type=text], textarea').val (function () {
      if(this.id!='username'){
        return this.value.toUpperCase();
      }else{
        return this.value;
      }
    })
      var form_data = $(this).serialize();
      $('#employee_id').val("");
      $.ajax({ 
      type: 'POST', 
      url: '<?php echo base_url(); ?>Contact_tracing/add_est', 
      data:new FormData(this), 
      dataType: 'json',
      processData:false,
      contentType:false,
      cache:false,
      async:true,
      beforeSend: function() {
        $('#registration_div').addClass('disable');
        $('#loader').show();
        $('#submit').prop('disabled', true);
      },
      complete: function(){
        $('#registration_div').removeClass('disable');
        $('#loader').hide();
        $('#submit').prop('disabled', false);
        html2canvas(element, {
          background:'#fff',
          onrendered: function (canvas) {
            $("#previewImage").append(canvas);
            getCanvas = canvas;
          }
        });
      },
      success: function (data) { 
        $('#username_qr').html('');
        $('#password_qr').html('');
        $('#message').removeClass('alert alert-warning');
        $('#message').html(``);
        if(arrayContains(1,data.error_log)){
          $('#message').append(`
            <div class="alert alert-warning">
            <div style="display:inline-block;vertical-align:top;">
              <img src="<?php echo base_url('assets/images/icon/warning.png'); ?>" height="45" width="45"/>
            </div>
            <div style="display:inline-block;">
              <div>Client already </div>
              <div>registered</div>
            </div>
            </div>
            <hr>
            `);
          $('html, body').animate({ scrollTop: $('#message').offset().top }, 'slow');
        }
        if(arrayContains(3,data.error_log)){
          $('#message').append(`
            <div class="alert alert-warning">
            <div style="display:inline-block;vertical-align:top;">
              <img src="<?php echo base_url('assets/images/icon/warning.png'); ?>" height="45" width="45"/>
            </div>
            <div style="display:inline-block;">
              <div>Username</div>
              <div>already taken</div>
            </div>
            </div>
            <hr>
            `);
          $('html, body').animate({ scrollTop: $('#message').offset().top }, 'slow');
        }
        if(data.error_log.length === 0){
            $('#username_qr').qrcode(
              {
                render: "canvas",
                width: 200,
                height: 200,
                background: "#ffffff",
                foreground: "#000000",
                text: data.client_info.username,
                src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
                imgWidth: 75,
                imgHeight: 75
              }
              );
            $('#password_qr').qrcode(
              {
                render: "canvas",
                width: 200,
                height: 200,
                background: "#ffffff",
                foreground: "#000000",
                text: data.qr_p,
                src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
                imgWidth: 75,
                imgHeight: 75
              }
              );
          $('.name_display').html(data.client_info.name);
          // $('#username_display').html(data.client_info.username);
          // $('#password_display').html(data.password);
          // $('#number_display').html(data.client_info.contact_number);
          // $('#cp_display').html(data.client_info.contact_person);
          // $('#address_display').html(`${data.client_info.address} ${data.client_info.brgyDesc} ${data.client_info.citymunDesc}`);
          //$('#birthday_display').html(convert_date(data.client_info.birthday));

           $('#client_info_modal').modal('show');

           $('#registration_form')[0].reset();
           $('#citymunCode').val('43411');
           $('#citymunCode').select2().trigger('');
           $('#brgyCode').val('');
           $('#brgyCode').select2().trigger('');
           $('.valid_id_display').html(``);

        }

      }
    });
  });

  $('.asd').click(function(e){
     $('#client_info_modal').modal('show');
  })

});
</script>

<?php  $this->load->view('contact_tracing/establishment_registration/info_modal'); ?>
<?php  $this->load->view('contact_tracing/establishment_registration/qr-reader'); ?>
<?php  $this->load->view('template/loader'); ?>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
