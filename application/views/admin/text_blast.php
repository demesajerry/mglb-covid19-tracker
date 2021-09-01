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

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-syringe"></i></h1>
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
              <div class="col-md-1">  
                <label>Brgy</label>
                <select id="brgyCode" name="brgyCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select Brgy</option>
                  <?php foreach($brgy_list as $val){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                  <?php } ?>
                </select> 
              </div> 
              <div class="col-md-2"> 
                <label>Age bracket</label>
                <select name='age_bracket' id='age_bracket' class="form-control select2">
                  <option value="" selected>ALL</option>
                  <option value="0" >18 - 59</option>
                  <option value="1" >60 and up</option>
                </select>  
              </div> 
              <div class="col-md-1"> 
                <label>Quantity from</label>
                <input type="text" name="q1" id="q1" class="form-control"> 
              </div> 
              <div class="col-md-1">
                <label>Quantity To</label>
                <input type="text" name="q2" id="q2" class="form-control"> 
              </div> 
              <div class="col-md-1"> 
                <br>
                <button type="button" id="btn-reset" class="btn btn-warning"><i class='fa fa-undo'></i> &nbsp; Reset</button>
              </div>
              <div class="col-md-1"> <br> 
                <button type="button" id="btn-filter" class="btn btn-primary"><i class='fa fa-filter'></i> &nbsp; Filter</button>
              </div> 
              <div class="col-md-1"> <br> 
                       <button class="btn btn-success" id='text_all'><i class='fa fa-mobile'></i> Bulk Text</button>
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
                    <th width="15%">Full Name</th>
                    <th width="5%">Barangay</th>
                    <th width="5%">Age</th>
                    <th width="5%">with Commorbidity</th>
                    <th width="5%">Contact</th>
                    <th width="5%">Date</th>
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
  var table, bulk_tbl, bulk_schedTbl, vac_manufacturer_bulk;


  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }  

  function bulk_list(){
    var schedule = $('#schedule').val();
    var status = $('#status').val();
    var vac_site = $('#vac_site_bulk').val();
    $.ajax({
      url : "<?= base_url();?>Vac_list/get_scheduled_list",
      type: "POST",
      data: {schedule:schedule, status:status, vac_site:vac_site},
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

  $(document).ready(function(){
   bulk_tbl =  $('#bulk_table').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      dom: 'lfrtip',
      "iDisplayLength": 5
    });

    $('#update_message').hide();
    //datatables
    // table = $('#table').DataTable({ 
    //   "processing": true, //Feature control the processing indicator.
    //   "serverSide": true, //Feature control DataTables' server-side processing mode.
    //   "ordering": false,
    //   responsive: true,
    //   "aLengthMenu": [[5, 10, 20, 50,-1], [5, 10, 20, 50,'ALL']],
    //   buttons:[
    //           {
    //             extend: 'excelHtml5',
    //             title: 'MGLB-COVID19-TRACKER Health Declarations',
    //           },
    //         ],
    //   "iDisplayLength": 10,
    //   //add toolbar div after button
    //   dom: 'lB<"toolbar">frtip',
    //   select: true,
    //   "ajax": {
    //     "url": "<?php echo site_url('Vac_list/ajax_admin_list')?>",
    //     "type": "POST",
    //     "data": function ( data ) {
    //       data.provCode = $('#provCode').val();
    //       data.citymunCode = $('#citymunCode').val();
    //       data.brgyCode = $('#brgyCode').val();
    //       data.age_bracket = $('#age_bracket').val();
    //     },
    //     "dataSrc": function(json){
    //       return json.data;
    //     }
    //   },
   
    //   //Set column definition initialisation properties.
    //   "columnDefs": [
    //     { 
    //       "targets": [ 0 ], //first column / numbering column
    //       "orderable": false, //set not orderable
    //     },
    //   ],
    //   createdRow: function( row, data, dataIndex ) {
    //     // Set the data-status attribute, and add a class
    //     if(data[9]=='NO'){
    //           $(row).find('td:eq(9)').addClass("label-warning");
    //     }else if(data[9]=='YES'){
    //           $(row).find('td:eq(9)').addClass("label-info");
    //     }else if(data[11]!=null && data[6]!=''){
    //           $(row).find('td:eq(9)').addClass("label-danger");
    //     }
    //   }
    // });

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
          $('#provCode').select2().val(""); 
          $('#citymunCode').select2().val(""); 
          $('#brgyCode').select2().val(""); 
          $('#age_bracket').select2().val(""); 
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

        var site = conv_site(vac_site);

        $('#display-name1').html(`<h5>${name}</h5>`);
        $('#display-sched1').html(`<h5>${convert_date(vac_date)}</h5>`);
        $('#display-site1').html(`<h5>${site}</h5>`);
        $('#display-vac1').html(`<h5>${vac_manufacturer}</h5>`);

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
      var userid =  $('#userid-sms').val();
      $.ajax({
        url : "<?= base_url();?>Sms/vac_msg",
        type: "POST",
        data: {username:'pido', password:'sms@losbanos', contact_number:contact_number, name:name, userid:userid, vac_date: vac_date, vac_manufacturer:vac_manufacturer, vac_site:vac_site},
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

    $('#confirmBtn').click(function(e){
      e.preventDefault();
      var userid =$('#userid').val();
      var date_sched = $('#date_sched').val();
      var vac_manufacturer = $('#vac_manufacturer').val();
      var vac_site = $('#vac_site').val();
      $.ajax({
          url : "<?= base_url();?>Vac_list/update_sched",
          type: "POST",
          data: {date_sched:date_sched, userid:userid, vac_manufacturer:vac_manufacturer, vac_site:vac_site},
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


    //datepicker on dynamically created input
    // $('body').on('focus',".date", function(){
    //     $(this).datepicker({
    //       changeYear:true,
    //       changeMonth: true,
    //       minDate: 1,
    //       yearRange: year+":+1",
    //       dateFormat: 'MM dd, yy',
    //       showButtonPanel: true,
    //        closeText: 'Clear',
    //        onClose: function (dateText, inst) {
    //            if ($(window.event.srcElement).hasClass('ui-datepicker-close')) {
    //                document.getElementById(this.id).value = '';
    //            }
    //        }

    //     });
    // });


  $('#text_all').click(function(e){
    e.preventDefault();
    bulk_tbl.clear().draw();
    $('#schedule').val('');
    $('#vac_site_bulk').val('').trigger('change');
    $('#status').val('').trigger('change');
    $('#bulkMsg_modal').modal('show');
  })

    $('#bulkSendBtn').click(function(){
      var schedule = $('#schedule').val();
      var status = $('#status').val();
      var vac_site = $('#vac_site_bulk').val();
      var username = 'pido';
      var password = 'smsatlosbanos';
      if(schedule!=''){
        $.ajax({
          url : "<?= base_url();?>Sms/bulk_vac_msg",
          type: "POST",
          data: {schedule:schedule,  status:status, vac_site:vac_site},
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
            table.ajax.reload(null, false);
          },
          success: function(data)
          {
            $('#bulkMsg_modal').modal('hide');
            toastr.info('Message sent to gsm modem!');
          }
        });
      }else{
            toastr.info('Add Schedule First!');
      }
    })


    //DOST API

    $('#bulkSendBtn_dost').click(function(){
      var q1 = $('#q1').val();
      var q2 = $('#q2').val();
        $.ajax({
          url : "<?= base_url();?>Admin/get_sms",
          type: "POST",
          data: {q1:q1,  q2:q2},
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
                url : "<?= base_url();?>Sms/ayuda_text",
                type: "POST",
                cache: false,  
                async: false,
                data: {contact_number:val.contact_number},
                dataType: "JSON",
                complete: function(){
                $('#bulkMsg_modal').modal('hide');
                },
                success: function(data)
                {
                  if(data=='1'){
                    $('#confirm_modal').modal('hide');
                    toastr.info(`Message sent!`);
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
    })


});
</script>
<div class="modal fade" id="bulkMsg_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Send Bulk Message</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">
        </div>                  <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
              <button id="bulkSendBtn_dost" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->