<?php
include(dirname(__FILE__) . "/init.php");
  $cid = $_GET["cid"];
  $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT catname,categoryid FROM [|PREFIX|]categories where catparentid= $cid ORDER BY catname");
  $option = '';
  while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($query)) {
    $categoryid = $row['categoryid'];
    $categoryname = $row['catname'];                   
    $option.= "<option value=".$categoryid.">".$categoryname."</option>";
  }
  echo $option; exit;
?>