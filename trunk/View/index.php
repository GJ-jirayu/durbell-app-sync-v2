<?php session_start();
ob_start(); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!--Courier New font -->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

        <title>Setup Discount Promotion By Item</title>


        <!-- kendo css start-->
        <link href="../kendoUi/styles/kendo.common.min.css" rel="stylesheet" />
        <link href="../kendoUi/styles/kendo.default.min.css" rel="stylesheet" />
        <link href="../kendoUi/styles/kendo.dataviz.min.css" rel="stylesheet" />
        <link href="../kendoUi/styles/kendo.dataviz.default.min.css" rel="stylesheet" />
        <!-- kendo css end-->

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../bootstrap-3.1.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="../bootstrap-3.1.1/css/blog.css">
        <link rel="stylesheet" href="../bootstrap-3.1.1/css/doc.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="../bootstrap-3.1.1/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->

<!--<script src="//code.jquery.com/jquery-2.1.0.min.js"></script>-->
        <script src="../bootstrap-3.1.1/js/jquery-2.1.1.min.js"></script>
        <script src="../bootstrap-3.1.1/js/bootstrap.min.js"></script>


        <!-- jquery ui -->
        <script src="../Utility/jqueryUi/js/jquery-ui-1.10.4.custom.min.js"></script>
        <link  href="../Utility/jqueryUi/css/cupertino/jquery-ui-1.10.4.custom.min.css" rel="stylesheet" />
        <!-- jquery ui -->


        <!-- call js -->
        <script src="../Utility/jqueryUi/jquery.multiselect.js"></script>
        <link href="../Utility/jqueryUi/jquery.multiselect.css" rel="stylesheet" />

        <script src="../Utility/jqueryUi/jquery.multiselect.filter.js"></script>
        <link href="../Utility/jqueryUi/jquery.multiselect.filter.css" rel="stylesheet" />
        <!-- call js -->


        <!-- kendo js start-->
        <script src="../kendoUi/js/angular.min.js"></script>
        <script src="../kendoUi/js/kendo.all.min.js"></script>
        <!-- kendo js end-->

        <!--
        <link rel="stylesheet" type="text/css" href="../jquery-ui-multiselect/jquery.multiselect.css" />
        <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="../jquery-ui-multiselect/src/jquery.multiselect.js"></script>
        -->
        <!-- include js start-->

<!--<script class="prodGroupForProm" type="text/javascript" src="../Controller/prodGroupForProm.js"></script>-->
        <script type="text/javascript" src="../Controller/main.js"></script>
        <!-- include js start-->

        <style>
            .bs-callout {
                margin: 10px 0;
                padding: 12px;
            }
            .well{
                margin-bottom: 5px;
                padding:5px;
                padding-top:2px;

            }
            h3{
                margin:2px;
            }
            h4{
                margin:2px;
            }
            .alert{
                margin-top:0px;
            }
            .blog-masthead{
                margin-bottom: 5px;
            }
            table tr td{
                vertical-align: top;
            }
            .container {
                width: 1100px;
            }
            .textNumber{
                text-align: right;
                padding-right: 5px;
            } 

        </style>
    </head>
    <body>
        <?php
        if (!$_SESSION['sessUser']) {
            header("location:../login.php");
        }

        /*
          echo"sessUser".$_SESSION['sessUser']."<br>";
          echo"sesPass".$_SESSION['sesPass']."<br>";
          echo"sesGroupID".$_SESSION['sesGroupID']."<br>";
         */
        ?>
        <div class="blog-masthead">
            <div class="container">
                <nav class="blog-nav">
                    <ul class="nav navbar-nav bg-primary">
                        <li><a href="#" id="prodGroupForProm"><span class="glyphicon glyphicon-th"></span> Promotion Group </a></li>
                        <li class="dropdown ">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <span class="glyphicon glyphicon-th-list"></span> Discount Promotion <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="DiscPromByItem"><span class="glyphicon glyphicon-star-empty"></span> Setup Discount Promotion by Item</a></li>
                                <li><a href="#" id="DiscPromByGroup"><span class="glyphicon glyphicon-user"></span> Setup Discount Promotion by Group</a></li>
                                <li><a href="#" id="DiscPromByBundle"><span class="glyphicon glyphicon-star"></span> Setup Bundle Discount Promotion</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-gift"></span>  Free Item Promotion<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#" id="FreePromByItem"><span class="glyphicon glyphicon-tag"></span> Setup Free Promotion By Item</a></li>
                                <li><a href="#" id="FreePromByGroup"><span class="glyphicon glyphicon-tags"></span> Setup Free Promotion By Group</a></li>
                                <li><a href="#" id="FreePromByBundle"><span class="glyphicon glyphicon-calendar"></span> Setup Bundle Free Item Promotion</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../loginAction.php?paramAction=logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- main content -->
        <div class="container">
            <div id="content">
            </div>
        </div>
        <!-- main content -->



        <div class="blog-footer">
            <p>iVan BackOffice</p>
            <p>
                <a href="#">Back to top</a>
            </p>
        </div>
    </body>
</html>
