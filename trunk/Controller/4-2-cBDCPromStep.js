//search auto complte start
var searchAutoCompltePromGroup = function(id) {
    $.ajax({
        url: "../Model/mPromGroup.php",
        type: "post",
        dataType: "json",
        //data:{"paramTextSearch":paramTextSearch},
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
            var defaultValue = "";
            var formatAutoComplte = "[";
            $(data).each(function(index, indexEntry) {
                //alert(indexEntry[1]);

                if (index == 0) {
                    defaultValue = indexEntry[1];
                    formatAutoComplte += "\"" + indexEntry[1] + "\"";
                } else {
                    formatAutoComplte += ",\"" + indexEntry[1] + "\"";
                }
            });
            formatAutoComplte += "]";
            var objFormatAutoComplte = eval("(" + formatAutoComplte + ")");
            $("td#groudDescSearchArea").html("<input name=\"groudDescSearch\"  id=\"groudDescSearch\" type=\"text\" value=\"" + defaultValue + "\"/>");
            createAutocomplete(id, objFormatAutoComplte, "Group Description...");
            //console.log(objFormatAutoComplte);	


            /*click item name for get group code start*/
            var k = 0;
            $("#groudDescSearch").off("change");
            $("#groudDescSearch").on("change", function() {
                $.ajax({
                    url: "../Model/mPromGroup.php",
                    type: "post",
                    dataType: "json",
                    data: {"paramItemName": $("#groudDescSearch").val()},
                    sync: false,
                    success: function(data) {

                        //create group prom code droup down start
                        createGroupPromCodeDropDown(data[0][0]);
                        //create group prom code droup down end
                    }
                });
            });
            /*click item name for get group start*/
        }
    });
};
//search auto complte end	


//group code gernarate  for search start here.
var createGroupPromCodeDropDown = function(groupCode, disable) {
    //alert("createGroupPromCodeDropDown");
    $.ajax({
        url: "../Model/mPromGroup.php",
        dataType: "json",
        sync: false,
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";

            htmlDropDown += "<select id=\"GroupCode\" name=\"GroupCode\" style=\"height:27px;\">";
            //htmlDropDown+="<option selected value=All>All-All</option>";
            var defaultValue = "";
            $.each(data, function(index, indexEntry) {
                if (groupCode == indexEntry[0]) {
                    if (index == 0) {
                        defaultValue = indexEntry[1];
                    }
                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#groupCodeArea").html(htmlDropDown);

                if (disable == "disable") {
                    //disable select item for edit start
                    $("select#GroupCode").prop("disabled", true);
                    //disable select item for edit end
                }
                //group code start
                $("#GroupCode").change(function() {
                    //alert($(this).val());

                    $.ajax({
                        url: "../Model/mProdGroupForPromService.php",
                        type: "post",
                        dataType: "json",
                        data: {"paramGroupCode": $(this).val(), "paramAction": "edit"},
                        success: function(data) {
                            //alert(data[1]);
                            $("#groudDescSearch").val(data[1]);
                        }
                    });
                });
                //create auto complte end
            }, 100);
            //alert(htmlBrand);
        }
    });
};

//group code gernarate  for search end here.
// create brand  start
var calculateBreakUnitFactor = function(Qty, UnitCode, paramPromCode) {

    $.ajax({
        url: "../Model/2-3-mAddFreeItemDiscountPromByItem.php",
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
            if (unitCode == "PCS") {
                htmlDropDown += "<option selected value=\"PCS\"> ชิ้น </option>";
            } else if(unitCode == "CNT"){
                htmlDropDown += "<option selected value=\"CNT\"> ลัง </option>";
            } else if(unitCode == "PAC"){
                htmlDropDown += "<option selected value=\"CNT\"> แพ็ค </option>";
            } else {
                $.each(data, function(index, indexEntry) {

                    if (unitCode == indexEntry[0]) {
                        htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                    } else {
                        htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                    }
                });
            }
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#breakUnitCodeArea").html(htmlDropDown);

            }, 100);
            //alert(htmlBrand);

        }
    });
};

// create createUnitCodeBreakDropDown end


var countStep = function(paramPromType, paramPromNo) {

    $.ajax({
        url: "../Model/4-2-mBDCPromStep.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType, "paramAction": "countPromStep"},
        success: function(data) {
            //alert(data[0]);
            setTimeout(function() {
                //$("#Step").val(parseInt(data[0])+1);
                if (parseInt(data[0]) > 0) {

                    $("tr.PromStepNoteDisplay").hide();


                } else {

                    $("tr.PromStepNoteDisplay").show();
                    $("#PromStepNote").val("");
                }
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
};
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
//createItemCodeDropDown();
//test call createItemCodeDropDown end


// clear field   start
var clearFielddata = function() {

    //Step
    //PromStepNote
    //MinimumSKU
    //BreakAmt
    //DiscBaht
    $("#BreakAmt").val("0");
    $("#DiscBaht").val("0");
    $("#BreakQty").val("0");
    $("#breakUnitCode").val("PCS");
    $("#BreakUnitFactor").val("1");
    $("#PromStepNote").text("");
    $("#Step").val("").removeAttr("readonly").css({"background": "white"});
    $("input#itemCodeRadio").removeAttr('disabled').trigger("click");
    $("#DiscPer").val("0");
    $("input#groupCodeRadio").removeAttr('disabled');

    createItemCodeDropDown("All");
    createBrand();
    $("#itemName").removeAttr("readonly").css({"background": "white"});

    createGroupPromCodeDropDown();
    $("#groudDescSearch").removeAttr("readonly").css({"background": "white"});
    //$(".inputData").val("");


    $("#submit").val("Add");
    $("#paramAction").val("add");

};
// clear field  end





// check validation start
var validationFn = function(paramPromNo, paramPromType, paramPromCode, paramPromStepType) {
    //alert("paramPromNo"+paramPromNo);
    //alert("paramPromType"+paramPromType);
    //alert("paramPromCode"+paramPromCode);
    /*
     Step
     MinimumSKU
     PromStepNote
     */
    if ($("#BreakQty").val() == "") {
        $("#BreakQty").val(0);
    }
    
    if($("#itemCodeRadio").is(":checked")) { 
        if($("#itemCode").val() == null || $("#itemCode").val() == ""){
            alert("กรุณาใส่ข้อมูล Item Code.");
            return false;
        }
    }
    
    if ($("#Step").val() == "") {
        alert("กรุณาใส่ข้อมูล Step");
        return false;
    }else if (!$("#PromStepNote").is(':hidden') && $("#PromStepNote").val() == "") {
        alert("กรุณาใส่ข้อมูล Promotion Step Note");
        return false;
    } else {
        insertDataFn(paramPromNo, paramPromType, jQuery.makeArray(paramPromCode), paramPromStepType);
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
var insertDataFn = function(paramPromNo, paramPromType, paramPromCode, paramPromStepType) {

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
        url: "../Model/4-2-mBDCPromStep.php",
        type: "post",
        dataType: "json",
        sync: false,
        data: {"paramPromNo": paramPromNo,
            "paramPromType": paramPromType,
            "paramPromCode": paramPromCode,
            "paramStep": $("#Step").val(),
            "paramPromStepType": paramPromStepType,
            "paramMinimumSKU": $("#MinimumSKU").val(),
            "paramBreakQty": $("#BreakQty").val(),
            "paramBreakUnitCode": $("#breakUnitCode").val(),
            "paramBreakUnitFactor": $("#BreakUnitFactor").val(),
            "paramBreakAmt": $("#BreakAmt").val(),
//            "paramDiscPer": $("#DiscPer").val(), 
//            "paramDiscBaht": $("#DiscBaht").val(),
            "paramDiscPer": 0,
            "paramDiscBaht": 0,
            "paramPromStepNote": $("#PromStepNote:visible").val(),
            "paramAction": $("#paramAction").val()},
        success: function(data) {
            //alert(data);

            /*if (data[0] == "id-already") {
             alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");
             
             }
             if (data[0] == "save-success") {
             alert("บันทึกข้อมูลใหม่แล้ว");
             clearFielddata();
             showAlldata(paramPromNo, paramPromType, paramPromCode);
             countStep(paramPromType, paramPromNo);
             }
             
             if (data[0] == "update-success") {
             alert("บันทึกข้อมูลที่แก้ไขแล้ว");
             clearFielddata();
             showAlldata(paramPromNo, paramPromType, paramPromCode);
             countStep(paramPromType, paramPromNo);
             $("#submit").val("Add");
             $("#paramAction").val("add");
             
             }*/
            var msg = "";
            if (data[0] && data[0] != "update-success") {
                $.each(data, function(idx, obj) {
                    msg += "\n - " + obj;
                });
                alert("บันทึกข้อมูลเรียบร้อยแล้ว \nและไม่สามารถบันทึกข้อมูลต่อไปนี้ได้เนื่องจากมีข้อมูลอยู่แล้ว" + msg);
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                countStep(paramPromType, paramPromNo);
            } else if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว");
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                countStep(paramPromType, paramPromNo);
                $("#submit").val("Add");
                $("#paramAction").val("add");
                $("#lbBreakUnitFactor").hide();
                $("#BreakUnitFactor").hide();
            } else {
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                countStep(paramPromType, paramPromNo);
            }

        }
    });
};
// insert to database end
var manangementAction = function(paramPromType, paramPromNo) {

    // delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {
        var idDel = this.id.split("-");
        var paramPromCode = $(this).parent().parent().children().eq(2).text();

        var id = idDel[1];

        $.ajax({
            url: "../Model/4-2-mBDCPromStep.php",
            type: "POST",
            dataType: "JSON",
            data: {"paramAction": "checkUseProm", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
            success: function(data) {
                if (data[0] == "id-already") {

                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");

                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/4-2-mBDCPromStep.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {"paramAction": "delete", "paramPromType": paramPromType, "paramPromNo": paramPromNo, "paramPromCode": paramPromCode, "paramStep": id},
                            success: function(data) {
                                if (data[0] == "success") {
                                    showAlldata(paramPromNo, paramPromType, paramPromCode);
                                    clearFielddata();
                                    countStep(paramPromType, paramPromNo);
                                    $("#submit").val("Add");
                                    $("#paramAction").val("add");
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
    $(".btnEdit").off("click");
    $(".btnEdit").on("click", function() {

        $("#lbBreakUnitFactor").show();
        $("#BreakUnitFactor").show();
        var idEdit = this.id.split("-");
        var id = idEdit[1];
        var paramPromCode = $(this).parent().parent().children().eq(2).text();
        if ($(this).hasClass("record1")) {
            $("tr.PromStepNoteDisplay").show();
        } else {
            $("tr.PromStepNoteDisplay").hide();
        }
        //alert(paramPromCode);
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

//        $("#itemCodeRadio").attr('disabled', 'disabled');
//        $("#groupCodeRadio").attr('disabled', 'disabled');

        $.ajax({
            url: "../Model/4-2-mBDCPromStep.php",
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
                $("input#itemCodeRadio").removeAttr('disabled');
                $("input#groupCodeRadio").removeAttr('disabled');

                //$("#Step").val(""+data[0]+"");
                $("#Step").val(data[0]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});
                $("#MinimumSKU").val("" + data[1] + "");
                $("#BreakQty").val("" + data[2] + "");
                $("#breakUnitCode").val("" + data[3] + "");
                $("#BreakUnitFactor").val("" + data[4] + "");
                $("#BreakAmt").val("" + data[5] + "");
                $("#DiscPer").val("" + data[6] + "");
                $("#DiscBaht").val("" + data[7] + "");
                //alert(data[8]);
                if (data[8] != "") {
                    //alert(data[3]);
                    $("#PromStepNote").val("" + data[8] + "");
//                    $("tr.PromStepNoteDisplay").show();
                } else {
                    $("tr.PromStepNoteDisplay").hide();
                }
                //disable select item for edit start
                $("select#brand").prop("disabled", true);
                //disable select item for edit end

                if (data[11] == "BDI") { 
                    $("#itemCodeRadio").trigger( "click" );
                    //$("#itemCodeRadio").attr('checked', true);
                    $("input#itemCodeRadio").attr('disabled', 'disabled');
                    $("input#groupCodeRadio").attr('disabled', 'disabled');
                    createItemCodeDropDown("All", data[9], "disable");
                    $("#itemName").val(data[10]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});
                    
                } else { 
                    $("#groupCodeRadio").trigger( "click" );
                    //$("#groupCodeRadio").attr('checked', true);                    
                    $("input#itemCodeRadio").attr('disabled', 'disabled');
                    $("input#groupCodeRadio").attr('disabled', 'disabled');
                    createGroupPromCodeDropDown(data[9], "disable");
                    $("#groudDescSearch").val(data[10]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});
                    
                }
                //asign value into input text area end.

                //manage change everlopment for add insert
                $("#submit").val("Save");
                $("#cancel").off("click");
                $("#cancel").on("click", function() {
                    $("#lbBreakUnitFactor").hide();
                    $("#BreakUnitFactor").hide();
                    $("#submit").val("Add");
                    $("#paramAction").val("add");
                    $("#itemCodeRadio").prop("disabled", false);
                    $("#groupCodeRadio").prop("disabled", false);
                    clearFielddata();
                    countStep(paramPromType, paramPromNo);
                });               
                createUnitCodeBreakDropDown(data[3]);
            }
        });

    });
    // edit data end
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
        url: "../Model/4-2-mBDCPromStep.php",
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
                    {field: "field1", width: '13%'},
                    {field: "field2", width: '5%'},
                    {field: "field3", width: '15%'},
                    {field: "field4", width: '30%'},
                    {field: "field5", width: ''},
                    {field: "field6", width: ''},
                    {field: "field7", width: '15%'}
                ]
            });
            setTable();
            $("table#grid1 tbody tr").each(function() {
                $("td", this).eq(1).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                $("td", this).eq(5).css({"text-align": "right", "padding-rigth": "5px"});
            });
            //END: Set Table
            // biding grid method end


            //binding mangement function start
            manangementAction(paramPromType, paramPromNo);

            //sorting start
            setTimeout(function() {
                $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    $("table#grid1 tbody tr").each(function() {
                        $("td", this).eq(1).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                        $("td", this).eq(5).css({"text-align": "right", "padding-rigth": "5px"});
                    });
                    //END: Set Table
                    manangementAction(paramPromType, paramPromNo);
                });
            }, 1000);
        }
    });
};
// show all data end

//cAddProdForPromGroup.js start
var callcBDCPromStepFn = function(paramPromNo, paramPromType) {

    /*
     $(".embParam").remove();
     $("body").append("<input type=\"hidden\" id=\"embPromNo\" class=\"embParam\" value="+paramPromNo+">");
     */

    $.ajax({
        url: "4-2-vBDCPromStep.php",
        type: "post",
        data: {"paramPromNo": paramPromNo, "paramPromType": paramPromType},
        dataType: "html",
        sync: false,
        success: function(data) {
            //alert(data);
            $("#content").html(data);
            //binding Unit Code Break Start.
//            if ($("input#groupCodeRadio").prop('checked', true)) {
            createUnitCodeBreakDropDown();
//            }else{
//                createUnitCodeBreakDropDown();
//            }
            //Binning Unit Code Break End.
            //call crete brand start
            createBrand();
            //call crete brand end

            //create dropdownc prom code
            createGroupPromCodeDropDown();
            //create auto complte start
            searchAutoCompltePromGroup("#groudDescSearch");



            //click radio select item code or group code start
            var paramPromCode;
            var paramPromStepType;
            setTimeout(function() {

                $("tr.itemDisplay").show();
                $("tr.groupDisplay").hide();
                $("tr.displayMinimumSKU").hide();
                $("#MinimumSKU").val(0);

                $("#lbBreakUnitFactor").hide();
                $("#BreakUnitFactor").hide();

                paramPromStepType = $(".item").val();
                $(".item").click(function() {
                    if ($(this).val() == "BDI") {
                        paramPromStepType = $(this).val();
                        $("tr.itemDisplay").show();
                        $("tr.groupDisplay").hide();
                        $("tr.displayMinimumSKU").hide();
                        $("#MinimumSKU").val(0);
                        createUnitCodeBreakDropDown();
                        calculateBreakUnitFactor($("#BreakQty").val(), $("#breakUnitCode").val(), $("#itemCode").val());
                        setTimeout(function() {
                            $("#breakUnitCode, #itemCode").change(function() {
                                if ($("#itemCodeRadio").is(':checked')) {
                                    calculateBreakUnitFactor($("#BreakQty").val(), $("#breakUnitCode").val(), $("#itemCode").val());
                                }
                            });
                        }, 1000);
                    } else {
                        paramPromStepType = $(this).val();
                        $("tr.itemDisplay").hide();
                        $("tr.groupDisplay").show();
                        $("tr.displayMinimumSKU").show();
//                        $("#MinimumSKU").val(0);
                        createUnitCodeBreakDropDown("PCS");
                        $("#BreakUnitFactor").val("1");
                    }
                    //alert(paramPromCode);
                });
                //call showAllData start
                showAlldata(paramPromNo, paramPromType, paramPromCode);
                //call showAllData end
            }, 1000);
            //click radio select item code or group code end

            //check number in text field before press submit start
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
            $("#Step").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#MinimumSKU").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
            //check number in text field before press submit end


            //calculate unit code for Free Unit Factor 	start
            $("#BreakQty").keyup(function() {

                //alert($("#FreeQty").val());
                //alert($("#unitCode").val());
                var BreakQty = 0;
                if ($("#BreakQty").val() == "") {
                    BreakQty = 0;
                } else {
                    BreakQty = $("#BreakQty").val();
                }
                calculateBreakUnitFactor(BreakQty, $("#breakUnitCode").val(), $("#itemCode").val());
            });
            setTimeout(function() {
                $("#breakUnitCode, #itemCode").change(function() {
                    if ($("#itemCodeRadio").is(':checked')) {
                        calculateBreakUnitFactor($("#BreakQty").val(), $("#breakUnitCode").val(), $("#itemCode").val());
                    }
                });
            }, 1000);

            //calculate unit code for Free Unit Factor 	end

            //click submit start
            $("form#addStepDiscountProm").submit(function() {
                // check validation start
                var paramPromCode;
                if (paramPromStepType == "BDI") {
                    paramPromCode = $("#itemCode").val();
                } else {
                    paramPromCode = $("#GroupCode").val();
                }
                validationFn(paramPromNo, paramPromType, paramPromCode, paramPromStepType);
                // check validation end
                return false;
            });
            //click submit end

            //back to prodGroupForProm start
            $("#back").click(function() {
                $(".Controller").remove();
                $("head").append("<script class=\"Controller\" id=\"cBDCPromHeader\" type=\"text/javascript\" src=\"../Controller/4-1-cBDCPromHeader.js\"></script>");
                callBDCPromHeaderFn("BDC");
                return false;
            });
            //back to prodGroupForProm end
            //num count step for enable text note or disable
            countStep(paramPromType, paramPromNo);
        }

    });
};
//callprodGroupForProm end


/*#############################################################################################################################################*/
/*#############################################################################################################################################*/
