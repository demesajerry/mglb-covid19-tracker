<!----MODAL--->

<div class="modal fade" id="add_sched_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Confirm Schedule</p>
        </h4>
      </div>
              
      <!-- Modal Body For View -->
      <div class="modal-body"> 
        <form method="POST" id="form_sched" class="form-horizontal" role="form">
          <input type="hidden" id="userid" name="userid">
          <table>
            <tr>
              <td><label>Name:</label></td>
              <td id="display-name"></td>
            </tr>
            <tr>
              <td><label>Schedule:</label> </td>
              <td id="display-sched"></td>
            </tr>
            <tr>
              <td><label>Vaccination Site:</label> </td>
              <td id="display-site"></td>
            </tr>
            <tr>
              <td><label>Vaccine:</label> </td>
              <td id="display-vac"></td>
            </tr>
            <tr>
              <td><label>Dose Number:</label></td>
              <td id="display-dose"></td>
            </tr>
            <tr>
              <td><label>Total schedule on site:</label></td>
              <td id="display-total_site"></td>
            </tr>
            <tr>
              <td><h3><label>Total schedule:</label></h3> </td>
              <td id="display-total"></td>
            </tr>
          </table>
          <br>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button> 
                <button id="confirmBtn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<!----MODAL--->

<div class="modal fade" id="confirm_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Confirm Send Message</p>
        </h4>
      </div>
              
      <!-- Modal Body For View -->
      <div class="modal-body"> 
        <form method="POST" id="form_sched" class="form-horizontal" role="form">
          <input type="hidden" id="userid-sms" name="userid-sms">
          <input type="hidden" id="name-sms" name="name-sms">
          <input type="hidden" id="contact_number-sms" name="contact_number-sms">
          <input type="hidden" id="vac_manufacturer-sms" name="vac_manufacturer-sms">
          <input type="hidden" id="vac_site-sms" name="vac_site-sms">
          <input type="hidden" id="vac_date-sms" name="vac_date-sms">
          <input type="hidden" id="dose-sms" name="dose-sms">
          <table class="table">
            <tr>
              <td><label>Name:</label></td>
              <td id="display-name1"></td>
            </tr>
            <tr>
              <td><label>Schedule:</label> </td>
              <td id="display-sched1"></td>
            </tr>
            <tr>
              <td><label>Vaccination Site:</label> </td>
              <td id="display-site1"></td>
            </tr>
            <tr>
              <td><label>Vaccine:</label> </td>
              <td id="display-vac1"></td>
            </tr>
            <tr>
              <td><label>Dose Number:</label></td>
              <td id="display-dose1"></td>
            </tr>
            <tr>
              <td>Time:</td>
              <td>
                <select name="si_id_single" id="si_id_single" class="form-control">
                  <?php foreach($sched_interval as $val){ ?>
                    <option value="<?= $val->si_id ?>"><?= $val->description ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>device:</td>
              <td>
                <select name="sdevice_id" id="sdevice_id" class="form-control">
                  <option value="">Select Device</option>
                  <?php foreach($device as $val){ ?>
                    <option value="<?= $val->device_id ?>" data-device='<?= $val->device ?>' data-link="<?= $val->link ?>" <?php echo ($val->is_active=='1')?'selected':''; ?>><?= $val->description ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
          </table>
          <br>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button> 
                <button id="sendBtn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<!----MODAL--->

<div class="modal fade" id="bulk_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">BULK SCHEDULING</p>
        </h4>
      </div>
              
      <!-- Modal Body For View -->
      <div class="modal-body"> 
        <form method="POST" id="form_sched" class="form-horizontal" role="form">
          <input type="hidden" id="vac_manufacturer-bulk" name="vac_manufacturer-bulk">
          <input type="hidden" id="vac_site-bulk" name="vac_site-bulk">
          <input type="hidden" id="vac_date-bulk" name="vac_date-bulk">
          <input type="hidden" id="dose-bulk" name="dose-bulk">
          <table class="table">
            <thead>
              <tr>
                <td><label>Schedule:</label>
                  <p id="display-sched-bulk"></p>
                </td>
                <td><label>Vaccination Site:</label>
                  <p id="display-site-bulk"></p>
                </td>
                <td><label>Vaccine:</label>
                  <p id="display-vac-bulk"></p>
                </td>
                <td><label>Dose Number:</label>
                  <p id="display-dose-bulk"></p>
                </td>
              </tr>
              <tr>
                <td colspan="3"><h3><label>Total schedule:</label></h3> </td>
                <td id="display-total-bulk"></td>
              </tr>
            </thead>
          </table>
          <table id="bulk_schedtable" class="table table-bordered" width="100%">
            <thead>
              <tr>
                <td>FULL NAME</td>
                <td>AGE</td>
                <td>WITH COMORBIDITY</td>
                <td>FIRST DOSE</td>
                <td>Vaccine</td>
              </tr>
            </thead>
            <tbody id="tbody-bulk">
            </tbody>
          </table>

          <br>
          <!--SUBMIT BUTTON -->
          <div class="modal-footer" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Close
                </button> 
                <button id="cbsBtn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
              </div>
            </div>
          </div>
        </form>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<!----MODAL--->

<div class="modal fade" id="bulkMsg_modal" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Send Bulk Message</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">
        <div class="col-xs-12">
          <div class="col-xs-4"> 
            <label>Default Device</label>
            <select name="device_id" id="device_id" class="form-control">
              <option value="">Select Device</option>
              <?php foreach($device as $val){ ?>
                <option value="<?= $val->device_id ?>" data-device='<?= $val->device ?>' data-link="<?= $val->link ?>" <?php echo ($val->is_active=='1')?'selected':''; ?>><?= $val->description ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-xs-4"> 
            <label>Set Time</label>
            <select name="si_id" id="si_id" class="form-control">
              <?php foreach($sched_interval as $val){ ?>
                <option value="<?= $val->si_id ?>"><?= $val->description ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="col-xs-4"> 
            <label>Vaccine used</label>
              <select id="vaccine_used_sms" name="vaccine_used_sms" class="form-control select2 required"
              onchange="bulk_list();">
                <?php if($dose==2){ ?>
                  <option value="" selected>Select Vaccine</option>
                  <?php foreach($vaccines as $val){ ?>
                    <option value="<?= $val->vaccine_id ?>"><?= $val->brand ?></option>
                  <?php } ?>
                <?php }else{ ?>
                  <option value="" selected>Select Vaccine</option>
                  <option value="Pfizer">Pfizer</option>
                  <option value="Moderna">Moderna</option>
                  <option value="Astrazeneca">Astrazeneca</option>
                  <option value="Sinovac">Sinovac</option>
                  <option value="Gamaleya">Gamaleya</option>
                  <option value="Janssen">Janssen</option>
                <?php }?>
              </select>
          </div>
        </div>
        <div class="col-xs-12">
          <div class="col-xs-4"> 
            <label>Schedule:</label><input type="text" name="schedule" id="schedule" class="form-control date"  onchange="bulk_list();">
          </div> 
          <div class="col-xs-4"> 
            <label>Status:</label>
            <select class="select2" name="status" id="status" onchange="bulk_list();">
              <option value="">ALL</option>
              <option value="1">Texted with no reply</option>
              <option value="2">Not yet texted</option>
            </select>
          </div> 
          <div class="col-xs-4"> 
            <label>Vaccination Site</label>
            <select id="vac_site_bulk" name="vac_site_bulk" class="form-control select2"  onchange="bulk_list();"> 
              <option value="">ALL</option>
                  <?php foreach($vac_site_list as $val){  ?>
                    <option value="<?= $val->vac_site_id ?>"><?= $val->vac_site ?></option>
                  <?php } ?>
             </select>
          </div> 
          <div class="col-xs-12"> 
            <hr>
          </div>
        </div>
        <table id="bulk_table" class="table table-bordered" width="100%">
          <thead>
            <tr>
              <td> Name: </td>
              <td> Number: </td>
              <td> Vaccine: </td>
              <td> Site: </td>
            </tr>
          </thead>
          <tbody id="bulk_list">
          </tbody>
        </table>
                  <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
              <button id="bulkSendBtn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<div class="modal fade" id="reminder_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Send Reminder Message</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">

        <h3>Send Reminder to all confirmed schedules for:</h3>
        <div>
            <label>Start:</label>
            <input type="number" name="start" class="form-control" id="start">
            <label>End:</label>
            <input type="number" name="end" class="form-control" id="end">
            <label>Device:</label>
            <select name="reminder_device_id" id="reminder_device_id" class="form-control">
              <option value="">Select Device</option>
              <?php foreach($device as $val){ ?>
                <option value="<?= $val->device_id ?>" data-device='<?= $val->device ?>' data-link="<?= $val->link ?>" <?php echo ($val->is_active=='1')?'selected':''; ?>><?= $val->description ?></option>
              <?php } ?>
            </select>
        </div>
        <div class="bottom-border">
          <div class="input-group col-sm-12" id="vac_sched_display">
            
          </div>
        </div>

        <hr>
        <table class="table tbl-stripped" id="tbl_reminder" style="width: 100% !important">
          <thead>
            <tr>
              <td>FULL NAME</td>
              <td>Contact Number</td>
              <td>Vaccine</td>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
                  <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
<!--               <button id="reminderSendBtn-FL" class="btn btn-info pull-left"><i class="fa fa-mobile fa-lg"></i>&nbsp; Send Frontliner Reminder</button>
 -->          
              <button id="send_custom_sms" class="btn btn-warning pull-left"><i class="fa fa-mobile fa-lg"></i>&nbsp; Custom Advisory</button>

              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
              <button id="reminderSendBtn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->


<div class="modal fade" id="update_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Update Client</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">
        <input type="hidden" name="uuserid" id="uuserid">
        <table class="table tbl-stripped">
          <tbody>
            <tr>
              <td>Name:</td>
              <td id="update_name_display"></td>
            </tr>
            <tr>
              <td>Contact Number</td>
              <td><input type="text" id="ucn" name="ucn" class="form-control "></td>
            </tr>
            <tr>
              <td>First Dose Date</td>
              <td><input type="text" id="uvd" name="uvd" class="form-control date"></td>
            </tr>
            <tr>
              <td>Second Dose Date</td>
              <td><input type="text" id="usvd" name="usvd" class="form-control date"></td>
            </tr>
            <tr>
              <td>Vaccine Manufacturer</td>
              <td>
                <select id="uvm" name="uvm" class="form-control select2 required">
                  <option value="" selected>Select Vaccine</option>
                  <?php foreach($vaccines as $val){ ?>
                    <option value="<?= $val->vaccine_id ?>"><?= $val->brand ?></option>
                  <?php } ?>
                 </select>
              </td>
            </tr>
            <tr>
              <td>Reply</td>
              <td>
                <select name="reply2" id="reply2" class="form-control">
                  <option value="">Select Reply</option>
                  <option value="YES">Yes</option>
                  <option value="RESCHED">Resched</option>
                  <option value="NO">No</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
        <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
              <button id="update_btn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<div class="modal fade" id="sms_history_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Sms History</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">
        <input type="hidden" name="uuserid" id="uuserid">
        <table class="table tbl-stripped">
          <thead>
            <th width="10%">Number</th>
            <th width="10%">Device</th>
            <th width="80%">Message</th>
          </thead>
          <tbody id="tbody_sms">
          </tbody>
        </table>
        <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
<!--               <button id="update_btn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
 -->            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->


<div class="modal fade" id="update1_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header --> 
      <div class="modal-header alert alert-info">
        <button type="button" class="close btn-close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">
          <p id="">Update Client</p>
        </h4>
      </div>  
      <!-- Modal Body For View -->
      <div class="modal-body">
        <input type="hidden" name="uuserid1" id="uuserid1">
        <input type="hidden" name="uvac_date" id="uvac_date">
        <input type="hidden" name="uvac_site" id="uvac_site">
        <input type="hidden" name="si_id" id="si_id">
        <table class="table tbl-stripped">
          <tbody>
            <tr>
              <td>Name:</td>
              <td id="update_name_display1"></td>
            </tr>
            <tr>
              <td>Contact Number</td>
              <td><input type="text" id="ucn1" name="ucn1" class="form-control "></td>
            </tr>
            <tr>
              <td>Disable Client</td>
              <td>
                <select name="is_disable" id="is_disable" class="form-control">
                  <option value="0">NO</option>
                  <option value="1">Yes</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Already Vaccinated?</td>
              <td>
                <select name="a1_vaccinated_status" id="a1_vaccinated_status" class="form-control">
                  <option value="0">NO</option>
                  <option value="1">Yes</option>
                </select>
              </td>
            </tr>
            <tr>
              <td>Reply</td>
              <td>
                <select name="reply" id="reply" class="form-control">
                  <option value="">Select Reply</option>
                  <option value="YES">Yes</option>
                  <option value="RESCHED">Resched</option>
                  <option value="NO">No</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
        <!--SUBMIT BUTTON -->
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default btn-close" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Close
              </button> 
              <button id="update1_btn" class="btn btn-success pull-right"><i class="fa fa-save fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div><!--end Modal body-->
    </div><!--end Modal content-->
  </div><!--end Modal dialog-->
</div><!--end modal receive-->

<script type="text/javascript">
$(document).ready(function(){
    $('#cbsBtn').click(function(e){
      e.preventDefault();
      var userid =selected_rowsID;
      var vac_site =$('#vac_site').val();
      var vac_manufacturer =$('#vac_manufacturer').val();
      var date_sched =$('#date_sched').val();
      $.ajax({
          url : "<?= base_url();?>Vac_list/update_bulk_sched",
          type: "POST",
          data: {userid:userid, dose:dose, vac_site:vac_site, vac_manufacturer:vac_manufacturer, date_sched:date_sched},
          dataType: "JSON",
          success: function(data)
          {
            if(data == 1){
              toastr.success('BULK SCHEDULE SUCCESS!');
              table.ajax.reload(null, false);
              $('#bulk_modal').modal('hide');
            }
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })
});
</script>

