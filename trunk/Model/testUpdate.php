<?php 
include_once("../config.php");
/*
UPDATE table_name
SET column1=value, column2=value2,...
WHERE some_column=some_value
*/
$sql="UPDATE Activity SET ActDesc='edit data' WHERE ActCode=11";
//$rs=odbc_exec($conn,$sql);


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{
  echo"edit data success";
}


odbc_close($conn);

?>

