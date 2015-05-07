<?php 
include_once("../config.php");
$sql="INSERT INTO Activity(ActCode,ActDesc) VALUES('12','test insert')";
//$rs=odbc_exec($conn,$sql);


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{
  echo"insert data success";
}


odbc_close($conn);

?>

