<style>
  .ui-datepicker-calendar {
        display: none;
    }
    .box-tools{
        width: 900px;
        padding: 0;
    }
    .filters{
        padding: 0;
    }
    .txt-bottom{
        vertical-align:bottom !important;
    }
    .table-hover>tbody>tr.warning:hover>td, .table-hover>tbody>tr.warning:hover>th, .table-hover>tbody>tr:hover>.warning, .table-hover>tbody>tr>td.warning:hover, .table-hover>tbody>tr>th.warning:hover {
      background-color: #FFFF66 !important;
    }
    .table>tbody>tr.warning>td{
      background-color: #FFFF99 !important;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Post Vaccination
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Post Vaccination</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form id="form1" method="post">
                        <div class="col-md-2"> 
                          <label>With Comorbidity</label>
                          <select id="with_comorbidity" name="with_comorbidity" class="form-control select2" >
                              <option value="">ALL</option>
                              <option value="01_Yes">With Comorbidity</option>
                              <option value="02_None">None</option>
                           </select>                        
                         </div>
                        <div class="col-md-2">
                          <label>Brgy:</label>
                          <select id="brgyCode" name="brgyCode[]" class="form-control select2" multiple="multiple">
                            <option value="">ALL</option>
                            <?php foreach($brgy_list as $val){ ?>
                            <!--Initial selected is LAGUNA ProvCode=0434-->
                              <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                            <?php } ?>
                          </select>
                        </div> 
                        <div class="col-md-2"> 
                          <label>Category</label>
                            <select id="category" name="category[]" class="form-control select2" multiple="multiple">
                              <option value="">Select Category</option>
                              <option value="">ALL</option>
                              <?php foreach($category as $key=>$val){ ?>
                                <option value="<?= $val->priority_group ?>"><?= $val->priority_group.'-'.$val->description ?></option>
                              <?php } ?>
                             </select>
                        </div>
                        <div class="col-md-1">
                        <label>Min AGE: </label> 
                          <input type="text" name="min_age" class="form-control" placeholder="Min" />
                        </div>
                        <div class="col-md-1">
                        <label>Max AGE: </label> 
                          <input type="text" name="max_age" class="form-control" placeholder="Max" />
                        </div>

                        <div class="col-md-2">
                          <label>Vaccination From Date: </label> 
                          <input type="date" name="date_start" id="date_start" class="form-control" placeholder="Start Date" />
                        </div>
                        <div class="col-md-2"> 
                          <label>To Date: </label>
                          <input type="date" name="date_end" id="date_end" class="form-control" placeholder="End Date" />
                        </div> 
 
                        <div class="col-md-2"> 
                          <label>With Deferral</label>
                            <select id="deferred" name="deferred" class="form-control select2"> 
                              <option value="">Select</option>
                              <option value="">ALL</option>
                              <option value="1">With Deferral</option>
                              <option value="0">None</option> 
                             </select>
                        </div>  

                        <div class="col-md-2"> 
                          <label>1st Vaccination Site</label>
                            <select id="vac_site1" name="vac_site1" class="form-control select2"> 
                              <option value="">Select</option>
                              <option value="">ALL</option>
                              <option value="0">EMPTY</option>
                              <?php foreach($vac_site as $val){ ?>
                                <option value="<?= $val->vac_site_id; ?>"><?= $val->vac_site; ?></option>
                              <?php } ?>
                            </select>
                        </div>  
                        <div class="col-md-2"> 
                          <label>2nd Vaccination Site</label>
                            <select id="vac_site2" name="vac_site2" class="form-control select2"> 
                              <option value="">Select</option>
                              <option value="">ALL</option>
                              <option value="0">EMPTY</option>
                              <?php foreach($vac_site as $val){ ?>
                                <option value="<?= $val->vac_site_id; ?>"><?= $val->vac_site; ?></option>
                              <?php } ?>
                             </select>
                        </div> 

                        <div class="col-md-2"> 
                          <label>Vaccinator </label>
                            <select id="vaccinator" name="vaccinator" class="form-control select2"> 
                              <option selected disabled>Select value</option>
                              <option value="">ALL</option> 
                              <option value="ANITA E. DORADO, R.N.">ANITA E. DORADO, R.N.</option>
                              <option value="WILMA U. ESTACIO, R.N.">WILMA U. ESTACIO, R.N.</option>
                              <option value="AIZA Q. TOLEDO, R.N">AIZA Q. TOLEDO, R.N</option>
                              <option value="JONAS BENJAMIN T. MADRIGAL, R.N">JONAS BENJAMIN T. MADRIGAL, R.N</option>
                              <option value="IRENE G. TIBOR, RM, RN">IRENE G. TIBOR, RM, RN</option>
                              <option value="IRENEA S. LAT, RN">IRENEA S. LAT, RN</option>
<!--                               <?php foreach($vaccinator_list as $val){ ?> 
                                <option value="<?= $val->fullname ?>"> <?= $val->fullname ?></option>
                              <?php } ?>
 -->                             </select>
                        </div> 
                        <div class="col-md-2"> 
                          <label>Vaccine Used </label>
                            <select id="vac_manufacturer" name="vac_manufacturer" class="form-control select2 required">
                              <option value="" selected>Select Answer</option>
                              <?php foreach($vaccines as $val){ ?>
                                <option value="<?= $val->vaccine_id; ?>"><?= $val->brand; ?></option>
                              <?php } ?>
                             </select>
                        </div> 

                        <div class="col-md-1"> 
                          <label>Dose </label>
                            <select id="dose" name="dose" class="form-control select2 required">
                              <option value="" selected>ALL</option>
                              <option value="1">1st Dose</option>
                              <option value="2">2nd Dose</option>
                             </select>
                        </div> 
                        
                        <div class="col-md-1"> 
                          <label>Acct Status </label>
                            <select id="acct_status" name="acct_status" class="form-control select2 required">
                              <option value="0">Active Accts</option>
                              <option value="1">Disable Accts</option>
                             </select>
                        </div> 
                        
                        <div class="col-md-1"><br>
                          <button class="btn btn-primary" id="generate">Generate</button>
                        </div>
                      </form>
                     </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title date_title">CLIENT COUNT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>Age</td> 
                        <td>date registered</td> 
                        <td>User ID*</td> 
                        <td>UNIQUE_PERSON_ID</td> 
                        <td>Vaccination Site</td>
                        <td>Category*</td>
                        <td>Category_ID*</td>
                        <td>Category_ID_Number*</td>
                        <td>PhilHealth_ID</td>
                        <td>PWD ID</td>
                        <td>Last_Name*</td>
                        <td>First_Name*</td>
                        <td>Middle_Name*</td>
                        <td>Suffix</td>
                        <td>Contact_No.*</td>
                        <td>Address</td>
                        <td>Region</td>
                        <td>Province</td>
                        <td>Municipality</td>
                        <td>Barangay</td>
                        <td>Sex</td>
                        <td>Birthday</td>  
                        <td>Consent</td>
                        <td>Reason for Refusal</td>
                        <td>More than 16 y/o?</td>
                        <td>Has no allergies to PEG or polysorbate?</td>
                        <td>Has no severe allergic reaction after the 1st dose?</td>
                        <td>Has no allergy to food, egg, medicines, and no asthma?</td>
                        <td>* If with allergy or asthma, will the vaccinator able to monitor the patient for 30 minutes</td>
                        <td>Has no history of bleeding disorders or currently taking anti-coagulants?</td>
                        <td>* If with bleeding history, is a gauge 23 - 25 syringe available for injection</td> 
                        <td>Does not manifest any of the following symptoms: Fever/chills, Headache, Cough, Colds, Sore throat,  Myalgia, Fatigue, Weakness, Loss of smell/taste, Diarrhea, Shortness of breath/ difficulty in breathing?</td>
                        <td>* If manifesting any of the mentioned symptom/s, specify all that apply</td>
                        <td>Has no history of exposure to a confirmed or suspected COVID-19 case in the past 2 weeks?</td>
                        <td>Has not been previously treated for COVID-19 in the past 90 days?</td>
                        <td>Has not received any vaccine in the past 2 weeks?</td>
                        <td>Has not received convalescent plasma or monoclonal antibodies for COVID-19 in the past 90 days?</td>
                        <td>Not Pregnant?</td>
                        <td>* if pregnant, 2nd or 3rd Trimester?</td>
                        <td>Does not have any of the following: HIV, Cancer/ Malignancy, Underwent Transplant, Under Steroid Medication/ Treatment, Bed Ridden, terminal illness, less than 6 months prognosis</td>
                        <td>* If with mentioned condition/s, specify.</td>
                        <td>* If with mentioned condition, has presented medical clearance prior to vaccination day?</td>
                        <td>Deferral</td>
                        <td>Date of Vaccination</td>
                        <td>Vaccine Manufacturer Name</td>
                        <td>Batch Number</td>
                        <td>Lot Number</td>
                        <td>BAKUNA_CENTER_CBCR_ID</td>
                        <td>Vaccinator Name</td>
                        <td>Profession of Vaccinator</td>
                        <td>1st Dose</td>
                        <td>2nd Dose </td>   
                        <td>Adverse Event</td>   
                        <td>Adverse Event Condition</td>   
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                    </tfoot>
                  </table>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
$('#loader').hide();
var client;
function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'reports/get_post_vac'; ?>",
  data: $("#form1").serializeArray(),
  beforeSend: function() {
    tr = `<tr id="loader">
                <td colspan="41">
                  <div class="callout callout-info"><p><i class="fa fa-circle-o-notch fa-spin"></i> Loading Data...</p></div>
                </td>
            </tr>`;
    $('#tbody').html(tr);
  },
  complete: function(){
    $('#loader').hide();
  },
  //data:formData,
    success: function(data){ 
        $('.date_title').html(`Date from ${data.date_start} to ${data.date_end}`);
      var tr ='',total_male=0,total_female=0,total_all=0,tfoot,fullname,datetime, category;
      table.clear();
       $.each(data.tracks, function(key, val){
        province = `_0${val.provCode}_${val.provDesc}`;
        employer_prov = `_${val.provCode} - ${val.employer_prov_desc}`;
        citymun = `_${val.citymunCode}_${val.citymunDesc}`;
        brgy = `_${val.brgyCode}_${val.brgyDesc}`;
        address = `${val.address} ${val.brgyDesc} ${val.citymunDesc}`;
        sex = val.sex==0?`01_Female`:`02_Male`;
        bady = convert_datetime(val.birthday);
        //A1
        if(val.priority_group == 'A1' || val.priority_group == 'A1.1' || val.priority_group == 'A1.2'){
          category = 'A1';
        }
        //A2
        if( val.priority_group == 'A2' || (val.vac_age >= 60 && val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2') ){
          category = 'A2';
        }
        //A2
        if( val.priority_group == 'A2' || (val.vac_age == null && val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2') ){
          category = 'A2';
        }
        //A3
        if( 
          (val.vac_age >= 18 && val.vac_age <= 59 && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2') && val.priority_group != 'A2' && val.with_comorbidity == '01_Yes') 
          || 
          (val.vac_age >= 18 && val.vac_age <= 59 && val.priority_group == 'A3' && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2')) 
          || 
          (val.vac_age == null && val.priority_group == 'A3' && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2')) 
          || 
          (val.vac_age == null && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2') && val.priority_group != 'A2' && val.with_comorbidity == '01_Yes') 
          ){
          category = 'A3';
        }
        //A4 and A1.1
        if( 
          (val.vac_age < 60 && val.priority_group == 'A4' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'A4' && val.with_comorbidity == '02_None') 
          ){
          if(val.category == '15'){
            category = 'A1.8';
          }else{
            category = 'A4';
          }
        }
        //A5
        if( 
          (val.vac_age < 60 && val.priority_group == 'A5' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'A5' && val.with_comorbidity == '02_None') 
          ){
          category = 'A5';
        }
        //ROP
        if( 
          (val.vac_age < 60 && val.priority_group == 'B1' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'B1' && val.with_comorbidity == '02_None') 
          ||
          (val.vac_age < 60 && val.priority_group == 'B2' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'B2' && val.with_comorbidity == '02_None') 
          ||
          (val.vac_age < 60 && val.priority_group == 'B3' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'B3' && val.with_comorbidity == '02_None') 
          ||
          (val.vac_age < 60 && val.priority_group == 'B4' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'B4' && val.with_comorbidity == '02_None')     
          ||
          (val.vac_age < 60 && val.priority_group == 'OTHERS' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'OTHERS' && val.with_comorbidity == '02_None') 
          ){
          category = 'ROP';
        }
                var vac_site = '';
        var bakuna_center = '';
        if(val.first_dose == '01_Yes'){
          vac_site = val.vs1;
          bakuna_center = val.first_vac_site;
        }
        if(val.second_dose == '01_Yes'){
          vac_site = val.vs2;
          bakuna_center = val.second_vac_site;
        }
        var adverse_event = (val.adverse_event_condition=='NONE' || val.adverse_event_condition == null)?'N':'Y';
          var unique_person_id = 'LBLAG-'+('00000' + val.vac_id).slice(-8);
         var rowNode = table.row.add([  
                      val.age,
                      val.date_reg,
                      val.userid,
                      unique_person_id,
                      vac_site,
                      category,
                      val.category_id,
                      val.category_id_number,
                      val.philhealth_id,
                      val.pwd_id,
                      val.lname,
                      val.fname,
                      val.mname,
                      val.suffix,
                      val.contact_number,
                      val.address,
                      'CALABARZON',
                      province,
                      citymun,
                      brgy,
                      sex,
                      val.birthday,
                      val.consent,
                      val.refusal_reason,
                      val.age_16,
                      val.peg,
                      val.allergy_1stDose,
                      val.food_allergy,
                      val.monitor_30Minutes,
                      val.bleeding_disorder,
                      val.injection,
                      val.manifest_symptoms,
                      val.symptoms,
                      val.covid19_exposure,
                      val.covid19_90days,
                      val.vac_2weeks,
                      val.covid19_plasma,
                      val.pregnancy_status, 
                      val.trimester,
                      val.prognosis,
                      val.terminal_illness,
                      val.clearance,
                      val.deferral,
                      val.vac_date,
                      val.vac_manufacturer,
                      val.batch_number,
                      val.lot_number,
                      bakuna_center,
                      val.vaccinator_name,
                      val.vaccinator_prof,
                      val.first_dose,
                      val.second_dose, 
                      adverse_event, 
                      val.adverse_event_condition 
                  ]).node();
         // if(){
         //    $( rowNode ).addClass('warning'); 
         //  }
        })    
        table.draw();     
    }
});
}

$('#generate').click(function(e){
  e.preventDefault();
  get_data();
})

$('.daterange').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('Y-MM-D') + ' - ' + picker.endDate.format('Y-MM-D'));
  });

    var table = $('#viewresult').DataTable({
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 5,
    "deferRender": true,
    "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }],
            buttons:[ 
              {
                text: 'Column Visibility',
                extend: 'colvis', 
              },
              {
                extend: 'colvisGroup',
                text: 'Show All',
                show: ':hidden',//show all 
              },
              {
                extend: 'colvisGroup',
                text: 'Hide All',
                hide: ':visible'//hide all
              },
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Vaccination Report',
                text: 'Download Report',
                exportOptions: {
                 columns: [ ':visible' ],
                },
              },
              {
              extend: 'copyHtml5',
              }
          ],
    });

 $("#client_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_clients",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      group_id: ''
    };
   },
processResults: function (data) {
  //add ALL to array
  if(data.length >= 20 ){
  data.unshift({
    fullname : 'ALL', 
    id : ''
  });
}
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.fullname,
                        id: item.id
                    }
                })
            };
        }
    }
 });

 $("#est_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_not_member",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      est_id: '', // search term
    };
   },
  processResults: function (data) {
    //add ALL to array
    if(data.length >= 20 ){
      data.unshift({
        name : 'ALL', 
        id : ''
      });
    }
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id
          }
        })
      };
    }
  }
 });
});
</script>
