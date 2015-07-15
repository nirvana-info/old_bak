<?php

	class ISC_ADMIN_ASSIGNQUALIFIERS 
	{
		var $_catid = 0;  

		function __construct()
		{
			//
            if(isset($_GET['Todo']) && $_GET['Todo'] == 'saveassigning')  {
                 $this->SaveAssociation();
            }
		}
       
		function HandlePage()
		{
			//
            if(isset($_GET['catid']) && $_GET['catid'] != '')    {
                $CatId = $_GET['catid'];
                $GLOBALS['CategoryId']   = $CatId;
                $GLOBALS['DDQualifiers'] = $this->getQualifiers();
            }
            
            if(isset($_GET['Todo']) && $_GET['Todo'] == 'saveassigning')  {
                $GLOBALS['DisplayDiv']   = "display:none";         
            }  
            
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("assignqualifiers");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(); 
            if(isset($_GET['Todo']) && $_GET['Todo'] == 'saveassigning')  { 
                 echo "<script type=\"text/javascript\"> savedAssoc(".$_POST['categoryid']."); </script>";
                 die;
            }        
		}
        
        public function getQualifiers()  
        {
            //
            $catid          = $_REQUEST['catid'];
            $selqualifierid = '';
            
            $uQuery = "SELECT catuniversal FROM [|PREFIX|]categories WHERE categoryid='".$catid."'";
            $uResult = $GLOBALS['ISC_CLASS_DB']->Query($uQuery);
            $isUniversal = $GLOBALS['ISC_CLASS_DB']->FetchOne($uResult);
            if($isUniversal)    {
                $Restriction = '^pq';
            }
            else    {
                $Restriction = '^pq|^vq'; 
            }
            
            $query = "SELECT qn.qid, qn.column_name FROM [|PREFIX|]qualifier_names qn WHERE column_name REGEXP '".$Restriction."' AND qn.qid NOT IN 
(SELECT DISTINCT qa.qualifierid FROM [|PREFIX|]qualifier_associations qa WHERE qa.categoryid='$catid')";
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            $QualifierOptions = '<select name="qualifier" id="qualifier" class="Field200">';
            $QualifierOptions .= '<option value="">--Choose a qualifier--</option>';
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {               
                $QualifierOptions .= '<option value="'.$row['qid'].'">'.$row['column_name'].'</option>'; 
            }
            
            $QualifierOptions .='</select>';
            return $QualifierOptions;       
        }
        
        function SaveAssociation()
        {
            
            $qualifierId = $_POST['qualifier'];
            $catId       = $_POST['categoryid'];
            
            $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$qualifierId' AND categoryid='$catId'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                   $newAssoc = array(
                        "qualifierid" => $qualifierId,
                        "categoryid" => $catId
                    );                            
                    $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);
                    //Add to subcategories
                    $query = "SELECT categoryid FROM [|PREFIX|]categories WHERE catparentid='$catId' ORDER BY catsort ASC, catname ASC";
                    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                        //
                        $this->AddSubcatAssociations($row['categoryid']);
                    } 
            }
        }
        
        
        private function AddSubcatAssociations($catId)  {     
                
            $c_query = "SELECT count(associd) as total FROM [|PREFIX|]qualifier_associations WHERE categoryid='".$catId."'";
            $c_result = $GLOBALS['ISC_CLASS_DB']->Query($c_query);
            $row = $GLOBALS['ISC_CLASS_DB']->Fetch($c_result); 
            
            if($row['total'] == 0)    {
                $qualifier = $_POST['qualifier'];
                
                $query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE qualifierid='$qualifier' AND categoryid='$catId'";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                
                if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                       $newAssoc = array(
                        "qualifierid" => $qualifier,
                        "categoryid" => $catId
                        );
                        $GLOBALS['ISC_CLASS_DB']->InsertQuery("qualifier_associations", $newAssoc);  
                }

                //Add to subcategories
                $query = "SELECT categoryid FROM [|PREFIX|]categories WHERE catparentid='$catId' ORDER BY catsort ASC, catname ASC";
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                    //
                    $this->AddSubcatAssociations($row['categoryid']);
                }     
            }
        }
       
        
	}

?>