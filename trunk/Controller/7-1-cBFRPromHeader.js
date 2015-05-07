
/*
 ####################################################################
 Free Item management start
 ####################################################################
 */
// create unit code Free  start

/*
 
 <select id="unitCode" name="unitCode">
 <option value="Piece">Piece</option>
 <option value="Pack">Pack</option>
 </select>
 
 */
// create unit code  start

/*
 
 <select id="unitCode" name="unitCode">
 <option value="Piece">Piece</option>
 <option value="Pack">Pack</option>
 </select>
 
 */

var createUnitCodeFreeDropDown = function(unitCode) {
    //alert("createUnitCodeDropDown");
    $.ajax({
        url: "../Model/mUnitCode.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"unitCodeFree\" name=\"unitCode\" style=\"height:26px;\">";
            $.each(data, function(index, indexEntry) {
                if (unitCode == indexEntry[0]) {

                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#unitCodeFreeArea").html(htmlDropDown);
                //alert("#unitCodeArea");
            }, 100);
            //alert(htmlBrand);
        }
    });
};
// create unit code Free end


//count seq for check   
var countSeq = function(paramPromType, paramPromNo, paramStep) {

    $.ajax({
        url: "../Model/7-3-mBFRPromBundleFreeItem.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramStep": paramStep, "paramActionFreeItem": "countPromStepFreeItemSeq"},
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


// clear field   start
var clearFielddataAddFreeItem = function() {
    //#FreeItemCode
    //#FreeQty
    //#GLAccount
    $("#FreeItemCode").val("");
    $("#FreeQty").val("0");
    $("#GLAccount").val("");
    $("#PromStepNote").val("");
    $("#unitCode").val("PCS");
    $("#FreeUnitFactor").val("1");

    $("#brand").removeAttr('disabled');
    $("#itemCode").removeAttr('disabled');
    $("#itemName").removeAttr('readonly');
    $("#freeStep").val("").removeAttr('readonly');

    createUnitCodeFreeDropDown();
    //createBrand();
    //createItemCodeDropDown("All");
};
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
var validationFnAddFreeItem = function(paramPromNo, paramPromType, paramFreeItemCode, paramStep, paramSeq) {

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
    if ($("#freeStep").val() == "") {
        alert("กรุณาใส่ข้อมูล Step");
        return false;

    } else if ($("#FreeQty").val() == "") {
        alert("กรุณาใส่ข้อมูล Free Qty");
        return false;

    } else {

        // insert to databse start

        insertDataFnAddFreeItem(paramPromNo, paramPromType, paramFreeItemCode, paramStep, paramSeq);
        // insert to database end
        return false;
    }



};
// check validation end

// insert to databse start
var insertDataFnAddFreeItem = function(paramPromNo, paramPromType, paramFreeItemCode, paramStep, paramSeq) {

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
        url: "../Model/7-3-mBFRPromBundleFreeItem.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType,
            "paramStep": paramStep, "paramSeq": paramSeq, "paramFreeItemCode": paramFreeItemCode,
            "paramFreeQty": $("#FreeQty").val(), "paramFreeUnitCode": $("#unitCodeFree").val(),
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
                showAlldataAddFreeItem(paramPromNo, paramPromType);
                //countSeq(paramPromType,paramPromNo,paramStep);
            }

            if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว”");
                clearFielddataAddFreeItem();
                showAlldataAddFreeItem(paramPromNo, paramPromType);
                $("#submitFreeItem").val("Add");
                $("#paramActionFreeItem").val("add");
                //countSeq(paramPromType,paramPromNo,paramPromCode,paramStep);
            }
            return false;
        }
    });
};
// insert to database end



var manangementActionFreeItem = function(paramPromType, paramPromNo) {

// delete data start
    $(".btnFreeItemDel").off("click");
    $(".btnFreeItemDel").on("click", function() {
        var idDel = this.id.split("-");
        var paramFreeItemCode = idDel[1];
        var paramSeq = $(this).parent().parent().children().eq(1).text();
        var paramStep = $(this).parent().parent().children().eq(0).text();
        var id = idDel[1];

        $.ajax({
            url: "../Model/7-3-mBFRPromBundleFreeItem.php",
            type: "POST",
            dataType: "JSON",
            data: {
                "paramActionFreeItem": "checkUseItemFree",
                "paramPromType": paramPromType,
                "paramPromNo": paramPromNo,
                "paramStep": paramStep,
                "paramSeq": paramSeq,
                "paramFreeItemCode": paramFreeItemCode
            },
            success: function(data) {
                if (data[0] === "id-already") {
                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/7-3-mBFRPromBundleFreeItem.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                "paramActionFreeItem": "delete",
                                "paramPromType": paramPromType,
                                "paramPromNo": paramPromNo,
                                "paramStep": paramStep,
                                "paramSeq": paramSeq,
                                "paramFreeItemCode": paramFreeItemCode
                            },
                            success: function(data) {
                                if (data[0] == "success") {
                                    //alert("Delete is Success");
                                    showAlldataAddFreeItem(paramPromNo, paramPromType);
                                    countSeq();
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
        var paramFreeItemCode = idEdit[1];
        var paramSeq = $(this).parent().parent().children().eq(1).text();
        var paramStep = $(this).parent().parent().children().eq(0).text();


        //add id for send to edit start

        $("#paramActionFreeItem").val("editAction");
        //add id for send to edit end
        $.ajax({
            url: "../Model/7-3-mBFRPromBundleFreeItem.php",
            type: "POST",
            dataType: "json",
            data: {"paramActionFreeItem": "edit", "paramPromType": paramPromType, "paramPromNo": paramPromNo,
                "paramStep": paramStep, "paramFreeItemCode": paramFreeItemCode, "paramSeq": paramSeq},
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
                $("#freeStep").val(data[6]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});
                ;
                $("#Seq").val(data[7]);
                $("#FreeQty").val("" + data[1] + "");
                //$("#FreeUnitCode").val(""+data[2]+"");
                createUnitCodeFreeDropDown(data[2]);
                //createFreeUnitCodeDropDown(data[2]);
                $("#FreeUnitFactor").val("" + parseInt(data[3]) + "");
                $("#GLAccount").val("" + data[4] + "");

                //$("#Seq").val(""+data[6]+"");
                //
                //calculate unit code for Free Unit Factor 	start
                $("#FreeQty").keyup(function() {
                    //alert($("#FreeQty").val());
                    //alert($("#unitCode").val());
                    calculateUnitFactor($("#FreeQty").val(), $("#unitCode").val(), $("#itemCode").val());
                });
                setTimeout(function() {
                    $("#unitCodeFree, #itemCode").change(function() {
                        calculateUnitFactor($("#FreeQty").val(), $("#unitCodeFree").val(), $("#itemCode").val());
                    });
                }, 1000);

                //calculate unit code for Free Unit Factor 	end


                //asign value into input text area end.

                //manage change everlopment for add insert
                $("#submitFreeItem").val("Edit");
                $("#cancelFreeItem").off("click");
                $("#cancelFreeItem").on("click", function() {

                    $("#submitFreeItem").val("Add");
                    $("#paramActionFreeItem").val("add");

                    clearFielddataAddFreeItem();
                    countSeq(paramPromType, paramPromNo, paramStep);

                });
            }
        });
    });
    // edit data end
};


// show all  data start
var showAlldataAddFreeItem = function(paramPromNo, paramPromType) {
    /*
     paramPromType
     paramPromNo
     paramPromCode
     */
    $.ajax({
        url: "../Model/7-3-mBFRPromBundleFreeItem.php",
        type: "post",
        dataType: "html",
        data: {"paramActionFreeItem": "showData", "paramPromType": paramPromType, "paramPromNo": paramPromNo},
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
                    {field: "field2", width: '5%'},
                    {field: "field3", width: '13%'},
                    {field: "field4", width: '30%'},
                    {field: "field5", width: '%'},
                    {field: "field6", width: '%'},
                    {field: "field7", width: '%'},
                    {field: "field8", width: '13%'}
                ]
            });
            setTable();
            $("table#grid2 tbody tr").each(function() {
                $("td", this).eq(1).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(0).css({"text-align": "right", "padding-rigth": "5px"});
            });
            // biding grid method end


            //binding mangement function start
            manangementActionFreeItem(paramPromType, paramPromNo);

            //sorting start
            setTimeout(function() {
                $("#showAllDataFreeItem table thead th.k-header").on("click", function() {
                    setTable();
                    $("table#grid2 tbody tr").each(function() {
                        $("td", this).eq(1).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(0).css({"text-align": "right", "padding-rigth": "5px"});
                    });

                    manangementActionFreeItem(paramPromType, paramPromNo);
                });
            }, 1000);
        }
    });
};
// show all data end


var calculateUnitFactor = function(FreeQty, UnitCode, paramFreeItemCode) {


    $.ajax({
        url: "../Model/7-3-mBFRPromBundleFreeItem.php",
        type: "post",
        data: {"paramFreeItemCode": paramFreeItemCode, "paramUnitCode": UnitCode, "paramActionFreeItem": "getDataUnitFactor"},
        dataType: "json",
        sync: false,
        success: function(data) {

            result = parseInt(data[0]);

            $("#FreeUnitFactor").val(result);
        }
    });

    //alert(result);

    //result=parseInt(unitCode)*parseInt(UnitFactor);
    //return result;
};

//cAddProdForPromGroup.js start
var callcAddFreeItemDiscountPromByItemFn = function(paramPromNo, paramPromType, paramStep) {
    //alert("callcAddFreeItemDiscountPromByItemFn");
    /*
     alert("paramPromNo"+paramPromNo);
     alert("paramPromCode"+paramPromCode);
     alert("paramPromType"+paramPromType);
     alert("paramStep"+paramStep);
     */

    $.ajax({
        url: "../Model/7-3-mBFRPromBundleFreeItem.php",
        type: "post",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramStep": paramStep, "paramActionFreeItem": "getDataPromStep"},
        dataType: "html",
        sync: false,
        success: function(data) {
            setTimeout(function() {

                $("#promNoArea").html(data);

                //call showAllData start

                showAlldataAddFreeItem(paramPromNo, paramPromType);
                //binding method bran itemcode,itemname start
                createBrandFreeItem();  //createBrand();
                createUnitCodeFreeDropDown();


                //Get value step  start
                $("#freeStep").keyup(function() {
                    //alert($(this).val());
                    var pramStep = $(this).val();
                    countSeq(paramPromType, paramPromNo, pramStep);
                });
                //Get value step end


                //binding method bran itemcode,itemname end

                //check number in text field before press submit start
                $("#FreeQty").keyup(function() {
                    this.value = this.value.replace(/[^0-9\.]/g, '');
                });
                $("#freeStep").keyup(function() {
                    this.value = this.value.replace(/[^0-9\.]/g, '');
                });

                //check number in text field before press submit end
                //calculate unit code for Free Unit Factor 	start
//                $("#FreeQty").keyup(function() {
//
//                    //alert($("#FreeQty").val());
//                    //alert($("#unitCode").val());
//                    calculateUnitFactor($("#FreeQty").val(), $("#unitCode").val(), $("#itemCode").val());
//
//                });
                setTimeout(function() {
                    $("#unitCodeFree, #itemCode").change(function() {
                        calculateUnitFactor($("#FreeQty").val(), $("#unitCodeFree").val(), $("#itemCode").val());
                    });
                }, 500);

                //calculate unit code for Free Unit Factor 	end


                //call showAllData end

                //click submit start
                $("form#addFreeItem").off("submit");
                $("form#addFreeItem").on("submit", function() {
                    //alert("sumit");
                    // check validation start
                    var paramStep = $("#freeStep").val();
                    var paramFreeItemCode = $("#itemCode").val();
                    var paramSeq = $("#Seq").val();
                    /*
                     alert("paramPromNo="+paramPromNo);
                     alert("paramPromType="+paramPromType);
                     alert("paramFreeItemCode="+paramFreeItemCode);
                     alert("paramStep="+paramStep);
                     alert("paramSeq="+paramSeq);
                     */

                    validationFnAddFreeItem(paramPromNo, paramPromType, paramFreeItemCode, paramStep, paramSeq);
                    // check validation end

                    return false;
                });
                //click submit end
            }, 500);	//setTimeout here.
        }
    });
};
//callprodGroupForProm end
/*
 ####################################################################################################
 ####################################################################################################
 ####################################################################################################
 */


// create salesTeam dropdown start

/*
 <select class="multiSelect" id="salesTeam" multiple="multiple">
 <option value="All">All Sales Team</option>
 <option value="A">Sales Team A</option>
 <option value="B">Sales Team B</option>
 <option value="C">Sales Team C</option>
 </select>
 */

var defaultDateInputText = function() {
//binding date start 01 of month for start date.

    var today = new Date();
    //new Date(year, month, day, hours, minutes, seconds, milliseconds) 
    var day = today.getDate();
    var year = today.getFullYear();
    var month = today.getMonth() + 1;


    var startDate = year + "-01-01";
    var endDate = year + "-" + checkNumberForDatePickerMonth(month) + "-" + checkNumberForDatePickerDay(day);
    $("#StartDateSearch").val(startDate);
    $("#StartDate").val(startDate);


//binding date start 01 of month for start date.

//binding date current data for end date.
    $("#EndDateSearch").val(endDate);
    $("#EndDate").val(endDate);

//binding date current data for end date.


}


//##################  group code gernarate for search stat here. ################

//search auto complte start
var searchAutoCompltePromDesc = function(id, defaultText, paramPromType) {
    $.ajax({
        url: "../Model/7-1-mBFRPromHeader.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramAction": "searchPromNo", "paramPromType": paramPromType},
        success: function(data) {
            //alert(data[1]);
            /*
             Format
             [
             "Albania",
             "Andorra",
             "Armenia"
             ]
             */
            var formatAutoComplte = "[";
            $(data).each(function(index, indexEntry) {
                //alert(indexEntry[1]);
                if (index == 0) {
                    formatAutoComplte += "\"" + indexEntry[1] + "\"";
                } else {
                    formatAutoComplte += ",\"" + indexEntry[1] + "\"";
                }
            });
            formatAutoComplte += "]";
            var objFormatAutoComplte = eval("(" + formatAutoComplte + ")");
            $("td#promDescSearchArea").html("<input name=\"promDescSearch\"  id=\"promDescSearch\" type=\"text\" />");
            createAutocomplete(id, objFormatAutoComplte, defaultText);
            /*click item name for get group code start*/
            var k = 0;
            $("#promDescSearch").off("change");
            $("#promDescSearch").on("change", function() {
                $.ajax({
                    url: "../Model/mDiscPromByItem.php",
                    type: "post",
                    dataType: "json",
                    data: {"paramPromDesc": $("#promDescSearch").val(), "paramAction": "searchPromDesc", "paramPromType": paramPromType},
                    sync: false,
                    success: function(data) {
                        //create  prom no droup down start
                        //createPromNoSearchDropDown(paramPromType);
                        createPromNoSearchDropDown(paramPromType, data[0][0]);
                        //create  prom no droup down end
                    }
                });

            });
            /*click item name for get group start*/
        }
    });
};
//search auto complte end	


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


    if (discountFor == "P") {
        $("tr#DiscountPercentArea").show();
        $("tr#DiscountBathArea").hide();
        //$("#DiscPer").val("0");
        $("#DiscBaht").val("0");
    } else {
        $("tr#DiscountPercentArea").hide();
        $("tr#DiscountBathArea").show();
        $("#DiscPer").val("0");
        //$("#DiscBaht").val("0");
    }



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
            htmlDropDown += " (B-Baht P-Percent) ";
            setTimeout(function() {
                $("#disCountForArea").html(htmlDropDown);
                /*###################   Event change select Droepdown Discount For  Start here...#####################*/
                disCountForChangeFn();
                /*###################   Event change select Droepdown Discount For  end here...#####################3*/
            }, 100);
            //alert(htmlDropDown);

        }
    });
}
// create discount for dropdown  end



/*
 <select class="form-control input-sm">
 <option>All</option>
 <option>DE5233</option>
 </select>
 */

var createPromNoSearchDropDown = function(paramPromType, paramPromNo) {

    $.ajax({
        url: "../Model/7-1-mBFRPromHeader.php",
        dataType: "json",
        type: "post",
        data: {"paramAction": "searchPromNo", "paramPromType": paramPromType},
        sync: false,
        success: function(data) {

            var htmlDropDown = "";

            htmlDropDown += "<select class=\"form-control input-sm\" id=\"promNoSearch\" name=\"promNoSearch\">";
            htmlDropDown += "<option selected value=All>All-All</option>";
            $.each(data, function(index, indexEntry) {

                if (paramPromNo == indexEntry[0]) {

                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                }

            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#promNoSearchArea").html(htmlDropDown);

                //group code start
                $("#promNoSearch").change(function() {
                    //alert($(this).val());

                    $.ajax({
                        url: "../Model/7-1-mBFRPromHeader.php",
                        type: "post",
                        dataType: "json",
                        data: {"paramPromNo": $(this).val(), "paramAction": "promNoSearch", "paramPromNoSearch": $("#promNoSearch").val()},
                        success: function(data) {
                            //alert(data[1]);
                            $("#promDescSearch").val(data[1]);
                        }
                    });


                });


            }, 100);

            //alert(htmlBrand);

        }
    });
}


//##################  group code gernarate for search end here. ################



var createSalesTeamDropDown = function(SalesTeamCode) {


    //$("#salesTeam").multiselect("enable");

    var htmlDropDownArray = new Array();
    $.ajax({
        url: "../Model/mSalesTeam.php",
        dataType: "json",
        success: function(data) {
            var htmlData = "";
            htmlData += "<select class=\"multiSelect\" id=\"salesTeam\" multiple=\"multiple\">";
            $.each(data, function(index, indexEntry) {
                if (indexEntry[0] != "All") {
                    htmlDropDownArray[index] = "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
                //check branchCode sent or not
                if (SalesTeamCode) {

                    $.each(SalesTeamCode, function(index2, indexEntry2) {

                        if (indexEntry2 == indexEntry[0]) {
                            if (indexEntry2 != "All") {
                                htmlDropDownArray[index] = "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                            }
                        }
                    });
                }//check branchCode sent or not

            });
            htmlData += htmlDropDownArray;
            htmlData += "</select>";

            $("#salesTeamArea").html(htmlData);
            //alert(htmlData);

            setTimeout(function() {
                //binding multi select start
                if (SalesTeamCode[0] == "All") {
                    $(".multiSelect").multiselect();
                    $("#salesTeam").multiselect("disable");
                    $("#salesTeamsAll").prop("checked", true);
                    //alert("SalesTeamCode[0]"+SalesTeamCode[0]);
                } else {
                    $(".multiSelect").multiselect();
                    $("#salesTeamsAll").prop("checked", false);
                }
                $(".ui-multiselect").css({"width": "150px"});
                //binding multi select end
            }, 100);
        }
    });





};



// create salesTeam dropdown start


// create brach dropdown start

/*
 <select class="multiSelect" id="branch">
 <option>All Branch</option>
 <option>Branch0</option>
 <option>Branch1</option>
 </select>
 */
var createBrach = function(branchCode) {
    var htmlDropDownArray = new Array();

    $.ajax({
        url: "../Model/mBranch.php",
        dataType: "json",
        success: function(data) {
            var htmlBrach = "";
            htmlBrach += "<select class=\"multiSelect\" id=\"branch\" multiple=\"multiple\">";
            $.each(data, function(index, indexEntry) {
                if (indexEntry[0] != "All") {
                    htmlDropDownArray[index] = "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
                //check branchCode sent or not
                if (branchCode) {

                    $.each(branchCode, function(index2, indexEntry2) {

                        if (indexEntry2 == indexEntry[0]) {
                            if (indexEntry2 != "All") {
                                htmlDropDownArray[index] = "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                            }
                        }
                    });
                }//check branchCode sent or not

            });
            htmlBrach += htmlDropDownArray;
            htmlBrach += "</select>";
            $("#branchArea").html(htmlBrach);
            //alert(htmlBrach);

            setTimeout(function() {
                //binding multi select start
                if (branchCode[0] == "All") {
                    $(".multiSelect").multiselect();
                    $("#branch").multiselect("disable");
                    $("#branchAll").prop("checked", true);
                    //alert("SalesTeamCode[0]"+SalesTeamCode[0]);
                } else {
                    $(".multiSelect").multiselect();

                    //$("#branchAll").attr({"checked":""});
                    $("#branchAll").prop("checked", false);
                }
                $(".ui-multiselect").css({"width": "150px"});
                //binding multi select end
            }, 100);
        }
    });
}


// create brach dropdown end


// create Sales Type  start

/*
 
 <select class="multiSelect" id="shopType">
 <option>All ShopType</option>
 <option>Shop Type</option>
 <option>Shop Type</option>
 </select>
 
 */

var createShopTypeDropDown = function(shopTypeCode) {
    var htmlDropDownArray = new Array();
    //alert(itemCode);
    $.ajax({
        url: "../Model/mShopType.php",
        dataType: "json",
        success: function(data) {

            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select class=\"multiSelect\" id=\"shopType\" multiple=\"multiple\">";
            $.each(data, function(index, indexEntry) {
                if (indexEntry[0] != "All") {
                    htmlDropDownArray[index] = "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
                //check branchCode sent or not
                if (shopTypeCode) {

                    $.each(shopTypeCode, function(index2, indexEntry2) {

                        if (indexEntry2 == indexEntry[0]) {
                            if (indexEntry2 != "All") {
                                htmlDropDownArray[index] = "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                            }
                        }
                    });
                }//check branchCode sent or not

            });
            htmlDropDown += htmlDropDownArray;
            htmlDropDown += "</select>";


            setTimeout(function() {
                //alert(htmlDropDown);
                $("#shopTypeArea").html(htmlDropDown);
                //binding multi select start
                if (shopTypeCode[0] == "All") {
                    $(".multiSelect").multiselect();
                    $("#shopType").multiselect("disable");
                    $("#shopTypeAll").prop("checked", true);
                    //alert("SalesTeamCode[0]"+SalesTeamCode[0]);
                } else {
                    $(".multiSelect").multiselect();
                    $("#shopTypeAll").prop("checked", false);
                    //$("#shopTypeAll").attr({"checked":""});

                }
                $(".ui-multiselect").css({"width": "150px"});
                //binding multi select end

            }, 100);
            //alert(htmlBrand);

        }
    });
};

// create Sales Type end



// create priority dropdown start

/*
 
 <select id="Priority" name="Priority">
 <option selected>0</option>
 <option>1</option>
 </select>
 
 */

var createPriorityDropDown = function(Priority) {


    var htmlDropDown = "";
    htmlDropDown += "<select id=\"Priority\" name=\"Priority\">";

    if (Priority == 0) {

        htmlDropDown += "<option selected value=\"0\">0</option>";
        htmlDropDown += "<option  value=\"1\">1</option>";
    } else {
        htmlDropDown += "<option selected value=\"1\">1</option>";
        htmlDropDown += "<option  value=\"0\">0</option>";
    }

    htmlDropDown += "</select>";

    setTimeout(function() {

        $("#priorityArea").html(htmlDropDown);
    }, 100);
    //alert(htmlBrand);



};

// create priority dropdown end


// create Alway checkbox start
/*
 <input type="checkbox"  checked id="Alway" name="Alway" value="1">
 */
var createAlwayCheckbox = function(Alway) {
    var $html = "";
    if (Alway == 1) {
        $html = "<input type=\"checkbox\"  checked id=\"Alway\" name=\"Alway\" value=\"1\">";
    } else {
        $html = "<input type=\"checkbox\"   id=\"Alway\" name=\"Alway\" value=\"1\">";
    }
    $("#alwayArea").html($html);
}
// create Alway checkbox end



// create text item name start
var createItemNameText = function(itemCode) {
    $.ajax({
        url: "../Model/mCreateItemName.php",
        dataType: "json",
        data: "{paramItemCode:" + itemCode + "}",
        success: function(data) {
            //alert(data[0]);
            $("#itemName").val(data[0]);

        }
    })


};

// create text item name end





// clear field   start
var clearFielddata = function() {
    $("#PromNo").removeAttr("readonly").css("background", "#ffffff");
    $("#PromNo").val("");
    $("#PromDesc").val("");
    $("#StartDate").val("");
    $("#EndDate").val("");

    //$("#BreakBy").val("");
    //$("#disCountFor").val("0");
    $("#DiscPer").val("0");
    $("#DiscBaht").val("0");
    $("#limitFreeQty").val("0");
    $("#limitDiscBath").val("0");



    createBrach(["All", "All Brach"]);
    createShopTypeDropDown(["All", "All Shop Type"]);
    createSalesTeamDropDown(["All", "All Sales Team"]);
    //$("#Alway").val("");
    //$("#Priority").val("");
}
// clear field  end








// check validation start
var validationFn = function(paramPromType) {
    if ($("#PromNo").val() == "") {
        alert("กรุณาใส่ข้อมูล Promotion No");
        return false;
    } else if ($("#PromDesc").val() == "") {
        alert("กรุณาใส่ข้อมูล Promotion Desc");
        return false;
    } else if ($("#StartDate").val() == "") {
        alert("กรุณาใส่ข้อมูล StartDate");
        return false;
    } else if ($("#EndDate").val() == "") {
        alert("กรุณาใส่ข้อมูล EndDate");
        return false;
    } else if (!$("#branchAll").is(":checked") && getValueMulitSelect("#branch") == "") {
        alert("กรุณาใส่ข้อมูล branch");
        return false;
    } else if (!$("#salesTeamsAll").is(":checked") && getValueMulitSelect("#salesTeam") == "") {
        alert("กรุณาใส่ข้อมูล sales Team");
        return false;
    } else if (!$("#shopTypeAll").is(":checked") && getValueMulitSelect("#shopType") == "") {
        alert("กรุณาใส่ข้อมูล Shop Type");
        return false;
    } else {
        // insert to databse start
        insertDataFn(paramPromType);
        // insert to database end
    }
};

// check validation end



//get value from multi select start
var getValueMulitSelect = function(id) {
    var arBranch = "";
    var i = 0;
    $("" + id + " option:selected").each(function() {
        if (i == 0) {
            arBranch += "" + $(this).val();
        } else {
            arBranch += "," + $(this).val();
        }

        i++;
    });

    return arBranch;
};
//get value from multi select end

/*###################   Event change select Droepdown Discount For  Start here...#####################*/
var disCountForChangeFn = function() {
    $("#disCountFor").change(function() {

        $("tr#DiscountPercentArea").show();
        $("tr#DiscountBathArea").hide();
        if ($(this).val() == "P") {
            $("tr#DiscountPercentArea").show();
            $("tr#DiscountBathArea").hide();
            //$("#DiscPer").val("0");
            $("#DiscBaht").val("0");

        } else {

            $("tr#DiscountPercentArea").hide();
            $("tr#DiscountBathArea").show();
            $("#DiscPer").val("0");
            //$("#DiscBaht").val("0");

        }
    });
};
/*###################   Event change select Droepdown Discount For  Start here...#####################3*/


// insert to databse start
var insertDataFn = function(paramPromType) {

    var paramBranch = "";
    var paramSalesTeam = "";
    var paramShopType = "";

    if ($("#branchAll").is(":checked")) {
        paramBranch = $("#branchAll").val();
    } else {
        paramBranch = getValueMulitSelect("#branch");
    }

    if ($("#salesTeamsAll").is(":checked")) {
        paramSalesTeam = $("#salesTeamsAll").val();
    } else {
        paramSalesTeam = getValueMulitSelect("#salesTeam");
    }

    if ($("#shopTypeAll").is(":checked")) {
        paramShopType = $("#shopTypeAll").val();
    } else {
        paramShopType = getValueMulitSelect("#shopType");
    }



    /*
     var paramBranch= getValueMulitSelect("#branch");
     var paramSalesTeam= getValueMulitSelect("#salesTeam");
     var paramShopType= getValueMulitSelect("#shopType");
     */
    /*
     alert("breakBy="+$("#breakBy").val());
     alert("disCountFor="+$("#disCountFor").val());
     alert("DiscPer="+$("#DiscPer").val());
     alert("DiscBaht="+$("#DiscBaht").val());
     alert("limitFreeQty="+$("#limitFreeQty").val());
     alert("limitDiscBath="+$("#limitDiscBath").val());
     */

    $.ajax({
        url: "../Model/7-1-mBFRPromHeader.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": $("#PromNo").val(),
            "paramPromDesc": $("#PromDesc").val(),
            "paramStartDate": $("#StartDate").val(),
            "paramEndDate": $("#EndDate").val(),
            "paramPriority": $("#Priority").val(),
            "paramBranchCode": paramBranch,
            "paramSalesTeam": paramSalesTeam,
            "paramShopType": paramShopType,
            "paramPromType": paramPromType,
            "paramBreakBy": $("#breakBy").val(),
//            "paramDisCountFor": $("#disCountFor").val(),
//            "paramDiscPer": $("#DiscPer").val(),
//            "paramDiscBaht": $("#DiscBaht").val(),
            "paramLimitFreeQty": $("#limitFreeQty").val(),
//            "paramLimitDiscBath": $("#limitDiscBath").val(),
            "paramUnitCode": $("#unitCode").val(),
            "paramOldPromNo": $("#oldPromNo").val(),
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
                showAlldata(paramPromType);
                //call date default start
                defaultDateInputText();
                //call date default end
                createPromNoSearchDropDown(paramPromType);
            }
            if (data[0] == "update-success") {

                alert("บันทึกข้อมูลที่แก้ไขแล้ว");

                clearFielddata();
                showAlldata(paramPromType);
                $("#submit").val("Add");
                //call date default start
                defaultDateInputText();
                //call date default end
                createPromNoSearchDropDown(paramPromType);
            }
        }
    });

};
// insert to database end
var manangementAction = function(paramPromType) {
// delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {

        var idDel = this.id.split("-");
        var id = idDel[1];
        $.ajax({
            url: "../Model/7-1-mBFRPromHeader.php",
            type: "POST",
            dataType: "JSON",
            data: {"paramAction": "checkUseProm", "paramPromNo": id, "paramPromType": paramPromType},
            success: function(data) {

                if (data[0] == "id-already") {
                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/7-1-mBFRPromHeader.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {"paramAction": "delete", "paramPromNo": id, "paramPromType": paramPromType},
                            success: function(data) {
                                if (data[0] == "del-success") {
                                    showAlldata(paramPromType);
                                    createPromNoSearchDropDown(paramPromType);
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
    $(".btnEdit").off("click");
    $(".btnEdit").on("click", function() {

        var idEdit = this.id.split("-");
        var id = idEdit[1];

        //disable text id is not edit.
        $("#PromNo").attr("readonly", "readonly").css("background", "#f5f5f5");

        //add id for send to edit start
        $("#paramAction").val("editAction");
        //add id for send to edit end

        $.ajax({
            url: "../Model/7-1-mBFRPromHeader.php",
            type: "POST",
            dataType: "json",
            data: {"paramAction": "edit", "paramPromNo": id, "paramPromType": paramPromType},
            success: function(data) {

                /*
                 0-$PromNo=odbc_result($rs,"PromNo");
                 1-$PromDesc=odbc_result($rs,"PromDesc");
                 2-$StartDate=odbc_result($rs,"StartDate");
                 3-$EndDate=odbc_result($rs,"EndDate");
                 4-$Alway=odbc_result($rs,"Alway");
                 5-$Priority=odbc_result($rs,"Priority");
                 6-BranchCode
                 7-ShopTypeCode
                 8-SalesTeam
                 
                 
                 //9-BreakBy
                 //10-DiscFor
                 
                 //11-DiscPer
                 //12-DiscBaht
                 //13-LimitFreeQty
                 //14-FreeUnitCode
                 //15-FreeUnitFactor
                 //16-LimitDiscBaht
                 */
                /* asign value to text start*/


                $("#submit").val("Save");
                $("#PromNo").val(data[0]);
                $("#PromDesc").val(data[1]);
                $("#StartDate").val(data[2]);
                $("#EndDate").val(data[3]);

                $("#DiscPer").val(data[11]);
                $("#DiscBaht").val(data[12]);
                $("#limitFreeQty").val(data[13]);
                $("#limitDiscBath").val(data[16]);
                //$("#unitCode").val(data[14]);
                createUnitCodeDropDown(data[14]);
                createBreakByDropDown(data[9]);
                createDiscForDropDown(data[10]);



                createPriorityDropDown(data[5]);
                createBrach(data[6]);
                createShopTypeDropDown(data[7]);
                createSalesTeamDropDown(data[8]);


                //$("#Priority").val();


                /* asign value to text end*/
                $("#cancel").off("click");
                $("#cancel").on("click", function() {

                    $("#paramAction").val("add");
                    $("#submit").val("Add");
                    createPriorityDropDown("0");
                    defaultDateInputText();
                    clearFielddata();
                    return false;
                });

            }
        });

    });
    // edit data end

    //click Copy start
    $(".btnCopy").off("click");
    $(".btnCopy").on("click", function() {
        var idCopy = this.id.split("-");
        var id = idCopy[1];

        $(".classOldPromNo").remove();
        $("body").append("<input type=\"hidden\" name=\"oldPromNo\" id=\"oldPromNo\" class=\"classOldPromNo\" value=\"" + id + "\">");


        $.ajax({
            url: "../Model/7-1-mBFRPromHeader.php",
            type: "POST",
            dataType: "json",
            data: {"paramPromNo": id, "paramAction": "getPromotion", "paramPromType": paramPromType},
            success: function(data) {

                /*
                 cPromNo
                 cPromDesc
                 cStartDate
                 cEndDate
                 cAlway
                 cPriority
                 */

                $("td#cPromNo").html(data[0]);
                $("td#cPromDesc").html(data[1]);
                $("td#cStartDate").html(data[2]);
                $("td#cEndDate").html(data[3]);
                $("td#cAlway").html(data[4]);
                $("td#cPriority").html(data[5]);

                //binding method close modal start
                $("#nPromtionSubmit").off("click");
                $("#nPromtionSubmit").on("click", function() {
                    //alert($("#newPromotion:checked").val());
                    //if($("#newPromotion:checked").val()=="Copy_Existing_Promotion"){
//                    alert("You Coping Promotion " + data[0] + " to  Promotion " + $("#nPromNo").val());
                    $('.modal').modal('hide');
                    //$("#nPromNo").val("");
                    //}

                });
                $("#nCancel").click(function() {
                    $("#nPromNo").val("");
                    $('.modal').modal('hide');
                });
                //binding method close modal end

                //click button for new promotion start
                $("form#addNewPromotion").off("submit");
                $("form#addNewPromotion").on("submit", function() {
                    if ($("#nPromNo").val() == "") {
                        alert("Prom No is not empty");
                        return false;
                    } else {
                        //alert($("#nPromNo").val());
                        //alert($("#newPromotion:checked").val());
                        //	if($("#newPromotion:checked").val()=="Copy_Existing_Promotion"){

                        //get data for copy promotion start
                        $.ajax({
                            url: "../Model/7-1-mBFRPromHeader.php",
                            type: "POST",
                            dataType: "json",
                            data: {"paramAction": "edit", "paramPromNo": id, "paramPromType": paramPromType},
                            success: function(data) {

                                /*
                                 0-$PromNo=odbc_result($rs,"PromNo");
                                 1-$PromDesc=odbc_result($rs,"PromDesc");
                                 2-$StartDate=odbc_result($rs,"StartDate");
                                 3-$EndDate=odbc_result($rs,"EndDate");
                                 4-$Alway=odbc_result($rs,"Alway");
                                 5-$Priority=odbc_result($rs,"Priority");
                                 6-BranchCode
                                 7-ShopTypeCode
                                 8-SalesTeam
                                 */
                                /* asign value to text start*/


                                $("#submit").val("Add");
                                $("#PromNo").val($("#nPromNo").val());
                                $("#PromDesc").val(data[1]);
                                $("#StartDate").val(data[2]);
                                $("#EndDate").val(data[3]);
                                createPriorityDropDown(data[5]);
                                createBrach(data[6]);
                                createShopTypeDropDown(data[7]);
                                createSalesTeamDropDown(data[8]);



                                /* asign value to text end*/
                                $("#paramAction").val("add");
                                $("#nPromNo").val("");

                            }
                        });
                        //get data for copy promotion end

                        //}//if Copy_Existing_Promotion
                        /*
                         if($("#newPromotion:checked").val()=="Blank_Promotion"){
                         $("#PromNo").val($("#nPromNo").val());
                         }
                         */
                    }
                    return false;
                });
                //click buttob for new promotion end
            }
        });
        //return false;
    });
    //click Copy end


    //click add item start
    $(".btnAddItem").off("click");
    $(".btnAddItem").click(function() {
        var idAddItem = this.id.split("-");
        var id = idAddItem[1];
        //alert(id);
        //alert("paramPromNo"+id);
        //alert("paramPromType"+paramPromType);

        callcAddFreeItemDiscountPromByItemFn(id, paramPromType);

        //return false;

    });
    //click add item end

    //click print promotion star
    $(".btnPrint").off("click");
    $(".btnPrint").click(function() {
        var idPrint = this.id.split("-");
        var id = idPrint[1];
        var url = "../html2pdf/BFRReport.php?paramPromNo=" + id + "&paramPromType=" + paramPromType + "";
        //$(location).attr({'target':'_blank','href':url});
        window.open(url, '_blank');
    });
    //click print promotion end

    //promotion step start
    $(".btnPromStep").off("click");
    $(".btnPromStep").click(function() {
        var idArray = this.id.split("-");
        var paramPromNo = idArray[1];
        //alert(paramPromNo);

        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"4-2-cBDCPromStep\" type=\"text/javascript\" src=\"../Controller/7-2-cBFRPromStep.js\"></script>");
        callcBDCPromStepFn(paramPromNo, paramPromType);
    });
    //promotion step end

};

// show all  data start
var showAlldata = function(paramPromType, searchText) {

    /*
     alert(searchText['promDescSearch']);
     alert(searchText['StartDateSearch']);
     alert(searchText['EndDateSearch']);
     
     */
    var paramPromDesc = "";
    var paramStartDate = "";
    var paramEndDate = "";
    if (searchText == null) {
        paramPromDesc = "";
        paramStartDate = "";
        paramEndDate = "";
    } else {
        paramPromDesc = searchText['promDescSearch'];
        paramStartDate = searchText['StartDateSearch'];
        paramEndDate = searchText['EndDateSearch'];
    }

    $.ajax({
        url: "../Model/7-1-mBFRPromHeader.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramPromType": paramPromType, "paramPromDesc": paramPromDesc,
            "paramStartDate": paramStartDate, "paramEndDate": paramEndDate},
        sync: false,
        success: function(data) {
            //alert(data);
            $("#showAllData").html(data);

            // biding grid method strat
            $("#grid").kendoGrid({
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
                height: 350
            });
            setTable();
            // biding grid method end

            //binding mangement function start
            manangementAction(paramPromType);

            //sorting start
            setTimeout(function() {
                $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    manangementAction(paramPromType);
                });
            }, 1000);


        }
    });
}
// show all data end


//cAddProdForPromGroup.js start
var callBDCPromHeaderFn = function(paramPromType) {

    $.ajax({
        url: "../View/7-1-vBFRPromHeader.php",
        type: "post",
        dataType: "html",
        success: function(data) {
            $("#content").html(data);
            //binding library start
            // $( ".date" ).datepicker();
            $(".date").datepicker({
                showOn: "button",
                buttonImage: "../images/calendar.gif",
                buttonImageOnly: true,
                buttonText: "Select date"
            });
            $(".date").datepicker("option", "dateFormat", 'yy-mm-dd');
            //binding library end
            //call function for create multi select dropdown start
            setTimeout(function() {
                createBrach(["All", "All Branch "]);
                createShopTypeDropDown(["All", "All Shop Type "]);
                createSalesTeamDropDown(["All", "All Sales Team "]);
            }, 100);
            //call function for create multi select dropdown end
            // check branch all start
            $("#branchAll").click(function() {
                if ($('#branchAll').is(':checked')) {
                    //Disable mutiselect start
                    $("#branch").multiselect("disable");
                    //Disable mutiselect end
                } else {
                    $("#branch").multiselect("enable");
                }
            });
            // check branch all end

            // check salesTem all start
            $("#salesTeamsAll").click(function() {
                if ($('#salesTeamsAll').is(':checked')) {
                    //Disable mutiselect start
                    $("#salesTeam").multiselect("disable");
                    //Disable mutiselect end

                } else {

                    $("#salesTeam").multiselect("enable");
                }
            });
            // check salesTem all end

            // check Shop Type  all start
            $("#shopTypeAll").click(function() {
                if ($('#shopTypeAll').is(':checked')) {
                    //Disable mutiselect start
                    $("#shopType").multiselect("disable");
                    //Disable mutiselect end
                } else {
                    $("#shopType").multiselect("enable");
                }
            });
            // check Shop Type  all end



            //call showAllData start
            showAlldata(paramPromType);
            //call showAllData end
            //create select input unit code
            createUnitCodeDropDown();




            /*###################   Event change select Droepdown Discount For  Start here...#####################*/
            disCountForChangeFn();
            /*###################   Event change select Droepdown Discount For  end here...#####################3*/

            //form search start here
            $("form#search").submit(function() {
                var searchText = new Array()

                searchText['promDescSearch'] = $("#promDescSearch").val();
                searchText['StartDateSearch'] = $("#StartDateSearch").val();
                searchText['EndDateSearch'] = $("#EndDateSearch").val();
                /*
                 alert(searchText['promDescSearch']);
                 alert(searchText['StartDateSearch']);
                 alert(searchText['EndDateSearch']);
                 */
                showAlldata(paramPromType, searchText);
                return false;
            });
            //form search end here

            /*click submit start*/
            $("form#addBDCPromHeader").submit(function() {

                // check validation start
                validationFn(paramPromType);
                // check validation end

                return false;
            });

            /*click submit end*/

            /*
             click from form cancel start
             */
            $("#cancel").off("click");
            $("#cancel").on("click", function() {
                //alert("delete");

                createPriorityDropDown("0");
                clearFielddata();
                //call date default start
                defaultDateInputText();
                //call date default end


            });


            //binding dropdown search start
            createPromNoSearchDropDown(paramPromType);
            //binding dropdown search end

            //create auto complte start
            searchAutoCompltePromDesc("#promDescSearch", "Promotion Description", paramPromType);
            //create auto complte end




            //call date default start
            defaultDateInputText();
            //call date default end

            /*check number in text field before press submit start*/
            $("#DiscPer").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#DiscBaht").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#limitFreeQty").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#limitDiscBath").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            /*check number in text field before press submit end*/


        }

    });

};
//callprodGroupForProm end











	