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
.info-box{
  margin-bottom: 3px !important;
  min-height: 20px;
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
                  <button class="btn btn-info pull-right" id="add_tagger">Add tagger</button>
                  <table id="table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                          <th width="5%">ID</th>
                          <th width="25%">lname</th>
                          <th width="25%">fname</th>
                          <th width="20%">mname</th>
                          <th width="10%">barangay</th>
                          <th width="15%">Contact Number</th>
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
  var table;
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
  $(document).ready(function(){
    $("#add_tagger").click( function(){
      $('#change_password').prop('checked',true);
      $('#password').prop('disabled',false);
      $('#id').val('');
      $('#form1').trigger("reset");

      $("#add_tagger_modal").modal('show');
    });
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
        "url": "<?php echo site_url('admin/ajax_taggerList')?>",
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

  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }

  $('#table').on('click','#edit', function(){
    $('#change_password').prop('checked',false);
    $('#password').prop('disabled',true);
      var id = this.getAttribute("tagger_id");
      $('#id').val(id);
      save_method = 'update';
      $('#form1')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string

      //Ajax Load data from ajax
      $.ajax({
          url : "<?php echo site_url('Admin/tagger_ajax_edit/')?>/" + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('#id').val(data.tagger_id);
            $('#fname').val(data.fname);
            $('#lname').val(data.lname);
            $('#mname').val(data.mname);
            $('#citymunCode').val(data.citymunCode);
            $('#citymunCode').select2().trigger('');
            $('#brgyCode').val(data.brgyCode);
            $('#brgyCode').select2().trigger('');
            $('#username').val(data.username);
            $('#contact_number').val(data.contact_number);
            $('#access').val(data.access).trigger('change');
            $('#add_tagger_modal').modal('show'); // show bootstrap modal when complete loaded
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
    if($("#form1")[0].reportValidity()){
      // ajax adding data to database
      $.ajax({
          url : "<?php echo site_url('Admin/add_tagger')?>",
          type: "POST",
          data: $('#form1').serialize(),
          dataType: "JSON",
          complete: function(){
            html2canvas(element, {
              background:'#fff',
              onrendered: function (canvas) {
                $("#previewImage").append(canvas);
                getCanvas = canvas;
              }
            });
          },
          success: function(data)
          {
            if(data.password !=null){
              $('#username_qr').html('');
              $('#password_qr').html('');
              $('#username_qr').qrcode(
                {
                  render: "canvas",
                  width: 200,
                  height: 200,
                  background: "#ffffff",
                  foreground: "#000000",
                  text: data.username,
                  src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
                  imgWidth: 75,
                  imgHeight: 75
                }
                );
              $('#password_qr').qrcode(
                {
                  render: "canvas",
                  width: 200,
                  height: 200,
                  background: "#ffffff",
                  foreground: "#000000",
                  text: data.password,
                  src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
                  imgWidth: 75,
                  imgHeight: 75
                }
                );
            $('.name_display').html(data.fullname+'('+data.brgy+')');
             $('#tagger_info_modal').modal('show');
            }
            // $('#username_display').html(data.client_info.username);
            // $('#password_display').html(data.password);
            // $('#number_display').html(data.client_info.contact_number);
            // $('#cp_display').html(data.client_info.contact_person);
            // $('#address_display').html(`${data.client_info.address} ${data.client_info.brgyDesc} ${data.client_info.citymunDesc}`);
            //$('#birthday_display').html(convert_date(data.client_info.birthday));
              $("#add_tagger_modal").modal('hide');
              reload_table();
              $('#btnSave').attr('disabled',false); //set button enable 
            reload_table();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
              alert('Error adding / update data');
              $('#btnSave').text('save'); //change button text
              $('#btnSave').attr('disabled',false); //set button enable 

          }
      });
    }
  }); 

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

    $('#change_password').change(function() {
      if($('#change_password').prop('checked')){
        $('#password').prop('disabled',false);
      }else{
        $('#password').prop('disabled',true);
      }
    });


    $('#loader').hide();
});
</script>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<?php  $this->load->view('tagger/modal'); ?>
