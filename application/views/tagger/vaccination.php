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
--><section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-syringe"></i> COVID-19 Vaccine Pre-Registration</h2>
        <div class="row" id="registration_div">
            <div class="col-md-12 py-12 border">
              <div id="reg_details">
                <button class="qrcode-reader btn btn-primary" type="button" id="openreader-multi" 
                  data-qrr-target="#qrcode" style="float: right"><i class="fa fa-qrcode"></i> 
                  Scan QR Code
                </button>

                <h4>Please fill with your details</h4>
                <small class="red"><u>Inputs with RED icons/text are REQUIRED.</u></small>

                <form id="vac_form" method='POST' enctype="multipart/form-data">
                  <input type="hidden" name="userid" id="userid">
                  <input type="hidden" name="qrcode" id="qrcode">
                  <input type="hidden" name="with_comorbidity" id="with_comorbidity">
                    <div class="form-row">
                      <label class="red form-group col-md-4"><b>ARE YOU WILLING  TO BE VACCINATED?</b></label>
                      <div class="form-group col-md-8">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <select id="vaccine" name="vaccine" class="form-control select2" required="required">
                              <option value="" selected disabled="">Select Answer</option>
                              <option value="01_Yes">YES!</option>
                              <option value="02_No">NO</option>
                              <option value="03_undecided">UNDECIDED</option>
                             </select>
                          </div>
                      </div>

                      <div class="form-group col-md-12">
                        <hr>
                      </div>

                      <div class="form-group col-md-4">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                           <select id="category" name="category" class="form-control select2" required="required">
                              <option value="" selected disabled="">Select Category</option>
                              <?php foreach($priority_group as $val){ ?>
                                <option value="<?= $val->pg_id; ?>"><?= $val->priority_group.'-'.$val->description; ?></option>
                              <?php } ?>
<!--                          <option value="" selected disabled="">Select Category</option>
                              <option value="06_Other">Others</option>
                              <option value="01_Health_Care_Worker">Health Care Worker</option>
                              <option value="02_Senior_Citizen/A">Senior Citizen</option>
                              <option value="03_Indigent/A">Indigent</option>
                              <option value="04_Uniformed_Personnel">Uniformed Personnel</option>
                              <option value="05_Essential_Worker">Essential Worker</option>
 -->                             </select>
                          </div>
                      </div>

                      <div class="form-group col-md-4">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <select id="category_id" name="category_id" class="form-control select2" required="required">
                              <option value="" selected disabled="">Select Category ID</option>
                              <option value="04_Other_ID">Other ID</option>
                              <option value="01_PRC_number">PRC Number</option>
                              <option value="02_OSCA_number">OSCA number</option>
                              <option value="03_Facility_ID_number">Facility_ID_number</option>
                             </select>
                          </div>
                      </div>

                      <div class="form-group col-md-4">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <input id="category_id_number" name="category_id_number" placeholder="Category ID Number" class="form-control" type="text" required="required">
                          </div>
                      </div>
                    </div>   

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
                      <div class="form-group col-md-4">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="suffix" name="suffix" class="form-control select2">
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
                       <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="civil_status" name="civil_status" class="form-control select2" required>
                              <option value="" selected disabled="">Select Civil Status</option>
                              <option value="01_Single">Single</option>
                              <option value="02_Married">Married</option>
                              <option value="03_Widow/Widower">Widow/Widower</option>
                              <option value="04_Separated/Annulled">Separated/Annulled</option>
                              <option value="05_Living_with_Partner">Living_with_Partner</option>
                             </select>
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                       <div class="form-group input-group smallmargin ">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="employment_status" name="employment_status" class="form-control select2" required>
                              <option value="" selected disabled="">Select Employment Status</option>
                              <option value="01_Government_Employed">Government Employed</option>
                              <option value="02_Private_Employed">Private Employed</option>
                              <option value="03_Self_employed">Self Employed</option>
                              <option value="04_Private_practitioner">Private practitioner</option>
                              <option value="05_Others">Others</option>
                             </select>
                          </div>
                      </div>
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
                      <div class="form-group col-md-4">
                       <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="profession" name="profession" class="form-control select2" required>
                              <option value="" selected disabled="">Select Profession</option>
                              <option value="19_Others_">Others</option>
                              <option value="01_Dental_Hygienist">Dental Hygienist</option>
                              <option value="02_Dental_Technologist">Dental Technologist</option>
                              <option value="03_Dentist">Dentist</option>
                              <option value="04_Medical_Technologist">Medical Technologist</option>
                              <option value="05_Midwife">Midwife</option>
                              <option value="06_Nurse">Nurse</option>
                              <option value="07_Nutritionist_Dietician">Nutritionist Dietician</option>
                              <option value="08_Occupational_Therapist">Occupational Therapist</option>
                              <option value="09_Optometrist">Optometrist</option>
                              <option value="10_Pharmacist">Pharmacist</option>
                              <option value="11_Physical_Therapist">Physical Therapist</option>
                              <option value="12_Physician">Physician</option>
                              <option value="13_Radiologic_Technologist">Radiologic Technologist</option>
                              <option value="14_Respiratory_Therapist">Respiratory Therapist</option>
                              <option value="15_X_ray_Technologist">X-ray Technologist</option>
                              <option value="16_Barangay_Health_Worker">Barangay Health Worker</option>
                              <option value="17_Maintenance_Staff">Maintenance Staff</option>
                              <option value="18_Administrative_Staff">Administrative Staff</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-3">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id="birthday" name="birthday" placeholder="Date of Birth" class="form-control datepicker readonly"  required>
                          </div>
                        </div>
                        <div class="form-group col-md-3">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="number" id="birthyear" name="birthyear" placeholder="Birth Year" class="form-control" required="required" type="text" min="1900" max="2020" onKeyPress="if(this.value.length==4) return false;">
                          </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-group input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                               </div>
                              <input id="philhealth_id" name="philhealth_id" placeholder="PHILHEALTH ID Number" class="form-control" type="text">
                            </div>
                        </div>

                        <div class="form-group col-md-3">
                            <div class="form-group input-group">
                              <div class="input-group-prepend">
                                  <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                               </div>
                              <input id="pwd_id" name="pwd_id" placeholder="PWD ID" class="form-control" type="text">
                            </div>
                        </div>
                       </div>

                    <div class="form-row addr">
                      <div class="form-group col-md-12 red">
                        <hr class="noborder">
                        Client Address
                      </div>
                      <div class="form-group col-md-8 smallmargin">
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
                            <select id="region" name="region" class="form-control select2" required="required">
                                <option value="CALABARZON">CALABARZON</option>
                            </select>
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

                    <div class="form-row addr">
                      <div class="form-group col-md-12">
                        Employer Details
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
                      <div class="form-group col-md-12 smallmargin">
                        <hr class="noborder">
                      </div>
                    </div>

                    <div class="form-row">
                      <div class="form-group col-md-6 smallmargin">
                        <label class="red" for="radios"><b>Work requires direct interaction to covid19 patient?</b></label><br>
                          <label class="radio-br" for="dc1">
                            <input type="radio" name="direct_contact" id="dc1" value="01_Yes" required>
                            Yes
                          </label> 
                          <label class="radio-br" for="dc2">
                            <input type="radio" name="direct_contact" id="dc2" value="02_No">
                            No
                          </label>
                      </div>
                      <div class="form-group col-md-6 smallmargin">
                       <label class="control-label" for="radios">Pregnancy Status</label><br>
                          <label class="radio-br" for="ps1">
                            <input type="radio" name="pregnancy_status" id="ps1" value="01_Pregnant">
                            Yes
                          </label> 
                          <label class="radio-br" for="ps2">
                            <input type="radio" name="pregnancy_status" id="ps2" value="02_Not_Pregnant">
                            No
                          </label>
                      </div>

                      <div class="form-group col-md-12">
                        <hr>
                      </div>

                      <div class="form-group col-md-6 border">
                        <label class="red control-label">Allery Status</label>
                          <label class="radio-inline" for="aall1">
                            <input type="radio" name="aall" id="aall1" value="01_Yes">
                            Yes All
                          </label> 
                          <label class="radio-inline" for="aall2">
                            <input type="radio" name="aall" id="aall2" value="02_No">
                            No All
                          </label>     

                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Drug Allergy?
                          </label>
                          <label class="radio-inline" for="drug1">
                            <input type="radio" name="drug" id="drug1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="drug2">
                            <input type="radio" name="drug" id="drug2" value="02_No"  class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Food Allergy?
                          </label>
                          <label class="radio-inline" for="food1">
                            <input type="radio" name="food" id="food1" value="01_Yes"  class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="food2">
                            <input type="radio" name="food" id="food2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Insect Allergy?
                          </label>
                          <label class="radio-inline" for="insect1">
                            <input type="radio" name="insect" id="insect1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="insect2">
                            <input type="radio" name="insect" id="insect2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Latex Allergy?
                          </label>
                          <label class="radio-inline" for="latex1">
                            <input type="radio" name="latex" id="latex1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="latex2">
                            <input type="radio" name="latex" id="latex2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Mold Allergy?
                          </label>
                          <label class="radio-inline" for="mold1">
                            <input type="radio" name="mold" id="mold1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="mold2">
                            <input type="radio" name="mold" id="mold2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Pet Allergy?
                          </label>
                          <label class="radio-inline" for="pet1">
                            <input type="radio" name="pet" id="pet1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="pet2">
                            <input type="radio" name="pet" id="pet2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Pollen Allergy?
                          </label>
                          <label class="radio-inline" for="pollen1">
                            <input type="radio" name="pollen" id="pollen1" value="01_Yes" class="allergy1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="pollen2">
                            <input type="radio" name="pollen" id="pollen2" value="02_No" class="allergy2">
                            No
                          </label>                      
                        </div>
                      </div>

                      <div class="form-group col-md-6 border">
                        <label class="control-label red">With Comorbidity</label>
                          <label class="radio-inline" for="call1">
                            <input type="radio" name="call" id="call1" value="01_Yes">
                            Yes All
                          </label> 
                          <label class="radio-inline" for="call2">
                            <input type="radio" name="call" id="call2" value="02_No">
                            No All
                          </label>     

                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Hypertension?
                          </label>
                          <label class="radio-inline" for="hypertension1">
                            <input type="radio" name="hypertension" id="hypertension1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="hypertension2">
                            <input type="radio" name="hypertension" id="hypertension2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Heart Disease?
                          </label>
                          <label class="radio-inline" for="heart1">
                            <input type="radio" name="heart" id="heart1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="heart2">
                            <input type="radio" name="heart" id="heart2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Kidney Disease?
                          </label>
                          <label class="radio-inline" for="kidney1">
                            <input type="radio" name="kidney" id="kidney1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="kidney2">
                            <input type="radio" name="kidney" id="kidney2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Diabetes?
                          </label>
                          <label class="radio-inline" for="diabetes1">
                            <input type="radio" name="diabetes" id="diabetes1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="diabetes2">
                            <input type="radio" name="diabetes" id="diabetes2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Asthma?
                          </label>
                          <label class="radio-inline" for="asthma1">
                            <input type="radio" name="asthma" id="asthma1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="asthma2">
                            <input type="radio" name="asthma" id="asthma2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Immunodeficiency?
                          </label>
                          <label class="radio-inline" for="immuno1">
                            <input type="radio" name="immuno" id="immuno1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="immuno2">
                            <input type="radio" name="immuno" id="immuno2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Cancer?
                          </label>
                          <label class="radio-inline" for="cancer1">
                            <input type="radio" name="cancer" id="cancer1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="cancer2">
                            <input type="radio" name="cancer" id="cancer2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label class="control-label red" for="radios">
                            Others?
                          </label>
                          <label class="radio-inline" for="other1">
                            <input type="radio" name="other" id="other1" value="01_Yes" class="com1" required>
                            Yes
                          </label> 
                          <label class="radio-inline" for="other2">
                            <input type="radio" name="other" id="other2" value="02_No" class="com2">
                            No
                          </label>                      
                        </div>
                      </div>

                      <div class="form-group col-md-4 border">
                        <div class="form-group col-md-12 smallmargin radio-div">
                          <label for="radios">
                            Diagnosed With Covid19?
                          </label>
                          <label class="radio-br" for="covid191">
                            <input type="radio" name="covid19" id="covid191" value="01_Yes" required>
                            Yes
                          </label> 
                          <label class="radio-br" for="covid192">
                            <input type="radio" name="covid19" id="covid192" value="02_No">
                            No
                          </label>                      
                        </div>
                      </div>

                      <div class="form-group col-md-4 smallmargin">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <input id="covid19_date" name="covid19_date" placeholder="Date of Specimen Collected" class="form-control datepicker_full" type="text" >
                          </div>
                      </div>

                        <div class="form-group col-md-4 smallmargin">
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="covid19_class" name="covid19_class" class="form-control select2">
                              <option value="" selected disabled="">Covid19 Classification</option>
                              <option value="01_Asymptomatic">Asymptomatic</option>
                              <option value="02_Mild">Mild</option>
                              <option value="03_Moderate">Moderate</option>
                              <option value="04_Severe">Severe</option>
                              <option value="05_Critical">Critical</option>
                             </select>
                          </div>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Provide Electronic Concent?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="consent" name="consent" class="form-control select2">
                              <option value="03_Unknown">Unknown</option>
                              <option value="01_Yes">Yes</option>
                              <option value="02_No">No</option>
                             </select>
                          </div>
                        </div>
                    </div>

<!--                     <div class="form-row">
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
 -->                    <div class="form-row">
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
  var url = "<?= base_url(); ?>";
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
  $('#valid_id').prop('required',true);
  $('#browse').show();
  $('#browse_text').addClass("red");
}else{
  $('.capture_div').show();
  $('#valid_id').prop('required',false);
  // webcam();
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
      // if(blobObject!=null){
        //var form_data = $('form')[0].serialize();
        // form_data.append('fname',$('#fname').val());
        // form_data.append('mname',$('#mname').val());
        // form_data.append('lname',$('#lname').val());
        // form_data.append('address',$('#address').val());
        // form_data.append('provCode',$('#provCode').val());
        // form_data.append('citymunCode',$('#citymunCode').val());
        // form_data.append('brgyCode',$('#brgyCode').val());
        // form_data.append('birthday',$('#birthday').val()+', '+$('#birthyear').val());
        // form_data.append('contact_number',$('#contact_number').val());
        // form_data.append('sex',$('#sex').val());
        // form_data.append('username',$('#username').val());
        // form_data.append('password',$('#password').val());
        // form_data.append('qrcode',$('#qrcode').val());
        // form_data.append('pow',$('#pow').val());
        // form_data.append("upload_file", blobObject,'client_id.'+extension); 
        var form_data = new FormData(this);
        var with_comorbidity = false;
        $('.com1').each(function () {
          if ($(this).prop('checked')) {
            with_comorbidity = true;
          }
        });
        if(with_comorbidity){
          form_data.append('with_comorbidity','01_Yes');
        }else{
          form_data.append('with_comorbidity','02_None');
        }
        
        $('#employee_id').val("");
        $.ajax({ 
        type: 'POST', 
        url: url+'Vaccination/update', 
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
        },
        success: function (data) { 
          if(data.message == 1){
            toastr.success('Data has been updated!');
          }else{
            toastr.warning(data.message);
          }
          $('#vac_form').trigger("reset");
          $('#vac_form select').val("").trigger('change');
          $('#region').val("CALABARZON").trigger('change');
          $('#provCode').val("434").trigger('change');
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
</script>

<?php  $this->load->view('tagger/qr-reader'); ?>
<?php  $this->load->view('template/loader'); ?>
