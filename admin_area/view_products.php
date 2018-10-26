<?php
include ("admin_includes/dblogin.php");

if(isset($_GET['delete_product'])){

    $delete_id = $_GET['delete_product'];

    $delete_pro = "DELETE FROM products WHERE product_id='$delete_id'";

    $run_delete = $db_connect->query($delete_pro);

    if($run_delete){

        echo "<script>alert('One Product Has been deleted')</script>";

        echo "<script>window.open('view_products.php','_self')</script>";

    }

}




?>

<html>
<head>
    <title>View Manufacturer/Brand</title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="../styles/bootstrap.min.css.map" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>

</head>
<body>

    <div class="row"><!--  1 row Starts -->

        <div class="col-lg-12" ><!-- col-lg-12 Starts -->

            <ol class="breadcrumb" ><!-- breadcrumb Starts -->

                <li class="active" >

                    <i class="fa fa-dashboard"></i> Dashboard / View Products

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!--  1 row Ends -->

    <div class="row" ><!-- 2 row Starts -->

        <div class="col-lg-12" ><!-- col-lg-12 Starts -->

            <div class="panel panel-default" ><!-- panel panel-default Starts -->

                <div class="panel-heading" ><!-- panel-heading Starts -->

                    <h3 class="panel-title" ><!-- panel-title Starts -->

                        <i class="fa fa-money fa-fw" ></i> View Products

                    </h3><!-- panel-title Ends -->


                </div><!-- panel-heading Ends -->

                <div class="panel-body" ><!-- panel-body Starts -->

                    <div class="table-responsive" ><!-- table-responsive Starts -->

                        <table class="table table-bordered table-hover table-striped" ><!-- table table-bordered table-hover table-striped Starts -->

                            <thead>

                            <tr>
                                <th>Product ID</th>
                                <th>Product Title</th>
                                <th>Product Image</th>
                                <th>Product Weight (lb.)</th>
                                <th>Product Price</th>
                                <th>Product Label (Sale ot not)</th>
                                <th>Product Sale Price</th>
                                <th>Product sold</th>
                                <th>Product Keywords</th>
                                <th>Product Date</th>
                                <th>Product Delete</th>
                                <th>Product Edit</th>

                            </tr>

                            </thead>

                            <tbody>

                            <?php

                            $i = 0;

                            $get_pro = "SELECT * FROM products";

                            $run_pro = $db_connect->query($get_pro);

                            if($run_pro->rowCount()>0)
                            {
                            while($row_pro=$run_pro->fetch()){

                                $pro_id = $row_pro['product_id'];

                                $pro_title = $row_pro['product_title'];

                                $pro_image = $row_pro['product_img1'];

                                $pro_price = $row_pro['product_price'];

                                $pro_psp_price = $row_pro['product_psp_price'];

                                $pro_label = $row_pro['product_label'];

                                $pro_weight = $row_pro['product_weight'];

                                $pro_keywords = $row_pro['product_keywords'];

                                $pro_date = $row_pro['date'];

                                $i++;

                                ?>

                                <tr>

                                    <td><?php echo $i; ?></td>

                                    <td><?php echo $pro_title; ?></td>

                                    <td><img src="product_images/<?php echo $pro_image; ?>" width="60" height="60"></td>

                                    <td><?php echo $pro_weight; ?></td>

                                    <td>$ <?php echo $pro_price; ?></td>

                                    <td> <?php echo $pro_label; ?></td>

                                    <td>$ <?php echo $pro_psp_price; ?></td>

                                    <td>
                                        <?php

                                        $get_sold = "SELECT * FROM pending_orders WHERE product_id='$pro_id'";
                                        $run_sold = $db_connect->query($get_sold);
                                        $count = $run_sold->fetchColumn();
                                        echo $count;
                                        ?>
                                    </td>

                                    <td> <?php echo $pro_keywords; ?> </td>

                                    <td><?php echo $pro_date; ?></td>

                                    <td>

                                        <a href="view_products.php?delete_product=<?php echo $pro_id; ?>">

                                            <i class="fa fa-trash-o"> </i> Delete

                                        </a>

                                    </td>

                                    <td>

                                        <a href="edit_product.php?edit_product=<?php echo $pro_id; ?>">

                                            <i class="fa fa-pencil"> </i> Edit

                                        </a>

                                    </td>

                                </tr>

                            <?php }
                            }?>



                            </tbody>


                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

</body>
</html>
