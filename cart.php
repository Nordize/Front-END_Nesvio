<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 7:49 PM
 */

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
            <a href="#" class="btn btn-success btn-sm">Welcome : Guest</a>
            <a href="#">Shopping Cart Total Price: $100, Total Item 2</a>
        </div>
        <div class="col-md-6"> <!--Header start-->
            <ul class="menu">
                <li>
                    <a href="customer_register.php">Register</a>
                </li>
                <li>
                    <a href="checkout.php">My Account</a>
                </li>
                <li>
                    <a href="cart.php">Go to Cart</a>
                </li>
                <li>
                    <a href="checkout.php">Login</a>
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
                    <li >
                        <a href="shop.php">Shop</a>
                    </li>
                    <li>
                        <a href="hot_deal.php">Hot's Deal</a>
                    </li>
                    <li>
                        <a href="./customer/my_account.php">My Account</a>
                    </li>
                    <li class="active">
                        <a href="cart.php">Shopping Cart</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact Us</a>
                    </li>
                </ul>
            </div>
            <a class="btn btn-primary navbar-btn right" href="cart.php"><!--btn btn-primary navbar-btn right start-->
                <i class="fa fa-shopping-cart"></i>
                <span>4 items in cart</span>
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
        <div class="col-md-12"><!--col-md-12 -->
            <ul class="breadcrumb"><!--breadcrumb start -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Cart
                </li>
            </ul>
        </div>

        <div class="col-md-9" id="cart"><!--col-md-9 start -->

            <div class="box"><!-- box start -->
                <form action="cart.php" method="post" enctype="multipart-form-data"><!--multipart-form-data -->
                    <h1>Shopping Cart</h1>
                    <p class="text-muted">You currently have 3 item(s) in your cart.</p>
                    <div class="table-reponsive"><!--table-reponsive -->
                        <table class="table"><!--table start -->
                            <thead><!--thead start -->
                                <tr>
                                    <th colspan="2">Product</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Size</th>
                                    <th colspan="1">Delete</th>
                                    <th colspan="2">Sub Total</th>
                                </tr>
                            </thead>

                            <tbody><!--tbody start -->
                                <tr><!-- tr start -->
                                    <td>
                                        <img src="admin_area/product_images/product_demo.jpg">
                                    </td>
                                    <td>
                                        <a href="#">Product Details1</a>
                                    </td>
                                    <td>
                                        2
                                    </td>
                                    <td>
                                        $50.00
                                    </td>
                                    <td>
                                        Large
                                    </td>
                                    <td>
                                        <input type="checkbox" name="remove[]">
                                    </td>
                                    <td>
                                        $100.00
                                    </td>

                                </tr>
                            <tr><!-- tr start -->
                                <td>
                                    <img src="admin_area/product_images/product_demo.jpg">
                                </td>
                                <td>
                                    <a href="#">Product Details1</a>
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    $50.00
                                </td>
                                <td>
                                    Large
                                </td>
                                <td>
                                    <input type="checkbox" name="remove[]">
                                </td>
                                <td>
                                    $100.00
                                </td>

                            </tr>
                            <tr><!-- tr start -->
                                <td>
                                    <img src="admin_area/product_images/product_demo.jpg">
                                </td>
                                <td>
                                    <a href="#">Product Details1</a>
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    $50.00
                                </td>
                                <td>
                                    Large
                                </td>
                                <td>
                                    <input type="checkbox" name="remove[]">
                                </td>
                                <td>
                                    $100.00
                                </td>

                            </tr>
                            </tbody>
                            <tfoot><!--tfoot start -->
                                <tr>
                                    <th colspan="5">Total</th>
                                    <th colspan="2">$100.00</th>
                                </tr>
                            </tfoot>


                        </table>

                    </div>

                    <div class="box-footer"><!--box-footer -->
                        <div class="pull-left"><!--pull-left -->
                            <a href="index.php" class="btn btn-default">
                                <i class="fa fa-chevron-circle-left"></i>Continue Shopping
                            </a>
                        </div>
                        <div class="pull-right"><!--pull-right -->
                            <button class="btn btn-default" type="submit" name="update" value="Update Cart">
                                <i class="fa fa-refresh"></i>Update Cart

                            </button>

                            <a href="checkout.php" class="btn btn-primary">
                                Proceed to checkout <i class="fa fa-chevron-right"></i>

                            </a>

                        </div>
                    </div>

                </form>

            </div>

            <?php include ("includes/also_like.php")?>

        </div>

        <div class="col-md-3"><!--col-md-3 -->
            <div class="box" id="order-summary"><!--box start -->
                <div class="box-header"><!--box-header-->

                    <h3>Order Summary</h3>

                </div>
                <p class="text-muted">
                    Shipping and additional costs are calculated based on the values you have entered.
                </p>

                <div class="table-responsive"><!-- table-responsive-->
                    <table class="table"><!--table start-->
                        <tbody><!--tbody start -->
                            <tr>
                                <td>Order Subtotal</td>
                                <th>$200.00</th>
                            </tr>
                        <tr>
                            <td>Shipping and handling</td>
                            <td>$0.00</td>
                        </tr>
                        <tr>
                           <td>Tax</td>
                            <td>$0.00</td>
                        </tr>
                        <tr class="total">
                            <td>Total</td>
                            <th>$200.00</th>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>


    </div>
</div>


<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>
