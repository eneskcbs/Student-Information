<?php 

function LoadStudent (){
global $dbo;
$result="";

$my_tables = $dbo->get_results("SELECT * FROM `student`");



	foreach ( $my_tables as $table )
	{
	$result.="<tr><td>".$table->id."</td><td>".$table->full_name."</td><td>".$table->number."</td><td>".$table->email."</td><td>".$table->gsm_number."</td><td class='project-actions text-right'>
                          <a class='btn btn-primary btn-sm' href='".base_url()."editProfile/".$table->number."'>
                              <i class='fas fa-eye'>
                              </i>
                              View
                          </a>
                          <a class='btn btn-info btn-sm' href='".base_url()."AddExam/".$table->number."'>
                              <i class='fas fa-pencil-alt'>
                              </i>
                              Add Exam
                          </a>
                          <a class='btn btn-danger btn-sm' href='".base_url()."DeleteStudent/".$table->number."'>
                              <i class='fas fa-trash'>
                              </i>
                              Delete
                          </a>
                      </td></tr>";
	}	
	
	echo $result;
}
function LoadExam ($studentid){
global $dbo;
$result="";

$my_tables = $dbo->get_results("SELECT * FROM `exam_result` where student_id=$studentid");
	if($my_tables==0)
		return;
$counter=1;

	foreach ( $my_tables as $table )
	{
		$get = $dbo->get_row("SELECT * FROM course where id={$table->course_id}");

	$result.="<tr><td>".$counter."</td><td>".$table->student_id."</td><td>".$table->course_id."</td><td>".$get->name."</td><td>".$table->score."</td><td>".  ($table->score > 2 ? "<span class='float-right badge bg-success'>Successful</span>" : "<span class='float-right badge bg-danger'>Unsuccessful</span>") ."</td></tr>";

	$counter++;
	}	
	
	echo $result;
}

function LoadAllExam (){
global $dbo;
$result="";
$counter=1;
$my_tables = $dbo->get_results("SELECT * FROM `exam_result`");

	if($my_tables==0)
		return;
	
	foreach ( $my_tables as $table )
	{
		$get = $dbo->get_row("SELECT * FROM student where number={$table->student_id}");
		$get2 = $dbo->get_row("SELECT * FROM course where id={$table->course_id}");

	$result.="<tr><td>".$counter."</td><td>  ".$get->full_name."
                   
                      </div></td><td>".$get2->name."</td><td>".$table->score."</td><td>".  ($table->score > 2 ? "<span class='float-right badge bg-success'>Successful</span>" : "<span class='float-right badge bg-danger'>Unsuccessful</span>") ."</td></tr>";
	$counter++;
	}	
	
	echo $result;
}
function LoadAllCourse (){
global $dbo;
$result="";
$counter=1;
$my_tables = $dbo->get_results("SELECT * FROM `course`");



	foreach ( $my_tables as $table )
	{
		$get = $dbo->get_var("SELECT COUNT(*)  FROM exam_result where course_id={$table->id} and Score > 3");
		$get2 = $dbo->get_var("SELECT COUNT(*)  FROM exam_result where course_id={$table->id} and Score < 3");

	$result.="<tr><td>".$counter."</td><td>".$table->id."</td><td>".$table->name."</td><td><span class='float-right badge bg-success'> ".$get."</span></td><td><span class='float-right badge bg-danger'>".$get2."<span></td></tr>";
	$counter++;
	}	
	
	echo $result;
}
function LoadAllCourseMini (){
global $dbo;
$result="";
$counter=1;
$my_tables = $dbo->get_results("SELECT * FROM `course`");



	foreach ( $my_tables as $table )
	{

$result.="<tr><td>".$counter."</td><td>".$table->id."</td><td>".$table->name."</td><td class='text-right py-0 align-middle'>
                      <div class='btn-group btn-group-sm'>
                        <a href='#' class='btn btn-info'><i class='fas fa-eye'></i></a>
                        <a href='".base_url()."DeleteCourse/".$table->id."' class='btn btn-danger'><i class='fas fa-trash'></i></a>
                      </div>
                    </td></tr>";
	$counter++;
	}	
	
	echo $result;
}
?>