<?php
CLASS ISC_FEATUREDPOINTS_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		$GLOBALS['ProductDesc'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetDesc();
		if(!trim($GLOBALS['ProductDesc'])) {
			$GLOBALS['HidePanels'][] = 'ProductDescription';
		}
        
        $GLOBALS['ProductDescFeature'] = $GLOBALS['ISC_CLASS_PRODUCT']->GetDescFeature();
       
	}
}

?>