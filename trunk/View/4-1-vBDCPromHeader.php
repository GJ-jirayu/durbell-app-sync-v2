
<div class="alert alert-warning" role="alert" >
    <h4>Setup Bundle Discount Promotion</h4>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong> Add Promotion</Strong>
            </div>
            <form id="addBDCPromHeader" name="addBDCPromHeader">
                <table >
                    <tr>
                        <td>Promotion No</td>
                        <td colspan="2">

                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text"  class="form-control input-sm" size="5" name="PromNo" id="PromNo" maxlength="10"/>
                                </div>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Promotion Description</td>
                        <td colspan="2">
                            <input type="text" class="form-control input-sm" name="PromDesc" id="PromDesc" maxlength="30"/>
                        </td>

                    </tr>

                    <tr>
                        <td>Effective Date</td>
                        <td colspan="2">
                            <input type="text" size="8" class="date" id="StartDate" name="StartDate">
                            &nbsp; To	&nbsp;
                            <input type="text"size="8" class="date" id="EndDate" name="EndDate">

                        </td>
                    </tr>
                    <tr>
                        <td>
                            Priority
                        </td>
                        <td id="priorityArea" colspan="2">

                            <select id="Priority" name="Priority">
                                <option selected>0</option>
                                <option>1</option>
                            </select>

                        </td>
                    </tr>

                    <!--
                    <tr>
                            <td>
                                    Note
                            </td>
                            <td>
                                    <textarea id="note" rows="5" cols="50" ></textarea>
                            </td>
                    </tr>
                    
                    <tr>
                            <td>Alway</td>
                            <td id="alwayArea" colspan="2"><input type="checkbox"  checked id="Alway" name="Alway" value="1"></td>
                    </tr>
                    -->
                    <tr>
                        <td>
                            Branch
                        </td>
                        <td colspan="3">
                            <div  id="branchArea" style="display:inline"></div>
                            <!--
                                    <select class="multiSelect" id="branch">
                                            <option>All Branch</option>
                                            <option>Branch0</option>
                                            <option>Branch1</option>
                                    </select>
                            -->
                            <div style="display:inline">
                                <input type="checkbox" name="branchAll" id="branchAll" checked value="All"> All Branch 
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td >
                            Sales Team 
                        </td>
                        <td   colspan="3">
                            <div id="salesTeamArea" style="display:inline"></div>
                            <!--
                            <select class="multiSelect" id="salesTeam" multiple="multiple">
                                    <option value="All">All Sales Team</option>
                                    <option value="A">Sales Team A</option>
                                    <option value="B">Sales Team B</option>
                                    <option value="C">Sales Team C</option>
                            </select>
                            -->
                            <div style="display:inline">
                                <input type="checkbox" name="salesTeamsAll" id="salesTeamsAll" checked value="All"> All Sales Team 
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            Shop Type
                        </td>
                        <td  colspan="3">
                            <div id="shopTypeArea" style="display:inline"></div>
                            <!--
                            <select class="multiSelect" id="shopType">
                                    <option>All ShopType</option>
                                    <option>Shop Type</option>
                                    <option>Shop Type</option>
                            </select>
                            -->
                            <div style="display:inline">
                                <input type="checkbox" name="shopTypeAll" id="shopTypeAll" checked value="All"> All Shop Type 
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <td>Break By</td>
                        <td id="breakByArea" colspan="2">
                            <select name="breakBy" id="breakBy" style="height:26px;">
                                <option value="A">A</option>
                                <option value="Q">Q</option>
                                <option selected="selected" value="LA">LA</option>
                                <option value="LQ">LQ</option>
                            </select>(Q-Quantity, A-Amount, LQ-Loop Quantity, LA-Loop Amount)
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Discount For
                        </td>
                        <td  id="disCountForArea" colspan="2">
                            <select  name="disCountFor" id="disCountFor" style="height:26px;">
                                <option value="P" selected>P</option>
                                <option value="B">B</option>


                            </select>(P-Percent B-Baht)
                        </td>
                    </tr>
                    <tr id="DiscountPercentArea">
                        <td>Discount Percent</td>
                        <td colspan="2"><input  class="inputData textNumber" type="text" name="DiscPer" id="DiscPer" maxlength="8" value="0"></td>
                    </tr>
                    <tr id="DiscountBathArea" style="display:none;">
                        <td>Discount Baht</td>
                        <td colspan="2"><input  class="inputData textNumber" type="text" name="DiscBaht" id="DiscBaht" maxlength="13" value="0"></td>
                    </tr>
                    <tr>
                        <td>
                            Limit Free Qty
                        </td>
                        <td colspan="2">
                            <input type="text" class="textNumber" name="limitFreeQty" id="limitFreeQty" value="0">
                            Unit 
                            <div id="unitCodeArea" style="display:inline">
                                <input type="text" name="freeUnitCode" id="freeUnitCode"/>
                        </td>

                    </tr>
                    <tr>
                        <td>
                            Limit Discount Baht
                        </td>
                        <td colspan="2">
                            <input type="text" class="textNumber" name="limitDiscBath" id="limitDiscBath" maxlength="13" value="0"/>
                        </td>
                    </tr>



                </table>


                <br style="clear:both">

                <table>
                    <tr>
                        <td>
                            <input type="hidden"  id="paramAction" name="paramAction" value="add">
                            <input type="submit" class="btn btn-primary  btn-xs" id="submit" value="Add">
                            <input type="button" class="btn btn-primary  btn-xs" id="cancel" value="Cancel">
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
                <Strong> List of Bundle Discount Promotion</Strong>
            </div>


            <!-- Search start-->
            <form class="form-inline" role="form" id="search" name="search">
                <div class="form-group">

                    <table>

                        <tr>
                            <td> Promotion No:</td>
                            <td id="promNoSearchArea">
                                <select class="form-control input-sm">
                                    <option>All</option>
                                    <option>DE5233</option>
                                </select>
                            </td>
                            <td id="promDescSearchArea">
                                    <!--<input type="text" class="form-control input-sm" id="promDescSearch" placeholder="Promotion Description">-->
                            </td>
                            <td>
                                Start Date:
                            </td>
                            <td>
                                <input type="text" size="8" class="date  " id="StartDateSearch" name="StartDateSearch">
                            </td>
                            <td>
                                End Date:
                            </td>
                            <td>
                                <input type="text"size="8" class="date  " id="EndDateSearch" name="EndDateSearch">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary   btn-xs">Search</button>
                            </td>
                        </tr>

                    </table>

                    <!--
                    Promotion No:
                          <select class="form-control input-sm">
                                  <option>All</option>
                                  <option>DE5233</option>
                          </select>
                          
                          
                          <input type="text" class="form-control input-sm" id="groudDesc" placeholder="Promtion Description">
                    </div>
                          Start Date:
                          <input type="text" size="6" class="date  " id="StartDateSearch" name="StartDateSearch">
                          &nbsp;
                          End Date:
                          <input type="text"size="6" class="date  " id="EndDateSearch" name="EndDateSearch">

                    
                    <button type="submit" class="btn btn-primary   btn-xs">Search</button>
                    -->

            </form>
            <br style="clear:both">
            <!-- Search end-->

            <div id="showAllData">

            </div><!-- content-->
        </div>
    </div>
</div>

</div>
<!--Copy Start Large modal -->


<div class="modal fade bs-copy-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Copy Promotion</h4>
            </div>


            <div class="modal-body">
                <h4>Promotion</h4>

                <div class="row">

                    <div class="col-md-12">

                        <table class="table">
                            <tbody>
                                <tr >
                                    <th>
                                        Promotion No
                                    </th>
                                    <th>
                                        Promotion Description
                                    </th>
                                    <th>
                                        Start Date
                                    </th>
                                    <th>
                                        End Date
                                    </th>
                                    <!--
                                    <th>
                                    Away
                                    </th>
                                    -->
                                    <th>
                                        Alway
                                    </th>


                                </tr>
                                <tr>
                                    <td id="cPromNo">

                                        DI0908 

                                    </td>
                                    <td id="cPromDesc">
                                        Puriku350 ml
                                    </td>
                                    <td id="cStartDate">
                                        28/05/2553
                                    </td>
                                    <td id="cEndDate">
                                        28/05/2553
                                    </td>
                                    <!--
                                    <td id="cAlway">
                                    
                                    </td>
                                    -->
                                    <td id="cPriority">

                                    </td>



                                </tr>

                            </tbody>
                        </table>


                    </div>
                </div>

            </div>




            <form id="addNewPromotion" name="addNewPromotion">
                <div class="bs-callout bs-callout-info">
                    <h4>New Promotion</h4>
                    <div class="row">
                        <div class="col-md-5">
                            <table >
                                <tbody>
                                    <tr>
                                        <td colspan="2">
                                            <!--
                                            Copy Existing Promotion
                                            
                                            <input type="radio" checked name="newPromotion" id="newPromotion" value="Copy_Existing_Promotion">
                                            -->
                                        </td>

                                    </tr>
                                    <!--
                            <tr>
                                    <td><input type="radio"  name="newPromotion" id="newPromotion" value="Blank_Promotion"></td>
                                    <td>As Blank Promotion</td>
                            </tr>
                                    -->
                                    <tr>
                                        <td>Promotion No</td>
                                        <td><input type="text" id="nPromNo"size="10" name="nPromNo" maxlength="10"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <br style="clear:both">
                            <button type="submit" class="btn btn-primary btn-xs" id="nPromtionSubmit">Add </button>
                            <button type="reset" class="btn btn-danger btn-xs" id="nCancel">Cancel </button>
                        </div>
                    </div>
                </div>



            </form>



        </div>

    </div>
</div>

<!--Copy End Large modal -->     	
<!-- Start Large modal -->

<div class="modal fade bs-addFreeItem-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Setup Bundle Discount Promotion - Free Item</h4>
            </div>
            <!--
    <div class="bs-callout bs-callout-info">
                                <h4>Promotion Step</h4>
                                    <div id="detailPromotion">
                                    </div>
                                    

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
                                    
                    </div>
            -->


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
                                                <td>Promotion No</td>
                                                <td id="promNoArea">1010</td>
                                            </tr>
                                            <tr>
                                                <td>Step</td>
                                                <td><input type="text" name="freeStep" class="textNumber" id="freeStep" maxlength="1" size="5"></td>
                                            </tr>
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
                                                    <input type="text" size="20" id="FreeQty" name="FreeQty" value="0" class="textNumber">
                                                </td >
                                                <td >Unit </td>
                                                <td id="unitCodeFreeArea" >

                                                    <select id="FreeUnitCode" size="20" name="FreeUnitCode">
                                                        <option>ชิ้น</option>
                                                        <option>แพ็ค</option>
                                                    </select>

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

                                                    <input type="text" size="20" id="GLAccount" name="GLAccount" value="" maxlength="20" >
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