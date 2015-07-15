<?php
include(dirname(__FILE__) . "/admin/init.php");
//require_once(ISC_BASE_PATH."/admin/includes/classes/class.product.php");
$GLOBALS['ISC_CLASS_ADMIN_PRODUCT'] = GetClass('ISC_ADMIN_PRODUCT');
//$GLOBALS['ISC_CLASS_ADMIN_PRODUCT']=new ISC_ADMIN_PRODUCT;

$GLOBALS['args'] = $argv;
$productFiles=array();

function outmsg($msg){
	print date('Y-m-d H:i:s ').$msg."\n";	
}

outmsg("start import....");
                
        if($GLOBALS['args'][1]=="185fe8da917cfbdce647e4e70e00f61e"){
         
         //update ymm cache first.
         $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->updateYmmsCacheData();

          $sql="select * from [|PREFIX|]import_products where flag=0 order by tempid asc";
		  $query=$GLOBALS['ISC_CLASS_DB']->Query($sql);
							
	      while($record=$GLOBALS['ISC_CLASS_DB']->Fetch($query)){
             ProcessImg($record);
	      }
        }else{
        	exit;
        }



  function ProcessImg($record){
			 
	  // Do we have a product file? We need to deal with it now damn it!
		if(isset($record['product_article']) && $record['product_article'] != '') {
			// Is this a remote file?
			$downloadDirectory = ISC_BASE_PATH."/".GetConfig('DownloadDirectory');
			if(isc_substr(isc_strtolower($record['product_article']), 0, 7) == "http://") {
				// Need to fetch the remote file
				$file = PostToRemoteFileAndGetResponse($record['product_article']);
				if($file) {
					// Place it in our downloads directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir($downloadDirectory.$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName(basename($record['product_article']));
					if(!@file_put_contents($downloadDirectory."/".$fileName, $file)) {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['product_article']),
							"downdescription" => ""
							);
					}
				}
				else {
					//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileDoesntExist');
				}
			}
			// Treating the file as a local file, in the product_fules/import directory
			else {
				// This file exists, can be imported
				if(file_exists($downloadDirectory."/import/".$record['product_article'])) {

					// Move it to our images directory
					$randomDir = strtolower(chr(rand(65, 90)));
					if(!is_dir("../".$downloadDirectory."/".$randomDir)) {
						if(!@mkdir($downloadDirectory."/".$randomDir, 0777)) {
							$randomDir = '';
						}
					}

					// Generate a random filename
					$fileName = $randomDir . "/" . GenRandFileName($record['product_article']);
					if(!@copy($downloadDirectory."/import/".$record['product_article'], $downloadDirectory."/".$fileName)) {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileUnableToMove');
					}
					else {
						$productFiles[] = array(
							"prodhash" => "",
							"downfile" => $fileName,
							"downdateadded" => time(),
							"downmaxdownloads" => 0,
							"downexpiresafter" => 0,
							"downfilesize" => filesize($downloadDirectory."/".$fileName),
							"downname" => basename($record['product_article']),
							"downdescription" => ""
							);
					}
				}
				else {
					//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductFileDoesntExist');
				}
			}
		}

		
		// Do we have an image? We need to deal with it before we do anything else
		$productImages = array();
		if(isset($record['product_images']) && $record['product_images'] != '') {
			// Is this a remote file?
			
			$imageDirectory = ISC_BASE_PATH."/".GetConfig('ImageDirectory');
			
			if(isc_substr(isc_strtolower($record['product_images']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['product_images']);
				$end = end($image_pieces);
						
				if(empty($end)) array_pop($image_pieces);
				
				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
									
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						
						if(!@file_put_contents($imageDirectory.$fileName, $image)) {
							////$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
							
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($imageDirectory."/".$fileName))) {
							
							@unlink($imageDirectory."/".$fileName);
							//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");
							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);



							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
								if($mediumName) {
									$productImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					
					}
					else {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}


				}
				

			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['product_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($imageDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($imageDirectory."/".$randomDir)) {
							if(!@mkdir($imageDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($imageDirectory."/import/".$value, $imageDirectory."/".$fileName)) {
							//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName,"large");

							$productImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($imageDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($imageDirectory."/import/".$localDirectory.$thumbFile, $imageDirectory."/".$thumbName)) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName);
									if($thumbName) {
										$productImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "tiny");
									if($tinyName) {
										$productImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateThumb($fileName, "medium");
							if($mediumName) {
								$productImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}

				}

			}
		}

		
		// Do we have an install image? We need to deal with it after product images added by blessen
		$productInstallImages = array();
		if(isset($record['install_images']) && $record['install_images'] != '') {
			// Is this a remote file?

			$InstallDirectory = ISC_BASE_PATH."/install_images";
			if(isc_substr(isc_strtolower($record['install_images']), 0, 7) == "http://") {
				// Need to fetch the remote file

				$image_pieces = preg_split("/[;,]/", $record['install_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;
					$image = PostToRemoteFileAndGetResponse($value);
					if($image) {
						// Place it in our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$fileName = $randomDir . "/" . GenRandFileName(basename($value));
						if(!@file_put_contents($InstallDirectory."/".$fileName, $image)) {
							//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						// Check to see if it is an image
						else if (!is_array(@getimagesize($InstallDirectory."/".$fileName))) {
							@unlink($InstallDirectory."/".$fileName);
							//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageInvalidFile');
						}
						else {

							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");
							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" =>  $temp_key
							);




							if($hasThumb == false) {
									

								if ($key == 0)
								{

									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}
									else {
										//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}


									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
									"imagefile" => $tinyName,
									"imageisthumb" => 2,
									"imagesort" => 0
										);
									}
									else {
										//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
									}
								}
								$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
								if($mediumName) {
									$productInstallImages[] = array(
									"imagefile" => $mediumName,
									"imageisthumb" => 3,
									"imagesort" => $temp_key
									);
								}
								else {
									//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageCorrupt');
								}

							}
						}
					}
					else {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}


				}




			}
			// Treating the file as a local file, in the product_images/import directory
			else {
				// This file exists, can be imported

				$image_pieces = preg_split("/[;,]/", $record['install_images']);
				$end = end($image_pieces);
				if(empty($end)) array_pop($image_pieces);

				foreach ($image_pieces as $key => $value)
				{
					$temp_key = $key+1;


					if(file_exists($InstallDirectory."/import/".$value)) {

						// Move it to our images directory
						$randomDir = strtolower(chr(rand(65, 90)));
						if(!is_dir($InstallDirectory."/".$randomDir)) {
							if(!@mkdir($InstallDirectory."/".$randomDir, 0777)) {
								$randomDir = '';
							}
						}

						// Generate a random filename
						$baseFileName = basename($value);
						if($baseFileName != $value) {
							$localDirectory = dirname($value)."/";
						}
						else {
							$localDirectory = '';
						}
						$fileName = $randomDir . "/" . GenRandFileName($baseFileName);
						if(!@copy($InstallDirectory."/import/".$value, $InstallDirectory."/".$fileName)) {
							//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageUnableToMove');
						}
						else {
							$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName,"large");

							$productInstallImages[] = array(
							"imagefile" => $thumbName,
							"imageisthumb" => 0,
							"imagesort" => $temp_key
							);

							// Does a thumbnail file exist?
							$thumbFile = "thumb_".$baseFileName;
							if ($key == 0)
							{
								if(file_exists($InstallDirectory."/import/".$localDirectory.$thumbFile)) {
									$thumbName = $randomDir . "/" . GenRandFileName($thumbFile);
									if(@copy($InstallDirectory."/import/".$localDirectory.$thumbFile, $InstallDirectory."/".$thumbName)) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" =>  0
										);
									}
								}
								// Otherwise, generate the thumb
								else {


									$thumbName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName);
									if($thumbName) {
										$productInstallImages[] = array(
									"imagefile" => $thumbName,
									"imageisthumb" => 1,
									"imagesort" => 0
										);
									}


									// Still need to generate "tiny" thumbnail
									$tinyName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "tiny");
									if($tinyName) {
										$productInstallImages[] = array(
								"imagefile" => $tinyName,
								"imageisthumb" => 2,
								"imagesort" => 0
										);
									}
								}
							}
							$mediumName = $GLOBALS['ISC_CLASS_ADMIN_PRODUCT']->_AutoGenerateInsThumb($fileName, "medium");
							if($mediumName) {
								$productInstallImages[] = array(
								"imagefile" => $mediumName,
								"imageisthumb" => 3,
								"imagesort" => $temp_key
								);
							}

						}
					}
					else {
						//$this->ImportSession['Results']['Warnings'][] = $record['partnumber'].GetLang('ImportProductImageDoesntExist');
					}

				}




			}

		}
		
		//fetch the new insert product id.
	   $query ="SELECT productid,prodcode,prodvendorprefix FROM [|PREFIX|]products_statistics WHERE prodcode='".$GLOBALS['ISC_CLASS_DB']->Quote($record['partnumber'])."' and prodvendorprefix = '".$record['vendorprefix']."'";
		
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		
		 while($rs=$GLOBALS['ISC_CLASS_DB']->Fetch($result)){
		 	$productId=$rs['productid'];
		 }
		 
		 if(empty($productId) || $productId==""){
		 	$productid=0;
		 }
		
	 // Are there any images?
			if(count($productImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_images', "WHERE imageprodid='".$productId."'");
				foreach($productImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_images", $image);
				}
			}
			// Are there any Install images? blessen
			if(count($productInstallImages) > 0) {
				$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_images', "WHERE imageprodid='".$productId."'");
				foreach($productInstallImages as $image) {
					$image['imageprodid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_images", $image);
				}
			}

			// Are there any Install videos ? blessen

			if ($record['install_video'] != "")
			{
				$productInstallVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['install_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productInstallVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productInstallVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('install_videos', "WHERE videoprodid='".$productId."'");
					foreach($productInstallVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("install_videos", $video);
					}
				}
			}


			// Are there any product videos ? blessen audio_clip
			if ($record['product_video'] != "")
			{
				$productVideos = array();
				$video_pieces = preg_split("/[;,]/", $record['product_video']);
				$end = end($video_pieces);
				if(empty($end)) array_pop($video_pieces);

				foreach ($video_pieces as $key => $values)
				{
					$productVideos[] = array(
					"videofile" => $values,
					"videotype" => 1,
					"videoprodid" => $productId
					);

				}

				if(count($productVideos) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('product_videos', "WHERE videoprodid='".$productId."'");
					foreach($productVideos as $video) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_videos", $video);
					}
				}
			}
			// Are there any product audio_clip ? blessen
			if ($record['audio_clip'] != "")
			{
				$product_audio_clip = array();
				$audio_pieces = preg_split("/[;,]/", $record['audio_clip']);
				$end = end($audio_pieces);
				if(empty($end)) array_pop($audio_pieces);

				foreach ($audio_pieces as $key => $values)
				{
					$product_audio_clip[] = array(
					"audiofile" => $values,
					"audiotype" => 1,
					"audioprodid" => $productId
					);

				}

				if(count($product_audio_clip) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('audio_clips', "WHERE audioprodid='".$productId."'");
					foreach($product_audio_clip as $audio) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("audio_clips", $audio);
					}
				}
			}

			// Are there any product article file ? blessen
			if (isset($record['product_article_file']) && $record['product_article_file'] != "")
			{
				$product_article = array();
				$article_pieces = preg_split("/[;,]/", $record['product_article_file']);
				$end = end($article_pieces);
				if(empty($end)) array_pop($article_pieces);

				foreach ($article_pieces as $key => $values)
				{
					$product_article[] = array(
					"articlefile" => $values,
					"articletype" => 1,
					"articleprodid" => $productId
					);

				}

				if(count($product_article) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('article_files', "WHERE articleprodid='".$productId."'");
					foreach($product_article as $article) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("article_files", $article);
					}
				}
			}

			// Are there any product instruction_file  ? blessen
			if (isset($record['instruction_file']) && $record['instruction_file'] != "")
			{
				$product_instruction = array();
				$instruction_pieces = preg_split("/[;,]/", $record['instruction_file']);
				$end = end($instruction_pieces);
				if(empty($end)) array_pop($instruction_pieces);

				foreach ($instruction_pieces as $key => $values)
				{
					$product_instruction[] = array(
					"instructionfile" => $values,
					"instructiontype" => 1,
					"instructionprodid" => $productId
					);

				}

				if(count($product_instruction) > 0) {
					$GLOBALS['ISC_CLASS_DB']->DeleteQuery('instruction_files', "WHERE instructionprodid='".$productId."'");
					foreach($product_instruction as $instruction) {
						$GLOBALS['ISC_CLASS_DB']->InsertQuery("instruction_files", $instruction);
					}
				}

			}


			// Are there any product files?
			if(isset($productFiles) && count($productFiles) > 0) {
				foreach($productFiles as $file) {
					$file['productid'] = $productId;
					$GLOBALS['ISC_CLASS_DB']->InsertQuery("product_downloads", $file);
				}
			}
			
		 //when finish image,prodfile,etc. processed,then update the import_products flag=1;
		 $updatesql="update [|PREFIX|]import_products set flag=1 where tempid=".$record['tempid'];
		  $GLOBALS['ISC_CLASS_DB']->Query($updatesql);

		 outmsg($record['vendorprefix']."_".$record['partnumber']." Over import....");
	   
	}
	outmsg("End import....");
?>