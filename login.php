<?php

include 'UserManager.php';

$con = mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);

// Check to see if user is logged in and authenticated already
if(!isset($_SESSION['username']) && !isset($_SESSION['password'])){
    // User is not logged in
    // Handle the login form
    if(isset($_POST['submit'])){
        // Sanitize input
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Check to see if user exists
        if(userExists($username)){
            // User exists
            // Hash password
            $password = md5($password);

            // Authenticate user
            if(authenticateUser($username, $password)){
                // User is authenticated
                // Start session
                session_start();

                // Set session variables
                $_SESSION['username'] = $username;
                $_SESSION['password'] = $password;

                // Redirect to profile page
                header("Location: profile.php");
            }else{
                // User is not authenticated
                // Redirect to login page
                header("Location: login.php");
            }
        }
    }
}

// Handle logout request
if(isset($_POST['logout'])){
    // Destroy session
    session_destroy();

    // Redirect to login page
    header("Location: login.php");
}
?>

<html>

<!-- Login Form -->
<!-- We will need to make sure the user exists and the password is correct -->
<form action="login.php" method="post">
    <input type="text" name="username" placeholder="Username" />
    <input type="password" name="password" placeholder="Password" />
    <input type="submit" name="submit" value="Login" />
</form>

</html>