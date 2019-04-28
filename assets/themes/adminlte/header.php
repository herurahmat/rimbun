<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php
  echo cdn_bootstrap3_css();
  echo cdn_font_awesome();
  echo cdn_ionicons();
  ?>
  <link href="<?=rb_path_themes();?>adminlte/dist/css/AdminLTE.min.css" rel="stylesheet">
  <link href="<?=rb_path_themes();?>adminlte/dist/css/skins/_all-skins.min.css" rel="stylesheet">
  <?php
  echo cdn_jquery();
  rb_user_check_login();
  rb_core_header();
  ?>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?=rb_dashboard_url();?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>PP</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?=rb_system_option('app_name');?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?=rb_user_avatar(64);?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?=rb_user_info('nick_name');?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?=rb_user_avatar(200);?>" class="img-circle" alt="User Image">

                <p>
                  <?=rb_user_info('full_name');?> - <?=rb_user_role_name();?>
                </p>
              </li>
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="<?=base_url();?>core/member/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="<?=base_url();?>core/auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?=rb_user_avatar(200);?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=rb_user_info('full_name');?></p>
          <?=rb_user_role_name();?>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="<?=rb_dashboard_url();?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <?php
        require_once(dirname(__FILE__).DS.'navigation.php');
        ?>
        <li class="header">Execution Time {elapsed_time} ms<br/>
        Memory Usage {memory_usage}</li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     <?=rb_message_header_get();?>
     <h1>
	    <?=$title;?>
	    <?php
	    if(isset($help))
	    {
			if($help==TRUE)
			{
				echo rb_get_documentation($help);
			}
		}
	    ?>
	</h1>
    </section>

    <!-- Main content -->
    <section class="content">
	
      <!-- Default box -->
      <div class="box">
        <div class="box-header">
          
        </div>
        <div class="box-body">
        
