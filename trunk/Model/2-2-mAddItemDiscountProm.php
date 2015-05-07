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
$paramDisCountFor = $_POST['paramDisCountFor'];
$paramLimitFreeQty = $_POST['paramLimitFreeQty'];
$paramFreeUnitCode = $_POST['paramFreeUnitCode'];
$paramLimitDiscBath = $_POST['paramLimitDiscBath'];



//get parameter end

include_once("../config.php");

$last_modified = date("Y-m-d H:i:s");
//echo"$paramAction";
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
    $itemNo = count($paramItemCode);
    $res = array();
    for ($i = 0; $i < $itemNo; $i++) {
        $sqlCheck = "SELECT * FROM PromItem where PromType ='$paramPromType' and  PromNo ='$paramPromNo'and  PromCode ='$paramItemCode[$i]'";
        if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
            array_push($res, $paramItemCode[$i]);
        } else {
            $sql = "INSERT INTO PromItem(PromType,PromNo,PromCode,BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht,last_modified) 
		VALUES('$paramPromType','$paramPromNo','$paramItemCode[$i]','$paramBreakBy','$paramDisCountFor','$paramLimitFreeQty','$paramFreeUnitCode','$paramLimitDiscBath','$last_modified')";

            $rs = odbc_exec($conn, $sql);
            /*if (!$rs) {
                exit("Error in SQL");
            } else {
                echo'["save-success"]';
            }*/
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

//select data for edit
if ($paramAction == "edit") {

    $sql = "SELECT PromItem.*,Item.ItemDesc FROM PromItem
left join Item on PromItem.PromCode=Item.ItemCode  where PromCode ='$paramItemCode' and PromType='$paramPromType' and PromNo='$paramPromNo'";
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
where PromType='$paramPromType' and PromNo='$paramPromNo' order by PromNo, PromCode ";


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
    $htmlShowData.= "<col style=\"width:20%\" />";
    $htmlShowData.= "</colgroup>";

    $htmlShowData.= "<thead>";
    $htmlShowData.= "<tr>";
    $htmlShowData.= "<th data-field=\"field0\" ><b>Promotion No</b></th>";
    $htmlShowData.= "<th data-field=\"field1\" ><b>Item Code </b></th>";
    $htmlShowData.= "<th data-field=\"field2\" ><b>Description </b></th>";
    $htmlShowData.= "<th data-field=\"field3\" ><b>Break By </b></th>";
    $htmlShowData.= "<th data-field=\"field4\" ><b>Discount <br> For</b></th>";
    $htmlShowData.= "<th data-field=\"field5\" ><b>Limit Free <br> Qty</b></th>";
    $htmlShowData.= "<th data-field=\"field6\" ><b>Limit Discount <br> Baht</b></th>";
    $htmlShowData.= "<th data-field=\"field7\" ><b>Manage  </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";

    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
        $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
        $Description = iconv("tis-620", "utf-8//IGNORE", odbc_result($rs, "ItemDesc"));
        
        $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
        $LimitFreeQty = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "LimitFreeQty"))); //number_format($number, 2, '.', '')
        //$FreeUnitCode=odbc_result($rs,"FreeUnitCode");
        $LimitDiscBaht = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "LimitDiscBaht")), 2, '.', ',');

        $htmlShowData.= "<tr><td>$PromNo</td>";
        $htmlShowData.= "<td>$PromCode</td>";
        $htmlShowData.= "<td>$Description</td>";
        $htmlShowData.= "<td>$BreakBy</td>";
        $htmlShowData.= "<td>$DiscFor</td>";
        $htmlShowData.= "<td>$LimitFreeQty</td>";
        $htmlShowData.= "<td>$LimitDiscBaht</td>";
        //$htmlShowData.= "<td>$FreeUnitCode</td>";


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