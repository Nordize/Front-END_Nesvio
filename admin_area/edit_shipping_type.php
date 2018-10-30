<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 1:28 AM
 */


include ("admin_includes/dblogin.php");


if(isset($_GET['edit_shipping_type']))
{
    $edit_type_id = $_GET['edit_shipping_type'];
    $get_shipping_type = "SELECT * FROM shipping_types WHERE type_id='$edit_type_id'";

    $run_shipping_type = $db_connect->query($get_shipping_type);
    if($run_shipping_type->rowCount()>0)
    {
        while ($row_shipping_type = $run_shipping_type->fetch())
        {
            $type_name = $row_shipping_type['type_name'];
            $type_default = $row_shipping_type['type_default'];
            $type_local = $row_shipping_type['type_local'];
        }
    }
}



if(isset($_POST['update']))
{
    $type_name = $_POST['type_name'];
    $type_default = $_POST['type_default'];

    if($type_default == "yes")
    {
        $update_type_default = "UPDATE shipping_types SET type_default='no' WHERE type_local ='$type_local'";
        $run_update_type_default = $db_connect->query($update_type_default);
    }

    $update_shipping_type = "UPDATE shipping_types SET type_name='$type_name',type_default='$type_default' WHERE type_id='$edit_type_id' ";

    $run_update_shipping_type = $db_connect->query($update_shipping_type);

    if($run_update_shipping_type)
    {
        echo"
        <script>
        alert('Your Shipping Type Has Been Updated Successfully.');
        window.open('view_shipping_types.php?view_shipping_types','_self');
        </script>
        ";
    }



}


?>

<html>
<head>
    <title>Edit Shipping Type</title>
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
                <i class="fa fa-dashboard"></i> Dashboard / Edit Shipping Types
            </li>
        </ol>
    </div>
</div>

<div class="row"><!-- 2 row-->
    <div class="col-lg-12"><!-- col-lg-12 start -->
        <div class="panel panel-default"><!-- panel panel-default start -->
            <div class="panel-heading"><!--panel-heading start -->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Edit Shipping Type
                </h3>
            </div>
            <div class="panel_body"><!--panel_body start -->
                <form class="form-horizontal" method="post"><!-- form-horizontal start-->
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Name</label>
                        <div class="col-md-7">
                            <input type="text" name="type_name" class="form-control" value="<?php echo $type_name; ?>" required>
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Default</label>
                        <div class="col-md-7">
                            <label>
                                <input type="radio" name="type_default" value="yes" required
                                <?php
                                if($type_default=="yes") {echo "checked";}
                                ?>
                                > Yes
                            </label>
                            <label>
                                <input type="radio" name="type_default" value="no" required
                                    <?php
                                    if($type_default=="no") {echo "checked";}
                                    ?>
                                > No
                            </label>
                        </div>
                    </div>

                    <div class="form-group"><!--form-group start-->
                        <label class="col-md-3 control-label">Type Name</label>
                        <div class="col-md-7">
                            <input type="submit" name="update" class="form-control btn btn-success" value="Update Shipping Type">
                        </div>
                    </div>
                </form>
            </div>


        </div>
    </div>
</div>




</body>
</html>

