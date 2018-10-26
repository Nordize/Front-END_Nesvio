<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 8:17 PM
 */
?>


<div id="row same-height-row"><!-- row same-height-row start-->
    <!--<div class="col-md-3 col-sm-6"><!--col-md-3 col-sm-6 -->
       <!-- <div class="box same-height headline"><!--box same-height headline -->
   <!--         <h3 class="text-center">You also like these Products</h3>
        </div>
    </div>-->

    <?php
    $get_products = "SELECT * FROM products ORDER BY RAND() LIMIT 0,3";

    $run_products = $db_connect->query($get_products);

    while($row_products = $run_products->fetch(PDO::FETCH_BOTH))
    {
        $pro_id = $row_products['product_id'];
        $pro_title = $row_products['product_title'];
        $pro_price = $row_products['product_price'];
        $pro_img1 = $row_products['product_img1'];
        $pro_label = $row_products['product_label'];
        $manufacturer_id = $row_products['manufacturer_id'];
        $pro_psp_price = $row_products['product_psp_price'];


        $pro_price = sprintf('%.2f',$pro_price);
        $pro_psp_price = sprintf('%.2f',$pro_psp_price);

        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
        $run_manufacturer = $db_connect->query($get_manufacturer);
        $row_manufacturer = $run_manufacturer->fetch();

        $manufacturer_name = $row_manufacturer['manufacturer_title'];



        //if label is SALE
        if($pro_label == "yes"){

            $product_price = "<del> $$pro_price </del>";

            $product_psp_price = "| $$pro_psp_price";

            $product_label = "
                                    <div class='box_sale'>
                                        <div class='ribbon'><span>Sale</span>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                        </div>
                                    </div>
                                        
                                        ";


        }
        else if($pro_label == "no"){

            $product_psp_price = "";

            $product_price = "$$pro_price";

            $product_label = "
                                    <div class='box_sale'>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                      
                                    </div>
                                        ";

        }



        echo "

                                <div class='col-md-4 col-sm-6 center-responsive' >
                                    <div class='product' >
                                    
                                        $product_label
                                    
                                    <div class='text' >
                                
                                    <center>
                                    
                                        <p class='btn btn-primary'> $manufacturer_name </p>
                                    
                                    </center>
                                
                                     <hr>
                                
                                    <h3><a href='details.php?pro_id=$pro_id' >$pro_title</a></h3>
                                
                                    <p class='price' > $product_price $product_psp_price </p>
                                    
                                    <p class='buttons' >
                                    
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-default' >View details</a>
                                        
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
                                    
                                            <i class='fa fa-shopping-cart'></i> Add to cart                         
                                        </a>
                                     </p>
                                
                                </div>                         
                            </div>
                            
                            </div>
                            
                            ";


    }


    ?>


</div> <!-- row same-height-row end -->


