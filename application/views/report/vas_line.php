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
        DICT - VAS
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">DICT - VAS</li>
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
                    <h3 class="box-title date_title">DICT REPORT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>CATEGORY</td> 
                        <td>UNIQUE_PERSON_ID</td> 
                        <td>PWD</td>
                        <td>Indigenous Member</td>
                        <td>LAST_NAME</td>
                        <td>FIRST_NAME</td>
                        <td>MIDDLE_NAME</td>
                        <td>SUFFIX</td>
                        <td>CONTACT_NO.*</td>
                        <td>REGION</td>
                        <td>PROVINCE</td>
                        <td>MUN_CITY</td>
                        <td>BARANGAY</td>
                        <td>SEX</td>
                        <td>BIRTHDATE</td>  
                        <td>DEFERRAL</td>
                        <td>REASON_FOR_DEFERRAL</td>
                        <td>VACCINATION_DATE</td>
                        <td>VACCINE_MANUFACTURER_NAME</td>
                        <td>BATCH_NUMBER</td>
                        <td>LOT_NO</td>
                        <td>BAKUNA_CENTER_CBCR_ID</td>
                        <td>VACCINATOR_NAME</td>
                        <td>1ST_DOSE</td>
                        <td>2ND_DOSE</td>
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
      var tr ='',total_male=0,total_female=0,total_all=0,tfoot,fullname,datetime, category,pwd, deferral,bday,vac_date, first_dose, second_dose, ind, contact_number, rod;
      table.clear();
       $.each(data.tracks, function(key, val){
        sex = val.sex==0?`F`:`M`;
        bday = convert_date_report(val.birthday);
        vac_date = convert_date_report(val.vac_date);
        //A1
        if(val.priority_group == 'A1'){
          category = 'A1';
        }
        if(val.priority_group == 'A1.1' || val.priority_group == 'A1.2'){
          category = 'A1.9';
        }
        if(val.priority_group == 'A1.8'){
          category = 'A1.8';
        }
        //A2
        if( val.priority_group == 'A2' || (val.vac_age >= 60 && val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8') ){
          category = 'A2';
        }
        //A2
        if( val.priority_group == 'A2' || (val.vac_age == null && val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8') ){
          category = 'A2';
        }
        //A3
        if( 
          (val.vac_age >= 18 && val.vac_age <= 59 && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8') && val.priority_group != 'A2' && val.with_comorbidity == '01_Yes') 
          || 
          (val.vac_age >= 18 && val.vac_age <= 59 && val.priority_group == 'A3' && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8')) 
          || 
          (val.vac_age == null && val.priority_group == 'A3' && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8')) 
          || 
          (val.vac_age == null && (val.priority_group != 'A1' && val.priority_group != 'A1.1' && val.priority_group != 'A1.2' && val.priority_group != 'A1.8') && val.priority_group != 'A2' && val.with_comorbidity == '01_Yes') 
          ){
          category = 'A3';
        }
        //A4 and A1.1
        if( 
          (val.vac_age < 60 && val.priority_group == 'A4' && val.with_comorbidity == '02_None') 
          || 
          (val.vac_age == null && val.priority_group == 'A4' && val.with_comorbidity == '02_None') 
          ){
            category = 'A4';
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
          first_dose = 'Y';
          second_dose = 'N';
        }

        if(val.second_dose == '01_Yes'){
          vac_site = val.vs2;
          bakuna_center = val.second_vac_site;
          first_dose = 'N';
          second_dose = 'Y';
        }

        if(val.pwd_id == 'YES' || val.pwd_id == 'yes' || val.pwd_id == 'Yes'){
          pwd = 'Y';
        }else{
          pwd = 'N';
        }

        if(val.deferral == 'NO' || val.deferral == ''){
          deferral = 'N';
          rod = 'None';
        }else{
          deferral = 'Y';
          rod = val.deferral;
        }

      if(val.vac_manufacturer == 'Astrazeneca'){
        vac_manufacturer = 'AZ';
      }else{
        vac_manufacturer = val.vac_manufacturer;
      }

      if(val.contact_number.length == 7){
        contact_number = ('049'+contact_number).slice(-11);
      }else if(val.contact_number.length == 10){
        contact_number = contact_number;
      }else{
        contact_number = ('0000000000' + val.contact_number.slice(-10)).slice(-11);
      }

        ind = (val.ind=='')?'No':val.ind;

        var adverse_event = (val.adverse_event_condition=='NONE' || val.adverse_event_condition == null)?'N':'Y';
        var adverse_event_condition = (val.adverse_event_condition=='' || val.adverse_event_condition == null)?'NONE':val.adverse_event_condition;
        var unique_person_id = 'LBLAG-'+('0000000' + val.vac_id).slice(-8);
         var rowNode = table.row.add([  
                      category,
                      unique_person_id,
                      pwd,
                      ind,
                      val.lname,
                      val.fname,
                      val.mname,
                      val.suffix,
                      contact_number,
                      'REGION IV-A ('+val.region+')',
                      val.codeprov,
                      val.codecitymun,
                      val.brgyDesc,
                      sex,
                      bday,
                      deferral,
                      rod,
                      vac_date,
                      vac_manufacturer,
                      val.batch_number,
                      val.lot_number,
                      bakuna_center,
                      val.vaccinator_name,
                      first_dose,
                      second_dose,
                      adverse_event, 
                      adverse_event_condition
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
                // "targets": [ 0 ],
                // "visible": false,
                // "searchable": false
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
                extend: 'pdf',
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
