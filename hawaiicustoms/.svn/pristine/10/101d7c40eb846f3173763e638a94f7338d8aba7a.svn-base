<?php

	class ISC_NEWS
	{

		var $_newsid = 0;
		var $_newstitle = "";
		var $_newscontent = "";
		var $_newsdate = "";

		function __construct()
		{
			$this->_SetPageData();
		}

		function _SetPageData()
		{

			if (isset($_REQUEST['newsid'])) {
				$newsid = (int)$_REQUEST['newsid'];
			}
			else {
				$newsid = preg_replace('#\.html$#i', '', $GLOBALS['PathInfo'][1]);
				$newsid = $GLOBALS['ISC_CLASS_DB']->Quote(MakeURLNormal($newsid));
			}

			$query = sprintf("select * from [|PREFIX|]news where newsid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($newsid));
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

			if ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$this->_newsid = $row['newsid'];
				$this->_newstitle = $row['newstitle'];
				$this->_newscontent = $row['newscontent'];
				$this->_newsdate = $row['newsdate'];
			}
		}

		function HandlePage()
		{
			$this->ShowNews();
		}

		function ShowNews()
		{
			if ($this->_newsid > 0) {
				$GLOBALS['NewsTitle'] = $this->_newstitle;
				$GLOBALS['NewsContent'] = $this->_newscontent;

				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
					$GLOBALS['NewsContent'] = str_replace($GLOBALS['ShopPathNormal'], $GLOBALS['ShopPathSSL'], $GLOBALS['NewsContent']);
				}

				$GLOBALS['NewsDate'] = isc_date(GetConfig('ExtendedDisplayDateFormat'), $this->_newsdate);

				$GLOBALS['ISC_CLASS_TEMPLATE']->SetPageTitle($this->_newstitle);
				$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("news");
				$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			}
			else {
				ob_end_clean();
				header("Location: " . $GLOBALS['ShopPath']);
				die();
			}
		}
	}

?>
