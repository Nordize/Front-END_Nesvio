<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/12/2018
 * Time: 11:47 AM
 */

include ("admin_includes/dblogin.php");

if(isset($_POST['submit']))
{
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $cat = $_POST['cat'];
    $manufacturer_id = $_POST['manufacturer'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keywords = $_POST['product_keywords'];
    $psp_price = $_POST['psp_price'];
    $product_label = $_POST['product_label'];
    $product_weight = $_POST['product_weight'];

    $product_img1 = $_FILES['product_img1']['name'];
    $product_img2 = $_FILES['product_img2']['name'];
    $product_img3 = $_FILES['product_img3']['name'];

    $temp_name1 = $_FILES['product_img1']['tmp_name'];
    $temp_name2 = $_FILES['product_img2']['tmp_name'];
    $temp_name3 = $_FILES['product_img3']['tmp_name'];

    move_uploaded_file($temp_name1,"product_images/$product_img1");
    move_uploaded_file($temp_name2,"product_images/$product_img2");
    move_uploaded_file($temp_name3,"product_images/$product_img3");

    $insert_product = "INSERT INTO products (p_cat_id,cat_id,manufacturer_id,date,product_title,product_img1,product_img2,product_img3,product_price,product_psp_price,product_desc,product_weight,product_keywords,product_label) VALUES ('$product_cat','$cat','$manufacturer_id',NOW(),'$product_title','$product_img1','$product_img2','$product_img3','$product_price','$psp_price','$product_desc','$product_weight','$product_keywords','$product_label')";

    $run_product = $db_connect->query($insert_product);

    if ($run_product->rowCount() >0) {
        echo "<script>alert('Product have been inserted successfully.')</script>";
        echo "<script>window.open('insert_product.php','_self')</script>";

    }
}

?>

<html>
    <head>
        <title>Insert Products</title>
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
        <script>tinymce.init({ selector:'textarea' });</script>

    </head>
    <body>
    <div class="row"><!-- row Start-->
        <div class="col-lg-12"><!--col-lg-12 start -->
            <ol class="breadcrumb"><!--breadcrumb start -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Insert Products
                </li>
            </ol>
        </div>
    </div>

    <div class="row"><!--2 row start -->
        <div class="col-lg-12"><!-- col-lg-12-->
            <div class="panel panel-default"><!--panel panel-default start -->
                <div class="panel-heading"><!--panel-heading start -->
                    <h3 class="panel-title">
                       <i class="fa fa-money fa-fw"></i> Insert Products
                    </h3>
                </div>
                <div class="panel-body"><!--panel-body -->
                    <form class="form-horizontal" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data"><!--form-horizontal -->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Title</label>
                            <div class="col-md-6">
                                <input type="text" name="product_title" class="form-control" required>
                            </div>
                        </div><!-- form-group end-->


                        <div class="form-group" ><!-- form-group Starts -->
                            <label class="col-md-3 control-label" > Select A Manufacturer </label>
                            <div class="col-md-6" >
                                <select class="form-control" name="manufacturer"><!-- select manufacturer Starts -->

                                    <option> Select A Manufacturer </option>

                                    <?php

                                    $get_manufacturer = "select * from manufacturers";
                                    $run_manufacturer = $db_connect->query($get_manufacturer);
                                    if($run_manufacturer->rowCount()>0)
                                    {
                                        while($row_manufacturer= $run_manufacturer->fetch()){
                                            $manufacturer_id = $row_manufacturer['manufacturer_id'];
                                            $manufacturer_title = $row_manufacturer['manufacturer_title'];

                                            echo "<option value='$manufacturer_id'>$manufacturer_title </option>";

                                        }
                                    }


                                    ?>
                                </select><!-- select manufacturer Ends -->
                            </div>
                        </div><!-- form-group Ends -->


                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Category</label>
                            <div class="col-md-6">
                                <select name="product_cat" class="form-control">
                                    <option> Select a Product Category</option>
                                    <?php
                                        $get_p_cats = "SELECT * FROM product_categories";
                                        $run_p_cats = $db_connect->query($get_p_cats);

                                        if ($run_p_cats->rowCount() >0) {
                                            while($row_p_cats = $run_p_cats->fetch()){
                                                $p_cat_id = $row_p_cats['p_cat_id'];
                                                $p_cat_title = $row_p_cats['p_cat_title'];

                                                echo "<option value='$p_cat_id'>$p_cat_title</option>";
                                            }
                                        }

                                    ?>
                                </select>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Category</label>
                            <div class="col-md-6">
                                <select name="cat" class="form-control">
                                    <option> Select a Cetegory </option>
                                    <?php
                                        $get_cat = "SELECT * FROM categories";

                                        $run_cat = $db_connect->query($get_cat);
                                        if ($run_cat->rowCount() >0) {
                                            while($row_cat = $run_cat->fetch()){
                                                $cat_id = $row_cat['cat_id'];
                                                $cat_title = $row_cat['cat_title'];

                                                echo"<option value='$cat_id'>$cat_title</option>";
                                            }
                                        }
                                    ?>

                                </select>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Image1</label>
                            <div class="col-md-6">
                                <input type="file" name="product_img1" class="form-control" required>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Image2</label>
                            <div class="col-md-6">
                                <input type="file" name="product_img2" class="form-control" required>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Imgage3</label>
                            <div class="col-md-6">
                                <input type="file" name="product_img3" class="form-control" required>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Weight (lb.)</label>
                            <div class="col-md-6">
                                <input type="text" name="product_weight" class="form-control" >
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Price</label>
                            <div class="col-md-6">
                                <input type="text" name="product_price" class="form-control" required>
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group" ><!-- form-group Starts -->
                            <label class="col-md-3 control-label" > Product Sale Price </label>
                            <div class="col-md-6" >
                                <input type="text" name="psp_price" class="form-control" >
                            </div>
                        </div>
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Keywords (Please use comma ( , ) as delimeter to seperate your keywords.)</label>
                            <div class="col-md-6">
                                <input type="text" name="product_keywords" class="form-control">
                            </div>
                        </div><!-- form-group end-->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Description</label>
                            <div class="col-md-6">
                                <textarea name="product_desc" class="form-control" rows="6" cols="19"></textarea>
                            </div>
                        </div><!-- form-group end-->

                        <div class="form-group" ><!-- form-group Starts -->
                            <label class="col-md-3 control-label" > Product Label (Please type 'Sale' or 'sale' to labeled it as sale product, Default is blank)</label>
                            <div class="col-md-6" >
                                <input type="radio" name="product_label" value="no" checked="checked" > No, I don't want to labeled as 'Sale' on this product.<br>
                                <input type="radio" name="product_label" value="yes" > Yes, I want to label as 'Sale' on this product.<br>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6">
                                <input type="submit" name="submit" value="Insert Product" class="btn btn-primary form-control">
                            </div>
                        </div><!-- form-group end-->

                    </form>
                </div>
            </div>
        </div>
    </div>

    </body>
</html>
