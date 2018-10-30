<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/28/2018
 * Time: 10:02 PM
 */
include ("admin_includes/dblogin.php");


    $edit_zone_id = $_GET['edit_shipping_zone'];
    $get_zone = "SELECT * FROM zones WHERE zone_id = '$edit_zone_id'";
    $run_zone = $db_connect->query($get_zone);

    $row_zone = $run_zone->fetch();
    $zone_name = $row_zone['zone_name'];


if(isset($_POST['update']))
{
    $zone_countries = $_POST['zone_countries'];
    $edit_zone_id = $_GET['edit_shipping_zone'];

    $update_zone = "UPDATE zones SET zone_name = '$zone_name' WHERE zone_id='$edit_zone_id'";
    $run_update_zone = $db_connect->query($update_zone);

    if($run_update_zone)
    {
        $delete_zone_locations = "DELETE FROM zones_locations WHERE zone_id ='$edit_zone_id'";
        $run_delete_zone_locations = $db_connect->query($delete_zone_locations);

        foreach ($zone_countries as $country_id)
        {
            $insert_zone_location = "INSERT INTO zones_locations (zone_id,location_code,location_type) VALUES ('$edit_zone_id','$country_id','country')";

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
                $insert_zone_location = "INSERT INTO zones_locations (zone_id,location_code,location_type) VALUES ('$edit_zone_id','$location_code','postcode')";
                $run_zone_location = $db_connect->query($insert_zone_location);
            }
        }

        echo "
            <script>
            alert('Your One Shipping Zone Has Been Updated Successfully.');
            window.open('view_shipping_zones.php?view_shipping_zones','_self');
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
                <i class="fa fa-dashboard"></i> Dashboard / Edit Shipping Zone
            </li>
        </ol>
    </div>
</div>

<div class="row"><!-- 2 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <div class="panel panel-default"><!--panel panel-default start -->
            <div class="panel-heading"><!--panel-heading  start-->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Edit Shipping Zone
                </h3>
            </div>

            <div class="panel-body"><!--panel-body start -->
                <form class="form-horizontal" method="post"><!--form-horizontal start -->
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"> Zone Name</label>
                        <div class="col-md-7">
                            <input type="text" name="zone_name" class="form-control" value="<?php echo $zone_name;?>">
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

                                        $get_zone_locations = "SELECT COUNT(*) FROM zones_locations WHERE zone_id ='$edit_zone_id' AND location_type='country' AND location_code='$country_id'";
                                        $run_zone_locations = $db_connect->query($get_zone_locations);
                                        $count_zone_locations = $run_zone_locations->fetchColumn();

                                        if($count_zone_locations ==0)
                                        {
                                            echo "<option value='$country_id'>$country_name</option>";

                                        }else{
                                            echo "<option value='$country_id' selected>$country_name</option>";
                                        }



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
                            <textarea name="zone_post_codes" class="form-control" rows="5" placeholder="List 1 Zip/Posttcode Per Line">
                            <?php
                            $result = "";
                            $get_zone_locations = "SELECT * FROM zones_locations WHERE zone_id = '$edit_zone_id' AND location_type='postcode'";
                            $run_zone_locations = $db_connect->query($get_zone_locations);

                            if($run_zone_locations->rowCount()>0)
                            {
                                while($row_zone_locations=$run_zone_locations->fetch() )
                                {
                                    $location_code = $row_zone_locations['location_code'];
                                    $result .= "$location_code\n";
                                }
                                echo rtrim($result, "\n");

                            }

                            ?>
                            </textarea>

                        </div>
                    </div>
                    <div class="form-group"><!--form-group start -->
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-7">
                            <input type="submit" name="update" class="form-control btn btn-primary" value="Update Shipping Zone">
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div><!--2 row end -->



</body>
</html>
