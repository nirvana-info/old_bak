<?php
session_start();
  $q = $_GET["q"];
  $_SESSION['congoseries'] = $q;
  exit;
?>
