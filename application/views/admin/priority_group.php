
<?php
$id_name = "pg_id";
$table = "priority_group";
$labels = "Priority Group";
?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        <?= $labels; ?>
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active"><?= $labels; ?></li>
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
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="table" id="table" value="<?= $table; ?>">
                                    <input type="hidden" name="id_name" id="id_name" value="<?= $id_name; ?>">
                                     <table class="table table-bordered table-hover">
                                      <tr>
                                        <td>
                                          Status
                                        </td>
                                        <td>
                                          <select name="status" class="form-control select2" id="status" style="width: 100%">
                                            <option value="0">ENABLED</option>
                                            <option value="1">DISABLED</option>
                                          </select>
                                        </td>
                                      </tr>
                                      <tr>
                                            <td><?= $labels; ?></td>
                                            <td>
                                              <select name="dbval" id="dbval" class="select2" required="required">
                                                <option value="A1">A1</option>
                                                <option value="A1.1">A1.1</option>
                                                <option value="A1.2">A1.2</option>
                                                <option value="A2">A2</option>
                                                <option value="EA3">EA3</option>
                                                <option value="A3">A3</option>
                                                <option value="A4">A4</option>
                                                <option value="A5">A5</option>
                                                <option value="B1">B1</option>
                                                <option value="B2">B2</option>
                                                <option value="B3">B3</option>
                                                <option value="B4">B4</option>
                                                <option value="OTHERS">Others</option>
                                            </td>
                                      </tr>
                                      <tr>
                                            <td>Description</td>
                                            <td><input type="text" name="description" id="description" class="form-control" required="required"/></td>
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
                              <th width="20%"><?= $labels; ?> ID</th>
                              <th width="20%"><?= $labels; ?></th>
                              <th width="40%">Description</th>
                              <th width="10%">Status</th>
                              <th width="10%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($list != false){
                            foreach($list as $value){ 
                        ?>
                        <tr>
                            <td><?php echo $value->{$id_name}; ?></td>
                            <td><?php echo $value->priority_group; ?></td>
                            <td><?php echo $value->description; ?></td>
                            <td><?php echo ($value->status=='0')?'ENABLED':'DISABLED'; ?></td>
                            <td>            
                              <a class="edit_modal" href="#"  title="edit"
                              id="<?php echo $value->{$id_name}; ?>" 
                              dbval="<?php echo $value->{$table}; ?>" 
                              description="<?php echo $value->description; ?>" 
                              status="<?php echo $value->status; ?>" 
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
                              <a class="delete_modal" href="#" title="delete" 
                              id="<?php echo $value->{$id_name}; ?>" 
                              dbval="<?php echo $value->{$table}; ?>" 
                              description="<?php echo $value->description; ?>" 
                              status="<?php echo $value->status; ?>" 
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
                    <select name="links_id" id='links' style='width: 100%;' required="required">
                     <option value='' selected disabled>Select Client</option>
                    </select> 
                  </form>                        
                </div>
                <div class="col-sm-3 col-xs-3">
                  <button id="add_client" class="btn btn-success"><i class="fa fa-save fa-lg"></i>&nbsp; ADD</button>
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
  $("#submit_add").click(function (e) {
    $("#form1").submit();
  });

  $("#submit_edit").click(function (e) {
    $("#edit_form").submit();
  });

    $("#add").click(function() {
      $('#form1')[0].reset();
      $("#id").val('');
      //set selected value for select2
      $('#status').val('0');
      //trigger change for select2
      $('#status').select2().trigger('status');
      $('#dbval').val('').trigger('change');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_priority_group';
      $("#modal_title").text('Add <?= $labels ?>');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Save');
      $('#modal').modal('show');
});

  $(".edit_modal").click(function() {
      var id = this.getAttribute("id");
      var dbval = this.getAttribute("dbval");
      var status = this.getAttribute("status");
      var description = this.getAttribute("description");
      $("#modal_title").text('Edit <?= $labels ?>');
      $("#modal_title").removeClass('alert alert-danger');
      $("#modal_title").addClass('alert alert-info');
      $("#submit_add").removeClass('btn btn-danger');
      $("#submit_add").addClass('btn btn-success');
      $("#submit_add").text('Edit');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/add_priority_group';
      //set selected value for select2
      $('#description').val(description);
      $('#dbval').val(dbval).trigger('change');
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      $("#id").val(id);
      $('#modal').modal('show');
  });

  $(".delete_modal").click(function() {
      var id = this.getAttribute("id");
      var dbval = this.getAttribute("dbval");
      var status = this.getAttribute("status");
      var description = this.getAttribute("description");
      $("#modal_title").text('Delete <?= $labels ?>');
      $("#modal_title").removeClass('alert alert-info');
      $("#modal_title").addClass('alert alert-danger');
      $("#submit_add").removeClass('btn btn-success');
      $("#submit_add").addClass('btn btn-danger');
      $("#submit_add").text('Delete');
      document.getElementById('form1').action =  '<?php echo base_url(); ?>admin/delete';
      //set selected value for select2      //set selected value for select2
      $('#description').val(description);
      $('#dbval').val(dbval).trigger('change');
      $('#status').val(status);
      //trigger change for select2
      $('#status').select2().trigger('status');
      $("#id").val(id);
      $('#modal').modal('show');
  });

    $('#viewresult').DataTable({
            responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10
    });

});

</script>