
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
       $dbo->delete("student", array("number" => $value));
 $dbo->delete("exam_result", array("student_id" => $value));

      
         redirect(base_url());

}else
redirect(base_url());
?>