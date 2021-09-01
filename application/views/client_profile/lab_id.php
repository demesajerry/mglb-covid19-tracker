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
<?php
  $user = $this->session->userdata('user');
  extract($user);
?>
<div class="modal" id="client_info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">Please download or screenshot this information and present to LB establishments for scanning.
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body" id="id_details">
      <center><h3 class="black">LB LAB ID</h3>
        <div class="col-md-12" id="qrcode_dispay"></div></center>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="fname_display"><?= $fname ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>First Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="mname_display"><?= $mname ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Middle Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="lname_display"><?= $lname ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Last Name</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="number_display"><?= $contact_number ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Contact Number</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="username_display"><?= $username ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Username</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="sex_display"><?= $sex==1?'MALE':'FEMALE' ?></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Sex</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">         
              <div class="col-md-12">         
                <div class="col-md-12 black wide" id="address_display"><?=$address.' '.$brgyDesc.' '.$citymunDesc.' '.$provDesc ?></div>
                <div class="col-md-12 wide " id='add_color'><hr class="noborder"><small>Address</small></div>
              </div>
            </div>
            <hr class="noborder green">
          </div>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
          <a id="download_id" href="#"><button class="btn btn-success"><i class="fa fa-download"></i> Download</button></a>
        </div>
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
    $("#download_id").attr("download", "mglb-contact-tracing-ID.png").attr("href", newData);
  });
});
</script>

