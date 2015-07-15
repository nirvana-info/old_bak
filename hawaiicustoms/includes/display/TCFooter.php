<?php

class ISC_TCFooter_PANEL extends PANEL {

    public function SetPanelSettings() {
        $GLOBALS['TCFooterJavaScript'] = '';
        if (isset($GLOBALS['ISC_SRCH_BRAND_NAME']) && $GLOBALS['ISC_SRCH_BRAND_NAME'] == 'thule') {
            $javascripts = array(
                "<script type=\"text/javascript\" src=\"{$GLOBALS['ShopPath']}/javascript/lib/fancybox/jquery.mousewheel-3.0.4.pack.js\"></script>",
                "<script type=\"text/javascript\" src=\"{$GLOBALS['ShopPath']}/javascript/lib/fancybox/jquery.fancybox-1.3.4.pack.js\"></script>",
                "<script type=\"text/javascript\" src=\"{$GLOBALS['ShopPath']}/javascript/thule_brand.js\"></script>",
            );
            $GLOBALS['TCFooterJavaScript'] .= implode("\n", $javascripts);

            $GLOBALS['TCFooterStylesheets'] .= "<link href=\"{$GLOBALS['ShopPath']}/javascript/lib/fancybox/jquery.fancybox-1.3.4.css\" type=\"text/css\" rel=\"stylesheet\" />";
        }
    }

}

?>
