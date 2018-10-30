<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/29/2018
 * Time: 11:15 AM
 */
session_start();
include ("admin_includes/dblogin.php");

function get_previous_key($key,$array=array())
{
    $array_keys = array_keys($array);
    $found_index = array_search($key,$array_keys);
    return $array_keys[$found_index-1];
}



if(isset($_GET['edit_shipping_rates']))
{
    $type_id = $_GET['edit_shipping_rates'];
    $select_shipping_type = "SELECT * FROM shipping_types WHERE type_id='$type_id'";

    $run_shipping_type = $db_connect->query($select_shipping_type);

    if($run_shipping_type->rowCount()>0)
    {
        while ($row_shipping_type = $run_shipping_type->fetch())
        {
            $type_name = $row_shipping_type['type_name'];

            if(isset($_GET['zone_id']))
            {
                $zone_id = $_GET['zone_id'];
                $get_zone = "SELECT * FROM zones WHERE zone_id = '$zone_id'";
                $run_zone = $db_connect->query($get_zone);
                $row_zone = $run_zone->fetch();

                $zone_name = $row_zone['zone_name'];

            }elseif(isset($_GET['country_id'])){
                $country_id = $_GET['country_id'];
                $get_country = "SELECT * FROM countries WHERE id='$country_id'";
                $run_country = $db_connect->query($get_country);
                $row_country = $run_country->fetch();

                $country_name = $row_country['country_name'];
            }
        }
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
            $("form").submit(function(event){
                event.preventDefault();
                $.ajax({
                    method : "POST",
                    url: "insert_shipping_rate.php",
                    <?php if(isset($_GET['zone_id']))
                    {?>
                    data: $("form").serialize() + "&type_id=<?php echo $type_id;?>&zone_id=<?php echo $zone_id;?>",
                    <?php
                    } elseif (isset($_GET['country_id']))
                    {?>
                    data: $("form").serialize() + "&type_id=<?php echo $type_id;?>&country_id=<?php echo $country_id;?>",
                    <?php
                    }?>

                    success:function(){
                        $("form").find("input[type=text]").val("");

                    }
                });
            });



        });
    </script>


</head>
<body>

<div class="row"><!-- 1 row start -->
    <div class="col-lg-12"><!--col-lg-12 start -->
        <ol class="breadcrumb"><!--breadcrumb start -->
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Edit Shipping Rates
            </li>
        </ol>
    </div>
</div>


<div class="row"><!--2 row start -->
    <div class="col-lg-12"><!-- col-lg-12 start-->
        <div class="panel panel-default"><!-- panel panel-default start -->
            <div class="panel-heading"><!-- panel-heading start -->
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> Edit Shipping Rates
                </h3>
            </div>
            <div class="panel-body"><!--panel-body start -->
                <h4>
                    <strong>Edit Shipping Rates For:</strong>
                    <?php
                    if(isset($_GET['zone_id']))
                    {
                        echo $zone_name;
                    }elseif (isset($_GET['country_id']))
                    {
                        echo $country_name;
                    }

                    ?>
                    : <?php echo $type_name;?>
                </h4>
                <h3>Insert Shipping Rate</h3>
                <form method="post"><!-- form start -->
                    <div class="row"><!--row start -->
                        <div class="col-sm-4"><!--col-sm-4 start -->
                            <div class="form-group"><!--form-group start -->
                                <label>Weight Up To (lbs): </label>
                                <input type="text" name="shipping_weight" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-4"><!--col-sm-4 start -->
                            <div class="form-group"><!--form-group start -->
                                <label>Cost ($): </label>
                                <input type="text" name="shipping_cost" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group"><!--form-group start -->
                        <input type="submit" name="submit" value="Insert Shipping Rate" class="btn btn-primary">
                    </div>

                </form>

                <table class="table table-hover table-bordered table-striped"><!-- table table-hover table-bordered table-striped start -->
                    <thead>
                    <tr>
                        <th>Weight From: </th>
                        <th>Weight To: </th>
                        <th>Cost: </th>
                        <th>Delete: </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 0;

                    $shipping_weights = array();

                    if(isset($_GET['zone_id']))
                    {
                        $get_shipping_rates = "SELECT * FROM shipping WHERE shipping_type='$type_id' AND shipping_zone='$zone_id' ORDER BY shipping_weight";

                    }elseif (isset($_GET['country_id']))
                    {
                        $get_shipping_rates = "SELECT * FROM shipping WHERE shipping_type='$type_id' AND shipping_country='$country_id' ORDER BY shipping_weight";
                    }

                    $run_shipping_rates = $db_connect->query($get_shipping_rates);

                    if($run_shipping_rates->rowCount()>0)
                    {
                        while ($row_shipping_rates = $run_shipping_rates->fetch())
                        {
                            $i++;

                            $shipping_id = $row_shipping_rates['shipping_id'];
                            $shipping_weight = $row_shipping_rates['shipping_weight'];
                            $shipping_cost = $row_shipping_rates['shipping_cost'];
                            $shipping_weights[$shipping_id] = $shipping_weight + 0.01;

                            if($i==1)
                            {
                                $shipping_weight_from = "0.00";
                            }else{
                                $previous_shipping_id = get_previous_key($shipping_id,$shipping_weights);
                                $shipping_weight_from = $shipping_weights[$previous_shipping_id];
                            }
                        ?>
                        <tr id="tr_<?php echo $shipping_id;?>">
                            <td><?php echo $shipping_weight_from;?> <small>Lbs</small></td>
                            <td><?php echo $shipping_weight;?> <small>Lbs</small></td>
                            <td>$ <?php echo $shipping_cost;?> </td>
                            <td>
                                <a href="#" id="delete_shipping_rate_<?php echo $shipping_id;?>">
                                    <i class="fa fa-trash-o"></i> Delete
                                </a>
                            </td>
                            <script>
                                //delete part
                                $(document).ready(function(){
                                    $("#delete_shipping_rate_<?php echo $shipping_id;?>").click(function (event) {
                                        event.preventDefault();
                                        $.ajax({
                                            method:"POST",
                                            url:"delete_shipping_rate.php",
                                            data: {shipping_id: <?php echo $shipping_id;?>, type_id:<?php echo $type_id;?>},
                                            success:function () {
                                                $("#tr_<?php echo $shipping_id;?>").remove();
                                            }
                                        });
                                    });
                                });

                            </script>
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