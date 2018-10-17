<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 7:20 PM
 */

include_once ('__DIR__/../../includes/dblogin.php')

?>

<div class="panel panel-default sidebar-menu"><!-- panel panel-default sidebar-menu-->
    <div class="panel-heading"><!--panel-heading -->
        <center>

            <!--<img src="/ecom_store/customer/customer_images/demo_user.png" class="img-responsive"> -->
            <?php
            if(isset($_SESSION['customer_username'])) {
                $customer_username = $_SESSION['customer_username'];
                $query_pic = "SELECT customer_image FROM customer WHERE customer_username = '$customer_username'";

                $run_query_pic = $db_connect->query($query_pic);

                if ($run_query_pic->rowCount() > 0) {
                    while ($row_query_pic = $run_query_pic->fetch()) {
                        $user_pic = $row_query_pic['customer_image'];
                        echo $user_pic;
                        if(empty($user_pic))
                        {

                            echo "<img src='__DIR__/../customer_images/demo_user.png' class='img-responsive'>";
                        }
                        else{
                            $user_pic = $row_query_pic['customer_image'];
                            echo "<img src='__DIR__/../customer_images/$user_pic' class='img-responsive'>";
                        }


                    }
                }
            }
            ?>
        </center>

        <br>

        <h3 align="center" class="panel-title">
            <?php
            if(!isset($_SESSION['customer_username']))
            {
                echo "Welcome: Guest";
            }
            else{
                echo"Welcome: ".$_SESSION['customer_username']."";
            }
            ?>
        </h3>
    </div>

    <div class="panel-body"><!--panel-body -->
        <ul class="nav nav-pills nav-stacked"><!--nav nav-pills nav-stacked start -->
            <li class="<?php if(isset($_GET['my_orders'])){echo "active";}?>">
                <a href="my_account.php?my_orders"><i class="fa fa-list"></i> My Orders </a>
            </li>

          <!--  <li class="<?php if(isset($_GET['pay_offline'])){echo "active";}?>">
                <a href="my_account.php?pay_offline"><i class="fa fa-bolt"></i> Pay Offline </a> -->
            </li>
            <li class="<?php if(isset($_GET['edit_account'])){echo "active";}?>">
                <a href="my_account.php?edit_account"><i class="fa fa-pencil"></i>Edit Account</a>
            </li>
            <li class="<?php if(isset($_GET['change_pass'])){echo "active";}?>">
                <a href="my_account.php?change_pass"><i class="fa fa-user"></i>Change Password</a>
            </li>
            <li class="<?php if(isset($_GET['delete_account'])){echo "active";}?>">
                <a href="my_account.php?delete_account"><i class="fa fa-trash-o"></i>Delete Account</a>
            </li>
            <li >
                <a href="__DIR__/../../logout.php"><i class="fa fa-sign-out"></i>Logout</a>
            </li>

        </ul>
    </div>


</div>

