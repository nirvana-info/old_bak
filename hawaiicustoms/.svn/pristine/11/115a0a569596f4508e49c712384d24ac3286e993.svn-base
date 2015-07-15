<?php
include(dirname(__FILE__) . "/init.php");
  $sid = $_GET["sid"];
//$sid = 8;
  $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]brand_series WHERE brandid='" . $sid . "' ORDER BY seriesname ASC");
  $option = '<select name="productseries" id="productseries" class="Field200">';
  $option .= ' <option value="0">-- Choose an Existing Series --</option>';
  while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
    $series = $row['seriesname'];
    $seriesid = $row['seriesid'];
    $option.= "<option value=".$seriesid.">".$series."</option>";
  }
  $option.='</select>';
  echo $option; exit;
?>
