<?php
include ("admin_includes/dblogin.php");


if(isset($_GET['delete_manufacturer']))
{

    $delete_id = $_GET['delete_manufacturer'];

    $delete_manufacturer = "DELETE FROM manufacturers WHERE manufacturer_id='$delete_id'";

    $run_manufacturer = $db_connect->query($delete_manufacturer);

    if($run_manufacturer) {

        echo "<script>alert('One Manufacturer Has Been Deleted')</script>";
        echo "<script>window.open('view_manufacturers.php','_self')</script>";

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
    <script>tinymce.init({ selector:'textarea' });</script>

</head>
<body>


<div class="row"><!-- 1 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <ol class="breadcrumb"><!-- breadcrumb Starts -->

                <li class="active">

                    <i class="fa fa-dashboard"></i> Dashboard / View Manufacturers/Brand

                </li>

            </ol><!-- breadcrumb Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 1 row Ends -->

    <div class="row"><!-- 2 row Starts -->

        <div class="col-lg-12"><!-- col-lg-12 Starts -->

            <div class="panel panel-default"><!-- panel panel-default Starts -->

                <div class="panel-heading"><!-- panel-heading Starts -->

                    <h3 class="panel-title">

                        <i class="fa fa-money fa-fw"></i> View Manufacturers/Brand

                    </h3>

                </div><!-- panel-heading Ends -->

                <div class="panel-body"><!-- panel-body Starts -->

                    <div class="table-responsive"><!-- table-responsive Starts --->

                        <table class="table table-bordered table-hover table-striped"><!-- table table-bordered table-hover table-striped Starts -->

                            <thead><!-- thead Starts -->

                            <tr>

                                <th>Manufacturer/Brand Id:</th>
                                <th>Manufacturer/Brand Title:</th>
                                <th>Delete Manufacturer/Brand:</th>
                                <th>Edit Manufacturer/Brand:</th>

                            </tr>

                            </thead><!-- thead Ends -->

                            <tbody><!-- tbody Starts -->

                            <?php

                            $i = 0;

                            $get_manufacturers = "SELECT * FROM manufacturers";

                            $run_manufacturers = $db_connect->query($get_manufacturers);

                            if($run_manufacturers->rowCount()>0)
                            {


                                while($row_manufacturers = $run_manufacturers->fetch()){

                                    $manufacturer_id = $row_manufacturers['manufacturer_id'];
                                    $manufacturer_title = $row_manufacturers['manufacturer_title'];

                                    $i++;

                                    ?>

                                    <tr>

                                        <td><?php echo $i; ?></td>

                                        <td><?php echo $manufacturer_title; ?></td>

                                        <td>

                                            <a href="view_manufacturers.php?delete_manufacturer=<?php echo $manufacturer_id; ?>">

                                                <i class="fa fa-trash-o"></i> Delete

                                            </a>

                                        </td>

                                        <td>

                                            <a href="edit_manufacturer.php?edit_manufacturer=<?php echo $manufacturer_id; ?>">

                                                <i class="fa fa-pencil"></i> Edit

                                            </a>

                                        </td>

                                    </tr>

                            <?php }
                            }
                            ?>

                            </tbody><!-- tbody Ends -->

                        </table><!-- table table-bordered table-hover table-striped Ends -->

                    </div><!-- table-responsive Ends --->

                </div><!-- panel-body Ends -->

            </div><!-- panel panel-default Ends -->

        </div><!-- col-lg-12 Ends -->

    </div><!-- 2 row Ends -->

</body>
</html>
