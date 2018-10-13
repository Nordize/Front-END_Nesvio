<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 9/29/2018
 * Time: 6:03 PM
 */
?>

<!-- upper sidebar category-->
<div class="panel panel-default sidebar-menu"><!--panel panel-default sidebar-menu-->
    <div class="panel-heading"><!--panel-heading -->
        <h3 class="panel-title">Products Categories</h3>
    </div>
    <div class="panel-body"><!--panel-body -->
        <ul class="nav nav-pills nav-stacked category-menu"><!-- nav nav-pills nav-stacked category-menu -->
            <?php get_product_category();?>
        </ul>
    </div>
</div>

<!-- lower sidebar category-->
<div class="panel panel-default sidebar-menu"><!--panel panel-default sidebar-menu-->
    <div class="panel-heading"><!--panel-heading -->
        <h3 class="panel-title">Categories</h3>
    </div>
    <div class="panel-body"><!--panel-body -->
        <ul class="nav nav-pills nav-stacked category-menu"><!-- nav nav-pills nav-stacked category-menu -->
            <?php get_category();?>
        </ul>
    </div>
</div>