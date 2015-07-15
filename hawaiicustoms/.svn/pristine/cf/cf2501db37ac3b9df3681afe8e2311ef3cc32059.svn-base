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

require_once('config.php');//base config
require_once(CALLBACK_LIB.'functions.php');//common functions
require_once(CALLBACK_LIB.'Synchronize.php');//base synchronize class
$synctype = strtolower(trim($_POST['_synctype_']));
require_once(CALLBACK_LIB.$synctype.DIRECTORY_SEPARATOR.'Synchronize'.ucfirst($synctype).'.php');//sub-base class

//---produce a synchronize
$app = Synchronize::factory($synctype, SYSTEM_CODE);
//---just run it!
$app->run();