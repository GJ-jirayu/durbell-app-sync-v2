<?php
	include_once("../config.php");
	//for real database start.

$sql="
select distinct substr(SalesNo,1,2) as SalesTeam
from Sales
order by SalesTeam
";


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{

	$jsonData="";
	$jsonData.="[";	
	$i=0;
	while (odbc_fetch_row($rs)) {
			$SalesTeam=odbc_result($rs,"SalesTeam");
			
			if($i==0){
				$jsonData.="[";
					$jsonData.="\"".$SalesTeam."\"";
					$jsonData.=",\"".$SalesTeam."\"";
				$jsonData.="]";
			}else{
				$jsonData.=",[";
					$jsonData.="\"".$SalesTeam."\"";
					$jsonData.=",\"".$SalesTeam."\"";
				$jsonData.="]";
			}
	$i++;
	}
	$jsonData.="]";	
}
echo $jsonData;


//for real database end.

//	echo"[[\"A\",\"Sales Team A\"],[\"B\",\"Sales Team B\"],[\"C\",\"Sales Team C\"]]";
?>