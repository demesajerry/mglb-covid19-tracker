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
  #cbirthday{z-index:9999 !important}
</style>

<div class="modal" id="client_info_modal" role="dialog" tabindex="-1"
     aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header red">
        <div> <h1><u> LB RESBAKUNA</u></h1> </div>
          <button type="button" class="close" 
             data-dismiss="modal">
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div>
          KAYO PO AY REHISTRADO NA SA LB RESBAKUNA. MANGYARING HINTAYIN NA LAMANG PO ANG INYONG SCHEDULE. ITO PO AY IPAPADALA SA NUMERO NA INYONG INIREHISTRO.
        </div>
      <div id="id_details">
      <center><h3 class="black">LB RESBAKUNA</h3>
        <div class="col-md-12" id="qrcode_dispay"></div></center>
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="fname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>First Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="mname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Middle Name</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="lname_display"></div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Last Name</small></div>
              <hr class="noborder green"> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="number_display">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Contact Number</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
                <div class="col-md-12 black wide" id="sex_display">&nbsp;</div>
                <div class="col-md-12 wide"><hr class="noborder"><small>Sex</small></div>
              <hr class="noborder green"> 
              </div>
              <div class="col-md-4">         
              <hr class="noborder green"> 
              </div>
              <div class="col-md-12">  
                <div class="col-md-12 black wide" id="resbakuna_date">&nbsp;</div>
                <div class="col-md-12 black wide" id=""><hr class="noborder"><small>Date Registered</small></div>
              <hr class="noborder green" id> 
              </div>
            </div>
            <hr class="noborder green">
            <div class="row">         
              <div class="col-md-12">         
                <div class="col-md-12 black wide" id="address_display">&nbsp;</div>
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

<div class="modal" id="info_modal" role="dialog" tabindex="-1"
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
      <div class="modal-body">
        <div>
          <h5 class="alert alert-info">For your clarifications and concerns you may reach the Information and Communication Systems Office through:</h5>
          <h5>Facebook Page: <a href='https://www.facebook.com/MGLB-Information-and-Communication-Systems-Office-ICSO-106964871173349'><i class="fab fa-facebook-square" aria-hidden="true"></i> MGLB ICSO</a></h5>
          <h5>GMAIL: <u style="color: blue;"><i class="fab fa-google" aria-hidden="true"> </i>mglbicso2020@gmail.com</u></h5>
          <h5>Land Line: <u style="color: blue;">530-2952 Local 108</u></h5>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal" id="birthday_modal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
            <!-- Modal Header -->
      <div class="modal-header">
          <button type="button" class="close" 
             data-dismiss="modal">Confirmation
                 <span aria-hidden="true">&times;</span>
                 <span class="sr-only">Close</span>
          </button>
      </div>              
      <!-- Modal Body -->
      <div class="modal-body">
        <div class="form-row">
           <div class="form-group col-md-2">
            <label class="red">Confirm Birthday:</label>
           </div>
           <div class="form-group col-md-5">
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="hidden" id="qrcode_verify" name="qrcode_verify">
              <input type="text" id="cbirthday" name="cbirthday" placeholder="Date of Birth" class="form-control datepicker readonly"  required>
            </div>
          </div>
          <div class="form-group col-md-5">
            <div class="form-group input-group">
              <div class="input-group-prepend">
                <span class="input-group-text red"><i class="fa fa-calendar"></i></span>
              </div>
              <input type="number" id="cbirthyear" name="cbirthyear" placeholder="Birth Year" class="form-control" required="required" type="text" min="1900" max="2021" onKeyPress="if(this.value.length==4) return false;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button id="close_modal" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Close</button>
          <button id="submitBtn" class="btn btn-primary"><i class="fa fa-check"></i> Confirm</button>
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

  $('#submitBtn').click(function(){
    var birthday = $('#cbirthday').val() + ' ' + $('#cbirthyear').val();
    var qrcode_verify = $('#qrcode_verify').val();
    if(birthday!==' '){
      get_details(qrcode_verify,birthday);
    }else{
      toastr.warning('Please input birthday!');
    }
  })
});
</script>

