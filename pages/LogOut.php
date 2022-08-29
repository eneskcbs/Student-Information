<?php
  if (@session("administrator") )
    {
        global $dbo;
 session_destroy();
    unset($_SESSION["administrator"]);
  
    redirect(base_url());
    }else redirect(base_url());
?>