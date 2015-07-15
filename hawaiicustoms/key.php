
<?php

$domain='dev1.tc.com';
// $domain=substr($domain,4); // without http and www

echo 'Vendor: ISC'.base64_encode(pack("CCVvvH*", 16,8,0,0,0,md5($domain))) . "<br>";
echo 'Ultimate: ISC'.base64_encode(pack("CCVvvH*", 16,4,0,0,0,md5($domain))) . "<br>";
echo 'Professional: ISC'.base64_encode(pack("CCVvvH*", 16,2,0,0,0,md5($domain))) . "<br>";
echo 'Starter: ISC'.base64_encode(pack("CCVvvH*", 16,1,0,0,0,md5($domain))) . "<br>";
?>
-----------------------------------

