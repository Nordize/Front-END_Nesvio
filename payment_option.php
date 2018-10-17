<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/15/2018
 * Time: 9:43 PM
 */

$session_username = $_SESSION['customer_username'];

$select_customer = "SELECT * FROM customer WHERE customer_username = '$session_username'";
$run_customer = $db_connect->query($select_customer);

if($run_customer->rowCount() >0)
{
    while($row_customer = $run_customer->fetch(PDO::FETCH_BOTH))
    {
        $customer_id = $row_customer['customer_id'];
    }


}


?>

<div class="box"><!--box start -->
    <h1 class="text-center">Please choose your payment option.</h1>
    <p class="lead text-center"></p>
    <a href="order.php?c_id=<?php echo $customer_id;?>">Paypal</a>
    <p class="lead"></p>
    <a href="order.php?c_id=<?php echo $customer_id;?>">Credit cards</a>
</div>