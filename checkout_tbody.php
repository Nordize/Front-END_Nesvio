<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/30/2018
 * Time: 12:02 AM
 */

session_start();
include ('includes/dblogin.php');
include ('functions/functions.php');

if(isset($_SESSION['customer_username']))
{
    $customer_username = $_SESSION['customer_username'];

    $get_customer = "SELECT * FROM customer WHERE customer_username = '$customer_username'";
    $run_customer = $db_connect->query($get_customer);

    if($run_customer->rowCount()>0) {
        $row_customer = $run_customer->fetch();

        $customer_id = $row_customer['customer_id'];

        $select_customers_addresses = "SELECT * FROM customer_addresses WHERE customer_id = '$customer_id'";
        $run_customers_addresses = $db_connect->query($select_customers_addresses);

        if ($run_customers_addresses->rowCount() > 0) {
            $row_customers_addresses = $run_customers_addresses->fetch();

            $billing_country = $row_customers_addresses['billing_country'];
            $billing_zipcode = $row_customers_addresses['billing_zipcode'];

            $shipping_country = $row_customers_addresses['shipping_country'];
            $shipping_zipcode = $row_customers_addresses['shipping_zipcode'];

            $ip_add = getRealUserIp();

        }
    }
?>
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
                                        if (@$_SESSION["shipping_type"] == $type_id) {
                                            $_SESSION["shipping_type"] = $type_id;
                                            $_SESSION["shipping_cost"] = $shipping_cost;

                                            echo "checked";


                                        } elseif ($i == 1) {

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
            <input id="stripe-radio" type="radio" name="payment_method" value="stripe"
            <?php if(@$_SESSION["payment_method"] == "stripe") {echo "checked";}?>
            >
            <label for="stripe-radio">Credit Card (Stripe)</label>
            <p id="stripe-desc" class="text-muted">
                Pay with your credit card via Stripe.
            </p>
        </th>
    </tr>
    <tr>
        <th colspan="2">
            <input id="paypal-radio" type="radio" name="payment_method" value="paypal"
                <?php if(@$_SESSION["payment_method"] == "paypal") {echo "checked";}?>
            >
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

    <script type="text/javascript">
    $(document).ready(function(){
        //script for payment method
        $("#stripe-desc").hide();
        $("#stripe-form").hide();
        $("#paypal-desc").hide();
        $("#paypal-form").hide();

        <?php if(@$_SESSION["payment_method"] == "stripe") { ?>
            $("#stripe-desc").show();
            $("#stripe-form").show();
            $("#paypal-desc").hide();
            $("#paypal-form").hide();
        });
        <?php } elseif (@$_SESSION["payment_method"] == "paypal") {?>
            $("#stripe-desc").hide();
            $("#stripe-form").hide();
            $("#paypal-desc").show();
            $("#paypal-form").show();
        });
        <?php }?>

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

<?php
}
?>


