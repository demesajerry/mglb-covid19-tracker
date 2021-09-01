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

<div class="modal" id="client_info_modal" role="dialog" tabindex="-1"
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
<!--         <div class="col-md-12">
          <center><h3 class="black"><img src="<?php echo base_url('assets/images/lblogo.png'); ?>" height="45" width="45"/>LB LAB ESTABLISHMENT</h3></center>
        </div>
 -->          <div class="col-md-12">
            <div class="row">
              <div class="col-md-6">         
                <div class="col-md-12 black wide name_display" id="">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Establishment / Business Name / Account Location</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-6">         
                <div class="col-md-12 black wide name_display" id="">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Establishment / Business Name / Account Location</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">
              <div class="col-md-6">         
                <div class="col-md-12 black wide" id="username_qr">&nbsp;</div>
               <div class="col-md-12 wide"><hr class="noborder"><h6>Username</h6></div>
               <div class="col-md-12 wide"><hr class="noborder"><small>https://www.mglb-covid19-tracker.com/authentication/est</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-6">         
                <div class="col-md-12 black wide" id="password_qr">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><h6>Password</h6></div>
               <div class="col-md-12 wide"><hr class="noborder"><small>https://www.mglb-covid19-tracker.com/authentication/est</small></div>
              <hr class="noborder green"> 
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
    var name = $('.name_display').text();
    $("#download_id").attr("download", name+".png").attr("href", newData);
  });
});
</script>

