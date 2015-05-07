<?php 
include_once("../config.php");
$sql="SELECT * FROM Activity";
//$rs=odbc_exec($conn,$sql);


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}

echo "<table><tr>";
echo "<th>ActCode</th>";
echo "<th>ActDesc</th></tr>";
while (odbc_fetch_row($rs)) {
  $compname=odbc_result($rs,"ActCode");
  $conname=odbc_result($rs,"ActDesc");
  echo "<tr><td>$compname</td>";
  echo "<td>$conname</td></tr>";
}
odbc_close($conn);
echo "</table>";
?>

