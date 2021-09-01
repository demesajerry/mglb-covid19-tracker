<style>
  #bgimg{
    position: relative;
  }
  .vac_card_display{

  }
  .full_name{
    position: absolute;
    left: 16mm;
    top: 86mm;
    font-family: "Times New Roman", Times, serif;
    font-size: 14;
    font-weight: bold;
  }
  .bday{
    position: absolute;
    left: 29mm;
    top: 45mm;
    font-family: "Times New Roman", Times, serif;
    font-size: 14;
    font-weight: bold;
  }
  .sex{
    position: absolute;
    left: 90mm;
    top: 45mm;
    font-family: "Times New Roman", Times, serif;
    font-size: 14;
    font-weight: bold;
  }
  .address{
    position: absolute;
    left: 29mm;
    top: 53mm;
    font-family: "Times New Roman", Times, serif;
    font-size: 14;
    font-weight: bold;
  }
  .idno{
    position: absolute;
    left: 105mm;
    top: 71mm;
    font-family: "Times New Roman", Times, serif;
    font-size: 14;
    font-weight: bold;
  }
</style>
<!---- MODAL DISABLE-->
<div class="modal fade" id="vac_card_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-info no-print">
        <h4>
          <p id="vac_card_title"></p>
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </h4>
      </div>
      <!--Modal Body For Update -->
      <div class="modal-body table-responsive">
        <div class="vac_card_display">
          <p class="full_name"></p>
          <p class="bday"></p>
          <p class="sex"></p>
          <p class="address"></p>
          <p class="idno"></p>
          <img src="<?php echo base_url('assets/images/bg/vaccard3.png'); ?>" id='vaccard_img' id='bgimg'/>
        </div>
        <form action="<?= base_url('Vac_card/print_vc'); ?>" method="POST" target="_blank">
          <input type="hidden" name="userid" id="userid">
          <div class="modal-footer no-print" align="right">
            <div class="form-group">
              <div class="col-sm-12" align="right">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                  <i class="fa fa-times fa-lg"></i>&nbsp; Cancel
                </button>
                <button id="confirm_print" class="btn btn-info pull-right"><i class="fa fa-check fa-lg"></i>&nbsp; Confirm</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
