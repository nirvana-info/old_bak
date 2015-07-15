<?php

  class ISC_ADMIN_WISHLIST
    {
        public function HandleToDo($Do)
        {
            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('customers');
            switch (isc_strtolower($Do)) {
                default:
                {   
                    if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Brands)) {
                        $GLOBALS['BreadcrumEntries'] = array(GetLang('Home') => "index.php", GetLang('Wishlist') => "index.php?ToDo=wishlist");

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
                        }

                        $this->manageWishList();

                        if(!isset($_REQUEST['ajax'])) {
                            $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
                        }
                    } else {
                        $GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
                    }
                }
            }
        }
        
       public function manageWishList($MsgDesc = "", $MsgStatus = "")
        {
            // Fetch any results, place them in the data grid
            
                $numMake = 0; 
                $GLOBALS['WishListDataGrid'] = $this->ManageWishListGrid($numMake);
                    
                // Was this an ajax based sort? Return the table now
                if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) {
                    echo $GLOBALS['WishListDataGrid'];
                    return;
                }

                if ($MsgDesc != "") {
                    $GLOBALS['Message'] = MessageBox($MsgDesc, $MsgStatus);
                }


                $GLOBALS['WishListIntro'] = GetLang('ManageWishListIntro');

                // No results
                if($numMake == 0) {
                    $GLOBALS['DisplayGrid'] = "none";
                        $GLOBALS['Message'] = MessageBox(GetLang('NoWishList'), MSG_SUCCESS);
                }

                $GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("wishlist.manage");
                $GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
        }

        public function ManageWishListGrid(&$numMake)
        {
            // Show a list of news in a table
            $page = 0;
            $start = 0;
            $numMake = 0;
            $numPages = 0;
            $GLOBALS['WishListGrid'] = "";
            $GLOBALS['Nav'] = "";
            $max = 0;
            $searchURL = '';

                                     
            if (isset($_GET['sortOrder']) && $_GET['sortOrder'] == 'desc') {
                $sortOrder = 'desc';
            } else {
                $sortOrder = "asc";
            }

            $sortLinks = array(
                "CustomerName" => "c.custconfirstname",
                "ProductName" => "p.prodname",
				"Amount" => "p.prodprice"
            );

            if (isset($_GET['sortField']) && in_array($_GET['sortField'], $sortLinks)) {
                $sortField = $_GET['sortField'];
                SaveDefaultSortField("manageWishList", $_REQUEST['sortField'], $sortOrder);
            }
            else {
                list($sortField, $sortOrder) = GetDefaultSortField("manageWishList", "c.custconfirstname", $sortOrder);
            }
            if (isset($_GET['page'])) {
                $page = (int)$_GET['page'];
            }
            else {
                $page = 1;
            }

            $sortURL = sprintf("&sortField=%s&sortOrder=%s", $sortField, $sortOrder);
            $GLOBALS['SortURL'] = $sortURL;

            // Limit the number of WishList returned
            if ($page == 1) {
                $start = 1;
            }
            else {
                $start = ($page * ISC_WISHLIST_PER_PAGE) - (ISC_WISHLIST_PER_PAGE-1);
            }

            $start = $start-1;

            // Get the results for the query
            $wishlistResult = $this->_GetWishList($start, $sortField, $sortOrder, $numMake);
            $numPages = ceil($numMake / ISC_WISHLIST_PER_PAGE);
            // Workout the paging navigation
            if($numMake > ISC_WISHLIST_PER_PAGE) {
                $GLOBALS['Nav'] = sprintf("(%s %d of %d) &nbsp;&nbsp;&nbsp;", GetLang('Page'), $page, $numPages);

                $GLOBALS['Nav'] .= BuildPagination($numMake, ISC_WISHLIST_PER_PAGE, $page, sprintf("index.php?ToDo=wishlist%s", $sortURL));
            }
            else {
                $GLOBALS['Nav'] = "";
            }

            $GLOBALS['SortField'] = $sortField;
            $GLOBALS['SortOrder'] = $sortOrder;

            BuildAdminSortingLinks($sortLinks, "index.php?ToDo=wishlist&amp;".$searchURL."&amp;page=".$page, $sortField, $sortOrder);


            // Workout the maximum size of the array
            $max = $start + ISC_WISHLIST_PER_PAGE;

            if ($max > count($wishlistResult)) {
                $max = count($wishlistResult);
            }
            
            if($numMake > 0) {
                while ($row = $GLOBALS["ISC_CLASS_DB"]->Fetch($wishlistResult)) {
                    $GLOBALS['CustomerName'] = isc_html_escape($row['customername']);
                    $GLOBALS['ProductName'] = isc_html_escape($row['prodname']);
                    $GLOBALS['Amount'] = number_format($row['prodprice'],2);
                    
                    $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("wishlist.manage.row");
                    $GLOBALS['WishListGrid'] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
                }
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("wishlist.manage.grid");
                return $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
            }
        }
        
        public function _GetWishList($Start, $SortField, $SortOrder, &$NumResults)
        {

//            $query = "SELECT * FROM [|PREFIX|]product_mmy p";
	          $query = "SELECT concat(c.custconfirstname,' ',c.custconlastname) as customername, p.prodname, p.prodprice FROM [|PREFIX|]wishlists w, [|PREFIX|]wishlist_items wi, [|PREFIX|]products p, [|PREFIX|]customers c where wi.wishlistid = w.wishlistid and c.customerid = w.customerid and p.productid = wi.productid";

			$countQuery = "SELECT count(*) FROM [|PREFIX|]wishlists w, [|PREFIX|]wishlist_items wi, [|PREFIX|]products p, [|PREFIX|]customers c ";
            $queryWhere = ' where wi.wishlistid = w.wishlistid and c.customerid = w.customerid and p.productid = wi.productid ';
			$countQuery .= $queryWhere;

			$result = $GLOBALS['ISC_CLASS_DB']->Query($countQuery);
            $NumResults = $GLOBALS['ISC_CLASS_DB']->FetchOne($result);
            if($NumResults > 0) {
                $query .= " ORDER BY ".$SortField." ".$SortOrder;
                // Add the limit
                $query .= $GLOBALS["ISC_CLASS_DB"]->AddLimit($Start, ISC_WISHLIST_PER_PAGE);
                $result = $GLOBALS["ISC_CLASS_DB"]->Query($query);

                return $result;
                
            }
            else {
                return false;
            }
        }
    }
?>
