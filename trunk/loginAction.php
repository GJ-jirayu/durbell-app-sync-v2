<?php session_start(); ob_start();


include_once("config.php");

$paramUser=trim($_GET['paramUser']);
$paramPass=trim($_GET['paramPass']);
$paramAction=trim($_GET['paramAction']);

/*
if($paramUser=="admin" and $paramPass=="pass"){
	$_SESSION['sessUser']=$paramUser;
	$_SESSION['sesPass']=$paramUser;
	echo'["success"]';
}else{
	echo'["not-find"]';
}
*/

if($paramAction=="login"){

	$sql="
	select UserID,UserName,Password,GroupID from UserAccount
	WHERE UserName='$paramUser' and Password='$paramPass'
	";

	$rs=odbc_exec($conn,$sql);
	$num=odbc_fetch_row($rs);

	if($num){
		
		odbc_fetch_row($rs);
		
		$UserName=iconv("tis-620", "utf-8",odbc_result($rs,"UserName"));
		$Password=iconv("tis-620", "utf-8",odbc_result($rs,"Password"));
		$GroupID=iconv("tis-620", "utf-8",odbc_result($rs,"GroupID"));

		$_SESSION['sessUser']=$UserName;
		$_SESSION['sesPass']=$Password;
		$_SESSION['sesGroupID']=$GroupID;

		echo'["success"]';
	}else{
		echo'["not-find"]';
	}

}
if($paramAction=="logout"){

unset($_SESSION['sessUser']);
unset($_SESSION['sesPass']);
unset($_SESSION['sesGroupID']);

echo'["success"]';
header( "location:login.php" );

	

}

?>
