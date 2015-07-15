<?php

/******************************************
* Page Name         : class.sitemap.php
* Containing Folder : classes
* Created By        : Baskaran B
* Created On        : 16th August, 2010
* Modified By       : Baskaran B
* Modified On       : 24th August, 2010
* Description       : Display sitemap of the site.
**************************************************/

	class ISC_SITEMAP
	{
        public function HandlePage()
        {                       
            $action = '';
            if (count($GLOBALS['PathInfo']) > 0 ){
                if (isset ($GLOBALS['PathInfo'][1])) {
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][1];
                }
                else
                {             
                    $_REQUEST['action'] = $GLOBALS['PathInfo'][0];
                }
            }

            if (isset($_REQUEST['action'])) {
                $action = isc_strtolower($_REQUEST['action']);
            }
            
            switch ($action)
            {
                default: { 
                    $this->Sitemap();
                }
            }
        }

		public function Sitemap($MsgDesc = "", $MsgStatus = "")
        {       
               //$categories = $GLOBALS['ISC_CLASS_DATA_STORE']->Read('RootCategories');
		   $catquery = $GLOBALS['ISC_CLASS_DB']->Query("SELECT categoryid , catparentid, catname FROM [|PREFIX|]categories c WHERE catparentid = 0 ");
		   $categories = array();
		   while($catrow = $GLOBALS['ISC_CLASS_DB']->Fetch($catquery)) {
			   $catid = $catrow['categoryid'];
			   $catparentid = $catrow['catparentid'];
			   $catname = $catrow['catname'];
			   $categories[0][$catid] = array('categoryid'=> $catid,'catparentid'=>$catparentid,'catname'=>$catname);
		   }
            if (!isset($categories[0])) {
                $this->DontDisplay = true;
                return;
            }

            /*----- the below block has been added to display the categories department wise ----- */
            $dept = array();
            $cat_dept = array();
            $cat_department = array();
            $cat_dept_qry = "select categoryid , catdeptid , deptname, catparentid from isc_categories c left join isc_department d on d.deptid = c.catdeptid where catparentid = 0 order by deptname asc, catdeptid desc, catname";
            $cat_dept_res = $GLOBALS['ISC_CLASS_DB']->Query($cat_dept_qry);
            while($cat_dept_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_dept_res)) {
                //$cat_department[$cat_dept_row['categoryid']]['catdeptid'] = $cat_dept_row['deptname'];
                $dept[$cat_dept_row['catdeptid']] = $cat_dept_row['deptname'] ;
                $cat_dept[$cat_dept_row['categoryid']] = $cat_dept_row['catdeptid'];
//                $cat_dept[$cat_dept_row['catdeptid']][0] .= $cat_dept_row['categoryid'];
                if(isset($categories[0][$cat_dept_row['categoryid']]))
                $categories[0][$cat_dept_row['categoryid']]['catdeptid'] = $cat_dept_row['catdeptid'];
            }
            foreach($cat_dept as $key => $value) {
               if(isset($categories[0][$key])) 
               $cat_department[0][$key] = $categories[0][$key];
            }
            $categories = $cat_department;
            $ValidCats = $this->GetValidCategories();

            $output = ''; 
   

                /* the below two variables are added to apply updown animation and image */
                $GLOBALS['contentid'] = "all_category";
                if(isset($GLOBALS['CategoryJSFunction']))
                $GLOBALS['arrowimage'] = "<img src='$path/templates/default/images/imgHdrDropDownIcon.gif' border='0' id='all_categoryimage'>";

                $temp_dept = "";  
                foreach($categories[0] as $rootCat) {
                    // If we don't have permission to view this category then skip
                    if(!CustomerGroupHasAccessToCategory($rootCat['categoryid'])) {
                        continue;
                    }
                                                      
                    if(in_array($rootCat['categoryid'],$ValidCats))
                    {
                            
                            $GLOBALS['CategoryCount'] = ""; // making it empty as client told not to show the count on homepage.

                            if($temp_dept != $rootCat['catdeptid']) {
                                if(!empty($temp_dept))
                                    $output .= "</ul>";
                                if(!empty($dept[$rootCat['catdeptid']]))
                                    $GLOBALS['deptname'] = $dept[$rootCat['catdeptid']];
                                else
                                    $GLOBALS['deptname'] = "Others";

                                $GLOBALS['deptid'] = "li_".$rootCat['catdeptid'];

                                $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SitemapDepartment");
                                $output .= "<ul id='".$GLOBALS['deptid']."'>";   
                               // $output .= "<ul><li >".$dept[$rootCat['catdeptid']]."</li></ul><ul>";
                                $temp_dept = $rootCat['catdeptid'];
                            }

                            
                            $GLOBALS['SubCategoryList'] = $this->GetSubCategory($rootCat['categoryid'],$rootCat['catname']);
                            $GLOBALS['LastChildClass']='';
                            $GLOBALS['CategoryName'] = isc_html_escape($rootCat['catname']);
                            
                            ### Common code for creating links SEO friendly and Non-SEO friendly links   
                            $RootCatName = $rootCat['catname'];               
                            $GLOBALS['CategoryLink'] = $this->LeftCatLink($RootCatName);

                            $output .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SideCategoryList");
                    }

                }
                    $output .= "</ul>";                          
                    $GLOBALS['output'] = $output;
                 //$query = "SELECT * FROM [|PREFIX|]brands ORDER BY brandname";
				$query = "SELECT DISTINCT b . * , 
                            (SELECT COUNT( productid ) 
                                FROM [|PREFIX|]products p WHERE p.prodbrandid = b.brandid ) AS   products 
                                FROM [|PREFIX|]brands b 
                                LEFT JOIN isc_products p ON p.prodbrandid = b.brandid
                                ORDER BY b.brandname";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);

                    $brand = '';
                    while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
						if($row['products'] != '0') {
							//$url = htmlspecialchars(BrandLink($row['brandname']), ENT_COMPAT, 'UTF-8');
							$brandid = "brand_".$row['brandid'];
							$brand .= "<ul id='".$row['brandid']."'>";
	//                        $brand .= $row['brandname'];
							$GLOBALS['Brandname'] = isc_html_escape($row['brandname']);
							$GLOBALS['Brandid'] = $row['brandid'];
							$GLOBALS['BrandLink'] = $this->BrandLink($row['brandname']);
							$GLOBALS['Serieslist'] = $this->GetSeries($row['brandid'], $row['brandname']);
							$brand .= $GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("SitemapBrand");
							$brand .= "</ul>";   
						}
                    }
                    $GLOBALS['Brand'] = $brand;
                    
                    
                $CustomPages = '<ul><li><img id="staticDivImg" onclick="hideStaticUrls()" width="19" height="16" src="'.GetConfig('ShopPath').'/admin/images/minus.gif">Static Pages<ul id="staticDiv">';
                
                if(class_exists('DOMDocument')){
				    $xml = new DOMDocument();
				    $xml->load(ISC_BASE_PATH.'/sitemaps/static-pages.xml');
    				$locDom = $xml->getElementsByTagName('loc');
    				foreach($locDom as $loc){
    					$CustomPages .= '<li><a href="'.$loc->nodeValue.'">'.$loc->nodeValue.'</a></li>';
    				}
				}else{//ini_set("display_errors","1");
				    ini_set("memory_limit","-1");
				    require_once(ISC_BASE_PATH .'/class.opxml.php');
				    $xml = new OpXML();
				    $xml->load(ISC_BASE_PATH.'/sitemaps/static-pages.xml');
				    $locDom = $xml->getElementsByTagName('loc');
				    foreach($locDom as $loc){
    					$CustomPages .= '<li><a href="'.$loc->nodeValue.'">'.$loc.'</a></li>';
    				}
				}
				    
                $GLOBALS['CustomPages'] =  $CustomPages.'</ul></li></ul>';
                
                $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("sitemap");
                $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();
           /* }
            else {
                ob_end_clean();
                header(sprintf("Location: %s", $GLOBALS['ShopPath']));   
                die();
            } */
        }
                /**
        * get the category list
        *
        * return array of category list
        */
        function GetValidCategories()  {   

            $aquery   = array();   

            $aquery[] = "CREATE TEMPORARY TABLE temp
                    SELECT DISTINCT ca.categoryid 
                    FROM isc_products p
                    INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid";

            $aquery[] = "CREATE TEMPORARY TABLE cats
                    SELECT DISTINCT c.categoryid, c.catname
                    FROM temp t
                    INNER JOIN isc_categories c ON t.categoryid = c.categoryid
                    WHERE catparentid = 0";

            $aquery[] = "INSERT INTO cats
                    SELECT DISTINCT c.categoryid, c.catname
                    FROM isc_categories sc
                    INNER JOIN temp t ON t.categoryid = sc.categoryid
                    INNER JOIN isc_categories c ON sc.catparentid = c.categoryid";
                    
            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }

            $query = "SELECT DISTINCT * FROM cats ORDER BY 1";
                    
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);        

            $validcats = array();

            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $validcats[] = $row['categoryid'];    
            }

            $aquery   = array();
            $aquery[] = "DROP TABLE cats";
            $aquery[] = "DROP TABLE temp";

            for($i=0; $i<count($aquery); $i++)
            {
                $result = $GLOBALS['ISC_CLASS_DB']->Query($aquery[$i]); 
            }

            return $validcats;
          
        }
        
        /**
        * @desc Create Category links
        * @params Rootcatname
        */
        function LeftCatLink($RootCatName)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($RootCatName)));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($RootCatName));
            }
            return $NewLink;
        }
        
        /**
        * get the html for sub category list
        *
        * @param array $categories the array of all categories in a tree structure
        * @param int $parentCatId the parent category ID of the sub category list
        *
        * return string the html of the sub category list
        */
        function GetSubCategory($parentCatId, $parentCatname)
        {
            $output = '';                                          
            //if there is sub category for this parent cat
            //$query = "SELECT * FROM [|PREFIX|]categories WHERE catparentid = '$parentCatId' AND catvisible = 1";
			$query = "SELECT DISTINCT c.categoryid, ca.categoryid, c.catname FROM [|PREFIX|]categories c INNER JOIN [|PREFIX|]categoryassociations ca ON c.categoryid = ca.categoryid WHERE catparentid = '$parentCatId' ";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $catname = isc_html_escape($row['catname']);
                $catlink = $this->SubCatLink($row['catname'],$parentCatname);
                $output .= "<li><a href=\"$catlink\">$catname</a></li>";
            }
            if ($output!='') {
                $output = '<ul>'.$output.'</ul>';
            }
            return $output;
        }
        
        /** 
        * @desc Create SubCategory links
        * @params Subcatname
        */
        function SubCatLink($SubCatName,$parentCatname)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s/subcategory/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($parentCatname)),MakeURLSafe(strtolower($SubCatName)));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s&subcategory=%s", GetConfig('ShopPath'), MakeURLSafe($parentCatname), MakeURLSafe($SubCatName));
            }
            return $NewLink;
        }
        
        /** 
        * @desc Create Brand links
        * @params Brandname
        */
        function BrandLink($Brandname)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($Brandname)));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s", GetConfig('ShopPath'), MakeURLSafe($Brandname));
            }
            return $NewLink;
        }

        /** 
        * @desc Create Series list
        * @params Brandid
        */
        function GetSeries($brandid, $brandname) {
            $output = '';                                          
            //$query = "SELECT * FROM [|PREFIX|]brand_series WHERE brandid = '$brandid'";
			$query = "SELECT DISTINCT seriesid, seriesname FROM [|PREFIX|]brand_series b INNER JOIN isc_products p ON b.seriesid = p.brandseriesid WHERE brandid = '$brandid'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                $seriesname = isc_html_escape($row['seriesname']);
                $serieslink = $this->SeriesLink($row['seriesname'], $brandname);
                $output .= "<li><a href=\"$serieslink\">$seriesname</a></li>";
            }
            if ($output!='') {
                $output = "<ul>".$output."</ul>";
            }
            return $output;
        }
        
        /** 
        * @desc Create Series links
        * @params Seriesname
        */
        function SeriesLink($Seriesname, $Brandname)
        {
            $NewLink = '';
            if ($GLOBALS['EnableSEOUrls'] == 1) {
                $NewLink = sprintf("%s/%s/series/%s", GetConfig('ShopPath'), MakeURLSafe(strtolower($Brandname)), MakeURLSafe(strtolower($Seriesname)));
            } else {
                $NewLink = sprintf("%s/search.php?search_query=%s&series=%s", GetConfig('ShopPath'), MakeURLSafe($Brandname),MakeURLSafe($Seriesname));
            }
            return $NewLink;
        }
	}

?>