<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 1:06 PM
 */

session_start();
include ("admin_includes/dblogin.php");


if(isset($_POST['shipping_id']))
{
    $shipping_id = $_POST['shipping_id'];
    $type_id = $_POST['type_id'];
    $delete_shipping_rate ="DELETE FROM shipping WHERE shipping_id='$shipping_id' AND shipping_type='$type_id'";
    $run_delete_shipping_rate = $db_connect->query($delete_shipping_rate);
}




?>



