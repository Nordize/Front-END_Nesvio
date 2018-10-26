<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/12/2018
 * Time: 12:51 PM
 */

#include ('__DIR__/../includes/dblogin.php');
require_once ('C:/xampp/htdocs/ecom_store/includes/dblogin.php');

#get IP ADDRESS function start
function getRealUserIp()
{
    switch (true)
    {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default : return $_SERVER['REMOTE_ADDR'];
    }
}

# add to cart function start
function add_cart()
{
    global $db_connect;

    if(isset($_GET['add_cart']))
    {
        $ip_add = getRealUserIp();
        $p_id = $_GET['add_cart'];

        $product_qty = $_POST['product_qty'];
        $product_size = $_POST['product_size'];

        $get_price = "SELECT * FROM products WHERE product_id='$p_id'";
        $run_price = $db_connect->query($get_price);
        $row_price = $run_price->fetch();

        try{
            $query_cart = "INSERT INTO cart (p_id,ip_add,qty,p_size) VALUES ('$p_id','$ip_add','$product_qty','$product_size')";

            $db_connect->exec($query_cart);
            $db_connect = null;

            echo"<script>window.open('details.php?pro_id=$p_id','_self')</script>";
        }catch(PDOException $e)
        {
            echo $query_cart . "<br>" . $e->getMessage();
        }




    }
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


#item_in_cart function start
function items_in_cart()
{
    global $db_connect;

    $ip_add = getRealUserIp();

    $get_items_in_cart = "SELECT COUNT(*) FROM cart WHERE ip_add='$ip_add'";

    $run_items_in_cart = $db_connect->query($get_items_in_cart);

    $count_items_in_cart = $run_items_in_cart->fetchColumn();

    echo $count_items_in_cart;
}



#get today deal function start
function get_today_deal()
{
    global $db_connect;
    //show first 8 items
    $get_products = "SELECT * FROM products ORDER BY 1 DESC LIMIT 0,8";

    $run_products = $db_connect->query($get_products);

    if ($run_products->rowCount() >0) {
        while($row_products = $run_products->fetch()){
            $pro_id = $row_products['product_id'];

            $pro_title = $row_products['product_title'];

            $pro_price = $row_products['product_price'];

            $pro_img1 = $row_products['product_img1'];

            $pro_label = $row_products['product_label'];

            $manufacturer_id = $row_products['manufacturer_id'];

            $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";

            $run_manufacturer = $db_connect->query($get_manufacturer);

            $row_manufacturer = $run_manufacturer->fetch();

            $manufacturer_name = $row_manufacturer['manufacturer_title'];

            $pro_psp_price = $row_products['product_psp_price'];

            $pro_price = sprintf('%.2f',$pro_price);
            $pro_psp_price = sprintf('%.2f',$pro_psp_price);

            //if label is SALE
            if($pro_label == "yes"){

                $product_price = "<del> $$pro_price </del>";

                $product_psp_price = "| $$pro_psp_price";

                $product_label = "
                                    <div class='box_sale'>
                                        <div class='ribbon'><span>Sale</span>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                        </div>
                                    </div>
                                        
                                        ";


            }
            else if($pro_label == "no"){

                $product_psp_price = "";

                $product_price = "$$pro_price";

                $product_label = "
                                    <div class='box_sale'>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                      
                                    </div>
                                        ";

            }



            echo "

                                <div class='col-md-3 col-sm-6 center-responsive' >
                                    <div class='product' >
                                    
                                        $product_label
                                    
                                    <div class='text' >
                                
                                    <center>
                                    
                                        <p class='btn btn-primary'> $manufacturer_name </p>
                                    
                                    </center>
                                
                                     <hr>
                                
                                    <h3><a href='details.php?pro_id=$pro_id' >$pro_title</a></h3>
                                
                                    <p class='price' > $product_price $product_psp_price </p>
                                    
                                    <p class='buttons' >
                                    
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-default' >View details</a>
                                        
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
                                    
                                            <i class='fa fa-shopping-cart'></i> Add to cart                         
                                        </a>
                                     </p>
                                
                                </div>                         
                            </div>
                            
                            </div>
                            
                            ";

        }
    }

}

#function update_cart start
function update_cart()
{
    global $db_connect;

    if(isset($_POST['update']))
    {
        if(isset($_POST['remove']))
        {
            foreach ($_POST['remove'] as $remove_id)
            {
                $delete_product = "DELETE FROM cart WHERE p_id ='$remove_id'";

                $run_delete = $db_connect->query($delete_product);

                if($run_delete)
                {
                    echo"<script>window.open('cart.php','_self')</script>";
                }
            }
        }

    }

}
echo @$up_cart = update_cart();




function getProducts(){

/// getProducts function Code Starts ///

    global $db_connect;

    $aWhere = array();

/// Manufacturers Code Starts ///

    if(isset($_REQUEST['man'])&&is_array($_REQUEST['man'])){

        foreach($_REQUEST['man'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'manufacturer_id='.(int)$sVal;

            }

        }

    }

/// Manufacturers Code Ends ///

/// Products Categories Code Starts ///

    if(isset($_REQUEST['p_cat'])&&is_array($_REQUEST['p_cat'])){

        foreach($_REQUEST['p_cat'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'p_cat_id='.(int)$sVal;

            }

        }

    }

/// Products Categories Code Ends ///

/// Categories Code Starts ///

    if(isset($_REQUEST['cat'])&&is_array($_REQUEST['cat'])){

        foreach($_REQUEST['cat'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'cat_id='.(int)$sVal;

            }

        }

    }

/// Categories Code Ends ///

    $per_page=6;


    if(isset($_GET['page'])){

        $page = $_GET['page'];

    }else {

        $page=1;

    }

    $start_from = ($page-1) * $per_page ;

    $sLimit = " order by 1 DESC LIMIT $start_from,$per_page";

    $sWhere = (count($aWhere)>0?' WHERE '.implode(' or ',$aWhere):'').$sLimit;

    $get_products = "SELECT * FROM products  ".$sWhere;

    $run_products = $db_connect->query($get_products);

    while($row_products=$run_products->fetch()){

        $pro_id = $row_products['product_id'];

        $pro_title = $row_products['product_title'];

        $pro_price = $row_products['product_price'];

        $pro_img1 = $row_products['product_img1'];

        $pro_label = $row_products['product_label'];

        $manufacturer_id = $row_products['manufacturer_id'];

        $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";

        $run_manufacturer = $db_connect->query($get_manufacturer);

        $row_manufacturer = $run_manufacturer->fetch();

        $manufacturer_name = $row_manufacturer['manufacturer_title'];

        $pro_psp_price = $row_products['product_psp_price'];

       // $pro_url = $row_products['product_url'];


        //if label is SALE
        if($pro_label == "yes"){

            $product_price = "<del> $$pro_price </del>";

            $product_psp_price = "| $$pro_psp_price";

            $product_label = "
                                    <div class='box_sale'>
                                        <div class='ribbon'><span>Sale</span>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                        </div>
                                    </div>
                                        
                                        ";


        }
        else if($pro_label == "no"){

            $product_psp_price = "";

            $product_price = "$$pro_price";

            $product_label = "
                                    <div class='box_sale'>
                                        <a href='details.php?pro_id=$pro_id' >
                                            
                                                <img src='admin_area/product_images/$pro_img1' class='img-responsive' >
                                            
                                            </a>
                                      
                                    </div>
                                        ";

        }



        echo "

                                <div class='col-md-4 col-sm-6 center-responsive' >
                                    <div class='product' >
                                    
                                        $product_label
                                    
                                    <div class='text' >
                                
                                    <center>
                                    
                                        <p class='btn btn-primary'> $manufacturer_name </p>
                                    
                                    </center>
                                
                                     <hr>
                                
                                    <h3><a href='details.php?pro_id=$pro_id' >$pro_title</a></h3>
                                
                                    <p class='price' > $product_price $product_psp_price </p>
                                    
                                    <p class='buttons' >
                                    
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-default' >View details</a>
                                        
                                        <a href='details.php?pro_id=$pro_id' class='btn btn-primary'>
                                    
                                            <i class='fa fa-shopping-cart'></i> Add to cart                         
                                        </a>
                                     </p>
                                
                                </div>                         
                            </div>
                            
                            </div>
                            
                            ";

    }
/// getProducts function Code Ends ///

}


/// getProducts Function Ends ///


/// getPaginator Function Starts ///

function getPaginator(){

/// getPaginator Function Code Starts ///

    $per_page = 6;

    global $db_connect;

    $aWhere = array();

    $aPath = '';

/// Manufacturers Code Starts ///

    if(isset($_REQUEST['man'])&&is_array($_REQUEST['man'])){

        foreach($_REQUEST['man'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'manufacturer_id='.(int)$sVal;

                $aPath .= 'man[]='.(int)$sVal.'&';

            }

        }

    }

/// Manufacturers Code Ends ///

/// Products Categories Code Starts ///

    if(isset($_REQUEST['p_cat'])&&is_array($_REQUEST['p_cat'])){

        foreach($_REQUEST['p_cat'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'p_cat_id='.(int)$sVal;

                $aPath .= 'p_cat[]='.(int)$sVal.'&';

            }

        }

    }

/// Products Categories Code Ends ///

/// Categories Code Starts ///

    if(isset($_REQUEST['cat'])&&is_array($_REQUEST['cat'])){

        foreach($_REQUEST['cat'] as $sKey=>$sVal){

            if((int)$sVal!=0){

                $aWhere[] = 'cat_id='.(int)$sVal;

                $aPath .= 'cat[]='.(int)$sVal.'&';

            }

        }

    }

/// Categories Code Ends ///

    $sWhere = (count($aWhere)>0?' WHERE '.implode(' or ',$aWhere):'');

    $query = "SELECT COUNT(*) FROM products ".$sWhere;

    $result = $db_connect->query($query);

    $total_records = $result->fetchColumn();

    $total_pages = ceil($total_records / $per_page);

    echo "<li><a href='shop.php?page=1";

    if(!empty($aPath)){ echo "&".$aPath; }

    echo "' >".'First Page'."</a></li>";

    for ($i=1; $i<=$total_pages; $i++){

        echo "<li><a href='shop.php?page=".$i.(!empty($aPath)?'&'.$aPath:'')."' >".$i."</a></li>";

    };

    echo "<li><a href='shop.php?page=$total_pages";

    if(!empty($aPath)){ echo "&".$aPath; }

    echo "' >".'Last Page'."</a></li>";

/// getPaginator Function Code Ends ///

}

/// getPaginator Function Ends ///
?>

