<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/12/2018
 * Time: 12:51 PM
 */

#include ('../includes/dblogin.php');
require_once '__DIR__/../includes/dblogin.php';

function get_today_deal()
{
    global $db_connect;
    //show first 6 items
    $get_products = "SELECT * FROM products ORDER BY 1 DESC LIMIT 0,6";

    $run_products = $db_connect->query($get_products);

    if ($run_products->rowCount() >0) {
        while($row_products = $run_products->fetch()){
            $pro_id = $row_products['product_id'];
            $pro_title = $row_products['product_title'];
            $pro_price = $row_products['product_price'];
            $pro_img1 = $row_products['product_img1'];

            echo "
            <div class='col-md-4 col-sm-6 single'>
                <div class='product'>
                    <a href='details.php?pro_id=$pro_id'>
                        <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                    </a>
                    
                    <div class='text'>
                        <h3><a href='details.php?pro_id=$pro_id'>$pro_title</a> </h3>
                        <p class='price'>$ $pro_price</p>
                        <p class='buttons'>
                            <a href='details.php?pro_id=$pro_id' class='btn btn-default'>View Details</a>
                        
                        </p>
                    </div>
                
                </div>
            
            </div>
            ";
        }
    }
}

?>

