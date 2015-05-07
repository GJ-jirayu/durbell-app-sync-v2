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
$paramAction = $_POST['paramAction'];
$paramPromType = $_POST['paramPromType'];
$paramPromNo = $_POST['paramPromNo'];
$paramItemCode = $_POST['paramItemCode'];
$paramBreakBy = $_POST['paramBreakBy'];
//$paramDisCountFor = $_POST['paramDisCountFor'];
$paramLimitFreeQty = $_POST['paramLimitFreeQty'];
$paramFreeUnitCode = $_POST['paramFreeUnitCode'];
//$paramLimitDiscBath = $_POST['paramLimitDiscBath'];
$paramPromNoSearch = trim($_POST['paramPromNoSearch']);


//get parameter end

include_once("../config.php");
//echo"$paramAction";
$last_modified = date("Y-m-d H:i:s");
//add data
if ($paramAction == "add") {
    
    $itemNo = count($paramItemCode);
    $res = array();
    for ($i = 0; $i < $itemNo; $i++) {
        $sqlCheck = "SELECT * FROM PromItem where PromType ='$paramPromType' and  PromNo ='$paramPromNo'and  PromCode ='$paramItemCode[$i]'";
        if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
//            echo'["id-already"]';
            array_push($res, $paramItemCode[$i]);
        } else {
            $sql = "INSERT INTO PromItem(PromType,PromNo,PromCode,BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,last_modified) 
		VALUES('$paramPromType','$paramPromNo','$paramItemCode[$i]','$paramBreakBy','','$paramLimitFreeQty','$paramFreeUnitCode','$last_modified')";

            $rs = odbc_exec($conn, $sql);
            /* if (!$rs) {
              exit("Error in SQL");
              } else {
              echo'["save-success"]';
              } */
        }
    }
    echo json_encode($res);
    odbc_close($conn);
}


//delete data
if ($paramAction == "checkUseProm") {
    $sqlCheck = "SELECT * FROM OrderDetailGetPromotion  where PromType ='$paramPromType'and  PromNo ='$paramPromNo' and PromCode='$paramItemCode'";
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
            if (!$rs) {
                exit("Error in SQL");
            } else {
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

    $sql = "SELECT PromItem.*,Item.ItemDesc FROM PromItem "
            . "left join Item on PromItem.PromCode=Item.ItemCode  where PromCode ='$paramItemCode' "
            . "and PromType='$paramPromType' and PromNo='$paramPromNo'";
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
            $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
            $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
//            $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
            $LimitFreeQty = iconv("tis-620", "utf-8", odbc_result($rs, "LimitFreeQty"));
            $FreeUnitCode = iconv("tis-620", "utf-8", odbc_result($rs, "FreeUnitCode"));
//            $LimitDiscBaht = iconv("tis-620", "utf-8", odbc_result($rs, "LimitDiscBaht"));
        }
//        echo"[\"$PromCode\",\"$BreakBy\",\"$DiscFor\",\"$LimitFreeQty\",\"$FreeUnitCode\",\"$LimitDiscBaht\",\"$ItemDesc\"]";
        echo"[\"$PromCode\",\"$BreakBy\",\"$LimitFreeQty\",\"$FreeUnitCode\",\"$ItemDesc\"]";
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

    $sql = "UPDATE PromItem SET "
            . "BreakBy='$paramBreakBy',"
//            . "DiscFor='$paramDisCountFor',"
            . "LimitFreeQty='$paramLimitFreeQty',"
            . "FreeUnitCode='$paramFreeUnitCode',"
//            . "LimitDiscBaht='$paramLimitDiscBath',"
            . "last_modified='$last_modified'"
            . "WHERE PromCode ='$paramItemCode' "
            . "and PromType='$paramPromType' "
            . "and PromNo='$paramPromNo'";

    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        echo'["update-success"]';
    }
    odbc_close($conn);
}


//show data
if ($paramAction == "showData") {
    $sql = "SELECT PromItem.*,Item.ItemDesc FROM PromItem left join Item
on PromItem.PromCode=Item.ItemCode
where PromType='$paramPromType' and PromNo='$paramPromNo' order by PromNo, PromCode";


    $htmlShowData = "";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    /*
      Item code 	Description 	Break By 	Limit Free Qty   	Manage
     */
    $htmlShowData.= "<table id='grid' class='table table-striped'>";
    $htmlShowData.= "<colgroup>";
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
    $htmlShowData.= "<th data-field=\"field2\"><b>Item code </b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Description </b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>Break By </b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Limit Free Qty</b></th>";
    $htmlShowData.= "<th data-field=\"field6\"><b>Manage  </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    
    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
        $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
        $Description = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
        $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
        $LimitFreeQty = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "LimitFreeQty")));
        //$FreeUnitCode=odbc_result($rs,"FreeUnitCode");
        $LimitDiscBaht = iconv("tis-620", "utf-8", odbc_result($rs, "LimitDiscBaht"));

        $htmlShowData.= "<tr><td>$PromNo</td>";
        $htmlShowData.= "<td>$PromCode</td>";
        $htmlShowData.= "<td>$Description</td>";
        $htmlShowData.= "<td>$BreakBy</td>";
        $htmlShowData.= "<td style=\"text-align: right\">$LimitFreeQty</td>";
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

if ($paramAction == "promNoSearch") {

    $sql = "SELECT * FROM PromHeader where PromNo ='$paramPromNoSearch'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {

        if ($paramPromNoSearch == "All") {
            $PromNo = "All";
            $PromDesc = "";
        } else {
            while (odbc_fetch_row($rs)) {
                $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
                $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
            }
        }
        echo"[\"$PromNo\",\"$PromDesc\"]";
    }
}
?>