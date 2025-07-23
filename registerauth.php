<?php
    session_start();

    include('connect.php');  
    $username = $_POST['user'];  
    $password = $_POST['pass'];  
    $_SESSION["invalid"] = false;
        

    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($conn, $username);  
    $password = mysqli_real_escape_string($conn, $password); 

    $_SESSION["username"] = $username;

    $sql = "select * from users where username = '$username'";  
    $result = mysqli_query($conn, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  

    $url = "./register.php";
    $url2 = "./login.php";

    $sqlInsert = "INSERT INTO users(username, password, member, pfp) VALUES ('$username', '$password', 0, './Images/pfps/default-pfp.png')";
    if($count == 1){  
        $_SESSION["invalidR"] = true;
        header('Location: '.$url);
        die();
    }  
    else{
        if($conn->query($sqlInsert) === TRUE)
        {
            header('Location: '.$url2);
            die();
        }
        else
        {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }     
?>  