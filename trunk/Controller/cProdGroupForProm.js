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
            $("td#groudDescSearchArea").html("<input name=\"groudDescSearch\"  id=\"groudDescSearch\" type=\"text\" />");
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



//search auto complte group description end.




// clear field   start
var clearFielddata = function() {
    $("#groupCode").val("");
    $("#groupDesc").val("");

    $("#submit").val("Add");
    $("#paramAction").val("add");
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


var manangementAction = function() {

    // delete data start
    $(".btnDel").off("click");
    $(".btnDel").on("click", function() {
//        $.ajax({
//            url: "../Model/mProdGroupForPromService.php",
//            type: 'POST',
//            dataType: 'JSON',
//            
//        })
        if (confirm('ยืนยันลบข้อมูลใช่ไหม ?')) {
            var idDel = this.id.split("-");
            var id = idDel[1];
            $.ajax({
                url: "../Model/mProdGroupForPromService.php",
                type: "POST",
                dataType: "JSON",
                data: {"paramAction": "delete", "paramGroupCode": id},
                success: function(data) {

                    if (data[0] == "id-already") {
                        alert("ไม่สามารถลบข้อมูลได้ เนื่องจากยังมีการใช้งานอยู่");
                    }
                    if (data[0] == "success") {
                        showAlldata();
                        createGroupPromCodeDropDown();
                    }
                }
            });
        }
    });
    // delete data end

    // edit data start
    $(".btnEdit").off("click");
    $(".btnEdit").on("click", function() {

        var idEdit = this.id.split("-");
        var id = idEdit[1];

        //show form start
        $(".prodGroupForPromFrom").show();
        $("h3.addPromGroup").show();
        $("#submit").show();
        $("#cancel").show();
        //show form end

        //add id for send to edit start
        $(".idEdit").remove();
        //$("form#prodGroupForProm table").append("<input type=\"hidden\" id=\"idEdit-"+id+"\" name=\"idEdit-"+id+"\" class=\"idEdit\">");
        $("#paramAction").val("editAction");
        $("#groupCode").attr("readonly", "readonly").css("background", "#cccccc");
        //add id for send to edit end

        $.ajax({
            url: "../Model/mProdGroupForPromService.php",
            type: "POST",
            dataType: "json",
            data: {"paramAction": "edit", "paramGroupCode": id},
            success: function(data) {

                $("#groupCode").val(data[0]);
                $("#groupDesc").val(data[1]);

                $("#submit").val("Save");

                $("#cancel").click(function() {
                    $("#paramAction").val("add");
                    $("#submit").val("Add");
                    $("#groupCode").removeAttr("readonly").css("background", "white");
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
        //$("#cAddProdForPromGroup").remove();
        $(".Controller").remove();
        $("head").append("<script class=\"Controller\" id=\"cAddProdForPromGroup\" type=\"text/javascript\" src=\"../Controller/cAddProdForPromGroup.js\"></script>");
        callAddProdForPromGroupFn(id);

    });
    //add item end
};


// show all  data start
var showAlldata = function(searchText) {
    //alert(searchText);
    $.ajax({
        url: "../Model/mProdGroupForPromService.php",
        type: "post",
        dataType: "html",
        data: {"paramAction": "showData", "paramSearchText": searchText},
        sync: false,
        success: function(data) {
            //alert(data);

            $("#showAllData").html(data);

            // biding grid method strat
            $("#gird").kendoGrid({
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
                    {field: "field1", width: '30%'},
                    {field: "field2", width: '35%'},
                    {field: "field3", width: '35%'}
                ]
            });
            setTable();
            // biding grid method end

            //binding mangement function start
            manangementAction();

            //sorting start
            setTimeout(function() {
                $("table thead th.k-header, .k-pager-wrap, .k-grid-pager, .k-widget").on("click", function() {
                    setTable();
                    manangementAction();                    
                });
            }, 1000);
            //auto complete start
            //createGroupPromCodeDropDown();
        }
    });
};
// show all data end



//callprodGroupForProm start
var callprodGroupForPromContentFn = function() {

    $.ajax({
        url: "vProdGroupForProm.php",
        type: "get",
        dataType: "html",
        success: function(data) {
            $("#content").empty();
            $("#content").html(data);

            //call showAllData start
            showAlldata();
            //call showAllData end

            //create dropdownc prom code
            createGroupPromCodeDropDown();
            //create auto complte start
            searchAutoCompltePromGroup("#groudDescSearch");


            //form search start here
            $("form#search").submit(function() {
                showAlldata($("#groudDescSearch").val());
                //searchAutoCompltePromGroup("#groudDescSearch");
                return false;
            });
            //form search end here


            /*click submit start*/
            $("form#prodGroupForProm").submit(function() {

                // check validation start
                if ($("#groupCode").val() == "") {
                    alert("กรุณาใส่ข้อมูล Group Code");
                    return false;
                } else if ($("#groupDesc").val() == "") {
                    alert("กรุณาใส่ข้อมูล Group Description");
                    return false;
                }

                // check validation end


                // insert to databse start
                $.ajax({
                    url: "../Model/mProdGroupForPromService.php",
                    type: "post",
                    dataType: "json",
                    data: {"paramGroupCode": $("#groupCode").val(), "paramGroupDesc": $("#groupDesc").val(), "paramAction": $("#paramAction").val()},
                    success: function(data) {

                        if (data[0] == "id-already") {
                            alert("ไม่สามารถบันทึกข้อมูลได้เนื่องจากมีข้อมูลอยู่แล้ว");
                        }
                        if (data[0] == "save-success") {
                            alert("บันทึกข้อมูลใหม่แล้ว");
                            clearFielddata();
                            showAlldata();
                            createGroupPromCodeDropDown();
                        }
                        if (data[0] == "update-success") {
                            alert("บันทึกข้อมูลที่แก้ไขแล้ว");
                            clearFielddata();
                            showAlldata();
                            $("#groupCode").removeAttr("readonly").css("background", "#ffffff");
                            $("#submit").val("Add");
                            createGroupPromCodeDropDown();
                        }

                    }
                });
                // insert to database end

                return false;
            });
            /*click submit end*/
        }
    });
};
//callprodGroupForProm end

//group code gernarate for search stat here.
/*
 <select class="form-control input-sm">
 <option>All</option>
 <option>DE5233</option>
 </select>
 
 */

var createGroupPromCodeDropDown = function(groupCode) {
    //alert("createGroupPromCodeDropDown");
    $.ajax({
        url: "../Model/mPromGroup.php",
        dataType: "json",
        sync: false,
        success: function(data) {
            //console.log(data);
            var htmlDropDown = "";

            htmlDropDown += "<select class=\"form-control input-sm\" id=\"GroupCode\" name=\"GroupCode\">";
            htmlDropDown += "<option selected value=All>All-All</option>";
            $.each(data, function(index, indexEntry) {
                if (groupCode == indexEntry[0]) {

                    htmlDropDown += "<option selected value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                } else {
                    htmlDropDown += "<option value=" + indexEntry[0] + ">" + indexEntry[0] + "-" + indexEntry[1] + "</option>";
                }
            });
            htmlDropDown += "</select>";

            setTimeout(function() {
                $("#groupCodeArea").html(htmlDropDown);

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
