<?php
class ISC_CACHECATEGORYBRANDS{
	private $data;
	private $iscached;
	private $cache_file;
	private $validCategoryIds;
	private $categories;
	private $subcategory;
	private $brands;
	/***
	 * store the ralation of category and brand;
	 */
	private $categorybrands;
	/***
	 * if $enableSubcategory is set true,then select out sub category.else just root category.
	 */
	private $enableSubcategory = true;
	/***
	 * if $enableSeries is set true,then select out series.else just brands.
	 */
	private $enableSeries = false;

	public function __construct(){
		$this->cache_file = ISC_BASE_PATH . '/cache/categoriesbands.cache.data';

		if(file_exists($this->cache_file)){
			$data_cached = file_get_contents($this->cache_file);
			$this->data = unserialize($data_cached);
			$this->iscached = TRUE;
		}else{
			$this->data = "";
			$this->iscached = FALSE;
		}
	}

	private function getCategoryBrandFromDB(){

		$result = array();
		$this->GetValidCategoryIds($validCategoryIds);
		$this->GetAvaliableBrandAndSeries($brands);
		$this->GetCategoryBrandRelations($categorybrands);
		//$this->GetAllCategoryRawData($categories,$validCategoryIds);
		$cat_depts= $this->GetCategoryDepts();
		$indexbrands = $this->GetBrandOnIndexPage();
		$result["validcategory"] =$validCategoryIds;
		//$result["categories"] =$categories;
		//$result["subcategories"] =$subcategory;
		$result["brands"] =$brands;
		$result["categorybrands"]=$categorybrands;
		$result["cat_depts"] = $cat_depts;
		$result["indexbrands"] = $indexbrands;
		$result["brand_forsearch"] = $this->GetBrandInfoForSearch();
		$result["category_forsearch"] = $this->GetCategoryInfoForSearch();
		$result["type_forsearch"] = $this->GetTypeInfoForSearch();
		return $result;

	}

	public function setCategoryBrandData(){
		$data = $this->getCategoryBrandFromDB();
		$this->data = $data;
		file_put_contents($this->cache_file, serialize($data));
		$this->iscached = TRUE;
	}
	
	public function ClearCategoryBrandData(){
		try {
			if(file_exists($this->cache_file)){
			   unlink($this->cache_file);
			  }
		}
		catch (Exception $e)
		{
			
		}
		$this->iscached = FALSE;
	}
	

	public function getCategoryBrandsData(){
		if(!($this->iscached) || !file_exists($this->cache_file)){
			$this->setCategoryBrandData();
			$GLOBALS['ISC_CLASS_LOG']->LogSystemSuccess(array('general', 'category_brands font_end'),'category brands cache file not found, has been created.','category brands cache file not found, has been created.');
		}
		
		if(!isset($this->data["brand_forsearch"]) || !isset($this->data["category_forsearch"]) || !isset($this->data["type_forsearch"]))
		{
			$this->ClearCategoryBrandData();
			return $this->getCategoryBrandsData();
		}
		
		return $this->data;
	}
	
	public function GetValidCategoryIds(&$ids)
	{
		$ids = array();
		$query = "SELECT DISTINCT c.categoryid, c.catname
                    FROM (SELECT DISTINCT ca.categoryid 
                    FROM isc_products p
                    INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid
                    WHERE prodvisible='1') t
                    INNER JOIN isc_categories c ON t.categoryid = c.categoryid
                    WHERE c.catvisible = 1 AND catparentid = 0

			union
					SELECT DISTINCT c.categoryid, c.catname
                    FROM isc_categories sc
                    INNER JOIN (SELECT DISTINCT ca.categoryid 
                    FROM isc_products p
                    INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid
                    WHERE prodvisible='1'
					) t ON t.categoryid = sc.categoryid
                    INNER JOIN isc_categories c ON sc.catparentid = c.categoryid
                    WHERE c.catvisible = 1";
		
		$cat_res = $GLOBALS['ISC_CLASS_DB']->Query($query);
		echo $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
		
		while($cat_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_res)) {
			$ids[] = $cat_row['categoryid'];   
		}
	}
	
	/***
	 * get the root category(include department and root category);
	 * 
	 */
	private function  GetAllCategoryRawData(&$rootcategory=array(),$validCategoryIds=array())//,&$subcategory= array())
	{
		$rootcategory = array();
		//return;
		//$subcategory = array();
		$cat_dept_qry = "select c.categoryid ,c.catname,c.catparentid,c.catparentlist,c.catsort, c.catdeptid , deptname from [|PREFIX|]categories c left join [|PREFIX|]department d on d.deptid = c.catdeptid ";
		//$cat_dept_qry .= " inner join (SELECT DISTINCT ca.categoryid FROM isc_products p  INNER JOIN isc_categoryassociations ca ON p.productid = ca.productid WHERE prodvisible='1') ca on ca.categoryid= c.categoryid ";
		//$cat_dept_qry .= " INNER JOIN isc_categories ct ON ct.catparentid = c.categoryid ";
		$cat_dept_qry.= "  where ";
		/*if(!$this->enableSubcategory)
		{
			$cat_dept_qry.= " c.catparentid = 0 and ";
		}*/
		$cat_dept_qry.=" c.catvisible = 1 order by deptname asc, c.catdeptid desc, c.catname";
		
		$cat_dept_res = $GLOBALS['ISC_CLASS_DB']->Query($cat_dept_qry);
		echo $GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
		
		while($cat_dept_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_dept_res)) {
			$totalproducts = 0;
			//if($cat_dept_row["catparentid"] == 0 || in_array($cat_dept_row["categoryid"], $validCategoryIds))
			//{
			//	$totalproducts =  $this->GetCategoryProductCount($cat_dept_row["categoryid"]);
			//}
			
			//$cat_department[$cat_dept_row['categoryid']]['catdeptid'] = $cat_dept_row['deptname'];
			//$rootcategory[$cat_dept_row['catdeptid']][0] = $cat_dept_row['deptname'] ;
			//echo $cat_dept_row["catparentid"]."<br/>";
			//if($cat_dept_row["catparentid"] == 0 )
			//{
				//echo $cat_dept_row["categoryid"]."<br/>";
				
				$rootcategory[$cat_dept_row["categoryid"]] = array(
					'categoryid' => $cat_dept_row["categoryid"],
					'catname' => $cat_dept_row["catname"],
					'catparentid' => $cat_dept_row["catparentid"],
					'catparentlist'=> $cat_dept_row["catparentlist"],
					'catsort' => $cat_dept_row['catsort'],
					'catdeptid'=> $cat_dept_row['catdeptid'],
					'deptname' => $cat_dept_row['deptname'],
					'totalproducts' => $totalproducts // no need now
				);
				
			//}
			/*else
			{
				
				if($this->enableSubcategory)
				{
					
					$subcategory[$cat_dept_row["catparentid"]][$cat_dept_row["categoryid"]] = array(
					'categoryid' => $cat_dept_row["categoryid"],
					'catname' => $cat_dept_row["catname"],
					'catparentid' => $cat_dept_row["catparentid"],
					'catparentlist'=> $cat_dept_row["catparentlist"],
					'catsort' => $cat_dept_row['catsort'],
					'catdeptid'=> $cat_dept_row['catdeptid']
					);
				}
			}*/
		}
	}
	/***
	 * get avaliable brand and series;
	 * but now we just get the brand data;
	 */
	private function GetAvaliableBrandAndSeries(&$brands=array(),&$series= array())
	{
		$brands = array();
		$series= array();
		$query = "select b.brandid, b.brandname, (select count(productid) from [|PREFIX|]products p where p.prodbrandid=b.brandid and p.prodvisible='1') as num from [|PREFIX|]brands b order by b.brandname asc";

		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$brands[$row['brandid']] = array(
				'brandid' => $row['brandid'],
				'brandname' => $row['brandname'],
				'num' => $row["num"]
			);
		}

		//series
		//not coding now
	}
	/***
	 * get brands on index page
	 */
	private function GetBrandOnIndexPage()
	{
		$brands = array();
		$query = "SELECT brandid, brandname, COUNT(*) AS num
			FROM [|PREFIX|]brands b, [|PREFIX|]products p
			WHERE p.prodbrandid = b.brandid
			AND prodvisible=1
			GROUP BY prodbrandid
			ORDER BY brandname ASC";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);

		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$brands[$row['brandid']] = array(
				'brandid' => $row['brandid'],
				'brandname' => $row['brandname'],
				'num' => $row["num"]
			);
		}
		return $brands;
		
	}
	/***
	 * store the relation of the category and brand;
	 */
	private function GetCategoryBrandRelations(&$relations = array())
	{
		$relations = array();
		$query = " select distinct brandid , brandname,prodcatids from  [|PREFIX|]brands b inner join  [|PREFIX|]products p on b.brandid = p.prodbrandid order by brandname asc ";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$GLOBALS['ISC_CLASS_DB']->GetErrorMsg();
		while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			
			$catids = $row['prodcatids'];
			$catidsArr = explode(',',$catids);
			foreach ($catidsArr as $catid)
			{
				$catid = trim($catid);
				if(!isId($catid))
				{
					continue;
				}
				if(!isset($relations[$catid]))
				{
					$relations[$catid] = array();
				}
				
				$relations[$catid][] = array(
				'brandid' => $row['brandid'],
				'brandname' => $row['brandname'],
				'catid' => $catid
				);
			}
		}
	}

	private function GetCategoryDepts()
	{
		$depts = array();
		$cat_dept_qry = "select categoryid , catdeptid , deptname from isc_categories c left join isc_department d on d.deptid = c.catdeptid where catparentid = 0 and catvisible = 1 order by deptname asc, catdeptid desc, catname";
         $cat_dept_res = $GLOBALS['ISC_CLASS_DB']->Query($cat_dept_qry);
        while($cat_dept_row = $GLOBALS['ISC_CLASS_DB']->Fetch($cat_dept_res)) {
        	  $depts[] =   $cat_dept_row;	
        }
        return $depts;
	}
	/***
	 * get the brands from the cached data;
	 * @param $data : the cached data
	 * return brand array;
	 */
	public function GetBrands($data)
	{
		if(isset($data) && isset($data["brands"]))
		{
			return $data["brands"];
		}
		
		return array();
	}
	
	public function GetBrandsIndexpage($data)
	{
		if(isset($data) && isset($data["indexbrands"]))
		{
			return $data["indexbrands"];
		}
		
		return array();
	}
	
	/***
	 * get the root category from the cached data;
	 * @param $data : the cached data
	 * return root category array;
	 */
	public function GetValidCategories($data)
	{
		if(isset($data) && isset($data["validcategory"]))
		{
			return $data["validcategory"];
		}
		
		return array();
	}
	
	/*/***
	 * get the all category from the cached data;
	 * @param $data : the cached data
	 * return subcategory array;
	 */
	public function GetAllCategories($data)
	{
		if(isset($data) && isset($data["categories"]))
		{
			return $data["categories"];
		}
		
		return array();
	}
	
	/***
	 * get the the relation of category and brands from the cached data;
	 * @param $data : the cached data
	 * return relation array;
	 */
	public function GetCategoryBrands($data)
	{
		if(isset($data) && isset($data["categorybrands"]))
		{
			return $data["categorybrands"];
		}
		
		return array();
	}
	
	public function GetCatDepts($data)
	{
		if(isset($data) && isset($data["cat_depts"]))
		{
			return $data["cat_depts"];
		}
		
		return array();
	}
	/***
	 * get the product count from a category and it subcategory
	 */
	private function GetCategoryProductCount($categoryid)
	{
		$query =  "select count(ca.productid) as count,categoryid 
						from isc_categoryassociations ca left join isc_products p on ca.productid = p.productid
						where p.prodvisible = 1 and categoryid in 
							(select categoryid   from isc_categories 
								where (catparentid = ".$categoryid." or categoryid=".$categoryid.") and catvisible = 1)	";
		  $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
        if($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
        	return $row["count"];	
        }
        return 0;
								
	}
	
	//get brand data for search page.
	private function GetBrandInfoForSearch()
	{
		$arr = array();
		$brand_qry = "select brandid, brandname, brandaltkeyword from [|PREFIX|]brands order by CHAR_LENGTH(brandname) desc";
		$brand_res =  $GLOBALS['ISC_CLASS_DB']->Query($brand_qry);
		while($brand_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($brand_res))
		{
			$arr[] = $brand_arr;
		}
		return $arr;
	}
	
	public function GetBrandsForSearch($data)
	{
		if(isset($data) && isset($data["brand_forsearch"]))
		{
			return $data["brand_forsearch"];
		}
		
		return array();
	}
	
	//get category data for search page.
	private function GetCategoryInfoForSearch()
	{
		$arr = array();
		$catg_qry = "select * from [|PREFIX|]categories order by catparentid ASC , CHAR_LENGTH(catname) DESC";
		$catg_res =  $GLOBALS['ISC_CLASS_DB']->Query($catg_qry);

		while($catg_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($catg_res))
		{
			$arr[] = $catg_arr;
		}
		return $arr;
	}
	
	public function GetCategoryForSearch($data)
	{
		if(isset($data) && isset($data["category_forsearch"]))
		{
			return $data["category_forsearch"];
		}
		
		return array();
	}
	
	private function GetTypeInfoForSearch()
	{
		$arr = array();
		$common_qry =	 "select brandname as typename, 'brand' as type, brandid as 'id' from [|PREFIX|]brands
						UNION ALL
						( select catname as typename, 'category' as type, categoryid as 'id' from [|PREFIX|]categories c order by catparentid )
						order by CHAR_LENGTH(typename) DESC , typename asc ";
		$common_res	=	$GLOBALS['ISC_CLASS_DB']->Query($common_qry);
		
		while($common_arr = $GLOBALS['ISC_CLASS_DB']->Fetch($common_res))
		{
			$arr[] = $common_arr;
		}
		return $arr;
	}
	
	public function GetTypeForSearch($data)
	{
		if(isset($data) && isset($data["type_forsearch"]))
		{
			return $data["type_forsearch"];
		}
		
		return array();
	}
}
?>