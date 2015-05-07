<?php


include_once("../config.php");
$sql="
select BranchCode, BranchName
from Branch
order by BranchName 

";


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{

	$jsonData="";
	$jsonData.="[";	
	$i=0;
	while (odbc_fetch_row($rs)) {
			$BranchCode=iconv("tis-620", "utf-8",odbc_result($rs,"BranchCode"));
			$BranchName=iconv("tis-620", "utf-8",odbc_result($rs,"BranchName"));
			
			if($i==0){
				$jsonData.="[";
					$jsonData.="\"".$BranchCode."\"";
					$jsonData.=",\"".$BranchName."\"";
				$jsonData.="]";
			}else{
				$jsonData.=",[";
					$jsonData.="\"".$BranchCode."\"";
					$jsonData.=",\"".$BranchName."\"";
				$jsonData.="]";
			}
	$i++;
	}
	$jsonData.="]";	
}
echo $jsonData;


//for real database end.

/*
	echo"[[\"All\",\"All Brach\"],[\"001\",\"Brach001\"],[\"002\",\"Brach002\"],[\"003\",\"Brach003\"],[\"004\",\"Brach004\"],[\"005\",\"Brach005\"],[\"006\",\"Brach006\"],[\"007\",\"Brach007\"]]";
*/
?>