<!---- MODAL DISABLE-->
<div class="modal fade" id="arrived_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header alert alert-info">
        <h4>
          Confirm client arrival
        <button type="button" class="close" data-dismiss="modal">
          <span aria-hidden="true">&times;</span>
          <span class="sr-only">Close</span>
        </button>
      </h4>
      </div>
      <!--Modal Body For Update -->
      <div class="modal-body table-responsive">
        <div id="client_name">
        </div>
        <input type="hidden" name="userid" id="userid">
        <div class="modal-footer" align="right">
          <div class="form-group">
            <div class="col-sm-12" align="right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="fa fa-times fa-lg"></i>&nbsp; Cancel
              </button>
              <button id="confirm_arrival" class="btn btn-info pull-right"><i class="fa fa-check fa-lg"></i>&nbsp; Confirm</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
