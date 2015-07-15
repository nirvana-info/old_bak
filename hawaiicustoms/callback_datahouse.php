<?php
/**
 * Callback of datahouse
 *
 * Remote callback api for the interaction between datahouse & this site
 *
 * @package		Datahouse
 * @author		Wilson Zeng | jackzcs@gmail.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

//*****************************HTTP params********************************
$controller = strtolower(trim($_GET['c']));
$action = strtolower(trim($_GET['a']));
$token = trim($_GET['k']);
$time = trim($_GET['t']);

//*****************************Configuration******************************
//---communication[Editable]
define('KEY', 'ZGJkNmNhMDU5ZjAwNDViNTg3NGExZGI1ZDZkMDExZWQ');
define('API_SERVER', 'http://70.90.149.161');
define('DH_WEB', API_SERVER);//normally equals to API_SERVER
define('DH_WEB_PHOTOS', DH_WEB.'/photos');
define('EXPIRE_TIME', 86400);//the expire time of this communication

//---photo size
define('PHOTO_ORIGINAL', 'origin');
define('PHOTO_LARGE', 'large');
define('PHOTO_MEDIUM', 'medium');
define('PHOTO_SMALL', 'small');
define('PHOTO_THUMB', 'thumbnail');

//---photo type
define('PHOTO_TYPE_PRODUCT', 1);
define('PHOTO_TYPE_CATEGORY', 2);
define('PHOTO_TYPE_SUBCATEGORY', 3);
define('PHOTO_TYPE_BRAND', 4);
define('PHOTO_TYPE_SERIES', 5);
define('PHOTO_TYPE_INSTALLATION', 6);
define('PHOTO_TYPE_CUSTOMER', 7);

//---location(related to the location id in database of datahouse)
//define('LOCATION_SERVER', 1);
define('LOCATION_LOFINC', 2);
define('LOCATION_TRUCKCHAMP', 3);
//define('LOCATION_LOCAL', 4);
//define('LOCATION_URL', 5);
//define('LOCATION_CSV', 6);
//define('LOCATION_XML', 7);
//******************************Dispatcher******************************
if(verified($token, $controller, $action, $time)){
	//---keep running in background
	ignore_user_abort(1);
	set_time_limit(0);
	//---just let browser disconnect
	header("Content-Length: 0");
	header("Connection: close");
	flush();
	//---fetch data,(send $_POST directly)
	//var_dump(call_api($controller, $action, $_POST));exit;
	$photos = unserialize(call_api($controller, $action, $_POST));
	//sleep(10);
	//---do sync(Now it will do api_update_photo)
	do_sync($photos, 'api_update_photo');
	//---update sync status[!!!Now it will be done in do_sync()!!!]
	//call_api('photo_inventory', 'api_update_photo', array('photo_updated' => json_encode($photo_updated)));
}

//******************************Actions[Editable Area]******************************
/**
 * [EDITABLE]This function may needs to be altered
 * @param $photos
 * @return $updated Array which will update photo sync in datahouse by this status
*/
function do_sync($photos = NULL, $func_update = NULL){
	$current_locationid = LOCATION_TRUCKCHAMP;
	$buffer_num = 0;//record number of update-items in cache that need tobe sent
	$max_num = count($photos);
	if($max_num > 0){
		$updated = array();
		foreach($photos as $photo){
			//--filter invalid datas(only accept the data that send to current location)
			if($photo['destid'] != $current_locationid){
				continue;
			}
			$current_photo_time = time();
			$tmp_update = array(
				'photoid' => $photo['photoid'],
				'locationid' => $current_locationid,
				'data' => '',
				PHOTO_THUMB => '',
				PHOTO_SMALL => '',
				PHOTO_MEDIUM => '',
				PHOTO_LARGE => '',
				'syncstatus' => 0,
				'lastsyncenddate' => $current_photo_time,//record a end-time for this item
			);
			//---determine photo type: For product,category or ...
			require_once('./lib/init.php');
			$relative_fullpath = $photo['photopath'].'/'.dh_filename($photo['photoid'], $current_locationid, $photo['photoextension']);
			switch($photo['type']){
				case PHOTO_TYPE_PRODUCT:
					//---initial constants
					$photo_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'product_images'.DIRECTORY_SEPARATOR;
					$table_image = 'product_images';
					$table_product = 'products';
					//---get productid (WHERE MATCHED (vendorprefix, sku))
					$sql = "SELECT productid FROM [|PREFIX|]$table_product
						WHERE (prodvendorprefix='".$GLOBALS['ISC_CLASS_DB']->Quote($photo['vendorprefix'])."'
						AND prodcode='".$GLOBALS['ISC_CLASS_DB']->Quote($photo['sku'])."')";
					$result = $GLOBALS['ISC_CLASS_DB']->Query($sql);
					$prod_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
					if(isset($prod_row['productid']) && $prod_row['productid'] > 0){
						//which size is not exist
						$flag_notexist = array(
							PHOTO_LARGE => 0,
							PHOTO_THUMB => 1,
							PHOTO_SMALL => 2,
							PHOTO_MEDIUM => 3,
						);
						//---get his image records
						$sql = "SELECT * FROM [|PREFIX|]$table_image WHERE imageprodid=".(int)$prod_row['productid'];
						$result = $GLOBALS['ISC_CLASS_DB']->Query($sql);
						//---update exist photos
						while (($img_row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) && in_array($img_row['imageisthumb'],array(0,1,2,3))) {
							//---update old one, use his file path
							$image_size_db = '';
							switch($img_row['imageisthumb']){
								case 0://large
									$image_size_db = PHOTO_LARGE;
									break;
								case 1://thumb
									$image_size_db = PHOTO_THUMB;
									break;
								case 2://small
									$image_size_db = PHOTO_SMALL;
									break;
								case 3://medium
									$image_size_db = PHOTO_MEDIUM;
									break;
							}
							//--use a compatible size[NOTE:the $tmp_update log will use it too]
							$image_size = get_better_size($photo, $image_size_db);
							//--remove from not-exists
							$flag_notexist[$image_size_db] = NULL;
							//---transfer
							$source_file = DH_WEB_PHOTOS.'/'.$image_size.'/'.$relative_fullpath;
							$new_imagefile = copy_fileext($source_file, $img_row['imagefile']);//write new extension
							$dest_file = $photo_path.$new_imagefile;
							remkdir(dirname($dest_file));
							//---default log
							$tmp_update[$image_size] = '0';//failed
							if(trans_file($source_file, $dest_file)){
								//---if not a same file, delete the old one
								if($new_imagefile != $img_row['imagefile']){
									unlink($photo_path.$img_row['imagefile']);
								}
								//---update field to new imagefile(Main of updating extension)
								$set['imagefile'] = $new_imagefile;
								if($GLOBALS['ISC_CLASS_DB']->UpdateQuery($table_image, $set, "imageid=".(int)$img_row['imageid']) !== FALSE) {
									//---set sync status
									$tmp_update[$image_size] = '1';//success
								}
							}
						}
						//---create records for not exist photo-size
						foreach($flag_notexist as $image_size => $size_flag){
							if($size_flag !== NULL){
								//--use a compatible size[NOTE:the $tmp_update log will use it too]
								$image_size = get_better_size($photo, $image_size);
								//default
								$tmp_update[$image_size] = '0';//failed
								//--transfer file
								$source_file = DH_WEB_PHOTOS.'/'.$image_size.'/'.$relative_fullpath;
								$imagefile = build_product_path($photo['sku'], basename($relative_fullpath), $image_size);
								$dest_file = $photo_path.$imagefile;
								remkdir(dirname($dest_file));
								if(trans_file($source_file, $dest_file)){
									//--insert data
									$data['imageprodid'] = $prod_row['productid'];
									$data['imagefile'] = $imagefile;
									$data['imageisthumb'] = $size_flag;
									$imageid = $GLOBALS['ISC_CLASS_DB']->InsertQuery($table_image, $data);
									if($imageid > 0){
										//--remove from not-exists
										$flag_notexist[$image_size] = NULL;
										//---set sync status
										$tmp_update[$image_size] = '1';//success
									}
								}
							}
						}
					}
					break;
				case PHOTO_TYPE_CATEGORY:
				case PHOTO_TYPE_SUBCATEGORY:
					//---initial constants
					$method = 'build_category_path';
					$table = 'categories';
					$pk = 'catname';
					$dh_pk = 'catname';
					$name_field = 'catname';
					$base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'category_images'.DIRECTORY_SEPARATOR;
					$image_fields = array(
						'catimagefile' => PHOTO_LARGE,
						'cathoverimagefile' => PHOTO_MEDIUM,
					);
					sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
						    $name_field, $photo, $tmp_update, $relative_fullpath);
					break;
				case PHOTO_TYPE_BRAND:
					//---initial constants
					$method = 'build_brand_path';
					$table = 'brands';
					$pk = 'brandname';
					$dh_pk = 'brandname';
					$name_field = 'brandname';
					$base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'product_images'.DIRECTORY_SEPARATOR;
					$image_fields = array(
						'brandimagefile' => PHOTO_LARGE,
						'brandlargefile' => PHOTO_MEDIUM,
					);
					sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
						    $name_field, $photo, $tmp_update, $relative_fullpath);
					break;
				case PHOTO_TYPE_SERIES:
					//---initial constants
					$method = 'build_series_path';
					$table = 'brand_series';
					$pk = 'seriesname';
					$dh_pk = 'seriesname';
					$name_field = 'seriesname';
					$base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'series_images'.DIRECTORY_SEPARATOR;
					$image_fields = array(
						'seriesphoto' => PHOTO_LARGE,
						'serieshoverimagefile' => PHOTO_MEDIUM,
						'serieslogoimage' => PHOTO_THUMB,
					);
					sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
						    $name_field, $photo, $tmp_update, $relative_fullpath);
					break;
				case PHOTO_TYPE_CUSTOMER:
					//---initial constants
					$method = 'build_customer_path';
					$table = 'pic';
					$pk = 'picid';
					$dh_pk = 'sourceid';
					$name_field = 'picid';
					$base_path = ISC_BASE_PATH;
					$image_fields = array(
						'path' => PHOTO_LARGE,
					);
					$update_mapping = array(
						'description' => 'description',
						'uploaderFirstName' => 'firstname',
						'uploaderLastName' => 'lastname',
						'address1' => 'address',
						'address2' => '',
						'adminnote' => 'comments',
						'synctime' => $current_photo_time,
					);
					sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
						    $name_field, $photo, $tmp_update, $relative_fullpath, $update_mapping);
					break;
				case PHOTO_TYPE_INSTALLATION:
					break;
			}
			//---set if all is success:1=OK,2=FAILED,3=PARTIAL
			$field_ok = 0;
			$field_failed = 0;
			$judge_field = array('data', PHOTO_THUMB, PHOTO_SMALL, PHOTO_MEDIUM, PHOTO_LARGE);
			foreach($judge_field as $field){
				switch($tmp_update[$field]){
					case '1':
						$field_ok++;
						break;
					case '0':
						$field_failed++;
						break;
				}
			}
			if($field_ok > 0 && $field_failed == 0){
				$tmp_update['syncstatus'] = 1;
			}elseif($field_failed > 0 && $field_failed == 0){
				$tmp_update['syncstatus'] = 2;
			}elseif($field_ok == 0 && $field_failed == 0){
				$tmp_update['syncstatus'] = 0;//not synced,(Maybe not in the switch-loop above)
			}else{
				$tmp_update['syncstatus'] = 3;
			}
			//---push to updated stack
			$updated[] = $tmp_update;
			//---update buffered num
			$buffer_num++;
			//---check if it's time to send updated-item
			if($buffer_num >= 100 || $buffer_num >= $max_num){
				//--send them
				call_user_func($func_update, $updated);
				//--clear cache buffer
				$updated = array();
				$buffer_num = 0;
			}
		}
		return $updated;
	}
	return FALSE;
}

//----------------build image path----------------------------
function build_product_path($prefix, $FileName, $Append=""){
	require_once('./lib/general.php');
	$FileName = $prefix.'__'.$FileName;
	return strtolower(chr(rand(65,90))).DIRECTORY_SEPARATOR.GenRandFileName($FileName, $Append);
}
function build_category_path($catname, $FileName, $Append=""){
	require_once('./lib/general.php');
	$FileName = str_replace(' ', '-', $catname).'__'.$FileName;
	return strtolower(str_replace(' ', '', $catname)).DIRECTORY_SEPARATOR.GenRandFileName($FileName, $Append);
}
function build_brand_path($prefix, $FileName, $Append=""){
	return build_product_path($prefix, $FileName, $Append);
}
function build_series_path($prefix, $FileName, $Append=""){
	require_once('./lib/general.php');
	$FileName = $prefix.'__'.$FileName;
	return GenRandFileName($FileName, $Append);
}
function build_customer_path($prefix, $FileName, $Append=""){
	$cur_time = time();
	return '/upload/'.date('ymd', $cur_time).'/'.$cur_time.'_'.$FileName;
}
//-------------------------------------------------------------

/**
 * used for Category,Brand,Series,(They have something in common)
 * @param $method | callback function name
 * @param $table | table in db
 * @param $base_path | base path for image file in db
 * @param $pk | primary key in current website's table
 * @param $dh_pk | primary key in datahouse's table, it will do matching with $pk
 * @param $image_fields | which fields need update
 * @param $name_field | when create new image file, this will be used as a name prefix
 * @param $photo | the array data from dh
 * @param &$tmp_update | record flag
 * @param $relative_fullpath | the path that build with photopath & photoid & locationid & extension
 * @param $update_mapping | array('CURRENT_FIELD'=>'DH_FIELD')if need some base field for updating
*/
function sync_common($method, $table, $base_path, $pk, $dh_pk = 'sourceid', $image_fields = array(), $name_field,
		     $photo, &$tmp_update, $relative_fullpath, $update_mapping = NULL){
	//---get this (MATCHED PK=sourceid)
	$sql = "SELECT *
		FROM [|PREFIX|]$table
		WHERE $pk='".$GLOBALS['ISC_CLASS_DB']->Quote($photo[$dh_pk])."'";
	$result = $GLOBALS['ISC_CLASS_DB']->Query($sql);
	if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)){
		//---[DATA FIELDS]update the base information according to the field mapping
		if($update_mapping){
			$set_base = array();
			foreach($update_mapping as $cur_field => $dh_field){
				$set_base[$cur_field] = $photo[$dh_field];
			}
			if($GLOBALS['ISC_CLASS_DB']->UpdateQuery($table, $set_base, "$pk='".$photo[$dh_pk]."'") !== FALSE){
				$tmp_update['data'] = '1';
			}else{
				$tmp_update['data'] = '0';
			}
		}
		//---[IMAGE FIELDS]image field that to be update
		$last_size = '';//last size that has been update successfully
		$last_imagefile = '';//last imagefile that has been saved successfully
		foreach($image_fields as $field => $image_size){
			//--use a compatible size[NOTE:the $tmp_update log will use it too]
			$image_size = get_better_size($photo, $image_size);
			if($image_size === FALSE){//have no suitable image
				$tmp_update[$image_size] = '0';//failed
				continue;
			}
			$source_file = DH_WEB_PHOTOS.'/'.$image_size.'/'.$relative_fullpath;
			//image field
			$imagefile = NULL;
			//---default sync status
			$tmp_update[$image_size] = '0';//failed
			//---imagefile exist?
			$dest_file = $base_path.$row[$field];
			if(is_file($dest_file)){//exist,overwrite him
				if($last_size == $image_size){//it seems that image have transed before,just copy it
					$source_file = $base_path.$last_imagefile;
				}
				//--write new extension
				$imagefile = copy_fileext($source_file, $row[$field]);
				//--change dest to use a new extension
				$dest_file = $base_path.$imagefile;
				//--transfer
				if(trans_file($source_file, $dest_file)){
					//---if not a same file, delete the old one
					if($imagefile != $row[$field]){
						unlink($base_path.$row[$field]);
					}
				}else{
					//---mark to not update into database
					$imagefile = NULL;
				}
			}else{//not exist,create a new
				//--build new image path
				if($last_size == $image_size){//its no need to do transfer,just update the field only
					$imagefile = $last_imagefile;
				}else{//a new transfer must start
					$imagefile = $method($row[$name_field], basename($relative_fullpath), $image_size);
					$dest_file = $base_path.$imagefile;
					remkdir(dirname($dest_file));
					if(!trans_file($source_file, $dest_file)){
						//---mark to not update into database
						$imagefile = NULL;
					}
				}
			}
			//---update to database
			if($imagefile){
				$set[$field] = $imagefile;
				if($GLOBALS['ISC_CLASS_DB']->UpdateQuery($table, $set, "$pk='".$photo[$dh_pk]."'") !== FALSE) {
					//---set sync status
					$tmp_update[$image_size] = '1';//success
					//---record last successed item
					$last_size = $image_size;
					$last_imagefile = $imagefile;
				}
			}
		}
	}
}
function get_better_size($photo, $expect = PHOTO_LARGE){
	$sequence = array(
		PHOTO_LARGE => $photo['large_resize'],
		PHOTO_MEDIUM => $photo['medium_resize'],
		PHOTO_SMALL => $photo['small_resize'],
		PHOTO_THUMB => $photo['thumbnail_resize'],
	);
	$flag_reached = FALSE;//record if is reached expect element
	foreach($sequence as $size_type => $exist){//get the size that <= expect && exist
		if($expect == $size_type){
			$flag_reached = TRUE;
			if($exist){
				return $size_type;
			}else{
				continue;
			}
		}elseif($flag_reached && $exist){
			return $size_type;
		}else{
			continue;
		}
	}
	//default
	return FALSE;
}

//******************************Functions******************************
function verified($token, $controller, $action, $time){
	if(time() <= ($time + EXPIRE_TIME) && md5(KEY.$controller.$action.$time) == $token){
		return TRUE;
	}
	return FALSE;
}

//[Controller]/api_dispatcher/[action]/super_key/param1/param2/...
function call_api($controller, $action, $posts = array()){
	$url = API_SERVER.'/'.
		$controller.'/'.
		'api_dispatcher'.'/'.
		$action.'/'.
		KEY;
	$ch = curl_init($url);
	$opts = array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => http_build_query($posts),
	);
	curl_setopt_array($ch, $opts);
	return curl_exec($ch);
}
function api_update_photo($updated){
	return call_api('photo_inventory', 'api_update_photo', array('photo_updated' => serialize($updated)));
}
function dh_filename($photoid, $locationid, $ext){
	return $photoid.'_'.$locationid.'.'.$ext;
}
//******************************Tool functions******************************
/**
 * Mkdir recursively
 * @author Wilson Zeng
*/
function remkdir($path, $mode = 0777){
    if(!file_exists($path)){
        remkdir(dirname($path), $mode);
        mkdir($path, $mode);
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
