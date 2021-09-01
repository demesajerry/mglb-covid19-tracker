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
                          <th width="30%">Address</th>
                          <th width="10%">Birthday</th>
                          <th width="5%">Contact</th>
                          <th width="5%">Status</th>
                          <th width="5%">Action</th>
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

<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="modal_title"></p>
        </h4>
      </div>
              
      <!-- Modal Body For View -->
      <div class="modal-body"> 
        <form method="POST" id="form_status" class="form-horizontal" role="form">
          <input type="hidden" name="cs_id" id="cs_id">
            <table class="table table-bordered table-hover">  
              <tr>
                <td colspan="3">Valid ID Presented :</td>
              </tr>
              <tr>
                <td colspan="3">
                  <div class="col-sm-12">
                    <div class="col-sm-6"> 
                      <input type="hidden" name="view_image_path" id="view_image_path" class="image-tag2">
                    </div>
                    <div class="col-sm-6">
                      <div id="view_results"> </div> 
                      <div class="full_name">
                        First Name: <input type="text" name="view_fname" id="view_fname" class="form-control uppercase" disabled=""/>
                        Last Name: <input type="text" name="view_lname" id="view_lname" class="form-control uppercase" disabled=""/>
                        Middle Name:<input type="text" name="view_mname" id="view_mname" class="form-control uppercase" disabled="" />
                        Birthdate: <input type="date" name="view_birthday" id="view_birthday"  class="form-control" disabled>
                      </div>
                    </div>
                  </div>
                </td>
              </tr> 
              <tr>
                <td>
                    Status: 
                    <select name="status" id="status" class="form-control select2" style="width: 100%;">
                      <option value="0" selected disabled>Select Status</option>
                      <?php
                        foreach ($status_list as $status) {
                      ?>
                      <option value="<?= $status->c_status_id ?>"> <?= $status->c_classification ?></option> 
                      <?php    
                        }
                      ?>
                    </select>
                </td> 
                <td>
                  Status Date:
                  <input type="text" name="date_changed" id="date_changed" class="birthday form-control" value="<?= date('Y-m-d'); ?>">
                </td>
              </tr>
              <tr> 
                <td><input type="hidden" name="password" id="password"  class="form-control" value="<?= $userdata->password ?>"></td> 
                <td><input type="hidden" name="encoder" id="encoder" value="<?=$userdata->userid?>" class="form-control"></td> 
              </tr>
            </table>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button> 
                <button id="btnSave_status" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; UPDATE</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<div class="modal fade" id="add_clients_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="modal_title"></p>
        </h4>
      </div>
              
      <!-- Modal Body For Update -->
      <div class="modal-body"> 
        <form method="POST" id="form1" class="form-horizontal" role="form">
          <input type="hidden" name="id" id="id">
            <table class="table table-bordered table-hover">
              <tr>
                <td>First Name: <input type="text" name="fname" id="fname" class="form-control uppercase" required="required"/></td>
                <td>Last Name: <input type="text" name="lname" id="lname" class="form-control uppercase" required="required"/></td>
                <td>Middle Name:<input type="text" name="mname" id="mname" class="form-control uppercase"/></td>
              </tr> 
              <tr> 
                <td colspan="3">Client Address:<br><input type="text" name="address" id="address" placeholder="House No./Street" class="form-control" required="required"/></td>
              </tr> 
              <tr>
                <td>Province: <br>
                  <select id="update_provCode" name="update_provCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select Province</option>
                    <?php foreach($prov_list as $prov){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                    <?php } ?>
                  </select>
                </td>
                <td>Municipality:  <br>  
                  <select id="update_citymunCode" name="update_citymunCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select City / Municipality</option>
                    <?php foreach($municipality_list as $mun){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                    <?php } ?>
                  </select> 
                </td> 
                <td>Brgy: <br>
                  <select id="update_brgyCode" name="update_brgyCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select Brgy</option>
                    <?php foreach($brgy_list as $val){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr> 
                <td>Birthdate: <input type="text" name="birthday" id="birthday"  class="form-control birthday" required="required"/></td>
                <td>Contact Number: <input type="text" name="contact_number" id="contact_number"  class="form-control" required="required"/></td>
                <td>Gender: 
                  <select id="sex" name="sex" class="form-control select2" required="required" style="width:100%;">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                  </select>  
                </td>
              </tr>
              <tr> 
                 <td colspan="1">username :<br><input type="text" name="username" id="username" class="form-control" required readonly=""></td>
                 <td colspan="1">QR Code :<br><input type="text" name="qrcode" id="qrcode" class="form-control uppercase" required></td>
                 <td colspan="1">Place of Work :<br><input type="text" name="pow" id="pow" class="form-control uppercase" required></td>
              </tr>   
              <tr>
                <td colspan="2">Attached Valid ID:</td>
                <td colspan="1">
                  <div class="form-check">
                    <input type="checkbox" name="oddeven_exemption" class="form-check-input" id="oddeven_exemption" value="1">
                    <label class="form-check-label" for="oddeven_exemption">Odd-Even Exemption</label>
                  </div>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <div class="col-sm-12">
<!--                                       <div class="col-sm-6">
                      <div id="my_camera"></div>
                      <br/>
                      <input type=button value="Capture Photo" class="btn btn-info" onClick="take_snapshot()">
                      <input type="hidden" name="image_path" id="image_path" class="image-tag">
                    </div>
-->                                      <div class="col-sm-12">
                      <div id="results"></div>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button>
                <button id="btnVerify" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Verify</button>
                <button id="btnDisable" class="btn btn-danger pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Disable</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

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
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "iDisplayLength": 10,
      // dom: 'Blfrtip',
      select: true,
      // "buttons":[
      //   {
      //     extend: 'print',
      //     text: 'Print all',
      //     title:"Clients List",
      //     messageTop:"",
      //     exportOptions:{
      //       columns: [ 0, 1, 2, 3, 4, 5],
      //         modifier: {
      //           selected: null
      //         },
      //     }
      //   },
      //   {
      //     extend: 'print',
      //     text: 'Print Selected',
      //     title:"Clients List",
      //     messageTop:"",
      //     exportOptions:{
      //       columns: [ 0, 1, 2, 3, 4, 5],
      //         modifier: {
      //           selected: true
      //         },
      //       }
      //   },
      //   {
      //     extend: 'pdf',
      //     text: 'Pdf',
      //     title:"Clients List", 
      //     exportOptions:{
      //       columns:[ 0, 1, 2, 3, 4, 5],
      //         modifier: {
      //           selected: null
      //         },
      //       }
      //   },
      //   {
      //     extend: 'excel',
      //     text: 'Excel',
      //     title:"Clients List",
      //     exportOptions:{
      //       columns: [ 0, 1, 2, 3, 4, 5],
      //         modifier: {
      //           selected: null
      //       },
      //     }
      //   },
      // ],
      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('clients/verify_list')?>",
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
            if(data.oddeven_exemption==1){
              $('#oddeven_exemption').prop( "checked", true );
            }else{
              $('#oddeven_exemption').prop( "checked", false );
            }
            $('[name="id"]').val(data.id); 
            $('[name="fname"]').val(data.fname); 
            $('[name="lname"]').val(data.lname); 
            $('[name="mname"]').val(data.mname); 
            $('[name="address"]').val(data.address); 
            $('[name="update_provCode"]').val(data.provCode);
            $('[name="update_provCode"]').select2().trigger('update_provCode'); 
            $('[name="update_citymunCode"]').val(data.citymunCode);
            $('[name="update_citymunCode"]').select2().trigger('update_citymunCode');
            update_brgy(data.citymunCode,data.brgyCode);
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

  function save(verify,active){
    var url; 
    if(save_method == 'update') {
        url = "<?php echo site_url('clients/ajax_update')?>";
    }  
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form1').serialize()+'&verify=' + verify+'&active=' + active,
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
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: {id:id, status:status,date:date, validate_password:validate_password, password:password,encoder:encoder },
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

  $(document).ready(function(){
    $('#update_message').hide();
    $('#btnVerify').click(function(e){
      e.preventDefault();
      save(1,1);
    });

    $('#btnDisable').click(function(e){
      e.preventDefault();
      save(0,0);
    });

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
      var birthday = $('#view_birthday').val();
      var status = $('#status').find(":selected").text();
      $('#validate_password').val('');
      $('#confirm_title').html('Confirm Status Update');
      $('#fname_c').html(fname);
      $('#lname_c').html(lname);
      $('#mname_c').html(mname);
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
});
</script>
