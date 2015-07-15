<?php
  include(dirname(__FILE__) . "/init.php");
  $make = MakeURLNormal($_GET['make']);
  $model = MakeURLNormal($_GET['model']);
  $year = $_GET['year'];
//  echo $make.$model.$year;
  /*$make = "chevrolet";
  $model = "c10 pickup";
  $year = "1971"; */
  $resultbed = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT DISTINCT bedsize FROM [|PREFIX|]product_mmy pm, [|PREFIX|]cabbed_table cb where pm.make = '".$make."' and pm.model = '".$model."' and pm.year = '".$year."' AND cb.ymm_id =  pm.id");
  $optionbed = '<select name="bedsize" id="bedsize" onclick=checkYMM()>';
  $optionbed .= '<option value="">--Select bed size--</option>';

   while($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($resultbed)) {
    $bedsize = $row['bedsize'];
    $optionbed.= "<option value='$bedsize'>".$bedsize."</option>";
  }
  $optionbed.='</select>';

  $resultcab = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT DISTINCT cabsize FROM [|PREFIX|]product_mmy pm, [|PREFIX|]cabbed_table cb where pm.make = '".$make."' and pm.model = '".$model."' and pm.year = '".$year."' AND cb.ymm_id =  pm.id");
  $optioncab = '<select name="cabsize" id="cabsize" onclick=checkYMM()>';
  $optioncab .= '<option value="">--Select cab size--</option>';
  
   while($row1 = $GLOBALS["ISC_CLASS_DB"]->Fetch($resultcab)) {
    $cabsize = $row1['cabsize'];
    $optioncab.= "<option value='$cabsize'>".$cabsize."</option>";
  }
   
  $optioncab.='</select>';
  echo $optionbed.'~'.$optioncab;
  exit;
    
?>
