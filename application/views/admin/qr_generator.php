<style>
  canvas{
    padding: 18px;
  }
  @media print{
    .div-settings
    {
        display: none !important;
    }
  }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        QRCode Generator
        <small></small>
        </h1>
        <ol class="breadcrumb">
        <li class="active">QRCode Generator</li>
        </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="div-settings">
          <div class="col-md-5">
          </div>
          <div class="col-md-2">
            <input type="text" id="from" class="form-control" placeholder="QR range From"> 
          </div>
          <div class="col-md-2">
            <input type="text" id="to" class="form-control" placeholder="QR range To"> 
          </div>
          <div class="col-md-3">  
            <button class="btn btn-success" id="generate_btn"><i class="fa fa-qrcode"></i> Generate QR</button>
            <button class="btn btn-info" id="print"><i class="fa fa-print"></i> PRINT</button>
          </div>
        </div>
        <div id="qrdiv" class="row">
        </div>
      </div>
    </section>
  </div>
<script>
  function pad (str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
  }
  $(document).ready(function(){
    $('#generate_btn').click(function(){
      $('#qrdiv').html('');
      var min = parseInt($('#from').val());
      var max = parseInt($('#to').val());
      for(var i=min;i<=max&&i>=min;i++){
        var qr = pad(i,6);
        $('#qrdiv').qrcode(
        {
          render: "canvas",
          width: 115,
          height: 115,
          background: "#ffffff",
          foreground: "#000000",
          text: `43411000-${qr}`,
          src: '<?php echo base_url('assets/images/lblogo-sm.png'); ?>',
          imgWidth: 40,
          imgHeight: 40
        }
        );
      }
    })
    $('#print').click(function(){
      window.print();
    });
  });
</script>
<script src="<?php echo base_url(); ?>assets/js/qr-generator/jquery.qrcode.min.js"></script>
