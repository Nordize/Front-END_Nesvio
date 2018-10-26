<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/26/2018
 * Time: 12:42 AM
 */


session_start();

include("dblogin.php");

include("../functions/functions.php");

$ip_add = getRealUserIp();

if(isset($_POST['id'])){

    $id = $_POST['id'];
    $qty = $_POST['quantity'];

    $change_qty = "UPDATE cart SET qty='$qty' where p_id='$id' AND ip_add='$ip_add'";

    $run_qty = $db_connect->query($change_qty);


}




?>

