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
                          <th width="25%">Full Name</th>
                          <th width="25%">Address</th>
                          <th width="10%">Birthday</th>
                          <th width="5%">Contact</th>
                          <th width="5%">Duplicate Count</th>
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
<script type="text/javascript"> 
  var save_method; //for save method string
  var table, table_dup;
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
            $("input[name=active][value='"+data.active+"']").prop("checked",true);
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

  function view_dup(fname,lname){ 
    //Ajax Load data from ajax
    $.ajax({
        url : "<?php echo base_url('duplicate_clients/search')?>",
        type: "POST",
        data:{fname:fname,lname:lname},
        dataType: "JSON",
        success: function(data)
        {
          table_dup.clear().draw();
          $.each(data.data, function(key, val){
            if(val.is_disable == 0){
              var is_disable = `<a id="disable_vac" href="#" title="Disable vaccination details"
                                  vac_id="${val.vac_id}">
                                  <i class="fa fa-toggle-on"></i> 
                                </a>`;
            }else{
              var is_disable = `<a id="enable_vac" href="#" title="Enable vaccination details"
                                  vac_id="${val.vac_id}">
                                  <i class="fa fa-toggle-off"></i> 
                                </a>`;
            }
              var rowNode = table_dup.row.add([
                            val.id, 
                            val.lname, 
                            val.fname,
                            val.mname,
                            `<a id="View Details" href="#" title="View Details"
                              onClick="edit_stats('${val.id}')">
                              <i class="fa fa-eye"></i> 
                            </a> |
                            <a id="Update_vac" href="#" title="Update Vaccination"
                              onClick="update_vac('${val.id}')">
                              <i class="fa fa-syringe"></i> 
                            </a> |${is_disable}
                             
                            `
                            ]).node();
          })
          table_dup.draw();
          $('#list_dup').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
  }

  function disable_vac(vac_id){
    if(confirm('Confirm Disable vaccination details.')){
    $.ajax({
      url : "<?php echo base_url('duplicate_clients/disable_vaccination')?>",
      type: "POST",
      data:{vac_id:vac_id},
      dataType: "JSON",
      success: function(data)
      {
        view_dup(data.fname,data.lname);
        toastr.success('Vaccination Details has been DISABLED!');
      }
    });
  }
  }

  function enable_vac(vac_id){
    if(confirm('Confirm enable vaccination details.')){
    $.ajax({
      url : "<?php echo base_url('duplicate_clients/enable_vaccination')?>",
      type: "POST",
      data:{vac_id:vac_id},
      dataType: "JSON",
      success: function(data)
      {
        view_dup(data.fname,data.lname);
        toastr.success('Vaccination Details has been ENABLED!');
      }
    });
  }
  }

  function update_vac(userid){
    $('#formvac').trigger('reset');
    $.ajax({
      url : "<?php echo base_url('duplicate_clients/search_vac')?>",
      type: "POST",
      data:{userid:userid},
      dataType: "JSON",
      success: function(data)
      {
        if(data.data!=false){
          $('#userid_orig').val(data.data[0].userid);
          $('#userid').val(data.data[0].userid);
          $('#vac_fname').html(data.data[0].fname);
          $('#vac_lname').html(data.data[0].lname);
          $('#vac_mname').html(data.data[0].mname);
          data.data_post != false?$('#with_postvac').html('YES'):$('#with_postvac').html('NO');
          $('#date_reg').html(data.data[0].date_reg);
          $('#list_vac').modal('show');
        }else{
          alert('No Pre-vaccination record');
        }
      }
    });
  }

  $(document).ready(function(){
    $('#exempted_clients').on('click','#disable_vac', function(){
      var vac_id = this.getAttribute("vac_id");
      disable_vac(vac_id);
    })

    $('#exempted_clients').on('click','#enable_vac', function(){
      var vac_id = this.getAttribute("vac_id");
      enable_vac(vac_id);
    })

    table_dup =  $('#exempted_clients').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
     "ordering": false,
     'sorting': false,
      "aaSorting": []
    });

    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      responsive: true,
      "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
      "iDisplayLength": 10,
      // dom: 'Blfrtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('Duplicate_clients/duplicate_list')?>",
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
          "targets": [ 5 ], //first column / numbering column
          "orderable": true, //set not orderable
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

      $('#btn-reset').click(function(e){ //button reset event click
        $('#form-filter')[0].reset();
        table.ajax.reload();  //just reload table  
          $('#provCode').select2().val("0"); 
          $('#citymunCode').select2().val("0"); 
          $('#brgyCode').select2().val("0"); 
          $('#status_filter').select2().val("0"); 
      });    
  }); 

  function disable(id){

  }

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
          toastr.success('Data has been updated!');
          view_dup(data.fname,data.lname);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled',false); //set button enable 

        }
    });
  } 

  $(document).ready(function(){
    $('#btn-updateVac').click(function(){
      var userid = $('#userid').val();
      var userid_orig = $('#userid_orig').val();
      $.ajax({
        url : "<?= base_url() ?>Duplicate_clients/update",
        type: "POST",
        data: {userid:userid, userid_orig:userid_orig},
        dataType: "JSON",
        success: function(data)
        {
          toastr.success('Data has been updated!');
          view_dup(data[0].fname,data[0].lname);
        }
      });
    })

    $('#update_message').hide();

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
<?php  $this->load->view('clients/modal/duplicate_clients'); ?>
