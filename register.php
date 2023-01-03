<?php

include 'UserManager.php';

$con = mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);

// Make sure there is not already a logged in user and session active
if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
    // User is not logged in
    // Handle the registration form
    if(isset($_POST['submit'])){
        // Sanitize input
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Check to see if user already exists
        if(!userExists($username)){
            // User does not exist
            // Hash password
            $password = md5($password);

            // Create the account (Input has been sanitized)
            createUserAccount($username, $password);

            //Redirect to login page
            header("Location: login.php");
        }else{
            // User already exists
            // Redirect to login page
            header("Location: login.php");
        }
    }
}

        

?>

<html>

<!-- Registration form -->
<!-- We will need to make sure the user doesnt already exist -->
<form action="register.php" method="post">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="submit" name="submit" value="Register" />
</form>


</html>