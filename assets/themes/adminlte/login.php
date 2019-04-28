<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php
  echo cdn_bootstrap3_css();
  echo cdn_font_awesome();
  echo cdn_ionicons();
  ?>
  <link href="<?=rb_path_themes();?>adminlte/dist/css/AdminLTE.min.css" rel="stylesheet">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="<?=rb_system_logo(200);?>"/>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Silahkan login untuk masuk dashboard</p>
	<?php
	echo form_open($url,array('id'=>'frmlogin','class'=>'form-signin'));
	echo rb_csrf_generate();
	?>
      <div class="form-group has-feedback">
        <input type="text" name="usertext" class="form-control" placeholder="Username or Email" autofocus="">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="userpass" class="form-control" placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
         &nbsp;
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    <?php
    echo form_close();
    ?>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<?php
echo cdn_jquery();
echo cdn_bootstrap3_js();
?>
</body>
</html>
