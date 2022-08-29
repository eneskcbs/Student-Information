<?php 


	include_once 'lib/Load.php';



	$router = new Buki\Router();

	
	
	include_once 'eko_ajaxpage/general.php';
include_once 'eko_ajaxpage/JSON.php';
	$router->run();
	?>