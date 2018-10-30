<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 1:18 AM
 */
session_start();
include ("admin_includes/dblogin.php");


$i = 0;

$types_ids = $_POST['types_ids'];
$type_local = $_POST['type_local'];

foreach ($types_ids as $type_id)
{
    $i++;
    $update_type_order = "UPDATE shipping_types SET type_order ='$i' WHERE type_id='$type_id' AND type_local='$type_local'";

    $run_update_type_order = $db_connect->query($update_type_order);

}


?>

