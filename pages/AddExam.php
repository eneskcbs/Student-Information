
<?php

  if ( !@session("administrator") )
    {
        redirect(base_url()."Login");
        return;
    }
?>
<?php
global $dbo;
  $is_object = $dbo->get_var("SELECT*FROM student WHERE number = {$value}");
if($is_object==0)
{
  echo'<section class="content">
      <div class="error-page">
        <h2 class="headline text-warning"> 404</h2>

        <div class="error-content">
          <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

          <p>
            We could not find the page you were looking for.
            Meanwhile, you may <a href="'.base_url().'">return to dashboard</a> or try using the search form.
          </p>

         
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page -->
    </section> </div>';
return;
}

$get = $dbo->get_row("SELECT * FROM student WHERE number = {$value}");

?>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="<?=base_url()?>plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url()?>dist/css/adminlte.min.css">

<section class="content">
      <div class="row">
        <div class="col-md-6">
			
          <div class="card card-primary">
            <div class="card-header">
				
              <h3 class="card-title">General</h3>

        
            </div>
                  <form method="post" id="register_form" action="<?=current_url()?>" novalidate="novalidate">
            <div class="card-body">
              <div class="form-group">
                <label for="inputName">Full Name</label>
                <input type="text" id="inputName" name="inputName"value="<?=$get->full_name?>" disabled="" class="form-control">
              </div>
         
              <div class="form-group">
                <label for="inputStatus">Select Course</label>
                <select id="getClass" name="getClass"  class="form-control custom-select">
               
                  <?php
        
      $my_tables = $dbo->get_results("SELECT * FROM course");

  foreach ( $my_tables as $table )
  {
                  ?>
                  <option value="<?=$table->id?>"><?=$table->name?></option>
     
                  <?php
          } 
                  ?>
                </select>
              </div>

            </div>
          
          </div>
        
     <a class="btn btn-app" href="<?=base_url()?>">
                  <i class="fas fa-edit"></i> Back Student List
                </a>
        </div>
        <div class="col-md-6">
          <div class="card card-secondary">
            <div class="card-header">
              <h3 class="card-title">Point</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                    <label for="exampleInputPassword1">Score</label>
                    <input type="number" class="form-control" id="score"  name="score">
                  </div>
             
                </div>
         <br>
    <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add Exam</button>
                </div>
            </div>

      </form>


            <!-- /.card-body -->
          </div>

          <!-- /.card -->
        </div>
     <table id="example1" class="table table-bordered table-striped">
                        <thead>
                  <tr>
                      <th style="width: 1%">
                          #
                      </th>
                      <th style="width: 20%">
                          Student_id
                      </th>
                      <th style="width: 30%">
                          Course_id
                      </th>
             <th style="width: 30%">
                          Course_Name
                      </th>
                      <th>
                         Score
                      </th> <th>
                         Status
                      </th>
                 
                  </tr>
              </thead>
                  </thead>
                  <tbody>
              <?=LoadExam($value)?>
                  </tbody>
            
                </table>
      </div>
    
    </section>
  </div>
<?php
  if ( $_POST )

    {
         global $dbo;

                $score = $_POST['score'];
                $getClass = $_POST['getClass'];
              
                if(!$getClass || !$score)
                {
                messageBox(2,"Please fill in all fields");
                }else{


               $checkNumber = $dbo->get_var("SELECT * FROM exam_result WHERE student_id = {$value} && course_id={$getClass}");

               if($checkNumber > 0)
               {
                 messageBox(2,"Course grade has already been given");
               }else
               {
$insert_student = $dbo->insert("exam_result", array(

                            "student_id"          =>  $value,
                            "course_id"                 =>  $getClass,
                            "score"           =>  $score,
                          


                        ) );



               messageBox(1,"The student was given a score.");
          
                // register complate
               

               }
             }
      }
?>

</body>
</html>
  <script>

  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
  
</script>