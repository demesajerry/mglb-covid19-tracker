    <div class="modal fade" id="add_tagger_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header alert alert-success">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">
              <p id="modal_title">Add Tagger Account</p>
            </h4>
          </div>
                  
          <!-- Modal Body For Update -->
          <div class="modal-body"> 
            <form method="POST" id="form1" class="form-horizontal" role="form">
              <input type="hidden" name="id" id="id">
              <div id="reg_details">
                    <div class="form-row">
                      <div class="col-sm-12 col-xs-12">
                        <div class="info-box main-box">
                          <label>First Name:</label>
                          <input id="fname" name="fname" placeholder="First Name" class="form-control" type="text" required="required">
                        </div>
                      </div>
                      <div class="col-sm-12 col-xs-12">
                        <div class="info-box main-box">
                          <label>Middle Name:</label>
                          <input id="mname" name="mname" placeholder="Middle Name" class="form-control" type="text" required="required">
                        </div>
                      </div>
                      <div class="col-sm-12 col-xs-12">
                        <div class="info-box main-box">
                          <label>Last Name:</label>
                          <input id="lname" name="lname" placeholder="Last Name" class="form-control" type="text" required="required">
                        </div>
                      </div>
                      <div class="col-sm-12 col-xs-12">
                        <div class="info-box main-box">
                          <label>Barangay:</label>
                          <select id="brgyCode" name="brgyCode" class="form-control select2" required="required"  style="width: 100%">
                            <option value="" disabled selected>Select Brgy</option>
                            <?php foreach($brgy_list as $val){ ?>
                            <!--Initial selected is LAGUNA ProvCode=0434-->
                              <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                       <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Username:</label>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control" required="required" type="text" required="required">
                          </div>
                        </div>
                       <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Password:</label>
                            <input type="text" id="password" name="password" placeholder="Password" class="form-control" required="required" type="text" disabled>
                            <input type="checkbox" name="change_password" class="form-check-input" id="change_password">
                            <label class="form-check-label" for="change_password">Change Password</label>
                          </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                          <div class="info-box main-box">
                            <label>Contact Number:</label>
                            <input id="contact_number" name="contact_number" placeholder="Contact Number" class="form-control" required="required" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;">
                          </div>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                          <div class="info-box main-box">
                            <label>Access:</label>
                            <select class="select2" name="access" id="access">
                              <option value="3">Tagger</option>
                              <option value="2">Client List</option>
                              <option value="1">Admin</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      </div>              <!--SUBMIT BUTTON -->
                      <div class="modal-footer" align="right">
                        <div class="form-group">
                          <div class="col-sm-12" align="right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                              <i class="fa fa-times fa-lg"></i>&nbsp; Close
                            </button>
                            <button id="btnSave" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; SAVE</button>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div><!--end Modal body-->
                </div><!--end Modal content-->
              </div><!--end Modal dialog-->
            </div><!--end modal receive-->
<!------------------------------------------end modal-------------------------------------------->
<!------------------------------------------Start modal-------------------------------------------->
<div class="modal fade" id="member_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p class="modal_title"></p>
        </h4>
      </div>               
<!-- Modal Body For Update -->
      <div class="modal-body"> 
        <input type="hidden" name="est_id" id="parent_id" class="est_id">
        <div id="reg_details">
              <div class="form-row">
                <div class="col-sm-9 col-xs-9">
                  <form id="exempted_form">
                  <select name="gest_id" id='gest_id' style='width: 100%;' required="required" multiple="multiple">
                  </select> 
                  </form>                        
                </div>
                <div class="col-sm-3 col-xs-3">
                  <button id="add_memberBtn" class="btn btn-success"><i class="fa fa-save fa-lg"></i>&nbsp; ADD</button>
                </div>
              </div>
              <div class="form-row">
                <div class="col-sm-12 col-xs-12 alert alert-info" id="member_alert">

                </div>
                <div class="col-sm-12 col-xs-12">
                  <div class="info-box main-box table-responsive">
                    <table class="table table-responsive table-bordered table-striped" id="member_list" width="100%">
                      <thead>
                        <tr>
                          <td>Member Establishments</td>
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

<style>
  hr.noborder{
    margin-top: 0 !important;
    margin-bottom: 0 !important;
        padding-right:0px !important;
    padding-left: .25rem !important;

  }
  hr.green{
    border-top: 1px solid green;
  }
  .black{
    color: black;
  }
  .wide{
    padding-right:0px !important;
    padding-left: .25rem !important;
  }
</style>

<div class="modal" id="tagger_info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body" id="id_details">
            <div class="row">
              <div class="col-md-6">         
                <div class="col-md-12 black wide name_display" id="">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Establishment / Business Tagger name ( Brgy )</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-6">         
                <div class="col-md-12 black wide name_display" id="">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Tagger name ( Brgy )</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">
              <div class="col-md-6">         
                <div class="col-md-12 black wide" id="username_qr">&nbsp;</div>
               <div class="col-md-12 wide"><hr class="noborder"><h6>Username</h6></div>
               <div class="col-md-12 wide"><hr class="noborder"><small>https://www.mglb-covid19-tracker.com/Tagger</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-6">         
                <div class="col-md-12 black wide" id="password_qr">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><h6>Password</h6></div>
               <div class="col-md-12 wide"><hr class="noborder"><small>https://www.mglb-covid19-tracker.com/Tagger</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
          <a id="download_id" href="#"><button class="btn btn-success"><i class="fa fa-download"></i> Download</button></a>
        </div>
      </div>
    </div>
  </div>
<script>
//variable for html2canvas
var getCanvas; // global variable
var element = $("#id_details"); // global variable
$(document).ready(function(){
  $("#download_id").on('click', function () {
    var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    var name = $('.name_display').text();
    $("#download_id").attr("download", name+".png").attr("href", newData);
  });
});
</script>

