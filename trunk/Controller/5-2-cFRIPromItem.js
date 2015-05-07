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
                if (BreakBy === indexEntry[0]) {
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
            htmlDropDown += " (B-Baht P-Percent) ";
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
    createItemCodeDropDown("All");
    createBrand();
    $("#itemName").removeAttr("readonly").css({"background": "white"});

    $("#limitFreeQty").val("0");
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
var validationFn = function(id, paramPromType) {
    
    if($("#itemCode").val() == null || $("#itemCode").val() == ""){
        alert("กรุณาใส่ข้อมูล Item Code.");
        return false;
    }
    
    if ($("#itemName").val() == "") {
        alert("กรุณาใส่ข้อมูล Item Name ");
        return false;
    } else {
        // insert to databse start
        insertDataFn(id, paramPromType);
        // insert to database end
    }
};
// check validation end


// insert to databse start
var insertDataFn = function(paramPromNo, paramPromType) {
    /*	
     ---Field---     
     promNo
     itemCode
     itemName
     breakBy
     disCountFor [No]
     limitFreeQty
     freeUnitCode
     limitDiscBath [No]
     
     ---Parameter---     
     paramPromNo
     paramItemCode
     paramItemName
     paramBreakBy
     paramDisCountFor [No]
     paramLimitFreeQty
     paramFreeUnitCode
     paramLimitDiscBath [No]
     */

    $.ajax({
        url: "../Model/5-2-mFRIPromStep.php",
        type: "post",
        dataType: "json",
        data: {"paramPromNo": paramPromNo,
            "paramItemCode": $("#itemCode").val(),
            "paramBreakBy": $("#breakBy").val(),
//            "paramDisCountFor": $("#disCountFor").val(),
            "paramLimitFreeQty": $("#limitFreeQty").val(),
            "paramFreeUnitCode": $("#unitCode").val(),
//            "paramLimitDiscBath": $("#limitDiscBath").val(),
            "paramAction": $("#paramAction").val(),
            "paramPromType": paramPromType},
        success: function(data) {
            //alert(data);
            /*if (data[0] === "id-already") {
                alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");
                clearFielddata();
                showAlldata(paramPromType, paramPromNo);
            }

            if (data[0] === "save-success") {
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(paramPromType, paramPromNo);
            }

            if (data[0] === "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว”");
                clearFielddata();
                showAlldata(paramPromType, paramPromNo);
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
                showAlldata(paramPromType, paramPromNo);
            }else if (data[0] == "update-success") {
                alert("บันทึกข้อมูลที่แก้ไขแล้ว”");
                clearFielddata();
                showAlldata(paramPromType, paramPromNo);
                $("#submit").val("Add");
                $("#paramAction").val("add");
            }else{
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(paramPromType, paramPromNo);
            }
        }
    });
};
// insert to database end


//funciont manage action start
var manangementAction = function(paramPromType, paramPromNo) {
    // delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {
        var idDel = this.id.split("-");
        var id = idDel[1];
        $.ajax({
            url: "../Model/5-2-mFRIPromStep.php",
            type: "POST",
            dataType: "JSON",
            data: {"paramAction": "checkUseProm", "paramItemCode": id, "paramPromType": paramPromType, "paramPromNo": paramPromNo},
            success: function(data) {
                if (data[0] === "id-already") {
                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                } else {

                    if (confirm("ยืนยันลบข้อมูลใช่ไหม")) {
                        $.ajax({
                            url: "../Model/2-2-mAddItemDiscountProm.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {"paramAction": "delete", "paramItemCode": id, "paramPromType": paramPromType, "paramPromNo": paramPromNo},
                            success: function(data) {
                                if (data[0] === "id-already") {
                                    alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                                } else {
                                    if (data[0] === "success") {
                                        showAlldata(paramPromType, paramPromNo);
                                    }
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
            url: "../Model/5-2-mFRIPromStep.php",
            type: "POST",
            dataType: "json",
            data: {"paramAction": "edit", "paramItemCode": id, "paramPromNo": $("#paramProNo").text(), "paramPromType": paramPromType},
            sync: false,
            success: function(data) {

                //createItemCodeDropDown = function(paramBrand,itemCode);
                createItemCodeDropDown("All", data[0], "disable");
                //disable select item for edit start
                $("select#brand").prop("disabled", true);
                //disable select item for edit end
                $("#itemName").val(data[4]).attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});

                createBreakByDropDown(data[1]);
                createDiscForDropDown(data[2]);
                createUnitCodeDropDown(data[4]);
                //createBrand();

                $("#limitFreeQty").val("" + data[2] + "");
                //$("#unitCode").val(""+data[4]+"");
                $("#limitDiscBath").val("" + data[5] + "");

                //call function for dropdown is selected end

                //manage change everlopment for add insert
                $("#submit").val("Save");
                $("#cancel").click(function() {
                    $("#submit").val("Add");
                    $("#paramAction").val("add");
                    clearFielddata();
                });
            }
        });
    });
    // edit data end

    //promotion step start
    $(".btnPromStep").click(function() {
        var idArray = this.id.split("-");
        var paramPromCode = idArray[1];
        var paramPromNo = $("#paramProNo").text();
        //alert(id);

        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"5-3-cFRIPromStep.js\" type=\"text/javascript\" src=\"../Controller/5-3-cFRIPromStep.js\"></script>");
        callcPromStepDiscountPromByItemFn(paramPromNo, paramPromCode, paramPromType);
    });
    //promotion step end
};

//funciont manage action end


// show all  data start
var showAlldata = function(paramPromType, paramPromNo) {
    $.ajax({
        url: "../Model/5-2-mFRIPromStep.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramPromType": paramPromType, "paramPromNo": paramPromNo},
        sync: false,
        success: function(data) {

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
                height: 350,
                columns: [
                    {field: "field1", width: '15%'},
                    {field: "field2", width: '15%'},
                    {field: "field3", width: '25%'},
                    {field: "field4", width: ''},
                    {field: "field5", width: ''},
                    {field: "field6", width: '23%'}
                ]
            });
            setTable();
            $("table#grid tbody tr").each(function() {
                $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
            });
            // biding grid method end


            //binding mangement function start
            manangementAction(paramPromType, paramPromNo);

            //sorting start
            setTimeout(function() {
                 $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    $("table#grid tbody tr").each(function() {
                        $("td", this).eq(4).css({"text-align": "right", "padding-rigth": "5px"});
                    });
                    manangementAction(paramPromType, paramPromNo);
                });
            }, 1000);
        }
    });
};
// show all data end


//5-2-cAddProdFreePromItem.js start
var callAddItemDiscountPromFn = function(id, paramPromType) {
    $.ajax({
        url: "5-2-vFRIPromItem.php",
        type: "POST",
        data: {"paramPromNo": id},
        dataType: "html",
        sync: false,
        success: function(data) {
            $("#content").empty();
            $("#content").html(data);

            //call crete brand start
            createBrand();
            //call crete brand end
            //create select input unit code
            createUnitCodeDropDown();

            //call showAllData start
            showAlldata(paramPromType, id);
            //call showAllData end



            /*check number in text field before press submit start*/
            $("#limitFreeQty").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });

            $("#limitDiscBath").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
            /*check number in text field before press submit end*/


            /*click submit start*/
            $("form#addItemDiscountProm").submit(function() {

                // check validation start
                validationFn(id, paramPromType);
                // check validation end

                return false;
            });

            /*click submit end*/


            //back to prodGroupForProm start
            $("#back").click(function() {
                //$("#cProdGroupForProm").remove();
                $(".Controller").remove();
                $("head").append("<script class=\"Controller\" id=\"FreePromByItem\" type=\"text/javascript\" src=\"../Controller/5-1-cFRIPromHeader.js\"></script>");
                callDiscPromByItemContentFn(paramPromType);
                return false;
            });
            //back to prodGroupForProm end
        }

    });

};
//callprodGroupForProm end




	