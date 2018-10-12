<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 8:13 PM
 */
?>


<h1 align="center">Edit Your Account</h1>

<form action="" method="post" enctype="multipart/form-data"><!--form start -->
    <div class="form-group"><!--form-group -->
        <label>Customer Name:</label>
        <input type="text" class="form-control" name="c_name" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Email:</label>
        <input type="text" class="form-control" name="c_email" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Password:</label>
        <input type="password" class="form-control" name="c_country" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Address:</label>
        <input type="text" class="form-control" name="c_address" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>city:</label>
        <input type="text" class="form-control" name="c_city" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>State:</label>
        <input type="text" class="form-control" name="c_state" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Zip code:</label>
        <input type="text" class="form-control" name="c_zipcode" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Phone No:</label>
        <input type="text" class="form-control" name="c_phone" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Your Image:</label>
        <input type="file" class="form-control" name="c_image">
    </div>

    <div class="text-center"><!--text-center -->
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fa fa-user-md"></i> Update Now
        </button>
    </div>
</form>