<style>
  .ui-datepicker-calendar {
        display: none;
    }
    .box-tools{
        width: 900px;
        padding: 0;
    }
    .filters{
        padding: 0;
    }
    .txt-bottom{
        vertical-align:bottom !important;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Health Declaration
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Health Declaration</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_client_count" id="form1" method="post" target="_blank" >
                        <div class="col-md-3"> 
                        <label>Client: </label> 
                          <select name="client_id" id="client_id" class="select2" style="width: 100%">
                            <option selected disabled>Select Client</option>
                          </select>
                        </div>
                        <div class="col-md-3">
                        <label>Symptoms Declared: </label> 
                        <select name="symptoms_id" id="symptoms_id" class="select2" style="width: 100%;" required>
                          <option value="" selected disabled>Select Symptoms</option>
                            <?php foreach($symptoms_list as $symptom){ ?>
                          <option value="<?= $symptom->c_symptom_id; ?>">
                            <?= $symptom->c_symptom; ?>
                          </option>
                            <?php } ?>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label>Onset Date: </label> 
                        <input type="text" name="date" class="form-control daterange" placeholder="Start and End Date" />
                        </div>
                        <div class="col-md-2">
                        <label>Date Declared: </label> 
                        <input type="text" name="date_declared" class="form-control daterange" placeholder="Start and End Date" />
                        </div>
                        <div class="col-md-1"><br>
                          <button class="btn btn-primary" id="generate">Generate</button>
                        </div>
                      </form>
                     </div>
                   </div>
                </div>

                <div class="box">
                    <div class="box-header">
                    <h3 class="box-title date_title">CLIENT COUNT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>Client Name</td>
                        <td>Contact Number</td>
                        <td>Address</td>
                        <td>Symptom</td>
                        <td>Date Declared</td>
                        <td>Onset Date</td>
                        <td>Date Recovered</td>
                      </tr>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                    <tfoot id="tfoot">
                    </tfoot>
                  </table>
                </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
$('#loader').hide();
var client;
function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'Reports/get_health_dec'; ?>",
  data: $("#form1").serializeArray(),
  beforeSend: function() {
    tr = `<tr id="loader">
                <td colspan="41">
                  <div class="callout callout-info"><p><i class="fa fa-circle-o-notch fa-spin"></i> Loading Data...</p></div>
                </td>
            </tr>`;
    $('#tbody').html(tr);
  },
  complete: function(){
    $('#loader').hide();
  },
  //data:formData,
    success: function(data){ 
        $('.date_title').html(`Client with Symptoms`);
      var tr ='',total_male=0,total_female=0,total_all=0,tfoot,fullname,datetime;
      table.clear();
       $.each(data.tracks, function(key, val){
        address = `${val.address} ${val.brgyDesc} ${val.citymunDesc}`;
        datetime = convert_datetime(val.datetime);
        table.row.add([ val.fullname,
                      val.contact_number,
                      address,
                      val.symptom,
                      val.date_changed,
                      val.onset_date,
                      val.date_recovered
                  ]).draw( false );
        })         
    }
});
}

$('#generate').click(function(e){
  e.preventDefault();
  client = $("#client_id option:selected").text();
  get_data();
})

$('.daterange').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('Y-MM-DD') + ' - ' + picker.endDate.format('Y-MM-DD'));
  });

    var table = $('#viewresult').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 5,
    "aaSorting": [],
    buttons:[
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Health Declarations',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER Health Declarations',
              }
            ]
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
});
</script>
