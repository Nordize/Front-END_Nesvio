<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/15/2018
 * Time: 9:39 PM
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

    <script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

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
                    <li >
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="shop.php">Shop</a>
                    </li>
                    <li>
                        <a href="hot_deal.php">Hot's Deal</a>
                    </li>
                    <li class="active">
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

<div id="content"><!--content start -->
    <div class="container"><!--container start-->
        <div class="col-md-12"><!--col-md-12 start-->
            <ul class="breadcrumb"><!--breadcrumb start -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Checkout Details
                </li>
            </ul>

            <div class ="crumb_body">
                <div class="breadcrumb_nav flat" >
                    <a href="cart.php" >Cart</a>
                    <a href="#">Shipping Information</a>
                    <a href="#">Shipping Method</a>
                    <a href="payment_option.php">Payment Method</a>
                    <a href="#">Order Confirmation</a>
                </div>
            </div>


        </div> <!--col-md-12 end-->

        <div class="col-md-3"><!-- col-md-3-->
            <?php include ("includes/sidebar.php");?>
        </div>

        <!-- checkout code start here -->
        <div class="col-md-9"> <!--col-md-9 start -->
            <?php
            if(!isset($_SESSION['customer_username']))
            {
                include('customer/customer_login.php');
            }else{
                include ('payment_option.php'); //change here
            }
            ?>
        </div>

    </div> <!--container end-->
</div> <!--content end-->


<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>


