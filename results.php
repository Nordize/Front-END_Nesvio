<?php

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

<div id="top"><!-- top Starts -->

    <div class="container"><!-- container Starts -->

        <div class="col-md-6 offer"><!-- col-md-6 offer Starts -->

            <a href="#" class="btn btn-success btn-sm" >
                <?php

                if(!isset($_SESSION['customer_username'])){

                    echo "Welcome: Guest";


                }else{

                    echo "Welcome: " . $_SESSION['customer_username'] . "";

                }


                ?>
            </a>

            <a href="#">
                Shopping Cart Total Price: <?php total_price(); ?>, Total Items <?php items_in_cart(); ?>
            </a>

        </div><!-- col-md-6 offer Ends -->

        <div class="col-md-6"><!-- col-md-6 Starts -->
            <ul class="menu"><!-- menu Starts -->

                <li>
                    <a href="customer_register.php">
                        Register
                    </a>
                </li>

                <li>
                    <?php

                    if(!isset($_SESSION['customer_username'])){

                        echo "<a href='checkout.php' >My Account</a>";

                    }
                    else{

                        echo "<a href='customer/my_account.php?my_orders'>My Account</a>";

                    }


                    ?>
                </li>

                <li>
                    <a href="cart.php">
                        Go to Cart
                    </a>
                </li>

                <li>
                    <?php

                    if(!isset($_SESSION['customer_username'])){

                        echo "<a href='checkout.php'> Login </a>";

                    }else {

                        echo "<a href='logout.php'> Logout </a>";

                    }

                    ?>
                </li>

            </ul><!-- menu Ends -->

        </div><!-- col-md-6 Ends -->

    </div><!-- container Ends -->
</div><!-- top Ends -->

<div class="navbar navbar-default" id="navbar"><!-- navbar navbar-default Starts -->
    <div class="container" ><!-- container Starts -->

        <div class="navbar-header"><!-- navbar-header Starts -->

            <a class="navbar-brand home" href="index.php" ><!--- navbar navbar-brand home Starts -->

                <img src="images/EiShops_resize.png" alt="E-commerce Logo" class="hidden-xs" style="margin-top: 5px;">
                <img src="images/EiShops_resize.png" alt="E-commerce Logo" class="visible-xs" style="margin-top: 5px;">

            </a><!--- navbar navbar-brand home Ends -->

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation"  >

                <span class="sr-only" >Toggle Navigation </span>

                <i class="fa fa-align-justify"></i>

            </button>

            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search" >

                <span class="sr-only" >Toggle Search</span>

                <i class="fa fa-search" ></i>

            </button>


        </div><!-- navbar-header Ends -->

        <div class="navbar-collapse collapse" id="navigation" ><!-- navbar-collapse collapse Starts -->

            <div class="padding-nav" ><!-- padding-nav Starts -->

                <ul class="nav navbar-nav navbar-left"><!-- nav navbar-nav navbar-left Starts -->

                    <li>
                        <a href="index.php"> Home </a>
                    </li>

                    <li class="active" >
                        <a href="shop.php"> Shop </a>
                    </li>

                    <li>
                        <?php

                        if(!isset($_SESSION['customer_username'])){

                            echo "<a href='checkout.php' >My Account</a>";

                        }
                        else{

                            echo "<a href='customer/my_account.php?my_orders'>My Account</a>";

                        }


                        ?>
                    </li>

                    <li>
                        <a href="cart.php"> Shopping Cart </a>
                    </li>

                    <li>
                        <a href="contact.php"> Contact Us </a>
                    </li>

                </ul><!-- nav navbar-nav navbar-left Ends -->

            </div><!-- padding-nav Ends -->

            <a class="btn btn-primary navbar-btn right" href="cart.php"><!-- btn btn-primary navbar-btn right Starts -->

                <i class="fa fa-shopping-cart"></i>

                <span> <?php items_in_cart(); ?> items in cart </span>

            </a><!-- btn btn-primary navbar-btn right Ends -->

            <div class="navbar-collapse collapse right"><!-- navbar-collapse collapse right Starts -->

                <button class="btn navbar-btn btn-primary" type="button" data-toggle="collapse" data-target="#search">

                    <span class="sr-only">Toggle Search</span>

                    <i class="fa fa-search"></i>

                </button>

            </div><!-- navbar-collapse collapse right Ends -->

            <!-- search bar start here -->
            <?php include ('includes/searchModule.php');?>
            <!-- search bar end here -->

        </div><!-- navbar-collapse collapse Ends -->

    </div><!-- container Ends -->
</div><!-- navbar navbar-default Ends -->


<div id="content" ><!-- content Starts -->
    <div class="container" ><!-- container Starts -->

        <div class="col-md-12" ><!--- col-md-12 Starts -->

            <ul class="breadcrumb" ><!-- breadcrumb Starts -->

                <li>
                    <a href="index.php">Home</a>
                </li>

                <li>Search Results</li>

            </ul><!-- breadcrumb Ends -->



        </div><!--- col-md-12 Ends -->

        <div class="col-md-12" ><!-- col-md-12 Starts --->

            <div class="row" id="Products" ><!-- row Starts -->

                <?php

                if(isset($_GET['search'])){

                    $user_keyword = $_GET['user_query'];

                    $get_products = "SELECT COUNT(*) FROM products WHERE product_keywords LIKE '%$user_keyword%' OR (product_title LIKE '%$user_keyword%')";

                    $run_products = $db_connect->query($get_products);

                    $count = $run_products->fetchColumn();

                    if($count==0){

                        echo "

                        <div class='box'>
                        
                        <h2>No Search Results Found</h2>
                        
                        </div>
                        
                        ";

                    }else{

                        $get_products = "SELECT * FROM products WHERE product_keywords LIKE '%$user_keyword%' OR (product_title LIKE '%$user_keyword%')";

                        $run_products = $db_connect->query($get_products);


                        while($row_products=$run_products->fetch()){

                            $pro_id = $row_products['product_id'];
                            $pro_title = $row_products['product_title'];
                            $pro_price = $row_products['product_price'];
                            $pro_img1 = $row_products['product_img1'];
                            $pro_label = $row_products['product_label'];
                            $manufacturer_id = $row_products['manufacturer_id'];
                            $pro_psp_price = $row_products['product_psp_price'];
                            $product_label = $row_products['product_label'];

                            $pro_price = sprintf('%.2f',$pro_price);
                            $pro_psp_price = sprintf('%.2f',$pro_psp_price);

                            $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";

                            $run_manufacturer = $db_connect->query($get_manufacturer);

                            if($run_manufacturer->rowCount()>0)
                            {
                                $row_manufacturer = $run_manufacturer->fetch();

                                $manufacturer_name = $row_manufacturer['manufacturer_title'];

                            }

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

                    }

                }
                ?>

            </div><!-- row Ends -->

        </div><!-- col-md-9 Ends --->

    </div><!-- container Ends -->

</div><!-- content Ends -->


<?php

include("includes/footer.php");

?>




</body>

</html>