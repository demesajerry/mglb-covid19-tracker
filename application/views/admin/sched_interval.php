
<?php
$id_name = "si_id";
$table = "sched_interval";
$labels = "Description";
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
       Schedule Interval

        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Sched Interval</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">LIST</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add" >
                                <i  class="fa fa-plus fa-1x"> </i> Add
                            </button>
                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="modal" role="dialog" 
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header">
                                    <button type="button" class="close" 
                                       data-dismiss="modal">
                                           <span aria-hidden="true">&times;</span>
                                           <span class="sr-only">Close</span>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">
                                        <p id="modal_title"></p>
                                    </h4>
                                </div>
                                
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    
                                  <form method="POST" id="form1" class="form-horizontal" role="form">
                                    <input type="hidden" name="si_id" id="si_id">
                                     <table class="table table-bordered table-hover">
                                       <tr>
                                            <td>Description</td>
                                            <td><input type="text" name="description" id="description" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Start Time</td>
                                            <td><input type="text" name="start_time" id="start_time" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>End Time</td>
                                            <td><input type="text" name="end_time" id="end_time" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Hour Interval</td>
                                            <td><input type="text" name="hour_interval" id="hour_interval" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Max per Hour</td>
                                            <td><input type="text" name="max_per_hour" id="max_per_hour" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>Max Client</td>
                                            <td><input type="text" name="max_client" id="max_client" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                       <tr>
                                            <td>over_time</td>
                                            <td><input type="text" name="over_time" id="over_time" class="form-control uppercase" required="required"/></td>
                                        </tr>
                                    </table>
                                      <!--SUBMIT BUTTON -->
                                    <div class="modal-footer" align="right">
                                      <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">
                                             Close
                                          </button>
                                          <button type="submit" class="btn btn-success btnSubmit" id="submit_add">SAVE</button>
                                        </div>
                                      </div>
                                     </div>
                                    </form>
                                </div><!--end Modal body-->
                            </div><!--end Modal content-->
                        </div><!--end Modal dialog-->
                    </div><!--end modal receive-->
                <hr />
                <?php echo $this->session->flashdata('message'); ?>
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="20%">ID</th>
                              <th width="40%">Description</th>
                              <th width="20%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($list != false){
                            foreach($list as $value){ 
                        ?>
                        <tr>
                            <td><?php echo $value->{$id_name}; ?></td>
                            <td><?php echo $value->description; ?></td>
                            <td>            
                              <a class="edit_modal" href="#"  title="edit"
                              si_id="<?php echo $value->si_id; ?>" 
                              description="<?php echo $value->description; ?>" 
                              start_time="<?php echo $value->start_time; ?>" 
                              hour_interval="<?php echo $value->hour_interval; ?>" 
                              max_per_hour="<?php echo $value->max_per_hour; ?>" 
                              end_time="<?php echo $value->end_time ; ?>" 
                              over_time="<?php echo $value->over_time ; ?>" 
                              max_client="<?php echo $value->max_client; ?>" 
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
                              <a class="delete_modal" href="#" title="delete" 
                              si_id="<?php echo $value->si_id; ?>" 
                              description="<?php echo $value->description; ?>" 
                              start_time="<?php echo $value->start_time; ?>" 
                              hour_interval="<?php echo $value->hour_interval; ?>" 
                              max_per_hour="<?php echo $value->max_per_hour; ?>" 
                              end_time="<?php echo $value->end_time ; ?>" 
                              over_time="<?php echo $value->over_time ; ?>" 
                              max_client="<?php echo $value->max_client; ?>" 
                              >
                                   <i class="fa fa-remove"></i> 
                               </a> 
                            </td>
                        </tr>
                        <?php 
                            }
                        }
                        ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="exemption_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="exemption_title"></p>
        </h4>
      </div>               
<!-- Modal Body For Update -->
      <div class="modal-body"> 
        <input type="hidden" name="at_id" id="at_id">
        <div id="reg_details">
              <div class="form-row">
                <div class="col-sm-9 col-xs-9">
                  <form id="exempted_form">
                    <select name="link_id" id='links' style='width: 100%;' required="required">
                     <option value='' selected disabled>Select Client</option>
                    </select> 
                  </form>                        
                </div>
                <div class="col-sm-3 col-xs-3">
                  <button id="add_link" class="btn btn-success"><i class="fa fa-save fa-lg"></i>&nbsp; ADD</button>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-12 col-xs-12 alert alert-info" id="alert-exempted">

                </div>
                <div class="col-sm-12 col-xs-12">
                  <div class="info-box main-box table-responsive">
                    <table class="table table-responsive table-bordered table-striped" id="links_table" width="100%">
                      <thead>
                        <tr>
                          <td>Accessible Links</td>
                          <td>Action</td>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
        <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button>
              </div>
            </div>
          </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<script>
$(document).ready(function() {
    $('#viewresult').on('click','.links', function(){
      var at_id = this.getAttribute("at_id");
      var access_type = this.getAttribute("access_type");
      $('#exemption_title').html('Add links for '+access_type);
      $('#at_id').val(at_id);
      view_exempted(at_id);
      $('#exemption_modal').modal('show');
    })

  $("#submit_add").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#form1").submit();
  });

  $("#submit_edit").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#edit_form").submit();
  });

    $("#add").click(function() {
      $('#form1')[0].reset();
      $("#id").val('');
      //set selected value for select2
      $('#status').val('0');
      //trigger change for select2
      $('#status').select2().trigger('status');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_si';
      $("#modal_title").text('Add <?= $labels ?>');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Save');
      $('#modal').modal('show');
});

  $(".edit_modal").click(function() {
      var si_id = this.getAttribute("si_id");
      var start_time = this.getAttribute("start_time");
      var hour_interval = this.getAttribute("hour_interval");
      var max_per_hour = this.getAttribute("max_per_hour");
      var end_time = this.getAttribute("end_time");
      var description = this.getAttribute("description");
      var max_client = this.getAttribute("max_client");
      var over_time = this.getAttribute("over_time");
      $("#modal_title").text('Edit Sched Interval');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Edit');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_si';
      //set selected value for select2
      $('#si_id').val(si_id);
      $('#start_time').val(start_time);
      $('#hour_interval').val(hour_interval);
      $('#max_per_hour').val(max_per_hour);
      $('#end_time').val(end_time);
      $('#description').val(description);
      $('#max_client').val(max_client);
      $('#over_time').val(over_time);
      $('#modal').modal('show');
  });

  $(".delete_modal").click(function() {
      var si_id = this.getAttribute("si_id");
      var start_time = this.getAttribute("start_time");
      var hour_interval = this.getAttribute("hour_interval");
      var max_per_hour = this.getAttribute("max_per_hour");
      var end_time = this.getAttribute("end_time");
      var description = this.getAttribute("description");
      var max_client = this.getAttribute("max_client");
      var over_time = this.getAttribute("over_time");
      $("#modal_title").text('Delete Sched Interval');
      $("#modal_title").removeClass('alert alert-info');
      $("#modal_title").addClass('alert alert-danger');
      $("#submit_add").removeClass('btn btn-success');
      $("#submit_add").addClass('btn btn-danger');
      $("#submit_add").text('Delete');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/delete';
      //set selected value for select2      //set selected value for select2
      $('#si_id').val(si_id);
      $('#start_time').val(start_time);
      $('#hour_interval').val(hour_interval);
      $('#max_per_hour').val(max_per_hour);
      $('#end_time').val(end_time);
      $('#description').val(description);
      $('#max_client').val(max_client);
      $('#over_time').val(over_time);
      $('#modal').modal('show');
  });

    $('#viewresult').DataTable({
            responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10
    });

  $('#links_table').on('click','#delete_link', function(){
    var a_id = this.getAttribute("a_id");
    var at_id = $('#at_id').val();
      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>Admin/delete_link",
        dataType: "JSON",
        data:{a_id:a_id},
        success: function(data){
          view_exempted(at_id);
          $('#alert-exempted').show().html('Link has been removed from the access.').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn().fadeOut();
          $('#exemp_client').val('').change();
        }
      });
  })

function view_exempted(at_id){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url(); ?>Admin/get_access",
  dataType: "JSON",
  data:{at_id:at_id },
  success: function(data){ 
  table.clear().draw();
  $.each(data, function(key, val){
      var rowNode = table.row.add([`${val.link}`, 
                    `<a id="delete_link" href="#" title="Remove Link"
                      a_id="${val.a_id}">
                      <i class="fa fa-trash"></i> 
                    </a>`
                    ]).draw().node();
        })
      }
    });
}

var table =  $('#links_table').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
     "ordering": false,
     'sorting': false,
      "aaSorting": []
    });

 $("#links").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>Admin/get_links",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      at_id: $('#at_id').val()
    };
   },
processResults: function (data) {
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.link,
                        id: item.link_id
                    }
                })
            };
        }
    }
 });


$('#add_link').click(function(e){
  e.preventDefault();
  var link_id = $('#links').val();
  var at_id = $('#at_id').val();
  if(link_id!=null){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Admin/add_access",
      dataType: "JSON",
      data:{link_id:link_id,at_id:at_id },
      success: function(data){
        view_exempted(data);
        $('#alert-exempted').show().html('Link has been added.').fadeOut().fadeIn().fadeOut().fadeOut().fadeIn().fadeOut();
        $('#links').val('').change();
      }
    });
  }else{
    alert('Please select link');
  }
});

});

</script>