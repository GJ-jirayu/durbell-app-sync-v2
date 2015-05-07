<?php

$checkError = ini_get('error_reporting');
error_reporting($checkError ^ E_NOTICE);
//get parameter start


$paramAction = trim($_POST['paramAction']);
$paramPromNo = trim($_POST['paramPromNo']);
$paramPromDesc = trim($_POST['paramPromDesc']);
$paramStartDate = trim($_POST['paramStartDate']);
$paramEndDate = trim($_POST['paramEndDate']);
//$paramAlway = $_POST['paramAlway'];
$paramBranchCode = trim($_POST['paramBranchCode']);
$paramSalesTeam = trim($_POST['paramSalesTeam']);
$paramShopType = trim($_POST['paramShopType']);
$paramPromType = trim($_POST['paramPromType']);
$paramOldPromNo = trim($_POST['paramOldPromNo']);
$paramPromNoSearch = trim($_POST['paramPromNoSearch']);


$paramAlway = 1;
$paramBundleFlag = 1;
$paramPriority = $_POST['paramPriority'];



//get parameter end


include_once("../config.php");
$last_modified = date("Y-m-d H:i:s");

//echo"$paramAction";
//copyTablePromGroup function
function copyTablePromItemPromStepPromStepFreeItem($conn, $paramPromNo, $paramPromType, $paramOldPromNo, $succss, $last_modified) {
    /*
      echo "paramPromNo=".$paramPromNo."<br>";
      echo "paramPromType=".$paramPromType."<br>";
      echo "paramOldPromNo=".$paramOldPromNo."<br>";
      echo" hello copyTablePromItem";
     */

    /*
      INSERT INTO PromItem
      (PromType,PromNo,PromCode,
      BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht)

      SELECT PromType,'p112233',PromCode,
      BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht
      FROM PromItem
      where PromNo='A11223344';


     */
    $sql = "INSERT INTO PromItem
(PromType,PromNo,PromCode,
BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht,last_modified)

SELECT PromType,'$paramPromNo',PromCode,
BreakBy,DiscFor,LimitFreeQty,FreeUnitCode,LimitDiscBaht,'$last_modified'
FROM PromItem
where PromNo='$paramOldPromNo'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {


        $sqlPromStep = "INSERT INTO PromStep
			(PromType,PromNo,PromCode,Step,PromStepType,MinimumSKU,BreakQty,
			BreakUnitCode,BreakUnitFactor,BreakAmt,DiscPer,DiscBaht,PromStepNote,last_modified)

			SELECT PromType,'$paramPromNo',PromCode,Step,PromStepType,MinimumSKU,BreakQty,
			BreakUnitCode,BreakUnitFactor,BreakAmt,DiscPer,DiscBaht,PromStepNote,'$last_modified'
			from PromStep
			where PromNo='$paramOldPromNo'";
        $sqlPromStepConv = iconv("utf-8", "tis-620", $sqlPromStep);
        $rsPromStep = odbc_exec($conn, $sqlPromStepConv);
        if (!$rsPromStep) {
            exit("Error in SQL");
        } else {


            $sqlPromStepFreeItem = "INSERT INTO PromStepFreeItem
				(PromType,PromNo,PromCode,Step,Seq,FreeItemCode,FreeQty,FreeUnitCode,FreeUnitFactor,GLAccount,last_modified)
				select PromType,'$paramPromNo',PromCode,Step,Seq,FreeItemCode,FreeQty,FreeUnitCode,FreeUnitFactor,GLAccount,'$last_modified'
				from PromStepFreeItem
				where PromNo='$paramOldPromNo'";
            $sqlPromStepFreeItemConv = iconv("utf-8", "tis-620", $sqlPromStepFreeItem);
            $rsPromStepFreeItem = odbc_exec($conn, $sqlPromStepFreeItemConv);
            if (!$rsPromStepFreeItem) {
                exit("Error in SQL");
            } else {
                echo"[\"" . $succss . "\"]";
                //echo "insert success";
            }
        }
    }
}

//delete data
if ($paramAction == "checkUseProm") {
    $sqlCheck = "SELECT * FROM OrderDetailGetPromotion  where PromType ='$paramPromType'and  PromNo ='$paramPromNo'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {
        echo'["id-empty"]';
    }
}
if ($paramAction == "delete") {

    deleteForiegnTable($conn, $paramPromNo, $success = "Return", $paramPromType);
}

//delete Foriegn Table start
function deleteForiegnTable($conn, $paramPromNo, $success, $paramPromType) {

    //del branch start

    $sqlBranch = "DELETE FROM PromOfBranch WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
    $rsBranch = odbc_exec($conn, $sqlBranch);
    if ($rsBranch) {
        //del salesTeam start
        $sqlSalesTeam = "DELETE FROM PromOfSalesTeam WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
        $rsSalesTeam = odbc_exec($conn, $sqlSalesTeam);
        //del salesTeam end
        if ($rsSalesTeam) {
            //del shop type start
            $sqlShopType = "DELETE FROM PromOfShopType WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
            $rsShopType = odbc_exec($conn, $sqlShopType);

            if ($rsShopType) {
                if ($success == "No-Return") {
                    
                } else {
                    deleteTablePromItemPromStepPromStepFreeItem($conn, $paramPromNo, $paramPromType);
                    //echo'["del-success"]';
                }
            }

            //del shop type end
        }
    }
//echo"test2".$paramAction;
}

//delete table for reference
function deleteTablePromItemPromStepPromStepFreeItem($conn, $paramPromNo, $paramPromType) {
    //delete PromItem
    $sqlPromItem = "DELETE FROM PromItem WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
    $rsPromItem = odbc_exec($conn, $sqlPromItem);
    if ($rsPromItem) {

        //delete PromStepFreeItem start
        $sqlPromStepFreeItem = "DELETE FROM PromStepFreeItem WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
        $rsPromStepFreeItem = odbc_exec($conn, $sqlPromStepFreeItem);

        if ($rsPromStepFreeItem) {
            //delete PromStep
            $sqlPromStep = "DELETE FROM PromStep WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
            $rsPromStep = odbc_exec($conn, $sqlPromStep);

            if ($rsPromStep) {
                //echo "ok delete is success=$paramPromNo";
                deleteMainPromHeader($conn, $paramPromNo, $paramPromType);
            }
        }
    }
}

//deleteMainPromHeader start
function deleteMainPromHeader($conn, $paramPromNo, $paramPromType) {
    $sqlPromHeader = "DELETE FROM PromHeader WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
    $rsPromHeader = odbc_exec($conn, $sqlPromHeader);
    if ($rsPromHeader) {
        echo'["del-success"]';
    }
}

//deleteMainPromHeader end



//update Foriegn Table start
function insertForiegnTable($conn, $paramPromNo, $paramBranchCode, $paramSalesTeam, $paramShopType, $succss, $paramPromType, $paramOldPromNo, $last_modified) {

//echo'["save-success"]';
    $paramBranchCodeArray = explode(',', $paramBranchCode);
// echo(count($paramBranchCodeArray));
//loop insert into branch for promotion start 
    for ($i = 0; $i < count($paramBranchCodeArray); $i++) {
//echo $paramBranchCodeArray[$i];
        $sqlBranch = "INSERT INTO PromOfBranch(PromType,PromNo,BranchCode,last_modified)VALUES('$paramPromType','$paramPromNo','$paramBranchCodeArray[$i]','$last_modified')";
        $sqlBranchConv = iconv("utf-8", "tis-620", $sqlBranch);
        $rsBranch = odbc_exec($conn, $sqlBranchConv);
    }
//loop insert into branch for promotion end 
    if (!$rsBranch) {
        echo'["save-insert-branch-error"]';
    } else {

        //echo'["save-success"]';
        $paramSalesTeamArray = explode(',', $paramSalesTeam);
        //loop insert into PromOfSalesTeam for promotion start 
        for ($i = 0; $i < count($paramSalesTeamArray); $i++) {
            //echo $paramBranchCodeArray[$i];
            $sqlSalesTeam = "INSERT INTO PromOfSalesTeam(PromType,PromNo,SalesTeam,last_modified)VALUES('$paramPromType','$paramPromNo','$paramSalesTeamArray[$i]','$last_modified')";
            $sqlSalesTeamConv = iconv("utf-8", "tis-620", $sqlSalesTeam);
            $rsSalesTeam = odbc_exec($conn, $sqlSalesTeamConv);
        }
        //loop insert into PromOfSalesTeam for promotion end 

        if (!$rsSalesTeam) {
            echo'["save-insert-branch-error"]';
        } else {

            //loop insert into PromOfShopType for promotion start 
            $paramShopTypeArray = explode(',', $paramShopType);
            for ($i = 0; $i < count($paramShopTypeArray); $i++) {
                $sqlShopType = "INSERT INTO PromOfShopType(PromType,PromNo,ShopTypeCode,last_modified)VALUES('$paramPromType','$paramPromNo','$paramShopTypeArray[$i]','$last_modified')";
                $sqlShopTypeConv = iconv("utf-8", "tis-620", $sqlShopType);
                $rsShopType = odbc_exec($conn, $sqlShopTypeConv);
            }
            //loop insert into PromOfShopType for promotion end 

            if (!$rsShopType) {
                echo'["save-insert-shop-type-error"]';
            } else {


                //insert table referance related start
                //echo"[\"".$succss."\"]";
                if ($succss == "update-success") {
                    echo"[\"" . $succss . "\"]";
                } else {
                    copyTablePromItemPromStepPromStepFreeItem($conn, $paramPromNo, $paramPromType, $paramOldPromNo, $succss, $last_modified);
                }

                //insert table referance related end
            } //check is corrected rsShopType start
        }//check is corrected rsSalesTeam start
    }//check is corrected rsBranch start
//echo"test2".$paramAction;
}

//update ForiegnTable end
//add data
if ($paramAction == "add") {
//echo"$paramBranchCode";
    /*

      PromType
      PromNo
      PromDesc
      StartDate
      EndDate
      Alway
      Priority

     */
    $sqlCheck = "SELECT * FROM PromHeader where PromType ='$paramPromType'and  PromNo ='$paramPromNo'";
    if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
        echo'["id-already"]';
    } else {

        $sql = "INSERT INTO PromHeader(PromType,PromNo,PromDesc,StartDate,EndDate,Priority,last_modified) 
		VALUES('$paramPromType','$paramPromNo','$paramPromDesc','$paramStartDate','$paramEndDate','$paramPriority','$last_modified')";
        $sqlConv = iconv("utf-8", "tis-620", $sql);
        $rs = odbc_exec($conn, $sqlConv);
        if (!$rs) {
            exit("Error in SQL");
        } else {
            insertForiegnTable($conn, $paramPromNo, $paramBranchCode, $paramSalesTeam, $paramShopType, $success = "save-success", $paramPromType, $paramOldPromNo, $last_modified);
        }//check is corrected rs start 
        odbc_close($conn);
    }
}


//select data for edit
if ($paramAction == "edit") {

    $sql = "SELECT * FROM PromHeader where PromNo ='$paramPromNo' and PromType='$paramPromType'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        while (odbc_fetch_row($rs)) {
            $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
            $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
            $StartDate = iconv("tis-620", "utf-8", odbc_result($rs, "StartDate"));
            $EndDate = iconv("tis-620", "utf-8", odbc_result($rs, "EndDate"));
//            $Alway=iconv("tis-620", "utf-8",odbc_result($rs,"Alway"));
            $Priority = iconv("tis-620", "utf-8", odbc_result($rs, "Priority"));
            $Alway = null;
        }
        //select branch is selected for sent edit start
        $sqlBranch = "SELECT * FROM PromOfBranch where PromNo ='$paramPromNo' and PromType='$paramPromType'";
        $rsBranch = odbc_exec($conn, $sqlBranch);

        $BranchCode = "";
        $ShopTypeCode = "";
        $SalesTeam = "";

        if ($rsBranch) {
            $i = 0;
            while (odbc_fetch_row($rsBranch)) {
                if ($i == 0) {
                    $BranchCode.="\"" . odbc_result($rsBranch, "BranchCode") . "\"";
                } else {
                    $BranchCode.=",\"" . odbc_result($rsBranch, "BranchCode") . "\"";
                }
                $i++;
            }
        }
        //select branch is selected for sent edit end
        //select shop type is selected for sent edit start
        $sqlShopType = "SELECT * FROM PromOfShopType where PromNo ='$paramPromNo' and PromType='$paramPromType'";
        $rsShopType = odbc_exec($conn, $sqlShopType);
        if ($rsShopType) {
            $j = 0;
            while (odbc_fetch_row($rsShopType)) {
                if ($j == 0) {
                    $ShopTypeCode.="\"" . odbc_result($rsShopType, "ShopTypeCode") . "\"";
                } else {
                    $ShopTypeCode.=",\"" . odbc_result($rsShopType, "ShopTypeCode") . "\"";
                }
                $j++;
            }

            //select  shop type is selected for sent edit end
        }
        //select sales team is selected for sent edit start
        $sqlSalesTeam = "SELECT * FROM PromOfSalesTeam where PromNo ='$paramPromNo' and PromType='$paramPromType'";
        $rsSalesTeam = odbc_exec($conn, $sqlSalesTeam);
        if ($rsSalesTeam) {
            $k = 0;
            while (odbc_fetch_row($rsSalesTeam)) {
                if ($k == 0) {
                    $SalesTeam.="\"" . odbc_result($rsSalesTeam, "SalesTeam") . "\"";
                } else {
                    $SalesTeam.=",\"" . odbc_result($rsSalesTeam, "SalesTeam") . "\"";
                }
                $k++;
            }
            //select  sales team is selected for sent edit end
        }

        echo"[\"$PromNo\",\"$PromDesc\",\"$StartDate\",\"$EndDate\",\"$Alway\",\"$Priority\",[$BranchCode],[$ShopTypeCode],[$SalesTeam]]";
    }
    odbc_close($conn);
}
//update data 
if ($paramAction == "editAction") {
    /*
      field in table
      PromType
      PromNo
      PromDesc
      StartDate
      EndDate
      Alway
      Priority

     */
    /* parameter start */
    /*
      $paramAction
      $paramPromNo
      $paramPromDesc
      $paramStartDate
      $paramEndDate
      $paramAlway

      $paramBranchCode
      $paramSalesTeam
      $paramShopType
     */
    /* parameter end */

    $sql = "UPDATE PromHeader SET PromDesc='$paramPromDesc',StartDate='$paramStartDate',EndDate='$paramEndDate',Priority='$paramPriority',last_modified='$last_modified' WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        //delete  foriegn table 
        deleteForiegnTable($conn, $paramPromNo, $success = "No-Return", $paramPromType);
        //insert  foriegn table 
        insertForiegnTable($conn, $paramPromNo, $paramBranchCode, $paramSalesTeam, $paramShopType, $success = "update-success", $paramPromType, $paramOldPromNo, $last_modified);

        //echo'["update-success"]';
        //before update u cloude delete foriegn key for new insert.
    }
    odbc_close($conn);
}
//show data
if ($paramAction == "showData") {

    if ($paramPromDesc != "" or ( $paramStartDate != "" and $paramEndDate != "")) {
        $sql = "SELECT * FROM PromHeader where (PromType='$paramPromType' and PromDesc like '%$paramPromDesc%') or (StartDate >= '$paramStartDate' and EndDate<='$paramEndDate' and  PromType='$paramPromType')";
    } else {
        $sql = "SELECT * FROM PromHeader where PromType='$paramPromType'";
    }

    $paramPromDesc = $_POST['paramPromDesc'];
    $paramStartDate = $_POST['paramStartDate'];
    $paramEndDate = $_POST['paramEndDate'];

    $htmlShowData = "";
    $sqlSConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlSConv);

    if (!$rs) {
        exit("Error in SQL");
    }

    $htmlShowData.= "<table id='grid' class='table table-striped'>";
    $htmlShowData.= "<colgroup>";
    $htmlShowData.= "<col style=\"width:15%\" />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col style=\"width:15%\" />";
    $htmlShowData.= "<col style=\"width:15%\" />";
    $htmlShowData.= "<col style=\"width:25%\" />";
    $htmlShowData.= "</colgroup>";

    $htmlShowData.= "<thead>";
    $htmlShowData.= "<tr>";
//    $htmlShowData.= "<th data-field=\"field1\"><b>Prom Type</b></th>";
    $htmlShowData.= "<th data-field=\"field1\"><b>Promotion No</b></th>";
    $htmlShowData.= "<th data-field=\"field2\"><b>Promotion Description </b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Start Date</b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>End Date </b></th>";
//    $htmlShowData.= "<th data-field=\"field6\"><b>Away </b></th>";
//    $htmlShowData.= "<th data-field=\"field7\"><b>Priority </b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Manage </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rs, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
        $StartDate = iconv("tis-620", "utf-8", odbc_result($rs, "StartDate"));
        $EndDate = iconv("tis-620", "utf-8", odbc_result($rs, "EndDate"));

        //  $Priority=odbc_result($rs,"Priority");

        $htmlShowData.= "<tr>";
//        $htmlShowData.= "<td>$PromType</td>";
        $htmlShowData.= "<td>$PromNo</td>";
        $htmlShowData.= "<td>$PromDesc</td>";
        $htmlShowData.= "<td>$StartDate</td>";
        $htmlShowData.= "<td>$EndDate</td>";
        // $htmlShowData.= "<td>$Alway</td>";
        //  $htmlShowData.= "<td>$Priority</td>";

        $htmlShowData.="
							<td>
						
								<button type=\"button\" class=\"btn btn-primary btn-xs btnEdit\" id=\"idEdit-$PromNo\">Edit </button>
								
								<button type=\"button\" class=\"btn btn-primary btn-xs btnPrint\" id=\"idPrint-$PromNo\" target=\"_blank\">Print </button>
								<button type=\"button\" class=\"btn btn-primary btn-xs btnAddItem\" id=\"idAdd-$PromNo\">Add Item </button>
								<button type=\"button\" class=\"btn btn-primary btn-xs btnCopy\"  id=\"idCopy-$PromNo\" data-toggle=\"modal\" data-target=\".bs-copy-modal-lg\">Copy </button>
								<button type=\"button\" class=\"btn btn-danger btn-xs btnDel\" id=\"idDel-$PromNo\">Delete </button>
								
							</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}

if ($paramAction == "searchPromDesc") {
    $sql = "SELECT * FROM PromHeader where PromType='$paramPromType' and  PromDesc like '%$paramPromDesc%'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        $i = 0;
        $jsonData = "";
        $jsonData.="[";
        while (odbc_fetch_row($rs)) {

            $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
            $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));

            if ($i == 0) {
                $jsonData.="[";
                $jsonData.="\"" . $PromNo . "\"";
                $jsonData.=",\"" . $PromDesc . "\"";
                $jsonData.="]";
            } else {
                $jsonData.=",[";
                $jsonData.="\"" . $PromNo . "\"";
                $jsonData.=",\"" . $PromDesc . "\"";
                $jsonData.="]";
            }

            $i++;
        }

        $jsonData.="]";
        odbc_close($conn);


        echo $jsonData;
        //echo"[\"$GroupCode\",\"$GroupDesc\"]";
    }
}
//show detail promotion start
if ($paramAction == "getPromotion") {

    //select sales team is selected for sent edit start
    $sql = "SELECT * FROM PromHeader where PromNo ='$paramPromNo'";
    $rs = odbc_exec($conn, $sql);
    if ($rs) {
        while (odbc_fetch_row($rs)) {

            $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
            $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
            $StartDate = iconv("tis-620", "utf-8", odbc_result($rs, "StartDate"));
            $EndDate = iconv("tis-620", "utf-8", odbc_result($rs, "EndDate"));
            //$Alway=iconv("tis-620", "utf-8",odbc_result($rs,"Alway"));
            $Priority = iconv("tis-620", "utf-8", odbc_result($rs, "Priority"));
        }
        //select  sales team is selected for sent edit end
        echo"[\"$PromNo\",\"$PromDesc\",\"$StartDate\",\"$EndDate\",\"$Priority\"]";
    }

    odbc_close($conn);
}
//show detail promotion end
//search data for discount by Group start.
if ($paramAction == "searchPromNo") {
    $sql = "SELECT * FROM PromHeader where PromType='$paramPromType'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        $i = 0;
        $jsonData = "";
        $jsonData.="[";
        while (odbc_fetch_row($rs)) {

            $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
            $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));

            if ($i == 0) {
                $jsonData.="[";
                $jsonData.="\"" . $PromNo . "\"";
                $jsonData.=",\"" . $PromDesc . "\"";
                $jsonData.="]";
            } else {
                $jsonData.=",[";
                $jsonData.="\"" . $PromNo . "\"";
                $jsonData.=",\"" . $PromDesc . "\"";
                $jsonData.="]";
            }

            $i++;
        }

        $jsonData.="]";
        odbc_close($conn);


        echo $jsonData;
        //echo"[\"$GroupCode\",\"$GroupDesc\"]";
    }
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
//search data for discount by Group end.
?>