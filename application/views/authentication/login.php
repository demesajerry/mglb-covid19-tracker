<!DOCTYPE html>
<html>
<head>
  <style>
  .btnRefresh{background-color:#8B8B8B;border:0;padding:7px 10px;color:#FFF;float:left;}
  .span-captcha{
    width: 78px !important;
  }
  #captcha_code{
    height: 33px  !important;
    vertical-align: baseline;
  }
  </style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LAB-Tracker | Log in</title>
  <link rel="icon" href="<?php echo base_url('assets/images/silislogo.png'); ?>">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
      <span class="logo-lg"><img src="<?php echo base_url('assets/images/lblogo.png'); ?>" width='100' height='100'></span>
      LB LAB
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in</p>

    <form  method="post">
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="username" placeholder="Username">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="text" id="captcha" class="form-control" placeholder="Captcha" required="required">
        <span class="form-control-feedback span-captcha"><img id="captcha_code" src="<?php echo base_url();?>/General/captcha_generator" /></span>
      </div>
      <div>
        <button class="btnRefresh" id="refreshCaptcha">Refresh Captcha</button>

      </div>
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="button" id="btnlogin" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script type="text/javascript">
  var lat, long;
  var baseurl = "<?php echo base_url();?>";	
    $(document).ready(function(){
      $('#btnlogin').on('click', function(){
        login();		
      });
    });	
    $(document).keypress(function(event){

    if ("geolocation" in navigator){ //check geolocation available 
        //try to get user current location using getCurrentPosition() method
        navigator.geolocation.getCurrentPosition(function(position){ 
          lat = position.coords.latitude;
          long = position.coords.longitude;
        });
    }else{
          lat = '0';
          long = '0';
    }      

    var keycode = (event.keyCode ? event.keyCode : event.which);
        if(keycode == '13'){
          $('#btnlogin').addClass("disabled"); 
          login();  
        }

    });   

    $('#refreshCaptcha').click(function(e){
      e.preventDefault();
      $("#captcha_code").attr("src","<?php echo base_url();?>/General/captcha_generator");
    })

    function login()
    {
      var username = $('#username').val();
      var password = $('#password').val();        
      var captcha = $('#captcha').val();    
      var message='';    
      if(username==''){
        message +='Username Cannot be Empty.\n';
      }
      if(password==''){
        message +='Password Cannot be Empty.\n';
      }
      if(captcha==''){
        message +='Captcha Cannot be Empty.';
      }
      if(message==''){
      $(this).addClass("disabled"); 
      $.ajax({
        type: "POST",
        url: baseurl + "Authentication/login",
        data: {
          username: username,
          password: password,
          captcha: captcha,
          lat: lat,
          long: long
        },
        success: function(e){				
          $('#btnlogin').removeClass("disabled");
          if(e.message != "Completed"){	
            alert(e.message);
          } else{
            window.location = baseurl+e.home_page;
          }
        }				
      });
    }else{
      alert(message);
    }
    }
</script>
</body>
</html>
