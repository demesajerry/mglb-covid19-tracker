<style type="text/css">
  .full_name{
    margin: -180px 0 40px 50px;
  }
  html,body
{
    width: 100%;
    height: 100%;
    margin: 0px;
    padding: 0px !important;
    overflow-x: hidden; 
}
  .badge-info{
    background-color: #17a2b8;
  }
  .badge-danger{
    background-color: #007bff;
  }
  .badge-success{
    background-color: #28a745;
  }
  .toolbar{
    position: relative;
    display: inline-block;
    vertical-align: middle;
  }
  .red{
    box-shadow: 0 0 3px #CC0000;
  }
 /* placeholder color*/
.red::-webkit-input-placeholder {
    color: #ff8080
}
.disable{
  pointer-events: none;
  opacity: 0.4;
}
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 1s linear infinite;
  position: fixed;
  top: 50%;
  left: 50%;
  margin-top: -50px;
  margin-left: -100px;
  -webkit-transform: translate(-50%, -50%);
  transform: translate(-50%, -50%);
  z-index: 9999 !important;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<div class="content-wrapper">
<!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><i class="fa fa-syringe"></i> <?= $title_page; ?></h1>
    <ol class="breadcrumb">
      <li class="active">Client Vaccination</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="panel-body">
            <form id="form-filter" class="form-horizontal">
              <div class="col-md-2"> 
                <label>Province</label>
                <select id="provCode" name="provCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select Province</option>
                  <option value="">ALL</option>
                  <?php foreach($prov_list as $prov){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $prov->provCode ?>" <?= ($prov->provCode == '434')?'selected':''; ?>> <?= $prov->provDesc ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2"> 
                <label>Municipality/City</label>
                <select id="citymunCode" name="citymunCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select City / Municipality</option>
                  <option value="">All</option>
                  <?php foreach($municipality_list as $mun){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $mun->citymunCode ?>" <?= ($mun->citymunCode == '43411')?'selected':''; ?>> <?= $mun->citymunDesc ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-2">  
                <label>Brgy</label>
                <select id="brgyCode" name="brgyCode" class="form-control select2" required="required">
                  <option value="" disabled selected>Select Brgy</option>
                  <?php foreach($brgy_list as $val){ ?>
                  <!--Initial selected is LAGUNA ProvCode=0434-->
                    <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                  <?php } ?>
                </select> 
              </div> 
              <div class="col-md-2"> 
                <label>Reply</label>
                <select name='sched_rep' id='sched_rep' class="form-control select2">
                  <option value="" selected>ALL</option>
                    <option value="0" >No Reply</option>
                    <option value="1" >With reply - NO</option>
                    <option value="2" >With reply - YES</option>
                </select>  
              </div> 
              <div class="col-md-2"> 
                <label>Arrived?</label>
                <select name='arrived' id='arrived' class="form-control select2">
                  <option value="" selected>ALL</option>
                    <option value="1" >Yes</option>
                    <option value="0" >No</option>
                </select>  
              </div> 
              <div class="col-md-1"> 
                <br>
                <button type="button" id="btn-reset" class="btn btn-warning"><i class='fa fa-undo'></i> &nbsp; Reset</button>
              </div>
              <div class="col-md-1"> <br> 
                <button type="button" id="btn-filter" class="btn btn-primary"><i class='fa fa-filter'></i> &nbsp; Filter</button>
              </div> 
            </form>   
          </div> 
        </div>
        <!--START TABLE-->
        <div class="box">
          <div class="alert alert-danger" style="display: none; width: 900px;">
          </div>
          <div class="box-body table-responsive">
            <table id="table" class="table table-striped table-bordered">
              <thead>
                  <tr>
                    <th width="15%">Full Name</th>
                    <th width="5%">Barangay</th>
                    <th width="5%">Age</th>
                    <th width="5%">with Commorbidity</th>
                    <th width="5%">Contact</th>
                    <th width="5%"><?= $fifth_col ?></th>
                    <th width="5%">Schedule</th>
                    <th width="5%">Time</th>
                    <th width="5%">Text Status</th>
                    <th width="5%">Reply</th>
                    <th width="5%">Action</th>
                  </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
            <div class="loader"></div>
          </div> 
        </div>
      </div>
    </div>
  </section>
  </div>
<script type="text/javascript"> 
  var save_method; //for save method string
  var table, bulk_tbl, bulk_schedTbl, vac_manufacturer_bulk, tbl_reminder;
  const dose = "<?= $dose; ?>";
  const dose_text = "<?= $dose_text; ?>";
  const year = new Date().getFullYear();
  let selected_rowsID = [];
  let selected_rowsName = [];

  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }  

  $(document).ready(function(){

    $('#update_message').hide();
    //datatables
    table = $('#table').DataTable({ 
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "ordering": false,
      responsive: true,
      "aLengthMenu": [[5, 10, 20, 50,-1], [5, 10, 20, 50,'ALL']],
      buttons:[
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Health Declarations',
              },
            ],
      "iDisplayLength": 10,
      //add toolbar div after button
      dom: 'lB<"toolbar">frtip',
      select: true,
      "ajax": {
        "url": "<?php echo site_url('Vac_list/list_client_today')?>",
        "type": "POST",
        "data": function ( data ) {
          data.provCode = $('#provCode').val();
          data.citymunCode = $('#citymunCode').val();
          data.brgyCode = $('#brgyCode').val();
          data.vac_date = "<?php echo date('F d, Y'). ' - '.date('F d, Y'); ?>";
          data.text_status = "1";
          data.sched_rep = $('#sched_rep').val();
          data.dose = dose;
          data.age_bracket = $('#age_bracket').val();
          data.with_comorbidity = $('#with_comorbidity').val();
          data.fvd = $('#fvd').val();
          data.time_schedule = $('#time_schedule').val();
          data.category = $('#category').val();
          data.vaccine_used = $('#vaccine_used').val();
          data.arrived = $('#arrived').val();
        },
        "dataSrc": function(json){
          return json.data;
        }
      },
   
      //Set column definition initialisation properties.
      "columnDefs": [
        { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
        },
      ],
      createdRow: function( row, data, dataIndex ) {
        // Set the data-status attribute, and add a class
        if(data[9]=='NO'){
              $(row).find('td:eq(9)').addClass("label-warning");
        }else if(data[9]=='YES'){
              $(row).find('td:eq(9)').addClass("label-info");
        }else if(data[11]!=null && data[6]!=''){
              $(row).find('td:eq(9)').addClass("label-danger");
        }
        if(data[13] == '1' || data[13] == '2' ){
              $(row).find('td:eq(0)').addClass("label-success");
        }
      }
    });

    $('#btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table 
    }); 

      $('#btn-reset').click(function(e){ //button reset event click
        $('#form-filter')[0].reset();
          table.ajax.reload();  //just reload table  
          $('#provCode').select2().val("434"); 
          $('#citymunCode').select2().val("43411"); 
          $('#brgyCode').select2().val(""); 
      });    

    $("form").keypress(function(e) {
    //Enter key
      if (e.which == 13) {
        return false;
      }
    });  

    $('.loader').hide();

    $('#table').on('click','.arrived', function(){
      var userid = this.getAttribute('userid');
      var client_name = this.getAttribute('client_name');
      $('#userid').val(userid);
      $('#client_name').html(`<h4><strong><u>${client_name}</u></strong></h4>`);

      $('#arrived_modal').modal('show');
    })

    $('#confirm_arrival').click(function(e){
      e.preventDefault();
      var userid =$('#userid').val();
      $.ajax({
          url : "<?= base_url();?>Vac_list/update_arrival",
          type: "POST",
          data: {userid:userid, dose:dose},
          dataType: "JSON",
          success: function(data)
          {
            toastr.info('Client Arrival has been updated!');
            table.ajax.reload(null, false);
            $('#arrived_modal').modal('hide');
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
          }
      });
    })
});
</script>
<?php  $this->load->view('vaccination/modal/client_today'); ?>
