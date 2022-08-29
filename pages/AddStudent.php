
<?php

  if ( !@session("administrator") )
    {
        redirect(base_url()."Login");
        return;
    }
?>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">


<section class="content">
   <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">New Student Register</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               <form method="post" id="register_form" action="<?=base_url()?>AddStudent" novalidate="novalidate">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Full Name</label>
                    <input type="text" class="form-control" id="FullName" name="FullName" placeholder="FullName">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Number</label>
                    <input type="text" class="form-control" id="number" name="number"  placeholder="Student Number">
                  </div>
                            <div class="form-group">
                    <label for="exampleInputPassword1">GSM Number</label>
                    <input type="text" class="form-control" id="gsm" name="gsm"placeholder="GSM Number">
                  </div>
                                    <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" id="email"  name="email"placeholder="exampe@example.com">
                  </div>
             
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Register Studen</button>
                </div>
              </form>
            </div>
    </section>
      </div>
<?php
  if ( $_POST )

    {
               global $dbo;

                $FullName = $_POST['FullName'];
                $number = $_POST['number'];
                $gsm = $_POST['gsm'];
                $email = $_POST['email'];
                if(!$FullName || !$number || !$gsm || !$email)
                {
                messageBox(2,"Please fill in all fields");
                }else{


               $checkNumber = $dbo->get_var("SELECT COUNT(*) FROM student WHERE number = {$number}");

               if($checkNumber > 0)
               {
                 messageBox(2,"Registered student available");
               }else if(!is_email($email))
               {
messageBox(2,"Not found email adres!");
                }
                else{
            $insert_student = $dbo->insert("student", array(

                            "Full_name"          =>  $FullName,
                            "email"                 =>  $email,
                            "gsm_number"           =>  $gsm,
                            "number"         =>  $number,


                        ) );
            if($insert_student)
               messageBox(1,"Registered Succesfully");
             else
               messageBox(2,"Registered Error !");
                // register complate
               }



                }
               
      }
?>

</body>
</html>
