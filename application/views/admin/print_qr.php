<style>
  canvas{
    padding: 18px;
  }
</style>
<html>
  <body>
    <div id="test">
    </div>
  </body>
</html>
<script>
  $(document).ready(function(){
    var min = 29001;
    var max = 30000;
    for(var i=min;i<=max&&i>=min;i++){
      var qr = ('0' + i).slice(-6);
    $('#test').qrcode(
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
  });
</script>
<script src="<?php echo base_url(); ?>assets/js/qr-generator/jquery.qrcode.min.js"></script>
