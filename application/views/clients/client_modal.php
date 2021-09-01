<!----MODAL--->

<div class="modal fade" id="status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="modal_title"></p>
        </h4>
      </div>
              
      <!-- Modal Body For View -->
      <div class="modal-body"> 
        <form method="POST" id="form_status" class="form-horizontal" role="form">
          <input type="hidden" name="cs_id" id="cs_id">
          <input type="hidden" name="former_status" id="former_status">
            <table class="table table-bordered table-hover">  
              <tr>
                <td colspan="3">Valid ID Presented :</td>
              </tr>
              <tr>
                <td colspan="3">
                  <div class="col-sm-12">
                    <div class="col-sm-6"> 
                      <input type="hidden" name="view_image_path" id="view_image_path" class="image-tag2">
                    </div>
                    <div class="col-sm-6">
                      <div id="view_results"> </div> 
                      <div class="full_name">
                        First Name: <input type="text" name="view_fname" id="view_fname" class="form-control uppercase" disabled=""/>
                        Last Name: <input type="text" name="view_lname" id="view_lname" class="form-control uppercase" disabled=""/>
                        Middle Name:<input type="text" name="view_mname" id="view_mname" class="form-control uppercase" disabled="" />
                        Birthdate: <input type="date" name="view_birthday" id="view_birthday"  class="form-control" disabled>
                      </div>
                    </div>
                  </div>
                </td>
              </tr> 
              <tr>
                <td>
                    Status: 
                    <select name="status" id="status" class="form-control select2" style="width: 100%;">
                      <option value="0" selected disabled>Select Status</option>
                      <?php
                        foreach ($status_list as $status) {
                      ?>
                      <option value="<?= $status->c_status_id ?>"> <?= $status->c_classification ?></option> 
                      <?php    
                        }
                      ?>
                    </select>
                </td> 
                <td>
                  Status Date:
                  <input type="text" name="date_changed" id="date_changed" class="eoq form-control" value="<?= date('Y-m-d'); ?>">
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  End of Quarantine:
                  <input type="text" name="end_quarantine" id="end_quarantine" class="eoq form-control">
                </td>
              </tr>
              <tr> 
                <td><input type="hidden" name="password" id="password"  class="form-control" value="<?= $userdata->password ?>"></td> 
                <td><input type="hidden" name="encoder" id="encoder" value="<?=$userdata->userid?>" class="form-control"></td> 
              </tr>
            </table>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button> 
                <button id="btnSave_status" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; UPDATE</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<div class="modal fade" id="add_clients_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="modal_title"></p>
        </h4>
      </div>
              
      <!-- Modal Body For Update -->
      <div class="modal-body"> 
        <form method="POST" id="form1" class="form-horizontal" role="form">
          <input type="hidden" name="id" id="id">
            <table class="table table-bordered table-hover">
              <tr>
                <td>First Name: <input type="text" name="fname" id="fname" class="form-control uppercase" required="required"/></td>
                <td>Last Name: <input type="text" name="lname" id="lname" class="form-control uppercase" required="required"/></td>
                <td>Middle Name:<input type="text" name="mname" id="mname" class="form-control uppercase"/></td>
              </tr> 
              <tr> 
                <td colspan="3">Client Address:<br><input type="text" name="address" id="address" placeholder="House No./Street" class="form-control" required="required"/></td>
              </tr> 
              <tr>
                <td>Province: <br>
                  <select id="update_provCode" name="update_provCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select Province</option>
                    <?php foreach($prov_list as $prov){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                    <?php } ?>
                  </select>
                </td>
                <td>Municipality:  <br>  
                  <select id="update_citymunCode" name="update_citymunCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select City / Municipality</option>
                    <?php foreach($municipality_list as $mun){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                    <?php } ?>
                  </select> 
                </td> 
                <td>Brgy: <br>
                  <select id="update_brgyCode" name="update_brgyCode" class="form-control select2" required="required" style="width: 100%;">
                    <option value="" disabled selected>Select Brgy</option>
                    <?php foreach($brgy_list as $val){ ?>
                    <!--Initial selected is LAGUNA ProvCode=0434-->
                      <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                    <?php } ?>
                  </select>
                </td>
              </tr>
              <tr> 
                <td>Birthdate: <input type="text" name="birthday" id="birthday"  class="form-control birthday" required="required"/></td>
                <td>Contact Number: <input type="text" name="contact_number" id="contact_number"  class="form-control" required="required"/></td>
                <td>Gender: 
                  <select id="sex" name="sex" class="form-control select2" required="required" style="width:100%;">
                    <option value="" disabled selected>Select Gender</option>
                    <option value="1">Male</option>
                    <option value="0">Female</option>
                  </select>  
                </td>
              </tr>
              <tr> 
                 <td colspan="1">username :<br><input type="text" name="username" id="username" class="form-control" required></td>
                 <td colspan="1">QR Code :<br><input type="text" name="qrcode" id="qrcode" class="form-control uppercase" required></td>
                 <td colspan="1">Place of Work :<br><input type="text" name="pow" id="pow" class="form-control uppercase" required></td>
              </tr>
              <tr>
                <td>
                  <div class="form-check">
                    <input name="oddeven_exemption" class="form-check-input" type="checkbox" value="1" id="oddeven_exemption" required="required">
                    <label class="form-check-label" for="oddeven_exemption">
                      Front Liner
                    </label>
                  </div>
                </td>
              </tr>   
              <tr>
                <td colspan="3">
                  <label>Odd-Even Scheme Exemptions</label>
                  <select name="exemption[]" id="exemption" class="form-control select2" multiple="multiple" disabled>
                    <?php
                      foreach($est_list as $val){
                        echo '<option value="'.$val->group_id.'">'.$val->name.'</option>';
                      }
                    ?>
                  </select>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <div class="col-sm-12">
                    Attached Valid ID:
<!--                                       <div class="col-sm-6">
                      <div id="my_camera"></div>
                      <br/>
                      <input type=button value="Capture Photo" class="btn btn-info" onClick="take_snapshot()">
                      <input type="hidden" name="image_path" id="image_path" class="image-tag">
                    </div>
-->                                      <div class="col-sm-12">
                      <div id="results"></div>
                    </div>
                  </div>
                </td>
              </tr>
            </table>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button>
                <button id="btnSave" onclick="save()" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; SAVE</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<div class="modal fade" id="confirm_update_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 id="confirm_title">
        </h4>
      </div>
      <!-- Modal Body For Update -->
      <div class="modal-body table-responsive">
        <table class="table table-striped table-bordered">
          <tr>
            <td>First Name</td>
            <td id="fname_c"></td>
          </tr>
          <tr>
            <td>Middle Name</td>
            <td id="mname_c"></td>
          </tr>
          <tr>
            <td>Last Name</td>
            <td id="lname_c"></td>
          </tr>
          <tr>
            <td>Birthday</td>
            <td id="birthday_c"></td>
          </tr>
          <tr>
            <td>To Status</td>
            <td id="to_status"></td>
          </tr>
          <tr>
            <td>End of Quarantine</td>
            <td id="eoq_c"></td>
          </tr>
          <tr>
            <td colspan="2">Validate Password</td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="input-group">
                <input type="password" name="validate_password" id="validate_password" class="form-control" placeholder="Validate Password">
                <span class="input-group-addon" id="showpass">
                  <i class="fa fa-eye" id="eye"></i>
                  <small id="showhide">
                    Show
                  </small>
                </span>
              </div>
            </td>
          </tr>
        </table>
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Cancel
              </button>
              <button onclick="save_status()" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!---- STATUS HISTORY MODAL-->
<div class="modal fade" id="view_status_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 id="status_title">
        </h4>
      </div>
      <!-- Modal Body For Update -->
      <div class="modal-body table-responsive">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <td>Status</td>
              <td>Start of Quarantine</td>
              <td>End of Quarantine</td>
              <td>Updated By</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody id="status_tbody">
          </tbody>
        </table>
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; CLOSE
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!---- STATUS update_eoq_modal-->
<div class="modal fade" id="update_eoq_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4>
          Update End of Quarantine
        </h4>
      </div>
      <!--Modal Body For Update -->
      <div class="modal-body table-responsive">
        <div id="eoq_message">
        </div>
        <input type="hidden" name="stats_id" id="stats_id">
        <input type="hidden" name="client_id_update" id="client_id_update">
        <table class="table table-striped table-bordered">
          <tr>
            <td>Status:</td>
            <td id="status_col"></td>
          </tr>
          <tr>
            <td>Start of Quarantine:</td>
            <td id="soq_col"></td>
          </tr>
          <tr>
            <td>End of Quarantine:</td>
            <td><input type="text" id="eoq_update" class="form-control eoq"></td>
          </tr>
        </table>
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Cancel
              </button>
              <button id="update_eoq_btn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Update</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
