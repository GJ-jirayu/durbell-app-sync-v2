<?php

$checkError = ini_get('error_reporting');
error_reporting($checkError ^ E_NOTICE);
//get parameter start
/* 	
  ################       PromStepFreeItem Start ###############
  paramPromType
  paramPromNo
  paramPromCode
  paramStep
  paramFreeItemCode
  paramFreeQty
  paramFreeUnitCode
  paramFreeUnitFactor
  paramGLAccount
  ################       PromStepFreeItem End ###############
 */


$paramAction = $_POST['paramActionFreeItem'];
$paramPromType = $_POST['paramPromType'];
$paramPromNo = $_POST['paramPromNo'];

$paramStep = $_POST['paramStep'];
$paramSeq = $_POST['paramSeq'];
$paramFreeItemCode = $_POST['paramFreeItemCode'];
$paramFreeQty = $_POST['paramFreeQty'];
$paramFreeUnitCode = $_POST['paramFreeUnitCode'];
$paramFreeUnitFactor = $_POST['paramFreeUnitFactor'];
$paramGLAccount = $_POST['paramGLAccount'];
$paramUnitCode = $_POST['paramUnitCode'];
$last_modified = date("Y-m-d H:i:s");


//get parameter end

include_once("../config.php");
//echo"$paramAction";
$last_modified = date("Y-m-d H:i:s");

if ($paramAction == "countPromStepFreeItemSeq") {
    $sqlCountRows = "SELECT max(Seq) as countRows
	FROM PromBundleFreeItem
	WHERE PromType='$paramPromType'
	And PromNo='$paramPromNo'
	and Step='$paramStep'";

    //echo"test data countPromStepFreeItemSeq";


    $rsCoountRows = odbc_exec($conn, $sqlCountRows);
    if (!$rsCoountRows) {
        exit("Error in SQL");
    } else {
        odbc_fetch_row($rsCoountRows);
        $countRows = odbc_result($rsCoountRows, "countRows");
        echo'["' . $countRows . '"]';
    }
}


//get data getUitFactor start
if ($paramAction == "getDataUnitFactor") {
    $sql = "select UnitFactor from UnitOfItem
where ItemCode='$paramFreeItemCode'
and UnitCode='$paramUnitCode'
";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {

        while (odbc_fetch_row($rs)) {
            $UnitFactor = odbc_result($rs, "UnitFactor");
        }
        echo"[\"$UnitFactor\"]";
    }
}

//get data prom step start
if ($paramAction == "getDataPromStep") {

    /*
      <table class="table">
      <thead>
      <tr>
      <th>Prom No</th>
      <th>Prom Desc</th>
      <th>Step</th>
      <th>Prom Code</th>
      <th>Description</th>
      <th>Break By</th>
      <th>Discount For</th>


      </tr>
      </thead>
      <tbody>
      <tr>
      <td>D1520501</td>
      <td>F4 Kavamucho Start Promo</td>
      <td>1</td>
      <td>Detail Promotion.</td>
      <td>Q</td>
      <td>B</td>
      </tr>
      </tbody>
      </table>
     */


    $sql = "select * from PromHeader
where PromType='$paramPromType'
and PromNo='$paramPromNo'";

    $htmlShowData = "";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    odbc_fetch_row($rs);
    $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
    $Description = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
    $htmlShowData.= "$PromNo $Description";
    echo $htmlShowData;
}




//get data prom step end
//add data
if ($paramAction == "add") {
    /*
      echo "1". $paramAction ."<br>";
      echo "2".$paramPromType  ."<br>";
      echo "3".$paramPromNo  ."<br>";
      echo "4".$paramPromCode  ."<br>";
      echo "5".$paramStep ."<br>";
      echo "6".$paramFreeItemCode ."<br>";
      echo "7".$paramFreeQty ."<br>";
      echo "8".$paramFreeUnitCode ."<br>";
      echo "9".$paramFreeUnitFactor ."<br>";
      echo "10".$paramGLAccount ."<br>";
     */
    /*
      ################       PromStepFreeItem Start ###############
      paramPromType
      paramPromNo
      paramPromCode
      paramStep
      paramFreeItemCode
      paramFreeQty
      paramFreeUnitCode
      paramFreeUnitFactor
      paramGLAccount
      ################       PromStepFreeItem End ###############
     */
    $sqlCheck = "SELECT * FROM PromBundleFreeItem 
where PromType ='$paramPromType' and  PromNo ='$paramPromNo' AND Step='$paramStep' AND FreeItemCode='$paramFreeItemCode' AND Seq='$paramSeq'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {

        $sql = "INSERT INTO PromBundleFreeItem(PromType,PromNo,Step,Seq,FreeItemCode,FreeQty,FreeUnitCode,FreeUnitFactor,GLAccount,last_modified) 
		VALUES('$paramPromType','$paramPromNo','$paramStep','$paramSeq','$paramFreeItemCode','$paramFreeQty','$paramFreeUnitCode','$paramFreeUnitFactor','$paramFreeItemCode$paramGLAccount','$last_modified')";

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
if ($paramAction == "checkUseItemFree") {
    $sqlCheck = "SELECT * FROM OrderDetailGetPromotion WHERE PromType='$paramPromType' and PromNo='$paramPromNo' and Seq='$paramSeq' and Step='$paramStep' and FreeItemCode='$paramFreeItemCode' ";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        echo'["id-empty"]';
    }
}
if ($paramAction == "delete") {
    $sql = "DELETE FROM PromBundleFreeItem WHERE PromType='$paramPromType' and PromNo='$paramPromNo' and Seq='$paramSeq' and Step='$paramStep' and FreeItemCode='$paramFreeItemCode'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        echo'["success"]';
    }
    odbc_close($conn);
}

//select data for edit
if ($paramAction == "edit") {

    $sql = "SELECT psfi.*,Item.ItemDesc FROM PromBundleFreeItem psfi
left join Item on psfi.FreeItemCode=Item.ItemCode
WHERE PromType='$paramPromType' and PromNo='$paramPromNo' and Step='$paramStep' and Seq='$paramSeq'";

    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        /*
          ################       PromStepFreeItem Start ###############
          paramPromType
          paramPromNo
          paramPromCode
          paramStep
          paramFreeItemCode
          paramFreeQty
          paramFreeUnitCode
          paramFreeUnitFactor
          paramGLAccount
          ################       PromStepFreeItem End ###############
         */
        while (odbc_fetch_row($rs)) {
            $FreeItemCode = iconv("tis-620", "utf-8", odbc_result($rs, "FreeItemCode"));
            $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
            $FreeQty = iconv("tis-620", "utf-8", odbc_result($rs, "FreeQty"));
            $FreeUnitCode = iconv("tis-620", "utf-8", odbc_result($rs, "FreeUnitCode"));
            $FreeUnitFactor = iconv("tis-620", "utf-8", odbc_result($rs, "FreeUnitFactor"));
            $GLAccount = iconv("tis-620", "utf-8", odbc_result($rs, "GLAccount"));
            $Step = iconv("tis-620", "utf-8", odbc_result($rs, "Step"));
            $Seq = iconv("tis-620", "utf-8", odbc_result($rs, "Seq"));
        }
        echo"[\"$FreeItemCode\",\"$FreeQty\",\"$FreeUnitCode\",\"$FreeUnitFactor\",\"$GLAccount\",\"$ItemDesc\",\"$Step\",\"$Seq\"]";
    }
}
//update data 
if ($paramAction == "editAction") {



    /*
      ################       PromStepFreeItem Start ###############
      paramPromType
      paramPromNo
      paramPromCode
      paramStep

      paramFreeItemCode
      paramFreeQty
      paramFreeUnitCode
      paramFreeUnitFactor
      paramGLAccount

      FreeItemCode
      FreeQty
      FreeUnitCode
      FreeUnitFactor
      GLAccount

      ################       PromStepFreeItem End ###############
     */
    $sql = "UPDATE PromBundleFreeItem SET FreeItemCode='$paramFreeItemCode',FreeQty='$paramFreeQty',FreeUnitCode='$paramFreeUnitCode',
		FreeUnitFactor='$paramFreeUnitFactor',GLAccount='$paramGLAccount',last_modified='$last_modified'
		WHERE PromType='$paramPromType' and PromNo='$paramPromNo' and Step='$paramStep' and Seq='$paramSeq'";

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
    $sql = "SELECT pbft.*,Item.ItemDesc,Unit.UnitName FROM PromBundleFreeItem pbft
left join Item on pbft.FreeItemCode=Item.ItemCode
inner join Unit on pbft.FreeUnitCode= Unit.UnitCode
where PromType='$paramPromType' and PromNo='$paramPromNo' order by Step,Seq";

    $htmlShowData = "";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    /*
      Free Item Code 	Description 	Free Qty 	Unit 	Gl Account 	Manage
     */
    $htmlShowData.= "<table id='grid2' class='table table-striped'>";
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
    $htmlShowData.= "<th data-field=\"field1\"><b>Step</b></th>";
    $htmlShowData.= "<th data-field=\"field2\"><b>Seq</b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Free Item Code</b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>Description</b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Free Qty</b></th>";
    $htmlShowData.= "<th data-field=\"field6\"><b>Unit </b></th>";
    $htmlShowData.= "<th data-field=\"field7\"><b>Gl Account</b></th>";
    $htmlShowData.= "<th data-field=\"field8\"><b>Manage </b> </th>";
    /*
      ################       PromStepFreeItem Start ###############
      paramPromType
      paramPromNo
      paramPromCode
      paramStep
      paramFreeItemCode
      paramFreeQty
      paramFreeUnitCode
      paramFreeUnitFactor
      paramGLAccount
      ################       PromStepFreeItem End ###############
     */
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $Step = iconv("tis-620", "utf-8", odbc_result($rs, "Step"));
        $Seq = iconv("tis-620", "utf-8", odbc_result($rs, "Seq"));
        $FreeItemCode = iconv("tis-620", "utf-8", odbc_result($rs, "FreeItemCode"));
        $Description = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
        $FreeQty = iconv("tis-620", "utf-8", odbc_result($rs, "FreeQty"));
        $UnitName = iconv("tis-620", "utf-8", odbc_result($rs, "UnitName"));
        $FreeUnitFactor = iconv("tis-620", "utf-8", odbc_result($rs, "FreeUnitFactor"));
        $GLAccount = iconv("tis-620", "utf-8", odbc_result($rs, "GLAccount"));

        $htmlShowData.= "<tr>";
        $htmlShowData.= "<td>$Step</td>";
        $htmlShowData.= "<td>$Seq</td>";
        $htmlShowData.= "<td>$FreeItemCode</td>";
        $htmlShowData.= "<td>$Description</td>";
        $htmlShowData.= "<td>$FreeQty</td>";
        $htmlShowData.= "<td>$UnitName</td>";
        $htmlShowData.= "<td>$GLAccount</td>";
        $htmlShowData.="
			<td>
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnFreeItemEdit\" id=\"idEdit-$FreeItemCode\">Edit </button>
                            <button type=\"button\" class=\"btn btn-danger btn-xs btnFreeItemDel\"  id=\"idDel-$FreeItemCode\">Delete </button>
			</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}
?>