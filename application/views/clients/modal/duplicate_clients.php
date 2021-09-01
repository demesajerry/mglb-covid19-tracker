<!------------------------------------------Start modal-------------------------------------------->
<div class="modal fade" id="list_dup" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
        <input type="hidden" name="group_id" id="group_id">
        <div id="reg_details">
              <div class="form-row">
                <div class="col-sm-12 col-xs-12">
                  <div class="info-box main-box table-responsive">
                    <table class="table table-responsive table-bordered table-striped" id="exempted_clients" width="100%">
                      <thead>
                        <tr>
                          <td>ID</td>
                          <td>Last</td>
                          <td>First</td>
                          <td>Middle</td>
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

<!------------------------------------------end modal-------------------------------------------->
<!------------------------------------------START modal-------------------------------------------->
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
                    <input name="oddeven_exemption" class="form-check-input" type="checkbox" value="1" id="oddeven_exemption">
                    <label class="form-check-label" for="oddeven_exemption">
                      Front Liner
                    </label>
                  </div>
                </td>
                <td>
                  <div class="form-check">
                    <input name="active" class="form-check-input" type="checkbox" value="0" id="active">
                    <label class="form-check-label" for="active">
                      Disable Account
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
<!------------------------------------------end modal-------------------------------------------->
<!------------------------------------------Start modal-------------------------------------------->
<div class="modal fade" id="list_vac" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content modal-sm">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          Update Vaccination userid
        </h4>
      </div>               
<!-- Modal Body For Update -->
      <div class="modal-body"> 
        <div id="reg_details">
          <form id="formvac">
              <div class="form-row">
                <div class="col-sm-12 col-xs-12">
                  <div class="info-box main-box table-responsive">
                    <table class="table table-responsive table-bordered table-striped" id="vac_table" width="100%">
                      <tr>
                        <td>Vac ID</td>
                        <td>
                          <input type="hidden" class="form-control" id="userid_orig" name="userid_orig">
                          <input type="text" class="form-control" id="userid" name="userid">
                        </td>
                      </tr>
                      <tr>
                        <td>Fname</td>
                        <td id="vac_fname"></td>
                      </tr>
                      <tr>
                        <td>Lname</td>
                        <td id="vac_lname"></td>
                      </tr>
                      <tr>
                        <td>Mname</td>
                        <td id="vac_mname"></td>
                      </tr>
                      <tr>
                        <td>With Post Vac</td>
                        <td id="with_postvac"></td>
                      </tr>
                      <tr>
                        <td>Date Registered</td>
                        <td id="date_reg"></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </form>
          </div>
        <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button>
                <button type="button" id="btn-updateVac" class="btn btn-success" data-dismiss="modal">
                  <i class="fa fa-save fa-lg"></i>&nbsp; Update
                </button>
              </div>
            </div>
          </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<!------------------------------------------end modal-------------------------------------------->
