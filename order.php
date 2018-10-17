<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/16/2018
 * Time: 1:02 AM
 */


include ('includes/dblogin.php');
include ('functions/functions.php');

if(isset($_GET['c_id']))
{
    $customer_id = $_GET['c_id'];
}

$ip_add = getRealUserIp();
$status = "Pending";
$invoice_no = mt_rand();

$select_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";

$run_cart = $db_connect->query($select_cart);

if($run_cart->rowCount() >0)
{
    while($row_cart = $run_cart->fetch(PDO::FETCH_BOTH))
    {
        $pro_id = $row_cart['p_id'];
        $pro_size = $row_cart['p_size'];
        $pro_qty = $row_cart['qty'];

        $get_products = "SELECT * FROM products WHERE product_id = '$pro_id'";

        $run_products = $db_connect->query($get_products);

        if($run_products->rowCount() >0)
        {
            while($row_products = $run_products->fetch(PDO::FETCH_BOTH))
            {
                $sub_total = $row_products['product_price']*$pro_qty;

                $insert_customer_order = "INSERT INTO customer_orders (customer_id,due_amount,invoice_no,qty,size,order_date,order_status) 
                                          VALUES (:customer_id,:due_amount,:invoice_no,:qty,:size,NOW(),:order_status)";

                $run_customer_order = $db_connect->prepare($insert_customer_order);
                $run_customer_order->execute(array(':customer_id'=>$customer_id,':due_amount'=>$sub_total,':invoice_no'=>$invoice_no,':qty'=>$pro_qty,':size'=>$pro_size,':order_status'=>$status));

                $insert_pending_order = "INSERT INTO pending_orders (customer_id,invoice_no,product_id,qty,size,order_status) 
                                        VALUES(:customer_id,:invoice_no,:product_id,:qty,:size,:order_status)";
                $run_pending_order = $db_connect->prepare($insert_pending_order);
                $run_pending_order->execute(array(':customer_id'=>$customer_id,':invoice_no'=>$invoice_no,':product_id'=>$pro_id,':qty'=>$pro_qty,':size'=>$pro_size,':order_status'=>$status));

                $delete_cart = "DELETE FROM cart WHERE ip_add = '$ip_add'";
                $db_connect->exec($delete_cart);

                echo "<script>alert('Your order has been submitted, Thanks')</script>";
                echo "<script>window.open('customer/my_account.php?my_orders','_self')</script>";

            }
        }

    }


}



?>


