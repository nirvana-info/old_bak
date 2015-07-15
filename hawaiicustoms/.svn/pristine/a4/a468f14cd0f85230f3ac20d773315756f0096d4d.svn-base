<?php
include(dirname(__FILE__) . "/init.php");
  $q = $_GET["catid"];
  $result = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE categoryid='" . $q . "'");
  $row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);
  $parent = $row['catparentid'];
  $add = '';
  if($parent == '0') {
      $resparent = $GLOBALS["ISC_CLASS_DB"]->Query("SELECT * FROM [|PREFIX|]categories WHERE catparentid='" . $q . "'");
      $cnt = $GLOBALS["ISC_CLASS_DB"]->CountResult($resparent);
      if($cnt > 0) {
          $add = "wrong";
      }
      else {
          $add = "correct1";
      }
  }
  else {
      $add = "correct2";
  }
  echo $add; exit;
?>
