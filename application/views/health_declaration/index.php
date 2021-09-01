<?php
  $user = $this->session->userdata('user');
  extract($user);
?> 
<style type="text/css">
 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

</style> 
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
          <i class="fa fa-medkit"></i> Health Declaration
          <small></small>
        </h1> 
    </section>
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-danger"><i class="fa fa-exclamation"></i>&nbsp; Important</h6>
      </div>
      <div class="card-body">
        <p>Health record declaration is discretionary, the Municipality of los Baños will use this information in contract tracing. Be sure that the information you give is accurate. Informations submitted shall be strictly used only in compliance to Philippine law, guidelines, and ordinances, in relation to business operation in light of COVID-19 response.</p>
        <p class="mb-0">Providing information means agreeing to the terms and condition stated above.</p>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Symptoms</h6> 
          <button class="btn btn-success add_symptom_modal float-right" style="margin-top: -30px;" data-toggle="modal" data-target="#add_product" >
            <i class="fa fa-plus"> </i>   Add Symptom
          </button> 
            </div>
                <div class="card-body">
                  <div class="table-responsive"> 
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4"> 
                      <div class="row">
                        <div class="col-sm-12">
                          <table class="table table-bordered dataTable" id="viewresult" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                            <thead>
                              <tr role="row"> 
                                <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 10px;">ID</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 282px;">Date Onset</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 125px;">Symptom</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 125px;">Date Recovered</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 125px;">Action</th>
                              </tr>
                            </thead> 
                            <tbody>  
                                <?php 
                              $no=0;
                              if(isset($healthRecord_table)){
                                foreach($healthRecord_table as $health){  
                                  $no++;
                            ?>
                              <tr role="row">
                              <td><?=$no?></td>
                              <td><?=$health->onset_date?></td>
                              <td><?=$health->c_symptom?></td> 
                              <td><?=$health->date_recovered?></td>     
                              <td>
                                <a class="edit_symptom_modal" href="#" title="Edit Symptom"
                                  symptom_id="<?php echo $health->symptom_id; ?>"
                                  onset_date="<?php echo $health->onset_date; ?>"
                                  symptoms="<?php echo $health->symptoms; ?>" 
                                  date_recovered="<?php echo $health->date_recovered; ?>"  
                                  action = "edit"><i class="fa fa-edit fa-lg"></i> 
                                </a>  
                              </td>
                            
                              </tr>
                             <?php 
                                  }
                                }
                          ?>
                          </tbody>
                        </table>
                    </div>
                </div>
              </div>
              </div>
          </div>
      </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Closed Contact</h6>
                <button class="btn btn-danger add_closed_contact_modal float-right" style="margin-top: -30px;" data-toggle="modal" data-target="#add_product" ><i class="fa fa-plus"> </i>   Add Report</button>
            </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">  
                    <div class="row">
                      <div class="col-sm-12">
                        <table class="table table-bordered dataTable" id="closed_contact_tbl" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                          <thead> 
                            <tr role="row">
                              <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 5px;">ID</th>
                              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 25px;">Closed Contact Date</th>
                              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 5px;">Date Added</th>
                              <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 25px;">Action</th>
                            </tr>
                          </thead> 
                          <tbody> 
                          <?php 
                            $no=0;
                            if(isset($closed_contact_table)){
                              foreach($closed_contact_table as $closed_contact){  
                                $no++;
                          ?>
                            <tr>
                            <td><?=$no?></td>
                            <td><?=$closed_contact->closed_contact_date?></td>
                            <td><?=$closed_contact->date_added?></td>     
                            <td>
                              <a class="edit_closed_contact_modal" href="#" title="Edit closed contact"
                                closed_contact_id="<?php echo $closed_contact->closed_contact_id; ?>"
                                closed_client_id="<?php echo $closed_contact->closed_client_id; ?>"
                                closed_contact_date="<?php echo $closed_contact->closed_contact_date; ?>"
                                date_added="<?php echo $closed_contact->date_added; ?>"  
                                action = "edit"><i class="fa fa-edit fa-lg"></i> 
                              </a>  
                            </td>
                          </tr>
                            <?php 
                                }
                            }
                       ?>  
                        </tbody>
                      </table>
                  </div>
              </div>
              </div>
           </div>
        </div>
      </div>
    </div>
  </div> 
</div>


<div class="modal fade" id="add_symptom_modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-md">
    <form id="form_symptom" method="post">
      <input type="hidden" name="client_id" value="<?=$id?>">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header btn-success">Add Symptom
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
          </div>  
            <!-- Modal Body -->
            <div class="modal-body">
              <input type="hidden" name="symptom_id" id="symptom_id">          
              <!--start of div1 -->
              <div id="div1">
                <table class="table table-bordered">
                  <tr>
                    <td colspan="2" class="info">Please Fill Up required Information</td>
                  </tr>
                  <tr>
                    <td>Symptom </td>
                    <td>
                      <select name="symptoms" id="symptoms" class="select2" style="width: 100%;" required>
                        <option value="" selected disabled>Select Symptoms</option>
                          <?php foreach($symptoms_list as $symptom){ ?>
                        <option value="<?= $symptom->c_symptom_id; ?>">
                          <?= $symptom->c_symptom; ?>
                        </option>
                          <?php } ?>
                      </select>
                    </td>
                  </tr>
                  <tr>
                      <td>On-set Date </td>
                      <td><input type="date" name="onset_date" id="onset_date" class="form-control" required="required"></td>
                  </tr> 
                  <tr>
                      <td>Date Recovered</td>
                      <td><input type="date" name="date_recovered" id="date_recovered" class="form-control"></td>
                  </tr> 
                </table>
              </div><!--end of div1 -->
            </div>
                <!--SUBMIT BUTTON -->
              <div class="modal-footer">
                <button id="Close" class="btn btn-danger" data-dismiss="modal"  ><li class='fa fa-remove'></li>Close</button>
                <button id="submit" class="btn btn-success pull-right">Submit  <li class='fa fa-thumbs-up'></li></button>
              </div> 
            </form>
      </div>
  </div><!--end Modal body-->
</div><!--end Modal content-->

<div class="modal fade" id="add_closed_contact_modal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-md">
    <form id="form_closed_contact" method="post">
      <input type="hidden" name="closed_client_id" value="<?=$id?>">
        <div class="modal-content">
          <!-- Modal Header -->
            <div class="modal-header btn-danger">Add Closed Contact
              <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
            </div>  
            <!-- Modal Body -->
            <div class="modal-body">
              <input type="hidden" name="closed_contact_id" id="closed_contact_id">          
              <!--start of div1 -->
              <div id="div1">
                <table class="table table-bordered  ">
                  <tr>
                    <td colspan="2" class="info">Please Fill Up required Information</td>
                  </tr>
                  <tr>
                      <td>Closed Contact Date </td>
                      <td><input type="date" name="closed_contact_date" id="closed_contact_date" class="form-control" required="required"></td>
                  </tr> 
                </table>
              </div><!--end of div1 -->
            </div>
                <!--SUBMIT BUTTON -->
              <div class="modal-footer">
                <button id="closed_contact" class="btn btn-danger" data-dismiss="modal"  ><li class='fa fa-remove'></li>Close</button>
                <button id="submit_closed_contact" class="btn btn-success pull-right">Submit  <li class='fa fa-thumbs-up'></li></button>
              </div> 
            </form>
         </div>
  </div><!--end Modal body-->
</div><!--end Modal content-->

<script>
$(document).ready(function() {
  $("form_symptom").keypress(function(e) {
    //Enter key
    if (e.which == 13) {
      return false;
    }
  });


  $(".add_symptom_modal").click(function() {  
      $('#form_symptom')[0].reset();
      document.getElementById('form_symptom').action =  '<?php echo base_url(); ?>Health_declaration/add';
      $("#modal_title").text('Add Symptom');
      $('#add_symptom_modal').modal('show');      
  }); 

  $(".add_closed_contact_modal").click(function() {  
      $('#form_closed_contact')[0].reset();
      document.getElementById('form_closed_contact').action =  '<?php echo base_url(); ?>Health_declaration/add_closed_contact';
      $("#modal_title").text('Add Closed Contact');
      $('#add_closed_contact_modal').modal('show');      
  });  

  $(".edit_symptom_modal").click(function() {
      var symptom_id = this.getAttribute("symptom_id");
      var client_id = this.getAttribute("client_id");
      var onset_date = this.getAttribute("onset_date");
      var date_recovered = this.getAttribute("date_recovered");
      var symptoms = this.getAttribute("symptoms");
      var date_changed = this.getAttribute("date_changed"); 

      $("#symptom_id").val(symptom_id);
      $("#client_id").val(client_id);
      $("#onset_date").val(onset_date);
      $("#date_recovered").val(date_recovered);
      $("#symptoms").val(symptoms);
      $("#symptoms").select2().trigger('symptoms'); 
      $("#date_changed").val(date_changed); 

      document.getElementById('form_symptom').action =  '<?php echo base_url(); ?>Health_declaration/edit';
      $("#modal_title").text('Edit Symptom');
      $('#add_symptom_modal').modal('show');      
  });  

  $(".edit_closed_contact_modal").click(function() {
      var closed_contact_id = this.getAttribute("closed_contact_id");
      var closed_client_id = this.getAttribute("closed_client_id");
      var closed_contact_date = this.getAttribute("closed_contact_date");
      var date_added = this.getAttribute("date_added");  

      $("#closed_contact_id").val(closed_contact_id);
      $("#closed_client_id").val(closed_client_id);
      $("#closed_contact_date").val(closed_contact_date);
      $("#date_added").val(date_added); 

      document.getElementById('form_closed_contact').action =  '<?php echo base_url(); ?>Health_declaration/edit_closed_contact';
      $("#modal_title").text('Edit Closed Contact');
      $('#add_closed_contact_modal').modal('show');      
  });  

    
  $("#submit").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=hidden]').val (function () {
      return this.value.toUpperCase();
    })
    $form_symptom.submit();
  }); 

  $("#submit_closed_contact").click(function (e) {
    $('input[type=text]').val (function () {
      return this.value.toUpperCase();
    })
    $('input[type=hidden]').val (function () {
      return this.value.toUpperCase();
    })
    $form_closed_contact.submit_closed_contact();
  }); 


  $('#closed_contact_tbl').DataTable({ 
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
    dom: 'Blfrtip',
    select: true, 
    "order":[],    
  });
});        
</script> 
<script type="text/javascript">
  $("#unhide_closed_contact").click(function (){  
    if ($("#unhide_closed_contact").prop("checked")){  
      $("#closed_contact_section").show();  
      $("#symptom_section").hide();   
    } 
    else{ 
      $("#closed_contact_section").hide(); 
      $("#symptom_section").show(); 
    }              
  });
</script>