
<?php
$paramPromNo = $_POST['paramPromNo'];
$paramPromType = $_POST['paramPromType'];
include_once("../config.php");
$sql = "SELECT * FROM PromHeader WHERE PromNo='$paramPromNo' and PromType='$paramPromType'";
$rs = odbc_exec($conn, $sql);
if (!$rs) {
    exit("Error in SQL");
}
while (odbc_fetch_row($rs)) {
    $PromNo = iconv("tis-620", "utf-8", odbc_result($rs, "PromNo"));
    $PromDesc = iconv("tis-620", "utf-8", odbc_result($rs, "PromDesc"));
}
odbc_close($conn);
?>

<div class="alert alert-warning" role="alert" >
    <h4>Setup Free Promotion by Group</h4>
</div>

<div class="row">
    <!-- form start-->
    <form id="addItemDiscountProm" name="addItemDiscountProm">
        <div class="col-md-12">
            <div class="well">
                <div class="alert alert-warning" role="alert">
                    <Strong> Add Group to Promotion(<?= $PromNo ?>)</Strong>
                </div>
                <table>
                    <tr>
                        <td>Promotion No</td>
                        <td colspan="2">
                            <b>
                                <div id="paramProNo" style="display:inline;"><?= $PromNo ?></div> <div id="paramProDesc" style="display:inline;"><?= $PromDesc ?></div>
                            </b>
                        </td>
                    </tr>


                    <tr>
                        <td>Group Code</td>
                        <td>
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
                        <td id="itemNameArea">
                            <input name="itemName" id="itemName" type="text" />

                        </td>
                    </tr>
                    <!--
                    <tr>
                            <td>Description</td>
                            <td>
                            <input type="text" readonly="readonly" style="background:#dddddd"/>
                            </td>
                                    
                    </tr>
                    -->
                    <tr>
                        <td>Break By</td>
                        <td id="breakByArea" colspan="2">
                            <select name="breakBy" id="breakBy" style="height:26px;">
                                <option value="A">A</option>
                                <option value="Q">Q</option>
                                <option value="LA" selected="selected">LA</option>
                                <option value="LQ">LQ</option>
                            </select>
                            (Q-Quantity, A-Amount, LQ-Loop Quantity, LA-Loop Amount)
                        </td>
                    </tr>

                    <!--<tr>
                        <td>
                            Discount For
                        </td>
                        <td  id="disCountForArea" colspan="2">
                            <select  name="disCountFor" id="disCountFor" style="height:26px;">
                                <option value="P">P</option>
                                <option value="B">B</option>


                            </select>

                            (B-Baht P-Percent)
                        </td>
                    </tr>-->
                    
                    <tr>
                        <td>
                            Limit Free Qty
                        </td>
                        <td colspan="2">
                            <input type="text" class="textNumber" name="limitFreeQty" id="limitFreeQty" value="0" />
                            Unit 
                            <div id="unitCodeArea" style="display:inline">
                            <!--<input type="text" name="freeUnitCode" id="freeUnitCode"/>-->
                        </td>

                    </tr>
                    <!--<tr>
                        <td>
                            Limit Disc Bath
                        </td>
                        <td colspan="2">
                            <input type="text" name="limitDiscBath" id="limitDiscBath"/>
                        </td>
                    </tr>-->

                </table>
                <br style="clear:both">
                <table>
                    <tr>
                        <td>
                            <input type="button" class="btn btn-primary  btn-xs" id="back" value="Back">
                            <input type="hidden"  id="paramAction" name="paramAction" value="add">
                            <input type="submit" class="btn btn-primary  btn-xs" id="submit" value="Add">
                            <input type="reset" class="btn btn-primary  btn-xs" id="cancel" value="Cancel">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- form end-->


</div>








<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong> List of Promotion Group</Strong>
            </div>

            <div id="showAllData">

                <!-- show data-->
                <!--
                                        <table class="table">
                                                <thead>
                                                        <tr >
                                                                <th>
                                                                Item code
                                                                </th>
                                                                <th>
                                                                Description
                                                                </th>
                                                                <th>
                                                                Break By
                                                                </th>
                                                                <th>
                                                                Disc For
                                                                </th>
                                                                
                                                                <th>
                                                                Limit Free Qty
                                                                </th>
                                                                <th>
                                                                Limit Disc Qty
                                                                </th>
                                                                <th>
                                                                Manage
                                                                </th>
                                                        </tr>
                                                        <tr>
                                                                <td>
                                                                11130801 
                                                                </td>
                                                                <td>
                                                                 ดารามูโจ้ 18 g ฮ็อดชิลลี
                                                                </td>
                                                                <td>
                                                                Q
                                                                </td>
                                                                <td>
                                                                B
                                                                </td>
                                                                <td>
                                                                1
                                                                </td>
                                                                <td>
                                                                5
                                                                </td>
                                                                
                                                                
                                                                
                                                                
                                                                <td>
                                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-viewStep-modal-lg">View Step </button>
                                                                <a href="2-3-setup-discount-prom-by-item-prom-step.html">
                                                                <button type="button" class="btn btn-primary btn-xs">Promotion Step </button>
                                                                </a>
                                                                
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td>
                                                                11130802 
                                                                </td>
                                                                <td>
                                                                 ดารามูโจ้ 70 g ฮ็อดชิลลี
                                                                </td>
                                                                <td>
                                                                Q
                                                                </td>
                                                                <td>
                                                                B
                                                                </td>
                                                                <td>
                                                                1
                                                                </td>
                                                                <td>
                                                                5
                                                                </td>
                                                                
                                                                
                                                                
                                                                <td>
                                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-viewStep-modal-lg">View Step </button>
                                                                <a href="2-3-setup-discount-prom-by-item-prom-step.html">
                                                                <button type="button" class="btn btn-primary btn-xs">Promotion Step </button>
                                                                </a>
                                                                
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td>
                                                                11130803 
                                                                </td>
                                                                <td>
                                                                15 g สไปชิโนชิ
                                                                </td>
                                                                <td>
                                                                Q
                                                                </td>
                                                                <td>
                                                                B
                                                                </td>
                                                                <td>
                                                                1
                                                                </td>
                                                                <td>
                                                                5
                                                                </td>
                                                                
                                                                
                                                                <td>
                                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-viewStep-modal-lg">View Step </button>
                                                                <a href="2-3-setup-discount-prom-by-item-prom-step.html">
                                                                <button type="button" class="btn btn-primary btn-xs">Promotion Step </button>
                                                                </a>
                                                                
                                                                </td>
                                                        </tr>
                                                        <tr>
                                                                <td>
                                                                11130804 
                                                                </td>
                                                                <td>
                                                                 ดารามูโจ้ 15 g สไปขิโนริ
                                                                </td>
                                                                <td>
                                                                Q
                                                                </td>
                                                                <td>
                                                                B
                                                                </td>
                                                                <td>
                                                                1
                                                                </td>
                                                                <td>
                                                                5
                                                                </td>
                                                                
                                                                
                                                                
                                                                <td>
                                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-viewStep-modal-lg">View Step </button>
                                                                <a href="2-3-setup-discount-prom-by-item-prom-step.html">
                                                                <button type="button" class="btn btn-primary btn-xs">Promotion Step </button>
                                                                </a>
                                                                
                                                                </td>
                                                        </tr>
                                                </thead>
                                        </table>
                -->

            </div><!-- show data-->

        </div>

    </div>
</div>

</div>


<!-- Start  View Step Large modal -->


<div class="modal fade bs-viewStep-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">View Step (DI0908 Puriku350 ml)</h4>
            </div>
            <div class="bs-callout bs-callout-info">
                <h4>Break By</h4>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prom Code</th>
                                    <th>Description</th>
                                    <th>Minimum SKU</th>
                                    <th>Break Qty</th>
                                    <th>Unit</th>
                                    <th>Break Amt</th>
                                    <th>DiscPer</th>
                                    <th>Disc Bath</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        11130801
                                    </td>
                                    <td>
                                        ค่ารามูโจ้18gฮ็อดชิลลี
                                    </td>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        1
                                    </td>
                                    <td>
                                        Pack
                                    </td>

                                    <td>

                                    </td>
                                    <td>
                                        6
                                    </td>
                                    <td>

                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>


                                    <th>Free Item Code</th>
                                    <th>Description</th>

                                    <th>Free Qty</th>
                                    <th>Unit</th>
                                    <th>Gl Account</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>01010006</td>
                                    <td>กระทิงแดง150มล.</td>
                                    <td>1</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                                <tr>

                                    <td>01010007</td>
                                    <td>กระทิงแดง150มล.(พ)</td>
                                    <td>1</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                                <tr>

                                    <td>01010008</td>
                                    <td>เรดดิ้โกจิ</td>
                                    <td>1</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>



                </div>

            </div>
            <div class="bs-callout bs-callout-info">
                <h4>Break By</h4>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Prom Code</th>
                                    <th>Description</th>
                                    <th>Minimum SKU</th>
                                    <th>Break Qty</th>
                                    <th>Unit</th>
                                    <th>Break Amt</th>
                                    <th>Disc Per</th>
                                    <th>Disc Bath</th>



                                </tr>
                            </thead>
                            <tbodyy>
                                <tr>
                                    <td>
                                        11130801
                                    </td>
                                    <td>
                                        ค่ารามูโจ้18gฮ็อดชิลลี
                                    </td>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        1
                                    </td>

                                    <td>
                                        Pack
                                    </td>

                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>
                                        6
                                    </td>


                                </tr>



                            </tbodyy>
                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>


                                    <th>Free Item Code</th>
                                    <th>Description</th>
                                    <th>Free Qty</th>
                                    <th>Unit</th>
                                    <th>Gl Account</th>


                                </tr>
                            </thead>
                            <tbody>
                                <tr>

                                    <td>01010006</td>
                                    <td>กระทิงแดง150มล.</td>
                                    <td>1</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                                <tr>

                                    <td>01010007</td>
                                    <td>กระทิงแดง150มล.(พ)</td>
                                    <td>2</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                                <tr>

                                    <td>01010008</td>
                                    <td>เรดดิ้โกจิ</td>
                                    <td>1</td>
                                    <td>Piece</td>
                                    <td></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>



                </div>





            </div>
        </div>
    </div>
</div>
<!-- End View Step Large modal -->   


