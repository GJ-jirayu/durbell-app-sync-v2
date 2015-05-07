<?php
$paramPromNo = $_POST['paramPromNo'];
$paramPromType = $_POST['paramPromType'];
$paramPromCode = $_POST['paramPromCode'];
include_once("../config.php");
/*
  PromType
  PromNo
  PromCode
  BreakBy
  DiscFor
  LimitFreeQty
  FreeUnitCode
  LimitDiscBaht
 */
$sql = "SELECT pi.*,ph.PromDesc as PromDesc ,Item.ItemDesc
FROM PromItem pi 
inner join PromHeader ph on pi.PromNo=ph.PromNo
inner join Item on pi.PromCode=Item.ItemCode
WHERE pi.PromNo='$paramPromNo' and pi.PromType='$paramPromType' and pi.PromCode='$paramPromCode'";


$sqlCountRows = "SELECT max(Step) as countRows
FROM PromStep
WHERE PromType='$paramPromType'
And PromNo='$paramPromNo'
and PromCode='$paramPromCode'";

$rs = odbc_exec($conn, $sql);
$rsCoountRows = odbc_exec($conn, $sqlCountRows);
odbc_fetch_row($rsCoountRows);
$countRows = odbc_result($rsCoountRows, "countRows");

if (!$rs) {
    exit("Error in SQL");
}
while (odbc_fetch_row($rs)) {
    $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
    $PromCode = iconv("tis-620", "utf-8", odbc_result($rs, "PromCode"));
    $BreakBy = iconv("tis-620", "utf-8", odbc_result($rs, "BreakBy"));
    $DiscFor = iconv("tis-620", "utf-8", odbc_result($rs, "DiscFor"));
    $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
    $ItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
}
odbc_close($conn);
?>



<div class="alert alert-warning" role="alert" >
    <h4>Setup Free Promotion By Item </h4>
</div>

<form id="addStepDiscountProm" name="addStepDiscountProm">
    <div class="row">

        <div class="col-md-12">
            <div class="well">
                <div class="alert alert-warning" role="alert">
                    <Strong> Promotion Step</Strong>
                </div>
                <table>
                    <tr>
                        <td> Promotion No</td>
                        <td colspan="4">
                            <b id="PromNo"><?= $PromNo ?>&nbsp; <?= $PromDesc ?></b>
                            <!--
                            <input text="text" name="promotionNo"  value="D1520501"/>
                            &nbsp;
                            <input text="text" name="promotionName" value="F4 Kavamucho Start Promo"/>
                            -->
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Item Code
                        </td>
                        <td  colspan="4">
                            <b id="PromCode"><?= $PromCode ?>&nbsp; <?= $ItemDesc ?></b>
                            <!--
                                    <input type="text" name="itemCode" value="11130801">
                                    &nbsp;
                                    <input type="text" name="itemName" value="ค่ารามูโจ้18gฮ็อดชิลลี">
                            -->
                        </td>
                    </tr>


                    <tr>
                        <td>Break By</td>
                        <td  colspan="4">
                            <b><?= $BreakBy ?></b>

                            (Q-Quantity, A-Amount, LQ-Loop Quantity, LA-Loop Amount)
                        </td>
                    </tr>
                    <!--<tr>
                        <td>
                            Discount For
                        </td>
                        <td  colspan="4">
                            <b><= $DiscFor ?></b>
                            (B-Baht P-Percent)
                        </td>
                    </tr>-->
                    <tr>
                        <!--<td>
                            Step
                        </td>-->
                        <td  colspan="4">

                            <input class="inputData" type="hidden" id="Step" name="Step"  size="3" value="<?= $countRows + 1 ?>" readonly="readonly"  style="background:#f5f5f5">	

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Promotion Step Note<font color="red">*</font>
                        </td>
                        <td  colspan="4">

                            <textarea  class="inputData" rows="5" cols="50" id="PromStepNote" name="PromStepNote"></textarea>	

                        </td>
                    </tr>
                    <!--
                    <tr>
                            <td>
                                    Minimum SKU
                            </td>
                            <td  colspan="4">
                            
                                    <input class="inputData" type="text" id="MinimumSKU" name="MinimumSKU">	
                            
                            </td>
                    </tr>
                    -->

                    <tr>
                        <td colspan="2">
                            <b>Break By</b>
                        </td>
                    </tr>
                    <?php
                    if ($BreakBy == "Q" or $BreakBy == "LQ") {
                        ?>
                        <tr>
                            <td>Break Quantity</td>
                            <td>
                                <input  class="inputData textNumber" type="text" id="BreakQty" name="BreakQty" value="0">
                            </td>
                            <td>
                                Unit

                            </td>
                            <td id="breakUnitCodeArea">
                                <select>
                                    <option>
                                        Pack
                                    </option>
                                    <option>
                                        Piece
                                    </option>
                                </select>
                            </td>

                            <td>Break Unit Factor</td>
                            <td>
                                <input  class="inputData textNumber" type="text" id="BreakUnitFactor" name="BreakUnitFactor" value="1" readonly="readonly"  style="background:#f5f5f5" size="3">
                            </td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td>Break Amount</td>
                            <td>
                                <input  class="inputData textNumber" type="text"  id="BreakAmt" name="BreakAmt"  value="0">
                            </td>
                        </tr>
                        <?php
                    }
                    ?>

                    <!--<tr>
                        <td colspan="2">
                            <b>Discount By</b>
                        </td>
                    </tr>

                    <php
                    if ($DiscFor == "P") {
                        ?>
                        <tr>
                            <td>Discount Percent</td>
                            <td><input  class="inputData" type="text" name="DiscPer" id="DiscPer"  value="0"></td>
                        </tr>
                        <php
                    } else {
                        ?>
                        <tr>
                            <td>Discount Bath</td>
                            <td><input  class="inputData" type="text" name="DiscBaht" id="DiscBaht"  value="0"></td>
                        </tr>
                        <php
                    }
                    ?>
                    -->

                    <tr>
                        <td>
                            <br>
                            <input type="button" class="btn btn-primary  btn-xs" id="back" value="Back">
                            <input type="hidden"  id="paramAction" name="paramAction" value="add">
                            <input type="submit" class="btn btn-primary  btn-xs" id="submit" value="Add">
                            <input type="reset" class="btn btn-primary  btn-xs" id="cancel" value="Cancel">
                        </td>

                    </tr>

                </table>
            </div>
        </div>

    </div>
    <!--
            <b>Break By</b>
            <div class="row">
                    <div class="col-md-12">
                            <div class="well">
                                    <table >
    
    <?php
    if ($BreakBy == "Q" or $BreakBy == "LQ") {
        ?>
                                                        <tr>
                                                                <td>Break Quantity</td>
                                                                <td>
                                                                <input type="text" id="BreakQty" name="BreakQty">
                                                                </td>
                                                                <td>
                                                                Unit
                                                                
                                                                </td>
                                                                <td>
                                                                <select>
                                                                        <option>
                                                                        Pack
                                                                        </option>
                                                                        <option>
                                                                        Piece
                                                                        </option>
                                                                        
                                                                </select>
                                                                
                                                                </td>
                                                                
                                                                <td>Break Quantity Factory</td>
                                                                <td>
                                                                <input type="text" id="BreakUnitFactor" name="BreakUnitFactor">
                                                                </td>
                                                        </tr>
        <?php
    } else {
        ?>
                
                                                <tr>
                                                        <td>Break Amount</td>
                                                        <td>
                                                        <input type="text" value="0.00" id="BreakAmt" name="BreakAmt">
                                                        </td>
                                                </tr>
                
        <?php
    }
    ?>
                                    
                                    </table >
                            </div>
                    </div>
            </div>
            
            
            <b>Discount By</b>
                    <div class="row">
                    <div class="col-md-12">
                            <div class="well">
                                    <table >
    <?php
    if ($BreakBy == "B" or $BreakBy == "LB") {
        ?>
                                                        <tr>
                                                                <td>Discount Percent</td>
                                                                <td><input type="text" name="DiscPer" id="DiscPer"></td>
                                                        </tr>
        <?php
    } else {
        ?>
                                                <tr>
                                                                <td>Discount Bath</td>
                                                                <td><input type="text" name="DiscBaht" id="DiscBaht"></td>
                                                </tr>
        <?php
    }
    ?>
                                    </table>
                            </div>
                    </div>
            </div>
            
            <div class="row">
                    <div class="col-md-12">
                            <div class="well">
                                    <table>
                                            <tr>
                                                    <td>
                                                            <input type="button" class="btn btn-primary  btn-xs" id="back" value="back">
                                                            <input type="hidden"  id="paramAction" name="paramAction" value="add">
                                                            <input type="submit" class="btn btn-primary  btn-xs" id="submit" value="Add">
                                                            <input type="reset" class="btn btn-primary  btn-xs" id="cancel" value="Cancel">
                                                    </td>
                                                    
                                            </tr>
                                    </table>
                            </div>
                    </div>
            </div>
    -->
</form><!-- form end here-->




<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong>List of Promotion Step</Strong>
            </div>
            <div id="showAllData">
            </div>
        </div>
    </div>
</div>
<!--
<table class="table">
        <thead>
                <tr>
                        <th>Promotion No</th>
                        <th>Item Code</th>
                        <th>Description</th>
                        <th>Step</th> 
                        <th>Break Qty</th>
                        <th>Break Amt</th>
                        <th>Disc Per</th>
                        <th>Disc Bath</th>
                        <th>Manage</th>
                </tr>
        </thead>
        <tbody>
                <tr>
                        <td>
                        D1520501
                        </td>
                        <td>
                        11130801
                        </td>
                        <td>
                        ค่ารามูโจ้18gฮ็อดชิลลี1
                        </td>
                        <td>
                        1
                        </td>
                        <td>
                        1
                        </td>
                        <td>
                        
                        </td>
                
                        <td>
                        6
                        </td>
                        <td>
                        </td>
                        <td>
                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg">Add Free Item </button>
                                
                        </td>
                </tr>
                <tr>
                        <td>
                        D1520501
                        </td>
                        <td>
                        11130802
                        </td>
                        <td>
                        ค่ารามูโจ้18gฮ็อดชิลลี2
                        </td>
                        <td>
                        2
                        </td>
                        <td>
                        1
                        </td>
                        <td>
                        
                        </td>
                
                        <td>
                        </td>
                        
                        <td>
                        6
                        </td>
                        <td>
                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg">Add Free Item </button>
                        </td>
                </tr>
                <tr>
                        <td>
                        D1520501
                        </td>
                        <td>
                        11130803
                        </td>
                        <td>
                        ค่ารามูโจ้18gฮ็อดชิลลี3
                        </td>
                        <td>
                        3
                        </td>
                        <td>
                        1
                        </td>
                        <td>
                        
                        </td>
                        
                        <td>
                        </td>
                        
                        <td>
                        6
                        </td>
                        <td>
                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-example-modal-lg">Add Free Item </button>
                        </td>
                </tr>
                
        </tbody>
</table>

-->








<!-- Start Large modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Setup Free Promotion By Item - Free Item </h4>
            </div>
            <div class="bs-callout bs-callout-info">
                <h4>Promotion Step</h4>
                <div id="detailPromotion"></div>
                <!--
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
                                <td>ค่ารามูโจ้18gฮ็อดชิลลี1</td>
                                <td>Q</td>
                                <td>B</td>
                        </tr>
                </tbody>
            </table>
                -->
            </div>



            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <div class="alert alert-warning" role="alert">
                                <Strong> Add Free Item</Strong>
                            </div>
                            <form id="addFreeItem" name="addFreeItem">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table >
                                            <tr>
                                                <td> Brand</td>
                                                <td id="brandArea"  colspan="5">
                                                    <!--
                                                            <select id="brand" name="brand" class="multiSelect" style="width:150px">
                                                                    <option>All Band</option>
                                                                    <option>Band01</option>
                                                                    <option>Band02</option>
                                                                    <option>Band03</option>
                                                                    <option>Band04</option>
                                                                    <option>Band05</option>
                                                                    <option>Band06</option>
                                                            </select>
                                                    -->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Free Item Code</td>
                                                <td colspan="5">
                                                    <div  id="itemCodeArea" style="display:inline">
                                                        <!--
                                                                <select id="itemCode" name="itemCode">
                                                                        <option>10101001</option>
                                                                        <option>10101002</option>
                                                                        <option>10101003</option>
                                                                        <option>10101004</option>
                                                                        <option>10101005</option>
                                                                        <option>10101006</option>
                                                                        <option>10101007</option>
                                                                        <option>10101008</option>
                                                                        <option>10101009</option>
                                                                        <option>101010010</option>
                                                                </select>
                                                        -->
                                                    </div>

                                                    <div id="itemNameArea" style="display:inline">
                                                        <input name="itemName" id="itemName" type="text" />
                                                    </div>

                                                </td>
                                            </tr>

                                            <tr>
                                                <td>Free Qty</td>
                                                <td >
                                                    <input type="text" size="20"class="textNumber" id="FreeQty" name="FreeQty" value="1">
                                                </td >
                                                <td >Unit </td>
                                                <td id="unitCodeArea">
                                                    <!--
                                                    <select id="FreeUnitCode" size="20" name="FreeUnitCode">
                                                            <option>ชิ้น</option>
                                                            <option>แพ็ค</option>
                                                    </select>
                                                    -->
                                                </td>

                                                <td>Free Unit Factor </td>
                                                <td>
                                                    <div >
                                                        <input id="FreeUnitFactor" class="textNumber" type="text" size="3" style="background:#f5f5f5 " value="1"  >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>GL Account</td>
                                                <td>

                                                    <input type="text" size="20" id="GLAccount" name="GLAccount" value="">
                                                    <input type="hidden" size="20" id="Seq" name="Seq">

                                                </td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                                <br style="clear:both">
                                <input type="hidden"  id="paramActionFreeItem" name="paramActionFreeItem" value="add">
                                <input type="submit" class="btn btn-primary  btn-xs" id="submitFreeItem" value="Add">
                                <input type="reset" class="btn btn-primary  btn-xs" id="cancelFreeItem" value="Cancel">

                            </form>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div class="well">
                            <div class="alert alert-warning" role="alert">
                                <Strong>List of Step Free Item</Strong>
                            </div>

                            <div id="showAllDataFreeItem">


                            </div>


                        </div>
                    </div>
                </div>
                <!--
          <table class="table">
                <thead>
                        <tr>
                                
                                
                                <th>Free Item Code</th>
                                <th>Description</th>
                                <th>Free Qty</th>
                                <th>Unit</th>
                                <th>Gl Account</th>
                                <th>Manage</th>
                                
                        </tr>
                </thead>
                <tbody>
                        <tr>
                                
                                <td>01010006</td>
                                <td>กระทิงแดง150มล.</td>
                                <td>1</td>
                                <td>Piece</td>
                                <td></td>
                                <td>
                                                <button type="button" class="btn btn-primary btn-xs btn-xs">Edit </button>
                                                        <button type="button" class="btn btn-danger btn-xs btn-xs">Delete </button>
                                </td>
                        </tr>
                        <tr>
                        
                                <td>01010007</td>
                                <td>กระทิงแดง150มล.(พ)</td>
                                <td>1</td>
                                <td>Piece</td>
                                <td></td>
                                <td>
                                                <button type="button" class="btn btn-primary btn-xs ">Edit </button>
                                                        <button type="button" class="btn btn-danger btn-xs ">Delete </button>
                                </td>
                        </tr>
                        <tr>
                                
                                <td>01010008</td>
                                <td>เรดดิ้โกจิ</td>
                                <td>1</td>
                                <td>Piece</td>
                                <td></td>
                                <td>
                                                <button type="button" class="btn btn-primary btn-xs ">Edit </button>
                                                        <button type="button" class="btn btn-danger btn-xs ">Delete </button>
                                </td>
                        </tr>
                </tbody>
          </table>
                -->

            </div>
        </div>

    </div>
</div>
<!-- End Large modal -->



