<style> 
    .disInline{
        display:inline;
    }
</style>

<?php
$paramGroupCode = $_POST['paramGroupCode'];
include_once("../config.php");
$sql = "SELECT * FROM PromGroup WHERE GroupCode='$paramGroupCode'";
$rs = odbc_exec($conn, $sql);
if (!$rs) {
    exit("Error in SQL");
}
while (odbc_fetch_row($rs)) {
    $GroupCode = iconv("tis-620", "utf-8", odbc_result($rs, "GroupCode"));
    $GroupDesc = iconv("tis-620", "utf-8", odbc_result($rs, "GroupDesc"));
}
odbc_close($conn);
?>


<div class="alert alert-warning" role="alert" >
    <h4>Promotion Group</h4>

</div>



<div class="row">

    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong>Add Item of Group(<div id="<?= $GroupCode ?>" class="disInline groupCode"><?= $GroupCode ?></div>,<?= $GroupDesc ?>)</Strong>
            </div>
            <form name="AddProdForPromGroup" id="AddProdForPromGroup">
                <table >
                    <tr>
                        <td>Brand</td>
                        <td id="brandArea" colspan="3">
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
                        <td>Item Code</td>
                        <td colspan="3">
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
                        </td>
                        <!--<td id="itemNameArea">

                            <input name="itemName"  id="itemName" type="text"  />

                        </td>-->
                    </tr>
                    <tr>
                        <td>
                            Minimum Order
                        </td>
                        <td colspan="3">
                            <input id="minimum"  name="minimum" type="text" size="4" name="minimum" value="0" class="textNumber"/>

                            Unit

                            <div id="unitCodeArea" style="display:inline" >
                                <!--
                                <select id="unitCode" name="unitCode">
                                        <option value="Piece">Piece</option>
                                        <option value="Pack">Pack</option>
                                </select>
                                -->
                            </div>
                        </td>
                    </tr>

                </table>
                <br style="clear:both">
                <table>

                    <tr>
                        <td>

                                                                <!--<input type="button"  class="btn btn-primary  btn-xs" id="ShowHide" value="Show/Hide">-->
                            <input type="button" class="btn btn-primary  btn-xs" id="back" value="Back">
                            <input type="hidden"  id="paramAction" name="paramAction" value="add">
                            <input type="submit" class="btn btn-primary  btn-xs" id="submit" value="Add">
                            <input type="reset" class="btn btn-primary  btn-xs" id="cancel" value="Cancel">

                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-12">
        <div class="well">

            <div class="alert alert-warning" role="alert">
                <Strong>List of Item of Group</Strong>
            </div>
            <!-- Search start-->
            <!--
            <form class="form-inline" role="form" id="search" name="search">
                      <div class="form-group">
                      Group Code
                            <select class="form-control input-sm">
                                    <option>All</option>
                                    <option>DE5233</option>
                            </select>
                            
                            <label class="sr-only" for="groudDesc">Search</label>
                            <input type="text" class="form-control input-sm" id="groudDesc" placeholder="Group Description">
                      </div>
                      
                      <button type="submit" class="btn btn-primary   btn-xs">Search</button>
            </form>
            <br style="clear:both">
            -->
            <!-- Search end-->

            <div id="showAllData">

            </div>
            <!--
                    <table class="table">
                            <thead>
                                    <tr >
                                            <th>
                                            Item Code
                                            </th>
                                            <th>
                                            Item Name
                                            </th>
                                            <th>
                                            Minimum  Order
                                            </th>
                                            <th>
                                            Unit
                                            </th>
                                            
                                            <th>
                                            Manage
                                            </th>
                                    </tr>
                                    <tr>
                                            <td>
                                            10101001
                                            </td>
                                            <td>
                                            ทีโอเปลํกซ์ คลับแพ็ค 
                                            </td>
                                            <td>
                                            0
                                            </td>
                                            <td>
                                            Pack
                                            </td>
                                            
                                            
                                            <td>
                                            <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                            <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                            10101002
                                            </td>
                                            <td>
                                            กระทิงแดง150 มล.
                                            </td>
                                            <td>
                                            0
                                            </td>
                                            <td>
                                            Pack
                                            </td>
                                            
                                            <td>
                                            <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                            <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                            10101003
                                            </td>
                                            <td>
                                            กระทิงแดง บาร์โค้ด
                                            </td>
                                            <td>
                                            0
                                            </td>
                                            <td>
                                            Pack
                                            </td>
                                            
                                            <td>
                                            <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                            <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                            </td>
                                    </tr>
                                    <tr>
                                            <td>
                                            10101004
                                            </td>
                                            <td>
                                            กระทิงแดงบาร์โค้ด
                                            </td>
                                            <td>
                                            0
                                            </td>
                                            <td>
                                            Pack
                                            </td>
                                            
                                            <td>
                                            <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                            <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                            </td>
                                    </tr>
                            </thead>
                    </table>
            -->
        </div>
    </div>
</div>

