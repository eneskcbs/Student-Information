<?php 

// php settings.
	session_start();
	date_default_timezone_set('Europe/Istanbul');

	require 'lib/Router/RouterCommand.php';
	require 'lib/Router/RouterException.php';
	require 'lib/Router/RouterRequest.php';
	require 'lib/Router.php';
	include_once 'ez_sql_core.php'; // ezSQL Database Class
	include_once 'ez_sql_mysql.php'; // ezSQL MySQL Database Class
	include_once 'LoadTable.php'; // LoadTable 

 $mysqldb = array(
		"DB_HOST"		=> "localhost",
		"DB_NAME" 		=> "admin_enes",
		"DB_USER" 		=> "admin_enes",
		"DB_PASS" 		=> '9Dpv#99h',
		);
		
				
$dbo = new ezSQL_mysqli($mysqldb["DB_USER"], $mysqldb["DB_PASS"], $mysqldb["DB_NAME"], $mysqldb["DB_HOST"]);

	
 $settings = $dbo->get_row("SELECT * FROM student LIMIT 1");

function current_url()
{
    return "http://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
}

function base_url()
{
    return "http://" . $_SERVER["HTTP_HOST"] . "/";
}
function gondereko ($url){
	echo "<script>window.location = '".$url."'</script>";	
}

function messageBox($status,$message)
{
	if($status==1)
	echo "<script type=\"text/javascript\"> \$(function() { toastr.success('".$message."') }); </script>";
	else
		echo "<script type=\"text/javascript\"> \$(function() { toastr.error('".$message."') }); </script>";
}

function redirect($url = "", $time = 0)
{
    echo '<script>
  window.location.href = "'.$url.'";
</script>';

}

function is_email($email = NULL)
{
    return preg_match("#([a-zA-Z0-9_-]+)(\\@)([a-zA-Z0-9_-]+)(\\.)([a-zA-Z0-9]{2,4})(\\.[a-zA-Z0-9]{2,4})?#", $email);
}
function is_phone($phone = NULL)
{
    return preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $phone);
}
function create_session($par)
{
    foreach( $par as $anahtar => $deger ) 
    {
        $_SESSION[$anahtar] = $deger;
    }
}

function session($par)
{
    if( $_SESSION[$par] ) 
    {
        return $_SESSION[$par];
    }

    return false;
}

function unset_session($par)
{
    if( $_SESSION[$par] ) 
    {
        unset($_SESSION[$par]);
        return true;
    }

    return false;
}

function sqldefender($str)
		{
			$search = array("/*", "*/", "'");
			$replace = array("", "" , "");
			$str = str_ireplace($search, $replace, $str);
			$str = htmlspecialchars($str);

			if( preg_match("@insert|delete|update|replace|truncate|drop|create|exec|select@si",$str) )
			{
				die( "SQL Injection Detected" );
			}
			else
			{
				switch (gettype($str))
				{
					case 'string' : $str = addslashes(stripslashes($str));
					break;
					case 'boolean' : $str = ($str === FALSE) ? 0 : 1;
					break;
					default : $str = ($str === NULL) ? 'NULL' : $str;
					break;
				}
			}
			return $str;
		}

?>
