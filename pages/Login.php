<?php
  if ( @session("administrator") )
    {
        redirect(base_url());
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Manager Login | Page </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/adminlte.min.css">
      <link rel="stylesheet" href="<?=base_url()?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/toastr/toastr.min.css">
<!-- jQuery -->
<script src="<?=base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
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
<script src="<?=base_url()?>plugins/sweetalert2/sweetalert2.min.js"></script>

<script src="<?=base_url()?>plugins/toastr/toastr.min.js"></script>

<script src="<?=base_url()?>dist/js/adminlte.min.js"></script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?=base_url()?>" class="h1"><b>Login</b>Page</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?=base_url()?>Login" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="uid" id="uid" placeholder="Administrator">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      

  </div>

</div>
 <?php         
 global $dbo;
                        if ( isset($_POST["login"]) )
                        {

                            $uid        =   sqldefender($_POST["uid"]);
                            $pass       =   sqldefender($_POST["pass"]);
                            $passmd5    =   md5($pass);

                            if ( !$uid || !$pass )
                            {
                               echo  $uid;
                                messageBox(2,"Please fill in all fields");
                            }
                            else
                            {
                                $is = $dbo->get_var("SELECT COUNT(*) FROM _web_adminusers WHERE uname = '{$uid}' and passmd5 = '{$passmd5}' LIMIT 1");
                                if ( !$is )
                                {
                                     messageBox(2,"Username or Password is wrong");
                                }
                                else
                                {
                                    messageBox(1,"Login Succesful");
                                    $sessions   =   array(
                                        "administrator"         =>  $uid
                                        );
                                    create_session($sessions);

                                    $dbo->update("_web_adminusers", array(
                                        "last_login_time" => date("Y-m-j H:i:s"),
                                        "last_login_ip" => $_SERVER["REMOTE_ADDR"]
                                        ),
                                        array(
                                            "uname" => $uid
                                        ));

                                    redirect(base_url(), 2);
                                }
                            }
                        }
                    ?>

<!-- jQuery -->
<script src="<?=base_url()?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url()?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>dist/js/adminlte.min.js"></script>
</body>
</html>
