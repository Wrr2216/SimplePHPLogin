<?php

$DatabaseConfig = array(
    $DB_Host = "",
    $DB_User = "",
    $DB_Password = "",
    $DB_Name = ""
);

// Path: DatabaseManager.php

function loadUserData(){
    mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "SELECT * FROM users");

    // Echo out each user name
    while($row = mysqli_fetch_array($result)){
        echo $row['username'];
        echo $row['password'];
    }
}

function saveUserData($data, $table){
    mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "INSERT INTO $table (username, password) VALUES ('$data[0]', '$data[1]')");
}

function userAuthenticated($username, $password){
    mysqli_connect($DatabaseConfig[0], $DatabaseConfig[1], $DatabaseConfig[2], $DatabaseConfig[3]);
    if(mysqli_connect_errno()){
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $result = mysqli_query($con, "SELECT * FROM users WHERE username = '$username' AND password = '$password'");

    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}


?>


