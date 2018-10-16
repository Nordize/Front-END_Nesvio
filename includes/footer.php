<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 3:52 PM
 */

include ('includes/dblogin.php');

?>

<div id="footer"><!--footer start-->
    <div class="container"><!-- container start-->
        <div class="row"><!--row start-->
            <div class="col-md-3 col-sm-6"><!--col-md-3 col-sm-6 start-->
                <h4>Pages</h4>
                <ul><!-- ul start-->
                    <li><a href="cart.php">Shopping Cart</a></li>
                    <li><a href="contact.php">Contact Us</a> </li>
                    <li><a href="shop.php">Shop</a> </li>
                    <li><a href="__DIR__/../customer/my_account.php">My Account</a> </li>
                </ul>
                <hr>
                <h4>User Section</h4>
                <ul><!-- ul start-->
                    <li><a href="checkout.php">Login</a> </li>
                    <li><a href="customer_register.php">Register</a> </li>
                </ul>
                <hr class="hidden-md hidden-lg hidden-sm">
            </div>

            <div class="col-md-3 col-sm-6"><!--col-md-3 col-sm-6-->
                <h4>Top Products Categories</h4>
                <ul><!--ul start-->
                    <?php
                        $get_p_cats = "SELECT * FROM product_categories";

                        $run_p_cats = $db_connect->query($get_p_cats);

                        if ($run_p_cats->rowCount() >0) {
                            while($row_p_cats = $run_p_cats->fetch()){
                                $p_cat_id = $row_p_cats['p_cat_id'];
                                $p_cat_title = $row_p_cats['p_cat_title'];

                                echo"<li><a href='shop.php?p_cat=$p_cat_id'> $p_cat_title </a> </li>";

                            }
                        }

                    ?>
                </ul>

                <hr class="hidden-md hidden-lg">

            </div>

            <div class="col-md-3 col-sm-6"><!--col-md-3 col-sm-6-->
                <h4>Where to find us</h4>

                <p>
                    <strong>Nesvio Inc,</strong>
                    <br>Address1
                    <br>Address2
                    <br>Phone#
                    <br>Email
                    <br>
                    <strong>Name Lastname</strong>
                </p>

                <a href="../contact.php">Go to Contact us page</a>

                <hr class="hidden-md hidden-lg">
            </div>

            <div class="col-md-3 col-sm-6"><!-- col-md-3 col-sm-6 start -->
                <h4>Get the news</h4>
                <p class="text-muted">news information here.</p>

                <span>NEED TO IMPLEMENT EMAIL SUBSCRIPTION LATER!!! at SEC 5, LEC 107 </span>
                <!--NEED TO IMPLEMENT EMAIL SUBSCRIPTION LATER!!! -->
                <form action="" method="post"><!-- form start-->
                    <div class="input-group"><!--input-group start-->
                        <input type="text" class="form-control" name="email">
                        <span class="input-group-btn"><!--input-group-btn -->
                            <input type="submit" value="subscribe" class="btn btn-default">

                        </span>
                    </div>
                </form>
                <hr>
                <h4>Stay in touch</h4>
                <p class="social"><!-- social start-->
                    <a href="#"><i class="fa fa-facebook"></i></a>
                    <a href="#"><i class="fa fa-twitter"></i></a>
                    <a href="#"><i class="fa fa-instagram"></i></a>
                    <a href="#"><i class="fa fa-google-plus"></i></a>
                    <a href="#"><i class="fa fa-envelope"></i></a>
                </p>

            </div>

        </div>
    </div>
</div>


<div id="copyright"><!-- copyright start -->
    <div class="container"><!-- container start -->
        <div class="col-md-6"><!--col-md-6 start -->
            <p class="pull-left">&copy; 2018 Nesvio Inc,</p>
        </div>
        <div class="col-md-6"><!--col-md-6 start -->
            <p class="pull-right">
                Template by <a href="http://nesvio.com">Nesvio.com</a>
            </p>
        </div>
    </div>
</div>