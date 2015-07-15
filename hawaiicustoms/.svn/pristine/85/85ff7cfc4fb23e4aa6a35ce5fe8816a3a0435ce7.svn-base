<?php
include(dirname(__FILE__) . "/init.php");
  $vid = $_GET["vid"];
    $query = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT vendorid FROM [|PREFIX|]brands where brandid= $vid");
    $vrow = $GLOBALS["ISC_CLASS_DB"]->Fetch($query);
    $vendorid_brand = $vrow['vendorid'];
    $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]vendors ORDER BY vendorname ASC");
    $option = '<select name="vendor_id" id="vendor_id" class="Field400" style="%%GLOBAL_HideVendorSelect%%" onchange="showBrand(this.value);toggleVendorSettings($(this).val());" disabled="disabled">';
  $option .= ' <option value="0">Do not assign to a vendor</option>';
  while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
    $vendor = $row['vendorname'];
    $vendorid = $row['vendorid'];                   
    if($vendorid == $vendorid_brand){
        $sel = 'selected = "selected"';
    }
    else {
        $sel = "";
    }
    $option.= "<option value=".$vendorid." $sel>".$vendor."</option>";
  }
  $option.='</select>';
  echo $option."~".$vendorid_brand; exit;
?>