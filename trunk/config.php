<?php

$checkError = ini_get('error_reporting');
error_reporting($checkError  ^ E_NOTICE);

date_default_timezone_set('Asia/Bangkok');


$conn=odbc_connect('SmartVanDB_Server','dba','sql');
//odbc_exec($conn,'SET NAMES UTF8');
$message = "ทดสอบ UTF-8";

$tis620 = iconv("utf-8", "tis-620", $message );
$utf8 = iconv("tis-620", "utf-8", $tis620 );

/*
echo "Page charset=utf-8";
echo "<br/>";
echo "Convert from UTF-8 to TIS-620 = ".$tis620;
echo "<br/>";
echo "Convert from TIS-620 to UTF-8 = ".$utf8;
*/
function checkAlreadyId($conn,$sql){
		
		$rs=odbc_exec($conn,$sql);
		if (!$rs) {
		    exit("Error in SQL");
		}else{
			$num=odbc_fetch_row($rs);
			if($num){
			return"Already-Id";
			}else{
			return"Empty-Id";
			}
		}
		odbc_close($conn);
	}


function utf8_to_tis620($string) {
   $str = $string;
   $res = "";
   for ($i = 0; $i < strlen($str); $i++) {
      if (ord($str[$i]) == 224) {
        $unicode = ord($str[$i+2]) & 0x3F;
        $unicode |= (ord($str[$i+1]) & 0x3F) << 6;
        $unicode |= (ord($str[$i]) & 0x0F) << 12;
        $res .= chr($unicode-0x0E00+0xA0);
        $i += 2;
      } else {
        $res .= $str[$i];
      }
   }
   return $res;
}

function tis620_to_utf8($in) {
   $out = "";
   for ($i = 0; $i < strlen($in); $i++)
   {
     if (ord($in[$i])){
       $out .= $in[$i];
     }else{
       $out .= "&#" . (ord($in[$i]) - 161 + 3585) . ";";
	 }
   }
   return $out;
}

?>