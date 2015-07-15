<?php

require_once("paysimple.php");

class DynamicKey
{
	function DynamicKey($path, $gateway)
	{        
        $dynamicKeyFile = file_get_contents($path);
        
        if ($dynamicKeyFile !== FALSE)
		{
			$dynamicKeyParts = explode("\n", $dynamicKeyFile);
			
			if (!isset($dymanicKeyParts[1]) || ($dynamicKeyParts[1] - mktime()) < 0)
            {           
                $this->GenerateNewKey(10, $dynamicKeyParts, $path, $gateway);
            }
            else
            {                
                $this->key = trim($dynamicKeyParts[0]) . trim($dynamicKeyParts[2]);            
            }
        }
    }

    function GenerateNewKey($daysToExpire, $dynamicKeyParts, $path, $gateway)
    {            
		$expiry = mktime() + ($daysToExpire * 86400);
		$staticHalf = trim($dynamicKeyParts[0]);
		$date = date("Y-m-d", $expiry).'T'.date("H:i:s", $expiry);
        $dynamicHalf = $gateway->GetDynamicKey($staticHalf, $date);
        $this->key = $staticHalf . $dynamicHalf;
        $keyParts = $staticHalf."\r\n".$expiry."\r\n".$dynamicHalf;
        
        file_put_contents($path, $keyParts);
        
        return true;
    }
}

?>
