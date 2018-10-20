<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/16/2018
 * Time: 1:05 PM
 */
include_once ('dblogin.php');

$product_id = $_GET['pro_id'];

$ratingDetails = "SELECT ratingNumber FROM item_rating WHERE product_id = '$product_id' ";
$rateResult = $db_connect->query($ratingDetails);

$ratingNumber = 0;
$count = 0;
$fiveStarRating = 0;
$fourStarRating = 0;
$threeStarRating = 0;
$twoStarRating = 0;
$oneStarRating = 0;

if ($rateResult->rowCount() >0) {
    while($row_rateResult = $rateResult->fetch())
    {
        $ratingNumber += $row_rateResult['ratingNumber'];
        $count += 1;
        if($row_rateResult['ratingNumber'] ==5)
        {
            $fiveStarRating += 1;
        }elseif ($row_rateResult['ratingNumber'] == 4)
        {
            $fourStarRating +=1;
        }elseif ($row_rateResult['ratingNumber'] ==3)
        {
            $threeStarRating += 1;
        }elseif ($row_rateResult['ratingNumber'] ==2)
        {
            $twoStarRating += 1;
        }elseif ($row_rateResult['ratingNumber'] ==1)
        {
            $twoStarRating += 1;
        }
    }
    //$average = 0;

    if($ratingNumber && $count)
    {
        $average = $ratingNumber/$count;
    }
}

?>
<div id="ratingDetails">
    <div class="row">
        <div class="col-sm-3">
            <h4>Rating and Reviews</h4>
            <h2 class="bold padding-buttom-7"><?php printf('%.1f',$average);?><small>/ 5</small></h2>
            <?php
            $averageRating = round($average,0);
            for($i=1;$i<=5;$i++)
            {
                $ratingClass = "btn-default btn-grey";
                if($i <= $averageRating)
                {
                    $ratingClass = "btn-warning";
                }

            ?>
            <button type="button" class="btn btn-sm <?php echo $ratingClass;?>" aria-label="Left Align">
                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
            </button>
            <?php }?>
        </div>
        <div class="col-sm-3">
            <?php
            $fiveStarRatingPercent = round(($fiveStarRating/5)*100);
            $fiveStarRatingPercent = !empty($fiveStarRatingPercent)?$fiveStarRatingPercent.'%':'0';

            $fourStarRatingPercent = round(($fourStarRating/5)*100);
            $fourStarRatingPercent = !empty($fourStarRatingPercent)?$fourStarRatingPercent.'%':'0';

            $threeStarRatingPercent = round(($threeStarRating/5)*100);
            $threeStarRatingPercent = !empty($threeStarRatingPercent)?$threeStarRatingPercent.'%':'0';

            $twoStarRatingPercent = round(($twoStarRating/5)*100);
            $twoStarRatingPercent = !empty($twoStarRatingPercent)?$twoStarRatingPercent.'%':'0';

            $oneStarRatingPercent = round(($oneStarRating/5)*100);
            $oneStarRatingPercent = !empty($oneStarRatingPercent)?$oneStarRatingPercent.'%':'0';

            ?>
            <!--5 stars start here -->
            <div class="pull-left">
                <div class="pull-left" style="width: 35px; line-height: 1;">
                    <div style="height: 9px; margin: 5px;">5 <span class="glyphicon glyphicon-start"></span></div>
                </div>
                <div class="pull-left" style="width: 180px;">
                    <div class="progress" style="height: 9px; margin: 8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="5" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo $fiveStarRatingPercent;?> ;">
                            <span class="sr-only"><?php echo $fiveStarRatingPercent; ?></span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left: 10px;"><?php echo $fiveStarRating;?></div>
            </div>

            <div class="pull-left">
                <div class="pull-left" style="width: 35px; line-height: 1;">
                    <div style="height: 9px; margin: 5px;">4 <span class="glyphicon glyphicon-start"></span></div>
                </div>
                <div class="pull-left" style="width: 180px;">
                    <div class="progress" style="height: 9px; margin: 8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="4" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo $fourStarRatingPercent;?> ;">
                            <span class="sr-only"><?php echo $fourStarRatingPercent; ?></span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left: 10px;"><?php echo $fourStarRating;?></div>
            </div>

            <div class="pull-left">
                <div class="pull-left" style="width: 35px; line-height: 1;">
                    <div style="height: 9px; margin: 5px;">3 <span class="glyphicon glyphicon-start"></span></div>
                </div>
                <div class="pull-left" style="width: 180px;">
                    <div class="progress" style="height: 9px; margin: 8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="3" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo $threeStarRatingPercent;?> ;">
                            <span class="sr-only"><?php echo $threeStarRatingPercent; ?></span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left: 10px;"><?php echo $threeStarRating;?></div>
            </div>

            <div class="pull-left">
                <div class="pull-left" style="width: 35px; line-height: 1;">
                    <div style="height: 9px; margin: 5px;">2 <span class="glyphicon glyphicon-start"></span></div>
                </div>
                <div class="pull-left" style="width: 180px;">
                    <div class="progress" style="height: 9px; margin: 8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo $twoStarRatingPercent;?> ;">
                            <span class="sr-only"><?php echo $twoStarRatingPercent; ?></span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left: 10px;"><?php echo $twoStarRating;?></div>
            </div>

            <div class="pull-left">
                <div class="pull-left" style="width: 35px; line-height: 1;">
                    <div style="height: 9px; margin: 5px;">1 <span class="glyphicon glyphicon-start"></span></div>
                </div>
                <div class="pull-left" style="width: 180px;">
                    <div class="progress" style="height: 9px; margin: 8px 0;">
                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="5" style="width:<?php echo $oneStarRatingPercent;?> ;">
                            <span class="sr-only"><?php echo $oneStarRatingPercent; ?></span>
                        </div>
                    </div>
                </div>
                <div class="pull-right" style="margin-left: 10px;"><?php echo $oneStarRating;?></div>
            </div>
        </div>
        <!--Rate this product Button -->
        <?php
        if(isset($_SESSION['customer_username']))
        {
            echo"<div class='col-sm-3'>";
            echo"<button type='button' id='rateProduct' class='btn btn-default'>Rate this product</button>";
            echo "</div>";
        }
        else{
            echo "Please Login for Rate this product";
        }
        ?>
        <!--<div class="col-sm-3">
            <button type="button" id="rateProduct" class="btn btn-default">Rate this product</button>
        </div>-->
    </div>

    <!-- review block start here-->
    <div class="row">
        <div class="col-sm-7">
            <hr>
            <div class="review-block">
                <?php

                $ratingQuery = "SELECT * FROM item_rating  WHERE product_id = '$product_id' ";
                $run_ratingQuery = $db_connect->query($ratingQuery);

                if ($run_ratingQuery->rowCount() >0)
                {
                    while ($row_ratingQuery = $run_ratingQuery->fetch())
                    {
                        $user_id = $row_ratingQuery['userId'];
                        $date = date_create($row_ratingQuery['created_time']);
                        $reviewDate = date_format($date, "M d, Y");

                        ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <?php

                                    $query_pic = "SELECT customer_username,customer_image FROM customer WHERE customer_id =".$user_id;

                                    $run_query_pic = $db_connect->query($query_pic);

                                    if ($run_query_pic->rowCount() > 0) {
                                        while ($row_query_pic = $run_query_pic->fetch()) {
                                            $user_pic = $row_query_pic['customer_image'];
                                            $customer_username = $row_query_pic['customer_username'];
                                            echo $user_pic;
                                            if(empty($user_pic))
                                            {

                                                echo "<img src='__DIR__/../customer/customer_images/demo_user.png' class='img-responsive'>";
                                                echo "<div class='review-block-name'>By <a href='__DIR__/../customer/my_account.php'>$customer_username</a></div>";
                                            }
                                            else{
                                                $user_pic = $row_query_pic['customer_image'];
                                                echo "<img src='__DIR__/../customer/customer_images/$user_pic' class='img-responsive'>";
                                                echo "<div class='review-block-name'>By <a href='__DIR__/../customer/my_account.php'>$customer_username</a></div>";
                                            }


                                        }
                                    }

                                ?>
                                <div class="review-block-date"><?php echo $reviewDate; ?></div>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {
                                        $ratingClass = "btn-default btn-grey";
                                        if ($i <= $row_ratingQuery['ratingNumber']) {
                                            $ratingClass = "btn-warning";
                                        }

                                        ?>
                                        <button type="button" class="btn btn-xs <?php echo $ratingClass; ?>"
                                                aria-label="Left Align">
                                            <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                        </button>
                                    <?php } ?>
                                </div>
                                <div class="review-block-title"><?php echo $row_ratingQuery['title']; ?></div>
                                <div class="review-block-description"><?php echo $row_ratingQuery['comments']; ?></div>
                            </div>
                        </div>
                        <hr>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


<div id="ratingSection" style="display: none;">

    <div class="row">
        <div class="col-sm-12">
            <form id="ratingForm" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <h4>Rate this product</h4>
                    <button type="button" class="btn btn-warning btn-sm rateButton" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey btn-sm rateButton" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey rateButton" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey rateButton" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-grey rateButton" aria-label="Left Align">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                    </button>
                    <input type="hidden" class="form-control" id="rating" name="rating" value="1">
                    <input type="hidden" class="form-control" id="pro_id" name="pro_id" value="<?php echo $_GET['pro_id'];?>">

                </div>
                <div class="form-group">
                    <label for="usr">Title*</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="comment">Comment*</label>
                    <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-info" id="saveReview" name="submit">Save Review</button>
                    <button type="button" class="btn btn-info" id="cancelReview">Cancel</button>
                </div>

            </form>
        </div>

    </div>
</div>
