<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/21/2018
 * Time: 3:42 PM
 */
?>

<!--<div class="clearfix" id="search">--> <!--collapse clearfix starts-->
<div class="clearfix" style=" border-bottom: solid 1px #9adacd; text-align: left;  margin-top: 11px; ">
    <form class="navbar-form" method="get" action="__DIR__/../results.php"><!--navbar-form start-->
        <button type="button" value="All" name="all" class="btn btn-primary" style="height: 33px;">
            All <!-- comeback to do the all category-->
        </button>
        <div class="input-group"><!--input-group start-->
            <input class="form-control" type="text" placeholder="Search" name="user_query" style="width: 900px" required>
            <span class="input-group-btn"><!--input-group-btn start-->
                <button type="submit" value="Search" name="search" class="btn btn-primary" style="height: 33px;">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>

</div>
