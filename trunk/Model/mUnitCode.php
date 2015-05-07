<?php
include_once("../config.php");
/*
select UnitCode,UnitName 
from Unit
*/
$sql="
select UnitCode, UnitName
from Unit
where UnitCode in ('CTN', 'PAC', 'PCS')
order by UnitName 

";


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{

	$jsonData="";
	$jsonData.="[";	
	$i=0;
	while (odbc_fetch_row($rs)) {
			$UnitCode=iconv("tis-620", "utf-8",odbc_result($rs,"UnitCode"));
			$UnitName=iconv("tis-620", "utf-8",odbc_result($rs,"UnitName"));
			if($i==0){
				$jsonData.="[";

					$jsonData.="\"".$UnitCode."\"";
					$jsonData.=",\"".$UnitName."\"";

				$jsonData.="]";
			}else{
				$jsonData.=",[";

					$jsonData.="\"".$UnitCode."\"";
					$jsonData.=",\"".$UnitName."\"";

				$jsonData.="]";
			}
	$i++;
	}
	$jsonData.="]";	
}
echo $jsonData;



//echo"[[\"Piece\",\"Piece1\"],[\"Pack\",\"Pack\"]]";
?>