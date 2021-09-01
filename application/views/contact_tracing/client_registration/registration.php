<style>
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
</style>
<!-- <button class="asd">asd</button>
--><section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-user"></i> Client Registration</h2>
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
                <h4>Please fill with your details</h4><small class="red"><u>Inputs with RED icons/text are REQUIRED.</u></small>
                <form id="registration_form" method='POST' enctype="multipart/form-data">
                    <div class="form-row">
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="fname" name="fname" placeholder="First Name" class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="mname" name="mname" placeholder="Middle Name" class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="lname" name="lname" placeholder="Last Name" class="form-control" type="text" required="required">
                          </div>
                      </div>
                    </div>
                    <div class="form-row addr">
                      <div class="form-group col-md-12 red">
                        <hr class="noborder">
                        Client Address
                      </div>
                      <div class="form-group col-md-12 smallmargin">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card red"></i> </span>
                             </div>
                            <input id="address" name="address" placeholder="House No. / Street" class="form-control" type="text" required="required">
                          </div>
                      </div>
                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group smallmargin">
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
                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group smallmargin">
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
                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group smallmargin">
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
                      <div class="col-md-12">
                          <hr class="">
                      </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id="birthday" name="birthday" placeholder="Date of Birth" class="form-control datepicker" required="required" readonly="readonly">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="number" id="birthyear" name="birthyear" placeholder="Birth Year" class="form-control" required="required" type="text" min="1900" max="2020" onKeyPress="if(this.value.length==4) return false;">
                          </div>
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-phone red"></i> </span>
                            </div>
                            <input id="contact_number" name="contact_number" placeholder="Contact Number" class="form-control" required="required" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;">
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-venus-mars red"></i> </span>
                            </div>
                            <select name="sex" id="sex" class="form-control" required="required">
                              <option selected disabled value="">Sex</option>
                              <option value="1">Male</option>
                              <option value="0">Female</option>
                            </select>
                          </div>
                        </div>
                       <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="far fa-id-badge"></i></span>
                            </div>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control" required="required" type="text" required="required" minlength="4">
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-user-shield "></i> </span>
                            </div>
                            <input type="password" id="password" name="password" placeholder="Password" class="form-control"  type="text" minlength="6">
                            <div class="input-group-append" id="showpass">
                              <span class="input-group-text"> 
                                <i class="fas fa-eye" id="eye"></i>
                                <small id="showhide">
                                  Show
                                </small>
                              </span>
                            </div>

                              <small>If no password entered. Default password is covid19 and can be changed upon login.</small>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group qrcoderow">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-qrcode"></i> </span>
                             </div>
                            <input id="qrcode" name="qrcode" placeholder="QR Code" class="form-control" type="text" readonly="readonly">
                          </div>
                          <button class="qrcode-reader btn btn-primary" type="button" id="openreader-multi" 
                            data-qrr-target="#qrcode" style="float: left"><i class="fa fa-eye"></i> Scan QR Code</button>
                          <small>Note: Use this to scan QR Code given by the MGLB. If no QR Code receive disregard this step, the system will automatically generate your QR Code.</small>
                          <hr>
                        </div>  
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                             </div>
                            <input id="pow" name="pow" placeholder="Place of Work" class="form-control" type="text">
                          </div>
                        </div>
                      </div>
                    <div class="form-row">
                        <div class="form-group col-md-6" id='browse'>
                          <div class="custom-file " id="browse_text">
                              <input type="file" name="valid_id" onchange="loadImageFile();"  id="valid_id"  accept="video/*;capture=camcorder" required="required">
                              <label class="custom-file-label" for="valid_id">Choose file (Valid ID - Max file size 5MB)</label>
                            </div>
                                                      <hr>
                          <div class='valid_id_display'>
                          </div>

                          </div>
                        </div>
                    <div class="form-row">
                        <div class="form-group col-md-6 capture_div">
                          <p class="">Capture Valid ID</p>
                          <div id="my_camera"></div>
                          <hr>
                          <input type=button value="Capture Photo" class="btn btn-info webcam_btn" onClick="capture_id()">
                        </div>

                        <div class="form-group col-md-6">
                        <p class="red">Valid ID (Browse or capture)</p>
                          <div id="results"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="1" id="agree" required="required">
                                  <label class="form-check-label" for="agree">
                                    <small>I hereby authorize the Municipality of Los Baños Laguna, to collect my personal data supplied herein for the purpose of effective control of the COVID-19 transmission. I understand that it is protected by RA 10173, otherwise known as the "Data Privacy Act of 2012", and that I am required by RA 11469, otherwise known as the "Bayanihan to Heal as One Act", to provide truthful information.</small>
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
var blobObject, extension;
function capture_id() {
  Webcam.snap( function(data_uri) {  
    blobObject = dataURItoBlob(data_uri);
    extension = get_extension(data_uri);
    document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="75%" height="75%"/>';
    $('#pic_trigger').val('1');
    if($("#med_trigger").val()== "1"){
    $("#submit").removeAttr("disabled");
    }
  });
}

function arrayContains(needle, arrhaystack)
{
    return (arrhaystack.indexOf(needle) > -1);
}

var fileReader = new FileReader();
var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;

fileReader.onload = function (event) {
  var image = new Image();
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     var size = 8;
    }else{
     var size = 6;
    }

      image.onload=function(){
      var canvas=document.createElement("canvas");
      var context=canvas.getContext("2d");
      canvas.width=image.width/size;
      canvas.height=image.height/size;
      context.drawImage(image,
          0,
          0,
          image.width,
          image.height,
          0,
          0,
          canvas.width,
          canvas.height
      );
      document.getElementById('results').innerHTML = '<img src="'+canvas.toDataURL()+'" width="75%" height="75%"/>';
      blobObject = dataURItoBlob(canvas.toDataURL()); 
      extension = get_extension(canvas.toDataURL());

      //document.getElementById("upload-Preview").src = canvas.toDataURL();
  }
  image.src=event.target.result;
};

var loadImageFile = function () {
  var uploadImage = document.getElementById("valid_id");
  
  //check and retuns the length of uploded file.
  if (uploadImage.files.length === 0) { 
    return; 
  }
  
  //Is Used for validate a valid file.
  var uploadFile = document.getElementById("valid_id").files[0];
  if (!filterType.test(uploadFile.type)) {
    alert("Please select a valid image."); 
    return;
  }
  
  fileReader.readAsDataURL(uploadFile);
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
  var brgy_list=null;
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
    brgy_list = "<option value='' disabled selected>Select Municipality / City First</option>";
    $("#brgyCode").html(brgy_list);
  }
}
$(document).ready(function(){
  $('#showpass').click(function(){
    if($('#password').attr('type') == 'password' ){
      $('#password').attr("type","text");
      $('#showhide').text('Hide');
      $('#eye').removeClass('fa-eye');
      $('#eye').addClass('fa-eye-slash');
    }else{
      $('#password').attr("type","password");
      $('#showhide').text('Show');
      $('#eye').removeClass('fa-eye-slash');
      $('#eye').addClass('fa-eye');
    }
  })

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $('.webcam_btn').hide();
  $('.capture_div').hide();
  $('#valid_id').prop('required',true);
  $('#browse').show();
  $('#browse_text').addClass("red");
}else{
  $('.capture_div').show();
  $('#valid_id').prop('required',false);
  webcam();
  $('.webcam_btn').show();
  $('#browse_text').removeClass("red");
}
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
      if(blobObject!=null){
      $('input[type=text]').val(function () {
        if($(this).attr("id")!='password' && $(this).attr("id")!='username'){
          return this.value.toUpperCase();
        }else{
          return this.value;
        }
      })
      $('input[type=text], textarea').val (function () {
        if($(this).attr("id")!='password' && $(this).attr("id")!='username'){
          return this.value.toUpperCase();
        }else{
          return this.value;
        }
      })
        var form_data = new FormData();
        form_data.append('fname',$('#fname').val());
        form_data.append('mname',$('#mname').val());
        form_data.append('lname',$('#lname').val());
        form_data.append('address',$('#address').val());
        form_data.append('provCode',$('#provCode').val());
        form_data.append('citymunCode',$('#citymunCode').val());
        form_data.append('brgyCode',$('#brgyCode').val());
        form_data.append('birthday',$('#birthday').val()+', '+$('#birthyear').val());
        form_data.append('contact_number',$('#contact_number').val());
        form_data.append('sex',$('#sex').val());
        form_data.append('username',$('#username').val());
        form_data.append('password',$('#password').val());
        form_data.append('qrcode',$('#qrcode').val());
        form_data.append('pow',$('#pow').val());
        form_data.append("upload_file", blobObject,'client_id.'+extension); 

        $('#employee_id').val("");
        $.ajax({ 
        type: 'POST', 
        url: url+'Contact_tracing/add_client', 
        data:form_data, 
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
          $('#qrcode_dispay').html('');
          if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
           var width = 200;
           var height = 200;
          }else{
           var width = 350;
           var height = 350;
          }
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
          if(arrayContains(2,data.error_log)){
            $('#message').append(`
              <div class="alert alert-warning">
              <div style="display:inline-block;vertical-align:top;">
                <img src="<?php echo base_url('assets/images/icon/warning.png'); ?>" height="45" width="45"/>
              </div>
              <div style="display:inline-block;">
                <div>QRCode already</div>
                <div>registered</div>
              </div>
              </div>
              <hr>
              `);
            $('html, body').animate({ scrollTop: $('#message').offset().top }, 'slow');
          }
          if(arrayContains(4,data.error_log)){
            $('#message').append(`
              <div class="alert alert-warning">
              <div style="display:inline-block;vertical-align:top;">
                <img src="<?php echo base_url('assets/images/icon/warning.png'); ?>" height="45" width="45"/>
              </div>
              <div style="display:inline-block;">
                <div>Upload Valid ID</div>
                <div>Failed!</div>
                ${data.error_image}
              </div>
              </div>
              <hr>
              `);
            $('html, body').animate({ scrollTop: $('#message').offset().top }, 'slow');
          }
          if(data.error_log.length === 0){
          var add_color = oddeven_color(data.client_info.brgyCode);
          var sex = data.client_info.sex == 1?'MALE':'FEMALE';
          var brgy = data.client_info.brgyDesc.toUpperCase();
            $('#qrcode_dispay').qrcode(
              {
                render: "canvas",
                width: width,
                height: height,
                background: "#ffffff",
                foreground: "#000000",
                text: data.client_info.qrcode,
                src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
                imgWidth: 75,
                imgHeight: 75
              }
              );
            $('#add_color').removeClass('bg-success');
            $('#add_color').removeClass('bg-warning');
            $('#add_color').addClass(add_color);
            $('#fname_display').html(data.client_info.fname);
            $('#mname_display').html(data.client_info.mname);
            $('#lname_display').html(data.client_info.lname);
            $('#sex_display').html(sex);
            $('#address_display').html(`${data.client_info.address} ${brgy} ${data.client_info.citymunDesc} ${data.client_info.provDesc}`);
            $('#number_display').html(data.client_info.contact_number);
            $('#username_display').html(data.client_info.username);
             $('#client_info_modal').modal('show');
             $('#registration_form')[0].reset();
             $('#citymunCode').val('43411');
             $('#citymunCode').select2().trigger('');
             $('#brgyCode').val('');
             $('#brgyCode').select2().trigger('');
             $('.valid_id_display').html(``);
             $('#results').html('');
             blobObject = null;
          }
        },
        error: function(xhr, status, error) {
          alert(`Something Went Wrong.`);
        }
      });
  }else{
    alert('Please capture or browse Valid ID for upload');
  }
  });

  $('.asd').click(function(e){
           $('#client_info_modal').modal('show');
  })
});
</script>

<?php  $this->load->view('contact_tracing/client_registration/client_info_modal'); ?>
<?php  $this->load->view('contact_tracing/client_registration/qr-reader'); ?>
<?php  $this->load->view('template/loader'); ?>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<script src="<?php echo base_url(); ?>assets/js/qr-reader/html5-qrcode.min.js"></script>
