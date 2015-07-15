<?php
/**
 * SynchronizePhoto
 *
 * Base class of SynchronizePhoto
 *
 * @package		Lib
 * @author		Wilson Zeng | jackzcs@gmail.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

abstract class SynchronizePhoto extends Synchronize
{
    
    public $current_dhpath = '';
    public $sync_id = 0; //record batch id;
    
/**********************************Processes*************************************/
    public function callback($controller, $action){
	//---keep running in background
	ignore_user_abort(1);
	set_time_limit(0);
	//---just let browser disconnect
	disconnect();
	//---fetch data,(send $_POST directly)
	//var_dump($this->call_api($controller, $action, $_POST));exit;
	$this->sync_id = (int)$_POST['photoids_str'];
	$photos = unserialize($this->call_api($controller, $action, $_POST));
	//var_dump($photos);exit;
	//sleep(10);
	//---do sync(Now it will do api_update_photo)
	$this->do_sync($photos);
	//---update sync status[!!!Now it will be done in do_sync()!!!]
	//call_api('photo_inventory', 'api_update_photo', array('photo_updated' => json_encode($photo_updated)));
    }
    
    /**
     * [EDITABLE]This function may needs to be altered
     * @param $photos
     * @return $updated Array which will update photo sync in datahouse by this status
    */
    public function do_sync($data = NULL){
	$photos = $data['photos'];
	$option = $data['option'];
        $buffer_num = 0;//record number of update-items in cache that need tobe sent
	$max_num = count($photos);
	if($max_num > 0){
            $updated = array();
            $current_photo_time = time();//all photos have a same end-time
            foreach($photos as $key => $photo){
                $tmp_update = array(
                    'photoid' => $photo['photoid'],
                    'locationid' => $photo['destid'],
                	'sku' => $photo['sku'],
                	'vendorprefix' => $photo['vendorprefix'],
                    'data' => '',
                    PHOTO_THUMB => '',
                    PHOTO_SMALL => '',
                    PHOTO_MEDIUM => '',
                    PHOTO_LARGE => '',
                    'syncstatus' => 0,
                    'galleryorder' => $key,
                    'lastsyncenddate' => $current_photo_time,//record a end-time for this item
                    'error' => '',
                    'tracksyncid' => $this->sync_id
                );
                //---determine photo type: For product,category or ...
                //image file web-path in datahouse
                $this->current_dhpath = $photo['photopath'].'/'.$this->dh_filename($photo['photoid'], $photo['destid'], $photo['photoextension']);
                /*2011-11-18 alandy commit.sync every type as product.
                switch($photo['type']){
                    case PHOTO_TYPE_PRODUCT:
                        $this->sync_product($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_CATEGORY:
                        $this->sync_category($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_SUBCATEGORY:
                        $this->sync_subcategory($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_BRAND:
                        $this->sync_brand($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_SERIES:
                        $this->sync_series($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_CUSTOMER:
                        $this->sync_customer($photo, $tmp_update, $option);
                        break;
                    case PHOTO_TYPE_INSTALLATION:
                        $this->sync_installation($photo, $tmp_update, $option);
                        break;
                }
                */
                
                $this->sync_product($photo, $tmp_update, $option);
                
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
                }elseif($field_failed > 0 && $field_ok == 0){
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
                if($buffer_num % 100 == 0 || $buffer_num >= $max_num){
                        //--send them
                        $this->api_update_photo($updated);
                        //--clear cache buffer
                        unset($updated);
                        $updated = array();
                }
            }
	}
    }

/**********************************Synchronize Handlers**********************/
    public abstract function sync_product(&$photo, &$tmp_update, $option);
    public abstract function sync_category(&$photo, &$tmp_update, $option);
    public abstract function sync_subcategory(&$photo, &$tmp_update, $option);
    public abstract function sync_brand(&$photo, &$tmp_update, $option);
    public abstract function sync_series(&$photo, &$tmp_update, $option);
    public abstract function sync_customer(&$photo, &$tmp_update, $option);
    public abstract function sync_installation(&$photo, &$tmp_update, $option);
    
/*************************************Functions******************************/
    public function api_update_photo($updated){
        return $this->call_api('photo_inventory', 'api_update_photo', array('photo_updated' => serialize($updated)));
    }
    public function dh_filename($photoid, $locationid, $ext){
        return $photoid.'_'.$locationid.'.'.$ext;
    }
    public function dh_sourcefile($dh_size){
	$current_dhpath = $this->current_dhpath;
	if($dh_size == PHOTO_ICON){
	    $current_dhpath = preg_replace('/^(.*?)_\d+?(.*?)/i', '$1$2', $current_dhpath);
	}
        return DH_WEB_PHOTOS.'/'.$dh_size.'/'.$current_dhpath;
    }
}