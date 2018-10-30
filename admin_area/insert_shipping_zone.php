<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/28/2018
 * Time: 2:36 PM
 */

include ("admin_includes/dblogin.php");

if(isset($_POST['submit']))
{

    $zone_name = $_POST['zone_name'];
    $get_zone_order = "SELECT MAX(zone_order) AS zone_order FROM zones";
    $run_zone_order = $db_connect->query($get_zone_order);

    if($run_zone_order->rowCount()>0)
    {
        $row_zone_order = $run_zone_order->fetch();
        $zone_order = $row_zone_order['zone_order'] + 1;

        $zone_countries = $_POST['zone_countries']; //!!!!Problem Right here, Still could not POST the data from name=zone_countries[]!!!

        $insert_zone = "INSERT INTO zones (zone_name,zone_order) VALUES ('$zone_name','$zone_order')";
        $run_zone = $db_connect->query($insert_zone);
        $insert_zone_id = $db_connect->lastInsertId();

        if($run_zone)
        {
            foreach ($zone_countries as $country_id)
            {
                $insert_zone_location = "INSERT INTO zones_locations (zone_id,location_code,location_type) VALUES ('$insert_zone_id','$country_id','country')";

                $run_zone_location = $db_connect->query($insert_zone_location);
            }

            if(!empty($_POST['zone_post_codes']))
            {
                if(strpos($_POST['zone_post_codes'],"\n"))
                {
                    $post_codes = explode("\n",$_POST['zone_post_codes']);
                }else{
                    $post_codes = array($_POST['zone_post_codes']);
                }


                foreach ($post_codes as $post_code)
                {
                    $location_code =$post_code;
                    $insert_zone_location = "INSERT INTO zones_locations (zone_id,location_code,location_type) VALUES ('$insert_zone_id','$location_code','postcode')";
                    $run_zone_location = $db_connect->query($insert_zone_location);
                }
            }

            echo "
            <script>
            alert('New Shipping Zone Has Been Inserted Successfully.');
            window.open('view_shipping_zones.php?view_shipping_zones','_self');
            </script>
            ";

        }

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
                <i class="fa fa-dashboard"></i> Dashboard / Insert Shipping Zone
            </li>
        </ol>
    </div>
</div>

<div class="row"><!-- 2 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <div class="panel panel-default"><!--panel panel-default start -->
            <div class="panel-heading"><!--panel-heading  start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Insert Shipping Zone
                </h3>
            </div>

            <div class="panel-body"><!--panel-body start -->
                <form class="form-horizontal" method="post" action="<?=$_SERVER['PHP_SELF']?>"><!--form-horizontal start -->
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"> Zone Name</label>
                        <div class="col-md-7">
                            <input type="text" name="zone_name" class="form-control">
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"> Zone Regions</label>
                        <div class="col-md-7">
                            <select name="zone_countries[]" class="form-control chosen-select" data-placeholder="Select Zone Regions" multiple="multiple">
                                <?php
                                $select_countries = "SELECT * FROM countries";
                                $run_countries = $db_connect->query($select_countries);

                                if($run_countries->rowCount()>0)
                                {
                                    while($row_countries = $run_countries->fetch())
                                    {
                                        $country_id = $row_countries['country_id'];
                                        $country_name = $row_countries['country_name'];
                                        echo "<option value='$country_id'>$country_name</option>";
                                    }
                                }

                                ?>
                            </select>
                            <!--script for create multiple choice for countries start -->
                            <script >
                                $('.chosen-select').chosen();
                            </script>
                            <!--script for create multiple choice for countries end -->
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"> Limit To Specific ZIP/Postcodes</label>
                        <div class="col-md-7">
                            <textarea name="zone_post_codes" class="form-control" rows="5" placeholder="List 1 Zip/Posttcode Per Line"></textarea>
                        </div>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Insert Shipping Zone">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div><!--2 row end -->




</body>
</html>
