<link rel="stylesheet" href="<?=base_url();?>assets/bower_components/select2/dist/css/select2.min.css">
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
#data_table{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
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
  <section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-syringe"></i> A1 Relative registration </h2>   
        <div class="row" id="registration_div">
            <div class="col-md-12 py-12 border"> 
              <div id="reg_details">
                <button class="qrcode-reader btn btn-primary" type="button" id="openreader-multi" 
                  data-qrr-target="#qrcode" style="float: right"><i class="fa fa-qrcode"></i> 
                  Scan LB LAB-ID QR Code
                </button>

                <h4>Please fill with your details <button class="btn btn-success open_instruction float-right" id='open_instruction' data-toggle="modal" data-target="#add_product"><i class="fa fa-exclamation"> </i> &nbsp; See Instruction</button></h4>
                <small class="red"><u>Inputs with RED icons/text are REQUIRED.</u></small>

                <form id="vac_form" method='POST' enctype="multipart/form-data"> 
                  <input type="hidden" name="userid" id="userid" onchange="check_idval()">
                  <input type="hidden" name="qrcode" id="qrcode">
                  <input type="hidden" name="with_comorbidity" id="with_comorbidity"> 
                    <div class="form-row"> 
                      <div class="form-group col-md-12"> 
                        <hr>
                        Registered Client Information
                      </div>

                      <div class="form-group col-md-12">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                           <select id="category" name="category" class="form-control select2 hidden" required="required">
                              <option value="" selected disabled="">Select Category</option>
                              <?php foreach($priority_group as $val){ 
                                $arrayClass = array('30', '31', '32');
                                  if (!in_array($val->pg_id, $arrayClass)){
                              ?>
                                <option value="<?= $val->pg_id; ?>"><?= $val->description; ?></option>
                              <?php }} ?> 
                           </select> 
                          </div>
                      </div>
    

                    <div class="form-row">
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="fname" name="fname" placeholder="First Name" class="form-control" required="required" type="text" onchange="search_userid()" >
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="mname" name="mname" placeholder="Middle Name" class="form-control" type="text" required="required" onchange="search_userid()" >
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user red"></i> </span>
                             </div>
                            <input id="lname" name="lname" placeholder="Last Name" class="form-control" type="text" required="required" onchange="search_userid()" >
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="suffix" name="suffix" class="form-control select2" >
                              <option value="" selected disabled="">Select Suffix</option>
                              <option value="NA">NA</option>
                              <option value="II">II</option>
                              <option value="III">III</option>
                              <option value="IV">IV</option>
                              <option value="V">IV</option>
                              <option value="JR">JR</option>
                              <option value="SR">SR</option>
                             </select>
                          </div>
                        </div> 

                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id="birthday" name="birthday" placeholder="Date of Birth" required="required" class="form-control datepicker" onchange="search_userid()"  required >
                          </div>
                        </div>
                        <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="number" id="birthyear" name="birthyear" placeholder="Birth Year" required="required" class="form-control" required="required" type="text" min="1900" max="2020" onKeyPress="if(this.value.length==4) return false;" onchange="search_userid()" >
                          </div>
                        </div>      
                      </div>

                     <div class="form-group col-md-4">
                        <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="vaccinated_status" name="vaccinated_status" class="form-control select2" required="required" >
                              <option value="" selected disabled="">Already Vaccinated?</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                             </select>
                          </div>
                        </div> 
 
                      <div class="col-md-12">
                          <hr class="">
                      </div>
                    </div>

                    <div class="form-row addr">
                      <div class="form-group col-md-12">
                        Employer details / Place of work
                      </div>

                      <div class="form-group col-md-12">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                           <select id="a1_workplace" name="a1_workplace" class="form-control select2" required="required">
                              <option value="" selected disabled="">Select Place of Work</option>
                              <?php foreach($a1_workplace as $val){ ?>
                                <option value="<?= $val->a1_id; ?>"><?= $val->workplace; ?></option>
                              <?php } ?> 
                           </select>
                          </div>
                      </div>

                      <div class="form-group col-md-8 smallmargin">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <input id="employer_name" name="employer_name" placeholder="Employer Name" class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <input id="employer_no" name="employer_no" placeholder="Employer Number" class="form-control" type="text">
                          </div>
                      </div>

                      <div class="form-group col-md-8 smallmargin">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                             </div>
                            <input id="employer_add" name="employer_add" placeholder="Address" class="form-control" type="text">
                          </div>
                      </div>
                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-address-card"></i> </span>
                             </div>
                            <select id="employer_prov" name="employer_prov" class="form-control select2">
                                <option value="" disabled selected>Province /  HUC / ICC</option>
                              <?php foreach($prov_list as $prov){ ?>
                              <!--Initial selected is LAGUNA ProvCode=0434-->
                                <option value="<?= $prov->provCode ?>"> <?= $prov->provDesc ?></option>
                              <?php } ?>
                            </select>
                          </div>
                      </div>

                      <hr> 
                    </div> 
                    <hr>

                    <div class="form-row">
                        <div class="form-group col-md-6" id='browse'>
                          <div class="custom-file " id="browse_text">
                              <input type="file" name="userfile" onchange="loadImageFile();"  id="userfile"  accept="image/*">
                              <label class="custom-file-label" for="userfile">Choose file (Any proof as A1)</label>
                            </div>
                          <hr>
                          <div class='valid_id_display'>
                          </div>

                          </div>
                        </div>   

                    <div class="form-row">
                        <div class="form-group col-md-6 capture_div">
                          <p class="">Any proof as A1</p>
                          <div id="my_camera"></div>
                          <hr>
                          <input type=button value="Capture Photo" class="btn btn-info" onClick="take_snapshot()">
                          <input type="hidden" name="image" id="image" class="image-tag">
                        </div>

                        <div class="form-group col-md-6">
                        <p class="red">Valid ID (Browse or capture)</p>
                          <div id="results"></div> 
                        </div>
                    </div>
 
                    <div class="form-row">
                       <div class="form-group col-md-12 red">
                        <hr class="noborder">
                        Immediate Relative/s
                      </div>  

                    <div class="container">
                     <div class="row">  
                      <button class="btn btn-primary add_fam_member" id='button_addfam' data-toggle="modal" data-target="#add_product" disabled>
                        <i class="fa fa-plus"> </i>   Add Relative
                      </button> 
                        
                      <div class="col-md-12"> 
                        <div class="modal fade" id="add_fam_member" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog  modal-md">
                              <form id="relative_form" method='POST'> 
                              <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header btn-primary">Add Relative  
                                      <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                      </button>
                                    </div>  
                                      <!-- Modal Body -->
                                      <div class="modal-body">  
                                        <div id="div1">
                                          <table class="table table-bordered"> 
                                            <tr>
                                              <td colspan="2" class="info">Please Fill Up required Information</td>
                                              <button class="search-qrcode btn btn-info pull-right" type="button" id="openreader-multi" data-qrr-target="#qrcode" style="float: right"><i class="fa fa-qrcode"></i> 
                                                Scan LB LAB-ID QR Code
                                              </button>
                                              <input type="hidden" name="reluserid" id="reluserid" class="form-control" required="required" onchange="check_relative()"> 
                                            </tr>   
                                            <tr>
                                              <td>Name of Immediate Relative </td> 
                                              <td><input type="text" name="member_name" id="member_name" class="form-control" required="required" disabled=""></td>
                                            </tr>  
                                            <tr>
                                              <td>Relation </td> 
                                              <td> 
                                                <select name="member_relation" id="member_relation" class="form-control select2" style="width: 100%" required>
                                                  <option value="" selected disabled>Select Relation</option>
                                                    <?php foreach($priority_group_a1 as $val){ 
                                                    ?>
                                                   <option value="<?= $val->pg_id; ?>"><?= $val->description; ?></option>
                                                  <?php } ?>
                                                </select>  
                                              </td>
                                            </tr>
                                            <tr>
                                              <td>Living with Registered A1? </td> 
                                              <td> 
                                                <select name="living" id="living" class="form-control select2" style="width: 100%">
                                                  <option selected disabled value="">Select</option>
                                                  <option value="Yes">Yes</option>
                                                  <option value="No">No</option>
                                                </select>
                                              </td>
                                            </tr> 
                           
                                          </table>
                                        </div><!--end of div1 -->
                                      </div>
                                            <!--SUBMIT BUTTON -->
                                          <div class="modal-footer">
                                            <button id="Close" class="btn btn-danger" data-dismiss="modal"  ><li class='fa fa-remove'></li>Close</button>  
                                            <input type='button' readonly value='Add' id="add_data" class="btn btn-primary pull-right" onclick='AddRow()'>
                                            <!-- <button id="add_data" class="btn btn-primary pull-right">Add  <li class='fa fa-plus'></li></button> -->
                                          </div> 
                                </div>
                              </div><!--end Modal body-->
                            </div><!--end Modal content-->


                            <div class="panel-heading">Family Members</div>
                              <div class="panel-body">

                              <div class="table_wrapper">
                                <table class="table table-hover table-striped table-bordered" id="data_table"> 
                                  <thead>
                                    <tr> 
                                      <th style="display: none;">User id</th>
                                      <th style="display: none;">Relative id</th>
                                      <th style="display: none;">Relation id</th>
                                      <th width="30%">Name/s of Immediate Relative of A1</th> 
                                      <th width="20%">Relation</th>
                                      <th>Living with Registered A1?</th> 
                                      <th>Action</th>  
                                    </tr>
                                  </thead>  
                                    <tbody>
                                     
                                    </tbody> 

                                </table> 
                              </div>
                                 
                            </div>
                          </div>
                        </div>   
                      </div>  
                    </div>
                   
                    
                    <div class="form-row">
                        <div class="form-group">
                            <div class="form-group">
                                <div class="form-check">  
                                  <input class="form-check-input" type="checkbox" value="1" name="agree" id="agree" value="on" required> 
                                  <label class="form-check-label" for="agree">
                                    <small>I hereby authorize the Municipality of Los Baños Laguna, to collect my personal data supplied herein for the purpose of effective control of the COVID-19 transmission. I understand that it is protected by RA 10173, otherwise known as the "Data Privacy Act of 2012", and that I am required by RA 11469, otherwise known as the "Bayanihan to Heal as One Act", to provide truthful information.</small>
                                  </label>
                                </div>
                              </div>
                          </div>
                    </div>
                    <div class="form-row"> 
                      <input type="hidden" readonly id="update_workplace">
                      <button type="submit" class="btn btn-success btn-block" id="save_member">Submit</button>
                      <!-- <button type="submit" class="btn btn-success" id="submit">Submit</button> -->
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
    document.getElementById('results').innerHTML = '<img src="'+data_uri+'" width="250px" height="190px"/>';
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
      canvas.width=image.width;
      canvas.height=image.height;
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
  var uploadImage = document.getElementById("userfile");
  
  //check and retuns the length of uploded file.
  if (uploadImage.files.length === 0) { 
    return; 
  }
  
  //Is Used for validate a valid file.
  var uploadFile = document.getElementById("userfile").files[0];
  if (!filterType.test(uploadFile.type)) {
    alert("Please select a valid image."); 
    return;
  }
  
  fileReader.readAsDataURL(uploadFile);
}
    $( ".datepicker_full" ).datepicker({
    changeYear:true,
    changeMonth: true,
    //yearRange: "-100:+0",
    dateFormat: 'MM dd yy',
    //maxDate: '0'
    });

    function get_details_rel(qrcode){ 
    var userid = $('#userid').val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>A1registration/confirm_details_rel",
      dataType: "JSON",
      data:{qrcode:qrcode},
      async:true,
      success: function(data){ 
        if(data.error == 0){
            $('#relative_form').trigger("reset");
            if(data.details[0].vac_id != null){
              $.each( data.details, function( key, val ) { 
                $('#reluserid').val(val.id);
                $('#member_name').val(val.fname+' '+val.mname+' '+val.lname);
               
                if(userid == val.id){
                  clear_fields();
                  toastr.warning('Not applicable to add yourself as your relative!'); 
                }
                else{ 
                  check_relative();  
                }
              });
            }else{
              $('#alert1_modal').modal('show');              
            }
        }
        else{
            toastr.warning('No record Found!');
        }
      },
    });
  } 

  function get_details(qrcode,birthday){
    var userid = $('#userid').val(); 
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>A1registration/confirm_details",
      dataType: "JSON",
      data:{qrcode:qrcode, birthday:birthday},
      async:true,
      success: function(data){
        if(data.error == 0){
          $('#vac_form').trigger("reset");
          $.each( data.details, function( key, val ) {
            var bday = val.birthday.split('-');
            var birthday = convert_date_M_D(val.birthday);
            $('#vaccine').val(val.vaccine).trigger('change');
            $('#userid').val(val.id);
            $('#fname').val(val.fname);
            $('#lname').val(val.lname);
            $('#mname').val(val.mname);
            $('#address').val(val.address);
            $('#a1_workplace').val(val.a1_workplace).trigger('change');
            if(val.provCode!='434'){
              $('#provCode').val(val.provCode).trigger('change');
            }
            get_mun(val.provCode,val.citymunCode,val.brgyCode);
            $('#birthday').val(birthday);
            $('#birthyear').val(bday[0]);
            $('#contact_number').val(val.contact_number);
            $('#sex').val(val.sex).trigger('change');
            $('#category').val(val.category).trigger('change');
            $('#categ').val(val.category);
            $('#category_id').val(val.category_id).trigger('change');
            $('#category_id_number').val(val.category_id_number);
            $('#philhealth_id').val(val.philhealth_id);
            $('#pwd_id').val(val.pwd_id);
            $('#suffix').val(val.suffix).trigger('change');
            $('#civil_status').val(val.civil_status).trigger('change');
            $('#employment_status').val(val.employment_status).trigger('change');
            $('#profession').val(val.profession).trigger('change');
            $('#employer_name').val(val.employer_name);
            $('#employer_no').val(val.employer_no);
            $('#employer_add').val(val.employer_add);
            $('#employer_prov').val(val.employer_prov).trigger('change');
             

            $("input[name=direct_contact][value='"+val.direct_contact+"']").prop("checked",true);
            $("input[name=pregnancy_status][value='"+val.pregnancy_status+"']").prop("checked",true);

            $("input[name=drug][value='"+val.drug+"']").prop("checked",true);
            $("input[name=food][value='"+val.food+"']").prop("checked",true);
            $("input[name=insect][value='"+val.insect+"']").prop("checked",true);
            $("input[name=latex][value='"+val.latex+"']").prop("checked",true);
            $("input[name=mold][value='"+val.mold+"']").prop("checked",true);
            $("input[name=pet][value='"+val.pet+"']").prop("checked",true);
            $("input[name=pollen][value='"+val.pollen+"']").prop("checked",true);

            $("input[name=hypertension][value='"+val.hypertension+"']").prop("checked",true);
            $("input[name=heart][value='"+val.heart+"']").prop("checked",true);
            $("input[name=kidney][value='"+val.kidney+"']").prop("checked",true);
            $("input[name=diabetes][value='"+val.diabetes+"']").prop("checked",true);
            $("input[name=asthma][value='"+val.asthma+"']").prop("checked",true);
            $("input[name=immuno][value='"+val.immuno+"']").prop("checked",true);
            $("input[name=cancer][value='"+val.cancer+"']").prop("checked",true);
            $("input[name=other][value='"+val.other+"']").prop("checked",true);

            $("input[name=covid19][value='"+val.covid19+"']").prop("checked",true);
            $('#covid19_class').val(val.covid19_class).trigger('change');
            $('#covid19_date').val(val.covid19_date);
            $('#consent').val(val.consent).trigger('change');
            $('#birthday_modal').modal('hide'); 
            if(val.category != 1){
              check_category();
            }
            else{
              toastr.success('Data has been populated!');
              check_idval(); 
              disable_inputs();
            }  
          });
        }
        else{
            toastr.warning('No record Found!');
        } 
      },
    });
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
            if(brgy){
              get_brgy(selected,brgy);
            }
        }
    },
    complete: function (data) {
        $("#citymunCode").html(municipality_list);
        $("#brgyCode").html("<option value='' disabled selected>Select Municipality / City First</option>");
        //get_brgy(selected,brgy);
    }
  });
}

function get_brgy(val,selected){
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
                  if(selected == val.brgyCode){
                    brgy_list +="<option value='"+val.brgyCode+"' selected>"+val.brgyDesc+"</option>";
                  }else{
                    brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
                  }
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
  $("input[name='agree']").attr('checked', 'checked');
  $('#instruction_modal').modal('show');
  $(".add_fam_member").click(function(e) {    
    e.preventDefault();
      $("#modal_title").text('Add Member');
      $('#add_fam_member').modal('show');      
  });
  $(".open_instruction").click(function() {    
      $("#modal_title").text('Instruction');
      $('#instruction_modal').trigger("reset");
      $('#instruction_modal').modal('show');      
  });
 $(".readonly").keydown(function(e){
        e.preventDefault();
    });  

$('#aall1').click(function(){
  $('.allergy1').prop("checked",true);
});
$('#aall2').click(function(){
  $('.allergy2').prop("checked",true);
});

$('#call1').click(function(){
  $('.com1').prop("checked",true);
});
$('#call2').click(function(){
  $('.com2').prop("checked",true);
});

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
  $('.webcam_btn').hide();
  $('.capture_div').hide();
  $('#userfile').prop('required',true);
  $('#browse').show();
  $('#browse_text').addClass("red");
}else{
  $('.capture_div').show();
  $('#userfile').prop('required',false);
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
 

$("#vac_form").submit(function(e){
      e.preventDefault();
        var form_data = new FormData(this);   
        $.ajax({ 
        type: 'POST', 
        url: url+'A1registration/addA1Fam', 
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
          if(data){
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
             $('.valid_id_display').html(``);
             $('#results').html('');


         }else{
            toastr.success('Please Register first to LB - LAB ID!');
          }
          $('#vac_form').trigger("reset");
          $('#qrcode').val('');
          $('#userid').val('');
          $('#vac_form select').val("").trigger('change');
          $('#region').val("CALABARZON").trigger('change');

          $('#provCode').val('434').trigger('change');
          $('#citymunCode').val('43411').trigger('change');

        },
        error: function(xhr, status, error) {
          alert(`Something Went Wrong.`);
        }
      });
  // }else{
  //   alert('Please capture or browse Valid ID for upload');
  // }
  }); 
}); 

$(document).ready(function(){    
  $('#update_workplace').on('click', function(){ 
    var userid = $('#userid').val(); 
    var a1_workplace = $('#a1_workplace').val();  
    var employer_name = $('#employer_name').val();
    var employer_no = $('#employer_no').val();
    var employer_add = $('#employer_add').val();
    var employer_prov = $('#employer_prov').val(); 
    var vaccinated_status = $('#vaccinated_status').val(); 
    var userfile = $('#userfile').val();
    var image = $('#image').val();
      $.ajax({
        url : "<?php echo site_url('A1registration/update_workplace')?>",
        type: "POST",
        contentType: false,       
      cache: false,             
      processData:false, 
        data: new FormData($('#vac_form')[0]),
        dataType: "JSON",
          success: function(data){       
             toastr.success('A1 record updated!');  
          },
      });  
                            
  }); 

});
</script>

<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<?php  $this->load->view('a1family/qr-reader'); ?>
<?php  $this->load->view('a1family/confirmation_modal'); ?>
<?php  $this->load->view('template/loader'); ?>
<script type="text/javascript">
  function clear_fields(){
    $('#reluserid').val('');
    $('#member_name').val('');   
    $('#member_relation').val(''); 
    $('#member_relation').select2().trigger('');
    $('#living').val(''); 
    $('#living').select2().trigger('');
  }

  function deleteRow(r) {
    var i = r.parentNode.parentNode.rowIndex;
    document.getElementById("data_table").deleteRow(i);
  }

  function AddRow() { 
      var userid = $('#userid').val(); 
      var reluserid = $('#reluserid').val();
      var member_name = $('#member_name').val();  
      var member_relation = $('#member_relation').val();
      if(member_relation == 30){
        var convert_relation = 'Parent';
      }
      if(member_relation == 31){
        var convert_relation = 'Husband/Wife';
      }
      if(member_relation == 32){
        var convert_relation = 'Child';
      } 
      var living = $('#living').val();
        
      var delete_button = "<input type='text' readonly value='X' class='btn btn-danger' onclick='deleteRow(this)' style='width: 40px;'>";  

      if(reluserid != ''){
        $('#data_table tbody:last-child').append(
          '<tr>'+
          '<td style="display: none;">'+userid+'</td>'+
          '<td style="display: none;">'+reluserid+'</td>'+ 
          '<td style="display: none;">'+member_relation+'</td>'+  
          '<td>'+member_name+'</td>'+
          '<td>'+convert_relation+'</td>'+
          '<td>'+living+'</td>'+
          '<td>'+delete_button+'</td>'+
          '</tr>'
        ); 
        toastr.success('A1 relative added!'); 
        clear_fields();   
      }                  
  } 
 
  $('#save_member').on('click', function(){  
    var category = $('#category').val();
    var vaccinated_status = $('#vaccinated_status').val();
    var fname = $('#fname').val(); 
    var mname = $('#mname').val(); 
    var lname = $('#lname').val();
    var suffix = $('#suffix').val();
    var a1_workplace = $('#a1_workplace').val();
    var employer_name = $('#employer_name').val(); 
    var employer_add = $('#employer_add').val();  
    var check_a1_workplace = document.forms['vac_form'].a1_workplace.value;  
    var image = $('#image').val();
    var userfile = $('#userfile').val(); 
    var relname = $('#member_name').val(); 
      
    var table_data = [];

        $('#data_table tr').each(function(row,tr){
          if($(tr).find('td:eq(0)').text() != ""){
            var sub = {
              'userid' : $(tr).find('td:eq(0)').text(),
              'reluserid' : $(tr).find('td:eq(1)').text(),
              'member_relation' : $(tr).find('td:eq(2)').text(),
              'member_name' : $(tr).find('td:eq(3)').text(),  
              'convert_relation' : $(tr).find('td:eq(4)').text(),
              'living' : $(tr).find('td:eq(5)').text()
            }; 
            table_data.push(sub);  
          } 
        }); 
        var data = {'data_table' : table_data};
 
        if(fname != '' && mname != '' && lname != '' && suffix != '' && vaccinated_status!='' && vaccinated_status!=null){ 
          if(vaccinated_status == ""){
            toastr.warning('Please select if you are already vaccinated!'); 
            return false; 
          }

          if (category === "") { 
            toastr.warning('Please select Category!'); 
            return false; 
          } 

          if (check_a1_workplace === "") { 
            toastr.warning('Please select place of work!'); 
            return false; 
          } 
           
          if (image === "" && userfile === "") { 
            toastr.warning('Valid id is required!'); 
            return false; 
          }  
            $("#update_workplace").trigger("click");
            
            $.ajax({
              data : data,
              type : 'POST',
              url : "<?php echo base_url('A1registration/addA1Fam');?>",
              crossOrigin: false,
              datType: 'json', 
                success :function(result){   
                  // console.log(result.check);  
                  $('#data_table tr').each(function(row,tr){
                    if($(tr).find('td:eq(0)').text() != ""){
                       
                    } 
                  });  
                  toastr.success('Your registration will be subject to verification.');  
                  $("#data_table").find("tr:gt(0)").remove();  
                  $('#vac_form').trigger("reset");
                  $('#qrcode').val('');
                  $('#userid').val('');
                  $('#vac_form select').val("").trigger('change');
                  $('#button_addfam').prop('disabled', true);
                  $('#save_member').prop('disabled', true);
                  $('.valid_id_display').html(``);
                  $('#results').html('');
                  $('#image').val('');
                  blobObject = null;
                  disable_inputs();

                }
            });  
        } 
        else{
          if(vaccinated_status == null){
            toastr.warning('Please select if you are already vaccinated!'); 
            return false; 
          }

          if (category == null) { 
            toastr.warning('Please select Category!'); 
            return false; 
          } 

          if (check_a1_workplace === "") { 
            toastr.warning('Please select place of work!'); 
            return false; 
          } 
           
          if (image === "" && userfile === "") { 
            toastr.warning('Valid id is required!'); 
            return false; 
          }  
        }  
      }); 


      function search_userid(){
        var category = $("#category").val();
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var mname = $("#mname").val();
        var birthday = $("#birthday").val();
        var birthyear = $("#birthyear").val();
        $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>A1family/search_userid",
        dataType: "JSON",
        data:'fname='+fname+'&lname='+lname+'&mname='+mname+'&birthday='+birthday+'&birthyear='+birthyear,
        success: function(data){
            if(data != false){ 
                document.getElementById("userid").value = data; 
                check_idval();  
            }
          }
        });
      }  

      function check_category(){ 
        check_idval(); 
        var userid = $("#userid").val(); 
        var category = $("#category").val(); 
        if(userid != '' && category != 1){  
          $('#vac_form').trigger("reset");
          $('#category').val('').trigger('change');
          $('#workplace').val('').trigger('change');
          $('#userid').val(''); 
          toastr.warning('Sorry this page is exclusively for Registered A1!'); 
          $('#info_modal').modal('show'); 
        }  
      }

      function check_idval(){
        disable_inputs(); 
        var userid = $("#userid").val(); 
        var category = $("#category").val(); 
        if(userid != '' && category == 1){ 
          $('#button_addfam').prop('disabled', false); 
          $('#save_member').prop('disabled', false);
        }
        else{
          $('#button_addfam').prop('disabled', true); 
          $('#save_member').prop('disabled', true);   
        }
      }

      function disable_inputs(){
        var userid = $("#userid").val(); 
        var category = $("#category").val();
        if(userid != '' && category == 1){ 
          $("#category").attr("disabled","disabled");
          $("#fname").attr("disabled","disabled");
          $("#mname").attr("disabled","disabled");
          $("#lname").attr("disabled","disabled");
          $("#birthday").attr("disabled","disabled");
          $("#birthyear").attr("disabled","disabled");   
        }
        else{
          $('#category').prop('disabled', false);
          $('#fname').prop('disabled', false);
          $('#mname').prop('disabled', false);
          $('#lname').prop('disabled', false);
          $('#birthday').prop('disabled', false);
          $('#birthyear').prop('disabled', false);  
        }
      }
  

      function check_relative(){
        var userid = $("#userid").val();
        var reluserid = $("#reluserid").val(); 
        $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>A1registration/check_relative",
        dataType: "JSON",
        data:'userid='+userid+'&reluserid='+reluserid,
        success: function(data){
            if(data != false){
              toastr.warning('Already Registered as your Immediate Relative!');  
              clear_fields();   
            } 
            else{
              toastr.info('Retrieved Successfully!');
            } 
          }

        });
      }  
</script>
