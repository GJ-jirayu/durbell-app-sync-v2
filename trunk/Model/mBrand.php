<?php


include_once("../config.php");
$brand=$_POST['pramBrand'];
$paramItemCode=$_POST['paramItemCode'];


$sql="
select 'All' as BrandCode,'All-Brand' as BrandName
union
SELECT BrandCode,BrandName FROM Brand 
where IsActive = 1
and IsFree = 0
order by BrandName
";


$rs=odbc_exec($conn,$sql);
if (!$rs) {
  exit("Error in SQL");
}else{

	$jsonBrand="";
	$jsonBrand.="[";	
	$i=0;
	while (odbc_fetch_row($rs)) {
			$BrandCode=iconv("tis-620", "utf-8",odbc_result($rs,"BrandCode"));
			$BrandName=iconv("tis-620", "utf-8",odbc_result($rs,"BrandName"));
			if($i==0){
				$jsonBrand.="[";
					$jsonBrand.="\"".$BrandCode."\"";
					$jsonBrand.=",\"".$BrandName."\"";
				$jsonBrand.="]";
			}else{
				$jsonBrand.=",[";
					$jsonBrand.="\"".$BrandCode."\"";
					$jsonBrand.=",\"".$BrandName."\"";
				$jsonBrand.="]";
			}
	$i++;
	}
	$jsonBrand.="]";	
}
echo $jsonBrand;


	//echo"[[\"All\",\"All Brand\"],[\"001\",\"Brand01\"],[\"002\",\"Brand02\"],[\"003\",\"Brand03\"],[\"004\",\"Brand04\"],[\"005\",\"Brand05\"],[\"006\",\"Brand06\"],[\"007\",\"Brand07\"]]";
?>
