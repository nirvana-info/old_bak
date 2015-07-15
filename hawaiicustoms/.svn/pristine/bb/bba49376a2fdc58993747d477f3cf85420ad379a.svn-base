<?php
ini_set('max_execution_time', '0'); 
$link = mysql_connect('localhost', 'webtc', 'cDReuq3#');
if (!$link) {
    die('Not connected : ' . mysql_error());
}

// make foo the current db
$db_selected = mysql_select_db('tc_store', $link);
if (!$db_selected) {
    die ('Can\'t use tc_store : ' . mysql_error());
}

function MakeURLSafe($val)
	{
		$val = str_replace("-", "%2d", $val);
		$val = str_replace("+", "%2b", $val);
		$val = str_replace("+", "%2b", $val);
		$val = str_replace("/", "{47}", $val);
		$val = urlencode($val);
		$val = str_replace("+", "-", $val);
		return $val;
	}



if ($_POST['b1'])
{

$catname = strtolower(trim($_POST['cat']));
$brand = strtolower(trim($_POST['brand']));
if ($brand == "") $brandquery = "";
else
	{
$brandquery = "LOWER(b.brandname) = '".$brand."'  and ";

$query = "select brandid from isc_brands where  LOWER(brandname) = '".$brand."'  ";
$result = mysql_query($query);
$row = mysql_fetch_array($result) ;
$brandid = $row['brandid'];
	}


$pqvqlist = "";
$data  = "";
$theurltype = "http://www.truckchamp.com/products/";

$query = "select catparentid,categoryid  from isc_categories where LOWER(catname) = '".$catname."'  ";
$result = mysql_query($query);
$row = mysql_fetch_array($result) ;
$categoryid = $row['categoryid'];
$catparentid = $row['catparentid'];

if ($categoryid == "" || $categoryid == 0) 
	{
	echo "<BR>Entered category not found in database";
	
	}
	else
		if ($_POST['brand'] != "" and ($brandid == 0 || $brandid == "") )
	{
	echo "<BR><FONT  COLOR='#FF0000'>Entered Brand not found in database</FONT>";
	
	}
	else
	{
if ($catparentid != 0)
		{
$query = "select catname  from isc_categories where categoryid = '".$catparentid."'  ";
$result = mysql_query($query);
$row = mysql_fetch_array($result) ;
$parentname = $row['catname'];

$subids = $categoryid;

		}
else
		{
$query = " select GROUP_CONCAT( `categoryid` separator ',' ) AS subids   from isc_categories where catparentid = '".$categoryid."' GROUP BY `catparentid` ";	 
$result = mysql_query($query);
$row = mysql_fetch_array($result) ;
$subids = $row['subids'];
$parentname = ucwords($catname);
		}



$header = "";
$field  = array();


$query2 = "select qn.qid,qn.column_name  from isc_qualifier_associations qa join isc_qualifier_names qn  on qn.qid  = qa.qualifierid where categoryid = ".$categoryid." ";
$result2 = mysql_query($query2);
while ($row2 = mysql_fetch_array($result2)) {    
if ($row2['column_name'] != "") 
	{
	$pqvqlist.= "iv.".$row2['column_name'].",";
	$header.= ucfirst($row2['column_name']).",";
	$field[$row2['qid']] = $row2['column_name'];
	}

}


$header	= "Start Year,End Year,Make,Model,Submodel, SKU,Price,Brand , Series , Category , Subcategory , Product URL ,".$header." Bedsize Generalname, Cabsize Generalname \n";
                  

$query = " select p.prodname , iv.prodstartyear,iv.prodendyear,iv.prodmake,iv.prodmodel,iv.prodsubmodel,".$pqvqlist." iv.bedsize_generalname, iv.cabsize_generalname,b.brandname,
iv.prodcode,pf.prodfinalprice,b.brandname , c.catname ,bs.seriesname
from isc_products p 
left join isc_product_finalprice pf on pf.productid = p.productid 
left join isc_brands b on p.prodbrandid = b.brandid
left join isc_brand_series bs on bs.brandid = b.brandid
left join isc_categoryassociations ca on ca.productid = p.productid 
left join isc_categories c on ca.categoryid = c.categoryid 
left join isc_import_variations iv on iv.productid = p.productid 
where  ".$brandquery." c.categoryid IN ($subids)";



$result = mysql_query($query);
while ($row = mysql_fetch_array($result)) {    

$data.= $row['prodstartyear'].",".$row['prodendyear'].",".$row['prodmake'].",".$row['prodmodel'].",".$row['prodsubmodel'].",";


 $data.= $row['prodcode'].",".$row['prodfinalprice'].",".$row['brandname'].",".$row['seriesname'].",".$parentname.",".$row['catname']." , ".$theurltype.MakeURLSafe($row['prodname']).".html, ";


 foreach ($field as $k => $v) {

$query2 = "select displayname  from isc_qualifier_associations  where categoryid = ".$categoryid." and qualifierid =  ".$k ;
$result2 = mysql_query($query2);
$row2 = mysql_fetch_array($result2);   
$displayname = $row2['displayname'];
if ($displayname == "" and $catparentid != 0)
	 {
	$query2 = "select displayname  from isc_qualifier_associations  where categoryid = ".$catparentid." and qualifierid =  ".$k ;
	$result2 = mysql_query($query2);
	$row2 = mysql_fetch_array($result2);   
	$displayname = $row2['displayname'];
	 }
		if ($displayname == "" ) 	 
			$displayname = substr($row[$v],0,2).strtolower(substr($row[$v],2));
			
	 $data.= $displayname.",";

}

$data.= $row['bedsize_generalname'].",".$row['cabsize_generalname']."  \n";
}


$content = $header.$data;

$filename = $brand."_".$catname.'.csv';
$filename = str_replace(" ", "_", $filename);


	 if (!$handle = fopen($filename, 'w')) {
         
	}
    if (fwrite($handle, $content) === FALSE) {
          
    }
    fclose($handle);		

						$fsize = filesize($filename); 
						$fileContents = file_get_contents($filename);
						header("Content-length:".$fsize);
						header("Content-type: text/csv");
						header("Content-Disposition: attachment; filename=".$filename);
						echo $fileContents;
						if (file_exists($filename)) {
										@unlink($filename);
										clearstatcache();
									}

die();

	}


}
?>


<HTML>
<HEAD>
<TITLE> CSV genrating file </TITLE>

</HEAD>

<BODY>
<FORM METHOD=POST ACTION="">
<TABLE>
<TR>
	<TD></TD>
	<TD></TD>
</TR>
<TR>


	<TD>Enter the Category name <FONT  COLOR="#FF0000">*</FONT></TD>
	<TD><INPUT TYPE="text" NAME="cat" value = "<?php echo $catname; ?>"></TD>
</TR>
<TR>
	<TD>Enter the brand name (Optional)</TD>
	<TD><INPUT TYPE="text" NAME="brand" value = "<?php echo $brand; ?>" > </TD>
</TR>
<TR>
	<TD></TD>
	<TD><INPUT TYPE="submit" value = "Submit" name = "b1"></TD>
</TR>
</TABLE>
</FORM>


</BODY>
</HTML>
