<style type="text/css">
  .full_name{
    margin: -180px 0 40px 50px;
  }
  html,body
{
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px !important;
    overflow-x: hidden; 
}
  .badge-info{
    background-color: #17a2b8;
  }
  .badge-danger{
    background-color: #007bff;
  }
  .badge-success{
    background-color: #28a745;
  }
  .toolbar{
    position: relative;
    display: inline-block;
    vertical-align: middle;
  }
  .red{
    box-shadow: 0 0 3px #CC0000;
  }
 /* placeholder color*/
.red::-webkit-input-placeholder {
    color: #ff8080
}
.disable{
  pointer-events: none;
  opacity: 0.4;
}
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 1s linear infinite;
  position: fixed;
  top: 50%;
  left: 50%;
  margin-top: -50px;
  margin-left: -100px;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  z-index: 9999 !important;
}
.slim {
    margin-top: 0px; 
    margin-bottom: 0px; 
    border: 0; 
    border-top: 1px solid #000; 
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-syringe"></i> <?= $title_page; ?></h1>
    <ol class="breadcrumb">
      <li class="active">Client Vaccination</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="panel-body">
            <form id="form-filter" class="form-horizontal">
              <div class="col-md-2"> 
                <label>Province</label>
                <select id="provCode" name="provCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select Province</option>
                  <option value="">ALL</option>
                  <?php foreach($prov_list as $prov){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2"> 
                <label>Municipality/City</label>
                <select id="citymunCode" name="citymunCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select City / Municipality</option>
                  <option value="">All</option>
                  <?php foreach($municipality_list as $mun){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2">  
                <label>Brgy</label>
                <select id="brgyCode" name="brgyCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select Brgy</option>
                  <?php foreach($brgy_list as $val){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                  <?php } ?>
                </select> 
              </div> 
              <div class="col-md-1"> 
                <label>Age bracket</label>
                <select name='age_bracket' id='age_bracket' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <option value="0" >18 - 59</option>
                  <option value="1" >60 and up</option>
                </select>  
              </div> 
              <div class="col-md-1"> 
                <label>Comorb?</label>
                <select name='with_comorbidity' id='with_comorbidity' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <option value="01_Yes" >Yes</option>
                  <option value="02_None" >No</option>
                </select>  
              </div> 
              <div class="col-md-2"> 
                <label>With Schedule?</label>
                <select name='sched_status' id='sched_status' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <option value="0" >No</option>
                  <?php if($dose == 1){ ?>
                    <option value="1" >Yes</option>
                  <?php }else{ ?>
                    <option value="2" >Yes</option>
                  <?php } ?>
                </select>  
              </div> 
              <div class="col-md-2"> 
                <label>Vaccine</label>
                <select id="vaccine_used" name="vaccine_used" class="form-control select2 required">
                  <?php if($dose==2){ ?>
                    <option value="" selected>Select Vaccine</option>
                    <?php foreach($vaccines as $val){ ?>
                      <option value="<?= $val->vaccine_id ?>"><?= $val->brand ?></option>
                    <?php } ?>
                  <?php }else{ ?>
                    <option value="" selected>Select Vaccine</option>
                    <option value="Pfizer">Pfizer</option>
                    <option value="Moderna">Moderna</option>
                    <option value="Astrazeneca">Astrazeneca</option>
                    <option value="Sinovac">Sinovac</option>
                    <option value="Gamaleya">Gamaleya</option>
                    <option value="Janssen">Janssen</option>
                  <?php }?>
                 </select>
              </div> 
              <div class="col-md-2"> 
                <label>Vaccine Schedule</label>
                <input type="text" name="vac_date" id="vac_date" class="form-control daterange_full">  
              </div> 
              <div class="col-md-2"> 
                <label>Texted Status</label>
                <select name='text_status' id='text_status' class="form-control select2">
                  <option value="" selected>ALL</option>
                    <option value="0" >No</option>
                    <option value="1" >yes</option>
                </select>  
              </div> 
              <div class="col-md-2"> 
                <label>Reply</label>
                <select name='sched_rep' id='sched_rep' class="form-control select2">
                  <option value="" selected>ALL</option>
                    <option value="0" >No Reply</option>
                    <option value="RESCHED" >With reply - RESCHED</option>
                    <option value="YES" >With reply - YES</option>
                    <option value="NO" >With reply - NO</option>
                </select>  
              </div> 
              <div class="col-md-2"> 
                <label>Time Schedule</label>
                <select name='time_schedule' id='time_schedule' class="form-control select2">
                  <option value="" selected>ALL</option>
                    <option value="8 AM" >8 AM</option>
                    <option value="9 AM" >9 AM</option>
                    <option value="10 AM" >10 AM</option>
                    <option value="11 AM" >11 AM</option>
                    <option value="1 PM" >1 PM</option>
                    <option value="2 PM" >2 PM</option>
                    <option value="3 PM" >3 PM</option>
                    <option value="4 PM" >4 PM</option>
                </select>  
              </div> 
              <div class="col-md-2"> 
                  <label>Category Group</label>
                    <select id="category_group" name="category_group[]" class="form-control select2" multiple="multiple">
                      <option value="">Select Category</option>
                      <option value="">ALL</option>
                      <?php foreach($category_group as $key=>$val){ ?>
                        <option value="<?= $val->priority_group ?>"><?= $val->priority_group ?></option>
                      <?php } ?>
                     </select>
              </div> 
              <div class="col-md-2"> 
                <label>Vac Site</label>
                <select name='vac_site_id' id='vac_site_id' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <?php foreach($vac_site_list as $val){  ?>
                    <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
                  <?php } ?>
                </select>  
              </div> 
              <div class="col-md-2">
                <label>Category</label>
                  <select id="category" name="category" class="form-control select2">
                    <option value="">Select Category</option>
                    <option value="">ALL</option>
                    <?php foreach($category as $key=>$val){ ?>
                      <option value="<?= $val->pg_id ?>"><?= $val->description ?></option>
                    <?php } ?>
                   </select>
              </div> 
              <div class="col-md-2">
              <?php if($dose == '2'){ ?> 
                <label>First Dose Date</label>
                <input type="text" name="fvd" id="fvd" class="form-control date">  
              <?php } ?>
              </div> 
              <div class="col-md-2">
              <?php if($dose == '2'){ ?> 
                <label>First Vac Site</label>
                <select name='first_vac_site_id' id='first_vac_site_id' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <?php foreach($vac_site_list as $val){  ?>
                    <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
                  <?php } ?>
                </select>  
              <?php } ?>
              </div> 
              <div class="col-md-4"> 
              </div>
              <div class="col-md-1"> 
                <br>
                <button type="button" id="btn-reset" class="btn btn-warning"><i class='fa fa-undo'></i> &nbsp; Reset</button>
              </div>
              <div class="col-md-1"> <br> 
                <button type="button" id="btn-filter" class="btn btn-primary"><i class='fa fa-filter'></i> &nbsp; Filter</button>
              </div> 
            </form>   
          </div> 
        </div>
        <!--START TABLE-->
        <div class="box">
          <div class="alert alert-danger" style="display: none; width: 900px;">
          </div>
          <div class="box-body table-responsive">
            <table id="table" class="table table-striped table-bordered">
              <thead>
                  <tr>
                    <th width="3%">Userid</th>
                    <th width="12%">Full Name</th>
                    <th width="5%">Category</th>
                    <th width="5%">Age</th>
                    <th width="5%">Barangay</th>
                    <th width="5%">with Comorb</th>
                    <th width="5%">Contact</th>
                    <th width="5%"><?= $fifth_col ?></th>
                    <th width="5%">Schedule</th>
                    <th width="5%">Time</th>
                    <th width="5%">Text Status</th>
                    <th width="5%">Reply</th>
                    <th width="5%">Action</th>
                  </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
            <div class="loader"></div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  </div>
<script type="text/javascript"> 
  var save_method; //for save method string
  var table, bulk_tbl, bulk_schedTbl, vac_manufacturer_bulk, tbl_reminder;
  const dose = "<?= $dose; ?>";
  const scheduler_access = "<?= $scheduler_access; ?>";
  const dose_text = "<?= $dose_text; ?>";
  const year = new Date().getFullYear();
  let selected_rowsID = [];
  let selected_rowsName = [];

  function sendSms_dost(){
    e.preventDefault();
    var name = $('#name-sms').val();
    var contact_number = $('#contact_number-sms').val();
    var vac_date = $('#vac_date-sms').val();
    var vac_manufacturer = $('#vac_manufacturer-sms').val();
    var vac_site = $('#vac_site-sms').val();
    var userid =  $('#userid-sms').val();

    $.ajax({
      url : "<?= base_url();?>DostApi/send_new",
      type: "POST",
      data: {contact_number:contact_number, name:name, userid:userid, vac_date: vac_date, vac_manufacturer:vac_manufacturer, vac_site:vac_site, dose:dose},
      dataType: "JSON",
      beforeSend: function() {
        $('.content-wrapper').addClass('disable');
        $('.btn-close').prop('disabled', true);
        $('.loader').show();
      },
      complete: function(){
        $('.content-wrapper').removeClass('disable');
        $('.btn-close').prop('disabled', false);
        $('.loader').hide();
      },
      success: function(data)
      {
        if(data=='1'){
          $('#confirm_modal').modal('hide');
          toastr.info('Message sent to gsm modem!');
          table.ajax.reload(null, false);
        }else{
          toastr.warning('Message not sent!');
        }
        console.log(data);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
      }
    });
  }

  function sendSms_dost_bulk(){
    var schedule = $('#schedule').val();
    var status = $('#status').val();
    var vac_site = $('#vac_site_bulk').val();
    if(schedule!=''){
      $.ajax({
        url : "<?= base_url();?>Vac_list/get_scheduled_list",
        type: "POST",
        data: {schedule:schedule, dose:dose, status:status, vac_site:vac_site},
        dataType: "JSON",
        beforeSend: function() {
          $('.content-wrapper').addClass('disable');
          $('.modal-content').addClass('disable');
          $('.btn-close').prop('disabled', true);
          $('.loader').show();
        },
        complete: function(){
          $('.content-wrapper').removeClass('disable');
          $('.modal-content').removeClass('disable');
          $('.btn-close').prop('disabled', false);
          $('.loader').hide();
          table.ajax.reload(null, false);
        },
        success: function(data)
        {
          $.each(data, function( key, val ) {
            $.ajax({
              url : "<?= base_url();?>DostApi/send_new",
              type: "POST",
              cache: false,  
              async: false,
              data: {contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, userid:val.userid, vac_date: val.vac_date, vac_manufacturer:val.vaccine, vac_site:val.vac_site, dose:dose},
              dataType: "JSON",
              complete: function(){
              $('#bulkMsg_modal').modal('hide');
              },
              success: function(data)
              {
                if(data=='1'){
                  $('#confirm_modal').modal('hide');
                  toastr.info(`Message sent to ${val.lname}, ${val.fname}!`);
                }else{
                  toastr.warning('Message not sent!');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  toastr.warning('Message not sent!');
              }
            });
          });
        }
      });
    }else{
          toastr.info('Add Schedule First!');
    }
  }

  function sendReminder_dost(){
    var reminder_date = $('#vac_date').val();
    var category_group = $('#category_group').val();
    $.ajax({
      url : "<?= base_url();?>DostApi/reminder_data",
      dataType: "JSON",
      data:{reminder_date:reminder_date, dose:dose, category_group:category_group},
      type: "POST",
      beforeSend: function() {
        $('.content-wrapper').addClass('disable');
        $('.btn-close').prop('disabled', true);
          $('.modal-content').addClass('disable');
        $('.loader').show();
      },
      complete: function(){
        $('.content-wrapper').removeClass('disable');
        $('.btn-close').prop('disabled', false);
        $('.modal-content').removeClass('disable');
        $('.loader').hide();
        $('#reminder_modal').modal('hide');
      },
      success: function(data)
      {
        if(data){
          $.each(data, function( key, val ) {
            $.ajax({
              url : "<?= base_url();?>DostApi/send_reminder",
              type: "POST",
              cache: false,  
              async: false,
              data: {api_key:'smsatlosbanos', contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date: val.vac_date, vac_site:val.vac_site, time_schedule:val.time_schedule},
              dataType: "JSON",
              complete: function(){
              },
              success: function(data)
              {
                if(data=='1'){
                  toastr.info(`Reminder sent!`);
                }else{
                  toastr.warning('Reminder not sent!');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  toastr.warning('Reminder not sent!');
              }
            });
          });
        }else{
          toastr.warning('NO REMINDERS TO SEND!');
        }
      }
    });
  }

  function send_custom_sms(){
    var reminder_date = $('#vac_date').val();
    var category_group = $('#category_group').val();
    $.ajax({
      url : "<?= base_url();?>Vac_list/bulk_sched",
      type: "POST",
      data: {
              dose:dose, 
              first_vac_site_id:$('#first_vac_site_id').val(), 
              vac_site_id:$('#vac_site_id').val(), 
              provCode:$('#provCode').val(),
              citymunCode:$('#citymunCode').val(),
              brgyCode:$('#brgyCode').val(),
              age_bracket:$('#age_bracket').val(),
              with_comorbidity:$('#with_comorbidity').val(),
              sched_status:$('#sched_status').val(),
              vac_date:$('#vac_date').val(),
              text_status:$('#text_status').val(),
              sched_rep:$('#sched_rep').val(),
              category_group:$('#category_group').val(),
              category:$('#category').val(),
              vaccine_used:$('#vaccine_used').val(),
              fvd:$('#fvd').val()
            },
      beforeSend: function() {
        $('.content-wrapper').addClass('disable');
        $('.btn-close').prop('disabled', true);
          $('.modal-content').addClass('disable');
        $('.loader').show();
      },
      complete: function(){
        $('.content-wrapper').removeClass('disable');
        $('.btn-close').prop('disabled', false);
        $('.modal-content').removeClass('disable');
        $('.loader').hide();
        $('#reminder_modal').modal('hide');
      },
      dataType: "JSON",
      success: function(data)
      {
        if(data){
          $.each(data.list, function( key, val ) {
            if(dose == 1){
              var time_schedule = val.time1;
            }else{
              var time_schedule = val.time2;
            }
            $.ajax({
              url : "<?= base_url();?>Sms/a1_relative",
              type: "POST",
              cache: false,  
              async: false,
              data: {apikey:'smsatlosbanos',userid:val.userid, contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date:val.first_vac_date, vac_site:val.first_vac_site, dose:dose, time_schedule:time_schedule},
              dataType: "JSON",
              complete: function(){
              },
              success: function(data)
              {
                if(data.status=='200'){
                  toastr.info(`Reminder sent!`);
                }else{
                  toastr.warning('Reminder not sent!');
                }
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  toastr.warning('Reminder not sent!');
              }
            });
          });
        }else{
          toastr.warning('NO REMINDERS TO SEND!');
        }
      }
    });
  }

  function sendSms_android_bulk(){
    var schedule = $('#schedule').val();
    var status = $('#status').val();
    var vac_site = $('#vac_site_bulk').val();
    var si_id = $('#si_id').val();
    var username = 'pido';
    var password = 'smsatlosbanos';
    var device_id = $('#device_id').val();
    var vaccine_used = $('#vaccine_used_sms').val();
    var link = $('#device_id').find(':selected').data('link');
    if(schedule!=''){
      $.ajax({
        url : "<?= base_url();?>Vac_list/get_scheduled_list",
        type: "POST",
        data: {schedule:schedule, dose:dose, status:status, vac_site:vac_site, vaccine_used:vaccine_used},
        dataType: "JSON",
        beforeSend: function() {
          $('.content-wrapper').addClass('disable');
          $('.modal-content').addClass('disable');
          $('.btn-close').prop('disabled', true);
          $('.loader').show();
        },
        complete: function(){
          $('.content-wrapper').removeClass('disable');
          $('.modal-content').removeClass('disable');
          $('.btn-close').prop('disabled', false);
          $('.loader').hide();
          table.ajax.reload(null, false);
          $('#bulkMsg_modal').modal('hide');
        },
        success: function(data)
        {
          $.each(data,function(key, val){
            $.ajax({
              url : "<?= base_url();?>Sms/vac_msg",
              type: "POST",
              cache: false,  
              async: false,
              data: {userid:val.userid, contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date:val.vac_date, vac_manufacturer:val.vaccine, vac_site:val.vac_site, dose:dose, si_id:si_id, device_id:device_id, link:link},
              dataType: "JSON",
              success: function(data)
              {
                if(data.status=='200'){
                  toastr.info(`Message Sent to ${val.lname}, ${val.fname}!`);
                }else{
                  toastr.warning(`Message Send Failed to ${val.lname}, ${val.fname}!`);
                }
              }
            });
          });
        }
      });
    }else{
          toastr.info('Add Schedule First!');
    }
  }

  function bulk_list(){
    var schedule = $('#schedule').val();
    var status = $('#status').val();
    var vac_site = $('#vac_site_bulk').val();
    var vaccine_used = $('#vaccine_used_sms').val();
    $.ajax({
      url : "<?= base_url();?>Vac_list/get_scheduled_list",
      type: "POST",
      data: {schedule:schedule, dose:dose,status:status, vac_site:vac_site, vaccine_used:vaccine_used},
      dataType: "JSON",
      success: function(data)
      {
        bulk_tbl.clear();
        var vac_site;
        $.each(data, function( key, val ) {
          vac_site =conv_site(val.vac_site);
          bulk_tbl.row.add([ `${val.lname}, ${val.fname}`,
                              val.contact_number,
                              val.vaccine,
                              vac_site,
                          ]).node();
        });
        bulk_tbl.draw();
      }
    });
  }

  function bulk_list_reminder(){
      $.ajax({
      url : "<?= base_url();?>Vac_list/bulk_sched",
      type: "POST",
      data: {
                    dose:dose, 
                    first_vac_site_id:$('#first_vac_site_id').val(), 
                    vac_site_id:$('#vac_site_id').val(), 
                    provCode:$('#provCode').val(),
                    citymunCode:$('#citymunCode').val(),
                    brgyCode:$('#brgyCode').val(),
                    age_bracket:$('#age_bracket').val(),
                    with_comorbidity:$('#with_comorbidity').val(),
                    sched_status:$('#sched_status').val(),
                    vac_date:$('#vac_date').val(),
                    text_status:$('#text_status').val(),
                    sched_rep:$('#sched_rep').val(),
                    category:$('#category').val(),
                    category_group:$('#category_group').val(),
                    vaccine_used:$('#vaccine_used').val(),
                    fvd:$('#fvd').val()
            },
      dataType: "JSON",
      success: function(data)
      {
        tbl_reminder.clear();
        var vac_site;
        $.each(data.list, function( key, val ) {
          vac_site =conv_site(val.second_vac_site);
          tbl_reminder.row.add([ `${val.lname}, ${val.fname}`,
                              val.contact_number,
                              val.possible_vaccine,
                          ]).node();
        });
        tbl_reminder.draw();
      }
    });
  }


  function conv_site(vac_site){
    if(vac_site == 1){
      var site = 'Batong Malake';
    }else if(vac_site == 2){
      var site = 'UPLB Copeland';
    }else if(vac_site == 3){
      var site = 'LB Evacuation Center';
    }else if(vac_site == 4){
      var site = 'St. Jude';
    }else if(vac_site == 5){
      var site = 'LBDH';
    }else if(vac_site == 6){
      var site = 'HealthServ';
    }else if(vac_site == 7){
      var site = 'UPLB UHS';
    }else if(vac_site == 8){
      var site = 'IRRI';
    }
    return site;
  }

  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }  

  $(document).ready(function(){
   bulk_tbl =  $('#bulk_table').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      dom: 'lfrtip',
      "iDisplayLength": 5
    });

   bulk_schedTbl =  $('#bulk_schedtable').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      dom: 'lfrtip',
      "iDisplayLength": 5,
      "ordering": false
    });

   tbl_reminder =  $('#tbl_reminder').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      dom: 'lfrtip',
      "iDisplayLength": 5,
      "ordering": false
    });

    $('#update_message').hide();
    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "ordering": false,
      responsive: true,
      "aLengthMenu": [[5, 10, 20, 50,-1], [5, 10, 20, 50,'ALL']],
      buttons:[
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Health Declarations',
              },
            ],
      "iDisplayLength": 10,
      //add toolbar div after button
      dom: 'lB<"toolbar">frtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('Vac_list/ajax_admin_list')?>",
        "type": "POST",
        "data": function ( data ) {
          data.provCode = $('#provCode').val();
          data.citymunCode = $('#citymunCode').val();
          data.brgyCode = $('#brgyCode').val();
          data.age_bracket = $('#age_bracket').val();
          data.with_comorbidity = $('#with_comorbidity').val();
          data.sched_status = $('#sched_status').val();
          data.vac_date = $('#vac_date').val();
          data.text_status = $('#text_status').val();
          data.sched_rep = $('#sched_rep').val();
          data.fvd = $('#fvd').val();
          data.time_schedule = $('#time_schedule').val();
          data.category = $('#category').val();
          data.category_group = $('#category_group').val();
          data.vaccine_used = $('#vaccine_used').val();
          data.vac_site_id = $('#vac_site_id').val();
          data.first_vac_site_id = $('#first_vac_site_id').val();
          data.dose = dose;
        },
        "dataSrc": function(json){
          return json.data;
        }
      },
   
      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
        },
      ],
      createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class
        if(data[11]=='NO'){
              $(row).find('td:eq(11)').addClass("label-warning");
        }else if(data[11]=='YES'){
              $(row).find('td:eq(11)').addClass("label-info");
        }else if(data[11]=='RESCHED'){
              $(row).find('td:eq(11)').addClass("bg-gray-active color-palette");
        }else if(data[13]!=null && data[8]!=''){
              $(row).find('td:eq(11)').addClass("label-danger");
        }
        if(data[15] == '1' || data[15] == '2' ){
              $(row).find('td:eq(1)').addClass("label-success");
        }
      }
    });

    $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table 
    }); 

    //refresh the table every 20 seconds
    // setInterval(function(){
    //   table.ajax.reload(null,false); //reload datatable ajax 
    // }, 5000);

      $('#btn-reset').click(function(e){ //button reset event click
        $('#form-filter')[0].reset();
          table.ajax.reload();  //just reload table  
          $('#provCode').select2().val("434"); 
          $('#citymunCode').select2().val("43411"); 
          $('#brgyCode').select2().val(""); 
          $('#age_bracket').select2().val(""); 
          $('#with_comorbidity').select2().val(""); 
          $('#sched_status').select2().val(""); 
          $('#vac_status').select2().val(""); 
          $('#sched_rep').select2().val(""); 
          $('#vaccine_used').select2().val(""); 
          $('#category').select2().val(); 
          $('#category_group').select2().val(); 
          $('#text_status').select2().val(); 
          $('#time_schedule').select2().val(); 
          $('#vac_site_id').select2().val(); 
          $('#first_vac_site_id').select2().val(); 
      });    

    $("form").keypress(function(e) {
    //Enter key
      if (e.which == 13) {
        return false;
      }
    });  

    $('.loader').hide();


    $('#table').on('click','#view_status', function(){
      var id = this.getAttribute("client_id");
      view_status(id);
    });

    $('#table').on('click','.vac_msg', function(){
      var name = this.getAttribute('name');
      var contact_number = this.getAttribute('contact_number');
      var vac_date = this.getAttribute('vac_date');
      var vac_manufacturer = this.getAttribute('vac_manufacturer');
      var vac_site = this.getAttribute('vac_site');
      var userid = this.getAttribute('userid');
      if(vac_date!='' && vac_site!=0 && vac_manufacturer!='' ){
        $('#userid-sms').val(userid);
        $('#name-sms').val(name);
        $('#contact_number-sms').val(contact_number);
        $('#vac_date-sms').val(vac_date);
        $('#vac_manufacturer-sms').val(vac_manufacturer);
        $('#vac_site-sms').val(vac_site);
        $('#dose-sms').val(dose);

        var site = conv_site(vac_site);

        $('#display-name1').html(`<h5>${name}</h5>`);
        $('#display-sched1').html(`<h5>${convert_date(vac_date)}</h5>`);
        $('#display-site1').html(`<h5>${site}</h5>`);
        $('#display-vac1').html(`<h5>${vac_manufacturer}</h5>`);
        $('#display-dose1').html(`<h5>${dose_text}</h5>`);

        $('#confirm_modal').modal('show');
      }else{
        toastr.warning('Incomplete Parameters!');
      }
    })

    $('#sendBtn').click(function(e){
      e.preventDefault();
      var name = $('#name-sms').val();
      var contact_number = $('#contact_number-sms').val();
      var vac_date = $('#vac_date-sms').val();
      var vac_manufacturer = $('#vac_manufacturer-sms').val();
      var vac_site = $('#vac_site-sms').val();
      var si_id = $('#si_id_single').val();
      var userid =  $('#userid-sms').val();
      var device_id =  $('#sdevice_id').val();
      var link = $('#sdevice_id').find(':selected').data('link');
      $.ajax({
        url : "<?= base_url();?>Sms/vac_msg",
        type: "POST",
        data: {username:'pido', password:'sms@losbanos', contact_number:contact_number, name:name, userid:userid, vac_date: vac_date, vac_manufacturer:vac_manufacturer, vac_site:vac_site, dose:dose, si_id:si_id, device_id:device_id, link:link},
        dataType: "JSON",
        beforeSend: function() {
          $('.content-wrapper').addClass('disable');
          $('.btn-close').prop('disabled', true);
          $('.loader').show();
        },
        complete: function(){
          $('.content-wrapper').removeClass('disable');
          $('.btn-close').prop('disabled', false);
          $('.loader').hide();
        },
        success: function(data)
        {
          if(data.status=='200'){
            $('#confirm_modal').modal('hide');
            toastr.info('Message sent!');
            table.ajax.reload(null, false);
          }else{
            toastr.warning('Message not sent!');
          }
          console.log(data);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
        }
      });
    })

    $('#table').on('click','.add_schedule', function(){
      var date_sched = $('#date_sched').val();
      var vac_manufacturer = dose=='1'?$('#vac_manufacturer').val():this.getAttribute('vac_manufacturer');
      var vac_site = $('#vac_site').val();
      var fullname = this.getAttribute('name');
      var userid = this.getAttribute('userid');
      var site_text = $( "#vac_site option:selected" ).text();
      $('#userid').val(userid);
      if(date_sched!='' && vac_site!='' && vac_manufacturer !=''){
          $.ajax({
              url : "<?= base_url();?>Vac_list/check_sched",
              type: "POST",
              data: {date_sched:date_sched, dose:dose, vac_site:vac_site},
              dataType: "JSON",
              success: function(data)
              {
                  var total = data.total?data.total:'0';
                  var total_site = data.total_site?data.total_site:'0';
                  $('#userid').val(userid);
                  $('#display-name').html(`<h5>${fullname}</h5>`);
                  $('#display-sched').html(`<h5>${date_sched}</h5>`);
                  $('#display-site').html(`<h5>${site_text}</h5>`);
                  $('#display-vac').html(`<h5>${vac_manufacturer}</h5>`);
                  $('#display-dose').html(`<h5>${dose_text}</h5>`);
                  $('#display-total').html(`<h2 class='red'><center>${total}</center></h2>`);
                  $('#display-total_site').html(`<h3 class='red'><center>${total_site}</center></h3>`);
                  $('#add_sched_modal').modal('show');
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
              }
          });
      }else{
        toastr.warning('Incomplete Parameterssss!');
      }
    })

    $('#table').on('click','.update', function(){
      var userid = this.getAttribute('userid');
      var contact_number = this.getAttribute('contact_number');
      var vac_date = this.getAttribute('vac_date');
      var next_vac_date = this.getAttribute('next_vac_date');
      var vac_manufacturer = this.getAttribute('vac_manufacturer');
      var dose = this.getAttribute('dose');
      var name = this.getAttribute('name');
      var vac_site = this.getAttribute('vac_site');
      var reply = this.getAttribute('reply');
      var si_id = this.getAttribute('si_id');
      $('#uuserid').val(userid);
      $('#ucn').val(contact_number);
      $('#reply2').val(reply);
      $('#uvd').val(vac_date);
      $('#usvd').val(next_vac_date);
      $('#uvac_site').val(vac_site);
      $('#si_id').val(si_id);
      $('#uvm').val(vac_manufacturer).trigger('change');
      $('#update_name_display').html(name);

      $('#update_modal').modal('show');
    })

    $('#table').on('click','.sms_history', function(){
      var contact_number = this.getAttribute('contact_number');
      var dose = this.getAttribute('dose');

      $.ajax({
          url : "<?= base_url();?>Sms_records/client_reply",
          type: "POST",
          data: {contact_number:contact_number, dose:dose},
          dataType: "JSON",
          success: function(data)
          {
            var table ='';
            $.each(data,function(key, val){
              table += `<tr><td>${val.number}</td>`;
              table += `<td>${val.device}</td>`;
              table += `<td>${val.message}</td></tr>`;
            });
            $('#tbody_sms').html(table);
            $('#sms_history_modal').modal('show');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })

    $('#table').on('click','.update1', function(){
      var userid = this.getAttribute('userid');
      var contact_number = this.getAttribute('contact_number');
      var dose = this.getAttribute('dose');
      var name = this.getAttribute('name');
      var vac_date = this.getAttribute('vac_date');
      var vac_site = this.getAttribute('vac_site');
      var reply = this.getAttribute('reply');
      var si_id = this.getAttribute('si_id');
      $('#reply').val(reply);
      $('#uuserid1').val(userid);
      $('#uvac_date').val(vac_date);
      $('#uvac_site').val(vac_site);
      $('#si_id').val(si_id);
      $('#ucn1').val(contact_number);
      $('#update_name_display1').html(name);
      $('#a1_vaccinated_status').val('0');

      $('#update1_modal').modal('show');
    })

    $('#update_btn').click(function(){
      var userid =$('#uuserid').val();
      var contact_number = $('#ucn').val();
      var vac_manufacturer = $('#uvm').val();
      var next_vac_date = $('#usvd').val();
      var first_dose_date = $('#uvd').val();
      var reply = $('#reply2').val();
      var vac_date = $('#usvd').val();
      var vac_site = $('#uvac_site').val();
      var si_id = $('#si_id').val();

      $.ajax({
          url : "<?= base_url();?>Vac_list/update_client",
          type: "POST",
          data: {contact_number:contact_number, userid:userid, vac_manufacturer:vac_manufacturer, first_dose_date:first_dose_date,next_vac_date:next_vac_date,reply:reply, dose:dose,vac_site:vac_site,si_id:si_id},
          dataType: "JSON",
          success: function(data)
          {
            toastr.info('Client detail has been updated!');
            table.ajax.reload(null, false);
            $('#update_modal').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })

    $('#update1_btn').click(function(){
      var userid =$('#uuserid1').val();
      var contact_number = $('#ucn1').val();
      var is_disable = $('#is_disable').val();
      var a1_vaccinated_status = $('#a1_vaccinated_status').val();
      var reply = $('#reply').val();
      var vac_date = $('#uvac_date').val();
      var vac_site = $('#uvac_site').val();
      var si_id = $('#si_id').val();

      $.ajax({
          url : "<?= base_url();?>Vac_list/update1_client",
          type: "POST",
          data: {contact_number:contact_number, userid:userid, is_disable:is_disable, a1_vaccinated_status:a1_vaccinated_status, reply:reply, dose:dose, vac_date:vac_date, vac_site:vac_site,si_id:si_id},
          dataType: "JSON",
          success: function(data)
          {
            toastr.info('Client detail has been updated!');
            table.ajax.reload(null, false);
            $('#update1_modal').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })

    $('#confirmBtn').click(function(e){
      e.preventDefault();
      var userid =$('#userid').val();
      var date_sched = $('#date_sched').val();
      var vac_manufacturer = $('#vac_manufacturer').val();
      var vac_site = $('#vac_site').val();
      $.ajax({
          url : "<?= base_url();?>Vac_list/update_sched",
          type: "POST",
          data: {date_sched:date_sched, userid:userid, vac_manufacturer:vac_manufacturer, vac_site:vac_site, dose:dose},
          dataType: "JSON",
          success: function(data)
          {
            toastr.info('Schedule has been updated!');
            table.ajax.reload(null, false);
            $('#add_sched_modal').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })

    //add input text after buttons inside toolbar div
    if(dose=="1" && scheduler_access == "1"){
      $("div.toolbar").html(
        `
        <input type="number" class="form-control red" placeholder="Quantity of schedule" id="sched_quantity"  min="1" max="200">
        <input type="text" class="form-control date red" placeholder="Schedule Date" id="date_sched">
        <select id="vac_site" name="vac_site" class="form-control select2 required">
          <option value="">Select Venue</option>
          <?php foreach($vac_site_list as $val){  ?>
            <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
          <?php } ?>
         </select>
        <select id="vac_manufacturer" name="vac_manufacturer" class="form-control select2 required">
          <option value="" selected>Select Vaccine</option>
          <option value="Pfizer">Pfizer</option>
          <option value="Moderna">Moderna</option>
          <option value="Astrazeneca">Astrazeneca</option>
          <option value="Sinovac">Sinovac</option>
          <option value="Gamaleya">Gamaleya</option>
          <option value="Janssen">Janssen</option>
         </select>
         <button class="btn btn-primary" id='bulk_sched'><i class='fa fa-calendar'></i> Bulk Sched</button>
         <button class="btn btn-success" id='text_all'><i class='fa fa-mobile'></i> Bulk Text</button>
         <button class="btn btn-info" id='reminder'><i class='fa fa-mobile'></i> Send Reminder</button>
        `);
    }
    if(dose=="2" && scheduler_access == "1"){
      $("div.toolbar").html(
        `
        <input type="number" class="form-control red" placeholder="Quantity of schedule" id="sched_quantity"  min="1" max="200">
        <input type="text" class="form-control date red" placeholder="Schedule Date" id="date_sched">
        <select id="vac_site" name="vac_site" class="form-control select2 required">
          <option value="">Select Venue</option>
          <?php foreach($vac_site_list as $val){  ?>
            <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
          <?php } ?>
         </select>
         <button class="btn btn-primary" id='bulk_sched'><i class='fa fa-calendar'></i> Bulk Sched</button>
         <button class="btn btn-success" id='text_all'><i class='fa fa-mobile'></i> Bulk Text</button>
         <button class="btn btn-info" id='reminder'><i class='fa fa-mobile'></i> Send Reminder</button>
        `);
    }

    //datepicker on dynamically created input
    $('body').on('focus',".date", function(){
        $(this).datepicker({
          changeYear:true,
          changeMonth: true,
          minDate: 1,
          yearRange: year+":+1",
          dateFormat: 'MM dd, yy',
          showButtonPanel: true,
           closeText: 'Clear',
           onClose: function (dateText, inst) {
               if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
                   document.getElementById(this.id).value = '';
               }
           }

        });
    });

    $('body').on('change',"#date_sched", function(){
      if($(this).val()!=''){
        $(this).css('box-shadow','0 0 3px #002699');
      }else{
        $(this).css('box-shadow','0 0 3px #CC0000');
      }
    })

  $('body').on('click','#text_all',function(){
    bulk_tbl.clear().draw();
    $('#schedule').val('');
    $('#vac_site_bulk').val('').trigger('change');
    $('#status').val('').trigger('change');
    $('#bulkMsg_modal').modal('show');
  })

  $('body').on('click','#reminder',function(){
    var selected_category = $( "#category_group option:selected" ).text();
    var vac_date = $('#vac_date').val();
    if(vac_date!=''){
      $('#vac_sched_display').html(`<h3>DATE: ${vac_date}<br>CATEGORY Group:  ${selected_category}</h3>`);
      $('#reminder_date').val('');
      bulk_list_reminder();
      $('#reminder_modal').modal('show');
    }else{
      alert('Select Vaccine Schedule First');
    }
  })

    $('#bulkSendBtn').click(function(){
      var device = $('#device_id').find(':selected').data('device');
      if(device!=''){
        if(device == '1'){
          sendSms_android_bulk();
        }
        if(device == '2'){
          sendSms_dost_bulk();
        }
      }else{
        toastr.warning(`Select device first!`);
      }
    })

    $('#reminderSendBtn-FL').click(function(){
      var reminder_date = $('#vac_date').val();
      var category_group = $('#category_group').val();
      var start = $('#start').val();
      var end = $('#end').val();
      var device_id = $("#reminder_device_id").val();
      if(reminder_date!=''){
        $.ajax({
          url : "<?= base_url();?>Sms/reminder_data",
          type: "POST",
          data: {reminder_date:reminder_date, dose:dose, category_group:category_group,start:start,end:end},
          dataType: "JSON",
          beforeSend: function() {
            $('.content-wrapper').addClass('disable');
            $('.modal-content').addClass('disable');
            $('.btn-close').prop('disabled', true);
            $('.loader').show();
          },
          complete: function(){
            $('.content-wrapper').removeClass('disable');
            $('.modal-content').removeClass('disable');
            $('.btn-close').prop('disabled', false);
            $('.loader').hide();
            $('#reminder_modal').modal('hide');
            table.ajax.reload(null, false);
          },
          success: function(data)
          {
            $.each(data,function(key, val){
              $.ajax({
                url : "<?= base_url();?>Sms/frontliner_reminder",
                type: "POST",
                cache: false,  
                async: false,
                data: {apikey:'smsatlosbanos',userid:val.userid, contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date:val.vac_date, vac_site:val.vac_site, dose:dose, time_schedule:val.time_schedule,device_id:device_id},
                dataType: "JSON",
                success: function(data)
                {
                  if(data.status=='200'){
                    toastr.info(`Message Sent to ${val.lname}, ${val.fname}!`);
                  }else{
                    toastr.warning(`Message Send Failed to ${val.lname}, ${val.fname}!`);
                  }
                }
              });
            });
          }
        });
      }else{
            toastr.info('Add Schedule First!');
      }
    })

    $('#reminderSendBtn-C').click(function(){
      var reminder_date = $('#vac_date').val();
      var category_group = $('#category_group').val();
      if(reminder_date!=''){
        $.ajax({
          url : "<?= base_url();?>Sms/reminder_data",
          type: "POST",
          data: {reminder_date:reminder_date, dose:dose, category_group:category_group},
          dataType: "JSON",
          beforeSend: function() {
            $('.content-wrapper').addClass('disable');
            $('.modal-content').addClass('disable');
            $('.btn-close').prop('disabled', true);
            $('.loader').show();
          },
          complete: function(){
            $('.content-wrapper').removeClass('disable');
            $('.modal-content').removeClass('disable');
            $('.btn-close').prop('disabled', false);
            $('.loader').hide();
            $('#reminder_modal').modal('hide');
            table.ajax.reload(null, false);
          },
          success: function(data)
          {
            $.each(data,function(key, val){
              $.ajax({
                url : "<?= base_url();?>Sms/send_cancellation",
                type: "POST",
                cache: false,  
                async: false,
                data: {contact_number:val.contact_number, vac_date:val.vac_date},
                dataType: "JSON",
                success: function(data)
                {
                  if(data.status=='200'){
                    toastr.info(`Message Sent to ${val.lname}, ${val.fname}!`);
                  }else{
                    toastr.warning(`Message Send Failed to ${val.lname}, ${val.fname}!`);
                  }
                }
              });
            });
          }
        });
      }else{
            toastr.info('Add Schedule First!');
      }
    })


    $('#reminderSendBtn').click(function(){
    var reminder_date = $('#vac_date').val();
    var category_group = $('#category_group').val();
      var start = $('#start').val();
      var end = $('#end').val();
      alert(start);
      var device_id = $("#reminder_device_id").val();
      if(reminder_date!=''){
        $.ajax({
          url : "<?= base_url();?>Sms/reminder_data",
          type: "POST",
          data: {reminder_date:reminder_date, dose:dose, category_group:category_group, start:start, end:end},
          dataType: "JSON",
          beforeSend: function() {
            $('.content-wrapper').addClass('disable');
            $('.modal-content').addClass('disable');
            $('.btn-close').prop('disabled', true);
            $('.loader').show();
          },
          complete: function(){
            $('.content-wrapper').removeClass('disable');
            $('.modal-content').removeClass('disable');
            $('.btn-close').prop('disabled', false);
            $('.loader').hide();
            table.ajax.reload(null, false);
            $('#reminder_modal').modal('hide');
          },
          success: function(data)
          {
            $.each(data,function(key, val){
              $.ajax({
                url : "<?= base_url();?>Sms/send_reminder",
                type: "POST",
                cache: false,  
                async: false,
                data: {apikey:'smsatlosbanos',userid:val.userid, contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date:val.vac_date, vac_site:val.vac_site, dose:dose, time_schedule:val.time_schedule,device_id:device_id},
                dataType: "JSON",
                success: function(data)
                {
                  if(data.status=='200'){
                    toastr.info(`Message Sent to ${val.lname}, ${val.fname}!`);
                  }else{
                    toastr.warning(`Message Send Failed to ${val.lname}, ${val.fname}!`);
                  }
                }
              });
            });
          }
        });
      }else{
            toastr.info('Add Schedule First!');
      }
    })

    $(this).datepicker({
      changeYear:true,
      changeMonth: true,
      minDate: 1,
      yearRange: year+":+1",
      dateFormat: 'MM dd, yy',
      showButtonPanel: true,
       closeText: 'Clear',
       onClose: function (dateText, inst) {
           if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
               document.getElementById(this.id).value = '';
           }
       }

    });

    $('body').on('click','#bulk_sched',function(){
      bulk_schedTbl.clear();
      //reset value of selected_rowsID
      selected_rowsID = [];
      var quantity = $('#sched_quantity').val();
      var date_sched = $('#date_sched').val();
      var vac_manufacturer = $('#vac_manufacturer').val();
      var vac_site = $('#vac_site').val();
      var site_text = $( "#vac_site option:selected" ).text();
      if(date_sched != '' && vac_manufacturer != '' && vac_site != '' && ((dose == 1 && quantity!='') || dose == 2 )){
      //table.page.len(-1).draw();
        $.ajax({
            url : "<?= base_url();?>Vac_list/bulk_sched",
            type: "POST",
            data: {date_sched:date_sched, 
                    dose:dose, 
                    vac_site:vac_site, 
                    quantity:quantity,
                    vac_manufacturer:vac_manufacturer,
                    first_vac_site_id:$('#first_vac_site_id').val(),
                    provCode:$('#provCode').val(),
                    citymunCode:$('#citymunCode').val(),
                    brgyCode:$('#brgyCode').val(),
                    age_bracket:$('#age_bracket').val(),
                    with_comorbidity:$('#with_comorbidity').val(),
                    sched_status:$('#sched_status').val(),
                    vac_date:$('#vac_date').val(),
                    text_status:$('#text_status').val(),
                    sched_rep:$('#sched_rep').val(),
                    category_group:$('#category_group').val(),
                    category:$('#category').val(),
                    vaccine_used:$('#vaccine_used').val(),
                    fvd:$('#fvd').val()
                  },
            dataType: "JSON",
            success: function(data)
            {
              $.each(data.list,function(key, val){
                selected_rowsID.push(val.userid);
                bulk_schedTbl.row.add([ `${val.lname}, ${val.fname} ${val.mname}`,
                                        val.age,
                                        val.comor,
                                        val.vac_date,
                                        val.vac2,
                ]);
              });
              bulk_schedTbl.draw();

              var total = data.total?data.total:'0';
              var total_site = data.total_site?data.total_site:'0';
              $('#display-sched-bulk').html(`<h5>${date_sched}</h5>`);
              $('#display-site-bulk').html(`<h5>${site_text}</h5>`);
              $('#display-dose-bulk').html(`<h5>${dose_text}</h5>`);
              if(vac_manufacturer!=undefined){
                $('#display-vac-bulk').html(`<h5>${vac_manufacturer}</h5>`);
              }
              $('#display-qtota-bulk').html(`<h2 class='red'><center>${quantity}</center></h2>`);
              $('#display-total-bulk').html(`<h3 class='red'><center>${total}</center></h3>`);
          }
          });
        $('#bulk_modal').modal('show');
      }else{
      toastr.warning('Incomplete Parameters!');
      }
    })

    $('#reminderSendBtn-FL_dost').click(function(){
      var reminder_date = $('#vac_date').val();
      var category_group = $('#category_group').val();
      $.ajax({
        url : "<?= base_url();?>Vac_list/reminder_list",
        dataType: "JSON",
        data:{reminder_date:reminder_date, category_group:category_group, dose:dose},
        type: "POST",
        beforeSend: function() {
          $('.content-wrapper').addClass('disable');
          $('.btn-close').prop('disabled', true);
            $('.modal-content').addClass('disable');
          $('.loader').show();
        },
        complete: function(){
          $('.content-wrapper').removeClass('disable');
          $('.btn-close').prop('disabled', false);
          $('.modal-content').removeClass('disable');
          $('.loader').hide();
          $('#reminder_modal').modal('hide');
        },
        success: function(data)
        {
          if(data){
            $.each(data, function( key, val ) {
              $.ajax({
                url : "<?= base_url();?>DostApi/send_reminder",
                type: "POST",
                cache: false,  
                async: false,
                data: {api_key:'smsatlosbanos', contact_number:val.contact_number, name:`${val.lname}, ${val.fname}`, vac_date: val.vac_date, vac_site:val.vac_site, time_schedule:val.time_schedule},
                dataType: "JSON",
                complete: function(){
                },
                success: function(data)
                {
                  if(data=='1'){
                    toastr.info(`Reminder sent!`);
                  }else{
                    toastr.warning('Reminder not sent!');
                  }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    toastr.warning('Reminder not sent!');
                }
              });
            });
          }else{
            toastr.warning('NO REMINDERS TO SEND!');
          }
        }
      });
    })

    $('#send_custom_sms').click(function(){
      send_custom_sms();
    });


});
</script>
<?php  $this->load->view('admin/modal/vaccination'); ?>
