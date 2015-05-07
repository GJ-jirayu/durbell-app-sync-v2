<?php

include_once("../config.php");

$paramTextSearch = trim($_POST["paramTextSearch"]);
$paramItemCode = trim($_POST["paramItemCode"]);
$paramItemName = trim($_POST["paramItemName"]);
/*
  if($paramTextSearch=="All"){
  $sql="SELECT * FROM PromGroup";

  }else{
  $sql="SELECT * FROM PromGroup where GroupCode like '%$paramTextSearch%' or GroupDesc like '%$paramTextSearch%'";
  }
 */
if ($paramItemCode != "") {

    $sql = "SELECT * FROM PromGroup where GroupCode='$paramItemCode' order by GroupCode";
} else if ($paramItemName != "") {

    $sql = "SELECT * FROM PromGroup where GroupDesc='$paramItemName' order by GroupCode";
} else {

    $sql = "SELECT * FROM PromGroup order by GroupCode";
}
$sqlConv = iconv("utf-8", "tis-620", $sql);
$rs = odbc_exec($conn, $sqlConv);
if (!$rs) {
    exit("Error in SQL");
} else {
    $i = 0;
    $promGroup = "";
    $promGroup.="[";
    while (odbc_fetch_row($rs)) {

        $GroupCode = iconv("tis-620", "utf-8", odbc_result($rs, "GroupCode"));
        $GroupDesc = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));

        if ($i == 0) {
            $promGroup.="[";
            $promGroup.="\"" . $GroupCode . "\"";
            $promGroup.=",\"" . $GroupDesc . "\"";
            $promGroup.="]";
        } else {
            $promGroup.=",[";
            $promGroup.="\"" . $GroupCode . "\"";
            $promGroup.=",\"" . $GroupDesc . "\"";
            $promGroup.="]";
        }

        $i++;
    }

    $promGroup.="]";
    odbc_close($conn);

    echo $promGroup;
    //echo"[\"$GroupCode\",\"$GroupDesc\"]";
}
//echo"[[\"Piece\",\"Piece1\"],[\"Pack\",\"Pack\"]]";
?>