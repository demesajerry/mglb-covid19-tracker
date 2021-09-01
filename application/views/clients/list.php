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
        All Active Clients
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
                    <div class="box-header">
                    <h3 class="box-title">Clients List</h3>
                        <div class="box-tools">
                            
                        </div>
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
                            <?php
                            if(!empty(array_intersect(array(1,3), $this->session->userdata('logged_in')->access))){
                            ?>
                            <div class="col-md-2"> 
                              <label>Status</label>
                                <select name='status_filter' id='status_filter' class="form-control select2">
                                  <option value="0" selected disabled>Select Status</option>
                                  <?php
                                      foreach ($status_list as $status) {
                                  ?>
                                  <option value="<?=$status->c_status_id?>" title="<?=$status->c_classification?>">
                                    <?=$status->c_classification?>
                                  </option>
                                  <?php    
                                    }
                                  ?>
                                </select>  
                              </div> 
                                <?php
                                }
                                ?>
                              <div class="col-md-3"> <br> 
                                <button type="button" id="btn-filter" class="btn btn-primary"><i class='fa fa-filter'></i> &nbsp; Filter</button>
                                <button type="reset" id="btn-reset" value="Reset" class="btn btn-default"><i class="fa fa-retweet"></i> Reset</button>    
                              </div> 
                          </form>   
                      </div> 
                    </div>
                <div id="update_message" class="alert alert-info" role="alert">
                </div>

                <div class="alert alert-danger" style="display: none; width: 900px;">
                    
                </div>
                <div class="box-body table-responsive">
                  <table id="table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">Clients ID</th>
                          <th width="20%">Full Name</th>
                          <th width="27%">Address</th>
                          <th width="10%">Birthday</th>
                          <th width="5%">Contact</th>
                          <th width="5%">Status</th>
                          <th width="8%">Action</th>
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
<?php  $this->load->view('clients/client_modal'); ?>
<script type="text/javascript"> 
  var save_method; //for save method string
  var table;
   
  $(document).ready(function(){
  $('#table').on('click','#reset_password', function(){
    var id = this.getAttribute("client_id");
    if(confirm('Confirm Reset Password.')){
      // ajax delete data to database
      $.ajax({
        url : "<?php echo site_url('clients/reset_password')?>/",
        type: "POST",
        data:{id:id},
        dataType: "JSON",
          success: function(data){
            //if success reload ajax table 
            $('#update_message').html('Client password has been reset.').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().fadeOut();
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
          }
        });
    }
  });
    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      responsive: true,
      "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
      "iDisplayLength": 10,
      // dom: 'Blfrtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('clients/ajax_list')?>",
        "type": "POST",
        "data": function ( data ) {
          data.provCode = $('#provCode').val();
          data.citymunCode = $('#citymunCode').val();
          data.brgyCode = $('#brgyCode').val();
          data.status_filter = $('#status_filter').val();
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
        if(data[7]!='' && data[7]!=null){
          var end_quarantine = new Date(data[7]);
          var today = new Date();
          var diff = new Date(end_quarantine - today);
          var days = Math.round(diff/1000/60/60/24);
            if(days ==1){
              $(row).addClass("label-warning");
            }
            else if(days <= 0){
              $(row).addClass("label-danger");
            }
        }
    }
    });
   
    $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table 
    }); 

    //refresh the table every 20 seconds
    setInterval(function(){
      table.ajax.reload(null,false); //reload datatable ajax 
    }, 180000);


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
    
  function edit_stats(id){ 
    // webcam();
    save_method = 'update';
    $('#form1')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('clients/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            var group_id = (data.group_id != null)?data.group_id.split(','):'';
            console.log(group_id);
            $('[name="id"]').val(data.id); 
            $('[name="fname"]').val(data.fname); 
            $('[name="lname"]').val(data.lname); 
            $('[name="mname"]').val(data.mname); 
            $('[name="address"]').val(data.address); 
            $('[name="update_provCode"]').val(data.provCode);
            $('[name="update_provCode"]').select2().trigger('update_provCode'); 
            update_mun(data.provCode,data.citymunCode,data.brgyCode);
            $('[name="update_citymunCode"]').val(data.citymunCode);
            $('[name="update_citymunCode"]').select2().trigger('update_citymunCode');
            $('[name="update_brgyCode"]').val(data.brgyCode);
            $('[name="update_brgyCode"]').select2().trigger('update_brgyCode');
            $('[name="birthday"]').val(data.birthday);
            $('[name="contact_number"]').val(data.contact_number); 
            $('[name="sex"]').val(data.sex); 
            $('[name="sex"]').select2().trigger('sex');
            $('[name="username"]').val(data.username); 
            $('[name="qrcode"]').val(data.qrcode); 
            $('[name="pow"]').val(data.pow); 
            $('[name="image_path"]').val(data.image_path); 
            if(data.oddeven_exemption == 1){
              $( "#oddeven_exemption" ).prop( "checked", true );
            }else{
              $( "#oddeven_exemption" ).prop( "checked", false );
            }
            $('#exemption').val(group_id).change();
            $("#results").html('<img src="<?php echo base_url(); ?>'+data.image_path+'" class="user-image" width="75%" height="75%">'); 
            $('#add_clients_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Update Client Data'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }

  function save(){
    // $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url; 
      if(save_method == 'update') {
          url = "<?php echo site_url('clients/ajax_update')?>";
      }  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form1').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            $('#add_clients_modal').modal('hide');
            reload_table();
              $('#btnSave').text('Save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
                if(save_method == 'update') {
                  $('#update_message').html('Client Account Successfully Updated').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().fadeOut();
                }  
          else{
            for (var i = 0; i < data.inputerror.length; i++){
              $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
              $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
              $('#btnSave').attr('disabled',true).fadeIn().delay(2000); //set button disable 
              $('#btnSave').attr('disabled',false); //set button disable
            } 
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
  } 

  function update_stats(id){  
    save_method = 'update';
    $('#form_status')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url : "<?php echo site_url('clients/ajax_edit/')?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        $('[name="cs_id"]').val(data.id); 
        $('[name="view_fname"]').val(data.fname); 
        $('[name="view_lname"]').val(data.lname); 
        $('[name="view_mname"]').val(data.mname);  
        $('[name="view_birthday"]').val(data.birthday); 
        $('[name="status"]').val(data.status);
        $('#former_status').val(data.status);
        $('[name="status"]').select2().trigger('status'); 
        $('[name="view_image_path"]').val(data.image_path); 
        $("#view_results").html('<img src="<?php echo base_url(); ?>'+data.image_path+'" class="user-image" width="75%" height="75%" style="position: relative; margin-left:-300px;">');
        // $('[name="bdate"]').datepicker('update',data.bdate); 
        $('#status_modal').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Update Status'); // Set title to Bootstrap modal title
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error get data from ajax');
      }
    });
  }

  function save_status(){
    var url; 
      if(save_method == 'update') {
          url = "<?php echo site_url('clients/ajax_update_status')?>";
      }  
    var id = $('#cs_id').val();
    var status = $('#status').val();
    var validate_password = $('#validate_password').val();
    var password = $('#password').val();
    var date = $('#date_changed').val();
    var encoder = $('#encoder').val();
    var end_quarantine = $('#end_quarantine').val();
    var former_status = $('#former_status').val();

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {id:id, status:status,date:date, validate_password:validate_password, password:password,encoder:encoder,end_quarantine:end_quarantine, former_status:former_status },
          dataType: "JSON",
          success: function(data)
          {
            if(data.status != false) //if success close modal and reload ajax table
            {
              $('#status_modal').modal('hide');
              $('#confirm_update_modal').modal('hide');
              reload_table();
              if(save_method == 'update') {
                $('#update_message').html('Client Status Updated Successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().fadeOut();
              } 
              $('#validate_password').attr("type","password");
              $('#showhide').text('Show');
              $('#eye').addClass('fa-eye');
              $('#eye').removeClass('fa-eye-slash');
            }
            else{
             alert('Incorrect Password!'); 
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave_status').text('save'); //change button text
              $('#btnSave_status').attr('disabled',false); //set button enable 

          }
      });
  }

  function inactive_client(id){
    if(confirm('Are you sure inactive this client?')){
      // ajax delete data to database
      $.ajax({
        url : "<?php echo site_url('clients/ajax_inactive')?>/"+id,
        type: "POST",
        dataType: "JSON",
          success: function(data){
            //if success reload ajax table 
            $('.alert-danger').html('Client Account Deactivated Successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
          }
        });

    }
  }

  function delete_client(id){
    if(confirm('Are you sure delete this client?')){
      // ajax delete data to database
      $.ajax({
        url : "<?php echo site_url('clients/ajax_delete')?>/"+id,
        type: "POST",
        dataType: "JSON",
          success: function(data){
            //if success reload ajax table 
            $('.alert-danger').html('Client Account Deleted successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
          }
        });

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
          else{
                  municipality_list ="<option value='' selected>ALL</option>";
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
              municipality_list += "<option value=''>ALL</option>";
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
                  console.log(val.brgyCode === selected);
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

  function view_status(id){
    $.ajax({
    url : "<?php echo site_url('clients/view_status')?>/",
    type: "POST",
    data: {id:id},
    dataType: "JSON",
    success: function(data)
    {
      var row='';
      $('#status_title').html('Status History: '+data[0].fullname);
      $.each(data, function(i, val) {
        if(val.stats_id!=null){
          row+=`<tr>
                  <td>${val.status}</td>
                  <td>${val.date_changed}</td>
                  <td>${val.end_quarantine}</td>
                  <td>${val.ufullname}</td>
                  <td><a id="update_eoq" href="javascript:void(0)" title="Update End of end quarantine" 
                      stats_id="${val.stats_id}"
                      eoq = "${val.end_quarantine}"
                      soq = "${val.date_changed}"
                      status = "${val.status}"
                      client_id = "${val.client_id}"
                      >
                    <i class="fa fa-edit"></i>
                    </a></td>
                </tr>
              `;
          }
      });
      $('#status_tbody').html(row);
      $('#view_status_modal').modal('show');
    }
  });
}

  $(document).ready(function(){
    $('#update_message').hide();

  $('#showpass').click(function(){
    if($('#validate_password').attr('type') == 'password' ){
      $('#validate_password').attr("type","text");
      $('#showhide').text('Hide');
      $('#eye').removeClass('fa-eye');
      $('#eye').addClass('fa-eye-slash');
    }else{
      $('#validate_password').attr("type","password");
      $('#showhide').text('Show');
      $('#eye').addClass('fa-eye');
      $('#eye').removeClass('fa-eye-slash');
    }
  })

    $('#btnSave_status').click(function(e){
      e.preventDefault();
      var fname = $('#view_fname').val();
      var lname = $('#view_lname').val();
      var mname = $('#view_mname').val();
      var end_quarantine = $('#end_quarantine').val();
      var birthday = $('#view_birthday').val();
      var status = $('#status').find(":selected").text();
      $('#validate_password').val('');
      $('#confirm_title').html('Confirm Status Update');
      $('#fname_c').html(fname);
      $('#lname_c').html(lname);
      $('#mname_c').html(mname);
      $('#eoq_c').html(convert_date(end_quarantine));
      $('#birthday_c').html(birthday);
      $('#to_status').html(status);
      $('#confirm_update_modal').modal('show');
    })

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

    $('#table').on('click','#view_status', function(){
      var id = this.getAttribute("client_id");
      view_status(id);
    });

    $('#status_tbody').on('click','#update_eoq', function(){
      var stats_id = this.getAttribute("stats_id");
      var eoq = this.getAttribute("eoq");
      var soq = this.getAttribute("soq");
      var status = this.getAttribute("status");
      var client_id = this.getAttribute("client_id");
      $('#eoq_update').val(eoq);
      $('#client_id_update').val(client_id);
      $('#stats_id').val(stats_id);
      $('#soq_col').html(soq);
      $('#status_col').html(status);
      $('#update_eoq_modal').modal('show');
    });

    $('#update_eoq_btn').click(function(){
      var stats_id = $("#stats_id").val();
      var eoq_update = $("#eoq_update").val();
      var id = $("#client_id_update").val();
      $.ajax({
        url : "<?php echo site_url('clients/update_eoq')?>/",
        type: "POST",
        data: {stats_id:stats_id,eoq_update:eoq_update,id:id},
        dataType: "JSON",
        success: function(data)
        {
          view_status(id);
          reload_table();
          $('#eoq_message').html('End of Quarantine Updated');
          $('#update_eoq_modal').modal('toggle');
        }
      })
    })
});
</script>
