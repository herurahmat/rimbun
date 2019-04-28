<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Login</title>
    <?php
    echo cdn_bootstrap_css();
    echo cdn_jquery();
    echo cdn_font_awesome();
    rb_core_header();
    ?>
    <style>
    	html,
body {
  height: 100%;
}

body {
  display: -ms-flexbox;
  display: -webkit-box;
  display: flex;
  -ms-flex-align: center;
  -ms-flex-pack: center;
  -webkit-box-align: center;
  align-items: center;
  -webkit-box-pack: center;
  justify-content: center;
  padding-top: 10px;
  padding-bottom: 40px;
  background-color: #f5f5f5;
}

.form-signin {
  width: 100%;
  max-width: 330px;
  padding: 15px;
  margin: 0 auto;
}
.form-signin .checkbox {
  font-weight: 400;
}
.form-signin .form-control {
  position: relative;
  box-sizing: border-box;
  height: auto;
  padding: 10px;
  font-size: 16px;
}
.form-signin .form-control:focus {
  z-index: 2;
}
.form-signin input[type="email"] {
  margin-bottom: -1px;
  border-bottom-right-radius: 0;
  border-bottom-left-radius: 0;
}
.form-signin input[type="password"] {
  margin-bottom: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
}
    </style>
  </head>
  <body class="text-center">
    	<?php
    	echo form_open($url,array('id'=>'frmlogin','class'=>'form-signin'));
    	echo rb_csrf_generate();
    	?>
      <img class="mb-4" src="<?=rb_system_logo(200);?>" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Silahkan Login</h1>
      <label for="userText" class="sr-only">Username atau Email</label>
      <input type="usertext" name="usertext" id="userText" class="form-control" placeholder="Username atau Email" required autofocus>
      <label for="userPass" class="sr-only">Password</label>
      <input type="password" name="userpass" id="userPass" class="form-control" placeholder="Password" required>
      <?php
      $flash=$this->session->flashdata('login_error');
      if(!empty($flash))
      {
	  	?>
	  	<div class="alert alert-warning">
		  <strong>Login Error!</strong> <?=$flash;?>
		</div>
	  	<?php
	  }
      ?>
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    <?php
    echo form_close();
    ?>
    
    <?php
    echo cdn_bootstrap_js();
    ?>
  </body>
</html>