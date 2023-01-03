<?php

include 'DatabaseManager.php';
include 'UserManager.php';

$con = mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);

// Check to see if user is logged in and authenticated
if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    // Check to see if user is authenticated
    if(authenticateUser($_SESSION['username'], $_SESSION['password'])){
        // User is authenticated
        // Load user data
        // Sanitize the username
        $user = mysqli_real_escape_string($con, $_SESSION['username']);
        $user = fetchUserAccount($user);
    }else{
        // User is not authenticated
        // Redirect to login page
        header("Location: login.php");
    }
}

// Handle editing profile
if(isset($_POST['submit'])){
    // Sanitize input
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Update username
    if($username != ""){
        $username = mysqli_real_escape_string($con, $_POST['username']);
        updateUserAccount($_SESSION['username'], "u", $username);
        $_SESSION['username'] = $username;
    }

    // Update password
    if($password != ""){
        // Sanitize username and hash password
        $username = mysqli_real_escape_string($con, $_SESSION['username']);
        $password = mysqli_real_escape_string($con, $password);
        $password = md5($password); 

        updateUserAccount($username, "p", $password);
        $_SESSION['password'] = $password;
    }

    

    // Redirect to profile page
    header("Location: profile.php");
}

// Delete Account
if(isset($_POST['delete'])){
    // Sanitize input
    $username = mysqli_real_escape_string($con, $_SESSION['username']);
    deleteUserAccount($username);
    header("Location: login.php");
}

?>

<html>
    <head>
        <title>Profile</title>
    </head>
    <body>
        <h1>Profile</h1>
        <p>Username: <?php echo $user['username']; ?></p>
        <p>Role: <?php echo $user['role']; ?></p>

        <!-- Logout Button -->
        <form action="login.php" method="post">
            <input type="submit" name="logout" value="Logout">
        </form>

        <!-- Handle editing profile -->
        <form action="profile.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="submit" value="Edit Profile">
        </form>

        <!-- Handle deleting profile -->
        <form action="profile.php" method="post">
            <input type="submit" name="delete" value="Delete Profile">

    </body>
</html>