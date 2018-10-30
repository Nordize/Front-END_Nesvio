<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 12:37 AM
 */

include ("admin_includes/dblogin.php");

if(isset($_GET['delete_shipping_type'])){

    $delete_id = $_GET['delete_shipping_type'];

    $delete_shipping_type = "DELETE FROM shipping_types WHERE type_id ='$delete_id'";

    $run_delete_shipping_type = $db_connect->query($delete_shipping_type);


    if($run_delete_shipping_type){

        $delete_shipping = "DELETE FROM shipping WHERE shipping_type='$delete_id'";
        $run_delete_shipping = $db_connect->query($delete_shipping);

        echo"
        <script>
        alert('Your Shipping Type Has Been Deleted Successfully.');
        window.open('view_shipping_types.php','_self');
        </script>
        ";

    }

}



?>

<html>
<head>
    <title>Insert Shipping Types</title>
    <link href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300,100" rel="stylesheet">
    <link href="../styles/bootstrap.min.css.map" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="../styles/style.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/chosen.min.css" rel="stylesheet" >
    <link href="css/jquery-ui.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chosen.jquery.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on("mouseenter","tr td:first-child",function(){
                $(this).css("cursor","move");
                $(".local-types tbody").sortable({
                    helper:fixWidthHelper,
                    placeholder: "placeholder-highlight",
                    containment: ".local-types tbody",
                    update: function(){
                        var types_ids = new Array();

                        $(".local-types tbody tr").each(function(){
                            type_id = $(this).attr("id");
                            types_ids.push(type_id);
                        });
                        $.ajax({
                            url: "update_type_order.php",
                            method: "POST",
                            data: {types_ids: types_ids,type_local:"yes"}
                        });
                    }
                }).disableSelection();
                function fixWidthHelper(e,ui){
                    ui.children().each(function () {
                        $(this).width($(this).width());

                    });
                    return ui;
                }
            });
            //international
            $(document).on("mouseenter","tr td:first-child",function(){
                $(this).css("cursor","move");
                $(".international-types tbody").sortable({
                    helper:fixWidthHelper,
                    placeholder: "placeholder-highlight",
                    containment: ".international-types tbody",
                    update: function(){
                        var types_ids = new Array();

                        $(".international-types tbody tr").each(function(){
                            type_id = $(this).attr("id");
                            types_ids.push(type_id);
                        });
                        $.ajax({
                            url: "update_type_order.php",
                            method: "POST",
                            data: {types_ids: types_ids,type_local:"no"}
                        });
                    }
                }).disableSelection();
                function fixWidthHelper(e,ui){
                    ui.children().each(function () {
                        $(this).width($(this).width());

                    });
                    return ui;
                }
            });

            $("select").change(function(){
                var option = $(this).find("option:selected");

                var url = option.data("url");
                window.open(url);
            })


        });
    </script>

</head>
<body>

<div class="row"><!-- 1 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <ol class="breadcrumb"><!--breadcrumb start -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Shipping Types
            </li>
        </ol>
    </div>
</div>

<div class="row"><!--2 row start -->
    <div class="col-lg-12"><!--col-lg-12 start-->
        <div class="panel panel-default"><!--panel panel-default start -->
            <div class="panel-heading"><!--panel-heading -->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> View Shipping Types
                </h3>
            </div>

            <div class="panel-body"><!--panel-body start -->
                <p class="lead">Shipping Local Types</p>
                <table class="table table-hover table-bordered table-striped local-types"><!--table table-hover table-bordered table-striped local-types start -->
                    <thead>
                    <tr>
                        <th>Type Order:</th>
                        <th>Type Name:</th>
                        <th>Type Rates:</th>
                        <th>Type Default:</th>
                        <th>Actions:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select_shipping_types = "SELECT * FROM shipping_types WHERE type_local='yes' ORDER BY type_order";
                    $run_shipping_types = $db_connect->query($select_shipping_types);

                    if($run_shipping_types->rowCount()>0)
                    {
                        while ($row_shipping_types = $run_shipping_types->fetch())
                        {
                            $type_id = $row_shipping_types['type_id'];
                            $type_name = $row_shipping_types['type_name'];
                            $type_default = $row_shipping_types['type_default'];
                            $type_order = $row_shipping_types['type_order'];


                        ?>
                            <tr id="<?php echo $type_id;?>">
                                <td><?php echo $type_order;?></td>
                                <td><?php echo $type_name;?></td>
                                <td>
                                    <select class="form-control">
                                        <option class="hidden">Edit Shipping Rates</option>
                                        <?php
                                        $get_zones = "SELECT * FROM zones ORDER BY zone_order";
                                        $run_zones = $db_connect->query($get_zones);

                                        if($run_zones->rowCount()>0)
                                        {
                                            while ($row_zones = $run_zones->fetch())
                                            {
                                                $zone_id = $row_zones['zone_id'];
                                                $zone_name = $row_zones['zone_name'];

                                                echo"
                                                <option data-url='edit_shipping_rates.php?edit_shipping_rates=$type_id&zone_id=$zone_id'>
                                                $zone_name
                                                </option>
                                                ";
                                            }
                                        }

                                        ?>

                                    </select>
                                </td>
                                <td><?php echo ucfirst($type_default);?></td>
                                <td>
                                    <div class="dropdown"><!--dropdown start -->
                                        <p>
                                            <a href="edit_shipping_type.php?edit_shipping_type=<?php echo $type_id;?>">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="view_shipping_types.php?delete_shipping_type=<?php echo $type_id;?>">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </p>

                                    </div>
                                </td>
                            </tr>

                    <?php
                        }
                    }

                    ?>

                    </tbody>


                </table>
                <!--international start here -->
                <p class="lead">Shipping International Types</p>
                <table class="table table-hover table-bordered table-striped international-types"><!--table table-hover table-bordered table-striped international-types start -->
                    <thead>
                    <tr>
                        <th>Type Order:</th>
                        <th>Type Name:</th>
                        <th>Type Rates:</th>
                        <th>Type Default:</th>
                        <th>Actions:</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $select_shipping_types = "SELECT * FROM shipping_types WHERE type_local='no' ORDER BY type_order";
                    $run_shipping_types = $db_connect->query($select_shipping_types);

                    if($run_shipping_types->rowCount()>0)
                    {
                        while ($row_shipping_types = $run_shipping_types->fetch())
                        {
                            $type_id = $row_shipping_types['type_id'];
                            $type_name = $row_shipping_types['type_name'];
                            $type_default = $row_shipping_types['type_default'];
                            $type_order = $row_shipping_types['type_order'];


                            ?>
                            <tr id="<?php echo $type_id;?>">
                                <td><?php echo $type_order;?></td>
                                <td><?php echo $type_name;?></td>
                                <td>
                                    <select class="form-control">
                                        <option class="hidden">Edit Shipping Rates</option>
                                        <?php
                                        $select_countries = "SELECT * FROM countries";
                                        $run_countries = $db_connect->query($select_countries);

                                        if($run_countries->rowCount()>0)
                                        {
                                            while ($row_countries = $run_countries->fetch())
                                            {
                                                $country_id = $row_countries['id'];
                                                $country_name = $row_countries['country_name'];

                                                echo "
                                                <option data-url='edit_shipping_rates.php?edit_shipping_rates=$type_id&country_id=$country_id'>
                                                $country_name
                                                </option>
                                                
                                                ";

                                            }
                                        }

                                        ?>

                                    </select>
                                </td>
                                <td><?php echo ucfirst($type_default);?></td>
                                <td>
                                    <div class="dropdown"><!--dropdown start -->
                                        <p>
                                            <a href="edit_shipping_type.php?edit_shipping_type=<?php echo $type_id;?>">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="view_shipping_types.php?delete_shipping_type=<?php echo $type_id;?>">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </p>

                                    </div>
                                </td>
                            </tr>

                            <?php
                        }
                    }

                    ?>

                    </tbody>


                </table>



            </div>



        </div>

    </div>
</div>



</body>
</html>