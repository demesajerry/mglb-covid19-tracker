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
        get_details(code);
      }
    });

    $(".qrcode-reader_rel").qrCodeReader({
      callback: function(code) {
        get_details_rel(code);
      }
    });
  });
</script>
