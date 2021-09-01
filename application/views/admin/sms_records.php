<!-- <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">
 --><style type="text/css">
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
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Active Clients for verification
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Clients List</li>
        </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="panel-body">
              <form id="form-sms" class="form-horizontal">
                <div class="col-md-2"> 
                  <label>Default Device</label>
                  <select name="device_id" id="device_id" class="form-control">
                    <option value="">Select Device</option>
                    <?php foreach($device as $val){ ?>
                      <option value="<?= $val->device_id ?>" <?php echo ($val->is_active=='1')?'selected':''; ?>><?= $val->description ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-1"> 
                  <br>
                  <button class="btn btn-info" id="save_device">Save</button>
                </div>
                <div class="col-md-4"> 
                </div>
                <div class="col-md-2"> 
                  <label>Contact Number</label>
                  <input type="text" name="phoneNumber" id="phoneNumber" class="form-control">
                </div>
                <div class="col-md-2"> 
                  <label>Message</label>
                  <input type="text" name="message" id="message" class="form-control">
                </div>
                <div class="col-md-1"> 
                  <br>
                  <button class="btn btn-info" id="sms-btn">Submit</button>
                </div>
              </form>   
            </div> 
          </div>
          <div class="box">
            <div class="box-body table-responsive">
              <table id="table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                      <th width="5%">#</th>
                      <th width="15%">Device</th>
                      <th width="15%">Number</th>
                      <th width="30%">Message</th>
                      <th width="5%">Action</th>
                      <th width="10%">Date</th>
                      <th width="10%">Time</th>
                    </tr>
                </thead>
                <tbody>

                </tbody> 
              </table>
              <hr /> 
            </div> 
          </div>
        </div>
      </div>
    </section>
  </div>

<!----MODAL--->

<script type="text/javascript"> 
  var table;
   
  $(document).ready(function(){
    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order":  false, //Initial no order.
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "iDisplayLength": 10,
      // dom: 'Blfrtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('Sms_records/list')?>",
        "type": "POST",
        "data": function ( data ) {
          data.provCode = $('#provCode').val();
          data.citymunCode = $('#citymunCode').val();
          data.brgyCode = $('#brgyCode').val();
          data.status_filter = $('#status_filter').val();
        }
      },
   
      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
        },
      ],
   
    });
   
    $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table 
    }); 

    //refresh the table every 20 seconds
    setInterval(function(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }, 20000);


      $('#btn-reset').click(function(e){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table  
          $('#provCode').select2().val("0"); 
          $('#citymunCode').select2().val("0"); 
          $('#brgyCode').select2().val("0"); 
          $('#status_filter').select2().val("0"); 
      });    
  }); 

  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }

  var save_method; //for save method string
  var table;

  $(document).ready(function() {
    $("form").keypress(function(e) {
    //Enter key
      if (e.which == 13) {
        return false;
      }
    });  
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
          }
      },
      complete: function (data) {
          $("#citymunCode").html(municipality_list);
          get_brgy(selected,brgy);
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
                brgy_list = "<option value=''>ALL</option>";
                jQuery.each(data, function(i, val) {
                    brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
                });
            }else{
                brgy_list = "<option value='' disabled selected>Select Brgy</option>";
                brgy_list = "<option value=''>ALL</option>";
            }
        },
        complete: function (data) {
          $("#brgyCode").html(brgy_list);
        }
      });
    }else{
      brgy_list = "<option value='' disabled selected>Select Municipality / City First</option>";
      brgy_list = "<option value=''>ALL</option>";
      $("#brgyCode").html(brgy_list);
    }
  }

  function update_mun(val,selected,brgy){
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
          $("#update_citymunCode").html(municipality_list);
          update_brgy(selected,brgy);
      }
    });
  }

  function update_brgy(val,selected){
    if(val!=''){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>General/brgy_list",
        dataType: "JSON",
        data:{citymunCode:val},
        success: function(data){
            if(data != false || data.length >0){
                brgy_list = "<option value='' disabled selected>Select Brgy</option>";
                brgy_list += "<option value=''>ALL</option>";
                jQuery.each(data, function(i, val) {
                  if(val.brgyCode == selected){
                    brgy_list +="<option value='"+val.brgyCode+"' selected>"+val.brgyDesc+"</option>";
                  }else{
                    brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
                  }
                });
            }else{
                brgy_list = "<option value='' disabled selected>Select Municipality</option>";
            }
        },
        complete: function (data) {
        $("#update_brgyCode").html(brgy_list);
        }
      });
    }else{
      update_brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
      $("#update_brgyCode").html(brgy_list);
    }
  }
  function manual_sms(){
    var phoneNumber = $('#phoneNumber').val();
    var message = $('#message').val();
    var device_id = $('#device_id').val();
    if(phoneNumber!='' && message!='' && phoneNumber.length == 11){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Sms/manual_sms",
        dataType: "JSON",
        data:{phoneNumber:phoneNumber, message:message, device_id:device_id},
        success: function(data){
          if(data.status=='200'){
            toastr.info('Message Sent!');
          }else{
            toastr.warning('Message Failed!');
          }
        },
      error: function (jqXHR, textStatus, errorThrown)
      {
            toastr.warning('Message Failed!');
      }
      });
    }else{
      toastr.warning('Invalid Parameters!');
    }
  }

  $('#save_device').click(function(e){
    var device_id = $('#device_id').val();
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Admin/save_device",
      dataType: "JSON",
      data:{device_id:device_id},
      success: function(data){
            toastr.success('Default device has been updated!');
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
            toastr.warning('Saving Failed!');
      }
    });
  })

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

    $("#update_provCode").change(function() {
      var val = $(this).val();
      update_mun(val);
    });  
    $("#update_citymunCode").change(function() {
      var val = $(this).val();
      update_brgy(val);
    }); 

    $('#sms-btn').click(function(e){
      e.preventDefault();
      manual_sms();
    })

    $('#form-sms').each(function() {
      $(this).find('input').keypress(function(e) {
          // Enter pressed?
        if(e.which == 10 || e.which == 13) {
          manual_sms();
        }
      });
    });
});
</script>
