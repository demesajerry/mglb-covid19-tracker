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
        Vaccine
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Vaccine</li>
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
                        <div class="col-md-3"> 
                        </div>
                        <!-- <div class="col-md-3">
                        <label>Establishment: </label> 
                        <select name="est_id" id="est_id" class="select2" style="width: 100%">
                          <option selected disabled>Select Establishment</option>
                        </select>
                        </div> -->
                        <div class="col-md-3">
                          <label>Date of Vaccination: </label> 
                          <input type="text" name="date" class="form-control daterange" placeholder="Start and End Date" />
                        </div>
                        <div class="col-md-1"> 
                          <label>Dose </label>
                            <select id="dose" name="dose" class="form-control select2 required">
                              <option value="" selected>ALL</option>
                              <option value="1">1st Dose</option>
                              <option value="2">2nd Dose</option>
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
                    <h3 class="box-title date_title">CLIENT COUNT</h3>
                    </div>
                <div class="box-body table-responsive">
                  <div id="toprint">
                  <table class="table table-striped table-bordered table-hover" id="viewresult">
                    <thead id="thead">
                      <tr>
                        <td>Date</td>
                        <td>Sinovac</td>
                        <td>Astrazeneca</td>
                        <td>SputniK V</td> 
                        <td>Pfizer</td>
                        <td>TOTAL</td> 
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

              <div class="box">
                <div id="chartContainer" style="height: 370px; max-width: 2220px; margin: 0px auto;"></div>
              </div> 
              <div class="box">
                <div id="piechartContainer" style="height: 600px; max-width: 1320px; margin: 0px auto;"></div>
              </div>
            </div>
    </section>
</div>

<script>  
$(document).ready(function() {
  $('#chartContainer').hide();
  $('#piechartContainer').hide();

var dataPoints = [];
$('#loader').hide();
var client;
function percentage(num, total)
{
  return (num/total)*100;
}

function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'Reports/get_vaccine'; ?>",
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
        $('.date_title').html(`Vaccine Used`);
      var t1=0,t2=0,t3=0,t4=0,t5=0,t6=0,t7=0,ta=0,total_alert=0;
      table.clear();
      chart.options.data[0].dataPoints = [];
      chart.options.data[1].dataPoints = [];
      chart.options.data[2].dataPoints = []; 
      chart.options.data[3].dataPoints = [];   
      chart.options.data[4].dataPoints = []; 
      piechart.options.data[0].dataPoints = [];
      //piechart.options.data.dataPoints = [];
       $.each(data.tracks, function(key, val){
        t1 += parseInt(val.Vac1);
        t2 += parseInt(val.Vac2);
        t3 += parseInt(val.Vac3); 
        t4 += parseInt(val.Vac4); 
        ta += parseInt(val.total);

        table.row.add([ val.date, 
                      val.Vac1.toLocaleString(),
                      val.Vac2.toLocaleString(),
                      val.Vac3.toLocaleString(),
                      val.Vac4.toLocaleString(), 
                      val.total.toLocaleString() 
                  ]).draw( false );

          chart.options.data[0].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.Vac1.toLocaleString()),color:'#FA8072', lineColor: '#FA8072', markerColor: "#FA8072"});
          chart.options.data[1].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.Vac2.toLocaleString()),color:'#0000FF', lineColor: '#0000FF', markerColor: "#0000FF" });
          chart.options.data[2].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.Vac3.toLocaleString()),color:'#808000', lineColor: '#808000', markerColor: "#808000" });
          chart.options.data[3].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.Vac4.toLocaleString()),color:'#DC143C', lineColor: '#DC143C', markerColor: "#DC143C" }); 
          chart.options.data[4].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.total.toLocaleString()),color:'#98DFF6', lineColor: '#98DFF6', markerColor: "#98DFF6" }); 
        })
      $('#tfoot').html(`<tr style='bgcolor:yellow;'>
                          <td>Total</td>
                          <td>${t1.toLocaleString()}</td>
                          <td>${t2.toLocaleString()}</td>
                          <td>${t3.toLocaleString()}</td>
                          <td>${t4.toLocaleString()}</td>
                          <td>${ta.toLocaleString()}</td> 
                        </tr>`);

      piechart.options.data[0].dataPoints.push(
                {label: `Sinovac( ${parseInt(t1).toLocaleString()} )`, y: percentage(parseInt(t1),parseInt(ta)), color: '#FA8072', indexLabelFontColor:'#FA8072'},
                {label: `Astrazeneca( ${parseInt(t2).toLocaleString()} )`, y: percentage(parseInt(t2),parseInt(ta)), color: '#0000FF', indexLabelFontColor:'#0000FF'},
                {label: `Gamaleya SputniK V( ${parseInt(t3).toLocaleString()} )`, y: percentage(parseInt(t3),parseInt(ta)), color: '#808000', indexLabelFontColor:'#808000'},
                {label: `Pfizer( ${parseInt(t4).toLocaleString()} )`, y: percentage(parseInt(t4),parseInt(ta)), color: '#DC143C', indexLabelFontColor:'#DC143C'}
                );
  $('#chartContainer').show();
  $('#piechartContainer').show();

      chart.options.title.text=`Vaccine Used`;
      chart.render();

      piechart.options.title.text=`Vaccine Used`;
      piechart.render();                    
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
                title: 'MGLB-COVID19-TRACKER Vaccine Used',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER Vaccine Used',
              },
              {
                text: 'Download Line Chart',
                attr: { id: 'exportChart' }
              },            
              {
                text: 'Download Pie Chart',
                attr: { id: 'exportPieChart' }
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
    //add ALL to array
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

  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
      text: "CLIENT DAILY COUNT",
    },
    subtitles:[
      {
        text: '',
        //Uncomment properties below to see how they behave
        //fontColor: "red",
        //fontSize: 30
      },
      ],
/*    axisY:{
      includeZero: false
    },
    axisX: {
      interval: 5
    },
*/    
    toolTip: {
      shared: true
    },
    data: [
      {        
      type: "line",
      showInLegend: true,
      name: "Sinovac",
      color: '#FA8072',
      showInLegend: true,
      color: '#FA8072',
      dataPoints: [
      ]
    }, 
    {        
      type: "line",
      showInLegend: true,
      name: "Astrazeneca",
      color: '#0000FF',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "Gamaleya SputniK V",
      color: '#808000',
      showInLegend: true,
      dataPoints: [
      ]
    },

    {        
      type: "line",
      showInLegend: true,
      name: "Pfizer",
      color: '#DC143C',
      showInLegend: true,
      dataPoints: [
      ]
    },
     
    {        
      type: "line",
      showInLegend: true,
      name: "Total",
      color: 'black',
      showInLegend: true,
      dataPoints: [
      ]
    },
    ]
  });

  var piechart = new CanvasJS.Chart("piechartContainer", {
    animationEnabled: true,
    title: {
      text: "Desktop Search Engine Market Share - 2016"
    },
    data: [{
      type: "pie",
      startAngle: 240,
      yValueFormatString: "##0.00\"%\"",
      indexLabel: "{label} {y}",
      dataPoints: [],
    }]
  });
  $("#exportChart").on("click",function(){
      chart.exportChart({format: "jpg"});
    }); 
  $("#exportPieChart").on("click",function(){
      piechart.exportChart({format: "jpg"});
    }); 
});
  
 
</script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-1.12.4.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script>
