<?php

include_once("../config.php");
$paramBrand = $_POST['paramBrand'];
$paramItemCode = $_POST['paramItemCode'];
$paramItemName = $_POST['paramItemName'];
//$paramItemName=$_GET['paramItemName'];
//search for text name for get itemcode
if ($paramItemName != "") {
    $sql = "
		select ItemCode,ItemDesc from Item
		where ItemDesc='$paramItemName' order by ItemCode;
		";
} else {

    if ($paramItemCode != "") {
        $sql = "
		select ItemCode,ItemDesc from Item
		where ItemCode='$paramItemCode' order by ItemCode;
		";
    } else {
        $sql = "
		select ItemCode,ItemDesc from Item
		where ClassCode='$paramBrand' or '$paramBrand'='All'
                order by ItemCode
		";
    }
}
$sqlConv = iconv("utf-8", "tis-620", $sql);
$rs = odbc_exec($conn, $sqlConv);


if (!$rs) {
    exit("Error in SQL");
} else {

    $jsonItem = "";
    $jsonItem.="[";
    $i = 0;
    while (odbc_fetch_row($rs)) {
        $jsonItemCode = iconv("tis-620", "utf-8", odbc_result($rs, "ItemCode"));
        $jsonItemDesc = iconv("tis-620", "utf-8", odbc_result($rs, "ItemDesc"));
        if ($i == 0) {
            $jsonItem.="[";
            $jsonItem.="\"" . $jsonItemCode . "\"";
            $jsonItem.=",\"" . $jsonItemDesc . "\"";
            $jsonItem.="]";
        } else {
            $jsonItem.=",[";
            $jsonItem.="\"" . $jsonItemCode . "\"";
            $jsonItem.=",\"" . $jsonItemDesc . "\"";
            $jsonItem.="]";
        }
        $i++;
    }
    $jsonItem.="]";
}





echo $jsonItem;



/*

  if($brand=="All"){
  echo"[[\"10101001\",\"Item01\"],[\"10101002\",\"Item02\"],[\"10101003\",\"Item03\"],[\"10101004\",\"Item04\"],[\"10101005\",\"Item05\"],[\"10101006\",\"Item06\"],[\"10101007\",\"Item07\"]]";
  }else if($brand=="001"){
  echo"[[\"10101001\",\"Item011\"],[\"101010021\",\"Item012\"],[\"101010013\",\"Item013\"],[\"101010014\",\"Item014\"],[\"101010015\",\"Item015\"],[\"101010016\",\"Item016\"],[\"101010017\",\"Item017\"]]";

  }else if($brand=="002"){
  echo"[[\"101010021\",\"Item021\"],[\"101010022\",\"Item022\"],[\"101010023\",\"Item023\"],[\"101010024\",\"Item024\"],[\"101010025\",\"Item025\"],[\"101010026\",\"Item026\"],[\"101010027\",\"Item027\"]]";

  }else if($brand=="003"){

  echo"[[\"101010031\",\"Item031\"],[\"101010032\",\"Item032\"],[\"101010033\",\"Item033\"],[\"101010034\",\"Item034\"],[\"101010035\",\"Item035\"],[\"101010036\",\"Item036\"],[\"101010037\",\"Item037\"]]";
  }else if($brand=="004"){
  echo"[[\"101010041\",\"Item041\"],[\"101010042\",\"Item042\"],[\"101010043\",\"Item043\"],[\"101010044\",\"Item044\"],[\"101010045\",\"Item045\"],[\"101010046\",\"Item046\"],[\"101010047\",\"Item047\"]]";

  }else if($brand=="005"){

  echo"[[\"101010051\",\"Item051\"],[\"101010052\",\"Item052\"],[\"101010053\",\"Item053\"],[\"101010054\",\"Item054\"],[\"101010055\",\"Item055\"],[\"101010056\",\"Item056\"],[\"101010057\",\"Item057\"]]";
  }else if($brand=="006"){

  echo"[[\"101010061\",\"Item01\"],[\"101010062\",\"Item062\"],[\"101010063\",\"Item063\"],[\"101010064\",\"Item064\"],[\"101010065\",\"Item065\"],[\"101010066\",\"Item066\"],[\"101010067\",\"Item067\"]]";
  }

  //echo"[[\"10101001\",\"Item01\"],
  //[\"10101002\",\"Item02\"],[\"10101003\",\"Item03\"],[\"10101004\",
  //\"Item04\"],[\"10101005\",\"Item05\"],[\"10101006\",\"Item06\"],[\"10101007\",\"Item07\"]]";


  if($paramItemCode=="10101001"){
  echo"[[\"10101001\",\"Item02\"]]";
  }else if($paramItemCode=="10101002"){
  echo"[[\"10101002\",\"Item02\"]]";
  }else if($paramItemCode=="10101003"){
  echo"[[\"10101003\",\"Item03\"]]";
  }else if($paramItemCode=="10101004"){
  echo"[[\"10101004\",\"Item04\"]]";
  }else if($paramItemCode=="10101005"){
  echo"[[\"10101005\",\"Item05\"]]";
  }else if($paramItemCode=="10101006"){
  echo"[[\"10101006\",\"Item06\"]]";
  }else if($paramItemCode=="10101007"){
  echo"[[\"10101007\",\"Item07\"]]";
  }else if($paramItemCode=="10101008"){
  echo"[[\"10101008\",\"Item08\"]]";
  }
 */
?>