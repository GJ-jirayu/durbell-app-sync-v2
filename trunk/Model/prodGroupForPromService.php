<?php
$checkError = ini_get('error_reporting');
error_reporting($checkError  ^ E_NOTICE);
	$paramGroupCode = $_POST['paramGroupCode'];
	$paramGroupDesc = $_POST['paramGroupDesc'];
	$paramAction = $_POST['paramAction'];
	//echo"$paramAction";

	if($paramAction=="add"){
		//echo"add here ";
		//echo $paramGroupCode;
		//echo $paramGroupDesc;
		
		echo'["success"]';
	}

	if($paramAction=="delete"){
		echo"delete here ";
	

	}
	if($paramAction=="edit"){
		echo"edit here ";


	}


?>