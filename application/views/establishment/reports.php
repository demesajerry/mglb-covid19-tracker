<style>
#loader {
    position: fixed;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
.disable{
  pointer-events: none;
  opacity: 0.4;
} 
table.dataTable {
  border-collapse: collapse !important;
}
</style>
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800"><i class="fa fa-folder"></i> REPORTS</h1>
    </div>
    <!-- Content Row -->
    <div class="row" id="main_div">
      <!--DISPLAY-->
      <div class="col-md-12 mb-4">
        <form id="form1">
          <div class="row">
            <div class="col-sm-1">
            </div>

            <div class="col-md-3">
              <div class="col-md-12">
              <label>Client:</label>
              </div>
              <div class="col-md-12">
                <select name="client_id" id="client_id" class="form-control select2">
                  <option value="">Select Client</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="col-md-12">
                <label>Establishment:</label>
              </div>
              <div class="col-md-12">
                <select name="est_id" id="est_id" class="form-control select2">
                  <option value="">Select Establishment</option>
                </select>
              </div>
            </div>

            <div class="col-md-3">
              <div class="col-md-12">
                <label>Date of Visit:</label>
              </div>
              <div class="col-md-12">
                <input type="text" id="dov" class="form-control daterange">
              </div>
            </div>

            <div class="col-md-2 float-right">
              <div class="col-md-12">
                <br>
              </div>
              <a href="#" id="btn-filter" class="btn btn-success btn-icon-split">
                  <span class="icon text-white-50">
                      <i class="fas fa-check"></i>
                  </span>
                  <span class="text">Generate</span>
              </a>
            </div>
          </div>
        </form>
        <hr>

      </div>
      <div class="col-lg-12 mb-4">
        <!-- Project Card Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Generated Report</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="viewresult" style="width: 100%">
                  <thead id="thead" class="thead-dark">
                    <tr>
                      <td>No.</td>
                      <td>First Name</td>
                      <td>Last Name</td>
                      <td>Establishment Visited</td>
                      <td>Date</td>
                      <td>Time</td>
                      <td>Status on visit</td>
                    </tr>
                  </thead>
                  <tbody id="tbody">
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
      <!-- /.container-fluid -->
    </div>
  </div>
</div>
<script>

$(document).ready(function() {
  table = $('#viewresult').DataTable({ 
    "processing": true, //Feature control the processing indicator.
    "serverSide": true, //Feature control DataTables' server-side processing mode.
    "order": [[ 0, "DESC" ]], //Initial no order.
    responsive: true,
    "aLengthMenu": [[5, 10, 20, 50], [5, 10, 20, 50]],
    "iDisplayLength": 10,
    dom: 'Blfrtip',
    select: true,
    "ajax": {
      "url": "<?php echo site_url('Est_reports/ajax_list')?>",
      "type": "POST",
      "data": function ( data ) {
        data.client_id = $('#client_id').val();
        data.est_id = $('#est_id').val();
        data.dov = $('#dov').val();
      },
      "dataSrc": function(json){
        return json.data;
      }
    },
    //Set column definition initialisation properties.
    "columnDefs": [
      { 
        "orderable": false, //set not orderable
      },
    ],
    buttons: [
            {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER UPLB COMMUNITY LOGS',
            }
        ]
  // createdRow: function( row, data, dataIndex ) {
  // }
  });
   // $('#viewresult_filter input').unbind();
   // $('#viewresult_filter input').bind('keyup', function(e) {
   //     if(e.keyCode == 13) {
   //      table.search(this.value).draw();   
   //  }
   // }); 
  $('#btn-filter').click(function(){ //button filter event click
    table.ajax.reload();  //just reload table 
  }); 

 $("#client_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_clients",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      group_id: ''
    };
   },
processResults: function (data) {
  //add ALL to array
  if(data.length >= 20 ){
  data.unshift({
    fullname : 'ALL', 
    id : ''
  });
}
            return {
                results: $.map(data, function (item) {
                    return {
                        text: item.fullname,
                        id: item.id
                    }
                })
            };
        }
    }
 });

 $("#est_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>Est_reports/uplb_est",
   type: "post",
   dataType: 'json',
   delay: 250,
   data: function (params) {
    return {
      search: params.term, // search term
      est_id: '', // search term
    };
   },
  processResults: function (data) {
    //add ALL to array
      data.unshift({
        name : 'ALL', 
        id : ''
      });
      return {
        results: $.map(data, function (item) {
          return {
            text: item.name,
            id: item.id
          }
        })
      };
    }
  }
 });
});
</script>
<!--DATERANGE PICKER -->
<script src="<?php echo base_url(); ?>assets/js/daterange/moment.min.js"></script>

