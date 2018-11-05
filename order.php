<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/16/2018
 * Time: 1:02 AM
 */


include ('includes/dblogin.php');
include ('functions/functions.php');

if(isset($_SESSION['customer_username']))
{
    $customer_username = $_SESSION['customer_username'];
    $ip_add = getRealUserIp();

    $get_customer = "SELECT * FROM customer WHERE customer_username = '$customer_username'";
    $run_customer = $db_connect->query($get_customer);

    if($run_customer->rowCount()>0)
    {
        $row_customer = $run_customer->fetch();

        $customer_id = $row_customer['customer_id'];

        $stripe_amount = $_POST['strip_total_amount'];

        $shipping_type = $_SESSION['shipping_type'];
        $shipping_cost = $_SESSION['shipping_cost'];

        $is_shipping_address_name = $_SESSION['is_shipping_address_name'];

        $select_shipping_type = "SELECT * FROM shipping_types WHERE type_id = '$shipping_type'";
        $run_shipping_type = $db_connect->query($select_shipping_type);
        $row_shipping_type = $run_shipping_type->fetch();

        $shipping_type_name = $row_shipping_type['type_name'];

        #--------------------------------------------------------------
        $select_customers_addresses = "SELECT * FROM customer_addresses WHERE customer_id = '$customer_id'";
        $run_customers_addresses = $db_connect->query($select_customers_addresses);

        if($run_customers_addresses->rowCount()>0) {
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

            date_default_timezone_set("America/New_York"); #set default time zone = NYC

            $order_date = date("F d, Y h:i");

            $payment_method = "Stripe";

            $status ="pending";

            $invoice_no = mt_rand();

            $insert_order = "INSERT INTO orders (customer_id,invoice_no,shipping_cost,payment_method,order_date,order_total,order_status)
                            VALUES ('$customer_id','$invoice_no','$shipping_type_name','$shipping_cost','$atripe_amount','$status')";

            $run_order = $db_connect->query($insert_order);

            #$last_order_id =  <-not done yet


        }

    }

}



?>


