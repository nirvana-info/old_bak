<?php
    include(dirname(__FILE__) . "/init.php");  
    
    $count = 0;
    $counttotal = 0;
    $query = "SELECT categoryid, catimagefile FROM isc_categories WHERE catimagefile !=''";
    $result = $GLOBALS['ISC_CLASS_DB']->Query($query);        
    
    while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
        
         $FolderName = GetFolderName($row['categoryid']);
         $FolderName = preg_replace("#[^\w.]#i", "", $FolderName);  
         $FolderName = strtolower($FolderName); 

         if(MoveAndUpdate($row['categoryid'], $row['catimagefile'], $FolderName))
         {
            $count++;
         }      
         $counttotal++;  
    }
    
    echo $count . " out of ".$counttotal." images moved and updated successfully";
    
    function GetFolderName($catid)    
    {
        $query1 = "SELECT pc.catname parentcatname, sc.catname subcatname FROM isc_categories sc
                 LEFT JOIN isc_categories pc ON pc.categoryid = sc.catparentid
                 WHERE sc.categoryid ='$catid'";
        $result1 = $GLOBALS['ISC_CLASS_DB']->Query($query1);        
        while($row1 = $GLOBALS['ISC_CLASS_DB']->Fetch($result1)) {
            if($row1['parentcatname']!='') {
                 return $row1['parentcatname'];
            }
            else    {
                 return $row1['subcatname'];
            }
        }
    }
    
    function MoveAndUpdate($CatId, $ImageFile, $FolderName)    
    {   
        
        $FileName = substr($ImageFile, 2);
        $subDir = "";
        
        // Determine the destination directory
        //$randomDir = strtolower(chr(rand(65, 90)));
        
        $subDir = $FolderName; 
        
        $destPath = realpath(ISC_BASE_PATH.'/' . 'category_images');

        if (!is_dir($destPath . '/' . $subDir)) {
            if (!mkdir($destPath . '/' . $subDir, 0777)) {
                $subDir = '';
            }
        }
        
        $destFile = GenRandFileName($FileName, 'cat');
        $destPath = $destPath . '/' . $subDir . '/' . $destFile;
        $returnPath = $subDir . '/' . $destFile;
        //echo ISC_BASE_PATH.'/' . 'product_images'. '/' .$ImageFile;
        if(file_exists(ISC_BASE_PATH.'/' . 'product_images'. '/' .$ImageFile))    {
            if(copy(ISC_BASE_PATH.'/' . 'product_images'. '/' .$ImageFile, $destPath)){ 
                $query2  = "UPDATE isc_categories SET catimagefile='$returnPath' WHERE categoryid ='$CatId'";
                $result2 = $GLOBALS['ISC_CLASS_DB']->Query($query2);
                return true;
            }
        }               
    }    
?>
