<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/13/2018
 * Time: 4:34 PM
 */


$total = 0;

global $db_connect;

$ip_add = getRealUserIp();

$get_items_in_cart = "SELECT * FROM cart WHERE ip_add='$ip_add'";

$run_items_in_cart = $db_connect->query($get_items_in_cart);

if ($run_items_in_cart->rowCount() > 0) {
    while ($row_items_in_cart = $run_items_in_cart->fetch(PDO::FETCH_BOTH)) {
        $pro_id = $row_items_in_cart['p_id'];
        $pro_size = $row_items_in_cart['p_size'];
        $pro_qty = $row_items_in_cart['qty'];

        $get_products = "SELECT * FROM products WHERE product_id='$pro_id'";
        $run_products = $db_connect->query($get_products);

        if ($run_products->rowCount() > 0) {
            while ($row_products = $run_products->fetch()) {
                $product_id = $row_products['product_id'];
                $product_title = $row_products['product_title'];
                $product_img1 = $row_products['product_img1'];
                $pro_psp_price = $row_products['product_psp_price'];
                $pro_label = $row_products['product_label'];

                $only_price = $row_products['product_price'];


                $_SESSION['pro_qty'] = $pro_qty;

                if($pro_label == "yes"){

                    $product_price = $pro_psp_price;
                    $sub_total = $product_price * $pro_qty;

                }
                else if($pro_label == "no"){

                    $product_price = $only_price;
                    $sub_total = $product_price * $pro_qty;

                }

                $product_price = sprintf('%.2f',$product_price);
                $sub_total = sprintf('%.2f',$sub_total);

                $product_price += $sub_total;


                echo "
                    <tbody><!--tbody start -->
                    <tr><!-- tr start -->
                        <td>
                            <img src='admin_area/product_images/$product_img1'>
                        </td>
                        <td>
                            <a href='details.php?pro_id=$product_id'>$product_title</a>
                        </td>
                       
                        <td>
                            <input type='text' name='quantity' value='$_SESSION[pro_qty]' data-product_id='$product_id' class='quantity form-control' style='width: 60px;'>
                        </td>
                       ";?>
                        <?php
                        if($pro_label == "yes"){

                               echo" <td>
                                        $$pro_psp_price
                                    </td>";
                            }
                            else if($pro_label == "no"){

                                echo "<td>
                                        $$only_price
                                     </td>";
                        }
                        ?>
                        <?php echo"<td>
                            $pro_size
                        </td>
                        <td>
                            <input type='checkbox' name='remove[]' value='$pro_id'>
                        </td>
                        <td>
                            $$sub_total
                        </td>
                    </tr>
                    </tbody>
                    
                    ";

            }
        }

    }

}
$total = sprintf('%.2f',$total);
echo"
    <tfoot><!--tfoot start -->
        <tr>
            <th colspan='5'>Total</th>
            <th colspan='2'>$ $total</th>
        </tr>
    </tfoot>
    
    ";

?>