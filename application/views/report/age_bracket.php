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
        Age Bracket
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
                        <div class="col-md-2"> 
                        </div>
                        <div class="col-md-3"> 
                        </div>
                        <div class="col-md-3">
                        <label>Establishment: </label> 
                        <select name="est_id" id="est_id" class="select2" style="width: 100%">
                          <option selected disabled>Select Establishment</option>
                        </select>
                        </div>
                        <div class="col-md-3">
                        <label>Date of Visit: </label> 
                        <input type="text" name="date" class="form-control daterange" placeholder="Start and End Date" />
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
                        <td>Below 20</td>
                        <td>21-29</td>
                        <td>30-39</td>
                        <td>40-49</td>
                        <td>50-59</td>
                        <td>60-65</td>
                        <td>65 Above</td>
                        <td>With Alert</td>
                        <td>Total</td>
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
  url: "<?php echo base_url().'Reports/get_age_bracket'; ?>",
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
        $('.date_title').html(`Client with Close Contact`);
      var t1=0,t2=0,t3=0,t4=0,t5=0,t6=0,t7=0,ta=0,total_alert=0;
      table.clear();
      chart.options.data[0].dataPoints = [];
      chart.options.data[1].dataPoints = [];
      chart.options.data[2].dataPoints = [];
      chart.options.data[3].dataPoints = [];
      chart.options.data[4].dataPoints = [];
      chart.options.data[5].dataPoints = [];
      chart.options.data[6].dataPoints = [];
      chart.options.data[7].dataPoints = [];
      piechart.options.data[0].dataPoints = [];
      //piechart.options.data.dataPoints = [];
       $.each(data.tracks, function(key, val){
        t1 += parseInt(val.ageb20);
        t2 += parseInt(val.age2129);
        t3 += parseInt(val.age3039);
        t4 += parseInt(val.age4049);
        t5 += parseInt(val.age5059);
        t6 += parseInt(val.age6065);
        t7 += parseInt(val.ageg66);
        total_alert += parseInt(val.alert_logs);
        ta += parseInt(val.total);
        table.row.add([ val.date,
                      val.ageb20.toLocaleString(),
                      val.age2129.toLocaleString(),
                      val.age3039.toLocaleString(),
                      val.age4049.toLocaleString(),
                      val.age5059.toLocaleString(),
                      val.age6065.toLocaleString(),
                      val.ageg66.toLocaleString(),
                      val.alert_logs.toLocaleString(),
                      val.total.toLocaleString()
                  ]);

          chart.options.data[0].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.ageb20.toLocaleString()),color:'#FA8072', lineColor: '#FA8072', markerColor: "#FA8072"});
          chart.options.data[1].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.age2129.toLocaleString()),color:'#0000FF', lineColor: '#0000FF', markerColor: "#0000FF" });
          chart.options.data[2].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.age3039.toLocaleString()),color:'#808000', lineColor: '#808000', markerColor: "#808000" });
          chart.options.data[3].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.age4049.toLocaleString()),color:'#008000', lineColor: '#008000', markerColor: "#008000" });
          chart.options.data[4].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.age5059.toLocaleString()),color:'#008080', lineColor: '#008080', markerColor: "#008080" });
          chart.options.data[5].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.age6065.toLocaleString()),color:'#FF0000', lineColor: '#FF0000', markerColor: "#FF0000" });
          chart.options.data[6].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.ageg66.toLocaleString()),color:'#DC143C', lineColor: '#DC143C', markerColor: "#DC143C" });
          chart.options.data[7].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.total.toLocaleString()),color:'#000000', lineColor: '#000000', markerColor: "#000000" });
        })
        table.draw();       
      $('#tfoot').html(`<tr style='bgcolor:yellow;'>
                          <td>Total</td>
                          <td>${t1.toLocaleString()}</td>
                          <td>${t2.toLocaleString()}</td>
                          <td>${t3.toLocaleString()}</td>
                          <td>${t4.toLocaleString()}</td>
                          <td>${t5.toLocaleString()}</td>
                          <td>${t6.toLocaleString()}</td>
                          <td>${t7.toLocaleString()}</td>
                          <td>${total_alert.toLocaleString()}</td>
                          <td>${ta.toLocaleString()}</td>
                        </tr>`);

      piechart.options.data[0].dataPoints.push(
                {label: `Below 20( ${parseInt(t1).toLocaleString()} )`, y: percentage(parseInt(t1),parseInt(ta)), color: '#FA8072', indexLabelFontColor:'#FA8072'},
                {label: `21-29( ${parseInt(t2).toLocaleString()} )`, y: percentage(parseInt(t2),parseInt(ta)), color: '#0000FF', indexLabelFontColor:'#0000FF'},
                {label: `30-39( ${parseInt(t3).toLocaleString()} )`, y: percentage(parseInt(t3),parseInt(ta)), color: '#808000', indexLabelFontColor:'#808000'},
                {label: `40-49( ${parseInt(t4).toLocaleString()} )`, y: percentage(parseInt(t4),parseInt(ta)), color: '#008000', indexLabelFontColor:'#008000'},
                {label: `50-59( ${parseInt(t5).toLocaleString()} )`, y: percentage(parseInt(t5),parseInt(ta)), color: '#008080', indexLabelFontColor:'#008080'},
                {label: `60-65( ${parseInt(t6).toLocaleString()} )`, y: percentage(parseInt(t6),parseInt(ta)), color: '#FF0000', indexLabelFontColor:'#FF0000'},
                {label: `66 Above( ${parseInt(t7).toLocaleString()} )`, y: percentage(parseInt(t7),parseInt(ta)), color: '#DC143C', indexLabelFontColor:'#DC143C'});
  $('#chartContainer').show();
  $('#piechartContainer').show();

      chart.options.title.text=`Age Bracket`;
      chart.render();

      piechart.options.title.text=`Age Bracket`;
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
                title: 'MGLB-COVID19-TRACKER Health Declarations',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER Health Declarations',
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
      name: "Below 20",
      color: '#FA8072',
      showInLegend: true,
      color: '#FA8072',
      dataPoints: [
      ]
    }, 
    {        
      type: "line",
      showInLegend: true,
      name: "21 - 29",
      color: '#0000FF',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "30 - 39",
      color: '#808000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "40 - 49",
      color: '#008000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "50 - 59",
      color: '#008080',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "60 - 65",
      color: '#FF0000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "66 Up",
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
