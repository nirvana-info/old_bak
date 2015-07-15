<?php
include(dirname(__FILE__) . "/init.php");
  $bid = $_GET["bid"];
  $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brand_series WHERE brandid='" . $bid . "' ORDER BY seriesname ASC");
  $s = 'seriesid=';
  $option = '';
  while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
    $series = $row['seriesname'];
    $seriesid = $row['seriesid'];
    $option.= "<option value=".$seriesid.">".$series."</option>";
  }
  echo $option; exit;
?>
