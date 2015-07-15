<?php
include(dirname(__FILE__) . "/init.php");
  $q = $_GET["catid"];
  $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . $q . "'");
  $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
  $catdept = $row['catdeptid'];
  echo $catdept; exit;
?>
