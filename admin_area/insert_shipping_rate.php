<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 11:53 AM
 */
session_start();
include ("admin_includes/dblogin.php");

$type_id = $_POST['type_id'];
$shipping_weight = $_POST['shipping_weight'];
$shipping_cost = $_POST['shipping_cost'];

if(isset($_POST['zone_id']))
{
    $zone_id = $_POST['zone_id'];
    $insert_shipping_rate = "INSERT INTO shipping (shipping_type,shipping_zone,shipping_weight,shipping_cost) VALUES ('$type_id','$zone_id','$shipping_weight','$shipping_cost')";
    $run_insert_shipping_rate = $db_connect->query($insert_shipping_rate);

}elseif (isset($_POST['country_id']))
{
    $country_id = $_POST['country_id'];
    $insert_shipping_rate = "INSERT INTO shipping (shipping_type,shipping_country,shipping_weight,shipping_cost) VALUES ('$type_id','$country_id','$shipping_weight','$shipping_cost')";
    $run_insert_shipping_rate = $db_connect->query($insert_shipping_rate);

}




?>


