<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 9:32 PM
 */


require_once('__DIR__/../vendor/autoload.php');

$stripe = array(
    "secret_key"      => "sk_live_xxxxxxxxxxxxxxxxxxxxxxxx",
    "publishable_key" => "pk_live_xxxxxxxxxxxxxxxxxxxxxxxx"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

?>



