<?php
$checkError = ini_get('error_reporting');
error_reporting($checkError  ^ E_NOTICE);
//get parameter start
/*
  ################       PromStep Start ###############
  paramPromType
  paramPromNo
  paramPromCode
  paramStep
  paramMinimumSKU
  paramBreakQty
  paramBreakUnitCode
  paramBreakUnitFactor
  paramBreakAmt
  paramDiscPer
  paramDiscBaht
  paramPromStepNote
  ################       PromStep End ###############
 */
$paramAction = $_POST['paramAction'];
$paramPromType = $_POST['paramPromType'];
$paramPromNo = $_POST['paramPromNo'];
$paramPromCode = $_POST['paramPromCode'];
$paramStep = $_POST['paramStep'];
$paramSeq = $_POST['paramSeq'];

$paramMinimumSKU = $_POST['paramMinimumSKU'];
$paramBreakQty = $_POST['paramBreakQty'];
$paramBreakUnitCode = $_POST['paramBreakUnitCode'];
$paramBreakUnitFactor = $_POST['paramBreakUnitFactor'];
$paramBreakAmt = $_POST['paramBreakAmt'];
$paramDiscPer = $_POST['paramDiscPer'];
$paramDiscBaht = $_POST['paramDiscBaht'];
$paramPromStepNote = $_POST['paramPromStepNote'];
//get parameter end


include_once("../config.php");
//echo"$paramAction";
$last_modified = date("Y-m-d H:i:s");

//#----- START: Add Date --------------------------------------------------- #//
if ($paramAction == "add") {
    /*
      echo "1". $paramAction ."<br>";
      echo "2".$paramPromType  ."<br>";
      echo "3".$paramPromNo  ."<br>";
      echo "4".$paramPromCode  ."<br>";
      echo "5".$paramStep ."<br>";
      echo "6".$paramMinimumSKU ."<br>";
      echo "7".$paramBreakQty ."<br>";
      echo "8".$paramBreakUnitCode ."<br>";
      echo "9".$paramBreakUnitFactor ."<br>";
      echo "10".$paramBreakAmt ."<br>";
      echo "11".$paramDiscPer ."<br>";
      echo "12".$paramDiscBaht ."<br>";
      echo "13".$paramPromStepNote ."<br>";
     */
    /*
      #### PromStep Start ###
      paramPromType
      paramPromNo
      paramPromCode
      paramStep
      paramMinimumSKU
      paramBreakQty
      paramBreakUnitCode
      paramBreakUnitFactor
      paramBreakAmt
      paramDiscPer
      paramDiscBaht
      paramPromStepNote
      ### PromStep End ###
     */

    $sqlCheck = "SELECT * FROM PromStep "
            . "where PromType ='$paramPromType' "
            . "and  PromNo ='$paramPromNo' "
            . "and  PromCode ='$paramPromCode' "
            . "and Step='$paramStep'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        $sql = "INSERT INTO PromStep"
                . "(PromType,PromNo,PromCode,Step,PromStepType,MinimumSKU,"
                . "BreakQty,BreakUnitCode,BreakUnitFactor,BreakAmt,DiscPer,"
                . "DiscBaht,PromStepNote,last_modified) "
                . "VALUES"
                . "('$paramPromType','$paramPromNo','$paramPromCode',"
                . "'$paramStep','$paramPromType','$paramMinimumSKU',"
                . "'$paramBreakQty','$paramBreakUnitCode','$paramBreakUnitFactor',"
                . "'$paramBreakAmt','$paramDiscPer','$paramDiscBaht',"
                . "'$paramPromStepNote','$last_modified')";
        $sqlConv = iconv("utf-8", "tis-620", $sql);
        $rs = odbc_exec($conn, $sqlConv);
        if (!$rs) {
            exit("Error in SQL Insert PromStep");
        } else {
            echo'["save-success"]';
        }
        odbc_close($conn);
    }
}
//#----- END: Add Date ----------------------------------------------------- #//


//#----- START: Delete Date ------------------------------------------------ #//
//check use Promotion?
if ($paramAction == "checkUseProm") {
    $sqlCheck = "SELECT * FROM OrderDetailGetPromotion  "
            . "where PromType ='$paramPromType' "
            . "and  PromNo ='$paramPromNo' "
            . "and PromCode = '$paramPromCode' "
            . "and Step='$paramStep'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        echo'["id-empty"]';
    }
}
if ($paramAction == "delete") {
    //Delete PromStepFreeItem ก่อนเพราะเป็นลูกของตาราง PromStep
    $subSql = "delete from PromStepFreeItem "
            . "where PromType = '$paramPromType' "
            . "and PromNo = '$paramPromNo' "
            . "and PromCode = '$paramPromCode' "
            . "and Step = '$paramStep'";
    $rsSub = odbc_exec($conn, $subSql);
    if(!$rsSub){
        exit("Error in SQL");
    }else{
       $sql = "DELETE FROM PromStep "
               . "WHERE PromType='$paramPromType' "
               . "and PromNo='$paramPromNo' "
               . "and PromCode='$paramPromCode' "
               . "and Step='$paramStep'";
        $rs = odbc_exec($conn, $sql);
        if (!$rs) {
            exit("Error in SQL");
        } else {
            echo'["success"]';
        } 
    }      
    odbc_close($conn);
}
//#----- END: Delete Date -------------------------------------------------- #//


//#----- START: Search Date fro edit --------------------------------------- #//
if ($paramAction == "edit") {
    
    $sql = "SELECT * FROM PromStep "
            . "where PromType='$paramPromType' "
            . "and PromNo='$paramPromNo' "
            . "and PromCode='$paramPromCode' "
            . "and Step='$paramStep'";
    $rs = odbc_exec($conn, $sql);
    
    if (!$rs) {
        exit("Error in SQL");
    } else {
        /*
          ################       PromStep Start ###############
          paramPromType
          paramPromNo
          paramPromCode

          paramStep
          paramMinimumSKU
          paramBreakQty
          paramBreakUnitCode
          paramBreakUnitFactor
          paramBreakAmt
          paramDiscPer
          paramDiscBaht
          paramPromStepNote
          ################       PromStep End ###############
         */
        while (odbc_fetch_row($rs)) {
            $Step = iconv("tis-620", "utf-8", odbc_result($rs, "Step"));
            $MinimumSKU = iconv("tis-620", "utf-8", odbc_result($rs, "MinimumSKU"));
            $BreakQty = iconv("tis-620", "utf-8", odbc_result($rs, "BreakQty"));
            $BreakUnitCode = iconv("tis-620", "utf-8", odbc_result($rs, "BreakUnitCode"));
            $BreakUnitFactor = iconv("tis-620", "utf-8", odbc_result($rs, "BreakUnitFactor"));
            $BreakAmt = iconv("tis-620", "utf-8", odbc_result($rs, "BreakAmt"));
            $DiscPer = iconv("tis-620", "utf-8", odbc_result($rs, "DiscPer"));
            $DiscBaht = iconv("tis-620", "utf-8", odbc_result($rs, "DiscBaht"));
            $PromStepNote = iconv("tis-620", "utf-8", odbc_result($rs, "PromStepNote"));
        }
        echo"[\"$Step\",\"$MinimumSKU\",\"$BreakQty\",\"$BreakUnitCode\",\"$BreakUnitFactor\",\"$BreakAmt\",\"$DiscPer\",\"$DiscBaht\",\"$PromStepNote\"]";
    }
}
//#----- END: Search Date fro edit ----------------------------------------- #//


//#----- START: Update Date ------------------------------------------------ #//
if ($paramAction == "editAction") {
    /*
      ### PromStep Start ###
      paramPromType
      paramPromNo
      paramPromCode

      paramStep
      paramMinimumSKU
      paramBreakQty
      paramBreakUnitCode
      paramBreakUnitFactor
      paramBreakAmt
      paramDiscPer
      paramDiscBaht
      paramPromStepNote
      ### PromStep End ###
     */
    $sql = "UPDATE PromStep "
            . "SET MinimumSKU='$paramMinimumSKU',"
            . "BreakQty='$paramBreakQty',"
            . "BreakUnitCode='$paramBreakUnitCode',"
            . "BreakUnitFactor='$paramBreakUnitFactor',"
            . "BreakAmt='$paramBreakAmt',"
            . "DiscPer='$paramDiscPer',"
            . "DiscBaht='$paramDiscBaht',"
            . "PromStepNote='$paramPromStepNote',"
            . "last_modified='$last_modified' "
            . "WHERE PromType='$paramPromType' "
            . "and PromNo='$paramPromNo' "
            . "and PromCode='$paramPromCode' "
            . "and Step='$paramStep'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        echo'["update-success"]';
    }
    odbc_close($conn);
}
//#----- END: Update Date -------------------------------------------------- #//


//#----- START: Show Date -------------------------------------------------- #//
if ($paramAction == "showData") {
    /*
      paramPromType
      paramPromNo
      paramPromCode
     */
    $sql = "SELECT PromStep.*,PromGroup.GroupDesc "
            . "FROM PromStep "
            . "left join PromGroup on PromStep.PromCode=PromGroup.GroupCode "
            . "where PromType='$paramPromType' "
            . "and PromNo='$paramPromNo' "
            . "and PromCode='$paramPromCode'"
            . "order by PromNo, PromCode, Step";

    $htmlShowData = "";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    /*
      Promotion No 	Item Code 	Description 	Step 	Break Qty 	Break Amt 	Disc Per 	Disc Bath 	Manage
     */
    $htmlShowData.= "<table id='grid1' class='table table-striped'>";
    $htmlShowData.= "<colgroup>";
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
    $htmlShowData.= "<th data-field=\"field1\"><b>Promotion No </b></th>";
    $htmlShowData.= "<th data-field=\"field2\"><b>Group Code </b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Description </b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>Step  </b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Break Qty   </b></th>";
    $htmlShowData.= "<th data-field=\"field6\"><b>Break Amt </b></th>";
    $htmlShowData.= "<th data-field=\"field7\"><b>Manage  </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    
    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
        $Description = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
        $MinimumSKU = iconv("tis-620", "utf-8", odbc_result($rs, "MinimumSKU"));
        $Step = iconv("tis-620", "utf-8", odbc_result($rs, "Step"));
        $BreakQty = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "BreakQty")));
        $BreakAmt = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "BreakAmt")), '2', '.', ',');
        $BreakUnitCode = iconv("tis-620", "utf-8", odbc_result($rs, "BreakUnitCode"));
        $BreakUnitFactor = iconv("tis-620", "utf-8", odbc_result($rs, "BreakUnitFactor"));
        $DiscPer = iconv("tis-620", "utf-8", odbc_result($rs, "DiscPer"));
        $DiscBaht = iconv("tis-620", "utf-8", odbc_result($rs, "DiscBaht"));

        $htmlShowData.= "<tr><td>$PromNo</td>";
        $htmlShowData.= "<td>$PromCode</td>";
        $htmlShowData.= "<td>$Description</td>";
        $htmlShowData.= "<td>$Step</td>";
        $htmlShowData.= "<td>$BreakQty</td>";
        $htmlShowData.= "<td>$BreakAmt</td>";
        $htmlShowData.="
                        <td>
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnEdit\" id=\"idEdit-$Step\">Edit </button>
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnAddFreeItem\" data-toggle=\"modal\" data-target=\".bs-example-modal-lg\" id=\"idAddFreeItem-$Step\">Add Free Item </button>
                            <button type=\"button\" class=\"btn btn-danger btn-xs btnDel\"  id=\"idDel-$Step\">Delete </button>
			</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}
//#----- END: Show Date ---------------------------------------------------- #//


//#----- START: Count Promotion Step --------------------------------------- #//
if ($paramAction == "countPromStep") {
    $sqlCountRows = "SELECT max(Step) as countRows
	FROM PromStep
	WHERE PromType='$paramPromType'
	And PromNo='$paramPromNo'
	and PromCode='$paramPromCode'";
    $rsCoountRows = odbc_exec($conn, $sqlCountRows);
    odbc_fetch_row($rsCoountRows);
    $countRows = odbc_result($rsCoountRows, "countRows");
    $countRows;
    echo'["' . $countRows . '"]';
}
//#----- END: Count Promotion Step ----------------------------------------- #//
?>