<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Indigenous Member
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Indigenous Member</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Indigenous Member List</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add_vaccinator" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Indigenous Member
                            </button>
                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="add_indigent_modal" tabindex="-1" role="dialog" 
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
                                    
                                  <form method="POST" id="form1" class="form-horizontal" role="form" action="<?php echo base_url()."admin/add_indigent"; ?>">
                                    <input type="hidden" name="ind_id" id="ind_id">
                                     <table class="table table-bordered table-hover">
                                      <tr>
                                        <td>Indigenous Member: <input type="text" name="indigent" id="indigent" class="form-control" required="required"/></td> 
                                      </tr> 

                                      <tr> 
                                        <td>
                                          Status:
                                          <select name="status" id="status" class="form-control select2" required="required" >
                                            <option value="1">Enable</option>
                                            <option value="0">Disable</option>
                                          </select>
                                        </td> 
                                      </tr>  
                                     </table>
                                      <!--SUBMIT BUTTON -->
                                    <div class="modal-footer" align="right">
                                      <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">
                                             Close
                                          </button>
                                          <button type="submit" class="btn btn-success" id="submit_add">Save</button>
                                        </div>
                                      </div>
                                     </div>
                                    </form>
                                </div><!--end Modal body-->
                            </div><!--end Modal content-->
                        </div><!--end Modal dialog-->
                    </div><!--end modal receive-->
                <hr />
                   <table class="table table-striped table-bordered table-hover" id="viewresult">
                        <thead>
                            <tr >
                              <th width="10%">ID</th>
                              <th width="30%">Indigenous Member</th>   
                              <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($indigent_list != false){
                            foreach($indigent_list as $indigent){  
                        ?>
                        <tr>
                            <td><?php echo $indigent->ind_id; ?></td>
                            <td><?php echo $indigent->indigent_grp?></td>    
                            <td>            
                              <a class="edit_modal" href="#" 
                              ind_id="<?php echo $indigent->ind_id; ?>" 
                              indigent="<?php echo $indigent->indigent_grp; ?>"  
                              status="<?php echo $indigent->status; ?>"     
                              >
                                   <i class="fa fa-edit"></i> 
                               </a> |
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
<script>
$(document).ready(function() {
  $("#submit_add").click(function (e) { 
    $("#form1").submit();
  });
  $("#add_vaccinator").click(function() { 
      $('#form1')[0].reset();
      $("#modal_title").text('Add Indigenous Member');  
      document.getElementById('form1').action =  '<?php echo base_url()."admin/add_indigent"; ?>';
      $('#add_indigent_modal').modal('show');
});

  $(".edit_modal").click(function() { 
      var dt = new Date();
      $('#form1')[0].reset();
      var ind_id = this.getAttribute("ind_id");
      var indigent_grp = this.getAttribute("indigent"); 
      var status = this.getAttribute("status");  
      $("#ind_id").val(ind_id);
      $("#indigent_grp").val(indigent_grp); 
      $("#status").val(status); 
      $("#modal_title").text('Edit Indigenous Member'); 
      document.getElementById('form1').action =  '<?php echo base_url()."admin/edit_indigent"; ?>';
      $('#add_indigent_modal').modal('show');
  });

    $('#viewresult').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "iDisplayLength": 10
    });


    $( "#datepicker" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
    $( "#birthday" ).datepicker({
    changeYear:true,
    changeMonth: true,
    yearRange: "1980:2015",
    dateFormat: 'yy-mm-dd'
    });
  
});
</script>

