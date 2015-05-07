
alert("hello");

// create break by start
/*
 <select name="breakBy" id="breakBy">
 <option value="A">A</option>
 <option value="Q">Q</option>
 <option value="LA">LA</option>
 <option value="LQ">LQ</option>
 </select>
 (Q-Quanlity A-Amonut LQ-Loop Quanlity LA-Loop Amonut)
 */
var createBreakByDropDown = function(BreakBy) {

    $.ajax({
        url: "../Model/mBreakBy.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"breakBy\" name=\"breakBy\">";
            $.each(data, function(index, indexEntry) {
                if (BreakBy == indexEntry[0]) {
                    //alert("ok");
                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";
            htmlDropDown += "(Q-Quanlity A-Amonut LQ-Loop Quanlity LA-Loop Amonut)";
            setTimeout(function() {
                $("#breakByArea").html(htmlDropDown);
            }, 100);
            //alert(htmlDropDown);

        }
    });
}
// create break by end


// create discount for dropdown by start
/*
 <select  name="disCountFor" id="disCountFor">
 <option value="B">B</option>
 <option value="P">P</option>
 <option value="LB">LB</option>
 <option value="LP">LP</option>
 </select>
 
 (Q-Quanlity A-Amonut LQ-Loop Quanlity LA-Loop Amonut)
 */
var createDiscForDropDown = function(discountFor) {

    $.ajax({
        url: "../Model/mDisCountFor.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"disCountFor\" name=\"disCountFor\">";
            $.each(data, function(index, indexEntry) {
                if (discountFor == indexEntry[0]) {
                    //alert("ok");
                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";
            htmlDropDown += " (B-Baht P-Percent LB-Loop Baht LP-Loop Percent) ";
            setTimeout(function() {
                $("#disCountForArea").html(htmlDropDown);
            }, 100);
            //alert(htmlDropDown);

        }
    });
};
// create discount for dropdown  end




//test call createItemCodeDropDown start
createItemCodeDropDown();
//test call createItemCodeDropDown end


// clear field   start
var clearFielddata = function() {
    //limitFreeQty
    //freeUnitCode
    //limitDiscBath
    $("#limitFreeQty").val("");
    $("#freeUnitCode").val("");
    $("#limitDiscBath").val("");

};
// clear field  end


//show hide form fn start
var showHideFormFn = function() {
    $(".prodGroupForPromFrom").toggle();
    $("h3.addPromGroup").toggle();
    $("#submit").toggle();
    $("#cancel").toggle();
};
//show hide form fn end



// check validation start
var validationFn = function(paramPromNo, paramPromType, paramPromCode, paramStep) {

    /*
     ################       PromStepFreeItem Start ###############
     paramPromType
     paramPromNo
     paramPromCode
     paramStep
     
     FreeItemCode 1
     FreeQty 1
     FreeUnitCode 0
     FreeUnitFactor 0
     GLAccount 1
     
     ################       PromStepFreeItem End ###############
     
     */

    if ($("#FreeItemCode").val() == "") {
        alert("Free Item Code is not empty");
        return false;
    } else if ($("#FreeQty").val() == "") {
        alert("Free Qty is not empty");
        return false;

    } else if ($("#GLAccount").val() == "") {
        alert("GL Account is not empty");
        return false;
    } else {
        // insert to databse start
        insertDataFn(paramPromNo, paramPromType, paramPromCode, paramStep);
        // insert to database end
    }



};
// check validation end

// insert to databse start
var insertDataFn = function(paramPromNo, paramPromType, paramPromCode, paramStep) {

    /*	
     ################       PromStepFreeItem Start ###############
     paramPromType
     paramPromNo
     paramPromCode
     paramStep
     FreeItemCode
     FreeQty
     FreeUnitCode
     FreeUnitFactor
     GLAccount
     ################       PromStepFreeItem End ###############
     */

    $.ajax({
        url: "../Model/2-3-mAddFreeItemDiscountPromByItem.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode,
            "paramStep": paramStep, "paramFreeItemCode": $("#FreeItemCode").val(),
            "paramFreeQty": $("#FreeQty").val(), "paramFreeUnitCode": $("#FreeUnitCode").val(),
            "paramFreeUnitFactor": $("#FreeUnitFactor").val(), "paramGLAccount": $("#GLAccount").val(),
            "paramAction": $("#paramAction").val()},
        success: function(data) {
            //alert(data);

            if (data[0] == "save-success") {
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
            }

            if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว");
                clearFielddata();
                showAlldata();
                $("#submit").val("Add");
                $("#paramAction").val("add");

            }

        }
    });
};
// insert to database end



// show all  data start
var showAlldata = function(paramPromNo, paramPromType, paramPromCode, paramStep) {
    alert("show All here.");

    /*
     paramPromType
     paramPromNo
     paramPromCode
     */
    $.ajax({
        url: "../Model/2-3-mAddFreeItemDiscountPromByItem.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": paramStep},
        sync: false,
        success: function(data) {
            alert(data);

            $("#showAllData").html(data);

            // delete data start
            $(".btnDel").off("click");
            $(".btnDel").on("click", function() {
                var idDel = this.id.split("-");
                var id = idDel[1];
                $.ajax({
                    url: "../Model/2-3-mAddFreeItemDiscountPromByItem.php",
                    type: "POST",
                    dataType: "JSON",
                    data: {"paramAction": "delete", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
                    success: function(data) {
                        if (data[0] == "success") {
                            showAlldata(paramPromNo, paramPromType, paramPromCode, id);
                        }
                    }
                });

            });
            // delete data end
            
            
            // edit data start
            $(".btnEdit").on("click", function() {

                var idEdit = this.id.split("-");
                var id = idEdit[1];


                //show form start
                /*
                 $(".prodGroupForPromFrom").show();
                 $("h3.addPromGroup").show();
                 $("#submit").show();
                 $("#cancel").show();
                 */
                //show form end

                //add id for send to edit start

                $("#paramAction").val("editAction");

                //add id for send to edit end

                $.ajax({
                    url: "../Model/2-3-mPromStepDiscountPromByItem.php",
                    type: "POST",
                    dataType: "json",
                    data: {"paramAction": "edit", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
                    success: function(data) {
                        /*
                         ################       PromStep Start ###############
                         paramPromType
                         paramPromNo
                         paramPromCode
                         
                         paramStep0
                         paramMinimumSKU1
                         paramBreakQty2
                         paramBreakUnitCode3
                         paramBreakUnitFactor4
                         paramBreakAmt5
                         paramDiscPer6
                         paramDiscBaht7
                         paramPromStepNote8
                         ################       PromStep End ###############
                         */


                        //sequence
                        //PromCode BreakBy DiscFor LimitFreeQty FreeUnitCode LimitDiscBaht

                        //asign value into input text area start.



                        $("#Step").val("" + data[0] + "");
                        $("#MinimumSKU").val("" + data[1] + "");
                        $("#BreakQty").val("" + data[2] + "");
                        $("#BreakUnitCode").val("" + data[3] + "");
                        $("#BreakUnitFactor").val("" + data[4] + "");
                        $("#BreakAmt").val("" + data[5] + "");
                        $("#DiscPer").val("" + data[6] + "");
                        $("#DiscBaht").val("" + data[7] + "");
                        $("#PromStepNote").val("" + data[8] + "");


                        //asign value into input text area end.

                        //manage change everlopment for add insert
                        $("#submit").val("Edit");
                        $("#cancel").click(function() {

                            $("#submit").val("Add");
                            $("#paramAction").val("add");

                        });

                    }
                });

            });
            // edit data end




        }
    });
}
// show all data end



//cAddProdForPromGroup.js start
var callcAddFreeItemDiscountPromByItemFn = function(paramPromNo, paramPromCode, paramPromType, paramStep) {
    /*
     alert("paramPromNo"+paramPromNo);
     alert("paramPromCode"+paramPromCode);
     alert("paramPromType"+paramPromType);
     alert("paramStep"+paramStep);
     */

    $.ajax({
        url: "../Model/2-3-mAddFreeItemDiscountPromByItem.php",
        type: "post",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode, "paramStep": paramStep, "paramAction": "getDataPromStep"},
        dataType: "html",
        success: function(data) {

            $("#detailPromotion").html(data);

            //call showAllData start
            setTimeout(function() {
                alert("hello");
                //showAllData(paramPromNo,paramPromType,paramPromCode,paramStep);
            }, 1000);

            //call showAllData end

            //click submit start
            $("form#addFreeItem").submit(function() {

                // check validation start

                validationFn(paramPromNo, paramPromType, paramPromCode, paramStep);

                // check validation end

                return false;
            });

            //click submit end


            //back to prodGroupForProm start
            $("#back").click(function() {

                //$("#cProdGroupForProm").remove();

                //$(".Controller").remove();
                //$("head").append("<script class=\"Controller\" id=\"cDiscPromByItem\" type=\"text/javascript\" src=\"../Controller/cDiscPromByItem.js\"></script>");
                //callDiscPromByItemContentFn();



                var idArray = this.id.split("-");
                var paramPromCode = idArray[1];
                var paramPromNo = $("#paramProNo").text();
                //alert(id);

                $(".Controller").remove();
                $("head").append("<script class=\"Controller\" id=\"2-3-cPromStepDiscountPromByItem\" type=\"text/javascript\" src=\"../Controller/2-3-cPromStepDiscountPromByItem.js\"></script>");
                callcPromStepDiscountPromByItemFn(paramPromNo, paramPromCode);


            });
            //back to prodGroupForProm end
        }

    });

};
//callprodGroupForProm end
		