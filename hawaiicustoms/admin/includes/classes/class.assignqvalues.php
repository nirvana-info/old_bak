<?php

	class ISC_ADMIN_ASSIGNQVALUES 
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
            if(isset($_GET['associd']) && $_GET['associd'] != '')    {
                $AssocId = $_GET['associd'];
                $GLOBALS['AssociationId']   = $AssocId;
                $GLOBALS['DDQValues'] = $this->getQValues();
            }
            
            if(isset($_GET['Todo']) && $_GET['Todo'] == 'saveassigning')  {
                $GLOBALS['DisplayDiv']   = "display:none";         
            }  
            
            $GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("assignqvalues");
            $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(); 
            if(isset($_GET['Todo']) && $_GET['Todo'] == 'saveassigning')  { 
                 echo "<script type=\"text/javascript\"> savedAssoc(".$_POST['associd']."); </script>";
                 die;
            }        
		}
        
        public function getQValues()  
        {
            //
            $associd          = $_REQUEST['associd'];
            $selqualifierid   = '';
            $qualifiername    = ''; 
            
            if($associd!=0 && $associd!=null)    {
                $query = " SELECT qn.column_name  
                            FROM [|PREFIX|]qualifier_names qn
                            INNER JOIN [|PREFIX|]qualifier_associations qa ON qn.qid = qa.qualifierid
                            WHERE qa.associd='".$associd."'"; 
                            
                $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
                     $qualifiername = $row['column_name'];
                }
            }
            
            $query = "SELECT DISTINCT `".$qualifiername."`  
                        FROM [|PREFIX|]import_variations iv
                        WHERE `".$qualifiername."`!=''";

            
            //$query = "SELECT qn.qid, qn.column_name FROM [|PREFIX|]qualifier_names qn WHERE column_name REGEXP '^pq|^vq' AND qn.qid NOT IN (SELECT DISTINCT qa.qualifierid FROM [|PREFIX|]qualifier_associations qa WHERE qa.categoryid='$catid')";

            $e_query = "SELECT DISTINCT qva.qvalue 
                FROM [|PREFIX|]qvalue_associations qva 
                INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid WHERE qva.associd='$associd'";
            $e_result = $GLOBALS['ISC_CLASS_DB']->Query($e_query);
            $exist_qvalues = array();
            while($e_row = $GLOBALS['ISC_CLASS_DB']->Fetch($e_result)) { 
                $exist_qvalues[] = $e_row['qvalue'];
            }
            
            $query = "SELECT DISTINCT `".$qualifiername."`  
                        FROM [|PREFIX|]import_variations iv
                        WHERE `".$qualifiername."`!='' AND `".$qualifiername."` NOT IN 
(SELECT DISTINCT qva.qvalue 
                FROM [|PREFIX|]qvalue_associations qva 
                INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid WHERE qva.associd='$associd')";
            
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);                             
            $array_qvalues = array();
            while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {    
                $qvalues = explode(";", $row[$qualifiername]);
                foreach ($qvalues as $val)  {           
                    $array_qvalues[] = $val;
                }
            }
            
            if($qualifiername=='VQbedsize')    {                  
                $bs_query = "SELECT DISTINCT `bedsize_generalname`  
                            FROM [|PREFIX|]import_variations iv
                            WHERE `bedsize_generalname`!='' AND `bedsize_generalname` NOT IN 
    (SELECT DISTINCT qva.qvalue 
                    FROM [|PREFIX|]qvalue_associations qva 
                    INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                    INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                    INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid WHERE qva.associd='$associd')";
                
                $bs_result = $GLOBALS['ISC_CLASS_DB']->Query($bs_query);                             
                
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($bs_result)) {    
                    $qvalues = explode(";", $row['bedsize_generalname']);
                    foreach ($qvalues as $val)  {           
                        $array_qvalues[] = $val;
                    }
                }     
            }
            
            if($qualifiername=='VQcabsize')    {
                $cs_query = "SELECT DISTINCT `cabsize_generalname`  
                            FROM [|PREFIX|]import_variations iv
                            WHERE `cabsize_generalname`!='' AND `cabsize_generalname` NOT IN 
    (SELECT DISTINCT qva.qvalue 
                    FROM [|PREFIX|]qvalue_associations qva 
                    INNER JOIN [|PREFIX|]categories c ON qva.categoryid = c.categoryid
                    INNER JOIN [|PREFIX|]qualifier_associations qa ON qva.associd = qa.associd
                    INNER JOIN [|PREFIX|]qualifier_names qn ON qn.qid = qa.qualifierid WHERE qva.associd='$associd')";
                
                $cs_result = $GLOBALS['ISC_CLASS_DB']->Query($cs_query);                             
                
                while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($cs_result)) {    
                    $qvalues = explode(";", $row['cabsize_generalname']);
                    foreach ($qvalues as $val)  {           
                        $array_qvalues[] = $val;
                    }
                } 
            }
             
            
            $array_qvalues = array_unique($array_qvalues);
            $array_qvalues = array_diff($array_qvalues, $exist_qvalues);
            
            $QualifierOptions = '<select name="qvalue" id="qvalue" class="Field200">';
            $QualifierOptions .= '<option value="">--Choose a qualifier value--</option>';
            foreach ($array_qvalues as $val)  {           
                $QualifierOptions .= '<option value="'.$val.'">'.$val.'</option>'; 
            }
            //echo count($array_qvalues);
            $QualifierOptions .='</select>';
            return $QualifierOptions;       
        }
        
        function SaveAssociation()
        {
            
            $qvaluename   = $_POST['qvalue'];
            $assocId       = $_POST['associd'];
            
            $query = "SELECT qvalueassocid FROM [|PREFIX|]qvalue_associations WHERE qvalue='$qvaluename' AND associd='$assocId'";
            $result = $GLOBALS['ISC_CLASS_DB']->Query($query);
            if($GLOBALS['ISC_CLASS_DB']->CountResult($result)==0)    {
                   
                //$query = "SELECT categoryid FROM [|PREFIX|]qualifier_associations WHERE associd='$assocId'";
                
                /*
                $newAssoc = array(
                    "qvalue" => $qvaluename,
                    "categoryid" => $catId,
                    "associd" => $assocId
                );
                $GLOBALS['ISC_CLASS_DB']->InsertQuery("qvalue_associations", $newAssoc);
                */  
                    
                $query1 = "INSERT INTO [|PREFIX|]qvalue_associations (`associd`, `qvalue`, `categoryid`) SELECT '$assocId', '$qvaluename', categoryid from [|PREFIX|]qualifier_associations WHERE associd='$assocId'";
                $result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1); 
                    
            }
        }
	}

?>