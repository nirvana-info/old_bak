<?php
//---load local library
define('LOCAL_LIB', SYSTEM_ROOT.'lib'.DIRECTORY_SEPARATOR);
require_once(LOCAL_LIB.'init.php');

/**
 * SynchronizeTruckchamp
 *
 * Truckchamp class of Synchronize
 *
 * @package		Lib
 * @author		Wilson Zeng | jackzcs@gmail.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

class SynchronizePhotoTruckchamp extends SynchronizePhoto
{
    
    public $db = NULL;
    public $saved_product = array();//product that once updated,array(prodid => image_sort)
    public $error = array(); //record sync error.
    
    public function __construct(){
        global $GLOBALS;
        $this->db = & $GLOBALS['ISC_CLASS_DB'];
    }

/**********************************Synchronize Handlers**********************/

    public function sync_product(&$photo, &$tmp_update, $option){
        //---initial constants
        $photo_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'product_images'.DIRECTORY_SEPARATOR;
        $backup_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'product_images_backup'.DIRECTORY_SEPARATOR;
        $table_image = 'product_images';
        $table_product = 'products';
        //---get productid (WHERE MATCHED (vendorprefix, sku))
        $sql = "SELECT productid FROM [|PREFIX|]$table_product
                WHERE (prodvendorprefix='".$GLOBALS['ISC_CLASS_DB']->Quote($photo['vendorprefix'])."'
                AND prodcode='".$GLOBALS['ISC_CLASS_DB']->Quote($photo['sku'])."')";
        $result = $this->db->Query($sql);
        $prod_row = $this->db->Fetch($result);
                
        if(isset($prod_row['productid']) && $prod_row['productid'] > 0){
            //size mapping
            $size_mapping = array(
                    PHOTO_ICON => 2,
                    PHOTO_THUMB => 1,
                    PHOTO_SMALL => 3,
                    PHOTO_MEDIUM => 4,
                    PHOTO_LARGE => 0,
            );
            //only not once updated product will do this below
            if(!isset($this->saved_product[$prod_row['productid']])){
                // $option defalt as replace--1, add--0
                if($option){
                    //---backup old image files to a new place
                    //-get his image records
                    $sql = "SELECT imagefile FROM [|PREFIX|]$table_image WHERE imageprodid=".(int)$prod_row['productid'];
                    $result = $this->db->Query($sql);
                    while ($img_row = $this->db->Fetch($result)) {
                        $fullpath_imagefile = $backup_path.$img_row['imagefile'];
                        if(remkdir(dirname($fullpath_imagefile)) === FALSE){
                        	$this->error[] = "remkdir [{$fullpath_imagefile}] failed";
                            common_log("remkdir [{$fullpath_imagefile}] failed", 'DEBUG');
                        }
                        //-backup
                        if(rename($photo_path.$img_row['imagefile'], $fullpath_imagefile) === FALSE){
                        	$this->error[] = "rename [".$photo_path.$img_row['imagefile']."] to [".$fullpath_imagefile."] failed";
                            common_log("rename [".$photo_path.$img_row['imagefile']."] to [".$fullpath_imagefile."] failed", 'DEBUG');
                        }
                    }
                    //---delete old image datas
                    $this->db->DeleteQuery($table_image, "WHERE imageprodid='".(int)$prod_row['productid']."'");
                    //---mark this updated product, next time, will not delete his datas & files
                }
                //johnny ---- insert medium & thumbnail once when mutil synch for one product
                $this->saved_product[$prod_row['productid']]['insert_medium_flag'] = TRUE;
                $this->saved_product[$prod_row['productid']]['insert_thumbnail_flag'] = TRUE;
            }
            // deal the image sort when select add option
            if($option){ // replace
                    //addon,here will save the same part images' sort
                    /* alandy_2011-11-18 commit.use galleryorder.
                    if(isset($this->saved_product[$prod_row['productid']]['record_sort']) && in_array($photo['sort'], $this->saved_product[$prod_row['productid']]['record_sort'])){
                        $this->saved_product[$prod_row['productid']]['sort'] = end(array_keys($this->saved_product[$prod_row['productid']]['record_sort'])) + 1;
                    }else{
                        $this->saved_product[$prod_row['productid']]['sort'] = $photo['sort'];
                    }
                    
                    $this->saved_product[$prod_row['productid']]['record_sort'][] = $photo['sort'];
                    */
            	    $this->saved_product[$prod_row['productid']]['sort'] = $tmp_update['galleryorder'];
            }else{  // add
                    // select database get current max sort number
                    $maxSort = $this->get_max_sort($prod_row['productid']);
                    if($maxSort === NULL){
                        $this->saved_product[$prod_row['productid']]['sort'] = 0;
                    }else{
                    	$this->saved_product[$prod_row['productid']]['sort'] = (int)$maxSort +1 ;
                    	/* Alandy_2011-11-7 change add sort order.
                        $photo['sort'] = intval($photo['sort']);
                        if($photo['sort'] > $maxSort){
                            $this->saved_product[$prod_row['productid']]['sort'] = $photo['sort'];
                        }elseif($photo['sort'] <= $maxSort){
                            $this->update_product_image_sort($prod_row['productid'], $photo['sort']);
                            $this->saved_product[$prod_row['productid']]['sort'] = $photo['sort'];
                        } 
                        */  
                    }   
            }
            //---insert new image datas & transfer new image files
            foreach($size_mapping as $dh_size => $size_flag){
                //johnny ---- insert medium once when mutil synch for one product
                if($size_flag == 1 && !$this->saved_product[$prod_row['productid']]['insert_medium_flag']){
                    continue;
                //johnny ---- insert thumbnail once when mutil synch for one product
                }elseif($size_flag == 2 && !$this->saved_product[$prod_row['productid']]['insert_thumbnail_flag']){
                    continue;
                }else{
                    if($size_flag == 1 && !$option && $this->is_exist_image($prod_row['productid'], $size_flag)){
                        $this->saved_product[$prod_row['productid']]['insert_medium_flag'] = FALSE;
                    }elseif($size_flag == 2 && !$option && $this->is_exist_image($prod_row['productid'], $size_flag)){
                        $this->saved_product[$prod_row['productid']]['insert_thumbnail_flag'] = FALSE;
                    }else{
                        $tmp_update[$dh_size] = '0';//sync status,default=failed
                        //--transfer file
                        $source_file = $this->dh_sourcefile($dh_size);
                        $imagefile = $this->build_product_path($photo['sku'], basename($this->current_dhpath), $dh_size);
                        $dest_file = $photo_path.$imagefile;
                        remkdir(dirname($dest_file));
                        if(trans_file($source_file, $dest_file)){
                            //--insert data
                            $data['imageprodid'] = $prod_row['productid'];
                            $data['imagefile'] = $imagefile;
                            $data['imageisthumb'] = $size_flag;
                            $data['imagesort'] = $this->saved_product[$prod_row['productid']]['sort'];//this like an ID of part images
                            $imageid = $this->db->InsertQuery($table_image, $data);
                            if($imageid > 0){
                                //---set sync status
                                $tmp_update[$dh_size] = '1';//success
                            }else{
                            	$this->error[] = "Productid:".$prod_row." insert into isc_product_images table failed";
                            }
                        }
                        //johnny ---- insert medium & thumbnail once when mutil synch for one product
                        if($size_flag == 1) $this->saved_product[$prod_row['productid']]['insert_medium_flag'] = FALSE;
                        if($size_flag == 2) $this->saved_product[$prod_row['productid']]['insert_thumbnail_flag'] = FALSE;
                    }
                } 
            }
            //---plus this part of images' sort, prepare for next part of images
            if($option) $this->saved_product[$prod_row['productid']]['sort']++; 

            //return $tmp_update['error']
            $tmp_update['error'] = implode(";", $this->error);
            //empty error value.
            $this->error = array();
        }else{
        	$this->error[] = 'Vendorprefix:'.$photo['vendorprefix']." ; SKU:".$photo['sku']." doesn't exist in TC SITE";
        	 //return $tmp_update['error']
        	$tmp_update['error'] = implode(";", $this->error);
        	//empty error value.
        	$this->error = array();
        }
    }
    
    public function sync_category(&$photo, &$tmp_update, $option){
        //---initial constants
        $method = 'build_category_path';
        $table = 'categories';
        $pk = 'catname';
        $dh_pk = 'catname';
        $name_field = 'catname';
        $base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'category_images'.DIRECTORY_SEPARATOR;
        $image_fields = array(
            'catimagefile' => PHOTO_SMALL,
            'cathoverimagefile' => PHOTO_MEDIUM,
        );
        $this->sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
                           $name_field, $photo, $tmp_update);
    }
    
    public function sync_subcategory(&$photo, &$tmp_update, $option){
        $this->sync_category($photo, $tmp_update);
    }
    
    public function sync_brand(&$photo, &$tmp_update, $option){
        //---initial constants
        $method = 'build_brand_path';
        $table = 'brands';
        $pk = 'brandname';
        $dh_pk = 'brandname';
        $name_field = 'brandname';
        $base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'product_images'.DIRECTORY_SEPARATOR;
        $image_fields = array(
                'brandimagefile' => PHOTO_SMALL,
                'brandlargefile' => PHOTO_MEDIUM,
        );
        $this->sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
                           $name_field, $photo, $tmp_update);
    }
    
    public function sync_series(&$photo, &$tmp_update, $option){
        //---initial constants
        $method = 'build_series_path';
        $table = 'brand_series';
        $pk = 'seriesname';
        $dh_pk = 'seriesname';
        $name_field = 'seriesname';
        $base_path = ISC_BASE_PATH.DIRECTORY_SEPARATOR.'series_images'.DIRECTORY_SEPARATOR;
        $image_fields = array(
                'seriesphoto' => PHOTO_SMALL,
                'serieshoverimagefile' => PHOTO_MEDIUM,
                'serieslogoimage' => PHOTO_THUMB,
        );
        $this->sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
                           $name_field, $photo, $tmp_update);
    }
    
    public function sync_customer(&$photo, &$tmp_update, $option){
        //---initial constants
        $method = 'build_customer_path';
        $table = 'pic';
        $pk = 'picid';
        $dh_pk = 'sourceid';
        $name_field = 'picid';
        $base_path = ISC_BASE_PATH;
        $image_fields = array(
                'path' => PHOTO_MEDIUM,
        );
        $update_mapping = array(
                'description' => array('description'),
                'uploaderFirstName' => array('firstname'),
                'uploaderLastName' => array('lastname'),
                'address1' => array('address'),
                'address2' => '',
                'adminnote' => array('comments'),
                'synctime' => $current_photo_time,
        );
        $this->sync_common($method, $table, $base_path, $pk, $dh_pk, $image_fields,
                           $name_field, $photo, $tmp_update, $update_mapping);
    }
    
    public function sync_installation(&$photo, &$tmp_update, $option){
        
    }
    
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
     * @param $update_mapping | array('CURRENT_FIELD'=>'DH_FIELD')if need some base field for updating
    */
    public function sync_common($method, $table, $base_path, $pk, $dh_pk = 'sourceid', $image_fields = array(), $name_field,
                         &$photo, &$tmp_update, $update_mapping = NULL){
            //---get this (MATCHED PK=sourceid)
            $sql = "SELECT *
                    FROM [|PREFIX|]$table
                    WHERE $pk='".$this->db->Quote($photo[$dh_pk])."'";
            $result = $this->db->Query($sql);
            if($row = $this->db->Fetch($result)){
                    //---[DATA FIELDS]update the base information according to the field mapping
                    if($update_mapping){
                            $set_base = array();
                            foreach($update_mapping as $cur_field => $dh_field){
                                    if(is_array($dh_field)){//if array,it shows that be dh fields
                                            $field_values = array();
                                            foreach($dh_field as $key){
                                                    $field_values[] = $photo[$key];
                                            }
                                            $set_base[$cur_field] = implode(',', $field_values);
                                    }else{//not array, it's a real value
                                            $set_base[$cur_field] = $dh_field;
                                    }
                            }
                            if($this->db->UpdateQuery($table, $set_base, "$pk='".$photo[$dh_pk]."'") !== FALSE){
                                    $tmp_update['data'] = '1';
                            }else{
                                    $tmp_update['data'] = '0';
                            }
                    }
                    //---[IMAGE FIELDS]image field that to be update
                    $last_size = '';//last size that has been update successfully
                    $last_imagefile = '';//last imagefile that has been saved successfully
                    foreach($image_fields as $field => $image_size){
                            
                            $source_file = $this->dh_sourcefile($image_size);
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
                                            $imagefile = $this->$method($row[$name_field], basename($this->current_dhpath), $image_size);
                                            $dest_file = $base_path.$imagefile;
                                            remkdir(dirname($dest_file));
                                            if(!trans_file($source_file, $dest_file)){
                                                    //---mark to not update into database
                                                    $imagefile = NULL;
                                            }
                                    }
                            }
                            //---update new imagefile to database
                            if($imagefile){
                                    $set[$field] = $imagefile;
                                    if($this->db->UpdateQuery($table, $set, "$pk='".$photo[$dh_pk]."'") !== FALSE) {
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
    
/************************************build image path*******************************/
    function build_product_path($prefix, $FileName, $Append=""){
        require_once(LOCAL_LIB.'general.php');
        $FileName = $prefix.'__'.$FileName;
        return strtolower(chr(rand(65,90))).DIRECTORY_SEPARATOR.GenRandFileName($FileName, $Append);
    }
    function build_category_path($catname, $FileName, $Append=""){
        require_once(LOCAL_LIB.'general.php');
        $FileName = str_replace(' ', '-', $catname).'__'.$FileName;
        return strtolower(str_replace(' ', '', $catname)).DIRECTORY_SEPARATOR.GenRandFileName($FileName, $Append);
    }
    function build_brand_path($prefix, $FileName, $Append=""){
        return $this->build_product_path($prefix, $FileName, $Append);
    }
    function build_series_path($prefix, $FileName, $Append=""){
        require_once(LOCAL_LIB.'general.php');
        $FileName = $prefix.'__'.$FileName;
        return GenRandFileName($FileName, $Append);
    }
    function build_customer_path($prefix, $FileName, $Append=""){
        $cur_time = time();
        return '/upload/'.date('ymd', $cur_time).'/'.$cur_time.'_'.$FileName;
    }
/**********************************functions*************************************/
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
    
    function get_max_sort($productId){
        $sql = "SELECT max(imagesort) as maxSort FROM [|PREFIX|]product_images WHERE imageprodid=".(int)$productId;
        $result = $this->db->Query($sql);
        $row = $this->db->Fetch($result);
        return isset($row['maxSort']) ? $row['maxSort'] : NULL;
    }
    
    function is_exist_image($productId, $isthumbnail){
        $sql = "SELECT count(0) as num FROM [|PREFIX|]product_images WHERE imageprodid=".(int)$productId. " AND imageisthumb = $isthumbnail";
        $result = $this->db->Query($sql);
        $row = $this->db->Fetch($result);
        return isset($row['num']) && $row['num'] > 0;
    }
    
    function update_product_image_sort($imgProdId, $flagSort){
        $sql = "UPDATE [|PREFIX|]product_images SET imagesort = imagesort+1 WHERE imageprodid = $imgProdId AND imagesort >= $flagSort AND imageisthumb not in(1, 2)";
        $result = $this->db->Query($sql);
        return isset($result) ? TRUE : FALSE;
    }
}