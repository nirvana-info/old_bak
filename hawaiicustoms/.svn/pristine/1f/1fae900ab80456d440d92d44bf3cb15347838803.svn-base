<?php
//---load local library
define('LOCAL_LIB', SYSTEM_ROOT.'lib'.DIRECTORY_SEPARATOR);
require_once(LOCAL_LIB.'init.php');

/**
 * SynchronizeTruckchamp
 *
 * Truckchamp class of Synchronize
 *
 * @package		Lib
 * @author		Alandy li| ddj88@126.com
 * @copyright	Copyright (c) 2011 - 2018, Truckchamp, Inc.
 * @since		Version 1.0
 * @filesource
 */

class SynchronizeDataTruckchamp extends SynchronizeData
{
    
	public $db = NULL;
	public $saved_product = array();//product that once updated,array(prodid => image_sort)
	//TC related product table.
	//product asssociate table
	private	$table_product = 'products';
	private $table_product_mmy = 'product_mmy';
	private $table_import_variations = 'import_variations';
	private $table_qualifier_associations = 'qualifier_associations';
	private $table_qualifier_names = 'qualifier_names';
	private $table_qualifier_value = 'qualifier_value';
	//vendor table
	private $table_vendors = 'vendors';
	//department table
	private $table_department = 'department';
	//category & categoryassociation table
	private $table_categories = 'categories';
	private $table_categoryassociations = 'categoryassociations';
	//brand & brand_series table.
	private $table_brands = 'brands';
	private $table_brand_series = 'brand_series';
	//log table.
	private $table_sync_log = 'sync_log';
    public function __construct(){
        global $GLOBALS;
        $this->db = & $GLOBALS['ISC_CLASS_DB'];
    }

/**********************************Synchronize Handlers**********************/
    public function sync_product(&$product, &$tmp_update, $option){
    	//$option 0:add   1:replace;
    	
    	if(is_array($product) && !empty($product)){
    		//---Fetch productid (WHERE MATCHED (vendorprefix, sku))
    		
     		foreach($product as $row){
	     		$sql = "SELECT productid FROM [|PREFIX|]$this->table_product
	                WHERE (prodvendorprefix='".$GLOBALS['ISC_CLASS_DB']->Quote($row['prodvendorprefix'])."'
	                AND prodcode='".$GLOBALS['ISC_CLASS_DB']->Quote($row['prodsku'])."')";
	     		$result = $this->db->Query($sql);
	     		$prod_row = $this->db->Fetch($result);
				
	     		
	     		//for update product and related table.
	     		if(isset($prod_row['productid']) && $prod_row['productid'] > 0){
	     			//if user tick 'replace' button,then update this product.
	     			if($option==1){
	     				$this->update_product($prod_row['productid'],$row);
	     			}
	     			
	     		}else{ //for add product
	     			//if user tick 'add' button,then add this product.
	     			if($option == 0){
	     				$this->add_product($row);
	     			}
	     		}
	     		     			     		
     		}
    	}
    }
    
    public function update_product($productid,$product){
    	//update product column.
    	//p.productid,p.prodcode,p.proddesc,p.prodprice,p.prodcostprice,p.prodretailprice,p.prodsaleprice,p.prodcalculatedprice,p.prodbrandid,p.prodvariationid,
    	//p.prodcatids,p.prodvendorid,p.prodvendorprefix,p.prodinvtrack,p.jobberprice,p.mapprice,p.ourcost,p.brandseriesid,p.prodwholesalejobber
    	
    	if($productid>0){
    		//first update variations table.
    		//if this product variation not exist,it will insert new variation record association.
    		$this->update_variation($productid,$product);
    		
    		//update brand and series.
    		$this->update_brand($productid,$product);
    		
    		//update category and subcategory.
    		$this->update_category($productid,$product);
    		

    		//last update product info.
    		//On TC site.  price=retailprice.
    		$update_product=array(
    						'proddesc' => $product['proddesc'],
       						'prodprice' => $product['prodretailprice'],
       						'prodcostprice' => $product['prodcostprice'],
       						'prodretailprice' => $product['prodretailprice'],
       						'prodsaleprice' => $product['prodsaleprice'],
       						'prodcalculatedprice' => $product['prodcalculatedprice'],
       						'prodbrandid' => $product['prodbrandid'],
       						'prodvariationid' => $product['prodvariationid'],
       						'prodcatids' => $product['prodcatids'],
       						'prodvendorid' => $product['prodvendorid'],
       						'prodinvtrack' => $product['prodinvtrack'],
       						'jobberprice' => $product['jobberprice'],
       						'mapprice' => $product['mapprice'],
       						'ourcost' => $product['ourcost'],
       						'brandseriesid' => $product['brandseriesid']
    		);
    		$this->db->UpdateQuery($this->table_product,$update_product,"productid=".$productid);
    		//var_dump($this->db->Error(),"update");exit;
    		
    	}
    }
    
    public function add_product($product){
    	//insert product column.
    	//p.productid,p.prodcode,p.proddesc,p.prodprice,p.prodcostprice,p.prodretailprice,p.prodsaleprice,p.prodcalculatedprice,p.prodbrandid,p.prodvariationid,
    	//p.prodcatids,p.prodvendorid,p.prodvendorprefix,p.prodinvtrack,p.jobberprice,p.mapprice,p.ourcost,p.brandseriesid,p.prodwholesalejobber
    	
    	//insert import_variation info.
    	$this->update_variation($product['productid'],$product);
    	
    	//update brand and series.
    	$this->update_brand($product['productid'],$product);

    	//update category and subcategory.
    	$this->update_category($product['productid'],$product);
    	
    	//last insert into product info.
    	//On TC site.  price=retailprice.
    	$insert_product=array(
		    	     		 'prodname' => $product['prodname'],
		                     'prodtype' => $product['prodtype'],
		                     'prodcode' => $product['prodsku'],
		                     'proddesc' => $product['proddesc'],
		                     'prodprice' => $product['prodretailprice'],
		                     'prodcostprice' => $product['prodcostprice'],
		                     'prodretailprice' => $product['prodretailprice'],
		                     'prodsaleprice' => $product['prodsaleprice'],
		                     'prodcalculatedprice' => $product['prodcalculatedprice'],
		                     'prodbrandid' => $product['prodbrandid'],
		                     'prodvariationid' => $product['prodvariationid'],
		                     'prodcatids' => $product['prodcatids'],
		                     'prodvendorid' => $product['prodvendorid'],
		                     'prodvendorprefix' => $product['prodvendorprefix'],
		                     'prodinvtrack' => $product['prodinvtrack'],
		                     'jobberprice' => $product['jobberprice'],
		                     'mapprice' => $product['mapprice'],
		                     'ourcost' => $product['ourcost'],
		                     'brandseriesid' => $product['brandseriesid']
    	);
    	$productid=$this->db->InsertQuery($this->table_product,$insert_product);
		//var_dump($this->db->Error(),$productid);exit;
	
    }
    
    //variation table.
    public function update_variation($productid,$product){
    	//Init update_pqvq array.
    	$update_pqvq = array();
    	$variation_sql="select productid from [|PREFIX|]$this->table_import_variations where productid=".$productid;
    	$query = $this->db->Query($variation_sql);
    	$result= $this->db->Fetch($query);
    	 
    	if(is_array($result) && count($result) > 0){
    		$update_variation=array(
    								'prodstartyear' => $product['prodstartyear'],
    								'prodendyear' => $product['prodendyear'],
    								'prodmodel' => $product['prodmodel'],
    								'prodsubmodel' => $product['prodsubmodel'],
    								'prodmake' => $product['prodmake']

    		);

    		//update product pq,vq info.
    		foreach($product['pqvq'] as $val){
    			$update_pqvq[$val['column_name']]=$product[$val['column_name']];
    		}
    		
    		$update_variation=array_merge($update_variation, $update_pqvq);
    		
    		$this->db->UpdateQuery($this->table_import_variations,$update_variation,"productid=".$productid);
    		//if failed,write log.
    		if(!is_null($this->db->GetErrorMsg())){
    			$this->write_log($productid,'Variation update',$this->db->GetErrorMsg());
    		}
    		
    		//var_dump($this->db->Error());exit;
    		
    	}else{
    		$insert_variation=array(
    								'productid' => $productid,
    								'prodstartyear' => $product['prodstartyear'],
    								'prodendyear' => $product['prodendyear'],
    								'prodmodel' => $product['prodmodel'],
    								'prodsubmodel' => $product['prodsubmodel'],
    								'prodmake' => $product['prodmake'],
    								'PQcolor' => '',
    								'PQmaterial' => '',
    								'PQstyle' => ''
    								
    								);

    		//update product pq,vq info.
    		foreach($product['pqvq'] as $val){
    			$update_pqvq[$val['column_name']]=$product[$val['column_name']];
    		}

    		if($update_pqvq && !empty($update_pqvq)){
    			$insert_variation=array_merge($insert_variation,$update_pqvq);
    		}

    		$variationid=$this->db->InsertQuery($this->table_import_variations,$insert_variation);
    		//if failed,write log.
    		if(!is_null($this->db->GetErrorMsg())){
    			$this->write_log($productid,'Variation Insert',$this->db->GetErrorMsg());
    		}
    		//var_dump($this->db->Error(),$variationid);exit;
    									
    	}
    }
    
    //Brand table. 
    public function update_brand($productid,$product){
    	//brand & brand_series table.
    	//$table_brands = 'brands';
    	//$table_brand_series = 'brand_series';
    	 
    	$sql="select brandid,brandname from [|PREFIX|]$this->table_brands where brandname='".$GLOBALS['ISC_CLASS_DB']->Quote($product['brandname'])."'";
    	$query = $this->db->Query($sql);
    	$result= $this->db->Fetch($query);
    	
    	if(is_array($result) && count($result) > 0){
    		$brandid=$result['brandid'];
    		$brand_arr = array('brandname' => $product['brandname'],
			              'brandpagetitle'=>'',
				          'vendorid' => $product['bvendorid'],
			              'brandaltkeyword' => $product['brandaltkeyword'],
				          'branddescription' => $product['branddescription'],
			              );
			              //update brand table.
			              $this->db->UpdateQuery($this->table_brands,$brand_arr,"brandid=".$brandid);
			              //if failed,write log.
			              if(!is_null($this->db->GetErrorMsg())){
			              	$this->write_log($productid,'Brand update',$this->db->GetErrorMsg(),'brandid:'.$brandid);
			              }
						  //var_dump($this->db->Error());exit;
			              
						  //update series.
			              $this->update_series($brandid,$product);
    	}else{
    		//need to add new brand.
    		$brand_arr = array('brandname' => $product['brandname'],
			              'brandpagetitle'=>'',
				          'vendorid' => $product['bvendorid'],
			              'brandaltkeyword' => $product['brandaltkeyword'],
				          'branddescription' => $product['branddescription'],
    					  'brandlargefile' => ''
			              );
			              	
			              $brandid=$this->db->InsertQuery($this->table_brands,$brand_arr);
			              //if failed,write log.
			              if(!is_null($this->db->GetErrorMsg())){
			              	$this->write_log($productid,'Brand Insert',$this->db->GetErrorMsg(),'brandid:'.$brandid);
			              }
			              //var_dump($this->db->Error(),$brandid);exit;
			              
			              if($brandid > 0){
			              	//update series.
			              	$this->update_series($brandid,$product);
			              }
			               
    	}
    }
    
    //series table
    public function update_series($brandid,$product){
    	//$table_brand_series = 'brand_series';
    	if(!empty($product['seriesname'])){
    		$sql="select seriesid,brandid,seriesname from [|PREFIX|]$table_brand_series where seriesname='".$GLOBALS['ISC_CLASS_DB']->Quote($product['seriesname'])."'";
    		$query = $this->db->Query($sql);
    		$result= $this->db->Fetch($query);
    		
    		if(is_array($result) && count($result) > 0){
    			//update existe series.
    			$seriesid=$result['seriesid'];
    			$series_arr=array('brandid' => $brandid,
						      'seriesname' => $product['seriesname'],
						      'seriesaltkeyword' => $product['seriesaltkeyword'],
						      'seriesdescription' => $product['seriesdescription']
					          );
	          	$this->db->UpdateQuery($this->table_brand_series,$series_arr,"seriesid=".$seriesid);
	          	//if failed,write log.
	          	if(!is_null($this->db->GetErrorMsg())){
	          		$this->write_log($product['productid'],'Series Update',$this->db->GetErrorMsg(),'brandid:'.$brandid.';Seriesid:'.$seriesid);
	          	}
	          	
    		}else{
    			//insert new series.
    			$series_arr=array('brandid' => $brandid,
						      'seriesname' => $product['seriesname'],
						      'seriesaltkeyword' => $product['seriesaltkeyword'],
						      'seriesdescription' => $product['seriesdescription'],
					          'feature_points' => '',
					          'divdesc' => '',
    			              'serieshoverimagefile' => '',
    			              'serieslogoimage' => '',  			       		
					          'seriesimagealt' => '',
					          'displayname' => ''
					          );
			  //$this->db->insert_string($this->table_brand_series,$series_arr);
	          $seriesid=$this->db->InsertQuery($this->table_brand_series,$series_arr);
	          //if failed,write log.
	          if(!is_null($this->db->GetErrorMsg())){
	          	$this->write_log($product['productid'],'Series Insert',$this->db->GetErrorMsg(),'brandid:'.$brandid.';Seriesid:'.$seriesid);
	          }
	          //var_dump($this->db->Error(),$seriesid);
    		}
    	}
    }
    
   //category table. 
    public function update_category($productid,$product){
    	//$table_categories = 'categories';
    	//$table_categoryassociations = 'categoryassociations';
    	$sql="select c.categoryid,c.catparentid,c.catname from [|PREFIX|]$this->table_categories c
    	               left join [|PREFIX|]$this->table_categoryassociations ca on ca.categoryid=c.categoryid
    	               where ca.productid=".$productid;
    	 
    	$query = $this->db->Query($sql);
    	$result= $this->db->Fetch($query);
    	 
    	//single category process
    	if(is_array($result) && count($result) > 0){ //this category exists;
    		//only need to update categoryassociations table
    		
    		$this->replace_categoryassociations($productid,$result['categoryid']);

    	}else{
    		//This branch has two scene.
    		//1,categoryassociation not exist,but category exist.
    		//2,Both categoryassociation and category not exist.
    		//So,we should select categoryname from category table.
    		//First select parent catgoryname is exists.
    		
    		$parentid=0;
    		$sql = "select categoryid,catparentid,catname from [|PREFIX|]$this->table_categories where catname='".$GLOBALS['ISC_CLASS_DB']->Quote($product['parentcatname'])."' and catparentid=0";
    		$query = $this->db->Query($sql);
    		$parent= $this->db->Fetch($query);
    		if(is_array($parent) && count($parent)>0){
    			$parentid=$parent['categoryid'];
    		}
    		
    			
    		$categoryname_sql = "select categoryid,catparentid,catname from [|PREFIX|]$this->table_categories where catname='".$GLOBALS['ISC_CLASS_DB']->Quote($product['catname'])."'";
    		$query = $this->db->Query($categoryname_sql);
    		$result= $this->db->Fetch($query);
    		
    		if(is_array($result) && count($result) > 0){
    			//1,this categoryname exist,need to update this category info and  replace_categoryassociations.
    			if($parentid>0){
    				$update_subcategory=array('catname' => $product['catname'],
						                'catdesc' => $product['catdesc'],
						                'cataltkeyword' => $product['cataltkeyword'],
						                'catdeptid' => $product['catdeptid']
    				);
    				$this->db->UpdateQuery($this->table_categories,$update_subcategory,"categoryid=".$result['categoryid']);
    				//if failed,write log.
    				if(!is_null($this->db->GetErrorMsg())){
    					$this->write_log($productid,'Subcategory update',$this->db->GetErrorMsg(),'categoryid:'.$result['categoryid']);
    				}
    				//var_dump($this->db->Error());exit;
    				$this->replace_categoryassociations($productid,$result['categoryid']);
    			}
    		}else{
    			//2,Both categoryassociation and category not exist.
    			//we need to add new category.
    			//Import column not null:catname,department,catdesc,catpagetitle,catlayoutfile,catimagefile,controlscript,trackingscript,
    			//catimagealt,cathoverimagefile,featurepoints,divdesc,pagecontenttype,customcontentid

    			if(is_array($parent) && count($parent)>0){//this scene is parent cat exist,but sub category not exist.Need to add new subcategory and replace categoryassociations.
    				//insert subcategory.
    				$insert_subcategory=array('catname' => $product['catname'],
								                'catparentid' => $parent['categoryid'],
								                'catdesc' => $product['catdesc'],
								                'cataltkeyword' => $product['cataltkeyword'],
								                'catdeptid' => $product['catdeptid'],
								                'controlscript' => '',
								                'trackingscript' => '',
								                'catimagealt' => '',
								                'featurepoints' => '',
								                'divdesc' => '',
    	            							'cathoverimagefile' => '',
								                'pagecontenttype' => 0,
								                'customcontentid' => 0
    				);

    				$subcategoryid=$this->db->InsertQuery($this->table_categories,$insert_subcategory);
    				//if failed,write log.
    				if(!is_null($this->db->GetErrorMsg())){
    					$this->write_log($productid,'Subcategory Insert',$this->db->GetErrorMsg(),'categoryid:'.$subcategoryid);
    				}
    				//var_dump($this->db->Error(),$subcategoryid);exit;
    				if($subcategoryid>0){
    					//update categoryassociations.
    					$this->replace_categoryassociations($productid,$subcategoryid);
    				}
    					
    			}else{ //this scene is both parentcategory and subcategory not exist.
    				//first insert parent category.
    				
    				$insert_category=array('catname' => $product['parentcatname'],
								                'catparentid' => 0,
								                'catdesc' => '',
								                'cataltkeyword' => '',
								                'catdeptid' => $product['catdeptid'],
								                'controlscript' => '',
								                'trackingscript' => '',
								                'catimagealt' => '',
								                'featurepoints' => '',
								                'divdesc' => '',
    	            							'cathoverimagefile' => '',
								                'pagecontenttype' => 0,
								                'customcontentid' => 0
    				);

    				$categoryid=$this->db->InsertQuery($this->table_categories,$insert_category);
    				//if failed,write log.
    				if(!is_null($this->db->GetErrorMsg())){
    					$this->write_log($productid,'Category Insert',$this->db->GetErrorMsg(),'categoryid:'.$categoryid);
    				}
    				//var_dump($this->db->Error(),$categoryid);exit;	
    				//Second,Insert subcategory.
    				if($categoryid>0){
    					$insert_subcategory=array('catname' => $product['catname'],
								                'catparentid' => $categoryid,
								                'catdesc' => $product['catdesc'],
								                'cataltkeyword' => $product['cataltkeyword'],
								                'catdeptid' => $product['catdeptid'],
								                'controlscript' => '',
								                'trackingscript' => '',
								                'catimagealt' => '',
								                'featurepoints' => '',
								                'divdesc' => '',
    	            							'cathoverimagefile' => '',
								                'pagecontenttype' => 0,
								                'customcontentid' => 0
    					);

    					$subcategoryid=$this->db->InsertQuery($this->table_categories,$insert_subcategory);
    					//if failed,write log.
    					if(!is_null($this->db->GetErrorMsg())){
    						$this->write_log($productid,'SubCategory Insert',$this->db->GetErrorMsg(),'categoryid:'.$subcategoryid);
    					}
						//var_dump($this->db->Error(),$subcategoryid);exit;
    					//Third,replace categoryassociations.
    					if($subcategoryid>0){
    						//update categoryassociations.
    						$this->replace_categoryassociations($productid,$subcategoryid);
    					}
    				}
    				 
    			}
    				
    		}
    			
    	}
    }

    //variation table.
    public function replace_categoryassociations($productid,$categoryid){
    	//Firstly,delete relate product categoryassociations.
    	$delete_sql="delete from [|PREFIX|]$this->table_categoryassociations where productid=".$productid;
    	$this->db->Query($delete_sql);
    	 
    	//Secondly,Insert new categoryassociations.
    	 $categoryassociations_arr=array(
    	 							'productid' => $productid,
    	 							'categoryid' => $categoryid
    	 							);
    	 $associationid=$this->db->InsertQuery($this->table_categoryassociations,$categoryassociations_arr);
    	 //if failed,write log.
    	 if(!is_null($this->db->GetErrorMsg())){
    	 	$this->write_log($productid,'CategoryAssociation Insert',$this->db->GetErrorMsg(),'categoryid:'.$categoryid.';associationid:'. $associationid);
    	 }
    	 //var_dump($this->db->Error(),$associationid);exit;
    }
    
    public function write_log($productid=0,$logsummary=null,$logmsg=null,$logmodule=null){
    	$log_arr=array(
	                'productid' => $productid,
	    		    'logmodule' => $logmodule,
			    	'logsummary' => $logsummary,
			    	'logmsg' => $logmsg,
			    	'logdate' => time(),
    	);
       $this->db->InsertQuery($this->table_sync_log,$log_arr);
    }
 
}