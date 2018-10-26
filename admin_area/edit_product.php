<?php

include ("admin_includes/dblogin.php");

    if(isset($_GET['edit_product'])){

        $edit_id = $_GET['edit_product'];

        $get_p = "SELECT * FROM products WHERE product_id='$edit_id'";

        $run_edit = $db_connect->query($get_p);

        $row_edit = $run_edit->fetch();

        $p_id = $row_edit['product_id'];
        $p_title = $row_edit['product_title'];
        $p_cat = $row_edit['p_cat_id'];
        $cat = $row_edit['cat_id'];
        $m_id = $row_edit['manufacturer_id'];
        $p_image1 = $row_edit['product_img1'];
        $p_image2 = $row_edit['product_img2'];
        $p_image3 = $row_edit['product_img3'];
        $new_p_image1 = $row_edit['product_img1'];
        $new_p_image2 = $row_edit['product_img2'];
        $new_p_image3 = $row_edit['product_img3'];
        $p_price = $row_edit['product_price'];
        $p_desc = $row_edit['product_desc'];
        $p_keywords = $row_edit['product_keywords'];
        $psp_price = $row_edit['product_psp_price'];
        $p_label = $row_edit['product_label'];

    }

    $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$m_id'";

    $run_manufacturer = $db_connect->query($get_manufacturer);

    $row_manfacturer = $run_manufacturer->fetch();

    $manufacturer_id = $row_manfacturer['manufacturer_id'];

    $manufacturer_title = $row_manfacturer['manufacturer_title'];


    $get_p_cat = "SELECT * FROM product_categories WHERE p_cat_id='$p_cat'";

    $run_p_cat = $db_connect->query($get_p_cat);

    $row_p_cat = $run_p_cat->fetch();

    $p_cat_title = $row_p_cat['p_cat_title'];

    $get_cat = "SELECT * FROM categories WHERE cat_id='$cat'";

    $run_cat = $db_connect->query($get_cat);

    $row_cat = $run_cat->fetch();

    $cat_title = $row_cat['cat_title'];


    if(isset($_POST['update'])){

        $product_title = $_POST['product_title'];
        $product_cat = $_POST['product_cat'];
        $cat = $_POST['cat'];
        $manufacturer_id = $_POST['manufacturer'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_keywords = $_POST['product_keywords'];

        $psp_price = $_POST['psp_price'];

        $product_label = $_POST['product_label'];

        $product_img1 = $_FILES['product_img1']['name'];
        $product_img2 = $_FILES['product_img2']['name'];
        $product_img3 = $_FILES['product_img3']['name'];

        $temp_name1 = $_FILES['product_img1']['tmp_name'];
        $temp_name2 = $_FILES['product_img2']['tmp_name'];
        $temp_name3 = $_FILES['product_img3']['tmp_name'];

        if(empty($product_img1)){

            $product_img1 = $new_p_image1;

        }


        if(empty($product_img2)){

            $product_img2 = $new_p_image2;

        }

        if(empty($product_img3)){

            $product_img3 = $new_p_image3;

        }


        move_uploaded_file($temp_name1,"product_images/$product_img1");
        move_uploaded_file($temp_name2,"product_images/$product_img2");
        move_uploaded_file($temp_name3,"product_images/$product_img3");

        $update_product = "UPDATE products SET p_cat_id='$product_cat',cat_id='$cat',manufacturer_id='$manufacturer_id',date=NOW(),product_title='$product_title',product_img1='$product_img1',product_img2='$product_img2',product_img3='$product_img3',product_price='$product_price',product_psp_price='$psp_price',product_desc='$product_desc',product_keywords='$product_keywords',product_label='$product_label' where product_id='$p_id'";

        $run_product = $db_connect->query($update_product);

        if($run_product){

            echo "<script> alert('Product has been updated successfully') </script>";

            echo "<script>window.open('view_products.php','_self')</script>";

        }

    }



    ?>


    <!DOCTYPE html>

    <html>

    <head>

        <title> Edit Products </title>


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

    <div class="row"><!-- row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"> </i> Dashboard / Edit Products

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- row Ends -->


    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title">

                        <i class="fa fa-money fa-fw"></i> Edit Products

                    </h3>

                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Title </label>

                            <div class="col-md-6" >

                                <input type="text" name="product_title" class="form-control" required value="<?php echo $p_title; ?>">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Select A Manufacturer </label>

                            <div class="col-md-6" >

                                <select name="manufacturer" class="form-control">

                                    <option value="<?php echo $manufacturer_id; ?>">
                                        <?php echo $manufacturer_title; ?>
                                    </option>

                                    <?php

                                    $get_manufacturer = "SELECT * FROM manufacturers";

                                    $run_manufacturer = $db_connect->query($get_manufacturer);

                                    while($row_manfacturer = $run_manufacturer->fetch()){

                                        $manufacturer_id = $row_manfacturer['manufacturer_id'];

                                        $manufacturer_title = $row_manfacturer['manufacturer_title'];

                                        echo "
                                            <option value='$manufacturer_id'>
                                            $manufacturer_title
                                            </option>
                                            ";

                                    }

                                    ?>

                                </select>

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Category </label>

                            <div class="col-md-6" >

                                <select name="product_cat" class="form-control" >

                                    <option value="<?php echo $p_cat; ?>" > <?php echo $p_cat_title; ?> </option>


                                    <?php

                                    $get_p_cats = "SELECT * FROM product_categories";

                                    $run_p_cats = $db_connect->query($get_p_cats);

                                    while ($row_p_cats=$run_p_cats->fetch()) {

                                        $p_cat_id = $row_p_cats['p_cat_id'];

                                        $p_cat_title = $row_p_cats['p_cat_title'];

                                        echo "<option value='$p_cat_id' >$p_cat_title</option>";

                                    }


                                    ?>


                                </select>

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Category </label>

                            <div class="col-md-6" >


                                <select name="cat" class="form-control" >

                                    <option value="<?php echo $cat; ?>" > <?php echo $cat_title; ?> </option>

                                    <?php

                                    $get_cat = "SELECT * FROM categories ";

                                    $run_cat = $db_connect->query($get_cat);

                                    while ($row_cat=$run_cat->fetch()) {

                                        $cat_id = $row_cat['cat_id'];

                                        $cat_title = $row_cat['cat_title'];

                                        echo "<option value='$cat_id'>$cat_title</option>";

                                    }

                                    ?>


                                </select>

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Image 1 </label>

                            <div class="col-md-6" >

                                <input type="file" name="product_img1" class="form-control" >
                                <br><img src="product_images/<?php echo $p_image1; ?>" width="70" height="70" >

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Image 2 </label>

                            <div class="col-md-6" >

                                <input type="file" name="product_img2" class="form-control" >
                                <br><img src="product_images/<?php echo $p_image2; ?>" width="70" height="70" >

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Image 3 </label>

                            <div class="col-md-6" >

                                <input type="file" name="product_img3" class="form-control" >
                                <br><img src="product_images/<?php echo $p_image3; ?>" width="70" height="70" >

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Price </label>

                            <div class="col-md-6" >

                                <input type="text" name="product_price" class="form-control" required value="<?php echo $p_price; ?>" >

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Sale Price </label>

                            <div class="col-md-6" >

                                <input type="text" name="psp_price" class="form-control" required value="<?php echo $psp_price; ?>">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Keywords </label>

                            <div class="col-md-6" >

                                <input type="text" name="product_keywords" class="form-control" required value="<?php echo $p_keywords; ?>" >

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group"><!-- form-group start-->
                            <label class="col-md-3 control-label"> Product Description</label>
                            <div class="col-md-6">
                                <textarea name="product_desc" class="form-control" rows="6" cols="19">
                                    <?php echo $p_desc;?>
                                </textarea>
                            </div>
                        </div><!-- form-group end-->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" > Product Label (Please type 'yes' or 'no')</label>

                            <div class="col-md-6" >

                                <input type="text" name="product_label" class="form-control" required value="<?php echo $p_label; ?>">

                            </div>

                        </div><!-- form-group Ends -->

                        <div class="form-group" ><!-- form-group Starts -->

                            <label class="col-md-3 control-label" ></label>

                            <div class="col-md-6" >

                                <input type="submit" name="update" value="Update Product" class="btn btn-primary form-control" >

                            </div>

                        </div><!-- form-group Ends -->

                    </form><!-- form-horizontal Ends -->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->




    </body>

    </html>


