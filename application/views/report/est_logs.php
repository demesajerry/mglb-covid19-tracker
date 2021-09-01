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
        Establishment Logs
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Establishment Logs</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_client_count" id="form1" method="post" target="_blank" >
                        <div class="col-md-2"> 
                        </div>
                        <div class="col-md-1"> 
                        </div>
                        <div class="col-md-3">
                        <label>Establishment: </label> 
                        <select name="est_id" id="est_id" class="select2" required="required" style="width: 100%">
                          <option selected disabled>Select Establishment</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label>Log Date: </label> 
                        <input type="text" name="date" class="form-control daterange" placeholder="Start and End Date" />
                        </div>
                        <div class="col-md-2">
                        <label>Alert: </label> 
                          <select name="alert" id="alert" class="select2" style="width: 100%">
                            <option value="">ALL</option>
                            <option value="0">No alert</option>
                            <option value="1">With Alert</option>
                          </select>
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
                    <h3 class="box-title date_title"></h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td width="50%">Establishment</td>
                        <td width="20%">Date</td>
<!--                         <td width="15%">Time</td>
 -->                        
                        <td width="10%">Normal Scans</td>
                        <td width="10%">Scans with Alert</td>
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

<!--             <div class="box">
              <div id="chartContainer" style="height: 370px; max-width: 1300px; margin: 0px auto;"></div>
            </div>
 -->    </section>
</div>

<script>
$(document).ready(function() {
var dataPoints = [];
$('#loader').hide();
var client;
function percentage(num, total)
{
  return (num/total)*100;
}

function get_data(){
  var est_id = $('#est_id').val();
  var daterange = $('.daterange').val();
  if(est_id==null|| daterange==''){
    alert('Establishment And Log Date is required');
  }else{
    $.ajax({
      type: "POST",
      url: "<?php echo base_url().'Reports/get_est_logs'; ?>",
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
          //$('.date_title').html(`Client with Close Contact`);
          if(data.error_log==''){
            var name, date_log, time_log, datetime;
            table.clear();
            // chart.options.data[0].dataPoints = [];
            $.each(data.tracks, function(key, val){
              datetime = val.datetime.split(' ');
              name = val.scanner_name == null?val.name:val.scanner_name;
              date_log = val.date_log == null?datetime[0]:val.date_log;
              // time_log = val.time_log == null?datetime[1]:val.time_log;
              table.row.add([ name,
                            date_log,
                            // time_log,
                            val.normal_logs,
                            val.alert_logs,
                        ]).draw( false );
          // chart.options.data[0].dataPoints.push({label: date_log,  y: parseInt(val.normal_logs),color:'#FA8072', lineColor: '#FA8072', markerColor: "#FA8072"});
            })
          // chart.options.title.text=`Establishment Logs`;
          // chart.render();
          }else{
          $('.date_title').html(data.error_log);
          }
        }
    });
  }
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
                title: 'MGLB-COVID19-TRACKER ESTABLISHMENT LOGS',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER ESTABLISHMENT LOGS',
              },
            ]
    });

 $("#est_id").select2({
  ajax: { 
   url: "<?php echo base_url(); ?>General/get_not_member",
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
    // add ALL to array
    if(data.length >= 20 ){
      data.unshift({
        name : 'ALL', 
        id : ''
      });
    }
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

  // var chart = new CanvasJS.Chart("chartContainer", {
  //   animationEnabled: true,
  //   theme: "light2",
  //   title:{
  //     text: "CLIENT DAILY COUNT",
  //   },
  //   subtitles:[
  //     {
  //       text: '',
  //       //Uncomment properties below to see how they behave
  //       //fontColor: "red",
  //       //fontSize: 30
  //     },
  //     ],
  //   axisY:{
  //     includeZero: false
  //   },
  //   axisX: {
  //     interval: 5
  //   },
    
  //   toolTip: {
  //     shared: true
  //   },
  //   data: [
  //     {        
  //     type: "line",
  //     showInLegend: true,
  //     name: "Below 20",
  //     color: '#FA8072',
  //     showInLegend: true,
  //     color: '#FA8072',
  //     dataPoints: [
  //     ]
  //   }, 
  //   ]
  // });
});
</script>
<!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script>
 -->