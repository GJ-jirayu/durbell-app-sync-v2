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


};


//##################  group code gernarate for search stat here. ################

//search auto complte start
var searchAutoCompltePromDesc = function(id, defaultText, paramPromType) {
    $.ajax({
        url: "../Model/mDiscPromByItem.php",
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
                        //alert(data[0][0]);
                        //create  prom no droup down start
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


/*
 <select class="form-control input-sm">
 <option>All</option>
 <option>DE5233</option>
 </select>
 
 */

var createPromNoSearchDropDown = function(paramPromType, paramPromNo) {

    $.ajax({
        url: "../Model/mDiscPromByItem.php",
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
                        url: "../Model/mDiscPromByItem.php",
                        type: "post",
                        dataType: "json",
                        data: {"paramPromNo": $(this).val(), "paramAction": "promNoSearch", "paramPromNoSearch": $("#promNoSearch").val()},
                        success: function(data) {
//                            alert(data[0]);
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


// create unit code  start

/*
 
 <select id="unitCode" name="unitCode">
 <option value="Piece">Piece</option>
 <option value="Pack">Pack</option>
 </select>
 
 */

var createUnitCodeDropDown = function(unitCode) {

    $.ajax({
        url: "../Model/mUnitCode.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"unitCode\" name=\"unitCode\">";
            $.each(data, function(index, indexEntry) {
                if (unitCode == indexEntry[0]) {

                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#unitCodeArea").html(htmlDropDown);
            }, 100);
            //alert(htmlBrand);

        }
    });
}

// create unit code end

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
    //$("#StartDate").val("");
    //$("#EndDate").val("");
    createBrach(["All", "All Brach"]);
    createShopTypeDropDown(["All", "All Shop Type"]);
    createSalesTeamDropDown(["All", "All Sales Team"]);


    $("#submit").val("Add");
    $("#paramAction").val("add");

    //$("#Alway").val("");
    //$("#Priority").val("");
}
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
        // insert to databse 

//        alert("Insert แล้วจร๊");
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


    $.ajax({
        url: "../Model/mDiscPromByItem.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": $("#PromNo").val(), "paramPromDesc": $("#PromDesc").val(),
            "paramStartDate": $("#StartDate").val(), "paramEndDate": $("#EndDate").val(),
            "paramPriority": $("#Priority").val(), "paramAlway": $("#Alway").val(),
            "paramBranchCode": paramBranch, "paramSalesTeam": paramSalesTeam,
            "paramShopType": paramShopType, "paramPromType": paramPromType,
            "paramOldPromNo": $("#oldPromNo").val(), "paramAction": $("#paramAction").val(),
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

                //binding dropdown search start
                createPromNoSearchDropDown(paramPromType);
                //binding dropdown search end

                //create auto complte start
                searchAutoCompltePromDesc("#promDescSearch", "Promotion Description", paramPromType);
                //create auto complte end

                //call date default start
                defaultDateInputText();
                //call date default end
            }
            if (data[0] == "update-success") {

                alert("บันทึกข้อมูลที่แก้ไขแล้ว");

                clearFielddata();
                showAlldata(paramPromType);
                $("#submit").val("Add");
                $("#paramAction").val("add");
                //call date default start
                defaultDateInputText();
                //call date default end

                createPromNoSearchDropDown(paramPromType);
                searchAutoCompltePromDesc("#promDescSearch", "Promotion Description", paramPromType);
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
            url: "../Model/mDiscPromByItem.php",
            type: "POST",
            dataType: "JSON",
            data: {"paramAction": "checkUseProm", "paramPromNo": id, "paramPromType": paramPromType},
            success: function(data) {

                if (data[0] == "id-already") {
                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                } else {
                    if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
                        $.ajax({
                            url: "../Model/mDiscPromByItem.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {"paramAction": "delete", "paramPromNo": id, "paramPromType": paramPromType},
                            success: function(data) {
                                if (data[0] == "del-success") {
                                    showAlldata(paramPromType);

                                    //binding dropdown search start
                                    createPromNoSearchDropDown(paramPromType);
                                    //binding dropdown search end

                                    //create auto complte start
                                    searchAutoCompltePromDesc("#promDescSearch", "Promotion Description", paramPromType);
                                    //create auto complte end

                                    //call date default start
                                    defaultDateInputText();
                                    //call date default end
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
            url: "../Model/mDiscPromByItem.php",
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


                $("#submit").val("Save");
                $("#PromNo").val(data[0]);
                $("#PromDesc").val(data[1]);
                $("#StartDate").val(data[2]);
                $("#EndDate").val(data[3]);
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
                    //call date default start
                    defaultDateInputText();
                    clearFielddata();
                    return false;
                });

            }
        });

    });
    // edit data end
    
    
    //add item start
    $(".btnAdd").off("click");
    $(".btnAdd").click(function() {
        var idEdit = this.id.split("-");
        var id = idEdit[1];

        $.ajax({
            url: "../View/vAddProdForPromGroup.php",
            type: "POST",
            dataType: "html",
            data: {"paramGroupCode": id, "paramPromType": paramPromType},
            success: function(data) {
                $("#content").html(data);

            }
        });

    });
    //add item end
    //click Copy start
    $(".btnCopy").off("click");
    $(".btnCopy").on("click", function() {
        var idCopy = this.id.split("-");
        var id = idCopy[1];

        $(".classOldPromNo").remove();
        $("body").append("<input type=\"hidden\ name=\"oldPromNo\" id=\"oldPromNo\" class=\"classOldPromNo\" value=\"" + id + "\">");


        $.ajax({
            url: "../Model/mDiscPromByItem.php",
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
//                $("td#cAlway").html(data[4]);
                $("td#cPriority").html(data[4]);

                //binding method close modal start
                $("#nPromtionSubmit").off("click");

                /*
                 $("#nPromtionSubmit").on("click",function(){
                 //alert($("#newPromotion:checked").val());
                 //if($("#newPromotion:checked").val()=="Copy_Existing_Promotion"){
                 //alert("You Coping Promotion "+data[0]+" to  Promotion "+$("#nPromNo").val());
                 $('.modal').modal('hide');
                 //$("#nPromNo").val("");
                 //}
                 });
                 */
                $("#nCancel").click(function() {
                    $("#nPromNo").val("");
                    $('.modal').modal('hide');
                });
                //binding method close modal end

                //click button for new promotion start
                $("form#addNewPromotion").off("submit");
                $("form#addNewPromotion").on("submit", function() {

                    if ($("#nPromNo").val() == "") {
                        alert("กรุณาใส่ Promotion No");
                        return false;
                    } else {
                        $('.modal').modal('hide');
                        //alert($("#nPromNo").val());
                        //alert($("#newPromotion:checked").val());
                        //	if($("#newPromotion:checked").val()=="Copy_Existing_Promotion"){


                        //get data for copy promotion start
                        $.ajax({
                            url: "../Model/mDiscPromByItem.php",
                            type: "POST",
                            dataType: "json",
                            sync: false,
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

        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"2-2-cAddItemDiscountProm\" type=\"text/javascript\" src=\"../Controller/2-2-cAddItemDiscountProm.js\"></script>");
        callAddItemDiscountPromFn(id, paramPromType);

        return false;
    });
    //click add item end

    //click print promotion star
    $(".btnPrint").off("click");
    $(".btnPrint").click(function() {
        var idPrint = this.id.split("-");
        var id = idPrint[1];

        var url = "../html2pdf/DCIResport.php?paramPromNo=" + id + "&paramPromType=" + paramPromType + "";
        //$(location).attr({'target':'_blank','href':url});
        window.open(url, '_blank');
    });
    //click print promotion end
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
        url: "../Model/mDiscPromByItem.php",
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
                $("table thead th.k-header, ul.k-list, a.k-link").on("click", function() {
                    manangementAction(paramPromType);
                    setTable();
                });
            }, 1000);
        }
    });
};
// show all data end


//cAddProdForPromGroup.js start
var callDiscPromByItemContentFn = function(paramPromType) {

    $.ajax({
        url: "../View/2-1-DiscPromByItem.php",
        type: "post",
        dataType: "html",
        success: function(data) {
            $("#content").empty();
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

            //############## Value Default Checkbox is All Start ###################
            /*
             setTimeout(function(){
             $("#shopTypeAll").trigger("click");
             $("#salesTeamsAll").trigger("click");
             $("#branchAll").trigger("click");
             },1000);
             */
            //############## Value Default Checkbox is All End ###################


            //call showAllData start
            showAlldata(paramPromType);
            //call showAllData end

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
            $("form#addDiscPromByItem").submit(function() {

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
        }

    });

};
//callprodGroupForProm end











	