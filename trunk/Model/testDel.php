<?php 
include_once("../config.php");

$sql="DELETE FROM Activity WHERE ActCode=12";
//$rs=odbc_exec($conn,$sql);


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{
  echo"delete data success";
}


odbc_close($conn);

?>

