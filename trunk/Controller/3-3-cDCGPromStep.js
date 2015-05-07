
//count seq for check   
var countSeq = function(paramPromType, paramPromNo, paramPromCode, paramStep) {

    $.ajax({
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode, "paramStep": paramStep, "paramActionFreeItem": "countPromStepFreeItemSeq"},
        success: function(data) {
            var dataValue = 0;

            if (data == "") {
                $("#Seq").val("1");
            } else {
                dataValue = parseInt(data[0]) + 1;
                $("#Seq").val(parseInt(data[0]) + 1);
            }
            //alert("countStep");
        }
    });
};


// create FreeUnitCode  start

/*
 <select id="FreeUnitCode" name="FreeUnitCode">
 <option>Picece</option>
 <option>Pack</option>
 </select>
 
 */
/*
 var createFreeUnitCodeDropDown = function(FreeUnitCode){
 $.ajax({
 url:"../Model/mUnitCode.php",
 dataType:"json",
 success:function(data){
 
 var htmlDropDown="";
 htmlDropDown+="<select id=\"FreeUnitCode\" name=\"FreeUnitCode\">";
 $.each(data,function(index,indexEntry){
 
 if(FreeUnitCode==indexEntry[0]){
 //alert("ok");
 htmlDropDown+="<option selected value="+indexEntry[0]+">"+indexEntry[1]+"</option>";
 }else{
 htmlDropDown+="<option value="+indexEntry[0]+">"+indexEntry[1]+"</option>";
 }
 });
 htmlDropDown+="</select>";
 
 $("#FreeUnitCodeArea").html(htmlDropDown);
 
 
 
 
 }
 });
 }
 createFreeUnitCodeDropDown();
 */
// create FreeUnitCode end






// clear field   start
var clearFielddataAddFreeItem = function() {
    //#FreeItemCode
    //#FreeQty
    //#GLAccount
    $("#FreeItemCode").val("");
    $("#FreeQty").val("1");
    $("#GLAccount").val("");

//    createBrand();
    createItemCodeDropDown($("#brand").val());
    $("#itemName").removeAttr("readonly").css({"background": "white"});

    $("#submitFreeItem").val("Add");
    $("#paramActionFreeItem").val("add");

}
// clear field  end


//show hide form fn start
var showHideFormFnAddFreeItem = function() {
    $(".prodGroupForPromFrom").toggle();
    $("h3.addPromGroup").toggle();
    $("#submit").toggle();
    $("#cancel").toggle();
};
//show hide form fn end



// check validation start
var validationFnAddFreeItem = function(paramPromNo, paramPromType, paramPromCode, paramStep, paramSeq) {

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
        alert("กรุณาใส่ข้อมูล Free Item Code");
        return false;
    } else if ($("#FreeQty").val() == "") {
        alert("กรุณาใส่ข้อมูล Free Qty");
        return false;

    } else {
        // insert to databse start
        insertDataFnAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep, paramSeq);
        // insert to database end
        return false;
    }



};
// check validation end

// insert to databse start
var insertDataFnAddFreeItem = function(paramPromNo, paramPromType, paramPromCode, paramStep, paramSeq) {
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
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode,
            "paramStep": paramStep, "paramSeq": paramSeq, "paramFreeItemCode": $("#itemCode").val(),
            "paramFreeQty": $("#FreeQty").val(), "paramFreeUnitCode": $("#unitCode").val(),
            "paramFreeUnitFactor": $("#FreeUnitFactor").val(), "paramGLAccount": $("#GLAccount").val(),
            "paramActionFreeItem": $("#paramActionFreeItem").val()},
        success: function(data) {
            //alert(data);

            if (data[0] == "id-already") {
                alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");
            }

            if (data[0] == "save-success") {
                alert("บันทึกข้อมูลใหม่แล้ว");
                //createStep();
                clearFielddataAddFreeItem();
                showAlldataAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep);
                countSeq(paramPromType, paramPromNo, paramPromCode, paramStep);
            }

            if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว”");
                clearFielddataAddFreeItem();
                showAlldataAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep);
                $("#submitFreeItem").val("Add");
                $("#paramActionFreeItem").val("add");
                countSeq(paramPromType, paramPromNo, paramPromCode, paramStep);
            }

        }
    });
};

// insert to database end
var manangementActionFreeItem = function(paramPromType, paramPromNo, paramPromCode, paramStep) {

// delete data start
    $(".btnFreeItemDel").off("click");
    $(".btnFreeItemDel").on("click", function() {
        var idDel = this.id.split("-");
        var paramSeq = $(this).parent().parent().children().eq(0).text();
        var id = idDel[1];

        $.ajax({
            url: "../Model/3-3-mDCGPromStepFreeItem.php",
            type: "POST",
            dataType: "JSON",
            data: {
                "paramActionFreeItem": "checkUseItemFree",
                "paramPromType": paramPromType,
                "paramPromNo": paramPromNo,
                "paramPromCode": paramPromCode,
                "paramStep": paramStep,
                "paramSeq": paramSeq,
                "paramFreeItemCode": id
            },
            success: function(data) {
                if (data[0] === "id-already") {
                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/3-3-mDCGPromStepFreeItem.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                "paramActionFreeItem": "delete",
                                "paramPromType": paramPromType,
                                "paramPromNo": paramPromNo,
                                "paramPromCode": paramPromCode,
                                "paramStep": paramStep,
                                "paramSeq": paramSeq,
                                "paramFreeItemCode": id
                            },
                            success: function(data) {
                                if (data[0] == "success") {
                                    //alert("Delete is Success");
                                    showAlldataAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep);
                                    countSeq(paramPromType, paramPromNo, paramPromCode, paramStep);
                                }
                            }
                        });
                    }//confirm
                }
            }
        });
    });
// delete data end



// edit data start
    $(".btnFreeItemEdit").off("click");
    $(".btnFreeItemEdit").on("click", function() {

        var idEdit = this.id.split("-");
        var id = idEdit[1];
        var paramSeq = $(this).parent().parent().children().eq(0).text();

        //add id for send to edit start

        $("#paramActionFreeItem").val("editAction");

        //add id for send to edit end

        $.ajax({
            url: "../Model/3-3-mDCGPromStepFreeItem.php",
            type: "POST",
            dataType: "json",
            data: {"paramActionFreeItem": "edit", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": paramStep, "paramSeq": paramSeq, "paramFreeItemCode": id},
            success: function(data) {
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


                //sequence
                //PromCode BreakBy DiscFor LimitFreeQty FreeUnitCode LimitDiscBaht

                //asign value into input text area start.

                //FreeItemCode
                //FreeQty
                //FreeUnitCode
                //FreeUnitFactor
                //GLAccount



                //$("#FreeItemCode").val(""+data[0]+"");
                //createItemCodeDropDown("All",data[0]);
                //$("#itemName").val(data[5]);
                createItemCodeDropDown("All", data[0], "disable");
                //disable select item for edit start
                $("select#brand").prop("disabled", true);
                //disable select item for edit end
                $("#itemName").val(data[5]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});

                $("#FreeQty").val("" + data[1] + "");
                //$("#FreeUnitCode").val(""+data[2]+"");
                createUnitCodeDropDown(data[2]);
                //createFreeUnitCodeDropDown(data[2]);
                $("#FreeUnitFactor").val("" + data[3] + "");
                $("#GLAccount").val("" + data[4] + "");
                $("#Seq").val("" + data[6] + "");


                //calculate unit code for Free Unit Factor 	start
                $("#FreeQty").keyup(function() {

                    //alert($("#FreeQty").val());
                    //alert($("#unitCode").val());
                    calculateUnitFactor($("#FreeQty").val(), $("#unitCode").val(), $("#itemCode").val());

                });
                setTimeout(function() {
                    $("#unitCode").change(function() {
                        calculateUnitFactor($("#FreeQty").val(), $(this).val(), $("#itemCode").val());
                    });
                }, 1000);

                //calculate unit code for Free Unit Factor 	end


                //asign value into input text area end.

                //manage change everlopment for add insert
                $("#submitFreeItem").val("Save");
                $("#cancelFreeItem").click(function() {

                    $("#submitFreeItem").val("Add");
                    $("#paramActionFreeItem").val("add");

                    clearFielddataAddFreeItem();
                    countSeq(paramPromType, paramPromNo, paramPromCode, paramStep);

                });

            }
        });

    });
// edit data end

};


// show all  data start
var showAlldataAddFreeItem = function(paramPromNo, paramPromType, paramPromCode, paramStep) {

    /*
     paramPromType
     paramPromNo
     paramPromCode
     */
    $.ajax({
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        dataType: "html",
        data: {"paramActionFreeItem": "showData", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": paramStep},
        sync: false,
        success: function(data) {


            $("#showAllDataFreeItem").html(data);

            // biding grid method strat
            $("#grid2").kendoGrid({
                height: 250,
                sortable: true,
                pageable: false,
                columns: [
                    {field: "field1", width: '5%'},
                    {field: "field2", width: '15%'},
                    {field: "field3", width: '33%'},
                    {field: "field4", width: '10%'},
                    {field: "field5", width: '10%'},
                    {field: "field6", width: '12%'},
                    {field: "field7", width: '15%'}
                ]
            });
            setTable();
            $("table#grid2 tbody tr").each(function() {
                $("td", this).eq(0).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(3).css({"text-align": "right", "padding-rigth": "5px"});
            });
            //END: Set Table
            // biding grid method end


            //binding mangement function start
            manangementActionFreeItem(paramPromType, paramPromNo, paramPromCode, paramStep);

            //sorting start
            setTimeout(function() {
                $("#showAllDataFreeItem table thead th.k-header").on("click", function() {
                    setTable();
                    $("table#grid2 tbody tr").each(function() {
                        $("td", this).eq(0).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(3).css({"text-align": "right", "padding-rigth": "5px"});
                    });
                    //END: Set Table
                    manangementActionFreeItem(paramPromType, paramPromNo, paramPromCode, paramStep);
                });
            }, 1000);
        }
    });
}
// show all data end

var calculateUnitFactor = function(FreeQty, UnitCode, paramPromCode) {


    $.ajax({
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        data: {"paramPromCode": paramPromCode,
            "paramUnitCode": UnitCode,
            "paramActionFreeItem": "getDataUnitFactor"},
        dataType: "json",
        sync: false,
        success: function(data) {

            var result;
            if (data[0] == "") {
                result = 0;
            } else {
                result = parseInt(data[0]);
            }


            $("#FreeUnitFactor").val(result);
        }
    });

    //alert(result);

    //result=parseInt(unitCode)*parseInt(UnitFactor);
    //return result;
};

//cAddProdForPromGroup.js start
var callcAddFreeItemDiscountPromByItemFn = function(paramPromNo, paramPromCode, paramPromType, paramStep) {
    /*
     alert("paramPromNo"+paramPromNo);
     alert("paramPromCode"+paramPromCode);
     alert("paramPromType"+paramPromType);
     alert("paramStep"+paramStep);
     */

    $.ajax({
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode, "paramStep": paramStep, "paramActionFreeItem": "getDataPromStep"},
        dataType: "html",
        sync: false,
        success: function(data) {
            setTimeout(function() {

                $("#detailPromotion").html(data);

                //call showAllData start

                //alert("hello");
                showAlldataAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep);

                //binding method bran itemcode,itemname start
                createBrandFreeItem(); //createBrand();
                createUnitCodeDropDown();
                countSeq(paramPromType, paramPromNo, paramPromCode, paramStep);
                //binding method bran itemcode,itemname end
                //calculate unit code for Free Unit Factor 	start
                $("#FreeQty").keyup(function() {
                    //alert($("#FreeQty").val());
                    //alert($("#unitCode").val());
                    //alert($("#itemCode").val());
                    calculateUnitFactor($("#FreeQty").val(), $("#unitCode").val(), $("#itemCode").val());
                });
                setTimeout(function() {
                    $("#unitCode, #itemCode").change(function() {
                        calculateUnitFactor($("#FreeQty").val(), $("#unitCode").val(), $("#itemCode").val());
                    });
                }, 1000);

                //calculate unit code for Free Unit Factor 	end

                //call showAllData end

                //click submit start
                $("form#addFreeItem").off("submit");
                $("form#addFreeItem").on("submit", function() {
                    //alert("sumit");
                    // check validation start
                    var paramSeq = $("#Seq").val();
                    validationFnAddFreeItem(paramPromNo, paramPromType, paramPromCode, paramStep, paramSeq);

                    // check validation end
                    return false;
                });
                //click submit end
            }, 500);	//setTimeout here.	
        }
    });
};
//callprodGroupForProm end

/*#############################################################################################################################################*/
/*#############################################################################################################################################*/
/*#############################################################################################################################################*/

// create brand  start


var calculateBreakUnitFactor = function(Qty, UnitCode, paramPromCode) {


    $.ajax({
        url: "../Model/3-3-mDCGPromStepFreeItem.php",
        type: "post",
        data: {"paramPromCode": paramPromCode, "paramUnitCode": UnitCode, "paramActionFreeItem": "getDataUnitFactor"},
        dataType: "json",
        sync: false,
        success: function(data) {
            var result;
            if (data[0] == "") {
                result = 0;
            } else {
                result = parseInt(data[0]);
            }


            $("#BreakUnitFactor").val(result);
        }
    });

    //alert(result);

    //result=parseInt(unitCode)*parseInt(UnitFactor);
    //return result;
};

// create createUnitCodeBreakDropDown  start


var createUnitCodeBreakDropDown = function(unitCode) {

    $.ajax({
        url: "../Model/mUnitCode.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"breakUnitCode\" name=\"breakUnitCode\">";
            $.each(data, function(index, indexEntry) {
                if (unitCode == indexEntry[0]) {

                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                } else if (indexEntry[0] == "PCS") {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#breakUnitCodeArea").html(htmlDropDown);

            }, 100);
            //alert(htmlBrand);

        }
    });
};

// create createUnitCodeBreakDropDown end


var countStep = function(paramPromType, paramPromNo, paramPromCode) {

    $.ajax({
        url: "../Model/3-3-mDCGPromStep.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode, "paramAction": "countPromStep"},
        success: function(data) {
            //alert(data[0]);
            setTimeout(function() {
                $("#Step").val(parseInt(data[0]) + 1);
            });

            //alert("countStep");
        }
    });
};




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
}
// create discount for dropdown  end





// clear field   start
var clearFielddata = function() {

    //Step
    //PromStepNote
    //MinimumSKU
    //BreakAmt
    //DiscBaht
    $("#PromStepNote").val("");
    $("#BreakAmt").val("0");
    $("#DiscBaht").val("0");
    $("#BreakQty").val("0");
    $("#BreakUnitFactor").val("1");
    $("#DiscPer").val("0");
    $("#MinimumSKU").val("0");
    $("#unitCode").val("PCS");

    $("#submit").val("Add");
    $("#paramAction").val("add");
    //$(".inputData").val("");


}
// clear field  end





// check validation start
var validationFn = function(paramPromNo, paramPromType, paramPromCode) {
    /*
     Step
     MinimumSKU
     PromStepNote
     
     */
    if ($("#BreakQty").val() == "") {
        $("#BreakQty").val(0);
    } else if ($("#PromStepNote").val() == "") {
        alert("กรุณาใส่ข้อมูล Promotion Step Note");
    } else {
        insertDataFn(paramPromNo, paramPromType, paramPromCode);
    }
    /*
     if($("#Step").val()==""){
     alert("กรุณาใส่ข้อมูล Step");
     return false;
     }else if($("#MinimumSKU").val()==""){
     alert("กรุณาใส่ข้อมูล Minimum SKU");
     return false;
     
     }else{
     // insert to databse start
     insertDataFn(paramPromNo,paramPromType,paramPromCode);
     // insert to database end
     }
     */



};
// check validation end

// insert to databse start
var insertDataFn = function(paramPromNo, paramPromType, paramPromCode) {

    /*	
     
     ################       PromStep Start ###############
     
     PromType
     PromNo
     PromCode
     Step
     MinimumSKU
     BreakQty
     BreakUnitCode
     BreakUnitFactor
     BreakAmt
     DiscPer
     DiscBaht
     PromStepNote
     
     ################       PromStep End ###############
     */

    $.ajax({
        url: "../Model/3-3-mDCGPromStep.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo,
            "paramPromType": paramPromType,
            "paramPromCode": paramPromCode,
            "paramStep": $("#Step").val(),
            "paramMinimumSKU": $("#MinimumSKU").val(),
            "paramBreakQty": $("#BreakQty").val(),
            "paramBreakUnitCode": $("#breakUnitCode").val(),
            "paramBreakUnitFactor": $("#BreakUnitFactor").val(),
            "paramBreakAmt": $("#BreakAmt").val(),
            "paramDiscPer": $("#DiscPer").val(),
            "paramDiscBaht": $("#DiscBaht").val(),
            "paramPromStepNote": $("#PromStepNote").val(),
            "paramAction": $("#paramAction").val()
        },
        success: function(data) {
            //alert(data);

            if (data[0] == "id-already") {
                alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");

            }
            if (data[0] == "save-success") {
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                countStep(paramPromType, paramPromNo, paramPromCode);
            }

            if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว");
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                countStep(paramPromType, paramPromNo, paramPromCode);
                $("#submit").val("Add");
                $("#paramAction").val("add");

            }

        }
    });
};
// insert to database end
var manangementAction = function(paramPromType, paramPromNo, paramPromCode) {

    // delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {
        var idDel = this.id.split("-");

        var id = idDel[1];

        $.ajax({
            url: "../Model/3-3-mDCGPromStep.php",
            type: "POST",
            dataType: "JSON",
            data: {"paramAction": "checkUseProm", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
            success: function(data) {
                if (data[0] == "id-already") {

                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");

                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/3-3-mDCGPromStep.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {"paramAction": "delete", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
                            success: function(data) {
                                if (data[0] == "success") {
                                    showAlldata(paramPromNo, paramPromType, paramPromCode);
                                    clearFielddata();
                                    countStep(paramPromType, paramPromNo, paramPromCode);
                                }
                            }
                        });

                    }


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
            url: "../Model/3-3-mDCGPromStep.php",
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
                $("#submit").val("Save");
                $("#cancel").on("click", function() {
                    $("#submit").val("Add");
                    $("#paramAction").val("add");
                    clearFielddata();
                    countStep(paramPromType, paramPromNo, paramPromCode);
                });
            }
        });
    });
    // edit data end


    //promotion step start
    $(".btnAddFreeItem").click(function() {
        var idArray = this.id.split("-");
        var id = idArray[1];
        //alert(id);
        //$(".Controller").remove();
        //$("head").append("<script class=\"Controller\" id=\"2-3-cAddFreeItemDiscountPromByItem\" type=\"text/javascript\" src=\"../Controller/2-3-cAddFreeItemDiscountPromByItem.js\"></script>");
        callcAddFreeItemDiscountPromByItemFn(paramPromNo, paramPromCode, paramPromType, id);
    });
    //promotion step end

};


// show all  data start
var showAlldata = function(paramPromNo, paramPromType, paramPromCode) {
    //alert("show All here.");

    /*
     paramPromType
     paramPromNo
     paramPromCode
     */
    $.ajax({
        url: "../Model/3-3-mDCGPromStep.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode},
        sync: false,
        success: function(data) {
            //alert(data);
            $("#showAllData").html(data);

            // biding grid method strat
            $("#grid1").kendoGrid({
                sortable: true,
                scrollable: true,
                pageable: {
                    refresh: false,
                    pageSizes: false,
                    buttonCount: 5
                },
                dataSource: {
                    pageSize: 100
                },
                height: 350,
                columns: [
                    {field: "field1", width: '10%'},
                    {field: "field2", width: '10%'},
                    {field: "field3", width: '20%'},
                    {field: "field4", width: '5%'},
                    {field: "field5", width: 'auto'},
                    {field: "field6", width: 'auto'},
                    {field: "field7", width: 'auto'},
                    {field: "field8", width: 'auto'},
                    {field: "field9", width: '20%'}
                ]
            });
            //START: Set Table
            setTable();
            $("table#grid1 tbody tr").each(function() {
                $("td", this).eq(3).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(5).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(6).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(7).css({"text-align": "right", "padding-rigth": "5px"});
            });
            //END: Set Table
            // biding grid method end


            //binding mangement function start
            manangementAction(paramPromType, paramPromNo, paramPromCode);

            //sorting start
            setTimeout(function() {
                $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    $("table#grid1 tbody tr").each(function() {
                        $("td", this).eq(3).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(5).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(6).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(7).css({"text-align": "right", "padding-rigth": "5px"});
                    });
                    //END: Set Table
                    manangementAction(paramPromType, paramPromNo, paramPromCode);
                });
            }, 1000);
        }
    });
}
// show all data end


//cAddProdForPromGroup.js start
var callDCGPromStepFn = function(paramPromNo, paramPromCode, paramPromType) {

    $(".embParam").remove();
    $("body").append("<input type=\"hidden\" id=\"embPromNo\" class=\"embParam\" value=" + paramPromNo + ">");

    $.ajax({
        url: "../View/3-3-vDCGPromStep.php",
        type: "post",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramPromCode": paramPromCode},
        dataType: "html",
        sync: false,
        success: function(data) {
            $("#content").html(data);
            //call showAllData start
            showAlldata(paramPromNo, paramPromType, paramPromCode);
            //call showAllData end
            //binding Unit Code Break Start.
            createUnitCodeBreakDropDown();
            //Binning Unit Code Break End.
            //calculate unit code for Free Unit Factor 	start
            $("#BreakQty").keyup(function() {

                //alert($("#FreeQty").val());
                //alert($("#unitCode").val());
                calculateBreakUnitFactor($("#BreakQty").val(), $("#breakUnitCode").val(), paramPromCode);

            });
            setTimeout(function() {
                $("#breakUnitCode").change(function() {
                    calculateBreakUnitFactor($("#BreakQty").val(), $(this).val(), paramPromCode);
                });
            }, 1000);

            //calculate unit code for Free Unit Factor 	end



            /*click submit start*/
            $("form#addStepDiscountProm").submit(function() {

                // check validation start
                validationFn(paramPromNo, paramPromType, paramPromCode);
                // check validation end

                return false;
            });

            /*click submit end*/

            /*check number in text field before press submit start*/
            $("#BreakAmt").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#DiscPer").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#limitFreeQty").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#limitDiscBath").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#BreakQty").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
            $("#DiscBaht").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            /*check number in text field before press submit end*/



            //back to prodGroupForProm start
            $("#back").click(function() {

                //$("#cProdGroupForProm").remove();
                /*
                 $(".Controller").remove();
                 $("head").append("<script class=\"Controller\" id=\"cDiscPromByItem\" type=\"text/javascript\" src=\"../Controller/cDiscPromByItem.js\"></script>");
                 callDiscPromByItemContentFn();
                 */

                $(".Controller").remove();
                $("head").append("<script class=\"Controller\" id=\"cDCGPromItem\" type=\"text/javascript\" src=\"../Controller/3-2-cDCGPromItem.js\"></script>");
                callDCGPromItemFn($("#embPromNo").val(), paramPromType);

                return false;

            });
            //back to prodGroupForProm end
        }
    });
};
//callprodGroupForProm end






/*#############################################################################################################################################*/
/*#############################################################################################################################################*/
/*#############################################################################################################################################*/
