<?php

Yii::import('application.vendor.*');
require_once 'ebay/RequestTool.php';

class EbayController extends Controller
{
	public function actionIndex()
	{
        /*$post_data = ebay::getRequestAuthHead(Yii::APP()->params['ebay']['ebay-discount']['tokens']['ebay-discount'], 'GetShippingDiscountProfiles');
        $post_data .= ebay::getRequestAuthFoot('GetShippingDiscountProfiles');
        $httpHead = array();
        $httpHead['SITEID'] = Yii::APP()->params['ebay']['SiteID']['MOTO'];
        $httpHead['COMPATIBILITYLEVEL'] = Yii::APP()->params['ebay']['ebay-discount']['COMPATIBILITYLEVEL'];
        $httpHead['DEVID'] = Yii::APP()->params['ebay']['ebay-discount']['keys']['lof']["DEVID"];
        $httpHead['AppID'] = Yii::APP()->params['ebay']['ebay-discount']['keys']['lof']["AppID"];
        $httpHead['CertID'] = Yii::APP()->params['ebay']['ebay-discount']['keys']['lof']["CertID"];
        $httpHead['API_URL'] = Yii::APP()->params['ebay']['ebay-discount']['API_URL'];
        $result = ebay::curl_request($post_data, $httpHead, 'GetShippingDiscountProfiles', false);*/
        /*$post_data = ebay::getRequestAuthHead(Yii::APP()->params['ebay']['production']['tokens']['himerus.wish'], 'GetShippingDiscountProfiles');
        $post_data .= ebay::getRequestAuthFoot('GetShippingDiscountProfiles');
        $httpHead = array();
        $httpHead['SITEID'] = Yii::APP()->params['ebay']['SiteID']['US'];
        $httpHead['COMPATIBILITYLEVEL'] = Yii::APP()->params['ebay']['production']['COMPATIBILITYLEVEL'];
        $httpHead['DEVID'] = Yii::APP()->params['ebay']['production']['keys']['prod key set']["DEVID"];
        $httpHead['AppID'] = Yii::APP()->params['ebay']['production']['keys']['prod key set']["AppID"];
        $httpHead['CertID'] = Yii::APP()->params['ebay']['production']['keys']['prod key set']["CertID"];
        $httpHead['API_URL'] = Yii::APP()->params['ebay']['production']['API_URL'];
        $result = ebay::curl_request($post_data, $httpHead, 'GetShippingDiscountProfiles', false);
        var_dump($result);die();*/
        $listing = eBayListing::model()->findByPk(1);var_dump($listing, $listing->eBayEntityType, $listing->eBayAttributeSet);die();
        $this->render('index');
	}

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

	/*public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}*/

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','index'),
                'users'=>array('@'),
            ),
            /* array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('admin'),
            ),*/
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }
}