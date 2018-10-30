<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/28/2018
 * Time: 11:21 PM
 */

include ("admin_includes/dblogin.php");

if(isset($_POST['submit']))
{
    $type_name = $_POST['type_name'];
    $type_default = $_POST['type_default'];
    $type_local = $_POST['type_local'];

    if($type_default == "yes")
    {
        $update_type_default = "UPDATE shipping_types SET type_default='no' WHERE type_local ='$type_local'";
        $run_update_type_default = $db_connect->query($update_type_default);
    }

    $select_type_order = "SELECT MAX(type_order) AS type_order FROM shipping_types WHERE type_local ='$type_local'";
    $run_type_order = $db_connect->query($select_type_order);

    if($run_type_order->rowCount()>0)
    {
        $row_type_order = $run_type_order->fetch();
        $type_order = $row_type_order['type_order']+1;

    }

    $insert_shipping_type = "INSERT INTO shipping_types (type_name,type_default,type_local,type_order) VALUES ('$type_name','$type_default','$type_local','$type_order')";
    $run_insert_shipping_type = $db_connect->query($insert_shipping_type);

    if($run_insert_shipping_type)
    {
        echo "
        <script>
        alert('New Shipping Type Has Been Inserted Successfully.');
        window.open('view_shipping_types.php?view_shipping_types','_self');
        </script>
        ";
    }

}


?>


<html>
<head>
    <title>Insert Shipping Zone</title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="../styles/bootstrap.min.css.map" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/chosen.min.css" rel="stylesheet" >

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.min.js"></script>




</head>
<body>
<div class="row"><!-- 1 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <ol class="breadcrumb"><!--breadcrumb start -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Insert Shipping Types
            </li>
        </ol>
    </div>
</div>

<div class="row"><!-- 2 row-->
    <div class="col-lg-12"><!-- col-lg-12 start -->
        <div class="panel panel-default"><!-- panel panel-default start -->
            <div class="panel-heading"><!--panel-heading start -->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Shipping Type
                </h3>
            </div>
            <div class="panel_body"><!--panel_body start -->
                <form class="form-horizontal" method="post"><!-- form-horizontal start-->
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Name</label>
                        <div class="col-md-7">
                            <input type="text" name="type_name" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Default</label>
                        <div class="col-md-7">
                            <label>
                                <input type="radio" name="type_default" value="yes" required> Yes
                            </label>
                            <label>
                                <input type="radio" name="type_default" value="no" required> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Local</label>
                        <div class="col-md-7">
                            <label>
                                <input type="radio" name="type_local" value="yes" required> Yes
                            </label>
                            <label>
                                <input type="radio" name="type_local" value="no" required> No
                            </label>
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Name</label>
                        <div class="col-md-7">
                            <input type="submit" name="submit" class="form-control btn btn-success" value="Insert Shipping Type">
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>




</body>
</html>
