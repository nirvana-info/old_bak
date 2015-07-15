<?php
include(dirname(__FILE__) . "/init.php");
  $cid = $_GET["cid"];
  $ot = $_GET["ot"];
    $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT catname,categoryid FROM [|PREFIX|]categories where catparentid= $cid ORDER BY catname");
    $option = '<select name="productsubcat'.$ot.'" id="productsubcat'.$ot.'"  onchange="addRow'.$ot.'(\'dataTable'.$ot.'\',this);" >';
  $option .= ' <option value="0">Select Subcategory</option>';
  while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
    $categoryid = $row['categoryid'];
    $categoryname = $row['catname'];                   
    $option.= "<option value=".$categoryid.">".$categoryname."</option>";
  }
  $option.='</select>';
  echo $option; exit;
?>