<?php
	define("ISC_EXPORT_FROOGLE_PER_PAGE", 20);
	class ISC_ADMIN_FROOGLE
	{
		public function HandleToDo($Do)
		{
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('froogle');
			switch (isc_strtolower($Do)) {
				case "cancelfroogleexport":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Export_Froogle)) {
						$this->CancelFroogleExport();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "downloadfroogleexport":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Export_Froogle)) {
						$this->DownloadFroogleExport();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "exportfroogleintro":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Export_Froogle)) {
						$this->ExportFroogleIntro();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
					break;
				case "exportfroogle":
					if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Export_Froogle)) {
						$this->ExportFroogle();
					} else {
						$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
					}
			}
		}

		private function CancelFroogleExport()
		{
			if(isset($_SESSION['FroogleFile']) && basename($_SESSION['FroogleFile']) == $_SESSION['FroogleFile'] && file_exists(APP_ROOT."../cache/".$_SESSION['FroogleFile'])) {
				@unlink(APP_ROOT."../cache/".$_SESSION['FroogleFile']);
				unset($_SESSION['FroogleFile']);
			}
			$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('FroogleExportCancelled'), MSG_ERROR);
		}

		private function ExportFroogleIntro()
		{
			$_SESSION['FroogleFile'] = '';

			$query = "SELECT COUNT(*)
			FROM [|PREFIX|]products p
			LEFT JOIN [|PREFIX|]categoryassociations ca ON (p.productid=ca.productid)
			WHERE prodvisible=1";

			$numProducts = $GLOBALS['ISC_CLASS_DB']->FetchOne($query);
			if($numProducts == 0) {
				$GLOBALS['HideExportIntro'] = "none";
			}
			else {
				$GLOBALS['HideNoProducts'] = "none";
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("froogle.intro");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
			exit;
		}

		private function ExportFroogle()
		{
			if(!isset($_REQUEST['start'])) {
				// This is our first visit to the export function. We create the file and the export session

				if(isset($_SESSION['FroogleFile']) && basename($_SESSION['FroogleFile']) == $_SESSION['FroogleFile'] && file_exists(APP_ROOT."../cache/".$_SESSION['FroogleFile'])) {
					@unlink(APP_ROOT."../cache/".$_SESSION['FroogleFile']);
					unset($_SESSION['FroogleFile']);
				}

				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

				$exportFile = "froogle-export-".time().".xml";
				$_SESSION['FroogleFile'] = $exportFile;
				$fp = fopen(APP_ROOT."/../cache/".$exportFile, "w+");
				if(!$fp) {
					echo "<script type='text/javascript'>self.parent.FroogleExportError('".GetLang('FroogleExportUnableCreate')."');</script>";
					exit;
				}

				$exportDate = isc_date("Y-m-d\TH:i:s\Z", time());

				$header = '<?xml version="1.0" encoding="' . GetConfig('CharacterSet') . '"?>
				<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">
					<title>'.$GLOBALS['StoreName'].'</title>
					<link rel="self" href="'.str_replace("https://", "http://",$GLOBALS['ShopPath']).'"/>
					<updated>'.$exportDate.'</updated>
					<author>
						<name>' . isc_html_escape($GLOBALS['StoreName']) . '</name>
					</author>
					<id>tag:'.time().'</id>';

				// Add the header to the file
				fwrite($fp, $header);
				$start = 0;

				// Count the number of products we'll be exporting
				$query = "
					SELECT COUNT(*)
					FROM [|PREFIX|]products p
					LEFT JOIN [|PREFIX|]categoryassociations ca ON (p.productid=ca.productid)
					WHERE prodvisible=1
				";
				$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
				$numProducts = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
				$_SESSION['FroogleNumProducts'] = $numProducts;
			}
			else {
				$exportFile = '';
				if(isset($_SESSION['FroogleFile']) && basename($_SESSION['FroogleFile']) == $_SESSION['FroogleFile'] && file_exists(APP_ROOT."/../cache/".$_SESSION['FroogleFile'])) {
					$exportFile = $_SESSION['FroogleFile'];
				}

				if(!$exportFile) {
					echo "<script type='text/javascript'>self.parent.FroogleExportError('".GetLang('FroogleExportInvalidFile')."');</script>";
					exit;
				}

				$fp = fopen(APP_ROOT."/../cache/".$exportFile, "a");
				if(!$fp) {
					echo "<script type='text/javascript'>self.parent.FroogleExportError('".GetLang('FroogleExportUnableCreate')."');</script>";
					exit;
				}
				$start = $_REQUEST['start'];
			}

			ob_end_clean();

			$entryBuffer = array();
			$expirationDate = isc_date("Y-m-d", time()+60*60*24*30);

			$query = "
				SELECT p.*, c.catname,
					(SELECT b.brandname FROM [|PREFIX|]brands b WHERE b.brandid=p.prodbrandid) AS brandname,
					(SELECT pi.imagefile FROM [|PREFIX|]product_images pi WHERE pi.imageprodid=p.productid AND pi.imageisthumb=0 AND pi.imagesort=1) AS imagefile
				 FROM [|PREFIX|]products p
				INNER JOIN [|PREFIX|]categoryassociations ca ON (p.productid=ca.productid)
				INNER JOIN [|PREFIX|]categories c ON (ca.categoryid=c.categoryid)
				WHERE p.prodvisible=1
			";
			$done = $start;
			$lastPercent = 0;
			$query .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, ISC_EXPORT_FROOGLE_PER_PAGE);
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
				$link = ProdLink($row['prodname']);
				$link = str_replace("https://", "http://", $link);
				$desc = strip_tags($row['proddesc']);
				// If the product is on sale, use the sale price instead of the product price
				if (($row['prodsaleprice'] < $row['prodprice']) && ($row['prodsaleprice'] > 0)) {
					$price = CNumeric($row['prodsaleprice']);
				}
				else {
					$price = CNumeric($row['prodprice']);
				}
				$entry = array();
				if($row['brandname']) {
					$entry[] = sprintf("<g:brand><![CDATA[%s]]></g:brand>", isc_html_escape($row['brandname']));
				}

				$entry []= sprintf("<g:department><![CDATA[%s]]></g:department>", isc_html_escape($row['catname']));
				if(isc_strlen($desc) > 1000) {
					$desc = isc_substr($desc, 0, 997)."...";
				}
				$entry[] = sprintf("<summary><![CDATA[%s]]></summary>", isc_html_escape($desc));
				$entry[] = sprintf("<g:expiration_date><![CDATA[%s]]></g:expiration_date>", $expirationDate);
				$entry[] = sprintf("<g:id>%d</g:id>", $row['productid']);

				if($row['imagefile']) {
					$image = str_replace("https://", "http://",$GLOBALS['ShopPath']).'/'.GetConfig('ImageDirectory').'/'.$row['imagefile'];
					$entry[] = sprintf("<g:image_link>%s</g:image_link>", isc_html_escape($image));
				}

				$entry[] = sprintf("<link>%s</link>", isc_html_escape($link));
				$entry[] = sprintf("<g:price>%s</g:price>", $price);
				if($row['prodcode']) {
					$entry[] = sprintf("<g:model_number><![CDATA[%s]]></g:model_number>", isc_html_escape($row['prodcode']));
				}
				$entry = implode("\n\n\t", $entry);
				$entry = sprintf("<entry>
					<title><![CDATA[%s]]></title>
					%s
					</entry>",
					isc_html_escape($row['prodname']),
					$entry);

				fwrite($fp, $entry);
				++$done;
				$percent = ceil($done/$_SESSION['FroogleNumProducts']*100);
				// Spit out a progress bar update
				if($percent != $lastPercent) {
					echo sprintf("<script type='text/javascript'>self.parent.UpdateFroogleExportProgress('%s');</script>", $percent);
					flush();
				}
			}

			$end = $start + ISC_EXPORT_FROOGLE_PER_PAGE;
			if($end >= $_SESSION['FroogleNumProducts']) {
				fwrite($fp, "</feed>");
				echo "<script type='text/javascript'>self.parent.FroogleExportComplete();</script>";
			}
			else {
				echo sprintf("<script type='text/javascript'>window.location='index.php?ToDo=exportFroogle&start=%d';</script>", $end);
			}
			fclose($fp);
			exit;
		}

		private function DownloadFroogleExport()
		{
			$exportFile = '';
			if(isset($_SESSION['FroogleFile']) && basename($_SESSION['FroogleFile']) == $_SESSION['FroogleFile'] && file_exists(APP_ROOT."/../cache/".$_SESSION['FroogleFile'])) {
				$exportFile = $_SESSION['FroogleFile'];
			}

			if(!$exportFile) {
				echo "<script type='text/javascript'>self.parent.FroogleExportError('".GetLang('FroogleExportInvalidFile')."');</script>";
				exit;
			}

			unset($_SESSION['FroogleFile']);

			$file = APP_ROOT."/../cache/".$exportFile;

			DownloadFile($file);
		}
	}

?>
