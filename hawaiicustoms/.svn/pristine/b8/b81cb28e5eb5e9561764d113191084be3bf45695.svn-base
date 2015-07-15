<?php

if (!defined('ISC_BASE_PATH')) {
	die();
}

require_once(ISC_BASE_PATH.'/lib/class.xml.php');

class ISC_ADMIN_REMOTE_IMAGEMANAGER extends ISC_XML_PARSER
{
	/**
	 * Handle the incoming action and pass it off to the correct method.
	 */
	public function HandleToDo()
	{
		ConvertRequestInput();
		$what = isc_strtolower(@$_REQUEST['w']);
		switch ($what) {
			case 'uploadimage':
				$this->UploadImage();
				break;
			case 'getimageslist':
				$this->GetImagesList();
				break;
		}
	}

	/**
	 * Fetch and return a list of images in a specific folder. Will only include valid images and will recurse in to subfolders.
	 *
	 * @param string The path to fetch images from.
	 * @return array An array of the images that were found.
	 */
	private function FetchImages($path='')
	{
		$images = array();
		$realPath = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/uploaded_images/'.$path;
		if(!is_dir($realPath)) {
			return $images;
		}

		$files = scandir($realPath);
		foreach($files as $file) {
			if(substr($file, 0, 1) == '.' || (!is_dir($realPath.'/'.$file) && !$this->IsImageFile($file))) {
				continue;
			}
			else if(is_dir($realPath.'/'.$file)) {
				$images = array_merge($images, $this->FetchImages($path.$file.'/'));
			}
			else {
				$images[] = $path.$file;
			}
		}

		return $images;
	}

	/**
	 * Build and output a list of images in the image uploads directory and format them using Javascript
	 * so that the TinyMCE image manager can display a list of them.
	 */
	private function GetImagesList()
	{
		header('Content-type: text/javascript');

		$imageList = $this->FetchImages();
		echo 'var tinyMCEImageList = new Array(';
		foreach($imageList as $k => $image) {
			$comma = ',';
			if(!isset($imageList[$k+1])) {
				$comma = '';
			}
			echo '["'.$image.'","'.GetConfig('AppPath').'/'.GetConfig('ImageDirectory').'/uploaded_images/'.$image.'"]'.$comma."\n";
		}
		echo ');';
		exit;
	}

	/**
	 * Upload a new image from the Image Manager or TinyMCE itself. Images are thrown in the uploaded_images
	 * directory. Invalid images (no dimensions available, mismatched type) are not accepted. Will output
	 * a JSON encoded array of details about the image just uploaded.
	 */
	private function UploadImage()
	{
		if(empty($_FILES['Filedata'])) {
			exit;
		}

		$_FILES['Filedata']['filesize'] = NiceSize($_FILES['Filedata']['size']);
		$_FILES['Filedata']['id'] = substr(md5($_FILES['Filedata']['name']), 0, 10);
		$_FILES['Filedata']['errorfile'] = false;
		$_FILES['Filedata']['imagepath'] = GetConfig('AppPath').'/'.GetConfig('ImageDirectory').'/uploaded_images/';
		$_FILES['Filedata']['duplicate'] = false;

		if($_FILES['Filedata']['error'] != UPLOAD_ERR_OK) {
			$_FILES['Filedata']['erorrfile'] = 'badupload';
			die(isc_json_encode($_FILES));
		}

		$tmpName = $_FILES['Filedata']['tmp_name'];
		$name = basename($_FILES['Filedata']['name']);
		$name = str_replace(' ', '_', $name);
		$destination = ISC_BASE_PATH.'/'.GetConfig('ImageDirectory').'/uploaded_images/'.$name;

		if(!$this->IsValidImageFile($tmpName, $_FILES['Filedata']['type'])) {
			$_FILES['FileData']['errorfile'] = 'badtype';
		}
		else if(!$this->IsImageFile(isc_strtolower($name))) {
			$_FILES['Filedata']['errorfile'] = 'badname';
		}
		else if(file_exists($destination)) {
			$_FILES['Filedata']['duplicate'] = true;
		}
		else if(!@move_uploaded_file($tmpName, $destination)) {
			$_FILES['Filedata']['errorfile'] = 'badupload';
		}

		// Get the image dimensions so we can show a thumbnail
		list($imgWidth, $imgHeight) = @getimagesize($destination);
		if(!$imgWidth || !$imgHeight) {
			$imgWidth = 200;
			$imgHeight = 150;
		}

		$_FILES['Filedata']['origwidth'] = $imgWidth;
		$_FILES['Filedata']['origheight'] = $imgHeight;

		if($imgWidth > 200) {
			$imgHeight = (200/$imgWidth) * $imgHeight;
			$imgWidth = 200;
		}

		if($imgHeight > 150) {
			$imgWidth = (150/$imgHeight) * $imgWidth;
			$imgHeight = 150;
		}

		$_FILES['Filedata']['width'] = $imgWidth;
		$_FILES['Filedata']['height'] = $imgHeight;
		unset($_FILES['Filedata']['tmp_name']);

		echo isc_json_encode($_FILES);
		exit;
	}

	/**
	 * Check if a particular image is valid by checking the uploaded MIME type vs the actual
	 * MIME type of the image.
	 *
	 * @param string The path to the image file to check.
	 * @return boolean True if the image is valid, false if not.
	 */
	private function IsValidImageFile($fileName, $type)
	{
		switch(strtolower($type)) {
			case 'image/gif':
				$imageType = IMAGETYPE_GIF;
				break;
			case 'image/jpg':
			case 'image/x-jpeg':
			case 'image/x-jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
			case 'image/jpg':
				$imageType = IMAGETYPE_JPEG;
				break;
			case 'image/png':
			case 'image/x-png':
				$imageType = IMAGETYPE_PNG;
				break;
			case 'image/bmp':
				$imageType = IMAGETYPE_BMP;
				break;
			case 'image/tiff':
				$imageType = IMAGETYPE_TIFF_II;
				break;
			default:
				$imageType = 0;
		}

		$imageDimensions = getimagesize($fileName);
		if(!is_array($imageDimensions) || $imageDimensions[2] != $imageType) {
			return false;
		}

		return true;
	}

	/**
	 * Check that a particular file name belongs to a list of known extensions
	 * for images.
	 *
	 * @param string The name of the file name.
	 * @return boolean True if the image has a valid file name, false if not.
	 */
	private function IsImageFile($fileName)
	{
		$validImages = array('png', 'jpg', 'gif', 'jpeg', 'tiff', 'bmp', 'jpe');
		foreach($validImages as $image) {
			if(substr($fileName, (int)-(strlen($image)+1)) === '.' . $image){
				return true;
			}
		}
		return false;
	}
}