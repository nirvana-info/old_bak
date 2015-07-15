<?php
/**
 * Global functions
 *
 * @package		Lib
 * @author		Wilson Zeng | jackzcs@gmail.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

//******************************Tool functions******************************
/**
 * Break down the HTTP connect
*/
function disconnect(){
	header("Content-Length: 0");
	header("Connection: close");
	flush();
}
/**
 * Mkdir recursively
 * @author Wilson Zeng
*/
function remkdir($path, $mode = 0777){
    if(!file_exists($path)){
        remkdir(dirname($path), $mode);
        mkdir($path, $mode);
	chmod($path, $mode);
    }
}
/**
 * simple getting extension of one file
 * @author Wilson Zeng
*/
function get_fileext($filename){
    //return image_type_to_extension(exif_imagetype($filename), FALSE);
    return strtolower(substr($filename, strrpos($filename, '.') + 1));
}
function remove_fileext($filename){
	return substr($filename, 0, strrpos($filename, '.'));
}
/**
 * Change the $dest_file's extension to $source_file's extension
 * @author Wilson Zeng
*/
function copy_fileext($source_file, $dest_file){
	return remove_fileext($dest_file).'.'.get_fileext($source_file);
}

/**
 * Enhanced copy(support url)
 * @author Wilson Zeng
*/
function trans_file($url, $destpath){
	if(preg_match('/[a-zA-z]+:\/\/[^\s]*/i', $url)){//a url
		$ch = curl_init($url);
		$opts = array(
			CURLOPT_RETURNTRANSFER => 1,
		);
		curl_setopt_array($ch, $opts);
		$file_str = curl_exec($ch);
		$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		if($http_code < 200 || $http_code >= 300 || file_put_contents($destpath, $file_str) <= 0){
			return FALSE;
		}
	}else{//a local file
		return copy($url, $destpath);
	}
	return TRUE;
}

/**
 * Common log
 * @author Wilson Zeng
 */
function common_log($message, $type = 'DEBUG', $filename = ''){
	$now = time();
	if(empty($filename)){
		$filename = $type.'_'.date('Ymd', $now).'.log';
	}
	$datetime = date('h:i:s Y/m/d', $now);
	$row_content = "[{$type}][{$datetime}]{$message}\n";
	$fullpath = LOG_FOLDER.$filename;
	remkdir(dirname($fullpath));
	file_put_contents(LOG_FOLDER.$filename, $row_content, FILE_APPEND);
}