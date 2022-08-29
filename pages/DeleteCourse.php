
<?php

  if ( !@session("administrator") )
    {
        redirect(base_url()."Login");
        return;
    }
?>
<?php
global $dbo;
if($value > 0)
{
     $dbo->delete("exam_result", array("course_id" => $value));
 $dbo->delete("course", array("id" => $value));

      
         redirect(base_url()."AddCourse");

}else
redirect(base_url());
?>