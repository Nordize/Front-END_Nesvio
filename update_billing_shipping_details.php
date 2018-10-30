<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 11:03 PM
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
        $ip_add = getRealUserIp();


    }
    //billing details start
    $billing_first_name = $_POST['billing_first_name'];
    $billing_last_name = $_POST['billing_last_name'];
    $billing_country = $_POST['billing_country'];
    $billing_address_1 = $_POST['billing_address_1'];
    $billing_address_2 = $_POST['billing_address_2'];
    $billing_state = $_POST['billing_state'];
    $billing_city = $_POST['billing_city'];
    $billing_zipcode = $_POST['billing_zipcode'];
    $is_shipping_address_same = $_POST['is_shipping_address_same'];

    //shipping detail start
    $shipping_first_name = $_POST['shipping_first_name'];
    $shipping_last_name = $_POST['shipping_last_name'];
    $shipping_country = $_POST['shipping_country'];
    $shipping_address_1 = $_POST['shipping_address_1'];
    $shipping_address_2 = $_POST['shipping_address_2'];
    $shipping_state = $_POST['shipping_state'];
    $shipping_city = $_POST['shipping_city'];
    $shipping_zipcode = $_POST['shipping_zipcode'];

    $update_billing_address = "UPDATE customer_addresses SET 
    billing_first_name='$billing_first_name',
    billing_last_name='$billing_last_name',
    billing_country='$billing_country',
    billing_address_1='$billing_address_1',
    billing_address_2='$billing_address_2',
    billing_state='$billing_state',
    billing_city='$billing_city',
    billing_zipcode='$billing_zipcode'
    WHERE customer_id='$customer_id'";

    $run_update_billing_address = $db_connect->query($update_billing_address);

    $shipping_type = $_POST['shipping_type'];
    $payment_method = $_POST['payment_method'];

    $_SESSION["is_shipping_address_same"] = $is_shipping_address_same;
    $_SESSION["shipping_type"] = $shipping_type;
    $_SESSION["payment_method"] = $payment_method;

    if($is_shipping_address_same == "no")
    {
        $shipping_first_name = $_POST['shipping_first_name'];
        $shipping_last_name = $_POST['shipping_last_name'];
        $shipping_country = $_POST['shipping_country'];
        $shipping_address_1 = $_POST['shipping_address_1'];
        $shipping_address_2 = $_POST['shipping_address_2'];
        $shipping_state = $_POST['shipping_state'];
        $shipping_city = $_POST['shipping_city'];
        $shipping_zipcode = $_POST['shipping_zipcode'];

        $update_shipping_address = "UPDATE customer_addresses SET
        shipping_first_name='$shipping_first_name',
        shipping_last_name='$shipping_last_name',
        shipping_country='$shipping_country',
        shipping_address_1='$shipping_address_1',
        shipping_address_2='$shipping_address_2',
        shipping_state='$shipping_state',
        shipping_city='$shipping_city',
        shipping_zipcode='$shipping_zipcode'
        WHERE customer_id='$customer_id'";

        $run_update_shipping_address = $db_connect->query($update_shipping_address);


    }

}

?>


