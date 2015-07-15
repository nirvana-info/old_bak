<?php
class ISC_SIMILARPRODUCTSBYTAG_PANEL extends PANEL
{
	public function SetPanelSettings()
	{
		if($GLOBALS['ISC_CLASS_PRODUCT']->ProductHasTags() == false) {
			$this->DontDisplay = true;
			return false;
		}

		// Get the tags associated with this product
		$tags = array();
		$query = "
			SELECT t.*
			FROM [|PREFIX|]product_tags t
			INNER JOIN [|PREFIX|]product_tagassociations ta ON (ta.productid='".(int)$GLOBALS['ISC_CLASS_PRODUCT']->GetProductId()."' AND ta.tagid=t.tagid)
			WHERE t.tagcount > 1
			ORDER BY t.tagname ASC
		";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($tag = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$tags[] = $tag;
		}

		if(empty($tags)) {
			$this->DontDisplay = true;
			return false;
		}
		$tagCount = count($tags);

		$min = GetConfig('TagCloudMinSize');
		$max = GetConfig('TagCloudMaxSize');
		$GLOBALS['SNIPPETS']['TagList'] = '';
		foreach($tags as $tag) {
			$weight = ceil(($tag['tagcount']/$tagCount)*100);
			if($max > $min) {
				$fontSize = (($weight/100) * ($max - $min)) + $min;
			}
			else {
				$fontSize = (((100-$weight)/100) * ($max - $min)) + $max;
			}
			$fontSize = (int)$fontSize;
			$GLOBALS['FontSize'] = $fontSize.'%';
			$GLOBALS['TagName'] = isc_html_escape($tag['tagname']);
			$GLOBALS['TagLink'] = TagLink($tag['tagfriendlyname'], $tag['tagid']);
			$GLOBALS['TagProductCount'] = sprintf(GetLang('XProductsTaggedWith'), $tag['tagcount'], isc_html_escape($tag['tagname']));
			$GLOBALS['SNIPPETS']['TagList'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet('SimilarProductsByTagTag');
		}
	}
}
?>