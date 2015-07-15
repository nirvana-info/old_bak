<?php

	CLASS ISC_PRODUCTMANUFACTURER_PANEL extends PANEL
	{
		function SetPanelSettings()
		{
			if(!isset($GLOBALS['ISC_CLASS_PRODUCT']) ) {
				$this->DontDisplay = true;
				return;
			}
            
			$ProductManufacturer = $GLOBALS['ISC_CLASS_PRODUCT']->GetProdMfg();
			if(strpos($ProductManufacturer, "<") === false) {
				$ProductManufacturer = nl2br($ProductManufacturer);
			}

			$GLOBALS['ProductManufacturer'] = $ProductManufacturer;
			
				if ( $ProductManufacturer == "" )
				{
				$this->DontDisplay = true;
				}
		}
	}

?>