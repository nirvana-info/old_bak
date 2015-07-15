<?php

class ISC_PRODUCT_HELPER {

    public function GetProductCallForBestPrice(array &$productData) {
        $categoryId = (isset($productData['prodcatids']) && !empty($productData['prodcatids'])) ? (int)$productData['prodcatids'] : (int)$productData['categoryid'];
        $categoryParentId = (int)$productData['catparentid'];
        $bandId = (int)$productData['prodbrandid'];
        $seriesId = (int)$productData['brandseriesid'];
        $displayScript = $displayfor = $popupMessage = '';
        $callForBest = array();
        
        static $isCustomerServiceTime = 'xxxxxx';
        if ($isCustomerServiceTime === 'xxxxxx') {
            $isCustomerServiceTime = IsCustomerServiceTime();
        }
        
        if ($categoryId) {
            $query = "select c1.categoryid,c1.catparentid,cs.displayfor,cs.popupmessage,cs.display_script
                from [|PREFIX|]categories c1 
                left join [|PREFIX|]categories c2 on c1.catparentid = c2.categoryid
                left join [|PREFIX|]coupon_settings cs on c1.categoryid = cs.catid
                where c1.callbestprice = 'yes' AND (c1.catparentid= $categoryParentId OR c1.categoryid IN ($categoryId,$categoryParentId)) order by c1.catparentid";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while ($item = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                if ($item['catparentid'] == 0) {
                    $callForBest[0] = $item;
                } else {
                    $callForBest[$item['catparentid']][] = $item['categoryid'];
                }
            }
            if (!empty($callForBest)) {
                if (isset($callForBest[$categoryParentId]) && in_array($categoryId, $callForBest[$categoryParentId])) {
                    $popupMessage = $callForBest[0]['popupmessage'];
                    $displayfor = $callForBest[0]['displayfor'];
                    $displayScript = $callForBest[0]['display_script'];
                } elseif (!isset($callForBest[$currentCategoryParentId])) {
                    $displayfor = $callForBest[0]['displayfor'];
                    $popupMessage = $callForBest[0]['popupmessage'];
                    $displayScript = $callForBest[0]['display_script'];
                }
            }
        }

        if ($bandId) {
            $query = "select c.displayfor,c.popupmessage,c.display_script
                    from [|PREFIX|]brands b
                    left join [|PREFIX|]coupon_settings c on b.brandid = c.brandid
                    where callbestprice='yes' AND b.brandid=$bandId";
            $item = $GLOBALS['ISC_CLASS_DB']->Fetch($GLOBALS['ISC_CLASS_DB']->Query($query));
            if ($item) {
                $query = "SELECT seriesid FROM [|PREFIX|]brand_series WHERE brandid=$bandId AND callbestprice='yes'";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                $otherSeriesid = array();

                while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    $otherSeriesid[] = $row['seriesid'];
                }
                if (empty($otherSeriesid) || in_array($seriesId, $otherSeriesid)) {
                    $displayfor = $item['displayfor'];
                    $popupMessage = $item['popupmessage'];
                    $displayScript = $item['display_script'];
                }
            }
        }
        $popupMessage = nl2br($popupMessage);
        
        if (empty($displayfor) || ($displayfor != "entireday" && !$isCustomerServiceTime)) {
            return false;
        }
        
        return array(
            'popupMessage' => $popupMessage,
            'displayScript' => $displayScript
        );
    }

}