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
    $.qrCodeReader.jsQRpath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.js";
    $.qrCodeReader.beepPath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep.mp3";
    // bind all elements of a given class
    $(".qrcode-reader").qrCodeReader({
      callback: function(code) {
       // $('html, body').animate({ scrollCenter: $('#qrcode').offset().top }, 'slow');
       $('.qrcoderow').fadeOut(300).fadeIn(300).fadeOut(300).fadeIn(300);
    }
    });
  });

</script>
