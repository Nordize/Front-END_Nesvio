<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 5:32 PM
 */

session_start();
include ('includes/dblogin.php');
include ('functions/functions.php');

include ('includes/stripe_config.php');

if(isset($_SESSION['customer_username']))
{
    $customer_username = $_SESSION['customer_username'];

    $get_cus_email = "SELECT customer_id,customer_email FROM customer WHERE customer_username = '$customer_username'";
    $run_get_cus_email = $db_connect->query($get_cus_email);

    if($run_get_cus_email->rowCount()>0)
    {
        while($row_get_cus_email = $run_get_cus_email->fetch())
        {
            $customer_id = $row_get_cus_email['customer_id'];
            $customer_email = $row_get_cus_email['customer_email'];
        }
    }

}



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

    <script type="text/javascript">
        //script for radio button on shipping same address
        $(document).ready(function () {
            <?php
            if(@$_SESSION["is_shipping_address_same"] == "yes")
            {
                ?>
            $("#shipping-details-form-div:input").prop("disabled",true);
            $("#shipping-details-form-div").hide();
            <?php
            }
            ?>
            $("input[name='is_shipping_address_same']").click(function(){
                var radio_value = $(this).val();
                if(radio_value == "yes"){
                    $("#shipping-details-form-div:input").prop("disabled",true);
                    $("#shipping-details-form-div").hide();
                }else if (radio_value == "no")
                {
                    $("#shipping-details-form-div:input").prop("disabled",false);
                    $("#shipping-details-form-div").show();
                }
            });
            $("#shipping-billing-details-form:input").change(function () {
                var form = document.getElementById("shipping-billing-details-form");

                var form_data = new FormData(form);

                var shipping_type = $("input[name='shipping_type']:checked").val();

                var payment_method = $("input[name='payment_method']:checked").val();

                form_data.append("shipping_type",shipping_type);
                form_data.append("payment_method",payment_method);

                $("table").addClass("wait-loader");
                $.ajax({
                   url: "update_billing_shipping_details.php",
                   method: "POST",
                   processData: false,
                    contentType: false,
                    cache: false,
                    data: form_data
                }).done(function () {
                    $("#checkout-tbody-reload").load("checkout_tbody.php");
                    $("table").removeClass("wait-loader");

                });
            });

            /*$(document).on("change",".shipping_type",function(){
                var total = Number(// echo $total; ?>);
                var tax = Number( // echo $tax; ?> );
                var shipping_type = $(this).val();
                var shipping_cost = Number($(this).data("shipping_cost"));
                var payment_method = $("input[name='payment_method']:checked").val();
                var total_cart_price = total + shipping_cost + tax;
                //$("table").addClass("wait-loader");
                $.ajax({
                    url: "change_checkout_shipping.php",
                    method:"POST",
                    data:{total:total,shipping_type:shipping_type,shipping_cost:shipping_cost,payment_method:payment_method}
                }).done(function(data){
                    $(".total-cart-price").html("$"+total_cart_price);
                    $("#payment-method-forums-td").html(data);
                    //$("table").removeClass("wait-loader");
                });
            });*/

            //script for payment method
            $("#stripe-desc").hide();
            $("#stripe-form").hide();
            $("#paypal-desc").hide();
            $("#paypal-form").hide();

            $("#stripe-radio").click(function(){
                $("#stripe-desc").show();
                $("#stripe-form").show();
                $("#paypal-desc").hide();
                $("#paypal-form").hide();
            });

            $("#paypal-radio").click(function(){
                $("#stripe-desc").hide();
                $("#stripe-form").hide();
                $("#paypal-desc").show();
                $("#paypal-form").show();
            });

            //stripe
            $("#stripe-submit").click(function(event){
                event.preventDefault();
                $("#shipping-billing-details-form").submit(function(event){
                    event.preventDefault();
                    var confirm_action = confirm("Do You Really Want To Order Cart Products By Credit Card (Stripe) Method?");
                    if(confirm_action==true)
                    {
                        var $button = $("#stripe-submit"),
                            $form = $button.parents('form');
                        var opts = $.extend({}, $button.data(), {
                            token: function(result) {
                                $form.append($('<input>').attr({ type: 'hidden', name: 'stripeToken', value: result.id })).submit();
                            }
                        });
                        StripeCheckout.open(opts);
                    }
                });
                $("#shipping-details-form-submit-button").click();
            });

            //paypal
            $("#paypal-submit").click(function(event){
                event.preventDefault();
                $("#shipping-billing-details-form").submit(function(event){
                    event.preventDefault();
                    var confirm_action = confirm("Do You Really Want To Order Cart Products By Paypal Method?");
                    if(confirm_action==true)
                    {
                       $("#paypal-submit").click();
                    }
                });
                $("#shipping-details-form-submit-button").click();
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
                    Checkout Details
                </li>
            </ul>

            <div class ="crumb_body">
                <div class="breadcrumb_nav flat" >
                    <a href="cart.php" >Shopping Cart</a>
                    <a href="review_order.php" class="active">Checkout Details</a>
                    <a href="#">Order Complete</a>
                </div>
            </div>

        </div>

        <div class="row"><!-- row start -->
            <?php
            $ip_add = getRealUserIp();

            $select_cart = "SELECT COUNT(*) FROM cart WHERE ip_add='$ip_add'";
            $run_cart = $db_connect->query($select_cart);
            $count_cart = $run_cart->fetchColumn();

            if($count_cart == 0)
            {?>
                <div class="col-md-12"><!-- col-md-12 start-->
                    <div class="box text-center"><!--  box text-center start-->
                        <p class="lead"> Checkout is not available. Your cart is currently empty.</p>

                        <a href="shop.php" class="btn btn-primary btn-lg"> Return To Shop</a>
                    </div>
                </div>
            <?php } else
            {?>
                <div class="col-md-8"><!--col-md-8 start -->
                    <div class="box"><!-- box start-->
                        <p class="lead"> Please Fell Free To Check Your Billing Details and Shipping Details</p>
                        <?php
                        $customer_username = $_SESSION['customer_username'];

                        $get_customer = "SELECT * FROM customer WHERE customer_username = '$customer_username'";
                        $run_customer = $db_connect->query($get_customer);

                        if($run_customer->rowCount()>0)
                        {
                            $row_customer = $run_customer->fetch();

                            $customer_id = $row_customer['customer_id'];

                            $select_customers_addresses = "SELECT * FROM customer_addresses WHERE customer_id = '$customer_id'";
                            $run_customers_addresses = $db_connect->query($select_customers_addresses);

                            if($run_customers_addresses->rowCount()>0)
                            {
                                $row_customers_addresses = $run_customers_addresses->fetch();

                                //Biling Details start
                                $billing_first_name = $row_customers_addresses['billing_first_name'];
                                $billing_last_name = $row_customers_addresses['billing_last_name'];
                                $billing_address_1 = $row_customers_addresses['billing_address_1'];
                                $billing_address_2 = $row_customers_addresses['billing_address_2'];
                                $billing_city = $row_customers_addresses['billing_city'];
                                $billing_state = $row_customers_addresses['billing_state'];
                                $billing_country = $row_customers_addresses['billing_country'];
                                $billing_zipcode = $row_customers_addresses['billing_zipcode'];

                                //Shipping Details start

                                $shipping_first_name = $row_customers_addresses['shipping_first_name'];
                                $shipping_last_name = $row_customers_addresses['shipping_last_name'];
                                $shipping_address_1 = $row_customers_addresses['shipping_address_1'];
                                $shipping_address_2 = $row_customers_addresses['shipping_address_2'];
                                $shipping_city = $row_customers_addresses['shipping_city'];
                                $shipping_state = $row_customers_addresses['shipping_state'];
                                $shipping_country = $row_customers_addresses['shipping_country'];
                                $shipping_zipcode = $row_customers_addresses['shipping_zipcode'];


                            }

                        }

                        ?>
                        <form method="post" id="shipping-billing-details-form"><!-- shipping-billing-details-form-->
                            <h2> Billing Details</h2>
                            <div class="row"><!--row start -->
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> First Name: </label>
                                        <input type="text" name="billing_first_name" class="form-control" value="<?php echo $billing_first_name;?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> Last Name: </label>
                                        <input type="text" name="billing_last_name" class="form-control" value="<?php echo $billing_last_name;?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> Address 1: </label>
                                        <input type="text" name="billing_address_1" class="form-control" value="<?php echo $billing_address_1;?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> Address 2: </label>
                                        <input type="text" name="billing_address_2" class="form-control" value="<?php echo $billing_address_2;?>" >
                                    </div>
                                </div>
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> City: </label>
                                        <input type="text" name="billing_city" class="form-control" value="<?php echo $billing_city;?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> State: </label>
                                        <input type="text" name="billing_state" class="form-control" value="<?php echo $billing_state;?>" required>
                                    </div>
                                </div>
                                <!-- can use with another form/project by copy this part -->
                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> Country: </label>
                                        <select name="billing_country" class="form-control" required>
                                            <option value="">Select A Country</option>
                                            <?php
                                            $get_countries = "SELECT * FROM countries";
                                            $run_countries = $db_connect->query($get_countries);

                                            if($run_countries->rowCount()>0)
                                            {
                                                while ($row_countries = $run_countries->fetch())
                                                {
                                                    $country_id = $row_countries['id'];
                                                    $country_code = $row_countries['country_code'];
                                                    $country_name = $row_countries['country_name'];

                                                    ?>
                                                    <option value="<?php echo $country_id;?>"
                                                        <?php
                                                        if($billing_country == $country_id ) {echo "selected";}

                                                        ?>
                                                    >

                                                        <?php echo $country_name;?>

                                                    </option>
                                                    <?php

                                                }
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- to this prt-->

                                <div class="col-sm-6"><!--col-sm-6 -->
                                    <div class="form-group"><!--form-group start -->
                                        <label> Zipcode: </label>
                                        <input type="text" name="billing_zipcode" class="form-control" value="<?php echo $billing_zipcode;?>" required>
                                    </div>
                                </div><!--col-sm-6 end-->
                            </div><!--row end -->

                            <!-- shipping address start here -->
                            <hr>
                            <div class="form-group"><!--form-group start -->
                                <h4 >Is Shipping Details Are The Same?</h4>
                                <?php

                                if(isset($_SESSION['is_shipping_address_same']))
                                {
                                    $_SESSION['is_shipping_address_same'] = 'yes';
                                }

                                ?>
                                <input type="radio" name="is_shipping_address_same" value="yes"
                                    <?php
                                    if(@$_SESSION['is_shipping_address_same'] == 'yes') {echo 'checked';}
                                    ?>
                                >
                                <label>Yes</label>

                                <input type="radio" name="is_shipping_address_same" value="no"
                                    <?php
                                    if(@$_SESSION['is_shipping_address_same'] == 'no') {echo 'checked';}
                                    ?>
                                >
                                <label>No</label>

                            </div><!--form-group end -->

                            <div id="shipping-details-form-div"><!--shipping-details-form-div start -->
                                <h2> Shipping Details</h2>
                                <div class="row"><!--row start -->
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> First Name: </label>
                                            <input type="text" name="shipping_first_name" class="form-control" value="<?php echo $shipping_first_name;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> Last Name: </label>
                                            <input type="text" name="shipping_last_name" class="form-control" value="<?php echo $shipping_last_name;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> Address 1: </label>
                                            <input type="text" name="shipping_address_1" class="form-control" value="<?php echo $shipping_address_1;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> Address 2: </label>
                                            <input type="text" name="shipping_address_2" class="form-control" value="<?php echo $shipping_address_2;?>" >
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> City: </label>
                                            <input type="text" name="shipping_city" class="form-control" value="<?php echo $shipping_city;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> State: </label>
                                            <input type="text" name="shipping_state" class="form-control" value="<?php echo $shipping_state;?>" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> Country: </label>
                                            <select name="shipping_country" class="form-control" required>
                                                <option value="">Select A Country</option>
                                                <?php
                                                $get_countries = "SELECT * FROM countries";
                                                $run_countries = $db_connect->query($get_countries);

                                                if($run_countries->rowCount()>0)
                                                {
                                                    while ($row_countries = $run_countries->fetch())
                                                    {
                                                        $country_id = $row_countries['id'];
                                                        $country_code = $row_countries['country_code'];
                                                        $country_name = $row_countries['country_name'];

                                                        ?>
                                                        <option value="<?php echo $country_id;?>"
                                                            <?php
                                                            if($shipping_country == $country_id ) {echo "selected";}

                                                            ?>
                                                        >

                                                            <?php echo $country_name;?>

                                                        </option>
                                                        <?php

                                                    }
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6"><!--col-sm-6 -->
                                        <div class="form-group"><!--form-group start -->
                                            <label> Zipcode: </label>
                                            <input type="text" name="shipping_zipcode" class="form-control" value="<?php echo $shipping_zipcode;?>" required>
                                        </div>
                                    </div><!--col-sm-6 end-->
                                </div><!--row end -->

                            </div><!--shipping-details-form-div end -->

                            <input type="submit" name="submit" id="shipping-details-form-submit-button" value="Submit Form" style="display: none;">


                        </form>

                    </div><!-- box end-->
                </div><!--col-md-8 end -->
     <!--these scripts for the right panel to show the review order summary and choose payment method  start-->
                <div class="col-md-4"><!--col-md-4 start-->
                    <div class="box" id="order-summary"><!--box start -->
                        <div class="box-header"><!-- box-header start -->
                            <h3>Order Summary</h3>
                        </div>
                        <table class="table"><!--table start -->
                            <thead>
                            <tr>
                                <th class="text-muted lead">Product: </th>
                                <th class="text-muted lead">Total: </th>
                            </tr>
                            </thead>
                            <tbody id="checkout-tbody-reload"><!--checkout-tbody-reload start -->
                            <?php
                            $total = 0;

                            $total_weight = 0;

                            $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";
                            $run_cart = $db_connect->query($select_cart);

                            if($run_cart->rowCount()>0)
                            {
                                while ($row_cart= $run_cart->fetch())
                                {
                                    $product_id = $row_cart['p_id'];
                                    $product_qty = $row_cart['qty'];
                                    $product_price = $row_cart['p_price'];
                                    $product_size = $row_cart['p_size'];

                                    $get_product = "SELECT * FROM products WHERE product_id='$product_id'";
                                    $run_product = $db_connect->query($get_product);
                                    $row_product = $run_product->fetch();

                                    $product_title = $row_product['product_title'];
                                    $product_weight = $row_product['product_weight'];

                                    //$subtotal = $product_price * $product_qty;  <-- doesn't need to multiple QTY, cause it already done before write to cart table

                                    $subtotal = $product_price;

                                    $total += $subtotal;

                                    $subtotal_weight = $product_weight * $product_qty;
                                    $total_weight += $subtotal_weight;


                                    ?>
                                    <tr>
                                        <td>
                                            <a href="#" class="bold"><?php echo $product_title;?></a>
                                            <i class="fa fa-times" title="Product Qty"></i> <?php echo $product_qty;?>
                                            <?php if($product_size != "None") {?>
                                                <i class="fa fa-plus" title="Product Size"></i><?php echo $product_size;?>
                                            <?php }
                                            ?>
                                        </td>
                                        <th>$ <?php echo $subtotal;?></th>
                                    </tr>
                                    <?php
                                }
                            }

                            ?>
                            <tr>
                                <td>Order Subtotal</td>
                                <th>$ <?php echo $total;?></th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <p class="shipping-header text-muted">
                                        <i class="fa fa-truck"></i> Shipping:
                                    </p>
                                    <ul class="list-unstyled"><!--shipping ul list list-unstyled start -->
                                        <?php
                                        $shipping_zone_id = ""; //default is blank

                                        //this case for local shipping
                                        if(@$_SESSION['is_shipping_address_same'] == 'yes')
                                        {
                                            if(empty($billing_country) and empty($billing_zipcode))
                                            {
                                                echo "
                                            <li>
                                            <p>
                                            There are no shipping types avaliable. Please check your address, or contact us if you need any help.
                                            </p>
                                            </li>
                                            ";
                                            }

                                            $select_zones = "SELECT * FROM zones ORDER BY zone_order DESC";
                                            $run_zones = $db_connect->query($select_zones);

                                            if($run_zones->rowCount()>0)
                                            {
                                                while($row_zones = $run_zones->fetch())
                                                {
                                                    $zone_id = $row_zones['zone_id'];
                                                    $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$billing_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);

                                                    $count_zones_locations = $run_zones_locations->fetchColumn();

                                                    if($count_zones_locations != "0")
                                                    {

                                                        $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$billing_country' AND location_type='country')";
                                                        $run_zones_locations = $db_connect->query($select_zones_locations);

                                                        $row_zones_locations = $run_zones_locations->fetch();
                                                        $zone_id = $row_zones_locations['zone_id'];

                                                        $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                        $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                        $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                        if($count_zones_shipping != "0")
                                                        {
                                                            $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                            if($count_zone_postcodes != "0")
                                                            {
                                                                $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                                $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                                while ($row_zones_postcodes = $run_zone_postcodes->fetch())
                                                                {
                                                                    $location_code = $row_zones_postcodes['location_code'];

                                                                    if($location_code == $billing_zipcode)
                                                                    {
                                                                        $shipping_zone_id = $zone_id;
                                                                    }
                                                                }

                                                            }else{
                                                                $shipping_zone_id = $zone_id;
                                                            }
                                                        }

                                                    }

                                                }
                                            }



                                        }elseif (@$_SESSION['is_shipping_address_same'] == 'no')
                                        {
                                            if(empty($shipping_country) and empty($shipping_zipcode))
                                            {
                                                echo "
                                            <li>
                                            <p>
                                            There are no shipping types avaliable. Please check your address, or contact us if you need any help.
                                            </p>
                                            </li>
                                            ";
                                            }

                                            $select_zones = "SELECT * FROM zones ORDER BY zone_order DESC";
                                            $run_zones = $db_connect->query($select_zones);

                                            if($run_zones->rowCount()>0)
                                            {
                                                while($row_zones = $run_zones->fetch())
                                                {
                                                    $zone_id = $row_zones['zone_id'];
                                                    $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);

                                                    $count_zones_locations = $run_zones_locations->fetchColumn();

                                                    if($count_zones_locations != "0")
                                                    {

                                                        $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                        $run_zones_locations = $db_connect->query($select_zones_locations);

                                                        $row_zones_locations = $run_zones_locations->fetch();
                                                        $zone_id = $row_zones_locations['zone_id'];

                                                        $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                        $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                        $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                        if($count_zones_shipping != "0")
                                                        {
                                                            $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                            if($count_zone_postcodes != "0")
                                                            {
                                                                $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                                $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                                while ($row_zones_postcodes = $run_zone_postcodes->fetch())
                                                                {
                                                                    $location_code = $row_zones_postcodes['location_code'];

                                                                    if($location_code == $shipping_zipcode)
                                                                    {
                                                                        $shipping_zone_id = $zone_id;
                                                                    }
                                                                }

                                                            }else{
                                                                $shipping_zone_id = $zone_id;
                                                            }
                                                        }

                                                    }

                                                }
                                            }


                                        }else{

                                            if(empty($shipping_country) and empty($shipping_zipcode))
                                            {
                                                echo "
                                            <li>
                                            <p>
                                            There are no shipping types avaliable. Please check your address, or contact us if you need any help.
                                            </p>
                                            </li>
                                            ";
                                            }

                                            $select_zones = "SELECT * FROM zones ORDER BY zone_order DESC";
                                            $run_zones = $db_connect->query($select_zones);

                                            if($run_zones->rowCount()>0)
                                            {
                                                while($row_zones = $run_zones->fetch())
                                                {
                                                    $zone_id = $row_zones['zone_id'];

                                                    $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);


                                                    $count_zones_locations = $run_zones_locations->fetchColumn();

                                                    if($count_zones_locations != "0")
                                                    {

                                                        $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                        $run_zones_locations = $db_connect->query($select_zones_locations);

                                                        $row_zones_locations = $run_zones_locations->fetch();
                                                        $zone_id = $row_zones_locations['zone_id'];

                                                        $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                        $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                        $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                        if($count_zones_shipping != "0")
                                                        {
                                                            $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                            if($count_zone_postcodes != "0")
                                                            {
                                                                $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                                $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                                while ($row_zones_postcodes = $run_zone_postcodes->fetch())
                                                                {
                                                                    $location_code = $row_zones_postcodes['location_code'];
                                                                    if($location_code == $shipping_zipcode)
                                                                    {
                                                                        $shipping_zone_id = $zone_id;
                                                                    }
                                                                }

                                                            }else{
                                                                $shipping_zone_id = $zone_id;
                                                            }
                                                        }

                                                    }

                                                }
                                            }
                                        }

                                        if(!empty($shipping_zone_id)) {

                                            $select_shipping_types = "SELECT *,IF(
                                                                            $total_weight > (
                                                                            SELECT MAX(shipping_weight) FROM shipping WHERE shipping_type = type_id AND shipping_zone='$shipping_zone_id'),
                                                                            (SELECT shipping_cost FROM shipping WHERE shipping_type=type_id AND shipping_zone='$shipping_zone_id' ORDER BY shipping_weight DESC LIMIT 0,1),
                                                                            (SELECT shipping_cost FROM shipping WHERE shipping_type = type_id AND shipping_zone='$shipping_zone_id' AND shipping_weight >= '$total_weight' ORDER BY shipping_weight ASC LIMIT 0,1)
                                                                            
                                                                            ) AS shipping_cost FROM shipping_types WHERE type_local = 'yes' ORDER BY type_order ASC";

                                            $run_shipping_types = $db_connect->query($select_shipping_types);
                                            $i = 0;

                                            if ($run_shipping_types->rowCount() > 0) {
                                                while ($row_shipping_types = $run_shipping_types->fetch()) {
                                                    $i++;

                                                    $type_id = $row_shipping_types['type_id'];
                                                    $type_name = $row_shipping_types['type_name'];
                                                    $type_default = $row_shipping_types['type_default'];
                                                    $shipping_cost = $row_shipping_types['shipping_cost'];

                                                    if (!empty($shipping_cost)) {
                                                        ?>
                                                        <li>
                                                            <input type="radio" name="shipping_type" value="<?php echo $type_id; ?>"
                                                                   class="shipping_type" data-shipping_cost="<?php echo $shipping_cost; ?>"
                                                                <?php
                                                                if ($type_default == "yes") {
                                                                    $_SESSION["shipping_type"] = $type_id;
                                                                    $_SESSION["shipping_cost"] = $shipping_cost;

                                                                    echo "checked";


                                                                } elseif ($i == 1) {
                                                                    $_SESSION["shipping_type"] = $type_id;
                                                                    $_SESSION["shipping_cost"] = $shipping_cost;

                                                                    echo "checked";

                                                                }

                                                                ?>
                                                            >

                                                            <?php echo $type_name; ?> : <span class="text-muted">$ <?php echo $shipping_cost; ?></span>

                                                        </li>


                                                        <?php
                                                    }
                                                }
                                            }
                                        }


                                        $tax = $total*0.07;   #Sales Tax in Florida is 7%
                                        $tax = sprintf('%.2f',$tax);

                                        $total_cart_price = $total + @$_SESSION['shipping_cost'] +$tax;
                                        $total_cart_price = sprintf('%.2f',$total_cart_price);

                                        ?>

                                    </ul><!--shipping ul list list-unstyled end -->
                                </th>
                            </tr>
                            <tr>
                                <td class="text-muted bold">Tax</td>
                                <td>$ <?php echo $tax;?></td>
                            </tr>
                            <tr class='total'>
                                <td>Total</td>
                                <th class='total-cart-price'>$ <?php echo $total_cart_price;?></th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input id="stripe-radio" type="radio" name="payment_method" value="stripe" checked>
                                    <label for="stripe-radio">Credit Card (Stripe)</label>
                                    <p id="stripe-desc" class="text-muted">
                                        Pay with your credit card via Stripe.
                                    </p>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <input id="paypal-radio" type="radio" name="payment_method" value="paypal">
                                    <label for="paypal-radio">PayPal</label>
                                    <p id="paypal-desc" class="text-muted">
                                        Pay via PayPal you can pay with your credit card if you don't have a PayPal account.
                                    </p>
                                </th>
                            </tr>
                            <tr>
                                <td id="payment-method-forums-td" colspan="2"><!--payment-method-forums-td start -->
                                    <?php
                                    $strip_total_amount = $total_cart_price * 100;
                                    ?>
                                    <form id="stripe-form" action="stripe_charge.php" method="post"><!--stripe-form start -->
                                        <input type="hidden" name="strip_total_amount" value="<?php echo $strip_total_amount;?>">
                                        <input type="submit" id="stripe-submit" class="btn btn-success btn-lg" value="Proceed With Stripe"
                                               style="border-radius: 0px;" data-name="eishops.com" data-description="Pay with Credit Card"
                                               data-image="../images/stripe-logo/png" data-key="<?php echo stripe['publishable_key'];?>"
                                               data-amount="<?php echo $strip_total_amount;?>" data-currency="usd" data-email="<?php echo $customer_email;?>">
                                    </form>

                                    <form id="paypal-form" action="https://www.sandbox.paypal.com/cgi-bin/websc" method="post"><!-- paypal-form start-->
                                        <input type="hidden" name="business" value="info-business@eishops.com">
                                        <input type="hidden" name="cmd" value="_cart">
                                        <input type="hidden" name="upload" value="1">
                                        <input type="hidden" name="currency_code" value="USD">

                                        <input type="hidden" name="return" value="http://127.0.0.1/ecom_store/paypal_order.php?c_id=<?php echo $customer_id;?>&amount=<?php echo $total_cart_price;?>">
                                        <input type="hidden" name="cancel_return" value="http://127.0.0.1/ecom_store/review_order.php">

                                        <?php
                                        $i =0;
                                        $select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";
                                        $run_cart = $db_connect->query($select_cart);

                                        if($run_cart->rowCount()>0)
                                        {
                                            while($row_cart = $run_cart->fetch())
                                            {
                                                $product_id = $row_cart['p_id'];
                                                $product_qty = $row_cart['qty'];
                                                $product_price = $row_cart['p_price'];

                                                $get_product="SELECT * FROM products WHERE product_id='$product_id'";

                                                $run_product = $db_connect->query($get_product);
                                                $row_product = $run_product->fetch();

                                                $product_title = $row_product['product_title'];

                                                $i++;

                                                ?>
                                                <input type="hidden" name="item_name_<?php echo $i;?>" value="<?php echo $product_title;?>">
                                                <input type="hidden" name="item_number_<?php echo $i;?>" value="<?php echo $i;?>">
                                                <input type="hidden" name="amount_<?php echo $i;?>" value="<?php echo $product_price;?>">
                                                <input type="hidden" name="quantity_<?php echo $i;?>" value="<?php echo $product_qty;?>">

                                            <?php    }
                                        }

                                        ?>

                                        <input type="hidden" name="shipping_1" value="<?php echo @$_SESSION["shipping_cost"];?>">
                                        <input type="hidden" name="first_name" value="<?php echo $billing_first_name;?>">
                                        <input type="hidden" name="last_name" value="<?php echo $billing_last_name;?>">
                                        <input type="hidden" name="address1" value="<?php echo $billing_address_1;?>">
                                        <input type="hidden" name="address2" value="<?php echo $billing_address_2;?>">
                                        <input type="hidden" name="city" value="<?php echo $billing_city;?>">
                                        <input type="hidden" name="state" value="<?php echo $billing_state;?>">
                                        <input type="hidden" name="zip" value="<?php echo $billing_zipcode;?>">
                                        <input type="hidden" name="email" value="<?php echo $customer_email;?>">

                                        <input type="submit" id="paypal-submit" name="submit" value="Proceed with PayPal" class="btn btn-success btn-lg" style="border-radius: 0px;">

                                    </form>

                                </td><!--payment-method-forums-td end -->
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div><!--col-md-4 end -->
        <!--these scripts for the right panel to show the review order summary and choose payment method  end-->


            <?php }?>


        </div>

        <!--//script here-->


    </div>
</div>

<!-- footer start here-->
<?php
include ('includes/footer.php');
?>
</body>
</html>
<script type="text/javascript">
    //function for calculate shipping + tax + total price when user click
    // need to put this function in the buttom of the page
$(document).ready(function(data){
    $(document).on("change",".shipping_type",function () {
        var shipping_cost = Number($(this).data("shipping_cost"));

        var total = Number(<?php echo $total; ?> );

        var tax = Number(<?php echo $tax; ?> );

        var total_cart_price = total + shipping_cost + tax;
        $(".total-cart-price").html("$"+total_cart_price);
    });

});

</script>
