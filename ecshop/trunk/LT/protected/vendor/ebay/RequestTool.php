<?php
/**
 * Created by PhpStorm.
 * User: cloud
 * Date: 14-10-10
 * Time: 10:30pm
 */

class RequestTool
{
    /*
	 * Method: create ebay xml head
	 * return array.
	 */
    public static function createHTTPHead($SITEID=0, $COMPATIBILITYLEVEL=893, $DEVID=NULL, $APPID=NULL, $CERTID=NULL, $CALLNAME=NULL)
    {
        if(!$COMPATIBILITYLEVEL || !$DEVID || !$APPID || !$CERTID || !$CALLNAME || $SITEID<0) return false;

        $ebayapiheader = array (
            "X-EBAY-API-COMPATIBILITY-LEVEL:".$COMPATIBILITYLEVEL,
            "X-EBAY-API-DEV-NAME:".$DEVID,
            "X-EBAY-API-APP-NAME:".$APPID,
            "X-EBAY-API-CERT-NAME:".$CERTID,
            "X-EBAY-API-CALL-NAME:".$CALLNAME,
            "X-EBAY-API-SITEID:".$SITEID,
            "X-EBAY-API-REQUEST-ENCODING:XML",
            "Content-Type : text/xml",
            "X-EBAY-API-DETAIL-LEVEL: 0",
            //"X-EBAY-API-SESSION-CERTIFICATE: $SESSIONCERTIFICATE",
        );
        return $ebayapiheader;
    }

    /*
	 * Return ebay auth header.
	 */
    public static function getRequestAuthHead($token=NULL,$CALLNAME=NULL)
    {
        if(!$token || !$CALLNAME) return false;
        // XML Request
        $post_data = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
        //start config callname
        $post_data .= "<".$CALLNAME."Request xmlns='urn:ebay:apis:eBLBaseComponents'>";
        $post_data .= "<RequesterCredentials>";
        $post_data .= "<eBayAuthToken>";
        $post_data .= $token;
        $post_data .= "</eBayAuthToken>";
        $post_data .= "</RequesterCredentials>";

        return $post_data;
    }

    /*
	 * return ebay auth footer
	 */
    public static function getRequestAuthFoot($CALLNAME)
    {
        if(!$CALLNAME) return false;
        return "</".$CALLNAME."Request>";
    }

    public static function curl_request($post_data = Null, $httpHead = true, $CALLNAME = '', $returnXML=false)
    {
        // GET POST EBAY HEAD
        $ebayapiheader = self::createHTTPHead($httpHead['SITEID'], $httpHead['COMPATIBILITYLEVEL'], $httpHead['DEVID'], $httpHead['AppID'], $httpHead['CertID'], $CALLNAME);

        $ch = curl_init();
        $res= curl_setopt ($ch, CURLOPT_URL,$httpHead['API_URL']);  //SET API  URL.

        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt ($ch, CURLOPT_HEADER, 0); // 0 = Don't give me the return header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $ebayapiheader); // Set this for eBayAPI
        curl_setopt($ch, CURLOPT_POST, 1); // POST Method
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); //My XML post fild Request
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);     //return as string.
        $body = curl_exec ($ch); //Send the request

        curl_close ($ch); // Close the connection

        if($body){
            return $returnXML ? $body : simplexml_load_string($body);
        }else{
            return false;
        }
    }
}