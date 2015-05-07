<?php
include_once("../config.php");
function checkAlreadyId1($conn,$sql){
		
		$rs=odbc_exec($conn,$sql);
		if (!$rs) {
		    exit("Error in SQL");
		}else{
			$num=odbc_fetch_row($rs);
			if($num){
			return 'Already-Id';
			}else{
			return 'Empty-Id';
			}
		}
		odbc_close($conn);
	}


$sqlCheck="SELECT * FROM PromGroupItem where GroupCode ='asdfasd'and  ItemCode ='10101008'";
echo checkAlreadyId1($conn,$sqlCheck);


$last_modified = date("Y-m-d");
echo $last_modified ;
?>