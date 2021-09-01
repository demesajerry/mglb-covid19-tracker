<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Covid-19 Classifications
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Classifications</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Classifications</h3>
                        <div class="box-tools">
                            <button class="btn btn-info" id="add_users" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Classifications
                            </button>
                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="add_class_modal" tabindex="-1" role="dialog" 
                         aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <!-- Modal Header -->
                                <div class="modal-header alert alert-info">
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
                                    
                                  <form method="POST" id="form1" class="form-horizontal" role="form" action="<?php echo base_url()."users/add_users"; ?>">
                                    <input type="hidden" name="c_status_id" id="c_status_id">
                                     <table class="table table-bordered table-hover">
                                       <tr>
                                          <td>Classification: </td>
                                          <td>
                                            <input type="text" name="c_classification" id="c_classification" class="form-control"></td>  
                                        </tr> 
                                       <tr>
                                       <tr>
                                          <td>Template Color: </td>
                                          <td>
                                            <select id="template" name="template" class="form-control">
                                              <option value="bg-light">None</option>
                                              <option value="bg-success">Green</option>
                                              <option value="bg-warning">Yellow</option>
                                              <option value="bg-info">Blue</option>
                                              <option value="bg-danger">Red</option>
                                            </select>
                                        </tr> 
                                       <tr>
                                          <td>Status: </td>
                                          <td>
                                            <select id="status" name="status" class="form-control">
                                              <option value="1">Active</option>
                                              <option value="0">In-Active</option>
                                            </select>
                                          </td> 
                                        </tr> 
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
                              <th width="10%">Classification ID</th>
                              <th width="30%">Covid Classification</th> 
                              <th width="10%">action</th>
                            </tr>
                        </thead>
                        <?php 
                        if($covidStatus_list != false){
                            foreach($covidStatus_list as $covidStatus){ 
                        ?>
                        <tr>
                            <td><?php echo $covidStatus->c_status_id; ?></td> 
                            <td><?php echo $covidStatus->c_classification; ?></td>
                            <td>            
                              <a class="edit_modal" href="#" 
                              c_status_id="<?php echo $covidStatus->c_status_id; ?>" 
                              c_classification="<?php echo $covidStatus->c_classification; ?>"     
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
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=text], textarea').val (function () {
      return this.value.toUpperCase();
    })   
    $("#form1").submit();
  });
  $("#add_users").click(function() { 
      $('#form1')[0].reset();
      $("#modal_title").text('Add Classification');
      //set selected value for select2
      $('#station_id').val("");
      //trigger change for select2
      $('#station_id').select2().trigger('station_id');

      //set selected value for select2
      $('#access').val("");
      //trigger change for select2
      $('#access').select2().trigger('access');

      document.getElementById('form1').action =  '<?php echo base_url()."classifications/add_classifications"; ?>';
      $('#add_class_modal').modal('show');
});

  $(".edit_modal").click(function() { 
      var dt = new Date();
      $('#form1')[0].reset();
      var c_status_id = this.getAttribute("c_status_id");
      var c_classification = this.getAttribute("c_classification");

      $("#c_status_id").val(c_status_id);
      $("#c_classification").val(c_classification);   
      document.getElementById('form1').action =  '<?php echo base_url()."classifications/edit_classifications"; ?>';
      $('#add_class_modal').modal('show');
  });

    $('#viewresult').DataTable({
      responsive: true,
      "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
      "iDisplayLength": 10,
      dom: 'Blfrtip',
      select: true,
      "buttons":[
        {
          extend: 'print',
          text: 'Print all',
          title:"Clients List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3],
              modifier: {
                selected: null
              },
          }
        },
        {
          extend: 'print',
          text: 'Print Selected',
          title:"Clients List",
          messageTop:"",
          exportOptions:{
            columns: [ 0, 1, 2, 3],
              modifier: {
                selected: true
              },
            }
        },
        {
          extend: 'pdf',
          text: 'Pdf',
          title:"Clients List", 
          exportOptions:{
            columns:[ 0, 1, 2, 3],
              modifier: {
                selected: null
              },
            }
        },
        {
          extend: 'excel',
          text: 'Excel',
          title:"Clients List",
          exportOptions:{
            columns: [ 0, 1, 2, 3],
              modifier: {
                selected: null
            },
          }
        },
      ],
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

