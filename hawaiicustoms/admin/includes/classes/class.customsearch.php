<?php

class ISC_ADMIN_CUSTOMSEARCH
{
	public $_searchType;

	public function __construct($searchType)
	{
		$this->_searchType = $searchType;
	}
	public function SaveSearch($customName, $searchVars)
	{
		$search_params = '';

		// Does a view already exist with this name?
		$query = sprintf("select count(searchname) as num from [|PREFIX|]custom_searches where lower(searchname)='%s'", $GLOBALS['ISC_CLASS_DB']->Quote(isc_strtolower($customName)));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		$row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result);

		if ($row['num'] == 0) {
			foreach ($searchVars as $k => $v) {
				if ($k == "customName" || $k == "ToDo" || $k == "SubmitButton1" || (!is_array($v) && trim($v)=='')) {
					continue;
				}
				if (is_array($v)) {
					foreach ($v as $v2) {
						$search_params .= sprintf("%s[]=%s&", $k, urlencode($v2));
					}
				}
				else {
					$search_params .= sprintf("%s=%s&", $k, urlencode($v));
				}
			}
			$search_params = $GLOBALS['ISC_CLASS_DB']->Quote(trim($search_params, "&"));
			$customSearch = array(
				"searchtype" => $this->_searchType,
				"searchname" => $customName,
				"searchvars" => $search_params
			);
			return $GLOBALS['ISC_CLASS_DB']->InsertQuery("custom_searches", $customSearch);
		}
		else {
			return 0;
		}
	}

	public function LoadSearch($searchId)
	{
		$searchId = (int)$searchId;
		$query = sprintf("SELECT searchname, searchvars FROM [|PREFIX|]custom_searches WHERE searchtype='%s' AND searchid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->_searchType), $GLOBALS['ISC_CLASS_DB']->Quote($searchId));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

		if ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			$search_vars = array();
			parse_str(urldecode($row['searchvars']), $search_vars);
			$row['searchvars'] = $search_vars;
			return $row;
		}
		return false;
	}

	public function GetSearchesAsOptions($selected, &$NumSearches, $FirstText, $FirstAction, $DefaultAction)
	{
		// Add the default "All Orders" view
		$menu_text = GetLang($FirstText);

		if ($selected == "") {
			$menu_text = "<strong>" . $menu_text . "</strong>";
		}

		$output = sprintf("<li><a href=\"index.php?ToDo=%s&searchId=0\" style='background-image:url(\"images/view.gif\"); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px'>%s</a></li>", $FirstAction, $menu_text);

		$query = sprintf("SELECT searchid, searchname FROM [|PREFIX|]custom_searches WHERE searchtype='%s' ORDER BY searchname ASC", $GLOBALS['ISC_CLASS_DB']->Quote($this->_searchType));
		$result = $GLOBALS["ISC_CLASS_DB"]->Query($query);
		$NumSearches = $GLOBALS["ISC_CLASS_DB"]->CountResult($result);
		while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($result)) {
			$menu_text = isc_html_escape($row['searchname']);

			if (@$selected == $row['searchid']) {
				$menu_text = "<strong>" . $menu_text . "</strong>";
			}

			$output .= sprintf("<li><a href=\"index.php?ToDo=%s&searchId=%d\" style='background-image:url(\"images/view.gif\"); background-repeat:no-repeat; background-position:5px 5px; padding-left:28px'>%s</a></li>", $DefaultAction, $row['searchid'], $menu_text);
		}
		return $output;
	}

	public function DeleteSearch($searchId)
	{
		$searchId = (int)$searchId;

		$query = sprintf("DELETE FROM [|PREFIX|]custom_searches WHERE searchtype='%s' AND searchid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->_searchType), $GLOBALS['ISC_CLASS_DB']->Quote($searchId));

		if ($GLOBALS['ISC_CLASS_DB']->Query($query)) {
			return true;
		} else {
			return false;
		}
	}
}
?>
