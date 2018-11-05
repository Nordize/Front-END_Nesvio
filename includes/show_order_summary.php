

<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/13/2018
 * Time: 4:35 PM
 */
//////get customer ID/////////////


///////////////////////////////

$total = 0;

$total_weight = 0;

global $db_connect;

$ip_add = getRealUserIp();

$get_items_in_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";

$run_items_in_cart = $db_connect->query($get_items_in_cart);

if ($run_items_in_cart->rowCount() > 0) {
    while ($row_items_in_cart = $run_items_in_cart->fetch(PDO::FETCH_BOTH)) {
        $pro_id = $row_items_in_cart['p_id'];
        $pro_size = $row_items_in_cart['p_size'];
        $pro_qty = $row_items_in_cart['qty'];

        $get_products = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_products = $db_connect->query($get_products);

        if ($run_products->rowCount() > 0) {
            while ($row_products = $run_products->fetch()) {
                $product_id = $row_products['product_id'];
                $product_title = $row_products['product_title'];
                $product_img1 = $row_products['product_img1'];
                $only_price = $row_products['product_price'];
                $pro_psp_price = $row_products['product_psp_price'];
                $pro_label = $row_products['product_label'];

                $product_weight = $row_products['product_weight'];
                $sub_total_weight = $product_weight *$pro_qty;

                $product_weight = sprintf('%.2f',$product_weight);
                $sub_total_weight = sprintf('%.2f',$sub_total_weight);

                $total_weight += $sub_total_weight;
                $total_weight = sprintf('%.2f',$total_weight);


                if($pro_label == "yes"){

                    $product_price = $pro_psp_price;
                    $sub_total = $product_price * $pro_qty;

                }
                else if($pro_label == "no"){

                    $product_price = $only_price;
                    $sub_total = $product_price * $pro_qty;

                }

                $sub_total = $product_price * $pro_qty;

                $product_price = sprintf('%.2f', $product_price);
                $sub_total = sprintf('%.2f', $sub_total);

                $total += $sub_total;
                $total = sprintf('%.2f',$total);

                $tax = $total*0.07;   #Sales Tax in Florida is 7%
                $tax = sprintf('%.2f',$tax);

                $final_total = $total + $tax;
                $final_total = sprintf('%.2f',$final_total);



            }

        }
    }
    echo"
                <tbody><!--tbody start -->
                    <tr>
                        <td>Order Subtotal</td>
                        <th>$$total</th>
                    </tr>
                    <tr>
                        <th colspan='2'>
                            <p class='shipping-header text-muted'>
                                Cart Total Weight: $total_weight Lbs.
                            </p>
                            <p class='shipping-header text-muted'>
                                <i class='fa fa-truck'></i> Shipping:
                            </p>
                            
                            <ul class='list-unstyled'><!--list-unstyled start -->
                                "?>

                                <?php

                                if(isset($_SESSION['customer_username'])) {
                                    $customer_username = $_SESSION['customer_username'];
                                    $get_customer = "SELECT customer_id FROM customer WHERE customer_username = '$customer_username'";
                                    $run_customer = $db_connect->query($get_customer);
                                    $row_customer = $run_customer->fetch();

                                    $customer_id = $row_customer['customer_id'];


                                    $select_customer_addresses = "SELECT * FROM customer_addresses WHERE customer_id='$customer_id'";
                                    $run_customer_addresses = $db_connect->query($select_customer_addresses);
                                    $row_customer_addresses = $run_customer_addresses->fetch();

                                    $billing_country = $row_customer_addresses['billing_country'];
                                    $billing_zipcode = $row_customer_addresses['billing_zipcode'];
                                    $shipping_country = $row_customer_addresses['shipping_country'];
                                    $shipping_zipcode = $row_customer_addresses['shipping_zipcode'];

                                    $shipping_zone_id = ""; //default is blank

                                    //this case for local shipping
                                    if (@$_SESSION['is_shipping_address_same'] == 'yes') {
                                        if (empty($billing_country) and empty($billing_zipcode)) {
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

                                        if ($run_zones->rowCount() > 0) {
                                            while ($row_zones = $run_zones->fetch()) {
                                                $zone_id = $row_zones['zone_id'];
                                                $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$billing_country' AND location_type='country')";
                                                $run_zones_locations = $db_connect->query($select_zones_locations);

                                                $count_zones_locations = $run_zones_locations->fetchColumn();

                                                if ($count_zones_locations != "0") {

                                                    $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$billing_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);

                                                    $row_zones_locations = $run_zones_locations->fetch();
                                                    $zone_id = $row_zones_locations['zone_id'];

                                                    $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                    $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                    $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                    if ($count_zones_shipping != "0") {
                                                        $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                        $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                        $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                        if ($count_zone_postcodes != "0") {
                                                            $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            while ($row_zones_postcodes = $run_zone_postcodes->fetch()) {
                                                                $location_code = $row_zones_postcodes['location_code'];

                                                                if ($location_code == $billing_zipcode) {
                                                                    $shipping_zone_id = $zone_id;
                                                                }
                                                            }

                                                        } else {
                                                            $shipping_zone_id = $zone_id;
                                                        }
                                                    }

                                                }

                                            }
                                        }


                                    } elseif (@$_SESSION['is_shipping_address_same'] == 'no') {
                                        if (empty($shipping_country) and empty($shipping_zipcode)) {
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

                                        if ($run_zones->rowCount() > 0) {
                                            while ($row_zones = $run_zones->fetch()) {
                                                $zone_id = $row_zones['zone_id'];
                                                $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                $run_zones_locations = $db_connect->query($select_zones_locations);

                                                $count_zones_locations = $run_zones_locations->fetchColumn();

                                                if ($count_zones_locations != "0") {

                                                    $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);

                                                    $row_zones_locations = $run_zones_locations->fetch();
                                                    $zone_id = $row_zones_locations['zone_id'];

                                                    $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                    $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                    $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                    if ($count_zones_shipping != "0") {
                                                        $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                        $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                        $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                        if ($count_zone_postcodes != "0") {
                                                            $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            while ($row_zones_postcodes = $run_zone_postcodes->fetch()) {
                                                                $location_code = $row_zones_postcodes['location_code'];

                                                                if ($location_code == $shipping_zipcode) {
                                                                    $shipping_zone_id = $zone_id;
                                                                }
                                                            }

                                                        } else {
                                                            $shipping_zone_id = $zone_id;
                                                        }
                                                    }

                                                }

                                            }
                                        }


                                    } else {

                                        if (empty($shipping_country) and empty($shipping_zipcode)) {
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

                                        if ($run_zones->rowCount() > 0) {
                                            while ($row_zones = $run_zones->fetch()) {
                                                $zone_id = $row_zones['zone_id'];

                                                $select_zones_locations = "SELECT  COUNT(DISTINCT zone_id) FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                $run_zones_locations = $db_connect->query($select_zones_locations);


                                                $count_zones_locations = $run_zones_locations->fetchColumn();

                                                if ($count_zones_locations != "0") {

                                                    $select_zones_locations = "SELECT  DISTINCT zone_id FROM zones_locations WHERE zone_id='$zone_id' AND (location_code ='$shipping_country' AND location_type='country')";
                                                    $run_zones_locations = $db_connect->query($select_zones_locations);

                                                    $row_zones_locations = $run_zones_locations->fetch();
                                                    $zone_id = $row_zones_locations['zone_id'];

                                                    $select_zone_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_zone='$zone_id'";

                                                    $run_zone_shipping = $db_connect->query($select_zone_shipping);

                                                    $count_zones_shipping = $run_zone_shipping->fetchColumn();

                                                    if ($count_zones_shipping != "0") {
                                                        $select_zone_postcodes = "SELECT COUNT(*) FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                        $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                        $count_zone_postcodes = $run_zone_postcodes->fetchColumn();

                                                        if ($count_zone_postcodes != "0") {
                                                            $select_zone_postcodes = "SELECT * FROM zones_locations WHERE zone_id = '$zone_id' AND location_type='postcode'";
                                                            $run_zone_postcodes = $db_connect->query($select_zone_postcodes);

                                                            while ($row_zones_postcodes = $run_zone_postcodes->fetch()) {
                                                                $location_code = $row_zones_postcodes['location_code'];
                                                                if ($location_code == $shipping_zipcode) {
                                                                    $shipping_zone_id = $zone_id;
                                                                }
                                                            }

                                                        } else {
                                                            $shipping_zone_id = $zone_id;
                                                        }
                                                    }

                                                }

                                            }
                                        }
                                    }

                                    if (!empty($shipping_zone_id)) {

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
                                                        <input type="radio" name="shipping_type"
                                                               value="<?php echo $type_id; ?>" class="shipping_type"
                                                               data-shipping_cost="<?php echo $shipping_cost; ?>"
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

                                                        <?php echo $type_name; ?> : <span
                                                                class="text-muted">$ <?php echo $shipping_cost; ?></span>

                                                    </li>


                                                    <?php
                                                }
                                            }
                                        }

                                    } else {
                                        //this case for international shipping

                                        if (!empty($billing_country) or !empty($shipping_country)) {
                                            if (@$_SESSION['is_shipping_address_same'] == "yes") {
                                                $select_country_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_country ='$billing_country'";

                                            } elseif (@$_SESSION['is_shipping_address_same'] == "no") {
                                                $select_country_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_country ='$billing_country'";

                                            } else {
                                                $select_country_shipping = "SELECT COUNT(*) FROM shipping WHERE shipping_country ='$billing_country'";
                                            }

                                            $run_country_shipping = $db_connect->query($select_country_shipping);
                                            $count_country_shipping = $run_country_shipping->fetchColumn();

                                            if ($count_country_shipping = "0") {
                                                echo "
                                            <li>
                                            <p>
                                            There are no shipping types matched/available for your address, or contact us if you need any help.
                                            
                                            </p>
                                            </li>
                                            
                                            
                                            ";


                                            } else {
                                                if (@$_SESSION['is_shipping_address_same'] == "yes") {

                                                    $select_shipping_types = "SELECT *,IF(
                                                                        $total_weight > (
                                                                        SELECT MAX(shipping_weight) FROM shipping WHERE shipping_type = type_id AND shipping_country='$billing_country'),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type=type_id AND shipping_country='$billing_country' ORDER BY shipping_weight DESC LIMIT 0,1),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type = type_id AND shipping_country='$billing_country' AND shipping_weight >= '$total_weight' ORDER BY shipping_weight ASC LIMIT 0,1)
                                                                        
                                                                        ) AS shipping_cost FROM shipping_types WHERE type_local = 'no' ORDER BY type_order ASC";

                                                } elseif (@$_SESSION['is_shipping_address_same'] == "no") {

                                                    $select_shipping_types = "SELECT *,IF(
                                                                        $total_weight > (
                                                                        SELECT MAX(shipping_weight) FROM shipping WHERE shipping_type = type_id AND shipping_country='$shipping_country'),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type=type_id AND shipping_country='$shipping_country' ORDER BY shipping_weight DESC LIMIT 0,1),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type = type_id AND shipping_country='$shipping_country' AND shipping_weight >= '$total_weight' ORDER BY shipping_weight ASC LIMIT 0,1)
                                                                        
                                                                        ) AS shipping_cost FROM shipping_types WHERE type_local = 'no' ORDER BY type_order ASC";


                                                } else {
                                                    $select_shipping_types = "SELECT *,IF(
                                                                        $total_weight > (
                                                                        SELECT MAX(shipping_weight) FROM shipping WHERE shipping_type = type_id AND shipping_country='$billing_country'),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type=type_id AND shipping_country='$billing_country' ORDER BY shipping_weight DESC LIMIT 0,1),
                                                                        (SELECT shipping_cost FROM shipping WHERE shipping_type = type_id AND shipping_country='$billing_country' AND shipping_weight >= '$total_weight' ORDER BY shipping_weight ASC LIMIT 0,1)
                                                                        
                                                                        ) AS shipping_cost FROM shipping_types WHERE type_local = 'no' ORDER BY type_order ASC";

                                                }


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
                                                                <input type="radio" name="shipping_type"
                                                                       value="<?php echo $type_id; ?>"
                                                                       class="shipping_type"
                                                                       data-shipping_cost="<?php echo $shipping_cost; ?>"
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

                                                                <?php echo $type_name; ?> : <span
                                                                        class="text-muted">$ <?php echo $shipping_cost; ?></span>

                                                            </li>


                                                            <?php
                                                        }
                                                    }
                                                }


                                            }

                                        }
                                    }
                                }else
                                {
                                    echo "Please login to see shipping option.";
                                }
                                ?>

                                <?php echo"
                            </ul>
                            
                        </th>
                 
                    </tr>
                    
                    ";?>
                    <?php
                    $total_cart_price = $total + @$_SESSION['shipping_cost'] +$tax;
                    $total_cart_price = sprintf('%.2f',$total_cart_price);

                    ?>

                    <?php echo"
                    <tr>
                       <td>Tax</td>
                        <td>$$tax</td>
                    </tr>
                    <tr class='total'>
                        <td>Total</td>     
                        <th class='total-cart-price'>$$total_cart_price</th>
                    </tr>
                </tbody>
                ";
}



?>
<script type="text/javascript">
    //function for calculate shipping + tax + total price when user click
$(document).ready(function(data){
    $(document).on("change",".shipping_type",function () {
        var shipping_cost = Number($(this).data("shipping_cost"));

        var total = Number(<?php echo $total; ?>);

        var tax = Number(<?php echo $tax; ?>);

        var total_cart_price = total + shipping_cost + tax;
        $(".total-cart-price").html("$"+total_cart_price);
    })

});
</script>
