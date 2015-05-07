
<div class="alert alert-warning" role="alert" >
    <h4>Setup Free Promotion By Item</h4>

</div>




<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong> Add Promotion</Strong>
            </div>
            <form id="addFreePromByItem" name="addFreePromByItem">
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
                            <input type="text" size="10" class="date" id="StartDate" name="StartDate">
                            &nbsp; To	&nbsp;
                            <input type="text"size="10" class="date" id="EndDate" name="EndDate">

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
                        <td id="branchArea">
                            <!--
                                    <select class="multiSelect" id="branch">
                                            <option>All Branch</option>
                                            <option>Branch0</option>
                                            <option>Branch1</option>
                                    </select>
                            -->
                        </td>
                        <td>
                            <input type="checkbox" name="branchAll" id="branchAll" checked value="All"> All Branch 
                        </td>
                    </tr>
                    <tr>
                        <td >
                            Sales Team 
                        </td>
                        <td id="salesTeamArea">
                            <!--
                            <select class="multiSelect" id="salesTeam" multiple="multiple">
                                    <option value="All">All Sales Team</option>
                                    <option value="A">Sales Team A</option>
                                    <option value="B">Sales Team B</option>
                                    <option value="C">Sales Team C</option>
                            </select>
                            -->
                        </td>
                        <td>
                            <input type="checkbox" name="salesTeamsAll" id="salesTeamsAll" checked value="All"> All Sales Team 
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Shop Type
                        </td>
                        <td id="shopTypeArea">
                            <!--
                            <select class="multiSelect" id="shopType">
                                    <option>All ShopType</option>
                                    <option>Shop Type</option>
                                    <option>Shop Type</option>
                            </select>
                            -->
                        </td>
                        <td>
                            <input type="checkbox" name="shopTypeAll" id="shopTypeAll" checked value="All"> All Shop Type 
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
                <Strong> List of Free Promotion By Item</Strong>
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
                <!--
                        <table class="table">
                                <thead>
                                        <tr >
                                                <th>
                                                Prom No
                                                </th>
                                                <th>
                                                Prom Decs
                                                </th>
                                                <th>
                                                Start Date
                                                </th>
                                                <th>
                                                End Date
                                                </th>
                                                <th>
                                                Away
                                                </th>
                                                
                                                
                                                <th>
                                                Manage
                                                </th>
                                        </tr>
                                        <tr>
                                                <td>
                                                
                                                DI0908 
                                        
                                                </td>
                                                <td>
                                                Puriku350 ml   
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td></td>
                                        
                                                
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                <button type="button" class="btn btn-primary btn-xs">Print </button>
                                                <a href="2-2-setup-discount-prom-by-item-detail.html" class="addItem">
                                                <button type="button" class="btn btn-primary btn-xs">Add Item </button>
                                                </a>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-copy-modal-lg">Copy </button>
                                                
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                
                                                DI520301
                                                
                                                </td>
                                                <td>
                                                Tea & Star Promo
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td></td>
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                <button type="button" class="btn btn-primary btn-xs">Print </button>
                                                <a href="2-2-setup-discount-prom-by-item-detail.html" class="addItem">
                                                <button type="button" class="btn btn-primary btn-xs">Add Item </button>
                                                </a>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-copy-modal-lg">Copy </button>
                                                
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                
                                                DI520501
                                                
                                                </td>
                                                <td>
                                                Tea & Star Promo
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td></td>
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                <button type="button" class="btn btn-primary btn-xs">Print </button>
                                                <a href="2-2-setup-discount-prom-by-item-detail.html" class="addItem">
                                                <button type="button" class="btn btn-primary btn-xs">Add Item </button>
                                                </a>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-copy-modal-lg">Copy </button>
                                                
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                DI5209
                                                </td>
                                                <td>
                                                Puriku 350 ml   
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td>
                                                28/05/2553
                                                </td>
                                                <td></td>
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                <button type="button" class="btn btn-primary btn-xs">Print </button>
                                                <a href="2-2-setup-discount-prom-by-item-detail.html" class="addItem">
                                                <button type="button" class="btn btn-primary btn-xs">Add Item </button>
                                                </a>
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target=".bs-copy-modal-lg">Copy </button>
                                                
                                                </td>
                                        </tr>
                                </thead>
                        </table>
                -->
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
                                    <!--
                                    <tr>
                                    <td colspan="2">
                                    
                                            Copy Existing Promotion
                                            
                                            <input type="radio" checked name="newPromotion" id="newPromotion" value="Copy_Existing_Promotion">
                                            
                                            </td>
                                    
                            </tr>
                                    -->
                                    <!--
                            <tr>
                                    <td><input type="radio"  name="newPromotion" id="newPromotion" value="Blank_Promotion"></td>
                                    <td>As Blank Promotion</td>
                            </tr>
                                    -->
                                    <tr>
                                        <td>Promotion No</td>
                                        <td><input type="text" id="nPromNo"size="10" name="nPromNo"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">

                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                            <br style="clear:both">
                            <button type="submit" class="btn btn-primary btn-xs" id="nPromtionSubmit">Copy </button>
                            <button type="reset" class="btn btn-primary btn-xs" id="nCancel">Cancel </button>
                        </div>
                    </div>
                </div>



            </form>



        </div>

    </div>
</div>

<!--Copy End Large modal -->     	
<!-- Start Large modal -->

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">Free Item </h4>
            </div>
            <div class="bs-callout bs-callout-info">
                <h4>Detail Promotion</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prom No</th>
                            <th>Prom Desc</th>

                            <th>Break By</th>
                            <th>Discount For</th>
                            <th>LimitFreeQty</th>
                            <th>LimitDiscBaht</th>


                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>DI520301</td>
                            <td>Tea & Star Promo</td>
                            <td>Q</td>
                            <td>B</td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="modal-body">
                <h2>Add Free Item</h2>
                <div class="row">

                    <div class="col-md-6">

                        <table class="table">
                            <tr>
                                <td>Brand </td>
                                <td>
                                    <select>
                                        <option>All Brand</option>
                                        <option>Brand01</option>
                                        <option>Brand02</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Free Item Code</td>
                                <td>
                                    <input type="text">
                                </td>
                            </tr>
                            <tr>
                                <td>Discription</td>
                                <td>
                                    <textarea></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Free Qty</td>
                                <td>
                                    <input type="text">
                                </td>
                            </tr>

                            <tr>
                                <td>Unit </td>
                                <td>
                                    <select>
                                        <option>Picece</option>
                                        <option>Pack</option>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td>Free Unit Factor </td>
                                <td>

                                </td>
                            </tr>
                            <tr>
                                <td>GL Account</td>
                                <td>
                                    <input type="text">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-xs">Add </button>
                <button type="button" class="btn btn-danger btn-xs">Cancle </button>
                <hr>
                <h2>Detail Free Item</h2>
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

            </div>
        </div>

    </div>
