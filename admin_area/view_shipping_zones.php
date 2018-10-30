<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/28/2018
 * Time: 3:36 PM
 */

include ("admin_includes/dblogin.php");


if(isset($_GET['delete_shipping_zone'])){

    $delete_zone_id = $_GET['delete_shipping_zone'];

    $delete_zone_location = "DELETE FROM zones_locations WHERE zone_id ='$delete_zone_id'";

    $run_delete_zone_location = $db_connect->query($delete_zone_location);


    $delete_zone = "DELETE FROM zones WHERE zone_id='$delete_zone_id'";

    $run_delete = $db_connect->query($delete_zone);

    if($run_delete){

        echo "<script>alert('One Zone Has been deleted')</script>";

        echo "<script>window.open('view_shipping_zones.php','_self')</script>";

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
                $("tbody").sortable({
                    helper:fixWidthHelper,
                    placeholder: "placeholder-highlight",
                    containment: "tbody",
                    update: function(){
                        var zones_ids = new Array();

                        $("tbody tr").each(function(){
                            zone_id = $(this).attr("id");
                            zones_ids.push(zone_id);
                        });
                        $.ajax({
                            url: "update_zone_order.php",
                            method: "POST",
                            data: {zones_ids: zones_ids}
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
        });
    </script>

</head>
<body>

<div class="row"><!-- 1 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <ol class="breadcrumb"><!--breadcrumb start -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Shipping Zones
            </li>
        </ol>
    </div>
</div>

<div class="row"><!--2 row start-->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <div class="panel panel-default"><!--panel panel-default start -->
            <div class="panel-heading"><!--panel-heading start -->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> View Shipping Zones
                </h3>
            </div>
            <div class="panel-body"><!--panel-body start -->
                <p class="lead">
                    Shipping Zones
                    <a href="insert_shipping_zone.php" class="btn btn-default">
                        Add Shipping Zone
                    </a>
                </p>
                A shipping zone is a geographic region where a certain set of shopping types are offered.
                System will match a customer to a single zone using their shipping address and present the shipping types within that zone to them.
                <br>
                <br>
                <div class="table-responsive"><!--table-responsive start -->
                    <table class="table table-hover table-bordered table-striped"><!--table table-hover table-bordered table-striped start -->
                        <thead>
                        <tr>
                            <th>Zone Order:</th>
                            <th>Zone Name:</th>
                            <th>Zone Regions:</th>
                            <th>Zone Actions:</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $get_zones = "SELECT * FROM zones ORDER BY zone_order";
                        $run_zones = $db_connect->query($get_zones);

                        if($run_zones->rowCount()>0)
                        {
                            while ($row_zones =$run_zones->fetch() )
                            {
                                $zone_id = $row_zones['zone_id'];
                                $zone_name = $row_zones['zone_name'];
                                $zone_order = $row_zones['zone_order'];
                            ?>

                            <tr id="<?php echo $zone_id;?>">
                                <td><?php echo $zone_order;?></td>
                                <td><?php echo $zone_name;?></td>
                                <td>
                                    <?php
                                    $result = "";
                                    $get_zones_locations = "SELECT * FROM zones_locations WHERE zone_id='$zone_id'";
                                    $run_zones_locations = $db_connect->query($get_zones_locations);

                                    if($run_zones_locations->rowCount()>0)
                                    {
                                        while($row_zones_locations = $run_zones_locations->fetch())
                                        {
                                            $location_code = $row_zones_locations['location_code'];
                                            $location_type = $row_zones_locations['location_type'];

                                            if($location_type == 'country')
                                            {
                                                $get_country = "SELECT * FROM countries WHERE id = '$location_code'";
                                                $run_country = $db_connect->query($get_country);
                                                $row_country = $run_country->fetch();

                                                $country_name = $row_country['country_name'];

                                                $result .= "$country_name, ";

                                            }elseif($location_type == 'postcode')
                                            {
                                                $result .= "$location_code, ";

                                            }
                                        }
                                    }

                                    echo rtrim($result,", ");

                                    ?>

                                </td>
                                <td>
                                    <div class="dropdown"><!--dropdown start -->
                                        <p>
                                            <a href="edit_shipping_zone.php?edit_shipping_zone=<?php echo $zone_id;?>">
                                                <i class="fa fa-pencil"></i> Edit
                                            </a>
                                            <a href="view_shipping_zones.php?delete_shipping_zone=<?php echo $zone_id;?>">
                                                <i class="fa fa-trash"></i> Delete
                                            </a>
                                        </p>

                                    </div>


                                </td>
                            </tr>

                    <?php    }
                        }
                        ?>

                        </tbody>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>





</body>
</html>
