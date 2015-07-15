<?php
/*
	class ISC_VALID_CATEGORY
	{

		public $_categoryids = array();  // this variable is used to get the categories array
        public $_newcategoryids = array(); // this variable is used to return the final list of categoruids
		
		function _ProcessCategories($catg_ids)  // this function is used to process categoryids to check whether any product exist or not
		{
			$GLOBALS['ISC_CategoryBrandCache'] = GetClass('ISC_CACHECATEGORYBRANDS');
			$cachedCategoryBrands = $GLOBALS['ISC_CategoryBrandCache']->getCategoryBrandsData();
			$mycategories = $GLOBALS['ISC_CategoryBrandCache']->GetAllCategories($cachedCategoryBrands);
			
             $this->_categoryids = $catg_ids; 
             foreach($this->_categoryids[0] as $rootCat)
             {           
                  $sub_catg_qry = "select group_concat(categoryid separator ',') as categoryid from [|PREFIX|]categories where catparentid = ".$rootCat['categoryid']." and catvisible = 1";
                  $sub_catg_res = $GLOBALS['ISC_CLASS_DB']->Query($sub_catg_qry);
                  $sub_catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($sub_catg_res);
                  if( $GLOBALS['ISC_CLASS_DB']->CountResult($sub_catg_res) == 0 || empty($sub_catg_arr['categoryid']) )
                  $sub_catg_arr['categoryid'] = $rootCat['categoryid'];
                  
                  if($sub_catg_arr['categoryid'] != $rootCat['categoryid'])   // this patch is for adding the parent categorus id in the list of catgories to get the count as parent catgid also has products under it.
                  $sub_catg_arr['categoryid'] .= ",". $rootCat['categoryid'];
                  
                  $count_qry = "select count(ca.productid) as count from [|PREFIX|]categoryassociations ca left join [|PREFIX|]products p on ca.productid = p.productid where p.prodvisible = 1 and categoryid in (".$sub_catg_arr['categoryid'].")";
                  $count_res = $GLOBALS['ISC_CLASS_DB']->Query($count_qry);
                  $count_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($count_res);
             	  $totalproduct = 0;
             	  
             	  if(isset($mycategories[$rootCat['categoryid']]))
             	  {
             	  	 $category = $mycategories[$rootCat['categoryid']];
             	  	 $totalproduct = $category["totalproducts"];
             	  }
             	  else 
             	  {
             	  	 //echo "category no found:".$rootCat['categoryid']."<br/>";
             	  }
             	  
                  
                  //if($count_arr['count'] != 0)   // this patch is added not to display the categories having zero products under it
                  if($totalproduct >0)
                     $this->_newcategoryids[$rootCat['categoryid']] = $count_arr['count'];
             }  
		}
        
        function _GetCategoryids()    // this function is used to return the new categoryids 
        {
            return $this->_newcategoryids;
        }
		
	}
*/
?>
