<?php

include_once("../config.php");


//for real database start.
$sql="
select ShopTypeCode, ShopTypeName
from ShopType
order by ShopTypeName
";


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{

	$jsonData="";
	$jsonData.="[";	
	$i=0;
	while (odbc_fetch_row($rs)) {
			$ShopTypeCode=iconv("tis-620", "utf-8",odbc_result($rs,"ShopTypeCode"));
			$ShopTypeName=iconv("tis-620", "utf-8",odbc_result($rs,"ShopTypeName"));
			
			if($i==0){
				$jsonData.="[";
					$jsonData.="\"".$ShopTypeCode."\"";
					$jsonData.=",\"".$ShopTypeName."\"";
				$jsonData.="]";
			}else{
				$jsonData.=",[";
					$jsonData.="\"".$ShopTypeCode."\"";
					$jsonData.=",\"".$ShopTypeName."\"";
				$jsonData.="]";
			}
	$i++;
	}
	$jsonData.="]";	
}
echo $jsonData;


//for real database end.

//	echo"[[\"001\",\"Shop Type 01\"],[\"002\",\"Shop Type 02\"],[\"003\",\"Shop Type 03\"],[\"004\",\"Shop Type 04\"]]";
?>