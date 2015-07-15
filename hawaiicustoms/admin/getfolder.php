<?php
session_start();
include(dirname(__FILE__) . "/init.php");
  $q = $_GET["q"];
//  $q=3;
  $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT vendorid FROM [|PREFIX|]brands where brandid= $q");
  $vrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($query);
  $vendorid_brand = $vrow['vendorid'];
  $_SESSION['congobrand'] = $vendorid_brand;
  exit;
?>
