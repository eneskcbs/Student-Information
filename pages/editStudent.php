
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

$succes_course = $dbo->get_var("SELECT COUNT(*) FROM exam_result WHERE student_id = {$value} and score > 2");
$total_score =  0;


$unsucces_course =  0;
$total= 0;
$averange= 0;
$is_object = $dbo->get_row("SELECT * FROM student WHERE number = {$value}");
if($succes_course  > 0)
{

$total_score = $dbo->get_var("SELECT sum(score) FROM exam_result WHERE student_id = {$value}");


$unsucces_course = $dbo->get_var("SELECT COUNT(*) FROM exam_result WHERE student_id = {$value} and score < 3");
$total=intval($unsucces_course+$succes_course); 
$averange=intval($total_score/$total); 
}
?>
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">


            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="<?=base_url()?>dist/img/student.png" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$is_object->full_name?></h3>



                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Full Name</b> <a class="float-right"><?=$is_object->full_name?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Number</b> <a class="float-right"><?=$is_object->number?></a>
                  </li>
                  <li class="list-group-item">
                    <b>GSM Number</b> <a class="float-right"><?=$is_object->gsm_number?></a>
                  </li>
                   <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?=$is_object->email?></a>
                  </li>
                </ul>

               
              </div>
          
            </div>
        

          </div>
        
          <div class="col-md-9">
            <div class="card">
          
              <div class="card-body">
                <div class="tab-content">

     <a class="btn btn-app" href="<?=base_url()?>">
                  <i class="fas fa-edit"></i> Back Student List
                </a>
                  <div class="tab-pane active" id="settings">
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
                <div class="card-footer">
                <div class="row">
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"></i><?=$total?></span>
                      <h5 class="description-header">Total Course</h5>
       
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                      <span class="description-percentage text-success"></i><?=$succes_course?></span>
                      <h5 class="description-header">Total Successful Course</h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block border-right">
                       <span class="description-percentage text-danger"></i><?=$unsucces_course?></span>
                     <h5 class="description-header">Total Failed  Exam</h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-3 col-6">
                    <div class="description-block">
                      <span class="description-percentage text-<?=$averange> 3 ?"success":"danger"?>"></i><?=$averange?></span>
                 
                      <h5 class="description-header"><?=$averange> 3 ?"SUCCESSFUL":"FAILED"?></h5>
                              <span class="description-text">GANO</span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                </div>
                <!-- /.row -->
              </div>
                  </div>
                
                </div>
                
              </div>
            </div>
         
          </div>
       
        </div>
       
      </div>
    </section>
      </div>
	   <script>

  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  });
  
</script>