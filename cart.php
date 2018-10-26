<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 7:49 PM
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

    <script>
        //script for update quantity of the product in shopping cart
        $(document).ready(function(data){
            $(document).on('keyup', '.quantity', function(){
                var id = $(this).data("product_id");
                var quantity = $(this).val();
                if(quantity  != ''){
                    $.ajax({
                        url:"includes/change_qty.php",
                        method:"POST",
                        data:{id:id, quantity:quantity},
                        success:function(data){
                            $("body").load('show_shopping_cart.php');
                        }
                    });
                }
            });
        });

    </script>



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
                    <a href="checkout.php">My Account</a>
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
                    <li>
                        <a href="./customer/my_account.php">My Account</a>
                    </li>
                    <li class="active">
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
                    <p class="text-muted">You currently have <?php items_in_cart();?> item(s) in your cart.</p>
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
                                <?php include ('includes/show_shopping_cart.php');?>
                        </table>

                    </div>

                    <div class="box-footer"><!--box-footer -->
                        <div class="pull-left"><!--pull-left -->
                            <a href="index.php" class="btn btn-default">
                                <i class="fa fa-chevron-circle-left"></i>Continue Shopping
                            </a>
                        </div>
                        <div class="pull-right"><!--pull-right -->
                            <?php update_cart();?>
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


            <?php include ("includes/also_like.php");?>

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

                        <?php include ('includes/show_order_summary.php');?>

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
