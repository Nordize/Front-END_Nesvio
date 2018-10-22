<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/21/2018
 * Time: 6:39 PM
 */


session_start();

include("includes/dblogin.php");

include("functions/functions.php");

switch($_REQUEST['sAction']){

    default :

        getProducts();

        break;

    case'getPaginator';

        getPaginator();

        break;

}



?>


