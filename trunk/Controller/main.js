$(document).ready(function() {

    //set initail start
    $(".date").datepicker();
    setTimeout(function() {
        //$("#prodGroupForProm").trigger("click");

    });
    //set initail start


//process start prodGroupForProm start
    $("#prodGroupForProm").click(function() {
        //$("#cProdGroupForProm").remove();
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cProdGroupForProm\" type=\"text/javascript\" src=\"../Controller/cProdGroupForProm.js\"></script>");
        callprodGroupForPromContentFn();
    });
//process start prodGroupForProm end


    //process start DiscPromByItem
    $("#DiscPromByItem").click(function() {
        //ajax start
        /*
         $.ajax({
         url:"2-1-DiscPromByItem.php",
         type:"get",
         dataType:"html",
         success:function(data){
         
         $("#content").empty();
         $("#content").html(data);
         
         }
         });
         */
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cDiscPromByItem\" type=\"text/javascript\" src=\"../Controller/cDiscPromByItem.js\"></script>");
        callDiscPromByItemContentFn("DCI");
        //ajax end
    });
    //process end DiscPromByItem

    //process start DiscPromByGroup
    $("#DiscPromByGroup").click(function() {
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cDCGPromHeader\" type=\"text/javascript\" src=\"../Controller/3-1-cDCGPromHeader.js\"></script>");
        callDCGPromHeaderFn("DCG");

    });
    //process end DiscPromByGroup


    //process start DiscPromByBundle
    $("#DiscPromByBundle").click(function() {
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cBDCPromHeader\" type=\"text/javascript\" src=\"../Controller/4-1-cBDCPromHeader.js\"></script>");
        callBDCPromHeaderFn("BDC");
    });
    //process end DiscPromByBundle

    // ----- START: Setup Free Promotion By Item ----- //

//process start FreePromByItem start
    $("#FreePromByItem").click(function() {
        //$("#FreePromByItem").remove();
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"FreePromByItem\" type=\"text/javascript\" src=\"../Controller/5-1-cFRIPromHeader.js\"></script>");
        callDiscPromByItemContentFn("FRI");
    });
//process start FreePromByItem end


//process start FreePromByItem start
    $("#FreePromByGroup").click(function() {
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"FreePromByItem\" type=\"text/javascript\" src=\"../Controller/6-1-cFRGPromHeader.js\"></script>");
        callDCGPromHeaderFn("FRG");
    });
//process start FreePromByItem end

    //process start FreePromByBundle
    $("#FreePromByBundle").click(function() {
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cBDCPromHeader\" type=\"text/javascript\" src=\"../Controller/7-1-cBFRPromHeader.js\"></script>");
        callBDCPromHeaderFn("BFR");
    });
    //process end FreePromByBundle
// ----- END: Setup Free Promotion By Item ----- //


    /*
     //process start FreePromByItem
     $("#FreePromByItem").click(function(){
     alert("FreePromByItem");
     });
     //process end FreePromByItem
     
     //process start FreePromByGroup
     $("#FreePromByGroup").click(function(){
     alert("FreePromByGroup");
     });
     //process end FreePromByGroup
     
     
     
     //process start FreePromByBundle
     $("#FreePromByBundle").click(function(){
     alert("FreePromByBundle");
     });
     //process end FreePromByBundle
     */
});

// set table start
var setTable = function() {
    $("table tr td").css({"padding-left": "5px", "padding-rigth": "5px", "padding-top": "2px", "padding-button": "2px"});
//    $(".k-pager-info").text("");
};
// set table end	


// Add Commas //
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
// Add Commas //


//search auto complte group description start
var data = [
    "Albania",
    "Andorra",
    "Armenia",
    "Austria",
    "Azerbaijan",
    "Belarus",
    "Belgium",
    "Bosnia & Herzegovina",
    "Bulgaria",
    "Croatia",
    "Cyprus",
    "Czech Republic",
    "Denmark",
    "Estonia",
    "Finland",
    "France",
    "Georgia",
    "Germany",
    "Greece",
    "Hungary",
    "Iceland",
    "Ireland",
    "Italy",
    "Kosovo",
    "Latvia",
    "Liechtenstein",
    "Lithuania",
    "Luxembourg",
    "Macedonia",
    "Malta",
    "Moldova",
    "Monaco",
    "Montenegro",
    "Netherlands",
    "Norway",
    "Poland",
    "Portugal",
    "Romania",
    "Russia",
    "San Marino",
    "Serbia",
    "Slovakia",
    "Slovenia",
    "Spain",
    "Sweden",
    "Switzerland",
    "Turkey",
    "Ukraine",
    "United Kingdom",
    "Vatican City"
];


//create AutoComplete UI component


var createAutocomplete = function(id, data1, defaultText) {
    $(id).kendoAutoComplete({
        dataSource: data1,
        filter: "startswith",
        placeholder: defaultText,
        //separator: ", "
    });
};

var checkNumberForDatePickerDay = function(day) {
    if (day == 1) {
        day = "01";

    } else if (day == 2) {
        day = "02";

    } else if (day == 3) {
        day = "03";

    } else if (day == 4) {
        day = "04";

    } else if (day == 5) {
        day = "05";

    } else if (day == 6) {
        day = "06";

    } else if (day == 7) {
        day = "07";

    } else if (day == 8) {
        day = "08";

    } else if (day == 9) {
        day = "09";

    } else {
        day = day;
    }
    return day;

}
var checkNumberForDatePickerMonth = function(month) {
    if (month == 1) {
        month = "01";
    } else if (month == 2) {
        month = "02";
    } else if (month == 3) {
        month = "03";
    } else if (month == 4) {
        month = "04";
    } else if (month == 5) {
        month = "05";
    } else if (month == 6) {
        month = "06";
    } else if (month == 7) {
        month = "07";
    } else if (month == 8) {
        month = "08";
    } else if (month == 9) {
        month = "09";
    } else {
        month = month;
    }
    return month;

}


//search auto complte start
var searchAutoComplteItemDesc = function(id, paramBrand, defaultText) {

    $.ajax({
        url: "../Model/mItemCode.php",
        type: "post",
        dataType: "json",
        data: {"paramBrand": paramBrand},
        sync: false,
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
            $("#itemNameArea").html("<input name=\"itemName\" class=\"\"  id=\"itemName\" type=\"text\"  value=\"" + defaultText + "\" />");
            createAutocomplete(id, objFormatAutoComplte, defaultText);


            /*click item name for get itemcode start*/
            $("#itemName").off("change");
            var k = 0;
            $("#itemName").on("change", function() {
                $.ajax({
                    url: "../Model/mItemCode.php",
                    type: "post",
                    dataType: "json",
                    data: {"paramBrand": paramBrand, "paramItemName": $("#itemName").val()},
                    sync: false,
                    success: function(data) {


                        //console.log(data[0][0]);
                        createItemCodeDropDown(paramBrand, data[0][0]);



                    }
                });

            });

            /*click item name for get itemcode start*/



            //console.log(objFormatAutoComplte);	

        }
    });
};
//search auto complte end	


//search auto complte start
var searchAutoComplteCroupDesc = function(id, textEdit) {

    $.ajax({
        url: "../Model/mPromGroup.php",
        type: "post",
        dataType: "json",
        sync: false,
        success: function(data) {
            //alert(data);
            /*
             Format
             [
             "Albania",
             "Andorra",
             "Armenia"
             ]
             */
            var formatAutoComplte = "[";
            var defaultFirstValue = "";
            $(data).each(function(index, indexEntry) {
                //alert(indexEntry[1]);

                if (index == 0) {
                    defaultFirstValue = indexEntry[1];
                    formatAutoComplte += "\"" + indexEntry[1] + "\"";
                } else {
                    formatAutoComplte += ",\"" + indexEntry[1] + "\"";
                }
            });
            formatAutoComplte += "]";
            var objFormatAutoComplte = eval("(" + formatAutoComplte + ")");
            if ("firstValue" == textEdit) {
                $("#itemNameArea").html("<input name=\"itemName\"  id=\"itemName\" type=\"text\" value=\"" + defaultFirstValue + "\" />");

            } else {
                $("#itemNameArea").html("<input name=\"itemName\"  id=\"itemName\" type=\"text\" value=\"" + textEdit + "\" />");

            }

            createAutocomplete(id, objFormatAutoComplte, "Description...");

            /*click item name for get itemcode start*/
            $("#itemName").off("change");
            var k = 0;
            $("#itemName").on("change", function() {

                $.ajax({
                    url: "../Model/mPromGroup.php",
                    type: "post",
                    dataType: "json",
                    data: {"paramItemName": $("#itemName").val()},
                    sync: false,
                    success: function(data) {

                        //alert(data[0][0]);
                        //console.log(data[0][0]);
                        //createGroupCodeDropDown(GroupCode);
                        createGroupCodeDropDown(data[0][0]);


                    }
                });

            });

            /*click item name for get itemcode start*/



            //console.log(objFormatAutoComplte);	

        }
    });
};
//search auto complte end	


// create brand  start

/*
 <select id="brand" name="brand" class="multiSelect" style="width:150px">
 <option>All Band</option>
 <option>Band01</option>
 <option>Band02</option>
 <option>Band03</option>
 <option>Band04</option>
 <option>Band05</option>
 <option>Band06</option>
 </select>
 */
var createBrand = function(disable) {
    //alert("Brand");
    $.ajax({
        url: "../Model/mBrand.php",
        dataType: "json",
        success: function(data) {
            console.log(data);
            var htmlBrand = "";
            htmlBrand += "<select id=\"brand\"  name=\"brand\" style=\"width:150px; height:26px;\" >";
            $.each(data, function(index, indexEntry) {
                htmlBrand += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
            });
            htmlBrand += "</select>";
            $("#brandArea").html(htmlBrand);

            if (disable == "disable") {

                //disable select item for edit start
                //$( "select#brand" ).prop( "disabled", true );
                //disable select item for edit end

            }

            setTimeout(function() {
                //binding multi select start
                //$(".multiSelect").multiselect();
                //binding multi select end


                //call createItemCodeDropDown start
                $("#brand").change(function() {

                    //createItemCodeDropDown($(this).val());
                    createItemCodeMultiSelect($(this).val());
                    setTimeout(function() {
                        $("#itemCode").trigger("change");
                    }, 500);
                });
                $("#brand").trigger("change");
                //createItemCodeDropDown("All");
                //call createItemCodeDropDown end
            }, 100);
        }
    });
};
// create brand end


//START: Create Brand for free item.//
//----------------------------------------------------------------------------//
var createBrandFreeItem = function(disable) {
    //alert("Brand");
    $.ajax({
        url: "../Model/mBrand.php",
        dataType: "json",
        success: function(data) {
            console.log(data);
            var htmlBrand = "";
            htmlBrand += "<select id=\"brand\"  name=\"brand\" style=\"width:150px; height:26px;\" >";
            $.each(data, function(index, indexEntry) {
                htmlBrand += "<option value=" + indexEntry[0] + ">" + indexEntry[1] + "</option>";
            });
            htmlBrand += "</select>";
            $("#brandArea").html(htmlBrand);

            if (disable == "disable") {
                //disable select item for edit start
                $( "select#brand" ).prop( "disabled", true );
                //disable select item for edit end
            }

            setTimeout(function() {
                //binding multi select start
                //$(".multiSelect").multiselect();
                //binding multi select end


                //call createItemCodeDropDown start
                $("#brand").change(function() {

                    createItemCodeDropDown($(this).val());
                    //createItemCodeMultiSelect($(this).val());
                    setTimeout(function() {
                        $("#itemCode").trigger("change");
                    }, 500);
                });
                $("#brand").trigger("change");
                createItemCodeDropDown("All");
                //call createItemCodeDropDown end
            }, 100);
        }
    });
};
//----------------------------------------------------------------------------//
//END: Create Brand for free item.//


// create item code  start
var createItemCodeDropDown = function(paramBrand, itemCode, disable) {
    //alert(itemCode);
    $.ajax({
        url: "../Model/mItemCode.php",
        dataType: "json",
        type: "post",
        data: {"paramBrand": paramBrand},
        sync: false,
        success: function(data) {
            //console.log(data);
            var htmlBrand = "";
            htmlBrand += "<select   id=\"itemCode\" name=\"itemCode\" style=\"height:26px;\">";
            $.each(data, function(index, indexEntry) {

                if (itemCode == indexEntry[0]) {
                    //alert("ok");
                    htmlBrand += "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";

                } else {
                    htmlBrand += "<option value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";

                }
            });
            htmlBrand += "</select>";

            setTimeout(function() {
                $("#itemCodeArea").html(htmlBrand);

                if (disable == "disable") {

                    //disable select item for edit start
                    $("select#itemCode").prop("disabled", true);
                    //disable select item for edit end
                }

                $("#itemCode").change(function() {
                    $.ajax({
                        url: "../Model/mItemCode.php",
                        dataType: "json",
                        type: "post",
                        data: {"paramItemCode": $(this).val()},
                        sync: false,
                        success: function(data) {
                            var itemCode = 0;
                            if (data[0][1] == "") {
                                itemCode = 0;
                            } else {
                                itemCode = data[0][1];
                            }
                            searchAutoComplteItemDesc("#itemName", paramBrand, itemCode);
                        }
                    });

                });
            }, 100);
        }
    });
};
// create item code end



//START: Create Multiselect Item Code//
//----------------------------------------------------------------------------//
    var createItemCodeMultiSelect = function(paramBrand, itemCode, disable) {
    //alert(itemCode);
    var htmlDropDownArray = new Array();
    $.ajax({
        url: "../Model/mItemCode.php",
        dataType: "json",
        type: "post",
        data: {"paramBrand": paramBrand},
        sync: false,
        success: function(data) {
            //console.log(data);
            var htmlBrand = "";
            htmlBrand += "<select class=\"multiSelect\" multiple=\"multiple\" id=\"itemCode\" name=\"itemCode\" style=\"height:26px; width:100px;\">";
            $.each(data, function(index, indexEntry) {

                if (indexEntry[0] != "All") {
                    htmlDropDownArray[index] = "<option value=" + indexEntry[0] + ">" + indexEntry[0] + " - " + indexEntry[1] + "</option>";
                } 
                
                if(itemCode) {
                    $.each(itemCode, function(index2, indexEntry2) {

                        if (indexEntry2 == indexEntry[0]) {
                            if (indexEntry2 != "All") {
                                htmlDropDownArray[index] = "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + " - " + indexEntry[1] +"</option>";
                            }
                        }
                    });
                }
            });
            htmlBrand += htmlDropDownArray;
            htmlBrand += "</select>";

            setTimeout(function() {
                $("#itemCodeArea").html(htmlBrand);
                $(".multiSelect").multiselect().multiselectfilter();
                $(".ui-multiselect").css({"width": "250px"});
                $(".ui-multiselect-menu").css({"width": "400px"});
                
                if (disable == "disable") {
                    //disable select item for edit start
                    $("select#itemCode").prop("disabled", true);
                    //disable select item for edit end
                }
            }, 100);
        }
    });
};
//----------------------------------------------------------------------------//
//END: Create Multiselect Item Code//



// create group code  start
var createGroupCodeDropDown = function(itemCode, disable) {

    $.ajax({
        url: "../Model/mPromGroup.php",
        dataType: "json",
        type: "post",
        sync: false,
        success: function(data) {
            //alert(data);
            //console.log(data);
            var htmlSelect = "";
            htmlSelect += "<select   id=\"itemCode\" name=\"itemCode\" style=\"height:26px;\">";
            $.each(data, function(index, indexEntry) {
                if (itemCode == indexEntry[0]) {
                    //alert("ok");
                    htmlSelect += "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                } else {
                    htmlSelect += "<option value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                }
            });
            htmlSelect += "</select>";

            setTimeout(function() {
                $("#itemCodeArea").html(htmlSelect);

                if (disable == "disable") {

                    //disable select item for edit start
                    $("select#itemCode").prop("disabled", true);
                    //disable select item for edit end

                }


                $("#itemCode").change(function() {

                    $.ajax({
                        url: "../Model/mPromGroup.php",
                        dataType: "json",
                        type: "post",
                        data: {"paramItemCode": $(this).val()},
                        sync: false,
                        success: function(data) {

                            //alert(data[0][1]);
                            //$("#itemName").val(data[0][1]);
                            //create auto complte start
                            var itemName = "";
                            if (data[0] == undefined) {
                                itemName = "";
                            } else {
                                itemName = data[0][1];
                            }

                            searchAutoComplteCroupDesc("#itemName", itemName);

                        }
                    });

                });

            });
        }
    });
}

// create group code end





// create unit code  start

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

var createUnitCodeDropDown = function(unitCode) {
    //alert("createUnitCodeDropDown");
    $.ajax({
        url: "../Model/mUnitCode.php",
        dataType: "json",
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";
            htmlDropDown += "<select id=\"unitCode\" name=\"unitCode\" style=\"height:26px;\">";
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
                //alert("#unitCodeArea");
            }, 100);
            //alert(htmlBrand);

        }
    });
}

// create unit code end