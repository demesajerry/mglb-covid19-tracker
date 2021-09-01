<style>
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
    .table-hover>tbody>tr.warning:hover>td, .table-hover>tbody>tr.warning:hover>th, .table-hover>tbody>tr:hover>.warning, .table-hover>tbody>tr>td.warning:hover, .table-hover>tbody>tr>th.warning:hover {
      background-color: #FFFF66 !important;
    }
    .table>tbody>tr.warning>td{
      background-color: #FFFF99 !important;
    }
    .table-responsive{
      min-height: 50vh;
    }
    .dt-button-collection {
        max-height: 200px;
        overflow-y: scroll;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Vaccination
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">TRACKS</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                    <div class="col-xs-12">
                      <form id="form1" method="post">
                        <div class="col-md-1"> 
                          <label>With Comorbidity</label>
                          <select id="with_comorbidity" name="with_comorbidity" class="form-control select2" >
                              <option value="">ALL</option>
                              <option value="01_Yes">With Comorbidity</option>
                              <option value="02_None">None</option>
                           </select>                        
                         </div>
                        <div class="col-md-2">
                          <label>Brgy:</label>
                          <select id="brgyCode" name="brgyCode[]" class="form-control select2" multiple="multiple">
                            <option value="">ALL</option>
                            <?php foreach($brgy_list as $val){ ?>
                            <!--Initial selected is LAGUNA ProvCode=0434-->
                              <option value="<?= $val->brgyCode ?>"> <?= $val->brgyDesc ?></option>
                            <?php } ?>
                          </select>
                        </div> 
                        <div class="col-md-2"> 
                          <label>Category</label>
                            <select id="category" name="category[]" class="form-control select2" multiple="multiple">
                              <option value="">Select Category</option>
                              <option value="">ALL</option>
                              <?php foreach($category as $key=>$val){ ?>
                                <option value="<?= $val->priority_group ?>"><?= $val->priority_group.'-'.$val->description ?></option>
                              <?php } ?>
                             </select>
                        </div>
                        <div class="col-md-1">
                        <label>Min AGE: </label> 
                          <input type="text" name="min_age" class="form-control" placeholder="Min Age" />
                        </div>
                        <div class="col-md-1">
                        <label>Max AGE: </label> 
                          <input type="text" name="max_age" class="form-control" placeholder="Max Age" />
                        </div>

                        <div class="col-md-2">
                        <label>Date: </label> 
                        <input type="date" name="date" class="form-control" placeholder="Date" />
                        </div>
                        <div class="col-md-1">
                        <label>Time: </label> 
                        <input type="time" name="time" class="form-control" placeholder="Time" />
                        </div>
                        <div class="col-md-1">
                        <label>Next Vaccination: </label> 
                        <input type="next_vac_date" name="next_vac_date" class="form-control date" placeholder="Next Vaccination Date" />
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
                        <td> </td>
                        <td>USERID</td>
                        <td>Date Registered</td>
                        <td>Age</td>
                        <td>Category</td>
                        <td>Category ID</td>
                        <td>ID #</td>
                        <td>Philhealth ID</td>
                        <td>PWD ID</td>
                        <td>Last Name</td>
                        <td>First Name</td>
                        <td>Middle Name</td>
                        <td>Suffix</td>
                        <td>Contact #</td>
                        <td>Address</td>
                        <td>Region</td>
                        <td>Province</td>
                        <td>Municipality</td>
                        <td>Barangay</td>
                        <td>Sex</td>
                        <td>Birthday</td>
                        <td>Civil Status</td>
                        <td>Employment Status</td>
                        <td>Direct Contact</td>
                        <td>Profession</td>
                        <td>Employer</td>
<!--                         <td>HUC</td>
 -->                        <td>E-Address</td>
                        <td>E-#</td>
                        <td>Pregnancy</td>
                        <td>Drug</td>
                        <td>Food</td>
                        <td>Insect</td>
                        <td>Latex</td>
                        <td>Mold</td>
                        <td>Pet</td>
                        <td>Pollen</td>
                        <td>Comorbidity</td>
                        <td>Hypertension</td>
                        <td>Heart</td>
                        <td>Kidney</td>
                        <td>Diabetes</td>
                        <td>Asthma</td>
                        <td>Immuno</td>
                        <td>Cancer</td>
                        <td>Others</td>
                        <td>Covid19</td>
                        <td>Date</td>
                        <td>Class</td>
                        <td>Consent</td>
                        <td>Next Vaccine</td>
                        <td>Priority Description</td>
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
                <div id="piechartContainer" style="height: 600px; max-width: 1320px; margin: 0px auto;"></div>
              </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
  $('#piechartContainer').hide();
  var dataPoints = [];

$('#loader').hide();
function percentage(num, total)
{
  return (num/total)*100;
}

var client;
function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'reports/get_vac'; ?>",
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
      $('.date_title').html(`Registered from ${data.date_reg}`);
      var t1=0,t2=0,t3=0,t4=0,t5=0,t6=0,t7=0,t8=0,t9=0,t10=0,t11=0,t12=0,t13=0,t14=0,ta=0;
      var tr ='',total_male=0,total_female=0,total_all=0,tfoot,fullname,datetime, category;
      var pg = ["A1", "A2", "A3", "A4", "A5"];
      table.clear();
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

        province = `_0${val.provCode}_${val.provDesc}`;
        //employer_prov = `_${val.provCode} - ${val.employer_prov_desc}`;
        citymun = `_${val.citymunCode}_${val.citymunDesc}`;
        brgy = `_${val.brgyCode}_${val.brgyDesc}`;
        address = `${val.address} ${val.brgyDesc} ${val.citymunDesc}`;
        date_reg = convert_datetime(val.date_reg);
        sex = val.sex==0?`01_Female`:`02_Male`;
        bady = convert_datetime(val.birthday);
        switch(val.priority_group) {
          case 'A1':
             category ='01_Health_Care_Worker';
            break;
          case 'A2':
             category ='02_Senior_Citizen';
            break;
          case 'A5':
             category ='03_Indigent';
            break;
          case 'A4':
             if(val.pg_id=='21'){
              category = '04_Uniformed_Personnel';
             }else{
              category = '05_Essential_Worker';
             }
            break;
          default:
              category = '06_Other';
        }
         var rowNode = table.row.add([ 
                      `${val.date_reg_timestamp}`,
                      `${val.userid}`,
                      `${date_reg}`,
                      val.age,
                      category,
                      val.category_id,
                      val.category_id_number,
                      val.philhealth_id,
                      val.pwd_id,
                      val.lname,
                      val.fname,
                      val.mname,
                      val.suffix,
                      val.contact_number,
                      val.address,
                      'CALABARZON',
                      province,
                      citymun,
                      brgy,
                      sex,
                      val.birthday,
                      val.civil_status,
                      val.employment_status,
                      val.direct_contact,
                      val.profession,
                      val.employer_name,
                      //employer_prov,
                      val.employer_add,
                      val.employer_no,
                      val.pregnancy_status,
                      val.drug,
                      val.food,
                      val.insect,
                      val.latex,
                      val.mold,
                      val.pet,
                      val.pollen,
                      val.with_comorbidity,
                      val.hypertension,
                      val.heart,
                      val.kidney,
                      val.diabetes,
                      val.asthma,
                      val.immuno,
                      val.cancer,
                      val.other,
                      val.covid19,
                      val.covid19_date,
                      val.covid19_class,
                      val.consent,
                      val.next_vac_date,
                      val.description
                  ]).node();
         // if(){
         //    $( rowNode ).addClass('warning'); 
         //  }
        })
        table.draw();  

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

            $('#piechartContainer').show();
            piechart.options.title.text=`Covid19 Vaccine Pre-Registration`;
            piechart.render();       
    }
});
}

$('#generate').click(function(e){
  e.preventDefault();
  get_data();
})

$('.daterange').on('apply.daterangepicker', function(ev, picker) {
    $(this).val(picker.startDate.format('Y-MM-D') + ' - ' + picker.endDate.format('Y-MM-D'));
  });

    var table = $('#viewresult').DataTable({
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    dom: 'Blfrtip',
    "iDisplayLength": 5,
    "deferRender": true,
    "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            }],
            buttons:[
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Vaccination Report',
                text: 'Excel DOH Report',
                exportOptions: {
                 columns: [ 1, 2,8,9,10,11,12,17,3,4,5,6,7,13,14,15,16,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48 ],
                },
              },
              {
                extend: 'excelHtml5',
                title: 'MGLB-COVID19-TRACKER Vaccination Report',
                text: 'Excel ALL',
                exportOptions: {
                 columns: [ ':visible' ],
                },
              },
             {
                extend: 'colvis',
             },
             {
                extend: 'colvisGroup',
                text: 'Basic Info',
                show: [ 1, 2,8,9,10,11,12,17 ],//show basic info
                hide: [3,4,5,6,7,13,14,15,16,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48]//hide all other column
            },
             {
                extend: 'colvisGroup',
                text: 'Hide All',
                hide: ':visible'//hide all
            },
             {
                extend: 'colvisGroup',
                text: 'Show All',
                show: ':hidden',//show all
                hide: [0]//hide 1st column
            },
            {
                text: 'Download Pie Chart',
                attr: { id: 'exportPieChart' }
            } 
            ],
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
  $("#exportPieChart").on("click",function(){
    piechart.exportChart({format: "jpg"});
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
//reset column width (recalculate)
 $('.buttons-colvisGroup').click(function(){
  $('#viewresult').css( 'display', 'block' );
  table.columns.adjust().draw();
 })
});
</script>
<script src="<?php echo base_url(); ?>assets/js/canvasjs.min.js"></script>