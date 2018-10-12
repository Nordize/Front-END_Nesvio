<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 9:21 PM
 */

$username = 'root';
$dsn = 'mysql:host=localhost;dbname=ecom_store';
$password ='';

try{
    $db_connect = new PDO($dsn,$username,$password);

    $db_connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    // echo "Coonected to the register database";
}catch (PDOException $ex)
{
    echo "Connection Failed ".$ex->getMessage();
}


?>

