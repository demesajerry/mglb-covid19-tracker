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
        Per Brgy
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">Per Brgy</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form action="<?php echo base_url(); ?>reports/print_client_count" id="form1" method="post" target="_blank" >
                        <div class="col-md-7"> 
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
                        <td>BAYBAYIN</td>
                        <td>ANOS</td>
                        <td>BAGONG SILANG</td>
                        <td>BAMBANG</td>
                        <td>BATONG MALAKE</td>
                        <td>BAYOG</td>
                        <td>LALAKAY</td>
                        <td>MAAHAS</td>
                        <td>MALINTA</td>
                        <td>MAYONDON</td>
                        <td>SAN ANTONIO</td>
                        <td>TADLAC</td>
                        <td>TIMUGAN</td>
                        <td>TUNTUNGIN-PUTHO</td> 
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
  url: "<?php echo base_url().'Reports/get_vac_per_brgy'; ?>",
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
      var t1=0,t2=0,t3=0,t4=0,t5=0,t6=0,t7=0,t8=0,t9=0,t10=0,t11=0,t12=0,t13=0,t14=0,ta=0;
      table.clear();
      chart.options.data[0].dataPoints = [];
      chart.options.data[1].dataPoints = [];
      chart.options.data[2].dataPoints = [];
      chart.options.data[3].dataPoints = [];
      chart.options.data[4].dataPoints = [];
      chart.options.data[5].dataPoints = [];
      chart.options.data[6].dataPoints = [];
      chart.options.data[7].dataPoints = [];
      chart.options.data[8].dataPoints = [];
      chart.options.data[9].dataPoints = [];
      chart.options.data[10].dataPoints = [];
      chart.options.data[11].dataPoints = [];
      chart.options.data[12].dataPoints = [];
      chart.options.data[13].dataPoints = []; 
      chart.options.data[14].dataPoints = [];
      piechart.options.data[0].dataPoints = [];
 
       $.each(data.tracks, function(key, val){
        t1 += parseInt(val.baybayin);
        t2 += parseInt(val.anos);
        t3 += parseInt(val.bagong_silang);
        t4 += parseInt(val.bambang);
        t5 += parseInt(val.batong_malake);
        t6 += parseInt(val.bayog);
        t7 += parseInt(val.lalakay);
        t8 += parseInt(val.maahas);
        t9 += parseInt(val.malinta);
        t10 += parseInt(val.mayondon);
        t11 += parseInt(val.san_antonio);
        t12 += parseInt(val.tadlac);
        t13 += parseInt(val.timugan);
        t14 += parseInt(val.tuntungin_putho);
        ta += parseInt(val.total); 

        table.row.add([ val.date,
                      val.baybayin.toLocaleString(),
                      val.anos.toLocaleString(),
                      val.bagong_silang.toLocaleString(),
                      val.bambang.toLocaleString(),
                      val.batong_malake.toLocaleString(),
                      val.bayog.toLocaleString(),
                      val.lalakay.toLocaleString(),
                      val.maahas.toLocaleString(),
                      val.malinta.toLocaleString(),
                      val.mayondon.toLocaleString(),
                      val.san_antonio.toLocaleString(),
                      val.tadlac.toLocaleString(),
                      val.timugan.toLocaleString(),
                      val.tuntungin_putho.toLocaleString(),  
                      val.total.toLocaleString()
                  ]).draw( false );

          chart.options.data[0].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.baybayin.toLocaleString()),color:'#FA8072', lineColor: '#FA8072', markerColor: "#FA8072"});
          chart.options.data[1].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.anos.toLocaleString()),color:'#0000FF', lineColor: '#0000FF', markerColor: "#0000FF" });
          chart.options.data[2].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.bagong_silang.toLocaleString()),color:'#808000', lineColor: '#808000', markerColor: "#808000" });
          chart.options.data[3].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.bambang.toLocaleString()),color:'#008000', lineColor: '#008000', markerColor: "#008000" });
          chart.options.data[4].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.batong_malake.toLocaleString()),color:'#008080', lineColor: '#008080', markerColor: "#008080" });
          chart.options.data[5].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.bayog.toLocaleString()),color:'#FF0000', lineColor: '#FF0000', markerColor: "#FF0000" });
          chart.options.data[6].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.lalakay.toLocaleString()),color:'#DC143C', lineColor: '#DC143C', markerColor: "#DC143C" });
          chart.options.data[7].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.maahas.toLocaleString()),color:'#98DFF6', lineColor: '#98DFF6', markerColor: "#98DFF6" });
          chart.options.data[8].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.malinta.toLocaleString()),color:'#C03C1E', lineColor: '#C03C1E', markerColor: "#C03C1E" });
          chart.options.data[9].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.mayondon.toLocaleString()),color:'#0B8201', lineColor: '#0B8201', markerColor: "#0B8201" });
          chart.options.data[10].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.san_antonio.toLocaleString()),color:'#858505', lineColor: '#858505', markerColor: "#858505" });
          chart.options.data[11].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.tadlac.toLocaleString()),color:'#570648', lineColor: '#570648', markerColor: "#570648" });
          chart.options.data[12].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.timugan.toLocaleString()),color:'#40495F', lineColor: '#40495F', markerColor: "#40495F" });
          chart.options.data[13].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.tuntungin_putho.toLocaleString()),color:'#B22440', lineColor: '#B22440', markerColor: "#B22440" });
          chart.options.data[14].dataPoints.push({label: convert_date(val.date),  y: parseInt(val.total.toLocaleString()),color:'#000000', lineColor: '#000000', markerColor: "#000000" });
        })
      $('#tfoot').html(`<tr style='bgcolor:yellow;'>
                          <td>Total</td>
                          <td>${t1.toLocaleString()}</td>
                          <td>${t2.toLocaleString()}</td>
                          <td>${t3.toLocaleString()}</td>
                          <td>${t4.toLocaleString()}</td>
                          <td>${t5.toLocaleString()}</td>
                          <td>${t6.toLocaleString()}</td>
                          <td>${t7.toLocaleString()}</td>
                          <td>${t8.toLocaleString()}</td>
                          <td>${t9.toLocaleString()}</td>
                          <td>${t10.toLocaleString()}</td>
                          <td>${t11.toLocaleString()}</td>
                          <td>${t12.toLocaleString()}</td>
                          <td>${t13.toLocaleString()}</td>
                          <td>${t14.toLocaleString()}</td> 
                          <td>${ta.toLocaleString()}</td>
                        </tr>`); 

      piechart.options.data[0].dataPoints.push(
                {label: `Baybayin( ${parseInt(t1).toLocaleString()} )`, y: percentage(parseInt(t1),parseInt(ta)), color: '#FA8072', indexLabelFontColor:'#FA8072'},
                {label: `Anos( ${parseInt(t2).toLocaleString()} )`, y: percentage(parseInt(t2),parseInt(ta)), color: '#0000FF', indexLabelFontColor:'#0000FF'},
                {label: `Bagong Silang( ${parseInt(t3).toLocaleString()} )`, y: percentage(parseInt(t3),parseInt(ta)), color: '#808000', indexLabelFontColor:'#808000'},
                {label: `Bambang( ${parseInt(t4).toLocaleString()} )`, y: percentage(parseInt(t4),parseInt(ta)), color: '#008000', indexLabelFontColor:'#008000'},
                {label: `Batong Malake( ${parseInt(t5).toLocaleString()} )`, y: percentage(parseInt(t5),parseInt(ta)), color: '#008080', indexLabelFontColor:'#008080'},
                {label: `Bayog( ${parseInt(t6).toLocaleString()} )`, y: percentage(parseInt(t6),parseInt(ta)), color: '#FF0000', indexLabelFontColor:'#FF0000'},
                {label: `Lalakay( ${parseInt(t7).toLocaleString()} )`, y: percentage(parseInt(t7),parseInt(ta)), color: '#DC143C', indexLabelFontColor:'#DC143C'},
                {label: `Maahas( ${parseInt(t8).toLocaleString()} )`, y: percentage(parseInt(t8),parseInt(ta)), color: '#98DFF6', indexLabelFontColor:'#98DFF6'},
                {label: `Malinta( ${parseInt(t9).toLocaleString()} )`, y: percentage(parseInt(t9),parseInt(ta)), color: '#C03C1E', indexLabelFontColor:'#C03C1E'},
                {label: `Mayondon( ${parseInt(t10).toLocaleString()} )`, y: percentage(parseInt(t10),parseInt(ta)), color: '#0B8201', indexLabelFontColor:'#0B8201'},
                {label: `San Antonio( ${parseInt(t11).toLocaleString()} )`, y: percentage(parseInt(t11),parseInt(ta)), color: '#858505', indexLabelFontColor:'#858505'},
                {label: `Tadlac( ${parseInt(t12).toLocaleString()} )`, y: percentage(parseInt(t12),parseInt(ta)), color: '#570648', indexLabelFontColor:'#570648'},
                {label: `Timugan( ${parseInt(t13).toLocaleString()} )`, y: percentage(parseInt(t13),parseInt(ta)), color: '#40495F', indexLabelFontColor:'#40495F'},
                {label: `Tuntungin Putho( ${parseInt(t14).toLocaleString()} )`, y: percentage(parseInt(t14),parseInt(ta)), color: '#B22440', indexLabelFontColor:'#B22440'});
  $('#chartContainer').show();
  $('#piechartContainer').show();

      chart.options.title.text=`Vaccination`;
      chart.render();

      piechart.options.title.text=`Vaccination`;
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
                title: 'MGLB-COVID19-TRACKER Vaccination',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER Vaccination',
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

  var chart = new CanvasJS.Chart("chartContainer", {
    animationEnabled: true,
    theme: "light2",
    title:{
      text: "VACCINATED CLIENT PER BRGY DAILY COUNT",
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
      name: "BAYBAYIN",
      color: '#FA8072',
      showInLegend: true,
      color: '#FA8072',
      dataPoints: [
      ]
    }, 
    {        
      type: "line",
      showInLegend: true,
      name: "ANOS",
      color: '#0000FF',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "BAGONG SILANG",
      color: '#808000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "BAMBANG",
      color: '#008000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "BATONG MALAKE",
      color: '#008080',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "BAYOG",
      color: '#FF0000',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "LALAKAY",
      color: '#DC143C',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "MAAHAS",
      color: '#98DFF6',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "MALINTA",
      color: '#C03C1E',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "MAYONDON",
      color: '#0B8201',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "SAN ANTONIO",
      color: '#858505',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "TADLAC",
      color: '#570648',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "TIMUGAN",
      color: '#40495F',
      showInLegend: true,
      dataPoints: [
      ]
    },
    {        
      type: "line",
      showInLegend: true,
      name: "TUNTUNGIN-PUTHO",
      color: '#B22440',
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
