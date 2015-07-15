<?php

	CLASS ISC_SHOWIMAGE_PANEL extends PANEL
	{
		/**
		 * Set the settings for this panel.
		 */
		public function SetPanelSettings()
		{
			$image_list = $GLOBALS['ISC_CLASS_ACCOUNT']->GetUploadImage();

			if(count($image_list) == 0){
				$GLOBALS['SNIPPETS']['UploadImageList'] = 'There is no image at the moment.';
			}
			foreach($image_list as $address) {
				$GLOBALS['picId'] = (int) $address['picid'];
				$GLOBALS['ImageUrl'] = $address['path'];
				$GLOBALS['ImageDesc'] = isc_html_escape($address['description']);

				$GLOBALS['SNIPPETS']['UploadImageList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("UploadImageItem");
			}

		}

	}

?>