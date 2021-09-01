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
    .table-hover>tbody>tr.warning:hover>td, .table-hover>tbody>tr.warning:hover>th, .table-hover>tbody>tr:hover>.warning, .table-hover>tbody>tr>td.warning:hover, .table-hover>tbody>tr>th.warning:hover {
      background-color: #FFFF66 !important;
    }
    .table>tbody>tr.warning>td{
      background-color: #FFFF99 !important;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Municipal Health Office
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Reports</a></li>
        <li class="active">MHO</li>
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
                        </div>
                        <div class="col-md-3">
                        <label>Date: </label> 
                        <input type="text" name="date" class="form-control daterange" placeholder="Start and End Date" value="<?php echo date('Y-m-d').' - '.date('Y-m-d') ?>" />
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
                        <td>Full Name(first middle last)</td>
                        <td>Age</td>
                        <td>Gender</td>
                        <td>Address</td>
                        <td>Current Status</td>
                        <td>Status on visit</td>
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

setInterval(function(){
get_data();
}, 30000);

setTimeout(function () {
  get_data();
}, 1000)

var client;
function get_data(){
$.ajax({
  type: "POST",
  url: "<?php echo base_url().'reports/get_mho'; ?>",
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
      if(data.date.date!=''){
        $('.date_title').html(`Client / Establishment Tracks from ${data.date.from} TO ${data.date.to}`);
      }else{
        $('.date_title').html(`Client / Establishment Tracks`);
      }
      var tr ='',total_male=0,total_female=0,total_all=0,tfoot,fullname,datetime;
      table.clear();
       $.each(data.tracks, function(key, val){
        fullname = `${val.fname} ${val.mname} ${val.lname}`;
        address = `${val.address} ${val.brgyDesc} ${val.citymunDesc}`;
        datetime = convert_datetime(val.datetime);
        gender = val.sex=='1'?'MALE':'FEMALE';
         var rowNode = table.row.add([ fullname,
                      val.age,
                      gender,
                      address,
                      val.status,
                      val.sov
                  ]).draw().node();
         if((val.status_id!=1 && val.status_id!=4) || ( val.sov_id!=1 && val.sov_id!=4)){
            $( rowNode ).addClass('warning'); 
          }
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
    $(this).val(picker.startDate.format('Y-MM-D') + ' - ' + picker.endDate.format('Y-MM-D'));
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
                title: 'MGLB-COVID19-TRACKER Report',
              },
              {
                extend: 'print',
                title: 'MGLB-COVID19-TRACKER Report',
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
});
</script>
