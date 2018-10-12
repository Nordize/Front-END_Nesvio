<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 6:50 PM
 */
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
                <img src="images/logo_light.png" alt="E-commerce Logo" class="hidden-xs">
                <img src="images/demo_logo-small.png" alt="E-commerce Logo" class="visible-xs">
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
                    <li class="active">
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
<!-- start of left side navigator bar -->
<div id="content"><!--content start -->
    <div class="container"><!--container start-->
        <div class="col-md-12"><!--col-md-12 -->
            <ul class="breadcrumb"><!--breadcrumb start -->
                <li>
                    <a href="index.php">Home</a>
                </li>
                <li>
                    Shop
                </li>
            </ul>
        </div>

        <div class="col-md-3"><!-- col-md-3-->
            <?php include ("includes/sidebar.php");?>
        </div>

        <!-- begin of product details -->
        <div class="col-md-9"><!--col-md-9 -->
            <div class="row" id="productMain"><!--row start -->
                <div class="col-sm-6"><!--col-sm-6 -->
                    <div id="mainImage"><!--mainImage start-->
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators"><!-- carousel-indicators-->
                                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                <li data-target="#myCarousel" data-slide-to="1"></li>
                                <li data-target="#myCarousel" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner"><!-- carousel-inner-->
                                <div class="item active">
                                    <center>
                                        <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                                    </center>
                                </div>
                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/product_demo_back.jpg" class="img-responsive">
                                    </center>
                                </div>
                                <div class="item">
                                    <center>
                                        <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">
                                    </center>
                                </div>

                            </div>
                            <!--Left arrow for slider -->
                            <a href="#myCarousel" class="left carousel-control" data-slide="prev"><!--left carousel-control start -->
                                <span class="glyphicon glyphicon-chevron-left"></span>

                                <span class="sr-only">Previous</span>
                            </a>
                            <!--Right arrow for slider -->
                            <a class="right carousel-control" href="#myCarousel" data-slide="next"><!--right carousel-control -->
                                <span class="glyphicon glyphicon-chevron-right"></span>
                                <span class="sr-only">Next</span>
                            </a>


                        </div>
                    </div> <!--mainImage end-->
                </div>   <!--col-sm-6 end -->

                <div class="col-sm-6"><!--col-sm-6 start -->
                    <div class="box"><!--box start -->
                        <h1 class="text-center">Product Details1</h1>
                        <form action="details.php" method="post" class="form-horizontal"><!--form-horizontal -->
                            <div class="form-group"><!--form-group -->
                                <label class="col-md-5 control-label">Product Quantity</label>

                                <div class="col-md-7"><!--col-md-7 -->
                                    <select name="product_qty" class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>

                                    </select>
                                </div>
                            </div>

                            <div class="form-group"><!--form-group -->
                                <label class="col-md-5 control-label">Product Size</label>
                                <div class="col-md-7"><!-- col-md-7-->
                                    <select name="product_size" class="form-control">
                                        <option>Select a Size</option>
                                        <option>Small</option>
                                        <option>Medium</option>
                                        <option>Large</option>
                                        <option>X-Large</option>
                                        <option>XX-Large</option>
                                        <option>XXX-Large</option>
                                    </select>
                                </div>
                            </div>

                            <p class="price">$50</p>
                            <p class="text-center buttons"><!--text-center buttons start -->
                                <button class="btn btn-primary" type="submit">
                                    <i class="fa fa-shopping-cart"></i>Add to Cart
                                </button>
                            </p>


                        </form>
                    </div>

                    <div class="row" id="thumbs"><!--row start -->
                        <div class="col-xs-4"><!-- col-xs-4-->
                            <a href="#" class="thumb">
                                <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">

                            </a>
                        </div>
                        <div class="col-xs-4"><!-- col-xs-4-->
                            <a href="#" class="thumb">
                                <img src="admin_area/product_images/product_demo_back.jpg" class="img-responsive">

                            </a>
                        </div>
                        <div class="col-xs-4"><!-- col-xs-4-->
                            <a href="#" class="thumb">
                                <img src="admin_area/product_images/product_demo.jpg" class="img-responsive">

                            </a>
                        </div>
                    </div>


                </div>

            </div> <!-- row Ends-->

            <div class="box" id="details"><!--box start -->
                <p><!--p start-->
                    <h4>Product details</h4>
                    <p>The is the detail of the product.</p>
                    <h4>Size</h4>
                    <ul>
                        <li>Small</li>
                        <li>Medium</li>
                        <li>Large</li>
                        <li>X-Large</li>
                        <li>XX-Large</li>
                    </ul>
                </p>

                <hr>

            </div>
            <?php include ("includes/also_like.php")?>

        </div>

    </div>
</div>
<!-- end of left side navigator bar -->



<!-- end of product details -->
<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>
