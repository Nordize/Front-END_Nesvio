<?php
/**
 * Created by PhpStorm.
 * User: Nordize
 * Date: 10/2/2018
 * Time: 8:30 PM
 */


if(isset($_POST['passwordResetBtn']))
{
    $customer_username = $_SESSION['customer_username'];

    //initialize an array to store any error message from the form
    $form_errors = array();

    //form validation
    $required_fields = array('email', 'new_password', 'confirm_password');

    //call the function to check empty field and merge the return data into form_error array
    $form_errors = array_merge($form_errors,check_empty_fields($required_fields));

    //Fields that requires checking for minimum length
    $fields_to_check_length = array('new_password'=>6,'confirm_password'=>6);

    //call the function to check minimum required length and merge the return data into form_error array
    $form_errors = array_merge($form_errors,check_min_length($fields_to_check_length));

    //email validation / merge the return data into form_error array
    $form_errors = array_merge($form_errors,check_email($_POST));

    //check if error array is empty, if yes process form data and insert record
    if (empty($form_errors)) {
        //collect form data and store in variables
        $email = $_POST['email'];
        $password1 = $_POST['new_password'];
        $password2 = $_POST['confirm_password'];

        //check if new password and confirm password is same
        if($password1 != $password2)
        {
            $result = "<p style='padding: 20px; border: 1px solid grey; color: red;'>New password and confirm password does not match</p>";
        }
        else{
            try{
                //create SQl select statement to verify if email address input exist in the database
                $sqlQuery = "SELECT customer_email FROM customer WHERE customer_email =:customer_email";

                //use PDO prepared to sanitize data
                $statement = $db_connect->prepare($sqlQuery);

                //execute the query
                $statement->execute(array(':customer_email' =>$email));

                //check if record exist
                if($statement->rowCount() == 1)
                {
                    //hash the password
                    $hashed_password = password_hash($password1,PASSWORD_DEFAULT);

                    //SQL statment to update password
                    $sqlUpdate = "UPDATE customer SET customer_pass =:password WHERE customer_email=:email";

                    //use PDO prepared to sanitize SQL statement
                    $statement=$db_connect->prepare($sqlUpdate);

                    //execute the statement
                    $statement->execute(array(':password'=>$hashed_password,':email'=>$email));

                    $result = "<p style='padding: 20px;border: 1px solid gray; color: green'>Password Reset Successful</p>";


                }else{
                    $result = "<p style='padding: 20px;border: 1px solid gray; color: red'>Th email address provided does not exist in our database, please try again</p>";

                }

            }catch (PDOException $ex)
            {
                $result = "<p style='padding: 20px;border: 1px solid gray; color: red'>An error occurred: ".$ex->getMessage()."</p>";
            }
        }




    }else{
        if(count($form_errors)==1)
        {
            $result = "<p style='color: red'>There was 1 error in the form</p> <br>";
        }else{
            $result = "<p style='color: red'>".count($form_errors)." errors in the form</p> <br>";
        }
    }


}



?>

<h1 align="center">Forgot Password</h1>
<?php if(isset($result)) echo $result; ?>
<?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
<form action="" method="post"><!--form start -->
    <div class="form-group"><!--form-group start -->
        <label>Enter Your Email:</label>
        <input type="text" name="email" class="form-control" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Enter Your New Password:</label>
        <input type="text" name="new_password" class="form-control" required>
    </div>
    <div class="form-group"><!--form-group start -->
        <label>Please Confirm Your New Password Again:</label>
        <input type="text" name="confirm_password" class="form-control" required>
    </div>
    <div class="text-center"><!--text-center start -->
        <button type="submit" name="passwordResetBtn" class="btn btn-primary" >
            <i class="fa fa-user-md"></i> Recover Password
        </button>
    </div>




</form>
