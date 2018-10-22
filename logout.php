<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/15/2018
 * Time: 9:07 PM
 */
include_once ('resources/utilities.php');

session_start();

session_destroy();

echo "<script>window.open('admin_index.php','_self')</script>";



?>

