
<?php

  if ( !@session("administrator") )
    {
        redirect(base_url()."Login");
        return;
    }
    global $dbo;
    $check_student = $dbo->get_var("SELECT COUNT(*) FROM student");
       $check_course = $dbo->get_var("SELECT COUNT(*) FROM course");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$page_title?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?=base_url()?>plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/adminlte.min.css">
  
<!-- jQuery -->
<script src="<?=base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
  <link rel="stylesheet" href="../../plugins/pace-progress/themes/black/pace-theme-flat-top.css">
<script src="<?=base_url()?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url()?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url()?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url()?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url()?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="../../plugins/pace-progress/pace.min.js"></script
<script src="<?=base_url()?>plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="<?=base_url()?>plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!---test -->
<script src="<?=base_url()?>dist/js/ekoAjax.js"></script>
</head>
<body class="hold-transition sidebar-mini pace-primary">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=base_url()?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=current_url()?>" class="nav-link"><?=$page_title?></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">


    <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">1</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="<?=base_url()?>dist/img/student.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Enes KOCABAŞ
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The under construction</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 1 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
     
     
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" href="<?=base_url()?>LogOut">
          <i class="fas fa-th-large" aria-hidden="true"></i>
          <span class="badge badge-warning navbar-badge">Exit</span>
        </a>
   
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="<?=base_url()?>" class="brand-link">
      <img src="<?=base_url()?>dist/img/student.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Manager Student</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?=base_url()?>dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Hello ! Admin</a>
        </div>
      </div>

    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                 <li class="nav-header">STUDENT</li>
                <li class="nav-item">
            <a href="<?=base_url()?>" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <span class="badge badge-info right"><?=$check_student?></span>
              <p>
                All Student
                
              </p>
            </a>
          </li>
        <li class="nav-item">
            <a href="<?=base_url()?>AddStudent" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Add Student
        
              </p>
            </a>
          </li>

 <li class="nav-header">COURSE</li>
           <li class="nav-item">
            <a href="<?=base_url()?>AllCourse" class="nav-link">
              <i class="nav-icon fas fa-columns"></i>
                 <span class="badge badge-info right"><?=$check_course?></span>
              <p>
                All Course
        
              </p>
            </a>
          </li>
            <li class="nav-item">
            <a href="<?=base_url()?>AddCourse" class="nav-link">
  <i class="nav-icon fas fa-edit"></i>

              <p>
                Add Course
        
              </p>
            </a>
          </li>
           <li class="nav-header">EXAM</li>
                   <li class="nav-item">
            <a href="<?=base_url()?>AllExam" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              
              <p>
                All Exam
        
              </p>
            </a>
          </li>
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
    
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>