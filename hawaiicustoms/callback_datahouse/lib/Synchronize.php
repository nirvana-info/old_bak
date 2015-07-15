<?php

/**
 * Synchronize
 *
 * Base class of Synchronize
 *
 * @package		Lib
 * @author		Wilson Zeng | jackzcs@gmail.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

abstract class Synchronize
{
    /**
     * Factory of synchronize classes
     * @param $source | which product needs to be create
     * @param $params | mixed | parameters for sub-class's constructor
     * @return Object
    */
    public static function factory($synctype, $source, $params = array()){
        $classname = 'Synchronize'.ucfirst($synctype).ucfirst($source);
        require_once($synctype.DIRECTORY_SEPARATOR.$classname.'.php');
        if(empty($params)){
            return new $classname;
        }elseif(is_array($params)){
            $rc = new ReflectionClass($classname);
            return $rc->newInstanceArgs($params);
        }else{
            $rc = new ReflectionClass($classname);
            return $rc->newInstance($params);
        }
    }
    
/**********************************Processes*************************************/
    public function run(){
        //[HTTP params]
        $controller = strtolower(trim($_GET['c']));
        $action = strtolower(trim($_GET['a']));
        $token = trim($_GET['k']);
        $time = trim($_GET['t']);
        //[Dispatcher]
        if($this->verified($token, array($controller, $action), $time)){
            $this->callback($controller, $action);
        }
    }
    abstract public function callback($controller, $action);
    
/*************************************Functions******************************/
    public function verified($token, $params = array(), $time){
	$params_str = implode('', $params);
        if(time() <= ($time + EXPIRE_TIME) && md5(KEY.$params_str.$time) == $token){
            return TRUE;
        }
        return FALSE;
    }
    
    //[Controller]/api_dispatcher/[action]/super_key/param1/param2/...
    public function call_api($controller, $action, $POST = array()){
        $url = API_SERVER.'/'.
            $controller.'/'.
            'api_dispatcher'.'/'.
            $action.'/'.
            KEY;
        $ch = curl_init($url);
        $opts = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($POST),
        );
       
        curl_setopt_array($ch, $opts);
        return curl_exec($ch);
    }
}