<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        A1 Application for Relatives
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> A1 Relatives</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">A1 Application List</h3>
                        <div class="box-tools">
<!--                             <button class="btn btn-info" id="add_vaccinator" >
                                <i  class="fa fa-plus fa-1x"> </i> Add Vaccine
                            </button>
 -->                        </div>
                    </div>
                <div class="box-body table-responsive">
                    <div class="modal fade" id="approve_modal" tabindex="-1" role="dialog" 
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
                                        <p id="modal_title">List of Relatives</p>
                                    </h4>
                                </div>
                                <input type="hidden" name="userid" id="userid">
                                  <div id="proof_div">
                                  </div>
                                  <table class="table table-striped table-bordered">
                                    <tr>
                                      <td>Name</td>
                                      <td>Living with A1</td>
                                    </tr>
                                    <tbody id="tbody_a1">
                                    </tbody>
                                  </table>
                                <!-- Modal Body -->
                                <div class="modal-body">
                                    <div class="modal-footer" align="right">
                                      <div class="form-group">
                                        <div class="col-sm-12" align="right">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">
                                             Close
                                          </button>
                                          <?php if(!empty(array_intersect(array(1,18), $this->session->userdata('logged_in')->access))){
                                          ?>
                                          <button type="submit" class="btn btn-success" id="approve">Approve</button>
                                          <button type="submit" class="btn btn-warning" id="disapprove">Disapprove</button>
                                        <?php } ?>
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
                              <th width="10%">userid</th>
                              <th width="20%">First Name</th>
                              <th width="20%">Last Name</th>
                              <th width="10%"># of relatives approved</th>  
                              <th width="10%"># of relatives for approval</th>  
                              <th width="20%">Number</th>
                              <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_list">
                        <?php 
                        if($a1_list != false){
                            foreach($a1_list as $val){                             
                              if($val->for_approval != 0){          
                        ?>
                        <tr>
                            <td><?php echo $val->a1_userid; ?></td>
                            <td><?php echo $val->fname; ?></td>  
                            <td><?php echo $val->lname; ?></td>  
                            <td><?php echo $val->approved; ?></td>  
                            <td><?php echo $val->for_approval; ?></td>  
                            <td><?php echo $val->contact_number; ?></td>  
                            <td>
                              <a class="relative_modal" href="#" 
                              userid="<?php echo $val->a1_userid; ?>" 
                              >
                                   <i class="fa fa-check"></i> 
                              </a> |
                            </td>
                        </tr>
                        <?php 
                              }
                            }
                        }
                        ?>
                      </tbody>
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
      $("#modal_title").text('Add Vaccine');  
      document.getElementById('form1').action =  '<?php echo base_url()."admin/add_vaccine"; ?>';
      $('#add_adverse_modal').modal('show');
});

  $("#viewresult").on('click','.relative_modal', function(){ 
    var userid = this.getAttribute('userid');
    $('#userid').val(userid);
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>A1registration/get_relatives",
      dataType: "JSON",
      data:{userid:userid},
      success: function(data){
        var list = '';
        $.each(data, function( index, val ) {
          list +=`<tr>
                    <td>${val.relative_name}</td>
                    <td>${val.is_living}</td>
                  </tr>
                  `;
        })
        $('#proof_div').html(`<img src="<?php echo base_url('assets/images/a1_photo/a1user${userid}.jpg'); ?>" height="100%" width="100%"/>`);
        $('#tbody_a1').html(list);

        $('#approve_modal').modal('show');
      }
    })
  });

  $("#approve").click(function() { 
    var userid = $('#userid').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>A1registration/approve",
      dataType: "JSON",
      data:{userid:userid},
      success: function(data){
        toastr.info('A1 relative has been approved!'); 
        var list='';
        $.each(data, function( index, val ) {
          if(val.for_approval != 0){
          var living = val.is_living==1?'YES':'NO';
          list +=`<tr>
                    <td>${val.a1_userid}</td>
                    <td>${val.fname}</td>
                    <td>${val.lname}</td>
                    <td>${val.approved}</td>
                    <td>${val.for_approval}</td>
                    <td>${val.contact_number}</td>
                    <td>${` <a class="relative_modal" href="#" 
                              userid="${val.a1_userid}" 
                              >
                                   <i class="fa fa-check"></i> 
                               </a>`}</td>
                  </tr>
                  `;
          }
        })
        $('#tbody_list').html(list);
        $('#approve_modal').modal('hide');
      }
    })
  })

  $("#disapprove").click(function() { 
    var userid = $('#userid').val();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>A1registration/disapprove",
      dataType: "JSON",
      data:{userid:userid},
      success: function(data){
        toastr.warning('A1 relative has been disapproved!');

        var list='';
        $.each(data, function( index, val ) {
          var living = val.is_living==1?'YES':'NO';
          list +=`<tr>
                    <td>${val.a1_userid}</td>
                    <td>${val.fname}</td>
                    <td>${val.lname}</td>
                    <td>${val.approved}</td>
                    <td>${val.for_approval}</td>
                    <td>${` <a class="relative_modal" href="#" 
                              userid="${val.a1_userid}" 
                              >
                                   <i class="fa fa-check"></i> 
                               </a>`}</td>
                  </tr>
                  `;
        })

        $('#tbody_list').html(list);         
        $('#approve_modal').modal('hide');
      }
    })
  })

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

