<?php
/*
// Are SEO urls automatically enabled?
$GLOBALS['EnableSEOUrls'] = 2;
if(GetConfig('EnableSEOUrls') == 2) {
    if(isset($_SERVER['SEO_SUPPORT']) && $_SERVER['SEO_SUPPORT'] == 1) {
        $GLOBALS['EnableSEOUrls'] = 1;
    } elseif (isset($_SERVER["HTTP_X_REWRITE_URL"]) && !empty($_SERVER["HTTP_X_REWRITE_URL"])) {
        $GLOBALS['EnableSEOUrls'] = 1;
    } else {
        $GLOBALS['EnableSEOUrls'] = 0;
    }
}
*/
echo "<pre>";
print_r($_SERVER);

?>