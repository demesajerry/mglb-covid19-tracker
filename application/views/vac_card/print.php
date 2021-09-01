<style>
.print_area{
    width: 157.5mm;
    height: 110.5mm;
    position:relative;
    padding: 0 0 0 0px;
    font-weight: bold;
    font-size: 14pt;}
.full_name{
    position: absolute;
    left: 24.5mm;
    top: 33.7mm;
}
.bday{
    position: absolute;
    left: 24.5mm;
    top: 41.7mm;
}
.sex{
    position: absolute;
    left: 85.5mm;
    top: 41.7mm;
}
.address{
    position: absolute;
    left: 24.5mm;
    top: 50.7mm;
}
.idno{
    position: absolute;
    left: 107.7mm;
    top: 71.7mm;
    color: red !important;
}
#qrcode{
    position: absolute;
    left: 107mm;
    top: 30.9mm;
}

/*DOSE2 CSS*/
.ddate1{
    position: absolute;
    left: 19.4mm;
    top: 90.5mm;
    font-size: 10pt;
    width: 78px;
    text-align: center;
}
.dvac1{
    position: absolute;
    left: 39.7mm;
    top: 90.5mm;
    font-size: 10pt;
    width: 105px;
    text-align: center;
}
.dlot1{
    position: absolute;
    left: 67.2mm;
    top: 90.5mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dvaccinator1{
    position: absolute;
    left: 87.7mm;
    top: 90.5mm;
    font-size: 10pt;
    width: 150px;
    text-align: center;
}
.desig1{
    position: absolute;
    left: 129.7mm;
    top: 86mm;
    font-size: 9pt;
    width: 86px;
    text-align: center;
}

/*DOSE2 CSS*/

.ddate2{
    position: absolute;
    left: 19.4mm;
    top: 99mm;
    font-size: 10pt;
    width: 78px;
    text-align: center;
}
.dvac2{
    position: absolute;
    left: 39.7mm;
    top: 99mm;
    font-size: 10pt;
    width: 105px;
    text-align: center;
}
.dlot2{
    position: absolute;
    left: 67.2mm;
    top: 99mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dvaccinator2{
    position: absolute;
    left: 87.7mm;
    top: 99mm;
    font-size: 10pt;
    width: 150px;
    text-align: center;
}
.desig2{
    position: absolute;
    left: 129.7mm;
    top: 94mm;
    font-size: 10pt;
    width: 86px;
    text-align: center;
}
.bgimg{
    height: 100%;
    width: 100%;
}
@media print{
    @page{
        size: landscape;
        -webkit-print-color-adjust: exact;
    }

}
</style>
<!-- <body onload="window.print()" onfocus="window.close()">
 --><!-- <body onload="window.print()">
 -->
<div class="print_area">
  <p class="full_name"><?= $details->fullname ?></p>
  <p class="bday"><?= $details->bday ?></p>
  <p class="sex"><?= $details->sex ?></p>
  <p class="address"><?= $details->address ?></p>
  <p class="idno"><?= $details->dict_id_no ?></p>

  <p class="ddate1"><?= $details->f_vac_date ?></p>
  <p class="dvac1"><?= $details->f_vaccine ?></p>
  <p class="dlot1"><?= $details->f_lot_number ?></p>
  <p class="dvaccinator1"><?= $details->f_vaccinator ?></p>
<!--   <p class="desig1"><img src="<?php echo base_url('assets/images/esig/jvdm.png'); ?>" height="55" width="55"/></p>
 -->
  <p class="ddate2"><?= $details->s_vac_date ?></p>
  <p class="dvac2"><?= $details->s_vaccine ?></p>
  <p class="dlot2"><?= $details->s_lot_number ?></p>
  <p class="dvaccinator2"><?= $details->s_vaccinator ?></p>
<!--   <p class="desig2"><img src="<?php echo base_url('assets/images/esig/jvdm.png'); ?>" height="55" width="55"/></p>
 --><div class="col-md-12 black wide" id="qrcode">&nbsp;</div>

<!-- <img src="<?php echo base_url('assets/images/bg/vaccard_grey.png'); ?>" id='vaccard_img' class='bgimg'/>
 --> </div>
</body>
<script>
    $(document).ready(function(){
      $('#qrcode').qrcode(
        {
          render: "canvas",
          width: 140,
          height: 140,
          background: "#ffffff",
          foreground: "#000000",
          text: "https://www.mglb-covid19-tracker.com/Resbakuna/validate/<?= $details->id_no ?>/<?= $hash ?>",
          // src: '<?php echo base_url('assets/images/lblogo.png'); ?>',
          imgWidth: 75,
          imgHeight: 75
        });
    });

</script>
