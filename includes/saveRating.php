<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/18/2018
 * Time: 12:29 AM
 */
session_start();
include ('dblogin.php');
include ('../functions/functions.php');

if(isset($_SESSION['customer_username'])) {
    $customer_username = $_SESSION['customer_username'];
    //echo $customer_username;
    $rating = $_POST['rating'];
    $title = $_POST['title'];
    $comment = $_POST['comment'];
    $product_id = $_POST['pro_id'];

    //echo $rating;
    //echo $title;
    //echo $comment;

    $query_userID = "SELECT customer_id FROM customer WHERE customer_username = '$customer_username'";
    $run_query_userID = $db_connect->query($query_userID);

    if ($run_query_userID->rowCount() > 0) {
        while ($row_query_userID = $run_query_userID->fetch()) {
            $userID = $row_query_userID['customer_id'];

            $user_ip = getRealUserIp();
            $status = 1;  #default by 1 = Block, 0 =Unblock

            echo "do inserting here";
            $insertRating = "INSERT INTO item_rating (product_id,userId,ratingNumber,title,comments,created_time,status,user_ip) VALUES (:product_id,:userId,:ratingNumber,:title,:comments,NOW(),:status,:user_ip)";
            $insertRating_statement = $db_connect->prepare($insertRating);
            $insertRating_statement->execute(array(':product_id' => $product_id, ':userId' => $userID, ':ratingNumber' => $rating, ':title' => $title, ':comments' => $comment, ':status' => $status, ':user_ip' => $user_ip));

            //check if one new row was created
            if ($insertRating_statement->rowCount() == 1) {
                echo "<script>alert('Rating Save!');</script>";
            } else {
                echo "<script>alert('error!');</script>";
            }


        }
    }


}else
{
    $message = 'PLease login';
    echo "<script type='text/javascript'>alert('$message');</script>";
}



?>

