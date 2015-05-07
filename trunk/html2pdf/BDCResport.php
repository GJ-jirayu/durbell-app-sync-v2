<?php
$checkError = ini_get('error_reporting');
error_reporting($checkError  ^ E_NOTICE);

require_once("setPDF.php");

// เพิ่มหน้าใน PDF 
$pdf->AddPage();

// กำหนด HTML code หรือรับค่าจากตัวแปรที่ส่งมา
//	กรณีกำหนดโดยตรง
//	ตัวอย่าง กรณีรับจากตัวแปร
// $htmlcontent =$_POST['HTMLcode'];


include_once("../config.php");

$paramPromNo = $_GET['paramPromNo'];
$paramPromType = $_GET['paramPromType'];
//$paramPromNo = 'BFR01';
//$paramPromType = 'BFR';

$titleReport = "Setup Bundle Discount Promotion Report";

$htmlShowData = "";

//#----- START: Select Promotion Header -------------------------------------#//
$sql = "SELECT * FROM PromHeader WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";

$rs = odbc_exec($conn, $sql);
if (!$rs) {
    exit("Error in SQL");
} else {
    while (odbc_fetch_row($rs)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rs, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
        $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
        $StartDate = iconv("tis-620", "utf-8", odbc_result($rs, "StartDate"));
        $EndDate = iconv("tis-620", "utf-8", odbc_result($rs, "EndDate"));
    }
    odbc_close($conn);
}
//#----- END: Select Promotion Header ---------------------------------------#//


//#----- START: Select PromOfShopType ---------------------------------------#//
$sqlShopType = "SELECT post.*,st.ShopTypeName "
        . "FROM PromOfShopType post "
        . "left join ShopType st on post.ShopTypeCode=st.ShopTypeCode "
        . "WHERE PromNo='$paramPromNo' "
        . "and PromType='$paramPromType' ";

$shopType = "";
$rsShopType = odbc_exec($conn, $sqlShopType);
if (!$rsShopType) {
    exit("Error in SQL");
} else {
    $i = 0;
    while (odbc_fetch_row($rsShopType)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rsShopType, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rsShopType, "PromNo"));
        $ShopTypeCode = iconv("tis-620", "utf-8", odbc_result($rsShopType, "ShopTypeCode"));
        $ShopTypeName = iconv("tis-620", "utf-8", odbc_result($rsShopType, "ShopTypeName"));

        if ($i == 0) {
            if ($ShopTypeCode == "All") {
                $shopType = "All Shop Type";
            } else {
                $shopType.=$ShopTypeCode . "-" . $ShopTypeName;
            }
        } else {
            $shopType.="," . $ShopTypeCode . "-" . $ShopTypeName;
        }
        $i++;
    }
    odbc_close($conn);
}
//#----- END: Select PromOfShopType -----------------------------------------#//


//#----- START: Select PromOfSalesTeam --------------------------------------#//
$sqlSalesTeam = "SELECT * FROM PromOfSalesTeam "
        . "WHERE PromNo='$paramPromNo' "
        . "and PromType='$paramPromType' ";

$rsSalesTeam = odbc_exec($conn, $sqlSalesTeam);
$salesTeam = "";

if (!$rsSalesTeam) {
    exit("Error in SQL");
} else {
    $i = 0;
    while (odbc_fetch_row($rsSalesTeam)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rsSalesTeam, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rsSalesTeam, "PromNo"));
        $SalesTeam = iconv("tis-620", "utf-8", odbc_result($rsSalesTeam, "SalesTeam"));
        if ($i == 0) {
            if ($SalesTeam == "All") {
                $salesTeam = "All Sales Team";
            } else {
                $salesTeam.=$SalesTeam;
            }
        } else {
            $salesTeam.="," . $SalesTeam;
        }
        $i++;
    }
    odbc_close($conn);
}
//#----- END: Select PromOfSalesTeam ----------------------------------------#//


//#----- START: Select PromOfBranch -----------------------------------------#//
$sqlBranchCode = "SELECT pob.*,b.BranchName FROM PromOfBranch pob "
        . "left join Branch b on pob.BranchCode=b.BranchCode "
        . "WHERE PromNo='$paramPromNo' "
        . "and PromType='$paramPromType'";

$rsBranchCode = odbc_exec($conn, $sqlBranchCode);
$branch = "";

if (!$rsBranchCode) {
    exit("Error in SQL");
} else {
    $i = 0;
    while (odbc_fetch_row($rsBranchCode)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rsBranchCode, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rsBranchCode, "PromNo"));
        $BranchCode = iconv("tis-620", "utf-8", odbc_result($rsBranchCode, "BranchCode"));
        $BranchName = iconv("tis-620", "utf-8", odbc_result($rsBranchCode, "BranchName"));
        if ($i == 0) {
            if ($BranchCode == "All") {
                $branch = "All Branch";
            } else {
                $branch.=$BranchCode . "-" . $BranchName;
            }
        } else {
            $branch.="," . $BranchCode . "-" . $BranchName;
        }

        $i++;
    }
    odbc_close($conn);
}
//#----- END: Select PromOfBranch -----------------------------------------#//


//-------------------------------------------------------------------------------------------------------------------------------//

/* ########################### select promotion start ######################### */
$htmlData = '';

$sqlPromItem = "
    select 
        ps.PromType,
        ps.PromNo,
        ps.PromCode,
        prom.PromDesc,
        ph.BreakBy,
        ph.DiscFor,
        ph.LimitFreeQty,
        ph.FreeUnitCode,
        ph.LimitDiscBaht,
        ps.BreakAmt,
        ps.BreakQty,
        ps.BreakUnitCode,
        ph.DiscBaht,
        ph.DiscPer,
        ps.BreakUnitFactor,
        ps.Step,
        ps.PromStepNote,
        u.UnitName,
        uf.UnitName as FreeUnitName
    from PromStep ps 
    left join ( 
            select ItemCode as PromCode, ItemDesc as PromDesc 
            from Item 
            Union 
            select GroupCode as PromCode, GroupDesc as PromDesc 
            from PromGroup 
        )prom on prom.PromCode = ps.PromCode 
    left join PromHeader ph on ph.PromType = ps.PromType 
        and ph.PromNo = ps.PromNo 
    left join unit u on u.unitCode = ps.BreakUnitCode 
    left join unit uf on u.unitCode = ph.FreeUnitCode
    where ps.PromType='$paramPromType' 
    AND ps.PromNo='$paramPromNo'
    order by ps.Step 
";

$rsPromItem = odbc_exec($conn, $sqlPromItem);
if (!$rsPromItem) {
    exit("Error in SQL");
} else {
    $j = 0;
    while (odbc_fetch_row($rsPromItem)) {
        $PromType = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "PromType"));
        $PromNo = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "PromNo"));
        $PromCode = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "PromCode"));
        $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "PromDesc"));
        $BreakBy = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakBy"));
        $DiscFor = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "DiscFor"));
        $LimitFreeQty = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "LimitFreeQty"));
        //$FreeUnitCode = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "FreeUnitCode"));
        $FreeUnitCode = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "FreeUnitName"));
        $LimitDiscBaht = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "LimitDiscBaht"));
        /*
          (Q-Quanlity A-Amonut LQ-Loop Quanlity LA-Loop Amonut)
          (B-Baht P-Percent LB-Loop Baht LP-Loop Percent)
         */
        $BreakAmt = "";
        $BreakQty = "";
        $Break = "";
        $BreakUnitCode = "";
        
        
        if ($BreakBy == "A" or $BreakBy == "LA") {
            $BreakAmt = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakAmt"));
            $Break = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakAmt"));
            //$BreakUnitCode = "THB";
            $BreakUnitCode = "บาท";
        } else {
            $BreakQty = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakQty"));
            $Break = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakQty"));
            //$BreakUnitCode = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakUnitCode"));
            $BreakUnitCode = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "UnitName"));
        }

        if ($DiscFor == "B" or $DiscFor == "LB") {
            $Disc = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "DiscBaht"));
        } else {
            $Disc = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "DiscPer"));
        }

        $BreakUnitFactor = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "BreakUnitFactor"));
        $Step = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "Step"));
        $PromStepNote = iconv("tis-620", "utf-8", odbc_result($rsPromItem, "PromStepNote"));


        $htmlData.='<tr >';
        
        $htmlData.='<td width="60" style="text-align:left;padding-left: 5px;">';
        $htmlData.=$PromCode . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="130" style="text-align:left;padding-left: 5px;">';
        $htmlData.=$ItemDesc . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="30" style="text-align:right;" >';
        $htmlData.= $Step . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="70" style="text-align:right;padding-right: 5px;" >';
        $htmlData.=$Break . ' ' . $BreakUnitCode . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="35" style="text-align:left;" >';
        $htmlData.= $BreakBy . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="50" style="text-align:right;" >';
        $htmlData.= $Disc . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="25" style="text-align:left;" >';
        $htmlData.= $DiscFor . '';
        $htmlData.='</td>';
        
        $htmlData.='<td width="45" style="text-align:right;padding-right: 5px;" > ';
        $htmlData.=$LimitFreeQty . ' ' . $FreeUnitCode;
        $htmlData.='</td>';
        
        $htmlData.='<td width="50" style="text-align:right;" >';
        $htmlData.= $LimitDiscBaht . '';
        $htmlData.='</td>';

$sqlStepFreeItem = "
    select 
        fi.Seq,  
        fi.FreeItemCode,
        i.ItemDesc,
        fi.FreeQty,
        u.UnitName
    from PromBundleFreeItem fi
    left join item i on i.itemCode = fi.FreeItemCode
    left join unit u on u.UnitCode = fi.FreeUnitCode
    where fi.PromNo = '$paramPromNo'
    and fi.PromType = '$paramPromType'
    and fi.Step = '$Step'
    order by fi.Seq
";

        $rsStepFreeItem = odbc_exec($conn, $sqlStepFreeItem);

        $num = odbc_num_rows($rsStepFreeItem); 
        if ($num>0) {
            
        } else {            
            $htmlData.='<td  width="65" style="text-align:center;" > ';
            $htmlData.='- </td>';
            
            $htmlData.='<td  width="160" style="text-align:center;" >';
            $htmlData.='- </td>';
            
            $htmlData.='<td  width="35" style="text-align:center;" >';
            $htmlData.='- </td> ';
            
            $htmlData.='</tr>';
        }

        if (!$rsStepFreeItem) {
            exit("Error in SQL");
        } else {
            $i = 1;
            while (odbc_fetch_row($rsStepFreeItem)) {
                $Seq = iconv("tis-620", "utf-8", odbc_result($rsStepFreeItem, "Seq"));
                $FreeItemCode = iconv("tis-620", "utf-8", odbc_result($rsStepFreeItem, "FreeItemCode"));
                $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rsStepFreeItem, "ItemDesc"));
                $FreeQty = iconv("tis-620", "utf-8", odbc_result($rsStepFreeItem, "FreeQty"));
                $UnitName = iconv("tis-620", "utf-8", odbc_result($rsStepFreeItem, "UnitName"));

                if ($i == 1) {
                    
                    $htmlData.='<td width="65" style="text-align:left;padding-left: 5px;" > ';
                    $htmlData.=$FreeItemCode . '';
                    $htmlData.='</td>';
                    
                    $htmlData.='<td width="160" style="text-align:left;padding-left: 5px;" >';
                    $htmlData.=$ItemDesc . '';
                    $htmlData.='</td>';
                    
                    $htmlData.='<td width="35" style="text-align:right;padding-right: 5px;" >';
                    $htmlData.=$FreeQty . ' ' . $UnitName . '';
                    $htmlData.='</td> ';
                    
                    $htmlData.='</tr>';
                } else {
                    $htmlData.='<tr  style="text-align:left;">';
                    
                    $htmlData.='<td width="60">' . '' . '</td>';
                    $htmlData.='<td width="130">' . '' . '</td>';
                    $htmlData.='<td width="30">' . '' . '</td>';
                    $htmlData.='<td width="70">' . '' . '</td>';
                    $htmlData.='<td width="35">' . '' . '</td>';
                    $htmlData.='<td width="50">' . '' . '</td>';
                    $htmlData.='<td width="35">' . '' . '</td>';
                    $htmlData.='<td width="30">' . '' . '</td>';
                    $htmlData.='<td width="50">' . '' . '</td>';
                    
                    //-------------------------------------------------------//
                    
                    $htmlData.='<td width="65" style="text-align:left;padding-left: 5px;"> ';
                    $htmlData.=$FreeItemCode . ' ';
                    $htmlData.='</td>';
                    
                    $htmlData.='<td width="160" style="text-align:left;padding-left: 5px;">';
                    $htmlData.=$ItemDesc . ' ';
                    $htmlData.='</td>';
                    
                    $htmlData.='<td width="35" style="text-align:right;padding-right: 5px;">';
                    $htmlData.=$FreeQty . ' ' . $UnitName . '';
                    $htmlData.='</td> ';
                    
                    $htmlData.='</tr>';
                }
                $i++;
            }//while
        }
        //$htmlData.='</tbody>';
        //$htmlData.='</table>';
    }//loop while
    odbc_close($conn);
}//if reslult 
//echo $htmlData;
/* ########################### select promotion end ######################### */



$htmlcontent = '
<p>
<div class="title" style="text-align:center"><h3>' . $titleReport . '</h3></center>
<div class="date" style="text-align:center">Date :' . date("Y/m/d H:i:s") . '</div>

<table border="0">

    <tr>
        <td colspan="6">&nbsp;</td>
    </tr>
    
    <tr>
        <td width="80">
            <div style="text-align:left;"> <b> Promotion No: </b> </div>
        </td>
	<td width="80">
            <div style="text-align:left;">' . $PromNo . '</div>
	</td>		
        <td  width="115">
            <div style="text-align:left;"> <b> Promotion Description: </b> </div>
        </td>
        <td colspan="3">
            <div style="text-align:left;">
                ' . $PromDesc . '&nbsp;&nbsp;&nbsp;&nbsp;
                <B>Start Date:</B> ' . $StartDate . '   &nbsp;&nbsp;&nbsp;&nbsp; 
                <B>End Date:</B> ' . $EndDate . '
            </div>
	</td>
    </tr>

    <tr>
        <td width="80">
            <div style="text-align:left;"> <b> Branch: </b> </div>
        </td>
	<td colspan="5" > 
            <div style="text-align:left;">' . $branch . '</div>
	</td>
    </tr>
	
    <tr>
	<td width="80">
            <div style="text-align:left;"> <b> Sales Team: </b> </div>
        </td>
	<td colspan="5" >
            <div style="text-align:left;">' . $salesTeam . '</div>
	</td>
    </tr>
    
    <tr>
        <td width="80">
            <div style="text-align:left;"> <b> Shop Type: </b> </div>
        </td>
	<td colspan="5" >
            <div style="text-align:left;">' . $shopType . '</div>
        </td>
    </tr>
    <tr>
        <td> </td>
        <td> </td>
    </tr>
</table>

<table border="1" style="border:1px solid gray" >
    <thead >
	<tr style="text-align:center; font-weight:bold; border:0.5px #cccccc solid; vertical-align: middle" >
            <th width="60"> Group Code </th>
            <th width="130"> Description </th>
            <th width="30"> Step </th>
            <th width="70"> Break </th>
            <!-- <th width="45"> Break Uint </th> -->
            <th width="35"> Break By </th> 
            <th width="50"> Discount </th>
            <th width="25"> Disc For </th>            
            <th width="45"> Limit Free Qty</th>
            <th width="50"> Limit Disc Baht  </th>
            
            <!-- <th width="30"> Seq </th> -->
            <th width="65"> Free Item Code </th>
            <th width="160"> Description </th>
            <th width="35"> Free Qty </th> 
            <!-- <th width="40"> Unit </th> -->
 	</tr>
    </thead>
    
    <tbody > 
       ' . $htmlData . '
    </tbody>
</table>

</p>';
//echo $htmlcontent;

$htmlcontent = stripslashes($htmlcontent);
$htmlcontent = AdjustHTML($htmlcontent);

// สร้างเนื้อหาจาก  HTML code
$pdf->writeHTML($htmlcontent, true, 0, true, 0);

// เลื่อน pointer ไปหน้าสุดท้าย
$pdf->lastPage();

// ปิดและสร้างเอกสาร PDF
$pdf->Output('BDCReport.pdf', 'I');
?>