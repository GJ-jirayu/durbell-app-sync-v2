<?php

$checkError = ini_get('error_reporting');
error_reporting($checkError ^ E_NOTICE);
//get parameter start
/*
  paramPromNo
  paramItemCode
  paramBreakBy
  paramDisCountFor
  paramLimitFreeQty
  paramFreeUnitCode
  paramLimitDiscBath
 */
$paramAction = trim($_POST['paramAction']);
$paramPromType = trim($_POST['paramPromType']);
$paramPromNo = trim($_POST['paramPromNo']);
$paramItemCode = trim($_POST['paramItemCode']);
$paramBreakBy = trim($_POST['paramBreakBy']);
$paramDisCountFor = trim($_POST['paramDisCountFor']);
$paramLimitFreeQty = trim($_POST['paramLimitFreeQty']);
$paramFreeUnitCode = trim($_POST['paramFreeUnitCode']);
$paramLimitDiscBath = trim($_POST['paramLimitDiscBath']);



//get parameter end

include_once("../config.php");
//echo"$paramAction";
$last_modified = date("Y-m-d H:i:s");
//add data
if ($paramAction == "add") {
    /*
      echo "1". $paramAction ."<br>";
      echo "2".$paramPromNo  ."<br>";
      echo "3".$paramItemCode  ."<br>";
      echo "4".$paramBreakBy  ."<br>";
      echo "5".$paramDisCountFor ."<br>";
      echo "6".$paramLimitFreeQty ."<br>";
      echo "7".$paramFreeUnitCode ."<br>";
      echo "8".$paramLimitDiscBath ."<br>";

      --Table PromItem start--

      PromType
      PromNo
      PromCode
      BreakBy
      DiscFor
      LimitFreeQty
      FreeUnitCode
      LimitDiscBaht

      --Table PromItem end--
     */
    //echo checkAlreadyId($conn,"asdfasd");
    $sqlCheck = "SELECT * FROM PromItem where PromType ='$paramPromType' and  PromNo ='$paramPromNo'and  PromCode ='$paramItemCode'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        $sql = "INSERT INTO PromItem(PromType,PromNo,PromCode,BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht,last_modified) 
		VALUES('$paramPromType','$paramPromNo','$paramItemCode','$paramBreakBy','$paramDisCountFor','$paramLimitFreeQty','$paramFreeUnitCode','$paramLimitDiscBath','$last_modified')";
        $sqlConv = iconv("utf-8", "tis-620", $sql);
        $rs = odbc_exec($conn, $sqlConv);
        if (!$rs) {
            exit("Error in SQL");
        } else {
            echo'["save-success"]';
        }
        odbc_close($conn);
    }
}


//delete data
if ($paramAction == "checkUseProm") {
    $sqlCheck = "SELECT * FROM OrderDetailGetPromotion  where PromType ='$paramPromType'and  PromNo ='$paramPromNo' and PromCode = '$paramItemCode' ";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        echo'["id-empty"]';
    }
}
if ($paramAction == "delete") {
    $sqlPromStepFreeItem = "delete from PromStepFreeItem where PromType = '$paramPromType' and PromNo = '$paramPromNo' and PromCode = '$paramItemCode' ";
    $rsPromStepFreeItem = odbc_exec($conn, $sqlPromStepFreeItem);
    if (!$rsPromStepFreeItem) {
        exit("Error in SQL");
    } else {
        $sqlPromStep = "delete from PromStep where PromType = '$paramPromType' and PromNo = '$paramPromNo' and PromCode = '$paramItemCode' ";
        $rsPromStep = odbc_exec($conn, $sqlPromStep);
        if (!$rsPromStep) {
            exit("Error in SQL");
        } else {
            $sql = "DELETE FROM PromItem WHERE PromCode='$paramItemCode' and PromType ='$paramPromType' and  PromNo ='$paramPromNo'";
            $rs = odbc_exec($conn, $sql);
            if(!$rs){
                exit("Error in SQL");
            }else{
                echo'["success"]';
            }
        }
    }
    odbc_close($conn);
}
//if ($paramAction == "delete") {
//
//    $sql = "DELETE FROM PromItem WHERE PromCode='$paramItemCode' and PromType ='$paramPromType' and  PromNo ='$paramPromNo'";
//    $rs = odbc_exec($conn, $sql);
//    if (!$rs) {
//        exit("Error in SQL");
//    } else {
//        echo'["success"]';
//    }
//    odbc_close($conn);
//}



//select data for edit
if ($paramAction == "edit") {

    $sql = "SELECT PromItem.*,PromGroup.GroupDesc FROM PromItem
left join PromGroup on PromItem.PromCode=PromGroup.GroupCode 
where PromCode ='$paramItemCode' and PromType='$paramPromType' and PromNo='$paramPromNo'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        /*
          Table PromItem Start

          PromType
          PromNo
          PromCode
          BreakBy
          DiscFor
          LimitFreeQty
          FreeUnitCode
          LimitDiscBaht

          Table PromItem End
         */
        while (odbc_fetch_row($rs)) {
            $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
            $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
            $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
            $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
            $LimitFreeQty = iconv("tis-620", "utf-8", odbc_result($rs, "LimitFreeQty"));
            $FreeUnitCode = iconv("tis-620", "utf-8", odbc_result($rs, "FreeUnitCode"));
            $LimitDiscBaht = iconv("tis-620", "utf-8", odbc_result($rs, "LimitDiscBaht"));
        }
        echo"[\"$PromCode\",\"$BreakBy\",\"$DiscFor\",\"$LimitFreeQty\",\"$FreeUnitCode\",\"$LimitDiscBaht\",\"$ItemDesc\"]";
    }
}
//update data 
if ($paramAction == "editAction") {


    /*

      -- PromItem --


      BreakBy
      DiscFor
      LimitFreeQty
      FreeUnitCode
      LimitDiscBaht

      -- Parameter PromItem Start --

      paramBreakBy
      paramDisCountFor
      paramLimitFreeQty
      paramFreeUnitCode
      paramLimitDiscBath

      -- Parameter PromItem End--

     */



    $sql = "UPDATE PromItem SET BreakBy='$paramBreakBy',DiscFor='$paramDisCountFor',LimitFreeQty='$paramLimitFreeQty',
		FreeUnitCode='$paramFreeUnitCode',LimitDiscBaht='$paramLimitDiscBath',last_modified='$last_modified'
		WHERE PromCode ='$paramItemCode' and PromType='$paramPromType' and PromNo='$paramPromNo'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        echo'["update-success"]';
    }
    odbc_close($conn);
}
//show data
if ($paramAction == "showData") {
    $sql = "SELECT PromItem.*,PromGroup.GroupDesc,Unit.UnitName FROM PromItem inner join PromGroup
on PromItem.PromCode=PromGroup.GroupCode
inner join Unit on PromItem.FreeUnitCode=Unit.UnitCode
where PromType='$paramPromType' and PromNo='$paramPromNo'
order by PromItem.promNo, PromItem.promCode ";

    $htmlShowData = "";

    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    /*
      Item code 	Description 	Break By 	Disc For 	Limit Free Qty 	Limit Disc Qty 	Manage
     */
    $htmlShowData.= "<table id='grid' class='table table-striped'>";
    $htmlShowData.= "<colgroup>";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "</colgroup>";

    $htmlShowData.= "<thead>";
    $htmlShowData.= "<tr>";
    $htmlShowData.= "<th data-field=\"field1\"><b>Promotion No</b></th>";
    $htmlShowData.= "<th data-field=\"field2\"><b>Group code </b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Description </b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>Break By </b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Discount <br> For  </b></th>";
    $htmlShowData.= "<th data-field=\"field6\"><b>Limit Free <br> Qty  </b></th>";
    $htmlShowData.= "<th data-field=\"field7\"><b>Limit Discount <br> baht  </b></th>";
    $htmlShowData.= "<th data-field=\"field8\"><b>Manage  </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $promNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
        $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
        $Description = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
        $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
        $LimitFreeQty = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "LimitFreeQty")));
        $UnitName = iconv("tis-620", "utf-8", odbc_result($rs, "UnitName"));
        $LimitDiscBaht = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "LimitDiscBaht")), '2', '.', ',');

        $htmlShowData.= "<tr>";
        $htmlShowData.= "<td>$promNo</td>";
        $htmlShowData.= "<td>$PromCode</td>";
        $htmlShowData.= "<td>$Description</td>";
        $htmlShowData.= "<td>$BreakBy</td>";
        $htmlShowData.= "<td>$DiscFor</td>";
        $htmlShowData.= "<td>$LimitFreeQty</td>";
        $htmlShowData.= "<td>$LimitDiscBaht</td>";
        $htmlShowData.="
							<td>
							<button type=\"button\" class=\"btn btn-primary btn-xs btnEdit\" id=\"idEdit-$PromCode\">Edit </button>
							<button type=\"button\" class=\"btn btn-primary btn-xs btnPromStep\"  id=\"idPromStep-$PromCode\">Promotion Step </button>
							<button type=\"button\" class=\"btn btn-danger btn-xs btnDel\"  id=\"idDel-$PromCode\">Delete </button>
							
							
							</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}
?>