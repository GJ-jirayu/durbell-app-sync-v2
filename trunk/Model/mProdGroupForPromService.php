<?php

$checkError = ini_get('error_reporting');
error_reporting($checkError ^ E_NOTICE);

$paramGroupCode = trim($_POST['paramGroupCode']);
$paramGroupDesc = trim($_POST['paramGroupDesc']);
$paramSearchText = trim($_POST['paramSearchText']);
$last_modified = date("Y-m-d H:i:s");
$paramAction = trim($_POST['paramAction']);
include_once("../config.php");
//echo"$paramAction";
/*
  $tis620 = iconv("utf-8", "tis-620", $message );
  $utf8 = iconv("tis-620", "utf-8", $tis620 );
 */

if ($paramAction == "add") {

    //echo checkAlreadyId($conn,"asdfasd");
    $sqlCheck = "SELECT * FROM PromGroup where GroupCode ='$paramGroupCode'";
    if (checkAlreadyId($conn, $sqlCheck, $paramGroupCode) == "Already-Id") {
        echo'["id-already"]';
    } else {
        $sql = "INSERT INTO PromGroup(GroupCode,GroupDesc,last_modified) VALUES('$paramGroupCode','$paramGroupDesc','$last_modified')";
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

if ($paramAction == "delete") {

    $sqlCheck = "
		select  * from PromStep
		where PromType in('BFR','DCG','FRG','BDC')
		AND PromCode='$paramGroupCode'";
    if (checkAlreadyId($conn, $sqlCheck, $paramGroupCode) == "Already-Id") {
        echo'["id-already"]';
    } else {

        $sqlPromGroupItem = "DELETE FROM PromGroupItem WHERE GroupCode='$paramGroupCode'";
        $sqlPromGroupItemConv = iconv("utf-8", "tis-620", $sqlPromGroupItem);
        $rsPromGroupItem = odbc_exec($conn, $sqlPromGroupItemConv);

        if (!$rsPromGroupItem) {
            exit("Error in SQL");
        } else {
            $sqlPromGroup = "DELETE FROM PromGroup WHERE GroupCode='$paramGroupCode'";
            $sqlPromGroupConv = iconv("utf-8", "tis-620", $sqlPromGroup);
            $rsPromGroup = odbc_exec($conn, $sqlPromGroupConv);
            if (!$rsPromGroup) {
                exit("Error in SQL");
            } else {
                echo'["success"]';
            }
            odbc_close($conn);
        }
    }
}


if ($paramAction == "edit") {

    $sql = "SELECT * FROM PromGroup where GroupCode ='$paramGroupCode'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {

        if ($paramGroupCode == "All") {
            $GroupCode = "All";
            $GroupDesc = "";
        } else {
            while (odbc_fetch_row($rs)) {
                $GroupCode = iconv("tis-620", "utf-8", odbc_result($rs, "GroupCode"));
                $GroupDesc = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
            }
        }
        echo"[\"$GroupCode\",\"$GroupDesc\"]";
    }
}


if ($paramAction == "editAction") {

    $sql = "UPDATE PromGroup SET GroupDesc='$paramGroupDesc',last_modified='$last_modified' WHERE GroupCode='$paramGroupCode'";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        echo'["update-success"]';
    }
    odbc_close($conn);
}


if ($paramAction == "showData") {
    if ($paramSearchText != "") {

        //echo"paramSearchText=$paramSearchText";
        $sql = "SELECT * FROM PromGroup  where  GroupDesc like '%$paramSearchText%' order by GroupCode";
    } else {
        $sql = "SELECT * FROM PromGroup order by GroupCode";
    }

    $htmlShowData = "";
    $sqlConv = iconv("utf-8", "tis-620", $sql);
    $rs = odbc_exec($conn, $sqlConv);
    if (!$rs) {
        exit("Error in SQL");
    }
    $htmlShowData.= "<table id='gird' class='table table-striped' "; 
    $htmlShowData.= "<colgroup>";
    $htmlShowData.= "<col style='width: 200px' />";
    $htmlShowData.= "<col style='width: 367px'/>";
    $htmlShowData.= "<col style='width: 450px'/>";
    $htmlShowData.= "</colgroup>";

    $htmlShowData.= "<thead >";
    $htmlShowData.= "<tr>";
    $htmlShowData.= "<th data-field=\"field1\" ><b>Group Code </b></th>";
    $htmlShowData.= "<th data-field=\"field2\" ><b>Group Description </b></th>";
    $htmlShowData.= "<th data-field=\"field3\" ><b>Manage </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";
    
    $htmlShowData.= "<tbody>";

    //$rsConv=iconv("utf-8", "tis-620", $rs );
    while (odbc_fetch_row($rs)) {
        $GroupCode = iconv("tis-620", "utf-8", odbc_result($rs, "GroupCode"));
        $GroupDesc = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
        //$GroupCode=odbc_result($rs,"GroupCode");
        //$GroupDesc=odbc_result($rs,"GroupDesc");
        $htmlShowData.= "<tr> <td > $GroupCode </td>";
        $htmlShowData.= "<td > $GroupDesc </td>";
        $htmlShowData.="
			<td >
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnEdit\" id=\"idEdit-$GroupCode\">Edit </button>
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnAdd\" id=\"idAdd-$GroupCode\">Add Item</button>
                            <button type=\"button\" class=\"btn btn-danger btn-xs btnDel\"  id=\"idDel-$GroupCode\">Delete </button>
			</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}
?>