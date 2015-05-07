<?php
 
$checkError = ini_get('error_reporting');
error_reporting($checkError ^ E_NOTICE);
//get parameter start
$paramGroupCode = $_POST['paramGroupCode'];
$paramItemCode = $_POST['paramItemCode'];
$paramMinimumOrder = $_POST['paramMinimum'];
$paramUnitCode = $_POST['paramUnitCode'];
$paramAction = $_POST['paramAction'];
$last_modified = date("Y-m-d H:i:s");

//get parameter end

$paramAction = $_POST['paramAction'];
include_once("../config.php");
//echo"$paramAction";
//add data
if ($paramAction == "add") {
    $itemNo = count($paramItemCode);
    $res = array();
    for ($i = 0; $i < $itemNo; $i++) {
        //echo checkAlreadyId($conn,"asdfasd");
        $sqlCheck = "SELECT * FROM PromGroupItem where GroupCode ='$paramGroupCode'and  ItemCode ='$paramItemCode[$i]'";
        if (checkAlreadyId($conn, $sqlCheck) == "Already-Id") {
            array_push($res, $paramItemCode[$i]);
        } else {
            $sql = "INSERT INTO PromGroupItem(GroupCode,ItemCode,MinimumOrder,UnitCode,last_modified) 
			VALUES('$paramGroupCode','$paramItemCode[$i]','$paramMinimumOrder','$paramUnitCode','$last_modified')";
            //echo $sql. '---';
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
if ($paramAction == "delete") {

    $sql = "DELETE FROM PromGroupItem WHERE GroupCode='$paramGroupCode' and ItemCode='$paramItemCode'";
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

    $sql = "SELECT * FROM PromGroupItem  where GroupCode='$paramGroupCode' and ItemCode ='$paramItemCode'";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    } else {
        while (odbc_fetch_row($rs)) {
            $ItemCode = odbc_result($rs, "ItemCode");
            $UnitCode = odbc_result($rs, "UnitCode");
            $MinimumOrder = odbc_result($rs, "MinimumOrder");
        }
        echo"[\"$ItemCode\",\"$UnitCode\",\"$MinimumOrder\"]";
    }
}
//update data 
if ($paramAction == "editAction") {

    $sql = "UPDATE PromGroupItem SET MinimumOrder='$paramMinimumOrder',UnitCode='$paramUnitCode',last_modified='$last_modified' WHERE GroupCode='$paramGroupCode' and ItemCode ='$paramItemCode'";
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

    $sql = "SELECT pgi.*,Item.ItemDesc,Unit.UnitName FROM PromGroupItem pgi
inner join Item on pgi.ItemCode=Item.ItemCode 
inner join Unit on pgi.UnitCode=Unit.UnitCode
where GroupCode='$paramGroupCode'
order by Item.ItemCode
";

    $htmlShowData = "";
    $rs = odbc_exec($conn, $sql);
    if (!$rs) {
        exit("Error in SQL");
    }
    $htmlShowData.= "<table id ='grid' class='table table-striped'>";
    $htmlShowData.= "<colgroup>";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "<col />";
    $htmlShowData.= "</colgroup>";

    $htmlShowData.= "<thead>";
    $htmlShowData.= "<tr>";
    $htmlShowData.= "<th data-field=\"field1\"><b>Item Code </b></th>";
    $htmlShowData.= "<th data-field=\"field2\"><b>Item Name </b></th>";
    $htmlShowData.= "<th data-field=\"field3\"><b>Minimum Order </b></th>";
    $htmlShowData.= "<th data-field=\"field4\"><b>Unit </b></th>";
    $htmlShowData.= "<th data-field=\"field5\"><b>Manage </b></th>";
    $htmlShowData.="</tr>";
    $htmlShowData.= "</thead>";

    $htmlShowData.= "<tbody>";
    while (odbc_fetch_row($rs)) {
        //$GroupCode=odbc_result($rs,"GroupCode");
        $ItemCode = iconv("tis-620", "utf-8", odbc_result($rs, "ItemCode"));
        $ItemDescSec = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
        if(!$ItemDescSec){
            $ItemDesc =  odbc_result($rs, "ItemDesc");
        } else{
            $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
        }
        $MinimumOrder = number_format(iconv("tis-620", "utf-8", odbc_result($rs, "MinimumOrder")));
        $UnitName = iconv("tis-620", "utf-8", odbc_result($rs, "UnitName"));

        $htmlShowData.= "<tr>";
        $htmlShowData.= "<td>$ItemCode</td>";
        $htmlShowData.= "<td>$ItemDesc</td>";
        $htmlShowData.= "<td>$MinimumOrder</td>";
        $htmlShowData.= "<td>$UnitName</td>";
        $htmlShowData.="
			<td>
                            <button type=\"button\" class=\"btn btn-primary btn-xs btnEdit\" id=\"idEdit-$ItemCode\">Edit </button>
                            <button type=\"button\" class=\"btn btn-danger btn-xs btnDel\"  id=\"idDel-$ItemCode\">Delete </button>
			</td>";
        $htmlShowData.="</tr>";
    }
    odbc_close($conn);
    $htmlShowData.= "</tbody>";
    $htmlShowData.= "</table>";

    echo $htmlShowData;
}
?>