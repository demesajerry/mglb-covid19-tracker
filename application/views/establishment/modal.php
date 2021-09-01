    <div class="modal fade" id="add_clients_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
              <div id="reg_details">
                    <div class="form-row">
                      <div class="col-sm-12 col-xs-12">
                        <div class="info-box main-box">
                          <label>Establishment / Business Name / Account Location</label>
                          <input id="name" name="name" placeholder="Establishment / Business Name / Account Location" class="form-control" type="text" required="required">
                          <hr class="noborder">
                        </div>
                      </div>
                      <div class="col-sm-12 col-xs-12">
                        <div class="form-group">
                          <div class="form-check">
                            <input name="uplb" class="form-check-input" type="checkbox" value="1" id="uplb">
                            <label class="form-check-label" for="uplb">
                              <small>UPLB Community</small>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="col-sm-6 col-xs-12">
                        <label>Establishment Address</label>
                        <input id="address" name="address" placeholder="Building / Street / No." class="form-control" type="text" required="required">
                      </div>
                      <div class="col-sm-6 col-xs-12">
                        <label>Province</label>
                        <select id="provCode" name="provCode" class="form-control select2" required="required" style="width: 100%">
                            <option value="" disabled selected>Select Province</option>
                          <?php foreach($prov_list as $prov){ ?>
                          <!--Initial selected is LAGUNA ProvCode=0434-->
                            <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-6 col-xs-12">
                        <label>City/Municipality</label>
                        <select id="citymunCode" name="citymunCode" class="form-control select2" required="required" style="width: 100%">
                            <option value="" disabled selected>Select City / Municipality</option>
                          <?php foreach($municipality_list as $mun){ ?>
                          <!--Initial selected is LAGUNA ProvCode=0434-->
                            <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-sm-6 col-xs-12">
                        <label>Barangay</label>
                          <select id="brgyCode" name="brgyCode" class="form-control select2" required="required"  style="width: 100%">
                            <option value="" disabled selected>Select Brgy</option>
                            <?php foreach($brgy_list as $val){ ?>
                            <!--Initial selected is LAGUNA ProvCode=0434-->
                              <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                        <div class="form-row">
                       <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Username</label>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control" required="required" type="text" required="required">
                          </div>
                        </div>
                       <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Password</label>
                            <input type="text" id="password" name="password" placeholder="Password" class="form-control" required="required" type="text" disabled>
                            <input type="checkbox" name="change_password" class="form-check-input" id="change_password">
                            <label class="form-check-label" for="change_password">Change Password</label>
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Contact Person</label>
                            <input id="contact_person" name="contact_person" placeholder="Contact Person" class="form-control" required="required" type="text">
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Contact Number</label>
                            <input id="contact_number" name="contact_number" placeholder="Contact Number" class="form-control" required="required" type="number" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==11) return false;">
                          </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                          <div class="info-box main-box">
                            <label>Odd-Even Exemption</label>
                            <div class="form-check">
                              <input name="oddeven_exemption" class="form-check-input" type="checkbox" value="1" id="oddeven_exemption" required="required">
                              <label class="form-check-label" for="oddeven_exemption">
                                Exempted
                              </label>
                            </div>
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
        <input type="hidden" name="group_id" id="group_id">
        <div id="reg_details">
              <div class="form-row">
                <div class="col-sm-9 col-xs-9">
                  <form id="exempted_form">
                    <select name="client_id" id='exemp_client' style='width: 100%;' required="required">
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
                    <table class="table table-responsive table-bordered table-striped" id="exempted_clients" width="100%">
                      <thead>
                        <tr>
                          <td>Exempted Client</td>
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
<!------------------------------------------Start modal-------------------------------------------->
<div class="modal fade" id="m_exempt_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-success">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="mexemption_title"></p>
        </h4>
      </div>               
<!-- Modal Body For Update -->
    <div class="modal-body"> 
      <div id="">
            <div class="form-row">
              <div class="col-sm-12 col-xs-12">
                <label>Establishment(can be multiple)</label>
                  <select name="est_id" id='mest_id' style='width: 100%;' required="required" multiple="multiple">
                  </select> 
              </div>
              <div class="col-sm-12 col-xs-12">
                <label>Client</label>
                  <select name="client_id" id='mexemp_client' style='width: 100%;' required="required">
                   <option value='' selected disabled>Select Client</option>
                  </select> 
                  <hr>
              </div>
            </div>
            <div class="form-row">
              <div class="col-sm-12 col-xs-12 alert alert-info" id="malert-exempted">
                &nbsp;
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
                <button id="madd_client" class="btn btn-success"><i class="fa fa-save fa-lg">
                  </i>&nbsp; ADD
                </button>
              </div>
            </div>
          </div>
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
