<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/15/2018
 * Time: 9:42 PM
 */
include ('__DIR__/../../includes/dblogin.php');
include ('__DIR__/../../resources/utilities.php');


if(isset($_POST['loginBtn']));
{

    //array to hold error
    $form_errors = array();


    if(empty($form_errors))
    {
        error_reporting(~E_NOTICE);
        //collect form data
        $customer_username = $_POST['username'];
        $customer_pass = $_POST['password'];
        $get_ip = getRealUserIp();

        //check if user exist in the database
        $sqlQuery = "SELECT * FROM customer WHERE customer_username = :username";
        $statement = $db_connect->prepare($sqlQuery);
        $statement->execute(array(':username'=>$customer_username));

        //check cart with IP
        $select_cart = "SELECT COUNT(*) FROM cart WHERE ip_add='$get_ip'";
        $run_cart = $db_connect->query($select_cart);
        $check_cart = $run_cart->fetchColumn();

        while($row = $statement->fetch())
        {
            $id = $row['customer_id'];
            $hashed_password = $row['customer_pass'];
            $username = $row['customer_username'];

            //using PHP password varify function
            if(password_verify($customer_pass,$hashed_password) AND $check_cart ==0)  //if matched result is true
            {
                $_SESSION['customer_username'] = $username;

                echo "<script>alert('You are Logged In')</script>";

                echo"<script>window.open('customer/my_account.php?my_order','_self')</script>";

                //redirectTo('../checkout.php');
            }
            else if(password_verify($customer_pass,$hashed_password) AND $check_cart ==1)
            {
                $_SESSION['customer_username'] = $username;

                echo "<script>alert('You are Logged In')</script>";

                echo"<script>window.open('__DIR__/../checkout.php','_self')</script>";
            }
            else if(!password_verify($customer_pass,$hashed_password))
            {
                $result = flashMessage("Invalid username or password");
            }

        }


    }else
    {
        if(count($form_errors) == 1)
        {
            $result = flashMessage("There was one error in the form");

        }
        else
        {
            $result = flashMessage("There were ".count($form_errors)." error in the form");
        }
    }


}

?>


<div class="box"><!--box -->
    <div class="box-header" style="margin: -30px -30px -30px;"><!--box-header -->
        <center>
            <h1>Login</h1>
            <p class="lead">Already our Customer? Please login to your account.</p>
        </center>
        <?php if(isset($result)) echo $result;?>
        <?php if(!empty($form_errors)) echo show_errors($form_errors)?>
        <form action="__DIR__/../checkout.php" method="post"><!--form start -->
            <div class="form-group"><!--form-group start -->
                <label>Username:</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="form-group"><!--form-group start -->
                <label>Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="checkbox">
                <label>
                    <input name="rememberUserCookie" value="yes" type="checkbox"> Remember Me
                </label>
            </div>
            <div class="text-center"><!--text-center start -->
                <button name="loginBtn" value="Login" class="btn btn-primary">
                    <i class="fa fa-sign-in"></i> Login
                </button>
            </div>
        </form>
        <center><!--center start -->
            <a href="__DIR__/../customer_register.php">
                <h3>New customer? Please register here.</h3>
            </a>
        </center>
    </div>
</div>
