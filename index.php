<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/28/2018
 * Time: 3:50 PM
 */

session_start();

include ('includes/dblogin.php');
include ('functions/functions.php');
?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>E-Commerce Store</title>
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

    <div class="container" id="slider"><!-- containner slider start-->
        <div class="col-md-12"><!--col-md-12-->
            <div id="myCarousel" class="carousel slide" data-ride="carousel"><!--carousel slide start-->
                <ol class="carousel-indicators"><!--carousel-indicators-->
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1" ></li>
                    <li data-target="#myCarousel" data-slide-to="2" ></li>
                    <li data-target="#myCarousel" data-slide-to="3" ></li>
                </ol>
                <div class="carousel-inner"><!--carousel-inner start-->
                    <!--insert php for slider here -->
                    <?php
                    $get_sliders = "SELECT * FROM slider LIMIT 0,1";
                    $run_slides = $db_connect->query($get_sliders);

                    if ($run_slides->rowCount() >0) {
                        while($row_slides = $run_slides->fetch()){
                            $slide_name = $row_slides['slide_name'];
                            $slide_image = $row_slides['slide_image'];

                            echo "
                            
                            <div class='item active'>
                            <img src='admin_area/slide_images/$slide_image'>
                            </div>
                            ";

                        }
                    }

                    ?>
                    <?php
                    $get_sliders = "SELECT * FROM slider LIMIT 1,3";
                    $run_slides = $db_connect->query($get_sliders);

                    if ($run_slides->rowCount() >0) {
                        while($row_slides = $run_slides->fetch()){
                            $slide_name = $row_slides['slide_name'];
                            $slide_image = $row_slides['slide_image'];

                            echo "
                            
                            <div class='item'>
                            <img src='admin_area/slide_images/$slide_image'>
                            </div>
                            ";

                        }
                    }

                    ?>


                </div>

                <a class="left carousel-control" href="#myCarousel" data-slide="prev"><!--left carousel-control-->
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next"><!--right carousel-control-->
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>

                </a>

            </div>
        </div>
    </div>

    <div id="advantages"><!--advantages start -->
        <div class="container"> <!--container start -->
            <div class="same-height-row"><!--same-height-row start-->
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h3><a href="#">Thailand</a></h3>
                        <p>Country 1 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h3><a href="#">USA</a></h3>
                        <p>Country 2 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-heart"></i>
                        </div>
                        <h3><a href="#">Japan</a></h3>
                        <p>Country 3 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-tags"></i>
                        </div>
                        <h3><a href="#">Sri Lanka</a></h3>
                        <p>Country 4 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-tags"></i>
                        </div>
                        <h3><a href="#">South Korean</a></h3>
                        <p>Country 5 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-tags"></i>
                        </div>
                        <h3><a href="#">Philiphines</a></h3>
                        <p>Country 6 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <h3><a href="#">England</a></h3>
                        <p>Country 7 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <h3><a href="#">Russia</a></h3>
                        <p>Country 8 Product List</p>

                    </div>
                </div>
                <div class="col-sm-4"><!--col-sm-4 start -->
                    <div class="box same-height"><!--box same-height start-->
                        <div class="icon">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <h3><a href="#">Brazil</a></h3>
                        <p>Country 9 Product List</p>

                    </div>
                </div>
<!-- end of country category-->

            </div>
        </div>
    </div>

    <div id="hot"><!-- hot start-->
        <div class="box"><!-- box start-->
            <div class="container"><!--container start-->
                <div class="col-md-12"><!--col-md-12 start -->
                    <h2>Today's Deal</h2>
                </div>
            </div>
        </div>
    </div>
<!--Today's Deal product start-->
    <div id="content" class="container"><!-- container start-->
        <div class="row"><!--row start-->
            <?php
                get_today_deal();
            ?>

        </div>
    </div>

    <div id="hot"><!-- hot start-->
        <div class="box"><!-- box start-->
            <div class="container"><!--container start-->
                <div class="col-md-12"><!--col-md-12 start -->
                    <h2>Popular Product</h2>
                </div>
            </div>
        </div>
    </div>
<!--Popular Product start here -->
    <div id="content" class="container"><!-- container start-->
        <div class="row"><!--row start-->
            <!-- first product start here-->
            <div class="col-sm-4 col-sm-6 single"><!--col-sm-4 col-sm-6 single start-->
                <div class="product"><!--product start-->
                    <a href="details.php">
                        <img src="admin_area/admin_images/popular_demo.jpg" class="img-responsive">
                    </a>
                    <div class="text"><!-- text start-->
                        <h3><a href="details.php">Pupolar Test1</a></h3>
                        <p class="price">$50</p>
                        <p class="button">
                            <a href="details.php" class="btn btn-default"> View Details</a>
                            <a href="details.php" class="btn btn-primary">
                                <i class="fa fa-shopping-cart">Add to cart</i>
                            </a>
                        </p>
                    </div>

                </div>

            </div>
            <!-- second product start here-->
            <div class="col-sm-4 col-sm-6 single"><!--col-sm-4 col-sm-6 single start-->
                <div class="product"><!--product start-->
                    <a href="details.php">
                        <img src="admin_area/admin_images/popular_demo.jpg" class="img-responsive">
                    </a>
                    <div class="text"><!-- text start-->
                        <h3><a href="details.php">Pupolar Test2</a></h3>
                        <p class="price">$50</p>
                        <p class="button">
                            <a href="details.php" class="btn btn-default"> View Details</a>
                            <a href="details.php" class="btn btn-primary">
                                <i class="fa fa-shopping-cart">Add to cart</i>
                            </a>
                        </p>
                    </div>

                </div>

            </div>
            <!--Third product start here-->
            <div class="col-sm-4 col-sm-6 single"><!--col-sm-4 col-sm-6 single start-->
                <div class="product"><!--product start-->
                    <a href="details.php">
                        <img src="admin_area/admin_images/popular_demo.jpg" class="img-responsive">
                    </a>
                    <div class="text"><!-- text start-->
                        <h3><a href="details.php">Pupolar Test3</a></h3>
                        <p class="price">$50</p>
                        <p class="button">
                            <a href="details.php" class="btn btn-default"> View Details</a>
                            <a href="details.php" class="btn btn-primary">
                                <i class="fa fa-shopping-cart">Add to cart</i>
                            </a>
                        </p>
                    </div>

                </div>

            </div>
            <!--Fourth product start here-->
            <div class="col-sm-4 col-sm-6 single"><!--col-sm-4 col-sm-6 single start-->
                <div class="product"><!--product start-->
                    <a href="details.php">
                        <img src="admin_area/admin_images/popular_demo.jpg" class="img-responsive">
                    </a>
                    <div class="text"><!-- text start-->
                        <h3><a href="details.php">Pupolar Test4</a></h3>
                        <p class="price">$50</p>
                        <p class="button">
                            <a href="details.php" class="btn btn-default"> View Details</a>
                            <a href="details.php" class="btn btn-primary">
                                <i class="fa fa-shopping-cart">Add to cart</i>
                            </a>
                        </p>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <?php
    include ('includes/footer.php');
    ?>
    </body>

</html>
