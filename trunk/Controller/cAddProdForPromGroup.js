//create select input unit code
createUnitCodeDropDown();


// clear field   start
var clearFielddata = function() {

    $("#minimum").val("");
//    createBrand();    
    //createItemCodeDropDown($("#brand").val());
    createItemCodeMultiSelect($("#brand").val());
    $("#itemName").removeAttr("readonly").css({"background": "white"});
    $("#submit").val("Add");
    $("#paramAction").val("add");
    //$("#groupDesc").val("");
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
var validationFn = function(id) {
    if ($("#itemCode").val() == "" || $("#itemCode").val() == null) {
        alert("กรุณาใส่ข้อมูล Item Code");
        return false;
    } else if ($("#minimum").val() == "") {
        alert("กรุณาใส่ข้อมูล Minimum Order");
        return false;
    } else {
        // insert to databse start
        insertDataFn(id);
        // insert to database end
    }
};
// check validation end


// insert to databse start
var insertDataFn = function(groupCode) {
    $.ajax({
        url: "../Model/mAddProdForPromGroup.php",
        type: "post",
        dataType: "json",
        data: {"paramGroupCode": groupCode, "paramItemCode": $("#itemCode").val(), "paramMinimum": $("#minimum").val(), "paramUnitCode": $("#unitCode").val(), "paramAction": $("#paramAction").val()},
        success: function(data) {

            /*if (data[0] == "id-already") {
             alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");
             }
             if (data[0] == "save-success") {
             alert("บันทึกข้อมูลใหม่แล้ว");
             clearFielddata();
             showAlldata(groupCode);
             $("#minimum").val("0");
             }*/
            var msg = "";
            if (data[0] && data[0] != "update-success") {
                $.each(data, function(idx, obj) {
                    msg += "\n - " + obj;
                });
                alert("บันทึกข้อมูลเรียบร้อยแล้ว \nและไม่สามารถบันทึกข้อมูลต่อไปนี้ได้เนื่องจากมีข้อมูลอยู่แล้ว" + msg);
                clearFielddata();
                showAlldata(groupCode);
                $("#minimum").val("0");
            } else if (data[0] == "update-success") {

                alert("บันทึกข้อมูลที่แก้ไขแล้ว");
                clearFielddata();
                showAlldata(groupCode);
                $("#minimum").val("0");
                $("#groupCode").removeAttr("readonly").css("background", "#ffffff");
                $("#submit").val("Add");
            } else {
                alert("บันทึกข้อมูลใหม่แล้ว");
                clearFielddata();
                showAlldata(groupCode);
                $("#minimum").val("0");
            }
        }
    });
};
// insert to database end

var manangementAction = function(paramGroupCode) {
// delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {
        var idDel = this.id.split("-");
        var id = idDel[1];

        if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
            $.ajax({
                url: "../Model/mAddProdForPromGroup.php",
                type: "POST",
                dataType: "JSON",
                data: {"paramAction": "delete", "paramItemCode": id, "paramGroupCode": paramGroupCode},
                success: function(data) {
                    if (data[0] == "success") {
                        showAlldata($(".groupCode").text());
                    }
                }
            });
        }//confirm
    });
// delete data end
// edit data start
    $(".btnEdit").on("click", function() {

        var idEdit = this.id.split("-");
        var id = idEdit[1];
        //alert(id);
        //show form start
        /*
         $(".prodGroupForPromFrom").show();
         $("h3.addPromGroup").show();
         $("#submit").show();
         $("#cancel").show();
         */
        //show form end

        //add id for send to edit start
        $(".idEdit").remove();
        //$("form#prodGroupForProm table").append("<input type=\"hidden\" id=\"idEdit-"+id+"\" name=\"idEdit-"+id+"\" class=\"idEdit\">");
        $("#paramAction").val("editAction");

        //add id for send to edit end

        $.ajax({
            url: "../Model/mAddProdForPromGroup.php",
            type: "POST",
            dataType: "json",
            data: {"paramAction": "edit", "paramItemCode": id, "paramGroupCode": paramGroupCode},
            success: function(data) {
                //alert(data);
                //$("#itemCode").val(data[0]);
                //$("#unitCode").val(data[1]);
                //$("#minimum").val(data[2]);
                //alert(data[0]);//ItemCode
                //alert(data[1]);//unit code
                //alert(data[2]);//minimum order

                //createItemCodeDropDown("All",data[0]);
                createItemCodeDropDown("All", data[0], "disable");
                $("select#brand").prop("disabled", true);
                $("#itemName").attr({"readonly": "readonly"}).css({"background": "#f5f5f5"});

                //createItemNameText(data[0]);
                createUnitCodeDropDown(data[1]);
                $("#minimum").val(data[2]);
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


//add item start
    $(".btnAdd").click(function() {
        var idEdit = this.id.split("-");
        var id = idEdit[1];
        $.ajax({
            url: "../View/vAddProdForPromGroup.php",
            type: "POST",
            dataType: "html",
            data: {"paramGroupCode": id},
            success: function(data) {
                $("#content").html(data);
            }
        });
    });
//add item end
};

// show all  data start
var showAlldata = function(paramGroupCode) {
    $.ajax({
        url: "../Model/mAddProdForPromGroup.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramGroupCode": paramGroupCode},
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
                height: 350,
                columns: [
                    {field: "field1", width: '10%'},
                    {field: "field2", width: '45%'},
                    {field: "field3", width: '14%'},
                    {field: "field4", width: '15%'},
                    {field: "field5", width: '15%'}
                ]
            });

            //START: Set Table//
            setTable();
//            $("table#grid tbody tr").each(function() {
//                $("td:eq(2)", this).css({"text-align":"right", "padding-rigth":"5px"}); 
//            });
            //END Set Table.//


            //binding mangement function start
            manangementAction(paramGroupCode);

            //sorting start
            setTimeout(function() {
                $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    manangementAction(paramGroupCode);
                });
            }, 1000);


        }
    });
};
// show all data end



//cAddProdForPromGroup.js start
var callAddProdForPromGroupFn = function(id) {

    $.ajax({
        url: "vAddProdForPromGroup.php",
        type: "post",
        data: {"paramGroupCode": id},
        dataType: "html",
        success: function(data) {
            $("#content").empty();
            $("#content").html(data);


            //call crete brand start
            createBrand();
            //call crete brand end



            //call showAllData start
            showAlldata(id);
            //call showAllData end
            //show hide form start
            $("input#ShowHide").click(function() {
                //showHideFormFn();
            });
            //show hide form end

            /*click submit start*/
            $("form#AddProdForPromGroup").submit(function() {

                // check validation start
                validationFn(id);
                // check validation end              
                return false;
            });

            /*click submit end*/

            //back to prodGroupForProm start
            $("#back").click(function() {
                //$("#cProdGroupForProm").remove();
                $(".Controller").remove();
                $("head").append("<script class=\"Controller\" id=\"cProdGroupForProm\" type=\"text/javascript\" src=\"../Controller/cProdGroupForProm.js\"></script>");
                callprodGroupForPromContentFn();
            });
            //back to prodGroupForProm end
            $("#minimum").keyup(function() {
                this.value = this.value.replace(/[^0-9\.]/g, '');
            });
        }
    });
};
//callprodGroupForProm end




	