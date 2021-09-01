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
  function get_details(qrcode){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>Vaccination/get_details",
      dataType: "JSON",
      data:{qrcode:qrcode},
      async:true,
      success: function(data){
        if(data.error == 0){
          $('#vac_form').trigger("reset");
          $.each( data.details, function( key, val ) {
            var bday = val.birthday.split('-');
            var birthday = convert_date_M_D(val.birthday);
            if(val.symptoms){
            var symptoms = val.symptoms.split(", ");
            }else{
              symptoms = '';
            }
            $('#vaccine').val(val.vaccine).trigger('change');
            $('#userid').val(val.id);
            $('#qrcode').val(val.qrcode);
            $('#fname').val(val.fname);
            $('#lname').val(val.lname);
            $('#mname').val(val.mname);
            $('#address').val(val.address);
            if(val.provCode!='434'){
              $('#provCode').val(val.provCode).trigger('change');
            }
            get_mun(val.provCode,val.citymunCode,val.brgyCode);
            $('#birthday').val(birthday);
            $('#birthyear').val(bday[0]);
            $('#contact_number').val(val.contact_number);
            $('#sex').val(val.sex).trigger('change');
            $('#category').val(val.category).trigger('change');
            $('#category_id').val(val.category_id).trigger('change');
            $('#category_id_number').val(val.category_id_number);
            $('#philhealth_id').val(val.philhealth_id);
            $('#pwd_id').val(val.pwd_id);
            $('#suffix').val(val.suffix).trigger('change');
            $('#civil_status').val(val.civil_status).trigger('change');
            $('#employment_status').val(val.employment_status).trigger('change');
            $('#profession').val(val.profession).trigger('change');
            $('#employer_name').val(val.employer_name);
            $('#employer_no').val(val.employer_no);
            $('#employer_add').val(val.employer_add);
            $('#is_validated').val(val.is_validated).trigger('change');
            $('#employer_prov').val(val.employer_prov).trigger('change');

            $("input[name=direct_contact][value='"+val.direct_contact+"']").prop("checked",true);
            $("input[name=pregnancy_status][value='"+val.pregnancy_status+"']").prop("checked",true);

            $("input[name=drug][value='"+val.drug+"']").prop("checked",true);
            $("input[name=food][value='"+val.food+"']").prop("checked",true);
            $("input[name=insect][value='"+val.insect+"']").prop("checked",true);
            $("input[name=latex][value='"+val.latex+"']").prop("checked",true);
            $("input[name=mold][value='"+val.mold+"']").prop("checked",true);
            $("input[name=pet][value='"+val.pet+"']").prop("checked",true);
            $("input[name=pollen][value='"+val.pollen+"']").prop("checked",true);

            $("input[name=hypertension][value='"+val.hypertension+"']").prop("checked",true);
            $("input[name=heart][value='"+val.heart+"']").prop("checked",true);
            $("input[name=kidney][value='"+val.kidney+"']").prop("checked",true);
            $("input[name=diabetes][value='"+val.diabetes+"']").prop("checked",true);
            $("input[name=asthma][value='"+val.asthma+"']").prop("checked",true);
            $("input[name=immuno][value='"+val.immuno+"']").prop("checked",true);
            $("input[name=cancer][value='"+val.cancer+"']").prop("checked",true);
            $("input[name=other][value='"+val.other+"']").prop("checked",true);

            $("input[name=covid19][value='"+val.covid19+"']").prop("checked",true);
            $('#covid19_class').val(val.covid19_class).trigger('change');
            $('#covid19_date').val(val.covid19_date);
            $('#consent').val(val.consent).trigger('change');

            $('#refusal_reason').val(val.refusal_reason).trigger('change');
            $('#age_16').val(val.age_16).trigger('change');
            $('#peg').val(val.peg).trigger('change');
            $('#allergy_1stDose').val(val.allergy_1stDose).trigger('change');
            $('#food_allergy').val(val.food_allergy).trigger('change');
            $('#monitor_30Minutes').val(val.monitor_30Minutes).trigger('change');
            $('#bleeding_disorder').val(val.bleeding_disorder).trigger('change');
            $('#injection').val(val.injection).trigger('change');
            $('#manifest_symptoms').val(val.manifest_symptoms).trigger('change');
            $('#symptoms').val(symptoms).trigger('change');
            $('#covid19_exposure').val(val.covid19_exposure).trigger('change');
            $('#covid19_90days').val(val.covid19_90days).trigger('change');
            $('#vac_2weeks').val(val.vac_2weeks).trigger('change');
            $('#covid19_90days').val(val.covid19_90days).trigger('change');
            $('#covid19_plasma').val(val.covid19_plasma).trigger('change');
            $('#trimester').val(val.trimester).trigger('change');
            $('#prognosis').val(val.prognosis).trigger('change');
            $('#terminal_illness').val(val.terminal_illness);
            $('#clearance').val(val.clearance).trigger('change');
            $('#deferral').val(val.deferral);
            if(val.vac_date!=null){
                $('#vac_date').val(convert_date_full(val.vac_date));
            }
            $('#vac_manufacturer').val(val.vac_manufacturer).trigger('change');
            $('#batch_number').val(val.batch_number);
            $('#lot_number').val(val.lot_number).trigger('change');
            $('#is_vaccinated').val(val.is_vaccinated).trigger('change');
            $('#vaccinator_name').val(val.vaccinator_name);
            $('#vaccinator_prof').val(val.vaccinator_prof);
            if(val.first_dose == '01_Yes'){
              $('#dose_no').val('1').trigger('change');
            }

            $('#birthday_modal').modal('hide');
            toastr.success('Data has been populated!');
          });
        }else{
            toastr.warning('No record Found!');
        }
      },
    });
  }


  $(function(){
    // overriding path of JS script and audio 
    $.qrCodeReader.jsQRpath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/js/jsQR/jsQR.js";
    $.qrCodeReader.beepPath = "<?php echo base_url(); ?>assets/js/qr-reader/dist/audio/beep.mp3";
    // bind all elements of a given class
    $(".qrcode-reader").qrCodeReader({
      callback: function(code) {
       // $('html, body').animate({ scrollCenter: $('#qrcode').offset().top }, 'slow');
      get_details(code);
    }
    });
  });

</script>
