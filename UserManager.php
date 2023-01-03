<?php
    include 'DatabaseManager.php';
$con = mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);


function userExists($user){
    // Sanitize input
    $user = mysqli_real_escape_string($con, $user);
    $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
    if(mysqli_num_rows($result) > 0){
        return true;
}

function fetchUserAccount($user){
    // Sanitize input
    $user = mysqli_real_escape_string($con, $user);
    $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$user'");
    return $result;
}

function updateUserAccount($user, $type, $data){
    // Sanitize input
    $user = mysqli_real_escape_string($con, $user);
    $data = mysqli_real_escape_string($con, $data);
    $type = mysqli_real_escape_string($con, $type);

    switch($type){
        case "p":
            $data = md5($data);
            $query_string = "UPDATE users SET password = '$data' WHERE username = '$user'";
        case "u":
            $query_string = "UPDATE users SET username = '$data' WHERE username = '$user'";
        case "role":
            $query_string = "UPDATE users SET role = '$data' WHERE username = '$user'";
    }

    $result = mysqli_query($con, $query_string);
}

function deleteUserAccount($user){
    // Sanitize input
    $user = mysqli_real_escape_string($con, $user);
    $result = mysqli_query($con, "DELETE FROM users WHERE username = '$user'");
}

function createUserAccount($user, $pass, $role){
    // Sanitize input
    $user = mysqli_real_escape_string($con, $user);
    $pass = mysqli_real_escape_string($con, $pass);
    $role = mysqli_real_escape_string($con, $role);

    $pass = md5($pass);
    $result = mysqli_query($con, "INSERT INTO users (username, password, role) VALUES ('$user', '$pass', '$role')");
}

function authenticateUser($username, $password){
    // Sanitize input
    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $password = md5($password);
    $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");

    if(mysqli_num_rows($result) > 0){
        // User is authenticated
        // Set session variables
        $_SESSION['username'] = $username;

        // Encrypt password in cookies
        $password = md5($password);
        $_SESSION['password'] = $password;

        return true;
    }else{
        return false;
    }
}

function deauthenticateUser(){
    session_destroy();
}

?>