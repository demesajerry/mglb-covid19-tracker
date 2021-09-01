 <style type="text/css">
  .full_name{
    margin: -180px 0 40px 50px;
  }
    hr.noborder{
    margin-top: 0 !important;
    margin-bottom: 0 !important;
        padding-right:0px !important;
    padding-left: .25rem !important;

  }
.alert, #alert-exempted{
    padding: 5px !important;
}
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Establishments
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Establishment List</li>
        </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
                    <div class="box-header">
                      <div class="box-tools">                         
                      </div>
                    </div>
                  <div class="alert alert-info" style="display: none; width: 900px;">
                  </div>

                  <div class="alert alert-danger" style="display: none; width: 900px;">
                  </div>
                  <button class="btn btn-info pull-right" id="m_exempBtn">Add Multiple Exemption</button>
                  <table id="table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">ID</th>
                          <th width="40%">Establishment Name/Location Description</th>
                          <th width="30%">Address</th>
                          <th width="10%">Conatct Person</th>
                          <th width="10%">Contact Number</th>
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
<script type="text/javascript"> 
  $('#alert-exempted').hide();
  var save_method; //for save method string
  var table;
   
  $(document).ready(function(){
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
          title:"Establishments List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4 ],
              modifier: {
                selected: null
              },
          }
        },
        {
          extend: 'print',
          text: 'Print Selected',
          title:"Establishments List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4],
              modifier: {
                selected: true
              },
            }
        },
        {
          extend: 'pdf',
          text: 'Pdf',
          title:"Establishments List", 
          exportOptions:{
            columns:[ 0, 1, 2, 3, 4],
              modifier: {
                selected: null
              },
            }
        },
        {
          extend: 'excel',
          text: 'Excel',
          title:"Establishments List",
          exportOptions:{
            columns: [ 0, 1, 2, 3, 4],
              modifier: {
                selected: null
            },
          }
        },
      ],
      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('admin/ajax_list')?>",
        "type": "POST",
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
    $('#change_password').change(function() {
      if($('#change_password').prop('checked')){
        $('#password').prop('disabled',false);
      }else{
        $('#password').prop('disabled',true);
      }
    });
    $("form").keypress(function(e) {
    //Enter key
      if (e.which == 13) {
        return false;
      }
    });  

  $('#table').on('click','#edit', function(){
    $('#change_password').prop('checked',false);
    $('#password').prop('disabled',true);
      var id = this.getAttribute("est_id");
      $('#id').val(id);
      save_method = 'update';
      $('#form1')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('Admin/ajax_edit/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('#name').val(data.name);
            $('#address').val(data.address);
            $('#provCode').val(data.provCode);
            $('#provCode').select2().trigger('');
            $('#citymunCode').val(data.citymunCode);
            $('#citymunCode').select2().trigger('');
            $('#brgyCode').val(data.brgyCode);
            $('#brgyCode').select2().trigger('');
            $('#username').val(data.username);
            $('#contact_person').val(data.contact_person);
            $('#contact_number').val(data.contact_number);
            $('#add_clients_modal').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Update Establishment Data'); // Set title to Bootstrap modal title
            if(data.oddeven_exemption == 1){
              $( "#oddeven_exemption" ).prop( "checked", true );
            }else{
              $( "#oddeven_exemption" ).prop( "checked", false );
            }
            if(data.uplb == 1){
              $( "#uplb" ).prop( "checked", true );
            }else{
              $( "#uplb" ).prop( "checked", false );
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error get data from ajax');
          }
      });
    })
 $('#btnSave').click(function(e){
  e.preventDefault();
    // $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable 
    var url; 
      if(save_method == 'update') {
          url = "<?php echo site_url('Admin/ajax_update')?>";
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
                  $('.alert-info').html('Establishment Account Successfully Updated').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
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
  }); 

  });
    
  function update_stats(id){  
    document.getElementById("status").disabled = true;
    document.getElementById("date_changed").disabled = true;
    document.getElementById("btnSave_status").disabled = true;
    document.getElementById('message').innerHTML = '';
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
        $("#view_results").html('<img src="<?php echo base_url(); ?>'+data.image_path+'" class="user-image" width="300px" height="190px" style="position: relative; margin-left:-300px;">');
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
  var confirm_password = $('#confirm_password').val();
      confirm_password = $.sha1(confirm_password);
  if (confirm_password == document.getElementById('password').value) {
      // $('#btnSave').text('saving...'); //change button text
      $('#btnSave_status').attr('disabled',true); //set button disable 
      var url; 
        if(save_method == 'update') {
            url = "<?php echo site_url('clients/ajax_update_status')?>";
        }  

      // ajax adding data to database
      $.ajax({
          url : url,
          type: "POST",
          data: $('#form_status').serialize(),
          dataType: "JSON",
          success: function(data)
          {
            if(data.status) //if success close modal and reload ajax table
            {
              $('#status_modal').modal('hide');
              reload_table();
                $('#btnSave_status').text('Save'); //change button text
                $('#btnSave_status').attr('disabled',false); //set button enable
                  if(save_method == 'update') {
                    $('.alert-info').html('Client Status Updated Successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
                  }  
            }
            else{
              for (var i = 0; i < data.inputerror.length; i++){
                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                $('#btnSave_status').attr('disabled',true).fadeIn().delay(2000); //set button disable 
                $('#btnSave_status').attr('disabled',false); //set button disable
              } 
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave_status').text('save'); //change button text
              $('#btnSave_status').attr('disabled',false); //set button enable 

          }
      });
    }else{
      alert('Something Went Wrong! Please do not bypass confirm password.');
    }
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

var pass = function() {
  var confirm_password = $('#confirm_password').val();
      confirm_password = $.sha1(confirm_password);
  if (confirm_password == document.getElementById('password').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '<i class="glyphicon glyphicon-ok-sign"></i>Password Matched';
      document.getElementById("status").disabled = false;
      document.getElementById("date_changed").disabled = false;
      document.getElementById("btnSave_status").disabled = false;
      document.getElementById("status").required = true; 
  } 
  else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = '<i class="fa fa-exclamation-circle"></i>Password Did Not Matched!';
      document.getElementById("status").disabled = true;
      document.getElementById("date_changed").disabled = true;
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
          $("#brgyCode").html(brgy_list);
        }
      });
    }else{
      brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
      $("#brgyCode").html(brgy_list);
    }
  }

  function update_mun(val,selected,brgy){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>General/update_municipality_list",
      dataType: "JSON",
      data:'update_provCode='+val,
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

  function update_brgy(val){
    if(val!=''){
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>General/update_brgy_list",
        dataType: "JSON",
        data:{update_citymunCode:val},
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
      update_brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
      $("#update_brgyCode").html(brgy_list);
    }
  }
  $(document).ready(function(){
    $('#table').on('click','#add_member', function(){
      var est_id = this.getAttribute("est_id");
      var est_name = this.getAttribute("est_name");
      $('.modal_title').html('Add '+est_name+' Member');
      $('.est_id').val(est_id);
      view_member(est_id);
      $('#member_modal').modal('show');
    })

    $('#table').on('click','#add_exemption', function(){
      var group_id = this.getAttribute("group_id");
      var est_name = this.getAttribute("est_name");
      $('#exemption_title').html('Odd-Even Scheme Exempted for '+est_name);
      $('#group_id').val(group_id);
      view_exempted(group_id);
      $('#exemption_modal').modal('show');
    })
    $('#table').on('click','#delete', function(){
      var est_id = this.getAttribute("est_id");
      if(confirm('Are you sure delete this establishment?')){
        // ajax delete data to database
        $.ajax({
          url : "<?php echo site_url('Admin/ajax_delete')?>/"+est_id,
          type: "POST",
          dataType: "JSON",
            success: function(data){
              //if success reload ajax table 
             //$('.alert-danger').html('Establishment Account Deleted successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
              reload_table();
              alert(data);
            },
            error: function (jqXHR, textStatus, errorThrown){
                  alert('Error deleting data');
            }
          });

      }
    })

    $('#exempted_clients').on('click','#delete_exemption', function(){
      var exemption_id = this.getAttribute("exemption_id");
      var group_id = $('#group_id').val();
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Admin/delete_client_exemption",
          dataType: "JSON",
          data:{exemption_id:exemption_id},
          success: function(data){
            view_exempted(group_id);
            $('#alert-exempted').show().html('Client has been removed from exemption.').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn().fadeOut();
            $('#exemp_client').val('').change();
          }
        });
    })

    $('#add_client').click(function(e){
      e.preventDefault();
      var client_id = $('#exemp_client').val();
      var group_id = $('#group_id').val();
      if(client_id!=null){
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Admin/add_client_exemption",
          dataType: "JSON",
          data:{client_id:client_id,group_id:group_id },
          success: function(data){
            view_exempted(group_id);
            $('#alert-exempted').show().html(' has been added to exempted clients.').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn().fadeOut();
            $('#exemp_client').val('').change();
          }
        });
      }else{
        alert('Please select Client');
      }
    });

    $('#madd_client').click(function(e){
      e.preventDefault();
      var client_id = $('#mexemp_client').val();
      var group_id = $('#mest_id').val();
      if(client_id!=null){
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Admin/multiple_client_exemption",
          dataType: "JSON",
          data:{client_id:client_id,group_id:group_id },
          success: function(data){
            $('#malert-exempted').show().html('Exemption Has been added').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn();
            $('#mexemp_client').val('').change();
          }
        });
      }else{
        alert('Please select Client');
      }
    });

    $('#add_memberBtn').click(function(e){
      e.preventDefault();
      var est_id = $('#gest_id').val();
      var group_id = $('.est_id').val();
      if(est_id!=null){
        $.ajax({
          type: "POST",
          url: "<?php echo base_url(); ?>Admin/add_member",
          dataType: "JSON",
          data:{group_id:group_id,est_id:est_id },
          success: function(data){
            view_member(group_id);
            $('#member_alert').show().html('Member has been added').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn();
            $('#gest_id').val('').change();
          }
        });
      }else{
        alert('Please select Client');
      }
    });

    $('#m_exempBtn').click(function(e){
      e.preventDefault();
      $('#mexemption_title').html('Odd-Even Scheme Exemption for Multiple Establishment');
      $('#m_exempt_modal').modal('show');
    });

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


 $("#exemp_client").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_clients",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      group_id: $('#group_id').val()
    };
   },
processResults: function (data) {
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

 $("#mexemp_client").select2({
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

$("#mest_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_est",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
    };
   },
processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.name,
                        id: item.group_id
                    }
                })
            };
        }
    }
 });

$("#gest_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_not_member",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      est_id: $('#parent_id').val(), // search term
    };
   },
processResults: function (data) {
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

function view_exempted(group_id){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url(); ?>Admin/get_exempted",
  dataType: "JSON",
  data:{group_id:group_id },
  success: function(data){ 
  table.clear().draw();
  $.each(data, function(key, val){
      var rowNode = table.row.add([`${val.fullname}`, 
                    `<a id="delete_exemption" href="#" title="Remove from Exemption"
                      exemption_id="${val.exemption_id}">
                      <i class="fa fa-trash"></i> 
                    </a>`
                    ]).draw().node();
        })
      }
    });
}

function view_member(est_id){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url(); ?>Admin/get_members",
  dataType: "JSON",
  data:{est_id:est_id },
  success: function(data){ 
  member_table.clear().draw();
  $.each(data, function(key, val){
      var rowNode = member_table.row.add([`${val.name}`
                    ]).draw().node();
        })
      }
    });
}

var table =  $('#exempted_clients').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
     "ordering": false,
     'sorting': false,
      "aaSorting": []
    });

var member_table =  $('#member_list').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
     "ordering": false,
     'sorting': false,
      "aaSorting": []
    });


});
</script>

<?php  $this->load->view('establishment/modal'); ?>
