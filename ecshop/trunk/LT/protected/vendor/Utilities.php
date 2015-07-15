<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-10
 * Time: 9:47pm
 */

class Utilities {

    /*
	 * Create a xml element.
	 * demo:<ItemID comp="ebay:geturl">110098022988</ItemID>
	 */
    public static function createXMLElement($name,$value,$name_extension=''){
        $str = '';
        if(!empty($name)){
            if(!empty($name_extension)){
                $str = '<'.$name.' '.$name_extension.'>'.$value.'</'.$name.'>';
            }else{
                $str = '<'.$name.'>'.$value.'</'.$name.'>';
            }
        }

        return $str;
    }
} 