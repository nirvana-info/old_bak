<?php
        
	class ISC_CATGBRANDINFO
	{

		public $catgbrand = 0;
		public $catgbranddetails = "";

		function __construct()
		{

			if(isset($_GET['categoryid']))
			{
				$this->catgbrand = $_GET['categoryid'];
				$this->GetCategoryInfo();
			} 
			else if(isset($_GET['seriesid']))
			{
				$this->catgbrand = $_GET['seriesid'];
				$this->GetSeriesInfo();
			}

		}

		function GetCategoryInfo()
		{
			$catgqry			=	"select catname, cathoverimagefile, divdesc, min(prodfinalprice) as prodminprice, max(prodfinalprice) as prodmaxprice
										from [|PREFIX|]categories c left join [|PREFIX|]product_finalprice p on c.categoryid = p.prodcatid
										where c.categoryid = ".$this->catgbrand." group by categoryid ";
			$catgres			=	$GLOBALS['ISC_CLASS_DB']->Query($catgqry);
			$catgarr			=	$GLOBALS['ISC_CLASS_DB']->Fetch($catgres);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($catgres) > 0)
			{
				$GLOBALS['PATH']	=	GetConfig('ShopPath');
				$GLOBALS['LINKPATH']	=	isset($_GET['url']) ? $_GET['url'] : '';

				if($GLOBALS['LINKPATH'] == '')
				{
					$GLOBALS['LINKPATH'] = "#' onclick='self.parent.tb_remove();return checkcategoryselection();";
				}

				$GLOBALS['Header']	=	"<h3>Subcategory Description</h3>";

				if($catgarr['cathoverimagefile'] != "")
				{
					$GLOBALS['LeftImage']	=	"<a href='".$GLOBALS['LINKPATH']."'><img src='".$GLOBALS['PATH']."/category_images/".$catgarr['cathoverimagefile']."' alt='".$catgarr['cathoverimagefile']."' width='240'></a>";
				}
				$GLOBALS['TitleLink']	=	"<h2><a href='".$GLOBALS['LINKPATH']."' class='catgname'>".$catgarr['catname']."</a></h2>";
				$GLOBALS['Info']		=	$catgarr['divdesc'];

				if(number_format($catgarr['prodminprice'], 2) < number_format($catgarr['prodmaxprice'], 2))     
				{
					$GLOBALS['PriceRange'] = "Price range from $".number_format($catgarr['prodminprice'], 2, '.', '')." to $".number_format($catgarr['prodmaxprice'], 2, '.', '');
				}
				else    {
					$GLOBALS['PriceRange'] = "Available at $".number_format($catgarr['prodminprice'], 2, '.', '');    
				}
				
			}
			else
			{
				$GLOBALS['Info']		=	"Sorry, There is no information available.";
			}

			$this->catgbranddetails	=	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CatgSeriesInfo");

		}

		function GetSeriesInfo()
		{
			$catgqry			=	"select b.brandname, displayname, seriesname, divdesc, min(prodfinalprice) as prodminprice, max(prodfinalprice) as prodmaxprice, 						serieshoverimagefile from [|PREFIX|]brand_series s left join [|PREFIX|]product_finalprice p on s.seriesid = 
									p.prodseriesid LEFT JOIN [|PREFIX|]brands b ON s.brandid = b.brandid where seriesid = ".$this->catgbrand." group by seriesid ";
			$catgres			=	$GLOBALS['ISC_CLASS_DB']->Query($catgqry);
			$catgarr			=	$GLOBALS['ISC_CLASS_DB']->Fetch($catgres);

			if($GLOBALS['ISC_CLASS_DB']->CountResult($catgres) > 0)
			{
				$GLOBALS['PATH']	=	GetConfig('ShopPath');
				$GLOBALS['LINKPATH']	=	isset($_GET['url']) ? $_GET['url'] : '';

				if($GLOBALS['LINKPATH'] == '' || $GLOBALS['LINKPATH'] == '#') // added "#" condition as this spl characters is sent in IE8
				{
					$GLOBALS['LINKPATH'] = "#' onclick='self.parent.tb_remove();return checkcategoryselection();";
				}

				$GLOBALS['Header']	=	"<h3>Series Description</h3>";

				if($catgarr['serieshoverimagefile'] != "")
				{
					$GLOBALS['LeftImage']	=	"<a href='".$GLOBALS['LINKPATH']."'><img src='".$GLOBALS['PATH']."/series_images/".$catgarr['serieshoverimagefile']."' alt='".$catgarr['serieshoverimagefile']."' width='240'></a>";
				}
				$GLOBALS['TitleLink']	=	"<h2><a href='".$GLOBALS['LINKPATH']."' class='catgname'>".($catgarr['displayname']==''?$catgarr['brandname'].' '.$catgarr['seriesname'].' '.$_GET['catname']:$catgarr['displayname'])." </a></h2>";
				$GLOBALS['Info']		=	$catgarr['divdesc'];
				
				if(number_format($catgarr['prodminprice'], 2) < number_format($catgarr['prodmaxprice'], 2))     
				{
					$GLOBALS['PriceRange'] = "Price range from $".number_format($catgarr['prodminprice'], 2, '.', '')." to $".number_format($catgarr['prodmaxprice'], 2, '.', '');
				}
				else    {
					$GLOBALS['PriceRange'] = "Available at $".number_format($catgarr['prodminprice'], 2, '.', '');    
				}
			}
			else
			{
				$GLOBALS['Info']		=	"Sorry, There is no information available.";
				//alandy_2012-3-15 modify.
				$GLOBALS['LINKPATH']	=	isset($_GET['url']) ? $_GET['url'] : '';
			}

			$this->catgbranddetails	=	$GLOBALS['ISC_CLASS_TEMPLATE']->GetSnippet("CatgSeriesInfo");
		}

		function GetInfo()
		{
			return $this->catgbranddetails;
		}

		
	}

?>