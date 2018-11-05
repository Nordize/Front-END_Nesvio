<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/21/2018
 * Time: 3:42 PM
 */


?>
<!-- use only this page -->
<style type="text/css">
    p{
       display: block;
        margin-left: 10px;
    }
    #div_desc{
        width: 400px;
        font-size: 12px;
    }
</style>
<!--<div class="clearfix" id="search">--> <!--collapse clearfix starts-->
<div class="clearfix" style=" border-bottom: solid 1px #9adacd; text-align: left;  margin-top: 11px;">

    <form class="navbar-form" method="get" action="__DIR__/../results.php"><!--navbar-form start-->
       <!-- <button type="button" value="All" name="all" class="btn btn-primary" style="height: 33px;">
            All
        </button> -->

        <span class="dropdown" >
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-hover="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                All <span class="fa fa-caret-down"></span>
            </button>
            <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu" style="width: 300px;">
                <li class="dropdown-submenu">
                    <a  class="dropdown-item" tabindex="-1" href="#"> <span class="fa fa-globe"></span> Country</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a tabindex="-1" href="#">Thailand</a></li>
                        <li class="dropdown-item"><a tabindex="-1" href="#">USA</a></li>
                        <li class="dropdown-item"><a tabindex="-1" href="#">UK</a></li>
                        <li class="dropdown-item"><a tabindex="-1" href="#">JAPAN</a></li>
                        <li class="dropdown-item"><a tabindex="-1" href="#">SRI LANKA</a></li>
                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a  class="dropdown-item" tabindex="-1" href="#"><span class="fa fa-plus"> Manufacturer / Brand</a>
                    <ul class="dropdown-menu">
                        <?php
                        $manufac_qry = "SELECT * FROM manufacturers";
                        $run_manufac = $db_connect->query($manufac_qry);

                        if($run_manufac->rowCount()>0)
                        {
                            while ($row_manufac = $run_manufac->fetch())
                            {
                                $manufac_id = $row_manufac['manufacturer_id'];
                                $manufac_title = $row_manufac['manufacturer_title'];

                                ?>
                                <li class="dropdown-item"><a tabindex="-1" href="__DIR__/../dropdown_result.php?manufacturer&manufac_id=<?php echo $manufac_id;?>"><?php echo $manufac_title;?></a></li>
                            <?php }
                        } ?>
                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a  class="dropdown-item" tabindex="-1" href="#" ><span class="fa fa-product-hunt"> Category</a>
                    <ul class="dropdown-menu">
                        <?php
                        $cat_qry = "SELECT * FROM categories";
                        $run_cat = $db_connect->query($cat_qry);

                        if($run_cat->rowCount()>0)
                        {
                            while ($row_cat = $run_cat->fetch())
                            {
                                $cat_id = $row_cat['cat_id'];
                                $cat_title = $row_cat['cat_title'];
                                $cat_desc = $row_cat['cat_desc'];

                        ?>
                                <li class="dropdown-item"><a tabindex="-1" style="margin-left: 12px; font-weight: bold;" href="__DIR__/../dropdown_result.php?categories&cat_id=<?php echo $cat_id;?>"><?php echo $cat_title;?></a></li>
                            <div id="div_desc">
                                <p >● <?php echo $cat_desc;?></p>
                            </div>

                        <?php }
                        } ?>
                    </ul>
                </li>
                <li class="dropdown-submenu">
                    <a  class="dropdown-item" tabindex="-1" href="#"> <span class="fa fa-thumbs-up"></span> Product Category</a>
                    <ul class="dropdown-menu">
                        <?php
                        $p_cat_qry = "SELECT * FROM product_categories";
                        $run_p_cat_qry = $db_connect->query($p_cat_qry);

                        if($run_p_cat_qry->rowCount()>0)
                        {
                            while ($row_p_cat_qry = $run_p_cat_qry->fetch())
                            {
                                $p_cat_id = $row_p_cat_qry['p_cat_id'];
                                $p_cat_title = $row_p_cat_qry['p_cat_title'];
                                $p_cat_desc = $row_p_cat_qry['p_cat_desc'];

                                ?>
                                <li class="dropdown-item"><a tabindex="-1"  style="margin-left: 12px; font-weight: bold;" href="__DIR__/../dropdown_result.php?product_categories&p_cat_id=<?php echo $p_cat_id;?>"><?php echo $p_cat_title;?></a></li>
                                <div id="div_desc">
                                    <p >● <?php echo $p_cat_desc;?></p>
                                </div>
                            <?php }
                        } ?>
                    </ul>
                </li>
            </ul>
        </span>
        <!-- Search Module here -->
        <div class="input-group" ><!--input-group start-->
            <input class="form-control" type="text" placeholder="Search" name="user_query" style="width: 870px" required>
            <span class="input-group-btn"><!--input-group-btn start-->
                <button type="submit" value="Search" name="search" class="btn btn-primary" style="height: 33px;">
                    <i class="fa fa-search"></i>
                </button>
            </span>
        </div>
        <!-- search odule end -->
    </form>

</div>
