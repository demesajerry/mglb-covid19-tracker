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
        Categories
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Categories</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_client_count" id="form1" method="post" target="_blank" >
                        <div class="col-md-5"> 
                        </div>
                        <div class="col-md-2"> 
                          <label>Vaccine</label>
                            <select id="vac_manufacturer" name="vac_manufacturer" class="form-control select2 required">
                              <option value="" selected>Select Answer</option>
                              <?php foreach($vaccines as $val){ ?>
                                <option value="<?= $val->vaccine_id; ?>"><?= $val->brand; ?></option>
                              <?php } ?>
                             </select>
                        </div>
                        <div class="col-md-2"> 
                          <label>Dose</label>
                          <select name="dose" id="dose" class="form-control">
                            <option value="0">ALL</option>
                            <option value="1">Dose 1</option>
                            <option value="2">Dose 2</option>
                          </select>
                        </div>
                        <!-- <div class="col-md-3">
                        <label>Establishment: </label> 
                        <select name="est_id" id="est_id" class="select2" style="width: 100%">
                          <option selected disabled>Select Establishment</option>
                        </select>
                        </div> -->
                        <div class="col-md-2">
                        <label>Date of Vaccination: </label> 
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
                        <td>A1 - Health Worker / Frontliners</td>
                        <td>A1.8 - OFW</td>
                        <td>A2 - Senior Citizen</td>
                        <td>A3 - 18-59 With Comorbidities</td>
                        <td>A4</td>
                        <td>A5</td>
                        <td>Others</td>
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
  url: "<?php echo base_url().'Reports/get_vac_category'; ?>",
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
        $('.date_title').html(`Vaccinated Clients`);
      var t1=0,t2=0,t3=0,te3=0,t4=0,t5=0,tb1=0,tb2=0,tb3=0,tb4=0,ta=0,t18=0,total_alert=0,num_vac, average=0,others=0,dose_text='', ta3=0;
      table.clear();
      chart.options.data[0].dataPoints = [];
      chart.options.data[1].dataPoints = [];
      chart.options.data[2].dataPoints = []; 
      chart.options.data[3].dataPoints = [];  
      chart.options.data[4].dataPoints = [];  
      num_vac = data.tracks.length;
      piechart.options.data[0].dataPoints = [];
      //piechart.options.data.dataPoints = [];
       $.each(data.tracks, function(key, val){
        average += parseInt(val.total);
       });
       average = average/num_vac;
       $.each(data.tracks, function(key, val){
        t1 += parseInt(val.A1);
        t18 += parseInt(val.A18);
        t2 += parseInt(val.A2);
        t3 += parseInt(val.A3);  
        te3 += parseInt(val.EA3);  
        t4 += parseInt(val.A4) + parseInt(val.B1) + parseInt(val.B2) + parseInt(val.B3)+parseInt(val.B4)+parseInt(val.others);  
        t5 += parseInt(val.A5);  
        others += parseInt(val.others);  
        ta += parseInt(val.total);
        ta3 += parseInt(val.A4);
        table.row.add([ val.date, 
                      val.A1.toLocaleString(),
                      val.A18.toLocaleString(),
                      val.A2.toLocaleString(),
                      val.A3.toLocaleString(), 
                      val.A4.toLocaleString(), 
                      val.A5.toLocaleString(), 
                      val.others.toLocaleString(), 
                      val.total.toLocaleString() 
                  ]).draw( false );

          chart.options.data[0].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A1.toLocaleString()),color:'#0000FF', lineColor: '#0000FF', markerColor: "#0000FF"});
          chart.options.data[1].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A18.toLocaleString()),color:'#FFFF00', lineColor: '#FFFF00', markerColor: "#FFFF00"});
          chart.options.data[2].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A2.toLocaleString()),color:'#808080', lineColor: '#808080', markerColor: "#808080" });
          chart.options.data[3].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A3.toLocaleString()),color:'#008000', lineColor: '#008000', markerColor: "#008000" });
          chart.options.data[4].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A4.toLocaleString()),color:'#800000', lineColor: '#800000', markerColor: "#800000" }); 
          chart.options.data[5].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.A5.toLocaleString()),color:'#FFA500', lineColor: '#FFA500', markerColor: "#FFA500" }); 
          chart.options.data[6].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.total.toLocaleString()),color:'#000000', lineColor: '#000000', markerColor: "#000000" }); 
        })
      $('#tfoot').html(`<tr style='bgcolor:yellow;'>
                          <td>Total</td>
                          <td>${t1.toLocaleString()}</td>
                          <td>${t18.toLocaleString()}</td>
                          <td>${t2.toLocaleString()}</td>
                          <td>${t3.toLocaleString()}</td>
                          <td>${t4.toLocaleString()}</td>
                          <td>${t5.toLocaleString()}</td>
                          <td>${others.toLocaleString()}</td>
                          <td>${ta.toLocaleString()}</td> 
                        </tr>`);

      piechart.options.data[0].dataPoints.push(
                {label: `A1 Health Worker / Frontliners( ${parseInt(t1).toLocaleString()} )`, y: percentage(parseInt(t1),parseInt(ta)), color: '#0000FF', indexLabelFontColor:'#0000FF'},
                {label: `A1.8 OFW( ${parseInt(t18).toLocaleString()} )`, y: percentage(parseInt(t18),parseInt(ta)), color: '#FFFF00', indexLabelFontColor:'#FFFF00'},
                {label: `A2 Senior Citizen( ${parseInt(t2).toLocaleString()} )`, y: percentage(parseInt(t2),parseInt(ta)), color: '#808080', indexLabelFontColor:'#808080'},
                {label: `A3 18-59 With Comorbidities( ${parseInt(t3).toLocaleString()} )`, y: percentage(parseInt(t3),parseInt(ta)), color: '#008000', indexLabelFontColor:'#008000'},
                {label: `A4( ${parseInt(t4).toLocaleString()} )`, y: percentage(parseInt(t4),parseInt(ta)), color: '#800000', indexLabelFontColor:'#800000'},
                {label: `A5( ${parseInt(t5).toLocaleString()} )`, y: percentage(parseInt(t5),parseInt(ta)), color: '#FFA500', indexLabelFontColor:'#FFA500'},
                );
  $('#chartContainer').show();
  $('#piechartContainer').show();
    if($('#dose').val()==1){
      dose_text = "(DOSE 1)";
    }
    if($('#dose').val()==2){
      dose_text = "(DOSE 2)";
    }
      chart.options.title.text=`Vaccination per Category ${dose_text}`;
      chart.render();

      piechart.options.title.text=`Vaccination per Category ${dose_text}`;
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
      name: "A1 Health Worker / Frontliners",
      color: '#0000FF',
      showInLegend: true,
      dataPoints: [
      ]
    }, 
      {        
      type: "line",
      showInLegend: true,
      name: "A1.8 OFW",
      color: '#FFFF00',
      showInLegend: true,
      dataPoints: [
      ]
    }, 
    {        
      type: "line",
      showInLegend: true,
      name: "A2 Senior Citizen",
      color: '#808080',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "A3 18-59 With Comorbidities",
      color: '#008000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "A4 Economic frontliner",
      color: '#800000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "A5 Indigent Population",
      color: '#FFA500',
      showInLegend: true,
      dataPoints: [
      ]
    },
     
    {        
      type: "line",
      showInLegend: true,
      name: "Total",
      color: '#000000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    // {        
    //   type: "line",
    //   showInLegend: true,
    //   name: "Average",
    //   color: 'black',
    //   showInLegend: true,
    //   dataPoints: [
    //   ]
    // },
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
