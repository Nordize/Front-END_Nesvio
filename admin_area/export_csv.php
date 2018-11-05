<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 11/5/2018
 * Time: 12:49 AM
 */
include ("admin_includes/dblogin.php");

//Export CSV file
if(isset($_POST["Export"])){

    $query = "SELECT * from products ORDER BY product_id ASC";
    $result = $db_connect->query($query);

    if($result->rowCount()>0)
    {
        $delimeter = ',';
        $filename= "data_".date('Y-m-d').".csv";

        //create a file pointer
        $output = fopen("php://output", "w");

        //set column header
        $fields = array('id','title', 'description', 'google product category', 'product type','link','image link',
            'condition','available','price','sale price','sale price effective date','gtin','brand','mpn','item group id',
            'gender','age group','color','size','shipping','shipping weight','keywords');
        fputcsv($output,$fields,$delimeter);

        while($row = $result->fetch())
        {
            $product_id = $row['product_id'];
            $p_cat_id = $row['p_cat_id'];
            $cat_id = $row['cat_id'];
            $manufacturer_id = $row['manufacturer_id'];
            $product_title = $row['product_title'];
            $product_price = $row['product_price'];
            $product_psp_price = $row['product_psp_price'];
            $product_desc = $row['product_desc'];
            $product_weight = $row['product_weight'];
            $product_keywords = $row['product_keywords'];

            $lineData = array($product_id,$product_title,$product_desc,$cat_id.">".$p_cat_id,$cat_id.">".$p_cat_id,
                'http://127.0.0.1/ecom_store/details.php?pro_id='.$product_id,'Uploaded-image link later','New/Old',
                'In stock/Out of stock',$product_price,$product_psp_price,'Sale effective date',"gtin code",$manufacturer_id,
                'mpn code','Generated item code id','male/female/EE','Adult','add color','add size','add shipping price',
                $product_weight,$product_keywords);
            fputcsv($output,$lineData,$delimeter);
        }

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fclose($output);
    }

}



?>

