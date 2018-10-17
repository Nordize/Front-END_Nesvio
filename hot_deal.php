<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 8:41 PM
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
    <script scr="js/bootstrap.min.js"></script>
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
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navigation">
                <span class="sr-only">Toggle Navigation</span>
                <i class="fa fa-align-justify"></i>
            </button>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#search">
                <span class="sr-only">Toggle Search</span>
                <i class="fa fa-search"></i>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navigation"> <!--navbar-collapse collapse Starts-->
            <div class="padding-nav"> <!--padding-nav Starts-->
                <ul class="nav navbar-nav navbar-left"><!-- nav navbar-nav navbar-left start-->
                    <li >
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="shop.php">Shop</a>
                    </li>
                    <li class="active">
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
            <a class="btn btn-primary navbar-btn right" href="cart.php"><!--btn btn-primary navbar-btn right start-->
                <i class="fa fa-shopping-cart"></i>
                <span><?php items_in_cart();?> items in cart</span>
            </a>
            <div class="navbar-collapse collapse right"><!--navbar-collapse collapse right start-->
                <button class="btn navbar-btn btn-primary" type="button" data-toggle="collapse" data-target="#search" style="height: 33px;">
                    <span class="sr-only">Toggle Search</span>
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <div class="collapse clearfix" id="search"> <!--collapse clearfix starts-->
                <form class="navbar-form" method="get" action="results.php"><!--navbar-form start-->
                    <button type="button" value="All" name="all" class="btn btn-primary" style="height: 33px;">
                        All <!-- comeback to do the all category-->
                    </button>
                    <div class="input-group"><!--input-group start-->
                        <input class="form-control" type="text" placeholder="Search" name="user_query" style="width: 995px" required>
                        <span class="input-group-btn"><!--input-group-btn start-->
                                <button type="submit" value="Search" name="search" class="btn btn-primary" style="height: 33px;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!--End of Navigator bar-->

<div id="content"><!--content start -->
    <div class="container"><!--container start-->
        <div class="col-md-12"><!--col-md-12 start-->
            <ul class="breadcrumb"><!--breadcrumb start -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Hot's Deal
                </li>
            </ul>
        </div> <!--col-md-12 end-->

        <div class="col-md-3"><!-- col-md-3-->
            <?php include ("includes/sidebar.php");?>
        </div>

        <div class="col-md-9"><!-- col-md-9 start-->
            <div class="box"><!-- box start -->
                <h1>Hot Deal, Deal of the day!</h1>
                <p> This is the Hot Deal Page, Everything on this page is FAKE!!!</p>

            </div>

            <div class="row"><!--row start -->
                <!-- list product1-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details1</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
                <!-- list product2-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details2</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
                <!-- list product3-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details3</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
                <!-- list product4-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details4</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
                <!-- list product5-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details5</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>
                <!-- list product6-->
                <div class="col-md-4 col-sm-6 center-responsive"><!--col-md-4 col-sm-6 center-responsive -->
                    <div class="product"><!--product start -->
                        <a href="details.php"><!--a start -->
                            <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                        </a>
                        <div class="text"><!--text start -->
                            <h3>
                                <a href="details.php">Hot Product Details6</a>
                            </h3>
                            <p class="price">$50</p>

                            <p class="buttons">
                                <a href="details.php" class="btn btn-default">View details</a>
                                <a href="details.php" class="btn btn-primary">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </a>
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <center><!--center start -->
                <ul class="pagination"><!--pagination start -->
                    <li><a href="shop.php">First Page</a></li>
                    <li><a href="shop.php">1</a></li>
                    <li><a href="shop.php">2</a></li>
                    <li><a href="shop.php">3</a></li>
                    <li><a href="shop.php">4</a></li>
                    <li><a href="shop.php">5</a></li>
                    <li><a href="shop.php">Last Page</a></li>

                </ul>
            </center>


        </div>


    </div> <!--container end-->
</div> <!--content end-->


<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>
