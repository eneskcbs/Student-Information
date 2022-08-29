
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
      <div class="row">
        <div class="col-md-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Add New Course</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
       <form method="post" id="register_form" action="<?=base_url()?>AddCourse" novalidate="novalidate">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Course Name</label>
                    <input type="text" class="form-control" id="CourseName" name="CourseName" placeholder="CourseName">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Course ID</label>
                    <input type="text" class="form-control" id="number" name="number"  placeholder="Course ID">
                  </div>
                  
             
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
              
        <input type="submit" value="Add Course" class="btn btn-success float-right">
                </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Course List</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                        <thead>
                 <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 1%">
                       ID
                      </th>
                      <th style="width: 20%">
                         Course Name
                      </th>
                                 <th style="width: 1%">
                       
                      </th>
                  </tr>
              </thead>
                  </thead>
                  <tbody>
              <?=LoadAllCourseMini()?>
                  </tbody>
            
                </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
 
    </section>



      </div>
<?php
  if ( $_POST )

    {
               global $dbo;

                $CourseName = $_POST['CourseName'];
                $number = $_POST['number'];
                
                if(!$CourseName || !$number)
                {
                messageBox(2,"Please fill in all fields");
                }else{


               $checkNumber = $dbo->get_var("SELECT*FROM course WHERE id = {$number} or name='{$CourseName}'");

               if($checkNumber > 0)
               {
                 messageBox(2,"Registered course available");
               }else
               {


            $insert_student = $dbo->insert("course", array(

                            "name"          =>  $CourseName,
                            "id"                 =>  $number,
         


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
