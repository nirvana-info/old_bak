<?php
class ISC_ADMIN_REVIEW_OVERVIEW extends ISC_ADMIN_REVIEW
{
	/**
	*	Show the average status of each category
	*/
	public function ProductReviewOverviewGrid()
	{

		$GLOBALS['OrderGrid'] = "";

		// How many records per page?
		if(isset($_GET['Show'])) {
			$per_page = (int)$_GET['Show'];
		}
		else {
			$per_page = 20;
		}

		$GLOBALS['ProductsPerPage'] = $per_page;
		$GLOBALS["IsShowPerPage" . $per_page] = 'selected="selected"';

		// Should we limit the records returned?
		if(isset($_GET['Page'])) {
			$page = (int)$_GET['Page'];
		}
		else {
			$page = 1;
		}

		$GLOBALS['ProductsByNumViewsCurrentPage'] = $page;

		// Workout the start and end records
		$start = ($per_page * $page) - $per_page;
		$end = $start + ($per_page - 1);

		// Only fetch products this user can actually see
		$vendorSql = '';
		/*
		$vendorRestriction = $this->GetVendorRestriction();
		$vendorSql = '';
		if($vendorRestriction !== false) {
			$vendorSql = " WHERE prodvendorid = '" . $GLOBALS['ISC_CLASS_DB']->Quote($vendorRestriction) . "'";
		}
		*/

		// How many products are there in total?
		$CountQuery = "
			SELECT
				COUNT(*) AS num
			FROM
				[|PREFIX|]products
			" . $vendorSql;

		$result = $GLOBALS['ISC_CLASS_DB']->Query($CountQuery);

		$row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$total_products = $row['num'];

		//blessen
		if (isset($_REQUEST['export']) and  $total_products <= 0)
		{
			header("location:index.php?ToDo=viewReviews#");
			exit;
		}

		if ($total_products > 0) {
            
            //Sorting code goes by Simha
            if(isset($_GET['SortOrder']) && $_GET['SortOrder'] == "desc") {
                $sortOrder = 'desc';
            }
            else {
                $sortOrder = 'asc';
            }
            
            //changed field name and commented
            $sortFields = array('commonnamefield','avgrating','avgqutrating','avginsrating','avgvalrating','avgsptrating','avgdlvrating');//changed field name
            if(isset($_GET['SortBy']) && in_array($_GET['SortBy'], $sortFields)) {
                $sortField = $_GET['SortBy'];
                SaveDefaultSortField("ProductReviewsByViews", $_REQUEST['SortBy'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("ProductReviewsByViews", "commonnamefield", $sortOrder);
            }
            
            $sortLinks = array(        
                "Name" => "commonnamefield",
                "Rating" => "avgrating",
                "RatingQuality" => "avgqutrating",
                "RatingInstall" => "avginsrating",
                "RatingValue" => "avgvalrating",
                "RatingSupport" => "avgsptrating",
				"RatingDelivery" => "avgdlvrating"
            );
            
            //Above comment and new addition belowby Simha 
            //$sortLinks = array();
            
            $numSoldCounter = '921124412848294';
            BuildAdminSortingLinks($sortLinks, "javascript:SortProductsByNumViews('%%SORTFIELD%%', '%%SORTORDER%%');", $sortField, $sortOrder);
            //Sorting code goes ends by Simha
            
            $this->GetQueries($countQuery, $mainQuery, $vendorSql, $sortField, $sortOrder, $NameField);

            // How many products are there in total?
            $result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);

            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
            $total_records = $row['num'];
            
            
			//blessen
			if (isset($_REQUEST['export']) )
			{
               

				$file_path = 'exporttemp.csv';
				
				$content =  "Item Id,Item,Views,Units Sold ,Units Sold/Views,Average Rating \n";
				$resultexp = $GLOBALS['ISC_CLASS_DB']->Query($mainQuery);
				while($rowex = $GLOBALS['ISC_CLASS_DB']->Fetch($resultexp))
				{

					$pname = str_replace(",", " ", $rowex['commonnamefield']);
					
					$content.=  $rowex['itemid'].",".$pname.",".$rowex['prodnumviews'].",".(float)$rowex['numsold'].",".(float)($rowex['unitssoldpercent']*100)."%,".(float)$rowex['avgrating']."\n";

				}

				if (!$handle = fopen($file_path, 'w')) {
									 
				}

				if (fwrite($handle, $content) === FALSE) {
										
				}
				fclose($handle);

				$nename = "export_".date("F_j_Y_g_i_a");                 

						// file size in bytes
						$fsize = filesize($file_path); 

						$fileContents = file_get_contents($file_path);

						header("Content-length:".$fsize);
						header("Content-type: text/csv");
						header("Content-Disposition: attachment; filename=".$nename.".csv");
						echo $fileContents;
					
									if (file_exists($file_path)) {
										@unlink($file_path);
										clearstatcache();
									}

						die();

			}

			// Workout the paging
			$num_pages = ceil($total_records / $per_page);
            
            // Should we limit the records returned?
            if(isset($_GET['Page']) && (int)$_GET['Page']<=$num_pages) {
                $page = (int)$_GET['Page'];
            }
            else {
                $page = 1;
            }

            // Workout the start and end records
            $start = ($per_page * $page) - $per_page;
            $end = $start + ($per_page - 1);

			$paging = sprintf(GetLang('PageXOfX'), $page, $num_pages);
			$paging .= "&nbsp;&nbsp;&nbsp;&nbsp;";

			// Is there more than one page? If so show the &laquo; to jump back to page 1
			if($num_pages > 1) {
				$paging .= "<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(1)'>&laquo;</a> | ";
			}
			else {
				$paging .= "&laquo; | ";
			}

			// Are we on page 2 or above?
			if($page > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%s</a> | ", $page-1, GetLang('Prev'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Prev'));
			}

			for($i = 1; $i <= $num_pages; $i++) {
				// Only output paging -5 and +5 pages from the page we're on
				if($i >= $page-6 && $i <= $page+5) {
					if($page == $i) {
						$paging .= sprintf("<strong>%d</strong> | ", $i);
					}
					else {
						$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%d</a> | ", $i, $i);
					}
				}
			}

			// Are we on page 2 or above?
			if($page < $num_pages) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>%s</a> | ", $page+1, GetLang('Next'));
			}
			else {
				$paging .= sprintf("%s | ", GetLang('Next'));
			}

			// Is there more than one page? If so show the &raquo; to go to the last page
			if($num_pages > 1) {
				$paging .= sprintf("<a href='javascript:void(0)' onclick='ChangeProductsByNumViewsPage(%d)'>&raquo;</a> | ", $num_pages);
			}
			else {
				$paging .= "&raquo; | ";
			}

			$paging = rtrim($paging, ' |');
			$GLOBALS['Paging'] = $paging;

			// Should we set focus to the grid?
			if(isset($_GET['FromLink']) && $_GET['FromLink'] == "true") {
				$GLOBALS['JumpToOrdersByItemsSoldGrid'] = "<script type=\"text/javascript\">document.location.href='#ordersByItemsSoldAnchor';</script>";
			}
            //Sorting code moved to the topof this loop
            
            //Code here has been moved to the fucntion GetQueries 
            
			// Add the Limit
			$mainQuery .= $GLOBALS['ISC_CLASS_DB']->AddLimit($start, $per_page);      
			$result = $GLOBALS['ISC_CLASS_DB']->Query($mainQuery);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($result) > 0) {
				$ShopPath = GetConfig('ShopPath');
                $template = GetConfig('template');
				while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
					$code = GetLang('NA');
					if($row['prodcode'] != '') {
						$code = isc_html_escape($row['prodcode']);
					}
					if($_REQUEST['showby'] != ''){
                        $GLOBALS['OrderGrid'] .= sprintf("
                            <tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\"> 
                                <td nowrap class=\"".$GLOBALS['SortedFieldNameClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                                <td nowrap class=\"".$GLOBALS['SortedFieldAverageRatingClass']."\">
                                    %s
                                </td>
                            </tr>
                        ",                             
                           isc_html_escape($row['commonnamefield']),
                           parent::wrapRatingImages($row['avgrating']),
                           parent::wrapRatingImages($row['avgqutrating']),
                           parent::wrapRatingImages($row['avginsrating']),
                           parent::wrapRatingImages($row['avgvalrating']),
                           parent::wrapRatingImages($row['avgsptrating']),
                           parent::wrapRatingImages($row['avgdlvrating'])
                        );    
                    }
				}
			}
		}
		else {
			$GLOBALS['OrderGrid'] .= sprintf("
				<tr class=\"GridRow\" onmouseover=\"this.className='GridRowOver';\" onmouseout=\"this.className='GridRow';\">
					<td nowrap height=\"22\" colspan=\"5\">
						<em>%s</em>
					</td>
				</tr>
			", GetLang('StatsNoProducts')
			);
		}

		$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("reviews.manage.overviewgrid");
		$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
	}

	private function GetQueries(&$countQuery, &$mainQuery, $vendorSql, $sortField, $sortOrder, &$NameField)
    {
            
            switch($_REQUEST['showby']) {
                case 'category':    {
                    if($vendorSql=="")    {   
                        $WhereQuery = " WHERE rc.catparentid = 0 ";  
                    }
                    else    {    
                        $WhereQuery = " AND rc.catparentid = 0 ";   
                    }
                    
                    $mainQuery = "
                    	SELECT   t.productid, 
                    			t.prodcode, 
                    			t.prodname, 
                    			t.categoryid itemid, 
                    			t.catname commonnamefield, 
                    			AVG(op.revrate) AS avgrating, 
                    			AVG(op.qualityrate) AS avgqutrating, 
                    			AVG(op.installrate) AS avginsrating, 
                    			AVG(op.valuerate) AS avgvalrating, 
                    			AVG(op.supportrate) AS avgsptrating, 
                    			AVG(op.deliveryrate) AS avgdlvrating 
						FROM
						  (SELECT 
						    p.productid, p.prodcode, p.prodname, rc.categoryid, rc.catname 
						  FROM
						    isc_products p 
						    INNER JOIN
						    isc_categoryassociations ca 
						    ON (ca.productid = p.productid) 
						    LEFT JOIN
						    isc_categories c 
						    ON (c.categoryid = ca.categoryid) 
						    LEFT JOIN
						    isc_categories rc 
						    ON (c.catparentid = rc.categoryid) 
						  ". $vendorSql . "
                                " . $WhereQuery . "
						    UNION
						    ALL 
						    SELECT 
						      p.productid, p.prodcode, p.prodname, rc.categoryid, rc.catname 
						    FROM
						      isc_products p 
						      INNER JOIN
						      isc_categoryassociations ca 
						      ON (ca.productid = p.productid) 
						      LEFT JOIN
						      isc_categories c 
						      ON (c.categoryid = ca.categoryid) 
						      LEFT JOIN
						      isc_categories rc 
						      ON (
						        c.catparentid = 0 
						        AND c.categoryid = rc.categoryid
						      ) 
						    ". $vendorSql . "
                                " . $WhereQuery . ") t 
						    LEFT JOIN
						    (SELECT 
						      revproductid, AVG(revrating) revrate, AVG(qualityrating) qualityrate, AVG(installrating) installrate, AVG(valuerating) valuerate, AVG(supportrating) supportrate, AVG(deliveryrating) deliveryrate 
						    FROM
						      isc_reviews 
						    GROUP BY revproductid) AS op 
						    ON op.revproductid = t.productid 
						  GROUP BY t.categoryid 
						  ORDER BY " . $sortField . " " . $sortOrder;
                    
                    /*$mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    rc.categoryid itemid,
                                    rc.catname commonnamefield, 
                                    AVG(revrate) AS avgrating,
                                    AVG(qualityrate) AS avgqutrating,                           
                                    AVG(installrate) AS avginsrating,
                                    AVG(valuerate) AS avgvalrating,
                                    AVG(supportrate) AS avgsptrating,
                                    AVG(deliveryrate) AS avgdlvrating
                                FROM
                                    [|PREFIX|]products p
                                    INNER JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid )
                                    LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid )    
                                    LEFT JOIN [|PREFIX|]categories rc ON ((c.catparentid = rc.categoryid) || (c.catparentid=0 AND c.categoryid=rc.categoryid)) AND rc.catparentid = 0                           
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        AVG(revrating) revrate, 
                                        AVG(qualityrating) qualityrate,
                                        AVG(installrating) installrate,
                                        AVG(valuerating) valuerate,
                                        AVG(supportrating) supportrate,
                                        AVG(deliveryrating) deliveryrate,
                                        revproductid FROM [|PREFIX|]reviews
                                        GROUP BY revproductid
                                    ) AS op ON op.revproductid = p.productid 
                                " . $vendorSql . "
                                " . $WhereQuery . "
                                GROUP BY rc.categoryid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;*/
                     $countQuery = "SELECT COUNT(DISTINCT rc.categoryid) AS num FROM
                                        [|PREFIX|]products p
                                        INNER JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid )
                                        LEFT JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid )    
                                        LEFT JOIN [|PREFIX|]categories rc ON ((c.catparentid = rc.categoryid) || (c.catparentid=0 AND c.categoryid=rc.categoryid)) AND rc.catparentid = 0
                                    " . $vendorSql . "
                                    " . $WhereQuery . " ";
                                    
                    //$NameField = 'catname';       
                    //LEFT JOIN [|PREFIX|]categories rc ON ((c.catparentid = rc.categoryid) || (c.catparentid=0 AND c.categoryid=rc.categoryid))                     
                    
                    break;
                }
                case 'subcategory':    {
                    $mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    c.categoryid itemid,
                                    CONCAT(cp.catname,'-',c.catname) commonnamefield, 
                                    AVG(revrate) AS avgrating,
                                    AVG(qualityrate) AS avgqutrating,                           
                                    AVG(installrate) AS avginsrating,
                                    AVG(valuerate) AS avgvalrating,
                                    AVG(supportrate) AS avgsptrating,
                                    AVG(deliveryrate) AS avgdlvrating
                                FROM
                                    [|PREFIX|]products p
                                    INNER JOIN [|PREFIX|]categoryassociations ca ON ( ca.productid = p.productid )
                                    INNER JOIN [|PREFIX|]categories c ON ( c.categoryid = ca.categoryid ) 
                                    INNER JOIN [|PREFIX|]categories cp ON ( cp.categoryid = c.catparentid )
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        AVG(revrating) revrate, 
                                        AVG(qualityrating) qualityrate,
                                        AVG(installrating) installrate,
                                        AVG(valuerating) valuerate,
                                        AVG(supportrating) supportrate,
                                        AVG(deliveryrating) deliveryrate,
                                        revproductid FROM [|PREFIX|]reviews
                                        GROUP BY revproductid
                                    ) AS op ON op.revproductid = p.productid
                                " . $vendorSql . "
                                GROUP BY c.categoryid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;
                     $countQuery = "
                                    SELECT COUNT(DISTINCT c.categoryid) AS num
                                    FROM isc_categories c
                                    INNER JOIN isc_categoryassociations ca ON ( c.categoryid = ca.categoryid ) 
                                    INNER JOIN isc_products p ON ( ca.productid = p.productid ) 
                                    " . $vendorSql . "";

                    //$NameField = 'catname';
                    
                    break;
                }
                case 'brand':    {
                    $mainQuery = "
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    b.brandid itemid, 
                                    b.brandname commonnamefield,                                             
                                    AVG(revrate) AS avgrating,
                                    AVG(qualityrate) AS avgqutrating,                           
                                    AVG(installrate) AS avginsrating,
                                    AVG(valuerate) AS avgvalrating,
                                    AVG(supportrate) AS avgsptrating,
                                    AVG(deliveryrate) AS avgdlvrating
                                FROM
                                    [|PREFIX|]products p                                                 
                                    LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        AVG(revrating) revrate, 
                                        AVG(qualityrating) qualityrate,
                                        AVG(installrating) installrate,
                                        AVG(valuerating) valuerate,
                                        AVG(supportrating) supportrate,
                                        AVG(deliveryrating) deliveryrate,
                                        revproductid FROM [|PREFIX|]reviews
                                        GROUP BY revproductid
                                    ) AS op ON op.revproductid = p.productid
                                " . $vendorSql . "
                                GROUP BY b.brandid 
                                ORDER BY
                                " . $sortField . " " . $sortOrder;
                     $countQuery = "SELECT COUNT(DISTINCT b.brandid) AS num
                                    FROM [|PREFIX|]brands b
                                    INNER JOIN isc_products p ON b.brandid = p.prodbrandid 
                                    " . $vendorSql . "";
                                    
                    //$NameField = 'brandname';
                    
                    break;
                }
                case 'series':    {
                	
                    if($vendorSql=="")    {   
                        $WhereQuery1 = " WHERE bs.seriesid != 0 "; 
                        $WhereQuery2 = " WHERE p.brandseriesid = 0 "; 
                    }
                    else    {    
                        $WhereQuery1 = " AND bs.seriesid != 0 ";  
                        $WhereQuery2 = " AND p.brandseriesid = 0 "; 
                    }
                    
                    $mainQuery = "
                    SELECT * FROM 
                                (
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    bs.seriesid itemid, 
                                    CONCAT(b.brandname, ' - ', bs.seriesname) AS commonnamefield,
                                    AVG(revrate) AS avgrating,
                                    AVG(qualityrate) AS avgqutrating,                           
                                    AVG(installrate) AS avginsrating,
                                    AVG(valuerate) AS avgvalrating,
                                    AVG(supportrate) AS avgsptrating,
                                    AVG(deliveryrate) AS avgdlvrating
                                FROM
                                    [|PREFIX|]products p                                                
                                    LEFT JOIN [|PREFIX|]brand_series bs ON p.brandseriesid = bs.seriesid
                                    LEFT JOIN [|PREFIX|]brands b ON bs.brandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        AVG(revrating) revrate, 
                                        AVG(qualityrating) qualityrate,
                                        AVG(installrating) installrate,
                                        AVG(valuerating) valuerate,
                                        AVG(supportrating) supportrate,
                                        AVG(deliveryrating) deliveryrate,
                                        revproductid FROM [|PREFIX|]reviews
                                        GROUP BY revproductid
                                    ) AS op ON op.revproductid = p.productid
                                " . $vendorSql . "
                                " . $WhereQuery1 . "
                                GROUP BY bs.seriesid 
                                UNION
                                SELECT
                                    p.productid,
                                    p.prodcode,
                                    p.prodname,
                                    p.prodbrandid itemid, 
                                    b.brandname commonnamefield,
                                    AVG(revrate) AS avgrating,
                                    AVG(qualityrate) AS avgqutrating,                           
                                    AVG(installrate) AS avginsrating,
                                    AVG(valuerate) AS avgvalrating,
                                    AVG(supportrate) AS avgsptrating,
                                    AVG(deliveryrate) AS avgdlvrating
                                FROM
                                    [|PREFIX|]products p                                                  
                                    LEFT JOIN [|PREFIX|]brands b ON p.prodbrandid = b.brandid
                                    LEFT JOIN 
                                    (
                                    SELECT 
                                        AVG(revrating) revrate, 
                                        AVG(qualityrating) qualityrate,
                                        AVG(installrating) installrate,
                                        AVG(valuerating) valuerate,
                                        AVG(supportrating) supportrate,
                                        AVG(deliveryrating) deliveryrate,
                                        revproductid FROM [|PREFIX|]reviews
                                        GROUP BY revproductid
                                    ) AS op ON op.revproductid = p.productid
                                " . $vendorSql . "   
                                " . $WhereQuery2 . "
                                GROUP BY b.brandid
                    ) AS combinedtable
                                ORDER BY
                                combinedtable." . $sortField . " " . $sortOrder;
                                
                     $countQuery = "SELECT COUNT(DISTINCT bs.seriesid) AS num
                                    FROM [|PREFIX|]brand_series bs
                                    INNER JOIN isc_products p ON bs.seriesid = p.brandseriesid 
                                    " . $vendorSql . "";    
                    break;
                }    
                default:
                    // Fetch the orders for this page         
                    $mainQuery = "
                        SELECT
                            p.productid itemid,
                            p.prodcode,
                            p.prodname commonnamefield,
                            AVG(revrate) AS avgrating,
                            AVG(qualityrate) AS avgqutrating,                           
                            AVG(installrate) AS avginsrating,
                            AVG(valuerate) AS avgvalrating,
                            AVG(supportrate) AS avgsptrating,
                            AVG(deliveryrate) AS avgdlvrating
                        FROM
                            [|PREFIX|]products p
                            LEFT JOIN 
                            (
                            SELECT 
                                AVG(revrating) revrate, 
                                AVG(qualityrating) qualityrate,
                                AVG(installrating) installrate,
                                AVG(valuerating) valuerate,
                                AVG(supportrating) supportrate,
                                AVG(deliveryrating) deliveryrate,
                                revproductid FROM [|PREFIX|]reviews
                                GROUP BY revproductid
                            ) AS op ON op.revproductid = p.productid
                        " . $vendorSql . "      
                        ORDER BY
                            " . $sortField . " " . $sortOrder;
                    $countQuery = "
                        SELECT
                            COUNT(*) AS num
                        FROM
                            [|PREFIX|]products
                        " . $vendorSql;
                    //$NameField = 'prodname';
                    
            }        
            
    }
    
    //add other relative functions here  
}
?>
