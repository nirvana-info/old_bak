<?php
define('NL', "\n");

// CLI only
if(PHP_SAPI != 'cli' || isset($_SERVER['SERVER_PORT']) || isset($_SERVER['REQUEST_METHOD'])) {
	echo 'CLI only';
	exit;
}

if(!isset($argv) || !isset($argv[1])) {
	echo "Incorrect usage.";
	exit;
}

switch($argv[1]) {
	case 'install':
		// Check that ISC isn't actually installed
		if(file_exists($configFile)) {
			require $configFile;
		}

		if(isset($GLOBALS['ISC_CFG']['isSetup']) && $GLOBALS['ISC_CFG']['isSetup'] == true) {
			fwrite(STDOUT, "The install action will only work if the application isn't already installed".NL);
			exit;
		}

		// Include ISC and let it do it's magic
		define('CLI_INSTALL', true);
		require dirname(__FILE__).'/index.php';
		break;
	default:
		echo "Incorrect usage.";
		exit;
}
?>