<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/1/2018
 * Time: 8:45 PM
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

<?php include ('includes/top_header.php');?>

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
                    <li  class="active">
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
                    <li >
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
        <div class="col-md-12"><!--col-md-12 start-->
            <ul class="breadcrumb"><!--breadcrumb start -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Register
                </li>
            </ul>
        </div> <!--col-md-12 end-->

        <div class="col-md-3"><!-- col-md-3-->
            <?php include ("includes/sidebar.php");?>
        </div>

        <div class="col-md-9"><!--col-md-9 -->
            <div class="box"><!--box start -->
                <div class="box-header"><!--box-header -->
                    <center><!--center start -->
                        <h2>Register A New Account</h2>

                    </center>
                </div>

                <form action="customer_register.php" method="post" enctype="multipart/form-data"><!--form start -->
                    <div class="form-group"><!--form-group start -->
                        <label>Customer Name:</label>
                        <input type="text" class="form-control" name="c_name" required>
                    </div>

                    <div class="form-group"><!--form-group start -->
                        <label>Email:</label>
                        <input type="text" class="form-control" name="c_email" required>
                    </div>

                    <div class="form-group"><!--form-group start -->
                        <label>Password:</label>
                        <input type="password" class="form-control" name="c_country" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>Address:</label>
                        <input type="text" class="form-control" name="c_address" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>city:</label>
                        <input type="text" class="form-control" name="c_city" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>State:</label>
                        <input type="text" class="form-control" name="c_state" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>Zip code:</label>
                        <input type="text" class="form-control" name="c_zipcode" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>Phone No:</label>
                        <input type="text" class="form-control" name="c_phone" required>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label>Your Image:</label>
                        <input type="file" class="form-control" name="c_image" >
                    </div>

                    <div class="text-center"><!--text-center -->
                        <button type="submit" name="Register" class="btn btn-primary">
                            <i class="fa fa-user-md"></i> Register
                        </button>
                    </div>


                </form>




            </div>
        </div>


    </div> <!--container end-->
</div> <!--content end-->


<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>

