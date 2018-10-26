<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 4:52 PM
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

        $(document).ready(function(){

        /// Hide And Show Code Starts ///

            $('.nav-toggle').click(function(){

                $(".panel-collapse,.collapse-data").slideToggle(700,function(){

                    if($(this).css('display')=='none'){

                        $(".hide-show").html('Show');

                    }
                    else{

                        $(".hide-show").html('Hide');

                    }

                });

            });

            /// Hide And Show Code Ends ///

            /// Search Filters code Starts ///

            $(function(){

                $.fn.extend({

                    filterTable: function(){

                        return this.each(function(){

                            $(this).on('keyup', function(){

                                var $this = $(this),

                                    search = $this.val().toLowerCase(),

                                    target = $this.attr('data-filters'),

                                    handle = $(target),

                                    rows = handle.find('li a');

                                if(search == '') {

                                    rows.show();

                                } else {

                                    rows.each(function(){

                                        var $this = $(this);

                                        $this.text().toLowerCase().indexOf(search) === -1 ? $this.hide() : $this.show();

                                    });

                                }

                            });

                        });

                    }

                });

                $('[data-action="filter"][id="dev-table-filter"]').filterTable();

            });

            /// Search Filters code Ends ///

        });



    </script>


    <script>


        $(document).ready(function(){

            // getProducts Function Code Starts

            function getProducts(){

                // Manufacturers Code Starts

                var sPath = '';

                var aInputs = $('li').find('.get_manufacturer');

                var aKeys = Array();

                var aValues = Array();

                iKey = 0;

                $.each(aInputs,function(key,oInput){

                    if(oInput.checked){

                        aKeys[iKey] =  oInput.value

                    };

                    iKey++;

                });

                if(aKeys.length>0){

                    var sPath = '';

                    for(var i = 0; i < aKeys.length; i++){

                        sPath = sPath + 'man[]=' + aKeys[i]+'&';

                    }

                }

                // Manufacturers Code ENDS

                // Products Categories Code Starts

                var aInputs = Array();

                var aInputs = $('li').find('.get_p_cat');

                var aKeys = Array();

                var aValues = Array();

                iKey = 0;

                $.each(aInputs,function(key,oInput){

                    if(oInput.checked){

                        aKeys[iKey] =  oInput.value

                    };

                    iKey++;

                });

                if(aKeys.length>0){

                    for(var i = 0; i < aKeys.length; i++){

                        sPath = sPath + 'p_cat[]=' + aKeys[i]+'&';

                    }

                }

                // Products Categories Code ENDS

                // Categories Code Starts

                var aInputs = Array();

                var aInputs = $('li').find('.get_cat');

                var aKeys  = Array();

                var aValues = Array();

                iKey = 0;

                $.each(aInputs,function(key,oInput){

                    if(oInput.checked){

                        aKeys[iKey] =  oInput.value

                    };

                    iKey++;

                });

                if(aKeys.length>0){

                    for(var i = 0; i < aKeys.length; i++){

                        sPath = sPath + 'cat[]=' + aKeys[i]+'&';

                    }

                }

                // Categories Code ENDS

                // Loader Code Starts

                $('#wait').html('<img src="images/load.gif">');

                // Loader Code ENDS

                // ajax Code Starts

                $.ajax({

                    url:"load.php",

                    method:"POST",

                    data: sPath+'sAction=getProducts',

                    success:function(data){

                        $('#Products').html('');

                        $('#Products').html(data);

                        $("#wait").empty();

                    }

                });

                $.ajax({
                    url:"load.php",
                    method:"POST",
                    data: sPath+'sAction=getPaginator',
                    success:function(data){
                        $('.pagination').html('');
                        $('.pagination').html(data);
                    }

                });

            // ajax Code Ends

            }

            // getProducts Function Code Ends

            $('.get_manufacturer').click(function(){

                getProducts();

            });


            $('.get_p_cat').click(function(){

                getProducts();

            });

            $('.get_cat').click(function(){

                getProducts();

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
                    Shop
                </li>
            </ul>
        </div> <!--col-md-12 end-->
        <!--Sidebar here -->
        <div class="col-md-3"><!-- col-md-3 Starts -->

            <?php include("includes/sidebar.php"); ?>

        </div><!-- col-md-3 Ends -->
        <!--Sidebar end -->
        <div class="col-md-9"><!-- col-md-9 start-->
            <?php
                if(!isset($_GET['p_cat']))
                {
                    if(!isset($_GET['cat']))
                    {
                        echo"
                        <div class='box'>
                            <h1>Shop</h1>
                            <p>TEST detail for shop</p>
                        </div>
                        ";
                    }
                }
            ?>


            <div class="row" id="Products" ><!-- row Starts -->

                <?php getProducts(); ?>

            </div><!-- row Ends -->

            <center><!-- center Starts -->

                <ul class="pagination" ><!-- pagination Starts -->

                    <?php getPaginator(); ?>

                </ul><!-- pagination Ends -->

            </center><!-- center Ends -->



        </div><!-- col-md-9 Ends --->

        <div id="wait" style="position:absolute;top:40%;left:45%;padding:100px;padding-top:200px;"><!--- wait Starts -->

        </div><!--- wait Ends -->

    </div><!-- container Ends -->
</div><!-- content Ends -->


<!-- footer start here-->
<?php
include ('includes/footer.php');
?>

</body>
</html>
