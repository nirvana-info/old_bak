<?php
include(dirname(__FILE__) . "/init.php");
$GLOBALS['ISC_CLASS_CAPTCHA'] = GetClass('ISC_CAPTCHA');
$GLOBALS['ISC_CLASS_CAPTCHA']->isadmin = true;
$GLOBALS['ISC_CLASS_CAPTCHA']->ischange = true;
$GLOBALS['ISC_CLASS_CAPTCHA']->CreateSecret();
echo $returnData = $GLOBALS['CaptchaImage'] = $GLOBALS['ISC_CLASS_CAPTCHA']->ShowCaptcha();
exit;
?>
