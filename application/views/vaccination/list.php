<link rel="stylesheet" href="<?=base_url();?>assets/bower_components/select2/dist/css/select2.min.css">
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
.btn-xs {
    border-radius: 80%;
    height: 1.5rem;
    width: 1.5rem;
    font-size: .7rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-folder"></i> Vaccination Client List</h1>
    </div>
    <!-- Content Row -->
    <div class="row" id="main_div">
      <div class="col-md-12 mb-4">
      <form id="form-filter" class="form-horizontal">
          <div class="row">
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

            <div class="col-sm-2">
              <label>Step</label>
                <select name='status_filter' id='status_filter' class="form-control select2">
                  <option value="" selected disabled>Select Status</option>
                  <option value="0" >For Verification</option>
                  <option value="1" >For Post Vaccination</option>
                </select>  
            </div>

<!--             <div class="col-sm-2">
              <label>Vaccine Status</label>
                <select name='is_vaccinated' id='is_vaccinated' class="form-control select2">
                  <option value="0" >Not Yet Vaccinated</option>
                  <option value="1" >Vaccinated</option>
                </select>  
            </div>
 -->
            <div class="col-sm-2">
              <label>Dose</label>
                <select name='dose' id='dose' class="form-control select2">
                  <option value="" selected disabled>Select Status</option>
                  <option value="1" >First Dose</option>
                  <option value="2" >Second Dose</option>
                </select>  
            </div>
<!--             <div class="col-md-10">
            </div>
 -->            <div class="col-md-2">
              <br>
              <button type="button" id="btn-reset" class="btn btn-primary btn-sm"><i class='fa fa-undo'></i> &nbsp; Reset</button>
              <button type="button" id="btn-filter" class="btn btn-primary btn-sm"><i class='fa fa-filter'></i> &nbsp; Filter</button>
                <button class="search-qrcode btn btn-success btn-sm" type="button" id="openreader-multi" 
                  data-qrr-target="#qrcode" ><i class="fa fa-search"></i> 
                  Scan
                </button>          
              </div>
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
<!--                           <th width="5%">USERID</th>
 -->                          <th width="15%">Full Name</th>
                          <th width="15%">Address</th>
                          <th width="5%">Category Selected</th>
                          <th width="5%">Age</th>
                          <th width="5%">With Comorbidity</th>
                          <th width="7%">Birthday</th>
                          <th width="5%">Contact</th>
                          <th width="5%">Registration date</th>
                          <th width="8%">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody> 
                </table>
                <hr /> 
      <!-- /.container-fluid -->
    </div>
  </div>
</div>
<?php  $this->load->view('vaccination/modal/list'); ?>
<script type="text/javascript"> 
  var save_method; //for save method string
  var table;

  $(document).ready(function(){
    $('#table').on('click','.validate', function(e){
      e.preventDefault();
      var client_id = this.getAttribute('client_id');
      window.open(`<?= base_url(); ?>Vac_list/view_details/${client_id}/1`, '_blank');
    })

    $('#table').on('click','.dose_detail', function(e){
      e.preventDefault();
      var client_id = this.getAttribute('client_id');
      var dose = this.getAttribute('dose');
      window.open(`<?= base_url(); ?>Vac_list/view_details/${client_id}/2/${dose}`, '_blank');
    })

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
      "columnDefs": [
        { "orderable": false, targets: [1,2,3,4,6] }
      ],
      "order": [[5, 'asc']],
      "bFilter": true,
      "searchable":true,
      responsive: true,
      "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
      "iDisplayLength": 10,
      // dom: 'Blfrtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('Vac_list/ajax_list')?>",
        "type": "POST",
        "data": function ( data ) {
          data.provCode = $('#provCode').val();
          data.citymunCode = $('#citymunCode').val();
          data.brgyCode = $('#brgyCode').val();
          data.status_filter = $('#status_filter').val();
          data.is_vaccinated = $('#is_vaccinated').val();
          data.dose = $('#dose').val();
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
        if(data[2]=='A2' && parseInt(data[3]) < 60){
          $(row).find('td:eq(2)').addClass("bg-gradient-warning");
          $(row).find('td:eq(3)').addClass("bg-gradient-warning");
        }
    }
    });

   $('#table_filter input').unbind();
   $('#table_filter input').bind('keyup', function(e) {
      if(e.keyCode == 13) {
        table.search(this.value).draw();   
      }
  });

    $('#btn-filter').click(function(){ //button filter event click
     table.ajax.reload();
     }); 

    //refresh the table every 20 seconds
    // setInterval(function(){
    //   table.ajax.reload(null,false); //reload datatable ajax 
    // }, 180000);


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
    url : "<?php echo site_url('Vac_list/view_status')?>/",
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


      $('#btn-reset').click(function(e){ //button reset event click
        $('#form-filter')[0].reset();
          table.ajax.reload();  //just reload table  
          $('#provCode').select2().val(""); 
          $('#citymunCode').select2().val(""); 
          $('#brgyCode').select2().val(""); 
          $('#status_filter').select2().val(""); 
          $('#is_vaccinated').select2().val(""); 
          $('#dose').select2().val(""); 
          $('#table_filter input').val('');
          table.search('').draw();   
      });  

    $('#table').on('click','.disable', function(e){
      e.preventDefault();
      var client_id = this.getAttribute('client_id');
      var name = this.getAttribute('name');
      $('#client_id').val(client_id);
      $('#disable_display').html(`<h2>Are you sure you want to DISABLE ${name}</h2>`);
      $('#disable_modal').modal('show');
    })

    $('#confirm_disable').click(function(){
      var client_id = $('#client_id').val();
      $.ajax({
        url : "<?php echo site_url('vac_list/disable')?>/",
        type: "POST",
        data:{client_id:client_id},
        dataType: "JSON",
          success: function(data){
            //if success reload ajax table 
            toastr.success('Client has been disabled!');
            $('#disable_modal').modal('hide');
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown){
                alert('Error deleting data');
          }
        });
      })

    $('#table').on('click','.view_dose', function(e){
      var userid = this.getAttribute("client_id");
      var name = this.getAttribute("name");
        view_dose(userid)
      $('#dose_modal').modal('show');
    })

    $('#dose_display_tbody').on('click','.delete_dose', function(e){
      var dose_name = this.getAttribute("dose_name");
      var dose = this.getAttribute("dose");
      var userid = this.getAttribute("userid");
      var post_vac_id = this.getAttribute("post_vac_id");
      if(confirm('Are you sure you want to delete '+ dose)){
      $.ajax({
        url : "<?php echo site_url('Vac_list/delete_dose')?>",
        type: "POST",
        data:{userid:userid, dose:dose, post_vac_id:post_vac_id},
        dataType: "JSON",
          success: function(data){
            toastr.success(`Dose ${data} has been deleted`);
            view_dose(userid);
          }
        });
      }
    });

    $('#dose_display_tbody').on('click','.merge_dose', function(e){
      var post_vac_id = this.getAttribute("post_vac_id");
      var userid = this.getAttribute("userid");
      var dose = this.getAttribute("dose");
      var vac_date = this.getAttribute("vac_date");
      $('#post_vac_id').val(post_vac_id);
      $('#merge_dose').val(dose);
      $('#current_userid').val(dose);
      $('#vac_date').val(vac_date);
      $('#merge_modal').modal('show');
    });

    $('#confirm_merge').click(function(){
      var post_vac_id = $('#post_vac_id').val();
      var merge_userid = $('#merge_userid').val();
      var merge_dose = $('#merge_dose').val();
      var current_userid = $('#current_userid').val();
      var vac_date = $('#vac_date').val();
      $.ajax({
        url : "<?php echo site_url('Vac_list/merge_dose')?>",
        type: "POST",
        data:{post_vac_id:post_vac_id, merge_userid:merge_userid, dose:merge_dose, current_userid:current_userid,vac_date:vac_date},
        dataType: "JSON",
          success: function(data){
            toastr.success(`Dose ${data} has been Merged!`);
            $('#merge_modal').modal('hide');
            view_dose(current_userid);
          }
        });

    });

    function view_dose(userid){
      $('#dose_display_tbody').html('');
      $.ajax({
      url : "<?php echo site_url('Vac_list/get_doses')?>",
      type: "POST",
      data:{userid:userid},
      dataType: "JSON",
        success: function(data){
          $('#dose_title').html(`${name} Resbakuna Dose/s`);
          //if success reload ajax table 
          if(data){
            var tr = '', dose;
            $.each(data, function(i, val) {
              dose_name = '';
              if(val.first_dose=='01_Yes'){
                dose_name = '1st Dose'
                dose = 1;
              }
              if(val.second_dose=='01_Yes'){
                dose_name = '2nd Dose'
                dose = 2;
              }
              tr +=`<tr>
                      <td>${dose_name}</td>
                      <td>${val.manufacturer}</td>
                      <td>${convert_date_full(val.vac_date)}</td>
                      <td>${convert_date_full(val.date_added)}</td>
                      <td>
                          <button class="btn btn-xs btn-danger  delete_dose" 
                          userid="${val.userid}" 
                          post_vac_id="${val.post_vac_id}"
                          dose="${dose}"
                          dose_name="${dose_name}"
                          >
                            <i class="fa fa-trash"></i>
                          </button>
                          |
                          <button class="btn btn-xs btn-warning merge_dose" 
                          userid="${val.userid}" 
                          post_vac_id="${val.post_vac_id}"
                          dose="${dose}"
                          dose_name="${dose_name}"
                          vac_date="${val.vac_date}"
                          >
                            <i class="fa fa-compress"></i>
                          </button>
                      </td>
                    </tr>
                    `;
            });
            $('#dose_display_tbody').html(tr);
          }
          reload_table();
        },
        error: function (jqXHR, textStatus, errorThrown){
              alert('Error deleting data');
        }
      });
    }
});
</script>
<?php  $this->load->view('vaccination/qr-reader'); ?>
