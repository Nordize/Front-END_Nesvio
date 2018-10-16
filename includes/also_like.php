<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 8:17 PM
 */
?>


<div id="row same-height-row"><!-- row same-height-row start-->
    <div class="col-md-3 col-sm-6"><!--col-md-3 col-sm-6 -->
        <div class="box same-height headline"><!--box same-height headline -->
            <h3 class="text-center">You also like these Products</h3>
        </div>
    </div>

    <?php
    $get_products = "SELECT * FROM products ORDER BY RAND() LIMIT 0,3";

    $run_products = $db_connect->query($get_products);

    while($row_products = $run_products->fetch(PDO::FETCH_BOTH))
    {
        $pro_id = $row_products['product_id'];
        $pro_title = $row_products['product_title'];
        $pro_price = $row_products['product_price'];
        $pro_img1 = $row_products['product_img1'];

        $pro_price = sprintf('%.2f',$pro_price);

        echo "
        <div class='center-responsive col-md-3 col-sm-6'>
            <div class='product same-height'>
                <a href='details.php?pro_id=$pro_id'>
                <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                </a>
                <div class='text'>
                    <h3><a href='details.php?pro_id=$pro_id'>$pro_title</a></h3>
                    
                    <p class='price'>$$pro_price</p>
                
                </div>
            </div>
        </div>
        ";


    }


    ?>


</div> <!-- row same-height-row end -->


