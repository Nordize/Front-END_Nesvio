<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/13/2018
 * Time: 3:04 PM
 */


function getRealUserIp(){
    switch(true){
        case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default : return $_SERVER['REMOTE_ADDR'];
    }
}
/// IP address code Ends /////

// items function Starts ///

function items_in_cart(){

    global $db_connect;

    $ip_add = getRealUserIp();

    $get_items_in_cart = "SELECT COUNT(*) FROM cart WHERE ip_add='$ip_add'";

    $run_items_in_cart = $db_connect->query($get_items_in_cart);

    $count_items_in_cart = $run_items_in_cart->fetchColumn();

    echo $count_items_in_cart;

}

#total price function start
function total_price()
{
    global $db_connect;
    $ip_add = getRealUserIp();

    $total =0;

    $select_cart = "SELECT * FROM cart WHERE ip_add = '$ip_add'";

    $run_cart = $db_connect->query($select_cart);

    while($record = $run_cart->fetch(PDO::FETCH_BOTH))
    {
        $pro_id = $record['p_id'];
        $pro_qty = $record['qty'];
        $get_price = "SELECT * FROM products WHERE product_id = '$pro_id'";

        $run_price = $db_connect->query($get_price);

        while($row_price = $run_price->fetch(PDO::FETCH_BOTH))
        {
            $sub_total = $row_price['product_price']*$pro_qty;
            $total += $sub_total;
        }




    }
    echo"$".$total;
}

# get_product_category start
function get_product_category()
{
    global $db_connect;

    $get_p_cats = "SELECT * FROM product_categories";
    $run_p_cats = $db_connect->query($get_p_cats);

    if ($run_p_cats->rowCount() >0) {
        while($row_p_cats = $run_p_cats->fetch()){
            $p_cat_id = $row_p_cats['p_cat_id'];
            $p_cat_title = $row_p_cats['p_cat_title'];

            echo "<li><a href='../shop.php?p_cat=$p_cat_id'> $p_cat_title </a></li>";
        }
    }

}
#get_category start
function get_category()
{
    global $db_connect;

    $get_cats = "SELECT * FROM categories";

    $run_cats = $db_connect->query($get_cats);

    if ($run_cats->rowCount() >0) {
        while($row_cats = $run_cats->fetch()){
            $cat_id = $row_cats['cat_id'];
            $cat_title = $row_cats['cat_title'];

            echo"<li><a href='../shop.php?cat=$cat_id'>$cat_title</a></li>";
        }
    }

}

?>
