<head> 
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<!------ Include the above in your HEAD tag ---------->
<style>
  .black{
    color: black;
  }
  #lab_id, #hdec{
    cursor: pointer;
    padding:5px;
  }
  #showpass{
  cursor: pointer;
  }
  #cshowpass{
  cursor: pointer;
  }

</style>
</head>
<?php
  $user = $this->session->userdata('user');
  extract($user);
?>
<div class="container bootstrap snippets">
  <div class="row">
    <div class="col-lg-3 col-md-3 col-sm-4">
        <div class="panel rounded shadow">
            <div class="panel-body">
                <div class="inner-all">
                    <ul class="list-unstyled">
                        <li class="text-center bg-primary">
                          <center>
                            <img data-no-retina="" class=" img-responsive img-bordered-primary" src="<?php echo base_url();?>Get_image?img=<?= substr(md5(mt_rand()), 0, 7); ?>">
                          </center>
                        </li>
                        <li class="text-center ">
                          <small>Valid Government ID Presented</small>
                            <h4 class="text-capitalize black"><?= $fname.' '.$lname ?></h4>
                        </li> 
                        <li class="bg-success black" id="lab_id"><i class="fa fa-eye"></i> View LAB ID </li>
                        <li class="bg-success black" id="hdec"><hr class="noborder"><i class="fa fa-hospital"></i> Health Declaration</li>
                    </ul>
                </div>
            </div>
        </div><!-- /.panel --> 

    </div>
  <div class="col-lg-9 col-md-9 col-sm-8">
    <div class="profile-cover">
      <div class="cover rounded shadow no-overflow">
        <div class="inner-cover"> 
          <div class="btn-group cover-menu-mobile hidden-lg hidden-md">
            <div class="dropdown">
              <button type="button" class="btn btn-theme btn-sm dropdown-toggle" data-toggle="dropdown" onclick="myFunction()">
                <i class="fa fa-cogs"></i> <?=$username?>
              </button>
              <div id="myDropdown" class="dropdown-content"> 
                <a href="#change_password" onclick="unhide_change_password()"><i class="fa fa-lock"></i>&nbsp; Change Password</a>
              </div> 
            </div> 
          </div>
          <img  src="<?php echo base_url('assets/images/mglb.png'); ?>" class="" alt="cover" style="max-height:200px; max-width:400px; display: table; margin: 0 auto;">
        </div>
        <ul class="list-unstyled no-padding hidden-sm hidden-xs cover-menu">
          <li class="active" id="home_li" onclick="unhide_home()"><a href="#home"><i class="fa fa-user"></i> <span>Personal</span></a></li> 
          <li id="cpass_li"><a href="#change_password" onclick="unhide_change_password()"><i class="fa fa-lock"></i> <span>Change Password</span></a></li>
        </ul>
      </div><!-- /.cover -->
    </div><!-- /.profile-cover --> 

      <section class="testimonial py-5" id="home">
        <div class="container card">
            <div class="row "> 
                <div class="col-md-12 py-5">
                  <div id="reg_details">
                    <form id="registration_form" method='POST' enctype="multipart/form-data">
                        <div class="form-row">
                          <input type="hidden" name="client_id" name="client_id" value="<?=$id?>">
                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-user red"></i>&nbsp; <?=$fname?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; First Name                       
                            </div>
                          </div>
                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-user red"></i>&nbsp; <?=$mname?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Middle Name                       
                            </div>
                          </div>
                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-user red"></i>&nbsp; <?=$lname?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Last Name                       
                            </div>
                          </div>
                        </div>
                        <div class="form-row addr">
                          <div class="form-group col-md-12 smallmargin">
                            <div class="form-label-group black">
                              <label for="address"><i class="fa fa-address-card red"></i>&nbsp; <?=$address.' '.$brgyDesc.' '.$citymunDesc.' '.$provDesc ?></label><hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Address
                            </div>
                          </div>
                          <div class="col-md-12">
                              <hr class="">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-calendar red"></i>&nbsp; <?= date("F d, Y", strtotime($birthday)); ?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Birthday                     
                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-mobile red"></i>&nbsp; <?=$contact_number?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Contact Number                       
                            </div>
                          </div>

                          <div class="form-group col-md-4">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-venus-mars red"></i>&nbsp; 
                                <?php echo $sex=='1'?'Male':''; ?>
                                <?php echo $sex=='0'?'Female':''; ?>
                              </label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Sex                       
                            </div>
                          </div>

                            <div class="form-group col-md-12">
                            <div class="form-label-group">
                              <label for="fname" class="black">
                              <i class="fa fa-building red"></i>&nbsp; <?=$pow?></label> <hr class="noborder">
                              &nbsp; &nbsp;&nbsp; Place of Work                       
                            </div>
                            </div>
                          </div> 
                </form>
            </div>
        </div>
      </div>
    </section>

    <section class="testimonial py-5" id="change_password" style="display: none;">
        <div class="container card">
            <div class="row "> 
                <div class="col-md-12 py-5">
                  <div class="row">
                        <div class="col-md-12 col-md-offset-4">
                          <h2>Change Password</h2>
                        </div>
                      </div>
                  <div id="reg_details">
                    <small class="red"><u>Please re-enter your password to change.</u></small>
                    <div class="alert alert-primary" style="display: none; width: 800px;">
                      
                    </div> 
                    <form id="change_pass_form" method='POST' enctype="multipart/form-data">
                      <input type="hidden" name="client_id" name="client_id" value="<?=$id?>">
                        <div class="form-row">
                            <div class="form-group input-group">
                              <input type="hidden" id="username" name="username" placeholder="Username" value="<?=$username?>"class="form-control" required="required" type="text" required="required" minlength="4">
                            </div>
                        <input type="hidden" name="converted_password" id="converted_password" value="<?=$password?>">
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-user-shield red"></i> </span>
                            </div>
                            <input type="password" id="password" name="password" placeholder="Old Password" class="form-control" required="required" type="text" required="required" minlength="6" onkeyup='pass();'>
                            <div class="input-group-append" id="showpass">
                              <span class="input-group-text"> 
                                <i class="fas fa-eye" id="eye"></i>
                                <small id="showhide">
                                  Show
                                </small>
                              </span>
                            </div>
                            <span id='message' style="position: absolute; margin-top: -25px;"></span>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-user-shield red"></i> </span>
                            </div>
                            <input type="password" id="new_password" name="new_password" placeholder="New Password" class="form-control" required="required" type="text" required="required" minlength="6" disabled> 
                            <div class="input-group-append" id="cshowpass">
                              <span class="input-group-text"> 
                                <i class="fas fa-eye" id="ceye"></i>
                                <small id="cshowhide">
                                  Show
                                </small>
                              </span>
                            </div>
                          </div>
                        </div>
                        <div class="form-group col-md-6">
                          <div class="form-group input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text"> <i class="fas fa-user-shield red"></i> </span>
                            </div>
                            <input type="password" id="confirm_new_password" name="confirm_new_password" placeholder="Confirm New Password" class="form-control" required="required" type="text" required="required" minlength="6" onkeyup='check();' disabled>
                            <span id='confirm_message' style="position: absolute; margin-top: -25px;"></span>
                          </div>
                        </div>
                        </div>
                        <div class="form-row">
                          <hr>
                          <button type="submit" class="btn btn-primary" id="update_password" disabled>Change</button>
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>  
    </section> 
  </div>
</div> 
</div>
<script> 
  var pass = function() { 
  var password = $('#password').val();
  var converted_password = $('#converted_password').val();
    password = $.sha1(password);
  
    if (password === converted_password){
      document.getElementById('message').style.color = 'green';
      document.getElementById('message').innerHTML = '<i class="glyphicon glyphicon-ok-sign"></i>Password Matched';
      document.getElementById("new_password").disabled = false;
      document.getElementById("confirm_new_password").disabled = false; 
    } 
    else {
      document.getElementById('message').style.color = 'red';
      document.getElementById('message').innerHTML = '<i class="fa fa-exclamation-circle"></i>Password Did Not Matched!';
        document.getElementById("new_password").disabled = true;
        document.getElementById("confirm_new_password").disabled = true; 
    }
  }

  var check = function() {
    if (document.getElementById('new_password').value == document.getElementById('confirm_new_password').value) {
      document.getElementById('confirm_message').style.color = 'green';
      document.getElementById('confirm_message').innerHTML = '<i class="glyphicon glyphicon-ok-sign"></i>New Password Matched';
      document.getElementById("update_password").disabled = false; 
    } 
    else {
      document.getElementById('confirm_message').style.color = 'red';
      document.getElementById('confirm_message').innerHTML = '<i class="fa fa-exclamation-circle"></i>New Password Did Not Matched!';
      document.getElementById("update_password").disabled = true;
    }
  }

  function unhide_home() {
    var home = document.getElementById("home");
    var hide_health = document.getElementById("health");
    var hide_qrcode = document.getElementById("qrcode");
    var hide_change_password = document.getElementById("change_password");
      if (home.style.display === "none") {
        home.style.display = "block";
        hide_change_password.style.display = "none";
      } 
      else {
        home.style.display = "block";
      }
      $("#home_li").addClass('active');
      $("#cpass_li").removeClass('active');
  }

  function unhide_change_password() {
    var hide_home = document.getElementById("home");
    var hide_health = document.getElementById("health");
    var hide_qrcode = document.getElementById("qrcode");
    var change_password = document.getElementById("change_password");
    if (change_password.style.display === "none") {
      change_password.style.display = "block";
      hide_home.style.display = "none"; 
    } 
    else {
      change_password.style.display = "block";
    }
      $("#home_li").removeClass('active');
      $("#cpass_li").addClass('active');
  }
  /* When the user clicks on the button, 
  toggle between hiding and showing the dropdown content */
  function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }
      }
    }
  } 
</script>
<script type="text/javascript"> 
    $('#update').click(function(e){
      e.preventDefault();
        $.ajax({
        type : 'POST',
        url : '<?php echo base_url(); ?>Client_profile/update_client',
        contentType: false,       
        cache: false,             
        processData:false,
        data: new FormData($('#registration_form')[0]),
        success: function(data){
          $('.alert-info').html('Updated Successfully').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
          }
      });
    });

    $('#update_password').click(function(e){
      if ($('#change_pass_form')[0].checkValidity()){
        e.preventDefault();
        var password = $('#password').val();
        var converted_password = $('#converted_password').val();
        password = $.sha1(password);
        if (password === converted_password){
            $.ajax({
            type : 'POST',
            url : '<?php echo base_url(); ?>Client_profile/change_password',
            contentType: false,       
            cache: false,             
            processData:false,
            data: new FormData($('#change_pass_form')[0]),
            success: function(data){
              $('.alert-info').html('Password Changed').fadeIn().fadeOut().fadeIn().fadeOut().fadeIn().delay(4000).fadeOut('slow');
              $('#converted_password').val($.sha1($('#new_password').val()));
              $('#change_pass_form')[0].reset();
              document.getElementById("new_password").disabled = true;
              document.getElementById("confirm_new_password").disabled = true; 
              document.getElementById('message').innerHTML = '';
              document.getElementById('confirm_message').innerHTML = '';

              alert('Password Successfully Changed!');
              }
          });
          }else{
            alert('Something Went Wrong!');
          }
      }else{
        $('#change_pass_form')[0].reportValidity();
      }
    });

 
function get_mun(val,selected,brgy){
  $.ajax({
    type: "POST",
    url: "<?php echo base_url(); ?>General/municipality_list",
    dataType: "JSON",
    data:'provCode='+val,
    success: function(data){
        if(data != false){
            municipality_list = "<option value='' disabled selected>Select City</option>";
            jQuery.each(data, function(i, val) {
              if(selected == val.citymunCode){
                municipality_list +="<option value='"+val.citymunCode+"' selected>"+val.citymunDesc+"</option>";
              }else{
                municipality_list +="<option value='"+val.citymunCode+"'>"+val.citymunDesc+"</option>";
              }
            });
        }
    },
    complete: function (data) {
        $("#citymunCode").html(municipality_list);
        get_brgy(selected,brgy);
    }
  });
}

function get_brgy(val){
  if(val!=''){
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>General/brgy_list",
      dataType: "JSON",
      data:{citymunCode:val},
      success: function(data){
          if(data != false){
              brgy_list = "<option value='' disabled selected>Select Brgy</option>";
              jQuery.each(data, function(i, val) {
                  brgy_list +="<option value='"+val.brgyCode+"'>"+val.brgyDesc+"</option>";
              });
          }
      },
      complete: function (data) {
//$("#brgyCode").html(brgy_list);
      }
    });
  }else{
    brgyCode = "<option value='' disabled selected>Select Municipality / City First</option>";
    $("#brgyCode").html(brgy_list);
  }
}
$(document).ready(function(){
  $('#loader').hide();
  $("#provCode").change(function() {
    var val = $(this).val();
    get_mun(val);
  });  
  $("#citymunCode").change(function() {
    var val = $(this).val();
    get_brgy(val);
  });   
});
</script>

<script>
$(document).ready(function() {
  $('#showpass').click(function(){
    if($('#password').attr('type') == 'password' ){
      $('#password').attr("type","text");
      $('#showhide').text('Hide');
      $('#eye').removeClass('fa-eye');
      $('#eye').addClass('fa-eye-slash');
    }else{
      $('#password').attr("type","password");
      $('#showhide').text('Show');
      $('#eye').addClass('fa-eye');
      $('#eye').removeClass('fa-eye-slash');
    }
  })

  $('#cshowpass').click(function(){
    if($('#new_password').attr('type') == 'password' ){
      $('#new_password').attr("type","text");
      $('#confirm_new_password').attr("type","text");
      $('#cshowhide').text('Hide');
      $('#ceye').removeClass('fa-eye');
      $('#ceye').addClass('fa-eye-slash');
    }else{
      $('#new_password').attr("type","password");
      $('#confirm_new_password').attr("type","password");
      $('#cshowhide').text('Show');
      $('#ceye').removeClass('fa-eye');
      $('#ceye').addClass('fa-eye-slash');
    }
  })


  $('#hdec').click(function(){
    window.location.href = "<?php echo base_url(); ?>Health_declaration";
  });
  $('#lab_id').click(function(){
    $('#qrcode_dispay').html('');
    var add_color = oddeven_color('<?= $brgyCode ?>');
    $('#add_color').removeClass('bg-success');
    $('#add_color').removeClass('bg-warning');
    $('#add_color').addClass(add_color);
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     var width = 200;
     var height = 200;
    }else{
     var width = 350;
     var height = 350;
    }
    $('#qrcode_dispay').qrcode({
        render: "canvas",
        width: width,
        height: height,
        background: "#ffffff",
        foreground: "#000000",
        text: `<?= $qrcode ?>`,
        src: `<?php echo base_url('assets/images/lblogo.png'); ?>`,
        imgWidth: 75,
        imgHeight: 75
      });
   $('#client_info_modal').modal('show');
       html2canvas(element, {
      background:'#fff',
      onrendered: function (canvas) {
        $("#previewImage").append(canvas);
        getCanvas = canvas;
      }
    });
 }) 
   $('#viewresult').DataTable({
    responsive: true,
    "aLengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],
    "iDisplayLength": 10,
    //dom: 'Blfrtip',
    select: true,
    orderCellsTop: true,
    "order":[],
    "buttons":[
                {
                  extend: 'print',
                  text: 'Print all',
                  title:"<?= $fname.' '.$lname.' '?>Symptoms",
                  messageTop:"",
                  exportOptions:{
                    columns: [ 0, 1, 2],
                    modifier: {
                      selected: null
                    },
                  }
                },
                {
                  extend: 'print',
                  text: 'Print Selected Only',
                  title:"<?= $fname.' '.$lname.' '?>Symptoms",
                  messageTop:"",
                  exportOptions:{
                    columns: [ 0, 1, 2],
                    modifier: {
                      selected: true
                    },
                  }
                },
                {
                  extend: 'pdf',
                  text: 'Pdf',
                  title:"<?= $fname.' '.$lname.' '?>Symptoms",
                  exportOptions:{
                    columns: [ 0, 1, 2],
                    modifier: {
                      selected: true
                    },
                  }
                },
                {
                  extend: 'excel',
                  text: 'Excel',
                  title:"<?= $fname.' '.$lname.' '?>Symptoms",
                  exportOptions:{
                    columns: [ 0, 1, 2],
                    modifier: {
                      selected: true
                    },
                  }
                },
              ],    
            });
    $('#viewresult tbody').on( 'click', 'tr', function () {
        $(this).toggleClass('selected');
    });

});        
</script> 
<?php  $this->load->view('client_profile/lab_id'); ?>
<script src="<?php echo base_url(); ?>assets/js/html2canvas.js"></script>
<script src="<?php echo base_url(); ?>assets/js/sha1.js"></script>
