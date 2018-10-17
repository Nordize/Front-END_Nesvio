<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/16/2018
 * Time: 2:14 PM
 */

include ('dblogin.php');

if(!empty($_POST['rating']) && !empty($_POST['itemId']))
{
    $itemId = $_POST['itemId'];
    $userID = 1234567;
    $product_id = 2;
    $user_ip = getRealUserIp();

    $insertRating = "INSERT INTO item_rating (itemId,product_id,userId,ratingNumber,title,comments,created,modified,user_ip) 
                    VALUES (:itemId,:product_id,:userID,:raingNumber,:title,:comments,:create_time,:modified_time,:user_ip)";

    $insertRating_statement = $db_connect->prepare($insertRating);
    $insertRating_statement->execute(array(':itemId'=>$itemId,':product_id'=>$product_id,':userID'=>$userID,':raingNumber'=>$_POST['rating'],':title'=>$_POST['title'],':comments'=>$_POST['comment'],':create_time'=>date("Y-m-d H:i:s"),':modified_time'=>date("Y-m-d H:i:s"),':user_ip'=>$user_ip));

    //check if one new row was created
    if($insertRating_statement->rowCount() == 1){
        $result = "<p style='padding:20px; border: 1px solid gray; color: green;'>Rating Saved!</p>";
    }
}

?>




