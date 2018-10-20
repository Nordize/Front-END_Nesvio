<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 8:13 PM
 */


if(isset($_SESSION['customer_username']))
{
    $customer_session = $_SESSION['customer_username'];

    $get_customer = "SELECT * FROM customer WHERE customer_username = '$customer_session'";

    $run_customer = $db_connect->query($get_customer);

    if($run_customer->rowCount()>0)
    {
        while($row_customer = $run_customer->fetch()){

            $customer_id = $row_customer['customer_id'];
            $customer_firstname = $row_customer['customer_firstname'];
            $customer_lastname = $row_customer['customer_lastname'];
            $customer_username = $row_customer['customer_username'];
            $customer_email = $row_customer['customer_email'];
            $customer_address = $row_customer['customer_address'];
            $customer_city = $row_customer['customer_city'];
            $customer_state = $row_customer['customer_state'];
            $customer_country = $row_customer['customer_country'];
            $customer_zipcode = $row_customer['customer_zipcode'];
            $customer_phone = $row_customer['customer_phone'];
            $customer_image = $row_customer['customer_image'];



        }
    }
    #-------- show data end


}

#after submit update button

if(isset($_POST['update']))
{

    //initialize an array to store any error message from the form
    $form_errors = array();

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('username' => 4);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_min_length($fields_to_check_length));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors, check_email($_POST));

    //check duplicate username
    #$form_errors = checkDuplicateEntries('customer','customer_username','username',$db_connect);


    //check if error array is empty, if yes process form data and insert record
    if(empty($form_errors)) {

        //define for image
        $allowed_filetypes = array('.jpg', '.gif', '.bmp', '.png'); // These will be the types of file that will pass the validation.
        $max_filesize = 9999999999; // Maximum filesize in BYTES - SET IN to a low number for small files
        //$upload_path = './uploads/'; // The place the files will be uploaded to (currently a 'files' directory).
        $upload_path = 'customer_images/';


        $update_id = $customer_id;
        $c_firstname = $_POST['c_firstname'];
        $c_lastname = $_POST['c_lastname'];
        $c_username = $_POST['username'];
        $c_email = $_POST['email'];
        $c_address = $_POST['c_address'];
        $c_city = $_POST['c_city'];
        $c_state = $_POST['c_state'];
        $c_country = $_POST['c_country'];
        $c_zipcode = $_POST['c_zipcode'];
        $c_phone = $_POST['c_phone'];
        $c_image = $_FILES['c_image']['name'];
        $c_image_temp = $_FILES['c_image']['tmp_name'];
        $ext = substr($c_image, strpos($c_image,'.'), strlen($c_image)-1); // Get the extension from the filename.


        $customer_ip = getRealUserIp();

        // Check if the filetype is allowed, if not DIE and inform the user.
        if(!in_array($ext,$allowed_filetypes))
            $result = flashMessage('The file you attempted to upload is not allowed.');


        // Now check the filesize, if it is too large then DIE and inform the user.
        if(filesize($c_image_temp) > $max_filesize)
            $result = flashMessage('The file you attempted to upload is too large.');

        // Check if we can upload to the specified path, if not DIE and inform the user.
        if(!is_writable($upload_path))
            die('You cannot upload to the specified directory, please contact administrator.');

        // Upload the file to your specified path.
        if(move_uploaded_file($c_image_temp,$upload_path . $c_image))
            //echo 'Your file upload was successful'; // It worked.
            $result = flashMessage('Your file upload was successful');
        else
            $result = flashMessage('There was an error during the file upload. Please try again.'); // It failed

        //move_uploaded_file($c_image_temp,'customer/customer_images/$c_image');

        if(checkDuplicateEntries('customer','customer_email',$c_email,$db_connect))
        {
            $result = flashMessage("This email is already taken");

        }
        else if(checkDuplicateEntries('customer','customer_username',$c_username,$db_connect))
        {
            $result = flashMessage('Username is already taken');

        }
        else if(empty($form_errors)) {


            //create SQL insert statement
            $update_data= ['customer_firstname'=>$c_firstname,'customer_lastname'=>$c_lastname,'customer_username'=>$c_username,
                'customer_email'=>$c_email,'customer_address'=>$c_address,'customer_city'=>$c_city,'customer_state'=>$c_state,
                'customer_country'=>$c_country,'customer_zipcode'=>$c_zipcode,'customer_phone'=>$c_phone,'customer_image'=>$c_image,
                'customer_ip'=>$customer_ip];

            $update_customer = "UPDATE customer SET customer_firstname=:customer_firstname,customer_lastname=:customer_lastname,
                customer_username=:customer_username,customer_email=:customer_email,customer_address=:customer_address,customer_city=:customer_city,
                customer_state=:customer_state,customer_country=:customer_country,customer_zipcode=:customer_zipcode,customer_phone=:customer_phone,
                customer_image=:customer_image,customer_ip=:customer_ip,modified_date=NOW() WHERE customer_id = '$update_id'";

            $update_stmt = $db_connect->prepare($update_customer);
            $update_stmt->execute($update_data);

            //check if one row was updated
            if($update_stmt->rowCount() == 1){
                $result = "<p style='padding:20px; border: 1px solid gray; color: green;'>Your account has been updated please login again</p>";

                echo "<script>window.open('../logout.php','_self')</script>";
            }


        }


    }
    else{
        if(count($form_errors) == 1){
            $result = "<p style='color: red;'> There was 1 error in the form<br>";
        }else{
            $result = "<p style='color: red;'> There were " .count($form_errors). " errors in the form <br>";
        }
    }
}

?>

<h1 align="center">Edit Your Account</h1>
<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form action="" method="post" enctype="multipart/form-data"><!--form start -->

    <div class="form-group"><!--form-group start -->
        <label>First Name:</label>
        <input type="text" class="form-control" name="c_firstname"  required value="<?php echo $customer_firstname?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Last Name:</label>
        <input type="text" class="form-control" name="c_lastname" required value="<?php echo $customer_lastname?>">
    </div>

    <div class="form-group"><!--form-group start -->
        <label>User Name:</label>
        <input type="text" class="form-control" name="username" required value="<?php echo $customer_username?>">
    </div>

    <div class="form-group"><!--form-group start -->
        <label>Email:</label>
        <input type="text" class="form-control" name="email" required value="<?php echo $customer_email?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Address:</label>
        <input type="text" class="form-control" name="c_address" required value="<?php echo $customer_address?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>City:</label>
        <input type="text" class="form-control" name="c_city" required value="<?php echo $customer_city?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>State:</label>
        <input type="text" class="form-control" name="c_state" required value="<?php echo $customer_state?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Country:</label>
        <input type="text" class="form-control" name="c_country" required value="<?php echo $customer_country?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Zip code:</label>
        <input type="text" class="form-control" name="c_zipcode" required value="<?php echo $customer_zipcode?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Phone No:</label>
        <input type="text" class="form-control" name="c_phone" required value="<?php echo $customer_phone?>">
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Your Image:(.jpg/.gif/.bmp/.png Only)</label>
        <input type="file" class="form-control" name="c_image" >
        <img src="__DIR__/../customer_images/<?php echo $customer_image;?>" width='100' height='100' class='img-responsive'">
    </div>

    <div class="text-center"><!--text-center -->
        <button type="submit" name="update" class="btn btn-primary">
            <i class="fa fa-user-md"></i> Update Now
        </button>
    </div>
</form>