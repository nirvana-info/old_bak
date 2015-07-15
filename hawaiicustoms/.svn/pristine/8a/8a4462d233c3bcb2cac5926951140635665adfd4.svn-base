<?php
CLASS ISC_PRODUCTDESCRIPTION_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$GLOBALS['ProductDesc'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetDesc();
		if(!trim($GLOBALS['ProductDesc'])) {
			$GLOBALS['HidePanels'][] = 'ProductDescription';
		}

//		$warranty = $GLOBALS['ISC_CLASS_PRODUCT']->GetProductWarranty();
//		if(strpos($warranty, "<") === false) {
//			$warranty = nl2br($warranty);
//		}
//
//		$GLOBALS['ProductWarranty'] = $warranty;
//		
//		$GLOBALS['ProductManufacturer'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetProdMfg();

	}
}

?>