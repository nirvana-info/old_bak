<?php
    include(dirname(__FILE__) . "/init.php");
    /*
     * To get the prodnumviews from the product table and insert the count in product view count table. This is used to get       * the persons who view a product in a particular day -- Baskaran
     */
    $query = mysql_query("Select productid, prodnumviews from isc_products");
    while($row = mysql_fetch_array($query)) {
        $productid = $row['productid'];
        $prodnumview = $row['prodnumviews'];
        $date = "1265025600"; //"2010-02-01 12:00:00";
        for($i = 1;$i<=$prodnumview;$i++) {
            mysql_query("insert into isc_product_view_count values('','".$productid."','".$date."')");
        }
    }
?>
