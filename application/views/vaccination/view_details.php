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
-->
  <section class="testimonial" id="testimonial">
    <div class="container">
      <h2><i class="fa fa-syringe"></i> COVID-19 Vaccine Pre-Registration</h2>
        <div class="row" id="registration_div">
            <div class="col-md-12 py-12 border">
              <div id="reg_details">
                <button class="qrcode-reader btn btn-primary" type="button" id="openreader-multi" 
                  data-qrr-target="#qrcode" style="float: right"><i class="fa fa-qrcode"></i> 
                  Scan LB LAB-ID QR Code
                </button>

                <h4>Please fill with your details</h4>
                <small class="red"><u>Inputs with RED icons/text are REQUIRED.</u></small>
                <input type="hidden" name="search_userid" id="search_userid" value="<?= $userid ?>" >
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
<!--                               <option value="" selected disabled="">Select Category</option>
                              <option value="06_Other">Others</option>
                              <option value="01_Health_Care_Worker">Health Care Worker</option>
                              <option value="02_Senior_Citizen/A">Senior Citizen</option>
                              <option value="03_Indigent/A">Indigent</option>
                              <option value="04_Uniformed_Personnel">Uniformed Personnel</option>
                              <option value="05_Essential_Worker">Essential Worker</option>
 -->                             
                            </select>
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
                        <label class="red" for="radios"><b>Directly interaction with COVID19 patient?</b></label><br>
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

                       <div class="form-group col-md-3 smallmargin">
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

                       <div class="form-group col-md-3 smallmargin">
                        <label>Validated?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <select id="is_validated" name="is_validated" class="form-control select2 required">
                              <option value="" selected disabled>Select Answer</option>
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-3 smallmargin">
                        <label>First Dose Vaccination Site:</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <select id="first_vac_site" name="first_vac_site" class="form-control select2 required" required="required">
                              <option value="">Select Answer</option>
                              <?php foreach($vac_site as $val){ ?>
                              <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
                              <?php } ?>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-3 smallmargin">
                        <label>Second Dose Vaccination Site:</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="second_vac_site" name="second_vac_site" class="form-control select2">
                              <option value="">Select Answer</option>
                              <?php foreach($vac_site as $val){ ?>
                              <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
                              <?php } ?>
                             </select>
                          </div>
                        </div>
                    </div>
                    <?php if($action == 2){ ?>
                      <input type="hidden" name="post_vac" id="post_vac" value="1">
                     <div class="form-row">
                       <div class="form-group col-md-12 smallmargin">
                        <hr>
                        <label class="red">THIS PART IS TO BE FIELD UP BY POST VACCINATION TEAM ONLY.</label>
                       </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Reason For Refusal</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="refusal_reason" name="refusal_reason" class="form-control select2">
                              <option value="">Select Answer</option>
                              <option value="I do not think this vaccine is safe">I do not think this vaccine is safe</option>
                              <option value="I do not think this vaccine is effective">I do not think this vaccine is effective</option>
                              <option value="I do not trust a vaccine that has come from another country">I do not trust a vaccine that has come from another country</option>
                              <option value="I have religious beliefs that do not allow me to be vaccinated">I have religious beliefs that do not allow me to be vaccinated</option>
                              <option value="Others">Others</option>
                              <option value="Not Applicable" selected>Not Applicable</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Age more than 16?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="age_16" name="age_16" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Has no allergies to PEG or polysorbate?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="peg" name="peg" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Has no severe allergic reaction after the 1st dose of the vaccine?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="allergy_1stDose" name="allergy_1stDose" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Has no allergy to food, egg, medicines, and no asthma?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="food_allergy" name="food_allergy" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>If with allergy or asthma, will the vaccinator able to monitor the patient for 30 minutes?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="monitor_30Minutes" name="monitor_30Minutes" class="form-control select2">
                              <option value="" selected>Select Answer</option>
                              <option value="01_Yes">Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Has no history of bleeding disorders or currently taking anti-coagulants?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="bleeding_disorder" name="bleeding_disorder" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label> if with bleeding history, is a gauge 23 - 25 syringe available for injection?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="injection" name="injection" class="form-control select2">
                              <option value="" selected>Select Answer</option>
                              <option value="01_Yes" >Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label> Does not manifest any of the following symptoms: Fever/chills, Headache, Cough, Colds, Sore throat,  Myalgia, Fatigue, Weakness, Loss of smell/taste, Diarrhea, Shortness of breath/ difficulty in breathing</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="manifest_symptoms" name="manifest_symptoms" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label> If manifesting any of the mentioned symptom/s, specify all that apply</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="symptoms" name="symptoms[]" class="form-control select2" multiple="multiple">
                              <option value="Fever/chills">Fever/chills</option>
                              <option value="Headache">Headache</option>
                              <option value="Cough">Cough</option>
                              <option value="Colds">Colds</option>
                              <option value="Sore throat">Sore throat</option>
                              <option value="Myalgia">Myalgia</option>
                              <option value="Fatigue">Fatigue</option>
                              <option value="Weakness">Weakness</option>
                              <option value="Loss of smell/taste">Loss of smell/taste</option>
                              <option value="Diarrhea">Diarrhea</option>
                              <option value="Shortness of breath">Shortness of breath</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Has no history of exposure to a confirmed or suspected COVID-19 case in the past 2 weeks?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="covid19_exposure" name="covid19_exposure" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Has not been previously treated for COVID-19 in the past 90 days?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="covid19_90days" name="covid19_90days" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Has not received any vaccine in the past 2 weeks?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="vac_2weeks" name="vac_2weeks" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Has not received convalescent plasma or monoclonal antibodies for COVID-19 in the past 90 days?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="covid19_plasma" name="covid19_plasma" class="form-control select2">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>if pregnant, 2nd or 3rd Trimester?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="trimester" name="trimester" class="form-control select2 ">
                              <option value="" selected>Select Answer</option>
                              <option value="01_Yes">Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Does not have any of the following: HIV, Cancer/ Malignancy, Underwent Transplant, Under Steroid Medication/ Treatment, Bed Ridden, terminal illness, less than 6 months prognosis</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="prognosis" name="prognosis" class="form-control select2 ">
                              <option value="" >Select Answer</option>
                              <option value="01_Yes" selected>Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                      <div class="form-group col-md-4">
                        <label>If with mentioned condition/s, specify</label>
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="terminal_illness" name="terminal_illness" placeholder="If with mentioned condition/s, specify" class="form-control" type="text" >
                          </div>
                      </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>If with mentioned condition, has presented medical clearance prior to vaccination day?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle"></i> </span>
                             </div>
                            <select id="clearance" name="clearance" class="form-control select2 ">
                              <option value="" selected>Select Answer</option>
                              <option value="01_Yes">Yes</option>
                              <option value="02_no">No</option>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                      <div class="form-group col-md-4">
                        <label>Deferral</label>
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="deferral" name="deferral" placeholder="Deferral" class="form-control" type="text" >
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Date of Vaccination</label>
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-calendar  red"></i> </span>
                             </div>
                            <input id="vac_date" name="vac_date" placeholder="Date of Vaccination" value="<?= date('F d Y') ?>" class="form-control datepicker_full" type="text"  required="required">
                          </div>
                      </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Vaccine Manufacturer Name</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle  red"></i> </span>
                             </div>
                            <select id="vac_manufacturer" name="vac_manufacturer" class="form-control select2 required"  required="required">
                              <option value="" selected>Select Answer</option>
                              <?php foreach($vaccines as $val){ ?>
                                <option value="<?= $val->vaccine_id ?>"><?= $val->brand ?></option>
                              <?php } ?>
                             </select>
                          </div>
                        </div>
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                      <div class="form-group col-md-4">
                        <label>Batch Number</label>
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="batch_number" name="batch_number" placeholder="Batch Number" class="form-control" type="text" required="required" >
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                        <label>Lot Number</label>
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text red"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input id="lot_number" name="lot_number" placeholder="Lot Number" class="form-control" type="text" required="required" >
                          </div>
                      </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Name of Vaccinator</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle  red"></i> </span>
                             </div>
                            <select id="vaccinator_name" name="vaccinator_name" class="form-control select2 required"  required="required">
                              <option value="" selected>Select Answer</option>
                              <?php foreach($vaccinator as $val){ ?>
                                <option value="<?= $val->v_id ?>"><?= $val->vaccinator ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>                        
                        <div class="form-group col-md-12 smallmargin">
                          <hr>
                        </div>

                        <div class="form-group col-md-4 smallmargin radio-div">
                          <label>
                            Profession of Vaccinator
                          </label>
                          <div>
                          <label class="radio-inline" for="vaccinator_prof1">
                            <input type="radio" name="vaccinator_prof" id="vaccinator_prof1" value="NURSE">
                            NURSE
                          </label> 
                          <label class="radio-inline" for="vaccinator_prof2">
                            <input type="radio" name="vaccinator_prof" id="vaccinator_prof2" value="MIDWIFE">
                            MIDWIFE
                          </label>  
                          <label class="radio-inline" for="vaccinator_prof4">
                            <input type="radio" name="vaccinator_prof" id="vaccinator_prof4" value="DOCTOR">
                            DOCTOR
                          </label>  
                          <label class="radio-inline" for="vaccinator_prof3">
                            <input type="radio" name="vaccinator_prof" id="vaccinator_prof3" value="N/A">
                            N/A
                          </label>  
                          </div>                    
                      </div>

                       <div class="form-group col-md-4 smallmargin">
                        <label>Dose Number</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle  red"></i> </span>
                             </div>
                            <select id="dose_no" name="dose_no" class="form-control select2 required"  required="required">
                              <?php echo ($dose == "1")?'<option value="1">1st Dose</option>':'<option value="2">2nd Dose</option>'; ?>
                             </select>
                          </div>
                        </div>
                       <div class="form-group col-md-4 smallmargin">
                        <label>Vaccinated?</label>
                         <div class="form-group input-group smallmargin">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-circle red"></i> </span>
                             </div>
                            <?php if($dose == "1"){ ?>
                              <select id="is_vaccinated" name="is_vaccinated" class="form-control select2"  required="required" >
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                               </select>
                             <?php }else{ ?>
                              <select id="is_vaccinated_second" name="is_vaccinated_second" class="form-control select2"  required="required">
                                <option value="1" selected>Yes</option>
                                <option value="0">No</option>
                               </select>
                             <?php } ?>
                          </div>
                        </div>

                     <div class="form-group col-md-4 smallmargin">
                      <label>Adverse Event Condition</label>
                      <div class="form-group input-group smallmargin">
                          <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fa fa-circle  red"></i> </span>
                           </div>
                          <select id="adverse_event" name="adverse_event" class="form-control select2 required"  required="required">
                            <?php foreach($adverse_event as $val){ ?> 
                              <option value="<?= $val->av_id ?>"><?= $val->description ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group col-md-4">
                        <label>Possible Next Vaccination Date</label>
                        <p id="next_vac_date"></p>
                      </div>

                    </div>

                    <?php } ?>
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
  var url = "<?= base_url(); ?>";
  const dose = "<?= $dose; ?>";
  if(dose == '2'){
    $('#second_vac_site').attr("required", true);
  }
  $( ".datepicker_full" ).datepicker({
  changeYear:true,
  changeMonth: true,
  //yearRange: "-100:+0",
  dateFormat: 'MM dd yy',
  //maxDate: '0'
  });

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
//define qracode
var search_userid = $('#search_userid').val();

  function get_details_id(userid){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Vaccination/get_details_id",
      dataType: "JSON",
      data:{userid:userid, dose:dose},
      async:true,
      success: function(data){
        if(data.error == 0){
          $('#vac_form').trigger("reset");
          $.each( data.details, function( key, val ) {
            var bday = val.birthday.split('-');
            var birthday = convert_date_M_D(val.birthday);
            if(val.symptoms){
            var symptoms = val.symptoms.split(", ");
            }else{
              symptoms = '';
            }
            $('#vaccine').val(val.vaccine).trigger('change');
            $('#userid').val(val.id);
            $('#qrcode').val(val.qrcode);
            $('#fname').val(val.fname);
            $('#lname').val(val.lname);
            $('#mname').val(val.mname);
            $('#address').val(val.address);
            if(val.provCode!='434'){
              $('#provCode').val(val.provCode).trigger('change');
            }
            get_mun(val.provCode,val.citymunCode,val.brgyCode);
            $('#birthday').val(birthday);
            $('#birthyear').val(bday[0]);
            $('#contact_number').val(val.contact_number);
            $('#sex').val(val.sex).trigger('change');
            $('#category').val(val.category).trigger('change');
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
            $('#is_validated').val(val.is_validated).trigger('change');
            $('#first_vac_site').val(val.first_vac_site).trigger('change');
            $('#second_vac_site').val(val.second_vac_site).trigger('change');
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
            if((dose == 1 && val.is_vaccinated!=0) || (dose == 2 && val.is_vaccinated_second!=0)){
              $('#refusal_reason').val(val.refusal_reason).trigger('change');
              $('#age_16').val(val.age_16).trigger('change');
              $('#peg').val(val.peg).trigger('change');
              $('#allergy_1stDose').val(val.allergy_1stDose).trigger('change');
              $('#food_allergy').val(val.food_allergy).trigger('change');
              $('#monitor_30Minutes').val(val.monitor_30Minutes).trigger('change');
              $('#bleeding_disorder').val(val.bleeding_disorder).trigger('change');
              $('#injection').val(val.injection).trigger('change');
              $('#manifest_symptoms').val(val.manifest_symptoms).trigger('change');
              $('#symptoms').val(symptoms).trigger('change');
              $('#covid19_exposure').val(val.covid19_exposure).trigger('change');
              $('#covid19_90days').val(val.covid19_90days).trigger('change');
              $('#vac_2weeks').val(val.vac_2weeks).trigger('change');
              $('#covid19_90days').val(val.covid19_90days).trigger('change');
              $('#covid19_plasma').val(val.covid19_plasma).trigger('change');
              $('#trimester').val(val.trimester).trigger('change');
              $('#prognosis').val(val.prognosis).trigger('change');
              $('#terminal_illness').val(val.terminal_illness);
              $('#clearance').val(val.clearance).trigger('change');
              $('#deferral').val(val.deferral);
              if(val.vac_date!='0000-00-00' && val.vac_date!=null){
                  $('#vac_date').val(convert_date_full(val.vac_date));
              }
              $('#vac_manufacturer').val(val.vac_manufacturer).trigger('change');
              $('#batch_number').val(val.batch_number);
              $('#lot_number').val(val.lot_number).trigger('change');
              // if(val.is_vaccinated=='0'){
              //   $('#is_vaccinated').val('').trigger('change');
              // }else{
              //   $('#is_vaccinated').val(val.is_vaccinated).trigger('change');
              // }
              // if(val.is_vaccinated_second=='0'){
              //   $('#is_vaccinated_second').val('').trigger('change');
              // }else{
              //   $('#is_vaccinated_second').val(val.is_vaccinated_second).trigger('change');
              // }
              $('#vaccinator_name').val(val.vaccinator_name).trigger('change');
              $("input[name=vaccinator_prof][value='"+val.vaccinator_prof+"']").prop("checked",true);
              if(val.first_dose == '01_Yes'){
                $('#dose_no').val('1').trigger('change');
              }
              if(val.second_dose == '01_Yes'){
                $('#dose_no').val('2').trigger('change');
              }

              $('#birthday_modal').modal('hide');
            }
            toastr.success('Data has been populated!');
          });
        }else{
            toastr.warning('No record Found!');
        }
      },
    });
  }

$(document).ready(function(){
  // $('#dose_no').change(function(){
  //   dose_no = $(this).val();
  //   if(dose == '1'){
  //     if(dose_no!=''){
  //       $('#is_vaccinated').val('1').trigger('change');
  //     }
  //     else{
  //       $('#is_vaccinated').val('0').trigger('change');
  //     }
  //   }
  //   if(dose == '2'){
  //     if(dose_no!=''){
  //       $('#is_vaccinated_second').val('1').trigger('change');
  //     }
  //     else{
  //       $('#is_vaccinated_second').val('0').trigger('change');
  //     }
  //   }
  // });


  $('#vac_date').change(function(){
    var vac_date = $(this).val();
    var add_days = 28;
    //plus 28 days after 1st vac day
    var next_vac_date = new Date(new Date(vac_date).getTime()+(add_days*24*60*60*1000));
    //check day of next vac day
    var myDate = new Date();
    myDate.setFullYear(next_vac_date.getFullYear());
    myDate.setMonth(next_vac_date.getMonth());
    myDate.setDate(next_vac_date.getDate());

    if(myDate.getDay() == 0){
      //plus 1 day if next vac day is sunday
      var next_vac_date = new Date(new Date(next_vac_date).getTime()+(1*24*60*60*1000));
    }

    $('#next_vac_date').html(convert_date_full(next_vac_date));
  });
  if(search_userid!==''){
    get_details_id(search_userid);
  }

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
          if(data.message == 1){
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
            toastr.warning(data.message);
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
</script>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<?php  $this->load->view('vaccination/qr-reader'); ?>
<?php  $this->load->view('vaccination/confirmation_modal'); ?>
<?php  $this->load->view('template/loader'); ?>
