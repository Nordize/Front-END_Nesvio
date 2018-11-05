<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 11/4/2018
 * Time: 4:32 PM
 */
session_start();

include("includes/dblogin.php");

include("functions/functions.php");
?>



<!DOCTYPE html>
<html>

<head>
    <title>E commerce Store </title>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="styles/bootstrap.min.css.map" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="styles/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</head>

<body>

<div id="top"> <!-- top start-->
    <div class="container"> <!-- container start-->
        <div class="col-md-6 offer">
            <a href="#" class="btn btn-success btn-sm">
                <?php
                if(!isset($_SESSION['customer_username']))
                {
                    echo "Welcome: Guest";
                }
                else{
                    echo"Welcome: ".$_SESSION['customer_username']."";
                }
                ?>
            </a>
            <a href="#">Shopping Cart Total Price: <?php total_price();?>, Total Item <?php items_in_cart();?></a>
        </div>
        <div class="col-md-6"> <!--Header start-->
            <ul class="menu">
                <li>
                    <a href="customer_register.php">Register</a>
                </li>
                <li>
                    <a href="./customer/my_account.php">My Account</a>
                </li>
                <li>
                    <a href="cart.php">Go to Cart</a>
                </li>
                <li>

                    <?php
                    if(!isset($_SESSION['customer_username']))
                    {
                        echo "<a href='checkout.php'>Login</a>";

                    }
                    else{
                        echo"<a href='logout.php'>Logout</a>";
                    }
                    ?>

                </li>

            </ul>
        </div>

    </div>
</div>

<div class="navbar navbar-default" id="navbar"> <!--navbar navbar-default start-->
    <div class="container"> <!--container start-->
        <div class="navbar-header"><!-- navbar-header Start-->
            <a class="navbar-brand home" href="index.php"><!--navbar-brand home start-->
                <img src="images/EiShops_resize.png" alt="E-commerce Logo" class="hidden-xs" style="margin-top: 5px;">
                <img src="images/EiShops_resize.png" alt="E-commerce Logo" class="visible-xs" style="margin-top: 5px;">
            </a>
        </div>

        <!-- search bar start here -->
        <?php include ('includes/searchModule.php');?>
        <!-- search bar end here -->

        <a class="btn btn-primary navbar-btn right" style="margin-right: 15px;" href="cart.php"><!--btn btn-primary navbar-btn right start-->
            <i class="fa fa-shopping-cart"></i>
            <span><?php items_in_cart();?> items in cart</span>
        </a>


        <div class="navbar-collapse collapse" id="navigation"> <!--navbar-collapse collapse Starts-->
            <div class="padding-nav"> <!--padding-nav Starts-->
                <ul class="nav navbar-nav navbar-left"><!-- nav navbar-nav navbar-left start-->
                    <li class="active">
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="shop.php">Shop</a>
                    </li>
                    <li>
                        <a href="hot_deal.php">Hot's Deal</a>
                    </li>
                    <li>
                        <a href="./customer/my_account.php">My Account</a>
                    </li>
                    <li>
                        <a href="cart.php">Shopping Cart</a>
                    </li>
                    <li>
                        <a href="#">Sell</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact Us</a>
                    </li>
                </ul>
            </div>

            <!-- <div class="navbar-collapse collapse right"><!--navbar-collapse collapse right start-->
            <!--    <button class="btn navbar-btn btn-primary" type="button" data-toggle="collapse" data-target="#search" style="height: 33px;">
                    <span class="sr-only">Toggle Search</span>
                    <i class="fa fa-search"></i>
                </button>
            </div>-->

        </div>

    </div>
</div>

<!--End of Navigator bar-->


<div id="content" ><!-- content Starts -->
    <div class="container" ><!-- container Starts -->

        <div class="col-md-12" ><!--- col-md-12 Starts -->

            <ul class="breadcrumb" ><!-- breadcrumb Starts -->

                <li>
                    <a href="index.php">Home</a>
                </li>

                <li>Lists</li>

            </ul><!-- breadcrumb Ends -->

        </div><!--- col-md-12 Ends -->

        <!-- show result start here -->

        <?php
        if(isset($_GET['manufacturer']))
        {
            $manufac_id = $_GET['manufac_id'];
            $get_products = "SELECT * FROM products WHERE manufacturer_id = '$manufac_id'";

        }elseif (isset($_GET['categories']))
        {
            echo $_GET['categories'];
            $cat_id = $_GET['cat_id'];
            $get_products = "SELECT * FROM products WHERE cat_id = '$cat_id'";

        }elseif (isset($_GET['product_categories']))
        {
            echo $_GET['product_categories'];
            $p_cat_id = $_GET['p_cat_id'];
            $get_products = "SELECT * FROM products WHERE p_cat_id = '$p_cat_id'";
        }


        $run_products = $db_connect->query($get_products);


        while($row_products=$run_products->fetch()) {

            $pro_id = $row_products['product_id'];
            $pro_title = $row_products['product_title'];
            $pro_price = $row_products['product_price'];
            $pro_img1 = $row_products['product_img1'];
            $pro_label = $row_products['product_label'];
            $manufacturer_id = $row_products['manufacturer_id'];
            $pro_psp_price = $row_products['product_psp_price'];
            $product_label = $row_products['product_label'];

            $pro_price = sprintf('%.2f', $pro_price);
            $pro_psp_price = sprintf('%.2f', $pro_psp_price);

            $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";

            $run_manufacturer = $db_connect->query($get_manufacturer);

            if ($run_manufacturer->rowCount() > 0) {
                $row_manufacturer = $run_manufacturer->fetch();

                $manufacturer_name = $row_manufacturer['manufacturer_title'];

            }

            //if label is SALE
            if ($pro_label == "yes") {

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


            } else if ($pro_label == "no") {

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

                                <div class='col-md-3 col-sm-6 center-responsive' >
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

        <!-- show result start here -->

    </div><!-- container Ends -->

</div><!-- content Ends -->


<?php

include("includes/footer.php");

?>




</body>

</html>