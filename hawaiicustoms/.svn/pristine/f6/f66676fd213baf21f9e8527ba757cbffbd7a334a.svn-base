<?php

include("../init.php");

require_once("class.thumbnail.php");

/*	$width= 240;
	$height = 240;
//	$path = $_GET['path'];

	$imagename = "./background.jpg";
	$thumb = new Thumbnail($imagename);
//	$thumb->newImage = 'sv.jpg';
	//$thumb->resizeToWidth(240);
	$thumb->resize($width,$height);
	$thumb->save("./background_11.jpg");
//	$thumb->destruct();
*/

$no_thumb_string = array();
$file_dont_exist = array();
$image_file = array();
$orig_image_file = array();
$no_orig_file = array();

$sql = "Select * from isc_product_images where imageisthumb = 1 and imageprodid != 0 order by imageid";

$res = $GLOBALS['ISC_CLASS_DB']->Query($sql);

while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($res)) 
{
	if( strpos($row['imagefile'],"_thumb") !== false )
	{
		$file = realpath(ISC_BASE_PATH.'/product_images/' . $row['imagefile']);

		if($row['imagefile'] != '' && file_exists($file))
		{
			$image_file[] = $file;

			$orig_file = str_replace("_thumb","",$row['imagefile']);
			$new_file = realpath(ISC_BASE_PATH.'/product_images/' . $orig_file);

			if($orig_file != "" && file_exists($new_file))
			{
				// Original file
				$orig_image_file[] =$new_file;
				$width= 240;
				$height = 240;
				$imagename = $new_file;
				$thumb = new Thumbnail($imagename);
				$thumb->resize($width,$height);
				$thumb->save($file);

				$img_qry = "insert into test_image_script_backup(imageid,imageprodid) values('".$row['imageid']."','".$row['imageprodid']."')";
				$img_res =  $GLOBALS['ISC_CLASS_DB']->Query($img_qry);
			}
			else
			{
				// no oroginal file
				$no_orig_file[]	=$new_file;	
			}
		}
		else
		{
			// file not exist
			$file_dont_exist[] =$row['imageid'];
		}

	}
	else
	{
		// image name does nothave string thumb
		$no_thumb_string[] =$row['imagefile'];
	}

}

echo "<pre>";

print "Original File<br><br>";

print_r($orig_image_file);

print "<br><br>Thumbnail image file<br><br>";

print_r($image_file);

print "<br><br>file not exist<br><br>";

print_r($file_dont_exist);

print "<br><br>image name does nothave string thumb<br><br>";

print_r($no_thumb_string);

echo "</pre>";

/*
$str = "m/10045_and_10048__90798_thumb.jpg";
$path_parts = pathinfo($str);

echo $path_parts['dirname'], "<br>";
echo $path_parts['basename'], "<br>";
echo $path_parts['extension'], "<br>";
*/
?>