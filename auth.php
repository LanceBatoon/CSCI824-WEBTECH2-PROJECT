<?php
    session_start();

    include('connect.php');  
    $username = $_POST['user'];  
    $password = $_POST['pass'];  

    $username = stripcslashes($username);  
    $password = stripcslashes($password);  
    $username = mysqli_real_escape_string($conn, $username);  
    $password = mysqli_real_escape_string($conn, $password); 

    $_SESSION["username"] = $username;

    $sql = "select * from users where username = '$username' and password = '$password'";  
    $result = mysqli_query($conn, $sql);  

    $count = mysqli_num_rows($result);  
    $url = "./main.php";
    $url2 = "./login.php";
    
    if($count == 1){  
        $row = mysqli_fetch_assoc($result);
        $_SESSION['userinfo'][] = $row;
        $_SESSION["invalid"] = false;
        header('Location: '.$url);
        die();
    }  
    else{  
        $_SESSION["invalid"] = true;
        header('Location: '.$url2);
        die();
    }     
?>  
