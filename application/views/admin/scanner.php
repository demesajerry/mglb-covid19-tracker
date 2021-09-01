<style>
.main-box {
    position: relative;
}

.main-box .footer {
    position: absolute;
    bottom: 0;
    right: 0;
}
.info-box-icon {
font-size: 40px !important;
  }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Active Scanners <p style="display: inline" id="scanner_count"></p>
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"> Admin</a></li>
        <li class="active">Categories</li>
        </ol>
    </section>

    <section class="content" id="active_scanners">
    </section>
</div>
<script>
$(document).ready(function() {
  active_scanners();
//check new clients every 20sec
setInterval(function(){
active_scanners();
}, 60000);
function active_scanners(){
  $.ajax({
  type: "POST",
  url: "<?php echo base_url(); ?>"+'admin/active_scanners',
  success: function(data){
    var box='';
    var scanner_count = Object.keys(data).length;
    $.each(data, function(key, val){
      box +=`<div class="col-sm-3 col-xs-12">
                <div class="info-box main-box">
                    <span class="info-box-icon bg-aqua">${val.scan_count}</span>
                    <div class="info-box-content">
                        <span class=""><h4>${val.scanner_name}</h4></span>
                        <span class="footer"><small>Time log: ${val.time_log}</small></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div>
            `;
          });
    $('#active_scanners').html(box);
    $('#scanner_count').html("("+scanner_count+")");
  }
});
}

});

</script>
