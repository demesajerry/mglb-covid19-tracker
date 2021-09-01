<style>
.print_area{
    width: 165mm;
    height: 102mm;
    position:relative;
    padding: 0 0 0 0px;
    font-weight: bold;
    font-size: 14pt;
    position:absolute;
}
.idno{
    position: absolute;
    left: 108mm;
    top: 24mm;
    color: red !important;
}
.lname{
    position: absolute;
    left: 5mm;
    top: 30mm;
    width: 190px;
    text-align: left;
/*    border: dotted;
*/}
.fname{
    position: absolute;
    left: 58mm;
    top: 30mm;
    width: 220px;
    text-align: left;
/*    border: dotted;
*/}
.mname{
    position: absolute;
    left: 120mm;
    top: 30mm;
    width: 40px;
    text-align: left;
/*    border: dotted;
*/}
.suffix{
    position: absolute;
    left: 138mm;
    top: 30mm;
    width: 35px;
    text-align: left;
/*    border: dotted;
*/}
.address{
    position: absolute;
    left: 18mm;
    top: 40mm;
    font-size: 10pt;
}
.contact_number{
    position: absolute;
    left: 118mm;
    top: 40mm;
    font-size: 10pt;
}

.bday{
    position: absolute;
    left: 20mm;
    top: 45mm;
    font-size: 10pt;
}
.sex{
    position: absolute;
    left: 50mm;
    top: 45mm;
    font-size: 10pt;
}
.philhealth{
    position: absolute;
    left: 87mm;
    top: 46.5mm;
    font-size: 8pt;
}
.pg{
    position: absolute;
    left: 125mm;
    top: 45mm;
    font-size: 10pt;
}
#qrcode{
    position: absolute;
    left: 107mm;
    top: 30.9mm;
}

/*DOSE2 CSS*/
.ddate1{
    position: absolute;
    left: 36.7mm;
    top: 63.5mm;
    font-size: 10pt;
    width: 78px;
    text-align: center;
    color: red !important;

}
.dvac1{
    position: absolute;
    left: 52.7mm;
    top: 63.5mm;
    font-size: 10pt;
    width: 105px;
    text-align: center;
}
.dlot1{
    position: absolute;
    left: 100mm;
    top: 63.5mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dbatch1{
    position: absolute;
    left: 122mm;
    top: 63.5mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dvaccinator1{
    position: absolute;
    left: 60mm;
    top: 70mm;
    font-size: 10pt;
    width: 150px;
    text-align: center;
}
.dsig1{
    position: absolute;
    left: 112mm;
    top: 70.5mm;
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
    left: 36.7mm;
    top: 76mm;
    font-size: 10pt;
    width: 78px;
    text-align: center;
    color: red !important;
}
.dvac2{
    position: absolute;
    left: 52.7mm;
    top: 77.5mm;
    font-size: 10pt;
    width: 105px;
    text-align: center;
}
.dlot2{
    position: absolute;
    left: 100mm;
    top: 77.5mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dbatch2{
    position: absolute;
    left: 122mm;
    top: 77.5mm;
    font-size: 10pt;
    width: 82px;
    text-align: center;
}
.dvaccinator2{
    position: absolute;
    left: 60mm;
    top: 82.5mm;
    font-size: 10pt;
    width: 150px;
    text-align: center;
}
.dsig2{
    position: absolute;
    left: 112mm;
    top: 83mm;
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
.hfac{
    position: absolute;
    left: 27mm;
    top: 88mm;
    font-size: 10pt;
    width: 150px;
    text-align: center;
}
.cnum{
    position: absolute;
    left: 95mm;
    top: 88mm;
    font-size: 10pt;
    width: 150px;
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
    .print_area { 
        margin-top: .85in; margin-bottom: 0mm; 
           margin-left: 2.1in; margin-right: 0mm;page-break-before: always;}

}
</style>
<body onload="window.print()" onfocus="window.close()">

 <!-- <body onload="window.print()">
 -->
<div class="print_area">
  <p class="idno"><?= $details->dict_id_no ?></p>
  <p class="lname"><?= $details->lname ?></p>
  <p class="fname"><?= $details->fname ?></p>
  <p class="mname"><?= $details->mname ?></p>
  <p class="suffix"><?= $details->suffix ?></p>
  <p class="contact_number"><?= $details->contact_number ?></p>

  <p class="bday"><?= $details->bday ?></p>
  <p class="sex"><?= $details->sex ?></p>
  <p class="philhealth"><?= $details->philhealth_id ?></p>
  <p class="pg"><?= $details->priority_group ?></p>

  <p class="address"><?= $details->address ?></p>

  <p class="ddate1"><?= $details->f_vac_date ?></p>
  <p class="dvac1"><?= $details->f_vaccine ?></p>
  <p class="dlot1"><?= $details->f_lot_number ?></p>
  <p class="dbatch1"><?= $details->f_batch_number ?></p>
  <p class="dvaccinator1"><?= $details->f_vaccinator ?></p>
  <p class="dsig1"><?= $details->f_sig ?></p>
<!--   <p class="desig1"><img src="<?php echo base_url('assets/images/esig/jvdm.png'); ?>" height="55" width="55"/></p>
 -->
  <p class="ddate2"><?= $details->s_vac_date ?></p>
  <p class="dvac2"><?= $details->s_vaccine ?></p>
  <p class="dlot2"><?= $details->s_lot_number ?></p>
  <p class="dbatch2"><?= $details->s_batch_number ?></p>
  <p class="dvaccinator2"><?= $details->s_vaccinator ?></p>
  <p class="dsig2"><?= $details->s_sig ?></p>

  <p class="hfac">RHU Los Baños</p>
  <p class="cnum">536-6403</p>
<!--   <p class="desig2"><img src="<?php echo base_url('assets/images/esig/jvdm.png'); ?>" height="55" width="55"/></p>
 --><div class="col-md-12 black wide" id="qrcode">&nbsp;</div>

<!-- <img src="<?php echo base_url('assets/images/bg/vc.jpg'); ?>" id='vaccard_img' class='bgimg'/>
 --> 


</div>
</body>
<!-- <script>
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
 -->