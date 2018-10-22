<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 8:36 PM
 */

$customer_username = $_SESSION['customer_username'];

if(isset($_POST['yes']))
{
    $delete_customer = "DELETE FROM customer WHERE customer_username = '$customer_username'";
    $run_delete = $db_connect->exec($delete_customer);

    if($run_delete)
    {
        session_destroy();
        echo "<script>alert('Your Account Has Been Deleted, Good Bye')</script>";
        echo"<script>window.open(admiadmin_index.phphp,'_self')</script>";
    }
}
else if(isset($_POST['no']))
{
    echo "<script>window.open('my_account.php?my_orders','_self')</script>";
}

?>

<center>
    <h1>Do you really want to delete your account?</h1>
    <form action="" method="post">
        <input class="btn btn-danger" type="submit" name="yes" value="Yes, I want to delete">
        <input class="btn btn-primary" type="submit" name="no" value="No, I don't want to delete">
    </form>
</center>

