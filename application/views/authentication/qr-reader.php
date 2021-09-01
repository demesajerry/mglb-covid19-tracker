<style>
  #qrr-container {
    max-width: 800px !Important;
}
@media (min-width: 576px)
  #qrr-container {
    max-width: 500px  !Important;
    margin: 1.75rem auto  !Important;
}
</style>
<script>
  $(function(){
    // overriding path of JS script and audio 
    $.qrCodeReader.jsQRpath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.min.js";
    $.qrCodeReader.beepPath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep.mp3";
    // bind all elements of a given class
    $("#username").qrCodeReader({
      callback: function(code) {
        $("#username").val(code).focus();
       // $('html, body').animate({ scrollCenter: $('#qrcode').offset().top }, 'slow');
       if($("#password").val()!=''){
        login();
       }
    }
    });
    $("#password").qrCodeReader({
      callback: function(code) {
        $("#password").val(code).focus();
       // $('html, body').animate({ scrollCenter: $('#qrcode').offset().top }, 'slow');
       if($("#username").val()!=''){
        login();
       }
    }
    });
  });
</script>
