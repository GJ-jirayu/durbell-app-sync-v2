<?php session_start();
ob_start(); ?>


<div class="alert alert-warning" role="alert" >
    <h4> <Strong> Promotion Group </Strong> </h4>
</div>

<!-- from insert data start -->
<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong> Add Promotion Group</Strong>
            </div>

            <form name="prodGroupForProm" id="prodGroupForProm">
                <table class=" prodGroupForPromFrom">
                    <tr>
                        <td>Group Code</td>
                        <td>
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control input-sm" name="groupCode" id="groupCode" maxlength="10">
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Group Description</td>
                        <td><textarea name="groupDesc" class="form-control input-sm"  id="groupDesc" rows="1" cols="40" maxlength="30"></textarea></td>
                    </tr>

                </table>
                <table>
                    <tr>
                        <td>

                                                                <!--<input type="button"  class="btn btn-primary  btn-xs" id="ShowHide" value="Show/Hide">-->
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


<!-- from insert data end-->

<div class="row">
    <div class="col-md-12">
        <div class="well">
            <div class="alert alert-warning" role="alert">
                <Strong> List of Promotion Group</Strong>
            </div>
            <!-- Search start-->
            <form class="form-inline" role="form" id="search" name="search">
                <div class="form-group">

                    <!--
                    <select class="form-control input-sm">
                            <option>All</option>
                            <option>DE5233</option>
                    </select>
                    -->


                <!--<input type="text" class="form-control input-sm" id="groudDescSearch" placeholder="Group Description">-->
                    <table>
                        <tr>
                            <td>
                                Group Code
                            </td>
                            <td>

                                <div id="groupCodeArea" style="display:inline;">
                                </div>

                            </td>
                            <td id="groudDescSearchArea">
                                <input type="text" id="groudDescSearch" placeholder="Group Description">
                            </td>
                            <td>
                                <button type="submit" class="btn btn-primary   btn-xs">Search</button>
                            </td>
                        </tr>
                    </table>


                </div>


            </form>
            <br style="clear:both">
            <!-- Search end-->
            <!-- table from data base for show all data start-->
            <div id="showAllData">
                <!--
                        <table class="table">
                                <thead>
                                        <tr >
                                                <th>
                                                Group Code
                                                </th>
                                                <th>
                                                Group Desc
                                                </th>
                                                
                                                <th>
                                                Manage
                                                </th>
                                        </tr>
                                        <tr>
                                                <td>
                                                ED520301
                                                </td>
                                                <td>
                                                EDLP 52/03#1
                                                </td>
                                                
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                        <a href="1-2-add-prod-for-prom-group.html">
                                                        <button type="button" class="btn btn-primary btn-xs">Add Item</button>
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                ED520302
                                                </td>
                                                <td>
                                                EDLP 52/03#2
                                                </td>
                                                
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                        <a href="1-2-add-prod-for-prom-group.html">
                                                        <button type="button" class="btn btn-primary btn-xs">Add Item</button>
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                ED520303
                                                </td>
                                                <td>
                                                EDLP 52/03#3
                                                </td>
                                                
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                <a href="1-2-add-prod-for-prom-group.html">
                                                        <button type="button" class="btn btn-primary btn-xs">Add Item</button>
                                                        </a>
                                                </td>
                                        </tr>
                                        <tr>
                                                <td>
                                                ED520304
                                                </td>
                                                <td>
                                                EDLP 52/03#4
                                                </td>
                                                
                                                
                                                <td>
                                                <button type="button" class="btn btn-primary btn-xs">Edit </button>
                                                <button type="button" class="btn btn-danger btn-xs">Delete </button>
                                                        <a href="1-2-add-prod-for-prom-group.html">
                                                        <button type="button" class="btn btn-primary btn-xs">Add Item</button>
                                                        </a>
                                                </td>
                                        </tr>
                                </thead>
                        </table>
                </div>
                -->
            </div><!-- #showAllData-->


            <!-- table from data base for show all data end-->
        </div>
    </div>

</div>




<!-- Start Large modal -->


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">New Promotion</h4>
            </div>
            <div class="bs-callout bs-callout-info">
                <h4>Detail Promotion</h4>
                <div class="row">
                    <div class="col-md-5">
                        <table class="table">

                            <tbody>
                                <tr>
                                    <td><input type="radio" name="radio1"></td>
                                    <td>As Blank Promotion</td>
                                </tr>
                                <tr>
                                    <td><input type="radio" name="radio1"></td>
                                    <td>Copy Existing Promotion</td>


                                </tr>
                                <tr>
                                    <td><input type="text" size="5"></td>
                                    <td>Promotion No</td>


                                </tr>

                            </tbody>

                        </table>
                    </div>
                </div>

            </div>

            <div class="modal-body">
                <h2>Promotion</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <tbody>
                                <tr >
                                    <th>
                                        Prom Group No
                                    </th>
                                    <th>
                                        Prom Group Desc
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

                                </tr>
                                <tr>
                                    <td>
                                        <a href="5-2-setup-free-item-prom-by-group-detail.html">
                                            DG0908 
                                        </a>
                                    </td>
                                    <td>
                                        Colo KRMC   
                                    </td>
                                    <td>
                                        28/05/2553
                                    </td>
                                    <td>
                                        28/05/2553
                                    </td>
                                    <td></td>



                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-xs">Save </button>
                <button type="button" class="btn btn-danger btn-xs">Cancle </button>



            </div>
        </div>






    </div>
</div>

<!-- End Large modal -->
<br style="clear:both">


