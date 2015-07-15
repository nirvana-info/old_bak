<?php
	include(dirname(__FILE__) . "/init.php");
	require_once(ISC_BASE_PATH . "/includes/classes/class.thumbnail.php");

	$width= (int)$_GET['width'];
	$height = (int)$_GET['height'];
	$path = $_GET['path'];

	$imagename = ISC_BASE_PATH."/".$path;
	$thumb = new Thumbnail($imagename);
	//$thumb->resizeToWidth(240);
	$thumb->resize($width,$height);
	$thumb->show();
	$thumb->destruct();
?>