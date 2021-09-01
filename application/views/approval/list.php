<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.min.css">
<style type="text/css">
  .full_name{
    margin: -180px 0 40px 50px;
  }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        For Approval
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
                                  <option value="">All</option>
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
                  <div class="alert alert-info" style="display: none; width: 900px;">
                      
                  </div>
                  
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
              <div class="box-body table-responsive">
                  <div class="modal fade" id="update_registration_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                          <form method="POST" id="form_update_registration" class="form-horizontal" role="form">
                            <input type="hidden" name="id" id="id">
                              <table class="table table-bordered table-hover">
                                <tr>
                                  <td>First Name: <input type="text" name="fname" id="fname" class="form-control uppercase" required="required"/ disabled></td>
                                  <td>Last Name: <input type="text" name="lname" id="lname" class="form-control uppercase" required="required"/ disabled></td>
                                  <td>Middle Name:<input type="text" name="mname" id="mname" class="form-control uppercase"/ disabled></td>
                                </tr> 
                                <tr> 
                                  <td colspan="3">Client Address:<br><input type="text" name="address" id="address" placeholder="House No./Street" class="form-control" required="required"/ disabled></td>
                                </tr> 
                                <tr>
                                  <td>Province: <br>
                                    <select id="update_provCode" name="update_provCode" class="form-control select2" required="required" style="width: 100%;" disabled>
                                      <option value="" disabled selected>Select Province</option>
                                      <?php foreach($prov_list as $prov){ ?>
                                      <!--Initial selected is LAGUNA ProvCode=0434-->
                                        <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                                      <?php } ?>
                                    </select>
                                  </td>
                                  <td>Municipality:  <br>  
                                    <select id="update_citymunCode" name="update_citymunCode" class="form-control select2" required="required" style="width: 100%;" disabled>
                                      <option value="" disabled selected>Select City / Municipality</option>
                                      <?php foreach($municipality_list as $mun){ ?>
                                      <!--Initial selected is LAGUNA ProvCode=0434-->
                                        <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                                      <?php } ?>
                                    </select> 
                                  </td> 
                                  <td>Brgy: <br>
                                    <select id="update_brgyCode" name="update_brgyCode" class="form-control select2" required="required" style="width: 100%;" disabled>
                                      <option value="" disabled selected>Select Brgy</option>
                                      <?php foreach($brgy_list as $val){ ?>
                                      <!--Initial selected is LAGUNA ProvCode=0434-->
                                        <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                                      <?php } ?>
                                    </select>
                                  </td>
                                </tr>
                                <tr> 
                                  <td>Birthdate: <input type="date" name="birthday" id="birthday"  class="form-control" required="required"/ disabled></td>
                                  <td>Contact Number: <input type="text" name="contact_number" id="contact_number"  class="form-control" required="required"/ disabled></td>
                                  <td>Gender: 
                                    <select id="sex" name="sex" class="form-control select2" required="required" style="width:100%;" disabled>
                                      <option value="" disabled selected>Select Gender</option>
                                      <option value="1">Male</option>
                                      <option value="0">Female</option>
                                    </select>  
                                  </td>
                                </tr>
                                <tr> 
                                   <td colspan="3">Place of Work:<br><input type="text" name="pow" id="pow" class="form-control uppercase" required disabled></td>
                                </tr>   
                                <tr>
                                  <td colspan="3">Client Photo :</td>
                                </tr>
                                <tr>
                                  <td colspan="3">
                                    <div class="col-sm-12">
                                      <div class="col-sm-6">
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
                                  <button id="btnSave" onclick="save()" class="btn btn-success pull-right"><i class="fa fa-check fa-lg"></i>&nbsp; Approve</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div><!--end Modal body-->
                      </div><!--end Modal content-->
                    </div><!--end Modal dialog-->
                  </div><!--end modal receive-->
                <hr /> 
              </div>

              <div class="box-body table-responsive">
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
                                  <td colspan="3">Client Photo :</td>
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
                                  <td><font color="red">Re-enter your Password: </font>
                                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Password" class="form-control" required="required" required="required" minlength="6"  style="width: 100%;" onkeyup='pass();'>
                                    <span id='message' style="position: absolute;"></span>
                                  </td>
                                  <td>
                                      Status: 
                                      <select name="status" id="status" class="form-control select2" style="width: 100%;" disabled>
                                        <option value="0" selected disabled>Select Status</option>
                                        <option value="">All</option>
                                        <?php
                                          foreach ($status_list as $status) {
                                        ?>
                                        <option value="<?= $status->c_status_id ?>"> <?= $status->c_classification ?></option> 
                                        <?php    
                                          }
                                        ?>
                                      </select>
                                  </td> 
                                </tr> 
                                  <td><input type="text" name="password" id="password"  class="form-control"></td> 
                                  <td><input type="hidden" name="encoder" id="encoder" value="<?=$userdata->fullname?>" class="form-control"></td> 
                                </tr>
                              </table>
                            <!--SUBMIT BUTTON -->
                            <div class="modal-footer" align="right">
                              <div class="form-group">
                                <div class="col-sm-12" align="right">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">
                                    <i class="fa fa-times fa-lg"></i>&nbsp; Close
                                  </button> 
                                  <button id="btnSave_status" onclick="save_status()" class="btn btn-success pull-right" disabled><i class="fa fa-save fa-lg"></i>&nbsp; UPDATE</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div><!--end Modal body-->
                      </div><!--end Modal content-->
                    </div><!--end Modal dialog-->
                  </div><!--end modal receive-->
                <hr /> 
              </div> 
          </div>
        </div>
      </div>
    </section>

</div>
<script type="text/javascript"> 
  var save_method; //for save method string
  var table;
   
  $(document).ready(function() {
    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "iDisplayLength": 10,
      dom: 'Blfrtip',
      select: true,
      "buttons":[
        {
          extend: 'print',
          text: 'Print all',
          title:"For Approval List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4, 5],
              modifier: {
                selected: null
              },
          }
        },
        {
          extend: 'print',
          text: 'Print Selected',
          title:"For Approval List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4, 5],
              modifier: {
                selected: true
              },
            }
        },
        {
          extend: 'pdf',
          text: 'Pdf',
          title:"For Approval List", 
          exportOptions:{
            columns:[ 0, 1, 2, 3, 4, 5],
              modifier: {
                selected: null
              },
            }
        },
        {
          extend: 'excel',
          text: 'Excel',
          title:"For Approval List",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4, 5],
              modifier: {
                selected: null
            },
          }
        },
      ],
      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('approval/ajax_list')?>",
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
</script>

<script type="text/javascript">
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
    
  function approve_registration(id){ 
    save_method = 'update';
    $('#form_update_registration')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo site_url('approval/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {

            $('[name="id"]').val(data.id); 
            $('[name="fname"]').val(data.fname); 
            $('[name="lname"]').val(data.lname); 
            $('[name="mname"]').val(data.mname); 
            $('[name="address"]').val(data.address); 
            $('[name="update_provCode"]').val(data.provCode);
            $('[name="update_provCode"]').select2().trigger('update_provCode'); 
            $('[name="update_citymunCode"]').val(data.citymunCode);
            $('[name="update_citymunCode"]').select2().trigger('update_citymunCode');
            $('[name="update_brgyCode"]').val(data.brgyCode);
            $('[name="update_brgyCode"]').select2().trigger('update_brgyCode');
            $('[name="birthday"]').val(data.birthday);
            $('[name="contact_number"]').val(data.contact_number); 
            $('[name="sex"]').val(data.sex); 
            $('[name="sex"]').select2().trigger('sex');
            $('[name="pow"]').val(data.pow); 
            $('[name="image_path"]').val(data.image_path); 
            $("#results").html('<img src="<?php echo base_url(); ?>assets/images/client_photo/client'+id+'.jpg?<?php echo time(); ?>" class="user-image" width="250px" height="190px">'); 
            $('#update_registration_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Approve Registration'); // Set title to Bootstrap modal title

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
          url = "<?php echo site_url('approval/ajax_update')?>";
      }  

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form_update_registration').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            $('#update_registration_modal').modal('hide');
            reload_table();
              $('#btnSave').text('Approve'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable
                if(save_method == 'update') {
                  $('.alert-info').html('Client Registration Approved').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
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
            $('#btnSave').text('Approve'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
  } 

</script> 
<script type="text/javascript">
var pass = function() {

  if (document.getElementById('confirm_password').value == document.getElementById('password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '<i class="glyphicon glyphicon-ok-sign"></i>Password Matched';
      document.getElementById("status").disabled = false;
      document.getElementById("btnSave_status").disabled = false;
      document.getElementById("status").required = true; 
  } 
  else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = '<i class="fa fa-exclamation-circle"></i>Password Did Not Matched!';
      document.getElementById("status").disabled = true;
      document.getElementById("btnSave_status").disabled = true;
      document.getElementById("status").required = false; 
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
                jQuery.each(data, function(i, val) {
                    brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
                });
            }
        },
        complete: function (data) {
  //$("#brgyCode").html(brgy_list);
        }
      });
    }else{
      brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
      $("#brgyCode").html(brgy_list);
    }
  }
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
});
</script>