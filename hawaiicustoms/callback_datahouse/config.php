<?php
define('IN_CONFIG', '1');

//*****************************Configuration******************************
//---local
define('SYSTEM_CODE', 'Truckchamp');//[Editable] the sync library will use this to create class
define('SYSTEM_ROOT', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..').DIRECTORY_SEPARATOR);//system's web root path[Don't modify]

//---callback area
define('CALLBACK_LIB', 'lib'.DIRECTORY_SEPARATOR);
define('LOG_FOLDER', 'log'.DIRECTORY_SEPARATOR);

//---communication[Editable]
define('KEY', 'ZGJkNmNhMDU5ZjAwNDViNTg3NGExZGI1ZDZkMDExZWQ');
define('API_SERVER', 'http://70.90.149.161');
define('DH_WEB', API_SERVER);//normally equals to API_SERVER
define('EXPIRE_TIME', 86400);//the expire time of this communication

//---paths
define('DH_WEB_PHOTOS', DH_WEB.'/photos');

//---photo size
define('PHOTO_ORIGINAL', 'origin');
define('PHOTO_LARGE', 'large');
define('PHOTO_MEDIUM', 'medium');
define('PHOTO_SMALL', 'small');
define('PHOTO_THUMB', 'thumbnail');
define('PHOTO_ICON', 'icon');

//---photo type
define('PHOTO_TYPE_PRODUCT', 1);
define('PHOTO_TYPE_CATEGORY', 2);
define('PHOTO_TYPE_SUBCATEGORY', 3);
define('PHOTO_TYPE_BRAND', 4);
define('PHOTO_TYPE_SERIES', 5);
define('PHOTO_TYPE_INSTALLATION', 6);
define('PHOTO_TYPE_CUSTOMER', 7);