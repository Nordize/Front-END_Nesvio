<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/28/2018
 * Time: 9:56 PM
 */
session_start();
include ("admin_includes/dblogin.php");

$i = 0;

$zones_ids = $_POST['zones_ids'];

foreach ($zones_ids as $zones_id)
{
    $i++;
    $update_zone_order = "UPDATE zones SET zone_order='$i' WHERE zone_id='$zones_id'";

    $run_update_zone_order = $db_connect->query($update_zone_order);

}



?>



